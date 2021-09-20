<?php

require('../../fpdf.php');
require_once './AuxProtocoloEstabilidad.php';
require_once '../AuxiliarInformes.php';

class PDF extends FPDF
{

    public $aux;

    function initAux()
    {
        $this->aux = new AuxProtocoloEstabilidad($_POST["idMuestra"]);
    }

    function Header()
    {
        $this->auxInformes = new AuxiliarInformes();
        $this->auxInformes->generateHeader($this, 'CUADRO PROTOCOLO DE ESTABILIDAD', '', '');
    }

    function sec1()
    {

        $this->RoundedRect(145, 32, 45, 7, 2, 'S', '1234');
        $this->SetFont('Arial', '', 9);
        $this->SetXY(145, 49);

        $this->Cell(0, -28, utf8_decode('ANÁLISIS No.:') . $this->aux->muestra->tipoMuestra->prefijo . "-" . $this->aux->muestra->custom_id, 0, 0, 'L');

        $this->Ln(1);
        $this->SetFont('Arial', 'BU', 12);

        $estabilidad = "ESTABILIDAD "
            . strtoupper($this->aux->muestra->tipoEstabilidad->tipo_estabilidad);
        $this->Cell(135, -35, utf8_decode($estabilidad), 0, 0, 'C');
        $this->Ln(2);
        $this->SetFont('Arial', 'B', 12);
        $producto = strtoupper(utf8_decode($this->aux->muestra->producto->nombre));
        $this->Cell(135, -28, substr($producto, 0, 45), 0, 0, 'C');
        $this->Ln(2);
    }

    function sec2()
    {
        $this->SetFont('Arial', '', 9);
        $ensayos = $this->aux->getEnsayosByMuestra();
        $duraciones = $this->aux->getDuracionesByMuestra();

        $tamanoEnsayos = 50;
        $medida = (130 / count($duraciones));
        $widths = array_fill(0, count($duraciones), $medida);
        array_unshift($widths, $tamanoEnsayos);
        $this->SetWidths($widths);

        $cabeceras = ['ENSAYOS'];
        foreach ($duraciones as $duracion) {
            array_push($cabeceras, utf8_decode($duracion->duracion . ' ' . $duracion->temperatura));
        }
        $this->Row2($cabeceras);
        $matrizValores = $this->crearMatrizValores();

        $aligns = array_fill(0, count($duraciones), 'C');
        array_unshift($aligns, 'L');

        $this->SetAligns($aligns);
        foreach ($ensayos as $ensayo) {
            $x = $this->GetX();
            $y = $this->GetY();
            $arrayValores = [utf8_decode($ensayo->descripcion_especifica)];
            foreach ($duraciones as $duracion) {
                if ($matrizValores[$duracion->id_duracion][$duracion->id_temperatura][$ensayo->id_ensayo]) {
                    array_push($arrayValores, 'X');
                } else {
                    array_push($arrayValores, '');
                }
            }
            $this->Row2($arrayValores);

        }

    }

    function crearMatrizValores()
    {
        $matriz = [];
        foreach ($this->aux->muestra->subMuestras as $subMuestra) {
            $matriz[$subMuestra->id_duracion][$subMuestra->id_temperatura] = [];
            foreach ($subMuestra->ensayosSubMuestra as $ensayo) {
                $matriz[$subMuestra->id_duracion][$subMuestra->id_temperatura][$ensayo->id_ensayo] = $ensayo->descripcion_especifica;
            }
        }
        return $matriz;
    }

}

$pdf = new PDF();
$pdf->initAux();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->sec1();
$pdf->sec2();

$pdf->Output();


