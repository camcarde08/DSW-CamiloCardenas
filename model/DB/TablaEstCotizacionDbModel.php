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
class TablaEstCotizacionDbModel {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function rechazarEstCotizacion($idCotizacion, $motivo){
        $SQL = "UPDATE sgm_est_cotizacion SET estado = 4, motivo_rechazo = ? WHERE id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $motivo);
        $query->bindParam(2, $idCotizacion);
        if($query->execute()){
            return true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    public function updateCotizacionById($fechaSolicitud, $fechaCompromiso,$idtercero, $nomContacto, $telContacto, $idProducto, $tipoEstabilidadValue,$observacion1, $observacion2, $observacion3, $tiempos, $aplicaIva, $aplicaRetencion, $idCotizacion){
        $SQL = "UPDATE sgm_est_cotizacion SET fecha_solicitud = ?,fecha_compromiso = ?,id_tercero = ?,contacto = ?,tel_contacto = ?,id_producto = ?,tipo_estabilidad = ?,observaciones = ?,onservaciones2 = ?,observaciones3 = ?,tiempos = ?, aplica_iva = ?, aplica_retencion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $fechaSolicitud);
        $query->bindParam(2,$fechaCompromiso);
        $query->bindParam(3,$idtercero);
        $query->bindParam(4,$nomContacto);
        $query->bindParam(5,$telContacto);
        $query->bindParam(6,$idProducto);
        $query->bindParam(7,$tipoEstabilidadValue);
        $query->bindParam(8,$observacion1);
        $query->bindParam(9,$observacion2);
        $query->bindParam(10,$observacion3);
        $query->bindParam(11,$tiempos);
        $query->bindParam(12,$aplicaIva);
        $query->bindParam(13,$aplicaRetencion);
        $query->bindParam(14,$idCotizacion);
        
        
        
        if($query->execute()){
            return true;
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function insertEstCotizacion($customId, $estado,$fechaSolicitud, $fechaCompromiso, $tercero, $contacto, $telContacto, $producto, $tipoEstabilidad, $tiempos, $observaciones, $observaciones2, $observaciones3,$aplicaIva,$aplicaRetencion){
     $SQL = "INSERT INTO sgm_est_cotizacion (custom_id,estado,fecha_solicitud,fecha_compromiso,id_tercero,contacto,tel_contacto,id_producto,tipo_estabilidad,observaciones,onservaciones2,observaciones3,tiempos,aplica_iva,aplica_retencion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $customId);
        $query->bindParam(2,$estado);
        $query->bindParam(3,$fechaSolicitud);
        $query->bindParam(4,$fechaCompromiso);
        $query->bindParam(5,$tercero);
        $query->bindParam(6,$contacto);
        $query->bindParam(7,$telContacto);
        $query->bindParam(8,$producto);
        $query->bindParam(9,$tipoEstabilidad);
        $query->bindParam(10,$observaciones);
        $query->bindParam(11,$observaciones2);
        $query->bindParam(12,$observaciones3);
        $query->bindParam(13,$tiempos);
        $query->bindParam(14,$aplicaIva);
        $query->bindParam(15,$aplicaRetencion);
        
        
        if($query->execute()){
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }
    
    function selectEstCotizacionById($idEstCotizacion){
        
        $SQL = "SELECT t1.*, t2.nombre as nom_tercero, t3.nombre as nom_producto, t4.estado as nom_estado FROM sgm_est_cotizacion t1 join sgm_terceros t2 on t1.id_tercero = t2.id join sgm_producto t3 on t1.id_producto = t3.id join sgm_estado_cotizacion t4 on t4.id = t1.estado where t1.id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idEstCotizacion);
        
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
    
    function selectAllEstCotizaciones(){
        $SQL = "SELECT t1.*, t2.estado AS des_estado, t3.nombre AS des_tercero FROM sgm_est_cotizacion t1 JOIN sgm_estado_cotizacion t2 ON t1.estado = t2.id JOIN sgm_terceros t3 ON t1.id_tercero = t3.id;";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        
        
        if($query->execute()){
            $data = $query->fetchAll();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            $data =  false;
        }
        return $data;
    }
    
    public function updateEstadoCotizacionById($idCotizacion, $idEstado){
        $SQL = "UPDATE sgm_est_cotizacion SET estado = ? WHERE id = ? ;";
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
    
    
    
    
    
       
}
