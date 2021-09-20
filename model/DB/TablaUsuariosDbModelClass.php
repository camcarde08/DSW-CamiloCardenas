<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaUsuariosDbModelClass
 *
 * @author andres
 */
class TablaUsuariosDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllAnalistas() {

        $SQL = "select * from sgm_usuario where id_perfil = 6;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAnalistasProgramables($idsAnalistas) {
        $stringPerfiles = "";
        foreach ($idsAnalistas as $key => $value) {
            $stringPerfiles .= $value;
            if ($key != count($idsAnalistas) - 1) {
                $stringPerfiles .= ",";
            }
        }

        $SQL = "select * from sgm_usuario where estado = 1 and  id_perfil in (" . $stringPerfiles . ");";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $error = $query->errorInfo();
            $data = false;
        }
        return $data;
    }

    function getCalendarIdByUserId($userId) {
        $SQL = "select id_calendario from sgm_usuario where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $userId);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllUsuario() {
        $SQL = "SELECT * FROM sgm_usuario WHERE nombre != 'root' ORDER BY nombre";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllUsuario2() {
        $SQL = "SELECT t3.nombre as perfil, t2.nombre as cargo, t1.id_jefe, t1.nombre, t1.id_cargo, t1.email, t1.id_perfil, t1.login, t1.fecha_creacion, t1.id FROM sgm_usuario t1 "
                . "LEFT JOIN sgm_cargo t2 ON t2.id = t1.id_cargo "
                . "LEFT JOIN sgm_perfil t3 ON t3.id = t1.id_perfil "
                . "WHERE t1.estado = 1 AND t1.id != 1";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
            return $data;
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
    
    function createNewUsuario($nombre, $email, $login, $contrasena, $cargo, $jefe, $perfil, $fecha) {
        $calendario = 1;
        $SQL = "INSERT INTO sgm_usuario (nombre,login,clave,`caduca`,`fecha_caduca`,`estado`,`id_perfil`,`id_jefe`,`id_cargo`,`es_jefe`,`email`,`aplicacion`,`bloqueado`,`fecha_creacion`,`firma`,`ultimo_ingreso`,`intentos_fallidos`,`id_calendario`) VALUES "
                . "(?, ?, AES_ENCRYPT('" . $contrasena . "','SGM'), 0, null, 1, ?, ?, ?, 0, ?, ?, 0, ?, null, null, 0, ?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $login);
        $query->bindParam(3, $perfil);
        $query->bindParam(4, $jefe);
        $query->bindParam(5, $cargo);
        $query->bindParam(6, $email);
        $query->bindParam(7, $login);
        $query->bindParam(8, $fecha);
        $query->bindParam(9, $calendario);
        if ($query->execute()) {
            $data = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId() 
            );
            return $data;
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
    
    function getAllJefes() {
        $SQL = "SELECT id, nombre as jefe FROM sgm_usuario "
                . "WHERE estado = 1";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
            return $data;
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

    function getUsuariosActivosDependencias() {
        $SQL = "select usuario.*,perfil.nombre as nom_perfil,cargo.nombre as nom_cargo,calendario.nombre as nom_calendario from sgm_usuario usuario join sgm_perfil perfil on usuario.id_perfil = perfil.id join sgm_cargo cargo on usuario.id_cargo = cargo.id join sgm_calendario_base calendario on usuario.id_calendario = calendario.id where usuario.estado = 1";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function setEstadoUsuario($idUsuario, $estado) {
        $SQL = "UPDATE sgm_usuario SET estado= ? WHERE id= ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $estado);
        $query->bindParam(2, $idUsuario);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function insertUsuario($nombre, $email, $login, $contrasena, $cargo, $jefe, $perfil, $calendario) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization, If-Modified-Since, Cache-Control, Pragma");
        $fecha = new DateTime();
        $fecha = $fecha->format('Y-m-d');
        $SQL = "INSERT INTO sgm_usuario (nombre,login,clave,`caduca`,`fecha_caduca`,`estado`,`id_perfil`,`id_jefe`,`id_cargo`,`es_jefe`,`email`,`aplicacion`,`bloqueado`,`fecha_creacion`,`firma`,`ultimo_ingreso`,`intentos_fallidos`,`id_calendario`) VALUES "
                . "(?, ?, AES_ENCRYPT('" . $contrasena . "','SGM'), 0, null, 1, ?, ?, ?, 0, ?, ?, 0, ?, null, null, 0, ?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $login);
        $query->bindParam(3, $perfil);
        $query->bindParam(4, $jefe);
        $query->bindParam(5, $cargo);
        $query->bindParam(6, $email);
        $query->bindParam(7, $login);
        $query->bindParam(8, $fecha);
        $query->bindParam(9, $calendario);
        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }

    function updateUsuario($idUsuario, $nombre, $email, $login, $cargo, $jefe, $perfil, $calendario) {

        $SQL = "UPDATE sgm_usuario SET nombre = ?,email = ?,login = ?,id_cargo = ?,id_jefe = ?,id_perfil = ?,id_calendario = ?WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $email);
        $query->bindParam(3, $login);
        $query->bindParam(4, $cargo);
        $query->bindParam(5, $jefe);
        $query->bindParam(6, $perfil);
        $query->bindParam(7, $calendario);
        $query->bindParam(8, $idUsuario);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    function updateUsuario1($idUsuario, $nombre, $email, $login, $cargo, $jefe, $perfil) {
        $calendario = 1;

        $SQL = "UPDATE sgm_usuario SET nombre = ?,email = ?,login = ?,id_cargo = ?,id_jefe = ?,id_perfil = ?,id_calendario = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $email);
        $query->bindParam(3, $login);
        $query->bindParam(4, $cargo);
        $query->bindParam(5, $jefe);
        $query->bindParam(6, $perfil);
        $query->bindParam(7, $calendario);
        $query->bindParam(8, $idUsuario);
        if ($query->execute()) {
            $data = array(
                "code" => "0",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
            return $data;
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "101",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function updatePasswordByIdUser($idUser, $newPassword) {
        $SQL = "UPDATE sgm_usuario SET clave = AES_ENCRYPT(?,'SGM') WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newPassword);
        $query->bindParam(2, $idUser);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    function updatePasswordUsuario($idUser, $newPassword) {
        $SQL = "UPDATE sgm_usuario SET clave = AES_ENCRYPT(?,'SGM') WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newPassword);
        $query->bindParam(2, $idUser);
        if ($query->execute()) {
            $data = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
            return $data;
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
    
    function getAllActiveAnalistas() {
        $SQL = "SELECT id, nombre, login FROM sgm_usuario WHERE estado = 1 AND id_perfil = 6";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
            return $data;
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

    function getUsuarioByIdToAud($id) {

        $usuario = Usuario::find($id);
        return $usuario->toJson();
    }

}
