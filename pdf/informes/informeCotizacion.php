<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
include('../moneda.php');
$conex_moneda = new moneda();
$dato = $_GET['idCotizacion'];
$modelReporte = new TablaReportesDbModelClass();
    $data = $modelReporte->getInfoCotizacion($dato);
            foreach ($data as $informe) {
               $informes[] = array(
                   $id = $informe['id'],
                   $Estado = $informe['id_estado_cotizacion'],
                   $Fsolicitud = $informe['fecha_solicitud'],
                   $Fcompromiso = $informe['fcompromiso'],
                   $IdCliente = $informe['id_cliente'],
                   $Contacto = $informe['nombre_contacto'],
                   $Telefono = $informe['telefono_contacto'],
                   $Observaciones = $informe['observaciones'],
                   $ObservacionesFin = $informe['observacionesFin'],
                   $AplicaIva = $informe['aplica_iva'],
                   $AplicaRete = $informe['aplica_retencion'],
                   $Cliente = $informe['nombre_cliente'],
                   $Ciudad = $informe['Ciudad']
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
    $this->Ln(11);
}
function Footer()
{
  $this->SetY(-25);
  $this->Cell(60,5,'REV:00',0,0,'L');
   $this->Cell(60,5,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');
   $this->Cell(60,5,'PL-P-002-R-01',0,0,'R');
   $this->Ln();
}
    
}

$pdf = new PDF();
$pdf->SetFont('Arial','',14);
$pdf->AddPage();
$pdf->AliasNbPages();
$pdf->SetFont('Arial','',9);
$pdf->SetXY(105, 38);
 $pdf->Cell(45,4, "FECHA: ". substr($Fsolicitud, 0,10),0,0,'L');
 $pdf->Cell(45,4,utf8_decode('COTIZACIÓN No.'.' CTZ-'.$id),0,0,'L');
  $pdf->SetXY(10, 18);
 $pdf->SetFont('Arial','',9);
 $pdf->Cell(80,50,utf8_decode('Señores : '.($Cliente)),0,0,'L');
 $pdf->SetXY(10, 22);
 $pdf->Cell(55,50,utf8_decode('Contacto : '.($Contacto)),0,0,'L');
 $pdf->SetXY(10, 27);
 $pdf->Cell(30,50,'Ciudad: '.utf8_decode($Ciudad) ,0,0,'L');
$pdf->SetFont('Arial','',9);
$pdf->SetXY(10, 35);
$pdf->Cell(45,50,utf8_decode('Estimado(a) :'),0,0,'L');
 $pdf->SetXY(10, 64);
 $ob = utf8_decode($Observaciones);
 $observ1 = str_replace("<div>", "\r\n", $ob);
 $observ2 = str_replace("</div>", "\r\n", $observ1);
 $observ = str_replace("<br>", "\r\n", $observ2);
 $pdf->MultiCell(180,4,$observ);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(60,-5,'PRODUCTO',1,0,'C');
$pdf->Cell(60,-5,utf8_decode('ENSAYO'),1,0,'C');
$pdf->Cell(30,-5,utf8_decode('MÉTODO'),1,0,'C');
$pdf->Cell(30,-5,utf8_decode('PRECIO'),1,0,'C');
$pdf->SetFont('Arial','',7);
/////////////////////////////////////////
/////////INCIO LISTADO DE SERVICIOS////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerEnsayosCotizacion($dato);
  foreach ($data1 as $informe1) {
      $Producto = $informe1["nombre_producto"];      
      $Ensayo = $informe1["nombre_ensayo"];
      $Metodo = $informe1["metodo"];
      $Valor = $informe1["valor"];
$pdf->SetX(10);
$pdf->SetWidths(array(60,60,30,30));
$Resultado = ereg_replace("<br>","\r\n",$Resultado1);
$pdf->Row2(array(utf8_decode($Producto),utf8_decode($Ensayo),utf8_decode($Metodo),utf8_decode($conex_moneda->amoneda($Valor,pesos))));
}
 /////////////////////////////////////////
/////////FIN LISTADO DE SERVICIOS////////////
///////////////////////////////////////////////

$pdf->Ln(4);
 $pdf->SetFont('Arial','',9);
$data2 = $modelReporte->valor_cotizado($dato);
  foreach ($data2 as $informe2) {
  $total_sinIva = $informe2["suma_valor"];
 }

$iva = (($total_sinIva) * 0.16);
if($AplicaIva == '0'){$iva = 0;}
if($AplicaRete == '0'){$retencion = 0;} else {$retencion = $total_sinIva * 0.11;} 
$ivaf =  $conex_moneda->amoneda($iva,pesos);
$gran_total = ($total_sinIva + $iva) - ($retencion);
$gran_total_p =  $conex_moneda->amoneda($gran_total,pesos);


$pdf->Cell(160,5,'SUBTOTAL : ' ,0,0,'R');
$pdf->Cell(20,5,$conex_moneda->amoneda($total_sinIva,pesos) ,0,0,'R');
$pdf->Ln();
$pdf->Cell(160,5,'IVA : ' ,0,0,'R');
$pdf->Cell(20,5,$ivaf ,0,0,'R');
$pdf->Ln();
$pdf->Cell(160,5,'RETENCION : ' ,0,0,'R');
$pdf->Cell(20,5,$conex_moneda->amoneda($retencion,pesos) ,0,0,'R');
$pdf->Ln();
$pdf->Cell(160,5,'TOTAL : ' ,0,0,'R');
$pdf->Cell(20,5,$gran_total_p ,0,0,'R');

$pdf->Ln(7);





$ObservacionesF = ereg_replace("<br>","\r\n",$ObservacionesFin);
$ObservacionesFi = ereg_replace("<div>","\r\n",$ObservacionesF);
$ObservacionesFin = ereg_replace("</div>","\r\n",$ObservacionesFi);
$ObservacionesFina = ereg_replace("</span>","",$ObservacionesFin);
$ObservacionesFinal1 = ereg_replace('<span style="text-decoration: underline;">',"",$ObservacionesFina);
$ObservacionesFinal = ereg_replace('<span style="font-style: italic;">',"",$ObservacionesFinal1);
//$pdf_html = new PDF_HTML();
//$pdf_html->WriteHTML($ObservacionesFin);
$pdf->MultiCell(180,4,utf8_decode($ObservacionesFinal));
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
