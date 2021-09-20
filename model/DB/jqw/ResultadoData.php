<?php

require '../TablaResultadoDbModelClass.php';
require '../TablaResultadoMediosCultivoDbModelClass.php';
require '../TablaResultadoCepasDbModelClass.php';

require '../../DbClass.php';



if($_GET['query'] == 'getResultadoByIdEnsayoMuestra'){
    $TablaResultadoModel = new TablaResultadoDbModelClass();
    $data = $TablaResultadoModel->getResultadoByIdEnsayoMuestra($_GET['idEnsayoMuestra']);
    if($data != false){
        $tablaResultadoMedios = new TablaResultadoMediosCultivoDbModelClass();
        $tablaResultadoCepas = new TablaResultadoCepasDbModelClass();
        foreach ($data as $resultado) {
            $resultadoMediosResult = $tablaResultadoMedios->getMediosByIdResultado($resultado['id']);
            if($resultadoMediosResult["code"] === "00000"){
                $medios = null;
                foreach ($resultadoMediosResult["data"] as $resultadoMedio) {
                    $medios[] = array(
                        "id" => $resultadoMedio["id"],
                        "idResultado" => $resultadoMedio["id_resultado"],
                        "idMedio" => $resultadoMedio["id_estandar"]
                    );
                }
            } else {
                $medios[] = array();
            }
            $resultadoCepasResult = $tablaResultadoCepas->getCepasByIdResultado($resultado['id']);
            if($resultadoCepasResult["code"] === "00000"){
                $cepas = null;
                foreach ($resultadoCepasResult["data"] as $resultadoCepa) {
                    $cepas[] = array(
                        "id" => $resultadoCepa["id"],
                        "idResultado" => $resultadoCepa["id_resultado"],
                        "idMedio" => $resultadoCepa["id_reactivo"]
                    );
                }
            } else {
                $cepas[] = array();
            }
            $response[] = array(
                'id' => $resultado['id'],
                'idEnsayoMuestra' => $resultado['id_ensayo_muestra'],
                'idLote' => $resultado['id_lote'],
                "resultadoNumerico" => (double)$resultado["resultado_numerico"],
                'resultado' => $resultado['resultado'],
                'observaciones' => $resultado['observaciones'],
                'idUsuarioRegistro' => $resultado['id_usuario_registro'],
                'fechaRegistro' => $resultado['fecha_registro'],
                'nombreAnalistaAsignado' => $resultado['nombreAnalistaAsignado'],
                'numeroLote' => $resultado['numeroLote'],
                "mediosCultivo" => $medios,
                "cepas" => $cepas,
                "resultado1" => $resultado['resultado_1'],
                "resultado2" => $resultado['resultado_2']
            );
        }
    } else {
        $response = null;
    }
    echo json_encode($response);
}
