<?php

require('../../fpdf.php');
require '../../../model/DbClass.php';
require '../../../controller/UtilsController.php';
require_once './AuxHojaRutaEstabilidad.php';
require_once './../AuxiliarInformes.php';

class PDF extends FPDF {

    public $aux;
    public $auxGeneral;

    function initAux() {
        $this->aux = new AuxHojaRutaEstabilidad($_POST["idSubMuestra"], $_POST["idTemperatura"]);
    }

    function Header() {
//Logo
        $this->Cell(40, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../../views/images/logoEmpresa.png', 20, 12, 19);
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(80, 20, utf8_decode('HOJA DE TRABAJO ANALÍTICO'), 1, 0, 'C');

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(30, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('F-145-(LA-008)'), 1, 0, 'C');
        $this->SetXY(130, 15);
        $this->Cell(30, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('02'), 1, 0, 'C');
        $this->SetXY(130, 20);
        $this->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(30, 5, utf8_decode('13-07-18'), 1, 0, 'C');
        $this->SetXY(130, 25);
        $this->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(30, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(5);
        $this->Cell(180, 10, '', 0, 0, 'C');
        $this->Ln(5);

        // Marca de agua
        /* if ($GLOBALS['perfil'] == "false") {
          $this->SetFont('Arial', 'B', 35);
          $this->SetTextColor(255, 192, 203);
          $this->RotatedText(35, 200, 'C O P I A   C O N T R O L A D A', 45);
          } */
    }

    function Footer() {
// Position at 1.5 cm from bottom
        $this->SetY(-16);
        $this->SetFont('Arial', 'B', 6);
        $this->Ln();
        $this->Cell(90, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }

    function informacionMuestra() {
        $fechaLlegada = new DateTime($this->aux->subMuestra->muestra->fecha_llegada);

        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(169, 169, 169);
        $this->RoundedRect($this->GetX(), $this->GetY() + 2, 180, 6, 2, 'S', '12');

        $this->Ln(-20);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(180, 50, utf8_decode('HOJA DE TRABAJO ANALíTICO ' . strtoupper($this->aux->subMuestra->muestra->producto->formaFarmaceutica->descripcion) . ' ' . ($this->aux->subMuestra->muestra->producto->nombre)), 0, 0, 'C');
        $this->Ln(28);
        $this->Cell(25, 7, 'F. DE INGRESO', 1, 0, 'C');
        $this->Cell(25, 7, utf8_decode('F.ANÁLISIS INICIAL'), 1, 0, 'C');
        $this->Cell(25, 7, utf8_decode('F.ANÁLISIS FINAL'), 1, 0, 'C');
        $this->Cell(30, 7, 'LQF', 1, 0, 'C');
        $this->Cell(75, 7, 'Lote', 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 9);
        $this->Cell(25, 7, $fechaLlegada->format('d-m-y'), 1, 0, 'C');
        $this->Cell(25, 7, '', 1, 0, 'C');
        $this->Cell(25, 7, '', 1, 0, 'C');
        if($fechaLlegada->format('y') == '16' || $fechaLlegada->format('y') == '17') {
            $this->Cell(30, 7, 'EST-' . substr($this->aux->numeroCliente($this->aux->subMuestra->muestra->tipoMuestra->prefijo
                                    , $this->aux->subMuestra->muestra->custom_id), 6, 4) . '-' . (substr($this->aux->subMuestra->muestra->tipoMuestra->prefijo, 3, 4)), 1, 0, 'C');
        } else {
            $this->Cell(30, 7, 'EST-' . substr($this->aux->numeroCliente($this->aux->subMuestra->muestra->tipoMuestra->prefijo
                                    , $this->aux->subMuestra->muestra->custom_id), 6, 4) . '-' . (substr($this->aux->subMuestra->muestra->tipoMuestra->prefijo, 3, 4)), 1, 0, 'C');
        }
        $this->Cell(75, 7, utf8_decode($this->aux->subMuestra->muestra->numero_lote), 1, 0, 'J');
        $this->SetFont('Arial', 'B', 9);
        $this->Ln();
        $this->Cell(180, 7, utf8_decode(($this->aux->subMuestra->muestra->producto->nombre . " "
                        . $this->aux->subMuestra->duracion->label . " "
                        . $this->aux->subMuestra->temperatura->label)), 1, 0, 'C');
        $this->Ln();
        $this->MultiCell(180, 6, utf8_decode('ENSAYOS A REALIZAR: ') . utf8_decode(implode(",", $this->aux->subMuestra->ensayosRealizar)), 1, 'L', FALSE);
        $this->Ln(0);
        $this->Cell(180, 6, utf8_decode('MÉTODOS: ' . implode(",", $this->aux->subMuestra->metodos)
                        . ' ' . $this->aux->subMuestra->ensayosSubMuestra[0]->paquete->codigo), 1, 0, 'L');
        $this->Ln();
    }

    function plantillasEnsayos() {
        foreach ($this->aux->subMuestra->ensayosSubMuestra as $ensayo) {
            $this->imprimirPlantillaEnsayo($ensayo);
        }
    }

    function imprimirPlantillaEnsayo($ensayo) {
        $plantilla = $ensayo->ensayo->id_plantilla;
        if ($plantilla == '8' || $plantilla == '9' || $plantilla == '195' || $plantilla == '2008' || $plantilla == '2364' || $plantilla == '18' || $plantilla == '286' || $plantilla == '2365' || $plantilla == '2362' || $plantilla == '72' || $plantilla == '1833' || $plantilla == '262') {
            $this->cuadroControlValoracion = true;
        }if ($plantilla == '6' || $plantilla == '31' || $plantilla == '1848' || $plantilla == '2361') {
            $this->cuadroControlDisolucion = true;
        }if ($plantilla == '19') {
            $this->cuadroControlPureza = true;
        }


        /* if ($plantilla == 8 || $plantilla == 18 || $plantilla == 9 || $plantilla == 10 || $plantilla == 195 || $plantilla == 1821 || $plantilla == 2008 || $plantilla == 2364 || $plantilla == 31 || $plantilla == 129 || $plantilla == 1848 || $plantilla == 2361 || $plantilla == 34 || $plantilla == 62 || $plantilla == 323 || $plantilla == 2127 || $plantilla == 2365 || $plantilla == 286) {
          $this->cuadroControlPlantilla = true;
          } else if ($plantilla == 262) {
          $this->cuadroControlPlantilla = true;
          $this->cuadroControlEstandar = true;
          } */

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
        $exp_regular[13] = '/≤/';
        $exp_regular[14] = '/–/';

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
        $cadena_nueva[13] = '<=';
        $cadena_nueva[14] = '-';

        $especificacion = preg_replace($exp_regular, $cadena_nueva, $ensayo->especificacion);
        $desEnsayo = $ensayo->descripcion_especifica;
        $tipoMuestra = $this->aux->subMuestra->muestra->producto->id_formula_farma;


        $this->SetFont('Arial', 'B', 9);
        $this->Cell(180, 6, utf8_decode($desEnsayo . ' (' . $ensayo->metodo->descripcion . ')'), 1, 0, 'C', True); // True permite que asigne el color
        $this->SetFont('Arial', '', 9);
        $this->Ln(6);

        if ($plantilla == '2') {
            $this->Cell(180, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
        }

        if ($plantilla == '3') {
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(130, 6, utf8_decode('Cantidad / Tamaño partícula'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 4, utf8_decode('No. captura '), 'LRT', 0, 'C');
            $this->Cell(65, 8, utf8_decode('10 - 24  (um)'), 1, 0, 'C');
            $this->Cell(65, 8, utf8_decode('25 - 100  (um)'), 1, 0, 'C');
            $this->Ln(4);
            $this->Cell(50, 4, utf8_decode('de imagen'), 'LRB', 0, 'C');
            $this->Cell(65, 4, utf8_decode(''), 0, 0, 'C');
            $this->Cell(65, 4, utf8_decode(''), 0, 0, 'C');
            $this->Ln(4);
            $this->Cell(50, 6, utf8_decode('1'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('2'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('3'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('4'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('5'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('6'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('7'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('8'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(50, 6, utf8_decode('TOTAL'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $y = $this->GetY();
            $x = $this->GetX();
            $this->Cell(100, 40, utf8_decode(''), 1, 0, 'C');
            $this->Image('../../../views/images/conteoMicroscopico.png', $x + 30 , $y + 5, 30);
            $this->Cell(80, 40, utf8_decode(''), 1, 0, 'C');
            $this->Ln(0);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(80, 7, utf8_decode('Demarcación del cuadrante'), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(80, 7, utf8_decode(''), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(80, 7, utf8_decode('A'), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 7, utf8_decode(''), 0, 0, 'C');
            $this->Cell(80, 7, utf8_decode('B'), 1, 0, 'C');
            $this->Ln(7);
            $this->Cell(100, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(80, 6, utf8_decode('C'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(100, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(80, 6, utf8_decode('D'), 1, 0, 'C');
            $this->Ln(6);
        }

        if ($plantilla == '4') {
            $this->Cell(50, 6, utf8_decode('No. Vial o ampolla'), 1, 0, 'C', TRUE);
            $this->Cell(65, 6, utf8_decode('No. Partículas visibles'), 1, 0, 'C', TRUE);
            $this->Cell(65, 6, utf8_decode('Descripción de partículas'), 1, 0, 'C', TRUE    );
            $this->Ln(6);
            $numero = 1;
            for ($i = 1; $i <= 20; $i++){
                $this->Cell(50, 6, utf8_decode($numero), 1, 0, 'C');
                $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(65, 6, utf8_decode(''), 1, 0, 'C');
                $this->Ln(6);
                $numero++;
            }

        }

        if ($plantilla == '5') {
            $this->Cell(180, 6, utf8_decode('Partículas encontradas en la membrana o recipiente:'), 'LRT', 0, 'L');
            $this->Ln(6);
            $this->Cell(180, 15, utf8_decode(''), 'LRB', 0, 'C');
            $this->Ln(15);
        }

        if ($plantilla == '6') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(20, 12, utf8_decode('Especificación'), 1, 0, 'L');
            $this->Cell(70, 6, utf8_decode('No más de 20 partículas con un tamaño <= de 10 um '), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode('Partículas encontradas <= 10 um'), 1, 0, 'L');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(70, 6, utf8_decode('No más de 5 partículas con un tamaño <= de 25 um '), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode('Partículas encontradas <= 25 um'), 1, 0, 'L');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
        }

        if ($plantilla == '7') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(20, 6, utf8_decode('Peso inicial'), 1, 0, 'L');
            $this->Cell(100, 6, utf8_decode('Erlenmeyer + Tapón + Agua'), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode('Peso final'), 1, 0, 'L');
            $this->Cell(100, 6, utf8_decode('Erlenmeyer + Tapón + Agua agregada hasta completar el peso inicial'), 1, 0, 'L');
            $this->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
        }

        if ($plantilla == '8') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(80, 10, utf8_decode('N° de fragmentos visibles en la superficie  del filtro:'), 1, 0, 'C');
            $this->Cell(100, 10, utf8_decode(''), 1, 0, 'L');
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '9' || $plantilla == '10' || $plantilla == '14') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(180, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '11') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(180, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->Cell(60, 6, utf8_decode('Peso muestra (M)'), 1, 0, 'C');
            $this->Cell(60, 6, utf8_decode('Volumen aparente (V)'), 1, 0, 'C');
            $this->Cell(60, 6, utf8_decode('Volumen aparente (V)'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 2; $i++){
                $this->Cell(60, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(60, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(60, 10, utf8_decode(''), 1, 0, 'C');
                $this->Ln(10);
            }
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '12') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(180, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->Cell(33, 6, utf8_decode('Volumen (V10)'), 1, 0, 'C');
            $this->Cell(33, 6, utf8_decode('Volumen (V50)'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Volumen (V100)'), 1, 0, 'C');
            $this->Cell(42, 6, utf8_decode('Promedio (V10, V50, V100) / n'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Densidad (M / Vf)'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 2; $i++){
                $this->Cell(33, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(33, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(36, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(42, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(36, 10, utf8_decode(''), 1, 0, 'C');
                $this->Ln(10);
            }
            $this->SetFont('Arial', '', 9);
            $this->Cell(180, 6, utf8_decode('Altura de caída de probeta:'), 1, 0, 'L');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '13') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(180, 20, utf8_decode(''), 1, 0, 'L');
            $this->Ln(20);
            $this->Cell(45, 6, utf8_decode('Peso'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Dilución'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Solvente'), 1, 0, 'C');
            $this->Cell(45, 6, utf8_decode('Clasificación'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 4; $i++){
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Cell(45, 10, utf8_decode(''), 1, 0, 'C');
                $this->Ln(10);
            }
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('RESULTADO DEL ENSAYO'), 1, 0, 'C', TRUE);
            $this->Ln(6);
        }

        if ($plantilla == '15') {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('1. DESCRIPCIÓN DE LA MUESTRA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(180, 15, utf8_decode(''), 1, 0, 'C');
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('2. ASPECTO GENERAL DE LA ENTREGA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Empaque y embalaje: seguro, limpio '), 'LRT', 0, 'L');
            $this->Cell(35, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('y en buenas condiciones.'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Identificación: N°. lote, referencia.'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Mezclas (Tamaño, color, tipo de material)'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('3. ASPECTO DEL MATERIAL'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan la apariencia'), 'LRT', 0, 'L');
            $this->Cell(35, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('(rugosidades, fisuras, incrustaciones, otros.)'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan el uso (Maquinabilidad)'), 'LRT', 0, 'L');
            $this->Cell(35, 18, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 18, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode(' rebabas, deformes, descentrado, grietas, despicado,'), 'LR', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('pliegues, otros)'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad interior o exterior removible con un '), 'LRT', 0, 'L');
            $this->Cell(35, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('proceso adicional de limpieza'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad interior no removible'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad exterior no removible'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('4. DIMENSIONES'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Diámetro del cuerpo'), 1, 0, 'L');
            $this->Cell(35, 30, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro exterior de la boca'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro interior de la boca'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura total'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura de la pestaña'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
        }

        if ($plantilla == '16') {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('1. DESCRIPCIÓN DE LA MUESTRA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(180, 15, utf8_decode(''), 1, 0, 'C');
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 24, utf8_decode('INSERTO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y empaque'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Limpio, identificado, sin '), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor '), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('rayones ni perforaciones.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Textos del arte'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Debe ser legible y coincidir con'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('la información del arte aprobado'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 96, utf8_decode('CAJA'), 1, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Color'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Desgaste a la Fricción'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('La impresión no se corre (no'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('mancha) ni se desgasta '), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('(no se borra).'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Espesor del Cartón'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('Mayor que 0,37 mm '), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode('PLEGADIZA'), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y Empaque'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Limpio, identificado, sin rayones'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('ni perforaciones.'), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Dimensiones'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('arte y/o especificación de'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('cada material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Textos del Arte'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Debe ser legible y coincidir con'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('la información del arte'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('aprobado.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 72, utf8_decode('CAJA'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Espesor del Cartón'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('Mayor que 3,5 mm'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Funcionalidad'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('No se debe despegar por '), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('ninguno de sus lados.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y Empaque '), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Limpio, identificado, sin'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('rayones ni perforaciones.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode('CORRUGA'), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Textos del Arte'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Debe ser legible y coincidir'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('con la información del arte'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('aprobado.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Dimensiones'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(18, 12, utf8_decode('INSUMO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('PARAMETRO'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('ESPECIFICACIÓN'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('CLASE DE DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('N° DE UNIDADES'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode('DEFECTUOSAS'), 'LRB', 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(18, 210, utf8_decode('ETIQUETA'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Presentación y Empaque'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Limpio, identificado, sin'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Menor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('rayones ni perforaciones.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Textos del Arte'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Debe ser legible y coincidir'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('con la información del arte'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('aprobado.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Color'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Desgaste a la Fricción'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('La impresión no se corre (no'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('mancha) ni se desgasta '), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('(no se borra).'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Dimensiones'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Deben ser los definidos en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('arte y/o especificación de cada'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('material.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Reserva de Brillo'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Mínimo 10 mm medido desde'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('el borde.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Distancia entre Etiquetas'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Mínimo 3 mm entre una y otra,'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('la distancia se debe mantener'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('constante.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Adhesivo de Seguridad'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('Al momento de retirarla, la'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('etiqueta debe romperse dejando'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('fragmentos adheridos al vidrio.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 18, utf8_decode('Sentido de Bobinado'), 1, 0, 'C');
            $this->Cell(36, 6, utf8_decode('La punta del rollo sale en el'), 'LRT', 0, 'C');
            $this->Cell(26, 18, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('sentido de giro de las'), 'LR', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode('manecillas del reloj.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 36, utf8_decode('Altura Cinta'), 'LRT', 0, 'C');
            $this->Cell(36, 6, utf8_decode('Según las dimensiones de'), 'LRT', 0, 'C');
            $this->Cell(26, 36, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 36, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 36, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 30, utf8_decode('Porta-Etiquetas'), 'LRB', 0, 'C');
            $this->Cell(36, 6, utf8_decode('las etiquetas así'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(18, 12, utf8_decode('Etiqueta'), 1, 0, 'C');
            $this->Cell(18, 6, utf8_decode('Altura cinta'), 'LRT', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(18, 6, utf8_decode('Porta-Etiquetas'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(18, 6, utf8_decode('58 mm*28 mm'), 1, 0, 'C');
            $this->Cell(18, 6, utf8_decode('24 mm-31 mm'), 1, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(18, 6, utf8_decode('72 mm*42 mm'), 1, 0, 'C');
            $this->Cell(18, 6, utf8_decode('43 mm-45 mm'), 1, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Troquelado de la Cinta'), 'LRT', 0, 'C');
            $this->Cell(36, 6, utf8_decode('Mínimo 10 mm medido desde'), 'LRT', 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Porta-Etiquetas'), 'LRB', 0, 'C');
            $this->Cell(36, 6, utf8_decode('el borde.'), 'LRB', 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 12, utf8_decode('Diámetro Del Buje'), 1, 0, 'C');
            $this->Cell(36, 12, utf8_decode('41 mm ó 76 mm .'), 1, 0, 'C');
            $this->Cell(26, 12, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(18, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(36, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(26, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->Cell(180, 40, utf8_decode('PEGUE UNA   ETIQUETA EN ESTE ESPACIO, O ADJUNTE UNA MUESTRA DE LA PLEGADIZA O DEL INSERTO AL RESPALDO'), 1, 0, 'C');
            $this->Ln(40);
        }

        if ($plantilla == '17') {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('1. DESCRIPCIÓN DE LA MUESTRA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(180, 15, utf8_decode(''), 1, 0, 'C');
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('2. ASPECTO GENERAL DE LA ENTREGA'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Empaque y embalaje: seguro, limpio '), 'LRT', 0, 'L');
            $this->Cell(35, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('y en buenas condiciones.'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Identificación: N°. lote, referencia.'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Mezclas (Tamaño, color, tipo de material)'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('3. ASPECTO DEL MATERIAL'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan la apariencia'), 'LRT', 0, 'L');
            $this->Cell(35, 12, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 12, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 12, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('(rugosidades, fisuras, incrustaciones, otros.)'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Terminaciones que afectan el uso (Maquinabilidad)'), 'LRT', 0, 'L');
            $this->Cell(35, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 18, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 18, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode(' rebabas, deformes, descentrado, grietas, despicado,'), 'LR', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('pliegues, otros)'), 'LRB', 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 0, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Suciedad Removible y No Removible'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Color no característico'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('4. DIMENSIONES'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('ESPECIFICACIONES'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Altura total'), 1, 0, 'L');
            $this->Cell(35, 30, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura de la tapa'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura del cono'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro de la tapa'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro del cono'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->seccionCumpleEspecificaciones();
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(60, 6, utf8_decode('PARAMETRO  A EVALUAR'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CATEGORIA DEL DEFECTO'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('TAMAÑO DE LA MUESTRA'), 1, 0, 'C');
            $this->Cell(50, 6, utf8_decode('NUMERO DE UNIDADES DEFECTUOSAS'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('ESPECIFICACIONES'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->SetFont('Arial', '', 7);
            $this->Cell(60, 6, utf8_decode('Diámetro exterior'), 1, 0, 'L');
            $this->Cell(35, 18, utf8_decode('Crítico'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Diámetro interior'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Altura Total'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
            $this->Cell(60, 6, utf8_decode('Calibre de lamina'), 1, 0, 'L');
            $this->Cell(35, 6, utf8_decode('Mayor'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode(''), 1, 0, 'L');
            $this->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
            $this->Ln(6);
        }

        if ($plantilla == '18') {
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(40, 6, utf8_decode('ACTIVIDAD'), 1, 0, 'C', TRUE);
            $this->Cell(80, 6, utf8_decode('REALIZADO POR'), 1, 0, 'C', TRUE);
            $this->Cell(30, 6, utf8_decode('FECHA'), 1, 0, 'C', TRUE);
            $this->Cell(30, 6, utf8_decode('SANITIZANTE'), 1, 0, 'C', TRUE);
            $this->Ln(6);
            $this->Cell(20, 12, utf8_decode('Sanitización'), 1, 0, 'C', TRUE);
            $this->Cell(20, 6, utf8_decode('Loop 1'), 1, 0, 'C', TRUE);
            $this->Cell(80, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode('Loop 2'), 1, 0, 'C', TRUE);
            $this->Cell(80, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 12, utf8_decode('UBICACIÓN'), 1, 0, 'C');
            $this->Cell(5, 12, utf8_decode('Nº'), 1, 0, 'C');
            $this->Cell(40, 12, utf8_decode('PUNTO DE MUESTREO'), 1, 0, 'C');
            $this->Cell(30, 12, utf8_decode('CONDUCTIVIDAD'), 1, 0, 'C');
            $this->Cell(20, 12, utf8_decode('pH'), 1, 0, 'C');
            $this->Cell(20, 12, utf8_decode('TOC'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('CONCEPTO*'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(5, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(40, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(20, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(17, 6, utf8_decode('C'), 0, 0, 'C');
            $this->Cell(18, 6, utf8_decode('N.C'), 1, 0, 'C');
            $this->Ln(6);
            for ($i = 1; $i <= 15; $i++){
                $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(5, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(40, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(20, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(17, 6, utf8_decode(''), 1, 0, 'C');
                $this->Cell(18, 6, utf8_decode(''), 1, 0, 'C');
                $this->Ln(6);
            }
        }

        if ($plantilla != '16' || $plantilla != '18') {
            $this->seccionCumpleEspecificaciones();
        }
        if ($plantilla == '15' || $plantilla == '16' || $plantilla == '17') {
            $this->SetFont('Arial', '', 9);
            $this->Cell(180, 6, utf8_decode('Equipos o instrumentos de medida: '), 1, 0, 'L');
            $this->Ln(6);
        }
        if ($plantilla == '18') {
            $this->SetFont('Arial', '', 8);
            $this->Cell(30, 6, utf8_decode('Límites de alerta'), 'LRT', 0, 'C', TRUE);
            $this->Cell(75, 12, utf8_decode('ETAPA 1: 1,0 uS / cm  en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Cell(75, 12, utf8_decode('ETAPA 2: 1,9  uS / cm en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('conductividad'), 'LRB', 0, 'C', TRUE);
            $this->Cell(75, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(75, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('Límites de acción'), 'LRT', 0, 'C', TRUE);
            $this->Cell(150, 12, utf8_decode('Límite de acción: max 2,0 uS / cm en tres o mas puntos el mismo día'), 1, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode('conductividad'), 'LRB', 0, 'C', TRUE);
            $this->Cell(75, 6, utf8_decode(''), 0, 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 12, utf8_decode('Límites de TOC'), 1, 0, 'C', TRUE);
            $this->Cell(75, 6, utf8_decode('Límite de alerta: máximo 400 ppb en tres o mas puntos'), 'LRT', 0, 'C');
            $this->Cell(75, 6, utf8_decode('Límite de acción: máximo 450 ppb en tres o mas puntos'), 'LRT', 0, 'C');
            $this->Ln(6);
            $this->Cell(30, 6, utf8_decode(''), 0, 0, 'C');
            $this->Cell(75, 6, utf8_decode('un mismo día'), 'LRB', 0, 'C');
            $this->Cell(75, 6, utf8_decode('un mismo día'), 'LRB', 0, 'C');
            $this->Ln(6);
        }

    }

    function ruidoCondicionesCromatograficas() {
        $this->Cell(180, 6, utf8_decode('Aptitud del Sistema'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(30, 6, utf8_decode('Nombre'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('N'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('T'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('R'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('k'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('S/N'), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode('Ruido'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(30, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Cell(25, 6, utf8_decode(''), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(180, 6, utf8_decode('Verificación de condiciones cromatográficas'), 'TLR', 0, 'T');
        $this->Ln(6);
        $this->Cell(180, 12, utf8_decode(''), 'BLR', 0, 'T');
        $this->Ln(12);
        /* $this->Cell(60, 6, utf8_decode('Secuencia:'), 1, 0, 'L');
          $this->Cell(60, 6, utf8_decode('Método:'), 1, 0, 'L');
          $this->Cell(60, 6, utf8_decode('Fecha y hora:'), 1, 0, 'L');
          $this->Ln(6); */
    }

    function consultarEstandaresEnsayo($ensayoSubMuestra, $plantilla) {
        $this->SetFillColor(216, 216, 216);
        if (count($ensayoSubMuestra->estandaresLote) > 0) {
            $this->Cell(180, 6, utf8_decode('Datos del (los) Estándar (es)'), 1, 0, 'C', True); // True permite que asigne el color
            $this->Ln(6);
            $this->Cell(25, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(65, 6, utf8_decode('Nombre'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Lote'), 1, 0, 'C');
            if ($plantilla == '262' || $plantilla == '286') {
                $this->Cell(40, 6, utf8_decode('Potencia (P)'), 1, 0, 'C');
            } else {
                $this->Cell(40, 6, utf8_decode('Pureza  (P)'), 1, 0, 'C');
            }
            $this->Cell(20, 6, utf8_decode('FV'), 1, 0, 'C');
            $this->Ln(6);
            $this->SetWidths(array(25, 65, 30, 40, 20));
            $this->SetAligns(array('C', 'C', 'C', 'C', 'C'));
            foreach ($ensayoSubMuestra->estandaresLote as $estandar) {
                $fechaVen = $estandar->lote->fecha_vencimiento ? (new DateTime($estandar->lote->fecha_vencimiento))->format('m-Y') : '';
                $this->auxGeneral->tablaBordesTamanoLinea($this, array(
                    utf8_decode($estandar->estandar->codigo . '(' . $estandar->lote->stock . ')')
                    , utf8_decode($estandar->estandar->nombre), utf8_decode($estandar->lote->codigo)
                    , utf8_decode($estandar->lote->descripcion), utf8_decode($fechaVen))
                        , 6);
            }
        }
        $this->SetFillColor(169, 169, 169);
    }

    function consultarReactivosMuestra($idMuestra) {
        $reactivos = $this->aux->obtenerLoteReactivoMuestraActivo($idMuestra);
        $this->SetFillColor(169, 169, 169);
        if (count($reactivos) > 0) {
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(180, 6, utf8_decode('Datos del (los) Reactivo (s)'), 1, 0, 'C', True); // True permite que asigne el color
            $this->SetFont('Arial', '', 9);
            $this->Ln(6);
            $this->Cell(20, 6, utf8_decode('Código'), 1, 0, 'C');
            $this->Cell(70, 6, utf8_decode('Nombre'), 1, 0, 'C');
            $this->Cell(30, 6, utf8_decode('Grado'), 1, 0, 'C');
            $this->Cell(35, 6, utf8_decode('Lote'), 1, 0, 'C');
            $this->Cell(25, 6, utf8_decode('FV'), 1, 0, 'C');
            $this->Ln(6);
            foreach ($reactivos as $reactivo) {
                $fechaVen = $reactivo->lote->fecha_vencimiento ? (new DateTime($reactivo->lote->fecha_vencimiento))->format('m-Y') : '';
                $this->Cell(20, 6, utf8_decode($reactivo->reactivo->codigo), 1, 0, 'C');
                $this->Cell(70, 6, utf8_decode($reactivo->reactivo->nombre), 1, 0, 'L');
                $this->Cell(30, 6, utf8_decode($reactivo->reactivo->grado), 1, 0, 'L');
                $this->Cell(35, 6, utf8_decode($reactivo->lote->numero), 1, 0, 'L');
                $this->Cell(25, 6, utf8_decode($fechaVen), 1, 0, 'C');
                $this->Ln(6);
            }
        }
    }

    function seccionCumpleEspecificaciones() {
        $this->Cell(180, 6, utf8_decode('CUMPLE   SI[   ]    NO[   ]'), 1, 0, 'C');
        $this->Ln(6);
        $this->Cell(180, 6, utf8_decode('Verificado por: '), 1, 0, 'L');
        $this->Ln(6);
    }

    function consultarEquiposEnsayo($idEnsayo) {
        $equipos = $this->aux->obtenerEquiposEnsayo($idEnsayo);
        if (count($equipos) > 0) {
            $this->MultiCell(180, 6, utf8_decode('Equipos: ' . implode(",", $equipos)), 1, 'L'); // True permite que asigne el color
            $this->Ln(6);
        }
    }

    function verReactivosMuestra() {
        $this->Ln(6);
        $this->consultarReactivosMuestra($this->aux->subMuestra["id"]);
    }

    function faseMovil() {
        $this->Cell(180, 18, utf8_decode('Fase Móvil:'), 'LRT', 0, 'L');
        $this->Ln(18);
        $this->Cell(180, 6, utf8_decode('Verificado por:'), 'RLB', 0, 'L');
        $this->Ln(6);
    }

    function preparacionSoluciones() {
        $this->Cell(180, 25, utf8_decode('Preparación de soluciones'), 'TLR', 0, 'L');
        $this->Ln(25);
        $this->Cell(180, 6, utf8_decode('Verificado por:'), 'LRB', 0, 'L');
        $this->Ln(6);
    }

    function finalDocumento() {
        $this->Ln(10);
        $this->Cell(180, 6, utf8_decode('Balanza: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea

        $this->Ln(10);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(180, 5, utf8_decode('Observaciones: ____________________________________________________________________________________________________________________'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(180, 5, utf8_decode('___________________________________________________________________________________________________________________________________'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(180, 5, utf8_decode('___________________________________________________________________________________________________________________________________'), 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(180, 5, utf8_decode('___________________________________________________________________________________________________________________________________'), 0, 0, 'C');

        $this->Ln(8);
        $this->Cell(180, 12, utf8_decode('Resultado Fuera de Especificaciones'), 1, 0, 'L');
        $this->Ln(12);
        $this->Cell(180, 12, utf8_decode('Verificación'), 1, 0, 'L');
        $this->Ln(13);
        $this->Cell(180, 6, utf8_decode('Concepto:'), 1, 0, 'L');
        $this->Ln(6);
        $this->Cell(90, 6, utf8_decode('[   ]  Cumple las especificaciones'), 1, 0, 'L');
        $this->Cell(90, 6, utf8_decode('[   ]  No cumple las especificaciones'), 1, 0, 'L');
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(180, 5, utf8_decode('Analizado por: __________________________________________________   Verificado por: _______________________________________'), 0, 0, 'L');
        $this->Ln(10);
        $this->Cell(180, 5, utf8_decode('Transcrito por: __________________________________________________   Aprobado por: _______________________________________'), 0, 0, 'L');
        $this->Ln(10);

        if ($this->cuadroControlValoracion) {
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER (Valoración) con estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('Promedio de estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER entre STD1 y STD2: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        }
        if ($this->cuadroControlDisolucion) {
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('Promedio de estándar de control de disolución: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER (Disolución) con estándar de control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER entre STD1 y STD2: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
        }
        if ($this->cuadroControlPureza) {
            $this->Ln(6);
            $this->Cell(180, 6, utf8_decode('% de DER para estándar de pureza de Control: '), 1, 0, 'L'); // el segundo parametro 1 genera un salto de linea
            $this->Ln(6);
        }
    }

}

$pdf = new PDF();
$pdf->auxGeneral = new AuxiliarInformes();
$pdf->initAux();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->informacionMuestra();
$pdf->plantillasEnsayos();
$pdf->verReactivosMuestra();
$pdf->finalDocumento();


$pdf->Output();
