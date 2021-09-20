<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';

$modelReporte = new TablaReportesDbModelClass();

class PDF extends FPDF {

    function Header() {
        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(170, 20, utf8_decode('LISTA DE COLUMNAS'), 1, 0, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('F-048 (LA-007)'), 1, 0, 'C');

        $this->SetXY(220, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('03'), 1, 0, 'C');
        $this->SetXY(220, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('24-07-17'), 1, 0, 'C');
        $this->SetXY(220, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(30, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
    }

    function Row2($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            //WriteHTML($
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Ln(0);
//$pdf->Ln();
$data1 = $modelReporte->getInfoColumnasInforme()["data"];

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(8, 4, utf8_decode('#'), 1, 0, 'C');
$pdf->Cell(27, 4, utf8_decode('Numero'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Tipo'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Marca'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Serial'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Dimensión'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Diametro'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Longitud'), 1, 0, 'C');
$pdf->Cell(25, 4, utf8_decode('Fecha Inicio'), 1, 0, 'C');
$pdf->Cell(30, 4, utf8_decode('Observaciones'), 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', '', 8);
$colum1 = 8;
$colum2 = 27;
$colum3 = 30;
$colum4 = 30;
$colum5 = 30;
$colum6 = 30;
$colum7 = 30;
$colum8 = 30;
$colum9 = 25;
$colum10 = 30;
$pdf->SetWidths(array($colum1, $colum2, $colum3, $colum4, $colum5
    , $colum6, $colum7, $colum8, $colum9, $colum10));
foreach ($data1 as $informe) {
    $id = $informe->id;
    $numero = $informe->numero;
    $tipo = $informe->tipo;
    $marca = $informe->marca;
    $serial = $informe->serial;
    $dimension = $informe->dimensiones;
    $diametro = $informe->diametro;
    $longitud = $informe->longitud;
    $tecnica = $informe->tecnica;
    if($informe->fecha_inicio_uso !== NULL) {
        $fecha = new DateTime($informe->fecha_inicio_uso);
        if ($fecha->format('Y') == '2000') {
            $fecha_inicio = 'N.A';
        } else if ($fecha->format('Y') == '2001') {
            $fecha_inicio = 'N.E';
        } else if ($fecha->format('Y') == '2002') {
            $fecha_inicio = 'Vigente';
        } else {
            $fecha_inicio = $fecha->format('d-m-Y');
        }
    }

    $pdf->SetX(10);


    $pdf->SetAligns(array('C', 'C', 'C', 'C'));
    $pdf->Row2(array(utf8_decode($id), utf8_decode($numero), utf8_decode($tipo), utf8_decode($marca), utf8_decode($serial), utf8_decode($dimension)
        , utf8_decode($diametro), utf8_decode($longitud), utf8_decode($fecha_inicio), utf8_decode($tecnica)));
}

$pdf->Output();
?>