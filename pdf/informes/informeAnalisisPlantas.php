<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
$idInicio = $_GET['idInicio'];
$idFinal = $_GET['idFinal'];

//$idInicio = 'PL-174';
//$idFinal = 'PL-182';


//$perlf = $_POST['idPerfil'];
   
$modelReporte = new TablaReportesDbModelClass();
//$dini = $modelReporte->getIdInicio($dato1);
//$dato = $dini[0][id];

$dini = $modelReporte->getIdInicio($idInicio);
$dato1 = $dini[0][id];
$dfin = $modelReporte->getIdFin($idFinal);
$dato2 = $dfin[0][id];


    $data = $modelReporte->getInfoPrincipalHojaCalculoPlanta($dato1, $dato2);
            foreach ($data as $informe) {
               $informes[] = array(
                   $id = $informe['prefijo'].'-'.$informe['custom_id'] ,
                   $Empresa = $informe['empresa'],
                   $Sanitizante = $informe['sanitizante'],
                   $Cantidad = $informe['cantidad_enviada'],
                   $Planta = $informe['planta'],
                   $Frotis = $informe['frotis'],
                   $DirigidoA = $informe['dirigidoa'],
                   $Remision = $informe['numero_remision'],
                   $Responsable= $informe['responsable_toma'],
                   $Departamento = $informe['departamento'],
                   $Entrada = $informe['identificador_cliente'],
                   $Producto = $informe['producto'],
                   $Lote = $informe['numero'],
                   $TipoProducto = $informe['tipoproducto'],
		   $TipoEstabilidad = $informe['estabilidad'],

                   
                    $FechaMuestreo = $informe['fecha_muestreo'],
                    $FechaAm = substr($informe['fecha_muestreo'],2,2),
                    $FechaMm = substr($informe['fecha_muestreo'],5,2),
                    $FechaDm = substr($informe['fecha_muestreo'],8,2),
                    $FechaFabricacion = $FechaDm .'-'. $FechaMm .'-'.$FechaAm,
                   
                   
                   $FechaFabricacion1 = $informe['fecha_fabricacion'],
                    $FechaA = substr($informe['fecha_fabricacion'],2,2),
                    $FechaM = substr($informe['fecha_fabricacion'],5,2),
                    $FechaD = substr($informe['fecha_fabricacion'],8,2),
                    $FechaFabricacion = $FechaD .'-'. $FechaM .'-'.$FechaA,
                  
                    $FechaVencimiento1 = $informe['fecha_vencimiento'],
                    $FechaAv = substr($informe['fecha_vencimiento'],2,2),
                    $FechaMv = substr($informe['fecha_vencimiento'],5,2),
                    $FechaDv = substr($informe['fecha_vencimiento'],8,2),
                    $FechaVencimiento = $FechaDv .'-'. $FechaMv .'-'.$FechaAv,
                   
                    $CantidadTotal = $informe['tamano'],
                    $Tecnica = $informe['tecnicausada'],
                    $TecnicaUsada = $informe['planta_tec_usada'],
                    $Laboratorio = $informe['procedencia'],
                    $FechaMuestreo1 = $informe['fecha_muestreo'],
                    $FechaAm = substr($informe['fecha_muestreo'],2,2),
                    $FechaMm = substr($informe['fecha_muestreo'],5,2),
                    $FechaDm = substr($informe['fecha_muestreo'],8,2),
                    $FechaMuestreo = $FechaDm .'-'. $FechaMm .'-'.$FechaAm,
                    $FechaAnalisis1 = $informe['fechaanalisis'],
                    $FechaAa = substr($informe['fechaanalisis'],2,2),
                    $FechaMa = substr($informe['fechaanalisis'],5,2),
                    $FechaDa = substr($informe['fechaanalisis'],8,2),
                    $FechaAnalisis = $FechaDa .'-'. $FechaMa .'-'.$FechaAa,
                    $FechaReporte1 = $informe['fechareporte'],
                    $FechaAr = substr($informe['fechareporte'],2,2),
                    $FechaMr = substr($informe['fechareporte'],5,2),
                    $FechaDr = substr($informe['fechareporte'],8,2),
                    $FechaReporte = $FechaDr .'-'. $FechaMr .'-'.$FechaAr,
                   $Conclusion = $informe['conclusion']
                       
                 );
           }
           
             if($FechaA == '00'){$FechaFabricacion = 'N.E';} 
             if($FechaAv == '00'){$FechaVencimiento = 'N.E';} 
             if($Entrada == ''){$Entrada = 'N.E';} 
             if($Remision == ''){$Remision = 'N.E';} 
//            if($anofab == '2000'){$FechaFabri = 'N.E';}
//            if($anoven == '2000'){$FechaVence = 'N.E';}
	     if($TipoEstabilidad == 'NULL'){$TipoEstabilidad = '';}
             if($TipoEstabilidad == 'N.A'){$TipoEstabilidad = '';}




class PDF extends FPDF { 
    
       function Header()
{
    $this->Cell(60,20,utf8_decode(''),1,0,'C');
    $this->Image('../../views/images/logoEmpresa.png',13,12,35);
    //Arial bold 15
    $this->SetFont('Arial','B',11);
    //Move to the right
    //$this->Cell(1);
    //Title
    $this->Cell(160,20,('CERTIFICADO DE ANÁLISIS MICROBIOLÓGICO'),1,0,'C');
     $this->SetFont('Arial','B',7);
    $this->Cell(20,5,('CÓDIGO'),1,0,'C');
    $this->Cell(30,5,utf8_decode(' '),1,0,'C');
   
    $this->SetXY(230, 15);
    $this->Cell(20,5,('VERSIÓN'),1,0,'C');
    $this->Cell(30,5,utf8_decode(' '),1,0,'C');
    $this->SetXY(230, 20);
    $this->Cell(20,5,utf8_decode('VIGENCIA'),1,0,'C');
    $this->Cell(30,5,utf8_decode(' '),1,0,'C');
    $this->SetXY(230, 25);
    $this->Cell(20,5,('PÁGINA'),1,0,'C');
    $this->Cell(30,5, $this->PageNo().' de {nb}'  ,1,0,'C');
    $this->Ln(48);
}
function Footer()
{
  $this->SetY(-81);

            $this->SetFont('Arial','B',9);
            $this->Ln(20);
            $this->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
            $this->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
            $this->Ln(4);
            $this->Cell(90,4,('ELABORÓ'),0,0,'C');
            $this->Cell(90,4,('VERIFICÓ'),0,0,'C');
            $this->Ln(4);
             $this->SetFont('Arial','',9);
            $this->Cell(90,4,('ANALISTA DE MICROBIOLOGÍA'),0,0,'C');
            $this->Cell(90,4,('DIRECTOR TÉCNICO'),0,0,'C');
  $this->Ln(20);
  $this->SetFont('Arial','I',8);



        $this->SetFont('Arial','B',8);
        $this->Cell(180,7,('Calle 168 No 22-35 Piso 3 Telefonos: 3004271  Telefax 677 74 72 Bogotá D.C'),0,0,'C');
        $this->Ln(3);
        $this->Cell(180,7,utf8_decode('Email: gerencia@laserpharma.com'),0,0,'C');

}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage(L);
$pdf->Ln(-40);
                       
           
            $pdf->RoundedRect( 10, 33, 135, 7, 2,  'S', '1');
            $pdf->RoundedRect( 145, 33, 135, 7, 2,  'S', '2');
           // $pdf->RoundedRect( 10, 70, 135, 7, 2,  'S', '4');
            $pdf->RoundedRect( 10, 68, 270, 7, 2,  'S', '34');
            $pdf->Cell(135,7,('NOMBRE DE LA EMPRESA: '.substr((utf8_decode($Empresa)), 0,39)),0,0,'L');
            $pdf->Cell(135,7,utf8_decode('SANITIZANTE: ') . strtoupper($Sanitizante),0,0,'L');
            $pdf->Ln(7);
           //$pdf->SetFont('Arial','B',6);
            $pdf->Cell(135,7,('FECHA DE MUESTREO: '.(utf8_decode($FechaFabricacion))),1,0,'L');
            $pdf->Cell(135,7,('CANTIDAD DE MUESTRA: ' . strtoupper($Cantidad)),1,0,'L');
            $pdf->Ln(7);
            $pdf->Cell(135,7,('FECHA DE ANÁLISIS: '. (utf8_decode($FechaAnalisis))),1,0,'L');
            $pdf->Cell(135,7,utf8_decode('TÉCNICA USADA: '. strtoupper($TecnicaUsada)),1,0,'L');
            $pdf->Ln(7);
            $pdf->Cell(135,7,utf8_decode('PLANTA: '. strtoupper($Planta)),1,0,'L');
            $pdf->Cell(135,7,('FROTIS REALIZADO A: '. strtoupper($Frotis)),1,0,'L');
            $pdf->Ln(7);
            $pdf->Cell(135,7,utf8_decode('FECHA DE EMISIÓN DE RESULTADOS: '. strtoupper($FechaReporte)),1,0,'L');
            $pdf->Cell(135,7,utf8_decode('ESPECIFICACIÓN: '.strtoupper($Tecnica)),1,0,'L');
            $pdf->Ln(7);
            $pdf->Cell(135,7,('RESPONSABLE DE TOMA DE MUESTRA: '.strtoupper($Responsable)),0,0,'L');

 $pdf->SetFont('Arial','B',11);

         
            
          $pdf->Ln(13);        
            
//if($Estado >= 4){
$pdf->SetFont('Arial','B',7);
$pdf->RoundedRect( 10, 105, 40, 5, 2,  'S', '1');  
$pdf->RoundedRect( 125, 105, 65, 5, 2,  'S', '2');
$pdf->Cell(14,-5,('CÓDIGO'),1,0,'C');
$pdf->Cell(24,-5,('ÁREA'),1,0,'C');
$pdf->Cell(22,-5,'SUPERF./EQUIPO',1,0,'C');
$pdf->Cell(40,-5,utf8_decode('PROD./TIPO'),1,0,'C');
$pdf->Cell(15,-5,utf8_decode('LOTE'),1,0,'C');
$pdf->Cell(35,-5,utf8_decode('ESP.MESOFILOS'),1,0,'C');
$pdf->Cell(25,-5,utf8_decode('RES.MESOFILOS'),1,0,'C');
$pdf->Cell(35,-5,utf8_decode('ESP.HO. Y LEV.'),1,0,'C');
$pdf->Cell(23,-5,utf8_decode('RES.HO. Y LEV.'),1,0,'C');
$pdf->Cell(20,-5,utf8_decode('ESP.E.COLI'),1,0,'C');
$pdf->Cell(17,-5,utf8_decode('RES.E.COLI'),1,0,'C');
$pdf->SetFont('Arial','',9);
//$pdf->Ln();


/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////$idInicial, $idFinal
$data1 = $modelReporte->VerInformesResultadosPlantas($idInicial, $idFinal);
  foreach ($data1 as $informe1) {
            $Codigo = $informe1["prefijo"] . '-'. $informe1["custom_id"];
            $Frotis = $informe1["frotis"];
            $Area = $informe1["planta_area"];
            $Producto = $informe1["producto"];
            $Lote = $informe1["lote"];
            $EspMeso = $informe1["esp_aer_mes"];
            $EspHongo = $informe1["esp_moh_lev"];
            $EspColi = $informe1["esp_ecoli"];
            $Resultado = $informe1["resultado"];
            $Espacio =  ' ';
            
$pdf->SetX(10);
$pdf->SetWidths(array(14,24,22,40,15,35,25,35,23,20,17));
$ResultadoX = preg_replace("/<br>/","\r\n",$Resultado1);
$Resultado2 = preg_replace("/=/","<=",$ResultadoX);
$Resultado = preg_replace("/&lt;/","<",$Resultado2);

$pdf->Row2(array(utf8_decode($Codigo),utf8_decode($Area),utf8_decode($Frotis),utf8_decode($Producto),utf8_decode($Lote),utf8_decode($EspMeso),($Espacio),utf8_decode($EspHongo),($Espacio),utf8_decode($EspColi),($Espacio)));



}


$data2 = $modelReporte->VerResultadoMuestraCepasPlanta($idInicial, $idFinal);
  foreach ($data2 as $informe2) {
           $Cepas = $informe2["cepas"];
 $pdf->Ln(3);
            //$pdf->Cell(40,8,utf8_decode('Cepas control de calidad medios de cultivo:'),1,0,'L');
  $pdf->MultiCell(180,7,utf8_decode('Cepas control de calidad medios de cultivo: '). utf8_decode($Cepas),1);}
$pdf->Ln(3);
/////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////



//$pdf->Ln();

$pdf->SetFont('Arial','',7);
$Conclusion1= preg_replace("/<br>/","\r\n",$Conclusion);
$pdf->MultiCell(180,6,('CONCLUSIÓN: '). strtoupper(utf8_decode($Conclusion1))); 
$pdf->Ln(4);
$pdf->MultiCell(180,6,('OBSERVACIONES: RESULTADO VALIDO ÚNICAMENTE PARA LA MUESTRA ANALIZADA Y NO PARA OTRA DE LA MISMA PROCEDENCIA. ÉSTE CERTIFICADO NO PUEDE SER REPRODUCIDO SIN PREVIA AUTORIZACIÓN ESCRITA DE LA GERENCIA DEL LABORATORIO.')); 
$pdf->Ln(4);
//$pdf->Cell(100,7,('Este informe no podrá ser reproducido parcial o totalmente sin autorización de Tesla Chemical S.A.S.'),0,0,'L'); 
//$pdf->Ln();
//$pdf->Cell(100,7,('Sin el sello de seguridad, este informe no es válido.'),0,0,'L'); 


 $pdf->Output();

