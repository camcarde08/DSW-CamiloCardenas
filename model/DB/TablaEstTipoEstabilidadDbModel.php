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
class TablaEstTipoEstabilidadDbModel {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getTipos(){
        $SQL = "SELECT * FROM sgm_est_tipo_estabilidad;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
       
}
