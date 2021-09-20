<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaMetodoDbModelClass
 *
 * @author andres
 */
class TablaMetodoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllMetodo() {
        $SQL = "select * from sgm_metodo where activo = 1 order by descripcion ASC";

        $query = $this->dbClass->getConexion()->prepare($SQL);

        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function insertMetodo($nombre) {
        $activo = 1;
        $SQL = "INSERT INTO sgm_metodo (descripcion,activo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $activo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    function updateActivoById($id) {
        $activo = 0;

        $SQL = "UPDATE sgm_metodo SET activo = ? WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $activo);
        $query->bindParam(2, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function updateMetodoById($nombre, $id) {
        $SQL = "UPDATE sgm_metodo SET descripcion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function getMetodoByIdToAud($id) {
        $metodo = Metodo::find($id);
        return $metodo->toJson();
    }

}
