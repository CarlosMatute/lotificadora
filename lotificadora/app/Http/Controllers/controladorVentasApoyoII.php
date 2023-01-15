<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class controladorVentasApoyoII extends Controller
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
        $datosPagoCuota = collect(\DB::select("
            SELECT cantidad_pago, FORMAT(cantidad_pago, 2) as cantidad_pago_formato FROM fechas_cobros where id = :id_fecha_pago
        ", ["id_fecha_pago" => $id]))->first();

        $numeroLetra = collect(\DB::select("
            SELECT COUNT(*) as letra FROM fechas_cobros 
            where id_venta = (select id_venta from fechas_cobros where id = :id_fecha_pago)
            and estado = 'Pagado';
        ", ["id_fecha_pago" => $id]))->first();

        DB::select("SET lc_time_names = 'es_ES';");

        $mesCobro = collect(\DB::select("
        SELECT DATE_FORMAT(fecha_cobro,'%M') AS mes from fechas_cobros WHERE id = :id_fecha_pago;
        ", ["id_fecha_pago" => $id]))->first();

        $lotes = DB::select("
        select concat('L-',l.nombre) lote, b.nombre bloque, r.nombre residencial,
        l.norte, l.sur, l.este, l.oeste, l.area
        from fechas_cobros fc 
        join ventas v on fc.id_venta = v.id and fc.id = :id_fecha_pago
        join lotes_vendidos lv on v.id = lv.id_venta
        join lotes l on lv.id_lote = l.id
        join bloques b on l.id_bloque = b.id
        join residenciales r on b.id_residencial = r.id
        ", ["id_fecha_pago" => $id]);

        $fechaActual = collect(\DB::select("
            select date_format(now(), '%d') AS dia, date_format(now(), '%M') AS mes, date_format(now(), '%Y') AS anio
        "))->first();

        $numnero_letras = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $numero_letra_letras = new NumberFormatter("es", NumberFormatter::ORDINAL);

        $data[] = [
            'datosPagoCuota' => $datosPagoCuota,
            'mesCobro' => $mesCobro->mes,
            'numeroLetra' => $numero_letra_letras->format($numeroLetra->letra),
            'cantidadLetras' => $numnero_letras->format($datosPagoCuota->cantidad_pago),
            'lotes' => $lotes,
            'dia' => $fechaActual->dia,
            'mes' => $fechaActual->mes,
            'anio' => $fechaActual->anio,
            'diaLetras' => $numnero_letras->format($fechaActual->dia),
            'anioLetras' => $numnero_letras->format($fechaActual->anio)
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
