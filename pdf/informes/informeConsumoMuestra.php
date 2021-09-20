<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$numMuestra = $_POST["filtroNumero"];
$modelReporte = new TablaReportesDbModelClass();
$idRealMuestra = $modelReporte->getRealIdMuestra($numMuestra);

$muestra = $modelReporte->getInfoConsumoMuestra($idRealMuestra);
$historico = $modelReporte->getInfoHistoricoMuestra($idRealMuestra);
$ensayosMuestra = $modelReporte->getEnsayoMuestraTiempo($idRealMuestra);

foreach ($ensayosMuestra as $ensayo) {
    $condiciones = $modelReporte->getCondicionesEnsayo($ensayo->id);
    $ensayo->condiciones = $condiciones[0];
}

class PDF extends FPDF {

    function Header() {
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(140, 20, utf8_decode('INFORME CONSUMO DE MUESTRA'), 1, 0, 'C');
        $this->Ln(30);
    }

    function Footer() {
        $this->SetY(-27);
        $this->Ln();
        $this->Cell(90, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
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
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(40, 6, utf8_decode('Muestra N° ') . $numMuestra, 0, 0, 'C');
$pdf->Ln(20);

$x = $pdf->GetX();
$y = $pdf->GetY();

$hProd = $pdf->NbLines(50, $muestra[0]['cliente']);
$pdf->MultiCell(40, $hProd * 6, utf8_decode('Nombre'), 1, 'C');
$pdf->SetXY($x + 40, $y);
$pdf->MultiCell(140, 6, utf8_decode($muestra[0]['producto']), 1, 'C');
$pdf->Ln(0);
$x = $pdf->GetX();
$y = $pdf->GetY();

$hLote = $pdf->NbLines(50, $muestra[0]['lote']);
$hCliente = $pdf->NbLines(50, $muestra[0]['cliente']);

$h = $hLote > $hCliente ? $hLote * 6 : $hCliente * 6;
$hLoteG = $hLote > $hCliente ? 6 : $hCliente * 6;
$hClienteG = $hLote < $hCliente ? 6 : $hLote * 6;

$pdf->MultiCell(40, $h, utf8_decode('Lote'), 1, 'C');
$pdf->SetXY($x + 40, $y);
$pdf->MultiCell(50, $hLoteG, utf8_decode($muestra[0]['lote']), 1, 'C');
$pdf->SetXY($x + 90, $y);
$pdf->MultiCell(40, $h, utf8_decode('Cliente'), 1, 'C');
$pdf->SetXY($x + 130, $y);
$pdf->MultiCell(50, $hClienteG, utf8_decode($muestra[0]['cliente']), 1, 'C');
$pdf->Ln(10);

// historial muestra
$pdf->Cell(55, 6, utf8_decode(''), 'BR', 0, 'C');
$pdf->Cell(40, 6, utf8_decode('FECHA'), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode('USUARIO'), 1, 0, 'C');
$pdf->Ln(6);

$pdf->SetFont('Arial', '', 10);

$pdf->Cell(55, 6, utf8_decode('Fecha de registro'), 1, 0, 'L');
$found_key = array_search(1, array_column($historico, 'id_estado'));
$pdf->Cell(40, 6, utf8_decode($historico[$found_key]['fecha']), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode($historico[$found_key]['usuario']), 1, 0, 'C');
$pdf->Ln(6);

$pdf->Cell(55, 6, utf8_decode('Fecha de programación'), 1, 0, 'L');
$found_key = array_search(2, array_column($historico, 'id_estado'));
$pdf->Cell(40, 6, utf8_decode($historico[$found_key]['fecha']), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode($historico[$found_key]['usuario']), 1, 0, 'C');
$pdf->Ln(6);

$pdf->Cell(55, 6, utf8_decode('Fecha de análisis'), 1, 0, 'L');
$found_key = array_search(12, array_column($historico, 'id_estado'));
$pdf->Cell(40, 6, utf8_decode($historico[$found_key]['fecha']), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode($historico[$found_key]['usuario']), 1, 0, 'C');
$pdf->Ln(6);

$pdf->Cell(55, 6, utf8_decode('Fecha de ingreso de resultados'), 1, 0, 'L');
$found_key = array_search(14, array_column($historico, 'id_estado'));
$pdf->Cell(40, 6, utf8_decode($historico[$found_key]['fecha']), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode($historico[$found_key]['usuario']), 1, 0, 'C');
$pdf->Ln(6);

$pdf->Cell(55, 6, utf8_decode('Fecha de primera revisión'), 1, 0, 'L');
$found_key = array_search(15, array_column($historico, 'id_estado'));
$pdf->Cell(40, 6, utf8_decode($historico[$found_key]['fecha']), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode($historico[$found_key]['usuario']), 1, 0, 'C');
$pdf->Ln(6);

$pdf->Cell(55, 6, utf8_decode('Fecha de verificación'), 1, 0, 'L');
$found_key = array_search(17, array_column($historico, 'id_estado'));
$pdf->Cell(40, 6, utf8_decode($historico[$found_key]['fecha']), 1, 0, 'C');
$pdf->Cell(85, 6, utf8_decode($historico[$found_key]['usuario']), 1, 0, 'C');
$pdf->Ln(20);

$col1 = 35;
$col2 = 30;
$col3 = 30;
$col4 = 30;
$col5 = 30;
$col6 = 25;

$arrayCols = array($col1, $col2, $col3, $col4, $col5, $col6);
$pdf->SetWidths($arrayCols);
$pdf->SetAligns(array('C', 'C', 'C', 'C'));
$pdf->Row2(array(utf8_decode('ENSAYO'), utf8_decode('EQUIPOS'), utf8_decode('REACTIVOS'), utf8_decode('ESTÁNDARES'), utf8_decode('COLUMNAS'), utf8_decode('DURACIÓN')));

foreach ($ensayosMuestra as $ensayo) {
    $pdf->Row2(array(utf8_decode($ensayo->descripcion_especifica)
        , utf8_decode($ensayo->condiciones->equipos)
        , utf8_decode($ensayo->condiciones->reactivos)
        , utf8_decode($ensayo->condiciones->estandares)
        , utf8_decode($ensayo->condiciones->columna)
        , utf8_decode($ensayo->tiempo)));
}

$pdf->Output();
?>