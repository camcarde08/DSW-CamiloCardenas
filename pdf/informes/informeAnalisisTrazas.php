<?php

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';

$dato = $_POST['idMuestra'];
$perfil = $_POST['idPerfil'];

$modelReporte = new TablaReportesDbModelClass();
$validador = substr($dato, 2, 1);
if ($validador == '-') {
    $dini = $modelReporte->getIdInicio($dato);
    $datoidcepas = $dini[0][id];
    $dato = $dini[0][id];
}
//$dini = $modelReporte->getIdInicio($dato1);
//$dato = $dini[0][id];

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
        $Lote = $informe['lote'],
        $AreaAnalisis = $informe['des_area_analisis'],
        $Conclusion = $informe["conclusion"],
        $Estado = $informe["estado"],
        $nombreAnalista = $informe["nombreAnalista"],
        $perfilAnalista = $informe["PerfilAnalista"],
        $idPerfil = $perfil,
        $anofab = substr($FechaFabri, 0, 4),
        $anoven = substr($FechaVence, 0, 4),
        $codigo1 = $informe["codigo"],
        $estabilidad = $informe["estabilidad"],
        $idFormaFarmaceutica = $informe["idFormaFarmaceutica"]
    );
}

if ($anofab == '1900') {
    $FechaFabri1 = 'No Especificada';
}
if ($anoven == '1900') {
    $FechaVence1 = 'No Especificada';
}

$metodosTraza = $modelReporte->getMetodo($dato);
$especificacionesTraza = $modelReporte->getEspecificacion($dato);

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

        $this->Cell(80, 20, utf8_decode('INFORME DE ANÁLISIS FISICOQUIMICO'), 1, 0, 'C');
//     $this->Ln();
//     $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('F-095-(AD-009)'), 1, 0, 'C');

        $this->SetXY(130, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('03'), 1, 0, 'C');
        $this->SetXY(130, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('08-02-17'), 1, 0, 'C');
        $this->SetXY(130, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(30, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
        // To be implemented in your own inherited class

        if ($GLOBALS['perfil'] == "false") {
            $this->SetFont('Arial', 'B', 14);
            $this->SetTextColor(255, 192, 203);
            for ($i = 0; $i < 1000; $i += 30) {
                $this->RotatedText(0, $i, 'I N F O R M E  P A R C I A L   C O P I A   N O   C O N T R O L A D A    I N F O R M E  P A R C I A L C O P I A   N O   C O N T R O L A D A', 45);
            }
        }
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->RoundedRect(130, 33, 60, 7, 2, 'S', '1234');
$pdf->Cell(120, 7, utf8_decode(''), 0, 0, 'L');
$pdf->Cell(35, 7, utf8_decode('Radicación No. '), 0, 0, 'L');
$pdf->SetTextColor(0, 128, 255); //Azul
$pdf->Cell(25, 7, $codigolqf, 0, 0, 'L');
$pdf->SetTextColor(0, 0, 0); //NEGRO
$pdf->Ln(-3);

$cantletras = strlen($Producto);
if ($cantletras > 58) {
    $pdf->SetFont('Arial', 'B', 8);
} else {
    $pdf->SetFont('Arial', 'B', 10);
}
$pdf->Cell(120, 7, utf8_decode($Producto), 0, 0, 'C');

$pdf->Ln(6);
$pdf->Cell(120, 7, 'LOTE:' . utf8_decode($Lote), 0, 0, 'C');
$pdf->Ln(7);
if ($estabilidad !== 'N/A' && $estabilidad !== NULL) {
    $pdf->Cell(120, 5, utf8_decode('Estabilidad: ' . $estabilidad), 0, 0, 'C');
    $pdf->Ln(7);
}

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 6, 'Cliente:', LTB, 0, 'L');
$pdf->Cell(72, 6, substr(utf8_decode($Cliente), 0, 34), TBR, 0, 'L');
$pdf->Cell(18, 6, utf8_decode('Dirección: '), LTB, 0, 'L');
$pdf->Cell(72, 6, utf8_decode($Direccion), TBR, 0, 'L');
$pdf->Ln(6);
$pdf->Cell(18, 6, ('Propietario:'), LTB, 0, 'L');
$pdf->Cell(72, 6, utf8_decode($Procedencia), TBR, 0, 'L');
$pdf->Cell(18, 6, utf8_decode('Teléfono : '), LTB, 0, 'L');
$pdf->Cell(72, 6, utf8_decode($Telefono), TBR, 0, 'L');
$pdf->Ln(7);
$pdf->cY = $pdf->GetY();
if ($Forma == 'Materia Prima') {
    $heg = $pdf->NbLines(60, $Forma);
} else {
    $heg = $pdf->NbLines(60, $Forma . '  (' . $Envase . ')');
}

$pdf->MultiCell(31, 6 * $heg, utf8_decode('Tipo de Muestra:'), LT, 'T');
if ($Forma == 'Materia Prima') {
    $pdf->SetXY($pdf->GetX() + 31, $pdf->cY);
    $pdf->MultiCell(59, 6, utf8_decode($Forma), TR, 'L');
} else {
    $pdf->SetXY($pdf->GetX() + 31, $pdf->cY);
    $pdf->MultiCell(59, 6, utf8_decode($Forma . '  (' . $Envase . ')'), TR, 'L');
}
$tempy = ($pdf->GetY() - $pdf->cY) / 6;
$pdf->SetXY($pdf->GetX() + 90, $pdf->cY);
$pdf->Cell(32, 6 * $heg, utf8_decode('Presentación:'), LT, 0, 'L');
$pdf->SetXY($pdf->GetX(), $pdf->cY);
$pdf->Cell(58, 6 * $heg, utf8_decode(substr($Empaque, 0, 30)), TR, 0, 'L');

while ($tempy !== 0) {
    $pdf->Ln(6);
    $tempy = $tempy - 1;
}

$pdf->cY = $pdf->GetY();
$hegFab = $pdf->NbLines(58, $Fabricante);
if ($Forma == 'Materia Prima') {
    $pdf->Cell(31, 6 * $hegFab, utf8_decode('Cantidad: '), LTB, 0, 'L');
} else {
    $pdf->Cell(31, 6 * $hegFab, utf8_decode('Tamaño del lote: '), LTB, 0, 'L');
}


if ($CantidadLote == "N/A") {
    $pdf->Cell(59, 6 * $hegFab, "No especificado", TBR, 0, 'L');
} else {
    $pdf->Cell(59, 6 * $hegFab, $CantidadLote, TBR, 0, 'L');
}

if ($Forma == 'Materia Prima') {
    $pdf->Cell(32, 6 * $hegFab, utf8_decode('Proveedor: '), LTB, 0, 'L');
} else {
    $pdf->Cell(32, 6 * $hegFab, utf8_decode('Fabricante/O.P.: '), LTB, 0, 'L');
}
$pdf->Cell(58, 6, utf8_decode($Fabricante), TBR, 0, 'L');
$pdf->Ln(6);
$pdf->Cell(31, 6, utf8_decode('Fecha de fabricación:'), LTB, 0, 'L');
$pdf->Cell(59, 6, $FechaFabri1, TBR, 0, 'L');

if ($Forma == 'Materia Prima') {
    $pdf->Cell(32, 6, utf8_decode('Fecha de Venc./Rean:'), LTB, 0, 'L');
} else {
    $pdf->Cell(32, 6, utf8_decode('Fecha de vencimiento:'), LTB, 0, 'L');
}



$pdf->Cell(58, 6, $FechaVence1, TBR, 0, 'L');
$pdf->Ln(7);
$pdf->Cell(60, 6, utf8_decode('Fecha de llegada: ') . ($FechaLlegada1), 1, 0, 'L');
$pdf->Cell(60, 6, utf8_decode('Fecha de análisis : ') . ($inicioAnalisis), 1, 0, 'L');
$pdf->Cell(60, 6, utf8_decode('Fecha de aprobación : ') . ($finalizacionAnalisis), 1, 0, 'L');
$pdf->Ln(7);

$arr = explode('ESP:', $codigo1);

if ($arr[1] != null) {
    $codigo = $arr[1];
} else {
    $codigo = $arr[0];
}
//$posicion_coincidencia = strrpos($codigo1, 'ESP_:');
$metodoTraza = implode($metodosTraza);
$especificacionTraza = implode($especificacionesTraza);

$pdf->Cell(180, 6, utf8_decode('Método: ') . utf8_decode($metodoTraza), 1, 0, 'L');
$pdf->Ln(5);

$pdf->Cell(180, 6, utf8_decode('Especificaciones: ') . utf8_decode($especificacionTraza), 1, 0, 'L');
$pdf->Ln(5);

$pdf->SetXY(10, 101);
$pdf->SetFont('Arial', 'B', 10);
$tit1 = 50;
$tit2 = 65;
$tit3 = 65;

while ((($heg + $hegFab) - 2) !== 0) {
    $pdf->Ln();
    $heg--;
}
$pdf->Cell($tit1, -5, utf8_decode('ANÁLISIS') . $letrascol, 1, 0, 'C');
$pdf->Cell($tit2, -5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
$pdf->Cell($tit3, -5, 'RESULTADO', 1, 0, 'C');
$pdf->SetFont('Arial', '', 9);
//$pdf->Ln();
/////////////////////////////////////////
/////////INCIO LISTADO DE ENSAYOS////////////
///////////////////////////////////////////////
$data1 = $modelReporte->VerResultadoMuestra($dato);
foreach ($data1 as $informe1) {
    $Especificacion = $informe1["especificacion"];
    //$pdf->SetFont('Arial','I',9);
    $Descripcion = $informe1["descripcion"];
    //$pdf->SetFont('Arial','B',9);
    // $Cepas = $informe1["cepas"];
    $Aprobado = $informe1["aprobado"];
    $Resultado1 = $informe1["resultado"];

    $pdf->SetX(10);
    $colum1 = 50;
    $colum2 = 55;
    $colum3 = 65;
    $pdf->SetWidths(array($colum1, $colum2, $colum3));

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
    $pdf->SetAligns(array('L', 'L', 'L'));
    $pdf->Row2(array(utf8_decode($Descripcion), utf8_decode($Especificacion), utf8_decode($Resultado)));
}
$pdf->Ln(3);
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
$pdf->Cell(180, 4, utf8_decode('Carmen Guayambuco Q. - Q.F'), 0, 0, 'C');
$pdf->Ln(4);
$pdf->Cell(180, 4, utf8_decode('Directora Técnica'), 0, 0, 'C');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'I', 8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(180, 7, utf8_decode('Cra. 60 # 94 B - 23 Teléfonos: 6910852-6910853-2569310  Cel 313 2611280  Bogotá D.C'), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(180, 7, utf8_decode('Email: lqf@lqfcalidad.com   WEB: www.lqfcalidad.com '), 0, 0, 'C');
$pdf->Output();
?>