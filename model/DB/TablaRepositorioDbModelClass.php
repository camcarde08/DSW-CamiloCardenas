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
class TablaRepositorioDbModelClass {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function getParentById($idPath){
         $SQL = "SELECT t2.* from sgm_repositorio t1 join sgm_repositorio t2 on t1.parent = t2.id where t1.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
         $query->bindParam(1, $idPath);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function scanRepoById($idPath){
        $SQL = " select * from sgm_repositorio where parent = ? order by id,es_carpeta, nombre;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
         $query->bindParam(1, $idPath);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
        
    }
    
    public function getRepositorio(){
        
        $SQL = "select * from sgm_repositorio where id > 0 and es_carpeta = 1 order by parent, nombre;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function getitemById($idRepositorio){
        $SQL = "select * from sgm_repositorio where id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idRepositorio);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function deleteItemById($idRepositorio){
        $SQL = "DELETE  from sgm_repositorio where id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idRepositorio);
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function insertField($nombre, $extencion, $esCarpeta, $path, $parent, $descripcion){
        $SQL = "INSERT INTO sgm_repositorio (nombre,extension,es_carpeta,path,parent,descripcion) VALUES (?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $extencion);
        $query->bindParam(3, $esCarpeta);
        $query->bindParam(4, $path);
        $query->bindParam(5, $parent);
        $query->bindParam(6, $descripcion);
        
        if($query->execute()){
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function cleanTable(){
        $SQL = "DELETE FROM sgm_repositorio; ALTER TABLE sgm_repositorio AUTO_INCREMENT = 1 ;INSERT INTO sgm_repositorio (id, extension, es_carpeta, parent, descripcion) VALUES ('-1', '0', '0', '-1', 'N/A');";
        $query = $this->dbClass->getConexion()->prepare($SQL);
       
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function searchLikeName($name){
        $name = "%".$name."%";
        $SQL = "SELECT * FROM sgm_repositorio where nombre like ? order by es_carpeta, nombre;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $name);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
  
    
    
    
    
}
