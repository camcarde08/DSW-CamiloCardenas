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
require_once './AuxListadoCondicionesCromatograficas.php';
require_once '../../../../vendor/autoload.php';
require_once '../../../../eloquent/database.php';

class ListadoCondicionesCromatograficas extends tFPDF {

    public $auxInforme;
    private $auxCondiciones;

    function Header() {
        $this->auxInforme->generateHeader($this, 'LISTA DE TÉCNICAS', ' ', ' ', ' ');
    }

    function showCondiciones() {
        $this->auxCondiciones = new AuxListadoCondicionesCromatograficas();
        $this->SetWidths(array(40, 140));
        $this->SetFont('Arial', 'B', 9);
        $this->SetAligns(array('C', 'C'));
        $condiciones = $this->auxCondiciones->getAllCondicionesActivas();
        $this->auxInforme->tablaBordesTamanoLinea($this, array(utf8_decode('Código'), utf8_decode('Nombre')), 6);
        $this->SetFont('Arial', '', 9);
        $this->SetAligns(array('C', 'L'));
        foreach ($condiciones as $condicion) {
            $this->auxInforme->tablaBordesTamanoLinea($this, array(utf8_decode($condicion->codigo), utf8_decode($condicion->nombre)), 6);
        }
    }

}

$pdf = new ListadoCondicionesCromatograficas();
$pdf->auxInforme = new AuxiliarInformes();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->showCondiciones();
$pdf->Output();
