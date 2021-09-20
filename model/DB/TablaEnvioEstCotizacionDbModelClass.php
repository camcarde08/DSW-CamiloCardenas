<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaContactoDbModel
 *
 * @author hruge
 */
class TablaEnvioEstCotizacionDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertEnvioEstCotizacion($idCotizacion, $destino, $medio, $observaciones){
        
        $SQL = "INSERT INTO sgm_est_envio_cotizacion (`id_cotizacion`,`destino`,`medio`,`observaciones`) VALUES (?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        $query->bindParam(2,$destino);
        $query->bindParam(3,$medio);
        $query->bindParam(4,$observaciones);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function getEnvioCotizacionByIdCotizacion($idCotizacion){
        
        $SQL = "SELECT * FROM sgm_est_envio_cotizacion WHERE id_cotizacion = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            
            $data = false;
        }
        
        return $data;
    }
    
    
    
    
}
