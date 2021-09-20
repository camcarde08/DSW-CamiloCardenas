<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ViewMuestraReferenciasDbModel
 *
 * @author andres
 */
class ViewMuestraReferenciasDbModel {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllMuestras() {
        $SQL = "select * from sgm_muestras_referencias order by id desc";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllEstadoMuestras() {
        $SQL = "SELECT mr.*,pa.id_analista,
                tb1.nombre_analista,TIMESTAMP(min(pa.fecha_programada)) as fecha_programada, 
                tb1.fecha_resultado, tb1.ensayos,tb1.fecha_analisis,mr.fabricante as proveedor, 
                mr.procedencia as propietario,en.descripcion as envase, 
                emp.descripcion as forma_farmaceutica,mdm.fecha_muestreo 
                FROM sgm_muestras_referencias mr 
                left join (select em.id, em.id_muestra, max(res.fecha_registro) as fecha_resultado, 
                max(em.fecha_analisis) as fecha_analisis, 
                group_concat(DISTINCT(em.descripcion_especifica) SEPARATOR ', ') as ensayos ,
                group_concat(DISTINCT(us.nombre) SEPARATOR ', ') as nombre_analista
                from sgm_ensayo_muestra em 
                left join sgm_resultados res on res.id_ensayo_muestra = em.id 
                left join sgm_programacion_analistas pa on em.id=pa.id_ensayo_muestra 
                left join sgm_usuario us on us.id=pa.id_analista
                where em.validacion=1 
                group by em.id_muestra) tb1 on mr.id=tb1.id_muestra 
                left join sgm_programacion_analistas pa on tb1.id=pa.id_ensayo_muestra 
                left join sgm_envase en on mr.id_envase = en.id 
                left join sgm_empaque emp on emp.id = mr.id_empaque 
                left join sgm_muestra_detalle_mic mdm on mdm.id_muestra = mr.id 
                group by mr.id order by mr.id desc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllMuestrasEstablidadesTiempos() {
        $SQL = "SELECT t1.id, t1.fecha_llegada, t4.nombre AS producto, t5.nombre AS cliente, t6.tipo_estabilidad AS tipoEstabilidad,t7.numero as lote,(case t3.tiempo 
when '0t0' then 'Mes0_T30°-65%' when '1t0' then 'Mes3_T30°-65%' when '2t0' then 'Mes6_T30°-65%' when '3t0' then 'Mes9_T30°-65%' when '4t0' then 'Mes12_T30°-65%' when '5t0' then 'Mes18_T30°-65%' 
when '6t0' then 'Mes24_T30°-65%'   when '7t0' then 'Mes36_T30°-65%' when '0t1' then 'Mes0_T30°-75%'       when '1t1' then 'Mes3_T30°-75%' when '2t1' then 'Mes6_T30°-75%'  when '3t1' then 'Mes9_T30°-75%' 
when '4t1' then 'Mes12_T30°-75%' when '5t1' then 'Mes18_T30°-75%'  when '6t1' then 'Mes24_T30°-75%'  when '7t1' then 'Mes36_T30°-75%' when '0t2' then 'Mes0_T40°-75%'   when '1t2' then 'Mes3_T40°-75%' 
when '2t2' then 'Mes6_T40°-75%'  when '3t2' then 'Mes9_T40°-75%' when '4t2' then 'Mes12_T40°-75%'  when '5t2' then 'Mes18_T40°-75%' when '6t2' then 'Mes24_T40°-75%' when '7t2' then 'Mes36_T40°-75%'
when '0t3' then 'Mes0_T50°-80%'  when '1t3' then 'Mes3_T50°-80%'  when '2t3' then 'Mes6_T50°-80%'  when '3t3' then 'Mes9_T50°-80%'   when '4t3' then 'Mes12_T50°-80%' when '5t3' then 'Mes18_T50°-80%'  
when '6t3' then 'Mes24_T50°-80%' when '7t3' then 'Mes36_T50°-80%' end)as tiempos, t2.fecha_programacion , t8.fecha_referencia , t8.duracion,t3.tiempo as tiempotemp, t1.prefijo
FROM sgm_muestra t1 JOIN sgm_ensayo_muestra t2 ON t1.id = t2.id_muestra 
JOIN sgm_est_tiempo_muestra_ensayo t3 ON t2.id = t3.id_ensayo_muestra AND t3.is_check = 1 
JOIN sgm_producto t4 ON t1.id_producto = t4.id 
JOIN sgm_terceros t5 ON t1.id_tercero = t5.id JOIN sgm_est_tipo_estabilidad t6 ON t1.tipo_estabilidad = t6.id 
JOIN sgm_sub_muestra_est t8 ON t3.id_sub_muestra = t8.id AND t3.is_check = 1 
JOIN sgm_lote t7 ON t1.id = t7.id_muestra group by t1.id,t3.tiempo";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

}
