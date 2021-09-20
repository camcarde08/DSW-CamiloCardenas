<?php

require('../fpdf.php');
require('../tfpdf/tfpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';
require './AuxiliarInformes.php';

$dato = $_POST['idMuestra'];
$perfil = $_POST['idPerfil'];

$modelReporte = new TablaReportesDbModelClass();
$validador = substr($dato, 2, 1);

//$dini = $modelReporte->getIdInicio($dato1);
//$dato = $dini[0][id];

$infoFirmas = $modelReporte->infoGeneralFirmas($dato)[0];
$fechaPrueba1 = new DateTime("2018-03-14");
$fechaPrueba = $fechaPrueba1->format('d-m-Y');
$fechaConclusion1 = new Datetime($infoFirmas->fecha_conclusion);
$fechaConclusion = $fechaConclusion1->format('d-m-Y');

$data = $modelReporte->getInfoPrincipal($dato);
foreach ($data as $informe) {
    $informes[] = array(
        $id = $informe['id'],
        $FechaLlegada = $informe['fecha_llegada'],
        $Anollegada = substr($FechaLlegada, 0, 4),
        $Mesllegada = substr($FechaLlegada, 5, 2),
        $Diallegada = substr($FechaLlegada, 8, 2),
        $FechaLlegada1 = $Diallegada . '-' . $Mesllegada . '-' . $Anollegada,
        $Contacto = $informe['nombre_contacto'],
        $AreaContacto = $informe['area_contacto'],
        $Fabricante = $informe['fabricante'],
        $Procedencia = $informe['procedencia'],
        $NumeroInforme = $informe['num_informe'],
        $numeroremision = $informe['numero_remision'],
        $Producto = $informe['nombre_producto'],
        $Cliente = $informe['nombre_tercero'],
        $Direccion = $informe['direccion_tercero'],
        $Telefono = $informe['telefono_tercero'],
        $Forma = $informe['FormaFarmaceutica'], //Esto es tipo de Producto
        $tipoProducto = $informe['tipo_producto'],
        $des_area_analisis = $informe['nombre_producto'],
        $FechaFabri = substr($informe['fecha_fabricacion'], 0, 10),
        $AnoFv = substr($FechaFabri, 0, 4),
        $MesFv = substr($FechaFabri, 5, 2),
        $DiaFv = substr($FechaFabri, 8, 2),
        $FechaFabri1 = $MesFv . '-' . $AnoFv,
        $FechaVence = substr($informe['fecha_vencimiento'], 0, 10),
        $AnoFf = substr($FechaVence, 0, 4),
        $MesFf = substr($FechaVence, 5, 2),
        $DiaFf = substr($FechaVence, 8, 2),
        $FechaVence1 = $MesFf . '-' . $AnoFf,
        $finalizacionAnalisisw = substr($informe['finalizacionAnalisis'], 0, 10),
        $AnoF = substr($finalizacionAnalisis, 0, 4),
        $MesF = substr($finalizacionAnalisis, 5, 2),
        $DiaF = substr($finalizacionAnalisis, 8, 2),
        $finalizacionAnalisis = $DiaF . '-' . $MesF . '-' . $AnoF,
        $inicioAnalisisw = substr($informe['inicioAnalisis'], 0, 10),
        $AnoI = substr($inicioAnalisisw, 0, 4),
        $MesI = substr($inicioAnalisisw, 5, 2),
        $DiaI = substr($inicioAnalisisw, 8, 2),
        $inicioAnalisis = $DiaI . '-' . $MesI . '-' . $AnoI,
        $Empaque = $informe['Empaque'],
        $Envase = $informe['Envase'], // es Forma Farmaceutica
        $PrincipioActivo = $informe['PrincipioActivo'],
        $CantidadLote = $informe['cantidadLote'],
        $Lote = $informe['lote'],
        $AreaAnalisis = $informe['des_area_analisis'],
        $Conclusion = $informe["conclusion"],
        $Estado = $informe["estado"],
        $nombreAnalista = $informe["nombreAnalista"],
        $perfilAnalista = $informe["PerfilAnalista"],
        $idPerfil = $perfil,
        $anofab = substr($FechaFabri, 0, 4),
        $anoven = substr($FechaVence, 0, 4),
        $codigo1 = $informe["codigo"],
        $estabilidad = $informe["estabilidad"],
        $idFormaFarmaceutica = intval($informe["idFormaFarmaceutica"]),
        $invima = $informe["invima"],
        $especificacionesTraza = $informe["especificacionTraza"]
    );
}
if ($anofab == '1900') {
    $FechaFabri1 = 'No Especificada';
}
if ($anoven == '1900') {
    $FechaVence1 = 'No Especificada';
}
$fechaCod = new DateTime($FechaLlegada);
$numCliente = $modelReporte->numeroCliente($dato);
foreach ($numCliente as $nume) {
    $numee[] = array(
        $codigolqf = 'SSF-' . substr($nume['elnum'], 6, 4) . '-' . $fechaCod->format('y')
    );
}

$metodosTraza = $modelReporte->getMetodo($dato);

//$especificacionesTraza = $modelReporte->getEspecificacion($dato);

class PDF extends TFPDF {


    public $auxTabla;
    function formatDate($stringFecha, $separador){
        if($stringFecha == null || $stringFecha == ""){
            return "--";
        }
        $fecha = new DateTime($stringFecha);
        $dia = $fecha->format("j");
        $mes = $fecha->format("n");
        $ano = $fecha->format("y");

        $fullYear = $fecha->format("Y");

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

        if($fullYear == "1900"){
            return "N/A";
        } else {
            return $dia . $separador . $mes . $separador . $ano;
        }



    }

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Header() {
        $this->auxTabla = new AuxiliarInformes();
        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(80, 20, utf8_decode('CERTIFICADO DE ANÁLISIS'), 1, 0, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');




        $this->SetXY(130, 10);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode(''), 'LRT', 0, 'C');
        $this->Cell(30, 20, utf8_decode('Página'.$this->PageNo() . ' de {nb}'), 1, 0, 'C');

        $this->Ln(5);
        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(30, 5, utf8_decode('Código'), 'LR', 0, 'C');

        $this->Ln(5);

        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(30, 5, utf8_decode('GCC-04-FR-062-2'), 'LR', 0, 'C');
        $this->Ln(5);
        $this->Cell(120, 5, utf8_decode(''), 0, 0, 'C');
        $this->Cell(30, 5, utf8_decode(''), 'LRB', 0, 'C');


        $this->Ln(8);
        // To be implemented in your own inherited class

       /* $this->SetFont('Arial', 'B', 8);
        $this->RoundedRect(130, 33, 60, 7, 2, 'S', '1234');*/
//            $pdf->RoundedRect( 130, 40, 60, 7, 2,  'S', '');
//            $pdf->RoundedRect( 130, 47, 60, 7, 2,  'S', '');
//            $pdf->RoundedRect( 130, 54, 60, 7, 2,  'S', '34');
//$pdf->SetFont('Arial','B',6);
        $this->Cell(120, 7, utf8_decode(''), 0, 0, 'L');
        $this->Cell(35, 7, utf8_decode('Informe No. '), 'LTB', 0, 'L');
        $this->SetTextColor(0, 128, 255); //Azul
        $this->Cell(25, 7, $GLOBALS['numCliente'][0]['elnum'], 'RTB', 0, 'L');
        $this->SetTextColor(0, 0, 0); //NEGRO
        $this->Ln(-3);
        $this->SetFont('Arial', 'B', 10);
        $this->setX(20);


        $this->Cell(-20, 7, '', 0, 0, 'L');

        $cantletras = strlen($GLOBALS['Producto']);
        if ($cantletras > 58) {
            $this->SetFont('Arial', 'B', 8);
        } else {
            $this->SetFont('Arial', 'B', 9);
        }
        $this->Ln(5);

        $this->SetWidths(array(30,20,70));
        $array =  array( (''),utf8_decode('Producto:'),utf8_decode($GLOBALS['Producto']));
        $this->auxTabla->tablaSinBordes($this,$array);

        $this->Ln(2);

        $this->SetWidths(array(30,20,70));
        $array =  array( (''),utf8_decode('Lote:'),utf8_decode($GLOBALS['Lote']));
        $this->auxTabla->tablaSinBordes($this,$array);
        $this->Ln(2);



        $sumRenglon = 0;
        if ($GLOBALS['estabilidad'] !== 'N/A' && $GLOBALS['estabilidad'] !== NULL && $GLOBALS['estabilidad'] !== '') {

            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');
            $this->SetFont('Arial', '', 8);
            $this->Cell(75, 5, utf8_decode('Estabilidad: '), 0, 0, 'C');
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(10, 5, utf8_decode($GLOBALS['estabilidad']), 0, 0, 'C');

            $this->Ln(7);
            $GLOBALS['sumRenglon'] ++;
        }
        /*if ($GLOBALS['invima'] !== 'N/A' && $GLOBALS['invima'] !== NULL && $GLOBALS['invima'] !== '') {
            $this->Cell(120, 5, utf8_decode('Registro sanitario: ' . $GLOBALS['invima']), 0, 0, 'C');
            $this->Ln(7);
            $GLOBALS['sumRenglon'] ++;
        }*/
        if(    $GLOBALS['idFormaFarmaceutica'] == 75){
            $this->SetFont('Arial', '', 8);
            $this->Cell(5, 5, utf8_decode(), 0, 0, 'C');

            $this->Cell(75, 5, utf8_decode('Registro sanitario: '), 0, 0, 'C');
            $this->SetFont('Arial', 'B', 8);

            $this->Cell(10, 5, utf8_decode($GLOBALS['invima']), 0, 0, 'C');

            $this->Ln(7);
        }
        else{
            null;
        }


//        if ($GLOBALS['perfil'] == "true") {
//            $this->SetFont('Arial', 'B', 35);
//            $this->SetTextColor(255, 192, 203);
//            $this->RotatedText(35, 200, 'C O P I A   C O N T R O L A D A', 45);
//        }
        $this->Ln(7);

    }

    function Footer() {
//        codigo qr
//        $this->SetY(-60);
        $this->SetY(-20); //quitar cuando se habilite codigo qr
        $val = 0;

        //codigo qr
//        $this->SetFont('Arial', '', 8);
//        $this->Cell(8, 4, utf8_decode(''), 0, 0, 'L');
//        $this->Cell(150, 4, utf8_decode(''), 0, 0, 'L');
//        $this->Image('./../../docs/qr/fq/' . $_POST['idMuestra'] . "/qrcode.png", null, null, -270);
//        $this->Ln(1);
//        $this->SetFont('Arial', '', 6);
//        $this->Cell(8, 4, utf8_decode(''), 0, 0, 'L');
//        $this->Cell(100, 4, utf8_decode(''), 0, 0, 'L');
//        $this->Cell(100, 4, utf8_decode('*Valide la autenticidad de su informe por medio de este código QR'), 0, 0, 'L');
//        $this->Ln(7);
        if ($GLOBALS['fechaConclusion1'] > $GLOBALS['fechaPrueba1']) {
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(8, 4, utf8_decode(''), 0, 0, 'L');
            $this->Cell(275, 4, utf8_decode('*Este documento está firmado electrónicamente según parámetros establecidos por la FDA en la norma CFR21 parte 11'), 0, 0, 'L');
            $this->Ln(7);
        } else {
            
        }

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 4, utf8_decode('Carrera 43 No. 20B-07 - PBX:2693999 - FAX:2449930 - Bogotá, D.C Colombia - www.farmalogica.com'), 0, 0, 'C');
        $this->Ln();
        $this->Cell(5, 4, utf8_decode(''),0,0,'C');
        $this->Cell(120, 4, utf8_decode('Servicioalcliente@farmalogica.com-'),0,0,'C');
        $this->Image('../../views/images/logoTel.PNG',100,288,5);
        $this->Cell(12, 4, utf8_decode('- linea gratuita 01 8000 113990'),0,0,'R');

        $this->Ln();
        $this->Cell(180, 4, utf8_decode('NIT 830.057.982-4'), 0, 0, 'C');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(0);
/*
  $pdf->SetFont('Arial', 'B', 8);
  $pdf->RoundedRect(130, 33, 60, 7, 2, 'S', '1234');
  //            $pdf->RoundedRect( 130, 40, 60, 7, 2,  'S', '');
  //            $pdf->RoundedRect( 130, 47, 60, 7, 2,  'S', '');
  //            $pdf->RoundedRect( 130, 54, 60, 7, 2,  'S', '34');
  //$pdf->SetFont('Arial','B',6);
  $pdf->Cell(120, 7, utf8_decode(''), 0, 0, 'L');
  $pdf->Cell(35, 7, utf8_decode('Radicación No. '), 0, 0, 'L');
  $pdf->SetTextColor(0, 128, 255); //Azul
  $pdf->Cell(25, 7, $codigolqf, 0, 0, 'L');
  $pdf->SetTextColor(0, 0, 0); //NEGRO
  $pdf->Ln(-3);

  $cantletras = strlen($Producto);
  if ($cantletras > 58) {
  $pdf->SetFont('Arial', 'B', 8);
  } else {
  $pdf->SetFont('Arial', 'B', 10);
  }
  $pdf->Cell(120, 7, utf8_decode($Producto), 0, 0, 'C');

  $pdf->Ln(6);
  $pdf->Cell(120, 7, 'LOTE:' . utf8_decode($Lote), 0, 0, 'C');
  $pdf->Ln(7);
  $sumRenglon = 0;
  if ($estabilidad !== 'N/A' && $estabilidad !== NULL && $estabilidad !== '') {
  $pdf->Cell(120, 5, utf8_decode('Estabilidad: ' . $estabilidad), 0, 0, 'C');
  $pdf->Ln(7);
  $sumRenglon++;
  }
  if ($invima !== 'N/A' && $invima !== NULL && $invima !== '') {
  $pdf->Cell(120, 5, utf8_decode('Resol. INVIMA: ' . $invima), 0, 0, 'C');
  $pdf->Ln(7);
  $sumRenglon++;
  } */

$pdf->SetFont('Arial', '', 9);
//datos cliente
//$pdf->RoundedRect(10, 42, 110, 6, 2,  'S', '14');
////$pdf->RoundedRect(90, 68, 40, 6, 2,  'S', '');
//$pdf->RoundedRect(120, 42, 70, 6, 2,  'S', '23');
$pdf->Cell(18, 6, 'Cliente:', LTB, 0, 'L');
$pdf->Cell(72, 6, substr(utf8_decode($Cliente), 0, 34), TBR, 0, 'L');
$pdf->Cell(18, 6, utf8_decode('Dirección: '), LTB, 0, 'L');
$pdf->Cell(72, 6, utf8_decode($Direccion), TBR, 0, 'L');
$pdf->Ln(6);
$pdf->Cell(18, 6, ('Propietario:'), LTB, 0, 'L');
$pdf->Cell(72, 6, utf8_decode($Procedencia), TBR, 0, 'L');
$pdf->Cell(18, 6, utf8_decode('Teléfono : '), LTB, 0, 'L');
$pdf->Cell(72, 6, utf8_decode($Telefono), TBR, 0, 'L');
$pdf->Ln(7);
$pdf->cY = $pdf->GetY();
if ($Forma == 'Materia Prima') {
    $heg = $pdf->NbLines(61, $Forma);
} else {
    $heg = $pdf->NbLines(61, $Forma . '  (' . $Envase . ')');
}

$pdf->MultiCell(31, 6 * $heg, utf8_decode('Tipo de Muestra:'), LT, 'T');
if ($Forma == 'Materia Prima') {
    $pdf->SetXY($pdf->GetX() + 31, $pdf->cY);
    $pdf->MultiCell(59, 6, utf8_decode($Forma), TR, 'L');
} else {
    $pdf->SetXY($pdf->GetX() + 31, $pdf->cY);
    $pdf->MultiCell(59, 6, utf8_decode($Forma . '  (' . $Envase . ')'), TR, 'L');
}
$tempy = ($pdf->GetY() - $pdf->cY) / 6;
$pdf->SetXY($pdf->GetX() + 90, $pdf->cY);
$pdf->Cell(32, 6 * $heg, utf8_decode('Presentación:'), LT, 0, 'L');
$pdf->SetXY($pdf->GetX(), $pdf->cY);
$pdf->Cell(58, 6 * $heg, utf8_decode(substr($Empaque, 0, 30)), TR, 0, 'L');

while ($tempy !== 0) {
    $pdf->Ln(6);
    $tempy = $tempy - 1;
}

$pdf->cY = $pdf->GetY();
$hegFab = $pdf->NbLines(58, $Fabricante);
if ($Forma == 'Materia Prima') {
    $pdf->Cell(31, 6 * $hegFab, utf8_decode('Cantidad: '), LTB, 0, 'L');
} else {
    $pdf->Cell(31, 6 * $hegFab, utf8_decode('Tamaño del lote: '), LTB, 0, 'L');
}


if ($CantidadLote == "N/A") {
    $pdf->Cell(59, 6 * $hegFab, "No especificado", TBR, 0, 'L');
} else {
    $pdf->Cell(59, 6 * $hegFab, $CantidadLote, TBR, 0, 'L');
}

if ($Forma == 'Materia Prima') {
    $pdf->Cell(32, 6 * $hegFab, utf8_decode('Proveedor: '), LTB, 0, 'L');
} else {
    $pdf->Cell(32, 6 * $hegFab, utf8_decode('Fabricante/O.P.: '), LTB, 0, 'L');
}
$pdf->Cell(58, 6, utf8_decode($Fabricante), TBR, 0, 'L');
$pdf->Ln(6);
$pdf->Cell(31, 6, utf8_decode('Fecha de fabricación:'), LTB, 0, 'L');
$pdf->Cell(59, 6,$pdf->formatDate($GLOBALS['informe']['fecha_fabricacion'], "-"), TBR, 0, 'L');

if ($Forma == 'Materia Prima') {
    $pdf->Cell(32, 6, utf8_decode('Fecha de Venc./Rean:'), LTB, 0, 'L');
} else {
    $pdf->Cell(32, 6, utf8_decode('Fecha de vencimiento:'), LTB, 0, 'L');
}



$pdf->Cell(58, 6, $pdf->formatDate($GLOBALS['informe']['fecha_vencimiento'], "-"), TBR, 0, 'L');
$pdf->Ln(7);
$pdf->Cell(60, 6, utf8_decode('Fecha de llegada: ') . $pdf->formatDate($GLOBALS['FechaLlegada'], "-"), 1, 0, 'L');
$pdf->Cell(60, 6, utf8_decode('Fecha de análisis : ') .  utf8_decode($pdf->formatDate($inicioAnalisisw, "-")), 1, 0, 'L');
$pdf->Cell(60, 6, utf8_decode('Fecha de aprobación : ') . utf8_decode($pdf->formatDate($finalizacionAnalisisw, "-")), 1, 0, 'L');



$pdf->Ln(6);

if ($idFormaFarmaceutica !== 74) {
    $arr = explode('ESP:', $codigo1);

    if ($arr[1] != null) {
        $codigo = $arr[1];
    } else {
        $codigo = $arr[0];
    }
    $pdf->Cell(180, 6, utf8_decode('Especificaciones: ') . utf8_decode($codigo), 1, 0, 'L');
    $pdf->Ln(7);
} else {
    $metodoTraza = implode(",", $metodosTraza);

    $pdf->Cell(180, 6, utf8_decode('Método: ') . utf8_decode($metodoTraza), 1, 0, 'L');
    $pdf->Ln(7);

    $pdf->Cell(180, 6, utf8_decode('Especificaciones: ') . utf8_decode($especificacionesTraza), 1, 0, 'L');
    $pdf->Ln(7);
}

$pdf->SetXY(10, 105);
$pdf->SetFont('Arial', 'B', 10);

while ((($heg + $hegFab + $sumRenglon) - 2) !== 0) {
    $pdf->Ln();
    $heg--;
}
if ($idFormaFarmaceutica !== 74) {
    resultadosEnsayos($dato);
} else {
    resultadosTraza($dato);
}

/////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
//$pdf->Ln();
$indice = $pdf->GetY();
if ($indice > 235) {
    $pdf->AddPage();
}

$pdf->SetFont('Arial', '', 7);
$Conclusion1 = preg_replace("/<br>/", "\r\n", $Conclusion);
$Conclusion2 = preg_replace("/<div>/", "\r\n", $Conclusion1);
$Conclusion3 = preg_replace("/<\/div>/", "\r\n", $Conclusion2);
$Condiciones1 = preg_replace(" ", " ", $Condiciones);
$pdf->MultiCell(180, 4, (utf8_decode($Conclusion3)));

$indice = $pdf->GetY();
if ($indice > 235) {
    $pdf->AddPage();
}

$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln(5);
$pdf->Cell(55, 4, utf8_decode(' '), 0, 0, 'C');
$pdf->Cell(90, 4, utf8_decode('APROBADO POR'), 0, 0, 'L');
//  $this->Cell(90,4,utf8_decode('VERIFICÓ'),0,0,'C');
$pdf->Ln(15);

$pdf->SetFont('Arial', '', 8);
$indice = $pdf->GetY();
$pdf->Image('./../../docs/qr/fq/' . $_POST['idMuestra'] . "/qrcode.png", 20, $indice - 8, 19);
$pdf->Image('../../views/images/BPL.jpg', 40, $indice - 8, 19);
if ($fechaConclusion1 < $fechaPrueba1) {
    $pdf->Cell(180, 4, utf8_decode(''), 0, 0, 'C');
//            $this->Ln(4);
//            $this->Cell(180, 4, utf8_decode($fechaConclusionReal), 0, 0, 'C');
    $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(180, 4, utf8_decode('________________________________________'), 0, 0, 'C');
//            $this->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
    $pdf->Ln(4);
    $pdf->Cell(180, 4, utf8_decode('MARIA DEL CARMEN GUAYAMBUCO QUINTERO'), 0, 0, 'C');
    $pdf->Ln(4);
    $pdf->Cell(180, 4, utf8_decode('Directora Técnica'), 0, 0, 'C');
    $pdf->Ln(6);
} else {
    if ($infoFirmas->fecha_conclusion == null) {
        $fechaConclusionReal = null;
    } else {
        $fechaConclusionReal1 = new Datetime($infoFirmas->fecha_conclusion);
        $fechaConclusionReal = $fechaConclusionReal1->format('d-m-Y');
    }
    $pdf->Cell(180, 4, utf8_decode($infoFirmas->aprobado), 0, 0, 'C');
    $pdf->Ln(4);
    $pdf->Cell(180, 4, utf8_decode('' . $fechaConclusionReal), 0, 0, 'C');
    $pdf->Ln(2);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(180, 4, utf8_decode('________________________________________'), 0, 0, 'C');
//            $this->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
    $pdf->Ln(4);
    $pdf->Cell(180, 4, utf8_decode('' . $infoFirmas->cargo), 0, 0, 'C');
    $pdf->Ln(6);
}

$pdf->Output();

function resultadosTraza($dato) {
    $pdf = $GLOBALS['pdf'];
    $y = $pdf->GetY();
    $pdf->SetY($y + 5);
    $tit1 = 50;
    $tit2 = 65;
    $tit3 = 65;
    $letrascol = $GLOBALS['letrascol'];
    $modelReporte = $GLOBALS['modelReporte'];
    $pdf->Cell($tit1, -5, utf8_decode('MUESTRA') . $letrascol, 1, 0, 'C');
    $pdf->Cell($tit2, -5, utf8_decode('NOMBRE'), 1, 0, 'C');
    $pdf->Cell($tit3, -5, 'RESULTADO', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);

    /////////////////////////////////////////
    /////////INCIO LISTADO DE ENSAYOS////////
    /////////////////////////////////////////
    $data1 = $modelReporte->VerResultadoMuestra($dato);
    $dataTraza = $data1[0];


    $pdf->SetX(10);
    $Resultado = $dataTraza["resultado"];
    $pdf->MultiCell(180, 5, utf8_decode($Resultado), 1, 'L');
    $pdf->Ln(3);
}

function resultadosEnsayos($dato) {


    $pdf = $GLOBALS['pdf'];
    $letrascol = $GLOBALS['letrascol'];
    $modelReporte = $GLOBALS['modelReporte'];
    $tit1 = 40;
    $tit2 = 55;
    $tit3 = 60;
    $tit4 = 25;
    $pdf->Ln(10);

    $pdf->Cell($tit1, -5, utf8_decode('ANÁLISIS') . $letrascol, 1, 0, 'C');
    $pdf->Cell($tit2, -5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
    $pdf->Cell($tit3, -5, 'RESULTADO', 1, 0, 'C');
    $pdf->Cell($tit4, -5, utf8_decode('MÉTODO'), 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
    $data1 = $modelReporte->VerResultadoMuestra($dato);
    $pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
    $pdf->SetFont('DejaVu', '', 7);
    foreach ($data1 as $informe1) {
        $Especificacion = $informe1["especificacion"] . '                                ';
        //$pdf->SetFont('Arial','I',9);
        $Descripcion = $informe1["descripcion"];
        //$pdf->SetFont('Arial','B',9);
        $Metodo = $informe1["metodo"];
        $Resultado1 = $informe1["resultado"];

        $pdf->SetX(10);
        $colum1 = 40;
        $colum2 = 55;
        $colum3 = 60;
        $colum4 = 25;
        $pdf->SetWidths(array($colum1, $colum2, $colum3, $colum4));

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
//saco el resultado por pantalla
        $Resultado = preg_replace($exp_regular, $cadena_nueva, $Resultado1);
        $pdf->SetAligns(array('L', 'L', 'L', 'L'));
        $data = [$Descripcion,$Especificacion, $Resultado, $Metodo];

        $pdf->auxTabla->tablaBordes($pdf, $data);

//        $pdf->Row2(array(utf8_decode($Descripcion), utf8_decode($Especificacion), utf8_decode($Resultado), utf8_decode($Metodo)));

        $indice = $pdf->GetY();
        if ($indice > 235) {
            $pdf->AddPage();
        }
    }
    $pdf->Ln(3);
    
}

?>
