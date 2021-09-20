<?php

class TablaTipoProductoDbModelClass
{
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllTipoProducto(){
        $SQL = "SELECT * FROM sgm_forma_farmaceutica;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        if($query->execute()){
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function createNewTipoProducto($codigo, $nombre){
        $SQL = "INSERT INTO sgm_forma_farmaceutica (descripcion, tipo_producto) VALUES (?, ?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $codigo);
        if($query->execute()){
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }

    function actualizarTipoProducto($codigo, $descripcion, $id){
        $SQL = "UPDATE sgm_forma_farmaceutica SET tipo_producto = ?, descripcion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);
        $query->bindParam(3, $id);
        if($query->execute()){
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }
    }
    
    function getTipoProductoByIdToAud($id) { 
        $tipoProducto = FormaFarmaceutica::find($id); 
        return $tipoProducto->toJson(); 
    }

}
