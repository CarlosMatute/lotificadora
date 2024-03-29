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

class controladorVentasApoyo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $venta = Venta::find($request->id_venta);

        $cuota = $venta->cuota_mensual;//Obtener la cuota

        $cuotaFormato = str_replace(',', '', $cuota);//Quitar coma al valor de la cuota

        $letras = $request->abono / $cuotaFormato;//Abono entre la cuota para saber cuantas latras paga

        $letrasEntero = intval($letras);//Convertir a entero el numero de letras

        $ultimoPago = fechas_cobros::all()->where("id_venta",$request->id_venta)->where("estado","Pendiente")->first();//Obtener la primera fila pendiente de pago
       
        if($ultimoPago == NULL){
            $idUltimoPago = 0;
        }else{
            $idUltimoPago = $ultimoPago->id;//id de la primera fila
        }

        $multiplicacion = $cuotaFormato * $letrasEntero;

        $cola = $request->abono - $multiplicacion;//Cola restante del abono

        $verificarColaExistente = fechas_cobros::all()->where("id_venta",$request->id_venta)->where("estado","Cola")->first();//Verificar si existe pago en cola

        if($verificarColaExistente == NULL){
            $colaExistente = "";
        }else{
            $colaExistente = $verificarColaExistente->estado;
        }


//------------------------------ciclo if para los abonos------------------------------
        if($request->abono > $cuotaFormato){//Abono mayor a la cuota--------------------------------------------

            if($colaExistente == "Cola"){
                DB::table('fechas_cobros')
                    ->where('id', $verificarColaExistente->id)
                    ->update(["cantidad_pago" => $cuotaFormato,
                                "fecha_pago" => DATE("Y-m-d H:i:s"),
                                "estado" => "Pagado"]);
                $abonado = $cuotaFormato - $verificarColaExistente->cantidad_pago;
                
                $restante = $request->abono - $abonado;

                $letras2 = $restante / $cuotaFormato;

                $letrasEntero2 = intval($letras2);

                $pagos2 = $verificarColaExistente->id + $letrasEntero2;

                $alcancLetras = $cuotaFormato * $letrasEntero2;

                $cola2 = $restante - $alcancLetras;

                if($alcancLetras >= $cuotaFormato){
                    for($i=$verificarColaExistente->id;$i<=$pagos2;$i++){
                        DB::table('fechas_cobros')
                            ->where('id', $i)
                            ->update(["cantidad_pago" => $cuotaFormato,
                                        "fecha_pago" => DATE("Y-m-d H:i:s"),
                                        "estado" => "Pagado"]);
                    
                    } 
                    if($cola2 != 0){
                        DB::table('fechas_cobros')
                            ->where('id', $pagos2+1)
                            ->update(["cantidad_pago" => $cola2,
                                        "fecha_pago" => DATE("Y-m-d H:i:s"),
                                        "estado" => "Cola"]);
                    }  
                }else{
                        DB::table('fechas_cobros')
                            ->where('id', $pagos2+1)
                            ->update(["cantidad_pago" => $cola2,
                                        "fecha_pago" => DATE("Y-m-d H:i:s"),
                                        "estado" => "Cola"]);        
                   
                }

                
            }else{
                $pagos = $idUltimoPago + $letrasEntero;

                for($i=$idUltimoPago;$i<$pagos;$i++){
                    DB::table('fechas_cobros')
                        ->where('id', $i)
                        ->update(["cantidad_pago" => $cuotaFormato,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Pagado"]);
                }
                
                if($cola < $request->abono){
                    DB::table('fechas_cobros')
                        ->where('id', $i)
                        ->update(["cantidad_pago" => $cola,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Cola"]);
                                    
                }
            }


        }else if($request->abono == $cuotaFormato){//Abono igual a la cuota--------------------------------------------------

            if($colaExistente == "Cola"){
                DB::table('fechas_cobros')
                    ->where('id', $verificarColaExistente->id)
                    ->update(["cantidad_pago" => $cuotaFormato,
                                "fecha_pago" => DATE("Y-m-d H:i:s"),
                                "estado" => "Pagado"]);

                DB::table('fechas_cobros')
                    ->where('id', $verificarColaExistente->id+1)
                    ->update(["cantidad_pago" => $verificarColaExistente->cantidad_pago,
                                "fecha_pago" => DATE("Y-m-d H:i:s"),
                                "estado" => "Cola"]);
            }else{

                $pagos = $idUltimoPago;
                for($i=$idUltimoPago;$i<=$pagos;$i++){
                    DB::table('fechas_cobros')
                        ->where('id', $i)
                        ->update(["cantidad_pago" => $cuotaFormato,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Pagado"]);
                }

            }


        }else if($request->abono < $cuotaFormato){//Abono menor a la cuota-----------------------------------------------
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>Hey te quedaste aqui, resolve esto<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
            if($colaExistente == "Cola"){
                $abonoACola = $cuotaFormato - $verificarColaExistente->cantidad_pago;
                $abono = $request->abono - $abonoACola;
                if($abono == $cuotaFormato){
                    DB::table('fechas_cobros')
                        ->where('id', $verificarColaExistente->id)
                        ->update(["cantidad_pago" => $cuotaFormato,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Pagado"]);

                    DB::table('fechas_cobros')
                        ->where('id', $verificarColaExistente->id+1)
                        ->update(["cantidad_pago" => $cuotaFormato,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Pagado"]);

                }else if($abono < $cuotaFormato){
                    DB::table('fechas_cobros')
                        ->where('id', $verificarColaExistente->id)
                        ->update(["cantidad_pago" => $cuotaFormato,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Pagado"]);
                    if($abono <> 0){
                        DB::table('fechas_cobros')
                            ->where('id', $verificarColaExistente->id+1)
                            ->update(["cantidad_pago" => $abono,
                                        "fecha_pago" => DATE("Y-m-d H:i:s"),
                                        "estado" => "Cola"]);
                    }
                                    
                // }else if($abono > $cuotaFormato){
                //     DB::table('fechas_cobros')
                //         ->where('id', $verificarColaExistente->id)
                //         ->update(["cantidad_pago" => $cuotaFormato,
                //                     "fecha_pago" => DATE("Y-m-d H:i:s"),
                //                     "estado" => "Pagado"]);
                                
                //     DB::table('fechas_cobros')
                //         ->where('id', $verificarColaExistente->id+1)
                //         ->update(["cantidad_pago" => $cuotaFormato,
                //                     "fecha_pago" => DATE("Y-m-d H:i:s"),
                //                     "estado" => "Pagado"]);

                //     DB::table('fechas_cobros')
                //         ->where('id', $verificarColaExistente->id+1)
                //         ->update(["cantidad_pago" => $abono2,
                //                     "fecha_pago" => DATE("Y-m-d H:i:s"),
                //                     "estado" => "Cola"]);

                }
                
            }else{
                $pagos = $idUltimoPago;

                for($i=$idUltimoPago;$i<=$pagos;$i++){
                    DB::table('fechas_cobros')
                        ->where('id', $i)
                        ->update(["cantidad_pago" => $request->abono,
                                    "fecha_pago" => DATE("Y-m-d H:i:s"),
                                    "estado" => "Cola"]);
                }
            }
            
        }
        
        //------------------------------finaliza ciclo if para los abonos------------------------------
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

        $ultimaLetra = fechas_cobros::all()->where("id_venta",$request->id_venta)->last();

        if($ultimaLetra->estado == "Pagado"){
            DB::table('ventas')
                    ->where('id', $ultimaLetra->id_venta)
                    ->update(["estado" => "Pagado"]);

        }

        $resumenVenta = DB::table("ventas")
                            ->join("clientes","ventas.id_cliente","=","clientes.id")
                            ->where("ventas.id",$request->id_venta)
                            ->get();

        $fechasCobros = DB::table("fechas_cobros")
                            ->join("ventas","fechas_cobros.id_venta","=","ventas.id")
                            ->where("fechas_cobros.id_venta", $request->id_venta)
                            ->select("fechas_cobros.*","ventas.*","fechas_cobros.id as idFC","ventas.id as idV","ventas.estado as estadoV","fechas_cobros.estado as estadoFC")
                            ->get();

        foreach($resumenVenta as $row){
            $total = $row->total_pagar;
        }

        $sumaPagos = DB::table("fechas_cobros")->where("id_venta", $request->id_venta)->get()->sum("cantidad_pago");

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

        $ultimopago2 = fechas_cobros::all()->where("id_venta",$request->id_venta)->where("estado","Pagado")->last();

        $primerpago = fechas_cobros::all()->where("id_venta",$request->id_venta)->whereIn("estado",["Pendiente","Atrasado","Dia de cobro"])->first();

        $cola3 = fechas_cobros::all()->where("id_venta",$request->id_venta)->where("estado","Cola")->last();

        if($ultimopago2 == NULL){
            $idUltimpoPago = 0;
        }else{
            $idUltimpoPago = $ultimopago2->id;
        }

        if($primerpago == NULL){
            $letraActiva = 0;
        }else{
            $letraActiva = $primerpago->id;
        }

        if($cola3 == NULL){
            $colaId = 0;
            $data[]=[
                "resumenVenta"=>$resumenVenta,
                "fechaCobros"=>$fechasCobros,
                "totalRestante"=>$totalRestanteFormato,
                "pagos"=>$sumaPagosFormato,
                "ultimopago" => $idUltimpoPago,
                "letraActiva" => $letraActiva,
                "idVenta" => $request->id_venta,
                "cola" => $colaId,
                "deuda" => $deudaDecimal
            ];
        }else{
            $colaId = $cola3->estado;
            $data[]=[
                "resumenVenta"=>$resumenVenta,
                "fechaCobros"=>$fechasCobros,
                "totalRestante"=>$totalRestanteFormato,
                "pagos"=>$sumaPagosFormato,
                "ultimopago" => 0,
                "letraActiva" => 0,
                "idVenta" => $request->id_venta,
                "cola" => $colaId,
                "deuda" => $deudaDecimal
            ];
        }

        return $data;




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venta = fechas_cobros::find($id);

        $idVenta = $venta->id_venta;

        DB::table('fechas_cobros')
                    ->where('id', $id)
                    ->update(["cantidad_pago" => NULL,
                                "fecha_pago" => NULL,
                                "estado" => "Pendiente"]);

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $venta = fechas_cobros::find($id);

        $idVenta = $venta->id_venta;

        $venta = Venta::find($idVenta);
        $ventaCuota = $venta->cuota_mensual;
        $ventaCuotaFormato = str_replace(',', '', $ventaCuota);

        DB::table('fechas_cobros')
                    ->where('id', $id)
                    ->update(["cantidad_pago" => $ventaCuotaFormato,
                                "fecha_pago" => DATE("Y-m-d H:i:s"),
                                "estado" => "Pagado"]);

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

        $primerpago = fechas_cobros::all()->where("id_venta",$idVenta)->where("estado","Pendiente")->first();

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
        $msg = null;

            DB::beginTransaction();
            try{ 
            DB::select("update ventas set id_cliente = (select id from clientes where identidad = :identidad),
            pago = (case when :pago = 1 then 'Credito' else 'Contado' end), 
            estado = (case when :pago2 = 1 then 'Pendiente' else 'Pagado' end), total_contado = :total_contado, anios_financiamiento = :anios_financiamiento,
            tasa_interes = :tasa_interes, prima = :prima, cuotas = :cuotas, total_intereses = :total_interes, total_pagar = :total_pagar, 
            cuota_mensual = :cuota_mensual, dias_cobro_mes = :dias_cobro_mensual, updated_at = now()
            where id = :id_venta",
            ["identidad" => $request->cliente, 
            'pago' => $request->accionCreditoContado,
            'pago2' => $request->accionCreditoContado,
            'total_contado' => $request->total_contado,
            "anios_financiamiento" => $request->anios_financiamiento,
            'tasa_interes' => $request->tasa_interes,
            'prima' => $request->prima,
            'cuotas' => $request->cuotas,
            'total_interes' => $request->total_intereses,
            'total_pagar' => $request->total_pagar,
            'cuota_mensual' => $request->cuota_mensual,
            'dias_cobro_mensual' => $request->dias_cobro_mensual,
            'id_venta' => $id]);

            DB::select("delete from fechas_cobros where id_venta = :id_venta", ["id_venta" => $id]);

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
                        $fecha->id_venta = $id; 
                        
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
                        $fecha->id_venta = $id;  

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

            $msg = 'Venta editada Exitosamente';
            DB::commit();
            }catch (Exception $e){
                DB::rollback();
                $msg=$e->getMessage();
            }

        return $msg;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrarCuota = fechas_cobros::where("id_venta", $id)->delete();
        $lotesDisponibles = DB::select("update lotes set estado = 'Disponible' where id in (select id_lote from lotes_vendidos where id_venta = :id_venta);",
            ["id_venta" => $id]);
        $borrarLotesVendidos = lotes_vendidos::where("id_venta", $id)->delete();
        $borrarVenta = Venta::find($id);
        $borrarVenta->delete(); 

        return 'Borrado';
    }
}
