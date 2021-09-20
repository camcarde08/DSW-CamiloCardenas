<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaPerfilPermisoDbModelClass
 *
 * @author andres
 */
class TablaPerfilPermisoDbModelClass {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getPermisionsByPerfilId($idPerfil){
        
        $query = "SELECT * FROM sgm_perfil_permiso where id_perfil=$idPerfil";
        $query = $this->dbClass->getConexion()->prepare($query);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function insertPerfilPermiso($idPerfil, $idPermiso){
        $SQL="INSERT INTO sgm_perfil_permiso (id_perfil,id_permiso) values ( ? , ? )";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idPerfil);
        $query->bindParam(2, $idPermiso);
         if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            return false;
        }
    }
    
    function deletePerfilPermiso($idPerfil, $idPermiso){
        $SQL="DELETE FROM sgm_perfil_permiso WHERE id_perfil = ? AND id_permiso = ? ";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idPerfil);
        $query->bindParam(2, $idPermiso);
         if($query->execute()){
            return true;
        } else {
            return false;
        }
    }

    function getPermisosModulo($moduloId) {
        $SQL = "SELECT * FROM sgm_permiso where modulo_id = ? order by orden";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $moduloId);
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

