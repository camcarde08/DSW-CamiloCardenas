<?php

class TablaAreaMicrobiologicaDbModelClass {
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getActiveAreasMicrobiologicas(){
        $SQL = "SELECT id, descripcion FROM sgm_area_microbiologica";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
        
    }
}
