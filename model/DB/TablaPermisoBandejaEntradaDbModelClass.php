<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaPerfilPermisoDbModelClass
 *
 * @author andres
 */
class TablaPermisoBandejaEntradaDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllPermisosBandejaEntrada() {
        $SQL = "SELECT * FROM sgm_permiso_bandeja_entrada";
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

}
