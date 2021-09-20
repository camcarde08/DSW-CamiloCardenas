<?php

require('../../fpdf.php');
require './AuxInformeEstadistico.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF {

    function Header() {

//Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        define('ROOTPATH', __DIR__ . "/../../../");
        $this->Image(ROOTPATH . '/views/images/logoEmpresa.png', 20, 12, 19);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(80, 20, utf8_decode('INFORME ESTADÍSTICO MUESTRA'), 1, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(35, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(32, 5, utf8_decode(''), 1, 0, 'C');
        $this->SetXY(130, 15);
        $this->Cell(35, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(32, 5, utf8_decode(''), 1, 0, 'C');
        $this->SetXY(130, 20);
        $this->Cell(35, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(32, 5, utf8_decode(''), 1, 0, 'C');
        $this->SetXY(130, 25);
        $this->Cell(35, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(32, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
    }

    function tablaCabeceraInicial() {
        $this->auxiliarGeneral = new AuxiliarInformes();
        $this->aux = new AuxInformeEstadistico();

        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];

        $data = $this->aux->getEstadisticasMuestra($fechaInicio, $fechaFin);

        $this->Cell(42, 6, utf8_decode(''), 0, 0, 'C');
        $this->Cell(145, 6, utf8_decode('Muestras pendientes hasta el dia de ' . (new DateTime())->format('Y-m-d')), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(42, 6, utf8_decode('Muestras Recibidas'), 1, 0, 'C');
        $this->Cell(145, 6, utf8_decode($data['auxiliarConteoRecibidas']), 1, 0, 'C');
        $this->Ln(6);

        $this->Cell(42, 6, utf8_decode('Muestras Para Programación'), 1, 0, 'C');
        $flag = true;
        foreach ($data['auxiliarConteo'] as $keyConteoProgramadas => $valueConteoProgramadas) {
            if ($valueConteoProgramadas["estado"] == 2) {
                $this->Cell(145, 6, utf8_decode($valueConteoProgramadas["cantidad"]), 1, 0, 'C');
                $flag = false;
            }
        }
        if ($flag == true) {
            $this->Cell(145, 6, utf8_decode("0"), 1, 0, 'C');
        }
        $this->Ln(6);

        $this->Cell(42, 6, utf8_decode('Muestras Para Analizar'), 1, 0, 'C');
        $flag = true;
        foreach ($data['auxiliarConteo'] as $keyConteoAnalizadas => $valueConteoAnalizadas) {
            if ($valueConteoAnalizadas["estado"] == 3) {
                $this->Cell(145, 6, utf8_decode($valueConteoAnalizadas["cantidad"]), 1, 0, 'C');
                $flag = false;
            }
        }
        if ($flag == true) {
            $this->Cell(145, 6, utf8_decode("0"), 1, 0, 'C');
        }
        $this->Ln(6);

        $this->Cell(42, 6, utf8_decode('Muestras Para Trasncripción'), 1, 0, 'C');
        $flag = true;
        foreach ($data['auxiliarConteo'] as $keyConteoTranscritas => $valueConteoTranscritas) {
            if ($valueConteoTranscritas["estado"] == 13) {
                $this->Cell(145, 6, utf8_decode($valueConteoTranscritas["cantidad"]), 1, 0, 'C');
                $flag = false;
            }
        }
        if ($flag == true) {
            $this->Cell(145, 6, utf8_decode("0"), 1, 0, 'C');
        }
        $this->Ln(6);

        $this->Cell(42, 6, utf8_decode('Muestras Para revisión'), 1, 0, 'C');
        $flag = true;
        foreach ($data['auxiliarConteo'] as $keyConteoRevisadas => $valueConteoRevisadas) {
            if ($valueConteoRevisadas["estado"] == 4) {
                $this->Cell(145, 6, utf8_decode($valueConteoRevisadas["cantidad"]), 1, 0, 'C');
                $flag = false;
            }
        }
        if ($flag == true) {
            $this->Cell(145, 6, utf8_decode("0"), 1, 0, 'C');
        }
        $this->Ln(6);

        $this->Cell(42, 6, utf8_decode('Muestras Para Aprobar'), 1, 0, 'C');
        $flag = true;
        foreach ($data['auxiliarConteo'] as $keyConteoAprobadas => $valueConteoAprobadas) {
            if ($valueConteoAprobadas["estado"] == 16) {
                $this->Cell(145, 6, utf8_decode($valueConteoAprobadas["cantidad"]), 1, 0, 'C');
                $flag = false;
            }
        }
        if ($flag == true) {
            $this->Cell(145, 6, utf8_decode("0"), 1, 0, 'C');
        }
        $this->Ln(6);

        $this->Cell(42, 6, utf8_decode('Muestras Reprogramadas'), 1, 0, 'C');
        $flag = true;
        foreach ($data['auxiliarConteo'] as $keyConteoReprogramadas => $valueConteoReprogramadas) {
            if ($valueConteoReprogramadas == 5) {
                $this->Cell(145, 6, utf8_decode($valueConteoReprogramadas["cantidad"]), 1, 0, 'C');
                $flag = false;
            }
        }
        if ($flag == true) {
            $this->Cell(145, 6, utf8_decode("0"), 1, 0, 'C');
        }
        $this->Ln(15);

        $this->Cell(57, 6, utf8_decode(''), 0, 0, 'C');
        $this->Cell(26, 6, utf8_decode('Para programar'), 1, 0, 'C');
        $this->Cell(26, 6, utf8_decode('Para analizar'), 1, 0, 'C');
        $this->Cell(26, 6, utf8_decode('Para transcribir'), 1, 0, 'C');
        $this->Cell(26, 6, utf8_decode('Para revisar'), 1, 0, 'C');
        $this->Cell(26, 6, utf8_decode('Para aprobar'), 1, 0, 'C');
        $this->Ln(6);
        foreach ($data['auxClientes'] as $keyCliente => $cliente) {
            $this->Cell(57, 6, utf8_decode($cliente["cliente"]), 1, 0, 'C');
            $flagParaProgramar = true;
            $flagParaAnalizar = true;
            $flagParaTranscribir = true;
            $flagParaRevisar = true;
            $flagParaAprobar = true;
            foreach ($cliente['estados'] as $keyEstadoCliente => $valueClienteEstado) {
                if ($keyEstadoCliente == 2) {
                    $this->Cell((130 / 5), 6, utf8_decode($valueClienteEstado), 1, 0, 'C');
                    $flagParaProgramar = false;
                }
                if ($keyEstadoCliente == 3) {
                    $this->Cell((130 / 5), 6, utf8_decode($valueClienteEstado), 1, 0, 'C');
                    $flagParaAnalizar = false;
                }
                if ($keyEstadoCliente == 13) {
                    $this->Cell((130 / 5), 6, utf8_decode($valueClienteEstado), 1, 0, 'C');
                    $flagParaTranscribir = false;
                }
                if ($keyEstadoCliente == 4) {
                    $this->Cell((130 / 5), 6, utf8_decode($valueClienteEstado), 1, 0, 'C');
                    $flagParaRevisar = false;
                }
                if ($keyEstadoCliente == 16) {
                    $this->Cell((130 / 5), 6, utf8_decode($valueClienteEstado), 1, 0, 'C');
                    $flagParaAprobar = false;
                }
            }
            if ($flagParaProgramar == true) {
                $this->Cell((130 / 5), 6, utf8_decode("0"), 1, 0, 'C');
            }
            if ($flagParaAnalizar == true) {
                $this->Cell((130 / 5), 6, utf8_decode("0"), 1, 0, 'C');
            }
            if ($flagParaTranscribir == true) {
                $this->Cell((130 / 5), 6, utf8_decode("0"), 1, 0, 'C');
            }
            if ($flagParaRevisar == true) {
                $this->Cell((130 / 5), 6, utf8_decode("0"), 1, 0, 'C');
            }
            if ($flagParaAprobar == true) {
                $this->Cell((130 / 5), 6, utf8_decode("0"), 1, 0, 'C');
            }
            $this->Ln(6);
        }
        $this->Ln(15);

        $this->Cell(52, 6, utf8_decode(''), 0, 0, 'C');
        foreach ($data['aux'] as $keyAux => $valueAux) {
            $this->Cell((135 / count($data['aux'])), 6, utf8_decode((new DateTime($keyAux))->format('Y-m-d')), 1, 0, 'C');
        }
        $this->Ln(6);
        foreach ($data['auxAnalistas'] as $keyAnalista => $analista) {
            $this->Cell(52, 6, utf8_decode($analista["analista"]), 1, 0, 'C');
            foreach ($data['aux'] as $keyAux => $valueAux) {
                $flag = true;
                foreach ($analista['fechas'] as $keyAnalistaFechaCantidad => $analistaFechaCantidad) {
                    $a = (new DateTime($keyAux))->format('Y-m-d');
                    $b = (new DateTime($keyAnalistaFechaCantidad))->format('Y-m-d');
                    if ($a == $b) {
                        $this->Cell((135 / count($data['aux'])), 6, utf8_decode($analistaFechaCantidad), 1, 0, 'C');
                        $flag = false;
                    }
                }
                if ($flag == true) {
                    $this->Cell((135 / count($data['aux'])), 6, utf8_decode("0"), 1, 0, 'C');
                }
            }
            $this->Ln(6);
        }
        $this->Ln(15);
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->tablaCabeceraInicial();
$pdf->Output();
?>

