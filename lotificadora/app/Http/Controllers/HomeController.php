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
}
