<?php

require('../../fpdf.php');
require './AuxInformeUsoReactivosMuestra.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF {

    function Header() {

        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        define('ROOTPATH', __DIR__ . "/../../../");
        $this->Image(ROOTPATH . '/views/images/logoEmpresa.png', 20, 12, 19);
        $this->SetFont('Arial', 'B', 11);
            $this->Cell(147, 20, utf8_decode('INFORME USO DE REACTIVOS POR MUESTRA'), 1, 0, 'C');
        $this->Ln(25);
    }

    function tablaConsultaInfoUsoReactivosMuestra() {
        $this->auxiliarGeneral = new AuxiliarInformes();
        $this->aux = new AuxInformeUsoReactivosMuestra();

        $idReactivos = explode(',', $_POST["idReactivos"]);
        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];

        $infoUsoReactivosMuestra = $this->aux->getInfoUsoReactivosMuestra($idReactivos, $fechaInicio, $fechaFin);

        $this->tablaInformacionUsoReactivosMuestra($infoUsoReactivosMuestra);
    }

    function tablaInformacionUsoReactivosMuestra($infoUsoReactivosMuestra) {

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(47, 4, utf8_decode('REACTIVO'), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('MUESTRA'), 1, 0, 'C');
        $this->Cell(50, 4, utf8_decode('PRODUCTO'), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode('ENSAYO'), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 7);
        $colum1 = 47;
        $colum2 = 50;
        $colum3 = 50;
        $colum4 = 40;
        $this->SetWidths(array($colum1, $colum2, $colum3, $colum4));
        foreach ($infoUsoReactivosMuestra as $infoMuestra) {

            $reactivo = $infoMuestra->reactivo;
            $muestra = $infoMuestra->muestra;
            $producto = $infoMuestra->producto;
            $ensayo = $infoMuestra->ensayo;

            $this->SetX(10);

            $this->SetAligns(array('C', 'C', 'C', 'C'));
            $this->Row2(array(utf8_decode($reactivo), utf8_decode($muestra)
            , utf8_decode($producto), utf8_decode($ensayo)));
        }
        $this->Ln(8);
    }

}

$pdf = new PDF();
$pdf->AliasNbPages(H);
$pdf->AddPage();
$pdf->tablaConsultaInfoUsoReactivosMuestra();
$pdf->Output();
?>