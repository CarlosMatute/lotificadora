<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Models\Beneficiario;

class controladorClientesApoyo extends Controller
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
        $cliente = new Cliente();
        $cliente->primer_nombre = $request->pNombre;
        $cliente->segundo_nombre = $request->sNombre;
        $cliente->primer_apellido = $request->pApellido;
        $cliente->segundo_apellido = $request->sApellido;
        $cliente->identidad = $request->identidad;
        $cliente->cel = $request->cel;
        $cliente->cel2 = $request->cel2;
        $cliente->correo = $request->correo;
        $cliente->direccion = $request->direccion;
        $cliente->r_nombre_completo = $request->rNombre;
        $cliente->r_cel = $request->rCel;
        $cliente->r_direccion = $request->rDireccion;
        $cliente->id_user = auth()->id();
        $cliente->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beneficiario = Beneficiario::find($id);
        return $beneficiario;
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
        $beneficiario = Beneficiario::find($id);
        $beneficiario->nombre_completo = $request->nombre_completo;
        $beneficiario->identidad = $request->identidad;
        $beneficiario->parentezco = $request->parentezco;
        $beneficiario->cel = $request->cel;
        $beneficiario->cel2 = $request->cel2;
        $beneficiario->correo = $request->correo;
        $beneficiario->direccion = $request->direccion;
        $beneficiario->save();
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
