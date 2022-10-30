<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residenciales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('descripcion');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->string('imagen')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('bloques', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('id_residencial');
            $table->foreign('id_residencial')->references('id')->on('residenciales');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('area');
            $table->string('norte');
            $table->string('sur');
            $table->string('este');
            $table->string('oeste');
            $table->string('precio');
            $table->string('tiempo');
            $table->string('estado');
            $table->string('reservado_a')->nullable();
            $table->date('reservado_hasta')->nullable();
            $table->unsignedBigInteger('id_bloque');
            $table->foreign('id_bloque')->references('id')->on('bloques');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('identidad');
            $table->string('cel');
            $table->string('cel2')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccion');
            $table->string('imagen')->nullable();
            $table->string('r_nombre_completo');
            $table->string('r_cel');
            $table->string('r_direccion');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('beneficiarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('identidad');
            $table->string('parentezco');
            $table->string('cel');
            $table->string('cel2')->nullable();
            $table->string('correo')->nullable();
            $table->string('direccion');
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('lotes_apartados', function (Blueprint $table) {
            $table->id();
            $table->string('temp');
            $table->unsignedBigInteger('id_lote')->unique();
            $table->foreign('id_lote')->references('id')->on('lotes');
            $table->string('residencial');
            $table->string('bloque');
            $table->string('precio');
            $table->string('tiempo'); //años de financiamiemto
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_cliente');
            $table->foreign('id_cliente')->references('id')->on('clientes');
            $table->string('pago');
            $table->string('estado');
            $table->string('total_contado');
            $table->string('anios_financiamiento');
            $table->string('tasa_interes');
            $table->string('prima');
            $table->string('cuotas');
            $table->string('total_intereses');
            $table->string('total_pagar');
            $table->string('cuota_mensual');
            $table->string('dias_cobro_mes');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('lotes_vendidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lote');
            $table->foreign('id_lote')->references('id')->on('lotes');
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_venta')->references('id')->on('ventas');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('fechas_cobros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_venta');
            $table->foreign('id_venta')->references('id')->on('ventas');
            $table->string('fecha_cobro');
            $table->string('fecha_pago')->nullable();
            $table->string('cantidad_pago')->nullable();
            $table->string('estado');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residenciales');
        Schema::dropIfExists('bloques');
        Schema::dropIfExists('lotes');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('beneficiarios');
        Schema::dropIfExists('lotes_financiados');
        Schema::dropIfExists('lotes_apartados');
        Schema::dropIfExists('ventas');
        Schema::dropIfExists('lotes_vendidos');
        Schema::dropIfExists('fechas_cobros');
    }
}
