<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewProductoPaquetesEnsayosDbModelClass
 *
 * @author lvelasquez
 */
class ViewProductoPaquetesEnsayosDbModelClass {
    //put your code here
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getPaquetesEnsayosByProductos ($producto,$idAreaAnalisis){
        
        $query = "SELECT * FROM sgm_productos_paquetes_ensayos
                  where idProducto = '$producto' and idAreaAnalisis = '$idAreaAnalisis'";
                 
        
        $query = $this->dbClass->getConexion()->prepare($query);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getNomProductoPaqueteEnsayoByIdProducto($idProducto,$idAreaAnalisis){
        
        $SQL = "SELECT t2.nombre, t1.*, t3.valor as precio_real, t4.descripcion as metodo FROM sgm_productos_paquetes_ensayos t1 join sgm_producto t2 on t1.idProducto = t2.id join sgm_producto_ensayo t3 on t1.idEnsayo = t3.id_ensayo and t1.idProducto = t3.id_producto and t1.idProductoPaquete = t3.id_producto_paquete join sgm_metodo t4 on t3.id_metodo = t4.id 	where t1.idProducto = ? and t1.idAreaAnalisis = ?;";
                 
        
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idAreaAnalisis);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
}
