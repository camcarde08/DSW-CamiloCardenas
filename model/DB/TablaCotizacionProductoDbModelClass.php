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
class TablaCotizacionProductoDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertCotizacionProducto($idCotizacion, $idProducto){
        
        $SQL = "INSERT INTO sgm_cotizacion_producto (id_cotizacion,id_producto) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        $query->bindParam(2,$idProducto);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function deleteCotizacionProductoByIdCotizacion($idCotizacion){
        $SQL = "DELETE FROM sgm_cotizacion_producto WHERE id_cotizacion = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        if($query->execute()){
            return true;
        } else {
            
            return false;
        }
    }
    
    function getIdCotizacionProductoByIdCotizacion($idCotizacion){
        $SQL = "Select * from sgm_cotizacion_producto WHERE id_cotizacion = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        
        return $data;
    }
    
    function getProductsByIdCotizacion($idCotizacion){
        $SQL = "SELECT t2.id, t2.nombre, t3.id_area_analisis, t4.descripcion as nom_area FROM sgm_cotizacion_producto t1 join sgm_producto t2 on t1.id_producto = t2.id join (select * from sgm_cot_pro_ensayo t8 group by t8.id_cot_pro,t8.id_area_analisis) t3 on t1.id = t3.id_cot_pro join sgm_areas_analisis t4 on t3.id_area_analisis = t4.id where t1.id_cotizacion = ?;";
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
