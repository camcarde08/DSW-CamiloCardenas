<?php

require_once '../../../model/DbClass.php';

class AuxInformeOcupacionAnalista {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getProgramacionAnalista($fechaInicio, $fechaFin, $idAnalista) {
        $SQL = "SELECT t1.*, COUNT(t1.duracion_programada) as duracion, "
                . "t2.descripcion_especifica, t3.prefijo, t3.custom_id "
                . "FROM sgm_programacion_analistas t1 "
                . "JOIN sgm_ensayo_muestra t2 ON t1.id_ensayo_muestra = t2.id "
                . "JOIN sgm_muestra t3 ON t3.id = t2.id_muestra "
                . "WHERE t1.id_analista=? AND t1.fecha_programada >= ? AND t1.fecha_programada <= ? "
                . "GROUP BY t1.fecha_programada, t1.id_ensayo_muestra ORDER BY t1.fecha_programada ASC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAnalista);
        $query->bindParam(2, $fechaInicio);
        $query->bindParam(3, $fechaFin);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
            return null;
        }
    }

    function getAnalista($idAnalista) {
        $SQL = "SELECT * "
                . "FROM sgm_usuario "
                . "WHERE id=? LIMIT 1;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAnalista);
        if ($query->execute()) {
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
            return null;
        }
    }

}
