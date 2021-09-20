<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$sumRenglon = 0;
$modelReporte = new TablaReportesDbModelClass();
$dato2 = $_POST['filtroNumero'];
$dato1 = $modelReporte->getRealIdMuestra($dato2);
$dato = $dato1;
$validador = substr($dato, 2, 1);

//$dini = $modelReporte->getIdInicio($dato1);
//$dato = $dini[0][id];
$hoy = new DateTime();
$numCliente = $modelReporte->numeroCliente($dato);
foreach ($numCliente as $nume) {
    $numee[] = array(
        $codigolqf = $nume['elnum']
    );
}
$data = $modelReporte->getInfoPrincipal($dato);
foreach ($data as $informe) {
    $informes[] = array(
        $id = $informe['id'],
        $FechaLlegada = $informe['fecha_llegada'],
        $Anollegada = substr($FechaLlegada, 0, 4),
        $Mesllegada = substr($FechaLlegada, 5, 2),
        $Diallegada = substr($FechaLlegada, 8, 2),
        $FechaLlegada1 = $Diallegada . '-' . $Mesllegada . '-' . $Anollegada,
        $Contacto = $informe['nombre_contacto'],
        $AreaContacto = $informe['area_contacto'],
        $Fabricante = $informe['fabricante'],
        $Procedencia = $informe['procedencia'],
        $NumeroInforme = $informe['num_informe'],
        $numeroremision = $informe['numero_remision'],
        $Producto = $informe['nombre_producto'],
        $Cliente = $informe['nombre_tercero'],
        $Ciudad = $informe['ciudad'],
        $Direccion = $informe['direccion_tercero'],
        $Telefono = $informe['telefono_tercero'],
        $Forma = $informe['FormaFarmaceutica'], //Esto es tipo de Producto
        $tipoProducto = $informe['tipo_producto'],
        $des_area_analisis = $informe['nombre_producto'],
        $FechaFabri = substr($informe['fecha_fabricacion'], 0, 10),
        $AnoFv = substr($FechaFabri, 0, 4),
        $MesFv = substr($FechaFabri, 5, 2),
        $DiaFv = substr($FechaFabri, 8, 2),
        $FechaFabri1 = $MesFv . '-' . $AnoFv,
        $FechaVence = substr($informe['fecha_vencimiento'], 0, 10),
        $AnoFf = substr($FechaVence, 0, 4),
        $MesFf = substr($FechaVence, 5, 2),
        $DiaFf = substr($FechaVence, 8, 2),
        $FechaVence1 = $MesFf . '-' . $AnoFf,
        $finalizacionAnalisis = substr($informe['finalizacionAnalisis'], 0, 10),
        $AnoF = substr($finalizacionAnalisis, 0, 4),
        $MesF = substr($finalizacionAnalisis, 5, 2),
        $DiaF = substr($finalizacionAnalisis, 8, 2),
        $finalizacionAnalisis = $DiaF . '-' . $MesF . '-' . $AnoF,
        $inicioAnalisis = substr($informe['inicioAnalisis'], 0, 10),
        $AnoI = substr($inicioAnalisis, 0, 4),
        $MesI = substr($inicioAnalisis, 5, 2),
        $DiaI = substr($inicioAnalisis, 8, 2),
        $inicioAnalisis = $DiaI . '-' . $MesI . '-' . $AnoI,
        $Empaque = $informe['Empaque'],
        $Envase = $informe['Envase'], // es Forma Farmaceutica
        $PrincipioActivo = $informe['PrincipioActivo'],
        $CantidadLote = $informe['cantidadLote'],
        $cantidadEnvada = $informe['cantidadEnvada'],
        $Lote = $informe['lote'],
        $AreaAnalisis = $informe['des_area_analisis'],
        $Conclusion = $informe["conclusion"],
        $Estado = $informe["estado"],
        $nombreAnalista = $informe["nombreAnalista"],
        $perfilAnalista = $informe["PerfilAnalista"],
        $anofab = substr($FechaFabri, 0, 4),
        $anoven = substr($FechaVence, 0, 4),
        $codigo1 = $informe["codigo"],
        $estabilidad = $informe["estabilidad"],
        $idFormaFarmaceutica = intval($informe["idFormaFarmaceutica"]),
        $invima = $informe["invima"],
        $especificacionesTraza = $informe["especificacionTraza"]
    );
}
if ($anofab == '1900') {
    $FechaFabri1 = 'No Especificada';
}
if ($anoven == '1900') {
    $FechaVence1 = 'No Especificada';
}

$metodosTraza = $modelReporte->getMetodo($dato);

//$especificacionesTraza = $modelReporte->getEspecificacion($dato);

class PDF extends FPDF {

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Header() {
        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 15, 13, 30);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->MultiCell(80, 10, utf8_decode('CERTIFICADO DE ANÁLISIS FISICOQUIMICO'), 1, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');

        $this->SetXY(130, 10);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('F-CC-006-001 '), 1, 0, 'C');

        $this->SetXY(130, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('01'), 1, 0, 'C');
        $this->SetXY(130, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('2017-10-15'), 1, 0, 'C');
        $this->SetXY(130, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        // $this->Cell(30, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Cell(30, 5, $this->PageNo() . ' de ____', 1, 0, 'C');
        $this->Ln(8);
        // To be implemented in your own inherited class

        $this->SetFont('Arial', 'B', 8);
        $this->RoundedRect(130, 33, 60, 7, 2, 'S', '1234');
        $this->Cell(120, 7, utf8_decode(''), 0, 0, 'L');
        $this->Cell(35, 7, utf8_decode('Radicación No. '), 0, 0, 'L');
        $this->SetTextColor(0, 128, 255); //Azul
        $this->Cell(25, 7, $GLOBALS['codigolqf'], 0, 0, 'L');
        $this->SetTextColor(0, 0, 0); //NEGRO
        $this->Ln(-3);

        $cantletras = strlen($GLOBALS['Producto']);
        if ($cantletras > 58) {
            $this->SetFont('Arial', 'B', 8);
        } else {
            $this->SetFont('Arial', 'B', 10);
        }
        $this->Cell(120, 7, utf8_decode($GLOBALS['Producto']), 0, 0, 'C');

        $this->Ln(6);
        $this->Cell(120, 7, 'LOTE:' . utf8_decode($GLOBALS['Lote']), 0, 0, 'C');
        $this->Ln(7);
        if ($GLOBALS['estabilidad'] !== 'N/A' && $GLOBALS['estabilidad'] !== NULL && $GLOBALS['estabilidad'] !== '') {
            $this->Cell(120, 5, utf8_decode('Estabilidad: ' . $GLOBALS['estabilidad']), 0, 0, 'C');
            $this->Ln(7);
            $GLOBALS['sumRenglon'] ++;
        }
        if ($GLOBALS['invima'] !== 'N/A' && $GLOBALS['invima'] !== NULL && $GLOBALS['invima'] !== '') {
            $this->Cell(120, 5, utf8_decode('Registro INVIMA: ' . $GLOBALS['invima']), 0, 0, 'C');
            $this->Ln(7);
            $GLOBALS['sumRenglon'] ++;
        }

        $this->cabeceraInformacionMuestra();
    }

    function cabeceraInformacionMuestra() {
        $this->SetFont('Arial', '', 9);
        $this->Ln(5);
        $this->Cell(18, 6, 'Cliente:', LTB, 0, 'L');
        $this->Cell(72, 6, substr(utf8_decode($GLOBALS['Cliente']), 0, 34), TBR, 0, 'L');
        $this->Cell(18, 6, utf8_decode('Dirección: '), LTB, 0, 'L');
        $this->Cell(72, 6, utf8_decode($GLOBALS['Direccion']), TBR, 0, 'L');
        $this->Ln(6);
        $this->Cell(45, 6, utf8_decode('Número Interno del Cliente:'), LTB, 0, 'L');
        $this->Cell(45, 6, utf8_decode($GLOBALS['numeroremision']), TBR, 0, 'L');
        $this->Cell(18, 6, utf8_decode('Ciudad : '), TB, 0, 'L');
        $this->Cell(72, 6, utf8_decode($GLOBALS['Ciudad']), TBR, 0, 'L');

        $this->Ln(7);
        $this->cY = $this->GetY();
        if ($GLOBALS['Forma'] == 'Materia Prima') {
            $heg = $this->NbLines(61, $GLOBALS['Forma']);
        } else {
            $heg = $this->NbLines(61, $GLOBALS['Forma'] . '  (' . $GLOBALS['Envase'] . ')');
        }

        $this->MultiCell(31, 6 * $heg, utf8_decode('Tipo de Muestra:'), LT, 'T');
        if ($GLOBALS['Forma'] == 'Materia Prima') {
            $this->SetXY($this->GetX() + 31, $this->cY);
            $this->MultiCell(59, 6, utf8_decode($GLOBALS['Forma']), TR, 'L');
        } else {
            $this->SetXY($this->GetX() + 31, $this->cY);
            $this->MultiCell(59, 6, utf8_decode($GLOBALS['Forma'] . '  (' . $GLOBALS['Envase'] . ')'), TR, 'L');
        }
        $tempy = ($this->GetY() - $this->cY) / 6;
        $this->SetXY($this->GetX() + 90, $this->cY);
        $this->Cell(32, 6 * $heg, utf8_decode('Presentación:'), LT, 0, 'L');
        $this->SetXY($this->GetX(), $this->cY);
        $this->Cell(58, 6 * $heg, utf8_decode(substr($GLOBALS['Empaque'], 0, 30)), TR, 0, 'L');

        while ($tempy !== 0) {
            $this->Ln(6);
            $tempy = $tempy - 1;
        }

        $this->cY = $this->GetY();
        $hegFab = $this->NbLines(58, $GLOBALS['Fabricante']);
        if ($GLOBALS['Forma'] == 'Materia Prima') {
            $this->Cell(31, 6 * $hegFab, utf8_decode('Cantidad Recibida: '), LTB, 0, 'L');
        } else {
            $this->Cell(31, 6 * $hegFab, utf8_decode('Cantidad Recibida: '), LTB, 0, 'L');
        }
        if ($GLOBALS['cantidadEnvada'] == "N/A") {
            $this->Cell(59, 6 * $hegFab, "No especificado", TBR, 0, 'L');
        } else {
            $this->Cell(59, 6 * $hegFab, $GLOBALS['cantidadEnvada'], TBR, 0, 'L');
        }
        if ($GLOBALS['Forma'] == 'Materia Prima') {
            $this->Cell(32, 6 * $hegFab, utf8_decode('Proveedor: '), LTB, 0, 'L');
        } else {
            $this->Cell(32, 6 * $hegFab, utf8_decode('Fabricante/O.P.: '), LTB, 0, 'L');
        }
        $this->Cell(58, 6, utf8_decode($GLOBALS['Fabricante']), TBR, 0, 'L');
        $this->Ln(6);
        $this->Cell(31, 6, utf8_decode('Fecha de fabricación:'), LTB, 0, 'L');
        $auxFechaFabricacion = new DateTime($GLOBALS['FechaFabri']);
        if ($auxFechaFabricacion->format("Y") != "1900") {
            $this->Cell(59, 6, $auxFechaFabricacion->format("Y-m-d"), TBR, 0, 'L');
        } else {
            $this->Cell(59, 6, "No Especificada", TBR, 0, 'L');
        }

        if ($GLOBALS['Forma'] == 'Materia Prima') {
            $this->Cell(32, 6, utf8_decode('Fecha de Venc./Rean: '), LTB, 0, 'L');
        } else {
            $this->Cell(32, 6, utf8_decode('Fecha de vencimiento: '), LTB, 0, 'L');
        }


        $auxFechaVencimiento = new DateTime($GLOBALS['FechaVence']);

        if ($auxFechaVencimiento->format("Y") != "1900") {
            $this->Cell(58, 6, $auxFechaVencimiento->format("Y-m-d"), TBR, 0, 'L');
        } else {
            $this->Cell(58, 6, "No Especificada", TBR, 0, 'L');
        }
        $this->Ln(7);
        $auxFechaLlegada = new DateTime($GLOBALS['FechaLlegada']);
        $this->Cell(60, 6, utf8_decode('Fecha de llegada: ') . ($auxFechaLlegada->format("Y-m-d")), 1, 0, 'L');
        $auxFechaInicioAnalisis = new DateTime($GLOBALS['informe']['inicioAnalisis']);
        $this->Cell(60, 6, utf8_decode('Fecha de análisis : ') . ($auxFechaInicioAnalisis->format("Y-m-d")), 1, 0, 'L');
        if ($GLOBALS['informe']['finalizacionAnalisis']) {
            $auxFechafinalizacionAnalisis = new DateTime($GLOBALS['informe']['finalizacionAnalisis']);
            $this->Cell(60, 6, utf8_decode('Fecha de aprobación : ') . ($auxFechafinalizacionAnalisis->format("Y-m-d")), 1, 0, 'L');
        } else {
            $this->Cell(60, 6, utf8_decode('Fecha de aprobación : '), 1, 0, 'L');
        }

        $this->Ln(7);

        if ($GLOBALS['idFormaFarmaceutica'] !== 74) {
            $arr = explode('ESP:', $GLOBALS['codigo1']);

            if ($arr[1] != null) {
                $codigo = $arr[1];
            } else {
                $codigo = $arr[0];
            }
            $this->Cell(180, 6, utf8_decode('Especificaciones: ') . utf8_decode($codigo), 1, 0, 'L');
            $this->Ln(7);
        } else {
            $metodoTraza = implode(",", $GLOBALS['metodosTraza']);

            $this->Cell(180, 6, utf8_decode('Método: ') . utf8_decode($metodoTraza), 1, 0, 'L');
            $this->Ln(7);

            $this->Cell(180, 6, utf8_decode('Especificaciones: ') . utf8_decode($GLOBALS['especificacionesTraza']), 1, 0, 'L');
            $this->Ln(7);
        }

        $this->SetXY(10, 99);
        $this->SetFont('Arial', 'B', 10);

        while ((($heg + $hegFab + $GLOBALS['sumRenglon']) - 2) !== 0) {
            $this->Ln();
            $heg--;
        }
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(0);

if ($idFormaFarmaceutica !== 74) {
    resultadosEnsayos($dato);
} else {
    resultadosTraza($dato);
}

/////////////////////////////////////////
/////////FIN LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
//$pdf->Ln();
$pdf->SetFont('Arial', '', 7);
$Conclusion1 = preg_replace("/<br>/", "\r\n", $Conclusion);
$Conclusion2 = preg_replace("/<div>/", "\r\n", $Conclusion1);
$Conclusion3 = preg_replace("/<\/div>/", "\r\n", $Conclusion2);
$Condiciones1 = preg_replace(" ", " ", $Condiciones);
$pdf->MultiCell(180, 4, (utf8_decode($Conclusion3)));

$indice = $pdf->GetY();
if ($indice > 231) {
    $pdf->AddPage();
}
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln(5);
$pdf->Cell(55, 4, utf8_decode(' '), 0, 0, 'C');
$pdf->Cell(90, 4, utf8_decode('APROBADO POR'), 0, 0, 'L');
//  $this->Cell(90,4,utf8_decode('VERIFICÓ'),0,0,'C');
$pdf->Ln(12);
$pdf->Cell(180, 4, utf8_decode('________________________________________'), 0, 0, 'C');
//            $this->Cell(90,4,utf8_decode('________________________________________'),0,0,'C');
$pdf->Ln(4);
//$this->Cell(180,4,utf8_decode('Nombre y Firma del Director Técnico'),0,0,'C');
//  $this->Cell(90,4,utf8_decode('VERIFICÓ'),0,0,'C');
//$this->Ln(4);
// $this->SetFont('Arial','',9);
$pdf->Cell(180, 4, utf8_decode('MAGDALENA TIBAVISCO D. Q.F.U.N.'), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(180, 4, utf8_decode('Directora Técnica y de calidad'), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(180, 4, utf8_decode('c.c. Archivo Laboratorios Lafont'), 0, 0, 'C');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(180, 7, utf8_decode('Carrera 58 No. 97-36 Segundo Piso (Bogotá - Colombia) Teléfonos: 7185945 Cel 3166141444  Bogotá D.C'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 7, utf8_decode('Email: gerencia@soulsystem.co   WEB: www.soulsystem.co '), 0, 0, 'C');
$pdf->Output();

function resultadosTraza($dato) {
    $pdf = $GLOBALS['pdf'];
    $y = $pdf->GetY();
    $pdf->SetY($y + 5);
    $tit1 = 50;
    $tit2 = 65;
    $tit3 = 65;
    $letrascol = $GLOBALS['letrascol'];
    $modelReporte = $GLOBALS['modelReporte'];
    $pdf->Cell($tit1, -5, utf8_decode('MUESTRA') . $letrascol, 1, 0, 'C');
    $pdf->Cell($tit2, -5, utf8_decode('NOMBRE'), 1, 0, 'C');
    $pdf->Cell($tit3, -5, 'RESULTADO', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);

    /////////////////////////////////////////
    /////////INCIO LISTADO DE ENSAYOS////////
    /////////////////////////////////////////
    $data1 = $modelReporte->VerResultadoMuestra($dato);
    $dataTraza = $data1[0];


    $pdf->SetX(10);
    $Resultado = $dataTraza["resultado"];
    $pdf->MultiCell(180, 5, utf8_decode($Resultado), 1, 'L');
    $pdf->Ln(3);
}

function resultadosEnsayos($dato) {
    $pdf = $GLOBALS['pdf'];
    $letrascol = $GLOBALS['letrascol'];
    $modelReporte = $GLOBALS['modelReporte'];
    $tit1 = 40;
    $tit2 = 55;
    $tit3 = 60;
    $tit4 = 25;
    $pdf->Cell($tit1, -5, utf8_decode('Ensayo') . $letrascol, 1, 0, 'C');
    $pdf->Cell($tit2, -5, utf8_decode('Especificación'), 1, 0, 'C');
    $pdf->Cell($tit3, -5, 'Resultado', 1, 0, 'C');
    $pdf->Cell($tit4, -5, utf8_decode('Metodología'), 1, 0, 'C');
    $pdf->SetFont('Arial', '', 9);
/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
    $data1 = $modelReporte->VerResultadoMuestra($dato);
    foreach ($data1 as $informe1) {
        $Especificacion = $informe1["especificacion"];
        //$pdf->SetFont('Arial','I',9);
        $Descripcion = $informe1["descripcion"];
        //$pdf->SetFont('Arial','B',9);
        $Metodo = $informe1["metodo"];
        $Resultado1 = $informe1["resultado"];

        $pdf->SetX(10);
        $colum1 = 40;
        $colum2 = 55;
        $colum3 = 60;
        $colum4 = 25;
        $pdf->SetWidths(array($colum1, $colum2, $colum3, $colum4));

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
//saco el resultado por pantalla
        $Resultado = preg_replace($exp_regular, $cadena_nueva, $Resultado1);
        $pdf->SetAligns(array('C', 'C', 'C', 'C'));
        $pdf->Row2(array(utf8_decode($Descripcion), utf8_decode($Especificacion), utf8_decode($Resultado), utf8_decode($Metodo)));
    }
    $pdf->Ln(3);
}

?>