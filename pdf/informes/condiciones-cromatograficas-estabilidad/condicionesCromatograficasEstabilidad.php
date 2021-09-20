<?php

require_once ('../../tfpdf/tfpdf.php');
require_once './AuxInformeCondicionesCromatograficasEstabilidad.php';
require_once '../AuxiliarInformes.php';

class PDF extends tFPDF {

    public $aux;
    public $auxGeneral;
    public $condiciones;

    function init() {
        $idBusqueda = $_POST['idMuestraEstabilidad'];
        $this->aux = new AuxInformeCondicionesCromatograficasEstabilidad();
        $this->auxGeneral = new AuxiliarInformes();
        $this->condiciones = $this->aux->obtenerCondicionesCromatograficasMuestraEstabilidad($idBusqueda);
    }

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

        $this->Cell(100, 20, utf8_decode('ESPECIFICACIONES Y CONDICIONES DE TRABAJO'), 1, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('F-160(LA-008)'), 1, 0, 'C');
        $this->SetXY(150, 15);
        $this->Cell(20, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('02'), 1, 0, 'C');
        $this->SetXY(150, 20);
        $this->Cell(20, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(20, 5, utf8_decode('07-11-17'), 1, 0, 'C');
        $this->SetXY(150, 25);
        $this->Cell(20, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(20, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(180, 10, '', 0, 0, 'C');
        $this->Ln(5);

        if ($_POST['idPerfil'] == "false") {
            $this->SetFont('Arial', 'B', 35);
            $this->SetTextColor(255, 192, 203);
            $this->RotatedText(35, 200, 'C O P I A   C O N T R O L A D A', 45);
        }

        $this->Ln(10);
    }

    function imprimirCondiciones() {
        $columnas = [40, 140];
        $this->SetWidths($columnas);
        $this->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);

        $propiedadesCondicion = [
            ['Longitud de onda', 'longitud_onda'],
            ['Diluyente', 'diluyente_valoracion'],
            ['Fase Móvil', 'fase_movil'],
            ['Concentración', 'concentracion'],
            ['Flujo', 'flujo'],
            ['Volumen de Inyección', 'volumen_inyeccion'],
            ['Temperatura', 'temperatura'],
            ['Aptitud del sistema', 'aptitud_sistema'],
            ['Tr', 'tr'],
            ['Observaciones', 'observaciones'],
            ['Ecuación para el cálculo', 'ecuacion_calculo'],
            ['Referencia', 'referencia']
        ];

        $propiedadesDilucion = [
            ['Longitud de onda', 'disolucion_longitud_onda'],
            ['Diluyente', 'diluyente_disolucion'],
            ['Fase Móvil', 'disolucion_fase_movil'],
            ['Concentración', 'disolucion_concentracion'],
            ['Condiciones', 'disolucion_condiciones'],
            ['Medio de Disolución', 'disolucion_medio'],
            ['Flujo', 'disolucion_flujo'],
            ['Volumen de Inyección', 'disolucion_volumen_inyeccion'],
            ['Temperatura', 'disolucion_temperatura'],
            ['Aptitud del sistema', 'disolucion_aptitud_sistema'],
            ['Tr', 'disolucion_tr'],
            ['Observaciones', 'disolucion_observaciones'],
            ['Ecuación para el cálculo', 'disolucion_ecuacion_calculo'],
            ['Referencia', 'disolucion_referencia']
        ];

        foreach ($this->condiciones as $index => $condicion) {
            $this->AddPage();
            $this->SetFont('Arial', 'B', 11);
            $this->SetAligns(array('C', 'C'));
            $this->auxGeneral->tablaBordesTamanoLinea($this, array(utf8_decode($condicion['condicionCromatografica']->codigo)
                , utf8_decode($condicion['condicionCromatografica']->nombre)), 6);
            $this->SetFont('DejaVu', '', 9);
            $this->SetAligns(array('L', 'L'));
            $this->auxGeneral->tablaBordes($this, array(('Columna')
                , ($condicion['columna']->tipo . ' ' . $condicion['columna']->dimensiones . ' ( N° ' . $condicion['columna']->numero . ' ó Equivalente)')));

            foreach ($propiedadesCondicion as $propiedad) {
                if (($condicion['condicionCromatografica']->{$propiedad[1]}) !== '' &&
                        ($condicion['condicionCromatografica']->{$propiedad[1]}) !== NULL) {
                    $this->auxGeneral->tablaBordes($this, array($propiedad[0]
                        , ($condicion['condicionCromatografica']->{$propiedad[1]})));
                }
            }

            if ($condicion['condicionCromatografica']->disolucion_condiciones !== '' &&
                    $condicion['condicionCromatografica']->disolucion_condiciones !== null) {
                $this->SetFont('Arial', 'B', 10);
                $this->SetAligns(array('C', 'C'));
                $this->auxGeneral->tablaBordesTamanoLinea($this, array(utf8_decode($condicion['condicionCromatografica']->codigo . '-A')
                    , utf8_decode('Disolución')), 5);
                $this->SetFont('DejaVu', '', 9);
                $this->SetAligns(array('L', 'L'));

                foreach ($propiedadesDilucion as $propiedad) {
                    if (($condicion['condicionCromatografica']->{$propiedad[1]}) !== '' &&
                            ($condicion['condicionCromatografica']->{$propiedad[1]}) !== NULL) {
                        $this->auxGeneral->tablaBordes($this, array($propiedad[0]
                            , ($condicion['condicionCromatografica']->{$propiedad[1]})));
                    }
                }
            }
            $this->SetFont('Arial', '', 9);
            $this->Ln(12);
            $this->Cell(130, 12, utf8_decode('Elaborado por:  ' . $condicion['condicionCromatografica']->elaborado_por), 'TBL', 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 'TBR', 0, 'L');
            $this->Ln(12);
            $this->Cell(130, 12, utf8_decode('Revisado por:   ' . $condicion['condicionCromatografica']->revisado_por), 'TBL', 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 'TBR', 0, 'L');
            $this->Ln(12);
            $this->Cell(130, 12, utf8_decode('Aprobado por:  ' . $condicion['condicionCromatografica']->aprobado_por), 'TBL', 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 'TBR', 0, 'L');
            $this->Ln(12);
        }
    }

}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->init();
$pdf->imprimirCondiciones();
$pdf->Output();
