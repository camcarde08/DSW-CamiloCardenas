<?php

require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require './AuxiliarInformes.php';
require('mc_table.php');

$idInicio = $_GET['idInicio'];
$idFinal = $_GET['idFinal'];
$cantidad = $_GET['cantidad'];
$modelReporte = new TablaReportesDbModelClass();
$pdf = new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetLineWidth(0.5);
$pdf->SetWidths(array(44, 44));

//$datai = $modelReporte->getIdInicio($idInicio);
$dini = $modelReporte->getIdInicio($idInicio);
$dfin = $modelReporte->getIdFin($idFinal);
$data1 = $modelReporte->getSikers($dini, $dfin);
$x = 10;
$y = $pdf->GetY();
$aux = new AuxiliarInformes();
$contador = 0;

for ($i = 0; $i < $cantidad; $i++) {
    foreach ($data1 as $key => $informe1) {

        $id = $informe1["identificaCliente"];

        $aux2 = (string)$id;
        for($i = strlen($aux2); $i < 5; $i++ ){
            $aux2 = "0".$aux2;
        }

        $prefijo = $informe1['prefijo'];
        $cliente = $informe1["cliente"];
        $producto = $informe1["producto"];
        $lote = $informe1["lote"];

        $Ensayos = $informe1["ensayos"];

        $FechaA = substr($informe1["fecha"], 2, 2);
        $FechaM = substr($informe1["fecha"], 5, 2);
        $FechaD = substr($informe1["fecha"], 8, 2);
        $Fecha = $FechaD . '-' . $FechaM . '-' . $FechaA;

        $unidad = "\n" . '# Muestra: ' . $prefijo . ' - ' . '' . $aux2 . "\n" . 'Cliente :' . $cliente . "\n" . 'Producto: '
            . $producto . "\n" . 'Lote:' . $lote . "\n" . 'Análisis:' . $Ensayos . "\n" . " ";

        $pdf->MultiCell(44, 3, utf8_decode($unidad), 1, 'L');

        $contador++;

        if ($contador != 4) {

            $ymax = max([$ymax, $pdf->GetY()]);
            $x += 47;

        } else {

            $ymax = max([$ymax, $pdf->GetY()]);

            $x = 10;
            $y = $ymax;
            $contador = 0;
        }

        $pdf->SetXY($x, $y);

        if ($pdf->GetY() > 255) {
            $pdf->AddPage();
            $x = 10;
            $y = 10;
            $ymax = 0;

        }
    }

    if($i < $cantidad-1){
        $pdf->AddPage();
        $x = 10;
        $y = 10;
        $ymax = 0;
        $contador = 0;
    }
}

$pdf->Output();
?>
