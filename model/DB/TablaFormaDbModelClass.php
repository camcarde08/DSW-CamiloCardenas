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
class TablaFormaDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function getAllFormas() {
        $SQL = "SELECT * FROM sgm_forma_farmaceutica ORDER BY descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function insertForma($descripcion) {
        $SQL = "INSERT INTO sgm_forma_farmaceutica (descripcion) VALUES (?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);


        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    public function updateForma($idForma, $descripcionForma) {
        $SQL = "UPDATE sgm_forma_farmaceutica SET descripcion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcionForma);
        $query->bindParam(2, $idForma);

        if ($query->execute()) {
            return true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    public function getAllFormas2() {
        $SQL = "SELECT * FROM sgm_forma_farmaceutica ORDER BY descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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
    
    function getFormaByIdToAud($id) {
        $formaFarmaceutica = FormaFarmaceutica::find($id);
        return $formaFarmaceutica->toJson();
    }

}
