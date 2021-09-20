<?php


class TablaResultadoMediosCultivoDbModelClass {
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function insertResultadoMedioCultivo($idResultado, $idEstandar){
        $SQL = "INSERT INTO sgm_resultado_medios_cultivo (id_resultado,id_estandar) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idResultado);
        $query->bindParam(2, $idEstandar);
        if($query->execute()){
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => array(
                    "insertId" => $this->dbClass->getConexion()->lastInsertId()
                )
            ); 
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorSQL" => $query->errorInfo()
                )
            ); 
        }
        return $response;
    }
    
    public function getMediosByIdResultado($idResultado){
        $SQL = "SELECT * FROM sgm_resultado_medios_cultivo WHERE id_resultado = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idResultado);
        if($query->execute()){
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll()
            ); 
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorSQL" => $query->errorInfo()
                )
            ); 
        }
        return $response;
    }
    
    public function deleteMediosByIdResultado($idResultado){
        $SQL = "DELETE FROM sgm_resultado_medios_cultivo WHERE id_resultado = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idResultado);
        if($query->execute()){
            $response = array(
                "code" => "00000",
                "message" => "OK",
            ); 
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorSQL" => $query->errorInfo()
                )
            ); 
        }
        return $response;
    }
}
