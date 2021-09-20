<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$tipoFiltro = $_POST["filtroTipo"];
$modelReporte = new TablaReportesDbModelClass();

$anchoColumnas = array(18, 27, 30, 18, 30, 25, 25, 22, 23, 15, 20, 17);

class PDF extends FPDF {

    function Header() {
        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(170, 20, utf8_decode('LISTA DE REACTIVOS'), 1, 0, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('F-048 (LA-007)'), 1, 0, 'C');

        $this->SetXY(220, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('06'), 1, 0, 'C');
        $this->SetXY(220, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('24-07-17'), 1, 0, 'C');
        $this->SetXY(220, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(30, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);

        $this->SetFont('Arial', 'B', 8);
        $anchoColumnas = $GLOBALS['anchoColumnas'];
        $this->SetWidths($anchoColumnas);
        $this->tablaHeader(array(utf8_decode('Código'), utf8_decode('Nombre')
            , utf8_decode('Lote'), utf8_decode('Certificado')
            , utf8_decode('Ubicación'), utf8_decode('Clasificación')
            , utf8_decode('Fecha vencimiento'), utf8_decode('Fecha recibido'), utf8_decode('Fecha apertura')
            , utf8_decode('H.S.'), utf8_decode('Cantidad'), utf8_decode('Stock mínimo')));
    }

    function tablaData($data, $indiceFechaVencimiento, $numDias) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            if ($i !== 3 && $i !== 11) {
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
            if ($i == $indiceFechaVencimiento && ($numDias == 1)) {
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
            if ($i == 3 || $i == 11) {
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

}

$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();
//$pdf->Ln(0);
//$pdf->Ln();
if ($tipoFiltro == 4) {
    $fechaActual = new DateTime();
    $data1 = $modelReporte->getInfoReactivosVencidos($fechaActual->format('Y-m-d'));
} else if ($tipoFiltro == 5) {
    $fechaActual = new DateTime();
    $data1 = $modelReporte->getInfoReactivosFinalizados();
} else if ($tipoFiltro == 6) {
    $fechaActual = new DateTime();
    $data1 = $modelReporte->getInfoReactivosSinUsar();
} else {
    $data1 = $modelReporte->getInfoReactivosInforme();
}

$pdf->SetFont('Arial', '', 8);
foreach ($data1 as $informe) {
    $idReactivo = $informe['id'];
    $idLote = $informe['id_lote_reactivo'];
    $codigo = $informe['codigo'];
    $nombre = $informe['nombre'];
    $numero = $informe['numero'];
    $ubicacion = $informe['ubicacion'];
    $clasificacion = $informe['clasificacion'];
    $fecha_vencimiento = $informe['fecha_vencimiento'];
    $fecha_recibido = $informe['fecha_recibido'];
    $fecha_apertura = $informe['fecha_apertura'];
    $cantidad = $informe['cantidad'] . ' ' . $informe['unidad'];
    $stock = $informe['stock_minimo'];

    if ($fecha_apertura == NULL) {
        $fecha_apertura = 'STOCK';
    } else {
        $fechaAperturaObj = new DateTime($fecha_apertura);
        $fecha_apertura = $fechaAperturaObj->format('d-m-Y');
    }

    if ($fecha_recibido !== NULL) {
        $fechaRecibidoObj = new DateTime($fecha_recibido);
        $fecha_recibido = $fechaRecibidoObj->format('d-m-Y');
    }

    if ($fecha_vencimiento == NULL) {
        $fecha_vencimiento = 'OK';
    } else {
        $fechaVencimientoObj = ( new DateTime($fecha_vencimiento))->modify('first day of this month');
        if ($fechaVencimientoObj->format('Y') == '2000') {
            $fecha_vencimiento = "N.A";
            $dias = 70;
        } else {
            $dias = $pdf->validarFechaVencimiento($fechaVencimientoObj);
            $fecha_vencimiento = $fechaVencimientoObj->format('m-Y');
        }
    }

    $pdf->SetX(10);


    $pdf->SetWidths($anchoColumnas);
    $pdf->tablaData(array(utf8_decode($codigo), utf8_decode($nombre), utf8_decode($numero), '../../docs/reactivo/' . $idReactivo . '/' . $idLote
        , utf8_decode($ubicacion), utf8_decode($clasificacion), utf8_decode($fecha_vencimiento)
        , utf8_decode($fecha_recibido), utf8_decode($fecha_apertura)
        , '../../docs/reactivo/' . $idReactivo, utf8_decode($cantidad), utf8_decode($stock)), 8, $dias);
}

if (!empty($informe)) {
    $pdf->Ln(5);
    $actualizacion = $modelReporte->getUltimaActualizacionReactivos();
    $pdf->Cell(180, 5, utf8_decode('Última actualización: ' . $actualizacion[0]['fecha_actualizacion']), 0, 0, 'L');
}
$pdf->Output();
?>