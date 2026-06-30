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

    public function resumen_financiero($id)
    {
        $residencial = \App\Models\Residenciale::find($id);

        $resumen = collect(\DB::select("
            SELECT
                COUNT(DISTINCT v.id) total_ventas,
                COUNT(DISTINCT CASE WHEN v.estado = 'Pagado' THEN v.id END) ventas_pagadas,
                COUNT(DISTINCT CASE WHEN v.estado = 'Pendiente' THEN v.id END) ventas_pendientes,
                COALESCE(SUM(CAST(REPLACE(v.total_contado, ',', '') AS DECIMAL(14,2))), 0) total_contado,
                COALESCE(SUM(CAST(REPLACE(v.total_pagar, ',', '') AS DECIMAL(14,2))), 0) total_esperado,
                COALESCE((
                    SELECT SUM(CAST(REPLACE(fc2.cantidad_pago, ',', '') AS DECIMAL(14,2)))
                    FROM fechas_cobros fc2
                    WHERE fc2.estado = 'Pagado'
                    AND fc2.id_venta IN (
                        SELECT DISTINCT lv2.id_venta
                        FROM lotes_vendidos lv2
                        JOIN lotes l2 ON l2.id = lv2.id_lote
                        JOIN bloques b2 ON b2.id = l2.id_bloque
                        WHERE b2.id_residencial = ?
                    )
                ), 0) total_cobrado
            FROM ventas v
            WHERE v.id IN (
                SELECT DISTINCT lv.id_venta
                FROM lotes_vendidos lv
                JOIN lotes l ON l.id = lv.id_lote
                JOIN bloques b ON b.id = l.id_bloque
                WHERE b.id_residencial = ?
            )
        ", [$id, $id]))->first();

        $detalle = \DB::select("
            SELECT
                v.id id_venta,
                CONCAT(c.primer_nombre, ' ', c.segundo_nombre, ' ', c.primer_apellido, ' ', c.segundo_apellido) cliente,
                c.identidad,
                c.cel,
                v.pago,
                v.estado,
                CAST(REPLACE(v.total_contado, ',', '') AS DECIMAL(14,2)) total_contado,
                CAST(REPLACE(v.total_pagar, ',', '') AS DECIMAL(14,2)) total_pagar,
                CAST(REPLACE(v.cuota_mensual, ',', '') AS DECIMAL(14,2)) cuota_mensual,
                v.cuotas,
                v.anios_financiamiento,
                v.tasa_interes,
                DATE_FORMAT(v.created_at, '%d/%m/%Y') fecha_venta,
                COALESCE((
                    SELECT SUM(CAST(REPLACE(fc.cantidad_pago, ',', '') AS DECIMAL(14,2)))
                    FROM fechas_cobros fc
                    WHERE fc.id_venta = v.id AND fc.estado = 'Pagado'
                ), 0) cobrado
            FROM ventas v
            JOIN clientes c ON c.id = v.id_cliente
            WHERE v.id IN (
                SELECT DISTINCT lv.id_venta
                FROM lotes_vendidos lv
                JOIN lotes l ON l.id = lv.id_lote
                JOIN bloques b ON b.id = l.id_bloque
                WHERE b.id_residencial = ?
            )
            ORDER BY v.created_at DESC
        ", [$id]);

        $lotesPorVenta = \DB::select("
            SELECT lv.id_venta, GROUP_CONCAT(CONCAT('L-', l.nombre) SEPARATOR ', ') lotes
            FROM lotes_vendidos lv
            JOIN lotes l ON l.id = lv.id_lote
            JOIN bloques b ON b.id = l.id_bloque
            WHERE b.id_residencial = ?
            GROUP BY lv.id_venta
        ", [$id]);

        $lotesMap = [];
        foreach ($lotesPorVenta as $row) {
            $lotesMap[$row->id_venta] = $row->lotes;
        }

        foreach ($detalle as $row) {
            $row->lotes_texto = $lotesMap[$row->id_venta] ?? '';
            $row->saldo = $row->pago == 'Credito'
                ? $row->total_pagar - $row->cobrado
                : ($row->estado == 'Pagado' ? 0 : $row->total_contado);
        }

        $data = [
            'residencial' => $residencial,
            'resumen' => $resumen,
            'detalle' => $detalle
        ];

        return view('registrarResidenciales.resumenFinanciero')->with('data', $data);
    }

    public function detalle_venta($id)
    {
        $venta = collect(\DB::select("
            SELECT v.*,
                CONCAT(c.primer_nombre, ' ', c.segundo_nombre, ' ', c.primer_apellido, ' ', c.segundo_apellido) cliente,
                c.identidad, c.cel, c.cel2, c.correo, c.direccion
            FROM ventas v
            JOIN clientes c ON c.id = v.id_cliente
            WHERE v.id = ?
        ", [$id]))->first();

        $lotes = \DB::select("
            SELECT l.nombre, l.precio, l.area, l.norte, l.sur, l.este, l.oeste,
                b.nombre as bloque, r.nombre as residencial
            FROM lotes_vendidos lv
            JOIN lotes l ON l.id = lv.id_lote
            JOIN bloques b ON b.id = l.id_bloque
            JOIN residenciales r ON r.id = b.id_residencial
            WHERE lv.id_venta = ?
        ", [$id]);

        $historialCuotas = \DB::select("
            SELECT fc.id, fc.fecha_cobro, fc.fecha_pago,
                CAST(REPLACE(fc.cantidad_pago, ',', '') AS DECIMAL(14,2)) cantidad_pago,
                fc.estado estadoFC
            FROM fechas_cobros fc
            WHERE fc.id_venta = ?
            ORDER BY fc.fecha_cobro
        ", [$id]);

        $totalCobrado = collect(\DB::select("
            SELECT COALESCE(SUM(CAST(REPLACE(cantidad_pago, ',', '') AS DECIMAL(14,2))), 0) total
            FROM fechas_cobros WHERE id_venta = ? AND estado = 'Pagado'
        ", [$id]))->first()->total;

        $data = [
            'venta' => $venta,
            'lotes' => $lotes,
            'historialCuotas' => $historialCuotas,
            'totalCobrado' => $totalCobrado
        ];

        return view('registrarResidenciales.detalleVentaFinanciero')->with('data', $data);
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
