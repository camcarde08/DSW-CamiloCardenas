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
class TablaEstMuestraDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getDatosGraficaParticipacionClientesEst($fechaInicial, $fechaFinal) {
        $SQL = "SELECT t2.nombre as 'cliente', count(t1.id) as 'cantidad', t2.id FROM sgm_est_muestra t1 JOIN sgm_terceros t2 ON t2.id = t1.id_tercero where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? group by t2.nombre";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicial);
        $query->bindParam(2, $fechaFinal);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
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

    function getDetalleParticipacionClienteEst($fechaInicial, $fechaFinal, $idCliente)
    {
        $SQL = "SELECT t1.id as id_muestra,
                concat(t5.prefijo,'-',t1.custom_id) as show_id_muestra,
                t3.nombre as producto
                FROM sgm_est_muestra t1 
                JOIN sgm_terceros t2 ON t2.id = t1.id_tercero 
                JOIN sgm_producto t3 ON t3.id = t1.id_producto
                JOIN sgm_tipo_muestra t5 ON t1.id_tipo_muestra = t5.id
                where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? AND t2.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicial);
        $query->bindParam(2, $fechaFinal);
        $query->bindParam(3, $idCliente);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
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
