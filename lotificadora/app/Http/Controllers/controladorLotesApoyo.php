<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;

class controladorLotesApoyo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $lotes = DB::table("lotes_apartados")
        //             ->where("temp","Si")
        //             ->get();

        return "Hey";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lote = new Lote();
        $lote->nombre = $request->lote;
        $lote->area = number_format($request->area, 2, '.', ',');
        $lote->norte = number_format($request->norte, 2, '.', ',');
        $lote->sur = number_format($request->sur, 2, '.', ',');
        $lote->este = number_format($request->este, 2, '.', ',');
        $lote->oeste = number_format($request->oeste, 2, '.', ',');
        $lote->precio = number_format($request->precio, 2, '.', ',');
        $lote->id_bloque = $request->idBloque;
        $lote->tiempo = $request->tiempo;
        $lote->estado = "Disponible";
        $lote->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lote = Lote::find($id);

        $precio=$lote->precio;
        $precio=str_replace(',','',$precio);

        $area=$lote->area;
        $area=str_replace(',','',$area);

        $norte=$lote->norte;
        $norte=str_replace(',','',$norte);
        
        $sur=$lote->sur;
        $sur=str_replace(',','',$sur);

        $este=$lote->este;
        $este=str_replace(',','',$este);

        $oeste=$lote->oeste;
        $oeste=str_replace(',','',$oeste);

        $data[]=[
            "nombre" => $lote->nombre,
            "precio" => $precio,
            "area" => $area,
            "norte" => $norte,
            "sur" => $sur,
            "este" => $este,
            "oeste" => $oeste,
            "id" => $lote->id,
            "id_bloque" => $lote->id_bloque,
            "reservado" => $lote->reservado_a,
            "fecha" => $lote->reservado_hasta,
            "tiempo" => $lote->tiempo
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

        $infoLote = DB::table("lotes")
                    ->join("bloques", "lotes.id_bloque", "=", "bloques.id")
                    ->join("residenciales", "bloques.id_residencial", "=", "residenciales.id")
                    ->select("lotes.*","bloques.*","residenciales.*","lotes.nombre as nombreLote",
                    "bloques.nombre as nombreBloque","residenciales.nombre as nombreResidencial",
                    "lotes.id as idLote","bloques.id as idBloque","residenciales.id as idResidencial")
                    ->where("lotes.temp","Si")
                    ->get();
                    
        $precio = $infoLote[0]->precio;
        $precio = str_replace(',', '', $precio);
        $interes = $precio * 0.04;
        $interesAnual = $interes * $infoLote[0]->tiempo;
        $precioCredito = $precio + $interesAnual;
        $cuotas = $infoLote[0]->tiempo * 12;
        $valorCuota = $precioCredito / $cuotas;

        $interesAnualFormato = number_format($interesAnual, 2, '.', ',');
        $precioCreditoFormato = number_format($precioCredito, 2, '.', ',');
        $valorCuotaFormato = number_format($valorCuota, 2, '.', ',');
        

        $data[]=[
            "lote" => $infoLote[0]->nombreLote,
            "area" => $infoLote[0]->area,
            "precio" => $infoLote[0]->precio,
            "tiempo" => $infoLote[0]->tiempo,
            "residencial" => $infoLote[0]->nombreResidencial,
            "bloque" => $infoLote[0]->nombreBloque,
            "norte" => $infoLote[0]->norte,
            "sur" => $infoLote[0]->sur,
            "este" => $infoLote[0]->este,
            "oeste" => $infoLote[0]->oeste,
            "interes" => $interes,
            "interesAnual" => $interesAnualFormato,
            "precioCredito" => $precioCreditoFormato,
            "cuotas" => $cuotas,
            "valorCuotas" => $valorCuotaFormato,
            "idLote" => $infoLote[0]->idLote
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
        $lote->area = number_format($request->area, 2, '.', ',');
        $lote->norte = number_format($request->norte, 2, '.', ',');
        $lote->sur = number_format($request->sur, 2, '.', ',');
        $lote->este = number_format($request->este, 2, '.', ',');
        $lote->oeste = number_format($request->oeste, 2, '.', ',');
        $lote->precio = number_format($request->precio, 2, '.', ',');
        $lote->tiempo = $request->tiempo;
        $lote->save();

        return $request->all();
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
