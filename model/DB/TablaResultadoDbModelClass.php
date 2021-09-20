<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaResultadoDbModelClass
 *
 * @author andres
 */
class TablaResultadoDbModelClass {
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function getResultadoById($id){
        $SQL = "SELECT t1.*, t2.aprobado FROM sgm_resultados t1 JOIN sgm_ensayo_muestra t2 ON t1.id_ensayo_muestra = t2.id WHERE t1.id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en la consulta de resultado", "data" => $error
            );
        }
        return $response;
    }
    
    function insertResultado($idEnsayoMuestra, $idLote, $resultado, $observaciones, $usuarioRegistro, $fechaRegistro,$resultadoNumerico, $resultado1, $resultado2){
        $SQL= "INSERT INTO sgm_resultados (id_ensayo_muestra,id_lote,resultado,observaciones,id_usuario_registro,fecha_registro,resultado_numerico, resultado_1, resultado_2) VALUES (?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsayoMuestra);
        $query->bindParam(2, $idLote);
        $query->bindParam(3, $resultado);
        $query->bindParam(4, $observaciones);
        $query->bindParam(5, $usuarioRegistro);
        $query->bindParam(6, $fechaRegistro);
        $query->bindParam(7, $resultadoNumerico);
        $query->bindParam(8, $resultado1);
        $query->bindParam(9, $resultado2);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $arr = $query->errorInfo();
            return false;
        }
    }

    function insertResultado2($idEnsayoMuestra, $idLote, $resultado, $observaciones, $usuarioRegistro, $fechaRegistro,$resultadoNumerico, $resultado1, $resultado2){
        $SQL= "INSERT INTO sgm_resultados (id_ensayo_muestra,id_lote,resultado,observaciones,id_usuario_registro,fecha_registro,resultado_numerico, resultado_1, resultado_2) VALUES (?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsayoMuestra);
        $query->bindParam(2, $idLote);
        $query->bindParam(3, $resultado);
        $query->bindParam(4, $observaciones);
        $query->bindParam(5, $usuarioRegistro);
        $query->bindParam(6, $fechaRegistro);
        $query->bindParam(7, $resultadoNumerico);
        $query->bindParam(8, $resultado1);
        $query->bindParam(9, $resultado2);
        if($query->execute()){
            return array(
                "code" => "00000",
                "message" => "OK"
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
    
    function getResultadoByIdEnsayoMuestra($idEnsayoMuestra){
        $SQL="SELECT t1.* ,".
        "t2.nombre as nombreAnalistaAsignado,".
        "t3.numero as numeroLote ".
        "FROM sgm_resultados t1 ".
        "join sgm_usuario t2 on t1.id_usuario_registro = t2.id ".
        "left join sgm_lote t3 on t1.id_lote = t3.id ".
        "where id_ensayo_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsayoMuestra);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getResultadoByIdEnsayoMuestra2($idEnsayoMuestra){
        $SQL="SELECT t1.* ,".
            "t2.nombre as nombreAnalistaAsignado,".
            "t3.numero as numeroLote ".
            "FROM sgm_resultados t1 ".
            "join sgm_usuario t2 on t1.id_usuario_registro = t2.id ".
            "left join sgm_lote t3 on t1.id_lote = t3.id ".
            "where id_ensayo_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEnsayoMuestra);
        if($query->execute()){
            $data = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function updateResultadoById($idResultado, $idLote, $resultado, $observaciones, $idUsuario, $fechaRegistro,$resultado1,$resultado2,$resultadoNumerico){
        $SQL = "UPDATE sgm_resultados SET id_lote = ?,resultado = ?,observaciones = ?,id_usuario_registro = ?,fecha_registro = ?, resultado_1 = ?, resultado_2 = ?, resultado_numerico = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idLote);
        $query->bindParam(2, $resultado);
        $query->bindParam(3, $observaciones);
        $query->bindParam(4, $idUsuario);
        $query->bindParam(5, $fechaRegistro);
        $query->bindParam(6, $resultado1);
        $query->bindParam(7, $resultado2);
        $query->bindParam(8, $resultadoNumerico);
        $query->bindParam(9, $idResultado);
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    public function updateResultadoById2($idResultado, $idLote, $resultado, $observaciones, $idUsuario, $fechaRegistro,$resultado1,$resultado2,$resultadoNumerico){
        $SQL = "UPDATE sgm_resultados SET id_lote = ?,resultado = ?,observaciones = ?,id_usuario_registro = ?,fecha_registro = ?, resultado_1 = ?, resultado_2 = ?, resultado_numerico = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idLote);
        $query->bindParam(2, $resultado);
        $query->bindParam(3, $observaciones);
        $query->bindParam(4, $idUsuario);
        $query->bindParam(5, $fechaRegistro);
        $query->bindParam(6, $resultado1);
        $query->bindParam(7, $resultado2);
        $query->bindParam(8, $resultadoNumerico);
        $query->bindParam(9, $idResultado);
        if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
}
