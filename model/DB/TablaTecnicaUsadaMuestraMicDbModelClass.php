<?php


class TablaTecnicaUsadaMuestraMicDbModelClass {
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertTecnicaUsadaMuestraMic($idMuestraDetalleMic, $idMetodo){
        $SQL = "INSERT INTO sgm_tecnica_usada_muestra_mic (id_muestra_detalle_mic,id_metodo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestraDetalleMic);
        $query->bindParam(2, $idMetodo);
        if ($query->execute()) {
            $response = array(
                "code" => "0",
                "message" => "Insert tecnica usada muestra mic success",
                "data" => array(
                    "idTecnicaUsadaMuestraMic" => $this->dbClass->getConexion()->lastInsertId()
                )
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "RM-ITUMM-00001", "message" => "error en insert de la tabla sgm_tecnica_usada_muestra_mic", "data" => $error
            );
        }
        return $response;
    }
    
    function getTecnicaUsadaByIdMuestraDetalleMic($idMuestraDetalleMic){
        $SQL = "SELECT * FROM sgm_tecnica_usada_muestra_mic WHERE id_muestra_detalle_mic = ? ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestraDetalleMic);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_tecnica_usada_muestra_mic", "data" => $error
            );
        }
        return $response;
    }
    
    function deleteTecnicasUsadasByIdDetalleMuestraMic($idDetalleMuestraMic){
        $SQL = "DELETE FROM sgm_tecnica_usada_muestra_mic WHERE id_muestra_detalle_mic = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idDetalleMuestraMic);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en delete de la tabla sgm_tecnica_usada_muestra_mic", "data" => $error
            );
        }
        return $response;
    }
}
