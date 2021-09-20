<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$numMuestra = $_POST["filtroNumero"];
$modelReporte = new TablaReportesDbModelClass();
$idRealMuestra = $modelReporte->getRealIdMuestra($numMuestra);

$muestra = $modelReporte->getInfoConsumoMuestra($idRealMuestra);
$muestraaud = $modelReporte->getInfoEventoMuestra($idRealMuestra);
$ensayosMuestra = $modelReporte->getEnsayoMuestraTiempo($idRealMuestra);

foreach ($ensayosMuestra as $ensayo) {
    $condiciones = $modelReporte->getCondicionesEnsayo($ensayo->id);
    $ensayo->condiciones = $condiciones[0];
}

class PDF extends FPDF {

    function Header() {
        //Logo
        $this->Cell(55, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 28, 12, 19);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(100, 20, utf8_decode('INFORME EVENTO POR MUESTRA'), 1, 0, 'C');
//      $this->Ln();
//      $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('F-095-(AD-009)'), 1, 0, 'C');

        $this->SetXY(165, 15);
        $this->Cell(60, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('01'), 1, 0, 'C');
        $this->SetXY(165, 20);
        $this->Cell(60, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('08-02-17'), 1, 0, 'C');
        $this->SetXY(165, 25);
        $this->Cell(60, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(60, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
        // To be implemented in your own inherited class
    }

    function Footer() {
        $this->SetY(-27);
        $this->Ln();
        $this->Cell(155, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }

    function validarFechaVencimiento($fecha) {
        $fechaVencimiento = new DateTime($fecha);
        $fechaActual = new DateTime();
        $interval = $fechaActual->diff($fechaVencimiento);

        $dias = (int) $interval->format('%R%a');
        if ($fecha == NULL) {
            return 365;
        } else {
            return $dias;
        }
    }

    function tablaData($data, $indiceFechaVencimiento, $numDias) {
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
            if ($i == $indiceFechaVencimiento && ($numDias < 30 && $numDias >= 1)) {
                $this->SetFillColor(247, 247, 30);
                $this->Rect($x, $y, $w, $h, 'FD');
            } elseif ($i == $indiceFechaVencimiento && ($numDias > 30 && $numDias < 60)) {
                $this->SetFillColor(153, 0, 153);
                $this->Rect($x, $y, $w, $h, 'FD');
            } elseif ($i == $indiceFechaVencimiento && ($numDias < 1)) {
                $this->SetFillColor(255, 10, 59);
                $this->Rect($x, $y, $w, $h, 'FD');
            } else {
                $this->Rect($x, $y, $w, $h);
            }

            //Print the text
            //WriteHTML($
            if ($i == 5 || $i == 9) {
                $this->SetTextColor(0, 0, 255);
                $this->Write(5, 'Link', $data[$i]);
                $this->SetTextColor(0, 0, 0);
            } else {
                $this->MultiCell($w, 5, $data[$i], 0, $a);
            }
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage(H);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(260, 6, utf8_decode('Muestra N: ') . $numMuestra, 0, 0, 'R');
$pdf->RoundedRect(225, 33, 60, 7, 2, 'S', '1234');
$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(220, 7, '' . utf8_decode($muestra[0]['producto']), 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(220, 7, 'Cliente: ' . utf8_decode($muestra[0]['cliente']), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(220, 7, 'Lote: ' . utf8_decode($muestra[0]['lote']), 0, 0, 'C');
$pdf->Ln(10);

$x = $pdf->GetX();
$y = $pdf->GetY();
//datos cliente
//$pdf->RoundedRect(10, 42, 110, 6, 2,  'S', '14');
//$pdf->RoundedRect(90, 68, 40, 6, 2,  'S', '');
//$pdf->RoundedRect(120, 42, 70, 6, 2,  'S', '23');
//$pdf->MultiCell(90, $h, utf8_decode('Lote: '). $muestra[0]['lote'], 1, 'L');
//$pdf->SetXY($x + 40, $y);
//$pdf->MultiCell(50, $hLoteG, utf8_decode($muestra[0]['lote']), 1, 'C');
//$pdf->MultiCell(180, 7, utf8_decode('Cliente: ') . $muestra[0]['cliente'], 1, 'L');
//$pdf->SetXY($x + 130, $y);
//$pdf->MultiCell(50, $hClienteG, utf8_decode($muestra[0]['cliente']), 1, 'C');
//$pdf->Ln(15);
//$pdf->cY = $pdf->GetY();
// historial muestra
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(275, 6, utf8_decode('EDICIÓN MUESTRA'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 6, utf8_decode('ID'), 1, 0, 'C');
$pdf->Cell(82, 6, utf8_decode('USUARIO'), 1, 0, 'C');
$pdf->Cell(82, 6, utf8_decode('FECHA'), 1, 0, 'C');
$pdf->Cell(81, 6, utf8_decode('RAZON'), 1, 0, 'C');
$pdf->Ln(6);
$colum1 = 30;
$colum2 = 82;
$colum3 = 82;
$colum4 = 81;
$pdf->SetWidths(array($colum1, $colum2, $colum3, $colum4));
foreach ($muestraaud as $info) {
    $id = $info["id"];
    //$pdf->SetFont('Arial','I',9);
    $usuario = $info["nombre"];
    //$pdf->SetFont('Arial','B',9);
    $fecha = $info["fecha"];
    $razon = $info["razon"];
    if ($info["razon"] == "Reprogramación de ensayo") {
        $jsonOld = $modelReporte->getJsonOldMuestraAud($info["id"]);
        $jsonNew = $modelReporte->getJsonNewMuestraAud($info["id"]);
        foreach ($jsonOld->ensayos_muestra AS $old) {
            foreach ($jsonNew->ensayos_muestra AS $new) {
                if ($old->id == $new->id && $old->motivo_reprogramacion != $new->motivo_reprogramacion) {
                    $razon = $razon . "\n" . $new->motivo_reprogramacion;
                }
            }
        }
    }
    $pdf->SetX(10);


    $pdf->SetAligns(array('C', 'C', 'C', 'C'));
    $pdf->Row2(array(utf8_decode($id), utf8_decode($usuario), utf8_decode($fecha), utf8_decode($razon)));
}
$pdf->Ln(3);

$pdf->Output();
?>