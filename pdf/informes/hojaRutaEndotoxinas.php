<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
$dato = $_GET['idMuestra'];
$datoPref = $_GET['idMuestraPref'];
$modelReporte = new TablaReportesDbModelClass();
   $data = $modelReporte->getInfoPrincipalHRMicro($dato);
            foreach ($data as $informe) {
                  $informes[] = array(
                   $id = $informe['idPref'],
                   $FechaA = substr($informe["fecha"],0,4),
                   $FechaM = substr($informe["fecha"],5,2),
                   $FechaD = substr($informe["fecha"],8,2),
                   $FechaLlegada = $FechaD .'-'. $FechaM .'-'.$FechaA,   
                   $AreaAnalisis = $informe['area'],
                   $Ensayos = $informe['ensayos']  
           );  
            }
  class PDF extends FPDF { 
    
    function Header()
{
    //Logo
    $this->Cell(40,20,utf8_decode(''),1,0,'C');
    $this->Image('../../views/images/logoEmpresa.png',13,12,35);
    //Arial bold 15
    $this->SetFont('Arial','B',11);
    //Move to the right
    //$this->Cell(1);
    //Title
    $this->Cell(80,20,utf8_decode('HOJA DE CÁLCULO'),1,0,'C');
     $this->SetFont('Arial','B',7);
    $this->Cell(30,5,utf8_decode('CÓDIGO'),1,0,'C');
    $this->Cell(30,5,utf8_decode('3 FOR-004'),1,0,'C');
   
    $this->SetXY(130, 15);
    $this->Cell(30,5,utf8_decode('VERSIÓN'),1,0,'C');
    $this->Cell(30,5,utf8_decode('01'),1,0,'C');
    $this->SetXY(130, 20);
    $this->Cell(30,5,utf8_decode('VIGENCIA'),1,0,'C');
    $this->Cell(30,5,utf8_decode('08-08-21'),1,0,'C');
    $this->SetXY(130, 25);
    $this->Cell(30,5,utf8_decode('PÁGINA'),1,0,'C');
    $this->Cell(30,5, $this->PageNo().' de {nb}' ,1,0,'C');
    $this->Ln(48);
	// To be implemented in your own inherited class
}
function Footer()
{
   // Position at 1.5 cm from bottom
  $this->SetY(-26);
  $this->SetFont('Arial','B',6);
  //$this->Cell(180,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
  $this->Ln();
  $this->Cell(90,5, utf8_decode('3 FOR-004') . utf8_decode(' REV.04'),0,0,'L');
  $this->Cell(90,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
  $this->Ln();
   // Print centered page number
  // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);
$pdf->SetFillColor(169, 169, 169);
//$pdf->RoundedRect(10, 25, 90, 6, 2,  'S', '1'); //Cliente
//$pdf->RoundedRect(100, 25, 40, 6, 2,  'S', '');// Area
//$pdf->RoundedRect(140, 25, 50, 6, 2,  'S', '2');// Area
//$pdf->RoundedRect(10, 31, 60, 6, 2,  'S', '4');
//$pdf->RoundedRect(70, 31, 60, 6, 2,  'S', '');
//$pdf->RoundedRect(130, 31, 60, 6, 2,  'S', '3');
$pdf->SetXY(10, 13);
$pdf->Cell(50,50,utf8_decode('Fecha de ingreso : '. $FechaLlegada),0,0,'L');
$pdf->Cell(70,50,utf8_decode(' Fecha de análisis : __________________ '),0,0,'L');
$pdf->Cell(55,50,utf8_decode(' Fecha de reporte : __________________  '),0,0,'L');
$pdf->Ln();
$pdf->Cell(60,-37,utf8_decode('Número de análisis: ').($id),0,0,'L');
$pdf->Ln();
$pdf->Cell(55,50,utf8_decode('Área : '.($AreaAnalisis)),0,0,'L');
$pdf->Cell(140,50,utf8_decode('Tipo de Análisis: '.substr($Ensayos,0,85)),0,0,'L');
$pdf->Ln(30);

$pdf->Cell(180,4,utf8_decode('1. DESCRIPCIÓN DE LA MUESTRA: '),1,0,'L',TRUE);
$pdf->Ln();
$pdf->Cell(180,13,utf8_decode(''),1,0,'C');
$pdf->Ln();
$pdf->Cell(180,2,utf8_decode(''),0,0,'C');//espacio entre items
$pdf->Ln();
$pdf->Cell(180,4,utf8_decode('2. REACTIVOS Y ESTÁNDARES '),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(50,4,utf8_decode('REACTIVOS'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('LOTE'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('FECHA DE INGRESO'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('FECHA DE VENCIMIENTO'),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(50,4,utf8_decode('LAL (Limulus Amebocyte lysate)'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);

            $pdf->Cell(50,4,utf8_decode(' Reagent Water'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);

            $pdf->Cell(50,4,utf8_decode(' Pyrosperse Agente dispersante'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);

            $pdf->Cell(50,4,utf8_decode('Buffer tris'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('Endotoxina de E.coli O55:B5)'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(180,4,utf8_decode('OBSERVACIONES: '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' '),1,0,'C');
 
            $pdf->SetFont('Arial','B',7);
           
            $pdf->Ln(6);
            $pdf->Cell(180,4,utf8_decode('3. PRUEBA DE CONFIRMACIÓN DE LA SENSIBILIDAD DECLARADA DEL  LISADO'),1,0,'L',TRUE);
            $pdf->Ln(4);
               $pdf->Cell(180,4,utf8_decode('SENSIBILIDAD DEL REACTIVO'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(20,4,utf8_decode('No REPETICIONES'),1,0,'C');
             $pdf->SetFont('Symbol','',7);
            $pdf->Cell(20,4,utf8_decode('2').chr(108),1,0,'C');
           
            $pdf->Cell(20,4,chr(108),1,0,'C');
           // $pdf->Cell(10,5,chr($i),0,1);
            $pdf->Cell(20,4,utf8_decode('1/2').chr(108),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('1/4').chr(108),1,0,'C');
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(20,4,utf8_decode('(-)'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('(+)'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('PF'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Log'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('1'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('2'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('3'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('4'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
         
                      
            $pdf->Ln(9);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode('4. LIMITE DE ENDOTOXINAS'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(180,34,(''),1,0,'C');
            $pdf->Ln(4);
             //$pdf->Cell(20,4,utf8_decode('1/2').chr(108)
            $pdf->Cell(155,4,utf8_decode('5. MAXIMA DILUCIÓN VALIDA.  MDV = (límite de endotoxina x concentración de la Solución Muestra)/'),1,0,'R',TRUE);
            $pdf->SetFont('Symbol','',9); 
            $pdf->Cell(25,4,chr(108). ')',1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,34,utf8_decode(''),1,0,'C');
            $pdf->Ln(36);
            $pdf->Cell(180,4,utf8_decode('6. CALCULOS'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(180,34,utf8_decode(''),1,0,'C');
            $pdf->Ln(40);
            $pdf->Cell(180,4,utf8_decode('7. RESULTADOS'),1,0,'L',TRUE);
           $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(45,4,utf8_decode('CONTROL NEGATIVO'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('CONTROL POSITIVO'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('REPETICION 1'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('REPETICION 2'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');           
                      $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');       
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');  
            $pdf->Ln(16);
            $pdf->Cell(180,4,utf8_decode('8. INTERPRETACIÓN DE RESULTADOS Y CONCLUSIONES'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(180,24,utf8_decode(''),1,0,'C');
  
            
            $pdf->Ln(140);
            
// Generar caracteres especiales
//for($i=0;$i<=255;$i++)
//{
//$pdf->SetFont('Symbol','',14);
//$pdf->Cell(10,5,$i . " ",0,0);
//$pdf->Cell(10,5,chr($i),0,1);
//}
            
            $pdf->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
            $pdf->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('REALIZÓ'),0,0,'C');
            $pdf->Cell(90,4,utf8_decode('VERIFICÓ'),0,0,'C');
            $pdf->Ln(4);
             $pdf->SetFont('Arial','',9);
            $pdf->Cell(90,4,utf8_decode('ANALISTA DE MICROBIOLOGÍA'),0,0,'C');
            $pdf->Cell(90,4,utf8_decode('DIRECTOR TECNICO'),0,0,'C');
           $pdf->Output();
?>
