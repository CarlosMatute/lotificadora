<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;
use App\Models\lotes_apartados;
use App\Models\Cliente;
use App\Models\lotes_vendidos;
use App\Models\fechas_cobros;
use App\Models\Venta;

class ControladorVentas extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventaPendiente = DB::table("ventas")
                        ->join("clientes","ventas.id_cliente","=","clientes.id")
                        ->where("ventas.estado","Pendiente")
                        ->select("ventas.*","clientes.*","ventas.id as idV","clientes.id as idC","ventas.created_at as fechaV","clientes.created_at as fechaC")
                        ->get();
        $ventaContado = DB::table("ventas")
                        ->join("clientes","ventas.id_cliente","=","clientes.id")
                        ->where("ventas.pago","Contado")
                        ->select("ventas.*","clientes.*","ventas.id as idV","clientes.id as idC","ventas.created_at as fechaV","clientes.created_at as fechaC")
                        ->get();
        $ventaCredito = DB::table("ventas")
                        ->join("clientes","ventas.id_cliente","=","clientes.id")
                        ->where("ventas.pago","Credito")
                        ->where("ventas.estado","Pagado")
                        ->select("ventas.*","clientes.*","ventas.id as idV","clientes.id as idC","ventas.created_at as fechaV","clientes.created_at as fechaC")
                        ->get();

        $data[]=[
            "pendiente"=>$ventaPendiente,
            "contado"=>$ventaContado,
            "credito"=>$ventaCredito
        ];

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hoy = DATE("Y-m-d");

        $estados = DB::table("fechas_cobros")
                        ->where("estado","!=","Pagado")
                        ->get();

        foreach($estados as $row){
            $fecha = $row->fecha_cobro;

            if($hoy > $fecha){
                DB::table('fechas_cobros')
                    ->where('id', $row->id)
                    ->update(["estado" => "Atrasado"]);

               // return "Pago atrasado";
            }else if($hoy == $fecha){
                DB::table('fechas_cobros')
                    ->where('id', $row->id)
                    ->update(["estado" => "Dia de cobro"]);
               // return "Pago hoy";
            }else{
                //return "Pago pendiente";
            }
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = DB::table("clientes")
                    ->where("identidad", $request->cliente)
                    ->get();
        foreach($cliente as $row){
            $id_cliente = $row->id;
        }

        $primaFormato = number_format($request->prima, 2, '.', ',');

        if($request->accionCreditoContado == 1){
            $pago = "Credito";
            $estado = "Pendiente";
        }else{
            $pago = "Contado";
            $estado = "Pagado";
        }

        $venta = new Venta();
        $venta->id_cliente = $id_cliente;
        $venta->pago = $pago;
        $venta->estado = $estado;
        $venta->total_contado = $request->total_contado;
        $venta->anios_financiamiento = $request->anios_financiamiento;
        $venta->tasa_interes = $request->tasa_interes;
        $venta->prima = $primaFormato;
        $venta->cuotas = $request->cuotas;
        $venta->total_intereses = $request->total_intereses;
        $venta->total_pagar = $request->total_pagar;
        $venta->cuota_mensual = $request->cuota_mensual;
        $venta->dias_cobro_mes = $request->dias_cobro_mensual;
        $venta->save();
        
        $id_venta = Venta::all()->last();

        if($request->accionCreditoContado == 1){

            $meses = $request->anios_financiamiento*12;
            //Proceso de dias de cobro
            $hoy = DATE("Y-m");
            $hoyCompuesto = $hoy."-".$request->dias_cobro_mensual;

            //Insercion de fechas de cobro
            if($hoyCompuesto[6] == 2 && $request->dias_cobro_mensual >= 29){
                for($i=0; $i<$meses; $i++){
                    $date_now = $hoyCompuesto;
                    $date_future = strtotime('+ '.$i.' month', strtotime($date_now));
                    $date_future = date('Y-m-d', $date_future);  
                    $fecha = new fechas_cobros();
                    $fecha->id_venta = $id_venta->id; 
                    
                    if($date_future[5] == 0 && $date_future[6] == 2 && $request->dias_cobro_mensual >= 29){
                        $fecha->fecha_cobro = $date_future[0].$date_future[1].$date_future[2].$date_future[3].$date_future[4].$date_future[5]."2-28";
                    }else{
                        $fecha->fecha_cobro = $date_future[0].$date_future[1].$date_future[2].$date_future[3].$date_future[4].$date_future[5].$date_future[6]."-".$request->dias_cobro_mensual;
                    }
                    $fecha->estado = "Pendiente";
                    $fecha->save();
                }
            }else{
                for($i=1; $i<=$meses; $i++){
                    $date_now = $hoy;
                    $date_future = strtotime('+ '.$i.' month', strtotime($date_now));
                    $date_future = date('Y-m', $date_future); 
                    $fecha = new fechas_cobros();
                    $fecha->id_venta = $id_venta->id;  

                    if($date_future[5] != 0 || $date_future[6] != 2 || $request->dias_cobro_mensual <= 28){
                        $fecha->fecha_cobro = $date_future[0].$date_future[1].$date_future[2].$date_future[3].$date_future[4].$date_future[5].$date_future[6]."-".$request->dias_cobro_mensual;

                    }else{
                        $fecha->fecha_cobro = $date_future[0].$date_future[1].$date_future[2].$date_future[3].$date_future[4].$date_future[5]."2-28";
                    }
                    $fecha->estado = "Pendiente";
                    $fecha->save();
                
                }
            }
            
        }


         $id_lotes = lotes_apartados::select('id_lote')->get();
         //$id_lotes = array([1,2]);

         $datos_a_insertar = array();

         /* añadimos los datos al array */
         foreach ($id_lotes as $key => $lotes) 
         {
             $datos_a_insertar[$key]['id_lote'] = $lotes->id_lote;
             $datos_a_insertar[$key]['id_venta'] = $id_venta->id;
         }
 
         /* Luego simplemente lo insertamos con Eloquent o con Query Builder */
         /* con Eloquent */
         lotes_vendidos::insert($datos_a_insertar); 

         $lotes_apartados = DB::table("lotes_apartados")->get();

         $datos_array = array();
 
          /* añadimos los datos al array */
          foreach ($lotes_apartados as $key => $apartados) 
          {
              $datos_array[$key] = $apartados->id_lote;
          }

        DB::table('lotes')
            ->whereIn('id', $datos_array)
            ->update(["estado" => "Vendido"]);

        $borrar_lotes_apartados = DB::table("lotes_apartados")
            ->where("temp", "Si")
            ->delete();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resumenVenta = DB::table("ventas")
                            ->join("clientes","ventas.id_cliente","=","clientes.id")
                            ->where("ventas.id",$id)
                            ->get();

        $fechasCobros = DB::table("fechas_cobros")
                            ->join("ventas","fechas_cobros.id_venta","=","ventas.id")
                            ->where("fechas_cobros.id_venta", $id)
                            ->select("fechas_cobros.*","ventas.*","fechas_cobros.id as idFC","ventas.id as idV","ventas.estado as estadoV","fechas_cobros.estado as estadoFC")
                            ->get();

        foreach($resumenVenta as $row){
            $total = $row->total_pagar;
        }

        $sumaPagos = DB::table("fechas_cobros")->where("id_venta", $id)->get()->sum("cantidad_pago");

        foreach($resumenVenta as $row){
            $totalPago = $row->total_pagar;
        }

        $totalFormato = str_replace(',', '', $totalPago); 
        $totalDecimal = floatval($totalFormato);

        $totalRestante = $totalDecimal - $sumaPagos;

        $totalRestanteFormato = number_format($totalRestante, 2, '.', ',');

        $deudaFormato = number_format($totalRestante, 2, '.', '');

        $deudaDecimal = floatval($deudaFormato);

        $sumaPagosFormato = number_format($sumaPagos, 2, '.', ',');

        $ultimopago = fechas_cobros::all()->where("id_venta",$id)->where("estado","Pagado")->last();

        $primerpago = fechas_cobros::all()->where("id_venta",$id)->whereIn("estado",["Pendiente","Atrasado","Dia de cobro"])->first();

        $cola = fechas_cobros::all()->where("id_venta",$id)->where("estado","Cola")->last();

        if($ultimopago == NULL){
            $idUltimpoPago = 0;
        }else{
            $idUltimpoPago = $ultimopago->id;
        }

        if($primerpago == NULL){
            $letraActiva = 0;
        }else{
            $letraActiva = $primerpago->id;
        }

        if($cola == NULL){
            $colaId = 0;
            $data[]=[
                "resumenVenta"=>$resumenVenta,
                "fechaCobros"=>$fechasCobros,
                "totalRestante"=>$totalRestanteFormato,
                "pagos"=>$sumaPagosFormato,
                "ultimopago" => $idUltimpoPago,
                "letraActiva" => $letraActiva,
                "idVenta" => $id,
                "cola" => $colaId,
                "deuda" => $deudaDecimal
            ];
        }else{
            $colaId = $cola->estado;
            $data[]=[
                "resumenVenta"=>$resumenVenta,
                "fechaCobros"=>$fechasCobros,
                "totalRestante"=>$totalRestanteFormato,
                "pagos"=>$sumaPagosFormato,
                "ultimopago" => 0,
                "letraActiva" => 0,
                "idVenta" => $id,
                "cola" => $colaId,
                "deuda" => $deudaDecimal
            ];
        }

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fechasCobros = fechas_cobros::find($id);
        $idVenta = $fechasCobros->id_venta;

        $venta = Venta::find($idVenta);
        $ventaCuota = $venta->cuota_mensual;
        $ventaCuotaFormato = str_replace(',', '', $ventaCuota);

        DB::table('fechas_cobros')
            ->where('id', $id)
            ->update(["cantidad_pago" => $ventaCuotaFormato,
                        "fecha_pago" => DATE("Y-m-d H:i:s"),
                        "estado" => "Pagado"]);

        $hoy = DATE("Y-m-d");

        $estados = DB::table("fechas_cobros")
                        ->where("estado","!=","Pagado")
                        ->get();

        foreach($estados as $row){
            $fecha = $row->fecha_cobro;

            if($hoy > $fecha){
                DB::table('fechas_cobros')
                    ->where('id', $row->id)
                    ->update(["estado" => "Atrasado"]);

               // return "Pago atrasado";
            }else if($hoy == $fecha){
                DB::table('fechas_cobros')
                    ->where('id', $row->id)
                    ->update(["estado" => "Dia de cobro"]);
               // return "Pago hoy";
            }else{
                //return "Pago pendiente";
            }
        }

        $ultimaLetra = fechas_cobros::all()->where("id_venta",$idVenta)->last();

        if($ultimaLetra->estado == "Pagado"){
            DB::table('ventas')
                    ->where('id', $ultimaLetra->id_venta)
                    ->update(["estado" => "Pagado"]);

        }

        $resumenVenta = DB::table("ventas")
                        ->join("clientes","ventas.id_cliente","=","clientes.id")
                        ->where("ventas.id",$idVenta)
                        ->get();

        $fechasCobros = DB::table("fechas_cobros")
                            ->join("ventas","fechas_cobros.id_venta","=","ventas.id")
                            ->where("fechas_cobros.id_venta", $idVenta)
                            ->select("fechas_cobros.*","ventas.*","fechas_cobros.id as idFC","ventas.id as idV","ventas.estado as estadoV","fechas_cobros.estado as estadoFC")
                            ->get();

        foreach($resumenVenta as $row){
            $total = $row->total_pagar;
        }

        $sumaPagos = DB::table("fechas_cobros")->where("id_venta", $idVenta)->get()->sum("cantidad_pago");

        foreach($resumenVenta as $row){
            $totalPago = $row->total_pagar;
        }

        $totalFormato = str_replace(',', '', $totalPago); 
        $totalDecimal = floatval($totalFormato);

        $totalRestante = $totalDecimal - $sumaPagos;

        $totalRestanteFormato = number_format($totalRestante, 2, '.', ',');

        $deudaFormato = number_format($totalRestante, 2, '.', '');

        $deudaDecimal = floatval($deudaFormato);

        $sumaPagosFormato = number_format($sumaPagos, 2, '.', ',');

        $ultimopago = fechas_cobros::all()->where("id_venta",$idVenta)->where("estado","Pagado")->last();

        $primerpago = fechas_cobros::all()->where("id_venta",$idVenta)->whereIn("estado",["Pendiente","Atrasado","Dia de cobro"])->first();

        $cola = fechas_cobros::all()->where("id_venta",$id)->where("estado","Cola")->last();

        if($ultimopago == NULL){
            $idUltimpoPago = 0;
        }else{
            $idUltimpoPago = $ultimopago->id;
        }

        if($primerpago == NULL){
            $letraActiva = 0;
        }else{
            $letraActiva = $primerpago->id;
        }

        if($cola == NULL){
            $colaId = 0;
            $data[]=[
                "resumenVenta"=>$resumenVenta,
                "fechaCobros"=>$fechasCobros,
                "totalRestante"=>$totalRestanteFormato,
                "pagos"=>$sumaPagosFormato,
                "ultimopago" => $idUltimpoPago,
                "letraActiva" => $letraActiva,
                "idVenta" => $idVenta,
                "cola" => $colaId,
                "deuda" => $deudaDecimal
            ];
        }else{
            $colaId = $cola->estado;
            $data[]=[
                "resumenVenta"=>$resumenVenta,
                "fechaCobros"=>$fechasCobros,
                "totalRestante"=>$totalRestanteFormato,
                "pagos"=>$sumaPagosFormato,
                "ultimopago" => 0,
                "letraActiva" => 0,
                "idVenta" => $idVenta,
                "cola" => $colaId,
                "deuda" => $deudaDecimal
            ];
        }

        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('fechas_cobros')
            ->where('id', $id)
            ->update(["cantidad_pago" => NULL,
                        "fecha_pago" => NULL,
                        "estado" => "Pendiente"]);
                        
        $fechasCobros = fechas_cobros::find($id);
        $idVenta = $fechasCobros->id_venta;

        $hoy = DATE("Y-m-d");

        $estados = DB::table("fechas_cobros")
                        ->where("estado","!=","Pagado")
                        ->get();

        foreach($estados as $row){
            $fecha = $row->fecha_cobro;

            if($hoy > $fecha){
                DB::table('fechas_cobros')
                    ->where('id', $row->id)
                    ->update(["estado" => "Atrasado"]);

               // return "Pago atrasado";
            }else if($hoy == $fecha){
                DB::table('fechas_cobros')
                    ->where('id', $row->id)
                    ->update(["estado" => "Dia de cobro"]);
               // return "Pago hoy";
            }else{
                //return "Pago pendiente";
            }
        }

        $ultimaLetra = fechas_cobros::all()->where("id_venta",$idVenta)->last();

        if($ultimaLetra->estado != "Pagado"){
            DB::table('ventas')
                    ->where('id', $ultimaLetra->id_venta)
                    ->update(["estado" => "Pendiente"]);

        }

        $resumenVenta = DB::table("ventas")
                        ->join("clientes","ventas.id_cliente","=","clientes.id")
                        ->where("ventas.id",$idVenta)
                        ->get();

        $fechasCobros = DB::table("fechas_cobros")
                            ->join("ventas","fechas_cobros.id_venta","=","ventas.id")
                            ->where("fechas_cobros.id_venta", $idVenta)
                            ->select("fechas_cobros.*","ventas.*","fechas_cobros.id as idFC","ventas.id as idV","ventas.estado as estadoV","fechas_cobros.estado as estadoFC")
                            ->get();

        foreach($resumenVenta as $row){
            $total = $row->total_pagar;
        }

        $sumaPagos = DB::table("fechas_cobros")->where("id_venta", $idVenta)->get()->sum("cantidad_pago");

        foreach($resumenVenta as $row){
            $totalPago = $row->total_pagar;
        }

        $totalFormato = str_replace(',', '', $totalPago); 
        $totalDecimal = floatval($totalFormato);

        $totalRestante = $totalDecimal - $sumaPagos;

        $totalRestanteFormato = number_format($totalRestante, 2, '.', ',');

        $deudaFormato = number_format($totalRestante, 2, '.', '');

        $deudaDecimal = floatval($deudaFormato);

        $sumaPagosFormato = number_format($sumaPagos, 2, '.', ',');

        $ultimopago = fechas_cobros::all()->where("id_venta",$idVenta)->where("estado","Pagado")->last();

        $primerpago = fechas_cobros::all()->where("id_venta",$idVenta)->whereIn("estado",["Pendiente","Atrasado","Dia de cobro"])->first();

        if($ultimopago == NULL){
            $idUltimpoPago = 0;
        }else{
            $idUltimpoPago = $ultimopago->id;
        }

        $letraActiva = $primerpago->id;

        $data[]=[
            "resumenVenta"=>$resumenVenta,
            "fechaCobros"=>$fechasCobros,
            "totalRestante"=>$totalRestanteFormato,
            "pagos"=>$sumaPagosFormato,
            "ultimopago" => $idUltimpoPago,
            "letraActiva" => $letraActiva,
            "idVenta" => $idVenta,
            "deuda" => $deudaDecimal
        ];

        return $data;
    }
}
