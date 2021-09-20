<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaProgramacionAnalistasDbModelClass
 *
 * @author andres
 */
class TablaProgramacionAnalistasDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getUniqueProgramacionByIdEnsayoMuestra($idEnsayoMuestra) {
        $SQL = "SELECT * FROM sgm_programacion_analistas where id_ensayo_muestra = ? LIMIT 1;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);

        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => $query->errorInfo()
            );
        }
        return $response;
    }

    function insertProgramacionAnalistas($idEnsayoMuestra, $idAnalista, $fechaProg, $duracionProg, $idProgramador) {
        $SQL = "insert into sgm_programacion_analistas " .
                "(id_ensayo_muestra,id_analista, fecha_programada, duracion_programada, programado_por) " .
                "values (?,?,?,?,?)";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        $query->bindParam(2, $idAnalista);
        $query->bindParam(3, $fechaProg);
        $query->bindParam(4, $duracionProg);
        $query->bindParam(5, $idProgramador);
        if ($query->execute()) {
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }

    function getProgramacionByIdMuestraAndIdAnalista($idMuestra, $idAnalista) {
        $SQL = "SELECT t2.id_muestra, t1.id_ensayo_muestra, t2.estado_ensayo, t1.id_analista, t2.id_ensayo, t3.descripcion, t2.duracion, t2.equipo, t2.turno, DATE_FORMAT(t2.fecha_programacion, '%Y-%m-%d') as fecha_programacion, DATE_FORMAT(t2.fecha_compromiso_interno, '%Y-%m-%d') as fecha_compromiso_interno, t2.observaciones, t2.id_paquete, t4.descripcion as descripcion_paquete,  t5.descripcion as descripcion_equipo, t5.referencia as referencia_equipo, t2.aprobado, t6.descripcion as des_ensayo_est, t2.descripcion_especifica as desEspecifica, t3.prog_automatica as analizar_tercero FROM sgm_programacion_analistas t1 JOIN sgm_ensayo_muestra t2 ON t1.id_ensayo_muestra = t2.id JOIN sgm_ensayo t3 ON t2.id_ensayo = t3.id JOIN sgm_ensayo t4 ON t2.id_paquete = t4.id LEFT JOIN sgm_equipo t5 ON t2.equipo = t5.id  JOIN `sgm_muestra` `t7` ON `t2`.`id_muestra` = `t7`.`id` LEFT JOIN sgm_est_tiempo_muestra_ensayo t6 on t2.id = t6.id_ensayo_muestra WHERE t2.id_muestra = ? AND t1.id_analista = ? GROUP BY t1.id_ensayo_muestra;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $idAnalista);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function deleteProgramacionByIdEnsayoMuestra($idEnsayoMuestra) {
        $SQL = "DELETE FROM sgm_programacion_analistas WHERE id_ensayo_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function getProgramacionByIdAnalistaAndRangeTime($idAnalista, $startDate, $endDate) {
        $SQL = "SELECT t1.fecha_programada as fecha, sum(t1.duracion_programada) as tiempo_programado FROM sgm_programacion_analistas t1 JOIN sgm_ensayo_muestra t2 ON t1.id_ensayo_muestra = t2.id JOIN sgm_muestra t3 ON t2.id_muestra = t3.id where t3.id_estado_muestra != 11 AND t1.id_analista = ? and t1.fecha_programada >= ? and t1.fecha_programada <= ? group by t1.fecha_programada ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAnalista);
        $query->bindParam(2, $startDate);
        $query->bindParam(3, $endDate);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getProgramacionByIdAnalistaOnDate($idAnalista, $onDate) {
        $SQL = "SELECT t1.id as idProgramacion," .
                "t1.fecha_programada," .
                "t1.duracion_programada," .
                "t2.id_muestra," .
                "t2.id_ensayo," .
                "t3.descripcion as desEnsayo," .
                "t2.id_paquete," .
                "t4.descripcion as desPaquete," .
                "t2.fecha_programacion," .
                "t2.fecha_compromiso_interno," .
                "t2.duracion," .
                "t2.equipo as idEquipo," .
                "t5.descripcion as desEquipo," .
                "t6.id_area_analisis as idAreaAnalisis," .
                "t7.descripcion as desAreaAnalisis," .
                "t6.tipo_estabilidad," .
                "t1.programado_por as idProgramador," .
                "t8.nombre as nomProgramador, " .
                "t2.aprobado as aprobadoEnsMue, " .
                "t1.id_ensayo_muestra " .
                "FROM sgm_programacion_analistas t1 " .
                "join sgm_ensayo_muestra t2 on t1.id_ensayo_muestra = t2.id " .
                "join sgm_ensayo t3 on t2.id_ensayo = t3.id " .
                "join sgm_ensayo t4 on t2.id_paquete = t4.id " .
                "join sgm_equipo t5 on t2.equipo = t5.id " .
                "join sgm_muestra t6 on t2.id_muestra = t6.id " .
                "join sgm_areas_analisis t7 on t6.id_area_analisis = t7.id " .
                "join sgm_usuario t8 on t1.programado_por = t8.id " .
                "where " .
                "id_analista = ? " .
                "and " .
                "fecha_programada = ? " .
                "and " .
                "t6.id_estado_muestra != 11;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAnalista);
        $query->bindParam(2, $onDate);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function updateFechaProgramada($idProgramacion, $newDate, $programador) {
        $SQL = "UPDATE sgm_programacion_analistas " .
                "SET " .
                "fecha_programada = ? , " .
                "programado_por = ? " .
                "WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newDate);
        $query->bindParam(2, $programador);
        $query->bindParam(3, $idProgramacion);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function getProgramacionAnalista($idAnalista) {
        $SQL = "SELECT t2m.prefijo, t2m.custom_id, t2.id_muestra,t2.id_paquete, "
                . "t4.descripcion as des_paquete,t2.id_ensayo,t5.descripcion as des_ensayo, "
                . "t2.fecha_programacion,t2.fecha_compromiso_interno, t6.id_tercero,t7.nombre, "
                . "t8.descripcion as des_area, t6.tipo_estabilidad,t2.equipo, "
                . "t9.descripcion as des_equipo,t2.turno,t2.duracion,t2.observaciones, "
                . "t11.descripcion as desEspecifica, t2.especificacion as especificacion_ensayo_muestra, "
                . "t12.nombre as nombre_producto, t13.numero as numero_lote, t14.nombre as nombre_analista "
                . "FROM sgm_programacion_analistas t1 "
                . "join sgm_ensayo_muestra t2 on t1.id_ensayo_muestra = t2.id "
                . "join sgm_muestra t2m on t2.id_muestra = t2m.id left "
                . "join sgm_resultados t3 on t1.id_ensayo_muestra = t3.id_ensayo_muestra "
                . "join sgm_ensayo t4 on t2.id_paquete = t4.id "
                . "join sgm_ensayo t5 on t2.id_ensayo = t5.id "
                . "join sgm_muestra t6 on t2.id_muestra = t6.id "
                . "join sgm_terceros t7 on t6.id_tercero = t7.id "
                . "join sgm_areas_analisis t8 on t6.id_area_analisis = t8.id "
                . "left join sgm_equipo t9 on t2.equipo = t9.id "
                . "left join sgm_producto_paquete t10 on t6.id_producto = t10.id_producto "
                . "AND t2.id_paquete = t10.id_ensayo "
                . "left join sgm_producto_ensayo t11 on t6.id_producto = t11.id_producto "
                . "AND t10.id = t11.id_producto_paquete AND t2.id_ensayo = t11.id_ensayo "
                . "JOIN sgm_producto t12 on t6.id_producto = t12.id "
                . "JOIN sgm_lote t13 ON t6.id = t13.id_muestra "
                . "JOIN sgm_usuario t14 ON t14.id = t1.id_analista "
                . "where t2m.activa = 1 and t2.estado_ensayo=1 "
                . ($idAnalista == "0" ? "" : "AND t1.id_analista = '$idAnalista' ")
                . "group by t1.id_ensayo_muestra "
                . "order by t2m.fecha_llegada desc";
        $query = $this->dbClass->getConexion()->prepare($SQL);

        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $response = array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => $query->errorInfo()
            );
        }
        return $response;
    }

}
