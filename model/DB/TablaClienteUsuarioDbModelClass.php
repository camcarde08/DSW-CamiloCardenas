<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaTerceroDbModelClass
 *
 * @author hruge
 */
class TablaClienteUsuarioDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getUsuariosCliente($idCliente) {
        $SQL = "SELECT id, nombre, perfil, cliente, usuario, cargo FROM sgm_cliente_usuario where activo = 1 AND cliente = ? "
                . "ORDER BY nombre ASC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idCliente);
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
        $contrasena = crypt($contrasena);
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
        $contrasena = crypt($contrasena);
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

    function getPermisosUsuarioCliente($idUsuario) {
        $SQL = "SELECT tb1.id, tb2.id as id_usuario, tb1.id_permiso as id_permiso "
                . "FROM sgm_cliente_usuario_permiso tb1 "
                . "JOIN sgm_cliente_usuario tb2 ON tb2.id = tb1.id_usuario "
                . "WHERE tb2.id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idUsuario);
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

    function deletePermisosUsuarioCliente($idUsuario) {
        $SQL = "DELETE FROM sgm_cliente_usuario_permiso WHERE id_usuario = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idUsuario);
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

    function insertarPermisoUsuarioCliente($idUsuario, $idPermiso) {
        $SQL = "INSERT INTO sgm_cliente_usuario_permiso (id_usuario,id_permiso) "
                . "VALUES (?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idUsuario);
        $query->bindParam(2, $idPermiso);
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
