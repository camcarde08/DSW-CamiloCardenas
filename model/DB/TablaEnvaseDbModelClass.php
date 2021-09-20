<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEnvaseDbModelClass
 *
 * @author lvelasquez
 */
class TablaEnvaseDbModelClass {

    //put your code here

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllEnvase() {

        $query = "SELECT * FROM sgm_envase ORDER BY descripcion ASC";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getAllFormasFarmaceuticasAsociadas() { 
 
        $query = "SELECT DISTINCT t1.* FROM sgm_envase t1 " 
                . "JOIN sgm_muestra t2 ON t2.id_envase = t1.id " 
                . "WHERE t2.id_envase = t1.id;"; 
        $query = $this->dbClass->getConexion()->prepare($query); 
        if ($query->execute()) { 
            $data = $query->fetchAll(PDO::FETCH_OBJ); 
        } else { 
            $data = false; 
        } 
        return $data; 
    }

    function insertEnvase($descripcionEnvase) {
        $query = "INSERT INTO sgm_envase (descripcion) VALUES ('$descripcionEnvase')";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
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

    function actualizarFormaFarmaceutica($descripcion, $id) {
        $SQL = "UPDATE sgm_envase SET descripcion = ? WHERE id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);
        $query->bindParam(2, $id);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
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

    function borrarFormaFarmaceutica($id) {
        $SQL = "DELETE FROM sgm_envase WHERE id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
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
    
    function getEnvaseByIdToAud($id) {

        $envase = Envase::find($id);
        return $envase->toJson();
    }

}
