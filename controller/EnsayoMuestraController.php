<?php

/**
 * Created by PhpStorm.
 * User: hruge
 * Date: 12/03/2017
 * Time: 12:36 AM
 */
class EnsayoMuestraController {

    function reprogramarEnsayoMuestra($idMuestra, $idEnsayoMuestra, $motivo, $fechaReprog) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->updateEstadoByIdEnsayoMuestraReprogramacion($idEnsayoMuestra, 6, $motivo, $fechaReprog);
        if ($result["code"] == "00000") {
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("reprogramarEnsayoMuestra", $idMuestra);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "error al aprobar Ensayo muestra",
                "data" => array(
                    "errorDb" => $result
                )
            );
        }
        return $response;
    }

    function rechazarEnsayoMuestra($idMuestra, $idEnsayoMuestra) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->updateEstadoByIdEnsayoMuestra2($idEnsayoMuestra, 2);
        if ($result["code"] == "00000") {
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("rechazarEnsayoMuestra", $idMuestra);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "error al aprobar Ensayo muestra",
                "data" => array(
                    "errorDb" => $result
                )
            );
        }
        return $response;
    }

    function rechazarEnsayoMuestraRfe($idMuestra, $idEnsayoMuestra, $razon, $RFE) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->updateEstadoByIdEnsayoMuestra2RFE($idEnsayoMuestra, 2, $razon, $RFE);
        if ($result["code"] == "00000") {
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("rechazarEnsayoMuestra", $idMuestra);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "error al aprobar Ensayo muestra",
                "data" => array(
                    "errorDb" => $result
                )
            );
        }
        return $response;
    }

    function analizarEnsayoMuestra($muestraData, $idEnsayoMuestra, $fechaAnalisis) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $resultAnalizarEnsayoMuestra = $tablaEnsayoMuestra->analizarEnsayoMuestra($fechaAnalisis, $idEnsayoMuestra);
        if ($resultAnalizarEnsayoMuestra["code"] == "00000") {
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("analizarEnsayoMuestra", $muestraData);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "error al actualizar Ensayo muestra",
                "data" => array(
                    "errorDb" => $resultAnalizarEnsayoMuestra
                )
            );
        }
        return $response;
    }

    function aprobarEnsayoMuestra($idMuestra, $idEnsayoMuestra) {
        $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
        $result = $tablaEnsayoMuestra->updateEstadoByIdEnsayoMuestra2($idEnsayoMuestra, 3);
        if ($result["code"] == "00000") {
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("aprobarEnsayoMuestra", $idMuestra);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "error al aprobar Ensayo muestra",
                "data" => array(
                    "errorDb" => $result
                )
            );
        }
        return $response;
    }

}
