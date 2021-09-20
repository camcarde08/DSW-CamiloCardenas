<?php

class TablaEstEnsayoSubMuestraDbModel {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getEnsayosSubMuestraParaAalisisBe($fecha) {
        
        $SQL = "select t1.id, t4.prefijo, t3.custom_id, t5.label as duracion, t6.label as temperatura, t2.fecha_analisis, t7.nombre as tercero,
            t8.nombre as producto, t1.descripcion_especifica,  t3.numero_lote, t1.id_analista, t9.nombre as analista
            from sgm_est_ensayo_sub_muestra t1
            JOIN sgm_est_sub_muestra t2 on t1.id_sub_muestra = t2.id
            JOIN sgm_est_muestra t3 on t2.id_muestra = t3.id
            JOIN  sgm_tipo_muestra t4 on t3.id_tipo_muestra = t4.id
            JOIN sgm_est_duracion_estabilidad t5 on t2.id_duracion = t5.id
            JOIN sgm_est_temperatura t6 on t2.id_temperatura =t6.id
            JOIN sgm_terceros t7 on t3.id_tercero = t7.id
            JOIN sgm_producto t8 on t3.id_producto = t8.id
            JOIN sgm_usuario t9 on t1.id_analista = t9.id
            

            where t1.estado_ensayo = 1 and t2.fecha_analisis < ? ;";
        
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", 
                "message" => "error en delete de la tabla sgm_lote", 
                "data" => $error
            );
        }
        return $response;
    }
    
    function getEnsayosSubMuestraParaTranscripcionBe($fecha) {
        
        $SQL = "select t1.id, t4.prefijo, t3.custom_id, t5.label as duracion, t6.label as temperatura, t2.fecha_analisis, t7.nombre as tercero,
            t8.nombre as producto, t1.descripcion_especifica,  t3.numero_lote, t1.id_analista, t9.nombre as analista
            from sgm_est_ensayo_sub_muestra t1
            JOIN sgm_est_sub_muestra t2 on t1.id_sub_muestra = t2.id
            JOIN sgm_est_muestra t3 on t2.id_muestra = t3.id
            JOIN  sgm_tipo_muestra t4 on t3.id_tipo_muestra = t4.id
            JOIN sgm_est_duracion_estabilidad t5 on t2.id_duracion = t5.id
            JOIN sgm_est_temperatura t6 on t2.id_temperatura =t6.id
            JOIN sgm_terceros t7 on t3.id_tercero = t7.id
            JOIN sgm_producto t8 on t3.id_producto = t8.id
            JOIN sgm_usuario t9 on t1.id_analista = t9.id
            

            where t1.estado_ensayo = 4 and t2.fecha_analisis < ? ;";
        
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", 
                "message" => "error en delete de la tabla sgm_lote", 
                "data" => $error
            );
        }
        return $response;
    }
    
    function getEnsayosSubMuestraParaRevisionBe($fecha) {
        
        $SQL = "select t1.id, t4.prefijo, t3.custom_id, t5.label as duracion, t6.label as temperatura, t2.fecha_analisis, t7.nombre as tercero,
            t8.nombre as producto, t1.descripcion_especifica,  t3.numero_lote, t1.id_analista, t9.nombre as analista
            from sgm_est_ensayo_sub_muestra t1
            JOIN sgm_est_sub_muestra t2 on t1.id_sub_muestra = t2.id
            JOIN sgm_est_muestra t3 on t2.id_muestra = t3.id
            JOIN  sgm_tipo_muestra t4 on t3.id_tipo_muestra = t4.id
            JOIN sgm_est_duracion_estabilidad t5 on t2.id_duracion = t5.id
            JOIN sgm_est_temperatura t6 on t2.id_temperatura =t6.id
            JOIN sgm_terceros t7 on t3.id_tercero = t7.id
            JOIN sgm_producto t8 on t3.id_producto = t8.id
            JOIN sgm_usuario t9 on t1.id_analista = t9.id
            

            where t1.estado_ensayo = 5 and t2.fecha_analisis < ? ;";
        
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", 
                "message" => "error en delete de la tabla sgm_lote", 
                "data" => $error
            );
        }
        return $response;
    }
    
    function getEnsayosSubMuestraParaRevisionBe2($fecha) {
        
        $SQL = "select t1.id, t4.prefijo, t3.custom_id, t5.label as duracion, t6.label as temperatura, t2.fecha_analisis, t7.nombre as tercero,
            t8.nombre as producto, t1.descripcion_especifica,  t3.numero_lote, t1.id_analista, t9.nombre as analista
            from sgm_est_ensayo_sub_muestra t1
            JOIN sgm_est_sub_muestra t2 on t1.id_sub_muestra = t2.id
            JOIN sgm_est_muestra t3 on t2.id_muestra = t3.id
            JOIN  sgm_tipo_muestra t4 on t3.id_tipo_muestra = t4.id
            JOIN sgm_est_duracion_estabilidad t5 on t2.id_duracion = t5.id
            JOIN sgm_est_temperatura t6 on t2.id_temperatura =t6.id
            JOIN sgm_terceros t7 on t3.id_tercero = t7.id
            JOIN sgm_producto t8 on t3.id_producto = t8.id
            JOIN sgm_usuario t9 on t1.id_analista = t9.id
            

            where t1.estado_ensayo = 5 and t2.fecha_analisis < ? ;";
        
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", 
                "message" => "error en delete de la tabla sgm_lote", 
                "data" => $error
            );
        }
        return $response;
    }

}
