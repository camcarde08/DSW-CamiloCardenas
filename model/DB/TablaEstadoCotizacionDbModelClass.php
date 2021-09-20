<?php


class TablaEstadoCotizacionDbModelClass {
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getAllEstados(){
        $SQL = "SELECT * from sgm_estado_cotizacion order by id";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
        
    }
    
    
}
