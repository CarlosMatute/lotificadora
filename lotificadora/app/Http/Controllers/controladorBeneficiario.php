<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Beneficiario;
use App\Models\Cliente;

class controladorBeneficiario extends Controller
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
        $beneficiario = new Beneficiario;

        $beneficiario->nombre_completo = $request->nombreCompleto;
        $beneficiario->identidad = $request->identidad;
        $beneficiario->parentezco = $request->parentezco;
        $beneficiario->cel = $request->cel;
        $beneficiario->cel2 = $request->cel2;
        $beneficiario->correo = $request->correo;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->id_cliente = $request->idCliente;
        $beneficiario->save();
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
        $borrarBeneficiarios = Beneficiario::find($id);

        $idCliente = $borrarBeneficiarios->id_cliente;

        $borrarBeneficiarios->delete();

        $cliente = Cliente::find($idCliente);
        $beneficiaros = DB::table("beneficiarios")
                        ->where("id_cliente", $idCliente)
                        ->get();
        $data[]=[
            "id" => $cliente->id,
            "nombreCompleto" => $cliente->primer_nombre." ".$cliente->segundo_nombre." ".$cliente->primer_apellido." ".$cliente->segundo_apellido,
            "identidad" => $cliente->identidad,
            "correo" => $cliente->correo,
            "cel" => $cliente->cel,
            "cel2" => $cliente->cel2,
            "direccion" => $cliente->direccion,
            "r_nombre_completo" => $cliente->r_nombre_completo,
            "r_cel" => $cliente->r_cel,
            "r_direccion" => $cliente->r_direccion,
            "beneficiarios" => $beneficiaros
        ];
        return $data;
        
    }
}
