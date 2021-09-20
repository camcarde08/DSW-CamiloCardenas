<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaAreaAnalisisDbModel
 *
 * @author hruge
 */
class TablaAreaAnalisisDbModel {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getAreasWithOutEstabilidad(){
        $SQL = "SELECT * FROM sgm_areas_analisis where id != 4;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getAreas(){
        $SQL = "SELECT * FROM sgm_areas_analisis;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getAreasActivas(){
        
        $query = "select t1.id ,t1.descripcion,t3.nombre as cordinador from sgm_areas_analisis t1 join sgm_cargo t2 on t1.id_cargo_cordinador = t2.id
left join sgm_usuario t3 on t3.id_cargo = t2.id group by t1.descripcion order by t3.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getAreaDescriptionByIdMuestra($idMuestra){
        $SQL = "select t2.descripcion from sgm_muestra t1 join sgm_areas_analisis t2 on t1.id_area_analisis = t2.id where t1.id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $datas = $query->fetchAll();
            $data = $datas[0]['descripcion'];
        } else {
            $data = false;
        }
        return $data;
        
    }

    function getAreasActivas2(){
        $SQL = "select t1.id ,t1.descripcion,t3.nombre as coordinador from sgm_areas_analisis t1 join sgm_cargo t2 on t1.id_cargo_cordinador = t2.id
left join sgm_usuario t3 on t3.id_cargo = t2.id order by t1.id";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        
        if($query->execute()){
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC) 
            );
            
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => $query->errorInfo()
            );
        }
        return $response;
    }
   
}
