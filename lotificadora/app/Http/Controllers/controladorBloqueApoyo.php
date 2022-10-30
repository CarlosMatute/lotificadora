<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;

class controladorBloqueApoyo extends Controller
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
        $infoLote = DB::table("lotes")
                    ->join("bloques", "lotes.id_bloque", "=", "bloques.id")
                    ->join("residenciales", "bloques.id_residencial", "=", "residenciales.id")
                    ->select("lotes.*","bloques.*","residenciales.*","lotes.nombre as nombreLote",
                    "bloques.nombre as nombreBloque","residenciales.nombre as nombreResidencial",
                    "lotes.id as idLote","bloques.id as idBloque","residenciales.id as idResidencial")
                    ->where("lotes.id",$request->idLote)
                    ->get();
                    
        $precio = $infoLote[0]->precio;
        $precio = str_replace(',', '', $precio);
        $interes = $precio * 0.04;
        $interesAnual = $interes * $request->tiempo;
        $precioCredito = $precio + $interesAnual;
        $cuotas = $request->tiempo* 12;
        $valorCuota = $precioCredito / $cuotas;

        $interesAnualFormato = number_format($interesAnual, 2, '.', ',');
        $precioCreditoFormato = number_format($precioCredito, 2, '.', ',');
        $valorCuotaFormato = number_format($valorCuota, 2, '.', ',');
        

        $data[]=[
            "lote" => $infoLote[0]->nombreLote,
            "area" => $infoLote[0]->area,
            "precio" => $infoLote[0]->precio,
            "tiempo" => $request->tiempo,
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bloques = DB::table("bloques")
                    ->where("id_residencial", $id)
                    ->get();
        return $bloques;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lotes_apartados = DB::table("lotes_apartados")
                            ->where("lotes_apartados.temp","Si")
                            ->get();

        $datos_array = array();
 
        /* añadimos los datos al array */
        foreach ($lotes_apartados as $key => $apartados) 
        {
            $datos_array[$key] = $apartados->id_lote;
        }

        $lotes = DB::table("lotes")
                    //->join("lotes_apartados","lotes.id","=","lotes_apartados.id_lote")
                    ->where("lotes.id_bloque", $id)
                    ->where("lotes.estado","Disponible")
                    ->whereNotIn("id", $datos_array)
                    ->get();
        return $lotes;
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
