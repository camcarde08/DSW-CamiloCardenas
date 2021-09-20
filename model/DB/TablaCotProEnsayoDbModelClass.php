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
class TablaCotProEnsayoDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertCotizacionProducto($idCotPro, $idPaquete, $idEnsayo, $idAreaAnalisis, $duracion, $seleccion, $valor, $aprobado){
        
        $SQL = "INSERT INTO sgm_cot_pro_ensayo (id_cot_pro,id_paquete,id_ensayo,id_area_analisis,duracion,seleccion,valor,aprobado) VALUES (?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotPro);
        $query->bindParam(2,$idPaquete);
        $query->bindParam(3,$idEnsayo);
        $query->bindParam(4,$idAreaAnalisis);
        $query->bindParam(5,$duracion);
        $query->bindParam(6,$seleccion);
        $query->bindParam(7,$valor);
        $query->bindParam(8,$aprobado);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function getEnsayosByidCotizacion($idCotizacion){
        $SQL = "SELECT cotPro.*, cpe.*, pro.nombre as nombre_producto, eny.descripcion as nombre_paquete, enyo.descripcion as nombre_ensayo, area.descripcion as nombre_area_analisis, t4.descripcion as metodo FROM sgm_cotizacion_producto cotPro join sgm_cot_pro_ensayo cpe on cpe.id_cot_pro = cotPro.id  join sgm_producto pro on pro.id = cotPro.id_producto join sgm_ensayo eny on eny.id = cpe.id_paquete join sgm_ensayo enyo on enyo.id = cpe.id_ensayo join sgm_areas_analisis area on area.id = cpe.id_area_analisis  join sgm_producto_paquete t1 on cotPro.id_producto = t1.id_producto and cpe.id_paquete = t1.id_ensayo join sgm_producto_ensayo t3 on cotPro.id_producto = t3.id_producto and cpe.id_ensayo = t3.id_ensayo and t1.id = t3.id_producto_paquete join sgm_metodo t4 on t3.id_metodo = t4.id where  id_cotizacion = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function deleteByIdCotizacionProducto($idCotizacionProducto){
        $SQL = "DELETE FROM sgm_cot_pro_ensayo WHERE id_cot_pro = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacionProducto);
        if($query->execute()){
            return true;
        } else {
            
            return false;
        }
    }
    
    function getEnsayosByidCotizacionIdProductoidAreaAnalisis($idCotizacion, $idProducto, $idAreaAnalisis){
        $SQL = "SELECT cotPro.*, cpe.*, pro.nombre as nombre_producto, eny.descripcion as nombre_paquete, enyo.descripcion as nombre_ensayo, area.descripcion as nombre_area_analisis FROM sgm_cotizacion_producto cotPro join sgm_cot_pro_ensayo cpe on cpe.id_cot_pro = cotPro.id  join sgm_producto pro on pro.id = cotPro.id_producto  join sgm_ensayo eny on eny.id = cpe.id_paquete join sgm_ensayo enyo on enyo.id = cpe.id_ensayo join sgm_areas_analisis area on area.id = cpe.id_area_analisis where  id_cotizacion = ?;";
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
