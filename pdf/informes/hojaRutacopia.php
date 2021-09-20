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
                   $FechaLlegada =  substr($informe['fecha_llegada'],0,10),
                   $aa =   substr($FechaLlegada,2,2),
                   $mm =   substr($FechaLlegada,5,2),
                   $dd =   substr($FechaLlegada,8,2),
                   $FechaLlegada1 =   $dd.'-' . $mm .'-'.$aa,
                   $AreaAnalisis = $informe['des_area_analisis'],
                   $Producto = $informe['nombre_producto'],
                   $Forma = $informe['FormaFarmaceutica'],
                   $Lote = $informe['lote']  
                   
               );
           }
           
           $Producto = substr($Producto,0,46);
    $metodos = $modelReporte->getMetodosHR($dato);
            foreach ($metodos as $met) {
                   $informes[] = array(
                   $metodos = $met['metodos'] 
               );
           }
     $eyos = $modelReporte->getEnsayosARealizarHR($dato);
            foreach ($eyos as $ey) {
                   $informes[] = array(
                   $EnsayosARealizar = $ey['ensayosarealizar'] 
               );
           }
    $descripcion = $modelReporte->getDescripcionHR($dato);
            foreach ($descripcion as $desc) {
                   $descrip[] = array(
                   $descripcion = $desc['DESCRIPCION'] 
               );
           }
        $numCliente = $modelReporte->numeroCliente($dato);
            foreach ($numCliente as $nume) { $numee[] = array(
                   $ident = $nume['elnum'] 
               );
           }
class PDF extends FPDF { 
function Header()
{
    //Logo
    $this->Cell(40,20,utf8_decode(''),1,0,'C');
    $this->Image('../../views/images/logoEmpresa.png',20,12,21);
    //Arial bold 15
    $this->SetFont('Arial','B',11);
   
    $this->Cell(80,20,utf8_decode('HOJA DE TRABAJO ANÁLITICO'),1,0,'C');

    
     $this->SetFont('Arial','B',7);
    $this->Cell(30,5,utf8_decode('Código'),1,0,'C');
    $this->Cell(30,5,utf8_decode('F-145-(LA-008)'),1,0,'C');
   
    $this->SetXY(130, 15);
    $this->Cell(30,5,utf8_decode('Versión'),1,0,'C');
    $this->Cell(30,5,utf8_decode('01'),1,0,'C');
    $this->SetXY(130, 20);
    $this->Cell(30,5,utf8_decode('Vigente Desde'),1,0,'C');
    $this->Cell(30,5,utf8_decode('06-02-17'),1,0,'C');
    $this->SetXY(130, 25);
    $this->Cell(30,5,utf8_decode('Página'),1,0,'C');
    $this->Cell(30,5, $this->PageNo().' de {nb}' ,1,0,'C');
    $this->Ln(5);
	// To be implemented in your own inherited class
}
function Footer()
{
   // Position at 1.5 cm from bottom
  $this->SetY(-26);
  $this->SetFont('Arial','B',6);
  //$this->Cell(180,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
  $this->Ln();
 // $this->Cell(90,5, utf8_decode('3 FOR-004') . utf8_decode(' REV.04'),0,0,'L');
  $this->Cell(90,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'R');
  //$this->Ln();
   // Print centered page number
  // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(169, 169, 169);
$pdf->RoundedRect(10, 32, 180, 6, 2,  'S', '12');
//$pdf->RoundedRect(10, 32, 90, 6, 2,  'S', '1'); //Cliente
//$pdf->RoundedRect(100, 32, 40, 6, 2,  'S', '');// Area
//$pdf->RoundedRect(140, 32, 50, 6, 2,  'S', '2');// Area
//$pdf->RoundedRect(10, 39, 60, 6, 2,  'S', '4');
//$pdf->RoundedRect(70, 39, 60, 6, 2,  'S', '');
//$pdf->RoundedRect(130, 39, 60, 6, 2,  'S', '3');
//$pdf->SetXY(10, 3);


 $pdf->Ln(-20);
 $pdf->SetFont('Arial','B',7);
$pdf->Cell(180,50,utf8_decode('HOJA DE TRABAJO ANALÍTICO '. strtoupper ($Forma) .  ' ' .strtoupper ($Producto)),0,0,'C');
//$pdf->Cell(40,50,utf8_decode('No. '.($ident)),0,0,'L');
//$pdf->Cell(55,50,utf8_decode('Lote: '.($Lote)),0,0,'L');
$pdf->Ln(28);
$pdf->Cell(20,7,'F. DE INGRESO',1,0,'C');
$pdf->Cell(15,7,utf8_decode('F.ANÁLISIS'),1,0,'C');
$pdf->Cell(25,7,'LQF',1,0,'C');
$pdf->Cell(85,7,'Nombre',1,0,'C');
$pdf->Cell(35,7,'Lote',1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,7,$FechaLlegada1,1,0,'C');
$pdf->Cell(15,7,'',1,0,'C');
$pdf->Cell(25,7,$ident,1,0,'C');
$pdf->Cell(85,7,utf8_decode($Producto),1,0,'C');
$pdf->Cell(35,7,substr($Lote,0,22),1,0,'C');
$pdf->SetFont('Arial','B',9);
//Producto
//$pdf->RoundedRect(10, 37, 180, 6, 2,  'S', '12');
//$pdf->RoundedRect(10, 43, 180, 6, 2,  'S', '34');
$pdf->Ln();
$pdf->MultiCell(180,4,utf8_decode('ENSAYOS A REALIZAR: ').utf8_decode($EnsayosARealizar),1,L,FALSE);
$pdf->Ln(0);
$pdf->Cell(180,4,utf8_decode('MÉTODOS: '.$metodos),1,0,'L');
$pdf->Ln();
$pdf->SetFillColor(158, 158, 158); // establece el color del fondo de la celda (en este caso es GRIS
$pdf->SetFont('Arial','B',9);
$pdf->Cell(180,4,utf8_decode('Descripción'),1,0,'C',True);// True permite que asigne el color
$pdf->SetFont('Arial','',9);
$pdf->Ln(4);
$pdf->MultiCell(180,4,utf8_decode($descripcion),1,L,FALSE);
$pdf->Ln(0);
$pdf->MultiCell(180,4, '',1,L,FALSE);
//Muestra
$pdf->SetFont('Arial','B',7);
if($Forma == 'Material Envase o Empaque'){ //Material de Envase o Empaque
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
/////////INCIO LISTADO DE ENSAYOS EXCEPTO MATERIAL DE ENVASE Y EMPAQUE////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerHojadeRuta($dato);
  foreach ($data1 as $informe1) {
            $Ensayo = $informe1["desEspecifica"];
            $Especificacion1 = $informe1["especificacion"];
            $EnsayoId = $informe1["id_ensayo"];
            $TipoMuestra = $informe1["id_formula_farma"];
            $Plantilla = $informe1["id_plantilla"];
            $pdf->Ln(0);
    
            
            
$exp_regular = array();
$exp_regular[0] = '/<br>/';
$exp_regular[1] = '/<div>/';
$exp_regular[2] = '/<\/div>/';
$exp_regular[3] = '/<o:p>/';
$exp_regular[4] = '/&nbsp;/';
$exp_regular[5] = '/&lt;/';
$exp_regular[6] = '/<\/sup>/';
$exp_regular[7] = '/<\/p>/';
$exp_regular[8] = '/<sup>/';
$exp_regular[9] = '/<p>/';
$exp_regular[10] = '/<sup>/';
$exp_regular[11] = '/<p class="MsoNormal">/';
$exp_regular[12] = '/<\/o:p>/';
$exp_regular[13] = '/≤/';

//Array de los textos en la sustitucion
$cadena_nueva = array();
$cadena_nueva[0] = "\r\n";
$cadena_nueva[1] = "\r";
$cadena_nueva[2] = '';
$cadena_nueva[3] = '';
$cadena_nueva[4] = '';
$cadena_nueva[5] = "<";
$cadena_nueva[6] = '';
$cadena_nueva[7] = '';
$cadena_nueva[8] = '';
$cadena_nueva[9] = '';
$cadena_nueva[10] = '';
$cadena_nueva[11] = '';
$cadena_nueva[12] = '';
$cadena_nueva[12] = '<=';
//saco el resultado por pantalla
$Especificacion = preg_replace($exp_regular, $cadena_nueva, $Especificacion1);
            
            
            if($EnsayoId == '1'){// valida si es descripcion el ensayo,En caso de que sea DESCRIPCION, no sale nada
                $pdf->Cell(1,1,(''),0,0,'C'); }//Cierra else
                //$pdf->Cell(180,4,utf8_decode('Plantilla '. $Plantilla . 'y Tipo Muestra: ' . $TipoMuestra),1,0,'C',True);// True permite que asigne el color
          //  if($TipoMuestra == '2'){// MATERIA PRIMA
            // Plantillas según analisis de MP
           if($Plantilla == '2'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion . '            CUMPLE? :  SI[    ]   NO[    ]'),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);       
//            $pdf->Cell(180,4,utf8_decode('Datos del (los) Estándar (es)'),1,0,'C',True);// True permite que asigne el color
//            $pdf->Cell(90,4,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
           $pdf->Ln(4);
            
           }  // Identificación por HPLC
           if($Plantilla == '3'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(180,4,utf8_decode('Estándar'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Muestra'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Longitud de Onda'),1,0,'C');
            $pdf->Ln(4);
             $pdf->Cell(180,4,utf8_decode('Equipo UV'),1,0,'C');
            $pdf->Ln(4);
           }   // Identificación por UV
           if($Plantilla == '4'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(20,4,utf8_decode('P Vacío (Pv)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('P + muestra (Pm)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('Peso+Agua (PH2O)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('Cálculo =(Pm-Pv)/ (PH2O-Pv)'),1,0,'L');
            $pdf->Cell(40,4,utf8_decode('Resultado'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }   // Peso Pesos Varios
           if($Plantilla == '5'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(180,4,utf8_decode('P. Inicial'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('P. Muestra'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('P. Muestra'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('P. Final'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('W1 (P. final - P. Inicial) (Wm1)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('W2 (P. Muestra)  (Wm2)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('W3 (P. filtrado - P. inicial)  (Wm3)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Dilución (mL) (Dil)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Resultado'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Cálculo=((100*Wm1)*(Dil+Wm2))/((Wm2*Wm3)*(1-(0,01*H)))'),1,0,'L');
            $pdf->Ln(4);
           }   // Contenidos Varios
           if($Plantilla == '6'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(180,4,utf8_decode('Muestra'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Resultado'),1,0,'L');
            $pdf->Ln(4);
           }   // Disolución Totalidad de la Dosilución
           if($Plantilla == '7'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(50,4,utf8_decode('p. muestra'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Equipo'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }   // pH
           if($Plantilla == '8'){
            $pdf->Cell(180,4,utf8_decode('Datos del (los) Estándar (es)'),1,0,'C',True);// True permite que asigne el color
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode('Código'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Lote'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Potencia (P)'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('FV'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);   
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4); 
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(90,4,utf8_decode('Estándar:'),1,0,'C');
            $pdf->Cell(90,4,utf8_decode('Muestra:'),1,0,'C');
            $pdf->Ln(4); 
            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
            $pdf->Ln(4); 
            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('St2: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M2: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'C', True);
            $pdf->Ln(4);
            
           if($TipoMuestra==2){
             $pdf->Cell(180,4,utf8_decode(' __ de Activo = (Rm*Ps*P*D)/(Rs*Pm)'),1,0,'L');
            $pdf->Ln(4);            
            $pdf->Cell(180,4,utf8_decode('__ de Activo en B. S. = (de Activo en B. H. Promedio)*100/(100-H)'),1,0,'L');
           }
            else
            {
            
                

//Uniformidad de Dosis : % Activo = (Pcd*Pj)/Cp
                
                
            $pdf->Cell(180,4,utf8_decode(' __ de Activo/vial = (Rm*Ps*P*Cp*D)/(Rs*Pm)'),1,0,'L');
            $pdf->Ln(4);            
            $pdf->Cell(180,4,utf8_decode('__ Declarado = 100*(g Activo/Vial Promedio)/Cd'),1,0,'L');
              $pdf->Ln(4);            
            $pdf->Cell(180,4,utf8_decode('Uniformidad de Dosis : __ Activo = (Pcd*Pj)/Cp'),1,0,'L');
            
            }
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Fase Móvil'),1,0,'L');
            $pdf->Ln(12);
            $pdf->Cell(180,12,utf8_decode('Resolución'),1,0,'L');
            $pdf->Ln(12);
            $pdf->Cell(90,4,utf8_decode('Balanza'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
            $pdf->Ln(4);
            
           }   // Valoración por HPLC
           if($Plantilla == '9'){
            $pdf->Cell(180,4,utf8_decode('Datos del (los) Estándar (es)'),1,0,'C',True);// True permite que asigne el color
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode('Código'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('Nombre'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('Lote'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Potencia (P)'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('FV'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);   
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4); 
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(90,4,utf8_decode('Estándar:'),1,0,'C');
            $pdf->Cell(90,4,utf8_decode('Muestra:'),1,0,'C');
            $pdf->Ln(4); 
            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
            $pdf->Ln(4); 
            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'),1,0,'L');
            $pdf->Ln(4);            
            $pdf->Cell(180,4,utf8_decode('% de Activo en B. S. = (% de Activo en B. H. Promedio)*100/(100-H)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,8,utf8_decode('Fase Móvil'),1,0,'L');
            $pdf->Ln(8);
            $pdf->Cell(90,4,utf8_decode('Balanza'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
            $pdf->Ln(4);
            
           }   // Valoración por GASES  SIN EVALUAR
           if($Plantilla == '10'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(90,4,utf8_decode('Titulante'),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('Factor'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('Lote'),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('Equivalente  HClO4   0,1N      7,507'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(35,4,utf8_decode('Muestra(Pm1)'),1,0,'L');
            $pdf->Cell(55,4,utf8_decode('Volumen Muestra(Vc1)'),1,0,'L');
            $pdf->Cell(35,4,utf8_decode('Muestra(Pm2)'),1,0,'L');
            $pdf->Cell(55,4,utf8_decode('Volumen Muestra(Vc2)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Blanco: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('% en Base Húmeda= 100*((Vb-Vc)*Eq*Fti)/Pm'),1,0,'L');
            $pdf->Ln(4);            
            $pdf->Cell(180,4,utf8_decode('% en Base Seca= (% Promedio en B. H.)*100/(100-H)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('Balanza'),1,0,'L');
            $pdf->Ln(4);
           }  // Valoración por UV
           if($Plantilla == '13'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(45,4,utf8_decode('P Vacío (Pv)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('P muestra Ini. (Pmi)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('P muestra Fin. (Pmf)'),1,0,'C');
             $pdf->Cell(45,4,utf8_decode('Equipo'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
          $pdf->Cell(180,4,utf8_decode('Cálculo=100*(Pmi-Pmf)/(Pmi-Pv)'),1,0,'L');
            $pdf->Ln(4);
           $pdf->Cell(180,4,utf8_decode('Resultado'),1,0,'L');
            $pdf->Ln(4);
           }  // Pérdida por secado
           if($Plantilla == '14'){   
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(40,4,utf8_decode('Peso'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Dilución'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Solvente'),1,0,'C');
            $pdf->Cell(60,4,utf8_decode('Clasificación (P)'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);   
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4); 
           }  // Solubilidad
           if($Plantilla == '15'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(50,4,utf8_decode('Peso'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Equipo KF'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Agua KF Determinación de Agua Método I
           if($Plantilla == '16'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(90,4,utf8_decode('Punto de Fusión'),1,0,'C');
            $pdf->Cell(90,4,utf8_decode('Equipo'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Punto de Fusión
           if($Plantilla == '17'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(45,4,utf8_decode('P Vacío (Pv)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('P muestra Ini. (Pmi)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('P muestra Fin. (Pmf)'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('Equipo'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(45,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L');
            $pdf->Ln(4);
           $pdf->Cell(180,4,utf8_decode('Resultado'),1,0,'L');
            $pdf->Ln(4);
           }  // Residuo de Incineración Residuos de ignición
           if($Plantilla == '18'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(90,4,utf8_decode('Estándar'),1,0,'C');
            $pdf->Cell(90,4,utf8_decode('Muestra'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Uniformidad de contenido Uniformidad
           if($Plantilla == '19'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(180,4,utf8_decode('Fase Móvil'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('% de Impureza: (Ri/Rs)*(Ps*D/Pm)*P*(1/Fimp)'),1,0,'L');
           // $pdf->Ln(4);
           // $pdf->Cell(180,4,utf8_decode('% de Activo en B. S. = (% de Activo Promedio en B. H.)*100/(100-H))'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,6,utf8_decode('Solución Muestra'),1,0,'L');
            $pdf->Ln(6);
                        $pdf->Cell(180,6,utf8_decode('Solución  Estándar'),1,0,'L');
            $pdf->Ln(6);
                        $pdf->Cell(180,6,utf8_decode('Aptitud del Sistema'),1,0,'L');
            $pdf->Ln(6);
              //          $pdf->Cell(180,6,utf8_decode('Verificación'),1,0,'L');
            //$pdf->Ln(6);
           }  // Impurezas orgánicas - Compuestos Relacionados
           if($Plantilla == '20'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(40,4,utf8_decode('Muestra (Pm)'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('P. Inicial (Pi)'),1,0,'C');
            $pdf->Cell(30,4,utf8_decode('P. Final (Pf)'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Cell(40,4,utf8_decode('Cálculo'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Sustancias Insolubles - Sustancias Hidrosolubles
           if($Plantilla == '21'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(50,4,utf8_decode('Control'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('P. muestra'),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Resultado'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Límites varios
           if($Plantilla == '27'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(50,4,utf8_decode('Lectura'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('Angulo (°)'),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('P. Muestra g (Pm)'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('1.'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Dilución D: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('2.'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Longitud (dm): '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('3.'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Resultado: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('4.'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Cálculo=(100*Angulo)/(dm*Conc): '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('5.'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Concentración=(Pm*((100-%H)/100)/ D)*100'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode('Promedio:'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Equipo: '),1,0,'C');
            $pdf->Ln(4);
           }  // Rotación Espécifica  Gravedad Específica 
           if($Plantilla == '28'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(100,4,utf8_decode(''),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Equipo'),1,0,'C');
            $pdf->Ln(4);
           }  // Punto de Fusión -  Temperatura de Fusión
           if($Plantilla == '29'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(20,4,utf8_decode('P Vacío (Pv)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('P muestra Ini (Pmi)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('P Muestra Fin (Pmf)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'L');
            $pdf->Cell(10,4,utf8_decode('Equipo'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Peso Pesos Varios
           if($Plantilla == '30'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(100,4,utf8_decode('Resultado: '),1,0,'C');
            $pdf->Ln(4);
           }  // Apariencia de la solución
           if($Plantilla == '31'){
            $pdf->Cell(180,4,utf8_decode('Disolución: _____________Etapa Acida____________'),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4); 
            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('St2: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M2: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Condiciones: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('Medio de Disolución: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Gastrorresistencia: % de Activo = 100*(Rmd*Psd*P*Dd)/(Rs*Cd*100)'),1,0,'L');
            $pdf->Ln(4);            
                        $pdf->Cell(180,4,utf8_decode('Disolución: _____________Etapa Amortiguada___________'),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4); 
            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('St2: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('M2: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Condiciones: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('Medio de Disolución: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode(' % de Activo = (Rmd*Psd*P*Dd)/(Rsd*Cd*100)'),1,0,'L');
            $pdf->Ln(4); 
            }  // Gastrorresistencia Disolución VARIAS HORAS
           if($Plantilla == '33'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(36,4,utf8_decode('1.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('2.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('3.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('4.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('5.'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(36,4,utf8_decode('6.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('7.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('8.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('9.'),1,0,'L');
            $pdf->Cell(36,4,utf8_decode('10.'),1,0,'L');
            $pdf->Ln(4);
           $pdf->Cell(180,4,utf8_decode('Resultado:'),1,0,'L');
            $pdf->Ln(4);
           }  // Peso neto uniformidad de dosis
           if($Plantilla == '34'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(180,4,utf8_decode('Fase Móvil: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Muestra: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Estándar: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Resolución: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(100,12,utf8_decode('Resultado: '),1,0,'C');
            $pdf->Cell(80,12,utf8_decode('CUMPLE   SI[   ]    NO[   ] '),1,0,'C');
            $pdf->Ln(12);
            $pdf->Cell(90,4,utf8_decode('BALANZA: '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('HPLC: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(90,4,utf8_decode('  '),1,0,'L');
            $pdf->Cell(90,4,utf8_decode('  '),1,0,'L');
            $pdf->Ln(4);
           }  // Pureza Cromatográfica
           if($Plantilla == '36'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(12);
           }  // Jerinabilidad  o un solo campo Alcalinidad
           if($Plantilla == '38'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad HCI (N)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Cálculo=((Vb-Vm)*56,11*N*F)/Pm'),1,0,'L'); 
            $pdf->Ln(4);
              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Indice de Saponificación
           if($Plantilla == '44'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(50,4,utf8_decode('P. Inicial (Pi)'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('P. muestra (Pm)'),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Volumen (V)'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Resultado: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Cálculo=(Pm-Pi)/ V'),1,0,'L');
            $pdf->Ln(4);
           }   // Densidad 
           if($Plantilla == '52'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,4,utf8_decode('Blanco'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Muestra'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(60,4,utf8_decode('Máximo 0,4 a 240 nm'),1,0,'L');
            $pdf->Cell(60,4,utf8_decode('Máximo 0,3 a 250 nm - 260 nm'),1,0,'L');
            $pdf->Cell(60,4,utf8_decode('Máximo 0,1 a 270 nm - 340 nm'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(60,4,utf8_decode(''),1,0,'L');
            $pdf->Cell(60,4,utf8_decode(''),1,0,'L');
            $pdf->Cell(60,4,utf8_decode(''),1,0,'L');
            $pdf->Ln(4);
           }   // Absorción en el UV
           if($Plantilla == '67'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(45,4,utf8_decode('Muestra'),1,0,'C'); 
            $pdf->Cell(45,4,utf8_decode('W lleno'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('W vacío'),1,0,'C');
            $pdf->Cell(45,4,utf8_decode('W producto'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('1'),1,0,'C'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('2'),1,0,'C'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('3'),1,0,'C'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('4'),1,0,'C'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
            $pdf->Ln(4);
           }  // Peso de Llenado
           if($Plantilla == '69'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(20,4,utf8_decode('Muestra (Pm): '),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('P. Vacío (Pv)): '),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('P. Final  (Pf): '),1,0,'L');
            $pdf->Cell(30,4,utf8_decode('Resultado: '),1,0,'L');
            $pdf->Cell(40,4,utf8_decode('Cálculo=100*(Pf-Pv)/Pm: '),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Ácidos grasos libres
           if($Plantilla == '70'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad Na2S2O3 (N)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Cálculo=((Vb-Vm)*126,9*N*F)/(Pm*10)'),1,0,'L'); 
            $pdf->Ln(4);
              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Indice de Yodo
           if($Plantilla == '71'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad NaOH (N)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Cálculo=(Vm*56,11*N)/Pm'),1,0,'L'); 
            $pdf->Ln(4);
              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Indice de Acidez
           if($Plantilla == '72'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Muestra'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Estándar'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Fase Móvil'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Ecuación'),1,0,'C'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('% Limite p-Aminofenol libre =(Ps*P*D*Rm)/(Rs*Pm)'),1,0,'L'); 
            $pdf->Ln(4);
           }  // p-aminofenol libre
           if($Plantilla == '75'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad Na2S2O3 (N)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Cálculo=10((Vm-Vb)*1000*N*F)/Pm'),1,0,'L'); 
            $pdf->Ln(4);
              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Indice de Peróxido
           if($Plantilla == '76'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('P Vacío (Pv)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('P muestra Ini. (Pmi)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('P muestra Fin. (Pmf)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Residuo de Evaporación
           if($Plantilla == '78'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad HCI (N)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Cálculo Índice de Saponificación (S) =((Vb-Vm)*56,11*N*F)/Pm'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Cálculo Grado de Hidrólisis= 100-((7,84S/(100-0,075S))'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Grado de hidrólisis
           if($Plantilla == '79'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(45,12,utf8_decode('Muestra/Dilución'),1,0,'C'); 
            $pdf->Cell(45,12,utf8_decode('Titulante'),1,0,'C'); 
            $pdf->Cell(45,12,utf8_decode('Lote'),1,0,'C'); 
            $pdf->Cell(45,12,utf8_decode('Factor'),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
            $pdf->Ln(4);
            $pdf->Cell(45,12,utf8_decode('Resultado: '),1,0,'L'); 
            $pdf->Ln(4);
           }  // Límite de dioxido de azufre
           if($Plantilla == '80'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('P Vacío (Pv)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('P muestra Ini. (Pmi)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('P muestra Fin. (Pmf)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L'); 
            $pdf->Ln(4);
            $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(4);
             $pdf->Cell(180,12,utf8_decode('Equipo: '),1,0,'L'); 
            $pdf->Ln(4);
          
           }  // Residuos de ignición
           if($Plantilla == '90'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(50,4,utf8_decode('Cond. H2O'),1,0,'C');
            $pdf->Cell(50,4,utf8_decode('Cond. Muestra'),1,0,'C');
            $pdf->Cell(80,4,utf8_decode('Equipo'),1,0,'C');
            $pdf->Ln(4);
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
            $pdf->Ln(4);
           }  // Conductividad
           if($Plantilla == '93'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Titulante'),1,0,'L'); 
            $pdf->Ln(12);
            $pdf->Cell(180,12,utf8_decode('P. Muestra'),1,0,'L'); 
            $pdf->Ln(12);
            $pdf->Cell(180,12,utf8_decode('Vol. Mtra.'),1,0,'L'); 
            $pdf->Ln(12);
           }  // Magnesio y Metales Alcalinos
           if($Plantilla == '94'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Control'),1,0,'L'); 
            $pdf->Ln(12);
            $pdf->Cell(180,12,utf8_decode('P. Muestra'),1,0,'L'); 
            $pdf->Ln(12);
            $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
            $pdf->Ln(12);
           }  // Sulfatos
           if($Plantilla == '95'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode('Sol. Mtra '),1,0,'L'); 
            $pdf->Cell(180,12,utf8_decode('Adbsorbancia'),1,0,'L'); 
            $pdf->Cell(180,12,utf8_decode('Longitud de Onda'),1,0,'L'); 
            $pdf->Cell(180,12,utf8_decode('Equipo UV'),1,0,'L'); 
            $pdf->Ln(4);
           }  // Nitritos (UV)
           if($Plantilla == '26'){
            $pdf->SetFont('Arial','B',9);
            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
            $pdf->SetFont('Arial','',9);
            $pdf->Ln(4);
            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
            $pdf->Ln(0);
            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
            $pdf->Ln(0);
            $pdf->Cell(120,4,utf8_decode('Titulante'),1,0,'L');
            $pdf->Cell(60,4,utf8_decode('Factor Fti'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(120,4,utf8_decode('Lote'),1,0,'L');
            $pdf->Cell(60,4,utf8_decode('Equivalente H2SO4 0,1N 8.401'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('Muestra 1 (Pm1)'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('Volumen Muestra 1 (Vc1)'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(45,4,utf8_decode('Muestra 2 (Pm2)'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L');
            $pdf->Cell(45,4,utf8_decode('Volumen Muestra 2 (Vc2)'),1,0,'L');
            $pdf->Cell(45,4,utf8_decode(''),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(40,4,utf8_decode('Blanco (Vb)'),1,0,'L');
            $pdf->Cell(140,4,utf8_decode(''),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Ecuación para el Caculo'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('% en base Humeda = 100*((Vc-Vb)*eq*Fti)/Pm'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('Balanza'),1,0,'L');
            $pdf->Ln(4);
            $pdf->Cell(180,4,utf8_decode('HPLC'),1,0,'L');
              $pdf->Ln(4);
           }   // Contenidos Varios
           // 
           // 
           //}//  MATERIA PRIMA
            
                 
//            if($TipoMuestra == '1'){// PRODUCTO TERMINADO
//          // Plantillas según analisis de PT
//          if($Plantilla == '2'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion . '            CUMPLE? :  SI[    ]   NO[    ]'),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);                      
//           }  // Identificación por HPLC
//           if($Plantilla == '3'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(180,4,utf8_decode('Estándar'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Muestra'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Longitud de Onda'),1,0,'C');
//            $pdf->Ln(4);
//             $pdf->Cell(180,4,utf8_decode('Equipo UV'),1,0,'C');
//            $pdf->Ln(4);
//           }   // Identificación por UV
//           if($Plantilla == '4'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(20,4,utf8_decode('P Vacío (Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P + muestra (Pm)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Peso+Agua (PH2O)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Cálculo =(Pm-Pv)/ (PH2O-Pv)'),1,0,'L');
//            $pdf->Cell(40,4,utf8_decode('Resultado'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }   // Peso Pesos Varios
//           if($Plantilla == '5'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(180,4,utf8_decode('P. Inicial'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('P. Muestra'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('P. Muestra'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('P. Final'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('W1 (P. final - P. Inicial) (Wm1)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('W2 (P. Muestra)  (Wm2)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('W3 (P. filtrado - P. inicial)  (Wm3)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Dilución (mL) (Dil)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Resultado'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Cálculo=((100*Wm1)*(Dil+Wm2))/((Wm2*Wm3)*(1-(0,01*H)))'),1,0,'L');
//            $pdf->Ln(4);
//           }   // Contenidos Varios
//           if($Plantilla == '6'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(180,4,utf8_decode('Muestra'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Resultado'),1,0,'L');
//            $pdf->Ln(4);
//           }   // Disolución Totalidad de la Dosilución
//           if($Plantilla == '7'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(50,4,utf8_decode('p. muestra'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('Resultado'),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Equipo'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }   // pH
//           if($Plantilla == '8'){
//            $pdf->Cell(180,4,utf8_decode('Datos del (los) Estándar (es)'),1,0,'C',True);// True permite que asigne el color
//            $pdf->Ln(4);
//            $pdf->Cell(30,4,utf8_decode('Código'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('Nombre'),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode('Lote'),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode('Potencia (P)'),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode('FV'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);   
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4); 
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(90,4,utf8_decode('Estándar:'),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode('Muestra:'),1,0,'C');
//            $pdf->Ln(4); 
//            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
//            $pdf->Ln(4); 
//            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('St2: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M2: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'),1,0,'L');
//            $pdf->Ln(4);            
//            $pdf->Cell(180,4,utf8_decode('% de Activo en B. S. = (% de Activo en B. H. Promedio)*100/(100-H)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Fase Móvil'),1,0,'L');
//            $pdf->Ln(12);
//            $pdf->Cell(90,4,utf8_decode('Balanza'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
//            $pdf->Ln(4);
//            
//           }   // Valoración por HPLC
//           if($Plantilla == '9'){
//            $pdf->Cell(180,4,utf8_decode('Datos del (los) Estándar (es)'),1,0,'C',True);// True permite que asigne el color
//            $pdf->Ln(4);
//            $pdf->Cell(30,4,utf8_decode('Código'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('Nombre'),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode('Lote'),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode('Potencia (P)'),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode('FV'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);   
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4); 
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(90,4,utf8_decode('Estándar:'),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode('Muestra:'),1,0,'C');
//            $pdf->Ln(4); 
//            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode('Peso/Dilución:'),1,0,'C');
//            $pdf->Ln(4); 
//            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode(' % de Activo = (Rm*Ps*P*D)/(Rs*Pm)'),1,0,'L');
//            $pdf->Ln(4);            
//            $pdf->Cell(180,4,utf8_decode('% de Activo en B. S. = (% de Activo en B. H. Promedio)*100/(100-H)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,8,utf8_decode('Fase Móvil'),1,0,'L');
//            $pdf->Ln(8);
//            $pdf->Cell(90,4,utf8_decode('Balanza'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('HPLC '),1,1,'L'); // el segundo parametro 1 genera un salto de linea
//            $pdf->Ln(4);
//            
//           }   // Valoración por GASES  SIN EVALUAR
//           if($Plantilla == '10'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(90,4,utf8_decode('Titulante'),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('Factor'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('Lote'),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('Equivalente  HClO4   0,1N      7,507'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(35,4,utf8_decode('Muestra(Pm1)'),1,0,'L');
//            $pdf->Cell(55,4,utf8_decode('Volumen Muestra(Vc1)'),1,0,'L');
//            $pdf->Cell(35,4,utf8_decode('Muestra(Pm2)'),1,0,'L');
//            $pdf->Cell(55,4,utf8_decode('Volumen Muestra(Vc2)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Blanco: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('% en Base Húmeda= 100*((Vb-Vc)*Eq*Fti)/Pm'),1,0,'L');
//            $pdf->Ln(4);            
//            $pdf->Cell(180,4,utf8_decode('% en Base Seca= (% Promedio en B. H.)*100/(100-H)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('Balanza'),1,0,'L');
//            $pdf->Ln(4);
//           }  // Valoración por UV
//           if($Plantilla == '13'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(20,4,utf8_decode('P Vacío (Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P muestra Ini. (Pmi)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P muestra Fin. (Pmf)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Cálculo=100*(Pmi-Pmf)/(Pmi-Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'L');
//            $pdf->Cell(20,4,utf8_decode('Equipo'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Pérdida por secado
//           if($Plantilla == '14'){   
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(40,4,utf8_decode('Peso'),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode('Dilución'),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode('Solvente'),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode('Clasificación (P)'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);   
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4); 
//           }  // Solubilidad
//           if($Plantilla == '15'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(50,4,utf8_decode('Peso'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('Resultado'),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Equipo KF'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Agua KF Determinación de Agua Método I
//           if($Plantilla == '16'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(90,4,utf8_decode('Punto de Fusión'),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode('Equipo'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Punto de Fusión
//           if($Plantilla == '17'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(20,4,utf8_decode('P Vacío (Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P muestra Ini. (Pmi)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P muestra Fin. (Pmf)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'L');
//            $pdf->Cell(20,4,utf8_decode('Equipo'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Residuo de Incineración Residuos de ignición
//           if($Plantilla == '18'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(90,4,utf8_decode('Estándar'),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode('Muestra'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(90,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Uniformidad de contenido Uniformidad
//           if($Plantilla == '19'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(60,4,utf8_decode('Estándar'),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode('Muestra'),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode('Placebo'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(60,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Fase Móvil'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('% de Impureza: (Ri/Rs)*(Ps*D/Pm)*P*(1/Fimp)'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('% de Activo en B. S. = (% de Activo Promedio en B. H.)*100/(100-H))'),1,0,'L');
//            $pdf->Ln(4);
//           }  // Impurezas orgánicas - Compuestos Relacionados
//           if($Plantilla == '20'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(40,4,utf8_decode('Muestra (Pm)'),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode('P. Inicial (Pi)'),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode('P. Final (Pf)'),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode('Resultado'),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode('Cálculo'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Sustancias Insolubles - Sustancias Hidrosolubles
//           if($Plantilla == '21'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(50,4,utf8_decode('Control'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('P. muestra'),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Resultado'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Límites varios
//           if($Plantilla == '27'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(50,4,utf8_decode('Lectura'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('Angulo (°)'),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('P. Muestra g (Pm)'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode('1.'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Dilución D: '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode('2.'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Longitud (dm): '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode('3.'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Resultado: '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode('4.'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Cálculo=(100*Angulo)/(dm*Conc): '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode('5.'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Concentración=(Pm*((100-%H)/100)/ D)*100'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode('Promedio:'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Equipo: '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Rotación Espécifica  Gravedad Específica 
//           if($Plantilla == '28'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(100,4,utf8_decode(''),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Equipo'),1,0,'C');
//            $pdf->Ln(4);
//           }  // Punto de Fusión -  Temperatura de Fusión
//           if($Plantilla == '29'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(20,4,utf8_decode('P Vacío (Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P muestra Ini (Pmi)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P Muestra Fin (Pmf)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Resultado'),1,0,'L');
//            $pdf->Cell(10,4,utf8_decode('Equipo'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(10,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Peso Pesos Varios
//           if($Plantilla == '30'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(100,4,utf8_decode('Resultado: '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Apariencia de la solución
//           if($Plantilla == '31'){
//            $pdf->Cell(180,4,utf8_decode('Disolución: _____________Etapa Acida____________'),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4); 
//            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('St2: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M2: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Condiciones: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('Medio de Disolución: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Gastrorresistencia: % de Activo = 100*(Rmd*Psd*P*Dd)/(Rs*Cd*100)'),1,0,'L');
//            $pdf->Ln(4);            
//                        $pdf->Cell(180,4,utf8_decode('Disolución: _____________Etapa Amortiguada___________'),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4); 
//            $pdf->Cell(90,4,utf8_decode('St1: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M1: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('St2: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('M2: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('       %DER CUMPLE'),1,0,'L');
//            $pdf->Cell(45,4,utf8_decode('SI [  ]     NO [  ]'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Condiciones: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('Medio de Disolución: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Ecuación para el cálculo'),1,0,'L', True);
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode(' % de Activo = (Rmd*Psd*P*Dd)/(Rsd*Cd*100)'),1,0,'L');
//            $pdf->Ln(4); 
//            }  // Gastrorresistencia Disolución VARIAS HORAS
//           if($Plantilla == '33'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(36,4,utf8_decode('1.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('2.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('3.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('4.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('5.'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(36,4,utf8_decode('6.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('7.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('8.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('9.'),1,0,'L');
//            $pdf->Cell(36,4,utf8_decode('10.'),1,0,'L');
//            $pdf->Ln(4);
//           $pdf->Cell(180,4,utf8_decode('Resultado:'),1,0,'L');
//            $pdf->Ln(4);
//           }  // Peso neto uniformidad de dosis
//           if($Plantilla == '34'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(180,4,utf8_decode('Fase Móvil: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Muestra: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Estándar: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Resolución: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(100,12,utf8_decode('Resultado: '),1,0,'C');
//            $pdf->Cell(80,12,utf8_decode('CUMPLE   SI[   ]    NO[   ] '),1,0,'C');
//            $pdf->Ln(12);
//            $pdf->Cell(90,4,utf8_decode('BALANZA: '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('HPLC: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(90,4,utf8_decode('  '),1,0,'L');
//            $pdf->Cell(90,4,utf8_decode('  '),1,0,'L');
//            $pdf->Ln(4);
//           }  // Pureza Cromatográfica
//           if($Plantilla == '36'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(4);
//           }  // Jerinabilidad  o un solo campo Alcalinidad
//           if($Plantilla == '38'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad HCI (N)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Cálculo=((Vb-Vm)*56,11*N*F)/Pm'),1,0,'L'); 
//            $pdf->Ln(4);
//              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Indice de Saponificación
//           if($Plantilla == '44'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(50,4,utf8_decode('P. Inicial (Pi)'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('P. muestra (Pm)'),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Volumen (V)'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Resultado: '),1,0,'L');
//            $pdf->Cell(180,4,utf8_decode('Cálculo=(Pm-Pi)/ V'),1,0,'L');
//            $pdf->Ln(4);
//           }   // Densidad 
//           if($Plantilla == '52'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,4,utf8_decode('Blanco'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(180,4,utf8_decode('Muestra'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(60,4,utf8_decode('Máximo 0,4 a 240 nm'),1,0,'L');
//            $pdf->Cell(60,4,utf8_decode('Máximo 0,3 a 250 nm - 260 nm'),1,0,'L');
//            $pdf->Cell(60,4,utf8_decode('Máximo 0,1 a 270 nm - 340 nm'),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(60,4,utf8_decode(''),1,0,'L');
//            $pdf->Cell(60,4,utf8_decode(''),1,0,'L');
//            $pdf->Cell(60,4,utf8_decode(''),1,0,'L');
//            $pdf->Ln(4);
//           }   // Absorción en el UV
//           if($Plantilla == '67'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(45,4,utf8_decode('Muestra'),1,0,'C'); 
//            $pdf->Cell(45,4,utf8_decode('W lleno'),1,0,'C');
//            $pdf->Cell(45,4,utf8_decode('W vacío'),1,0,'C');
//            $pdf->Cell(45,4,utf8_decode('W producto'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('1'),1,0,'C'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('2'),1,0,'C'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('3'),1,0,'C'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(45,4,utf8_decode('4'),1,0,'C'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Cell(45,4,utf8_decode(''),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Peso de Llenado
//           if($Plantilla == '69'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(20,4,utf8_decode('Muestra (Pm): '),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P. Vacío (Pv)): '),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('P. Final  (Pf): '),1,0,'L');
//            $pdf->Cell(30,4,utf8_decode('Resultado: '),1,0,'L');
//            $pdf->Cell(40,4,utf8_decode('Cálculo=100*(Pf-Pv)/Pm: '),1,0,'L');
//            $pdf->Ln(4);
//            $pdf->Cell(20,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(30,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(40,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Ácidos grasos libres
//           if($Plantilla == '70'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad Na2S2O3 (N)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Cálculo=((Vb-Vm)*126,9*N*F)/(Pm*10)'),1,0,'L'); 
//            $pdf->Ln(4);
//              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Indice de Yodo
//           if($Plantilla == '71'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad NaOH (N)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Cálculo=(Vm*56,11*N)/Pm'),1,0,'L'); 
//            $pdf->Ln(4);
//              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Indice de Acidez
//           if($Plantilla == '72'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Muestra'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Estándar'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Fase Móvil'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Ecuación'),1,0,'C'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('% Limite p-Aminofenol libre =(Ps*P*D*Rm)/(Rs*Pm)'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // p-aminofenol libre
//           if($Plantilla == '75'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad Na2S2O3 (N)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Cálculo=10((Vm-Vb)*1000*N*F)/Pm'),1,0,'L'); 
//            $pdf->Ln(4);
//              $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Indice de Peróxido
//           if($Plantilla == '76'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('P Vacío (Pv)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('P muestra Ini. (Pmi)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('P muestra Fin. (Pmf)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Residuo de Evaporación
//           if($Plantilla == '78'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Lote/Normalidad HCI (N)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Factor Titulante (F)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Blanco (Vb)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Volumen Muestra (Vm)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Peso muestra (Pm)'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Cálculo Índice de Saponificación (S) =((Vb-Vm)*56,11*N*F)/Pm'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Cálculo Grado de Hidrólisis= 100-((7,84S/(100-0,075S))'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Grado de hidrólisis
//           if($Plantilla == '79'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(45,12,utf8_decode('Muestra/Dilución'),1,0,'C'); 
//            $pdf->Cell(45,12,utf8_decode('Titulante'),1,0,'C'); 
//            $pdf->Cell(45,12,utf8_decode('Lote'),1,0,'C'); 
//            $pdf->Cell(45,12,utf8_decode('Factor'),1,0,'C'); 
//            $pdf->Ln(4);
//            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
//            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
//            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
//            $pdf->Cell(45,12,utf8_decode(' '),1,0,'C'); 
//            $pdf->Ln(4);
//            $pdf->Cell(45,12,utf8_decode('Resultado: '),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Límite de dioxido de azufre
//           if($Plantilla == '80'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('P Vacío (Pv)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('P muestra Ini. (Pmi)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('P muestra Fin. (Pmf)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Cálculo %=100*(Pmf-Pv)/(Pmi-Pv)'),1,0,'L'); 
//            $pdf->Ln(4);
//            $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//             $pdf->Cell(180,12,utf8_decode('Equipo: '),1,0,'L'); 
//            $pdf->Ln(4);
//          
//           }  // Residuos de ignición
//           if($Plantilla == '90'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode(''),1,0,'C'); 
//            $pdf->Ln(0);
//            $pdf->Cell(50,4,utf8_decode('Cond. H2O'),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode('Cond. Muestra'),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode('Equipo'),1,0,'C');
//            $pdf->Ln(4);
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(50,4,utf8_decode(' '),1,0,'C');
//            $pdf->Cell(80,4,utf8_decode(' '),1,0,'C');
//            $pdf->Ln(4);
//           }  // Conductividad
//           if($Plantilla == '93'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Titulante'),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('P. Muestra'),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('Vol. Mtra.'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Magnesio y Metales Alcalinos
//           if($Plantilla == '94'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Control'),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('P. Muestra'),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('Resultado'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Sulfatos
//           if($Plantilla == '95'){
//            $pdf->SetFont('Arial','B',9);
//            $pdf->Cell(180,4,utf8_decode($Ensayo),1,0,'C',True);// True permite que asigne el color
//            $pdf->SetFont('Arial','',9);
//            $pdf->Ln(4);
//            $pdf->MultiCell(180,4,utf8_decode($Especificacion),1,L,FALSE);
//            $pdf->Ln(0);
//            $pdf->Cell(180,12,utf8_decode('Sol. Mtra '),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('Adbsorbancia'),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('Longitud de Onda'),1,0,'L'); 
//            $pdf->Cell(180,12,utf8_decode('Equipo UV'),1,0,'L'); 
//            $pdf->Ln(4);
//           }  // Nitritos (UV)
//                
//            }// PRODUCTO TERMINADO

            }//Fin Foreach
            /////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(180,5,utf8_decode('Observaciones: ____________________________________________________________________________________________________________________'),0,0,'C');
            $pdf->Ln(5);
            $pdf->Cell(180,5,utf8_decode('___________________________________________________________________________________________________________________________________'),0,0,'C');
             $pdf->Ln(5);
            $pdf->Cell(180,5,utf8_decode('___________________________________________________________________________________________________________________________________'),0,0,'C');
             $pdf->Ln(5);
             $pdf->Cell(180,5,utf8_decode('___________________________________________________________________________________________________________________________________'),0,0,'C');
             

     $pdf->Ln(8);   
     $pdf->Cell(180,12,utf8_decode('Resultado Fuera de Especificaciones'),1,0,'L');      
     $pdf->Ln(12);  
     $pdf->Cell(180,12,utf8_decode('Verificación'),1,0,'L');      
     $pdf->Ln(13);  
       //$pdf->Ln(5);  
       //$pdf->Cell(180,170,utf8_decode(''),1,0,'C'); 
       //$pdf->Ln(180);
       $pdf->Cell(180,6,utf8_decode('Concepto:'),1,0,'L'); 
       $pdf->Ln(6);
       $pdf->Cell(90,6,utf8_decode('[   ]  Cumple las especificaciones'),1,0,'L');
       $pdf->Cell(90,6,utf8_decode('[   ]  No cumple las especificaciones'),1,0,'L'); 
            $pdf->Ln(8);
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,6,utf8_decode('Analizado Por:'),1,0,'L');
            $pdf->Cell(50,6,utf8_decode('Transcrito Por:'),1,0,'L');
            $pdf->Cell(50,6,utf8_decode('Verificado Por:'),1,0,'L');
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Ln(6);
           $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,6,utf8_decode('Nombre:'),1,0,'L');
            $pdf->Cell(50,6,utf8_decode('Nombre:'),1,0,'L');
             $pdf->Cell(50,6,utf8_decode('Nombre:'),1,0,'L');
           $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,6,utf8_decode('Firma:'),1,0,'L');
            $pdf->Cell(50,6,utf8_decode('Firma:'),1,0,'L');
             $pdf->Cell(50,6,utf8_decode('Firma:'),1,0,'L');
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Ln(6);
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
            $pdf->Cell(50,6,utf8_decode('Fecha:'),1,0,'L');
            $pdf->Cell(50,6,utf8_decode('Fecha:'),1,0,'L');
            $pdf->Cell(50,6,utf8_decode('Fecha:'),1,0,'L');
            $pdf->Cell(15,6,utf8_decode(''),0,0,'L');
       $pdf->Output();
?>
