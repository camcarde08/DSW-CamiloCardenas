<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewEnsayoMuestraReferenciasDbModelClass
 *
 * @author hruge
 */
class ViewEnsayoMuestraReferenciasDbModelClass {
    //put your code here
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getEnsayoMuestraByIdMuestra($idMuestra){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    //Función para obtener ensayos muestras Fisicoquímicos
    function getEnsayoMuestraByIdMuestraFQ($idMuestra){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id_muestra = ? "
                . "order by orden asc, desEspecifica asc";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
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
                "code" => "PEND", "message" => "error en select de la vista sgm_ensayo_muestra_referecnias sgm_lote", "data" => $error
            );
        }
        return $response;
    }
    
    function getEnsayoMuestraByIdMuestra2($idMuestra){
        $SQL = "select t1.*, t2.descripcion as des_metodo from sgm_ensayo_muestra_referencias t1 JOIN sgm_metodo t2 ON t1.id_metodo = t2.id  where id_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
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
                "code" => "PEND", "message" => "error en select de la vista sgm_ensayo_muestra_referecnias sgm_lote", "data" => $error
            );
        }
        return $response;
    }
    
    function getEnsayoMuestraActivosByIdMuestraAndEstadoEnsayo($idMuestra, $estado){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id_muestra = ? and validacion = 1 and estado_ensayo=?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $estado);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayoMuestraActivosByIdMuestraAndEstadoEnsayo2($idMuestra, $estado){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id_muestra = ? and validacion = 1 and (estado_ensayo=0 OR estado_ensayo=6)";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMuestra);

        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getEnsayoMuestraRefByIdEnsayoMuestra($idEnsayoMuestra){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsayoMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getEnsayosByIdSubMuestra($idSubMuestra){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id_sub_muestra = ?  ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idSubMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getSelectedEnsayosByIdSubMuestra($idSubMuestra){
        $SQL = "select * from sgm_ensayo_muestra_referencias where id_sub_muestra = ? and validacion = 1  ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idSubMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getCantidadEnsayosSinResultadosByIdSubMuestra($idSubMuestra){
        $SQL = "SELECT COUNT(t3.id) as cantidad from (SELECT t1.*, count(t2.id) as cantidad_resultados FROM sgm_ensayo_muestra_referencias t1 LEFT JOIN sgm_resultados t2 ON t1.id = t2.id_ensayo_muestra WHERE t1.validacion = 1 AND t1.id_sub_muestra = 64 GROUP BY t1.id) t3 WHERE t3.cantidad_resultados = 0 ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idSubMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
            $data = $data[0]["cantidad"];
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getCantidadEnsayosSinRevisarByIdSubMuestra($idSubMuestra){
        $SQL = "SELECT count(id) as cantidad FROM sgm_ensayo_muestra_referencias WHERE validacion = 1 and id_sub_muestra = ? and estado_ensayo < 2";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idSubMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
            $data = $data[0]["cantidad"];
        } else {
            $data = false;
        }
        return $data;
    }
}
