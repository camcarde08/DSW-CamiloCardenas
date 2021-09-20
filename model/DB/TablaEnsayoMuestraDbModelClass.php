<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEnsayoMuestraDbModelClass
 *
 * @author lvelasquez
 */
class TablaEnsayoMuestraDbModelClass {

    //put your code here

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getEnsayosRevisadosByIdMuestra($idMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra t1 WHERE id_muestra = ? AND  (t1.estado_ensayo = 2 OR t1.estado_ensayo = 3);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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

    function getEnsayosConResultado($idMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra t1 JOIN sgm_resultados t2 ON t1.id = t2.id_ensayo_muestra where t1.id_muestra = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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

    function getEnsayosAnalisisOMayor($idMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra where id_muestra = ? AND validacion = 1 AND (estado_ensayo = 4 OR estado_ensayo = 5 OR estado_ensayo = 2 OR estado_ensayo = 3);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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

    function getEnsayosSeleccionadosByIdMuestra($idMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra where id_muestra = ? AND validacion = 1;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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

    function getEnsayoMuestraByIdMuestra($idMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra WHERE id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_ensayo_muestra", "data" => $error
            );
        }
        return $response;
    }

    function insertEnsayoMuestra($id_Muestra, $id_Paquete, $id_Ensayo, $validacion, $area, $tiempo, $duracion, $equipo, $id_Metodo, $especificacion, $descripcionEspecifica, $idHojaCalculo, $valor) {
        $RFE = 0;
        
        $SQL = "INSERT INTO sgm_ensayo_muestra(id_muestra,id_paquete,id_ensayo,validacion,area_analisis,tiempo,duracion,equipo,id_metodo,especificacion, descripcion_especifica, id_hoja_calculo,valor, RFE) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id_Muestra);
        $query->bindParam(2, $id_Paquete);
        $query->bindParam(3, $id_Ensayo);
        $query->bindParam(4, $validacion);
        $query->bindParam(5, $area);
        $query->bindParam(6, $tiempo);
        $query->bindParam(7, $duracion);
        $query->bindParam(8, $equipo);
        $query->bindParam(9, $id_Metodo);
        $query->bindParam(10, $especificacion);
        $query->bindParam(11, $descripcionEspecifica);
        $query->bindParam(12, $idHojaCalculo);
        $query->bindParam(13, $valor);
        $query->bindParam(14, $RFE);
        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $error = $query->errorInfo();
            return false;
        }
    }

    function insertEnsayoMuestraEst($id_Muestra, $id_Paquete, $id_Ensayo, $validacion, $area, $tiempo, $duracion, $equipo, $id_Metodo, $fechaProgramacion) {

        $SQL = "INSERT INTO sgm_ensayo_muestra(
                id_muestra,
                id_paquete,
                id_ensayo,
                validacion,
                area_analisis,
                tiempo,
                duracion,
                equipo,
                id_metodo,
                fecha_programacion)
                VALUES (?,?,?,?,?,?,?,?,?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id_Muestra);
        $query->bindParam(2, $id_Paquete);
        $query->bindParam(3, $id_Ensayo);
        $query->bindParam(4, $validacion);
        $query->bindParam(5, $area);
        $query->bindParam(6, $tiempo);
        $query->bindParam(7, $duracion);
        $query->bindParam(8, $equipo);
        $query->bindParam(9, $id_Metodo);
        $query->bindParam(10, $fechaProgramacion);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $error = $query->errorInfo();
            return false;
        }
    }

    function deleteEnsayosByIdMuestra($idMuestra) {
        $SQL = "delete from sgm_ensayo_muestra where id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function deleteEnsayosByIdMuestra2($idMuestra) {
        $SQL = "delete from sgm_ensayo_muestra where id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en delete de la tabla sgm_ensayo_muestra", "data" => $error
            );
        }
        return $response;
    }

    function updateDetalleEnsayoMuestraFromProgAnalistas($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones, $especificacion) {
        $SQL = "UPDATE sgm_ensayo_muestra SET duracion = ?,equipo = ?,turno = ?,fecha_programacion = ?,fecha_compromiso_interno = ?,observaciones = ?, especificacion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $duracion);
        $query->bindParam(2, $equipo);
        $query->bindParam(3, $turno);
        $query->bindParam(4, $fechaProg);
        $query->bindParam(5, $fechaCompInterno);
        $query->bindParam(6, $observaciones);
        $query->bindParam(7, $especificacion);
        $query->bindParam(8, $idEnsayoMuestra);

        if ($query->execute()) {
            return true;
        } else {
            $error = $this->dbClass->getConexion()->errorInfo();
            $erro2 = $error[2];
            return false;
        }
    }

    function updateEstadoByIdEnsayoMuestra($idEnsayoMuestra) {
        $SQL = "UPDATE sgm_ensayo_muestra " .
                "SET " .
                "estado_ensayo = 1 " .
                "WHERE " .
                "id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function updateEstadoByIdEnsayoMuestraReprogramacion($idEnsayoMuestra, $newEstado, $motivo, $fechaReprog) {
        $SQL = "UPDATE sgm_ensayo_muestra SET estado_ensayo = ?, motivo_reprogramacion = concat(IFNULL(concat(motivo_reprogramacion,'\n'), ''),?), fecha_reprogramacion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newEstado);
        $query->bindParam(2, $motivo);
        $query->bindParam(3, $fechaReprog);
        $query->bindParam(4, $idEnsayoMuestra);
        if ($query->execute()) {
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

    function updateEstadoByIdEnsayoMuestra2($idEnsayoMuestra, $newEstado) {
        
        $SQL = "UPDATE sgm_ensayo_muestra SET estado_ensayo = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newEstado);
        $query->bindParam(2, $idEnsayoMuestra);
        if ($query->execute()) {
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
    
    function updateEstadoByIdEnsayoMuestra2RFE($idEnsayoMuestra, $newEstado, $razon, $RFE) {
        if ($RFE == 1){
            $RFE = $RFE;
        } else {
            $RFE = 0;
        }
        
        $razon = $razon == "" ? NULL : $razon;
        
        $SQL = "UPDATE sgm_ensayo_muestra SET estado_ensayo = ?, motivo_rfe = concat(IFNULL(concat(motivo_reprogramacion,'\n'), ''),?), RFE = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newEstado);
        $query->bindParam(2, $razon);
        $query->bindParam(3, $RFE);
        $query->bindParam(4, $idEnsayoMuestra);
        if ($query->execute()) {
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

    function updateEstadoByIdEnsayoMuestraTo0($idEnsayoMuestra, $motivo) {
        $SQL = "UPDATE sgm_ensayo_muestra " .
                "SET " .
                "estado_ensayo = 0, " .
                "motivo_reprogramacion = concat(IFNULL(concat(motivo_reprogramacion,'\n'), ''),?)" .
                "WHERE " .
                "id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $motivo);
        $query->bindParam(2, $idEnsayoMuestra);
        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function getEnsayoMuestraByIdMuestraForConsultaHojaRuta($IdMuestra) {
        // $SQL = "select t1.*,t2.id_producto,t3.id as id_producto_paquete,t4.especificacion,t4.descripcion as desEspecifica,t5.descripcion as des_metodo,t6.id_analista,t7.descripcion as descripcionEnsayo,t8.descripcion as descripcionPaquete, t9.nombre as nombreAnalistaAsignado, t10.descripcion as des_ensayo_est, t11.descripcion as nom_estado_ensayo, if(isnull(t12.cant_resultados),0,t12.cant_resultados) as cant_resultados,t10.id_sub_muestra,t13.duracion_est,t13.temperatura_est from sgm_ensayo_muestra t1 join sgm_muestra t2 on t1.id_muestra = t2.id join sgm_producto_paquete t3 on t1.id_paquete = t3.id_ensayo and t2.id_producto = t3.id_producto join sgm_producto_ensayo t4 on t1.id_ensayo = t4.id_ensayo and t2.id_producto = t4.id_producto and t3.id = t4.id_producto_paquete join sgm_metodo t5 on t1.id_metodo = t5.id join sgm_programacion_analistas t6 on t1.id = t6.id_ensayo_muestra join sgm_ensayo t7 on t1.id_ensayo = t7.id join sgm_ensayo t8 on t1.id_paquete = t8.id join sgm_usuario t9 on t6.id_analista = t9.id join sgm_estado_ensayo_muestra t11 on t1.estado_ensayo = t11.id left join (select id_ensayo_muestra,count(id) as cant_resultados from sgm_resultados group by id_ensayo_muestra) t12 on t1.id = t12.id_ensayo_muestra LEFT JOIN sgm_est_tiempo_muestra_ensayo t10 on t1.id = t10.id_ensayo_muestra JOIN sgm_ensayo_muestra_referencias t13 ON t1.id=t13.id where (t1.estado_ensayo=1 or t1.estado_ensayo=2 or t1.estado_ensayo=3) and t1.validacion=1 and t1.id_muestra = ? group by t1.id;";
        $SQL = "SELECT * FROM prueba WHERE id_muestra = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $IdMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayoMuestraByIdMuestraIdAnalistaForConsultaHojaRuta($IdMuestra, $idAnalista) {
        $SQL = "select t1.*,t1.especificacion as especificacion_ensayo_muestra, t2.id_producto,t3.id as id_producto_paquete,t4.especificacion as especificacion_producto_ensayo,t4.descripcion as desEspecifica,t5.descripcion as des_metodo,t6.id_analista,t7.descripcion as descripcionEnsayo,t8.descripcion as descripcionPaquete,t9.nombre as nombreAnalistaAsignado, t10.descripcion as des_ensayo_est, t11.descripcion as nom_estado_ensayo, if(isnull(t12.cant_resultados),0,t12.cant_resultados) as cant_resultados,t10.id_sub_muestra,t13.duracion_est,t13.temperatura_est from sgm_ensayo_muestra t1 join sgm_muestra t2 on t1.id_muestra = t2.id join sgm_producto_paquete t3 on t1.id_paquete = t3.id_ensayo and t2.id_producto = t3.id_producto join sgm_producto_ensayo t4 on t1.id_ensayo = t4.id_ensayo and t2.id_producto = t4.id_producto and t3.id = t4.id_producto_paquete join sgm_metodo t5 on t1.id_metodo = t5.id join sgm_programacion_analistas t6 on t1.id = t6.id_ensayo_muestra join sgm_ensayo t7 on t1.id_ensayo = t7.id join sgm_ensayo t8 on t1.id_paquete = t8.id join sgm_usuario t9 on t6.id_analista = t9.id join sgm_estado_ensayo_muestra t11 on t1.estado_ensayo = t11.id left join (select id_ensayo_muestra,count(id) as cant_resultados from sgm_resultados group by id_ensayo_muestra) t12 on t1.id = t12.id_ensayo_muestra LEFT JOIN sgm_est_tiempo_muestra_ensayo t10 on t1.id = t10.id_ensayo_muestra JOIN sgm_ensayo_muestra_referencias t13 ON t1.id=t13.id where (t1.estado_ensayo=1 or t1.estado_ensayo=2 or t1.estado_ensayo=3) and t1.validacion=1 and t1.id_muestra = ? and  t6.id_analista = ? group by t1.id;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $IdMuestra);
        $query->bindParam(2, $idAnalista);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function updateAprobadoEnsayoMuestraByIdEnsayoMuestra($idEnsayoMuestra, $newAprobado, $newEstado, $aprobadoPor, $obsRevision) {
        $SQL = "UPDATE sgm_ensayo_muestra SET estado_ensayo = ?,aprobado = ?,aprobado_por = ?, observaciones_revision = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $newEstado);
        $query->bindParam(2, $newAprobado);
        $query->bindParam(3, $aprobadoPor);
        $query->bindParam(4, $obsRevision);
        $query->bindParam(5, $idEnsayoMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function updateMetodoAprobacionFromConHojaRutaMuestra($idEnsayoMuestra, $metodo, $aprobado) {

        $SQL1 = "select id from sgm_metodo where descripcion = ?";
        $auxQuery = $this->dbClass->getConexion()->prepare($SQL1);
        $auxQuery->bindParam(1, $metodo);
        if ($auxQuery->execute()) {
            $data1 = $auxQuery->fetchAll();
            if (count($data1) > 0) {
                $metodo = $data1[0][0];

                if ($aprobado === '1') {
                    $SQL = "UPDATE sgm_ensayo_muestra " .
                            "SET " .
                            "aprobado = ? ," .
                            "id_metodo = ?, " .
                            "aprobado_por = ? " .
                            "WHERE id = ? ;";
                    $query = $this->dbClass->getConexion()->prepare($SQL);
                    $query->bindParam(1, $aprobado);
                    $query->bindParam(2, $metodo);
                    $query->bindParam(3, $_SESSION['userId']);
                    $query->bindParam(4, $idEnsayoMuestra);
                    if ($query->execute()) {
                        $data = true;
                    } else {
                        $data = false;
                    }
                } else {
                    $SQL = "UPDATE sgm_ensayo_muestra " .
                            "SET " .
                            "aprobado = ? ," .
                            "id_metodo = ?, " .
                            "aprobado_por = null " .
                            "WHERE id = ? ;";
                    $query = $this->dbClass->getConexion()->prepare($SQL);
                    $query->bindParam(1, $aprobado);
                    $query->bindParam(2, $metodo);
                    $query->bindParam(3, $idEnsayoMuestra);
                    if ($query->execute()) {
                        $data = true;
                    } else {
                        $data = false;
                    }
                }
            } else {
                $data = false;
            }
        } else {
            $data = false;
        }
        return $data;
    }

    function getMuestraByIdEnsayoMuestra($idEnsayoMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayosWithOutProgramacionByidAreaAnalisis($idAreAnalisis) {
        $SQL = "SELECT concat(t2.prefijo, '-', t2.custom_id) as customId, t1.id_muestra,t4.descripcion as estado_muestra,t2.fecha_llegada, t3.nombre as nombre_tercero, t1.fecha_programacion,TIMESTAMPDIFF(DAY, NOW(), t1.fecha_programacion) as diferencia, p1.nombre as producto, lot.numero as lote FROM sgm_ensayo_muestra t1 join sgm_muestra t2 on t1.id_muestra = t2.id join sgm_producto p1 on t2.id_producto = p1.id join sgm_lote lot on t2.id = lot.id_muestra join sgm_terceros t3 on t2.id_tercero = t3.id,(SELECT id,id_muestra,max(fecha),id_estado,id_usuario FROM sgm_historico_estado_muestra group by id_muestra ) as res1 join sgm_estado t4 on res1.id_estado = t4.id where t1.id_muestra = res1.id_muestra and t1.estado_ensayo = 0 and t2.id_area_analisis = ? and t1.validacion = 1 and (TIMESTAMPDIFF(DAY, NOW(), t1.fecha_programacion) <= 60 or isnull(t1.fecha_programacion)) group by t1.id_muestra";
        //$SQL = "SELECT t1.id_muestra,t4.descripcion as estado_muestra,t2.fecha_llegada, t3.nombre as nombre_tercero FROM sgm_ensayo_muestra t1 join sgm_muestra t2 on t1.id_muestra = t2.id join sgm_terceros t3 on t2.id_tercero = t3.id, (SELECT id,id_muestra,max(fecha),id_estado,id_usuario FROM sgm_historico_estado_muestra group by id_muestra )  as res1 join sgm_estado t4 on res1.id_estado = t4.id where t1.id_muestra = res1.id_muestra and t1.estado_ensayo = 0 and t2.id_area_analisis = ? and t1.validacion = 1 group by id_muestra";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAreAnalisis);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayosPorProgramar($idAreAnalisis) {
        $SQL = "SELECT t2.prefijo as prefijo, t2.custom_id as customId,"
                . "t2.id,t4.descripcion as estado_muestra, t2.fecha_llegada,"
                . "t3.nombre as nombre_tercero, p1.nombre as producto, lot.numero as lote, t2.fecha_compromiso "
                . "FROM sgm_ensayo_muestra t1 "
                . "join sgm_muestra t2 on t1.id_muestra = t2.id "
                . "join sgm_producto p1 on t2.id_producto = p1.id "
                . "join sgm_lote lot on t2.id = lot.id_muestra "
                . "join sgm_terceros t3 on t2.id_tercero = t3.id "
                . "join sgm_estado t4 "
                . "where t4.id=2 and (t1.estado_ensayo = 0 or t1.estado_ensayo = 6) "
                . "and t2.id_area_analisis = ? and t1.validacion = 1 and t2.activa = 1 "
                . "group by t1.id_muestra "
                . "order by t2.fecha_llegada desc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAreAnalisis);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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

    function getEnsayosCountAporbacionesGroupByMuestra() {
        $SQL = "SELECT t1.id_muestra,count(t1.id) as cantidad_total,lot.numero as lote,t2.cant_aprobado,t3.cant_no_aprobado, 
t4.id_producto,t5.nombre as nom_producto,t4.id_tercero,t6.nombre as nom_tercero, est.descripcion as estado,mue.id_estado_muestra as idEstado,
mue.fecha_llegada, mue.fecha_compromiso 
FROM sgm_ensayo_muestra t1 left join (select *, count(aprobado) as cant_aprobado from sgm_ensayo_muestra where aprobado = 1 
group by id_muestra) t2 on t1.id_muestra = t2.id_muestra join sgm_lote lot on t1.id_muestra = lot.id_muestra 
join sgm_muestra mue on t1.id_muestra = mue.id join sgm_estado est on mue.id_estado_muestra = est.id left 
join (select *, count(aprobado) as cant_no_aprobado from sgm_ensayo_muestra where aprobado = 0 
AND validacion = 1 group by id_muestra) t3 on t1.id_muestra = t3.id_muestra join sgm_muestra t4 on t1.id_muestra = t4.id 
join sgm_producto t5 on t4.id_producto = t5.id join sgm_terceros t6 on t4.id_tercero = t6.id 
WHERE t1.validacion = 1 group by t1.id_muestra";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayosCountAprobacionAndResultadosGroupByMuestra() {
        $SQL = "SELECT mu.prefijo, mu.custom_id, t1.id_muestra,count(t1.id) as cantidad_total,mu.id_estado_muestra,sum(t1.aprobado) as cant_aprobado,(count(t1.id) - sum(t1.aprobado)) as cant_no_aprobado,ifnull(t5.ensayos_con_resultados,0) as ensayos_con_resultados, prod.nombre as nom_producto, ter.nombre as nom_tercero, lot.numero as lote FROM sgm_ensayo_muestra t1 LEFT JOIN ( select t4.id_ensayo_muestra, t4.id_muestra, count(t4.cant_resultados) as ensayos_con_resultados from (select t2.id as id_ensayo_muestra, t2.id_muestra,  count(t3.id) as cant_resultados  from sgm_ensayo_muestra t2 join sgm_resultados t3 on t2.id = t3.id_ensayo_muestra  group by t2.id ) t4 group by id_muestra ) t5 on t1.id_muestra = t5.id_muestra join sgm_muestra mu on t1.id_muestra = mu.id  join sgm_producto prod on mu.id_producto = prod.id join sgm_lote lot on mu.id = lot.id_muestra join sgm_terceros ter on mu.id_tercero = ter.id WHERE t1.validacion = 1 AND ensayos_con_resultados > 0 AND mu.id_estado_muestra = 3 || mu.id_estado_muestra = 4 || mu.id_estado_muestra = 8 group by t1.id_muestra";
        //$SQL ="SELECT t1.id,sum(t1.aprobado) as cant_aprobado,15 as cant_no_aprobado,0 as ensayos_con_resultados, t1.area_analisis as nom_producto, t1.observaciones as nom_tercero, t1.id_paquete as lote FROM sgm_ensayo_muestra t1 group by id"
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayoMuestraByIdMuestraAndEstado($idMuestra, $estadoEnsayoMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra where id_muestra = ? and estado_ensayo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $estadoEnsayoMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayoMuestraByIdMuestraAndEstadoAndValicacion($idMuestra, $estadoEnsayoMuestra, $validacion) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra where id_muestra = ? and estado_ensayo =? and validacion = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $estadoEnsayoMuestra);
        $query->bindParam(3, $validacion);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getResumenEnsayoMuestraByIdMuestra($idMuestra) {
        $SQL = "SELECT t1.id_muestra,count(t1.id) as cantidad_total,t2.cant_aprobado,t3.cant_no_aprobado,t4.id_producto,t5.nombre as nom_producto,t4.id_tercero,t6.nombre as nom_tercero FROM sgm_ensayo_muestra t1 left join (select *, count(aprobado) as cant_aprobado from sgm_ensayo_muestra where aprobado = 1 group by id_muestra) t2 on t1.id_muestra = t2.id_muestra left join (select *, count(aprobado) as cant_no_aprobado from sgm_ensayo_muestra where aprobado = 0 group by id_muestra) t3 on t1.id_muestra = t3.id_muestra join sgm_muestra t4 on t1.id_muestra = t4.id join sgm_producto t5 on t4.id_producto = t5.id join sgm_terceros t6 on t4.id_tercero = t6.id  where t1.id_muestra = ? group by t1.id_muestra;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);

        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getBasicEnsayoMuestraEstabilidad($idMuestra) {
        $SQL = "SELECT t1.id_muestra,t1.id_paquete, t2.descripcion as nom_paquete,t1.id_ensayo,t3.descripcion as nom_ensayo,t7.descripcion as nom_ensayo_per,t4.id_producto ,t5.nombre as nom_producto,t6.id as id_pro_paq,t7.tiempo as duracion,t1.area_analisis FROM sgm_ensayo_muestra t1 join sgm_ensayo t2 on t1.id_paquete = t2.id join sgm_ensayo t3 on t1.id_ensayo = t3.id join sgm_muestra t4 on t4.id = t1.id_muestra join sgm_producto t5 on t4.id_producto = t5.id join sgm_producto_paquete t6 on t4.id_producto = t6.id_producto and t1.id_paquete = t6.id_ensayo join sgm_producto_ensayo t7 on t1.id_ensayo = t7.id_ensayo and t4.id_producto = t7.id_producto and t6.id = t7.id_producto_paquete where id_muestra = ? group by id_muestra,id_paquete,id_ensayo;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);

        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function contarEnsayoSinResutadosByIdMuestra($idMuestra) {
        $SQL = "SELECT count(t1.id) as cantidad FROM sgm_ensayo_muestra t1 LEFT JOIN (select count(id) as cant_resultados, id_ensayo_muestra from sgm_resultados group by id_ensayo_muestra) t2 on t1.id = t2.id_ensayo_muestra where t1.validacion = 1 and t1.id_muestra = ? and isnull(cant_resultados)";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function contarEnsayosSinRevisionByIdMuestra($idMuestra) {
        $SQL = "SELECT count(id) as cantidad from sgm_ensayo_muestra t1 WHERE t1.validacion = 1 AND t1.aprobado = 0 AND t1. id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function getEnsayoMuestraById($idEnsayoMuestra) {
        $SQL = "SELECT * FROM sgm_ensayo_muestra where id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function getBECordEst() {
        $SQL = "SELECT t1.id_muestra, t2.id_area_analisis, t3.nombre as producto, t5.duracion as tiempo_est, SUBSTRING_INDEX(t4.tiempo, 't', -(1))  as temperatura_est, t6.numero as lote, t5.fecha_referencia FROM sgm_ensayo_muestra t1 JOIN sgm_muestra t2 ON t1.id_muestra = t2.id JOIN sgm_producto t3 ON t2.id_producto = t3.id JOIN sgm_est_tiempo_muestra_ensayo t4 ON t1.id = t4.id_ensayo_muestra JOIN sgm_sub_muestra_est t5 ON t4.id_sub_muestra = t5.id JOIN sgm_lote t6 ON t6.id_muestra = t1.id_muestra WHERE t1.validacion = 1 AND t1.estado_ensayo = 0 AND t2.id_area_analisis = 4 AND t2.activa = 1 GROUP BY t1.id_muestra, t5.duracion ORDER BY t1.id_muestra, t5.duracion;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function analizarEnsayoMuestra($fechaAnalisis, $idEnsayoMuestra) {
        $SQL = "UPDATE sgm_ensayo_muestra SET estado_ensayo=4, fecha_analisis = ? WHERE id=?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaAnalisis);
        $query->bindParam(2, $idEnsayoMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
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

    function getEnsayosParaTranscripcion() {
        $SQL = "SELECT t2m.prefijo,t2m.custom_id,t2.id_muestra,t2.id_paquete, "
                . "t4.descripcion as des_paquete,t2.id_ensayo,t5.descripcion as des_ensayo, "
                . "t2.fecha_programacion,t2.fecha_compromiso_interno,t6.id_tercero, "
                . "t7.nombre,t8.descripcion as des_area,t6.tipo_estabilidad,t2.equipo, "
                . "t9.descripcion as des_equipo,t2.duracion,t2.observaciones, "
                . "t2.descripcion_especifica as desEspecifica, "
                . "t2.especificacion as especificacion_ensayo_muestra, "
                . "t12.nombre as nombre_producto,t13.numero as numero_lote,t14.nombre as analista "
                . "FROM sgm_programacion_analistas t1 "
                . "join sgm_ensayo_muestra t2 on t1.id_ensayo_muestra = t2.id "
                . "join sgm_muestra t2m on t2.id_muestra = t2m.id "
                . "left join sgm_resultados t3 on t1.id_ensayo_muestra = t3.id_ensayo_muestra "
                . "join sgm_ensayo t4 on t2.id_paquete = t4.id "
                . "join sgm_ensayo t5 on t2.id_ensayo = t5.id "
                . "join sgm_muestra t6 on t2.id_muestra = t6.id "
                . "join sgm_terceros t7 on t6.id_tercero = t7.id "
                . "join sgm_areas_analisis t8 on t6.id_area_analisis = t8.id "
                . "left join sgm_equipo t9 on t2.equipo = t9.id "
                . "join sgm_usuario t14 on t1.id_analista = t14.id "
                . "JOIN sgm_producto t12 on t6.id_producto = t12.id "
                . "JOIN sgm_lote t13 ON t6.id = t13.id_muestra "
                . "where t2m.activa = 1 and t2.estado_ensayo=4 and t2.validacion = 1 "
                . "group by t1.id_ensayo_muestra";
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

    function getEnsayosParaRevisar($areaAnalisis) {
        $SQL = "SELECT t2m.prefijo, t2m.custom_id, t2.id_muestra,t2.id_paquete, "
                . "t4.descripcion as des_paquete,t2.id_ensayo,t5.descripcion as des_ensayo, "
                . "t2.fecha_programacion,t2.fecha_compromiso_interno,t6.id_tercero, "
                . "t7.nombre,t8.descripcion as des_area, t6.tipo_estabilidad,t2.equipo, "
                . "t9.descripcion as des_equipo,t2.duracion,t2.observaciones, "
                . "t11.descripcion as desEspecifica,t2.especificacion as especificacion_ensayo_muestra, "
                . "t12.nombre as nombre_producto, t13.numero as numero_lote,t14.nombre as analista "
                . "FROM sgm_programacion_analistas t1 "
                . "join sgm_ensayo_muestra t2 on t1.id_ensayo_muestra = t2.id "
                . "join sgm_muestra t2m on t2.id_muestra = t2m.id "
                . "left join sgm_resultados t3 on t1.id_ensayo_muestra = t3.id_ensayo_muestra "
                . "join sgm_ensayo t4 on t2.id_paquete = t4.id "
                . "join sgm_ensayo t5 on t2.id_ensayo = t5.id "
                . "join sgm_muestra t6 on t2.id_muestra = t6.id "
                . "join sgm_terceros t7 on t6.id_tercero = t7.id "
                . "join sgm_areas_analisis t8 on t6.id_area_analisis = t8.id and t6.id_area_analisis = ? "
                . "left join sgm_equipo t9 on t2.equipo = t9.id "
                . "join sgm_usuario t14 on t1.id_analista = t14.id "
                . "left join sgm_producto_paquete t10 on t6.id_producto = t10.id_producto "
                . "AND t2.id_paquete = t10.id_ensayo "
                . "left join sgm_producto_ensayo t11 on t6.id_producto = t11.id_producto "
                . "AND t10.id = t11.id_producto_paquete AND t2.id_ensayo = t11.id_ensayo "
                . "JOIN sgm_producto t12 on t6.id_producto = t12.id "
                . "JOIN sgm_lote t13 ON t6.id = t13.id_muestra "
                . "where t2m.activa = 1 and t2.validacion = 1 "
                . "and (t2.estado_ensayo=5 "
                . "or (isnull( t2m.fecha_pre_conclusion) and ISNULL(t2m.usuario_pre_conclusion) "
                . "and t2m.id_estado_muestra=16)) "
                . "group by t1.id_ensayo_muestra "
                . "order by t2m.fecha_llegada desc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $areaAnalisis);

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

    function obtenerEnsayosAsignados($idUsuario, $idMuestra) {
        $SQL = "SELECT DISTINCT(tbl2.id), tbl2.descripcion_especifica "
                . "FROM sgm_muestra tbl1 join sgm_ensayo_muestra tbl2 on tbl2.id_muestra = tbl1.id "
                . "join sgm_programacion_analistas tbl3 on tbl3.id_ensayo_muestra = tbl2.id "
                . "where tbl1.id = ? and tbl3.id_analista = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $idUsuario);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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

    function anularEnsayosMuestra($idMuestra) {
        $SQL = "UPDATE sgm_ensayo_muestra "
                . "SET estado_ensayo = 7 "
                . "WHERE id_muestra = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
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

    function consultaInfoIdHojaCalculo($idEnsayoMuestra)
    {
        $SQL = "SELECT t4.id_hoja_calculo 
                FROM sgm_ensayo_muestra t1 
                JOIN sgm_muestra t2 ON t1.id_muestra = t2.id 
                JOIN sgm_producto_paquete t3 ON t3.id_producto = t2.id_producto AND t3.id_ensayo = t1.id_paquete 
                JOIN sgm_producto_ensayo t4 ON t4.id_producto_paquete = t3.id AND t4.id_ensayo = t1.id_ensayo 
                WHERE t1.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_OBJ)
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
