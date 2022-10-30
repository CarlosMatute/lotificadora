<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;
use App\Models\lotes_apartados;

class controladorLotesFinanciados extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lotesVender = DB::table("lotes_apartados")
                            ->join("lotes","lotes_apartados.id_lote","=","lotes.id")
                            ->join("bloques", "lotes.id_bloque","=","bloques.id")
                            ->join("residenciales", "bloques.id_residencial","=","residenciales.id")
                            ->select("lotes_apartados.*","lotes.*","bloques.*","residenciales.*",
                            "lotes_apartados.id as idLA","lotes.id as idL","bloques.id as idB","residenciales.id as idR",
                            "lotes.nombre as nombreL","bloques.nombre as nombreB","residenciales.nombre as nombreR")
                            ->where("lotes_apartados.temp","Si")
                            ->get();

        return $lotesVender;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $borrarLote = DB::table("lotes_apartados")
                        ->where("temp","Si")
                        ->delete();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $infoLote = DB::table("lotes")
                    ->join("bloques", "lotes.id_bloque", "=", "bloques.id")
                    ->join("residenciales", "bloques.id_residencial", "=", "residenciales.id")
                    ->select("lotes.*","bloques.*","residenciales.*","lotes.nombre as nombreLote",
                    "bloques.nombre as nombreBloque","residenciales.nombre as nombreResidencial",
                    "lotes.id as idLote","bloques.id as idBloque","residenciales.id as idResidencial")
                    ->where("lotes.id", $request->idLote)
                    ->get();

        //return $infoLote;
        $precio = $infoLote[0]->precio;
        
        $lote = new lotes_apartados();
        $lote->id_lote = $request->idLote;
        $lote->temp = "Si";
        $lote->residencial = $infoLote[0]->nombreResidencial;
        $lote->bloque = $infoLote[0]->nombreBloque;
        $lote->precio = str_replace(',', '', $precio);
        $lote->tiempo = $infoLote[0]->tiempo;
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
        $eliminar = DB::table("lotes_apartados")
                        ->where("id_lote",$id);
        $eliminar->delete();
    }
}
