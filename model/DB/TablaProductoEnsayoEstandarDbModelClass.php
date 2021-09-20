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
class TablaProductoEnsayoEstandarDbModelClass {

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function deleteProductoEnsayoEstandar($idEstandar, $idProductoEnsayo) {
        $SQL = "DELETE FROM sgm_producto_ensayo_estandar WHERE id_producto_ensayo = ? and id_estandar=?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);
        $query->bindParam(2, $idEstandar);

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

    function insertProductoEnsayoEstandar($idProductoEnsayo, $idEstandar) {
        $SQL = "INSERT INTO sgm_producto_ensayo_estandar (id_producto_ensayo,id_estandar) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);
        $query->bindParam(2, $idEstandar);

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
                    "data" => "Estándar ya asignado"
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

    function getEstandarLoteProductoEnsayo($idProductoEnsayo) {
        $SQL = "SELECT tb1.id_estandar, tb2.id as id_lote "
                . "FROM sgm_producto_ensayo_estandar tb1 "
                . "left join sgm_lote_estandar tb2 on tb2.id_estandar = tb1.id_estandar and tb2.activo = 1 "
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
