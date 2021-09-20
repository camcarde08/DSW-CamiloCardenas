<?php

require './../../vendor/autoload.php';
require './../../eloquent/database.php';
require_once './../../eloquent/models/EstMuestra.php';
require_once './../../eloquent/models/Lote.php';
require_once './../../eloquent/models/Producto.php';
require_once './../../eloquent/models/Tercero.php';
require_once './../../eloquent/models/TipoMuestra.php';
require_once './../../eloquent/models/Usuario.php';
require_once './../../eloquent/models/SystemParameters.php';

require('../fpdf.php');
require '../../model/DB/TablaReportesDbModelClass.php';
require '../../model/DbClass.php';
require_once '../rotation.php';


$idMuestra = $_POST["idMuestra"];


class PDF extends FPDF {

    function Header() {
        //Logo
        $this->Cell(55, 20, utf8_decode(''), 1, 0, 'C');
        $this->Image('../../views/images/logoEmpresa.png', 28, 12, 19);
        //Arial bold 15
        $this->SetFont('Arial', 'B', 11);

        $this->Cell(100, 20, utf8_decode('INFORME EVENTO POR MUESTRA'), 1, 0, 'C');
//      $this->Ln();
//      $this->Cell(80,10,utf8_decode('LQF LTDA.'),1,0,'C');
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(60, 5, utf8_decode('Código'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('F-095-(AD-009)'), 1, 0, 'C');

        $this->SetXY(165, 15);
        $this->Cell(60, 5, utf8_decode('Versión'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('01'), 1, 0, 'C');
        $this->SetXY(165, 20);
        $this->Cell(60, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');
        $this->Cell(60, 5, utf8_decode('08-02-17'), 1, 0, 'C');
        $this->SetXY(165, 25);
        $this->Cell(60, 5, utf8_decode('Página'), 1, 0, 'C');
        $this->Cell(60, 5, $this->PageNo() . ' de {nb}', 1, 0, 'C');
        $this->Ln(8);
        // To be implemented in your own inherited class
    }

    function Footer() {
        $this->SetY(-27);
        $this->Ln();
        $this->Cell(155, 5, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'R');
    }





}

$separador = SystemParameters::where("propiedad", "prefixMuestraSeparator")->first();

$muestra = EstMuestra::find($idMuestra);
$muestra->tipoMuestra;
$muestra->producto;

$eventos = $capsule->table('sgm_est_muestra_aud')
    ->select("id", "fecha", "id_usuario", "id_muestra", "evento", "razon")
    ->where("id_muestra", $idMuestra)
    ->get();
//$results = Empaque::all();

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage(H);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(260, 6, utf8_decode('Muestra N: ') . $muestra->tipoMuestra->prefijo . $separador->valor . $muestra->custom_id, 0, 0, 'R');
$pdf->RoundedRect(225, 33, 60, 7, 2, 'S', '1234');
$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(220, 7, '' . utf8_decode($muestra->producto->nombre), 0, 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(220, 7, 'Cliente: ' . utf8_decode($muestra->tercero->nombre), 0, 0, 'C');
$pdf->Ln(5);
$pdf->Cell(220, 7, 'Lote: ' . utf8_decode($muestra->numero_lote), 0, 0, 'C');
$pdf->Ln(10);

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(275, 6, utf8_decode('EDICIÓN MUESTRA'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 6, utf8_decode('ID'), 1, 0, 'C');
$pdf->Cell(82, 6, utf8_decode('USUARIO'), 1, 0, 'C');
$pdf->Cell(82, 6, utf8_decode('FECHA'), 1, 0, 'C');
$pdf->Cell(81, 6, utf8_decode('RAZON'), 1, 0, 'C');
$pdf->Ln(6);
$colum1 = 30;
$colum2 = 82;
$colum3 = 82;
$colum4 = 81;
$pdf->SetWidths(array($colum1, $colum2, $colum3, $colum4));
foreach ($eventos as $evento) {


    $evento->usuario = Usuario::find($evento->id_usuario);
    $pdf->SetX(10);


    $pdf->SetAligns(array('C', 'C', 'C', 'C'));
    $pdf->Row2(array(utf8_decode($evento->id), utf8_decode($evento->usuario->nombre), utf8_decode($evento->fecha), utf8_decode($evento->razon)));
}
$pdf->Ln(3);

$pdf->Output();
?>