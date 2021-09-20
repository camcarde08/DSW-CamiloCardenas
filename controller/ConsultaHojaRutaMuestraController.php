<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ConsultaHojaRutaMuestraController
 *
 * @author andres
 */
class ConsultaHojaRutaMuestraController {

    public function registrarConclusionSubmuestra($idSubMuestra, $conclusion) {
        $modelTablaSubMuestra = new TablaSubMuestraEstDbModelClass();
        if ($modelTablaSubMuestra->updateConclusionBiIdSubMuestra($idSubMuestra, $conclusion)) {
            $response = array('result' => 0, 'message' => 'Se registro la conclusion exitosamente');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo el registro de la conclusion');
        }
        echo json_encode($response);
    }

    public function updateResultado($idResultado, $idLote, $resultado, $observaciones, $idUsuario, $fechaRegistro, $resultado1, $resultado2, $medios, $cepas, $resultadoNumerico) {
        $medios = json_decode(stripslashes($medios));
        $cepas = json_decode(stripslashes($cepas));

        $modelTablaResultado = new TablaResultadoDbModelClass();
        $update = $modelTablaResultado->updateResultadoById($idResultado, $idLote, $resultado, $observaciones, $idUsuario, $fechaRegistro, $resultado1, $resultado2,$resultadoNumerico);
        if ($update == true) {
            $tablaResultadoMedios = new TablaResultadoMediosCultivoDbModelClass();
            $resultDeleteMedios = $tablaResultadoMedios->deleteMediosByIdResultado($idResultado);
            if ($resultDeleteMedios["code"] == "00000") {
                $insertNewMedios = true;
                foreach ($medios as $medio) {
                    $resultInsertNewMedios = $tablaResultadoMedios->insertResultadoMedioCultivo($idResultado, $medio->id);
                    if ($resultInsertNewMedios["code"] != "00000") {
                        $insertNewMedios = false;
                        break;
                    }
                }
                if ($insertNewMedios) {
                    $tablaResultadoCepas = new TablaResultadoCepasDbModelClass();
                    $resultDeleteCepas = $tablaResultadoCepas->deleteCepasByIdResultado($idResultado);
                    if ($resultDeleteCepas["code"] == "00000") {
                        $insertNewCepas = true;
                        foreach ($cepas as $cepa) {
                            $resultInsertCepa = $tablaResultadoCepas->insertResultadoCepas($idResultado, $cepa->id);
                            if ($resultInsertCepa["code"] != "00000") {
                                $insertNewCepas = false;
                                break;
                            }
                        }
                        if ($insertNewCepas) {
                            $response = array('result' => 0, 'message' => 'Se actualizo correctamente el resultado');
                        } else {
                            $response = array('result' => 1, 'message' => 'Fallo al insertar las nuevas cepas');
                        }
                    } else {
                        $response = array('result' => 1, 'message' => 'Fallo al eliminar las cepas anteriores');
                    }
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo al insertar los nuevos medios de cultivo');
                }
            } else {
                $response = array('result' => 1, 'message' => 'Fallo al borrar los medios de cultivo anteriores');
            }
        } else {
            $response = array('result' => 1, 'message' => 'Fallo al actualizar el resultado');
        }
        echo json_encode($response);
    }

    public function rechazaMuestra($idMuestra) {
        $generalController = new GeneralController();
        $generalController->updateEstadoByIdMuestra($idMuestra, 6, null);
        $response = array('result' => '1', 'message' => 'Se guardo correctamente el resultado');
        echo json_encode($response);
    }

    public function reprogramarEnsayoMuestra($idEnsayoMuestra, $observaciones) {
        $modelEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        if ($modelEnsayoMuestra->updateEstadoByIdEnsayoMuestraTo0($idEnsayoMuestra)) {
            $modelProgramacionAnalista = new TablaProgramacionAnalistasDbModelClass();
            $modelProgramacionAnalista->deleteProgramacionByIdEnsayoMuestra($idEnsayoMuestra);
            $data = $modelEnsayoMuestra->getMuestraByIdEnsayoMuestra($idEnsayoMuestra);
            $idMuestra = $data[0]['id_muestra'];

            $generalController = new GeneralController();
            $generalController->updateEstadoByIdMuestra($idMuestra, 5, $observaciones, $idEnsayoMuestra);

            $response = array('result' => '1', 'message' => 'Se guardo correctamente el resultado');
            echo json_encode($response);
        } else {

            $response = array('result' => '0', 'message' => 'fallo al guaradar el resultado');
            echo json_encode($response);
        }
    }

    public function paintConsultaHojaRutaMuestra() {
        $consultaHojaRutaMuestraModel = new ConsultaHojaRutaMuestraModelClass();
        $consultaHojaRutaMuestraModel->paintConsultaHojaRutaMuestra();
    }

    public function paintHojaRutaPrint() {
        $consultaHojaRutaMuestraModel = new ConsultaHojaRutaMuestraModelClass();
        $consultaHojaRutaMuestraModel->paintHojaRutaPrint();
    }

    public function revisarEnsayoMuestraConHojaRutaMuestra($idEnsayoMuestra, $aprobado, $tipoRevision, $observaciones) {
        $tablaEnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        if ($tipoRevision == "Aprobar") {
            $newEstado = 3;
        } elseif ($tipoRevision == "Rechazar") {
            $newEstado = 2;
        }
        if ($aprobado == true) {
            $newAprobado = 1;
        } else {
            $newAprobado = 0;
        }

        if ($tablaEnsayoMuestraModel->updateAprobadoEnsayoMuestraByIdEnsayoMuestra($idEnsayoMuestra, $newAprobado, $newEstado, $_SESSION['userId'], $observaciones)) {
            $muestra = $tablaEnsayoMuestraModel->getMuestraByIdEnsayoMuestra($idEnsayoMuestra);

            if ($muestra != false) {
                $idMuestra = $muestra[0]["id_muestra"];
                $generalController = new GeneralController();
                $generalController->updateEstadoByIdMuestra($idMuestra, 7, $observaciones, $idEnsayoMuestra);
            }
            $response = array('result' => 0, 'message' => 'Se registro la revision del ensayo exitosamente');
        } else {
            $response = array('result' => 1, 'message' => 'Fallo la revision del ensayo');
        }
        echo json_encode($response);
    }

    public function updateEnsayoConHojaRutaMuestra($idEnsayoMuestra, $aprobado, $tipoRevision, $observaciones) {
        $tablaEnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        if ($tablaEnsayoMuestraModel->updateMetodoAprobacionFromConHojaRutaMuestra($idEnsayoMuestra, $metodo, $aprobado)) {
            $ensayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
            $data = $ensayoMuestraModel->getMuestraByIdEnsayoMuestra($idEnsayoMuestra);
            $idMuestra = $data[0]['id_muestra'];
            $generalController = new GeneralController();
            $generalController->updateEstadoByIdMuestra($idMuestra, 8, $observaciones);
            $response = array('result' => '1', 'message' => 'Se ha actualizado el ensayo');
            echo json_encode($response);
        } else {
            $response = array('result' => '0', 'message' => 'fallo la actualizació el ensayo');
            echo json_encode($response);
        }
    }

    public function saveResultado($idEnsayoMuestra, $idLote, $resultado, $observaciones, $usuarioRegistro, $fechaRegistro, $resultadoNumerico, $resultado1, $resultado2, $mediosCultivo, $cepas) {
        $tablaResultadoModel = new TablaResultadoDbModelClass();
        if ($idLote == "Please Choose:") {
            $idLote = null;
        }
        $result = $tablaResultadoModel->insertResultado($idEnsayoMuestra, $idLote, $resultado, $observaciones, $usuarioRegistro, $fechaRegistro, $resultadoNumerico, $resultado1, $resultado2);
        if ($result != false) {
            $tablaResultadoMedios = new TablaResultadoMediosCultivoDbModelClass();
            foreach ($mediosCultivo as $medio) {
                $tablaResultadoMedios->insertResultadoMedioCultivo($result, $medio);
            }

            $tablaResultadoCepas = new TablaResultadoCepasDbModelClass();
            foreach ($cepas as $cepa) {
                $tablaResultadoCepas->insertResultadoCepas($result, $cepa);
            }

            $ensayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
            $data = $ensayoMuestraModel->getMuestraByIdEnsayoMuestra($idEnsayoMuestra);
            $idMuestra = $data[0]['id_muestra'];
            $generalController = new GeneralController();
            $generalController->updateEstadoByIdMuestra($idMuestra, 4, "", $idEnsayoMuestra);

            $response = array('result' => 0, 'message' => 'Se guardo correctamente el resultado');
        } else {
            $response = array('result' => 1, 'message' => 'fallo al guaradar el resultado');
        }
        echo json_encode($response);
    }

    public function validarEnsayosSubMuestra($idMuestra) {
        $modelTablaSubMuestra = new TablaSubMuestraEstDbModelClass();
        $subMuestraData = $modelTablaSubMuestra->getSubmuestrasSinFinalizarByIdMuestra($idMuestra);
        $response = array('result' => 1, 'message' => 'no se finalizo ninguna sub muestra');
        if ($subMuestraData != false) {
            foreach ($subMuestraData as $subMuestra) {
                $modelViewEnsayoMuestraRef = new ViewEnsayoMuestraReferenciasDbModelClass();
                $cantidadEnsayosSinRevisar = $modelViewEnsayoMuestraRef->getCantidadEnsayosSinRevisarByIdSubMuestra($subMuestra["id"]);
                if ($cantidadEnsayosSinRevisar == 0) {
                    $response = array('result' => 0, 'message' => 'la submuestra' . $subMuestra["id"] . 'se finalizo', 'idSubMuestra' => (int) $subMuestra["id"], 'duracion' => $subMuestra["duracion"]);
                    break;
                }
            }
        }
        echo json_encode($response);
    }

}
