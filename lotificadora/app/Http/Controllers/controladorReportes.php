<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPJasper\PHPJasper;
use NumberFormatter;

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

    public function ver_reporte_word() {
        
        $file = public_path('/documentos/recibo_letra.docx');
		
        try {
            
            $template = new \PhpOffice\PhpWord\TemplateProcessor( $file ); 
            $template->setValue( 'name', 'Cristan');
            $template->setValue( 'lastname', 'Laurek');
            $template->setValue( 'age', '38');
            
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $template->saveAs($tempFile);
            
            $headers = [
                "Content-Type: application/octet-stream",
            ];
            
            return response()->download($tempFile, 'documento.docx', $headers)->deleteFileAfterSend(true);
            
       } catch (Exception $ex) {
            
        }
        
    }

    public function recibo_letra(Request $request, $id) {
        DB::select("SET lc_time_names = 'es_ES';");

        $numnero_letras = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $numero_letra_letras = new NumberFormatter("es", NumberFormatter::ORDINAL);

        $datosPagoCuota = collect(\DB::select("
            SELECT cantidad_pago, FORMAT(cantidad_pago, 2) as cantidad_pago_formato FROM fechas_cobros where id = :id_fecha_pago
        ", ["id_fecha_pago" => $id]))->first();

        $cuota_letras = $numnero_letras->format($datosPagoCuota->cantidad_pago);

        $cuota_letras_mayusculas = strtoupper($cuota_letras);

        $datosPagoCuota = collect(\DB::select(" WITH global_var as (
                    select :id_fecha_pago id_fecha_cobro
            ), letra as (
                    SELECT count(id) as letra, gv.id_fecha_cobro
                            FROM fechas_cobros fc
                            join global_var gv on true
                            where fc.id_venta = (select id_venta from fechas_cobros where id = gv.id_fecha_cobro)
                            and fc.id <= gv.id_fecha_cobro
                            and fc.estado = 'Pagado'
                            group by gv.id_fecha_cobro
            ), cliente as (     
                    SELECT concat('Yo \"Allan Javier Rivera Carvajal\", mayor de edad, casado, ingeniero, hondureño, con domicilio en Catacamas y en tránsito por esta ciudad, ',
                            'con tarjeta de identidad número 1503-1983-01548, por medio del presente \"HAGO CONSTAR:\" Que he recibido del señor(a) \"',
                            TRIM(
                            concat(
                                    COALESCE(concat(TRIM(c.primer_nombre),' '),''),
                                    COALESCE(concat(TRIM(c.segundo_nombre),' '),''),
                                    COALESCE(concat(TRIM(c.primer_apellido),' '),''),
                                    COALESCE(concat(TRIM(c.segundo_apellido),' '),'')
                                )
            
                                ), '\" con número de identidad \"', c.identidad, '\", mayor de edad, Soltero, hondureño, con domicilio en \"',
                            c.direccion, '\", y en tránsito por esta ciudad, la cantidad de \"$cuota_letras_mayusculas LEMPIRAS EXACTOS (Lps.',
                            FORMAT(fc.cantidad_pago, 2),')\", en concepto de la ',l.letra, ' letra en el mes de ', DATE_FORMAT(fecha_cobro,'%M'),
                            ', por la compra de: '
                        ) cuerpo_texto,
                        FORMAT(fc.cantidad_pago, 2) cantidad_pago_formato,
                        l.id_fecha_cobro,
                        l.letra,
                            TRIM(
                                concat(
                                        COALESCE(concat(TRIM(c.primer_nombre),' '),''),
                                        COALESCE(concat(TRIM(c.segundo_nombre),' '),''),
                                        COALESCE(concat(TRIM(c.primer_apellido),' '),''),
                                        COALESCE(concat(TRIM(c.segundo_apellido),' '),'')
                                    )
                            )nombre_cliente
                    from fechas_cobros fc
                    join ventas v on fc.id_venta = v.id 
                    join clientes c on v.id_cliente = c.id
                    join letra l on fc.id = l.id_fecha_cobro
            )
            select concat(c.cuerpo_texto, GROUP_CONCAT(concat('un Lote \"L-', l.nombre, '\", bloque \"', b.nombre, '\", ubicado en Lotificadora \"', r.nombre,
                    '\", zona de esta ciudad de Catacamas, departamento de Olancho, el que mide y colinda de la siguiente manera: \"AL NORTE\": ',
                    l.norte, ' mts, \"AL SUR\": ', l.sur, ' mts, \"AL ESTE\": ', l.este, ' mts y \"AL OESTE\": ', l.oeste, 
                    ' mts, con un área superficial de \"', l.area , '\" mts².') SEPARATOR ' También ')) cuerpo_documento,
                    c.cantidad_pago_formato,
                    c.letra,
                    c.nombre_cliente
                from fechas_cobros fc 
                join ventas v on fc.id_venta = v.id 
                join lotes_vendidos lv on v.id = lv.id_venta
                join lotes l on lv.id_lote = l.id
                join bloques b on l.id_bloque = b.id
                join residenciales r on b.id_residencial = r.id
                join cliente c ON fc.id = c.id_fecha_cobro
                ", ["id_fecha_pago" => $id]))->first();

        //Inicia fecha actual produccion
        $fechaActual = collect(\DB::select("
            select 
            date_format(DATE_SUB(now(),INTERVAL 8 HOUR), '%d') AS dia, 
            date_format(DATE_SUB(now(),INTERVAL 8 HOUR), '%M') AS mes, 
            date_format(DATE_SUB(now(),INTERVAL 8 HOUR), '%Y') AS anio
        "))->first();
        //Finaliza fecha actual produccion

        $final_documento = "Y para constancia firmo el presente recibo en la ciudad de Catacamas, Olancho, a los ".$numnero_letras->format($fechaActual->dia)." ($fechaActual->dia) días del mes de ($fechaActual->mes) del ".$numnero_letras->format($fechaActual->anio)." ($fechaActual->anio).";
        
        //$file = ('C:/xampp/htdocs/lotificadora/lotificadora/public/documentos/recibo_letra.docx'); //Desarrollo
        $file = "/home/xafysozx/public_html/pruebaslotificadora/documentos/recibo_letra.docx"; //Producción
		
        try {
            
            $template = new \PhpOffice\PhpWord\TemplateProcessor( $file ); 
            $template->setValue( 'cuerpo_documento', $datosPagoCuota->cuerpo_documento);
            $template->setValue( 'cuota', $datosPagoCuota->cantidad_pago_formato);
            $template->setValue( 'final_documento', $final_documento );
            
            $tempFile = tempnam(sys_get_temp_dir(), 'PHPWord');
            $template->saveAs($tempFile);
            
            $headers = [
                "Content-Type: application/octet-stream",
            ];
            
            return response()->download($tempFile, 'Recibo '.$datosPagoCuota->nombre_cliente.' Letra '.$datosPagoCuota->letra.'.docx', $headers)->deleteFileAfterSend(true);
            
       } catch (Exception $ex) {
            
        }
        
    }


}
