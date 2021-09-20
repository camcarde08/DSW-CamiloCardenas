<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
include('../moneda.php');
$modelReporte = new TablaReportesDbModelClass();
$conex_moneda = new moneda();
class PDF extends FPDF {
    function Header()
{
    //Logo
    $this->Image('../../views/images/logoEmpresa.png',170,10,20);
    $this->SetFont('Arial','B',13);
    $this->Cell(120,10,utf8_decode('LISTA DE PRECIOS'),0,0,'C');
    $this->Ln(25);
    $this->SetFont('Arial','B',9);
    $this->Cell(90,-5,utf8_decode('Ensayo'),1,0,'C');
    $this->Cell(30,-5,utf8_decode('Tiempo(Minutos)'),1,0,'C');
    $this->Cell(60,-5,utf8_decode('Valor'),1,0,'C');
    $this->Ln(1);
}
function Footer()
{
    
    // Position at 1.5 cm from bottom
  $this->SetY(-20);
  $this->SetFont('Arial','B',7);
  $this->Cell(180,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
  $this->Ln();
  //$this->Cell(90,5,utf8_decode('REV.00'),0,0,'L');
  //$this->Cell(90,5,utf8_decode('PL-P-008-R-05'),0,0,'R');
  $this->Ln();
   // Print centered page number
  // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
} 
}

$pdf = new PDF();
//$pdf->SetFont('Arial','',14);
//$pdf->Header();
$pdf->AddPage();
$pdf->AliasNbPages();
//SGM
// cell(alto,ancho, $valor, 0 sinborde 1 con borde, 	
//RoundedRect(coord x der izq, coord y arr abaj, ancho, Alto, grado de curva,  extilo 'FD''F''S', 'bordes o lados 1234 todos');
//fecha


//$pdf->Ln();

/////////////////////////////////////////
/////////INCIO LISTA DE PRECIOS////////////
///////////////////////////////////////////////
$pdf->SetFont('Arial','',7);
$data1 = $modelReporte->getListadePrecios();
  foreach ($data1 as $informe1) {

      
      $Ensayo= $informe1["descripcion"];
      $Precio = $conex_moneda->amoneda($informe1["precio_real"],"pesos");
      $Duracion = $informe1["tiempo"];
$pdf->SetX(10);
$pdf->SetWidths(array(90,30,60));
//$rex = $pdf->WriteHTML($Resultado);
$Resultado = preg_replace("<br>","\r\n",$Resultado1);
$pdf->Row2(array(utf8_decode($Ensayo),utf8_decode($Duracion),utf8_decode($Precio)));
}
/////////////////////////////////////////
/////////FIN LISTA DE PRECIOS////////////
///////////////////////////////////////////////
$pdf->Output();
?>
