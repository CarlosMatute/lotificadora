<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $clave = Hash::make("admin");
        DB::table("users")->insert([
            "name"=>"Administrador",
            "email"=>"admin@loti",
            "password"=> $clave
         
        ]);
        
        DB::table("residenciales")->insert([
            "nombre"=>"Villas Colonial",
            "descripcion"=>"Ejemplo de descripcion",
            "id_user"=>"1",
            "imagen"=>"1642965739images.jpg"
            
        ]);

        DB::table("bloques")->insert([
            "nombre"=>"A",
            "id_residencial"=>"1"
            
        ]);
        DB::table("bloques")->insert([
            "nombre"=>"B",
            "id_residencial"=>"1"
            
        ]);
        DB::table("bloques")->insert([
            "nombre"=>"C",
            "id_residencial"=>"1"
            
        ]);
        DB::table("bloques")->insert([
            "nombre"=>"D",
            "id_residencial"=>"1"
            
        ]);

        for($i=1;$i<15;$i++){
            DB::table("lotes")->insert([
                "nombre"=>$i,
                "area"=>300,
                "norte"=>15,
                "sur"=>15,
                "este"=>20,
                "oeste"=>20,
                "precio"=>"120,000.00",
                "tiempo"=>5,
                "estado"=>"Disponible",
                "id_bloque"=>1
            ]);
        }
        for($i=1;$i<25;$i++){
            DB::table("lotes")->insert([
                "nombre"=>$i,
                "area"=>300,
                "norte"=>15,
                "sur"=>15,
                "este"=>20,
                "oeste"=>20,
                "precio"=>"200,000.00",
                "tiempo"=>4,
                "estado"=>"Disponible",
                "id_bloque"=>2
            ]);
        }
        for($i=1;$i<25;$i++){
            DB::table("lotes")->insert([
                "nombre"=>$i,
                "area"=>300,
                "norte"=>15,
                "sur"=>15,
                "este"=>20,
                "oeste"=>20,
                "precio"=>"250,000.00",
                "tiempo"=>5,
                "estado"=>"Disponible",
                "id_bloque"=>3
            ]);
        }
        DB::table("clientes")->insert([
            "primer_nombre"=>"Carlos",
            "segundo_nombre"=>"Heraldo",
            "primer_apellido"=>"Matute",
            "segundo_apellido"=>"Lobo",
            "identidad"=>"1503199500919",
            "cel"=>"98925372",
            "direccion"=>"Residencial El Llano 2 etapa",
            "r_nombre_completo"=>"Ligia Lobo",
            "r_cel"=>"96455070",
            "r_direccion"=>"Residencial El Llano 2 etapa",
            "id_user"=>1
            //"created_at"=>DATE("Y-m-d")
        ]);
        DB::table("clientes")->insert([
            "primer_nombre"=>"Daniela",
            "segundo_nombre"=>"Fernanda",
            "primer_apellido"=>"Medina",
            "segundo_apellido"=>"Lopez",
            "identidad"=>"1520199805682",
            "cel"=>"98653221",
            "direccion"=>"San Francico de La Paz",
            "r_nombre_completo"=>"Angelica Murillo",
            "r_cel"=>"98653221",
            "r_direccion"=>"Olancho",
            "id_user"=>1
        ]);
        
    }
}
