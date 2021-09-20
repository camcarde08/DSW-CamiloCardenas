<?php

require('../../fpdf.php');
require './AuxInformeAnalista.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF {

    function Header() {

        //Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        define('ROOTPATH', __DIR__ . "/../../../");
        $this->Image(ROOTPATH . '/views/images/logoEmpresa.png', 20, 12, 19);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(80, 20, utf8_decode('INFORME ANALISTA'), 1, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(35, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(32, 5, utf8_decode('F-095-(AD-009)'), 1, 0, 'C');
        $this->SetXY(130, 15);
        $this->Cell(35, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(32, 5, utf8_decode('03'), 1, 0, 'C');
        $this->SetXY(130, 20);
        $this->Cell(35, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(32, 5, utf8_decode('08-02-17'), 1, 0, 'C');
        $this->SetXY(130, 25);
        $this->Cell(35, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(32, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
    }

    function tablaCabeceraInicial() {
        $this->auxiliarGeneral = new AuxiliarInformes();
        $this->aux = new AuxInformeAnalista();

        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];
        $idAnalista = $_POST["idAnalista"];
        $estadoEnsayo = $_POST["estadoEnsayo"];

        $numeroMuestras = $this->aux->getInfoNumeroMuestras($fechaInicio, $fechaFin, $idAnalista);
        if ($estadoEnsayo == '1') {
            $numeroEnsayosMuestra = $this->aux->getInfoNumeroMuestrasEnsayosRealizados($fechaInicio, $fechaFin, $idAnalista);
        } else {
            $numeroEnsayosMuestra = $this->aux->getInfoNumeroMuestrasEnsayosSinRealizar($fechaInicio, $fechaFin, $idAnalista);
        }
        $infoMuestras = $this->aux->getInfoMuestras($fechaInicio, $fechaFin, $idAnalista);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 4, utf8_decode('Cantidad de muestras: '), 0, 0, 'R');
        $this->SetFont('Arial', '', 8);
        $this->Cell(70, 4, utf8_decode('' . $numeroMuestras[0]->muestras), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(50, 4, utf8_decode('Cantidad de ensayos muestra: '), 0, 0, 'R');
        $this->SetFont('Arial', '', 8);
        $this->Cell(40, 4, utf8_decode('' . $numeroEnsayosMuestra[0]->ensayosMuestra), 0, 0, 'L');
        $this->Ln(8);

        foreach ($infoMuestras as $muestra) {
            $idMuestra = $muestra->id;
            $nombreMuestra = $muestra->nombreMuestra;
            $fechaLlegada = $muestra->fecha_llegada !== NULL ? (new DateTime($muestra->fecha_llegada))->format('Y-m-d') : NULL;
            $fechaConclusion = $muestra->fecha_conclusion !== NULL ? (new DateTime($muestra->fecha_conclusion))->format('Y-m-d') : NULL;
            $cliente = $muestra->cliente;
            $productoMuestra = $muestra->productoMuestra;
            $loteMuestra = $muestra->loteMuestra;

            $this->cabeceraDeCadaMuestra($nombreMuestra, $fechaLlegada, $fechaConclusion, $cliente, $productoMuestra, $loteMuestra);

            if ($estadoEnsayo == '1') {
                $infoEnsayos = $this->aux->getInfoEnsayosRealizados($idMuestra, $idAnalista);
            } else {
                $infoEnsayos = $this->aux->getInfoEnsayosSinRealizar($idMuestra, $idAnalista);
            }

            $this->tablaEnsayos($infoEnsayos, $fechaConclusion);
        }
    }

    function cabeceraDeCadaMuestra($nombreMuestra, $fechaLlegada, $fechaConclusion, $cliente, $productoMuestra, $loteMuestra) {

        $fechaLlegadaConteo = new DateTime($fechaLlegada);
        $fechaConclusionConteo = new DateTime($fechaConclusion);
        if ($fechaConclusion == null) {
            $fechaConclusionConteo = new DateTime();
            $interval = date_diff($fechaLlegadaConteo, $fechaConclusionConteo);
            $diasTranscurridos = $interval->format('%a días');
        } else {
            $interval = date_diff($fechaLlegadaConteo, $fechaConclusionConteo);
            $diasTranscurridos = $interval->format('%a días');
        }

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 6, utf8_decode('Muestra: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 6, utf8_decode($nombreMuestra), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 6, utf8_decode('Cliente: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(67, 6, utf8_decode($cliente), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 6, utf8_decode('Lote: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 6, utf8_decode($loteMuestra), 1, 0, 'L');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 6, utf8_decode('Producto: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(162, 6, utf8_decode($productoMuestra), 1, 0, 'L');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(37, 6, utf8_decode('Fecha llegada: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(26, 6, utf8_decode($fechaLlegada), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(36, 6, utf8_decode('Fecha conclusión: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(26, 6, utf8_decode($fechaConclusion), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(36, 6, utf8_decode('Dias transcurridos: '), 1, 0, 'L');
        $this->SetFont('Arial', '', 9);
        $this->Cell(26, 6, utf8_decode($diasTranscurridos), 1, 0, 'L');
        $this->Ln(8);
    }

    function tablaEnsayos($infoEnsayos, $fechaConclusion) {

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 4, utf8_decode('ENSAYO'), 1, 0, 'C');
        $this->Cell(30, 4, utf8_decode('ANALISTA'), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode('F. PROGRAMACIÓN'), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode('ESTADO'), 1, 0, 'C');
        $this->Cell(22, 4, utf8_decode('F. ANÁLISIS'), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode('F. TRASNCRIPCIÓN'), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode('F. APROBADO'), 1, 0, 'C');
        $this->Cell(10, 4, utf8_decode('RFE'), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 7);
        $colum1 = 25;
        $colum2 = 30;
        $colum3 = 25;
        $colum4 = 25;
        $colum5 = 22;
        $colum6 = 25;
        $colum7 = 25;
        $colum8 = 10;
        $this->SetWidths(array($colum1, $colum2, $colum3, $colum4, $colum5, $colum6, $colum7, $colum8));
        foreach ($infoEnsayos as $ensayo) {
            $ensayoNombre = $ensayo->ensayo;
            $analista = $ensayo->analista;
            $fechaProgramacion = $ensayo->fecha_programada !== NULL ? (new DateTime($ensayo->fecha_programada))->format('Y-m-d') : NULL;
            $estado = $ensayo->estado;
            if ($ensayo->RFE == 1) {
                $rfe = 'X';
            } else {
                $rfe = '--';
            }
            $fechaAnalisis = $ensayo->fecha_analisis !== NULL ? (new DateTime($ensayo->fecha_analisis))->format('Y-m-d') : NULL;
            $fechaRegistro = $ensayo->fecha_registro !== NULL ? (new DateTime($ensayo->fecha_registro))->format('Y-m-d') : NULL;
            $fechaAprobacion = $fechaConclusion;

            $this->SetX(10);

            $this->SetAligns(array('C', 'C', 'C', 'C'));
            $this->Row2(array(utf8_decode($ensayoNombre), utf8_decode($analista)
                , utf8_decode($fechaProgramacion), utf8_decode($estado)
                , utf8_decode($fechaAnalisis), utf8_decode($fechaRegistro)
                , utf8_decode($fechaAprobacion), utf8_decode($rfe)));
        }
        $this->Ln(8);
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->tablaCabeceraInicial();
$pdf->Output();
?>