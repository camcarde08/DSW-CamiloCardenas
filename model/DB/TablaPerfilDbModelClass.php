<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaPerfilDbModelClass
 *
 * @author hruge
 */
class TablaPerfilDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getPerfilByID($id_perfil) {

        $query = "SELECT * FROM sgm_perfil WHERE id = $id_perfil";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getAllPerfiles() {
        $SQL = "SELECT id, nombre as perfil FROM sgm_perfil ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
            return $data;
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

    function getAllPerfil() {
        $query = "SELECT * FROM sgm_perfil order by nombre";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllPerfil2() {
        $SQL = "SELECT * FROM sgm_perfil order by nombre";
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

    function getPerfilByIdToAud($id){
        $perfil = Perfil::find($id);
        $perfil->permisos;
        $perfil->permisosBandejaEntrada;
        return $perfil->toJson();
    }
}
