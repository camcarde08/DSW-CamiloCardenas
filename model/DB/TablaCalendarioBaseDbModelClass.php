<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaCalendarioBaseDbModelClass
 *
 * @author andres
 */
class TablaCalendarioBaseDbModelClass {
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getCalendarioById($idCalendario){
        $SQL = "select * from sgm_calendario_base where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCalendario);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getAllCalendario(){
        $SQL = "select * from sgm_calendario_base";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
}
