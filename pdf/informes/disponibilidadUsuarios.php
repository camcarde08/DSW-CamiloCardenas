<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
$idAnalista = $_GET['idUsuario'];
$inicio = date('Y-m-d');
$nuevaFecha = strtotime('+3 month', strtotime(date('Y-m-d')));
$fin = date('Y-m-d', $nuevaFecha);
$modelReporte1 = new TablaReportesDbModelClass();
$modelReporte = new TablaReportesDbModelClass();
$datoa = $modelReporte->verNombreUsuario($idAnalista);
foreach ($datoa as $analist) {
    $analistaNombre = $analist["nombre"];
}

class PDF extends FPDF {

    function Header() {
        $this->Image('../../views/images/logoEmpresa.png', 170, 10, 20);
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(120, 10, utf8_decode('TRABAJOS DEL USUARIO'), 0, 0, 'C');
        $this->Ln(10);
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(60, 7, 'FECHA: ' . date("Y-m-d"), 1, 0, 'C');
        $this->Ln(13);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(180, -5, utf8_decode('OCUPACIÓN DE ANALISTA'), 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(38, -5, utf8_decode('Usuario'), 1, 0, 'C');
        $this->Cell(19, -5, utf8_decode('Fecha'), 1, 0, 'C');
        $this->Cell(72, -5, utf8_decode('Ensayo'), 1, 0, 'C');
        $this->Cell(8, -5, utf8_decode('Dur.'), 1, 0, 'C');
        $this->Cell(43, -5, utf8_decode('Programador'), 1, 0, 'C');
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
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 7);
/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
$pdf->SetFont('Arial', '', 8);
// $pdf->Cell(100,7,'ANALISTA :'. $analistaNombre ,1,0,'L');
$data1 = $modelReporte->getDisponibilidadUsuario($idAnalista, '$inicio', $fin);
foreach ($data1 as $informe1) {
    $fecha = $informe1["fecha"];
    $Duracion = $informe1["duracion_programada"];
    $Ensayo = $informe1["desEnsayo"] . '-' . $informe1["desPaquete"];
    $Programador = $informe1["nomProgramador"];
    $pdf->SetX(10);
    $pdf->SetWidths(array(38, 19, 72, 8, 43));
//$rex = $pdf->WriteHTML($Resultado);
    $Resultado = str_replace("<br>", "\r\n", $Resultado1);
    $pdf->Row2(array(utf8_decode($analistaNombre), utf8_decode($fecha), utf8_decode($Ensayo), utf8_decode($Duracion), utf8_decode($Programador)));
}
/////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
$pdf->Output();
?>
