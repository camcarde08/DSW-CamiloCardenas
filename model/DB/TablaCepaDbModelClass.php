<?php

/**
 * Created by PhpStorm.
 * User: hruge
 * Date: 17/02/2017
 * Time: 01:11 AM
 */
class TablaCepaDbModelClass
{
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllActiveCepas(){
        $SQL = "SELECT * FROM sgm_cepa WHERE activo = 1;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
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

    function insertNewCepa($codigo,$nombre,$tipo,$activo){
        $SQL = "INSERT INTO sgm_cepa (codigo,nombre,tipo,activo) VALUES (?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $tipo);
        $query->bindParam(4, $activo);
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


    function getActiveCepasAndLoteByIdMEdioCultivo($idMedioCultivo){
        $SQL = "SELECT t1.*, t2.id as id_lote_activo FROM sgm_mic.sgm_medio_cultivo_cepa t1 JOIN sgm_lote_cepa t2 ON t1.id_cepa = t2.id_cepa WHERE t1.id_medio_cultivo = ? AND t2.activo = 1;";
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

    function insertEnsayoMuestraMedioCultivoCepaLote($idEnsayoMuestraMedioCultivo, $idCepa, $idLote){
        $SQL = "INSERT INTO sgm_ens_mue_med_cul_cepa_lote (id_ensayo_muestra_medio_cultivo_lote,id_cepa,id_lote_cepa) VALUES (?,?,?)";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsayoMuestraMedioCultivo);
        $query->bindParam(2, $idCepa);
        $query->bindParam(3, $idLote);
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

    function getActiveCepasByIdMediCultivo($idMedioCultivo){
        $SQL = "SELECT t1.id, t3.codigo, t3.nombre, t3.tipo, t3.activo FROM sgm_medio_cultivo_cepa t1 JOIN sgm_medio_cultivo t2 ON t1.id_medio_cultivo = t2.id JOIN sgm_cepa t3 ON t1.id_cepa = t3.id WHERE t1.id_medio_cultivo = ? AND t3.activo = 1;";
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

    function getCepasDisponiblesByIdMedioCultivo($idMedioCultivo){
        $SQL = "SELECT t1.* FROM sgm_cepa t1 LEFT JOIN (SELECT * FROM sgm_medio_cultivo_cepa t2 WHERE t2.id_medio_cultivo = ?) t2 ON t1.id = t2.id_cepa WHERE t2.id is NULL;";
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

    function deleteCepaAsocidadById($idAsociacion){
        $SQL="DELETE FROM sgm_medio_cultivo_cepa WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idAsociacion);
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

    function insertCepaAsociacion($idMedioCultivo, $idCepa){
        $SQL = "INSERT INTO sgm_medio_cultivo_cepa (id_medio_cultivo, id_cepa) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idMedioCultivo);
        $query->bindParam(2, $idCepa);
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

    function updateCepaById($id,$codigo,$nombre,$tipo,$activo){
        $SQL = "UPDATE sgm_cepa SET codigo = ?, nombre = ?, tipo = ?, activo = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $tipo);
        $query->bindParam(4, $activo);
        $query->bindParam(5, $id);
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