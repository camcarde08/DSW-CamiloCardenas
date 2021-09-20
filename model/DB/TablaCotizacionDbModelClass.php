<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaContactoDbModel
 *
 * @author hruge
 */
class TablaCotizacionDbModelClass {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function insertCotizacion($estado, $fechaSol, $fechaCom, $idCLiente, $nomContacto, $telContacto, $observacion, $observacionFin,$aplicaIva,$aplicaRetencion){
        
        $SQL = "INSERT INTO sgm_cotizacion (estado,fecha_solicitud,fecha_compromiso,cliente,nombre_contacto,tel_contacto,observaciones,observacionesFin,aplica_iva,aplica_retencion) VALUES (?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $estado);
        $query->bindParam(2,$fechaSol);
        $query->bindParam(3,$fechaCom);
        $query->bindParam(4,$idCLiente);
        $query->bindParam(5,$nomContacto);
        $query->bindParam(6,$telContacto);
        $query->bindParam(7,$observacion);
        $query->bindParam(8,$observacionFin);
        $query->bindParam(9,$aplicaIva);
        $query->bindParam(10,$aplicaRetencion);
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function getCotizacionById($idCotizacion){
        $SQL = "SELECT cot.*, ter.nombre, DATE_FORMAT(cot.fecha_solicitud,'%Y/%m/%d') as fechaSol, DATE_FORMAT(cot.fecha_compromiso,'%Y/%m/%d') as fechaCom, cot.aplica_iva, cot.aplica_retencion FROM sgm_cotizacion  cot join sgm_terceros ter on cot.cliente = ter.id where cot.id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCotizacion);
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function updateCotizacionById($idCotizacion, $estado, $fechaSol, $fechaCom, $idCliente, $nomContacto, $telContacto, $observacion,$observacionFin,$aplicaIva, $aplicaRetencion){
        $SQL = "UPDATE sgm_cotizacion SET estado = ?, fecha_solicitud = ?,fecha_compromiso = ?,cliente = ?,nombre_contacto = ?,tel_contacto = ?,observaciones = ?,observacionesFin = ?, aplica_iva = ?, aplica_retencion = ? WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $estado);
        $query->bindParam(2, $fechaSol);
        $query->bindParam(3, $fechaCom);
        $query->bindParam(4, $idCliente);
        $query->bindParam(5, $nomContacto);
        $query->bindParam(6, $telContacto);
        $query->bindParam(7, $observacion);
        $query->bindParam(8, $observacionFin);
        $query->bindParam(9, $aplicaIva);
        $query->bindParam(10, $aplicaRetencion);
        $query->bindParam(11, $idCotizacion);
         if($query->execute()){
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }
    
    public function updateEstadoCotizacionByIdCotizacion($idCotizacion, $idEstado){
        $SQL = "UPDATE sgm_cotizacion SET estado = ? WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEstado);
        $query->bindParam(2, $idCotizacion);
        
        if($query->execute()){
            $data = true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
    
    public function rechazarCotizacionByIdCotizacion($idCotizacion, $motivo){
        $SQL = "UPDATE sgm_cotizacion SET motivo_rechazo = ?, estado = 4 WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $motivo);
        $query->bindParam(2, $idCotizacion);
        
        if($query->execute()){
            $data = true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
}
