<?php
require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
//$dato1 = $_POST['idMuestraIni'];
//$dato1 = $_POST['idMuestraFin'];
//
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
                   $DirigidoA = $informe['dirigidoa'],
                   $Remision = $informe['numero_remision'],
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
//            $this->SetFont('Arial','B',9);
//            $this->Ln();
//            $this->Cell(260,4,utf8_decode('(AB)Ambientes Áreas Blancas, (P) Personal, (PE) Personal Empaque, (S) Superficies, (AC) Aire Comprimido, (AA) Ambientes Áreas Grises, (F) Filtros, (U) Uniformes'),0,0,'C');
}
}
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage(L);
$pdf->Ln(-40);
            $pdf->SetFont('Arial','B',8);
//  $pdf->Ln(8);
//            $pdf->RoundedRect( 10, 62, 90, 7, 2,  'S', '1');
//            $pdf->RoundedRect( 100, 62, 90, 7, 2,  'S', '2');
//            $pdf->RoundedRect( 10, 97, 90, 7, 2,  'S', '4');
//            $pdf->RoundedRect( 100, 97, 90, 7, 2,  'S', '3');
            $pdf->Cell(135,7,('EMPRESA: '.substr((utf8_decode($Empresa)), 0,39)),1,0,'L');
            $pdf->Cell(135,7,utf8_decode('CANTIDAD DE LA MUESTRA: ') . strtoupper($Cantidad),1,0,'L');
            $pdf->Ln(7);
           //$pdf->SetFont('Arial','B',6);
            $pdf->Cell(135,7,('FECHA DE MUESTREO: '.(utf8_decode($FechaMuestreo))),1,0,'L');
            $pdf->Cell(135,7,('SANITIZANTE: ' . strtoupper($Sanitizante)),1,0,'L');
            $pdf->Ln(7);
            $pdf->Cell(135,7,('FECHA DE ANALISIS: '. (utf8_decode($FechaAnalisis))),1,0,'L');
            $pdf->Cell(135,7,utf8_decode('TÉNICA USADA: '.strtoupper($Tecnica)),1,0,'L');
            $pdf->Ln(7);
            $pdf->Cell(270,7,utf8_decode('PLANTA: '. strtoupper($Planta)),1,0,'L');
//            $pdf->Cell(135,7,('BLANCO '. strtoupper($FechaFabricacion)),1,0,'L');
             $pdf->SetFont('Arial','B',11);
         $pdf->Ln(13);        
          
//if($Estado >= 4){
//$pdf->RoundedRect( 10, 105, 40, 5, 2,  'S', '1');  
//$pdf->RoundedRect( 125, 105, 65, 5, 2,  'S', '2');
$pdf->SetFont('Arial','B',7);
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
$pdf->Ln(1);


/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerPlantasHojaCalculo($dato1, $dato2);
  foreach ($data1 as $informe1) {
            $Codigo = $informe1["prefijo"] . '-'. $informe1["custom_id"];
            $Frotis = $informe1["frotis"];
            $Area = $informe1["planta_area"];
            $Producto = $informe1["producto"];
            $Lote = $informe1["lote"];
            $EspMeso = $informe1["esp_aer_mes"];
            $EspHongo = $informe1["esp_moh_lev"];
            $EspColi = $informe1["esp_ecoli"];
            $Espacio =  ' ';
$pdf->SetX(10);
$pdf->SetWidths(array(14,24,22,40,15,35,25,35,23,20,17));
$ResultadoX = preg_replace("/<br>/","\r\n",$Resultado1);
$Resultado2 = preg_replace("/=/","<=",$ResultadoX);
$Resultado = preg_replace("/&lt;/","<",$Resultado2);

$pdf->Row2(array(utf8_decode($Codigo),utf8_decode($Area),utf8_decode($Frotis),utf8_decode($Producto),utf8_decode($Lote),utf8_decode($EspMeso),($Espacio),utf8_decode($EspHongo),($Espacio),utf8_decode($EspColi),($Espacio)));


}


 $pdf->Output();

