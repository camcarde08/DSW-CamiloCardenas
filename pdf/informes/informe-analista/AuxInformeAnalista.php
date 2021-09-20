<?php

require_once '../../../model/DbClass.php';

class AuxInformeAnalista {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getInfoMuestras($fechaInicio, $fechaFin, $idAnalista) {
        $SQL = "SELECT t1.id, CONCAT(t1.prefijo, '-', t1.custom_id) AS nombreMuestra, t1.fecha_llegada, t1.fecha_conclusion, 
t4.numero AS loteMuestra, t5.nombre AS productoMuestra, t6.nombre AS cliente 
FROM sgm_muestra t1 
JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_programacion_analistas t3 ON t2.id = t3.id_ensayo_muestra 
JOIN sgm_lote t4 ON t1.id = t4.id_muestra 
JOIN sgm_producto t5 ON t1.id_producto = t5.id 
JOIN sgm_terceros t6 ON t1.id_tercero = t6.id 
WHERE t1.fecha_llegada BETWEEN ? AND ? AND t3.id_analista = ? 
group by t1.id order by t1.id desc";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicio);
        $query->bindParam(2, $fechaFin);
        $query->bindParam(3, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

    function getInfoNumeroMuestrasEnsayosRealizados($fechaInicio, $fechaFin, $idAnalista) {
        $SQL = "SELECT count(distinct(t3.id_ensayo_muestra)) AS ensayosMuestra
FROM sgm_muestra t1 
JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_programacion_analistas t3 ON t2.id = t3.id_ensayo_muestra 
WHERE t1.fecha_llegada BETWEEN ? AND ? AND t3.id_analista = ? AND t2.validacion = 1 AND t2.estado_ensayo > 1";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicio);
        $query->bindParam(2, $fechaFin);
        $query->bindParam(3, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

    function getInfoNumeroMuestrasEnsayosSinRealizar($fechaInicio, $fechaFin, $idAnalista) {
        $SQL = "SELECT count(distinct(t3.id_ensayo_muestra)) AS ensayosMuestra
FROM sgm_muestra t1 
JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_programacion_analistas t3 ON t2.id = t3.id_ensayo_muestra 
WHERE t1.fecha_llegada BETWEEN ? AND ? AND t3.id_analista = ? AND t2.validacion = 1 AND t2.estado_ensayo = 1";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicio);
        $query->bindParam(2, $fechaFin);
        $query->bindParam(3, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }
    
    function getInfoNumeroMuestras($fechaInicio, $fechaFin, $idAnalista) {
        $SQL = "SELECT  count(distinct(t1.id)) AS muestras
FROM sgm_muestra t1 
JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_programacion_analistas t3 ON t2.id = t3.id_ensayo_muestra 
WHERE t1.fecha_llegada BETWEEN ? AND ? AND t3.id_analista = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicio);
        $query->bindParam(2, $fechaFin);
        $query->bindParam(3, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }
    
    function getInfoEnsayosRealizados($idMuestra, $idAnalista) {
        $SQL = "SELECT t4.descripcion AS ensayo, t5.nombre AS analista, t3.fecha_programada, t6.descripcion AS estado, t2.RFE, t2.fecha_analisis, t7.fecha_registro 
FROM sgm_muestra t1 
JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_programacion_analistas t3 ON t2.id = t3.id_ensayo_muestra 
JOIN sgm_ensayo t4 ON t2.id_ensayo = t4.id 
JOIN sgm_usuario t5 ON t5.id = t3.id_analista 
JOIN sgm_estado_ensayo_muestra t6 ON t6.id = t2.estado_ensayo 
LEFT JOIN sgm_resultados t7 ON t2.id = t7.id_ensayo_muestra 
WHERE t1.id = ? AND t3.id_analista = ? AND t2.validacion = 1 AND t2.estado_ensayo > 1
group by t3.id_ensayo_muestra";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }
    
    function getInfoEnsayosSinRealizar($idMuestra, $idAnalista) {
        $SQL = "SELECT t4.descripcion AS ensayo, t5.nombre AS analista, t3.fecha_programada, t6.descripcion AS estado, t2.RFE, t2.fecha_analisis, t7.fecha_registro 
FROM sgm_muestra t1 
JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_programacion_analistas t3 ON t2.id = t3.id_ensayo_muestra 
JOIN sgm_ensayo t4 ON t2.id_ensayo = t4.id 
JOIN sgm_usuario t5 ON t5.id = t3.id_analista 
JOIN sgm_estado_ensayo_muestra t6 ON t6.id = t2.estado_ensayo 
LEFT JOIN sgm_resultados t7 ON t2.id = t7.id_ensayo_muestra 
WHERE t1.id = ? AND t3.id_analista = ? AND t2.validacion = 1 AND t2.estado_ensayo = 1
group by t3.id_ensayo_muestra";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

}
