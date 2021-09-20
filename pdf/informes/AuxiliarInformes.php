<?php

class AuxiliarInformes {

    function generateHeader($pdf, $titulo, $codigo, $version) {
        //Logo
        define('ROOTPATH', __DIR__ . "/../../");
        $pdf->Cell(40, 20, (''), 1, 0, 'C');  
        $pdf->Image(ROOTPATH . '/views/images/logoEmpresa.png', 20, 12, 19);
        $pdf->SetFont('Arial', 'B', 11);  
        $pdf->Cell(80, 20, utf8_decode($titulo), 1, 0, 'C'); 

        $pdf->SetFont('Arial', '', 7);  
        $pdf->Cell(30, 10, utf8_decode('Código'), 1, 0, 'C');
        $pdf->Cell(30, 10, utf8_decode($codigo), 1, 0, 'C');

        $pdf->SetXY(130, 15);
        $pdf->SetXY(130, 20);  
        $pdf->Cell(30, 5, utf8_decode('Vigente Desde'), 1, 0, 'C');  
        $pdf->Cell(30, 5, utf8_decode(''), 1, 0, 'C');  
        $pdf->SetXY(130, 25);  
        $pdf->Cell(30, 5, utf8_decode('Página'), 1, 0, 'C');  
        $pdf->Cell(30, 5, $pdf->PageNo() . ' de {nb}', 1, 0, 'C');  
        $pdf->Ln(8);
    }

    function generateHeaderHorizontal($pdf, $titulo, $codigo, $version) {
        //Logo
        $pdf->Ln(5);
        define('ROOTPATH', __DIR__ . "/../../");
        $pdf->Image(ROOTPATH . '/views/images/logoEmpresa.png', 10, 10, 25);
        $pdf->SetFont('Arial', 'B', 9);

        $pdf->Cell(270, 6, utf8_decode($titulo), 0, 0, 'R');
        $pdf->Ln(6);

        $pdf->SetTextColor(236, 50, 55);
        $pdf->Cell(270, 6, utf8_decode($codigo), 0, 0, 'R');
        $pdf->Ln(6);

        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(270, 6, utf8_decode($version), 0, 0, 'R');
        $pdf->Ln(6);
    }

    function generateFooter($pdf) {
        $pdf->SetY(-20);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(180, 5, utf8_decode('Página ') . $pdf->PageNo() . ' de {nb}', 0, 0, 'R');
        $pdf->Ln(5);
        $pdf->Cell(180, 5, utf8_decode('Calle 66 No 73 A 38 - Celular: 321 366 9654 - Bogotá D.C, Colombia'), 0, 0, 'C');
        $pdf->Ln(5);
        $pdf->Cell(180, 5, utf8_decode('Contáctenos en: controldecalidad@knovelecvlab.com'), 0, 0, 'C');
        $pdf->Ln(5);
    }

    function tablaSinBordes($pdf, $data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            if ($i % 2 == 0) {
                $pdf->SetFont('Arial', 'B', 8);

            } else {
                $pdf->SetFont('Arial', '', 8);
            }
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'C';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();


            //WriteHTML($
            $pdf->MultiCell($w, 4, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

    function tablaBordes($pdf, $data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'L';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            //Draw the border
            $pdf->Rect($x, $y, $w, $h);
            //WriteHTML($
            $pdf->MultiCell($w, 4, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

    function tablaBordesTamanoLinea($pdf, $data, $altoLinea) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i] . '    '));
        $h = $altoLinea * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'L';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            //Draw the border
            $pdf->Rect($x, $y, $w, $h);
            //WriteHTML($
            $pdf->MultiCell($w, $altoLinea, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

    function tablaBordesCentrado($pdf, $data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'C';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            //Draw the border
            $pdf->Rect($x, $y, $w, $h);
            //WriteHTML($
            $lineMC = $pdf->NbLines($pdf->widths[$i], $data[$i]);
            $hMulticell = $h / $lineMC;
            $pdf->MultiCell($w, $hMulticell, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

    function tablaBordesCentradoV2($pdf, $data, $flagFilaFinal) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'C';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            //Draw the border
            if($i != 0){
                $pdf->Rect($x, $y, $w, $h);
            }

            //WriteHTML($
            $lineMC = $pdf->NbLines($pdf->widths[$i], $data[$i]);
            $hMulticell = $h / $lineMC;
            if($i != 0){
                $pdf->MultiCell($w, $hMulticell, $data[$i], 0, $a);
            } else {
                if($flagFilaFinal){
                    $pdf->MultiCell($w, $hMulticell, $data[$i], "LRB", $a);
                } else {
                    $pdf->MultiCell($w, $hMulticell, $data[$i], "LR", $a);
                }
            }

            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }



    function tablaBordesCentradoV3($pdf, $data, $flagFilaFinal) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            if ($i % 2 == 0) {
                $pdf->SetFont('Arial', 'B', 8);

            } else {
                $pdf->SetFont('Arial', '', 8);
            }
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'C';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            //Draw the border
            if($i != 0){
                $pdf->Rect($x, $y, $w, $h);
            }

            //WriteHTML($
            $lineMC = $pdf->NbLines($pdf->widths[$i], $data[$i]);
            $hMulticell = $h / $lineMC;
            if($i != 0){
                $pdf->MultiCell($w, $hMulticell, $data[$i], 0, $a);
            } else {
                if($flagFilaFinal){
                    $pdf->MultiCell($w, $hMulticell, $data[$i], 0, $a);
                } else {
                    $pdf->MultiCell($w, $hMulticell, $data[$i], "LR", $a);
                }
            }

            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

    function tablaBordesCentradoV4($pdf, $data, $flagFilaFinal) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $pdf->NbLines($pdf->widths[$i], $data[$i]));
        $h = 4 * $nb;
        //Issue a page break first if needed
        $pdf->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $pdf->widths[$i];
            $a = isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'C';
            //Save the current position
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            //Draw the border
            if($i > 0 && $i < 3){
                $pdf->Rect($x, $y, $w, $h);
            }

            //WriteHTML($
            $lineMC = $pdf->NbLines($pdf->widths[$i], $data[$i]);
            $hMulticell = $h / $lineMC;
            if($i > 0 && $i < 3){
                $pdf->MultiCell($w, $hMulticell, $data[$i], 0, $a);
            } else {
                if($flagFilaFinal){
                    $pdf->MultiCell($w, $hMulticell, $data[$i], "LRB", $a);
                } else {
                    $pdf->MultiCell($w, $hMulticell, $data[$i], "LR", $a);
                }
            }

            //Put the position to the right of the cell
            $pdf->SetXY($x + $w, $y);
        }
        //Go to the next line
        $pdf->Ln($h);
    }

}
