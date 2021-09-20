<?php

require('../../fpdf.php');
require './AuxInformeReanalisis.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF {

    private $COLUMNAS = array(50, 70, 70, 40, 40);

    function Header() {
        $this->auxiliarGeneral = new AuxiliarInformes();
        $titulo = 'INFORME MUESTRAS PARA REANÁLISIS';
        $version = 'V1 (2017-09-11)';
        $codigo = 'REG-LC-042';
        $this->auxiliarGeneral->generateHeaderHorizontal($this, $titulo, $codigo, $version);

        $this->SetFont('Arial', 'B', 9);
        $this->SetWidths($this->COLUMNAS);
        $this->tablaHeader(array(utf8_decode('Código'), utf8_decode('Producto')
            , utf8_decode('Cliente'), utf8_decode('Fecha de Llegada')
            , utf8_decode('Fecha de Vencimiento')));
    }

    function tablaData($data, $indiceFechaVencimiento, $numDias) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            if ($i !== 5 && $i !== 9) {
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            }
        }
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
            if ($numDias == null) {
                $this->Rect($x, $y, $w, $h);
            } else if ($i == $indiceFechaVencimiento && ($numDias <= 30 && $numDias >= 1)) {
                $this->SetFillColor(247, 247, 30);
                $this->Rect($x, $y, $w, $h, 'FD');
            } elseif ($i == $indiceFechaVencimiento && ($numDias > 30 && $numDias <= 60)) {
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

    function tablaHeader($data) {
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
            $this->SetFillColor(164, 166, 168);
            $this->Rect($x, $y, $w, $h, 'FD');
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function crearTablaBody() {
        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];
        $auxReanalisis = new AuxInformeReanalisis();

        $data = $auxReanalisis->getMuestrasReanalisis($fechaInicio, $fechaFin);
        $this->SetFont('Arial', '', 9);
        $this->SetWidths($this->COLUMNAS);
        foreach ($data as $muestra) {
            $fechaLlegada = (new DateTime($muestra->fecha_llegada))->format('Y-m-d');
            $fechaVencimiento = (new DateTime($muestra->fecha_vencimiento))->format('Y-m-d');
            $this->tablaData(array(utf8_decode($muestra->prefijo . '-' . $muestra->custom_id)
                , utf8_decode($muestra->producto), utf8_decode($muestra->cliente)
                , utf8_decode($fechaLlegada), utf8_decode($fechaVencimiento)));
        }
    }

}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->crearTablaBody();
$pdf->Output();
?>