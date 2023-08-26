<?php

use Illuminate\Support\Facades\Route;

use App\Mail\CobrosMaillable;
use Illuminate\Support\Facades\Mail;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Dashboard
Route::resource('/dashboard', App\Http\Controllers\controladorDashboard::class);
//Residenciales
Route::get('/registrarResidenciales', [App\Http\Controllers\HomeController::class, 'registrar_residenciales']);
Route::resource('/residenciales', App\Http\Controllers\controladorResidenciales::class);
Route::resource('/residenciales/apoyo', App\Http\Controllers\controladorResidencialesApoyo::class);
Route::resource('/lotes', App\Http\Controllers\controladorLotes::class);
Route::resource('/lotes/apoyo', App\Http\Controllers\controladorLotesApoyo::class);
Route::resource('/lotes/apoyo/II', App\Http\Controllers\controladorLotesApoyoII::class);
Route::resource('/lotes/apoyo/III', App\Http\Controllers\ControladorLotesApoyoIII::class);
Route::resource('/bloque', App\Http\Controllers\controladorBloque::class);
//Clientes
Route::get('/registrarClientes', [App\Http\Controllers\HomeController::class, 'registrar_clientes']);
Route::resource('/clientes', App\Http\Controllers\controladorClientes::class);
Route::resource('/clientes/apoyo', App\Http\Controllers\controladorClientesApoyo::class);
//Beneficiarios
Route::resource('/beneficiarios', App\Http\Controllers\controladorBeneficiario::class);
Route::resource('/beneficiarios/apoyo', App\Http\Controllers\controladorBeneficiarioApoyo::class);
//VenderLotes
Route::get('/venderLotes', [App\Http\Controllers\HomeController::class, 'vender_lotes']);
Route::resource('/bloque/apoyo', App\Http\Controllers\controladorBloqueApoyo::class);
Route::resource('/lote_financiado', App\Http\Controllers\controladorLotesFinanciados::class);
Route::resource('/venta', App\Http\Controllers\ControladorVentas::class);
Route::resource('/venta/apoyo', App\Http\Controllers\controladorVentasApoyo::class);
Route::resource('/venta/apoyo/II', App\Http\Controllers\controladorVentasApoyoII::class);
Route::get('correo', function () {
    $correo = new CobrosMaillable;

    Mail::to('carlosmatute1995@gmail.com')->send($correo);
    return "Correo enviado";
});
//Resportes
Route::get('/reportes/imprimir', [App\Http\Controllers\controladorReportes::class, 'imprimir']);