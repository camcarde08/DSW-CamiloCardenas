<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaClientePermisoDbModelClass
 *
 * @author hruge
 */
class TablaClientePermisoDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllPermisosUsuarioCliente() {
        $SQL = "SELECT * FROM sgm_cliente_permiso "
                . "ORDER BY nombre ASC;";
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

    function insertUsuarioCliente($nombre, $usuario, $cargo, $idCliente, $contrasena) {
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $SQL = "INSERT INTO sgm_cliente_usuario (nombre,usuario,cargo,cliente,contrasena) VALUES "
                . "(?, ?, ?, ?, ?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $usuario);
        $query->bindParam(3, $cargo);
        $query->bindParam(4, $idCliente);
        $query->bindParam(5, $contrasena);
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

    function updateUsuarioCliente($nombre, $usuario, $cargo, $id) {
        $SQL = "UPDATE sgm_cliente_usuario "
                . "SET nombre = ?, usuario = ?, cargo = ? WHERE id = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $usuario);
        $query->bindParam(3, $cargo);
        $query->bindParam(4, $id);
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

    function updateUsuarioClienteContrasena($contrasena, $id) {
        $contrasena = password_hash($contrasena, PASSWORD_DEFAULT);
        $SQL = "UPDATE sgm_cliente_usuario "
                . "SET contrasena = ? WHERE id = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $contrasena);
        $query->bindParam(2, $id);
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

    function eliminarUsuarioCliente($id) {
        $SQL = "UPDATE sgm_cliente_usuario "
                . "SET activo = 0 WHERE id = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);
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
