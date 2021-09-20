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
class TablaEstTiemposEnsMueDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertEstTiemposEnsMue($idEnsMue,$tiempo,$check, $descripcion, $idSubMuestra){
        $SQL="INSERT INTO sgm_est_tiempo_muestra_ensayo (id_ensayo_muestra,tiempo,is_check,descripcion,id_sub_muestra) VALUES (?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsMue);
        $query->bindParam(2,$tiempo);
        $query->bindParam(3,$check);
        $query->bindParam(4,$descripcion);
        $query->bindParam(5,$idSubMuestra);
        
        
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function getTiemposToEnsayoMuestra($idMuestra, $idPauete, $idEnsayo){
        $SQL="SELECT * FROM sgm_ensayo_muestra t1 JOIN sgm_est_tiempo_muestra_ensayo t2 on t1.id = t2.id_ensayo_muestra where t1.id_muestra = ? and t1.id_paquete = ? and t1.id_ensayo = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2,$idPauete);
        $query->bindParam(3,$idEnsayo);

        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $error = $this->dbClass->getConexion()->errorInfo();
            $data = false;
        }
        return $data;
    }
    
    function deleteTiemposByIdMuestra($idMuestra){
        $SQL="delete t1 from sgm_est_tiempo_muestra_ensayo t1 join sgm_ensayo_muestra t2 on t1.id_ensayo_muestra = t2.id where t2.id_muestra = ? ";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $data = true;
        } else {
            $error = $this->dbClass->getConexion()->errorInfo();
            $data = false;
        }
        return $data;
    }
}
