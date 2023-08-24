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

class controladorLotesApoyoII extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lotes = DB::table("lotes_apartados")
                    ->join("lotes","lotes_apartados.id_lote", "=", "lotes.id")
                    ->select("lotes_apartados.*","lotes.*","lotes.id","lotes_apartados.id as idLotesApartados","lotes.id as idLote")
                    ->where("temp","Si")
                    ->get();

        $totalPrecio = DB::table("lotes_apartados")
                    ->where("temp","Si")
                    ->sum("precio");

        $tiempoMaximo = lotes_apartados::max('tiempo'); // Valor maximo de años de financiamiento
        $interesAnual = $tiempoMaximo * 0.04;
        $interes = $totalPrecio * $interesAnual; //Interes calculado segun el total a pagar
        $precioCredito = $totalPrecio + $interes; //Total a pagar sumado el interes
        
        $cuotas = $tiempoMaximo * 12; //Cantidad de cuotas segun el valor maximo de años
        $valorCuotaMensual = $precioCredito / $cuotas; //Valor a pagar al mes

        $totalPrecioFormato = number_format($totalPrecio, 2, '.', ',');
        $InteresesFormato = number_format($interes, 2, '.', ',');
        $totalPrecioCreditoFormato = number_format($precioCredito, 2, '.', ',');
        $valorCuotaMensualFormato = number_format($valorCuotaMensual, 2, '.', ',');
        $pagoTotal =  str_replace(',', '', $valorCuotaMensualFormato) * $cuotas;
        $a = $precioCredito / $cuotas;
        $totalIntereses = (number_format($a, 2, '.', '') * $cuotas) - $totalPrecio;

        $data[]=[
            "precioContado" => $totalPrecioFormato,
            "tiempo" => $tiempoMaximo,
            "interes" => number_format($totalIntereses, 2, '.', ','),
            "precioCredito" => number_format($pagoTotal, 2, '.', ','),
            "cuotas" => $cuotas,
            "valorCuotaMensual" => $valorCuotaMensual,
            "lotesApartados" => $lotes,
            "contado" => $totalPrecioFormato
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lotes = DB::table("lotes_apartados")
                    ->join("lotes","lotes_apartados.id_lote", "=", "lotes.id")
                    ->select("lotes_apartados.*","lotes.*","lotes.id","lotes_apartados.id as idLotesApartados","lotes.id as idLote")
                    ->where("temp","Si")
                    ->get();

        $totalPrecio = DB::table("lotes_apartados")
                    ->where("temp","Si")
                    ->sum("precio");
   
        $valorConPrima = $totalPrecio - $request->prima;
        $interesAnual = $request->tiempo * $request->interes;
        $interes = $valorConPrima * $interesAnual; //Interes calculado segun el total a pagar
        
        $precioCredito = $valorConPrima + $interes; //Total a pagar sumado el interes
        
        //$tiempoMaximo = lotes_apartados::max('tiempo'); // Valor maximo de años de financiamiento
        $cuotas = $request->tiempo * 12; //Cantidad de cuotas segun el valor maximo de años
        $valorCuotaMensual = $precioCredito / $cuotas; //Valor a pagar al mes

        $totalPrecioFormato = number_format($totalPrecio, 2, '.', ',');
        $InteresesFormato = number_format($interes, 2, '.', ',');
        $totalValorConPrimaFormato = number_format($valorConPrima, 2, '.', ',');
        $valorCuotaMensualFormato = number_format($valorCuotaMensual, 2, '.', ',');

        $pagoTotal =  str_replace(',', '', $valorCuotaMensualFormato) * $cuotas;
        $a = $precioCredito / $cuotas;
        $totalIntereses = (number_format($a, 2, '.', '') * $cuotas) - $valorConPrima;

        $data[]=[
            "precioContado" => $totalValorConPrimaFormato,
            "tiempo" => $request->tiempo,
            "interes" => number_format($totalIntereses, 2, '.', ','),
            "precioCredito" => number_format($pagoTotal, 2, '.', ','),
            "cuotas" => $cuotas,
            "valorCuotaMensual" => $valorCuotaMensual,
            "lotesApartados" => $lotes,
            "interesPorcentaje" => $request->interes,
            "contado" => $totalPrecioFormato
        ];
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
        Lote::where("id",$id)
        ->update(["reservado_a" => null,
                    "reservado_hasta" => null,
                    "estado" => "Disponible"]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)//informacion para el resumen de venta
    {
        //$venta = Venta::find($id);
        DB::select("SET lc_time_names = 'es_MX';");

        $venta = collect(\DB::select("
        select id_cliente, pago, estado, total_contado, anios_financiamiento, 
                tasa_interes, prima, cuotas, total_intereses, total_pagar,
                cuota_mensual, dias_cobro_mes, 
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
        
        $data[]=[
            "total_contado"=>$venta->total_contado,
            "anios_financiamiento"=>$venta->anios_financiamiento,
            "tasa_interes"=>$venta->tasa_interes,
            "prima"=>$venta->prima,
            "cuotas"=>$venta->cuotas,
            "total_intereses"=>$venta->total_intereses,
            "total_pagar"=>$venta->total_pagar,
            "cuota_mensual"=>$venta->cuota_mensual,
            //"fecha"=> date("F j, Y - g:i A", strtotime($venta->created_at)),
            "fecha"=> $venta->fecha_venta,
            "fecha_registro"=> $venta->created_at,
            "cliente"=>$cliente->primer_nombre." ".$cliente->segundo_nombre." ".$cliente->primer_apellido." ".$cliente->segundo_apellido,
            "identidad"=>$cliente->identidad,
            "cel"=>$cliente->cel,
            "lotes"=>$lotes,
            "id_venta"=>$id
        ];

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
        $lote = Lote::find($id);
        $lote->reservado_a = $request->nombre;
        $lote->reservado_hasta = $request->fecha;
        $lote->save();
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
