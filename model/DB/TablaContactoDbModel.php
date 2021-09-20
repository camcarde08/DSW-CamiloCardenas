<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaContactoDbModel
 *
 * @author hruge
 */
class TablaContactoDbModel {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getContactosNameByTerceroId($idTercero) {

        $query = "SELECT * FROM sgm_contacto where id_tercero = $idTercero";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function updateContactoById($id, $nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias) {
        $SQL = "UPDATE sgm_contacto SET nombre = ?,cargo = ?,area = ?,telefono = ?,movil = ?,extencion = ?,email = ?,id_tercero = ?,preferencias = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $cargo);
        $query->bindParam(3, $area);
        $query->bindParam(4, $telefono);
        $query->bindParam(5, $movil);
        $query->bindParam(6, $extencion);
        $query->bindParam(7, $email);
        $query->bindParam(8, $idTercero);
        $query->bindParam(9, $preferencias);
        $query->bindParam(10, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function insertContacto($nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias) {
        $SQL = "INSERT INTO sgm_contacto (nombre,cargo,area,telefono,movil,extencion,email,id_tercero,preferencias) VALUES (?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $cargo);
        $query->bindParam(3, $area);
        $query->bindParam(4, $telefono);
        $query->bindParam(5, $movil);
        $query->bindParam(6, $extencion);
        $query->bindParam(7, $email);
        $query->bindParam(8, $idTercero);
        $query->bindParam(9, $preferencias);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            return false;
        }
    }

    function getContactosByIdCliente($idCliente) {
        $SQL = "select * from sgm_contacto where id_tercero = ? order by nombre asc";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idCliente);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_contacto", "data" => $error
            );
        }
        return $response;
    }

    function updateContactoById2($id, $nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias) {
        $SQL = "UPDATE sgm_contacto SET nombre = ?,cargo = ?,area = ?,telefono = ?,movil = ?,extencion = ?,email = ?,id_tercero = ?,preferencias = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $cargo);
        $query->bindParam(3, $area);
        $query->bindParam(4, $telefono);
        $query->bindParam(5, $movil);
        $query->bindParam(6, $extencion);
        $query->bindParam(7, $email);
        $query->bindParam(8, $idTercero);
        $query->bindParam(9, $preferencias);
        $query->bindParam(10, $id);

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

    function insertContacto2($nombre, $cargo, $area, $telefono, $movil, $extencion, $email, $idTercero, $preferencias) {
        $SQL = "INSERT INTO sgm_contacto (nombre,cargo,area,telefono,movil,extencion,email,id_tercero,preferencias) VALUES (?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $cargo);
        $query->bindParam(3, $area);
        $query->bindParam(4, $telefono);
        $query->bindParam(5, $movil);
        $query->bindParam(6, $extencion);
        $query->bindParam(7, $email);
        $query->bindParam(8, $idTercero);
        $query->bindParam(9, $preferencias);

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
