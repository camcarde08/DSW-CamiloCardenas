<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DB/TablaLoteEstandarDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$dato = $_POST['idMuestra'];
$perfil = $_POST['idPerfil'];

$modelReporte = new TablaReportesDbModelClass();
$ocultarCampos = 0;
$data = $modelReporte->getInfoPrincipalHR($dato);
foreach ($data as $informe) {
    $informes[] = array(
        $id = $informe['id'],
        $FechaLlegada = substr($informe['fecha_llegada'], 0, 10),
        $aa = substr($FechaLlegada, 2, 2),
        $mm = substr($FechaLlegada, 5, 2),
        $dd = substr($FechaLlegada, 8, 2),
        $FechaLlegada1 = $dd . '-' . $mm . '-' . $aa,
        $AreaAnalisis = $informe['des_area_analisis'],
        $Producto = $informe['nombre_producto'],
        $Forma = $informe['FormaFarmaceutica'],
        $Lote = $informe['lote']
    );
}
$Producto = ($Producto);
$metodos = $modelReporte->getMetodosHR($dato);
foreach ($metodos as $met) {
    $informes[] = array(
        $metodos = $met['metodos'],
        $codigo = $met['codigo']
    );
}
$eyos = $modelReporte->getEnsayosARealizarHR($dato);
foreach ($eyos as $ey) {
    $informes[] = array(
        $EnsayosARealizar = $ey['ensayosarealizar']
    );
}


//$sonTrazas = strstr($EnsayosARealizar ,'Traza');  
if (strstr($EnsayosARealizar, "Traza")) {
    $EnsayosARealizar = 'Análisis de Trazas ' . $sonTrazas;
}
//   if ($sonTrazas <= 0) 


$descripcion = $modelReporte->getDescripcionHR($dato);
foreach ($descripcion as $desc) {
    $descrip[] = array(
        $descripcion = $desc['DESCRIPCION']
    );
}

$numCliente = $modelReporte->numeroCliente($dato);
foreach ($numCliente as $nume) {
    $numee[] = array(
        $ident = $nume['elnum']
    );
}

$clienteid = $modelReporte->getidCliente($dato);
foreach ($clienteid as $cli) {
    $clien[] = array(
        $clienteid = $cli['DESCRIPCION']
    );
}

class PDF extends FPDF {

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Header() {
        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 11, 12, 39);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(80, 20, utf8_decode('HOJA DE TRABAJO ANALÍTICO'), 1, 0, 'C');


        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('F-145-(LA-008)'), 1, 0, 'C');

        $this->SetXY(130, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('01'), 1, 0, 'C');
        $this->SetXY(130, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('06-02-17'), 1, 0, 'C');
        $this->SetXY(130, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(30, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(180, 10, '', 0, 0, 'C');
        $this->Ln(5);

        if ($GLOBALS['perfil'] == "false") {
            $this->SetFont('Arial', 'B', 14);
            $this->SetTextColor(255, 192, 203);
            for ($i = 0; $i < 1000; $i += 30) {
                $this->RotatedText(0, $i, 'H O J A   D E   T R A B A J O   P A R C I A L   C O P I A   N O   C O N T R O L A D A    H O J A   D E   T R A B A J O   P A R C I A L   C O P I A   N O   C O N T R O L A D A', 45);
            }
        }
        // To be implemented in your own inherited class
    }

    function Footer() {
        // Position at 1.5 cm from bottom
        $this->SetY(-16);

        $this->SetFont('Arial', 'B', 6);
        //$this->Cell(180,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
        $this->Ln();
        // $this->Cell(90,5, utf8_decode('3 FOR-004') . utf8_decode(' REV.04'),0,0,'L');
        $this->Cell(90, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
        //$this->Ln();
        // Print centered page number
        // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->SetFont('Arial', '', 9);
$pdf->SetFillColor(169, 169, 169);
$pdf->RoundedRect($pdf->GetX(), $pdf->GetY() + 2, 180, 6, 2, 'S', '12');

$pdf->Ln(-20);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(180, 50, utf8_decode('HOJA DE TRABAJO ANALíTICO ' . strtoupper($Forma) . ' ' . ($Producto)), 0, 0, 'C');
//$pdf->Cell(40,50,utf8_decode('No. '.($ident)),0,0,'L');
//$pdf->Cell(55,50,utf8_decode('Lote: '.($Lote)),0,0,'L');
$pdf->Ln(28);
$pdf->Cell(25, 7, 'F. DE INGRESO' . $clienteid, 1, 0, 'C');
$pdf->Cell(25, 7, utf8_decode('F.ANÁLISIS'), 1, 0, 'C');
$pdf->Cell(30, 7, utf8_decode('N. ANÁLISIS'), 1, 0, 'C');
$pdf->Cell(100, 7, 'Lote', 1, 0, 'C');
$pdf->Ln();
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(25, 7, $FechaLlegada1, 1, 0, 'C');
$pdf->Cell(25, 7, '', 1, 0, 'C');
$pdf->Cell(30, 7, $ident, 1, 0, 'C');
$pdf->Cell(100, 7, utf8_decode($Lote), 1, 0, 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln();
$pdf->Cell(180, 7, utf8_decode($Producto), 1, 0, 'C');
//Producto
//$pdf->RoundedRect(10, 37, 180, 6, 2,  'S', '12');
//$pdf->RoundedRect(10, 43, 180, 6, 2,  'S', '34');
$pdf->Ln();
$pdf->MultiCell(180, 6, utf8_decode('ENSAYOS A REALIZAR: ') . utf8_decode($EnsayosARealizar), 1, L, FALSE);
$pdf->Ln(0);
$pdf->Cell(180, 6, utf8_decode('MÉTODOS: ' . $metodos . ' ' . $codigo), 1, 0, 'L');
$pdf->Ln();
$pdf->SetFillColor(158, 158, 158); // establece el color del fondo de la celda (en este caso es GRIS
$pdf->SetFont('Arial', 'B', 9);

if (!strstr($EnsayosARealizar, "Traza")) {
    $pdf->Cell(180, 6, utf8_decode('Descripción'), 1, 0, 'C', True); // True permite que asigne el color
    $pdf->SetFont('Arial', '', 9);
    $pdf->Ln(6);
    $pdf->MultiCell(180, 6, utf8_decode($descripcion), 1, L, FALSE);
    $pdf->Ln(0);
    $pdf->MultiCell(180, 12, '', 1, L, FALSE);
    $pdf->Ln(0);
    $pdf->Cell(180, 6, utf8_decode('CUMPLE   SI[   ]    NO[   ]'), 1, 0, 'C');
    $pdf->Ln(6);
}

//Muestra
$pdf->SetFont('Arial', 'B', 7);
/* if ($Forma == 'Material Envase o Empaque') { //Material de Envase o Empaque
  $pdf->Ln(6);
  $pdf->Cell(90, 6, utf8_decode('Material Volumetrico'), 1, 0, 'C', TRUE);
  $pdf->Cell(90, 6, utf8_decode('Equipos'), 1, 0, 'C', TRUE);
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode('Nombre'), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode('No. Identificación'), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode('Nombre'), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode('Fecha Calif. o Calib'), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode('Fecha Próxima Cali.'), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(7);

  $pdf->Cell(180, 6, utf8_decode('MEDIDAS'), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->SetFont('Arial', 'B', 6);
  $pdf->Cell(15, 6, utf8_decode('Ensayo'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode('Peso'), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode('Volumen de Llenado(mL)'), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode('Gramaje'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('Especificación'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('1'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('2'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('3'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('4'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('5'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('6'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('7'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('8'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('9'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('10'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('Promedio'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('CV (<=5%)'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Ln(6);
  $pdf->Cell(15, 6, utf8_decode('Concepto'), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
  } */// Fin de Material de Envase y Empaque 
/////////INCIO LISTADO DE ENSAYOS EXCEPTO MATERIAL DE ENVASE Y EMPAQUE////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerHojadeRuta($dato);
$cuadroControlPlantilla = false;
$cuadroControlEstandar = false;
foreach ($data1 as $informe1) {
    $Ensayo = $informe1["desEspecifica"];
    $Especificacion1 = $informe1["especificacion"];
    $EnsayoId = $informe1["id_ensayo"];
    $TipoMuestra = $informe1["id_formula_farma"];
    $Plantilla = $informe1["id_plantilla"];

    if ($Plantilla == 6 || $Plantilla == 8 || $Plantilla == 18 || $Plantilla == 9 || $Plantilla == 10 || $Plantilla == 195 || $Plantilla == 1821 || $Plantilla == 2008 || $Plantilla == 2364 || $Plantilla == 31 || $Plantilla == 129 || $Plantilla == 1848 || $Plantilla == 2361 || $Plantilla == 34 || $Plantilla == 62 || $Plantilla == 323 || $Plantilla == 2127 || $Plantilla == 2365 || $Plantilla == 286) {
        $cuadroControlPlantilla = true;
    } else if ($Plantilla == 262) {
        $cuadroControlPlantilla = true;
        $cuadroControlEstandar = true;
    }

    $pdf->Ln(0);
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
//saco el resultado por pantalla
    $Especificacion = preg_replace($exp_regular, $cadena_nueva, $Especificacion1);


    if ($EnsayoId == '1') {// valida si es descripcion el ensayo,En caso de que sea DESCRIPCION, no sale nada
        $pdf->Cell(1, 1, (''), 0, 0, 'C');
    }//Cierra else
    //$pdf->Cell(180,6,utf8_decode('Plantilla '. $Plantilla . 'y Tipo Muestra: ' . $TipoMuestra),1,0,'C',True);// True permite que asigne el color
    //  if($TipoMuestra == '2'){// MATERIA PRIMA
    // Plantillas según analisis de MP
    if ($Plantilla == '2') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 'LTR', L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);       
//            $pdf->Cell(180,6,utf8_decode('Datos del (los) Estándar (es)'),1,0,'C',True);// True permite que asigne el color
//            $pdf->Cell(90,6,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(6);
    }  // Identificación por HPLC
    if ($Plantilla == '3') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion . '            CUMPLE :  SI[    ]   NO[    ]'), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);

        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }

        $pdf->Cell(180, 6, utf8_decode('Estándar'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Longitud de Onda'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Espectrofotómetro: EL-042 '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Identificación por UV
    if ($Plantilla == '4') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(30, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('1'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('2'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('3'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('4'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('5'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('6'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('7'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('8'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('9'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('10'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Promedio'), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Promedio 20 unidades: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Peso promedio Tabletas y cápsulas
    if ($Plantilla == '5') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('P. Inicial'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('P. Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('P. Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('P. Final'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('W1 (P. final - P. Inicial) (Wm1)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('W2 (P. Muestra)  (Wm2)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('W3 (P. filtrado - P. inicial)  (Wm3)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Dilución (mL) (Dil)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=((100*Wm1)*(Dil+Wm2))/((Wm2*Wm3)*(1-(0,01*H)))'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Contenido de material hidrosoluble Croscarmelosa sódica
    if ($Plantilla == '6') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }


        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Disolutor: EL-018 [   ]    EL-041 [   ]   Balanza __________'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equipo: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Activo = 100*(Rmd*Psd*P*Dd)/(Rs*Cd*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Disolución 
    if ($Plantilla == '7') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(50, 6, utf8_decode('p. muestra/mL'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Equipo '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('EL-015 [   ]     EL-047 [   ]'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // pH
    if ($Plantilla == '8') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Estándar:'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Muestra:'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 1 (Pm): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Dilución:'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Dilución:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);

        if ($TipoMuestra == 2) {

            $pdf->Cell(180, 6, utf8_decode(' ______ de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('______ de Activo en B. S. = (de Activo en B. H. Promedio)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        } else {
            if ($clienteid == 17 OR $clienteid == 97) {//para clientes biotecno y alura
                $pdf->Cell(180, 6, utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 1, 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, utf8_decode('% Declarado = 100* % de activo promedio )/ Cd'), 1, 0, 'L');
            }


            $pdf->Cell(180, 6, utf8_decode('_____ de Activo = (Rm*Ps*P*_____*D)/(Rs*___)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo             Promedio)/Cd'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            // $pdf->Ln(6);       
            if ($TipoMuestra == 2) {
                $pdf->Cell(180, 6, utf8_decode('Uniformidad de Dosis : % Activo = (Pcd*Pj)/Cp'), 1, 0, 'L');
            }
        }
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Resolución:'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('Equipo '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 1, 0, 'C');
        $pdf->Ln(6);
    }   // Valoración por HPLC
    if ($Plantilla == '9') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Estándar:'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Muestra:'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Peso/Dilución:'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Peso/Dilución:'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 1 (Pm): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 1 (Pm): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 'LRT', 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Activo en B. S. = (% de Activo en B. H. Promedio)*100/(100-H)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
//            $pdf->Cell(90,6,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
//            $pdf->Ln(6);
    }   // Valoración por GASES  SIN EVALUAR
    if ($Plantilla == '195') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Estándar:'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Muestra:'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 1 (Pm): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Dilución:'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Dilución:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);

        if ($TipoMuestra == 2) {

            $pdf->Cell(180, 6, utf8_decode(' ______ de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('______ de Activo en B. S. = (de Activo en B. H. Promedio)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        } else {
            if ($clienteid == 17 OR $clienteid == 97) {//para clientes biotecno y alura
                $pdf->Cell(180, 6, utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 'LRT', 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, '', 'LR', 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
                $pdf->Ln(6);
                $pdf->Ln(6);
                $pdf->Cell(180, 6, utf8_decode('% Declarado = 100* % de activo promedio )/ Cd'), 'LRT', 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, '', 'LR', 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
                $pdf->Ln(6);
            }


            $pdf->Cell(180, 6, utf8_decode(' _____ de Activo       =    (Rm*Ps*P*_____*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo             Promedio)/Cd'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            // $pdf->Ln(6);       
            if ($TipoMuestra == 2) {
                $pdf->Ln(6);
                $pdf->Cell(180, 6, utf8_decode('Uniformidad de Dosis : % Activo = (Pcd*Pj)/Cp'), 'LRT', 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, '', 'LR', 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            }
        }
        $pdf->Ln(6);
//            $pdf->Cell(180,16,utf8_decode('Fase Móvil'),1,0,'L');
//            $pdf->Ln(16);
//            $pdf->Cell(180,12,utf8_decode('Resolución'),1,0,'L');
//            $pdf->Ln(12);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL 042 '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 1, 0, 'C');
        $pdf->Ln(6);
    }   // Valoración por UV
    if ($Plantilla == '10') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Factor'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Lote'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equivalente: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Muestra 1 (mg) [Pm1]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 1 (mL) [Vc1]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Muestra 2 (mg) [Pm2]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 2 (mL)[Vc2]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode('Blanco (Vb)'), 1, 0, 'L');
        $pdf->Cell(140, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        if ($TipoMuestra == 2) {
            $pdf->Cell(180, 6, utf8_decode(' % en Base Húmeda= 100*((           )*Eq*Fti)/Pm'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('% en Base Seca= (% Promedio en B. H.)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        } else {
            $pdf->Cell(180, 6, utf8_decode(' ____ de Activo/______________=______________(Vc-______*Eq*Fti)/(      )'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo/             Promedio)/Cd'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        }
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Valoración por volumetria
    if ($Plantilla == '13') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(45, 6, utf8_decode('Hora inicial'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Hora final'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Temperatura'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Número'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('P Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Ini. (Pmi)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Fin. (Pmf)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=100*(Pmi-Pmf)/(Pmi-Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-013, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Pérdida por secado
    if ($Plantilla == '14') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(40, 6, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Dilución'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Solvente'), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode('Clasificación'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Solubilidad
    if ($Plantilla == '15') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(50, 6, utf8_decode('Peso'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Equipo KF'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('EL-009, Balanza EL-002'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Agua KF Determinación de Agua Método I
    if ($Plantilla == '16') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Punto de Fusión'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Equipo'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('EL-045'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 140, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(140);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Punto de Fusión
    if ($Plantilla == '17') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(45, 6, utf8_decode('Hora inicial'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Hora final'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Temperatura'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Número'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('P Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Ini. (Pmi)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Fin. (Pmf)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo %=100-((100*Pmf-Pmi)/(Pmi-Pv))'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-048, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Residuo de Incineración Residuos de ignición
    if ($Plantilla == '18') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps)'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equipo'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Resolución:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Unformidad % de Activo = (Rmu*Ps*P*Du)/(Rs*Cd)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        // Uniformidad de contenido 
        if ($ocultarCampos == 0) {
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Uniformidad de contenido 
    if ($Plantilla == '19') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);

        if ($ocultarCampos == 0) {
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 18, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(18);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 18, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(18);

        //Se adicionan campos de ruido y condiciones cromatograficas para HPLC
        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 1, 0, 'C');
        $pdf->Ln(6);
        //          $pdf->Cell(180,6,utf8_decode('Verificación'),1,0,'L');
        //$pdf->Ln(6);
    }  // Impurezas orgánicas - Compuestos Relacionados HPLC
    if ($Plantilla == '20') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(40, 6, utf8_decode('Muestra (Pm)'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('P. Inicial (Pi)'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('P. Final (Pf)'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Cálculo'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('(100*(Pf-Pi)/Pm)'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Sustancias Insolubles - Sustancias Hidrosolubles
    if ($Plantilla == '21') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(50, 6, utf8_decode('Control'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('P. muestra'), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Límites varios
    if ($Plantilla == '26') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(120, 6, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode('Factor Fti'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(120, 6, utf8_decode('Lote'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode('Equivalente:  '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Muestra 1 (mg) [Pm1]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 1 (mL) [Vc1]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Muestra 2 (mg) [Pm2]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 2 (mL)[Vc2]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode('Blanco (Vb)'), 1, 0, 'L');
        $pdf->Cell(140, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        if ($TipoMuestra == 2) {
            $pdf->Cell(180, 6, utf8_decode(' % en Base Húmeda= 100*((          )*Eq*Fti)/Pm'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('% en Base Seca= (% Promedio en B. H.)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        } else {
            $pdf->Cell(180, 6, utf8_decode(' ____ de Activo/          =    (Vc*Eq*Fti)/(     )'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo/             Promedio)/Cd'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        }
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Titulación volumétrica
    if ($Plantilla == '27') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(50, 6, utf8_decode('Lectura'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Angulo (°)'), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('P. Muestra g (Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('1.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Dilución D: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('2.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Longitud (dm): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('3.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Resultado: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('4.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Cálculo=(100*Angulo)/(dm*Conc): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('5.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Concentración=(Pm*((100-%H)/100)/ D)*100'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode('Promedio:'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Equipo: EL-023, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Rotación Específica  
    if ($Plantilla == '28') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(100, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Equipo: EL-045'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 140, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(140);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Punto de Fusión -  Temperatura de Fusión
    if ($Plantilla == '29') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);

        $pdf->Cell(45, 6, utf8_decode('Hosa inicial'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Hora final'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Temperatura'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Número'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);

        $pdf->Cell(45, 6, utf8_decode('P Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Ini (Pmi)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P Muestra Fin (Pmf)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);


        $pdf->Cell(180, 6, utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-048, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Peso Pesos Varios
    if ($Plantilla == '30') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Resultado: '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Apariencia de la solución
    if ($Plantilla == '31') {
        //if ($Plantilla != '18') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Disolución: _____________Etapa ________________________'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Disolutor: EL-018 [   ]     EL-041 [   ]     Balanza __________'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Equipo:'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Activo = 100*(Rmd*Psd*P*Dd)/(Rs*Cd*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Disolución: _____________Etapa ________________________'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Disolutor:  EL-018 [   ]      EL-041 [   ]     Balanza __________'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Activo = 100*(Rmd*Psd*P*Dd)/(Rs*Cd*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Disolución: _____________Etapa ________________________'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Disolutor: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Activo = 100*(Rmd*Psd*P*Dd)/(Rs*Cd*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Gastrorresistencia Disolución VARIAS HORAS
    if ($Plantilla == '33') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(36, 6, utf8_decode('1.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('2.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('3.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('4.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('5.'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode('6.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('7.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('8.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('9.'), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode('10.'), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 6, utf8_decode('Resultado:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Peso neto uniformidad de dosis
    if ($Plantilla == '34') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Muestra: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resolución: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(100, 12, utf8_decode('Resultado: '), 1, 0, 'C');
        $pdf->Cell(80, 12, utf8_decode('CUMPLE   SI[   ]    NO[   ] '), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(90, 6, utf8_decode('BALANZA: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('HPLC: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('  '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('  '), 1, 0, 'L');
        $pdf->Ln(6);
    }  // Pureza Cromatográfica
    if ($Plantilla == '36') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 14, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(14);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE   SI[   ]    NO[   ]'), 1, 0, 'C');
        $pdf->Ln(6);
    }  // Jeringabilidad  o un solo campo Alcalinidad
    if ($Plantilla == '38') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Lote/Normalidad HCI (N)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Factor Titulante (F)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Volumen Blanco (Vb)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Volumen Muestra (Vm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Peso muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=((Vb-Vm)*56,11*N*F)/Pm'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Indice de Saponificación
    if ($Plantilla == '44') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(50, 6, utf8_decode('P. Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('P. + muestra (Pm)'), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Volumen (V)'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=(Pm-Pv)/ V'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Densidad 
    if ($Plantilla == '49') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(60, 6, utf8_decode('Peso Muestra (Pm)'), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode('Peso vacio (Pv)'), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode('Peso Final (Pf)'), 1, 0, 'C');

        $pdf->Ln(6);
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');

        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=100*(Pf-Pv)/(Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Alcoholes
    if ($Plantilla == '51') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(36, 6, utf8_decode('P Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode('P + muestra (Pm)'), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode('Peso+Agua (PH2O)'), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode('Cálculo'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(36, 6, utf8_decode('(Pm-Pv)/ (PH2O-Pv)'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   //Gravedad especifica- peso especifico
    if ($Plantilla == '52') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Blanco'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(60, 6, utf8_decode('Máximo 0,4 a 240 nm'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode('Máximo 0,3 a 250 nm - 260 nm'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode('Máximo 0,1 a 270 nm - 340 nm'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Espectrofotómetro UV:  EL-042'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Absorción en el UV
    if ($Plantilla == '62') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(30, 6, utf8_decode('Vial'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('P. Inicial'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('P. Final'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('P. Neto'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('1.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('2.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('3.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('4.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('5.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('6.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('7.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('8.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('9.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('10.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(130, 6, utf8_decode('Contenido Promedio:'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Uniformidad de Dosis Viales
    if ($Plantilla == '67') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(45, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('W lleno'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('W vacío'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('W producto'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('1'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('2'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('3'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('4'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('5'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('6'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('7'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('8'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('9'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('10'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Promedio:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Peso de Llenado
    if ($Plantilla == '69') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(20, 6, utf8_decode('Muestra (Pm): '), 1, 0, 'L');
        $pdf->Cell(30, 6, utf8_decode('P. Vacío (Pv)): '), 1, 0, 'L');
        $pdf->Cell(30, 6, utf8_decode('P. Final  (Pf): '), 1, 0, 'L');
        $pdf->Cell(30, 6, utf8_decode('Resultado: '), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode('Cálculo=100*(Pf-Pv)/Pm: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // ácidos grasos libres
    if ($Plantilla == '70') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('Lote/Normalidad Na2S2O3 (N)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Factor Titulante (F)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Volumen Blanco (Vb)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Volumen Muestra (Vm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Peso muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Cálculo=((Vb-Vm)*126,9*N*F)/(Pm*10)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Indice de Yodo
    if ($Plantilla == '71') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Lote/Normalidad NaOH (N)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Factor Titulante (F)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Volumen Muestra (Vm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Peso muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=(Vm*56,11*N)/Pm'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Indice de Acidez
    if ($Plantilla == '72') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 12, utf8_decode('Muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Estándar (Ps)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Solución de aptitud del sistema: '), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% Limite p-Aminofenol libre =(Rm*Ps*P*D)/(Rs*Pm)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('HPLC:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // p-aminofenol libre Materia prima
    if ($Plantilla == '75') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('Lote/Normalidad Na2S2O3 (N)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Factor Titulante (F)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Volumen Blanco (Vb)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Volumen Muestra (Vm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Peso muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Cálculo=10((Vm-Vb)*1000*N*F)/Pm'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Indice de Peróxido
    if ($Plantilla == '76') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('P Vacío (Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('P muestra Ini. (Pmi)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('P muestra Fin. (Pmf)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Residuo de Evaporación
    if ($Plantilla == '78') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('Lote/Normalidad HCI (N)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Factor Titulante (F)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Volumen Blanco (Vb)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Volumen Muestra (Vm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Peso muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Cálculo índice de Saponificación (S) =((Vb-Vm)*56,11*N*F)/Pm'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Cálculo Grado de Hidrólisis= 100-((7,84S/(100-0,075S))'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Grado de hidrólisis
    if ($Plantilla == '79') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(45, 6, utf8_decode('Muestra/Dilución'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Titulante'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Lote'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Factor'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Resultado: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Límite de dioxido de azufre
    if ($Plantilla == '80') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('P Vacío (Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('P muestra Ini. (Pmi)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('P muestra Fin. (Pmf)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('Equipo: EL-048, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Residuos de ignición
    if ($Plantilla == '90') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        /* $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
          $pdf->Ln(0);
          $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
          $pdf->Ln(0); */
        $pdf->Cell(60, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode('Conductividad H2O'), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode('Conductividad muestra'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo EL-049'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Conductividad
    if ($Plantilla == '93') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('P. Muestra'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Vol. Mtra.'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Magnesio y Metales Alcalinos
    if ($Plantilla == '94') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode('Control'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('P. Muestra'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Sulfatos
    if ($Plantilla == '95') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Estándar'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Blanco'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Absorbancia'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Longitud de Onda'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Espectrofotómetro UV:  EL-042'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Nitritos (UV)
    if ($Plantilla == '129') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Disolución y Totalidad de la solución
    if ($Plantilla == '168') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(20, 6, utf8_decode('Muestra'), 1, 0, 'C', TRUE);
        $pdf->Cell(39, 6, utf8_decode('Long. Tapa (mm)'), 1, 0, 'C', TRUE);
        $pdf->Cell(39, 6, utf8_decode('Long. Cuerpo (mm)'), 1, 0, 'C', TRUE);
        $pdf->Cell(40, 6, utf8_decode('Diametro Ext.Tapa (mm)'), 1, 0, 'C', TRUE);
        $pdf->Cell(42, 6, utf8_decode('Diametro Ext. Cuerpo (mm)'), 1, 0, 'C', TRUE);
        //$pdf->Cell(40,12,utf8_decode('Peso (mg)'),LTB,0,'C'); 
        $pdf->Ln(6);
//            $pdf->Cell(20,12,utf8_decode(''),LRB,0,'C'); 
//            $pdf->Cell(30,12,utf8_decode('(mm)'),LRB,0,'C'); 
//            $pdf->Cell(30,12,utf8_decode('(mm)'),LRB,0,'C'); 
//            $pdf->Cell(30,12,utf8_decode('Tapa (mm)'),LRB,0,'C'); 
//            $pdf->Cell(30,12,utf8_decode('Cuerpo (mm)'),LRB,0,'C'); 
//            //$pdf->Cell(40,12,utf8_decode(''),LRB,0,'C'); 
//            $pdf->Ln(6);
        //$pdf->Cell(18,6,'Cliente:',LTB,0,'L'); L: left T: top  R: right  B: bottom
        //$pdf->Cell(72,6,substr($Direccion,0,34),TBR,0,'L');
        $pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('4'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('5'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('6'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('7'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('8'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('9'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('10'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('PROMEDIO'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Dimensiones
    if ($Plantilla == '173') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(90, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(90, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(45, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Volumen (mL)'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('1'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('2'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('3'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('4'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('5'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('6'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('7'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('8'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('9'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('10'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Promedio'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Volumen de Entrega
    if ($Plantilla == '186') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Diasteroisómero RS-SR= 100*((RA)/(RA+RB))'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(12);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Relacion de Diasteroisómeros
    if ($Plantilla == '190') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Muestra/Dilución'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Factor'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Lote'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Límite de dióxido de azufre
    /* if ($Plantilla == '195') {
      $pdf->SetFont('Arial', 'B', 9);
      $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
      $pdf->SetFont('Arial', '', 9);
      $pdf->Ln(6);
      $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
      $pdf->Ln(0);
      $pdf->Cell(90, 6, utf8_decode('Titulante'), 1, 0, 'L');
      $pdf->Cell(90, 6, utf8_decode('Factor'), 1, 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(90, 6, utf8_decode('Lote'), 1, 0, 'L');
      $pdf->Cell(90, 6, utf8_decode('Equivalente: '), 1, 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(45, 6, utf8_decode('Muestra 1 (mg) [Pm1]'), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 1 (mL) [Vc1]'), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(45, 6, utf8_decode('Muestra 2 (mg) [Pm2]'), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 2 (mL)[Vc2]'), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(40, 6, utf8_decode('Blanco (Vb)'), 1, 0, 'L');
      $pdf->Cell(140, 6, utf8_decode(''), 1, 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
      $pdf->Ln(6);
      if ($TipoMuestra == 2) {
      $pdf->Cell(180, 6, utf8_decode(' % en Base Húmeda= 100*((           )*Eq*Fti)/Pm'), 'LRT', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 12, '', 'LR', 0, 'L');
      $pdf->Ln(12);
      $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, utf8_decode('% en Base Seca= (% Promedio en B. H.)*100/(100-H)'), 'LRT', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 12, '', 'LR', 0, 'L');
      $pdf->Ln(12);
      $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
      $pdf->Ln(6);
      } else {
      $pdf->Cell(180, 6, utf8_decode(' ____ de Activo/______________=______________(Vc*Eq*Fti)/(      )'), 'LRT', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, '', 'LR', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo/             Promedio)/Cd'), 'LRT', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, '', 'LR', 0, 'L');
      $pdf->Ln(6);
      $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
      $pdf->Ln(6);
      }
      $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
      $pdf->Ln(6);
      }  // Valoración por volumetria */
    if ($Plantilla == '199') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 'LTR', L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Espectrómetro:  EL-057'), 1, 0, 'L');
        $pdf->Ln(6);
    }  // Identificación por HPLC
    if ($Plantilla == '204') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Peso Mta/dil'), 1, 0, 'L');
        $pdf->Ln(6);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla); //potencia_est
            $ocultarCampos++;
        }

        $pdf->Cell(180, 16, utf8_decode('Fase Móvil: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Estándar: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 18, utf8_decode('Resultado:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Identificación, PUR/IMP. ORGANICAS x TLC
    if ($Plantilla == '209') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 14, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(14);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-042'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Tonalidad y color de la solución
    if ($Plantilla == '262') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla); //potencia_est
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('ESTÁNDAR LIMITE DE CUANTIFCACIÓN (Ps): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('ESTÁNDAR LIMITE DE DETECCIÓN: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('DILUCIÓN MUESTRA: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('NÚMERO DE PUNTOS: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('DILUENTE'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 13, utf8_decode('FASE MÓVIL: '), 1, 0, 'L');
        $pdf->Ln(13);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo: '), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('µg de Activo/muestra= 1000*(Rm*Ps*P*D)/(Rs*100)'), 'LR', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('HPLC: '), 1, 0, 'L');
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Trazas
    if ($Plantilla == '286') {
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla); //potencia_est
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Peso/Dilución'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('%DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equipo:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra (mg)'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('%DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Resolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(80, 6, utf8_decode('Diluciones Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('mg Activo/mezcla=(Rm*Ps*P*D*Cm)/(Rs*Pm*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de activo = mg Activo/mezcla*100/Cantidad declarada)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 1, 0, 'C');
        $pdf->Ln(6);
    } // Uniformidad de Mezcla
    if ($Plantilla == '323') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(20, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode('P Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode('P muestra Ini (Pmi)'), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode('P Muestra Fin (Pmf)'), 1, 0, 'C');


        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);

        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);

        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(53, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);


        $pdf->Cell(180, 6, utf8_decode('Cálculo %=100*(Pf-Pv)* ____ /(Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Sulfato de Sodio
    if ($Plantilla == '1802') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de Dimero (Ri*Ps*P*D*Pp*Fcon)/(Rs*Pm*Cd*Fimp)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(12);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Límite de Dmero 
    if ($Plantilla == '1810') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion . '            CUMPLE :  SI[    ]   NO[    ]'), 1, L, FALSE);
        $pdf->Ln(6);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Identificaciones (BIDONES) - Peso (mg)'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(180, 16, utf8_decode('Diluente:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Resolución:'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(90, 6, utf8_decode('Estándar'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('HPLC '), 1, 1, 'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(6);
    }//Identificaion BIDONES 
    if ($Plantilla == '1820') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(30, 6, utf8_decode('Lectura'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Angulo M1(°)'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Angulo M2(°)'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Peso M1 (mg)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('1.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('2.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Peso M2 (mg)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('3.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('4.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Dilución (mL)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('5.'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Promedio'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Longitud (dm)[Lt]: 1 '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('%DER CUMPLE SI[  ] NO[  ]'), 1, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('g de Dextrosa/Sobre=(D*Re*Pps)/(52,9*Lt*Pm)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de lo Declarado=100*(g de Activo/sobre Promedio)/Cd'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-023, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// Titulación polarimetrica Dextrosa en sales
    if ($Plantilla == '1828') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Factor'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Lote'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equivalente: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra M1'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra M2'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Blanco'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mL'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('mV'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// Titulación Potenciometrica
    if ($Plantilla == '1821') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Valoración Volumétrica'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Estándar 1 (Ps1)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vs1) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Estándar 2 (Ps2)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vs2) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Muestra 1 (Pm1)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vc1) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Muestra 2 (Pm2)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vc2) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de activo=100*(Ps*P*Vm)/(Pm*Vs*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Valoración CARBONATO DE CALCIO VOLUMETRICA
    if ($Plantilla == '1833') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);

        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración{//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 12, utf8_decode('Muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 12, utf8_decode('Estándar (Ps)'), 1, 0, 'L');
        $pdf->Ln(12);

        $pdf->Cell(180, 12, utf8_decode('Solución de aptitud del sistema: '), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'C', true);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% Limite p-Aminofenol libre =(Rm*Ps*P*D*___)/((Rs-Rm)*Pm*Cd)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('HPLC:'), 1, 0, 'L');
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// P-aminofenol libre Producto Terminado
    if ($Plantilla == '1848') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('%DER CUMPLE SI [  ]     NO [  ]'), 1, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Disolutor:     EL-018 [   ]     EL-041 [   ]     Balanza __________'), 1, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode('Peso vacío'), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode('Peso con Muestra'), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode('Peso Neto (Peso con Mta - Peso vacío)'), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode('Dilución:'),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D1'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');

        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D2'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D3'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D4'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        // $pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D5'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        // $pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D6'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Dilución muestra:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L', False);
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
//+
        $pdf->Cell(180, 6, utf8_decode('% de Activo = ______ * 100 *(Rmd*Ps*P*Dd*_____)/(Rsd*Pm * Cd)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// Disolución con peso
    if ($Plantilla == '1864') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Estándar A:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar B:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar C:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Solución Prueba A:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Solución Prueba A:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Solución Prueba B:'), 1, 0, 'L');
        $pdf->Ln(6);
        /* $pdf->MultiCell(180, 6, utf8_decode('Impureza A . Cualquier mancha debido a la impureza A. no es más intensa que la mancha obtenida en el cromatograma obtenido con la solución estándar (c) no más de 0,1%:'), 1, 1, 'L');
          $pdf->Ln(6); */
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Sustancias Relacionadas  por TLC
    if ($Plantilla == '1940') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 6, utf8_decode('%DER CUMPLE SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Disolutor:     EL-018 [   ]     EL-041 [   ]     Balanza __________'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode('Peso vacío'), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode('Peso con Muestra'), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode('Peso Neto (Peso con Mta - Peso vacío)'), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode('Dilución:'),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D1'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');

        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D2'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D3'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D4'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        // $pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D5'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        // $pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(15, 6, utf8_decode('D6'), 1, 0, 'L');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(54, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(57, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Dilución muestra:'), 1, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L', False);
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('g de Activo/100g = 100*(Rmg*Ps*P*Dg)/(Rs*Pmg*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// Disolución Gastrorresistencia
    if ($Plantilla == '2008') {
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(90, 6, utf8_decode('Estándar:'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Muestra:'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Peso/Dilución:'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Peso/Dilución:'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 1 (Pm): '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Muestra 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(' '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('       %DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);

        if ($TipoMuestra == 2) {

            $pdf->Cell(180, 6, utf8_decode(' __ de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ de Activo en B. S. = (de Activo en B. H. Promedio)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        } else {
//            if($clienteid==17 OR $clienteid==97){//para clientes biotecno y alura
//            
//            $pdf->Cell(180,6,utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'),1,0,'L');
//            $pdf->Ln(6);            
//            $pdf->Cell(180,6,utf8_decode('% Declarado = 100* % de activo promedio )/ Cd'),1,0,'L');
//               }
//               

            $pdf->Cell(180, 6, utf8_decode(' _____ de Activo       =    (Rm*Ps*P*Ro*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo             Promedio)/Cd'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('Densidad'), 1, 0, 'C', True);
            $pdf->Ln(6);
            $pdf->Cell(20, 6, utf8_decode('Muestra'), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode('P. Vacío (Pv)'), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode('P. + muestra (Pm)'), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode('Volumen (V)'), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode('Resultado: '), 1, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Ln(6);
            $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
            $pdf->Ln(6);
//            $pdf->Cell(180,6,utf8_decode('Densidad Muestra:'),1,0,'L');
//            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('Cálculo=(Pm-Pv)/ V'), 1, 0, 'L');
            $pdf->Ln(6);

            // $pdf->Ln(6);       
            if ($TipoMuestra == 2) {
                $pdf->Cell(180, 6, utf8_decode('Uniformidad de Dosis : % Activo = (Pcd*Pj)/Cp'), 1, 0, 'L');
            }
        }
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil:'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Resolución:'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(90, 6, utf8_decode('Equipo '), 1, 1, 'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Valoración por HPLC con Densidad
    if ($Plantilla == '2127') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(30, 6, utf8_decode('Peso muestra'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('W picnómetro lleno'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('W picnómetro vacio'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Volumen picnómetro'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Densidad'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('1.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('2.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('3.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('4.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('5.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('6.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('7.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('8.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('9.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('10.'), 1, 0, 'L');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
//            $pdf->Cell(130,6,utf8_decode('Contenido Promedio:'),1,0,'C');
//            $pdf->Cell(50,6,utf8_decode(' '),1,0,'C');
//	    $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Dilución'), 1, 0, 'L');
        $pdf->Cell(150, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('HPLC'), 1, 0, 'L');
        //$pdf->Cell(150,6,utf8_decode('HPLC '),1,0,'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }   // Uniformidad de Dosis en Liquidos
    if ($Plantilla == '2129') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Absorbancia'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-042'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Transparencia y color de la Solución (UV)
    if ($Plantilla == '2131') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Nombre'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Lote'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Pureza  (P)'), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('FV'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar   '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar    '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Estándar    '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('    '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 12, utf8_decode('Cumple    SI [    ]      NO [    ]'), 1, 0, 'L');
        $pdf->Ln(12);
    }//Identificación con Estandar 
    if ($Plantilla == '2357') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion . '            CUMPLE :  SI[    ]   NO[    ]'), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Identificaciones'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(36, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(12);
        $pdf->Cell(180, 16, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Equipo'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, utf8_decode('Resolución:'), 1, 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(90, 6, utf8_decode('Estándar'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('HPLC '), 1, 1, 'L'); // el segundo parametro 1 genera un salto de linea
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Identificación materia prima
    if ($Plantilla == '2358') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(45, 6, utf8_decode('Hora inicial'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Hora final'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Temperatura'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Número'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('P Vacío (Pv)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Ini. (Pmi)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('P muestra Fin. (Pmf)'), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode('Resultado'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(45, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo=100*(Pmi-Pmf)/(Pmi-Pv)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: EL-048, Balanza EL-002'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }  // Pérdida por ignición
    if ($Plantilla == '2359') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Lote/Normalidad NaOH (N)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Factor Titulante (F)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Volumen Muestra (Vm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Peso muestra (Pm)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE   SI[   ]    NO[   ]'), 1, 0, 'C');
        $pdf->Ln(6);
    }  // Acidez con muestra
    if ($Plantilla == '2360') {
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Dato tomado del certificado del proveedor'), 1, 0, 'L');
        $pdf->Ln(6);
    }//Dato tomado del certificado del proveedor
    if ($Plantilla == '2361') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Condiciones: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Medio de Disolución: '), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('%DER CUMPLE SI [  ]     NO [  ]'), 1, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Disolutor:     EL-018 [   ]     EL-041 [   ]     Balanza __________'), 1, 0, 'L');

        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Equipo: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode('Peso muestra'), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode('Dilución:'),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('D1'), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');

        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('D2'), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('D3'), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('D4'), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode(' '), 1, 0, 'C');
        // $pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('D5'), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode(' '), 1, 0, 'C');
        // $pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('D6'), 1, 0, 'L');
        $pdf->Cell(160, 6, utf8_decode(' '), 1, 0, 'C');
        //$pdf->Cell(60,6,utf8_decode(' '),1,0,'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Dilución muestra:'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 16, utf8_decode('Fase Móvil'), 1, 0, 'L', False);
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
//+
        $pdf->Cell(180, 6, utf8_decode('% de Activo = ______ * 100 *(Rmd*Ps*P*Dd*_____)/(Rsd*Pm * Cd)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Disolución de solución con peso
    if ($Plantilla == '2362') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Peso/Disolución'), 1, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->Cell(40, 6, utf8_decode('Estándar 1 (Ps)'), 1, 0, 'C', false);
        $pdf->Cell(140, 6, '', 1, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra'), 1, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 6, utf8_decode('LQF'), 1, 0, 'C', false);
        $pdf->Cell(140, 6, utf8_decode('Peso/Disolución'), 1, 0, 'C', false);
        $pdf->Ln(6);

        $pdf->Cell(40, 6, '', 1, 0, 'C', false);
        $pdf->Cell(140, 6, '', 1, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->Cell(40, 6, '', 1, 0, 'C', false);
        $pdf->Cell(140, 6, '', 1, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->Cell(40, 6, '', 1, 0, 'C', false);
        $pdf->Cell(140, 6, '', 1, 0, 'C', false);
        $pdf->Ln(6);
        $pdf->Cell(40, 6, '', 1, 0, 'C', false);
        $pdf->Cell(140, 6, '', 1, 0, 'C', false);
        $pdf->Ln(6);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'C', true);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(180, 6, utf8_decode('µg de Activo/ mL de Solución= (Rm*Ps*P*D*1000)/(Rs*Vm*100)'), 1, 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Diluente'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Fase móvil'), 'LRT', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LR', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resolución'), 'LRT', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LR', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LR', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'C', false);
        $pdf->Ln(6);

        $pdf->Cell(120, 6, utf8_decode('El área del pico de p-cloroanilina en el cromatograma '
                        . 'de la muestra no es mayor'), 'LTR', 0, 'L', false);
        $pdf->Cell(60, 6, '', 'LRT', 0, 'L', false);
        $pdf->Ln(6);
        $pdf->Cell(120, 6, utf8_decode('que el del estándar'), 'LRB', 0, 'L', false);
        $pdf->Cell(60, 6, '', 'LRB', 0, 'L', false);
        $pdf->Ln(6);

        ruidoCondicionesCromatograficas();

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Límite de p-Cloroanilina
    if ($Plantilla == '2363') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        /* $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
          $pdf->Ln(0); */
        $pdf->Cell(180, 6, utf8_decode('Informativo'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(120, 6, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode('Factor Fti'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(120, 6, utf8_decode('Lote'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode('Equivalente'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Muestra 1 (mg) [Pm1]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 1 (mL) [Vc1]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Muestra 2 (mg) [Pm2]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('Vol. cons. Mtra 2 (mL)[Vc2]'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('Blanco (Vb)'), 1, 0, 'L');
        $pdf->Cell(135, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode(' % de Activo = 100*((Vc-Vb)*Equiv*Fti)/Pm'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        if ($TipoMuestra == 2) {
            $pdf->Cell(180, 6, utf8_decode('% en Base Seca= (% Promedio en B. H.)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        }
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } // Contenido de bicarbonato
    if ($Plantilla == '2364') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 6, utf8_decode('Estándar'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Peso/Dilución'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps): '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('%DER CUMPLE'), 1, 0, 'C');
        $pdf->Cell(90, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);

        if ($TipoMuestra == 2) {

            $pdf->Cell(180, 6, utf8_decode(' ______ de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('______ de Activo en B. S. = (de Activo en B. H. Promedio)*100/(100-H)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
            $pdf->Ln(6);
        } else {
            if ($clienteid == 17 OR $clienteid == 97) {//para clientes biotecno y alura
                $pdf->Cell(180, 6, utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'), 1, 0, 'L');
                $pdf->Ln(6);
                $pdf->Cell(180, 6, utf8_decode('% Declarado = 100* % de activo promedio )/ Cd'), 1, 0, 'L');
            }


            $pdf->Cell(180, 6, utf8_decode(' _____ de Activo       =    (Rm*Ps*P*_____*D)/(Rs*Pm)'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 6, utf8_decode('__ Declarado = 100*( __ de Activo             Promedio)/Cd'), 'LRT', 0, 'L');
            $pdf->Ln(6);
            $pdf->Cell(180, 12, '', 'LR', 0, 'L');
            $pdf->Ln(12);
            $pdf->Cell(180, 6, '', 'LR', 0, 'L');
            //$pdf->Ln(6);       
            if ($TipoMuestra == 2) {
                $pdf->Cell(180, 6, utf8_decode('Uniformidad de Dosis : % Activo = (Pcd*Pj)/Cp'), 1, 0, 'L');
            }
        }
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 1, 0, 'C');
        $pdf->Ln(6);
    }// valoración
    if ($Plantilla == '2365') {
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla); //potencia_est
            $ocultarCampos++;
        }
        $pdf->Cell(180, 6, utf8_decode('Peso/Dilución'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Estándar 1 (Ps) '), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Estándar 2 '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('%DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equipo: EL 042'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Muestra (mg)'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(36, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('%DER CUMPLE'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('SI [  ]     NO [  ]'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 16, utf8_decode('Disoluciones Muestra'), 1, 0, 'L');
        $pdf->Ln(16);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el cálculo'), 1, 0, 'L', True);
        $pdf->Ln(6);
        $pdf->Cell(100, 6, utf8_decode('mg Activo=(Rm*Ps*P*D______)/(Rs*Pm*100)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de activo = (Activo/Mezcla______/Cantidad declarada)'), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LR', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// Uniformidad de mezcla por UV
    if ($Plantilla == '2366') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        if ($ocultarCampos == 0) {//permite ocultar campos si ya existen en la plantilla de valoración
            mostrarEstandares($Plantilla);
            $ocultarCampos++;
        }
        $pdf->Cell(90, 6, utf8_decode('Titulante'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Factor'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Lote'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode('Equivalente'), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 6, utf8_decode('Valoración Volumétrica'), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Estándar 1 (Ps1)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vs1) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Estándar 2 (Ps2)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vs2) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Muestra 1 (Pm1)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vc1) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode('Muestra 2 (Pm2)'), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode('Volumen (Vc2) '), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 1, 0, 'C', True);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('% de activo='), 'LRT', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 12, '', 'LR', 0, 'L');
        $pdf->Ln(12);
        $pdf->Cell(180, 6, '', 'LRB', 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }// Validación por titulación con estándar
    if ($Plantilla == '2367') {
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ver uniformidad de contenido'), 1, 0, 'L');
        $pdf->Ln(6);
    }//Ver uniformidad de contenido
    if ($Plantilla == '2368') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode('P. Inicial'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('P. Muestra'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('P. Filtrado'), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode('P. Final'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(45, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(90, 6, utf8_decode('W1 (P. Final - P. Inicial) (Wm1)'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('W2 (P. Muestra) (Wm2)'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('W3 (P. Filtrado - P. Inicial) (Wm3)'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Disolución (mL) (Dil)'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(90, 6, utf8_decode('Humedad'), 1, 0, 'L');
        $pdf->Cell(90, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo = ((100*Wm1)*(Dil+Wm2))/((Wm2*Wm3)*(1-0,01*H))'), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 6, utf8_decode('Resultado'), 1, 0, 'L');
        $pdf->Ln(6);

        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Material Hidrosoluble en Croscarmelosa
    if ($Plantilla == '2369') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
        $pdf->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(0);
        $pdf->Cell(50, 6, utf8_decode('Volumen Inicial (Vi)'), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode('Peso de muestra (Pm)'), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode('Volumen Final (Vf)'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(50, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Resultado: '), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Cálculo= Pm/(Vf-Vi)'), 1, 0, 'L');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    }//Densidad de sólidos
    if ($Plantilla == '2370') {
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Cell(180, 200, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln(200);
        $pdf->Cell(180, 6, utf8_decode('CUMPLE :  SI[    ]   NO[    ]'), 'LRB', 0, 'C');
        $pdf->Ln(6);
    } //peso promedio
    if ($Plantilla == '2371') { // cambiar id
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(180, 6, utf8_decode($Ensayo), 1, 0, 'C', True); // True permite que asigne el color
        $pdf->SetFont('Arial', '', 9);
        $pdf->Ln(6);
        $pdf->MultiCell(180, 6, utf8_decode($Especificacion), 1, L, FALSE);
        $pdf->Ln(0);
		$pdf->Cell(180, 6, utf8_decode('Densidad'), 1, 0, 'C', True); // True permite que asigne el color
		$pdf->Ln();
        $pdf->Cell(39, 6, utf8_decode('P. Vacio (Pv)'), 1, 0, 'C', TRUE);
        $pdf->Cell(39, 6, utf8_decode('P. + muestra (Pm)'), 1, 0, 'C', TRUE);
        $pdf->Cell(40, 6, utf8_decode('Volumen (V)'), 1, 0, 'C', TRUE);
        $pdf->Cell(62, 6, utf8_decode('Resultado'), 1, 0, 'C', TRUE);
        $pdf->Ln(6);
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(62, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
		 $pdf->Cell(180, 6, utf8_decode('Cálculo = (Pm -Pv)/V'), 0, 0, 'C', FALSE);
		$pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('Muestra'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode('Peso Lleno(g)'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode('Peso Vacio(g'), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode('Peso de Producto'), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode('Volumen (mL)'), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('4'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('5'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('6'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('7'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('8'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode('9'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
		$pdf->Cell(20, 6, utf8_decode('10'), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(''), 1, 0, 'C');
        $pdf->Cell(39, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(40, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(42, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(180, 6, utf8_decode('Ecuación para el Cálculo'), 'LRT', 0, 'L');
		$pdf->Ln(6);
		$pdf->Cell(180, 6, utf8_decode('Peso del producto = (Peso Vacio-Peso Lleno)'), 'LR', 0, 'L');
        $pdf->Ln(6);
		$pdf->Cell(180, 6, utf8_decode('Volumen = (Peso del Producto/Densidad)'), 'LRB', 0, 'L');
        $pdf->Ln(6);
    } // Nuevo
	}//Fin Foreach
/////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
$pdf->Ln(18);
$pdf->Cell(180, 6, utf8_decode('Balanza: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea

$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(180, 5, utf8_decode('Observaciones: ____________________________________________________________________________________________________________________'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 5, utf8_decode('___________________________________________________________________________________________________________________________________'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 5, utf8_decode('___________________________________________________________________________________________________________________________________'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 5, utf8_decode('___________________________________________________________________________________________________________________________________'), 0, 0, 'C');


$pdf->Ln(8);
$pdf->Cell(180, 12, utf8_decode('Resultado Fuera de Especificaciones'), 1, 0, 'L');
$pdf->Ln(12);
$pdf->Cell(180, 12, utf8_decode('Verificación'), 1, 0, 'L');
$pdf->Ln(13);
//$pdf->Ln(5);  
//$pdf->Cell(180,170,utf8_decode(''),1,0,'C'); 
//$pdf->Ln(180);
$pdf->Cell(180, 6, utf8_decode('Concepto:'), 1, 0, 'L');
$pdf->Ln(6);
$pdf->Cell(90, 6, utf8_decode('[   ]  Cumple las especificaciones'), 1, 0, 'L');
$pdf->Cell(90, 6, utf8_decode('[   ]  No cumple las especificaciones'), 1, 0, 'L');
$pdf->Ln(30);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(180, 5, utf8_decode('Analizado por: __________________________________________________   Verificado por: _______________________________________'), 0, 0, 'L');
$pdf->Ln(10);
$pdf->Cell(180, 5, utf8_decode('Transcrito por: __________________________________________________   Aprobado por: _______________________________________'), 0, 0, 'L');
$pdf->Ln(10);
if ($cuadroControlPlantilla && $cuadroControlEstandar) {
    $pdf->Ln(6);
    $pdf->Cell(180, 6, utf8_decode('% de DER (Valoración) con estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
    $pdf->Ln(6);
    $pdf->Cell(180, 6, utf8_decode('Promedio de estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
    $pdf->Ln(6);
    $pdf->Cell(180, 6, utf8_decode('Promedio de estándar de control de disolución: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
    $pdf->Ln(6);
    $pdf->Cell(180, 6, utf8_decode('% de DER (Disolución) con estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
    $pdf->Ln(6);
    $pdf->Cell(180, 6, utf8_decode('% de DER entre STD1 y STD2: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
    $pdf->Ln(6);
    $pdf->Cell(180, 6, utf8_decode('% de DER para estándar de pureza: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
    $pdf->Ln(6);
}

$pdf->Output();

function ruidoCondicionesCromatograficas() {
    $pdf = $GLOBALS['pdf'];
    $pdf->Cell(180, 12, utf8_decode('Ruido'), 1, 0, 'L');
    $pdf->Ln(12);
    $pdf->Cell(180, 6, utf8_decode('Verificación de condiciones cromatográficas'), 'TLR', 0, 'T');
    $pdf->Ln(6);
    $pdf->Cell(180, 12, utf8_decode(''), 'BLR', 0, 'T');
    $pdf->Ln(12);
}

function mostrarEstandares($idFormulario) {
    $GLOBALS['cuadroControlEstandar'] = true;
    $tablaLoteEstandar = new TablaLoteEstandarDbModelClass();
    $lotes = $tablaLoteEstandar->obtenerLoteEstandarMuestraActivo($GLOBALS['dato']);
    $pdf = $GLOBALS['pdf'];
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(180, 6, utf8_decode('Datos del (los) Estándar (es)'), 1, 0, 'C', True); // True permite que asigne el color
    $pdf->Ln(6);
    $pdf->Cell(20, 6, utf8_decode('Código'), 1, 0, 'C');
    $pdf->Cell(80, 6, utf8_decode('Nombre'), 1, 0, 'C');
    $pdf->Cell(30, 6, utf8_decode('Lote'), 1, 0, 'C');
    if ($idFormulario == '262' || $idFormulario == '286') {
        $pdf->Cell(30, 6, utf8_decode('Potencia (P)'), 1, 0, 'C');
    } else {
        $pdf->Cell(30, 6, utf8_decode('Pureza  (P)'), 1, 0, 'C');
    }
    $pdf->Cell(20, 6, utf8_decode('FV'), 1, 0, 'C');
    $pdf->Ln(6);
    if ($lotes['code'] == '00000' && $lotes['data'][0] !== null) {
        $data = $lotes['data'];
        foreach ($data as $estandar) {
            $pdf->SetWidths(array(20, 80, 30, 30, 20));
            $pdf->SetAligns(array('C', 'C', 'C', 'C'));
            $pdf->Row2(array(utf8_decode($estandar->codigo_estandar) . '(' . $estandar->stock . ')'
                , utf8_decode($estandar->nombre_estandar)
                , utf8_decode($estandar->lote_estandar)
                , utf8_decode($estandar->pureza)
                , utf8_decode($estandar->fecha_vencimiento)));
        }
    } else {
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(80, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(30, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Cell(20, 6, utf8_decode(' '), 1, 0, 'C');
        $pdf->Ln(6);
    }
}

?>
