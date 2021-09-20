<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
$dato = $_GET['idMuestra'];
$modelReporte = new TablaReportesDbModelClass();
    $data = $modelReporte->getInfoPrincipalHR($dato);
            foreach ($data as $informe) {
                   $informes[] = array(
                   $id = $informe['id'],
                   $FechaLlegada = $informe['fecha_llegada'],
                   $AreaAnalisis = $informe['des_area_analisis'],
                   $Producto = $informe['nombre_producto'],
                   $Forma = $informe['FormaFarmaceutica'],
                   $Lote = $informe['lote']  
               );
           }
    $metodos = $modelReporte->getMetodosHR($dato);
            foreach ($metodos as $met) {
                   $informes[] = array(
                   $metodos = $met['metodos'] 
               );
           }
    $descripcion = $modelReporte->getDescripcionHR($dato);
            foreach ($descripcion as $desc) {
                   $descrip[] = array(
                   $descripcion = $desc['DESCRIPCION'] 
               );
           }
        $numCliente = $modelReporte->numeroCliente($dato);
            foreach ($numCliente as $nume) { $descrip[] = array(
                   $ident = $nume['elnum'] 
               );
           }
class PDF extends FPDF { 
    
    function Header()
{
    //Logo
    $this->Image('../../views/images/logoEmpresa.png',165,10,25);
    //Arial bold 15
    $this->SetFont('Arial','B',11);
    //Move to the right
    //$this->Cell(1);
    //Title
    $this->Cell(160,7,utf8_decode('HOJA DE TRABAJO ANALITICO'),0,0,'C');
    $this->SetFont('Arial','B',10);
     $this->Ln(18);
  
	// To be implemented in your own inherited class
}
function Footer()
{
    
    // Position at 1.5 cm from bottom
  $this->SetY(-20);
  $this->SetFont('Arial','B',7);
  $this->Cell(180,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
  $this->Ln();
  $this->Cell(90,5,utf8_decode('REV.00'),0,0,'L');
  $this->Cell(90,5,utf8_decode('PL-P-008-R-05'),0,0,'R');
  $this->Ln();
   // Print centered page number
  // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(169, 169, 169);
$pdf->RoundedRect(10, 25, 90, 6, 2,  'S', '1'); //Cliente
$pdf->RoundedRect(100, 25, 40, 6, 2,  'S', '');// Area
$pdf->RoundedRect(140, 25, 50, 6, 2,  'S', '2');// Area
$pdf->RoundedRect(10, 31, 60, 6, 2,  'S', '4');
$pdf->RoundedRect(70, 31, 60, 6, 2,  'S', '');
$pdf->RoundedRect(130, 31, 60, 6, 2,  'S', '3');
$pdf->SetXY(10, 3);
$pdf->Cell(90,50,utf8_decode('Nombre de la Muestra: '. $Producto),0,0,'L');
$pdf->Cell(40,50,utf8_decode('No. '.($ident)),0,0,'L');
$pdf->Cell(55,50,utf8_decode('Lote: '.($Lote)),0,0,'L');
$pdf->Ln();
$pdf->Cell(60,-37,'Fecha Ingreso : '.($FechaLlegada),0,0,'L');
$pdf->Cell(60,-37,'Fecha Inicio : ',0,0,'L');
$pdf->Cell(55,-37,'Fecha Final : ',0,0,'L');
//Producto
$pdf->RoundedRect(10, 37, 180, 6, 2,  'S', '12');
$pdf->RoundedRect(10, 43, 180, 6, 2,  'S', '34');
$pdf->Ln();
$pdf->Cell(90,50,utf8_decode('Especificaciones de Referencia: '.($metodos)),0,0,'L');
$pdf->Ln();
$pdf->Cell(60,-37,utf8_decode('Descripción: ').utf8_decode($descripcion),0,0,'L');
//Muestra
$pdf->Ln(-17);
$pdf->SetFont('Arial','B',7);



if($Forma == 'Material de Envase o empaque'){ //Material de Envase o Empaque
            $pdf->Ln(4);
            
            $pdf->Cell(90,4,utf8_decode('Material Volumetrico'),1,0,'C',TRUE);
            $pdf->Cell(90,4,utf8_decode('Equipos'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('No. Identificación'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Fecha Calif. o Calib'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Fecha Próxima Cali.'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(7);
             
            $pdf->Cell(180,4,utf8_decode('MEDIDAS'),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',6);
            $pdf->Cell(15,6,utf8_decode('Ensayo'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode('Peso'),1,0,'C');
            $pdf->Cell(30,6,utf8_decode('Volumen de Llenado(mL)'),1,0,'C');
            $pdf->Cell(15,6,utf8_decode('Gramaje'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(' '),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(' '),1,0,'C');
            $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('Especificación'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('1'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('2'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('3'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('4'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('5'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('6'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('7'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('8'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('9'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('10'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('Promedio'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('CV (<=5%)'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
                        $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode('Concepto'),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,6,utf8_decode(''),1,0,'C');
            
 } // Fin de Material de Envase y Empaque 
/////////INCIO LISTADO DE ENSAYOS EXCEPTO MATERIA DE ENVASE Y EMPAQUE////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerHojadeRuta($dato);
  foreach ($data1 as $informe1) {
            $Ensayo = $informe1["descripcion"];
            $Especificacion = $informe1["especificacion"];
            $EnsayoId = $informe1["id_ensayo"];
            $FormaId = $informe1["id_formula_farma"];
            $Plantilla = $informe1["id_plantilla"];
            $pdf->Ln(3);
    
            if($EnsayoId == '2654'){// valida si es descripcion el ensayo,En caso de que sea DESCRIPCION, no sale nada
                $pdf->Cell(1,1,(''),0,0,'C'); }//Cierra else
           

 if($Plantilla == '2'){// FQ
                      
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,0,utf8_decode('Ensayo: ').utf8_decode($Ensayo),0,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Especificación: ').utf8_decode($Especificacion),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Condiciones de Trabajo: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Anexos de Página ___ a ___ '),0,0,'C');
$pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode('Material Volumétrico'),1,0,'C',TRUE);
            $pdf->Cell(45,4,utf8_decode('Estándar'),1,0,'C',TRUE);
            $pdf->Cell(45,4,utf8_decode('Equipos'),1,0,'C',TRUE);
            $pdf->Cell(60,4,utf8_decode('Datos Primarios'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C',TRUE);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C',TRUE);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C',TRUE);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(60,4,utf8_decode('Incluye Reactivos Analíticos,Soluciones,Consumibles'),1,0,'C',TRUE);
            $pdf->SetFont('Arial','B',5);
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('No.Id'),1,0,'C');
            $pdf->Cell(25,4,utf8_decode('Nombre Completo (base,sal)'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('No. Id.'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('Potencia'),1,0,'C');
            $pdf->Cell(25,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('Fec.Cali.'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('Próx.Fecha'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Aviso de Entrada'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('Cantidad'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
                        $pdf->Ln(4);
$pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);

            
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(''),1,0,'C');
     $pdf->Ln(4);
             $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,4,utf8_decode('Modelo(s) de calculo y demostración (1 Calculo)'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(120,4,utf8_decode('Calculo'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('Promedio'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('CV (%)'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(120,20,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,20,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,20,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,20,utf8_decode(''),1,0,'C');
            $pdf->Ln(20);
            //$pdf->SetFont('Arial','B',7);
            //$pdf->Cell(180,4,utf8_decode('Concepto Ensayo (Cumple o No Cumple): '),1,0,'L');
	    $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Lectura_____________________       Concepto de Ensayo (Cumple o No Cumple) __________________ '),0,0,'R');
                  
                  }// Fin FQ



if($Plantilla == '3')// valida si es valoracion HPLC 
            {//Inicio fisicoquimico
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,0,utf8_decode('Ensayo: ').utf8_decode($Ensayo),0,0,'L');
   $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Especificación: ').utf8_decode($Especificacion),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Anexos de Página ___ a ___ '),0,0,'C');
            $pdf->Ln(4);
            
            $pdf->Cell(50,4,utf8_decode('Condiciones de Análisis'),1,0,'C',TRUE);
            $pdf->Cell(50,4,utf8_decode('Material Volumétrico'),1,0,'C',TRUE);
            $pdf->Cell(80,4,utf8_decode('Estándar'),1,0,'C',TRUE);
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,utf8_decode('Columna'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Nombre Completo (base,sal)'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Potencia'),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(20,4,utf8_decode('Fase Móvil'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Flujo'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
	$pdf->Cell(20,4,utf8_decode('Detector'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Long. de Onda'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Vol. de inyección'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Temperatura'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Presión'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
$pdf->SetFont('Arial','B',7);
            $pdf->Cell(50,4,utf8_decode('System Suitability Test (SST)'),1,0,'C',TRUE);
            $pdf->Cell(50,4,utf8_decode('Columnas'),1,0,'C',TRUE);
            $pdf->Cell(80,4,utf8_decode('Equipos'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(25,4,utf8_decode('Parametros'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('Especif.'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Nombre Completo'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Fecha Cali.'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Próxima Cali.'),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(25,4,utf8_decode('Platos Teóricos'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('>= 1000'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(25,4,utf8_decode('Asimetría (Tailing)'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('<= 2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(25,4,utf8_decode('Factor de Capacidad(K)'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('> 2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(25,4,utf8_decode('Resolución(2 activos mín)'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('> 2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');            
             $pdf->Ln(4);
            $pdf->Cell(25,4,utf8_decode('CV STDs'),1,0,'C');
            $pdf->Cell(10,4,utf8_decode('<= 2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');   
            $pdf->Ln(6);
             $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,4,utf8_decode('Datos Primarios (Incluye Reactivos Analiticos, Soluciones, Consumibles)'),1,0,'C',TRUE);
            $pdf->Ln(4);
	
$pdf->Cell(45,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(25,4,utf8_decode('No.Identificación'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Cant. (g,mg,mL)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(25,4,utf8_decode('No.Identificación'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Cant. (g,mg,mL)'),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
                        $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);

            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(25,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
             $pdf->Ln(4);
             $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,4,utf8_decode('Modelo(s) de calculo y demostración (1 Calculo)'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(120,4,utf8_decode('Calculo'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('Promedio'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('CV (%)'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(120,30,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,30,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,30,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,30,utf8_decode(''),1,0,'C');
            $pdf->Ln(30);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,4,utf8_decode('Concepto Ensayo (Cumple o No Cumple): '),1,0,'L');
            }// Fin HPLC

 if($Plantilla == '4'){// valida si es valoracion por Gases

            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,0,utf8_decode('Ensayo: ').utf8_decode($Ensayo),0,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Especificación: ').utf8_decode($Especificacion),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Anexos de Página ___ a ___ '),0,0,'C');
            $pdf->Ln(4);
             $pdf->Cell(50,4,utf8_decode('Condiciones de Análisis'),1,0,'C',TRUE);
            $pdf->Cell(50,4,utf8_decode('Material Volumétrico'),1,0,'C',TRUE);
            $pdf->Cell(80,4,utf8_decode('Estándar'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(20,4,utf8_decode('Diluente'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Nombre Completo (base,sal)'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Potencia'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Vol. de Inyección'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');          
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Modo de Inyección'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');  
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Relación Split'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');  
                        $pdf->Ln(4);
$pdf->Cell(20,4,utf8_decode('Tiempo Splitless'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');  
                                    $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Temp. Inyector'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');  
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Ref.de Columna'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(4);
            
            $pdf->Cell(20,4,utf8_decode('Dimensiones Col.'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(50,4,utf8_decode('Columnas'),1,0,'C',TRUE);
            $pdf->Cell(80,4,utf8_decode('Equipos'),1,0,'C',TRUE);
            $pdf->SetFont('Arial','',6);
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Temp. Ini. de Horno'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Nombre/Tipo'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Identificación'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Fecha Cali.'),1,0,'C');
            $pdf->Cell(20,4,utf8_decode('Prox. Cali'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Gradiente.de Temp.'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Temp. Final Horno'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
              $pdf->Ln(4);
$pdf->Cell(20,4,utf8_decode('Gas de Arrastre'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
                        $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Flujo'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Detector'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Temp. Detector'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(20,4,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Frec. del Detector'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(130,4,utf8_decode('Datos Primarios (Incluye Reactivos Analiticos, Soluciones,Consumibles)'),1,0,'C',TRUE);
            $pdf->SetFont('Arial','',5);
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Relación flujo H2/Aire'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(50,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Aviso de Entrada: No. Identificacion'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Cantidad (g,mg,mL)'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Makeup Gas'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Flujo Makeup Gas'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(50,4,utf8_decode('System Suitability Test (SSL)'),1,0,'C',TRUE);
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
 $pdf->Cell(20,4,utf8_decode('Parámetros'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('Especificación'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Platos Teóricos'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('>=1000'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('Asimetría(Tailing)'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('>2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
             $pdf->SetFont('Arial','',5);
            $pdf->Cell(20,4,utf8_decode('Resolución (2 Act.Min.)'),1,0,'C');
            $pdf->SetFont('Arial','',6);
            $pdf->Cell(15,4,utf8_decode('>2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode('CVS STDs'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('<=2.0'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(''),1,0,'C');
$pdf->Ln(6);
$pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,4,utf8_decode('Modelo(s) de calculo y demostración (1 Calculo)'),1,0,'C',TRUE);
            $pdf->Ln(4);
            $pdf->Cell(120,4,utf8_decode('Calculo'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('Promedio'),1,0,'C');
            $pdf->Cell(15,4,utf8_decode('CV (%)'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(120,30,utf8_decode(''),1,0,'C');
            $pdf->Cell(30,30,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,30,utf8_decode(''),1,0,'C');
            $pdf->Cell(15,30,utf8_decode(''),1,0,'C');
            $pdf->Ln(30);
            $pdf->Cell(180,4,utf8_decode('Concepto Ensayo (Cumple o No Cumple): '),1,0,'L');

}// Fin Gases













            }//Fin Foreach
            /////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,5,utf8_decode('Observaciones: ____________________________________________________________________________________________________________________'),0,0,'C');
            $pdf->Ln(5);
            $pdf->Cell(180,5,utf8_decode('___________________________________________________________________________________________________________________________________'),0,0,'C');

     $pdf->Ln(8);   
      $pdf->Cell(180,5,utf8_decode('Registro Balanza'),1,0,'C');      
       $pdf->Ln(5);  
       $pdf->Cell(180,170,utf8_decode(''),1,0,'C'); 
       $pdf->Ln(180);
       $pdf->Cell(180,6,utf8_decode('CONCLUSIONES:'),1,0,'L'); 
       $pdf->Ln(6);
       $pdf->Cell(180,6,utf8_decode('Concepto Final (Cumple o No Cumple):'),1,0,'L'); 
            $pdf->Ln(8);
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(60,6,utf8_decode('Realizado Por:'),1,0,'L');
            $pdf->Cell(60,6,utf8_decode('Revisado y Aprobado Por:'),1,0,'L');
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Ln(6);
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(60,6,utf8_decode('Nombre:'),1,0,'L');
            $pdf->Cell(60,6,utf8_decode('Nombre:'),1,0,'L');
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Ln(6);
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(60,6,utf8_decode('Firma:'),1,0,'L');
            $pdf->Cell(60,6,utf8_decode('Firma:'),1,0,'L');
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Ln(6);
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(60,6,utf8_decode('Fecha:'),1,0,'L');
            $pdf->Cell(60,6,utf8_decode('Fecha:'),1,0,'L');
            $pdf->Cell(30,6,utf8_decode(''),0,0,'L');
       $pdf->Output();
?>
