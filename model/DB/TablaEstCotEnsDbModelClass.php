<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaAreaAnalisisDbModel
 *
 * @author hruge
 */
class TablaEstCotEnsDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function deleteEstCotEnsById($idEstCotEns){
        $SQL="DELETE FROM sgm_est_cot_ens WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEstCotEns);
        if($query->execute()){
            $data = true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
    
    function insertEstCotEns($idCotizacio,$idPaquete,$nomPaquete,$idEnsayo,$nomEnsayo,$valor){
        $SQL="INSERT INTO sgm_est_cot_ens (id_cotizacion,id_paquete,nom_paquete,id_ensayo,nom_ensayo,valor) VALUES (?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacio);
        $query->bindParam(2,$idPaquete);
        $query->bindParam(3,$nomPaquete);
        $query->bindParam(4,$idEnsayo);
        $query->bindParam(5,$nomEnsayo);
        $query->bindParam(6,$valor);
        
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function selectEstCotEnsByIdCotizacion($idCotizacion){
        $SQL = "SELECT * FROM sgm_est_cot_ens where id_cotizacion = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
    
    
    
       
}
