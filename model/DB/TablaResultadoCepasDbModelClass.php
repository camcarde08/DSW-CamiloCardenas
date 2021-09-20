<?php

class TablaResultadoCepasDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function insertResultadoCepas($idResultado, $idReactivo) {
        $SQL = "INSERT INTO sgm_resultado_cepas (id_resultado,id_reactivo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idResultado);
        $query->bindParam(2, $idReactivo);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => array(
                    "insertId" => $this->dbClass->getConexion()->lastInsertId()
                )
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorSQL" => $query->errorInfo()
                )
            );
        }
        return $response;
    }

    public function getCepasByIdResultado($idResultado) {
        $SQL = "SELECT * FROM sgm_resultado_cepas WHERE id_resultado = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idResultado);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll()
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorSQL" => $query->errorInfo()
                )
            );
        }
        return $response;
    }

    public function deleteCepasByIdResultado($idResultado) {
        $SQL = "DELETE FROM sgm_resultado_cepas WHERE id_resultado = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idResultado);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll()
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorSQL" => $query->errorInfo()
                )
            );
        }
        return $response;
    }

}
