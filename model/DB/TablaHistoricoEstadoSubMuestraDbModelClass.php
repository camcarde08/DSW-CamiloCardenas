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
class TablaHistoricoEstadoSubMuestraDbModelClass {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertHistoricoEstadoSubMuestra($idSubMuestra, $fecha, $idEstado, $idUsuario,$observaciones){
        $SQL="INSERT INTO sgm_historico_estado_sub_muestra (id_sub_muestra,fecha,id_estado,id_usuario,observaciones) VALUES (?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idSubMuestra);
        $query->bindParam(2, $fecha);
        $query->bindParam(3, $idEstado);
        $query->bindParam(4, $idUsuario);
        $query->bindParam(5, $observaciones);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getHistoricoEstadoSubmuestraByIdMuestra($idMuestra){
        $SQL="SELECT t1.id,t1.duracion, t4.descripcion as estado, t2.fecha, t3.nombre as usuario FROM sgm_sub_muestra_est t1 JOIN sgm_historico_estado_sub_muestra t2 ON t1.id = t2.id_sub_muestra JOIN sgm_usuario t3 ON t2.id_usuario = t3.id JOIN sgm_estado t4 ON t2.id_estado = t4.id WHERE t1.id_muestra = ? ORDER BY t1.id;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            return $query->fetchAll();
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
