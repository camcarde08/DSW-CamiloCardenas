<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaUbicacionDbModelClass
 *
 * @author andres
 */
class TablaTIpoIdentificacionDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllTipo() {
        $SQL = "select  * from sgm_tipo_identificacion; ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getTipoIdentificaciones() {
        $SQL = "select * from sgm_tipo_identificacion order by tipo_identificacion asc";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_tipo_identificacion", "data" => $error
            );
        }
        return $response;
    }

}
