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
class TablaSubMuestraEstDbModelClass {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function updateConclusionBiIdSubMuestra($idSubMuestra, $conclusion){
        $SQL = "UPDATE sgm_sub_muestra_est SET conclusion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $conclusion);
        $query->bindParam(2, $idSubMuestra);
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getSubMuestraByIdMuestraAndMes($idMuestra, $mes){
        $SQL = "select * from sgm_sub_muestra_est where id_muestra = ? and duracion = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $mes);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function insertSubMuestraEst($idMuestra, $duracion, $estado, $fechaReferencia){
        $SQL ="INSERT INTO sgm_sub_muestra_est (id_muestra,duracion,estado,fecha_referencia,conclusion) VALUES (?,?,?,?,?);";
        $conclusion = " ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $duracion);
        $query->bindParam(3, $estado);
        $query->bindParam(4, $fechaReferencia);
        $query->bindParam(5, $conclusion);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
             $error = $query->errorInfo();
            $data = false;
        }
        return $data;
    }
    
    function getSubmuestrasByIdMuestra($idMuestra){
        $SQL = "select * from sgm_sub_muestra_est where id_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getSubmuestrasSinFinalizarByIdMuestra($idMuestra){
        $SQL = "select * from sgm_sub_muestra_est where id_muestra = ? AND estado = 7 AND isnull(conclusion);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getSubMuestraById($idSubMuestra){
        $SQL = "select * from sgm_sub_muestra_est where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idSubMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function anular($idMuestra){
        $SQL="UPDATE sgm_sub_muestra_est SET estado = 11 WHERE id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    function updateEstadoById($idSubMuestra, $idEstado){
        $SQL="UPDATE sgm_sub_muestra_est SET estado = ? WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEstado);
        $query->bindParam(2, $idSubMuestra);
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }  
    
    function getMinEstadoByIdMuestra($idMuestra){
        $SQL = "SELECT min(estado) as estado FROM sgm_sub_muestra_est where id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    
    
//    function getAllAnalistas(){
//        
//        $SQL = "select * from sgm_usuario where id_cargo = 2 OR id_cargo = 3";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        if($query->execute()){
//            $data = $query->fetchAll();
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
//    
//    function getCalendarIdByUserId($userId){
//        $SQL = "select id_calendario from sgm_usuario where id = ?";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        $query->bindParam(1, $userId);
//        if($query->execute()){
//            $data = $query->fetchAll();
//        } else {
//            $data = false;
//        }
//        return $data;
//        
//    }
//    
//    function getAllUsuario(){
//        $SQL = "select * from sgm_usuario where nombre != 'root' order by nombre";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        if($query->execute()){
//            $data = $query->fetchAll();
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
//    
//    function getUsuariosActivosDependencias (){
//        $SQL = "select usuario.*,perfil.nombre as nom_perfil,cargo.nombre as nom_cargo,calendario.nombre as nom_calendario from sgm_usuario usuario join sgm_perfil perfil on usuario.id_perfil = perfil.id join sgm_cargo cargo on usuario.id_cargo = cargo.id join sgm_calendario_base calendario on usuario.id_calendario = calendario.id where usuario.estado = 1";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        if($query->execute()){
//            $data = $query->fetchAll();
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
//    
//    function setEstadoUsuario($idUsuario, $estado){
//        $SQL="UPDATE sgm_usuario SET estado= ? WHERE id= ?";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        $query->bindParam(1, $estado);
//        $query->bindParam(2, $idUsuario);
//        if($query->execute()){
//            $data = true;
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
//    
//    function insertUsuario($nombre, $email, $login, $contrasena, $cargo, $jefe, $perfil, $calendario){
//        $fecha = new DateTime();
//        $fecha = $fecha->format('Y-m-d');
//        $SQL="INSERT INTO sgm_usuario (nombre,login,clave,`caduca`,`fecha_caduca`,`estado`,`id_perfil`,`id_jefe`,`id_cargo`,`es_jefe`,`email`,`aplicacion`,`bloqueado`,`fecha_creacion`,`firma`,`ultimo_ingreso`,`intentos_fallidos`,`id_calendario`) VALUES "
//                . "(?, ?, AES_ENCRYPT('".$contrasena."','SGM'), 0, null, 1, ?, ?, ?, 0, ?, ?, 0, ?, null, null, 0, ?);";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        $query->bindParam(1, $nombre);
//        $query->bindParam(2, $login);
//        $query->bindParam(3, $perfil);
//        $query->bindParam(4, $jefe);
//        $query->bindParam(5, $cargo);
//        $query->bindParam(6, $email);
//        $query->bindParam(7, $login);
//        $query->bindParam(8, $fecha);
//        $query->bindParam(9, $calendario);
//        if($query->execute()){
//            return $this->dbClass->getConexion()->lastInsertId();
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
//    
//    function updateUsuario($idUsuario, $nombre, $email, $login, $cargo, $jefe, $perfil, $calendario){
//        
//        $SQL="UPDATE sgm_usuario SET nombre = ?,email = ?,login = ?,id_cargo = ?,id_jefe = ?,id_perfil = ?,id_calendario = ?WHERE id = ?;";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        $query->bindParam(1, $nombre);
//        $query->bindParam(2, $email);
//        $query->bindParam(3, $login);
//        $query->bindParam(4, $cargo);
//        $query->bindParam(5, $jefe);
//        $query->bindParam(6, $perfil);
//        $query->bindParam(7, $calendario);
//        $query->bindParam(8, $idUsuario);
//        if($query->execute()){
//            $data = true;
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
//    
//    function updatePasswordByIdUser($idUser, $newPassword){
//        $SQL = "UPDATE sgm_usuario SET clave = AES_ENCRYPT(?,'SGM') WHERE id = ?;";
//        $query = $this->dbClass->getConexion()->prepare($SQL);
//        $query->bindParam(1, $newPassword);
//        $query->bindParam(2, $idUser);
//         if($query->execute()){
//            $data = true;
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
}
