<?php

require_once '../../../model/DbClass.php';

class AuxInformeMuestraEstabilidadSalir {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getInfoMuestraEsabilidadPorSalir($fechaInicio, $fechaFin) {
            $SQL = "SELECT t1.id, CONCAT(t3.prefijo, '-', t1.custom_id) AS muestra, t1.label_producto AS producto, 
                    t2.fecha_analisis AS fechaSalida, t1.fecha_llegada, t1.numero_lote AS lote, t4.tipo_estabilidad, 
                    CONCAT(t5.label, '-', t6.label) AS tiempo, t1.label_tercero AS cliente 
                    FROM sgm_est_muestra t1 
                    JOIN sgm_est_sub_muestra t2 ON t1.id = t2.id_muestra 
                    JOIN sgm_tipo_muestra t3 ON t1.id_tipo_muestra = t3.id 
                    JOIN sgm_est_tipo_estabilidad t4 ON t1.id_tipo_estabilidad = t4.id 
                    LEFT JOIN sgm_est_duracion_estabilidad t5 ON t2.id_duracion = t5.id 
                    LEFT JOIN sgm_est_temperatura t6 ON t2.id_temperatura = t6.id 
                    WHERE t2.fecha_analisis BETWEEN ? AND ? order by t1.id asc";
            $query = $this->dbClass->getConexion()->prepare($SQL);
            $query->bindParam(1, $fechaInicio);
            $query->bindParam(2, $fechaFin);
            if ($query->execute()) {
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                $error = $query->errorInfo();
            }
    }

}
