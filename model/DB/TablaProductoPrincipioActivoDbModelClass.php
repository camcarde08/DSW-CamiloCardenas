<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaProductoDBModelClass
 *
 * @author lvelasquez
 */
class TablaProductoPrincipioActivoDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function deleteProductoPrincipio($idProductoPrincipio) {
        $SQL = "DELETE FROM sgm_producto_principio_activo WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoPrincipio);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK");
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

    function insertProductoPrincipio($idProducto, $idPrincipio) {
        $SQL = "INSERT INTO sgm_producto_principio_activo (id_producto,id_principio_activo,"
                . "principal,trasador,cantidad,unidad_cantidad,cantidad_decimal) "
                . "VALUES (?,?,1,1,1,1,1);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idPrincipio);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId());
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
