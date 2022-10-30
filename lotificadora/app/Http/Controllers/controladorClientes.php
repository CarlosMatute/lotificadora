<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;

class controladorClientes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = DB::table("clientes")
                        ->where("id_user", auth()->id())
                        ->orderBy('primer_nombre','ASC')
                        ->get();
        return $clientes;
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
        $cliente = DB::table("clientes")
                        ->where("identidad", $request->identidad)
                        ->where("id_user", auth()->id())
                        ->get();

        $verificar = count($cliente);

        return $verificar;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);
        $beneficiaros = DB::table("beneficiarios")
                        ->where("id_cliente", $id)
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);
        return $cliente;
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
        $cliente = Cliente::find($id);
        $cliente->primer_nombre = $request->primerNombre;
        $cliente->segundo_nombre = $request->segundoNombre;
        $cliente->primer_apellido = $request->primerApellido;
        $cliente->segundo_apellido = $request->segundoApellido;
        $cliente->identidad = $request->identidad;
        $cliente->cel = $request->cel;
        $cliente->cel2 = $request->cel2;
        $cliente->correo = $request->correo;
        $cliente->direccion = $request->direccion;
        $cliente->r_nombre_completo = $request->rNombre;
        $cliente->r_cel = $request->rCel;
        $cliente->r_direccion = $request->rDireccion;
        $cliente->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        $idCliente = $cliente->id;

        $beneficiaros = DB::table("beneficiarios")->where("id_cliente", $idCliente)->delete();

        $cliente->delete();
    }
}
