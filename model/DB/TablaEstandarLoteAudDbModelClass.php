<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEstandarLoteAudDbModelClass
 *
 * @author pcdvd
 */
class TablaEstandarLoteAudDbModelClass {
    //put your code here
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    } 
    
    function insertAudLote ($fecha,$old,$new,$idUsuario,$idLoteEstandar,$idEstandar,$evento,$razon)
    {
        $SQL="INSERT INTO `sgm_lote_estandar_aud`(`fecha`,`old`,`new`,`id_usuario`,`id_lote_estandar`,`id_estandar`,`evento`,`razon`)VALUES (?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        $query->bindParam(2, $old);
        $query->bindParam(3, $new);
        $query->bindParam(4, $idUsuario);
        $query->bindParam(5, $idLoteEstandar);
        $query->bindParam(6, $idEstandar);
        $query->bindParam(7, $evento);
        $query->bindParam(8, $razon);
        
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
