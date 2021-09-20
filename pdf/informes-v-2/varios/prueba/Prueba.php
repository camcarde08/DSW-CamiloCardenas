<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of prueba
 *
 * @author Jhoana Chacón
 */
require_once '../../../tfpdf/tfpdf.php';
require_once '../../AuxiliarInformes.php';
require_once '../../AuxiliarMuestra.php';
require_once './AuxiliarPrueba.php';

class Prueba extends tFPDF {

    public $auxInforme;
    private $auxMuestra;
    private $auxPrueba;

    function initAux() {
        $this->auxMuestra = new AuxiliarMuestra($_GET['idMuestra']);
        $this->auxPrueba = new AuxiliarPrueba();
    }

    function Header() {
        $this->auxInforme->generateHeader($this, 'Hola', '123', 'V2');
    }

    function showMuestra() {
        $this->SetFont('Arial', 'B', 7);
        $this->MultiCell(180, 6, $this->auxMuestra->muestra);
        $this->MultiCell(180, 6, $this->auxMuestra->muestra->dateFechaLlegada->format('Ymd'));
    }

}

$pdf = new Prueba();
$pdf->auxInforme = new AuxiliarInformes();
$pdf->initAux();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->showMuestra();
$pdf->Output();
