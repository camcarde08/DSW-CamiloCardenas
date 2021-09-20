<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaPrincipioActivoDbModelClass
 *
 * @author lvelasquez
 */
class TablaPrincipioActivoProductoDbModelClass {
    //put your code here
    
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getPrincipioActivoProductoByIdProducto($idProducto){
        $SQL = "SELECT t1.*, t2.nombre as nomPrincipioActivo FROM sgm_producto_principio_activo t1 JOIN sgm_principio_activo t2 on t1.id_principio_activo = t2.id where id_producto = ? ORDER BY t2.nombre ASC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function updatePrincipioActivoProducto($principal,$trasador,$cantidad,$unidadCantidad,$cantidadDecimal,$idPrincipioActivoProducto){
        $SQL ="UPDATE sgm_producto_principio_activo SET principal = ?,trasador = ?,cantidad = ?,unidad_cantidad = ?,cantidad_decimal = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $principal);
        $query->bindParam(2, $trasador);
        $query->bindParam(3, $cantidad);
        $query->bindParam(4, $unidadCantidad);
        $query->bindParam(5, $cantidadDecimal);
        $query->bindParam(6, $idPrincipioActivoProducto);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getPrincipioActivoProductoDisponiblesByIdProducto($idProducto){
        $SQL = "SELECT t1.* FROM sgm_principio_activo t1 left join (SELECT  * FROM sgm_producto_principio_activo WHERE id_producto = ?) t2 on t1.id = t2.id_principio_activo where isnull(t2.id) and t1.activo=1 ORDER BY t1.nombre ASC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function insertBasicPrincipioActivoProducto($idProducto,$idPrincipioActivo){
        $SQL ="INSERT INTO sgm_producto_principio_activo (id_producto,id_principio_activo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idPrincipioActivo);
        if($query->execute()){
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function deleteProductoPrincipioActivo($idProductoPrincipioActivo){
        $SQL = "DELETE FROM sgm_producto_principio_activo WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoPrincipioActivo);
        
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    
}
