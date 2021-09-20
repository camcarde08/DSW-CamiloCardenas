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
require_once './AuxListadoProductos.php';
require_once '../../../../vendor/autoload.php';
require_once '../../../../eloquent/database.php';

class ListadoProductos extends tFPDF {

    public $auxInforme;
    private $auxProductos;

    function Header() {
        $this->auxInforme->generateHeader($this, 'LISTA DE PRODUCTOS ANALIZADOS', 'F-042 (LA-002)', '01', '12-01-18');
    }

    function showProductos() {
        $this->auxProductos = new AuxListadoProductos();
        $this->SetWidths(array(90, 90));
        $this->SetFont('Arial', 'B', 9);
        $this->SetAligns(array('C', 'C'));
        $productos = $this->auxProductos->getAllProductosActivos();
        $this->auxInforme->tablaBordesTamanoLinea($this, array(utf8_decode('Nombre'), utf8_decode('Tipo de Producto')), 6);
        $this->SetFont('Arial', '', 9);
        $this->SetAligns(array('L', 'L'));
        foreach ($productos as $producto) {
            if ($producto->activo !== 0) {
                $this->auxInforme->tablaBordesTamanoLinea($this, array(utf8_decode($producto->nombre)
                    , utf8_decode($producto->formaFarmaceutica->descripcion)), 6);
            }
        }
    }

}

$pdf = new ListadoProductos();
$pdf->auxInforme = new AuxiliarInformes();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->showProductos();
$pdf->Output();
