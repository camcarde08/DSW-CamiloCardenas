<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$tipoFiltro = $_POST["filtroTipo"];
$modelReporte = new TablaReportesDbModelClass();

$anchoColumnas = array(15, 8, 27, 20, 32, 10, 15, 24, 28, 10, 20, 24, 30, 15);

class PDF extends FPDF {

    function Header() {
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(170, 20, utf8_decode('LISTA DE ESTÁNDARES Y MATERIALES DE REFERENCIA'), 1, 0, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');

        $tipoFiltro = $GLOBALS['tipoFiltro'];

        if ($tipoFiltro == 'Primario') {
            $this->Cell(37, 5, utf8_decode('F-040 (LA-002)'), 1, 0, 'C');
        } else if ($tipoFiltro == 'Secundario') {
            $this->Cell(37, 5, utf8_decode('F-041 (LA-002)'), 1, 0, 'C');
        } else {
            $this->Cell(37, 5, utf8_decode('F-042 (LA-002)'), 1, 0, 'C');
        }

        $this->SetXY(220, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(37, 5, utf8_decode('03'), 1, 0, 'C');
        $this->SetXY(220, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(37, 5, utf8_decode('24-07-17'), 1, 0, 'C');
        $this->SetXY(220, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(37, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
        $this->SetFont('Arial', 'B', 9);

        $anchoColumnas = $GLOBALS['anchoColumnas'];

        $this->SetWidths($anchoColumnas);
        $this->tablaHeader(array(utf8_decode('Código'), utf8_decode('N°')
            , utf8_decode('Nombre'), utf8_decode('Origen'), utf8_decode('Lote')
            , utf8_decode('Cert.'), utf8_decode('Pureza'), utf8_decode('Fecha vencimiento')
            , utf8_decode('Almacenamiento'), utf8_decode('H.S.'), utf8_decode('Fecha Apertura'), utf8_decode('Uso previsto')
            , utf8_decode('Propiedades'), utf8_decode('Cantidad final')));
    }

    function validarFechaVencimiento($fecha) {

        $fechaActual = (new DateTime())->modify('first day of this month');
        $interval = $fechaActual->diff($fecha);

        $dias = (int) $interval->format('%R%a');
        if ($fecha == NULL) {
            return 365;
        } elseif ($fecha->format('m-y') == $fechaActual->format('m-y')) {
            return 1;
        } else {
            return $dias;
        }
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
            } else if ($i == $indiceFechaVencimiento && ($numDias == 1)) {
                $this->SetFillColor(247, 247, 30);
                $this->Rect($x, $y, $w, $h, 'FD');
            } elseif ($i == $indiceFechaVencimiento && ($numDias > 1 && $numDias <= 60)) {
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

}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Ln(0);
//$pdf->Ln();
if ($tipoFiltro == 1) {
    $tipoFiltro = $_POST["filtroNombre"];
    $data1 = $modelReporte->getInfoEstandares($tipoFiltro);
} else if ($tipoFiltro == 4) {
    $fechaActual = new DateTime();
    $data1 = $modelReporte->getInfoEstandaresVencidos($fechaActual->format('Y-m-d'));
} else if ($tipoFiltro == 5) {
    $fechaActual = new DateTime();
    $data1 = $modelReporte->getInfoEstandaresFinalizados();
} else if ($tipoFiltro == 6) {
    $fechaActual = new DateTime();
    $data1 = $modelReporte->getInfoEstandaresSinUsar();
} else {
    $tipoFiltro = NULL;
    $data1 = $modelReporte->getInfoEstandares($tipoFiltro);
}

$pdf->SetFont('Arial', '', 8);
foreach ($data1 as $informe) {
    $dias = NULL;
    $idEstandar = $informe['id'];
    $idLote = $informe['idLote'];
    $codigo = $informe['codigo'];
    $consecutivo = $informe['consecutivo'];
    $nombre = $informe['nombre'];
    $lote = $informe['lote'];
    $origen = $informe['origen'];
    $pureza = $informe['pureza'];
    $fecha_vencimiento = $informe['fecha_vencimiento'];
    $almacenamiento = $informe['almacenamiento'];
    $uso_previsto = $informe['uso_previsto'];
    $propiedades = $informe['propiedades'];
    $observaciones = $informe['observaciones'];
    $cantidad = $informe['cantidad'];
    $cantidadFinal = $informe['cantidad_final'];
    $fecha_apertura = $informe['fecha_apertura'];

    $pdf->SetX(10);

    if ($fecha_vencimiento !== NULL) {
        $fechaVencimientoObj = ( new DateTime($fecha_vencimiento))->modify('first day of this month');
        if ($fechaVencimientoObj->format('Y') == '2000') {
            $fecha_vencimiento = "N.A";
            $dias = 70;
        } else {
            $dias = $pdf->validarFechaVencimiento($fechaVencimientoObj);
            $fecha_vencimiento = $fechaVencimientoObj->format('m-Y');
        }
    } else {
        $dias = 70;
    }

    if ($fecha_apertura == NULL) {
        $fecha_apertura = 'STOCK';
    } else {
        $fechaAperturaObj = new DateTime($fecha_apertura);
        $fecha_apertura = $fechaAperturaObj->format('d-m-Y');
    }

    $pdf->SetWidths($anchoColumnas);
    $pdf->tablaData(array(utf8_decode($codigo), utf8_decode($consecutivo), utf8_decode($nombre), utf8_decode($origen)
        , utf8_decode($lote), '../../docs/estandar/' . $idEstandar . '/' . $idLote, utf8_decode($pureza), utf8_decode($fecha_vencimiento), utf8_decode($almacenamiento)
        , '../../docs/estandar/' . $idEstandar, utf8_decode($fecha_apertura), utf8_decode($uso_previsto), utf8_decode($propiedades), utf8_decode($cantidadFinal)), 7, $dias);
}

if (!empty($informe)) {
    $pdf->Ln(5);
    $actualizacion = $modelReporte->getUltimaActualizacionEstandares();
    $pdf->Cell(180, 5, utf8_decode('Última actualización: ' . $actualizacion[0]['fecha_actualizacion']), 0, 0, 'L');
}

$pdf->Output();
?>