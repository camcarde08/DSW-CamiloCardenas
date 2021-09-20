<?php

require('../../fpdf.php');
require '../../../model/DbClass.php';
require '../../../controller/UtilsController.php';
require_once '../../rotation.php';
require_once '../AuxiliarInformes.php';
require_once './AuxInformeAnalisisEstabilidad.php';

class PDF extends FPDF {

    public $muestra;
    public $auxiliarGeneral;
    public $auxEst;

    function RotatedText($x, $y, $txt, $angle) {
        //Text rotated around its origin
        $this->Rotate($angle, $x, $y);
        $this->Text($x, $y, $txt);
        $this->Rotate(0);
    }

    function Header() {
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../../views/images/logoEmpresa.png', 20, 12, 19);
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(80, 20, utf8_decode('INFORME DE ANÁLISIS FISICOQUÍMICO'), 1, 0, 'C');

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

        $this->SetFont('Arial', 'B', 8);
        $this->RoundedRect(130, 33, 60, 7, 2, 'S', '1234');
        $this->Cell(120, 7, utf8_decode(''), 0, 0, 'L');
        $this->Cell(35, 7, utf8_decode('Radicación No. '), 0, 0, 'L');
        $this->SetTextColor(0, 128, 255); //Azul
        $this->Cell(25, 7, 'EST-' . substr($this->auxEst->numeroCliente($this->auxEst->subMuestra->muestra->tipoMuestra->prefijo
                                , $this->auxEst->subMuestra->muestra->custom_id), 6, 4) . '-'
                . (substr($this->auxEst->subMuestra->muestra->tipoMuestra->prefijo, 3, 4)), 0, 0, 'L');
        $this->SetTextColor(0, 0, 0); //NEGRO
        $this->Ln(-3);
//        if ((new DateTime($this->auxEst->subMuestra->muestra->fecha_llegada))->format('y') == '16' || (new DateTime($this->auxEst->subMuestra->muestra->fecha_llegada))->format('y') == '17') {
//            $this->Cell(25, 7, 'EST-' . substr($this->auxEst->numeroCliente($this->auxEst->subMuestra->muestra->tipoMuestra->prefijo
//                                    , $this->auxEst->subMuestra->muestra->custom_id), 6, 4) . '-'
//                    . ('18'), 0, 0, 'L');
//            $this->SetTextColor(0, 0, 0); //NEGRO
//            $this->Ln(-3);
//        } else {
//            $this->Cell(25, 7, 'EST-' . substr($this->auxEst->numeroCliente($this->auxEst->subMuestra->muestra->tipoMuestra->prefijo
//                                    , $this->auxEst->subMuestra->muestra->custom_id), 6, 4) . '-'
//                    . (new DateTime($this->auxEst->subMuestra->muestra->fecha_llegada))->format('y'), 0, 0, 'L');
//            $this->SetTextColor(0, 0, 0); //NEGRO
//            $this->Ln(-3);
//        }

        $cantletras = strlen(($this->auxEst->subMuestra->muestra->producto->nombre . " "
                . $this->auxEst->subMuestra->duracion->label . " "
                . $this->auxEst->subMuestra->temperatura->label));
        if ($cantletras > 58) {
            $this->SetFont('Arial', 'B', 8);
        } else {
            $this->SetFont('Arial', 'B', 10);
        }
        $this->MultiCell(116, 5, utf8_decode(($this->auxEst->subMuestra->muestra->producto->nombre)), 0, 'C');

        $this->Ln(1);
        $this->Cell(120, 5, utf8_decode(('Estabilidad: '
                        . $this->auxEst->subMuestra->muestra->tipoEstabilidad->tipo_estabilidad . " "
                        . $this->auxEst->subMuestra->duracion->label . " "
                        . $this->auxEst->subMuestra->temperatura->label)), 0, 0, 'C');
        $this->Ln(1);
        $this->Cell(120, 15, 'LOTE:' . utf8_decode($this->auxEst->subMuestra->muestra->numero_lote), 0, 0, 'C');
        $this->Ln();

        if ($_POST['perfil'] == "false") {
            $this->SetFont('Arial', 'B', 35);
            $this->SetTextColor(255, 192, 203);
            $this->RotatedText(35, 200, 'C O P I A   C O N T R O L A D A', 45);
        }
    }

    function resultadoAnalisis() {
        $this->SetFont('Arial', '', 9);
        $this->Cell(18, 6, 'Cliente:', LTB, 0, 'L');
        $this->Cell(72, 6, substr(utf8_decode($this->auxEst->subMuestra->muestra->tercero->nombre), 0, 34), TBR, 0, 'L');
        $this->Cell(18, 6, utf8_decode('Dirección: '), LTB, 0, 'L');
        $this->Cell(72, 6, utf8_decode($this->auxEst->subMuestra->muestra->tercero->direccion), TBR, 0, 'L');
        $this->Ln(6);
        $this->Cell(18, 6, ('Propietario:'), LTB, 0, 'L');
        $this->Cell(72, 6, utf8_decode($this->auxEst->subMuestra->muestra->procedencia), TBR, 0, 'L');
        $this->Cell(18, 6, utf8_decode('Teléfono : '), LTB, 0, 'L');
        $this->Cell(72, 6, utf8_decode($this->auxEst->subMuestra->muestra->tercero->telefono1), TBR, 0, 'L');
        $this->Ln(7);
        $this->cY = $this->GetY();
        $forma = $this->auxEst->subMuestra->muestra->producto->formaFarmaceutica->descripcion;
        if ($forma == 'Materia Prima') {
            $heg = $this->NbLines(61, $forma);
        } else {
            $heg = $this->NbLines(61, $forma . '  (' . $this->auxEst->subMuestra->muestra->envase->descripcion . ')');
        }

        $this->MultiCell(31, 6 * $heg, utf8_decode('Tipo de Muestra:'), LT, 'T');
        if ($forma == 'Materia Prima') {
            $this->SetXY($this->GetX() + 31, $this->cY);
            $this->MultiCell(59, 6, utf8_decode($forma), TR, 'L');
        } else {
            $this->SetXY($this->GetX() + 31, $this->cY);
            $this->MultiCell(59, 6, utf8_decode($forma . '  (' . $this->auxEst->subMuestra->muestra->envase->descripcion . ')'), TR, 'L');
        }
        $tempy = ($this->GetY() - $this->cY) / 6;
        $this->SetXY($this->GetX() + 90, $this->cY);
        $this->Cell(32, 6 * $heg, utf8_decode('Presentación:'), LT, 0, 'L');
        $this->SetXY($this->GetX(), $this->cY);
        $this->Cell(58, 6 * $heg, utf8_decode(substr($this->auxEst->subMuestra->muestra->empaque->descripcion, 0, 30)), TR, 0, 'L');

        while ($tempy !== 0) {
            $this->Ln(6);
            $tempy = $tempy - 1;
        }

        $this->cY = $this->GetY();
        $hegFab = $this->NbLines(58, $this->auxEst->subMuestra->muestra->fabricante);
        if ($forma == 'Materia Prima') {
            $this->Cell(31, 6 * $hegFab, utf8_decode('Cantidad: '), LTB, 0, 'L');
        } else {
            $this->Cell(31, 6 * $hegFab, utf8_decode('Tamaño del lote: '), LTB, 0, 'L');
        }


        if ($this->auxEst->subMuestra->muestra->tamano_lote == "N/A") {
            $this->Cell(59, 6 * $hegFab, "No especificado", TBR, 0, 'L');
        } else {
            $this->Cell(59, 6 * $hegFab, $this->auxEst->subMuestra->muestra->tamano_lote, TBR, 0, 'L');
        }

        if ($forma == 'Materia Prima') {
            $this->Cell(32, 6 * $hegFab, utf8_decode('Proveedor: '), LTB, 0, 'L');
        } else {
            $this->Cell(32, 6 * $hegFab, utf8_decode('Fabricante/O.P.: '), LTB, 0, 'L');
        }
        $this->Cell(58, 6, utf8_decode($this->auxEst->subMuestra->muestra->fabricante), TBR, 0, 'L');
        $this->Ln(6);

        $fechaFabricacion = $this->auxEst->subMuestra->muestra->fecha_fabricacion;
        if ($fechaFabricacion !== null) {
            $fechaFabricacion = new DateTime($fechaFabricacion);
            if ($fechaFabricacion->format('Y') == '1900') {
                $fechaFabricacion = 'No especificada';
            } else {
                $fechaFabricacion = $fechaFabricacion->format('m-Y');
            }
        }

        $fechaVencimiento = $this->auxEst->subMuestra->muestra->fecha_vencimiento;
        if ($fechaVencimiento !== null) {
            $fechaVencimiento = new DateTime($fechaVencimiento);
            if ($fechaVencimiento->format('Y') == '1900') {
                $fechaVencimiento = 'No especificada';
            } else {
                $fechaVencimiento = $fechaVencimiento->format('m-Y');
            }
        }

        $this->Cell(31, 6, utf8_decode('Fecha de fabricación:'), LTB, 0, 'L');
        $this->Cell(59, 6, $fechaFabricacion, TBR, 0, 'L');

        if ($forma == 'Materia Prima') {
            $this->Cell(32, 6, utf8_decode('Fecha de Venc./Rean:'), LTB, 0, 'L');
        } else {
            $this->Cell(32, 6, utf8_decode('Fecha de vencimiento:'), LTB, 0, 'L');
        }

        $fechaLlegada = $this->auxEst->subMuestra->muestra->fecha_llegada !== null ? (new DateTime($this->auxEst->subMuestra->muestra->fecha_llegada))->format('d-m-Y') : null;

        $fechaAprobacion = $this->auxEst->subMuestra->fecha_conclusion !== null ? (new DateTime($this->auxEst->subMuestra->fecha_conclusion))->format('d-m-Y') : null;

        $fechaAnalisis = $this->auxEst->subMuestra->fecha_analisis_ensayo ?
                $this->auxEst->subMuestra->fecha_analisis_ensayo->format('d-m-Y') : null;

        $this->Cell(58, 6, $fechaVencimiento, TBR, 0, 'L');
        $this->Ln(7);
        $this->Cell(60, 6, utf8_decode('Fecha de llegada: ') . ($fechaLlegada), 1, 0, 'L');
        $this->Cell(60, 6, utf8_decode('Fecha de análisis : ') . ($fechaAnalisis), 1, 0, 'L');
        $this->Cell(60, 6, utf8_decode('Fecha de aprobación : ') . ($fechaAprobacion), 1, 0, 'L');
        $this->Ln(7);

        $codigo = explode('ESP:', $this->auxEst->subMuestra->ensayosSubMuestra[0]->paquete->codigo);

        $this->Cell(180, 6, utf8_decode('Especificaciones: ') . utf8_decode($codigo[1]), 1, 0, 'L');
        $this->Ln(7);


        $this->SetXY(10, 99);
        $this->SetFont('Arial', 'B', 10);

        while ((($heg + $hegFab) - 2) !== 0) {
            $this->Ln();
            $heg--;
        }

        $this->resultadosEnsayos();
    }

    function resultadosEnsayos() {
        $this->Ln(7);
        $letrascol = $GLOBALS['letrascol'];
        $tit1 = 40;
        $tit2 = 55;
        $tit3 = 60;
        $tit4 = 25;
        $this->Cell($tit1, -5, utf8_decode('ANÁLISIS') . $letrascol, 1, 0, 'C');
        $this->Cell($tit2, -5, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
        $this->Cell($tit3, -5, 'RESULTADO', 1, 0, 'C');
        $this->Cell($tit4, -5, utf8_decode('MÉTODO'), 1, 0, 'C');
        $this->SetFont('Arial', '', 9);


        foreach ($this->auxEst->getEnsayosSubMuestraOrdenados() as $ensayosSubMuestra) {
            $Especificacion = $ensayosSubMuestra["especificacion"];
            //$this->SetFont('Arial','I',9);
            $Descripcion = $ensayosSubMuestra["descripcion_especifica"];
            //$this->SetFont('Arial','B',9);
            $Metodo = $ensayosSubMuestra["metodo"]["descripcion"];
            $Resultado = $ensayosSubMuestra["resultado"];

            $this->SetX(10);
            $colum1 = 40;
            $colum2 = 55;
            $colum3 = 60;
            $colum4 = 25;
            $this->SetWidths(array($colum1, $colum2, $colum3, $colum4));

            $this->SetAligns(array('L', 'L', 'L', 'L'));
            $this->Row2(array(utf8_decode($Descripcion), utf8_decode($Especificacion), utf8_decode($Resultado), utf8_decode($Metodo)));
        }


        $this->Ln(3);
    }

    function finalInforme() {

        $this->SetFont('Arial', '', 7);
        $this->MultiCell(180, 4, (utf8_decode($this->auxEst->subMuestra->conclusion)));


        $fechaPruebaComparacion = new DateTime("2018-04-23");
        if ($this->auxEst->subMuestra->fecha_conclusion == null) {
            $fechaAprobacionComparacion = null;
        } else {
            $fechaAprobacionComparacion = new DateTime($this->auxEst->subMuestra->fecha_conclusion);
        }
        
        $fechaFirmaElectronica = $this->auxEst->subMuestra->fecha_conclusion !== null ? (new DateTime($this->auxEst->subMuestra->fecha_conclusion))->format('d-m-Y') : null;

        $indice = $this->GetY();
        if ($indice > 231) {
            $this->AddPage();
        }

        if ($fechaAprobacionComparacion != null) {
            if ($fechaPruebaComparacion > $fechaAprobacionComparacion) {
                $this->SetFont('Arial', 'B', 9);
                $this->Ln(5);
                $this->Cell(55, 4, utf8_decode(' '), 0, 0, 'C');
                $this->Cell(90, 4, utf8_decode('APROBADO POR'), 0, 0, 'L');
                $this->Ln(10);
                $indice = $this->GetY();
                $this->Image('../../../views/images/BPL.jpg', 40, $indice - 8, 19);
                $this->Ln(2);
                $this->Cell(180, 4, utf8_decode('________________________________________'), 0, 0, 'C');
                $this->Ln(4);
                $this->Cell(180, 4, utf8_decode('Carmen Guayambuco Q. - Q.F'), 0, 0, 'C');
                $this->Ln(4);
                $this->Cell(180, 4, utf8_decode('Directora Técnica'), 0, 0, 'C');
                $this->Ln(8);
                $this->SetFont('Arial', 'I', 8);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(180, 7, utf8_decode('Carrera 58 No. 97-36 Segundo Piso (Bogotá - Colombia) Teléfonos: 7185945 Cel 3166141444  Bogotá D.C'), 0, 0, 'C');
                $this->Ln(5);
                $this->Cell(180, 7, utf8_decode('Email: gerencia@soulsystem.co   WEB: www.soulsystem.co '), 0, 0, 'C');
            } else {
                $this->SetFont('Arial', 'B', 9);
                $this->Ln(5);
                $this->Cell(55, 4, utf8_decode(' '), 0, 0, 'C');
                $this->Cell(90, 4, utf8_decode('APROBADO POR'), 0, 0, 'L');
                $this->Ln(10);
                $indice = $this->GetY();
                $this->Image('../../../views/images/BPL.jpg', 40, $indice - 8, 19);
                $this->Ln(2);
                $this->SetFont('Arial', '', 9);
                $this->Cell(180, 4, utf8_decode($this->auxEst->subMuestra->usuarioAprobacion->nombre), 0, 0, 'C');
                $this->Ln(4);
                $this->Cell(180, 4, utf8_decode($fechaFirmaElectronica), 0, 0, 'C');
                $this->Ln(4);
                $this->Cell(180, 4, utf8_decode('________________________________________'), 0, 0, 'C');
                $this->Ln(4);
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(180, 4, utf8_decode($this->auxEst->subMuestra->usuarioAprobacion->perfil->nombre), 0, 0, 'C');
                $this->Ln(8);
                $this->SetFont('Arial', 'I', 8);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell(180, 7, utf8_decode('*Este documento está firmado electrónicamente según parámetros establecidos por la FDA en la norma CFR21 parte 11'), 0, 0, 'C');
                $this->Ln(5);
                $this->Cell(180, 7, utf8_decode('Carrera 58 No. 97-36 Segundo Piso (Bogotá - Colombia) Teléfonos: 7185945 Cel 3166141444  Bogotá D.C'), 0, 0, 'C');
                $this->Ln(5);
                $this->Cell(180, 7, utf8_decode('Email: gerencia@soulsystem.co   WEB: www.soulsystem.co '), 0, 0, 'C');
            }
        } else {
            $this->SetFont('Arial', 'B', 9);
            $this->Ln(5);
            $this->Cell(55, 4, utf8_decode(' '), 0, 0, 'C');
            $this->Cell(90, 4, utf8_decode('APROBADO POR'), 0, 0, 'L');
            $this->Ln(12);
            $indice = $this->GetY();
            $this->Image('../../../views/images/BPL.jpg', 40, $indice - 14, 19);
            $this->Cell(180, 4, utf8_decode('________________________________________'), 0, 0, 'C');
            $this->Ln(4);
            $this->Cell(180, 4, utf8_decode(''), 0, 0, 'C');
            $this->Ln(4);
            $this->Cell(180, 4, utf8_decode(''), 0, 0, 'C');
            $this->Ln(8);
            $this->SetFont('Arial', 'I', 8);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(180, 7, utf8_decode('Carrera 58 No. 97-36 Segundo Piso (Bogotá - Colombia) Teléfonos: 7185945 Cel 3166141444  Bogotá D.C'), 0, 0, 'C');
            $this->Ln(5);
            $this->Cell(180, 7, utf8_decode('Email: gerencia@soulsystem.co   WEB: www.soulsystem.co '), 0, 0, 'C');
        }
    }

}

$pdf = new PDF();
$pdf->auxiliarGeneral = new AuxiliarInformes();
$pdf->auxEst = new AuxInformeAnalisisEstabilidad($_POST["idSubMuestra"], $_POST["idTemperatura"]);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->resultadoAnalisis();
$pdf->finalInforme();
$pdf->Output();
?>