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
require_once './AuxListadoEnsayos.php';
require_once '../../../../vendor/autoload.php';
require_once '../../../../eloquent/database.php';

class ListadoEnsayos extends tFPDF {

    public $auxInforme;
    private $auxEnsayos;

    function Header() {
        $this->auxInforme->generateHeader($this, 'LISTA DE ENSAYOS', 'F-042 (LA-002)', '01', '12-01-18');
    }

    function showEnsayos() {
        $this->auxEnsayos = new AuxListadoEnsayos();
        $this->SetWidths(array(180));
        $this->SetFont('Arial', 'B', 9);
        $this->SetAligns(array('C', 'C'));
        $ensayos = $this->auxEnsayos->getAllEnsayosActivos();
        $this->auxInforme->tablaBordesTamanoLinea($this, array(utf8_decode('Descripción')), 6);
        $this->SetFont('Arial', '', 9);
        $this->SetAligns(array('L'));
        foreach ($ensayos as $ensayo) {
            $this->auxInforme->tablaBordesTamanoLinea($this, array(utf8_decode($ensayo->descripcion)), 6);
        }
    }

}

$pdf = new ListadoEnsayos();
$pdf->auxInforme = new AuxiliarInformes();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->showEnsayos();
$pdf->Output();
