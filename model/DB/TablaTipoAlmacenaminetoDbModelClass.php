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
class TablaTipoAlmacenaminetoDbModelClass {
    //put your code here
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getAllTipoAlamacenamiento(){
        $SQL = "select  * from sgm_tipo_almacenamiento; ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
        
    }
}
