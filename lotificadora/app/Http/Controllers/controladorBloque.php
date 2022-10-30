<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;

class controladorBloque extends Controller
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
        $bloque = new Bloque();
        $bloque->nombre = $request->bloque;
        $bloque->id_residencial = $request->idResidencial;
        $bloque->save();

        $bloques = Bloque::all()->where("id_residencial", $request->idResidencial)->last();

        for($i=1; $i<=$request->cantidad; $i++){
            $lote = new Lote();
            $lote->nombre = $i;
            $lote->area = number_format($request->area, 2, '.', ',');
            $lote->norte = number_format($request->norte, 2, '.', ',');
            $lote->sur = number_format($request->sur, 2, '.', ',');
            $lote->este = number_format($request->este, 2, '.', ',');
            $lote->oeste = number_format($request->oeste, 2, '.', ',');
            $lote->precio = number_format($request->precio, 2, '.', ',');
            $lote->id_bloque = $bloques->id;
            $lote->tiempo = $request->tiempo;
            $lote->estado = "Disponible";
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

        $lotes = DB::table("lotes")
                    ->join("bloques", "lotes.id_bloque", "=", "bloques.id")
                    ->where("bloques.id",$id)
                    ->get();

        $totalLotes = count($lotes);

        $data[]=[
            "bloque" => $bloque->nombre,
            "idBloque" => $bloque->id,
            "totalLotes" => $totalLotes
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
        $bloques = Bloque::all()->where("id_residencial", $id)->last();

        //$cuentaBloques = count($bloques);
        
        if(empty($bloques)){
            $data[]=[
                "idResidencial" => $id,
                "siguienteLetra" => "A"
            ];

            return $data;
        }else{
        
            $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

            $posicion = strpos($abc, $bloques->nombre);

            $siguienteLetra = $abc[$posicion+1];

            $data[]=[
                "idResidencial" => $id,
                "siguienteLetra" => $siguienteLetra
            ];

            return $data;
        }
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
        $bloque = Bloque::find($id);

        $idResidencial = $bloque->id_residencial;

        $lotes = Lote::where("id_bloque", $id)->delete();

        $bloque->delete();

        return $idResidencial;
    }
}
