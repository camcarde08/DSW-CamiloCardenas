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
class TablaColumnaDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllColumnas() {
        $SQL = "SELECT * FROM sgm_columna where activo = 1 ORDER BY id ASC;";
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

    function updateColumnaById($numero, $tipo, $marca, $dimensiones, $serial, $uso, $fecha_inicio_uso, $id) {
        $SQL = "UPDATE sgm_columna SET numero = ?, tipo = ?, marca = ?, dimensiones = ?, serial = ?, "
                . "uso = ?, fecha_inicio_uso = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $numero);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $marca);
        $query->bindParam(4, $dimensiones);
        $query->bindParam(5, $serial);
        $query->bindParam(6, $uso);

        $fechaNula = null;

        if ($fecha_inicio_uso !== null && $fecha_inicio_uso !== '') {
            $explodeDate = explode("GMT", $fecha_inicio_uso);
            $query->bindParam(7, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(7, $fechaNula);
        }

        $query->bindParam(8, $id);
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

    function deleteColumnaById($idColumna) {
        $SQL = "UPDATE sgm_columna SET  activo = 0 WHERE id = ?;";
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

    function insertColumna($numero, $tipo, $marca, $dimensiones, $serial, $uso, $fecha_inicio_uso) {
        $SQL = "INSERT INTO sgm_columna (numero,tipo,marca,dimensiones,serial, "
                . "uso,fecha_inicio_uso) VALUES (?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $numero);
        $query->bindParam(2, $tipo);
        $query->bindParam(3, $marca);
        $query->bindParam(4, $dimensiones);
        $query->bindParam(5, $serial);
        $query->bindParam(6, $uso);

        $fechaNula = null;
        if ($fecha_inicio_uso !== null && $fecha_inicio_uso !== '') {
            $explodeDate = explode("GMT", $fecha_inicio_uso);
            $query->bindParam(7, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(7, $fechaNula);
        }

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

    function getColumnaByIdToAud($id) {
        $columna = Columna::find($id);
        $columna->principiosActivos;

        return $columna->toJson();
    }

}
