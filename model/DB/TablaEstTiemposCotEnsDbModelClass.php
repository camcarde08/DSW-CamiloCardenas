<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEstTiemposCotEnsDbModelClass
 *
 * @author hruge
 */
class TablaEstTiemposCotEnsDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function deleteEstTiemposCotEnsByIdCotEns($idEstCotEns){
        $SQL = "DELETE FROM sgm_est_tiempo_cot_ens WHERE id_est_cot_ens = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEstCotEns);
        if($query->execute()){
            return true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
        
    }
    
    function insertEstTiemposCotEns($idEstCotEns,$tiempo,$check){
        $SQL="INSERT INTO sgm_est_tiempo_cot_ens (id_est_cot_ens,tiempo,is_check) VALUES (?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEstCotEns);
        $query->bindParam(2,$tiempo);
        $query->bindParam(3,$check);
        
        
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function selectTiemposByIdEstCotEns($idEnsCotEns){
        $SQL = "SELECT * FROM sgm_est_tiempo_cot_ens where id_est_cot_ens = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsCotEns);
        
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
    
    
    
       
}
