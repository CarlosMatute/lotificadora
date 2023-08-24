<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ControladorLotesApoyoIII extends Controller
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
        $id_venta = $request->id_venta;
        $fecha_venta = $request->fecha_venta;

        $fechas_correctas = DB::select("
            with fecha_correcta as (
                WITH RECURSIVE nrows(date) AS (
                        SELECT date_add('".$fecha_venta."', interval 1 month) UNION ALL 
                        SELECT DATE_ADD(date,INTERVAL 1 month) FROM nrows WHERE date <= DATE(date_add('".$fecha_venta."', interval (select cuotas from ventas where id = ".$id_venta.")-1 month))
                )
                SELECT ROW_NUMBER() OVER (ORDER BY date) fila,
                        case when DATE_FORMAT(date,'%m-%d') between '02-28' and '02-30' then concat(DATE_FORMAT(date,'%Y-%m-'),'28') else date end fechas 
                FROM nrows
            ), fechas_modificar as (
                select ROW_NUMBER() OVER (ORDER BY fecha_cobro) fila,
                        id, fecha_cobro
                from fechas_cobros where id_venta = ".$id_venta." order by fecha_cobro
            )
            select fm.id, fc.fechas from fecha_correcta fc 
            join fechas_modificar fm on fc.fila = fm.fila
        ");

     
        foreach($fechas_correctas as $row){
            DB::select("update fechas_cobros set fecha_cobro = '".$row->fechas."' where id = ".$row->id."");
        }

        DB::select("update ventas set fecha_venta = '".$fecha_venta."' where id = ".$id_venta."");

        //Manejo de estados de fechas de cobros
        DB::select("
        UPDATE fechas_cobros SET estado = CASE
            WHEN DATE_FORMAT(fecha_cobro,'%Y-%m-%d') < DATE_FORMAT(now(),'%Y-%m-%d') THEN 'Atrasado'
            WHEN DATE_FORMAT(fecha_cobro,'%Y-%m-%d') = DATE_FORMAT(now(),'%Y-%m-%d') THEN 'Dia de cobro'
            ELSE estado
            END
        WHERE estado != 'Pagado' and id_venta = :id_venta
    ",["id_venta" => $id_venta]);

        return 'Exito';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
