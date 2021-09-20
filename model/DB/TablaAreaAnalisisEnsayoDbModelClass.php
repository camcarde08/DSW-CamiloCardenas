<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEquiposDbModelClass
 *
 * @author andres
 */
class TablaAreaAnalisisEnsayoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function insertAreaAnalisisEnsayo($idArea, $idEnsayo) {
        $SQL = "INSERT INTO sgm_ensayo_area_analisis (id_ensayo,id_area_analisis) VALUES (?, ?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        $query->bindParam(2, $idArea);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    function getAreaAnalisisEnsayoByIdEnsayo($idEnsayo) {
        $SQL = "SELECT * from sgm_ensayo_area_analisis WHERE id_ensayo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function updateAreaAnalisisEnsayo($idArea, $idEnsayo) {
        $SQL = "UPDATE sgm_ensayo_area_analisis SET id_area_analisis = ? WHERE id_ensayo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idArea);
        $query->bindParam(2, $idEnsayo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $idEnsayo
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

}
