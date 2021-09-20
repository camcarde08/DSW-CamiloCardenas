<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEstandarAudDbModelClass
 *
 * @author pcdvd
 */
class TablaEstandarAudDbModelClass {
    
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertAudEstandar($fecha, $old, $new, $idUsuario, $idEstandar, $evento, $razon){
        $SQL="INSERT INTO `sgm_estandar_aud` (`fecha`,`old`,`new`,`id_usuario`,`id_estandar`,`evento`,`razon`) VALUES (?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        $query->bindParam(2, $old);
        $query->bindParam(3, $new);
        $query->bindParam(4, $idUsuario);
        $query->bindParam(5, $idEstandar);
        $query->bindParam(6, $evento);
        $query->bindParam(7, $razon);
        
        
        
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorDb" => $query->errorInfo()
                )
            );
        }
        
        
                
    }
}
