<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
$dato = $_POST['idMuestra'];
$TiempoTemp = $_POST['TiempoTemp'];
$TiempoEst = $_POST['TiempoEstPost'];
$TipoEst = $_POST['TipoEstPost'];


$modelReporte = new TablaReportesDbModelClass();
    $data = $modelReporte->getInfoPrincipalEstabilidad($dato);
            foreach ($data as $informe) {
               $informes[] = array(
                   $id = $informe['id'],
                   $FechaLlegada = $informe['fecha_llegada'],
                   $Contacto = $informe['nombre_contacto'],
                   $AreaContacto = $informe['area_contacto'],
                   $Fabricante = $informe['fabricante'],
                   $Procedencia = $informe['procedencia'],
                   $NumeroInforme = $informe['num_informe'],
                   $Producto = $informe['nombre_producto'],
                   $Cliente = $informe['nombre_tercero'],
                   $Direccion = $informe['direccion_tercero'],
                   $Forma = $informe['FormaFarmaceutica'],
                   $tipoProducto = $informe['tipo_producto'],
                   $des_area_analisis = $informe['nombre_producto'],
                   $FechaFabri = substr($informe['fecha_fabricacion'],0,10),
                   $FechaVence = substr($informe['fecha_vencimiento'],0,10),
                   $finalizacionAnalisis = substr($informe['finalizacionAnalisis'],0,10),
                   $Empaque = $informe['Empaque'],
                   $Envase = $informe['Envase'],
                   $PrincipioActivo = $informe['PrincipioActivo'],
                   $CantidadLote = $informe['cantidadLote'],
                   $Lote = $informe['lote'],
                   $AreaAnalisis = $informe['des_area_analisis'],
                   $Conclusion = $informe["conclusion"],
                   $Estado = $informe["estado"],
                   $nombreAnalista = $informe["nombreAnalista"],
                   $perfilAnalista = $informe["PerfilAnalista"],
                   $idPerfil = $perlf,
                   $anofab = substr($FechaFabri,0,4),
                   $anoven = substr($FechaVence,0,4)
                      
                   
               );
           }
            if($anofab == '2000'){$FechaFabri = 'No Especifica';}
            if($anoven == '2000'){$FechaVence = 'No Especifica';}

if($Direccion == ''){$Direccion = 'N.A.';} 

    $condicionesEst = $modelReporte->VerCondicionesEstab($id);
            foreach ($condicionesEst as $condEst) { $cEst[] = array(
                 $condicionesE = substr($condEst['condiciones'], -1)
               );
           }
           
           if($condicionesE == '0')
               {$condicionesE = '30°C-65%HR' ;} 
               
           elseif($condicionesE == '1')
               {$condicionesE = '30°C-75%HR' ;}
               
            elseif($condicionesE == '2')
               {$condicionesE = '40°C-75%HR' ;}
               
           elseif($condicionesE == '3')
               {$condicionesE = '50°°C-80%HR' ;}
    
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
    $this->Cell(135,10,utf8_decode('CERTIFICADO DE ANÁLISIS'),1,0,'C');
    $this->SetFont('Arial','B',10);
    $this->Ln();
    $this->Cell(135,7,'LABORATORIO DE CONTROL DE CALIDAD',1,0,'C');
    $this->Ln(20);
    //Logo en marca 
    $this->RotatedImage('../../views/images/marcaAgua.jpg',45,100);
    $this->SetFont('Arial','B',10);
}
function RotatedImage($file,$x,$y,$w,$h)
//function RotatedImage($file,$x,$y,$w,$h,$angle)
{
    //Image rotated around its upper-left corner
    //$this->Rotate($angle,$x,$y);
    $this->Image($file,$x,$y,$w,$h);
    //$this->Rotate(0);
}

  function Footer($nombreAnalista,$perfilAnalista)
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
//$pdf->Header();
$pdf->AddPage();
//SGM
// cell(alto,ancho, $valor, 0 sinborde 1 con borde, 	
//RoundedRect(coord x der izq, coord y arr abaj, ancho, Alto, grado de curva,  extilo 'FD''F''S', 'bordes o lados 1234 todos');
$pdf->RoundedRect( 150, 32, 40, 7, 2,  'S', '1234');
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(255,0,0); //rojo
$pdf->SetXY(150, 49);
        $numCliente = $modelReporte->numeroCliente($id);
            foreach ($numCliente as $nume) { $descrip[] = array(
                   $ident = $nume['elnum'] 
               );
           }
$pdf->Cell(0,-28,utf8_decode('ANÁLISIS No.:'). $ident,0,0,'L');
$pdf->SetTextColor(0,0,0);
//fecha
$pdf->Ln(1);
//$pdf->SetFont('Arial','U',16);



//$pdf->RoundedRect(10, 32, 57, 7, 2,  'S', '1234');
$Forma = strtoupper($TipoEst);//a mayuscula
$TiempoEst = strtoupper($TiempoEst);//a mayuscula
$pdf->SetFont('Arial','BU',11);
$Producto = strtoupper(utf8_decode($Producto));//a mayuscula
$pdf->Cell(180,-35,utf8_decode('ESTABILIDAD '.$Forma .' '. $TiempoEst  ),0,0,'C');
$pdf->Ln(2);
$pdf->SetFont('Arial','B',14);
$pdf->Cell(180,-28,$Producto,0,0,'C');
//$pdf->RoundedRect(80, 32, 55, 7, 2,  'S', '1234');
//$pdf->Cell(68,-32,utf8_decode('EMISIÓN DE INFORME: '). substr($FechaLlegada,0,10),0,0,'R');
 
$pdf->Ln(0);	
//datos cliente
$pdf->RoundedRect(10, 42, 55, 6, 2,  'S', '1'); //Cliente
$pdf->RoundedRect(65, 42, 55, 6, 2,  'S', '0');// Area
$pdf->RoundedRect(120, 42, 70, 6, 2,  'S', '2');// Area
$pdf->RoundedRect(10, 48, 90, 6, 2,  'S', '4');
$pdf->RoundedRect(100, 48, 90, 6, 2,  'S', '3');
$pdf->Ln(-32);
$pdf->SetFont('Arial','',9);
$pdf->Cell(55,50,utf8_decode('Recepción de Muestra: ').substr($FechaLlegada,0,10),0,0,'L');
$pdf->Cell(55,50,utf8_decode('Emisión de Informe : ').date("Y-m-d"),0,0,'L');
$pdf->Cell(70,50,'Cliente: '.substr($Cliente,0,34),0,0,'L');
$pdf->Ln();
$pdf->Cell(90,-37,'Lote : '.($Lote),0,0,'L');
$pdf->Cell(55,-37,utf8_decode('Dirección de Cliente : ').($Direccion . $TiempoTemp),0,0,'L');
//Producto
$pdf->RoundedRect(10, 55, 90, 6, 2,  'S', '1');
$pdf->RoundedRect(100, 55, 90, 6, 2,  'S', '2');
$pdf->RoundedRect(10, 61, 90, 6, 2,  'S', '4');
$pdf->RoundedRect(100, 61, 90, 6, 2,  'S', '3');
$pdf->Ln();
//$pdf->Cell(90,50,utf8_decode'Presentación  : ').utf8_decode(substr($Envase,0,30)).''.utf8_decode(substr($Envase,0,30)),0,0,'L');
$pdf->Cell(90,50,utf8_decode('Presentación : ').utf8_decode(substr($Envase,0,30)).' '.utf8_decode(substr($Empaque,0,30)),0,0,'L');
$pdf->Cell(90,50,utf8_decode('Fecha Fab. : '). $FechaFabri,0,0,'L'); 
//$pdf->Cell(55,50,'Fabricante O Distribuidor : '.($Fabricante),0,0,'L');
$pdf->Ln();
$pdf->Cell(90,-37,'Fabricante o Distribuidor : '.($Fabricante),0,0,'L');
$pdf->Cell(90,-37,utf8_decode('Fecha Vence/Reanálisis  : '). $FechaVence,0,0,'L');  
//$pdf->Cell(60,-37,'Empaque : '.substr($Empaque,0,30),0,0,'L');
//$pdf->Cell(60,-37,'Envase : '.substr($Envase,0,30),0,0,'L');
//Muestra
$pdf->RoundedRect(10, 68, 180, 6, 2,  'S', '1234');
$pdf->Ln();

$pdf->Cell(90,50,utf8_decode('Condiciones de Almacenamiento : '). utf8_decode($condicionesE),0,0,'L');  

//$pdf->RoundedRect(10, 74, 90, 6, 2,  'S', '4');
//$pdf->RoundedRect(100, 74, 90, 6, 2,  'S', '3');
$pdf->Ln();
//$pdf->Cell(90,-37,utf8_decode('Tipo de Analisis : ').utf8_decode($AreaAnalisis),0,0,'L');  
//$pdf->Cell(90,-37,utf8_decode('Tamaño de lote : ').($CantidadLote),0,0,'L');


$pdf->SetFont('Arial','B',10);

$pdf->SetXY(10, 77); 
//repuestos instalados
//$pdf->Cell(180,-5,'ENSAYOS REALIZADOS',1,0,'C');
$pdf->Ln(5);
if($AreaAnalisis == 'Estabilidad'){
$pdf->Cell(40,-5,'ENSAYO',1,0,'C');
$pdf->Cell(65,-5,utf8_decode('ESPECIFICACIÓN'),1,0,'C');
$pdf->Cell(55,-5,'RESULTADO',1,0,'C');
$pdf->Cell(20,-5,utf8_decode('MÉTODO'),1,0,'C');
$pdf->SetFont('Arial','',7);
//$pdf->Ln();



/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
//$tiempoconespacio = ($_POST['$TiempoTemp']); 
$data1 = $modelReporte->VerResultadoMuestraEst($dato, $TiempoTemp);
  foreach ($data1 as $informe1) {
            $Especificacion = $informe1["especificacion"];
            $Descripcion = $informe1["desEspecifica"];
            $Metodo = $informe1["metodo"];
            $Resultado = $informe1["resultado"];
            $Aprobado = $informe1["aprobado"];
            if($Resultado == ''){$Resultado1 = 'Sin Realizar o En Revisión por DT';}else{$Resultado1 = $informe1["resultado"];}
            if($Aprobado <= 0){$Resultado1 = 'Sin Realizar o En Revisión por DT';}else{$Resultado1 = $informe1["resultado"];}
$pdf->SetX(10);
$pdf->SetWidths(array(40,65,55,20));
//$rex = $pdf->WriteHTML($Resultado)
//;
$ObservacionesFi = ereg_replace("&nbsp;","",$Resultado1);
$ObservacionesFia = ereg_replace("<div>","\r\n",$ObservacionesFi);
$ObservacionesFin = ereg_replace("</div>","",$ObservacionesFia);
$ObservacionesFinai = ereg_replace("</span>","",$ObservacionesFin);
$ObservacionesFina = ereg_replace("&","",$ObservacionesFinai);
$Resultado = ereg_replace("<br>","\r\n",$ObservacionesFina);
$pdf->Row2(array(utf8_decode($Descripcion),utf8_decode($Especificacion),utf8_decode($Resultado),utf8_decode($Metodo)));
}
/////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////



//$pdf->Ln();
$pdf->Cell(100,5,utf8_decode('N.E. : No Especifica      N.A. : No Aplica'),0,0,'L'); 
$pdf->Ln();
$pdf->Cell(100,5,utf8_decode('Los resultados emitidos son para la muestra analizada.'),0,0,'L'); 
$pdf->Ln();
$pdf->Cell(100,5,utf8_decode('Este informe no podrá ser reproducido parcial o totalmente sin autorización de Tesla Chemical S.A.S.'),0,0,'L'); 
$pdf->Ln();
$pdf->Cell(100,5,utf8_decode('Sin el sello de seguridad, este informe no es válido.'),0,0,'L'); 

$pdf->SetFont('Arial','',9);
$pdf->Ln(10);
//$pdf->SetXY(12, 180);

$Conclusion0 = ereg_replace("<br>","\r\n",$Conclusion);
$Conclusion2 = ereg_replace("<div>","\r\n",$Conclusion0);
$Conclusion3 = ereg_replace("</div>","\r\n",$Conclusion2);
$Conclusion4 = ereg_replace("</span>","",$Conclusion3);
$Conclusion5 = ereg_replace('<span style="text-decoration: underline;">',"",$Conclusion4);
$Conclusion6 = ereg_replace('<span style="font-style: italic;">',"",$Conclusion5);
$Conclusion7 = ereg_replace("</span>","",$Conclusion6);
$Conclusion8 = ereg_replace("</span>","",$Conclusion7);
if($Conclusion8 == ''){$Anexos1 = 'ANEXOS: HOJA DE DATOS PRIMARIOS, HOJA DE CALCULO, CROMATOGRAMAS'; 
$Conclusion1 = 'CONCLUSIÓN: CUMPLE ESPECIFICACIÓN PARA LOS ENSAYOS RELIZADOS';} else {$Conclusion1 = $Conclusion8;}
$pdf->Cell(10,5,utf8_decode($Anexos1),0,0,'L');
$pdf->Ln(7);
$pdf->Cell(10,5,utf8_decode($Conclusion1),0,0,'L');
//$pdf->Ln(5);
//$pdf->Cell(100,5,utf8_decode('CONCEPTO : APROBADO'),0,0,'L');


}
else 
{
   $pdf->Cell(100,5,utf8_decode('Lo sentimos, la muestra aún esta en proceso, consulte con el laboratorio'),0,0,'L'); 
}
 //se saca de footer por que no el footer no llama datos dinamicamente 
    // Position at 1.5 cm from bottom
  $pdf->SetY(-35);
  $pdf->Cell(90,2,utf8_decode('________________________________________'),0,0,'C');
  $pdf->Cell(90,2,utf8_decode('________________________________________'),0,0,'C');
  $pdf->Ln();
  $pdf->Cell(90,5,utf8_decode($nombreAnalista),0,0,'C');
  $pdf->Cell(90,5,utf8_decode('Q.F. UdeA JOSE DAVID LAZARUS A.'),0,0,'C');
  $pdf->Ln();
  $pdf->Cell(90,4,utf8_decode($perfilAnalista),0,0,'C');
  $pdf->Cell(90,4,utf8_decode('Director Técnico'),0,0,'C');
  $pdf->Ln();
  $pdf->SetFont('Arial','I',8);
    // Print centered page number
  // $this->Cell(0,10, utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');


 $pdf->Output();

?>