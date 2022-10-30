<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;

class controladorLotes extends Controller
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
        for($i=1; $i<=$request->cantidad; $i++){
            $lote = new Lote();
            $lote->nombre = $i;
            $lote->area = number_format($request->area, 2, '.', ',');
            $lote->norte = number_format($request->norte, 2, '.', ',');
            $lote->sur = number_format($request->sur, 2, '.', ',');
            $lote->este = number_format($request->este, 2, '.', ',');
            $lote->oeste = number_format($request->oeste, 2, '.', ',');
            $lote->precio = number_format($request->precio, 2, '.', ',');
            $lote->tiempo = $request->tiempo;
            $lote->estado = "Disponible";
            $lote->id_bloque = $request->idBloque;
            $lote->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bloque = Bloque::find($id);

        return $bloque;


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bloque = Bloque::find($id);

        $lotes = Lote::all()->where("id_bloque", $id)->last();

            $data[]=[
                "nombre" => $bloque->nombre,
                "id" => $bloque->id,
                "ultimoLote" => $lotes->nombre + 1
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
        Lote::where("id",$id)
        ->update(["reservado_a" => $request->nombre,
                    "reservado_hasta" => $request->fecha,
                    "estado" => "Reservado"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrarLote = Lote::find($id);
        $borrarLote->delete();

        $idBloque = $borrarLote->id_bloque;

        $bloque = Bloque::find($idBloque);

        $lotes = DB::table("lotes")
                    ->where("id_bloque",$idBloque)
                    ->get();

        $total = count($lotes);

        $data[]=[
            "bloqueNombre" => $bloque->nombre,
            "idResidencial" => $bloque->id_residencial,
            "idBloque" => $bloque->id,
            "lotes" => $lotes,
            "total" => $total
        ];

        return $data;
    }
}
