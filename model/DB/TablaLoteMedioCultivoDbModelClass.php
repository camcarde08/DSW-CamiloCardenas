<?php

/**
 * Created by PhpStorm.
 * User: hruge
 * Date: 12/02/2017
 * Time: 07:46 PM
 */
class TablaLoteMedioCultivoDbModelClass
{
    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function insertNewLoteMc($codigo,$descripcion,$fecha_vencimiento,$activo,$tipo,$cantidad_actual,$fecha_ingreso,$fecha_apertura,$fecha_terminacion,$fecha_preparacion,$fecha_promocion,$cantidad_preparada,$id_medio_cultivo,$lote_interno){
        $SQL = "INSERT INTO sgm_lote_mc (codigo,descripcion,fecha_vencimiento,activo,tipo,cantidad_actual,fecha_ingreso,fecha_apertura,fecha_terminacion,fecha_preparacion,fecha_promocion,cantidad_preparada,id_medio_cultivo,lote_interno) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);
        $query->bindParam(3, $fecha_vencimiento);
        $query->bindParam(4, $activo);
        $query->bindParam(5, $tipo);
        $query->bindParam(6, $cantidad_actual);
        $query->bindParam(7, $fecha_ingreso);
        $query->bindParam(8, $fecha_apertura);
        $query->bindParam(9, $fecha_terminacion);
        $query->bindParam(10, $fecha_preparacion);
        $query->bindParam(11, $fecha_promocion);
        $query->bindParam(12, $cantidad_preparada);
        $query->bindParam(13, $id_medio_cultivo);
        $query->bindParam(14, $lote_interno);
        if($query->execute()){
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => array(
                    "insertId" => $this->dbClass->getConexion()->lastInsertId()
                )
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "0001",
                "message" => "error",
                "data" => array(
                    "errorDb" => $error
                )
            );
        }

    }

    function getLotesByIdMedioCultivo($idMedioCultivo){
        $SQL = "SELECT * FROM sgm_lote_mc WHERE id_medio_cultivo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMedioCultivo);


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

    function deactivateAllLotesByIdMedioCultivo($idMedioCultivo){
        $SQL = "UPDATE sgm_lote_mc SET activo = 0 WHERE id_medio_cultivo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMedioCultivo);
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

    function activateLoteById($idLote){
        $SQL = "UPDATE sgm_lote_mc SET activo = 1 WHERE id = ?;";
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
    
    
    public function updateLoteMedioCultivo($codigo, $descripcion, $fecha_vencimiento, $tipo,$cantidad_actual, $fecha_ingreso, $fecha_apertura
            , $fecha_terminacion, $fecha_preparacion, $fecha_promocion, $cantidad_preparada, $lote_interno, $id) {
        $SQL = "UPDATE sgm_lote_mc SET codigo = ?, descripcion = ?, fecha_vencimiento = ?, tipo = ?, cantidad_actual = ?, fecha_ingreso = ?,"
                . " fecha_apertura = ?, fecha_terminacion = ?, fecha_preparacion = ?, fecha_promocion = ?, cantidad_preparada = ?,lote_interno = ?"
                . "  WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $campoNulo = null;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);
        
        if ($fecha_vencimiento !== null && $fecha_vencimiento !== '') {
            $explodeDate = explode("GMT", $fecha_vencimiento);
            $query->bindParam(3, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(3, $campoNulo);
        }
        
        $query->bindParam(4, $tipo);
        

        if ($cantidad_actual == '' || $cantidad_actual == 'null') {
            $query->bindParam(5, $campoNulo);
        } else {
            $query->bindParam(5, $cantidad_actual);
        }

        if ($fecha_ingreso !== null && $fecha_ingreso !== '') {
            $explodeDate = explode("GMT", $fecha_ingreso);
            $query->bindParam(6, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(6, $campoNulo);
        }

        if ($fecha_apertura !== null && $fecha_apertura !== '') {
            $explodeDate = explode("GMT", $fecha_apertura);
            $query->bindParam(7, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(7, $campoNulo);
        }

        if ($fecha_terminacion !== null && $fecha_terminacion !== '') {
            $explodeDate = explode("GMT", $fecha_terminacion);
            $query->bindParam(8, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(8, $campoNulo);
        }

        if ($fecha_preparacion !== null && $fecha_preparacion !== '') {
            $explodeDate = explode("GMT", $fecha_preparacion);
            $query->bindParam(9, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(9, $campoNulo);
        }

        if ($fecha_promocion !== null && $fecha_promocion !== '') {
            $explodeDate = explode("GMT", $fecha_promocion);
            $query->bindParam(10, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(10, $campoNulo);
        }

        if ($cantidad_preparada == '' || $cantidad_preparada == 'null') {
            $query->bindParam(11, $campoNulo);
        } else {
            $query->bindParam(11, $cantidad_preparada);
        }

        $query->bindParam(12, $lote_interno);
        $query->bindParam(13, $id);

        if ($query->execute()) {
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