<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
//$idMuestra = 259; //debe llegar por post
$ini = $_GET['inicio'];
$fin = $_GET['final'];
$modelReporte = new TablaReportesDbModelClass();

class PDF extends FPDF {

    function Header() {
        //Logo
        $this->Image('../../views/images/logoEmpresa.png', 165, 10, 25);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);
        //Move to the right
        //$this->Cell(1);
        //Title
        $this->Cell(160, 7, utf8_decode('CONSULTA ESTADO DE MUESTRAS'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 10);

        $this->Ln(20);
        $this->SetY(40);
        $this->Cell(180, -5, utf8_decode('ESTADOS DEL ANÁLISIS'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(15, -5, utf8_decode('id'), 1, 0, 'C');
        $this->Cell(20, -5, utf8_decode('Fecha'), 1, 0, 'C');
        $this->Cell(35, -5, utf8_decode('Cliente'), 1, 0, 'C');
        $this->Cell(45, -5, utf8_decode('Producto'), 1, 0, 'C');
        $this->Cell(25, -5, utf8_decode('Area'), 1, 0, 'C');
        $this->Cell(40, -5, utf8_decode('Estado'), 1, 0, 'C');
        $this->Ln(1);
    }

    function Footer() {

        // Position at 1.5 cm from bottom
        $this->SetY(-20);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(180, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
        $this->Ln();
        $this->Cell(90, 5, utf8_decode('REV.00'), 0, 0, 'L');
        $this->Cell(90, 5, utf8_decode('PL-P-008-R-05'), 0, 0, 'R');
        $this->Ln();
        // Print centered page number
        // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
$data1 = $modelReporte->getEstadosdeMuestra($ini, $fin);
$pdf->SetFont('Arial', '', 7);
foreach ($data1 as $informe1) {
    $id = $informe1["id"];

    $numCliente = $modelReporte->numeroCliente($id);
    foreach ($numCliente as $nume) {
        $descrip[] = array(
            $ident = $nume['elnum']
        );
    }
    $fecha = $informe1["fecha_llegada"];
    $cliente = $informe1["nombre_tercero"];
    $producto = $informe1["nombre_producto"];
    $area = $informe1["des_area_analisis"];
    $estado = $informe1["descripcion_estado_muestra"];
    $pdf->SetX(10);
    $pdf->SetWidths(array(15, 20, 35, 45, 25, 40));
    $pdf->Row2(array(utf8_decode($ident), utf8_decode(substr($fecha, 0, 10)), utf8_decode($cliente), utf8_decode($producto), utf8_decode($area), utf8_decode($estado)));
}
$pdf->Output();
?>
