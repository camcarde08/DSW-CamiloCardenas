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
class TablaEnsayoEquipoDbModelClass {

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function deleteEnsayoEquipo($idEnsayoEquipo) {
        $SQL = "DELETE FROM sgm_ensayo_equipo WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoEquipo);

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

    function insertEnsayoEquipo($idEnsayo, $idEquipo) {
        $SQL = "INSERT INTO sgm_ensayo_equipo (id_ensayo,id_equipo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        $query->bindParam(2, $idEquipo);

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

    function getEquiposByIdEnsayo($idEnsayo) {
        $SQL = "SELECT t1.id as id_ensayo_equipo, t2.* FROM sgm_ensayo_equipo t1 JOIN sgm_equipo t2 ON t1.id_equipo = t2.id WHERE t1.id_ensayo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);

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

    function getEquiposDisponiblesByIdEnsayo($idEnsayo) {
        $SQL = "SELECT t2.* FROM (SELECT t1.* FROM sgm_ensayo_equipo t1 WHERE t1.id_ensayo = ?) t3 right join sgm_equipo t2 ON t3.id_equipo = t2.id WHERE t3.id IS NULL;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);

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

    function obtenerEquiposEnsayo($idEnsayo) {
        $SQL = "SELECT group_concat(t2.cod_inventario,' ', t2.descripcion, '[   ]' separator '   ') as equipos
                FROM sgm_ensayo_equipo t1 
                JOIN sgm_equipo t2 on t2.id = t1.id_equipo
                WHERE t1.id_ensayo=?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
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

    function obtenerEquiposMuestra($idMuestra) {
        $SQL = "SELECT t3.* FROM sgm_ensayo_muestra t1 "
            . "JOIN sgm_ensayo_equipo t2 ON t2.id_ensayo = t1.id_ensayo "
            . "JOIN sgm_equipo t3 ON t2.id_equipo = t3.id "
            . "WHERE t1.id_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
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
