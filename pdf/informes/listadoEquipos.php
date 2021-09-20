<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once 'AuxiliarInformes.php';

$modelReporte = new TablaReportesDbModelClass();

$anchoColumnas = array(20, 32, 30, 51, 24, 23, 23, 20, 47);

class PDF extends FPDF {

    function Header() {
            $this->auxiliarGeneral = new AuxiliarInformes();

        //Logo
        $this->Cell(40, 15, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 11   , 30);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(170, 15, utf8_decode('LISTA DE REACTIVOS'), 1, 0, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 15, utf8_decode('GCC-02-FR-078-1'), 1, 0, 'C');
        $this->Cell(30, 15, utf8_decode('Página'.' '.$this->PageNo() . ' de {nb}'), 1, 0, 'C');

        $this->Ln(25);

        $this->SetFont('Arial', 'B', 8);
            $anchoColumnas = $GLOBALS['anchoColumnas'];
            $this->SetWidths($anchoColumnas);
        $this->tablaHeader(array(utf8_decode('Código'), utf8_decode('Modelo')
            , utf8_decode('Serie'), utf8_decode('Descripción'), utf8_decode('Marca')
            , utf8_decode('F. próximo mantenimiento')
            , utf8_decode('F. próxima calibración'), utf8_decode('F. próxima calificación')
            , utf8_decode('Ensayos')));
    }

    function validarColorCelda($numResult) {
        if ($numResult == 2) {
            $this->SetFillColor(236, 50, 55);
        } else if ($numResult == 1) {
            $this->SetFillColor(255, 223, 63);
        } else {
            $this->SetFillColor(255, 255, 255);
        }
    }

    function tablaData($data, $colorMant, $colorCalib, $colorCalif) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
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

            //color celda
            if ($i == 5) {
                $this->validarColorCelda($colorMant);
                $this->Rect($x, $y, $w, $h, 'FD');
            } else if ($i == 6) {
                $this->validarColorCelda($colorCalib);
                $this->Rect($x, $y, $w, $h, 'FD');
            } else if ($i == 7) {
                $this->validarColorCelda($colorCalif);
                $this->Rect($x, $y, $w, $h, 'FD');
            } else {
                //Draw the border
                $this->Rect($x, $y, $w, $h);
            }

            $this->MultiCell($w, 5, $data[$i], 0, $a);
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

    function validarFecha($fecha, $dias) {

        $fechaActual = new DateTime();
        $interval = $fechaActual->diff($fecha);

        $difer = (int) $interval->format('%R%a');
        if ($difer == NULL || $difer > $dias) {
            return 0;
        } else if ($difer > 0 && $difer <= $dias) {
            return 1;
        } else {
            return 2;
        }
    }

}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Ln(0);
//$pdf->Ln();
$modelReporte->cargarSystemParameters();
$data1 = $modelReporte->getInfoEquiposInforme();
$pdf->SetFont('Arial', '', 8);
$diasAlertaMant = $_SESSION['systemsParameters']['diasAnticipacionAlertaMantenimiento'];
$diasAlertaCalib = $_SESSION['systemsParameters']['diasAnticipacionAlertaCalibracion'];
$diasAlertaCalif = $_SESSION['systemsParameters']['diasAnticipacionAlertaCalificacion'];
foreach ($data1 as $informe) {
    $colorProxMant = 0;
    $colorProxCalib = 0;
    $colorProxCalif = 0;
    
    if ($informe['fecha_ult_mant'] !== NULL) {
        $fechaUltMantObj = new DateTime($informe['fecha_ult_mant']);
        $fechaUltMant = $fechaUltMantObj->format('d-m-Y');
    }
    if ($informe['fecha_ult_calib'] !== NULL) {
        $fechaUltCalibObj = new DateTime($informe['fecha_ult_calib']);
        $fechaUltCalib = $fechaUltCalibObj->format('d-m-Y');
    }
    if ($informe['fecha_prox_calibracion'] !== NULL) {
        $fechaProxCalibObj = new DateTime($informe['fecha_prox_calibracion']);
        if ($fechaProxCalibObj->format('Y') == '2000') {
            $fechaProxCalib = 'N.A';
        } else if ($fechaProxMantObj->format('Y') == '2001') {
            $fechaProxCalib = 'N.E';
        } else if ($fechaProxMantObj->format('Y') == '2002') {
            $fechaProxCalib = 'Vigente';
        } else {
            $fechaProxCalib = $fechaProxCalibObj->format('d-m-Y');
            
            $colorProxCalib = $pdf->validarFecha($fechaProxCalibObj, $diasAlertaCalib);
        }
    }
    if ($informe['fecha_prox_mantenimiento'] !== NULL) {
        $fechaProxMantObj = new DateTime($informe['fecha_prox_mantenimiento']);
        if ($fechaProxMantObj->format('Y') == '2000') {
            $fechaProxMant = 'N.A';
        } else if ($fechaProxMantObj->format('Y') == '2001') {
            $fechaProxMant = 'N.E';
        } else if ($fechaProxMantObj->format('Y') == '2002') {
            $fechaProxMant = 'Vigente';
        } else {
            $fechaProxMant = $fechaProxMantObj->format('d-m-Y');
            $colorProxMant = $pdf->validarFecha($fechaProxMantObj, $diasAlertaMant);
        }
    }
    if ($informe['fecha_ult_calificacion'] !== NULL) {
        $fechaUltCalifObj = new DateTime($informe['fecha_ult_calificacion']);
        $fechaUltCalif = $fechaUltCalifObj->format('d-m-Y');
    }
    
    if ($informe['fecha_prox_calificacion'] !== NULL) {
        $fechaProxCalifObj = new DateTime($informe['fecha_prox_calificacion']);
        if ($fechaProxCalifObj->format('Y') == '2000') {
            $fechaProxCalif = 'N.A';
        } else if ($fechaProxCalifObj->format('Y') == '2001') {
            $fechaProxCalif = 'N.E';
        } else if ($fechaProxCalifObj->format('Y') == '2002') {
            $fechaProxCalif = 'Vigente';
        } else {
            $fechaProxCalif = $fechaProxCalifObj->format('d-m-Y');
            
            $colorProxCalif = $pdf->validarFecha($fechaProxCalifObj, $diasAlertaCalif);
        }
    }

    $pdf->SetX(10);

    $pdf->SetWidths($anchoColumnas);
    $pdf->tablaData(array(utf8_decode($informe['cod_inventario']), utf8_decode($informe['modelo'])
        , utf8_decode($informe['serie']), utf8_decode($informe['descripcion']), utf8_decode($informe['marca'])
        , utf8_decode($fechaProxMant), utf8_decode($fechaProxCalib)
        , utf8_decode($fechaProxCalif), utf8_decode($informe['ensayos']))
            , $colorProxMant, $colorProxCalib, $colorProxCalif);
}

$pdf->Output();
?>