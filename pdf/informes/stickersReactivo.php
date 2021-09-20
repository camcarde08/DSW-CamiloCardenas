<?php

require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once 'AuxiliarInformes.php';
require('mc_table.php');
$idLote = $_POST['idLote'];
$cantidad = $_POST['cantidadSticker'];
$modelReporte = new TablaReportesDbModelClass();

class PDF extends FPDF {

    function tablaSticker($nombre, $codigo, $lote, $fechaLlegada, $fechaApertura
    , $fechaVencimiento, $clasificacion, $i) {

        $x = $this->GetX();
        $this->SetY($this->GetY() + 1);


        if ($i % 2 !== 0) {
            $col2 = 89;
        } else {
            $col2 = 0;
        }

        $this->SetFont('Arial', 'B', 9);

        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Reactivo'), 'TLR', 0, 'C');
        $this->Ln(5);
        $this->SetFont('Arial', '', 9);
        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Fecha recibido:  ' . $fechaLlegada), 'LR', 0, 'L');
        $this->Ln(5);
        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Responsable Recepción _______________________'), 'LR', 0, 'L');
        $this->Ln(5);
        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Fecha de apertura:  ' . $fechaApertura), 'LR', 0, 'L');
        $this->Ln(5);
        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Responsable apertura _______________________'), 'LR', 0, 'L');
        $this->Ln(5);
        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Fecha de Vencimiento:  ' . $fechaVencimiento), 'LR', 0, 'L');
        $this->Ln(5);
        $this->SetX($x + $col2);
        $this->Cell(88, 5, utf8_decode('Condiciones de Almacenamiento: '), 'LR', 0, 'L');
        $this->Ln(5);
        $this->SetX($x + $col2);
        $this->Circle(($x + 24 + $col2), $this->GetY() + 2, 1.5, 'F');
        $this->Cell(88, 4, utf8_decode('X Ambiente    O Refrigeración'), 'LR', 0, 'C');
        $this->Ln(4);
        $this->SetX($x + $col2);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(88, 4, utf8_decode('A1-(LA-007)'), 'LRB', 0, 'R');
        $this->Ln(4);
    }

    function Circle($x, $y, $r, $style = 'D') {
        $this->Ellipse($x, $y, $r, $r, $style);
    }

    function Ellipse($x, $y, $rx, $ry, $style = 'D') {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c', ($x + $rx) * $k, ($h - $y) * $k, ($x + $rx) * $k, ($h - ($y - $ly)) * $k, ($x + $lx) * $k, ($h - ($y - $ry)) * $k, $x * $k, ($h - ($y - $ry)) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', ($x - $lx) * $k, ($h - ($y - $ry)) * $k, ($x - $rx) * $k, ($h - ($y - $ly)) * $k, ($x - $rx) * $k, ($h - $y) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', ($x - $rx) * $k, ($h - ($y + $ly)) * $k, ($x - $lx) * $k, ($h - ($y + $ry)) * $k, $x * $k, ($h - ($y + $ry)) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s', ($x + $lx) * $k, ($h - ($y + $ry)) * $k, ($x + $rx) * $k, ($h - ($y + $ly)) * $k, ($x + $rx) * $k, ($h - $y) * $k, $op));
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetWidths(array(44, 44));
//$datai = $modelReporte->getIdInicio($idInicio);
$data1 = $modelReporte->getStickerReactivo($idLote);
$y = $pdf->GetY();
$contador = 0;
foreach ($data1 as $informe1) {
    $fechaLlegada = $informe1["fecha_recibido"] !== NULL ? new DateTime($informe1["fecha_recibido"]) : NULL;
    $fechaApertura = $informe1["fecha_apertura"] !== NULL ? new DateTime($informe1["fecha_apertura"]) : NULL;
    $fechaVencimiento = $informe1["fecha_vencimiento"] !== NULL ? new DateTime($informe1["fecha_vencimiento"]) : NULL;

    $fechaLlegada = $fechaLlegada !== NULL ? $fechaLlegada->format('d-m-y') : 'N.E';
    $fechaApertura = $fechaApertura !== NULL ? $fechaApertura->format('d-m-y') : 'N.E';
    $fechaVencimiento = $fechaVencimiento !== NULL ? $fechaVencimiento->format('m-y') : 'N.E';

    for ($i = 0; $i < $cantidad; $i++) {
        if ($y > 240) {
            $pdf->AddPage();
            $y = $pdf->GetY();
            $valueY = 0;
        } else {
            $pdf->SetY($y);
        }
        $pdf->tablaSticker($informe1["nombre"], $informe1["codigo"], $informe1["numero"]
                , $fechaLlegada, $fechaApertura, $fechaVencimiento, $informe1["clasificacion"], $contador);
        $valueY = max($valueY, $pdf->GetY());
        if ($contador % 2 !== 0 && $contador > 0) {
            $y = $valueY;
        }


        $contador ++;
    }
}
$pdf->Output();
?>
