<?php

/**
 * Created by PhpStorm.
 * User: hruge
 * Date: 12/03/2017
 * Time: 12:51 PM
 */
class ResultadoController
{
    public function guardarResultado($muestraData,$idMuestra,$idEnsayoMuestra,$idLote,$resultado,$observaciones,$usuarioRegistro,$fechaRegistro,$resultadoNumerico,$resultado1,$resltado2){
        $tablaResultado = new TablaResultadoDbModelClass();
        $result = $tablaResultado->insertResultado2($idEnsayoMuestra,$idLote,$resultado,$observaciones,$usuarioRegistro,$fechaRegistro,$resultadoNumerico,$resultado1,$resltado2);
        if($result["code"] == "00000"){
            $tablaEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
            $tablaEnsayoMuestra->updateEstadoByIdEnsayoMuestra2($idEnsayoMuestra,5);
            $generalController = new GeneralController();
            $generalController->cicloVidaMuestra("guardarResultado",$muestraData);
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else{
            $response = array(
                "code" => "00001",
                "message" => "error al guardar resultado",
                "data" => array(
                    "errorDb" => $result
                )
            );
        }
        return $response;
    }


}