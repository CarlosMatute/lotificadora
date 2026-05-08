<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use DB;
use App\Models\Cliente;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function registrar_residenciales()
    {
        return view('registrarResidenciales/registrarResidenciales');
    }
    public function registrar_clientes()
    {
        return view('registrarClientes/registrarClientes');
    }
    public function vender_lotes()
    {
        return view('venderLotes/venderLotes');
    }
    
    public function detalle_lote_vendido($id_lote)
    {

        $id = collect(\DB::select("SELECT id_venta from lotes_vendidos where id_lote = :id_lote",
                ["id_lote" => $id_lote]))->first();

        $id = $id->id_venta;

        DB::select("SET lc_time_names = 'es_MX';");

        $venta = collect(\DB::select("SELECT id_cliente, pago, estado, 
                total_contado, 
                case when pago = 'Credito' then concat(anios_financiamiento, ' años') else 'No aplica' end anios_financiamiento, 
                case when pago = 'Credito' then concat(tasa_interes, '%') else 'No aplica' end tasa_interes, 
                case when pago = 'Credito' then concat('L.',prima) else 'No aplica' end prima, 
                case when pago = 'Credito' then cuotas else 'No aplica' end cuotas, 
                case when pago = 'Credito' then concat('L.',total_intereses) else 'No aplica' end total_intereses, 
                case when pago = 'Credito' then concat('L.',total_pagar) else total_contado end total_pagar,
                case when pago = 'Credito' then concat('L.',cuota_mensual) else 'No aplica' end cuota_mensual, dias_cobro_mes,  
                coalesce(DATE_FORMAT(fecha_venta,'%d de %M de %Y'), 'Sin asignar') fecha_venta, DATE_FORMAT(created_at,'%d de %M de %Y') created_at
            from ventas where id = :id_venta
        ", ["id_venta" => $id]))->first();

        $cliente = Cliente::find($venta->id_cliente);

        $lotes = DB::table("lotes")
                        ->join("lotes_vendidos","lotes.id","=","lotes_vendidos.id_lote")
                        ->join("bloques","lotes.id_bloque","=","bloques.id")
                        ->join("residenciales","bloques.id_residencial","=","residenciales.id")
                        ->select("lotes_vendidos.*","bloques.*","lotes.*","residenciales.*",
                                "bloques.nombre as bloque","residenciales.nombre as residencial","lotes.nombre as nombre")
                        ->where("lotes_vendidos.id_venta",$id)
                        ->get();
            
        $historialCuotas = DB::select("SELECT fc.fecha_cobro, v.cuota_mensual, fc.fecha_pago, concat('L.',FORMAT(fc.cantidad_pago, 2, 'es_HN')) cantidad_pago, fc.estado estadoFC
            from lotes_vendidos lv 
            join fechas_cobros fc on lv.id_venta = fc.id_venta
            join ventas v on fc.id_venta = v.id
            where lv.id_lote = :id_lote", ["id_lote" => $id_lote]);
        
        $data[]=[
            "pago"=>$venta->pago,
            "estado"=>$venta->estado,
            "total_contado"=>$venta->total_contado,
            "anios_financiamiento"=>$venta->anios_financiamiento,
            "tasa_interes"=>$venta->tasa_interes,
            "prima"=>$venta->prima,
            "cuotas"=>$venta->cuotas,
            "total_intereses"=>$venta->total_intereses,
            "total_pagar"=>$venta->total_pagar,
            "cuota_mensual"=>$venta->cuota_mensual,
            "fecha"=> $venta->fecha_venta,
            "fecha_registro"=> $venta->created_at,
            "cliente"=>$cliente->primer_nombre." ".$cliente->segundo_nombre." ".$cliente->primer_apellido." ".$cliente->segundo_apellido,
            "identidad"=>$cliente->identidad,
            "cel"=>$cliente->cel,
            "ce2l"=>$cliente->cel2,
            "correo"=>$cliente->correo,
            "lotes"=>$lotes,
            "id_venta"=>$id,
            "historialCuotas"=>$historialCuotas
        ];

        //throw New Exception($data[0], true);
        //return $data;
        return view('registrarResidenciales.detalleLoteVendido')->with('data', $data);
    }

    public function detalle_morosos($anio, $mes)
    {
        DB::select("SET lc_time_names = 'es_MX';");

        $movimientos = collect(\DB::select("
            with total as (
                select coalesce(sum(CAST(replace(v.cuota_mensual, ',', '') AS UNSIGNED)), 0) total_cobrar from ventas v
                    join fechas_cobros fc on v.id = fc.id_venta
                    where year(fecha_cobro) = $anio and month(fecha_cobro) = $mes
            ), pagado as (
                    select coalesce(sum(cantidad_pago), 0) total_pagado from fechas_cobros where year(fecha_cobro) = $anio and month(fecha_cobro) = $mes and estado = 'Pagado'
            )
            select $mes mes_actual_numero, $anio anio, ELT($mes,
                'Enero',
                'Febrero',
                'Marzo',
                'Abril',
                'Mayo',
                'Junio',
                'Julio',
                'Agosto',
                'Septiembre',
                'Octubre',
                'Noviembre',
                'Diciembre'
            ) mes_actual, FORMAT(total_cobrar,2) total_cobrar, FORMAT(total_pagado,2) total_pagado, FORMAT((total_cobrar - total_pagado),2) restante,
                        ROUND((total_pagado*100/total_cobrar), 1) porcentaje_cobrado
                        from total 
                        join pagado on true
        "))->first();

        $morosos = DB::select("SELECT 
                v.id idV,
                DATE_FORMAT(v.fecha_venta, '%d de %M de %Y %h:%i %p') AS fecha_formateada,
                CONCAT(COALESCE(c.primer_nombre, ''),
                        ' ',
                        COALESCE(c.segundo_nombre, ''),
                        ' ',
                        COALESCE(c.primer_apellido, ''),
                        ' ',
                        COALESCE(c.segundo_apellido, '')) cliente,
                c.cel,
                fc.fecha_cobro,
                v.cuota_mensual,
                fc.estado
            FROM
                fechas_cobros fc
                    JOIN
                ventas v ON fc.id_venta = v.id
                    JOIN
                clientes c ON v.id_cliente = c.id
            WHERE
                fc.estado = 'Atrasado'
                    AND YEAR(fc.fecha_cobro) = :anio
                    AND MONTH(fc.fecha_cobro) = :mes", [
                        "anio" => $anio,
                        "mes" => $mes
                    ]);

        $sin_mora = DB::select("SELECT 
                v.id idV,
                DATE_FORMAT(v.fecha_venta, '%d de %M de %Y %h:%i %p') AS fecha_formateada,
                CONCAT(COALESCE(c.primer_nombre, ''),
                        ' ',
                        COALESCE(c.segundo_nombre, ''),
                        ' ',
                        COALESCE(c.primer_apellido, ''),
                        ' ',
                        COALESCE(c.segundo_apellido, '')) cliente,
                c.cel,
                fc.fecha_cobro,
                v.cuota_mensual,
                fc.estado
            FROM
                fechas_cobros fc
                    JOIN
                ventas v ON fc.id_venta = v.id
                    JOIN
                clientes c ON v.id_cliente = c.id
            WHERE
                fc.estado != 'Atrasado' and fc.estado != 'Pagado'
                    AND YEAR(fc.fecha_cobro) = :anio
                    AND MONTH(fc.fecha_cobro) = :mes", [
                        "anio" => $anio,
                        "mes" => $mes
                    ]);

            $mora_total = collect(\DB::select("SELECT 
                COALESCE(FORMAT(SUM(CAST(REPLACE(v.cuota_mensual, ',', '') AS UNSIGNED)),
                            2),
                        0) AS mora_total
            FROM
                fechas_cobros fc
                    JOIN
                ventas v ON fc.id_venta = v.id
                    JOIN
                clientes c ON v.id_cliente = c.id
            WHERE
                fc.estado = 'Atrasado'
                    AND YEAR(fc.fecha_cobro) = :anio
                    AND MONTH(fc.fecha_cobro) = :mes", [
                        "anio" => $anio,
                        "mes" => $mes
                    ]))->first();

            $sin_mora_total = collect(\DB::select("SELECT 
                COALESCE(FORMAT(SUM(CAST(REPLACE(v.cuota_mensual, ',', '') AS UNSIGNED)),
                            2),
                        0) AS mora_total
            FROM
                fechas_cobros fc
                    JOIN
                ventas v ON fc.id_venta = v.id
                    JOIN
                clientes c ON v.id_cliente = c.id
            WHERE
                fc.estado != 'Atrasado'
                    AND fc.estado != 'Pagado'
                    AND YEAR(fc.fecha_cobro) = :anio
                    AND MONTH(fc.fecha_cobro) = :mes", [
                        "anio" => $anio,
                        "mes" => $mes
                    ]))->first();
        
        $data[]=[
            "movimientos"=>$movimientos,
            "morosos"=>$morosos,
            "sin_mora"=>$sin_mora,
            "mora_total"=>$mora_total->mora_total,
            "sin_mora_total"=>$sin_mora_total->mora_total
        ];

        //throw New Exception($data[0], true);
        //return $data;
        return view('morosos')->with('data', $data);
    }
}
