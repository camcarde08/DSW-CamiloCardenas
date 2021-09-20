<?php

require('../../fpdf.php');
require './AuxInformeEstabilidadSalir.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF {

    function Header() {

        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        define('ROOTPATH', __DIR__ . "/../../../");
        $this->Image(ROOTPATH . '/views/images/logoEmpresa.png', 20, 12, 19);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(147, 20, utf8_decode('INFORME ESTABILIDADES POR SALIR'), 1, 0, 'C');
        $this->Ln(25);
    }

    function tablaConsultaInfoEstabilidadesPorSalir() {
        $this->auxiliarGeneral = new AuxiliarInformes();
        $this->aux = new AuxInformeMuestraEstabilidadSalir();

        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];

        $infoMuestraEsabilidadPorSalir = $this->aux->getInfoMuestraEsabilidadPorSalir($fechaInicio, $fechaFin);

        $this->tablaInformacionEstabilidadesPorSalir($infoMuestraEsabilidadPorSalir);
    }

    function tablaInformacionEstabilidadesPorSalir($infoMuestraEsabilidadPorSalir) {

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 4, utf8_decode('MUESTRA'), 1, 0, 'C');
        $this->Cell(30, 4, utf8_decode('PRODUCTO'), 1, 0, 'C');
        $this->Cell(20, 4, utf8_decode('TIPO'), 1, 0, 'C');
        $this->Cell(22, 4, utf8_decode('F. LLEGADA'), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode('CLIENTE'), 1, 0, 'C');
        $this->Cell(28, 4, utf8_decode('LOTE'), 1, 0, 'C');
        $this->Cell(22, 4, utf8_decode('F. SALIDA'), 1, 0, 'C');
        $this->Cell(20, 4, utf8_decode('TIEMPO'), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 7);
        $colum1 = 20;
        $colum2 = 30;
        $colum3 = 20;
        $colum4 = 22;
        $colum5 = 25;
        $colum6 = 28;
        $colum7 = 22;
        $colum8 = 20;
        $this->SetWidths(array($colum1, $colum2, $colum3, $colum4, $colum5, $colum6, $colum7, $colum8));
        foreach ($infoMuestraEsabilidadPorSalir as $infoMuestra) {
            $muestra = $infoMuestra->muestra;
            $producto = $infoMuestra->producto;
            $tipo = $infoMuestra->tipo_estabilidad;
            $fechaLlegada = $infoMuestra->fecha_llegada !== NULL ? (new DateTime($infoMuestra->fecha_llegada))->format('d-m-Y') : NULL;
            $cliente = $infoMuestra->cliente;
            $lote = $infoMuestra->lote;
            $fechaSalida = $infoMuestra->fechaSalida !== NULL ? (new DateTime($infoMuestra->fechaSalida))->format('d-m-Y') : NULL;
            $tiempo = $infoMuestra->tiempo;

            $this->SetX(10);

            $this->SetAligns(array('C', 'C', 'C', 'C'));
            $this->Row2(array(utf8_decode($muestra), utf8_decode($producto)
            , utf8_decode($tipo), utf8_decode($fechaLlegada)
            , utf8_decode($cliente), utf8_decode($lote)
            , utf8_decode($fechaSalida), utf8_decode($tiempo)));
        }
        $this->Ln(8);
    }

}

$pdf = new PDF();
$pdf->AliasNbPages(H);
$pdf->AddPage();
$pdf->tablaConsultaInfoEstabilidadesPorSalir();
$pdf->Output();
?>