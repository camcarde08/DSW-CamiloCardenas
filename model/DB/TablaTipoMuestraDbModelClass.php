<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaTipoAlmacenaminetoDbModelClass
 *
 * @author andres
 */
class TablaTipoMuestraDbModelClass {
    //put your code here
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getActiveTipoMuestraByIdArea($idArea){
        $SQL = "SELECT * FROM sgm_tipo_muestra where id_area_analisis = ? AND activo = 1 order by descripcion asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idArea);
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
