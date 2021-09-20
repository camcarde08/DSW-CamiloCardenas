<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEmpaqueDbModelClass
 *
 * @author lvelasquez
 */
class TablaEmpaqueDbModelClass {

    //put your code here


    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllEmpaques() {

        $query = "SELECT * FROM sgm_empaque ORDER BY descripcion ASC";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllEmpaqueAsociado() {

        $query = "SELECT DISTINCT t1.* FROM sgm_empaque t1 "
                . "JOIN sgm_muestra t2 ON t2.id_empaque = t1.id "
                . "WHERE t2.id_empaque = t1.id;";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = false;
        }
        return $data;
    }

    function insertEmpaque($descripcionEmpaque) {
        $query = "INSERT INTO sgm_empaque (descripcion) VALUES ('$descripcionEmpaque')";
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

    function actualizarEnvase($descripcion, $id) {
        $SQL = "UPDATE sgm_empaque SET descripcion = ? WHERE id = ?";
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

    function borrarEnvase($id) {
        $SQL = "DELETE FROM sgm_empaque WHERE id = ?";
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

    function getEmpaqueByIdToAud($id) {

        $empaque = Empaque::find($id);
        return $empaque->toJson();
    }

}
