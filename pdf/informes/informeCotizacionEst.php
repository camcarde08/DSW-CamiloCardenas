<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
include('../moneda.php');
$conex_moneda = new moneda();
$dato = $_GET['idCotizacion'];
$modelReporte = new TablaReportesDbModelClass();
    $data = $modelReporte->getInfoCotizacionEst($dato);
            foreach ($data as $informe) {
               $informes[] = array(
                   $id = $informe['id'],
                   $Estado = $informe['id_estado_cotizacion'],
                   $Fsolicitud = $informe['fecha_solicitud'],
                   $Fcompromiso = $informe['fcompromiso'],
                   $IdCliente = $informe['id_cliente'],
                   $Contacto = $informe['contacto'],
                   $Telefono = $informe['tel_contacto'],
                   $Observaciones = $informe['observaciones'],
                   $Observaciones2 = $informe['onservaciones2'],
                   $Observaciones3 = $informe['observaciones3'],
                   $AplicaIva = $informe['aplica_iva'],
                   $AplicaRete = $informe['aplica_retencion'],
                   $Cliente = $informe['nombre_cliente'],
                   $Producto = $informe['producto'],
                   $NombreEstabilidad = $informe['estabilidadNom'] 
              );
           }

class PDF extends FPDF {
 function Header()
{
    //Logo
      $this->Image('../../views/images/logoEmpresa.png',150,10,40);
    //Arial bold 15
    $this->SetFont('Arial','B',15);
    //Move to the right
    //$this->Cell(1);
    //Title
    $this->Cell(120,10,utf8_decode('COTIZACIÓN SERVICIOS'),0,0,'C');
    $this->SetFont('Arial','B',8);
     $this->Ln(5);
    $this->Cell(120,10,utf8_decode(' Tesla Chemical SAS'),0,0,'C');
     $this->Ln(3);
    $this->Cell(120,10,utf8_decode(' Laboratorio de Análisis'),0,0,'C'); 
    $this->Ln(3);
    $this->Cell(120,10,utf8_decode(' Cra 55 No. 71-45'),0,0,'C');
    $this->Ln(3);
    $this->Cell(120,10,utf8_decode(' www.teslachemical.co'),0,0,'C');
    $this->Ln(20);
    //Logo en marca 
    $this->RotatedImage('../../views/images/marcaAgua.jpg',45,100);
}
function RotatedText($x, $y, $txt, $angle)
{
    //Text rotated around its origin
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
}
function RotatedImage($file,$x,$y,$w,$h)
//function RotatedImage($file,$x,$y,$w,$h,$angle)
{
    //Image rotated around its upper-left corner
    //$this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    //$this->Rotate(0);
}
function Footer()
{
$this->SetY(-15);
  $this->SetFont('Arial','B',8);
  $this->SetTextColor(25,25,112);
  $this->Cell(180,2,utf8_decode('_____________________________________________________________________________________________________________________'),0,0,'C');
  $this->Ln(4);
  $this->Cell(180,2,utf8_decode('Cra. 55 N.71-45 - PBX: (571)5470586 - www.teslachemical.com.co - Cel. 3102606429 - Código Postal 111221 - Bogotá D.C. Colombia'),0,0,'C');
//  $this->Cell(90,2,utf8_decode('________________________________________'),0,0,'C');
//  $this->Ln();
}
    
}

$pdf = new PDF();
$pdf->SetFont('Arial','',14);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);
$pdf->SetXY(105, 38);
$pdf->RoundedRect( 105, 36, 32, 7, 2,  'S', '1234');
$pdf->RoundedRect( 145, 36, 45, 7, 2,  'S', '1234');
$pdf->RoundedRect( 10, 40, 90, 17, 2,  'S', '1234');
$pdf->SetFont('Arial','',9);

 $pdf->Cell(45,4, "FECHA: ". substr($Fsolicitud, 0,10),0,0,'L');
$pdf->SetTextColor(255,0,0); //rojo
 $pdf->Cell(45,4,utf8_decode('COTIZACIÓN No.'.' CTZ-0'.$id),0,0,'L');
  $pdf->SetXY(10, 18);
 $pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0); //negro
 $pdf->Cell(80,50,utf8_decode('Señores : '.($Cliente)),0,0,'L');
 $pdf->SetXY(10, 22);
 $pdf->Cell(55,50,utf8_decode('Contacto : '.($Contacto)),0,0,'L');
 $pdf->SetXY(10, 27);
 $pdf->Cell(30,50,'Ciudad.',0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetXY(10, 35);
$pdf->Cell(45,50,utf8_decode('Estimado(a) :'),0,0,'L');
 $pdf->SetXY(10, 64);
 $ob = utf8_decode($Observaciones);
 $observ1 = str_replace("<div>", "\r\n", $ob);
 $observ2 = str_replace("</div>", "\r\n", $observ1);
 $observ = str_replace("<br>", "\r\n", $observ2);
 $pdf->MultiCell(180,4,$observ);
$pdf->Ln(7);
$pdf->MultiCell(180,4,'Estabilidad: '.$NombreEstabilidad . '  para el producto: '  . utf8_decode($Producto));
$pdf->Ln(5);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,-5,'ENSAYO',1,0,'C');
$pdf->Cell(20,-5,utf8_decode('MÉTODO'),1,0,'C');
$pdf->Cell(20,-5,utf8_decode('VALOR UN.'),1,0,'C');
$pdf->Cell(75,-5,utf8_decode('TIEMPOS'),1,0,'C');
$pdf->Cell(25,-5,utf8_decode('VALOR TOTAL'),1,0,'C');
//$pdf->Cell(30,-5,utf8_decode('PRECIO'),1,0,'C');
$pdf->SetFont('Arial','',7);
/////////////////////////////////////////
/////////INCIO LISTADO DE SERVICIOS////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerEnsayosCotizacionEst($dato);
  foreach ($data1 as $informe1) {
      $Producto = $informe1["nombre_producto"];      
      $Ensayo = $informe1["nom_ensayo"];
      $Metodo = $informe1["metodoNom"];
      $ValorUnit = $informe1["valorUnit"];
      $TiemposQ = $informe1['tiempos'];
      $ValorTo = $informe1['valorTo'];
$pdf->SetX(10);
$pdf->SetWidths(array(40,20,20,75,25));
//$Resultado = ereg_replace("<br>","\r\n",$Resultado1);
$pdf->Row2(array(utf8_decode($Ensayo),utf8_decode($Metodo),utf8_decode($conex_moneda->amoneda($ValorUnit,pesos)),utf8_decode($TiemposQ),utf8_decode($conex_moneda->amoneda($ValorTo,pesos))));
//$pdf->Row2(array(utf8_decode($Producto),utf8_decode($Ensayo),utf8_decode($Metodo),utf8_decode($conex_moneda->amoneda($Valor,pesos))));
}
 /////////////////////////////////////////
/////////FIN LISTADO DE SERVICIOS////////////
///////////////////////////////////////////////

$pdf->Ln(4);
 $pdf->SetFont('Arial','',9);
$data2 = $modelReporte->valor_cotizadoEst($dato);
  foreach ($data2 as $informe2) {
  $total_sinIva = $informe2["suma_valor"];
 }

$iva = (($total_sinIva) * 0.16);
if($AplicaIva == '0'){$iva = 0;}
if($AplicaRete == '0'){$retencion = 0;} else {$retencion = $total_sinIva * 0.11;} 
$ivaf =  $conex_moneda->amoneda($iva,pesos);
$gran_total = ($total_sinIva + $iva - $retencion);
$gran_total_p =  $conex_moneda->amoneda($gran_total,pesos);


$pdf->Cell(160,5,'SUBTOTAL : ' ,0,0,'R');
$pdf->Cell(20,5,$conex_moneda->amoneda($total_sinIva,pesos) ,0,0,'R');
$pdf->Ln();
$pdf->Cell(160,5,'IVA : ' ,0,0,'R');
$pdf->Cell(20,5,$ivaf ,0,0,'R');
$pdf->Ln();
$pdf->Cell(160,5,utf8_decode('RETENCIÓN : ') ,0,0,'R');
$pdf->Cell(20,5,$conex_moneda->amoneda($retencion,pesos) ,0,0,'R');
$pdf->Ln();
$pdf->Cell(160,5,'TOTAL : ' ,0,0,'R');
$pdf->Cell(20,5,$gran_total_p ,0,0,'R');

$pdf->Ln(7);
$Observaciones2 = ereg_replace("<br>","\r\n",$Observaciones2);
$Observaciones3 = ereg_replace("<br>","\r\n",$Observaciones3);
//$pdf_html = new PDF_HTML();
//$pdf_html->WriteHTML($ObservacionesFin);
$pdf->MultiCell(180,4,utf8_decode($Observaciones2));
$pdf->Ln(5);
$pdf->MultiCell(180,4,utf8_decode($Observaciones3));
  $pdf->Ln(13);
 $pdf->Cell(10,10,utf8_decode('Cordialmente,'),0,0,'L');
  $pdf->Ln(13);
 $pdf->Cell(180,5,utf8_decode('Q.F. UdeA. JOSE DAVID LAZARUS'),0,0,'C');
   $pdf->Ln(4);
 $pdf->Cell(180,5,utf8_decode('DIRECTOR TECNICO'),0,0,'C');
   $pdf->Ln(4);
 $pdf->Cell(180,5,utf8_decode('Firma autorizada (Director Técnico y/o Gerente Técnico):'),0,0,'C');
   
$pdf->Output();
?>