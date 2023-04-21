<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;
use App\Models\lotes_apartados;
use App\Models\Venta;
use App\Models\Cliente;
use App\Models\fechas_cobros;

class controladorDashboard extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
       //$enenroUnico = $enero->unique('estado');
        $enero = fechas_cobros::whereMonth('fecha_cobro', '01')->where('estado','Atrasado')->first();
        $febrero = fechas_cobros::whereMonth('fecha_cobro', '02')->where('estado','Atrasado')->first();
        $marzo = fechas_cobros::whereMonth('fecha_cobro', '03')->where('estado','Atrasado')->first();
        $abril = fechas_cobros::whereMonth('fecha_cobro', '04')->where('estado','Atrasado')->first();
        $mayo = fechas_cobros::whereMonth('fecha_cobro', '05')->where('estado','Atrasado')->first();
        $junio = fechas_cobros::whereMonth('fecha_cobro', '06')->where('estado','Atrasado')->first();
        $julio = fechas_cobros::whereMonth('fecha_cobro', '07')->where('estado','Atrasado')->first();
        $agosto = fechas_cobros::whereMonth('fecha_cobro', '08')->where('estado','Atrasado')->first();
        $septiembre = fechas_cobros::whereMonth('fecha_cobro', '09')->where('estado','Atrasado')->first();
        $octubre = fechas_cobros::whereMonth('fecha_cobro', '10')->where('estado','Atrasado')->first();
        $noviembre = fechas_cobros::whereMonth('fecha_cobro', '11')->where('estado','Atrasado')->first();
        $diciembre = fechas_cobros::whereMonth('fecha_cobro', '12')->where('estado','Atrasado')->first();
        
        //Inicia estados de enero
        if($enero == NULL){
            $cobroEnero = fechas_cobros::whereMonth('fecha_cobro', '01')->where('estado','Dia de cobro')->first();
            if($cobroEnero == NULL){
                $enenroEstado = 0;
            }else{
                $enenroEstado = $cobroEnero->estado;
            }
            
        }else{
            $enenroEstado = $enero->estado;
        }
        //finaliza estados de enero
        //Inicia estados de febrero
        if($febrero == NULL){
            $cobroFebrero = fechas_cobros::whereMonth('fecha_cobro', '02')->where('estado','Dia de cobro')->first();
            if($cobroFebrero == NULL){
                $febreroEstado = 0;
            }else{
                $febreroEstado = $cobroFebrero->estado;
            }
        }else{
            $febreroEstado = $febrero->estado;
        }
        //Finaliza estados de febrero
        //Inicia estados de marzo
        if($marzo == NULL){
            $cobroMarzo = fechas_cobros::whereMonth('fecha_cobro', '03')->where('estado','Dia de cobro')->first();
            if($cobroMarzo == NULL){
                $marzoEstado = 0;
            }else{
                $marzoEstado = $cobroMarzo->estado;
            }
        }else{
            $marzoEstado = $marzo->estado;
        }
        //Finaliza estados de marzo
        //Inicia estados de abril
        if($abril == NULL){
            $cobroAbril = fechas_cobros::whereMonth('fecha_cobro', '04')->where('estado','Dia de cobro')->first();
            if($cobroAbril == NULL){
                $abrilEstado = 0;
            }else{
                $abrilEstado = $cobroAbril->estado;
            }
        }else{
            $abrilEstado = $abril->estado;
        }
        //Finaliza estados de abril
        //Inicia estados de mayo
        if($mayo == NULL){
            $cobroMayo = fechas_cobros::whereMonth('fecha_cobro', '05')->where('estado','Dia de cobro')->first();
            if($cobroMayo == NULL){
                $mayoEstado = 0;
            }else{
                $mayoEstado = $cobroMayo->estado;
            }
        }else{
            $mayoEstado = $mayo->estado;
        }
        //Finaliza estados de mayo
        //Inicia estados de junio
        if($junio == NULL){
            $cobroJunio = fechas_cobros::whereMonth('fecha_cobro', '06')->where('estado','Dia de cobro')->first();
            if($cobroJunio == NULL){
                $junioEstado = 0;
            }else{
                $junioEstado = $cobroJunio->estado;
            }
        }else{
            $junioEstado = $junio->estado;
        }
        //Finaliza estados de junio
        //Inicia estados de julio
        if($julio == NULL){
            $cobroJulio = fechas_cobros::whereMonth('fecha_cobro', '07')->where('estado','Dia de cobro')->first();
            if($cobroJulio == NULL){
                $julioEstado = 0;
            }else{
                $julioEstado = $cobroJulio->estado;
            }
        }else{
            $julioEstado = $julio->estado;
        }
        //Finaliza estados de julio
        //Inicia estados de agosto
        if($agosto == NULL){
            $cobroAgosto = fechas_cobros::whereMonth('fecha_cobro', '08')->where('estado','Dia de cobro')->first();
            if($cobroAgosto == NULL){
                $agostoEstado = 0;
            }else{
                $agostoEstado = $cobroAgosto->estado;
            }
        }else{
            $agostoEstado = $agosto->estado;
        }
        //Finaliza estados de agosto
        //Inicia estados de septiembre
        if($septiembre == NULL){
            $cobroSeptiembre = fechas_cobros::whereMonth('fecha_cobro', '09')->where('estado','Dia de cobro')->first();
            if($cobroSeptiembre == NULL){
                $septiembreEstado = 0;
            }else{
                $septiembreEstado = $cobroSeptiembre->estado;
            }
        }else{
            $septiembreEstado = $septiembre->estado;
        }
        //Finaliza estados de septiembre
        //Inicia estados de octubre
        if($octubre == NULL){
            $cobroOctubre = fechas_cobros::whereMonth('fecha_cobro', '10')->where('estado','Dia de cobro')->first();
            if($cobroOctubre == NULL){
                $octubreEstado = 0;
            }else{
                $octubreEstado = $cobroOctubre->estado;
            }
        }else{
            $octubreEstado = $octubre->estado;
        }
        //Finaliza estados de octubre
        //Inicia estados de noviembre
        if($noviembre == NULL){
            $cobroNoviembre = fechas_cobros::whereMonth('fecha_cobro', '11')->where('estado','Dia de cobro')->first();
            if($cobroNoviembre == NULL){
                $noviembreEstado = 0;
            }else{
                $noviembreEstado = $cobroNoviembre->estado;
            }
        }else{
            $noviembreEstado = $noviembre->estado;
        }
        //Finaliza estados de noviembre
        //Inicia estados de diciembre
        if($diciembre == NULL){
            $cobroDiciembre = fechas_cobros::whereMonth('fecha_cobro', '12')->where('estado','Dia de cobro')->first();
            if($cobroDiciembre == NULL){
                $diciembreEstado = 0;
            }else{
                $diciembreEstado = $cobroDiciembre->estado;
            }
        }else{
            $diciembreEstado = $diciembre->estado;
        }
        //Finaliza estados de diciembre
        
        // $enero = fechas_cobros::whereMonth('fecha_cobro', '01')->get();

        //setear base a español
        DB::select("SET lc_time_names = 'es_ES';");
        //Movimientos del mes actual
        $movimientos = collect(\DB::select("
        with total as (
            select coalesce(sum(CAST(replace(v.cuota_mensual, ',', '') AS UNSIGNED)), 0) total_cobrar from ventas v
                join fechas_cobros fc on v.id = fc.id_venta
                where DATE_FORMAT(fecha_cobro,'%m-%Y') = DATE_FORMAT(now(),'%m-%Y')
        ), pagado as (
                select coalesce(sum(cantidad_pago), 0) total_pagado from fechas_cobros where DATE_FORMAT(fecha_cobro,'%m-%Y') = DATE_FORMAT(now(),'%m-%Y') and estado = 'Pagado'
        )
        select DATE_FORMAT(now(), '%M') mes_actual, FORMAT(total_cobrar,2) total_cobrar, FORMAT(total_pagado,2) total_pagado, FORMAT((total_cobrar - total_pagado),2) restante,
        ROUND((total_pagado*100/total_cobrar), 1) porcentaje_cobrado
        from total 
        join pagado on true
        "))->first();


        $data[]=[
            "enero"=>$enenroEstado,
            "febrero"=>$febreroEstado,
            "marzo"=>$marzoEstado,
            "abril"=>$abrilEstado,
            "mayo"=>$mayoEstado,
            "junio"=>$junioEstado,
            "julio"=>$julioEstado,
            "agosto"=>$agostoEstado,
            "septiembre"=>$septiembreEstado,
            "octubre"=>$octubreEstado,
            "noviembre"=>$noviembreEstado,
            "diciembre"=>$diciembreEstado,
            "añoActual"=>date("Y"),
            "mesActual"=>$movimientos->mes_actual,
            "totalCobrar"=>$movimientos->total_cobrar,
            "totalPagado"=>$movimientos->total_pagado,
            "totalRestante"=>$movimientos->restante,
            "porcentajeCobrado"=>$movimientos->porcentaje_cobrado
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $añoActual = date("Y");
        $letras = DB::table("fechas_cobros")
                        ->join("ventas","fechas_cobros.id_venta","=","ventas.id")
                        ->join("clientes","ventas.id_cliente","=","clientes.id")
                        ->select("fechas_cobros.*","ventas.*","clientes.*","fechas_cobros.id as idFC","fechas_cobros.estado as estadoFC",
                                    "ventas.id as idV","ventas.estado as estadoV","clientes.id as idC","fechas_cobros.created_at as fechaFC",
                                    "ventas.created_at as fechaV","clientes.created_at as fechaC")
                        ->whereMonth('fecha_cobro', $id)->whereYear('fecha_cobro', $añoActual)->where("ventas.estado","Pendiente")
                        //->orderBy("fechas_cobros.created_at","ASC")
                        ->get();
        
        $data[]=[
            "infoCuotas"=>$letras,
            "id"=>$id,
            "añoActual"=>$añoActual
        ];
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
        $anio = $id == 0 ? 2023 : $id;
        
        //setear base a español
        DB::select("SET lc_time_names = 'es_ES';");
        $meses_anio_actual = DB::select("
        with total as (
            select DATE_FORMAT(fc.fecha_cobro,'%M') mes, coalesce(sum(CAST(replace(v.cuota_mensual, ',', '') AS UNSIGNED)), 0) total_cobrar from ventas v
                right join fechas_cobros fc on v.id = fc.id_venta
                where DATE_FORMAT(fc.fecha_cobro,'%Y') = ".$anio."
                group by DATE_FORMAT(fc.fecha_cobro,'%M')
                order by fc.fecha_cobro
        ), pagado as (
                select DATE_FORMAT(fecha_cobro,'%M') mes, coalesce(sum(cantidad_pago), 0) total_pagado from fechas_cobros where DATE_FORMAT(fecha_cobro,'%Y') = ".$anio." and estado = 'Pagado'
                group by DATE_FORMAT(fecha_cobro,'%M')
                order by fecha_cobro
        )
        select ".$anio." anio, t.mes, FORMAT(total_cobrar,2) total_cobrar, FORMAT(total_pagado,2) total_pagado, FORMAT((total_cobrar - total_pagado),2) restante,
        ROUND((total_pagado*100/total_cobrar), 1) porcentaje_cobrado
        from total t
        join pagado p on t.mes = p.mes
        ");

        return $meses_anio_actual;
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
        //
    }
}
