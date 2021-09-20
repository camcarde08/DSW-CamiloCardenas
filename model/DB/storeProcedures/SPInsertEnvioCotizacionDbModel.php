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
class SPInsertEnvioCotizacionDbModel {
    
     private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    public function spConsultaCotizaciones($idCotizacion,$destino,$medio,$observaciones){
        $spCodigo = 200;
        $spDetalle= "hola";
        $SQL = "CALL sgm.sp_insert_envio_cotizacion(?,?,?,?,@spCodigo,@spDetalle);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idCotizacion);
        $query->bindParam(2, $destino);
        $query->bindParam(3, $medio);
        $query->bindParam(4, $observaciones);
        
        
        if ($query->execute()) {
            $outputArray = $this->dbClass->getConexion()->query("select @spCodigo")->fetch(PDO::FETCH_ASSOC);
            $spCodigo = $outputArray['@spCodigo'];
            $outputArray = $this->dbClass->getConexion()->query("select @spDetalle")->fetch(PDO::FETCH_ASSOC);
            $spDetalle = $outputArray['@spDetalle'];

            $modelTablaCotizacion = new TablaCotizacionDbModelClass();
            $cotizacion = $modelTablaCotizacion->getCotizacionById($idCotizacion);
            if ($cotizacion[0]["estado"] != 3 && $cotizacion[0]["estado"] != 4) {
                $modelTablaCotizacion->updateEstadoCotizacionByIdCotizacion($idCotizacion, 2);
            }

            
            $response = array('result' => 0, 'message' => 'Se ha registrado exitosamente el envio de la cotizacion');
        } else {
            $arr = $query->errorInfo();
            $data = array('result' => 1, 'message' => 'Fallo el registro del envio');
        }
       
        return $response;
    }
   
}
