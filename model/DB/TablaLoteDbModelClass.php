<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaLoteDbModelClass
 *
 * @author lvelasquez
 */
class TablaLoteDbModelClass {
    //put your code here
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertLote($idMuestra, $index, $tamano, $numero, $cantidad,$estado){
        $query = "INSERT INTO sgm_lote (id_muestra, indice, tamano, numero, cantidad_enviada, estado) VALUES (?, ?, ?,?, ?, ?);";
        $query = $this->dbClass->getConexion()->prepare($query) ;
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $index);
        $query->bindParam(3, $tamano);
        $query->bindParam(4, $numero);
        $query->bindParam(5, $cantidad);
        $query->bindParam(6, $estado);
        
        
         if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            echo false;
        }
    }
    
    function getLotesByidMuestra($idMuestra){
        $query = "select * from sgm_lote where id_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($query) ;
        $query->bindParam(1, $idMuestra);
         if($query->execute()){
            return $query->fetchAll();
        } else {
            return false;
        }
    }
    
    function getLotesByidMuestra2($idMuestra){
        $query = "select * from sgm_lote where id_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($query) ;
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_lote", "data" => $error
            );
        }
        return $response;
    }
    
    function deleteLtesByIdMuestra($idMuestra){
        $SQL = "DELETE FROM sgm_lote WHERE id_muestra = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    function deleteLtesByIdMuestra2($idMuestra){
        $SQL = "DELETE FROM sgm_lote WHERE id_muestra = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en delete de la tabla sgm_lote", "data" => $error
            );
        }
        return $response;
    }
    
    function updateLoteByIdMuestra($indice,$tamano,$numero,$cantidadEnviada,$idMuestra){
        $SQL = "UPDATE sgm_lote SET indice = ?,tamano = ?,numero = ?,cantidad_enviada = ? WHERE id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $indice);
        $query->bindParam(2, $tamano);
        $query->bindParam(3, $numero);
        $query->bindParam(4, $cantidadEnviada);
        $query->bindParam(5, $idMuestra);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en update de la tabla sgm_lote", "data" => $error
            );
        }
        return $response;
    }
    
    
}
