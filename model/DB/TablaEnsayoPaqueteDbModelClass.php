<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEquiposDbModelClass
 *
 * @author andres
 */
class TablaEnsayoPaqueteDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function selectProductoPaqueteByIdEnsPaq($idEnsayoPaquete) {
        $SQL = "SELECT tbl3.id as id_producto_ensayo, tbl1.id as id_producto_paquete, "
                . "tbl2.id_ensayo, tbl2.id_paquete "
                . "FROM sgm_producto_paquete tbl1 "
                . "join sgm_ensayo_paquete tbl2 on tbl2.id_paquete = tbl1.id_ensayo "
                . "join sgm_producto_ensayo tbl3 on tbl3.id_producto_paquete = tbl1.id and tbl3.id_ensayo = tbl2.id_ensayo "
                . "where tbl2.id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoPaquete);
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

    function deleteEnsayoPaqueteById($idEnsayoPaquete) {
        $SQL = "DELETE FROM sgm_ensayo_paquete WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoPaquete);

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

    function getEnsayosPaquetesByIdPaquete($idPaquete) {
        $SQL = "SELECT t1.*, t2.descripcion, t2.tiempo, t2.precio_real FROM sgm_ensayo_paquete t1 JOIN sgm_ensayo t2 on t1.id_ensayo = t2.id WHERE t1.id_paquete = ? ORDER BY t2.descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayosPaquetesByIdPaquete2($idPaquete) {
        $SQL = "SELECT t1.*, t2.descripcion, t2.tiempo, t2.precio_real FROM sgm_ensayo_paquete t1 JOIN sgm_ensayo t2 on t1.id_ensayo = t2.id WHERE t1.id_paquete = ? ORDER BY t2.descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);
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

    function getEnsayosDisponiblesByIdPaquete($idPaquete) {
        $SQL = "select t1.id,t1.descripcion,t1.tiempo, t1.precio_real from sgm_ensayo t1 left  join (SELECT * FROM sgm_ensayo_paquete where id_paquete = ?)  t2 on t1.id = t2.id_ensayo where t1.es_paquete = 0 and t1.activo=1 and isnull(t2.id) ORDER BY t1.descripcion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);
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

    function insertEnsayoPaquete($idPaquete, $idEnsayo) {
        $SQL = "INSERT INTO sgm_ensayo_paquete (id_paquete,id_ensayo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);
        $query->bindParam(2, $idEnsayo);

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

    function getEnsayosByIdEnsayoPaquete($idPaquete) {
        $SQL = "SELECT tbl3.* "
                . "from sgm_ensayo tbl1 "
                . "join sgm_ensayo_paquete tbl2 on tbl2.id_paquete = tbl1.id "
                . "join sgm_ensayo tbl3 on tbl3.id = tbl2.id_ensayo "
                . "where tbl2.id_paquete = ? and tbl3.activo = 1 "
                . "order by tbl3.descripcion asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);
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
