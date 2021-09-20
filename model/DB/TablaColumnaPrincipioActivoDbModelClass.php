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
class TablaColumnaPrincipioActivoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllPrincipioActivoByIdColumnas($idColumna) {
        $SQL = "select tb1.id as id_col_principio_activo, tb2.id as id_principio_activo, "
                . "tb2.nombre from sgm_columna_principio_activo tb1 "
                . "join sgm_principio_activo tb2 on tb2.id = tb1.id_principio_activo "
                . "where tb1.id_columna = ? order by tb2.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idColumna);
        if ($query->execute()) {
            return array("code" => "00000",
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

    function getPrincipiosActivosDisponibles($idColumna) {
        $SQL = "SELECT t2.* FROM (SELECT t1.* FROM sgm_columna_principio_activo t1 WHERE t1.id_columna = ?) t3"
                . " right join sgm_principio_activo t2 ON t3.id_principio_activo = t2.id "
                . "WHERE t3.id IS NULL and t2.activo = 1 order by t2.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idColumna);
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

    function deleteColumnaPrincipioActivoByColumna($idColumna) {
        $SQL = "DELETE FROM sgm_columna_principio_activo WHERE id_columna = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idColumna);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $idColumna
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

    function insertColumnaPrincipioActivo($id_columna, $id_principio_activo) {
        $SQL = "INSERT INTO sgm_columna_principio_activo (id_columna,id_principio_activo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id_columna);
        $query->bindParam(2, $id_principio_activo);

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

}
