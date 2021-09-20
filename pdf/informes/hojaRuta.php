<?php

require('../tfpdf/tfpdf.php');
require_once '../../vendor/autoload.php';
require_once '../../eloquent/database.php';
require_once '../../eloquent/models/Equipo.php';
require_once '../../eloquent/models/Ensayo.php';
require_once '../../eloquent/models/EnsayoEquipo.php';
require_once '../../eloquent/models/EnsayoMuestra.php';
require_once '../../eloquent/models/EnsayoMuestraReactivoLote.php';
require_once '../../eloquent/models/EnsayoMuestraEstandarLote.php';
require_once '../../eloquent/models/FormaFarmaceutica.php';
require_once '../../eloquent/models/Lote.php';
require_once '../../eloquent/models/LoteReactivo.php';
require_once '../../eloquent/models/LoteEstandar.php';
require_once '../../eloquent/models/Muestra.php';
require_once '../../eloquent/models/Producto.php';
require_once '../../eloquent/models/Paquete.php';

require_once '../../eloquent/models/Reactivo.php';
require_once '../../eloquent/models/Estandar.php';
require_once '../../eloquent/models/SystemParameters.php';
//require '../../model/DB/TablaReportesDbModelClass.php';
//require '../../model/DB/TablaLoteEstandarDbModelClass.php';
//require '../../model/DB/TablaLoteReactivoDbModelClass.php';
//require '../../model/DB/TablaEnsayoEquipoDbModelClass.php';
//require '../../model/DbClass.php';
//require_once '../rotation.php';
require_once './AuxiliarInformes.php';
//$perfil = $_POST['idPerfil'];

class PDF extends TFPDF {

    public $muestra;
    public $customIdMuestra;
    public $equiposAgrupados;
    public $ensayoMuestraReactivosAgrupados;
    public $ensayoMuestraEstandaresAgrupados;
    public $auxGeneral;


    function RotatedText($x, $y, $txt, $angle) {
//Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Header() {

        $this->SetFont('Arial', '', 7);

        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);



        switch($this->muestra->producto->formaFarmaceutica->id){
            case 75:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO ANÁLISIS FISICOS'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-04-FR-052-2'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 76:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO ANÁLISIS FISICOS'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-04-FR-052-2'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 80:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO ANÁLISIS FISICOQUÍMICO SISTEMA DE AGUA Y VAPOR PURO'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-04-FR-054-3'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;

            case 77:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN PARA MATERIAL ENVASE FRASCO'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-03-FR-035-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 82:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN DE MATERIAL DE EMPAQUE'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-03-FR-033-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 83:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN DE MATERIAL DE EMPAQUE'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-03-FR-033-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 84:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN DE MATERIAL DE EMPAQUE'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-03-FR-033-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 85:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN DE MATERIAL DE EMPAQUE'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-03-FR-033-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 86:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO TAPONES ELASTOMÉRICOS'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-04-FR-058-2'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 78:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN PARA MATERIAL DE ENVASE'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-04-FR-054-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            case 81:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO INSPECCIÓN PARA MATERIAL ENVASE'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-03-FR-036-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
            default:
                $this->Cell(100, 20, utf8_decode('HOJA DE TRABAJO ANALÍTICO'), 1, 0, 'C');
                $this->Cell(25, 10, utf8_decode('CÓDIGO'), "LTR", 0, 'C');
                $this->SetXY(150, 20);
                $this->Cell(25, 10, utf8_decode('GCC-04-FR-054-1'), "LBR", 0, 'C');
                $this->SetXY(175, 10);
                $this->Cell(25, 20, utf8_decode('     Página ' . $this->PageNo() . ' de {nb}'), 1, 0, 'C');
                break;
        }

        $this->ln(25);

    }

    function Footer() {
        $this->SetY(-16);
        $this->SetFont('Arial', 'B', 6);
        $this->Ln();
        $this->Cell(90, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }

    function formatDate($stringFecha, $separador){
        if($stringFecha == NULL || $stringFecha == ""){
            return " ";
        }
        $fecha = new DateTime($stringFecha);
        $dia = $fecha->format("j");
        $mes = $fecha->format("n");
        $ano = $fecha->format("y");

        switch ($mes){
            case "1":
                $mes = "Ene";
                break;
            case "2":
                $mes = "Feb";
                break;
            case "3":
                $mes = "Mar";
                break;
            case "4":
                $mes = "Abr";
                break;
            case "5":
                $mes = "May";
                break;
            case "6":
                $mes = "Jun";
                break;
            case "7":
                $mes = "Jul";
                break;
            case "8":
                $mes = "Ago";
                break;
            case "9":
                $mes = "Sep";
                break;
            case "10":
                $mes = "Oct";
                break;
            case "11":
                $mes = "Nov";
                break;
            case "12":
                $mes = "Dic";
                break;
        }

        return $dia . $separador . $mes . $separador . $ano;

    }

    function getFullCustomIdMuestra($prefijo, $customId){
        $aux = (string)$customId;
        $cantidadCerosIzq = (SystemParameters::where("propiedad", "leftCeroCustomIdMuestra")->first())->valor;
        for($i = strlen($aux); $i < $cantidadCerosIzq; $i++ ){
            $aux = "0".$aux;
        }
        $separator = (SystemParameters::where("propiedad", "prefixMuestraSeparator")->first())->valor;
        $aux = $prefijo . $separator . $aux;
        return $aux;
    }

    function obtenerInformacionGeneral() {

        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
        $this->auxGeneral = new AuxiliarInformes();
        $this->muestra = Muestra::with([
            "lote",
            'producto.formaFarmaceutica',
            'ensayosMuestra.ensayo',
            'ensayosMuestra.ensayo.equipos.equipo',
            'ensayosMuestra.ensayo.equipos.equipo' => function($query){
                $query->where("activo",1);
            },
            'ensayosMuestra.paquete',
            "ensayosMuestra.reactivos.reactivo",
            "ensayosMuestra.reactivos.lote",
            "ensayosMuestra.estandares.estandar",
            "ensayosMuestra.estandares.lote",
        ])->find($_POST['idMuestra']);

        $this->ensayosOrdenados = $this->muestra->ensayosMuestra->sortBy('ensayo.orden');

        $this->customIdMuestra =  $this->getFullCustomIdMuestra($this->muestra->prefijo,$this->muestra->custom_id);

        $aux = $this->ensayosOrdenados->toArray();

        $dato = $_POST['idMuestra'];

        /*$modelReporte = new TablaReportesDbModelClass();
        $this->muestra = $modelReporte->getInfoPrincipalHR($dato)[0];
        $this->auxGeneral = new AuxiliarInformes();

        $this->muestra['metodos'] = $modelReporte->getMetodosHR($dato)[0];
        $this->muestra['ensayosRealizar'] = $modelReporte->getEnsayosARealizarHR($dato)[0];
        $this->muestra['clienteid'] = $modelReporte->getidCliente($dato)[0];
        $this->muestra['numeroCliente'] = $modelReporte->numeroCliente($dato)[0];
        $this->muestra['ensayos'] = $modelReporte->VerHojadeRuta($dato);*/
    }

    function selectHojaRuta(){
        switch($this->muestra->producto->formaFarmaceutica->id){
            case 75:
                $this->hojaDeTrabajoAnslisisFisicos();
                break;
            case 76:
                $this->hojaDeTrabajoAnslisisFisicos();
                break;
            case 77:
                $this->hojaDeTrabajoEnvaseFrasco();
                break;
            case 78:
                $this->hojaDeTrabajoMaterialEnvase();
                break;
            case 80:
                $this->hojaRutaAgua();
                break;
            case 81:
                $this->hojaDeTrabajoMaterialEnvase();
                break;
            case 82:
                $this->hojaDeTrabajoMaterialEmpaque();
                break;
            case 83:
                $this->hojaDeTrabajoMaterialEmpaque();
                break;
            case 84:
                $this->hojaDeTrabajoMaterialEmpaque();
                break;
            case 85:
                $this->hojaDeTrabajoMaterialEmpaque();
                break;
            case 86:
                $this->hojaDeTrabajoTaponElastomerico();
                break;
            case 87:
                $this->hojaDeTrabajoAnslisisFisicos();
                break;


            default:

                break;
        }

        $this->ln(25);
    }

    function hojaDeTrabajoMaterialEnvase(){

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(15);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_llegada, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode( $this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->SetFont('Arial', '', 7);

        $this->setWidths(array(25,40));
        $array = array( utf8_decode('No. DE LOTE'),utf8_decode($this->muestra->lote->numero));
        $this->auxGeneral->tablaBordesCentradoV3($this,$array,true);
        $this->Ln(10);

        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_analisis, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(54, 5, utf8_decode($this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->Cell(4, 5, utf8_decode(""), 0, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('No. DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode($this->customIdMuestra), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->ln(10);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 5, "",  0, 'C');

        $this->Cell(40, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(100, 5, utf8_decode($this->muestra->producto->nombre), 1, 0, 'C');
        $this->Cell(4, 5, "",  0, 'C');
        $this->Ln(10);

        $this->Ln(10);
        $this->SetWidths(array(110, 20, 20, 40));
        $this->SetFont('Arial', 'B', 7);
        $array = array(utf8_decode('PARAMETRO  A EVALUAR'),utf8_decode('CATEGORIA DEL DEFECTO'),utf8_decode('TAMAÑO DE LA MUESTRA'),utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'));
        $this->auxGeneral->tablaBordesCentrado($this, $array);

        $this->Ln(0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('1. ASPECTO GENERAL DE LA ENTREGA'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(110,6, utf8_decode('Empaque y embalaje: seguro, limpio y en buenas condiciones '), 'LRT', 0, 'L');
        $this->Cell(20, 6, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 1, 0, 'L');

        $this->Ln(6);
        $this->Cell(110, 6, utf8_decode('Identificación: N°. lote, referencia.'), 1, 0, 'L');
        $this->Cell(20, 6, utf8_decode('Crítico'), 1, 0, 'C');
        $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(110, 6, utf8_decode('Mezclas (Tamaño, color, tipo de material)'), 1, 0, 'L');
        $this->Cell(20, 6, utf8_decode('Crítico'), 1, 0, 'C');
        $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('2. ASPECTO DEL MATERIAL'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(110, 6, utf8_decode('Terminaciones que afectan la apariencia (rugosidades,fisuras,incrustaciones,otros.)'), 'LRT', 0, 'L');
        $this->Cell(20, 6, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 1, 0, 'L');

        $this->Ln(6);
        $this->Cell(110, 6, utf8_decode('Terminaciones que afectan el uso (Maquinabilidad) rebabas, '), 'LRT', 0, 'L');
        $this->Cell(20, 12, utf8_decode('Critico'), 1, 0, 'C');
        $this->Cell(20, 12, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 12, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(110, 6, utf8_decode('deformes, descentrado, grietas, despicado,liegues, otros)'), 'LR', 0, 'L');
        $this->Cell(20, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(20, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 0, 0, 'L');



        $this->Ln(6);
        $this->Cell(110, 6, utf8_decode('Suciedad removible y no removible'), 1, 0, 'L');
        $this->Cell(20, 6, utf8_decode('Crítico'), 1, 0, 'C');
        $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(110, 6, utf8_decode('Color no característico'), 1, 0, 'L');
        $this->Cell(20, 6, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(40, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 6, utf8_decode('3. DIMENSIONES'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
       if($this->muestra->producto->formaFarmaceutica->id == 78){
           foreach ($this->muestra->ensayosMuestra as $ensayoMuestra) {
               $this->SetWidths(array(20,53,45,17,20,35));
               $array = array((utf8_decode($this->muestra->producto->formaFarmaceutica->descripcion)),
                   (utf8_decode($ensayoMuestra->ensayo['descripcion'])),(utf8_decode($ensayoMuestra['especificacion'])),( utf8_decode($ensayoMuestra->ensayo['codinterno'])), (utf8_decode('')),(utf8_decode('')));

               $this->auxGeneral->tablaBordesCentrado($this, $array);
           }
       }else if($this->muestra->producto->formaFarmaceutica->id == 81){
            foreach ($this->muestra->ensayosMuestra as $ensayoMuestra) {
                $this->SetWidths(array(20,45,45,20,20,40));
                $array = array((utf8_decode($this->muestra->producto->formaFarmaceutica->descripcion)),
                    (utf8_decode($ensayoMuestra->ensayo['descripcion'])),(utf8_decode($ensayoMuestra['especificacion'])),(utf8_decode($ensayoMuestra->ensayo['codinterno'])), (utf8_decode('')),(utf8_decode('')));

                $this->auxGeneral->tablaBordesCentrado($this, $array);
            }
        }

        $this->seccionCumpleEspecificaciones();
        $this->Ln(0);
        $this->SetFont('Arial', 'B', 9);
        $this->finDocumentoSinReactivos();
    }

    function hojaDeTrabajoTaponElastomerico(){
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(13);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(2   , 5, "",  0, 'C');
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_llegada, "-")), 1, 0, 'C');
        $this->Cell(10   , 5, "",  0, 'C');



        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('CANT. DE ENVASES O MUESTRAS'), 0, 0, 'L');
        $this->Cell(20, 5, utf8_decode(''), 0, 0, 'L');
        $this->Cell(20, 5, utf8_decode($this->muestra->lote->cantidad_enviada), 1, 0, 'C');

        $this->setWidths(array(25,40));
        $array = array( utf8_decode('No. DE LOTE'),utf8_decode($this->muestra->lote->numero));
        $this->auxGeneral->tablaBordesCentradoV3($this,$array,true);
        $this->Ln(10);


        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->SetX(13);
        $this->Cell(27, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(2, 5, utf8_decode(''), 0, 0, 'L');
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_analisis, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');



        $this->SetFont('Arial', 'B', 7);

        $this->Cell(25, 5, utf8_decode('No. DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(-2   , 5, "",  0, 'C');
        $this->Cell(30, 5, utf8_decode($this->customIdMuestra), 1, 0, 'C');
        $this->Cell(10, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode( $this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->SetFont('Arial', '', 7);




        $this->Ln(10);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 5, utf8_decode(""), 0, 0, 'C');
        $this->Cell(45, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA '), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(100, 5, utf8_decode($this->muestra->producto->nombre), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');
        $this->Ln(10);



        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 6, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->Cell(20  , 5, utf8_decode('ÍTEM'), 1, 0, 'C');
        $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
        $this->Cell(97, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
        $this->Ln(5 );
        $this->SetFont('Arial', '', 8);

        $this->Cell(20, 5, utf8_decode(), 'LTR', 0, 'C');
        $this->Cell(73, 5, utf8_decode('USPv (381) Tapones Elastoméricos para Inyectables   '), 'LTR', 0, 'C');
        $this->Cell(30, 5, utf8_decode('Fragmentación'), 'LTR', 0, 'C');
        $this->Cell(67, 5, utf8_decode('No hay más de cinco fragmentos visibles. '), 'LTR', 0, 'C');

        $this->Ln(5 );
        $this->Cell(20, 5, utf8_decode('1'), 'LR', 0, 'C');
        $this->Cell(73, 5, utf8_decode('Método interno GCC-04-IN-002. '), 'LR', 0, 'C');
        $this->Cell(30, 5, utf8_decode('Capacidad de'), 'LTR', 0, 'C');
        $this->Cell(67 ,5, utf8_decode('Ninguno de los viales contiene'), 'LTR', 0, 'C');
        $this->Ln(5 );
        $this->Cell(20, 5, utf8_decode(), 'LBR', 0, 'C');
        $this->Cell(73, 5, utf8_decode(), 'LBR', 0, 'C');
        $this->Cell(30, 5, utf8_decode('autosellado'), 'LBR', 0, 'C');
        $this->Cell(67, 5, utf8_decode('vestigios de solución azul.'), 'LBR', 0, 'C');

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('PREPARACIÓN DE LAS MUESTRAS DE TAPON PARA LAS PRUEBAS DE FRAGMENTACIÓN Y CAPACIDAD DE AUTOSELLADO'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(50, 12, utf8_decode('Peso inicial'), 1, 0, 'C');
        $this->Cell(70, 12, utf8_decode('Erlenmeyer + Tapón + Agua'), 1, 0, 'C');
        $this->Cell(70  , 12, utf8_decode(''), 1, 0, 'C');
        $this->Ln(12);
        $this->Cell(50, 6, utf8_decode('Peso'), 'LTR', 0, 'C');
        $this->Cell(70, 6, utf8_decode('Erlenmeyer + Tapón + Agua agregada'), 'LTR', 0, 'C');
        $this->Cell(70, 6, utf8_decode(), 'LTR', 0, 'C');

        $this->Ln(6);
        $this->Cell(50, 6, utf8_decode('final'), 'LBR', 0, 'C');
        $this->Cell(70, 6, utf8_decode('hasta completar el peso inicial'), 'LBR', 0, 'C');
        $this->Cell(70, 6, utf8_decode(), 'LBR', 0, 'C');

        $this->Ln(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('PRUEBA DE FRAGMENTACIÓN'), 1, 0, 'C',TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(70, 12, utf8_decode('N° de fragmentos visibles en la superficie  del filtro:'), 'LBR', 0, 'C');
        $this->Cell(120, 12, utf8_decode(), 'LBR', 0, 'C');
        $this->Ln(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('RESULTADO  DEL ENSAYO'), 1, 0, 'C',TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('PRUEBA DE CAPACIDAD DE AUTOSELLADO'), 1, 0, 'C',TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->Cell(190, 18, utf8_decode(), 'LBR', 0, 'C');
        $this->Ln(18);
        $this->SetFont('Arial', '', 8);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 9);
        $this->Ln(0);
        $this->finDocumento();

    }

    function hojaDeTrabajoMaterialEmpaque(){

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(15);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_llegada, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(58, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'C');




        $this->setWidths(array(25,40));
        $array = array( utf8_decode('No. DE LOTE'),utf8_decode($this->muestra->lote->numero));
        $this->auxGeneral->tablaBordesCentradoV3($this,$array,true);

        $this->Ln(10);


        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_analisis, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(54, 5, utf8_decode($this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->Cell(4, 5, utf8_decode(""), 0, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('No. DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode($this->customIdMuestra), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->ln(10);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 5, utf8_decode(""), 0, 0, 'C');
        $this->Cell(45, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA '), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(100, 5, utf8_decode($this->muestra->producto->nombre), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->ln(10);
        $paquetes = [];
        foreach ( $this->muestra->ensayosMuestra as $item){
            $idPaquete = $item->paquete->id;
            $this->SetFont('Arial', 'B', 8);

            //if($idPaquete == 3503 || $idPaquete == 3504 || $idPaquete == 3505 || $idPaquete == 3506  ){


                    if(isset($paquetes[$idPaquete])){
                        array_push($paquetes[$idPaquete],$item);

                    }else{
                        $paquetes[$idPaquete] = [];
                        array_push($paquetes[$idPaquete],$item);
                    }
                foreach($paquetes as $ensayoPaquete){
                    foreach($ensayoPaquete as $paq){
                        $this->SetFont('Arial', '', 8);
                        //$array = array( utf8_decode( $paq->paquete['descripcion']), utf8_decode($item['descripcion_especifica']), utf8_decode($item['especificacion']),utf8_decode( $paq->ensayo['codinterno']),(''),(''));
                        //$this->auxGeneral->tablaBordesCentrado($this, $array);
                    }
                }


                //$this->seccionCumpleEspecificaciones();
            //$this->Ln(5);
       // }

        }

        $this->SetWidths(array(30, 35, 40, 30,25,30));
        foreach($paquetes as $paquete){
            $this->Rect($this->GetX(), $this->GetY(), 30, 8);
            $array =  array( utf8_decode('INSUMO'),utf8_decode(' PARAMETRO'),
                utf8_decode('ESPECIFICACIÓN'), utf8_decode('CLASE DE DEFECTO'),
                utf8_decode('TAMAÑO DE LA MUESTRA'),utf8_decode('No. DE UNIDADES DEFECTUOSAS'));
            $this->auxGeneral->tablaBordesCentrado($this, $array);
            foreach($paquete as $key => $ensayo){
                $this->SetFont('Arial', '', 8);


                if( $ensayo['id_ensayo'] == 3633){
                    $this->SetWidths(array(35,20,20,30,25,30));
                    $this->Cell(30, 20, utf8_decode(), 'L', 0, 'C');
                    $this->SetFont('Arial', '', 6.5);
                    $resultado = $ensayo['especificacion'];
                    $saltoLine = explode(";",$resultado);
                    $this->SetFont('Arial', '', 7);
                    $array = array(  utf8_decode($ensayo['descripcion_especifica']),($saltoLine[0]),($saltoLine[1]),(''),(''),(''));
                    $this->auxGeneral->tablaBordesCentradoV4($this, $array,false);
                    $this->SetWidths(array(35,20,20,30,25,30));
                    $this->Cell(30, 10, utf8_decode(), 'L', 0, 'C');
                    $array = array( utf8_decode(''),($saltoLine[2]),($saltoLine[3]),(($ensayo->ensayo['codinterno'])),(''),(''));
                    $this->auxGeneral->tablaBordesCentradoV4($this, $array,false);
                    $this->SetWidths(array(35,20,20,30,25,30));
                    $this->Cell(30, 10, utf8_decode(), 'L', 0, 'C');
                    $array = array( (''),($saltoLine[4]),($saltoLine[5]),(''),(''),(''));
                    $this->auxGeneral->tablaBordesCentradoV4($this, $array,false);
                }
                if($ensayo['id_ensayo'] == 3633){
                    null;
                }else{
                    $this->SetFont('Arial', '', 8);

                    $this->SetWidths(array(30, 35, 40, 30,25,30));

                    if($key == 0){
                        $array = array( utf8_decode( $ensayo->paquete['descripcion']), utf8_decode($ensayo['descripcion_especifica']), utf8_decode($ensayo['especificacion']),utf8_decode( $ensayo->ensayo['codinterno']),(''),(''));
                    }
                    else {
                        $array = array( utf8_decode( ""), utf8_decode($ensayo['descripcion_especifica']), utf8_decode($ensayo['especificacion']),utf8_decode( $ensayo->ensayo['codinterno']),(''),(''));
                    }
                    if($key == count($paquete)-1){
                        $this->auxGeneral->tablaBordesCentradoV2($this, $array, true);
                    } else {
                        $this->auxGeneral->tablaBordesCentradoV2($this, $array, false);
                    }
                }

            }

            $this->seccionCumpleEspecificaciones();

            $this->ln();

        }

        $y = $this->GetY();
        if(($y + 40) > 263){
            $this->AddPage();
        }

        $this->SetX(56);
        $this->Cell(99, 15, utf8_decode(), 'LRT', 0, 'C');
        $this->Ln(15);
        $this->SetX(56);
        $this->SetFont('Arial', '', 7);

        $this->Cell(99, 5, utf8_decode('PEGUE UNA   ETIQUETA EN ESTE ESPACIO, O ADJUNTE UNA MUESTRA DE'), 'LR', 0, 'C');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(99, 5, utf8_decode('LA PLEGADIZA O DEL INSERTO AL RESPALDO'), 'LR', 0, 'C');
        $this->Ln(5);
        $this->SetX(56);
        $this->Cell(99, 15, utf8_decode(''), 'LRB', 0, 'C');
        $this->Ln(20);
        $this->finDocumentoSinReactivos();
    }
    function hojaDeTrabajoEnvaseFrasco(){

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(15);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_llegada, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode( $this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->SetFont('Arial', '', 7);

        $this->setWidths(array(25,40));
        $array = array( utf8_decode('No. DE LOTE'),utf8_decode($this->muestra->lote->numero));
        $this->auxGeneral->tablaBordesCentradoV3($this,$array,true);
        $this->Ln(10);

        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_analisis, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(54, 5, utf8_decode($this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->Cell(4, 5, utf8_decode(""), 0, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('No. DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode($this->customIdMuestra), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->ln(10);

        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(80, 5, utf8_decode($this->muestra->producto->nombre), 1, 0, 'C');
        $this->Cell(4, 5, "",  0, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
        $this->Cell(38, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
        $this->Cell(38, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
        $this->Cell(54, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
        $this->Ln(6);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 6, utf8_decode('1. ASPECTO GENERAL DE LA ENTREGA'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 7);
        $this->Cell(60, 6, utf8_decode('Empaque y embalaje: seguro, limpio '), 'LRT', 0, 'L');
        $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 12, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('y en buenas condiciones.'), 'LRB', 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 0, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('Identificación: N°. lote, referencia.'), 1, 0, 'L');
        $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
        $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('Mezclas (Tamaño, color, tipo de material)'), 1, 0, 'L');
        $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
        $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 6, utf8_decode('2. ASPECTO DEL MATERIAL'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 7);
        $this->Cell(60, 6, utf8_decode('Terminaciones que afectan la apariencia'), 'LRT', 0, 'L');
        $this->Cell(38, 12, utf8_decode('Menor'), 1, 0, 'C');
        $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 12, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('(rugosidades, fisuras, incrustaciones, otros.)'), 'LRB', 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 0, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('Terminaciones que afectan el uso (Maquinabilidad)'), 'LRT', 0, 'L');
        $this->Cell(38, 18, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(38, 18, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 18, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode(' rebabas, deformes, descentrado, grietas, despicado,'), 'LR', 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 0, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('pliegues, otros)'), 'LRB', 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 0, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('Suciedad interior o exterior removible con un '), 'LRT', 0, 'L');
        $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 12, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('proceso adicional de limpieza'), 'LRB', 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 0, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('Suciedad interior no removible'), 1, 0, 'L');
        $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
        $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(60, 6, utf8_decode('Suciedad exterior no removible'), 1, 0, 'L');
        $this->Cell(38, 6, utf8_decode('Mayor'), 1, 0, 'C');
        $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
        $this->Cell(54, 6, utf8_decode(''), 1, 0, 'L');
        $this->Ln(6);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(190, 6, utf8_decode('3. DIMENSIONES'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);

        foreach ($this->muestra->ensayosMuestra as $ensayoMuestra) {
            $this->SetWidths(array(25, 35, 38, 38,54));
            $array = array(( utf8_decode($ensayoMuestra->ensayo['descripcion'])),(utf8_decode($ensayoMuestra['especificacion'])),(utf8_decode($ensayoMuestra->ensayo['codinterno'])),( utf8_decode('')),( utf8_decode('')));

            $this->auxGeneral->tablaBordesCentrado($this,$array);
            $this->Ln(0);

        }
        $this->Ln(5);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(5);
        $this->finDocumentoSinReactivos();

    }
    function hojaDeTrabajoAnslisisFisicos(){

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(15);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_llegada, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode( $this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->SetFont('Arial', '', 7);


        $this->setWidths(array(25,40));
        $array =  array(utf8_decode('No. DE LOTE'),utf8_decode($this->muestra->lote->numero));
        $this->auxGeneral->tablaBordesCentradoV3($this,$array,true);

        $this->Ln(10);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_analisis, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');


        $this->setWidths(array(13,45,39,45));

        $array = array(utf8_decode(),utf8_decode($this->muestra->producto->formaFarmaceutica->descripcion),utf8_decode('No. Análisis'),utf8_decode($this->customIdMuestra));
        $this->auxGeneral->tablaSinBordes($this,$array);
        $this->ln(5);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(69, 5, utf8_decode($this->muestra->producto->nombre), 1, 0, 'C');
        $this->Cell(4, 5, "",  0, 'C');
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(50, 5, utf8_decode('CANTIDAD DE ENVASES O MUESTRAS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(15, 5, utf8_decode($this->muestra->lote->cantidad_enviada), 1, 0, 'C');

        $this->ln(10);

        $this->plantillas();
        $this->Ln(10);
        $this->finDocumento();

    }

    function hojaRutaAgua(){

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(15);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_llegada, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('FECHA DE MUESTREO'), 0, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 5, utf8_decode( ""), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode( $this->muestra->producto->formaFarmaceutica->descripcion), 1, 0, 'C');
        $this->SetFont('Arial', '', 7);



        $this->Ln(10);


        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(27, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 5, utf8_decode( $this->formatDate($this->muestra->fecha_analisis, "-")), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('MUESTREADO POR'), 0, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(20, 5, utf8_decode( ""), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 5, utf8_decode('No. DE ANÁLISIS'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(40, 5, utf8_decode($this->customIdMuestra), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->ln(10);

        $this->SetX(15);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(45, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA'), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(133, 5, utf8_decode($this->muestra->producto->nombre), 1, 0, 'C');
        $this->Cell(8, 5, "",  0, 'C');

        $this->ln(10);

        $this->SetFillColor(169, 169, 169);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(50, 5, utf8_decode('ACTIVIDAD'), 1, 0, 'C', true);
        $this->Cell(80, 5, utf8_decode('REALIZADO POR'), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode('FECHA'), 1, 0, 'C', true);
        $this->Cell(30, 5, utf8_decode('SANITIZANTE'), 1, 0, 'C', true);

        $this->ln(5);

        $this->Cell(30, 15, utf8_decode('Sanitización'), 1, 0, 'C', true);
        $this->Cell(20, 5, utf8_decode('Loop 1 P1'), 1, 0, 'C', true);
        $this->Cell(80, 5, utf8_decode(''), 1, 0, 'C', false);
        $this->Cell(30, 5, utf8_decode(''), 1, 0, 'C', false);
        $this->Cell(30, 5, utf8_decode(''), 1, 0, 'C', false);

        $this->ln(5);
        $this->Cell(30, 15, utf8_decode(), 0, 0, 'C');

        $this->Cell(20, 5, utf8_decode('Loop 2 P2'), 1, 0, 'C', true);
        $this->Cell(80, 5, utf8_decode(''), 1, 0, 'C', false);
        $this->Cell(30, 5, utf8_decode(''), 1, 0, 'C', false);
        $this->Cell(30, 5, utf8_decode(''), 1, 0, 'C', false);

        $this->ln(5);
        $this->Cell(30, 15, utf8_decode(), 0, 0, 'C');

        $this->Cell(20, 5, utf8_decode('Loop 3 LCC '), 1, 0, 'C', true);
        $this->Cell(80, 5, utf8_decode(''), 1, 0, 'C', false);
        $this->Cell(30, 5, utf8_decode(''), 1, 0, 'C', false);
        $this->Cell(30, 5, utf8_decode(''), 1, 0, 'C', false);

        $this->ln(10);

        $this->Cell(40, 5, utf8_decode('PUNTOs DE MUESTREO'), "LTR", 0, 'C', false);
        $this->Cell(13, 5, utf8_decode('ASPECTO'), "LTR", 0, 'C', false);
        $this->Cell(13, 5, utf8_decode('COLOR'), "LTR", 0, 'C', false);
        $this->Cell(14, 5, utf8_decode('OLOR'), "LTR", 0, 'C', false);
        $this->Cell(35, 5, utf8_decode('CONDUCTIVIDAD'), "LTR", 0, 'C', false);
        $this->Cell(20, 5, utf8_decode('TEMPERATURA'), "LTR", 0, 'C', false);
        $this->Cell(15, 5, utf8_decode('pH'), "LTR", 0, 'C', false);
        $this->Cell(15, 5, utf8_decode('TOC'), "LTR", 0, 'C', false);
        $this->Cell(25, 5, utf8_decode('CONCEPTO*'), "LTRB", 0, 'C', false);

        $this->ln(5);

        $this->Cell(40, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(13, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(13, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(14, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(35, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(20, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(15, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(15, 5, utf8_decode(''), "LBR", 0, 'C', false);
        $this->Cell(12, 5, utf8_decode('C'), "LBR", 0, 'C', false);
        $this->Cell(13, 5, utf8_decode('N.C'), "LBR", 0, 'C', false);

        $this->ln(5);



        foreach ($this->ensayosOrdenados as $ensayoMuestra){




            if ($this->GetY() + 5 > $this->PageBreakTrigger){
                $this->Cell(40, 5, utf8_decode('PUNTOs DE MUESTREO'), "LTR", 0, 'C', false);
                $this->Cell(13, 5, utf8_decode('ASPECTO'), "LTR", 0, 'C', false);
                $this->Cell(13, 5, utf8_decode('COLOR'), "LTR", 0, 'C', false);
                $this->Cell(14, 5, utf8_decode('OLOR'), "LTR", 0, 'C', false);
                $this->Cell(35, 5, utf8_decode('CONDUCTIVIDAD'), "LTR", 0, 'C', false);
                $this->Cell(20, 5, utf8_decode('TEMPERATURA'), "LTR", 0, 'C', false);
                $this->Cell(15, 5, utf8_decode('pH'), "LTR", 0, 'C', false);
                $this->Cell(15, 5, utf8_decode('TOC'), "LTR", 0, 'C', false);
                $this->Cell(25, 5, utf8_decode('CONCEPTO*'), "LTRB", 0, 'C', false);

                $this->ln(5);

                $this->Cell(40, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(13, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(13, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(14, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(35, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(20, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(15, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(15, 5, utf8_decode(''), "LBR", 0, 'C', false);
                $this->Cell(12, 5, utf8_decode('C'), "LBR", 0, 'C', false);
                $this->Cell(13, 5, utf8_decode('N.C'), "LBR", 0, 'C', false);

                $this->ln(5);
            }
            $this->SetWidths(array(40, 13, 13, 14, 35, 20, 15, 15, 12, 13));
            $this->SetAligns(array('L', 'C','C','C','C', 'C', 'C', 'C', 'C'));
            $this->SetFont('Arial', '', 7);
            $this->auxGeneral->tablaBordesTamanoLinea($this, Array(utf8_decode($ensayoMuestra->descripcion_especifica),utf8_decode(''),utf8_decode(''),utf8_decode(''),utf8_decode(''),utf8_decode(''),utf8_decode(''),utf8_decode(''),utf8_decode(''), utf8_decode('')), 5);

        }

        $this->Cell(190, 5, utf8_decode('* C: Cumple               N.C: No Cumple'), 1, 0, 'C', false);

        $this->ln(10);


        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('Especificaciones conductividad'), "LTR", 0, 'C', true);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(30, 5, ('ETAPA 1: 1,3 μ  S / cm a '), "LTR", 0, 'F', false);
        $this->Cell(60, 5, ('ETAPA 2: 1,6 μ  S / cm a compensadas por tempera- '), "LTR", 0, 'F', false);
        $this->Cell(60, 5, ('ETAPA 3: Depende del pH. Rango de 5,0 a 7,0.'), "LTR", 0, 'F', false);
        $this->ln(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('USP 645'), "LBR", 0, 'C', true);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(30, 5, ('25° C'), "LBR", 0, 'F', false);
        $this->Cell(60, 5, ('tura a 25° C o no compensadas por temperatura'), "LBR", 0, 'F', false);
        $this->Cell(60, 5, ('Tabla 2. Etapa 3 Requisitos de pH y conductividad'), "LBR", 0, 'F', false);

        $this->ln(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, ('Limites de alerta conductividad'), 1, 0, 'C', true);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(150, 5, (' ETAPA 2: 1,6  µ  S / cm en tres o mas puntos el mismo dí a'), 1, 0, 'C', false);

        $this->ln(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('Límites de acción conductividad'), 1, 0, 'C', true);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(150, 5, ('1,8 µ  S / cm en tres o mas puntos el mismo dí a'), 1, 0, 'C', false);

        $this->ln(5);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(40, 5, utf8_decode('Límites de TOC'), 1, 0, 'C', true);
        $this->SetFont('DejaVu', '', 6);
        $this->Cell(75, 5, ('Lí mite de alerta: má  ximo 228 ppb en tres o mas puntos un mismo dí a'), 1, 0, 'F', false);
        $this->Cell(75, 5, ('Lí mite de acció  n: má  ximo 306 ppb en tres o mas puntos un mismo dí a'), 1, 0, 'F', false);

        $this->ln(10);
        $this->SetFont('Arial', 'B', 7);

        $this->Cell(40, 5, ('Observaciones: '), 1, 0, 'C', false);
        $this->Cell(150, 5, (''), 1, 0, 'C', false);

        $this->ln(5);

        $this->Cell(190, 5, (''), 1, 0, 'C', false);

        $this->ln(5);

        $this->Cell(190, 5, (''), 1, 0, 'C', false);

        $this->ln(5);

        $this->Cell(190, 5, (''), 1, 0, 'C', false);

        $this->ln(5);

        $this->secEquipos();

        $this->ln(5);

        $this->secReactivos();

        $this->ln(5);

        $this->secEstandares();

        $this->ln(10);

        $this->Cell(190, 5, ('Resultado fuera de especificaciones:'), 1, 0, 'L', false);

        $this->ln(5);

        $this->Cell(190, 5, utf8_decode('Verificación:'), 1, 0, 'L', false);

        $this->ln(5);

        $this->Cell(190, 5, (''), 1, 0, 'L', false);

        $this->ln(5);

        $this->Cell(190, 5, ('Concepto'), 1, 0, 'L', false);

        $this->ln(5);

        $this->Cell(95, 5, ('[ ] Cumple con las especificaciones      '), "LTB", 0, 'R', false);
        $this->Cell(95, 5, ('      [ ] No cumple con las especificaciones'), "TRB", 0, 'L', false);

        $this->ln(5);
        $this->ln(5);
        $this->ln(5);

        $this->Cell(20, 5, ('Analizado por: '), 0, 0, 'L', false);
        $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

        $this->Cell(20, 5, ('Verificado por: '), 0, 0, 'L', false);
        $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

        $this->ln(5);
        $this->ln(5);
        $this->ln(5);
        $this->ln(5);

        $this->Cell(20, 5, ('Transcrito por: '), 0, 0, 'L', false);
        $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

        $this->Cell(20, 5, ('Aprobado por: '), 0, 0, 'L', false);
        $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

        $this->Ln(25);
        $this->SetFont('DejaVu', '', 7);
            $this->AddPage();

        $this->Cell(10, 5, ('No.'), 1, 0, 'C');
        $this->Cell(70, 5, ('PUNTO DE MUESTREO '), 1, 0, 'L');
        $this->Cell(20, 5, ('Aspecto'), 1, 0, 'C');
        $this->Cell(15, 5, ('Color'), 1, 0, 'C');
        $this->Cell(15, 5, ('Olor'), 1, 0, 'C');
        $this->Cell(15, 5, ('pH'), 1, 0, 'C');
        $this->Cell(30, 5, ('Conductividad'), 1, 0, 'C');
        $this->Cell(15, 5, ('TOC'), 1, 0, 'C');
        $this->Ln(5);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(10, 5, ('1'), 1, 0, 'C');
        $this->Cell(70, 5, ('Suministro de agua potable '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 20, ('Max 9,0'), 1, 0, 'C');
        $this->Cell(30, 5, (''), 'LRT   ', 0, 'C');
        $this->Cell(15, 5, (''), 'LRT', 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('2'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida tanque de almacenamiento de agua potable '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, ('MAX 1.000'), 'LR', 0, 'C');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('3'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida del filtro multimedia'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, ('μ  S/cm3'), 'LR', 0, 'C');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('4'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida de los filtros de 10 micrómetros '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, (''), 'LRB', 0, 'L');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('5'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida del filtro de carbón activado'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 30, ('5,0-8,0'), 1, 0, 'C');
        $this->Cell(30, 5, (''), 'LRT', 0, 'L');
        $this->Cell(15, 5, ('N.A'), 'LR', 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('6'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida de los filtros de 5 micrómetros'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, (''), 'LR', 0, 'L');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('7'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida del suavizador'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, ('Max 120 μ  S/cm3'), 'LR', 0, 'C');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('8'), 1, 0, 'C');
        $this->Cell(70, 5, ('Después de la lámpara UV '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, (''), 'LR', 0, 'L');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('9'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida filtra 1 micrómetro'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, (''), 'LR', 0, 'L');
        $this->Cell(15, 5, (''), 'LR', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('10'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida del equipo de osmosis inversa primera etapa'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 0, 0, 'L');
        $this->Cell(30, 5, ('Max 10  μ  S/cm3'), 1, 0, 'C');
        $this->Cell(15, 5, (''), 'LRB', 0, 'L');
        $this->Ln(5);
        $this->Cell(10, 5, ('11'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida de la resina de lecho mixta '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Cell(15, 160, ('5,0 – 7,0'), 1, 0, 'C');
        $this->Cell(30, 160, ('≤   1,3 μ  S/cm3'), 1, 0, 'C');
        $this->Cell(15, 160, ('≤   500 ppb'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('12'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida del equipo de osmosis inversa segunda etapa'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('13'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida tanque generador de vapor limpio'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(10, 5, ('14'), 1, 0, 'C');
        $this->SetFont('DejaVu', '', 6.5);
        $this->Cell(70, 5, ('Salida de Tanque de almacenamiento 1 (WP P1) Primera etapa'), 1, 0, 'L');
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(10, 5, ('15'), 1, 0, 'C');
        $this->SetFont('DejaVu', '', 6.5);
        $this->Cell(70, 5, ('Salida de Tanque de almacenamiento 2 (WP P1) segunda etapa '), 1, 0, 'L');
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(10, 5, ('16'), 1, 0, 'C');
        $this->SetFont('DejaVu', '', 6.5);
        $this->Cell(70, 5, ('Salida de Tanque de almacenamiento 3 (WP P2) primera etapa'), 1, 0, 'L');
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(10, 5, ('17'), 1, 0, 'C');
        $this->SetFont('DejaVu', '', 6.5);
        $this->Cell(70, 5, ('Salida de Tanque de almacenamiento 4 (WP P2) segunda etapa'), 1, 0, 'L');
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->SetFont('DejaVu', '', 7);
        $this->Ln(5);
        $this->SetFont('DejaVu', '', 7);
        $this->Cell(10, 5, ('18'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida de Tanque de almacenamiento 5 (WP LCC)'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('19'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno tanque 1 (WP P1) primera etapa '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('20'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno tanque 2 (WP P1) segunda etapa'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('21'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno tanque 3 (WP P2) primera etapa'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('22'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno tanque 4 (WP P2) segunda etapa'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('23'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno tanque 5 (WP LCC) '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('24'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavadora de viales (primer enjuague) WP P1S'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('25'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de materiales WP P1  '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');

        $this->Ln(5);
        $this->Cell(10, 5, ('26'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavadora externa 1 WP P1 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('27'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de ropas WP P1 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('28'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida tanque 6 de 120 L - filtro 0,22 micrómetros'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('29'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de materiales WFI P1 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('30'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavadora de viales (ultimo enjuague) WFI P1'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('31'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno al tanque 6 de 120 L '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('32'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavadora de viales (primer enjuague) WP P2 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('33'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de materiales WP P2'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('34'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavadora externa WP P2 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('35'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de ropas WP P2'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('36'), 1, 0, 'C');
        $this->Cell(70, 5, ('Salida tanque 7 de 120 L - filtro 0,22 micrómetros '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('37'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de materiales WFI P2 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('38'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavadora de viales (ultimo enjuague) WFI P2 '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('39'), 1, 0, 'C');
        $this->Cell(70, 5, ('Retorno al tanque 7 de 120 L'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('40'), 1, 0, 'C');
        $this->Cell(70, 5, ('Lavado de materiales '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('41'), 1, 0, 'C');
        $this->Cell(70, 5, ('Preparación y almacenamiento  de medios de cultivo '), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(10, 5, ('42'), 1, 0, 'C');
        $this->Cell(70, 5, ('Manejo de cepas'), 1, 0, 'L');
        $this->Cell(20, 5, ('transparente'), 1, 0, 'C');
        $this->Cell(15, 5, ('Incoloro'), 1, 0, 'C');
        $this->Cell(15, 5, ('Inodoro'), 1, 0, 'C');
    }

    function secEstandares(){
        $this->ensayoMuestraEstandaresAgrupados = [];

        foreach ($this->muestra->ensayosMuestra as $ensayoMuestra){
            foreach ($ensayoMuestra->estandares as $ensayoMuestraEstandar){

                $flag = true;

                foreach ($this->ensayoMuestraEstandaresAgrupados as $ensayoMuestraEstandarAgrupado){
                    if($ensayoMuestraEstandarAgrupado->estandar->id == $ensayoMuestraEstandar->estandar->id &&
                        $ensayoMuestraEstandarAgrupado->lote->id == $ensayoMuestraEstandar->lote->id){
                        $flag = false;
                        break;
                    }
                }

                if($flag){
                    array_push($this->ensayoMuestraEstandaresAgrupados, $ensayoMuestraEstandar);
                }
            }
        }

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 5, utf8_decode('ESTANDARES DEL ENSAYO'), 1, 0, 'C', TRUE);
        $this->Ln(5);

        $this->setWidths(array(30,45,45,45,25));
        $array = array (utf8_decode('Código'),utf8_decode('Estandar'),utf8_decode('Lote'),utf8_decode('Fecha de vencimiento'),utf8_decode('Cantidad usada'));
        $this->auxGeneral->tablaBordesCentrado($this,$array);

        if(count($this->ensayoMuestraEstandaresAgrupados) > 0){
            $this->SetFont('Arial', '', 7);
            foreach ($this->ensayoMuestraEstandaresAgrupados as $ensayoMuestraEstandar){
                if($ensayoMuestraEstandar->estandar->activo == 1) {
                    $array = array(utf8_decode($ensayoMuestraEstandar->estandar->codigo), utf8_decode($ensayoMuestraEstandar->estandar->nombre), utf8_decode($ensayoMuestraEstandar->lote->codigo), utf8_decode($this->formatDate($ensayoMuestraEstandar->lote->fecha_vencimiento, "-")), (''));
                    $this->auxGeneral->tablaBordesCentrado($this, $array);
                }
            }
        } else {
            $this->Cell(190, 5, ('No se encontraron reactivos asociados'), 1, 0, 'C');
        }

    }

    function secEquipos(){
        $this->equiposAgrupados = [];


        foreach ($this->muestra->ensayosMuestra as $ensayoMuestra){
            foreach ($ensayoMuestra->ensayo->equipos as $ensayoEquipo){

                $flag = true;

                foreach ($this->equiposAgrupados as $equipoAgrupado){
                    if($equipoAgrupado->id == $ensayoEquipo->equipo->id){
                        $flag = false;
                        break;
                    }
                }

                if($flag){
                    array_push($this->equiposAgrupados, $ensayoEquipo->equipo);
                }
            }
        }

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 5, utf8_decode('EQUIPOS O INSTRUMENTOS DEL ENSAYO'), 1, 0, 'C', TRUE);
        $this->Ln(5);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('Equipo'), 1, 0, 'C');
        $this->Cell(50, 5, utf8_decode('Serie'), 1, 0, 'C');
        $this->Cell(50, 5, utf8_decode('Fecha de calibración'), 1, 0, 'C');
        $this->Ln(5);

        if(count($this->equiposAgrupados) > 0){
            $this->SetFont('Arial', '', 7);
            foreach ($this->equiposAgrupados as $equipo){
                if($equipo == null){
null;   
                }else{
                    $this->Cell(30, 5, ($equipo->cod_inventario), 1, 0, 'C');
                    $this->Cell(60, 5, ($equipo->descripcion), 1, 0, 'C');
                    $this->Cell(50, 5, ($equipo->serie), 1, 0, 'C');
                    $this->Cell(50, 5, ($this->formatDate($equipo->fecha_ult_calib, "-")), 1, 0, 'C');
                    $this->Ln(5);
                }
            }
        }

    }

    function secReactivos(){
        $this->ensayoMuestraReactivosAgrupados = [];

        foreach ($this->muestra->ensayosMuestra as $ensayoMuestra){
            foreach ($ensayoMuestra->reactivos as $ensayoMuestraReactivo){

                $flag = true;

                foreach ($this->ensayoMuestraReactivosAgrupados as $ensayoMuestraReactivoAgrupado){
                    if($ensayoMuestraReactivoAgrupado->reactivo->id == $ensayoMuestraReactivo->reactivo->id &&
                        $ensayoMuestraReactivoAgrupado->lote->id == $ensayoMuestraReactivo->lote->id){
                        $flag = false;
                        break;
                    }
                }

                if($flag){
                    array_push($this->ensayoMuestraReactivosAgrupados, $ensayoMuestraReactivo);
                }
            }
        }

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 5, utf8_decode('REACTIVOS DEL ENSAYO'), 1, 0, 'C', TRUE);
        $this->Ln(5);

        $this->setWidths(array(30,45,45,45,25));
        $array = array (utf8_decode('Código'),utf8_decode('Reactivo'),utf8_decode('Lote'),utf8_decode('Fecha de vencimiento'),utf8_decode('Cantidad usada'));
        $this->auxGeneral->tablaBordesCentrado($this,$array);

        if(count($this->ensayoMuestraReactivosAgrupados) > 0){
            $this->SetFont('Arial', '', 7);
            //$a = $this->ensayoMuestraReactivosAgrupados->toArray();
            foreach ($this->ensayoMuestraReactivosAgrupados as $ensayoMuestraReactivo){
                if($ensayoMuestraReactivo->reactivo->activo == 1){
                    $array = array( utf8_decode($ensayoMuestraReactivo->reactivo->codigo), utf8_decode($ensayoMuestraReactivo->reactivo->nombre),utf8_decode($ensayoMuestraReactivo->lote->numero),utf8_decode($this->formatDate($ensayoMuestraReactivo->lote->fecha_vencimiento, "-")),(''));
                    $this->auxGeneral->tablaBordesCentrado($this,$array);
                }

            }
        } else {
            $this->Cell(190, 5, ('No se encontraron reactivos asociados'), 1, 0, 'C');
        }

    }

    function plantillas(){
        foreach ($this->muestra->ensayosMuestra as $ensayoMuestra){
            switch ($ensayoMuestra->ensayo->id_plantilla){
                case 10:
                    $this->plantillaId_10();
                break;

                case 11:
                    $this->plantillaId_11();
                    break;

                case 13:
                    $this->plantillaId_13();
                    break;

                case 14:
                    $this->plantillaId_14();
                    break;

                case 4:
                    $this->plantillaId_4();
                    break;

                default:
                    break;

            }
        }
    }

    function plantillaId_10(){

        $this->SetFillColor(169, 169, 169);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 5, utf8_decode('ENSAYO CRISTALINIDAD'), 1, 0, 'C', true);


        $this->Ln(10);
        $this->Cell(190, 6, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->Cell(20  , 5, utf8_decode('ÍTEM'), 1, 0, 'C');
        $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
        $this->Cell(97, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
        $this->Ln(5 );
        $this->SetFont('Arial', '', 8);

        $this->Cell(20, 5, utf8_decode(), 'LTR', 0, 'C');
        $this->Cell(73, 5, utf8_decode(' (USPv <776> Microscopía óptica)   '), 'LTR', 0, 'C');
        $this->Cell(97, 5, utf8_decode('Las partículas presentan birrefrigencia (interferencia de colores) '), 'LTR', 0, 'C');


        $this->Ln(5 );
        $this->Cell(20, 5, utf8_decode('1'), 'LR', 0, 'C');
        $this->Cell(73, 5, utf8_decode('Método interno GCC-04-IN-002'), 'LR', 0, 'C');
        $this->Cell(97, 5, utf8_decode('y posiciones de extinción.'), 'LR', 0, 'C');
        $this->Ln(5 );
        $this->Cell(20, 5, utf8_decode(), 'LBR', 0, 'C');
        $this->Cell(73, 5, utf8_decode(), 'LBR', 0, 'C');
        $this->Cell(97, 5, utf8_decode(), 'LBR', 0, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(189, 6, utf8_decode('PRUEBA DE CRISTANILIDAD'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->Cell(189, 12, utf8_decode(), 1, 0, 'C');
        $this->Ln(12);
        $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', '', 8);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);

        $this->ln(5);
    }

    function plantillaId_11(){

        $this->SetFillColor(169, 169, 169);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 5, utf8_decode('ENSAYO DESIDAD APARENTE Y POR ASENTAMIENTO'), 1, 0, 'C', true);
        $this->Ln(10);
        $this->Cell(20  , 5, utf8_decode('ÍTEM'), 1, 0, 'C');
        $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
        $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
        $this->Ln(5 );
        $this->SetFont('Arial', '', 8);

        $this->Cell(20, 5, utf8_decode(), 'LTR', 0, 'C');
        $this->Cell(73, 5, utf8_decode('(USPv <616> Densidad aparente y densidad por '), 'LTR', 0, 'C');
        $this->Cell(96, 5, utf8_decode(), 'LTR', 0, 'C');

        $this->Ln(5 );
        $this->Cell(20, 5, utf8_decode('1'), 'LR', 0, 'C');
        $this->Cell(73, 5, utf8_decode(' asentamiento de los polvos) Método '), 'LR', 0, 'C');
        $this->Cell(96, 5, utf8_decode('Informativo'), 'LR', 0, 'C');
        $this->Ln(5 );
        $this->Cell(20, 5, utf8_decode(), 'LBR', 0, 'C');
        $this->Cell(73, 5, utf8_decode('interno GCC-04-IN-002.'), 'LBR', 0, 'C');
        $this->Cell(96, 5, utf8_decode(), 'LBR', 0, 'C');

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('PRUEBA DENSIDAD APARENTE'), 1, 0, 'C',TRUE);
        $this->Ln(6);
        $this->SetFont('Arial', 'B', 8);
        foreach ($this->muestra->ensayosMuestra as $especificacion){
            if($especificacion->ensayo['id_plantilla'] == 11){
                $this->MultiCell(190, 10, utf8_decode($especificacion['especificacion']), 1, 'L' );

            }

        }
        $this->Ln(0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(63, 6, utf8_decode('Peso muestra (M)'), 1, 0, 'C');
        $this->Cell(63, 6, utf8_decode('Volumen aparente (V)'), 1, 0, 'C');
        $this->Cell(64, 6, utf8_decode('Densidad M / V'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(63, 10, utf8_decode(''), 1, 0, 'C');
        $this->Cell(63, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(64, 10, utf8_decode(), 1, 0, 'C');
        $this->Ln(10);
        $this->Cell(63, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(63, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(64, 10, utf8_decode(), 1, 0, 'C');
        $this->Ln(10);
        $this->Cell(190, 5, utf8_decode('Resultado:'), 1, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
        $this->Ln(5);
        $this->SetFont('Arial', '', 8);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 6, utf8_decode('PRUEBA DENSIDAD POR ASENTAMIENTO'), 1, 0, 'C',TRUE);
        $this->Ln(6);
        foreach ($this->muestra->ensayosMuestra as $especificacion){
            if($especificacion->ensayo['id_plantilla'] == 11){
                $this->MultiCell(190, 10, utf8_decode($especificacion['especificacion']), 1, 'L' );

            }

        }
        $this->Ln(0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(35, 6, utf8_decode('Volumen (V10)'), 1, 0, 'C');
        $this->Cell(35, 6, utf8_decode('Volumen (V50)'), 1, 0, 'C');
        $this->Cell(36, 6, utf8_decode('Volumen (V100)'), 1, 0, 'C');
        $this->Cell(45, 6, utf8_decode('Promedio (V10, V50, V100) / n'), 1, 0, 'C');
        $this->Cell(39, 6, utf8_decode('Densidad (M / Vf)'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(36, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(45, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(39, 10, utf8_decode(), 1, 0, 'C');
        $this->Ln(10);
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(36, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(45, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(39, 10, utf8_decode(), 1, 0, 'C');
        $this->Ln(10);
        $this->Cell(190, 5, utf8_decode('Altura de caída de probeta:'), 1, 0, 'L');
        $this->Ln(5);
        $this->Cell(190, 5, utf8_decode('Resultado:'), 1, 0, 'L');
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
        $this->Ln(5);
        $this->SetFont('Arial', '', 8);
        $this->seccionCumpleEspecificaciones();
        $this->Ln(5);
    }

    function plantillaId_13(){

        $this->SetFillColor(169, 169, 169);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 5, utf8_decode('ENSAYO SOLUBILIDAD'), 1, 0, 'C', true);
        $this->ln(10);


        $this->Cell(20, 5, utf8_decode('ÍTEM'), 1, 0, 'C',TRUE);
        $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C',TRUE);
        $this->Cell(97, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C',TRUE);
        $this->Ln(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(20, 10, utf8_decode('1'), 1, 0, 'C');
        $this->Cell(73, 10, utf8_decode('Método interno GCC-04-IN-002'), 1, 0, 'C');
        $this->Cell(97, 10, utf8_decode('Informativo'), 1, 0, 'C');
        $this->Ln(15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('PRUEBA SOLUBILIDAD'), 1, 0, 'C',TRUE);
        $this->Ln(5);
        $this->SetFont('Arial', '', 8);

        foreach ($this->muestra->ensayosMuestra as $especificacion){
            if($especificacion->ensayo['id_plantilla'] == 13){
                $this->MultiCell(190, 10, utf8_decode($especificacion['especificacion']), 1, 'L' );

            }

        }
        $this->Ln(0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(35, 5, utf8_decode('PESO'), 1, 0, 'C');
        $this->Cell(35, 5, utf8_decode('DILUCIÓN'), 1, 0, 'C');
        $this->Cell(35, 5, utf8_decode('SOLVENTE'), 1, 0, 'C');
        $this->Cell(85, 5, utf8_decode('CLASIFICACIÓN'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(85, 10, utf8_decode(), 1, 0, 'C');
        $this->Ln(10);
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
        $this->Cell(85, 10, utf8_decode(), 1, 0, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(190, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
        $this->Ln(5);
        $this->SetFont('Arial', '', 8);
        $this->seccionCumpleEspecificaciones();
        $this->ln(5);
    }


     function plantillaId_14(){
         $this->SetFont('Arial', 'B', 8);
         $this->Cell(189, 5, utf8_decode('ENSAYO DE JERINGABILIDAD'), 1, 0, 'C',TRUE);

         $this->Ln(10);
         $this->Cell(189, 5, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C',TRUE);
         $this->Ln(5);
         $this->Cell(20, 5, utf8_decode('ÍTEM'), 1, 0, 'C');
         $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
         $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
         $this->Ln(5);
         $this->SetFont('Arial', '', 8);
         $this->Cell(20, 10, utf8_decode('1'), 1, 0, 'C');
         $this->Cell(73, 10, utf8_decode('Método interno GCC-04-IN-002'), 1, 0, 'C');
         $this->SetFont('Arial', '', 7);
         $this->Cell(96, 10, utf8_decode('Fácilmente extraible con jeringa hipodermica No 20 después de su reconstitución'), 1, 0, 'C');
         $this->Ln(15);
         $this->SetFont('Arial', 'B', 8);
         $this->Cell(189, 5, utf8_decode('PRUEBA JERINGABILIDAD'), 1, 0, 'C',TRUE);
         $this->Ln(5);
         $this->Cell(189, 15, utf8_decode(), 1, 0, 'C');
         $this->Ln(15);
         $this->SetFont('Arial', 'B', 8);
         $this->Cell(189, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
         $this->Ln(5);
         $this->SetFont('Arial', '', 8);
         $this->seccionCumpleEspecificaciones();
         $this->Ln(15);

     }

     function plantillaId_4(){
         $this->Cell(190, 5, utf8_decode('PARTÍCULAS EN INYECTABLES'), 1 , 0, 'C',TRUE);
         $this->Ln(5);
         $this->Cell(190, 5, utf8_decode('ENSAYO A REALIZAR'), 1 , 0, 'C',TRUE);
         $this->Ln(5);
         $this->Cell(95, 5, utf8_decode('MÉTODO'), 1 , 0, 'C');
         $this->Cell(95, 5, utf8_decode('ESPECIFICACIÓN'), 1 , 0, 'C');
         $this->Ln(5);
         $this->SetFont('DejaVu', '', 7);
         $this->Cell(95, 5, ('USPv <788> Partículas en inyectables, mé  todo 2 Prueba de conteo microscó  pico'), 'LRT' , 0, 'F');
         $this->Cell(25, 5, ('≥   10 µ  m '), 1 , 0, 'C');
         $this->Cell(70, 5, ('No excede 3000 partí culas por envase'), 1 , 0, 'C');
         $this->Ln(5);

         $this->Cell(95, 5, ('de partículas.GCC-04-IN-001 – Determinació  n de partí culas en inyectables '), 'LRB', 0, 'F');
         $this->Cell(25, 5, ('≥   25 µ  m'), 1 , 0, 'C');
         $this->SetFont('DejaVu', '', 8);

         $this->Cell(70, 5, ('No excede 300 partí culas por envase'), 1 , 0, 'C');

         $this->Ln(5);
         $this->Cell(95, 5, utf8_decode(''), 'LRT', 0, 'L');
         $this->SetFont('arial', '', 8);
         $this->Cell(95, 5, utf8_decode('Producto terminado: Máximo 2 viales pueden contener partículas visibles.  '), 'LRT', 0, 'L');

         $this->Ln(5);
         $this->Cell(95, 5, utf8_decode('USPv <790> Partículas visibles en inyectables, procedimiento de'), 'LR', 0, 'L');
         $this->Cell(95, 5, utf8_decode('Materia prima soluble: Máximo 2 partículas visibles se observan en la '), 'LR', 0, 'L');

         $this->Ln(5);
         $this->Cell(95, 5, utf8_decode('inspección GCC-04-IN-001  Determinación de partí culas en inyectables'), 'LR', 0, 'L');
         $this->Cell(95, 5, utf8_decode('membrana.'), 'LR', 0, 'L');

         $this->Ln(5);
         $this->Cell(95, 5, utf8_decode(''), 'LR', 0, 'L');
         $this->Cell(95, 5, utf8_decode('Materia prima suspensión: Máximo 2 partículas se observan en el fondo.'), 'LR', 0, 'L');

         $this->Ln(5);
         $this->Cell(95, 5, utf8_decode(''), 'LRB', 0, 'L');
         $this->Cell(95, 5, utf8_decode('del recipiente'), 'LRB', 0, 'L');

         $this->Ln(10);
         $this->Cell(190, 6, utf8_decode('PRUEBA DE BLANCO - APTITUD DEL SISTEMA USPv <788>'), 1, 0, 'C', TRUE);
         $this->Ln(6);
         $this->Cell(30, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
         $this->SetFont('DejaVu', '', 8);
         $this->Cell(75, 6, ('No má  s de 20 partí culas con un tamañ  o ≥   de 10 μ  m'), 1, 0, 'F');
         $this->Cell(55, 6, ('Partí culas encontradas ≥   10 µ  m'), 1, 0, 'C');
         $this->SetFont('arial', '', 8);
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');

         $this->Ln(6);
         $this->Cell(30, 6, utf8_decode(), 0, 0, 'L');
         $this->SetFont('DejaVu', '', 8);
         $this->Cell(75, 6, ('No má  s de 5 partí culas con un tamañ  o ≥   de 25 μ  m'), 1, 0, 'F');
         $this->Cell(55, 6, ('Partí culas encontradas ≥   25 µ  m'), 1, 0, 'C');
         $this->SetFont('arial', '', 8);
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Ln(6);
         $this->seccionCumpleEspecificaciones();
         $this->Ln(0);
         $this->Cell(190, 6, utf8_decode('Verificado por: '), 1, 0, 'L');
         $this->Ln(12);
         $this->SetFont('Arial', 'B', 9);
         $this->Cell(190, 6, utf8_decode('DESCRIPCIÓN DE LA PREPARACIÓN DE LA MUESTRA'), 1, 0, 'C',TRUE);
         $this->Ln(6);
         $this->Cell(190, 15, utf8_decode(), 1, 0, 'C');
         $this->Ln(20);
         $this->Cell(190, 6, utf8_decode('CONTEO MICROSCÓPICO  USPv <788>'), 1, 0, 'C',TRUE);
         $this->Ln(10);
         $this->SetFont('Arial', '', 8);

         $this->Cell(32, 8, utf8_decode(), 0, 0, 'C');
         $this->SetFont('Arial', 'B', 8);
         $this->Cell(60, 8, utf8_decode('Cantidad / Tamaño partícula'), 1, 0, 'C');
         $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
         $this->Cell(20, 4, utf8_decode('Demarcación del'), 0, 0, 'C');
         $this->Ln(4);
         $this->Cell(162, 6, utf8_decode(), 0, 0, 'C');
         $this->Cell(20, 4, utf8_decode('cuadrante'), 0, 0, 'C');
         $this->Ln(8);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('No. Captura de imagen'), 1, 0, 'C',TRUE);
         $this->SetFont('DejaVu', '', 8);

         $this->Cell(30, 6, ('10 – 24  (μ  m)'), 1, 0, 'C');
         $this->Cell(30, 6, ('25 – 100  (μ  m)'), 1, 0, 'C');

         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('1'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
         $this->Cell(20, 6, utf8_decode('A'), 1, 0, 'C');

         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('2'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
         $this->Cell(20, 6, utf8_decode('B'), 1, 0, 'C');
         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('3'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
         $this->Cell(20, 6, utf8_decode('B'), 1, 0, 'C');
         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('4'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
         $this->Cell(20, 6, utf8_decode('D'), 1, 0, 'C');
         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('5'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('6'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('7'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Ln();
         $this->Image('../../views/images/conteoMicroscopico.png', $this->getX() + 105, $this->getY() - 40, 50);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('8'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Ln(6);
         $this->SetFont('Arial', '', 8);
         $this->Cell(32, 6, utf8_decode('TOTAL'), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
         $this->Ln(12);
         $this->seccionCumpleEspecificaciones();
         $this->Ln(0);
         $this->Cell(190, 6, utf8_decode('Verificado por:'), 1, 0, 'L');
         $this->Ln(12);
         $this->SetFont('Arial', 'B', 9);
         $this->Cell(190, 6, utf8_decode('PARTÍCULAS VISIBLES PRODUCTO TERMINADO'), 1, 0, 'C',TRUE);

         $this->Ln(12);
         $this->Cell(15, 5, utf8_decode('No. Vial o'), 'LRT', 0, 'C',TRUE);
         $this->Cell(30, 5, utf8_decode('No. Partículas'), 'LRT', 0, 'C',TRUE);
         $this->Cell(47.5, 10, utf8_decode('Descripción de Partículas'), 1, 0, 'C',TRUE);
         $this->Cell(5, 10, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('No. Vial o'), 'LRT', 0, 'C',TRUE);
         $this->Cell(30, 5, utf8_decode('No. Partículas'), 'LRT', 0, 'C',TRUE);
         $this->Cell(47, 10, utf8_decode('Descripción de Partículas'), 1, 0, 'C',TRUE);
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('ampolla'), 'LRB', 0, 'C',TRUE);
         $this->Cell(30, 5, utf8_decode('visibles'), 'LRB', 0, 'C',TRUE);
         $this->Cell(52.5, 10, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('ampolla'), 'LRB', 0, 'C',TRUE);
         $this->Cell(30, 5, utf8_decode('visibles'), 'LRB', 0, 'C',TRUE);
         $this->Ln(5);
         $this->SetFont('Arial', '', 9);
         $this->Cell(15, 5, utf8_decode('1'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('11'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('2'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('12'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('3'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('13'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('4'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('14'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('5'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('15'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('6'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('16'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('7'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('17'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('8'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('18'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('9'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('19'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(5);
         $this->Cell(15, 5, utf8_decode('10'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
         $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
         $this->Cell(15, 5, utf8_decode('20'), 'LRB', 0, 'C');
         $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
         $this->Cell(47, 5, utf8_decode(), 1, 0, 'C');
         $this->Ln(10);
         $this->seccionCumpleEspecificaciones();
         $this->Ln(0);
         $this->Cell(190, 5, utf8_decode('Verificado por:'), 1, 0, 'L');
         $this->Ln(10);
         $this->Cell(190, 5, utf8_decode('PARTÍCULAS VISIBLES MATERIA PRIMA'), 1, 0, 'C',TRUE);
         $this->Ln(5);
         $this->Cell(190, 5, utf8_decode('Partículas encontradas en la membrana o recipiente:'), 'LRT', 0, 'L');
         $this->Ln(5);

         $this->Cell(190, 15, utf8_decode(''), 'LRB', 0, 'L');
         $this->Ln(15);
         $this->seccionCumpleEspecificaciones();
         $this->Ln(0);
         $this->Cell(190, 5, utf8_decode('Verificado por:'), 1, 0, 'L');
         $this->Ln(5);

     }

     function finDocumentoSinReactivos(){
         $this->Cell(40, 5, ('Observaciones: '), 1, 0, 'L');
         $this->Cell(150, 5, (''), 1, 0, 'C');

         $this->ln(5);

         $this->Cell(190, 5, (''), 1, 0, 'C');

         $this->ln(5);

         $this->Cell(190, 5, (''), 1, 0, 'C');

         $this->ln(5);

         $this->Cell(190, 5, (''), 1, 0, 'C');
         $this->Ln(10);
         $this->secEquipos();

         $this->ln(10);

         $this->Cell(190, 5, ('Resultado fuera de especificaciones:'), 1, 0, 'L', false);

         $this->ln(5);

         $this->Cell(190, 5, utf8_decode('Verificación:'), 1, 0, 'L', false);

         $this->ln(10);



         $this->Cell(190, 5, ('Concepto'), 1, 0, 'L', false);

         $this->ln(5);

         $this->Cell(95, 5, ('[ ] Cumple con las especificaciones      '), "LTB", 0, 'R', false);
         $this->Cell(95, 5, ('      [ ] No cumple con las especificaciones'), "TRB", 0, 'L', false);

         $this->ln(5);
         $this->ln(5);
         $this->ln(5);

         $this->Cell(20, 5, ('Analizado por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

         $this->Cell(20, 5, ('Verificado por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

         $this->ln(5);
         $this->ln(5);
         $this->ln(5);
         $this->ln(5);

         $this->Cell(20, 5, ('Transcrito por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

         $this->Cell(20, 5, ('Aprobado por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);


     }

     function finDocumento(){
         $this->Cell(40, 5, ('Observaciones: '), 1, 0, 'L');
         $this->Cell(150, 5, (''), 1, 0, 'C');

         $this->ln(5);

         $this->Cell(190, 5, (''), 1, 0, 'C');

         $this->ln(5);

         $this->Cell(190, 5, (''), 1, 0, 'C');

         $this->ln(5);

         $this->Cell(190, 5, (''), 1, 0, 'C');
         $this->Ln(10);
         $this->secEquipos();
         $this->Ln(10);
         $this->secReactivos();
         $this->ln(10);
         $this->secEstandares();
         $this->ln(10);

         $this->Cell(190, 5, ('Resultado fuera de especificaciones:'), 1, 0, 'L', false);

         $this->ln(5);

         $this->Cell(190, 5, utf8_decode('Verificación:'), 1, 0, 'L', false);

         $this->ln(10);



         $this->Cell(190, 5, ('Concepto'), 1, 0, 'L', false);

         $this->ln(5);

         $this->Cell(95, 5, ('[ ] Cumple con las especificaciones      '), "LTB", 0, 'R', false);
         $this->Cell(95, 5, ('      [ ] No cumple con las especificaciones'), "TRB", 0, 'L', false);

         $this->ln(5);
         $this->ln(5);
         $this->ln(5);

         $this->Cell(20, 5, ('Analizado por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

         $this->Cell(20, 5, ('Verificado por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

         $this->ln(5);
         $this->ln(5);
         $this->ln(5);
         $this->ln(5);

         $this->Cell(20, 5, ('Transcrito por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);

         $this->Cell(20, 5, ('Aprobado por: '), 0, 0, 'L', false);
         $this->Cell(75, 5, ('_____________________________________________________'), 0, 0, 'L', false);


     }
//////////////////////////////////////////////////////////////////////////////////////////



    function informacionMuestra() {
        if (strstr($this->muestra['ensayosRealizar']['ensayosarealizar'], "Traza")) {
            $this->muestra['ensayosRealizar'] = 'Análisis de Trazas ';
        }
        $fechaLlegada = new DateTime($this->muestra['fecha_llegada']);
        $fechaAnalisis = new DateTime($this->muestra['fecha_analisis']);

        $this->muestra['des_area_analisis'];
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->Ln(5);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 5, utf8_decode('FECHA DE INGRESO'), 0, 0, 'C');
        $this->Cell(8, 5, utf8_decode(),  0, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 5, utf8_decode( $fechaLlegada->format('d-m-y')), 1, 0, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(15, 5, utf8_decode( ), 0, 0, 'C');
        $this->Cell(30, 5, utf8_decode('TIPO DE MUESTRA'), 0, 0, 'C');
        $this->Cell(15, 5, utf8_decode(), 0, 0, 'C');
        $this->Cell(30, 5, utf8_decode('No. DE LOTE'), 0, 0, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 5, utf8_decode( $this->muestra['lote']), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(83, 5, utf8_decode(), 0, 0, 'C');
        $this->Cell(30, 5, utf8_decode($this->muestra['FormaFarmaceutica']), 1, 0, 'C');
        $this->Ln(5);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 5, utf8_decode('FECHA DE ANÁLISIS'), 0, 0, 'C');
        $this->Cell(8, 5, utf8_decode(),  0, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 5, utf8_decode( $fechaAnalisis->format('d-m-y')), 1, 0, 'C');
        $this->Cell(45, 5, utf8_decode( ), 0, 0, 'C');
        $this->Cell(15, 5, utf8_decode( ), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(30, 5, utf8_decode('No. DE ANÁLISIS'), 0, 0, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 5,'18-'.substr($this->muestra['numeroCliente']['elnum'], 6, 4), 1, 0, 'C');
        $this->Ln(10);
        $this->SetX(20);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(51, 5, utf8_decode('DESCRIPCIÓN DE LA MUESTRA'), 0, 0, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(110, 5, utf8_decode($this->muestra['nombre_producto']), 1, 0, 'C');
        $this->Ln(10);
    }

    function plantillasEnsayos() {
        foreach ($this->muestra['ensayos'] as $ensayo) {
            $this->imprimirPlantillaEnsayo($ensayo);
        }
    }

    function imprimirPlantillaEnsayo($ensayo) {
        $plantilla = $ensayo["id_plantilla"];
        if ($plantilla == '8' || $plantilla == '9' || $plantilla == '195' || $plantilla == '2008' || $plantilla == '2364' || $plantilla == '286' || $plantilla == '2365' || $plantilla == '2362' || $plantilla == '72' || $plantilla == '1833' || $plantilla == '262') {
            $this->cuadroControlValoracion = true;
        }if ($plantilla == '6' || $plantilla == '31' || $plantilla == '1848' || $plantilla == '2361') {
            $this->cuadroControlDisolucion = true;
        }if ($plantilla == '19') {
            $this->cuadroControlPureza = true;
        }


        /* if ($plantilla == 8 || $plantilla == 18 || $plantilla == 9 || $plantilla == 10 || $plantilla == 195 || $plantilla == 1821 || $plantilla == 2008 || $plantilla == 2364 || $plantilla == 31 || $plantilla == 129 || $plantilla == 1848 || $plantilla == 2361 || $plantilla == 34 || $plantilla == 62 || $plantilla == 323 || $plantilla == 2127 || $plantilla == 2365 || $plantilla == 286) {
          $this->cuadroControlPlantilla = true;
          } else if ($plantilla == 262) {
          $this->cuadroControlPlantilla = true;
          $this->cuadroControlEstandar = true;
          } */

        $exp_regular = array();
        $exp_regular[0] = '/<br>/';
        $exp_regular[1] = '/<div>/';
        $exp_regular[2] = '/<\/div>/';
        $exp_regular[3] = '/<o:p>/';
        $exp_regular[4] = '/&nbsp;/';
        $exp_regular[5] = '/&lt;/';
        $exp_regular[6] = '/<\/sup>/';
        $exp_regular[7] = '/<\/p>/';
        $exp_regular[8] = '/<sup>/';
        $exp_regular[9] = '/<p>/';
        $exp_regular[10] = '/<sup>/';
        $exp_regular[11] = '/<p class="MsoNormal">/';
        $exp_regular[12] = '/<\/o:p>/';
        $exp_regular[13] = '/≤/';
        $exp_regular[14] = '/–/';

//Array de los textos en la sustitucion
        $cadena_nueva = array();
        $cadena_nueva[0] = "\r\n";
        $cadena_nueva[1] = "\r";
        $cadena_nueva[2] = '';
        $cadena_nueva[3] = '';
        $cadena_nueva[4] = '';
        $cadena_nueva[5] = "<";
        $cadena_nueva[6] = '';
        $cadena_nueva[7] = '';
        $cadena_nueva[8] = '';
        $cadena_nueva[9] = '';
        $cadena_nueva[10] = '';
        $cadena_nueva[11] = '';
        $cadena_nueva[12] = '';
        $cadena_nueva[13] = '<=';
        $cadena_nueva[14] = '-';

        $especificacion = preg_replace($exp_regular, $cadena_nueva, $ensayo["especificacion"]);
        $desEnsayo = $ensayo["desEspecifica"];
        $tipoMuestra = $ensayo["id_formula_farma"];

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(189, 6, utf8_decode($desEnsayo . ' (' . $ensayo['des_metodo'] . ')'), 1, 0, 'C', True); // True permite que asigne el color
        $this->SetFont('Arial', '', 9);
        $this->Ln(6);

        if ($plantilla == '2') {
            $this->Cell(189, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
        }

        if ($plantilla == '3') {
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(139, 6, utf8_decode('Cantidad / Tamaño partícula'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 4, utf8_decode('No. captura '), 'LRT', 0, 'C');
            $this->Cell(70, 8, utf8_decode('10 - 24  (um)'), 1, 0, 'C');
            $this->Cell(69, 8, utf8_decode('25 - 100  (um)'), 1, 0, 'C');
            $this->Ln(4);
            $this->Cell(50, 4, utf8_decode('de imagen'), 'LRB', 0, 'C');
            $this->Cell(70, 4, utf8_decode(''), 0, 0, 'C');
            $this->Cell(69, 4, utf8_decode(''), 0, 0, 'C');
            $this->Ln(4);
            $this->Cell(50, 6, utf8_decode('1'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('2'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('3'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('4'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('5'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('6'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('7'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('8'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('TOTAL'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(69, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $y = $this->GetY();
            $x = $this->GetX();
            $this->Cell(100, 40, utf8_decode(''), 1, 0, 'C');
            $this->Image('../../views/images/conteoMicroscopico.png', $x + 30 , $y + 5, 30);
            $this->Cell(80, 40, utf8_decode(''), 1, 0, 'C');
            $this->Ln(0);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(89, 7, utf8_decode('Demarcación del cuadrante'), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(89, 7, utf8_decode(''), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(89, 7, utf8_decode('A'), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(89, 7, utf8_decode('B'), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(89, 6, utf8_decode('C'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(100, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(89, 6, utf8_decode('D'), 1, 0, 'C');
            $this->Ln(6);
        }

        if ($plantilla == '4') {
            $this->Cell(59, 6, utf8_decode('No. Vial o ampolla'), 1, 0, 'C', TRUE);
            $this->Cell(65, 6, utf8_decode('No. Partículas visibles'), 1, 0, 'C', TRUE);
            $this->Cell(65, 6, utf8_decode('Descripción de partículas'), 1, 0, 'C', TRUE    );
            $this->Ln(6);
            $numero = 1;
            for ($i = 1; $i <= 20; $i++){
                $this->Cell(59, 6, utf8_decode($numero), 1, 0, 'C');
                $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
                $this->Ln(6);
                $numero++;
            }

        }

        if ($plantilla == '5') {
            $this->Cell(189, 6, utf8_decode('Partículas encontradas en la membrana o recipiente:'), 'LRT', 0, 'L');
            $this->Ln(6);
            $this->Cell(189, 15, utf8_decode(''), 'LRB', 0, 'C');
            $this->Ln(15);
        }

        if ($plantilla == '6') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(29, 12, utf8_decode('Especificación'), 1, 0, 'L');
            $this->Cell(70, 6, utf8_decode('No más de 20 partículas con un tamaño <= de 10 um '), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode('Partículas encontradas <= 10 um'), 1, 0, 'L');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(29, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(70, 6, utf8_decode('No más de 5 partículas con un tamaño <= de 25 um '), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode('Partículas encontradas <= 25 um'), 1, 0, 'L');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
        }

        if ($plantilla == '7') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(29, 6, utf8_decode('Peso inicial'), 1, 0, 'L');
            $this->Cell(100, 6, utf8_decode('Erlenmeyer + Tapón + Agua'), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(29, 6, utf8_decode('Peso final'), 1, 0, 'L');
            $this->Cell(100, 6, utf8_decode('Erlenmeyer + Tapón + Agua agregada hasta completar el peso inicial'), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
        }

        if ($plantilla == '8') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(89, 10, utf8_decode('N° de fragmentos visibles en la superficie  del filtro:'), 1, 0, 'C');
            $this->Cell(100, 10, utf8_decode(''), 1, 0, 'L');
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '9' || $plantilla == '10' || $plantilla == '14') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '11') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->Cell(63, 6, utf8_decode('Peso muestra (M)'), 1, 0, 'C');
            $this->Cell(63, 6, utf8_decode('Volumen aparente (V)'), 1, 0, 'C');
            $this->Cell(63, 6, utf8_decode('Volumen aparente (V)'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 2; $i++){
                $this->Cell(63, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(63, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(63, 10, utf8_decode(''), 1, 0, 'C');
                $this->Ln(10);
            }
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '12') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(189, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->Cell(36, 6, utf8_decode('Volumen (V10)'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Volumen (V50)'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Volumen (V100)'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Promedio (V10, V50, V100) / n'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Densidad (M / Vf)'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 2; $i++){
                $this->Cell(36, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(36, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(36, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(36, 10, utf8_decode(''), 1, 0, 'C');
                $this->Ln(10);
            }
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 6, utf8_decode('Altura de caída de probeta:'), 1, 0, 'L');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '13') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->Cell(49, 6, utf8_decode('Peso'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Dilución'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Solvente'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('Clasificación'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 4; $i++){
                $this->Cell(49, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(50, 10, utf8_decode(''), 1, 0, 'C');
                $this->Ln(10);
            }
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '15') {
            $this->SetFont('Arial', 'B', 9);

            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(53, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('1. ASPECTO GENERAL DE LA ENTREGA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Empaque y embalaje: seguro, limpio '), 'LRT', 0, 'L');
            $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('y en buenas condiciones.'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Identificación: N°. lote, referencia.'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Mezclas (Tamaño, color, tipo de material)'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('2. ASPECTO DEL MATERIAL'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan la apariencia'), 'LRT', 0, 'L');
            $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('(rugosidades, fisuras, incrustaciones, otros.)'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan el uso (Maquinabilidad)'), 'LRT', 0, 'L');
            $this->Cell(38, 18, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 18, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 18, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode(' rebabas, deformes, descentrado, grietas, despicado,'), 'LR', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('pliegues, otros)'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad interior o exterior removible con un '), 'LRT', 0, 'L');
            $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('proceso adicional de limpieza'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad interior no removible'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad exterior no removible'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('3. DIMENSIONES'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Diámetro del cuerpo'), 1, 0, 'L');
            $this->Cell(38, 30, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro exterior de la boca'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro interior de la boca'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura total'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura de la pestaña'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);

            $this->Cell(30, 5, utf8_decode('Observaciones: '), 'LBT', 0, 'C');
            $this->Cell(159 , 5, utf8_decode(''), 'RBT', 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(5);
            $this->Cell(95, 6, ('GCC-01-FR-035-1'), 0, 0, 'L');
            $this->Cell(94, 6, ('GCC-01-FR-035-1'), 0, 0, 'R');
            $this->Ln(10);
        }

        if ($plantilla == '16') {
            $this->SetFont('Arial', 'B', 9);

            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(45, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 24, utf8_decode('INSERTO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y empaque'), 1, 0, 'C',true);
            $this->Cell(45, 6, utf8_decode('Limpio, identificado, sin '), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor '), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('rayones ni perforaciones.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Textos del arte'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Debe ser legible y coincidir con'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('la información del arte aprobado'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(45, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 96, utf8_decode('CAJA'), 1, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Color'), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Desgaste a la Fricción'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('La impresión no se corre (no'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('mancha) ni se desgasta '), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('(no se borra).'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Espesor del Cartón'), 1, 0, 'C', TRUE);
            $this->Cell(45, 12, utf8_decode('Mayor que 0,37 mm '), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode('PLEGADIZA'), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y Empaque'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Limpio, identificado, sin rayones'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('ni perforaciones.'), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Dimensiones'), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('arte y/o especificación de'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('cada material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Textos del Arte'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Debe ser legible y coincidir con'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('la información del arte'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('aprobado.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(45, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 72, utf8_decode('CAJA'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Espesor del Cartón'), 1, 0, 'C', TRUE);
            $this->Cell(45, 12, utf8_decode('Mayor que 3,5 mm'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Funcionalidad'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('No se debe despegar por '), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('ninguno de sus lados.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y Empaque '), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('Limpio, identificado, sin'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('rayones ni perforaciones.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode('CORRUGA'), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Textos del Arte'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Debe ser legible y coincidir'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('con la información del arte'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('aprobado.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Dimensiones'), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(45, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 210, utf8_decode('ETIQUETA'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y Empaque'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Limpio, identificado, sin'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('rayones ni perforaciones.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Textos del Arte'), 1, 0, 'C',TRUE);
            $this->Cell(45, 6, utf8_decode('Debe ser legible y coincidir'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('con la información del arte'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('aprobado.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Color'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Desgaste a la Fricción'), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('La impresión no se corre (no'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('mancha) ni se desgasta '), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('(no se borra).'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Dimensiones'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Reserva de Brillo'), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('Mínimo 10 mm medido desde'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('el borde.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Distancia entre Etiquetas'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Mínimo 3 mm entre una y otra,'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('la distancia se debe mantener'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('constante.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Adhesivo de Seguridad'), 1, 0, 'C', TRUE);
            $this->Cell(45, 6, utf8_decode('Al momento de retirarla, la'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('etiqueta debe romperse dejando'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('fragmentos adheridos al vidrio.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Sentido de Bobinado'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('La punta del rollo sale en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Critico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('sentido de giro de las'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode('manecillas del reloj.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 36, utf8_decode('Altura Cinta'), 'LRT', 0, 'C',TRUE);
            $this->Cell(45, 6, utf8_decode('Según las dimensiones de'), 'LRT', 0, 'C');
            $this->Cell(26, 36, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 36, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 36, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 30, utf8_decode('Porta-Etiquetas'), 'LRB', 0, 'C',TRUE);
            $this->Cell(45, 6, utf8_decode('las etiquetas así'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(22.5, 12, utf8_decode('Etiqueta'), 1, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode('Altura cinta'), 'LRT', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode('Porta-Etiquetas'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode('58 mm*28 mm'), 1, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode('24 mm-31 mm'), 1, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode('72 mm*42 mm'), 1, 0, 'C');
            $this->Cell(22.5, 6, utf8_decode('43 mm-45 mm'), 1, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Troquelado de la Cinta'), 'LRT', 0, 'C');
            $this->Cell(45, 6, utf8_decode('Mínimo 10 mm medido desde'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Porta-Etiquetas'), 'LRB', 0, 'C');
            $this->Cell(45, 6, utf8_decode('el borde.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Diámetro Del Buje'), 1, 0, 'C',TRUE);
            $this->Cell(45, 12, utf8_decode('41 mm ó 76 mm .'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(45, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(15);
            $this->SetX(56);
            $this->Cell(99, 15, utf8_decode(), 'LRT', 0, 'C');
            $this->Ln(15);
            $this->SetX(56);
            $this->Cell(99, 5, utf8_decode('PEGUE UNA   ETIQUETA EN ESTE ESPACIO, O ADJUNTE UNA MUESTRA DE'), 'LR', 0, 'C');
            $this->Ln(5);
            $this->SetX(56);
            $this->Cell(99, 5, utf8_decode('LA PLEGADIZA O DEL INSERTO AL RESPALDO'), 'LR', 0, 'C');
            $this->Ln(5);
            $this->SetX(56);
            $this->Cell(99, 15, utf8_decode(''), 'LRB', 0, 'C');
            $this->Ln(20);
            $this->SetFont('Arial', 'B', 9);

            $this->Cell(30, 5, utf8_decode('Observaciones: '), 'LBT', 0, 'C');
            $this->Cell(159 , 5, utf8_decode(''), 'RBT', 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(5);
            $this->Cell(95, 6, ('GCC-01-FR-033-1'), 0, 0, 'L');
            $this->Cell(94, 6, ('GCC-01-FR-033-1'), 0, 0, 'R');
            $this->Ln(10);
        }

        if ($plantilla == '17') {
            $this->SetFont('Arial', 'B', 9);

            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(53, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('1. ASPECTO GENERAL DE LA ENTREGA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Empaque y embalaje: seguro, limpio '), 'LRT', 0, 'L');
            $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('y en buenas condiciones.'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Identificación: N°. lote, referencia.'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Mezclas (Tamaño, color, tipo de material)'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('2. ASPECTO DEL MATERIAL'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan la apariencia'), 'LRT', 0, 'L');
            $this->Cell(38, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('(rugosidades, fisuras, incrustaciones, otros.)'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan el uso (Maquinabilidad)'), 'LRT', 0, 'L');
            $this->Cell(38, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 18, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 18, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode(' rebabas, deformes, descentrado, grietas, despicado,'), 'LR', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('pliegues, otros)'), 'LRB', 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(38, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad Removible y No Removible'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Color no característico'), 1, 0, 'L');
            $this->Cell(38, 6, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(38, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();

            $this->Ln(0);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 6, utf8_decode('3. DIMENSIONES'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(20, 36, utf8_decode('Tapón'), 1, 0, 'C');
            $this->Cell(42, 6, utf8_decode(), 1, 0, 'C', TRUE);
            $this->Cell(32, 6, utf8_decode('ESPECIFICACIONES'), 1, 0, 'C', TRUE);
            $this->Cell(95, 6, utf8_decode(), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Altura total'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(), 1, 0, 'L');
            $this->Cell(22, 30, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Altura de la tapa'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Altura del cono'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Diámetro de la tapa'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Diámetro del cono'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(20, 36, utf8_decode('Tapón'), 1, 0, 'C');
            $this->Cell(42, 6, utf8_decode(), 1, 0, 'C', TRUE);
            $this->Cell(32, 6, utf8_decode('ESPECIFICACIONES'), 1, 0, 'C', TRUE);
            $this->Cell(95, 6, utf8_decode(), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(20, 5, utf8_decode(), 0, 0, 'C');
            $this->SetFont('Arial', '', 7);
            $this->Cell(42, 6, utf8_decode('Diámetro exterior'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(22, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Diámetro interior'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Altura Total'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Calibre de lamina'), 1, 0, 'L');
            $this->Cell(32, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(22, 6, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(53, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
        }

        if ($plantilla == '18') {
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(49, 6, utf8_decode('ACTIVIDAD'), 1, 0, 'C', TRUE);
            $this->Cell(80, 6, utf8_decode('REALIZADO POR'), 1, 0, 'C', TRUE);
            $this->Cell(30, 6, utf8_decode('FECHA'), 1, 0, 'C', TRUE);
            $this->Cell(30, 6, utf8_decode('SANITIZANTE'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(27, 12, utf8_decode('Sanitización'), 1, 0, 'C', TRUE);
            $this->Cell(22, 6, utf8_decode('Loop 1'), 1, 0, 'C', TRUE);
            $this->Cell(80, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(27, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(22, 6, utf8_decode('Loop 2'), 1, 0, 'C', TRUE);
            $this->Cell(80, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);

            $this->Cell(84, 12, utf8_decode('PUNTO DE MUESTREO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('CONDUCTIVIDAD'), 1, 0, 'C');
            $this->Cell(20, 12, utf8_decode('pH'), 1, 0, 'C');
            $this->Cell(20, 12, utf8_decode('TOC'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CONCEPTO*'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(154, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(17, 6, utf8_decode('C'), 1, 0, 'C');
            $this->Cell(18, 6, utf8_decode('N.C'), 1, 0, 'C');
            $this->Ln(-6);
            foreach ($this->muestra['ensayos'] as $ensayo){
                $this->Ln(12);
                $this->SetFont('Arial', '', 8);
                $this->Cell(84, 12, utf8_decode($ensayo['descripcionEnsayo']), 1, 0, 'C');
                $this->Cell(30, 12, utf8_decode(), 1, 0, 'C');
                $this->Cell(20, 12, utf8_decode(), 1, 0, 'C');
                $this->Cell(20, 12, utf8_decode(), 1, 0, 'C');
                $this->Cell(35, 12, utf8_decode(), 1, 0, 'C');
            }
            $this->Ln(12);
            $this->Cell(189, 6, utf8_decode('*C: Cumple     *N.C: No cumple'), 1, 0, 'C');
            $this->Ln(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('pH'), 1, 0, 'C',TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(149, 6, utf8_decode('5,0 - 7,0'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('TOC'), 1, 0, 'C',TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(149, 6, utf8_decode('< 500 ppb'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 5, utf8_decode('Especificaciones'), 'LRT', 0, 'C',TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(30, 5, utf8_decode('ETAPA 1: 1,3 µS / cm'), 'LRT', 0, 'C');
            $this->SetFont('Arial', '', 7);

            $this->Cell(59.5, 5, utf8_decode('ETAPA 2: 2,1  µS / cm compensadas por'), 'LRT', 0, 'C');
            $this->Cell(59.5, 5, utf8_decode('ETAPA 3: Depende del pH. Rango de 5,0 - 7,0.'), 'LRT', 0, 'C');

            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('conductividad USP 645'), 'LRB', 0, 'C',TRUE);
            $this->SetFont('Arial', '', 7);
            $this->Cell(30, 6, utf8_decode('temperatura a 25 °C'), 'LRB', 0, 'C');
            $this->Cell(59.5, 6, utf8_decode(' 25°C o no compensadas por temperatura'), 'LRB', 0, 'C');
            $this->Cell(59.5, 6, utf8_decode('Tabla 2. Etapa 3 Requisitos de pH y conductividad'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('Límites de alerta'), 'LRT', 0, 'C', TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(74.5, 12, utf8_decode('ETAPA 1: 1,0 uS / cm  en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Cell(74.5, 12, utf8_decode('ETAPA 2: 1,9  uS / cm en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('conductividad'), 'LRB', 0, 'C', TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(74.5, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(74.5, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('Límites de acción'), 'LRT', 0, 'C', TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(149, 12, utf8_decode('Límite de acción: max 2,0 uS / cm en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('conductividad'), 'LRB', 0, 'C', TRUE);
            $this->Cell(74.5, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 12, utf8_decode('Límites de TOC'), 1, 0, 'C', TRUE);
            $this->SetFont('Arial', '', 8);
            $this->Cell(74.5, 6, utf8_decode('Límite de alerta: máximo 400 ppb en tres o mas puntos'), 'LRT', 0, 'C');
            $this->Cell(74.5, 6, utf8_decode('Límite de acción: máximo 450 ppb en tres o mas puntos'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(40, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(74.5, 6, utf8_decode('un mismo día'), 'LRB', 0, 'C');
            $this->Cell(74.5, 6, utf8_decode('un mismo día'), 'LRB', 0, 'C');
            $this->Ln(12);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(30, 5, utf8_decode('Observaciones: '), 'LBT', 0, 'C');
            $this->Cell(159 , 5, utf8_decode(''), 'RBT', 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(5);
            $this->Cell(95, 6, ('GCC-04-FR-054-1'), 0, 0, 'L');
            $this->Cell(94, 6, ('GCC-01-FR-054-1'), 0, 0, 'R');
            $this->Ln(24    );


        }


        /*if ( $plantilla == '17') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(180, 6, utf8_decode('Equipos o instrumentos de medida: '), 1, 0, 'L');
            $this->Ln(6);
        }*/
        /*if ($plantilla == '18') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(30, 6, utf8_decode('Límites de alerta'), 'LRT', 0, 'C', TRUE);
            $this->Cell(75, 12, utf8_decode('ETAPA 1: 1,0 uS / cm  en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Cell(75, 12, utf8_decode('ETAPA 2: 1,9  uS / cm en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('conductividad'), 'LRB', 0, 'C', TRUE);
            $this->Cell(75, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(75, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('Límites de acción'), 'LRT', 0, 'C', TRUE);
            $this->Cell(150, 12, utf8_decode('Límite de acción: max 2,0 uS / cm en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('conductividad'), 'LRB', 0, 'C', TRUE);
            $this->Cell(75, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 12, utf8_decode('Límites de TOC'), 1, 0, 'C', TRUE);
            $this->Cell(75, 6, utf8_decode('Límite de alerta: máximo 400 ppb en tres o mas puntos'), 'LRT', 0, 'C');
            $this->Cell(75, 6, utf8_decode('Límite de acción: máximo 450 ppb en tres o mas puntos'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(75, 6, utf8_decode('un mismo día'), 'LRB', 0, 'C');
            $this->Cell(75, 6, utf8_decode('un mismo día'), 'LRB', 0, 'C');
            $this->Ln(6);
        }*/

        if ($plantilla == '19') {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(20  , 5, utf8_decode('ÍTEM'), 1, 0, 'C');
            $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
            $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Ln(5 );
            $this->SetFont('Arial', '', 8);

            $this->Cell(20, 5, utf8_decode(), 'LTR', 0, 'C');
            $this->Cell(73, 5, utf8_decode('USPv (381) Tapones Elastoméricos para Inyectables   '), 'LTR', 0, 'C');
            $this->Cell(30, 5, utf8_decode('Fragmentación'), 'LTR', 0, 'C');
            $this->Cell(66, 5, utf8_decode('No hay más de cinco fragmentos visibles. '), 'LTR', 0, 'C');

            $this->Ln(5 );
            $this->Cell(20, 5, utf8_decode('1'), 'LR', 0, 'C');
            $this->Cell(73, 5, utf8_decode('Método interno GCC-04-IN-002. '), 'LR', 0, 'C');
            $this->Cell(30, 5, utf8_decode('Capacidad de'), 'LTR', 0, 'C');
            $this->Cell(66, 5, utf8_decode('Ninguno de los viales contiene'), 'LTR', 0, 'C');
            $this->Ln(5 );
            $this->Cell(20, 5, utf8_decode(), 'LBR', 0, 'C');
            $this->Cell(73, 5, utf8_decode(), 'LBR', 0, 'C');
            $this->Cell(30, 5, utf8_decode('autosellado'), 'LBR', 0, 'C');
            $this->Cell(66, 5, utf8_decode('vestigios de solución azul.'), 'LBR', 0, 'C');

           $this->Ln(10);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 6, utf8_decode('PREPARACIÓN DE LAS MUESTRAS DE TAPON PARA LAS PRUEBAS DE FRAGMENTACIÓN Y CAPACIDAD DE AUTOSELLADO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(50, 12, utf8_decode('Peso inicial'), 1, 0, 'C');
            $this->Cell(70, 12, utf8_decode('Erlenmeyer + Tapón + Agua'), 1, 0, 'C');
            $this->Cell(69, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(12);
            $this->Cell(50, 6, utf8_decode('Peso'), 'LTR', 0, 'C');
            $this->Cell(70, 6, utf8_decode('Erlenmeyer + Tapón + Agua agregada'), 'LTR', 0, 'C');
            $this->Cell(69, 6, utf8_decode(), 'LTR', 0, 'C');

            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('final'), 'LBR', 0, 'C');
            $this->Cell(70, 6, utf8_decode('hasta completar el peso inicial'), 'LBR', 0, 'C');
            $this->Cell(69, 6, utf8_decode(), 'LBR', 0, 'C');

            $this->Ln(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 6, utf8_decode('PRUEBA DE FRAGMENTACIÓN'), 1, 0, 'C',TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(70, 12, utf8_decode('N° de fragmentos visibles en la superficie  del filtro:'), 'LBR', 0, 'C');
            $this->Cell(119, 12, utf8_decode(), 'LBR', 0, 'C');
            $this->Ln(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 6, utf8_decode('RESULTADO  DEL ENSAYO'), 1, 0, 'C',TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(8);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 6, utf8_decode('PRUEBA DE FRAGMENTACIÓN'), 1, 0, 'C',TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(189, 18, utf8_decode(), 'LBR', 0, 'C');
            $this->Ln(18);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(8);
            $this->SetFont('Arial', 'B', 9);

            $this->Cell(30, 5, utf8_decode('Observaciones: '), 'LBT', 0, 'C');
            $this->Cell(159 , 5, utf8_decode(''), 'RBT', 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(5);
            $this->Cell(95, 6, ('GCC-04-FR-058-1 '), 0, 0, 'L');
            $this->Cell(94, 6, ('GCC-04-FR-058-1 '), 0, 0, 'R');
            $this->Ln(12);

        }


        if ($plantilla == '20') {
            $this->SetFont('Arial', 'B', 9);
            $this->Ln(4);
            $this->Cell(189, 6, utf8_decode('ENSAYO CRISTALINIDAD'), 0, 0, 'C', TRUE);
            $this->Ln(12);
            $this->Cell(189, 6, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(20  , 5, utf8_decode('ÍTEM'), 1, 0, 'C');
            $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
            $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Ln(5 );
            $this->SetFont('Arial', '', 8);

            $this->Cell(20, 5, utf8_decode(), 'LTR', 0, 'C');
            $this->Cell(73, 5, utf8_decode(' (USPv <776> Microscopía óptica)   '), 'LTR', 0, 'C');
            $this->Cell(96, 5, utf8_decode('Las partículas presentan birrefrigencia (interferencia de colores) '), 'LTR', 0, 'C');

            $this->Ln(5 );
            $this->Cell(20, 5, utf8_decode('1'), 'LR', 0, 'C');
            $this->Cell(73, 5, utf8_decode('Método interno GCC-04-IN-002'), 'LR', 0, 'C');
            $this->Cell(96, 5, utf8_decode('y posiciones de extinción.'), 'LR', 0, 'C');
            $this->Ln(5 );
            $this->Cell(20, 5, utf8_decode(), 'LBR', 0, 'C');
            $this->Cell(73, 5, utf8_decode(), 'LBR', 0, 'C');
            $this->Cell(96, 5, utf8_decode(), 'LBR', 0, 'C');
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 6, utf8_decode('PRUEBA DE CRISTANILIDAD'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(189, 12, utf8_decode(), 1, 0, 'C');
            $this->Ln(12);
            $this->Cell(189, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 8);

            $this->Cell(189, 6, utf8_decode('ENSAYO DENSIDAD APARENTE Y POR ASENTAMIENTO'), 0, 0, 'C', TRUE);
            $this->Ln(12);
            $this->Cell(20  , 5, utf8_decode('ÍTEM'), 1, 0, 'C');
            $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C');
            $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Ln(5 );
            $this->SetFont('Arial', '', 8);

            $this->Cell(20, 5, utf8_decode(), 'LTR', 0, 'C');
            $this->Cell(73, 5, utf8_decode('(USPv <616> Densidad aparente y densidad por '), 'LTR', 0, 'C');
            $this->Cell(96, 5, utf8_decode(), 'LTR', 0, 'C');

            $this->Ln(5 );
            $this->Cell(20, 5, utf8_decode('1'), 'LR', 0, 'C');
            $this->Cell(73, 5, utf8_decode(' asentamiento de los polvos) Método '), 'LR', 0, 'C');
            $this->Cell(96, 5, utf8_decode('Informativo'), 'LR', 0, 'C');
            $this->Ln(5 );
            $this->Cell(20, 5, utf8_decode(), 'LBR', 0, 'C');
            $this->Cell(73, 5, utf8_decode('interno GCC-04-IN-002.'), 'LBR', 0, 'C');
            $this->Cell(96, 5, utf8_decode(), 'LBR', 0, 'C');

            $this->Ln(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(190, 6, utf8_decode('PRUEBA DENSIDAD APARENTE'), 1, 0, 'C',TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(189, 10, utf8_decode(''), 'LBR', 0);
            $this->Ln(0);
            $this->Cell(63, 6, utf8_decode('Peso muestra (M)'), 1, 0, 'C');
            $this->Cell(63, 6, utf8_decode('Volumen aparente (V)'), 1, 0, 'C');
            $this->Cell(64, 6, utf8_decode('Densidad M / V'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(63, 10, utf8_decode(''), 1, 0, 'C');
            $this->Cell(63, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(64, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->Cell(63, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(63, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(64, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->Cell(190, 5, utf8_decode('Resultado:'), 1, 0, 'L');
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(190, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(190, 6, utf8_decode('PRUEBA DENSIDAD POR ASENTAMIENTO'), 1, 0, 'C',TRUE);
            $this->Ln(6);
            $this->MultiCell(190, 12, utf8_decode(), 1, 0);
            $this->Ln(0);
            $this->SetFont('Arial', '', 8);
            $this->Cell(35, 6, utf8_decode('Volumen (V10)'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('Volumen (V50)'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Volumen (V100)'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Promedio (V10, V50, V100) / n'), 1, 0, 'C');
            $this->Cell(39, 6, utf8_decode('Densidad (M / Vf)'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(36, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(45, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(39, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(36, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(45, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(39, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->Cell(190, 5, utf8_decode('Altura de caída de probeta:'), 1, 0, 'L');
            $this->Ln(5);
            $this->Cell(190, 5, utf8_decode('Resultado:'), 1, 0, 'L');
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(190, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(190, 5, utf8_decode('ENSAYO DE SOLUBILIDAD'), 0, 0, 'C',TRUE);
            $this->Ln(10);
            $this->Cell(190, 5, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(20, 5, utf8_decode('ÍTEM'), 1, 0, 'C',TRUE);
            $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C',TRUE);
            $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->Cell(20, 10, utf8_decode('1'), 1, 0, 'C');
            $this->Cell(73, 10, utf8_decode('Método interno GCC-04-IN-002'), 1, 0, 'C');
            $this->Cell(96, 10, utf8_decode('Informativo'), 1, 0, 'C');
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 5, utf8_decode('PRUEBA SOLUBILIDAD'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(189, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->SetFont('Arial', '', 8);
            $this->Cell(35, 5, utf8_decode('PESO'), 1, 0, 'C');
            $this->Cell(35, 5, utf8_decode('DILUCIÓN'), 1, 0, 'C');
            $this->Cell(35, 5, utf8_decode('SOLVENTE'), 1, 0, 'C');
            $this->Cell(84, 5, utf8_decode('CLASIFICACIÓN'), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(84, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(35, 10, utf8_decode(), 1, 0, 'C');
            $this->Cell(84, 10, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 5, utf8_decode('ENSAYO DE JERINGABILIDAD'), 0, 0, 'C',TRUE);

            $this->Ln(10);
            $this->Cell(189, 5, utf8_decode('ENSAYO A REALIZAR'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(20, 5, utf8_decode('ÍTEM'), 1, 0, 'C',TRUE);
            $this->Cell(73, 5, utf8_decode('MÉTODO'), 1, 0, 'C',TRUE);
            $this->Cell(96, 5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->Cell(20, 10, utf8_decode('1'), 1, 0, 'C');
            $this->Cell(73, 10, utf8_decode('Método interno GCC-04-IN-002'), 1, 0, 'C');
            $this->SetFont('Arial', '', 7);
            $this->Cell(96, 10, utf8_decode('Fácilmente extraible con jeringa hipodermica No 20 después de su reconstitución'), 1, 0, 'C');
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 5, utf8_decode('PRUEBA JERINGABILIDAD'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(189, 15, utf8_decode(), 1, 0, 'C');
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 5, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 8);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(189, 5, utf8_decode('PARTÍCULAS EN INYECTABLES'), 0 , 0, 'C',TRUE);
            $this->Ln(10);
            $this->Cell(189, 5, utf8_decode('ENSAYO A REALIZAR'), 1 , 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(95, 5, utf8_decode('MÉTODO'), 1 , 0, 'C',TRUE);
            $this->Cell(94, 5, utf8_decode('ESPECIFICACIÓN'), 1 , 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 7);
            $this->Cell(95, 5, utf8_decode('USPv <788> Partículas en inyectables, método 2 Prueba de conteo microscópico'), 'LRT' , 0, 'C');
            $this->SetFont('Arial', '', 8);
            $this->Cell(25, 5, utf8_decode('>= 10 µm '), 1 , 0, 'C');
            $this->Cell(69, 5, utf8_decode('No excede 3000 partículas por envase'), 1 , 0, 'C');
            $this->Ln(5);
            $this->SetFont('Arial', '', 7);

            $this->Cell(95, 5, utf8_decode('de partículas.GCC-04-IN-001 – Determinación de partículas en inyectables '), 'LRB', 0, 'C');
            $this->Cell(25, 5, utf8_decode('>= 25 µm'), 1 , 0, 'C');
            $this->SetFont('Arial', '', 8);

            $this->Cell(69, 5, utf8_decode('No excede 300 partículas por envase'), 1 , 0, 'C');

            $this->Ln(5);
            $this->Cell(95, 5, utf8_decode(''), 'LRT', 0, 'L');
            $this->Cell(94, 5, utf8_decode('Producto terminado: Máximo 2 viales pueden contener partículas visibles.  '), 'LRT', 0, 'L');

            $this->Ln(5);
            $this->Cell(95, 5, utf8_decode('USPv <790> Partículas visibles en inyectables, procedimiento de'), 'LR', 0, 'L');
            $this->Cell(94, 5, utf8_decode('Materia prima soluble: Máximo 2 partículas visibles se observan en la '), 'LR', 0, 'L');

            $this->Ln(5);
            $this->Cell(95, 5, utf8_decode('inspección GCC-04-IN-001 – Determinación de partículas en inyectables'), 'LR', 0, 'L');
            $this->Cell(94, 5, utf8_decode('membrana.'), 'LR', 0, 'L');

            $this->Ln(5);
            $this->Cell(95, 5, utf8_decode(''), 'LR', 0, 'L');
            $this->Cell(94, 5, utf8_decode('Materia prima suspensión: Máximo 2 partículas se observan en el fondo.'), 'LR', 0, 'L');

            $this->Ln(5);
            $this->Cell(95, 5, utf8_decode(''), 'LRB', 0, 'L');
            $this->Cell(94, 5, utf8_decode('del recipiente'), 'LRB', 0, 'L');

            $this->Ln(10);
            $this->Cell(189, 6, utf8_decode('PRUEBA DE BLANCO - APTITUD DEL SISTEMA USPv <788>'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(30, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(75, 6, utf8_decode('No más de 20 partículas con un tamaño < de 10 μm'), 1, 0, 'C');
            $this->Cell(55, 6, utf8_decode('Partículas encontradas < 10 µm'), 1, 0, 'C');
            $this->Cell(29, 6, utf8_decode(), 1, 0, 'C');

            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode(), 0, 0, 'L');
            $this->Cell(75, 6, utf8_decode('No más de 5 partículas con un tamaño ≤ de 25 μm'), 1, 0, 'C');
            $this->Cell(55, 6, utf8_decode('Partículas encontradas < 25 µm'), 1, 0, 'C');
            $this->Cell(29, 6, utf8_decode(), 1, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->Cell(189, 6, utf8_decode('Verificado por: '), 1, 0, 'L');
            $this->Ln(12);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('DESCRIPCIÓN DE LA PREPARACIÓN DE LA MUESTRA'), 1, 0, 'C',TRUE);
            $this->Ln(6);
            $this->Cell(189, 15, utf8_decode(), 1, 0, 'C');
            $this->Ln(20);
            $this->Cell(189, 6, utf8_decode('CONTEO MICROSCÓPICO  USPv <788>'), 1, 0, 'C',TRUE);
            $this->Ln(10);
            $this->SetFont('Arial', '', 8);

            $this->Cell(32, 8, utf8_decode(), 0, 0, 'C');
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(60, 8, utf8_decode('Cantidad / Tamaño partícula'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(20, 4, utf8_decode('Demarcación del'), 0, 0, 'C');
            $this->Ln(4);
            $this->Cell(162, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(20, 4, utf8_decode('cuadrante'), 0, 0, 'C');
            $this->Ln(8);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('No. Captura de imagen'), 1, 0, 'C',TRUE);
            $this->Cell(30, 6, utf8_decode('10 – 24  (μm)'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode('25 – 100  (μm)'), 1, 0, 'C');

            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('1'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode('A'), 1, 0, 'C');

            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('2'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode('B'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('3'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode('B'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('4'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode(), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode('D'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('5'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('6'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('7'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Ln(6);
            $this->Image('../../views/images/conteoMicroscopico.png', 115, 175, 50);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('8'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $this->Cell(32, 6, utf8_decode('TOTAL'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(), 1, 0, 'C');
            $this->Ln(12);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->Cell(189, 6, utf8_decode('Verificado por:'), 1, 0, 'L');
            $this->Ln(20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(189, 6, utf8_decode('PARTÍCULAS VISIBLES'), 1, 0, 'C',TRUE);

            $this->Ln(12);
            $this->Cell(15, 5, utf8_decode('No. Vial o'), 'LRT', 0, 'C',TRUE);
            $this->Cell(30, 5, utf8_decode('No. Partículas'), 'LRT', 0, 'C',TRUE);
            $this->Cell(47.5, 10, utf8_decode('Descripción de Partículas'), 1, 0, 'C',TRUE);
            $this->Cell(5, 10, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('No. Vial o'), 'LRT', 0, 'C',TRUE);
            $this->Cell(30, 5, utf8_decode('No. Partículas'), 'LRT', 0, 'C',TRUE);
            $this->Cell(46, 10, utf8_decode('Descripción de Partículas'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('ampolla'), 'LRB', 0, 'C',TRUE);
            $this->Cell(30, 5, utf8_decode('visibles'), 'LRB', 0, 'C',TRUE);
            $this->Cell(52.5, 10, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('ampolla'), 'LRB', 0, 'C',TRUE);
            $this->Cell(30, 5, utf8_decode('visibles'), 'LRB', 0, 'C',TRUE);
            $this->Ln(5);
            $this->SetFont('Arial', '', 9);
            $this->Cell(15, 5, utf8_decode('1'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('11'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('2'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('12'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('3'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('13'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('4'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('14'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('5'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('15'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('6'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('16'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('7'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('17'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('8'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('18'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('9'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('19'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(5);
            $this->Cell(15, 5, utf8_decode('10'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(47.5, 5, utf8_decode(), 1, 0, 'C');
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->Cell(15, 5, utf8_decode('20'), 'LRB', 0, 'C');
            $this->Cell(30, 5, utf8_decode(), 'LRB', 0, 'C');
            $this->Cell(46, 5, utf8_decode(), 1, 0, 'C');
            $this->Ln(10);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->Cell(189, 5, utf8_decode('Verificado por:'), 1, 0, 'L');
            $this->Ln(10);
            $this->Cell(189, 5, utf8_decode('PARTÍCULAS VISIBLES MATERIA PRIMA'), 1, 0, 'C',TRUE);
            $this->Ln(5);
            $this->Cell(189, 20, utf8_decode('Partículas encontradas en la membrana o recipiente:'), 1, 0, 'L');
            $this->Ln(20);
            $this->seccionCumpleEspecificaciones();
            $this->Ln(0);
            $this->Cell(189, 5, utf8_decode('Verificado por:'), 1, 0, 'L');

            $this->Ln(10);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(30, 5, utf8_decode('Observaciones: '), 'LBT', 0, 'C');
            $this->Cell(159 , 5, utf8_decode(''), 'RBT', 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(0);
            $this->Cell(189 , 5, utf8_decode(''), 1, 1, 'C');
            $this->Ln(5);
            $this->Cell(95, 6, ('GCC-04-FR-052-1'), 0, 0, 'L');
            $this->Cell(94, 6, ('GCC-04-FR-052-1 '), 0, 0, 'R');
            $this->Ln(12);

        }

    }

    function ruidoCondicionesCromatograficas() {
        $this->Cell(180, 6, utf8_decode('Aptitud del Sistema'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(30, 6, utf8_decode('Nombre'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('N'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('T'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('R'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('k'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('S/N'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('Ruido'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(180, 6, utf8_decode('Verificación de condiciones cromatográficas'), 'TLR', 0, 'T');
        $this->Ln(6);
        $this->Cell(180, 12, utf8_decode(''), 'BLR', 0, 'T');
        $this->Ln(12);
        /* $this->Cell(60, 6, utf8_decode('Secuencia:'), 1, 0, 'L');
          $this->Cell(60, 6, utf8_decode('Método:'), 1, 0, 'L');
          $this->Cell(60, 6, utf8_decode('Fecha y hora:'), 1, 0, 'L');
          $this->Ln(6); */
    }


    function consultarEstandaresEnsayo($idEnsayoMuestra, $plantilla) {
        $tablaLoteEstandar = new TablaLoteEstandarDbModelClass();
        $lotes = $tablaLoteEstandar->obtenerLoteEstandarMuestraActivo($idEnsayoMuestra);
        $this->SetFillColor(216, 216, 216);
        if ($lotes['code'] == '00000' && $lotes['data'][0] !== null) {
            $data = $lotes['data'];

            $this->Cell(180, 6, utf8_decode('Datos del (los) Estándar (es)'), 1, 0, 'C', True); // True permite que asigne el color
            $this->Ln(6);
            $this->Cell(25, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode('Nombre'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Lote'), 1, 0, 'C');
            if ($plantilla == '262' || $plantilla == '286') {
                $this->Cell(40, 6, utf8_decode('Potencia (P)'), 1, 0, 'C');
            } else {
                $this->Cell(40, 6, utf8_decode('Pureza  (P)'), 1, 0, 'C');
            }
            $this->Cell(20, 6, utf8_decode('FV'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetWidths(array(25, 65, 30, 40, 20));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));
            foreach ($data as $estandar) {
                $this->auxGeneral->tablaBordesTamanoLinea($this, array(
                        utf8_decode($estandar->codigo_estandar . '(' . $estandar->stock . ')')
                    , utf8_decode($estandar->nombre_estandar), utf8_decode($estandar->lote_estandar)
                    , utf8_decode($estandar->pureza), utf8_decode($estandar->fecha_vencimiento))
                    , 6);
            }
        }
        $this->SetFillColor(169, 169, 169);
    }

    function consultarReactivosMuestra($idMuestra) {
        $tabla = new TablaLoteReactivoDbModelClass();
        $lotes = $tabla->obtenerLoteReactivoMuestraActivo($idMuestra);
        $this->SetFillColor(169, 169, 169);
        if ($lotes['code'] == '00000' && $lotes['data'][0] !== null) {
            $data = $lotes['data'];
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 6, utf8_decode('REACTIVOS Y SOLUCIONES'), 1, 0, 'C', True); // True permite que asigne el color
            $this->SetFont('Arial', '', 9);
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(40, 6, utf8_decode('Lote No.'), 1, 0, 'C');
            $this->Cell(85, 6, utf8_decode('Nombre'), 1, 0, 'C');
            $this->Cell(34, 6, utf8_decode('F. Vencimiento'), 1, 0, 'C');
            $this->Ln(6);
            foreach ($data as $reactivo) {
                $this->Cell(30, 6, utf8_decode($reactivo->codigo_reactivo), 1, 0, 'C');
                $this->Cell(40, 6, utf8_decode($reactivo->lote_reactivo), 1, 0, 'L');
                $this->Cell(85, 6, utf8_decode($reactivo->nombre_reactivo), 1, 0, 'L');
                $this->Cell(34, 6, utf8_decode($reactivo->fecha_vencimiento), 1, 0, 'C');
                $this->Ln(6);
            }
        } else {
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 6, utf8_decode('REACTIVOS Y SOLUCIONES'), 1, 0, 'C', True); // True permite que asigne el color
            $this->SetFont('Arial', '', 9);
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(40, 6, utf8_decode('Lote No.'), 1, 0, 'C');
            $this->Cell(85, 6, utf8_decode('Nombre'), 1, 0, 'C');
            $this->Cell(34, 6, utf8_decode('F. Vencimiento'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(40, 6, (''), 1, 0, 'C');
            $this->Cell(85, 6, (''), 1, 0, 'C');
            $this->Cell(34, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(40, 6, (''), 1, 0, 'C');
            $this->Cell(85, 6, (''), 1, 0, 'C');
            $this->Cell(34, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(40, 6, (''), 1, 0, 'C');
            $this->Cell(85, 6, (''), 1, 0, 'C');
            $this->Cell(34, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(40, 6, (''), 1, 0, 'C');
            $this->Cell(85, 6, (''), 1, 0, 'C');
            $this->Cell(34, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(40, 6, (''), 1, 0, 'C');
            $this->Cell(85, 6, (''), 1, 0, 'C');
            $this->Cell(34, 6, (''), 1, 0, 'C');
            $this->Ln(6);
        }
    }


    function consultarEquiposMuestra($idMuestra) {
        $tablaEquipo = new TablaEnsayoEquipoDbModelClass();
        $equipos = $tablaEquipo->obtenerEquiposMuestra($idMuestra);
        $this->SetFillColor(216, 216, 216);
        if ($equipos['code'] == '00000' && $equipos['data'][0] !== null) {
            $data = $equipos['data'];

            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 6, utf8_decode('EQUIPOS DE LOS ENSAYOS'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(59, 6, utf8_decode('Equipo'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('Serie'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('Fecha de calibración'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 8);
            $colum1 = 30;
            $colum2 = 59;
            $colum3 = 50;
            $colum4 = 50;
            $this->SetWidths(array($colum1, $colum2, $colum3, $colum4));
            foreach ($data as $equipos) {
                $codigo = $equipos->cod_inventario;
                $nombre = $equipos->descripcion;
                $serie = $equipos->serie;
                if ($equipos->fecha_ult_calib != null){
                    $fechaUltimaCalibracion = (new DateTime($equipos->fecha_ult_calib))->format('d-m-y');
                } else {
                    $fechaUltimaCalibracion = '--';
                }

                $this->SetX(10);

                $this->SetAligns(array('C', 'C', 'C', 'C'));
                $this->Row2(array(utf8_decode($codigo), utf8_decode($nombre), utf8_decode($serie), utf8_decode($fechaUltimaCalibracion)));
            }
        } else {
            $this->SetFont('Arial', '', 9);
            $this->Cell(189, 6, utf8_decode('EQUIPOS DE LOS ENSAYOS'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(59, 6, utf8_decode('Equipo'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('Serie'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('Fecha de calibración'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(59, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(59, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(59, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(59, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(59, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, (''), 1, 0, 'C');
            $this->Cell(59, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Cell(50, 6, (''), 1, 0, 'C');
            $this->Ln(6);
            if($this->plantilla == '16'){
                $this->Cell(95, 6, ('GCC-03-FR-033-1'), 0, 0, 'L');
                $this->Cell(94, 6, ('GCC-03-FR-033-1'), 0, 0, 'R');
            }



            $this->Ln(5);

        }
        $this->SetFillColor(169, 169, 169);
    }

    function seccionCumpleEspecificaciones() {
        $this->Cell(190, 6, utf8_decode('Cumple   SI (  )      NO (  )'), 1, 0, 'C');
        $this->Ln(6);

    }

    function consultarEquiposEnsayo($idEnsayo) {
        $tabla = new TablaEnsayoEquipoDbModelClass();
        $equipos = $tabla->obtenerEquiposEnsayo($idEnsayo);
        if ($equipos['code'] == '00000' && $equipos['data'][0]->equipos !== null) {
            $this->Cell(180, 6, utf8_decode('Equipos: ' . $equipos['data'][0]->equipos), 1, 0, 'L'); // True permite que asigne el color
            $this->Ln(6);
        }
    }

    function verReactivosMuestraFq() {
        $this->Ln(6);
        $this->consultarReactivosMuestra($this->muestra["id"]);
    }

    function verEquiposMuestra() {
        $this->Ln(6);
        $this->consultarEquiposMuestra($this->muestra->id);
    }

    function faseMovil() {
        $this->Cell(180, 18, utf8_decode('Fase Móvil:'), 'LRT', 0, 'L');
        $this->Ln(18);
        $this->Cell(180, 6, utf8_decode('Verificado por:'), 'RLB', 0, 'L');
        $this->Ln(6);
    }

    function preparacionSoluciones() {
        $this->Cell(180, 25, utf8_decode('Preparación de soluciones'), 'TLR', 0, 'L');
        $this->Ln(25);
        $this->Cell(180, 6, utf8_decode('Verificado por:'), 'LRB', 0, 'L');
        $this->Ln(6);
    }

    function finalDocumento() {

        $this->Ln(8);
        $this->Cell(189, 8, utf8_decode('Resultado Fuera de Especificaciones'), 1, 0, 'L');
        $this->Ln(8);
        $this->Cell(189, 8, utf8_decode('Verificación'), 1, 0, 'L');
        $this->Ln(13);
        $this->Cell(189, 6, utf8_decode('Concepto:'), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(95, 6, utf8_decode('[   ]  Cumple las especificaciones'), 1, 0, 'L');
        $this->Cell(94, 6, utf8_decode('[   ]  No cumple las especificaciones'), 1, 0, 'L');
        $this->Ln(30);

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(189, 5, utf8_decode('     Analizado por: ________________________________________             Verificado por: __________________________________________'), 0, 0, 'L');
        $this->Ln(10);
        $this->Cell(189, 5, utf8_decode('     Transcrito por: ________________________________________             Aprobado por: __________________________________________'), 0, 0, 'L');
        $this->Ln(10);

        if ($this->cuadroControlValoracion) {
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER (Valoración) con estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('Promedio de estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER entre STD1 y STD2: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        }
        if ($this->cuadroControlDisolucion) {
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('Promedio de estándar de control de disolución: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER (Disolución) con estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER entre STD1 y STD2: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        }
        /*if ($this->cuadroControlPureza) {
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER para estándar de pureza de Control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
        }*/
    }

}

$pdf = new PDF();
$pdf->obtenerInformacionGeneral();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->selectHojaRuta();
//$pdf->secEquipos();

//$pdf->verEquiposMuestra();

//$pdf->informacionMuestra();
//$pdf->plantillasEnsayos();
//$pdf->verReactivosMuestraFq();

//$pdf->finalDocumento();

$pdf->Output();
?>
