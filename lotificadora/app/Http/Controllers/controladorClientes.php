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
        // $clientes = DB::table("clientes")
        //                 ->where("id_user", auth()->id())
        //                 ->orderBy('primer_nombre','ASC')
        //                 ->get();

        $clientes = DB::select("
            select * from clientes where id_user = :id_usuario
            order by primer_nombre, segundo_nombre, primer_apellido, segundo_apellido
        ", ["id_usuario" => auth()->id()]);

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
        // $cliente = Cliente::find($id);
        $cliente = collect(\DB::select("
            select id, TRIM(
                concat(
                COALESCE(concat(TRIM(primer_nombre),' '),''),
                COALESCE(concat(TRIM(segundo_nombre),' '),''),
                COALESCE(concat(TRIM(primer_apellido),' '),''),
                COALESCE(concat(TRIM(segundo_apellido),' '),'')
                )
            ) nombre_completo, 
            concat(SUBSTRING(identidad, 1, 4),'-',SUBSTRING(identidad, 5, 4),'-',SUBSTRING(identidad, 9, 5)) identidad,
            coalesce(cel,'Sin datos') cel, coalesce(cel2,'Sin datos') cel2, coalesce(correo,'Sin datos') correo,
            direccion, r_nombre_completo, r_cel, r_direccion
            from clientes where id = :id_cliente
        ", ["id_cliente" => $id]))->first();

        $beneficiaros = DB::table("beneficiarios")
                        ->where("id_cliente", $id)
                        ->get();
        $data[]=[
            "id" => $cliente->id,
            "nombreCompleto" => $cliente->nombre_completo,
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
