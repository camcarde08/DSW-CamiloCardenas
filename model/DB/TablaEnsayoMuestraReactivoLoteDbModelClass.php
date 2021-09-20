<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEnsayoEquipoDbModelClass
 *
 * @author Andres Ruge
 */
class TablaEnsayoMuestraReactivoLoteDbModelClass {

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function insertProductoEnsayoReactivo($idEnsayoMuestra, $idReactivo, $idLote) {
        $SQL = "INSERT INTO sgm_ensayo_muestra_reactivo_lote (id_ensayo_muestra,id_reactivo, id_lote) "
                . "VALUES (?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        
        $query->bindParam(1, $idEnsayoMuestra);
        $query->bindParam(2, $idReactivo);
        $query->bindParam(3, $idLote);

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
                "data" => array("errorDb" => $error)
            );
        }
    }

}
