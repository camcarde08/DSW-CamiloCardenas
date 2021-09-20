<?php

class ViewProductoPrincipioActivoDbModelClass {
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getPrincipioActivoByIdProducto($idProducto){
        $SQL = "SELECT id_producto, id_principio_activo, nombre, principal, trasador FROM sgm_producto_principios_activos WHERE id_producto = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
}
