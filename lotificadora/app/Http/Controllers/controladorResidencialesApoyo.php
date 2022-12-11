<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;
use File;

class controladorResidencialesApoyo extends Controller
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
        //unlink($request->imagenVieja);


        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path('dist/img').'', $name);
         }
         Residenciale::where("imagen",$request->imagenVieja)
         ->update(["imagen"=> $name]);

        // $residencial = new Residenciale();
        // $residencial->nombre = $request->nombre;
        // //$residencial->n_bloques = $request->nBloques;
        // $residencial->descripcion = $request->descripcion;
        // $residencial->imagen = $name;
        // $residencial->id_user = auth()->id();
        // $residencial->save();

        // $idResiencial = Residenciale::all()->last();

        // $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        // for($i=0; $i<$request->nBloques; $i++){
        //     $bloque = new Bloque();
        //     $bloque->nombre = $abc[$i];
        //     //$bloque->n_lotes = 5;
        //     $bloque->id_residencial = $idResiencial->id;
        //     $bloque->save();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $residencial = Residenciale::find($id);


            $bloques = DB::table("bloques")
                        ->where("id_residencial", $id)
                        ->get();

 
            $lotes = DB::table("lotes")
                        ->join("bloques","lotes.id_bloque","=","bloques.id")
                        ->where("bloques.id_residencial", $id)
                        ->get();
           
            $tBloques = count($bloques);

            $tLotes = count($lotes);

            $data[]=[
                "nombre" => $residencial->nombre,
                "bloques" => $tBloques,
                "lotes" => $tLotes,
                "idR" => $residencial->id
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
        $bloques = DB::table("bloques")
                        ->where("id_residencial",$id)
                        ->get();

        foreach($bloques as $bloque){
            $idB = $bloque->id;
            $lotes = Lote::where("id_bloque",$idB)->delete();
        }

        $bloquesBorrar = Bloque::where("id_residencial",$id)->delete();

        $residencial = Residenciale::find($id);

        $imagen = $residencial->imagen;
        //File::delete('public/dist/img/'.$imagen); //desarrollo
        //File::delete(public_path('dist/img').'archivos/'.$imagen); //produccion
        //unlink('dist/img/'.$imagen); // desarrollo
        unlink(public_path('dist/img/').$imagen); // produccion
        
        $residencial->delete();
    }
}
