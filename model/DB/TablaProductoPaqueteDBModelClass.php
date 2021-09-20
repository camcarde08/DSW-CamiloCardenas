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
class TablaProductoPaqueteDBModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllProductoPaquete($idProducto) {
        $SQL = "SELECT t1.*, t2.nombre as producto, t3.descripcion as ensayo FROM sgm_producto_paquete t1 JOIN sgm_producto t2 on t1.id_producto = t2.id JOIN sgm_ensayo t3 on t1.id_ensayo = t3.id WHERE id_producto = ? order by t3.descripcion;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function insertProductoPaquete($idProducto, $idPaquete) {
        $SQL = "INSERT INTO sgm_producto_paquete (id_producto,id_ensayo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idPaquete);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    function deleteProductoPaquete($idProductoPaquete) {
        $SQL = "DELETE FROM sgm_producto_paquete WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoPaquete);


        if ($query->execute()) {
            return true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    function getAllProductoPaquete2($idProducto) {
        $SQL = "SELECT t1.id as id_producto_paquete, t1.id_ensayo as id_paquete, t2.nombre as producto, t3.descripcion as paquete 
                FROM sgm_producto_paquete t1 
                JOIN sgm_producto t2 on t1.id_producto = t2.id 
                JOIN sgm_ensayo t3 on t1.id_ensayo = t3.id 
                WHERE id_producto = ? order by t3.descripcion;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllProductoPaqueteByPaquete($idPaquete) {
        $SQL = "select * from sgm_producto_paquete where id_ensayo = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ));
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

    function deleteProductoPaquete2($idProductoPaquete) {
        $SQL = "DELETE FROM sgm_producto_paquete WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoPaquete);

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

    function insertProductoPaquete2($idProducto, $idPaquete) {
        $SQL = "INSERT INTO sgm_producto_paquete (id_producto,id_ensayo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idPaquete);

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

    function deleteProductoPaqueteByIdPaquete($idPaquete) {
        $SQL = "DELETE FROM sgm_producto_paquete "
                . "WHERE id_ensayo = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK"
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
