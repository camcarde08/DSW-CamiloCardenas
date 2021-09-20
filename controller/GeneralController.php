<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GeneralController
 *
 * @author andres
 */
class GeneralController {

    //put your code here
    public function updateEstadoByIdMuestra($idMuestra, $idNewEstado, $observaciones, $idEnsayoMuestra) {
        $modelMuestra = new TablaMuestraDbModelClass();
        $muestraData = $modelMuestra->getMuestraReferenciasById($idMuestra);
        if ($muestraData[0]['id_area_analisis'] != 4) {
            $estadoActual = $muestraData[0]['id_estado_muestra'];
            if ($idNewEstado == 2) {
                $modelEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
                $data = $modelEnsayoMuestra->getEnsayoMuestraByIdMuestraAndEstadoAndValicacion($idMuestra, 0, 1);
                $ensayosSinProgramar = count($data);
                $data = $modelEnsayoMuestra->getEnsayoMuestraByIdMuestraAndEstadoAndValicacion($idMuestra, 1, 1);
                $ensayosProgramados = count($data);
                $totalensayos = $ensayosSinProgramar + $ensayosProgramados;
                if ($ensayosSinProgramar == $totalensayos) {
                    $modelMuestra->updateEstadoByIdMuestra($idMuestra, 1);
                    $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                    $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 1, $_SESSION['userId']);
                } else {
                    if ($ensayosSinProgramar == 0) {
                        if ($estadoActual != 3) {
                            $modelMuestra->updateEstadoByIdMuestra($idMuestra, 3);
                            if ($estadoActual == 2 || $estadoActual == 5 || $estadoActual == 1) {
                                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                                $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 3, $_SESSION['userId']);
                            }
                        }
                    } else {
                        if ($estadoActual != 2) {
                            $modelMuestra->updateEstadoByIdMuestra($idMuestra, 2);
                            if ($estadoActual == 1 or $estadoActual == 3) {
                                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                                $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 2, $_SESSION['userId']);
                            }
                        }
                    }
                }
            } elseif ($idNewEstado == 4) {
                if ($estadoActual == 3) {
                    $modelEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
                    $ensayosSinResultados = $modelEnsayoMuestra->contarEnsayoSinResutadosByIdMuestra($idMuestra);
                    if ($ensayosSinResultados != false) {
                        if ($ensayosSinResultados[0]["cantidad"] == 0) {
                            $modelMuestra->updateEstadoByIdMuestra($idMuestra, 4);
                            $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                            $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 4, $_SESSION['userId'], $observaciones);
                        }
                    } else {
                        
                    }
                }
            } else if ($idNewEstado == 5) {
                if ($estadoActual != 5) {
                    $modelMuestra->updateEstadoByIdMuestra($idMuestra, 5);
                }
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 5, $_SESSION['userId'], $observaciones);
            } else if ($idNewEstado == 6) {
                if ($estadoActual != 6) {
                    $modelMuestra->updateEstadoByIdMuestra($idMuestra, 6);
                }
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 6, $_SESSION['userId']);
            } elseif ($idNewEstado == 7) {
                if ($estadoActual == 4) {
                    $ensayoMuestraController = new TablaEnsayoMuestraDbModelClass();
                    $ensayosSinRevisar = $ensayoMuestraController->contarEnsayosSinRevisionByIdMuestra($idMuestra);
                    if ($ensayosSinRevisar != false) {
                        if ($ensayosSinRevisar[0]["cantidad"] == 0) {
                            $dataA = $modelMuestra->updateEstadoByIdMuestra($idMuestra, 7);
                            if ($dataA != false) {
                                $modelMuestra->updateFechaConclusionByIdMuestra($idMuestra, date("Y-m-j H:i:s"));
                            }
                            $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                            $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 7, $_SESSION['userId'], $observaciones);
                        }
                    }
                }
            } else if ($idNewEstado == 10) {
                if ($estadoActual != 10) {
                    $modelMuestra->updateEstadoByIdMuestra($idMuestra, 10);
                    $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                    $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 10, $_SESSION['userId']);
                }
            } else if ($idNewEstado == 11) {
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 11);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                //$modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 11, $_SESSION['userId']);
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 11, $_SESSION['userId'], $observaciones);
            }
        } else {

            $modelViewEnsayosMuestraRef = new ViewEnsayoMuestraReferenciasDbModelClass();
            $modelTablaSubMuestra = new TablaSubMuestraEstDbModelClass();
            $modelTablaHistoricoEstadoSubMuestra = new TablaHistoricoEstadoSubMuestraDbModelClass();
            $ensayoMuestraData = $modelViewEnsayosMuestraRef->getEnsayoMuestraRefByIdEnsayoMuestra($idEnsayoMuestra);
            $idSubMuestra = $ensayoMuestraData[0]["id_sub_muestra"];
            $subMuestraData = $modelTablaSubMuestra->getSubMuestraById($idSubMuestra);
            $currentEstado = $subMuestraData[0]["estado"];
            if ($idNewEstado == 2) {
                switch ($currentEstado) {
                    case 1:
                        $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 2);
                        $fecha = date("Y-m-d");
                        $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 2, $_SESSION['userId'], "");
                        $this->updateEstadoMuestraEstabilidad($idMuestra);
                        break;
                    case 2 :
                        $ensayosSubMuestraData = $modelViewEnsayosMuestraRef->getSelectedEnsayosByIdSubMuestra($idSubMuestra);
                        $cantidadEnsayosSubMuestra = count($ensayosSubMuestraData);
                        $cantidadEnsayosSubMuestraProgramados = 0;
                        foreach ($ensayosSubMuestraData as $ensayoSubMuestra) {
                            if ($ensayoSubMuestra["estado_ensayo"] > 0) {
                                $cantidadEnsayosSubMuestraProgramados++;
                            }
                        }
                        if ($cantidadEnsayosSubMuestraProgramados == 0) {
                            $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 1);
                            $fecha = date("Y-m-d");
                            $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 1, $_SESSION['userId'], "");
                            updateEstadoMuestraEstabilidad($idMuestra);
                        } elseif ($cantidadEnsayosSubMuestraProgramados == $cantidadEnsayosSubMuestra) {
                            $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 3);
                            $fecha = date("Y-m-d");
                            $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 3, $_SESSION['userId'], "");
                            $this->updateEstadoMuestraEstabilidad($idMuestra);
                        }
                        break;
                    case 3:
                        $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 2);
                        $fecha = date("Y-m-d");
                        $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 2, $_SESSION['userId'], "");
                        $this->updateEstadoMuestraEstabilidad($idMuestra);
                        break;
                    case 5 :
                        $ensayosSubMuestraData = $modelViewEnsayosMuestraRef->getSelectedEnsayosByIdSubMuestra($idSubMuestra);
                        $cantidadEnsayosSubMuestra = count($ensayosSubMuestraData);
                        $cantidadEnsayosSubMuestraProgramados = 0;
                        foreach ($ensayosSubMuestraData as $ensayoSubMuestra) {
                            if ($ensayoSubMuestra["estado_ensayo"] > 0) {
                                $cantidadEnsayosSubMuestraProgramados++;
                            }
                        }
                        if ($cantidadEnsayosSubMuestraProgramados == 0) {
                            $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 1);
                            $fecha = date("Y-m-d");
                            $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 1, $_SESSION['userId'], "");
                            updateEstadoMuestraEstabilidad($idMuestra);
                        } elseif ($cantidadEnsayosSubMuestraProgramados == $cantidadEnsayosSubMuestra) {
                            $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 3);
                            $fecha = date("Y-m-d");
                            $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 3, $_SESSION['userId'], "");
                            $this->updateEstadoMuestraEstabilidad($idMuestra);
                        }
                        break;
                    default:
                        break;
                }
            } elseif ($idNewEstado == 5) {
                switch ($currentEstado) {
                    case 1:

                        break;
                    case 2:

                        break;
                    case 3:
                        $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 5);
                        $fecha = date("Y-m-d");
                        $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 5, $_SESSION['userId'], $observaciones);
                        $this->updateEstadoMuestraEstabilidad($idMuestra);
                    default:
                        break;
                }
            } elseif ($idNewEstado == 4) {
                switch ($currentEstado) {
                    case 1:

                        break;
                    case 2:

                        break;
                    case 3:
                        $ensayosSinResultados = $modelViewEnsayosMuestraRef->getCantidadEnsayosSinResultadosByIdSubMuestra($idSubMuestra);
                        if ($ensayosSinResultados == 0) {
                            $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 4);
                            $fecha = date("Y-m-d");
                            $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 4, $_SESSION['userId'], $observaciones);
                            $this->updateEstadoMuestraEstabilidad($idMuestra);
                        }
                        break;
                    default:
                        break;
                }
            } elseif ($idNewEstado == 7) {
                switch ($currentEstado) {
                    case 4:
                        $cantidadEnsayosSinRevisar = $modelViewEnsayosMuestraRef->getCantidadEnsayosSinRevisarByIdSubMuestra($idSubMuestra);
                        if ($cantidadEnsayosSinRevisar == 0) {
                            $modelTablaSubMuestra->updateEstadoById($idSubMuestra, 7);
                            $fecha = date("Y-m-d");
                            $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, 7, $_SESSION['userId'], $observaciones);
                            $this->updateEstadoMuestraEstabilidad($idMuestra);
                        }
                        break;
                    default:
                        break;
                }
            } elseif ($idNewEstado == 11) {
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 11);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, 11, $_SESSION['userId']);
                $modelTablaSubMuestra->anular($idMuestra);
                $subMuestrasData = $modelTablaSubMuestra->getSubmuestrasByIdMuestra($idMuestra);
                $fecha = date("Y-m-d");
                foreach ($subMuestrasData as $subMuestra) {
                    $modelTablaHistoricoEstadoSubMuestra->insertHistoricoEstadoSubMuestra($subMuestra["id"], $fecha, 11, $_SESSION['userId'], "");
                }
            }
        }
    }

    public function updateEstadoMuestraEstabilidad($idMuestra) {
        $modelMuestra = new TablaMuestraDbModelClass();
        $muestraData = $modelMuestra->getMuestraReferenciasById($idMuestra);
        $currentEstado = $muestraData[0]["id_estado_muestra"];
        $modelTablaSubMuestra = new TablaSubMuestraEstDbModelClass();
        $dataAux = $modelTablaSubMuestra->getMinEstadoByIdMuestra($idMuestra);
        $newEstado = $dataAux[0]["estado"];
        if ($currentEstado != $newEstado) {
            $modelMuestra->updateEstadoByIdMuestra($idMuestra, $newEstado);
            $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
            $modelHistoricoMuestra->insertHistoricoEstadoMuestra($idMuestra, $newEstado, $_SESSION['userId']);
        }
    }

    public function exportEstadosMuestra($data) {
        require_once dirname(__FILE__) . '/../utils/PHPexcel/Classes/PHPExcel.php';
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator($_SESSION["user_nombre"])
                ->setLastModifiedBy($_SESSION["user_nombre"])
                ->setTitle("PHPExcel")
                ->setSubject("PHPExcel Document");

        // Add some data
        $columnsData = array_keys($data[0]);
        $style = array('font' => array('size' => 12, 'bold' => true));
        $objPHPExcel->getActiveSheet()->getStyle('1')->applyFromArray($style);
        for ($i = 0; $i < count($columnsData); $i++) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval($i), '1', $columnsData[$i]);
        }
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval($j), strval($i + 2), $data[$i][$columnsData[$j]]);
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle('Estados muestra');


        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


        // Save Excel 2007 file
        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $nombreArchivo = 'EstadosMuestra-' . date('Y-m-d') . '.xls';
        $objWriter->save($nombreArchivo);
        $response = array('result' => 0, 'fileName' => $nombreArchivo);


        echo json_encode($response);
    }

    public function exportXLSData($data) {
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        /** Include PHPExcel */
        require_once dirname(__FILE__) . '/../utils/PHPexcel/Classes/PHPExcel.php';


// Create new PHPExcel object

        $objPHPExcel = new PHPExcel();

// Set document properties

        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("PHPExcel Test Document")
                ->setSubject("PHPExcel Test Document")
                ->setDescription("Test document for PHPExcel, generated using PHP classes.")
                ->setKeywords("office PHPExcel php")
                ->setCategory("Test result file");


// Add some data

        $columnsData = array_keys($data[0]);

        for ($i = 0; $i < count($columnsData); $i++) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval($i), '1', $columnsData[$i]);
        }
        for ($i = 0; $i < count($data); $i++) {
            for ($j = 0; $j < count($data[$i]); $j++) {

                $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicitByColumnAndRow(strval($j), strval($i + 2), $data[$i][$columnsData[$j]]);
            }
        }
//        $objPHPExcel->setActiveSheetIndex(0)
//                ->setCellValueExplicitByColumnAndRow('1', '1', 'Hello')
//            ->setCellValueExplicitByColumnAndRow('1', '2', 'Hello')
//                ->setCellValueExplicitByColumnAndRow('0', '3', 'Hello');
// Miscellaneous glyphs, UTF-8
// Rename worksheet

        $objPHPExcel->getActiveSheet()->setTitle('data');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file

        $callStartTime = microtime(true);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('exportData-' . $_SESSION["user_login"] . '.xlsx');
        $callEndTime = microtime(true);
        $callTime = $callEndTime - $callStartTime;
        $response = array('result' => 0, 'fileName' => 'exportData-' . $_SESSION["user_login"] . '.xlsx');


        echo json_encode($response);
    }

    public function cicloVidaMuestra($evento, $data) {
        switch ($evento) {
            case "analizarEnsayoMuestra":
                return $this->eventAnalizarEnsayoMuestra($data["id"]);
                break;
            case "guardarResultado":
                return $this->eventGuardarResultado($data["id"]);
                break;
            case "aprobarEnsayoMuestra":
                return $this->eventAprobarEnsayoMuestra($data);
                break;
            case "rechazarEnsayoMuestra":
                return $this->eventRechazarEnsayoMuestra($data);
                break;
            case "reprogramarEnsayoMuestra":
                return $this->eventReprogramarEnsayoMuestra($data);
                break;
            case "verificarMuestra":
                return $this->eventVerificarMuestra($data);
                break;
        }
    }

    public function eventVerificarMuestra($idMuestra) {
        $modelMuestra = new TablaMuestraDbModelClass();
        $modelMuestra->updateEstadoByIdMuestra($idMuestra, 17);
        $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
        $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 17, $_SESSION['userId'], "Muestra verificada");
    }

    public function eventReprogramarEnsayoMuestra($idMuestra) {
        $modelMuestra = new TablaMuestraDbModelClass();
        $modelMuestra->updateEstadoByIdMuestra($idMuestra, 5);
        $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
        $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 5, $_SESSION['userId'], "Reprogramacion ensayo");
    }

    public function eventRechazarEnsayoMuestra($idMuestra) {
        $totalEnsayosSeleccionados = $this->cantidadEnsayosMeustraSeleccionadosMuestra($idMuestra);
        $cantEnsayosRevisados = $this->cantidadEnsayosRevisados($idMuestra);
        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->getMuestraReferenciasDetalleById($idMuestra);
        $currentIdEstadoMuestra = $result[0]["id_estado_muestra"];
        if ($totalEnsayosSeleccionados == $cantEnsayosRevisados) {
            if ($currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 17 && $currentIdEstadoMuestra != 10 && $currentIdEstadoMuestra != 11) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 16);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 16, $_SESSION['userId'], "Rechazo de ensayo");
            }
        } else {
            if ($currentIdEstadoMuestra != 15 && $currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 10 && $currentIdEstadoMuestra != 11) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 15);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 15, $_SESSION['userId'], "Rechazo de ensayo");
            }
        }
    }

    public function eventAprobarEnsayoMuestra($idMuestra) {
        $totalEnsayosSeleccionados = $this->cantidadEnsayosMeustraSeleccionadosMuestra($idMuestra);
        $cantEnsayosRevisados = $this->cantidadEnsayosRevisados($idMuestra);
        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->getMuestraReferenciasDetalleById($idMuestra);
        $currentIdEstadoMuestra = $result[0]["id_estado_muestra"];
        if ($totalEnsayosSeleccionados == $cantEnsayosRevisados) {
            if ($currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 17 && $currentIdEstadoMuestra != 10 && $currentIdEstadoMuestra != 11) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 16);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 16, $_SESSION['userId'], "Aprobacion de ensayo");
            }
        } else {
            if ($currentIdEstadoMuestra != 15 && $currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 10 && $currentIdEstadoMuestra != 11) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 15);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 15, $_SESSION['userId'], "Aprobacion de ensayo");
            }
        }
    }

    public function eventGuardarResultado($idMuestra) {
        $totalEnsayosSeleccionados = $this->cantidadEnsayosMeustraSeleccionadosMuestra($idMuestra);
        $ensayosConResultado = $this->cantidadEnsayosConResultado($idMuestra);
        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->getMuestraReferenciasDetalleById($idMuestra);
        $currentIdEstadoMuestra = $result[0]["id_estado_muestra"];
        if ($totalEnsayosSeleccionados == $ensayosConResultado) {
            if ($currentIdEstadoMuestra != 4 && $currentIdEstadoMuestra != 15 && $currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 9 && $currentIdEstadoMuestra != 6 && $currentIdEstadoMuestra != 10) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 4);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 4, $_SESSION['userId'], "Registro de resultado");
            }
        } else {
            if ($currentIdEstadoMuestra != 14 && $currentIdEstadoMuestra != 4 && $currentIdEstadoMuestra != 15 && $currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 9 && $currentIdEstadoMuestra != 6 && $currentIdEstadoMuestra != 10) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 14);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 14, $_SESSION['userId'], "Registro de resultado");
            }
        }
    }

    public function eventAnalizarEnsayoMuestra($idMuestra) {
        $totalEnsayosSeleccionados = $this->cantidadEnsayosMeustraSeleccionadosMuestra($idMuestra);
        $EnsayosEnAnalisisOSuperior = $this->cantidadEnsayosMuestraAnalisisOMayor($idMuestra);
        $tablaMuestra = new TablaMuestraDbModelClass();
        $result = $tablaMuestra->getMuestraReferenciasDetalleById($idMuestra);
        $currentIdEstadoMuestra = $result[0]["id_estado_muestra"];
        if ($totalEnsayosSeleccionados == $EnsayosEnAnalisisOSuperior) {
            if ($currentIdEstadoMuestra != 13 && $currentIdEstadoMuestra != 14 && $currentIdEstadoMuestra != 4 && $currentIdEstadoMuestra != 15 && $currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 9 && $currentIdEstadoMuestra != 6 && $currentIdEstadoMuestra != 10) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 13);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 13, $_SESSION['userId'], "Confirmación analisis de ensayo");
            }
        } else {
            if ($currentIdEstadoMuestra != 12 && $currentIdEstadoMuestra != 13 && $currentIdEstadoMuestra != 14 && $currentIdEstadoMuestra != 4 && $currentIdEstadoMuestra != 15 && $currentIdEstadoMuestra != 16 && $currentIdEstadoMuestra != 9 && $currentIdEstadoMuestra != 6 && $currentIdEstadoMuestra != 10) {
                $modelMuestra = new TablaMuestraDbModelClass();
                $modelMuestra->updateEstadoByIdMuestra($idMuestra, 12);
                $modelHistoricoMuestra = new TablaHistoricoEstadoMuestraDbModelClass();
                $modelHistoricoMuestra->insertHistoricoEstadoMuestraObservaciones($idMuestra, 12, $_SESSION['userId'], "Confirmación analisis de ensayo");
            }
        }
    }

    public function cantidadEnsayosMeustraSeleccionadosMuestra($idMuestra) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->getEnsayosSeleccionadosByIdMuestra($idMuestra);
        return count($result["data"]);
    }

    public function cantidadEnsayosMuestraAnalisisOMayor($idMuestra) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->getEnsayosAnalisisOMayor($idMuestra);
        return count($result["data"]);
    }

    public function cantidadEnsayosConResultado($idMuestra) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->getEnsayosConResultado($idMuestra);
        return count($result["data"]);
    }

    public function cantidadEnsayosRevisados($idMuestra) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->getEnsayosRevisadosByIdMuestra($idMuestra);
        return count($result["data"]);
    }

}
