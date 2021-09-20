<?php

require('../../fpdf.php');
require './AuxInformeOcupacionAnalista.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF {

    function Header() {

        //Logo
        $this->auxiliarGeneral->generateHeader($this, "INFORME DISPONIBILIDAD DE ANALISTA", "", "");
    }

    function tablaProgramacion() {
        $this->aux = new AuxInformeOcupacionAnalista();

        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];
        $idAnalista = $_POST["idAnalista"];

        $this->SetFont('Arial', 'B', 9);


        $programaciones = $this->aux->getProgramacionAnalista($fechaInicio, $fechaFin, $idAnalista);
        $analista = $this->aux->getAnalista($idAnalista);

        $fechaProgramada = null;

        $this->Cell(30, 6, utf8_decode("Analista: "), 0, 0, 'L');
        $this->Cell(150, 6, utf8_decode($analista->nombre), 0, 0, 'L');
        $this->Ln(8);

        foreach ($programaciones as $key => $programacion) {

            $bottomBorder = "";
            $longLinea = $this->NbLines(90, utf8_decode($programacion->descripcion_especifica));
            if (count($programaciones) - 1 == $key) {
                $bottomBorder = "B";
            }
            if ($programacion->fecha_programada !== $fechaProgramada || ($this->GetY() + (6 * $longLinea) > $this->PageBreakTrigger)) {
                $this->Cell(30, 6 * $longLinea, $programacion->fecha_programada, 'LTR' . $bottomBorder, 0, 'C');
            } else {
                $this->Cell(30, 6 * $longLinea, "", 'LR' . $bottomBorder, 0, 'C');
            }

            $this->Cell(30, 6 * $longLinea, $programacion->prefijo . "-" . $programacion->custom_id, 'TB', 0, 'C');
            $y = $this->GetY();
            $x = $this->GetX();
            $this->MultiCell(90, 6, utf8_decode($programacion->descripcion_especifica), 'TB', 'L');
            $this->SetY($y);
            $this->SetX($x + 90);
            $this->Cell(30, 6 * $longLinea, utf8_decode("Duración: " . $programacion->duracion), 'TBR', 0, 'C');
            $this->Ln();
            $fechaProgramada = $programacion->fecha_programada;
        }
    }

}

$pdf = new PDF();
$pdf->auxiliarGeneral = new AuxiliarInformes();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->tablaProgramacion();
$pdf->Output();
?>