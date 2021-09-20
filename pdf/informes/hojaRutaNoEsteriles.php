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
                    $FechaA = substr($informe["fecha"],2,2),
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
    $this->Cell(30,5,utf8_decode('04'),1,0,'C');
    $this->SetXY(130, 20);
    $this->Cell(30,5,utf8_decode('VIGENCIA'),1,0,'C');
    $this->Cell(30,5,utf8_decode('08-08-16'),1,0,'C');
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
//$pdf->AddPage(L);
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
$pdf->Cell(180,7,utf8_decode(''),1,0,'C');
$pdf->Ln();
$pdf->Cell(180,2,utf8_decode(''),0,0,'C');//espacio entre items
$pdf->Ln();
$pdf->Cell(180,4,utf8_decode('2. MEDIOS DE CULTIVO '),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(15,4,utf8_decode('LP-LE / MEDIO'),1,0,'C');
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(11,4,utf8_decode('TSB'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('TSA'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('AS'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('C-MK'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('MK'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('RP'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('XLD'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('CTR'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('MS'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('MO'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('VRBD'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('MYP'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('BLL'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('SPS'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode('ARC'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(15,4,utf8_decode('LP'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(15,4,utf8_decode('LE'),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(11,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('OBSERVACIONES: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(6);
            $pdf->Cell(180,4,utf8_decode('3. PESAJE Y/O FILTRACIÓN'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(180,4,utf8_decode('Nota 1: Diligengiar el campo de equipo con la letra correspondiente: a. EQ-04  balanza  siembra antibioticos  b.  EQ-16 Equipo filtracion   c. EQ-15 balanza no estériles'),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('EQUIPO'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('CALIBRACIÓN'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('Peso (g) y/o Volumen (mL)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('OBSERVACIONES'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(23,4,utf8_decode('cumple'),1,0,'C');
            $pdf->Cell(22,4,utf8_decode('no cumple'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(23,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(6);
            $pdf->Cell(180,4,utf8_decode('4. DILUCIONES EN SERIE'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(48,4,utf8_decode('DILUCIONES SEMBRADAS'),1,0,'L');
            $pdf->Cell(22,4,utf8_decode('10').chr(185),1,0,'C');
            $pdf->Cell(22,4,utf8_decode('10').chr(185),1,0,'C');
            $pdf->Cell(22,4,utf8_decode('10').chr(178),1,0,'C');
            $pdf->Cell(22,4,utf8_decode('10').chr(178),1,0,'C');
            $pdf->Cell(22,4,utf8_decode('10').chr(179),1,0,'C');
            $pdf->Cell(22,4,utf8_decode('10').chr(179),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(48,4,utf8_decode('Recuento de AM'),1,0,'L');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(48,4,utf8_decode('Recuento de HYL'),1,0,'L');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(22,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('OBSERVACIONES: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(6);
            $pdf->Cell(180,4,utf8_decode('5. MONITOREO AMBIENTAL DE LA CABINA DE FLUJO LAMINAR.  UFC/ tiempo'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(180,4,utf8_decode('Nota 2: Diligengiar el campo de equipo con la letra correspondiente: d. EQ-03 cabina de flujo siembra antibioticos   e.EQ-17  Cabina siembra no estériles'),0,0,'L');
            $pdf->SetFont('Arial','B',9);
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('EQUIPO'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('RECUENTO AM'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('RECUENTO HyL'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('OBSERVACIONES'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(6);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(180,4,utf8_decode('Nota 3: Las cajas de petri se dejan expuestas durante el procedimiento de siembra.'),0,0,'L');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode('6. ANÁLISIS MICROBIOLÓGICO DE ANALISTAS   (GUANTES) UFC/guante'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('Nombre del Análista'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('RECUENTO AM'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('E.coli'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('OBSERVACIONES'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(6);
            $pdf->Cell(180,4,utf8_decode('7. CONTROLES'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode('Medio'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Control'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Concepto'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Control negativo'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('OBSERVACIONES '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode('o caldo'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Positivo'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Cumple'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('No Cumple'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Cumple'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('No Cumple'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode('TSB'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Sa;Ec;Sal;Pse'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('TSA'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Sa;Ec;Sal;Pse'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('Caldo Sabouraud'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Cand; A.bra'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('AS'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Cand; A.bra'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('C-MK'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Ec'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('MK'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Ec'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('RP'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Sal'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('XLD'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Sal'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('CTR'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Pse'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('MS'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('S.a'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('MO'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Ec'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('VRBD'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Ec'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('MYP'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('B.subtilis'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('Columbia'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Clos'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('  '),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(40,4,utf8_decode('ARC'),1,0,'C');
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(30,4,utf8_decode('Clos'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            
            $pdf->Ln(8);
            $pdf->Ln(10);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode('8. CÁLCULOS Y RESULTADOS '),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(180,44,utf8_decode(''),1,0,'C');
            $pdf->Ln(46);
            $pdf->Cell(30,4,utf8_decode('Microorganismo'),1,0,'L');
            $pdf->Cell(17,4,utf8_decode('Ec'),1,0,'C');
            $pdf->Cell(17,4,utf8_decode('Sa'),1,0,'C');
            $pdf->Cell(17,4,utf8_decode('Pse'),1,0,'C');
            $pdf->Cell(17,4,utf8_decode('Sal'),1,0,'C');
            $pdf->Cell(17,4,utf8_decode('BTB'),1,0,'C');
            $pdf->Cell(17,4,utf8_decode('Clos'),1,0,'C');
            $pdf->Cell(17,4,utf8_decode('Cand'),1,0,'C');
            $pdf->Cell(31,4,utf8_decode('Otros'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode('Pres/aus'),1,0,'L');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(17,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(31,4,utf8_decode(' '),1,0,'C');
         
            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode('9. INTERPRETACIÓN DE RESULTADOS Y CONCLUSIONES'),1,0,'L',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(180,44,utf8_decode(''),1,0,'C');
            $pdf->Ln(113);
           
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
