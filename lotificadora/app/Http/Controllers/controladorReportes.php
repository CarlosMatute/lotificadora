<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;

class controladorReportes extends Controller
{
    protected $RPT_PRUEBA;

    protected $INPUT_RPT_PATH;
    protected $OUTPUT_RPT_PATH;
    protected $dbConnection=array();

    public function __construct(){
        $this->RPT_PRUEBA='prueba';

        $this->INPUT_RPT_PATH=app_path().'/Documents/Reports/';
        $this->OUTPUT_RPT_PATH='/documents/reports/';

        $this->dbConnection=[
            'driver'=> env('DB_CONNECTION'),
            'username'=> env('DB_USERNAME'),
            'password'=> env('DB_PASSWORD'),
            'host'=> env('DB_HOST'),
            'database'=> env('DB_DATABASE'),
            'port'=> env('DB_PORT')
        ];

    }

    public function imprimir(){

        $input =  $this->INPUT_RPT_PATH.$this->RPT_PRUEBA.'.jrxml';  
        $inputCompiled = $this->INPUT_RPT_PATH.$this->RPT_PRUEBA.'.jasper';
        $output = $this->OUTPUT_RPT_PATH.$this->RPT_PRUEBA;  
        
        /*$input = base_path() .
        '/vendor/geekcom/phpjasper/examples/hello_world.jrxml';

        $inputCompiled = base_path() .
        '/vendor/geekcom/phpjasper/examples/hello_world.jasper';

        $output = base_path() .
        '/vendor/geekcom/phpjasper/examples';*/
        
         if (!file_exists( $inputCompiled)) {
             $jasper = new PHPJasper;
             $jasper->compile($input)->output();
        }
        
    
        
        $options = [ 
            'format' => ['pdf'],
            //'params' =>['numero_registro_asignado'=>$numero_registro_asignado],            
            'db_connection' => $this->dbConnection
        ];
    
        $jasper = new PHPJasper;

 

        $jasper->process(
            $inputCompiled,
            $output,
            $options
            )->output();
        
        $pathToFile = $this->OUTPUT_RPT_PATH.$this->RPT_PRUEBA.'.pdf';
        return response()->file($pathToFile);
            //return view('reportes.generico')->with('reportName',$output.'.pdf');

    }


}
