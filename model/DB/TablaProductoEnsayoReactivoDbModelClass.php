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
class TablaProductoEnsayoReactivoDbModelClass {

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function deleteProductoEnsayoReactivo($idReactivo, $idProductoEnsayo) {
        $SQL = "DELETE FROM sgm_producto_ensayo_reactivo WHERE id_producto_ensayo = ? and id_reactivo=?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);
        $query->bindParam(2, $idReactivo);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
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

    function insertProductoEnsayoReactivo($idProductoEnsayo, $idReactivo) {
        $SQL = "INSERT INTO sgm_producto_ensayo_reactivo (id_producto_ensayo,id_reactivo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);
        $query->bindParam(2, $idReactivo);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            if ($error[1] == 1062) {
                return array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => "Reactivo ya asignado"
                );
            } else {
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

    function getReactivoLoteProductoEnsayo($idProductoEnsayo) {
        $SQL = "SELECT tb1.id_reactivo, tb2.id as id_lote "
                . "FROM sgm_producto_ensayo_reactivo tb1 "
                . "left join sgm_lote_reactivo tb2 on tb2.id_reactivo = tb1.id_reactivo and tb2.activo = 1 "
                . "where tb1.id_producto_ensayo = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);

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
