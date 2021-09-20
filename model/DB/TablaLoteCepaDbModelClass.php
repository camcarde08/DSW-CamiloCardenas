<?php

/**
 * Created by PhpStorm.
 * User: hruge
 * Date: 25/02/2017
 * Time: 01:40 AM
 */
class TablaLoteCepaDbModelClass
{
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function insertNewLote($codigo,$descripcion,$fechaVencimiento,$activo,$tipo,$cantidadActual,$fechaIngreso,$fechaApertura,
                                  $fechaTerminacion,$fechaPreparacion,$fechaPromocion,$cantidadPreparada,$idCepa,$loteInterno){
        $SQL = "INSERT INTO sgm_lote_cepa (codigo,descripcion,fecha_vencimiento,activo,tipo,cantidad_actual,fecha_ingreso,fecha_apertura,fecha_terminacion,fecha_preparacion,fecha_promocion,cantidad_preparada,id_cepa,lote_interno) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);
        $query->bindParam(3, $fechaVencimiento);
        $query->bindParam(4, $activo);
        $query->bindParam(5, $tipo);
        $query->bindParam(6, $cantidadActual);
        $query->bindParam(7, $fechaIngreso);
        $query->bindParam(8, $fechaApertura);
        $query->bindParam(9, $fechaTerminacion);
        $query->bindParam(10, $fechaPreparacion);
        $query->bindParam(11, $fechaPromocion);
        $query->bindParam(12, $cantidadPreparada);
        $query->bindParam(13, $idCepa);
        $query->bindParam(14, $loteInterno);
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

    public function getLotesByIdCepa($idCepa){
        $SQL = "SELECT * FROM sgm_lote_cepa WHERE id_cepa = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCepa);
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

    public function deactivateLotesByIdCepa($idCepa){
        $SQL = "UPDATE sgm_lote_cepa SET activo = 0 WHERE id_cepa = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCepa);
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

    public function activateLoteById($idLote){
        $SQL = "UPDATE sgm_lote_cepa SET activo = 1 WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idLote);
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

}