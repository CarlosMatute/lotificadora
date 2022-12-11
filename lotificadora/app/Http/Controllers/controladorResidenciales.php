<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Residenciale;
use App\Models\Bloque;
use App\Models\Lote;
use Illuminate\Support\Facades\Storage;

class controladorResidenciales extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $residenciales = DB::table('residenciales')
                            ->join('users','residenciales.id_user','=','users.id')
                            ->select('residenciales.*','users.*','residenciales.id as idR')
                            ->where('residenciales.id_user', auth()->id())
                            ->get();

        foreach($residenciales as $res){

            $idResidencial = $res->idR;

            $bloques = DB::table("bloques")
                        ->where("id_residencial", $idResidencial)
                        ->get();

 
                $lotes = DB::table("lotes")
                            ->join("bloques","lotes.id_bloque","=","bloques.id")
                            ->where("bloques.id_residencial", $idResidencial)
                            ->get();
           

            $data[]=[
                "nombre" => $res->nombre,
                "descripcion" => $res->descripcion,
                "imagen" => $res->imagen,
                "bloques" => $bloques,
                "lotes" => $lotes,
                "idR" => $idResidencial
            ];
        }
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
        if($request->hasFile('imagen')){
            $file = $request->file('imagen');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path('storage').'', $name);
            //$file->move(storage_path('app/public').'', $name);
            //Storage::disk('public')->put($name, 'Contents');
            //return $name;
        }
        $residencial = new Residenciale();
        $residencial->nombre = $request->nombre;
        //$residencial->n_bloques = $request->nBloques;
        $residencial->descripcion = $request->descripcion;
        $residencial->imagen = $name;
        $residencial->id_user = auth()->id();
        $residencial->save();

        $idResiencial = Residenciale::all()->last();

        $abc = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for($i=0; $i<$request->nBloques; $i++){
            $bloque = new Bloque();
            $bloque->nombre = $abc[$i];
            //$bloque->n_lotes = 5;
            $bloque->id_residencial = $idResiencial->id;
            $bloque->save();
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
        $residencial = Residenciale::find($id);
        $bloques = DB::table("bloques")
                        ->where("id_residencial", $id)
                        ->get();

        $totalB = count($bloques);



        // $dosis = DB::table("dosis")
        // ->where("id_tratamiento", $id)
        // ->selectRaw("count(*) as total")
        // ->get();

        // foreach($bloques as $bloque){
        //     $idB = $bloque->id;

        //     $bloquesLotes = DB::table("bloques")
        //     ->join("lotes","bloques.id","=","lotes.id_bloque")
        //     ->whereIn("lotes.id_bloque", [28,33])
        //     ->select("bloques.nombre as bloque")
        //     ->get();
        // }


            $lotes = DB::table("lotes")
                        ->join("bloques","lotes.id_bloque","=","bloques.id")
                        ->select("bloques.nombre")
                        ->where("bloques.id_residencial", $id)
                        ->get();
            
            $lotesDist = DB::table("lotes")
                        ->join("bloques","lotes.id_bloque","=","bloques.id")
                        ->select("bloques.nombre")
                        ->where("bloques.id_residencial", $id)
                        ->distinct()
                        ->get();

            //$lotesUnicos = array_unique($lotes);
            

            $totalL = count($lotes);
        

        $data[]=[
            "nombre" => $residencial->nombre,
            "descripcion" => $residencial->descripcion,
            "imagen" => $residencial->imagen,
            "bloques" => $bloques,
            "idResidencial" => $id,
            "totalB" => $totalB,
            "totalL" => $totalL,
            "lotesEnBloques" => $lotesDist
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

        $fecha = date("Y-m-d"); 

        Lote::where("reservado_hasta", "<=", $fecha)
        ->update(["reservado_a" => null,
                    "reservado_hasta" => null,
                    "estado" => "Disponible"]);
        

        $bloque = Bloque::find($id);

        $lotes = DB::table("lotes")
                    ->where("id_bloque",$id)
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $residencial = Residenciale::find($id);
        $residencial->nombre = $request->nombre;
        $residencial->descripcion = $request->descripcion;
        $residencial->save();
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
