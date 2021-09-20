<?php

/**
 * Soulsystem SAS
 *
 * @author jpinilla
 */
require '../../controller/UtilsController.php';
require '../../model/DB/TablaMuestraDbModelClass.php';

class TablaReportesDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function cargarSystemParameters() {
        if ($this->dbClass->getParametrosExisten() !== true) {
            $this->dbClass->loadSystemParameters();
        }
    }

    function getidCliente($idInforme) {
        $query = "SELECT id_tercero FROM sgm_muestra WHERE id = $idInforme";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////////////Número de Tesla///////////
    /* function numeroCliente($idInforme) {
      $query = "SELECT CONCAT(t1.prefijo,'-0',t1.custom_id,'-17') AS elnum FROM sgm_muestra t1 WHERE t1.id = $idInforme";
      $query = $this->dbClass->getConexion()->prepare($query);
      if ($query->execute()) {
      $data = $query->fetchAll();
      } else {
      $data = false;
      }
      return $data;
      } */

    function numeroCliente($idInforme) {
        $this->dbClass->loadSystemParameters();
        $utilsController = new UtilsController();
        $prefijoCustom = $this->obtenerPrefijoCustom($idInforme);
        $ident = $utilsController->constructComplexIdMuestra($prefijoCustom[0]['prefijo'], $prefijoCustom[0]['custom_id']);
        $elnum = array('elnum' => $ident);
        $arraySalida = array($elnum);
        return $arraySalida;
    }

    function getRealIdMuestra($idMuestra) {
        $this->dbClass->loadSystemParameters();
        $utilsController = new UtilsController();
        $realId = $utilsController->getRealIdMuestra($idMuestra);
        return $realId;
    }

    function obtenerPrefijoCustom($idInforme) {
        $SQL = "SELECT t1.prefijo,t1.custom_id FROM sgm_muestra t1 WHERE t1.id = $idInforme";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////////////Fin Número de Tesla

    function getAllMuestrasEstadisticas() {
        $SQL = "SELECT * FROM sgm_estadistico_resultados";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Inicio Reportes de Muestras//////
    function getInfoPrincipal($idInforme) {
        $SQL = "SELECT t1.id AS id, t1.fecha_llegada AS fecha_llegada,t131.codigo, t1.numero_remision AS numero_remision, t1.fabricante AS fabricante, t1.procedencia AS procedencia, 
t1.fecha_fabricacion AS fecha_fabricacion, t1.fecha_vencimiento AS fecha_vencimiento, t1.conclusion AS conclusion, 
t1.id_estado_muestra AS estado, t3.nombre AS nombre_tercero, t3.direccion AS direccion_tercero, t3.telefono1 AS telefono_tercero, t5.descripcion AS des_area_analisis, 
t6.nombre AS nombre_producto, t7.descripcion AS FormaFarmaceutica,t7.id as idFormaFarmaceutica, t8.descripcion AS Empaque, t9.descripcion AS Envase, t12.numero AS lote,t12.tamano AS cantidadLote,
t15.nombre AS nombreAnalista, t16.nombre as PerfilAnalista, MAX(t13.fecha_analisis) as inicioAnalisis, t1.fecha_conclusion as finalizacionAnalisis,
t17.estabilidad, t17.planta_area as invima, t17.esp_aer_mes as especificacionTraza
FROM sgm_muestra t1 JOIN sgm_terceros t3 ON t1.id_tercero = t3.id 
JOIN sgm_areas_analisis t5 ON t1.id_area_analisis = t5.id JOIN sgm_producto t6 ON t1.id_producto = t6.id 
JOIN sgm_forma_farmaceutica t7 ON t6.id_formula_farma = t7.id JOIN sgm_empaque t8 ON t1.id_empaque = t8.id 
JOIN sgm_envase t9 ON t1.id_envase = t9.id JOIN sgm_lote t12 ON t12.id_muestra = t1.id 
 JOIN sgm_ensayo_muestra t13 ON t1.id = t13.id_muestra 
 JOIN sgm_ensayo t131 ON t13.id_paquete = t131.id
 LEFT JOIN sgm_programacion_analistas t14 ON t13.id = t14.id_ensayo_muestra 
 LEFT JOIN sgm_usuario t15 ON t14.id_analista = t15.id 
 LEFT JOIN sgm_perfil t16 ON t15.id_perfil = t16.id
 LEFT JOIN sgm_muestra_detalle_mic t17 ON t17.id_muestra = t1.id
 WHERE t1.id = $idInforme and t13.validacion=1 group by t1.id";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getMetodo($idInforme) {
        $SQL = "select t3.descripcion
                from sgm_muestra t1
                join sgm_ensayo_muestra t2 on t1.id = t2.id_muestra
                left join sgm_metodo t3 on t3.id = t2.id_metodo 
                where t1.id = $idInforme and t2.validacion=1 group by t3.id";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $array = array();
        if ($query->execute()) {
            $data = $query->fetchAll();
            foreach ($data as $metodo) {
                $array[] = $metodo[0];
            }
        }
        return $array;
    }

    function getEspecificacion($idInforme) {
        $SQL = "select t2.especificacion
                from sgm_muestra t1
                join sgm_ensayo_muestra t2 on t1.id = t2.id_muestra
                where t1.id = $idInforme and t2.validacion=1 group by t2.especificacion";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $array = array();
        if ($query->execute()) {
            $data = $query->fetchAll();
            foreach ($data as $especificacion) {
                $array[] = $especificacion[0];
            }
        }
        return $array;
    }

    function getInfoPrincipalPevio($idInforme) {
        $query = "SELECT t1.id AS id, t1.fecha_llegada AS fecha_llegada,t1.numero_remision AS numero_remision, t1.fabricante AS fabricante, t1.procedencia AS procedencia, 
t1.fecha_fabricacion AS fecha_fabricacion, t1.fecha_vencimiento AS fecha_vencimiento, t1.conclusion AS conclusion, 
t1.id_estado_muestra AS estado, t3.nombre AS nombre_tercero, t3.direccion AS direccion_tercero, t3.telefono1 AS telefono_tercero, t5.descripcion AS des_area_analisis, 
t6.nombre AS nombre_producto, t7.descripcion AS FormaFarmaceutica, t8.descripcion AS Empaque, t9.descripcion AS Envase, t12.numero AS lote,t12.tamano AS cantidadLote,t15.nombre AS nombreAnalista, t16.nombre as PerfilAnalista,
t20.fecha AS finalizacionAnalisis, t21.fecha AS inicioAnalisis FROM sgm_muestra t1 JOIN sgm_terceros t3 ON t1.id_tercero = t3.id 
JOIN sgm_areas_analisis t5 ON t1.id_area_analisis = t5.id JOIN sgm_producto t6 ON t1.id_producto = t6.id 
JOIN sgm_forma_farmaceutica t7 ON t6.id_formula_farma = t7.id JOIN sgm_empaque t8 ON t1.id_empaque = t8.id 
JOIN sgm_envase t9 ON t1.id_envase = t9.id JOIN sgm_lote t12 ON t12.id_muestra = t1.id 
 JOIN sgm_ensayo_muestra t13 ON t1.id = t13.id_muestra LEFT JOIN sgm_programacion_analistas t14 ON t13.id = t14.id_ensayo_muestra 
 left JOIN sgm_usuario t15 ON t14.id_analista = t15.id left JOIN sgm_perfil t16 ON t15.id_perfil = t16.id 
 left JOIN sgm_historico_estado_muestra t20 ON t1.id = t20.id_muestra
 left JOIN sgm_historico_estado_muestra t21 ON t1.id = t21.id_muestra AND t21.id_estado = 3
 WHERE t1.id = $idInforme group by t1.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoPrincipalMicro($idInforme) {
        $query = "SELECT t1.*, t2.*, t3.nombre as empresa, t4.nombre as dirigidoa, t4.cargo, t4.area as departamento, t5.nombre as producto, t6.*, 
t7.descripcion AS tipoproducto , concat(t9.descripcion) as tecnicausada, t10.fecha as fechaanalisis, t11.fecha as fechareporte
FROM sgm_muestra t1 JOIN sgm_lote t2 ON t1.id = t2.id_muestra JOIN sgm_terceros t3 ON t1.id_tercero = t3.id JOIN sgm_contacto t4 ON t3.id = t4.id_tercero
JOIN sgm_producto t5 ON t1.id_producto = t5.id JOIN sgm_muestra_detalle_mic t6 ON t1.id = t6.id_muestra 
JOIN sgm_forma_farmaceutica t7 ON t5.id_formula_farma = t7.id 
JOIN sgm_tecnica_usada_muestra_mic t8 ON t6.id = t8.id_muestra_detalle_mic
JOIN sgm_metodo t9 ON t8.id_metodo = t9.id 
LEFT JOIN sgm_historico_estado_muestra t10 ON t1.id = t10.id_muestra AND t10.id_estado = 3
LEFT JOIN sgm_historico_estado_muestra t11 ON t1.id = t11.id_muestra AND t11.id_estado = 7 
WHERE t1.id = $idInforme group by t1.id
";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoPrincipalHojaCalculoPlanta($dato1, $dato2) {
        $query = "SELECT t1.*, t2.*, mic.*, t3.nombre as empresa, t4.nombre as dirigidoa, t4.cargo, t4.area as departamento, t5.nombre as producto, t6.*, 
	t7.descripcion AS tipoproducto , concat(t9.descripcion) as tecnicausada, t10.fecha as fechaanalisis, t11.fecha as fechareporte
	FROM sgm_muestra t1 JOIN sgm_lote t2 ON t1.id = t2.id_muestra JOIN sgm_terceros t3 ON t1.id_tercero = t3.id JOIN sgm_contacto t4 ON t3.id = t4.id_tercero
	JOIN sgm_producto t5 ON t1.id_producto = t5.id JOIN sgm_muestra_detalle_mic t6 ON t1.id = t6.id_muestra 
	JOIN sgm_forma_farmaceutica t7 ON t5.id_formula_farma = t7.id 
	JOIN sgm_tecnica_usada_muestra_mic t8 ON t6.id = t8.id_muestra_detalle_mic
	JOIN sgm_metodo t9 ON t8.id_metodo = t9.id 
	LEFT JOIN sgm_historico_estado_muestra t10 ON t1.id = t10.id_muestra AND t10.id_estado = 3
	LEFT JOIN sgm_historico_estado_muestra t11 ON t1.id = t11.id_muestra AND t11.id_estado = 7 
	JOIN sgm_muestra_detalle_mic mic ON mic.id_muestra = t1.id
	WHERE t1.id between $dato1 and $dato2 group by t1.fabricante";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoPrincipalMicroPlantas($idInforme) {
        $query = "SELECT t1.*, t2.*, t3.nombre as empresa, t4.nombre as dirigidoa, t4.cargo, t4.area as departamento, t5.nombre as producto, t6.*, 
t7.descripcion AS tipoproducto , concat(t9.descripcion) as tecnicausada, t10.fecha as fechaanalisis, t11.fecha as fechareporte
FROM sgm_muestra t1 JOIN sgm_lote t2 ON t1.id = t2.id_muestra JOIN sgm_terceros t3 ON t1.id_tercero = t3.id JOIN sgm_contacto t4 ON t3.id = t4.id_tercero
JOIN sgm_producto t5 ON t1.id_producto = t5.id JOIN sgm_muestra_detalle_mic t6 ON t1.id = t6.id_muestra 
JOIN sgm_forma_farmaceutica t7 ON t5.id_formula_farma = t7.id 
JOIN sgm_tecnica_usada_muestra_mic t8 ON t6.id = t8.id_muestra_detalle_mic
JOIN sgm_metodo t9 ON t8.id_metodo = t9.id 
LEFT JOIN sgm_historico_estado_muestra t10 ON t1.id = t10.id_muestra AND t10.id_estado = 3
LEFT JOIN sgm_historico_estado_muestra t11 ON t1.id = t11.id_muestra AND t11.id_estado = 7 
WHERE t1.id = $idInforme group by t1.id
";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Inicio Reportes de Muestras//////
    function getInfoPrincipalEstabilidad($idInforme) {

        $query = "SELECT t1.id AS id, t1.fecha_llegada AS fecha_llegada, t1.fabricante AS fabricante, t1.procedencia AS procedencia, 
t1.fecha_fabricacion AS fecha_fabricacion, t1.fecha_vencimiento AS fecha_vencimiento, t1.conclusion AS conclusion, 
t1.id_estado_muestra AS estado, t3.nombre AS nombre_tercero, t3.direccion AS direccion_tercero, t5.descripcion AS des_area_analisis, 
t6.nombre AS nombre_producto, t7.descripcion AS FormaFarmaceutica, t8.descripcion AS Empaque, t9.descripcion AS Envase, 
t12.numero AS lote,t15.nombre AS nombreAnalista, t16.nombre as PerfilAnalista
FROM sgm_muestra t1 JOIN sgm_terceros t3 ON t1.id_tercero = t3.id JOIN sgm_areas_analisis t5 ON t1.id_area_analisis = t5.id 
JOIN sgm_producto t6 ON t1.id_producto = t6.id JOIN sgm_forma_farmaceutica t7 ON t6.id_formula_farma = t7.id 
JOIN sgm_empaque t8 ON t1.id_empaque = t8.id JOIN sgm_envase t9 ON t1.id_envase = t9.id JOIN sgm_lote t12 ON t12.id_muestra = t1.id 
JOIN sgm_ensayo_muestra t13 ON t1.id = t13.id_muestra JOIN sgm_programacion_analistas t14 ON t13.id = t14.id_ensayo_muestra 
JOIN sgm_usuario t15 ON t14.id_analista = t15.id JOIN sgm_perfil t16 ON t15.id_perfil = t16.id 
WHERE t1.id = $idInforme group by t1.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerResultadoMuestra($idInforme) {

        $query = "SELECT t1.aprobado,t1.id_ensayo,t1.descripcion_especifica as descripcion,t1.especificacion, t4.descripcion as metodo,t5.resultado, 
 tm.id_producto
FROM sgm_ensayo_muestra t1 
JOIN sgm_muestra tm ON t1.id_muestra = tm.id 
JOIN sgm_metodo t4 ON t1.id_metodo = t4.id 
JOIN sgm_ensayo enyo ON t1.id_ensayo = enyo.id 
LEFT JOIN sgm_resultados t5 ON t1.id  = t5.id_ensayo_muestra AND t1.id_ensayo = t1.id_ensayo 
LEFT JOIN sgm_resultado_medios_cultivo t6 ON t6.id_resultado = t5.id
LEFT JOIN sgm_estandar t61 ON t61.id = t6.id_estandar
LEFT JOIN sgm_resultado_cepas t7 ON t7.id_resultado = t5.id
LEFT JOIN sgm_reactivo t71 ON t71.id = t7.id_reactivo
WHERE t1.id_muestra = $idInforme and (t1.RFE = 0 OR isnull(t1.RFE)) and t1.validacion = 1 group by t1.id_ensayo ORDER BY enyo.orden";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerPlantasHojaCalculo($idInicial, $idFinal) {
        $query = "SELECT t1.custom_id,t1.prefijo,t2.id_ensayo, t2.especificacion, t3.*, t4.numero as lote, t5.nombre as producto
FROM sgm_muestra t1  JOIN sgm_ensayo_muestra t2 ON t2.id_muestra = t1.id 
JOIN sgm_muestra_detalle_mic t3 ON t3.id_muestra = t1.id
JOIN sgm_lote t4 ON t4.id_muestra = t1.id JOIN sgm_producto t5 ON t5.id = t1.id_producto
WHERE t1.id between $idInicial and $idFinal group by t1.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerInformesResultadosPlantas($idInicial, $idFinal) {
        $query = "SELECT t1.custom_id,t1.prefijo,t2.id_ensayo, t2.especificacion, t3.*, t4.numero as lote, t5.nombre as producto, t6.resultado
FROM sgm_muestra t1  JOIN sgm_ensayo_muestra t2 ON t2.id_muestra = t1.id 
JOIN sgm_muestra_detalle_mic t3 ON t3.id_muestra = t1.id JOIN sgm_lote t4 ON t4.id_muestra = t1.id JOIN sgm_producto t5 ON t5.id = t1.id_producto
JOIN sgm_resultados t6 ON t6.id_lote = t4.id AND t6.id_ensayo_muestra = t2.id
WHERE t1.id between $idInicial and $idFinal group by t1.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerResultadoMuestraCepas($idInicial, $idFinal) {

        $query = "SELECT  group_concat( DISTINCT (CONCAT(t71.nombre, ' Lote: ', t71.lote))) AS cepas
FROM sgm_ensayo_muestra t1 
JOIN sgm_muestra tm ON t1.id_muestra = tm.id 
JOIN sgm_producto_paquete t2 ON t1.id_paquete = t2.id_ensayo and tm.id_producto = t2.id_producto 
JOIN sgm_producto_ensayo t3 ON t2.id = t3.id_producto_paquete 
JOIN sgm_metodo t4 ON t3.id_metodo = t4.id 
JOIN sgm_resultados t5 ON t1.id  = t5.id_ensayo_muestra AND t1.id_ensayo = t3.id_ensayo 
LEFT JOIN sgm_resultado_medios_cultivo t6 ON t6.id_resultado = t5.id
LEFT JOIN sgm_estandar t61 ON t61.id = t6.id_estandar
LEFT JOIN sgm_resultado_cepas t7 ON t7.id_resultado = t5.id
LEFT JOIN sgm_reactivo t71 ON t71.id = t7.id_reactivo
WHERE t1.id_muestra = $idInforme and t1.validacion = 1";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerResultadoMuestraCepasPlanta($idInicial, $idFinal) {
        $query = "SELECT  group_concat( DISTINCT (CONCAT(t71.nombre, ' Lote: ', t71.lote))) AS cepas, group_concat( DISTINCT (CONCAT(t61.nombre, ' Lote: ', t61.lote))) AS medios
FROM sgm_ensayo_muestra t1 
JOIN sgm_lote lot ON lot lot.id_muestra = t1.id_muestra
JOIN sgm_resultados t5 ON t1.id  = t5.id_ensayo_muestra AND t5.id_lote = lot.id
LEFT JOIN sgm_resultado_medios_cultivo t6 ON t6.id_resultado = t5.id
LEFT JOIN sgm_estandar t61 ON t61.id = t6.id_estandar
LEFT JOIN sgm_resultado_cepas t7 ON t7.id_resultado = t5.id
LEFT JOIN sgm_reactivo t71 ON t71.id = t7.id_reactivo
WHERE t1.id_muestra between $idInicial and $idFinal group by t1.id_muestra";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Fin Reportes de Muestras//////
    /////Estabilidades//////////
    function VerCondicionesEstab($idInforme) {

        $query = "SELECT group_concat( DISTINCT (t2.tiempo)) AS condiciones  FROM sgm_ensayo_muestra t1 
                    JOIN sgm_est_tiempo_muestra_ensayo t2 ON t1.id = t2.id_ensayo_muestra and t2.is_check = 1
JOIN sgm_sub_muestra_est t3 ON t2.id_sub_muestra = t3.id
WHERE t1.id_muestra = $idInforme and validacion = 1";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

//        function VerResultadoMuestraEst($idInforme){
//        
//        $query = "SELECT t1.aprobado,t3.id_ensayo,t3.descripcion,t3.especificacion, t4.descripcion as metodo,t5.resultado, t2.id as idproductopaquete, t2.id_producto FROM sgm_ensayo_muestra t1 JOIN sgm_muestra tm ON t1.id_muestra = tm.id JOIN sgm_producto_paquete t2 ON t1.id_paquete = t2.id_ensayo and tm.id_producto = t2.id_producto JOIN sgm_producto_ensayo t3 ON t2.id = t3.id_producto_paquete JOIN sgm_metodo t4 ON t3.id_metodo = t4.id JOIN sgm_resultados t5 ON t1.id  = t5.id_ensayo_muestra AND t1.id_ensayo = t3.id_ensayo  WHERE t1.id_muestra = $idInforme and t1.validacion = 1 group by t3.id_ensayo";
//        
//        $query = $this->dbClass->getConexion()->prepare($query);
//        if($query->execute()){
//            $data = $query->fetchAll();
//        } else {
//            $data = false;
//        }
//        return $data;
//    }
    function VerResultadoMuestraEst($idInforme, $TiempoEst) {

        $query = "SELECT t1.*, t0.resultado,t2.descripcion as metodo  FROM sgm_ensayo_muestra_referencias t1 
                LEFT JOIN sgm_resultados t0 ON t1.id = t0.id_ensayo_muestra
                JOIN sgm_metodo t2 ON t1.id_metodo = t2.id
                WHERE t1.id_muestra = $idInforme and validacion = 1 and t1.tiempotemp = '$TiempoEst'";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    //Fin Estabilidades
    ///////Hojas de Trabajo//////////////
    function getInfoPrincipalHRMicro($idInforme) {
        $query = "SELECT CONCAT(t1.prefijo, '-', t1.custom_id) AS idPref,  SUBSTRING(t1.fecha_llegada,1,10) AS fecha, t3.descripcion as area,
group_concat(DISTINCT (case t5.id_ensayo 
			   when 1 then 'AM' 
                           when 2 then 'HyL' 
			   when 5 then 'CT' 
			   when 6 then 'Ec' 
			   when 7 then 'BTB' 
			   when 8 then 'Sa' 
			   when 9 then 'Sal'
			   when 10 then 'Pse'
			   when 11 then 'Clos'
			   when 13 then 'Efectividad de Preservantes Bacterias' 
			   when 14 then 'Eficacia Antimicrobiana' 
			   when 15 then 'Endotoxinas' 
			   when 16 then 'Validación de Endotoxinas' 
			   when 17 then 'Potencia de Antibióticos' 
			   when 18 then 'Promoción de Crecimiento'
			   when 19 then 'Esterilidad'
			   when 20 then 'Aspecto'
			    when 25 then 'Control de Áreas' 
			   when 26 then 'Cand'
			   when 36 then 'Bac'
			  when 38 then 'Valoración Ampicilina'
			  when 42 then 'Coliformes Fecales' 
			  when 44 then 'NMP Coliformes Totales' 
			   when 45 then 'NMP Coliformes Fecales' 
			   when 46 then 'Esporas Sulfito Reductoras'
		      end)) AS ensayos
FROM sgm_muestra t1 JOIN sgm_muestra_detalle_mic t2 ON t1.id = t2.id_muestra
JOIN sgm_area_microbiologica t3 ON t2.area_microbiologica = t3.id
JOIN sgm_ensayo_muestra t5 ON t1.id = t5.id_muestra
JOIN sgm_ensayo t4 ON t5.id_ensayo = t4.id 
WHERE t5.validacion = 1 AND t1.id = $idInforme";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoPrincipalHR($idInforme) {
        $query = "SELECT `t1`.`id` AS `id`,`t1`.`id_producto` AS `idProducto`,`t1`.`fecha_llegada` AS `fecha_llegada` , `t5`.`descripcion` AS `des_area_analisis`, `t6`.`nombre` AS `nombre_producto`, `t20`.`fecha_analisis` AS `fecha_analisis` ,`t7`.`descripcion` AS `FormaFarmaceutica`,`t12`.`numero` AS `lote` FROM `sgm_muestra` `t1`  
        JOIN `sgm_areas_analisis` `t5` ON `t1`.`id_area_analisis` = `t5`.`id` 
        JOIN `sgm_ensayo_muestra` `t20` ON `t20`.`id_muestra` = `t1`.`id`
        JOIN `sgm_producto` `t6` ON `t1`.`id_producto` = `t6`.`id` 
        JOIN `sgm_forma_farmaceutica` `t7` ON `t6`.`id_formula_farma` = `t7`.`id` 
        JOIN `sgm_lote` `t12` ON `t12`.`id_muestra` = `t1`.`id` WHERE t1.id = $idInforme";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getCondicionesHR($idProducto) {
        $query = "SELECT * FROM tbl_condiciones WHERE t1.id = $idProducto";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getDescripcionHR($idInforme) {
        $query = "SELECT IFNULL(t1.especificacion, t2.especificacion) AS DESCRIPCION 
                FROM sgm_ensayo_muestra t1 , sgm_ensayo_muestra_referencias t2
                WHERE t1.id_muestra = " . $idInforme . " and t2.id_muestra = " . $idInforme . " and t1.validacion = 1 and t2.validacion = 1 
                and (t1.id_ensayo = 1 or t1.id_ensayo = 64) and (t2.id_ensayo = 1 or t2.id_ensayo = 64)";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getMetodosHR($idInforme) {
        $query = "SELECT group_concat( DISTINCT (t2.descripcion)) AS metodos, group_concat( DISTINCT (t3.codigo)) AS codigo FROM sgm_ensayo_muestra t1 
        JOIN sgm_metodo t2 ON t1.id_metodo = t2.id
        JOIN sgm_ensayo t3 ON t1.id_paquete = t3.id
        WHERE t1.id_muestra = $idInforme and t1.validacion = 1";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayosARealizarHR($idInforme) {
        $query = "select group_concat( DISTINCT (t4.descripcion_especifica)) AS ensayosarealizar, 
t4.especificacion from sgm_ensayo_muestra t4  
WHERE t4.id_muestra = $idInforme and t4.validacion = 1";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayosEspecificosHR($idInforme) {
        $query = "SELECT group_concat( DISTINCT (t2.descripcion)) AS metodos FROM sgm_ensayo_muestra t1 JOIN sgm_metodo t2 ON t1.id_metodo = t2.id WHERE t1.id_muestra = $idInforme and t1.validacion = 1";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerHojadeRuta($idInforme) {
        $query = "select t1.*,t2.id_producto,t3.id as id_producto_paquete, t22.id_formula_farma,t1.descripcion_especifica as desEspecifica,t5.descripcion as des_metodo,
t7.descripcion as descripcionEnsayo,t7.id_plantilla,t8.descripcion as descripcionPaquete, t10.descripcion as des_ensayo_est,
 t11.descripcion as nom_estado_ensayo, if(isnull(t12.cant_resultados),0,t12.cant_resultados) as cant_resultados 
 from sgm_ensayo_muestra t1 
 join sgm_muestra t2 on t1.id_muestra = t2.id 
 join sgm_producto t22 on t2.id_producto = t22.id 
 join sgm_producto_paquete t3 on t1.id_paquete = t3.id_ensayo and t2.id_producto = t3.id_producto 
 join sgm_metodo t5 on t1.id_metodo = t5.id 
 join sgm_ensayo t7 on t1.id_ensayo = t7.id  
 join sgm_ensayo t8 on t1.id_paquete = t8.id 
 join sgm_estado_ensayo_muestra t11 on t1.estado_ensayo = t11.id left 
 join (select id_ensayo_muestra,count(id) as cant_resultados 
 from sgm_resultados group by id_ensayo_muestra) t12 on t1.id = t12.id_ensayo_muestra 
 LEFT JOIN sgm_est_tiempo_muestra_ensayo t10 on t1.id = t10.id_ensayo_muestra 
 where t1.validacion=1  and id_muestra = $idInforme group by t1.id ORDER BY t7.orden";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    //////Fin Hojas de Trabajo///////////
    ///////////Hojas e trabajo Est/////////////
    function getInfoPrincipalHREst($idInforme) {
        $query = "SELECT `t1`.`id` AS `id`,`t1`.`fecha_llegada` AS `fecha_llegada` , `t5`.`descripcion` AS `des_area_analisis`, `t6`.`nombre` AS `nombre_producto`, `t7`.`descripcion` AS `FormaFarmaceutica`,`t12`.`numero` AS `lote` FROM `sgm_muestra` `t1`  JOIN `sgm_areas_analisis` `t5` ON `t1`.`id_area_analisis` = `t5`.`id` JOIN `sgm_producto` `t6` ON `t1`.`id_producto` = `t6`.`id` JOIN `sgm_forma_farmaceutica` `t7` ON `t6`.`id_formula_farma` = `t7`.`id` JOIN `sgm_lote` `t12` ON `t12`.`id_muestra` = `t1`.`id` WHERE t1.id = $idInforme";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    /////////Fin Hojas de trabajo Est///////////
    ////Inicio Reportes de Cotizaciones//////
    function getInfoCotizacion($idCotizacion) {

        $query = "SELECT  t1.*,t2.nombre as nombre_cliente, t3.estado as des_estado, t4.nombre AS Ciudad FROM sgm_cotizacion t1 join  sgm_terceros t2 on t1.cliente = t2.id join sgm_estado_cotizacion t3 on t1.estado = t3.id join sgm_ciudad t4 on t2.id_ciudad = t4.id WHERE t1.id = $idCotizacion";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoProdCotizacion($idCotizacion) {

        $query = "SELECT  `t1`.`id` AS `id`,
        `t1`.`estado` AS `id_estado_cotizacion`,
        `t1`.`fecha_solicitud` AS `fsolicitud`,
        `t1`.`fecha_compromiso` AS `fcompromiso`,
        `t1`.`cliente` AS `id_cliente`,
        `t1`.`nombre_contacto` AS `nombre_contacto`,
        `t1`.`tel_contacto` AS `telefono_contacto`,
        `t1`.`observaciones` AS `obs`,
		t2.nombre as nombre_cliente, 
		t3.estado as des_estado 
FROM sgm_cotizacion t1
join  sgm_terceros t2 on t1.cliente = t2.id
join sgm_estado_cotizacion t3 on t1.estado = t3.id
WHERE t1.id = $idCotizacion";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerEnsayosCotizacion($idCotizacion) {
        $query = "SELECT cotPro.*, cpe.*, pro.nombre as nombre_producto, eny.descripcion as nombre_paquete, enyo.descripcion as nombre_ensayo, area.descripcion as nombre_area_analisis, t4.descripcion as metodo FROM sgm_cotizacion_producto cotPro join sgm_cot_pro_ensayo cpe on cpe.id_cot_pro = cotPro.id  join sgm_producto pro on pro.id = cotPro.id_producto  join sgm_ensayo eny on eny.id = cpe.id_paquete join sgm_ensayo enyo on enyo.id = cpe.id_ensayo join sgm_areas_analisis area on area.id = cpe.id_area_analisis join sgm_producto_ensayo t3 on cotPro.id_producto = t3.id_producto and cpe.id_ensayo = t3.id_ensayo join sgm_metodo t4 on t3.id_metodo = t4.id where seleccion = 1 AND id_cotizacion = $idCotizacion";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function valor_cotizado($idCotizacion) {
        $query = "
SELECT  `t1`.`id` AS `id`,
        `t1`.`id_cotizacion` AS `id_cotizacion`,
        `t2`.`seleccion` AS `fsolicitud`,
        `t2`.`valor` AS `valor`,
        `t2`.`id_paquete` AS `paquete`,
        `t3`.`descripcion` AS `Ensayo`,
        `t3`.`es_paquete` AS `Paquete`,
        `t4`.`descripcion` AS `areaanalsis`,
        `t5`.`descripcion` AS `nombrepaquete`,
        `t6`.`nombre` AS `producto`,SUM(`t2`.`valor`) AS `suma_valor` FROM sgm_cotizacion_producto t1 join sgm_cot_pro_ensayo t2 on t1.id = t2.id_cot_pro join sgm_ensayo t3 on t2.id_ensayo = t3.id join sgm_areas_analisis t4 on t2.id_area_analisis = t4.id join sgm_ensayo t5 on t2.id_paquete = t5.id join sgm_producto t6 on t1.id_producto = t6.id WHERE t1.id_cotizacion = $idCotizacion AND t2.seleccion = 1 Order by t6.nombre";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Fin Reportes de Cotizacion//////
    ////Inicio Reportes de Cotizaciones Estabilidad//////
    function getInfoCotizacionEst($idCotizacion) {

        $query = "SELECT  t1.*,t2.nombre as nombre_cliente, t3.estado as des_estado, t4.nombre as producto, tes.tipo_estabilidad as estabilidadNom
                  FROM sgm_est_cotizacion t1 
				  join  sgm_terceros t2 on t1.id_tercero = t2.id 
                  join sgm_estado_cotizacion t3 on t1.estado = t3.id 
				  join sgm_producto t4 on t1.id_producto = t4.id
				  join sgm_est_tipo_estabilidad tes on t1.tipo_estabilidad = tes.id
                  WHERE t1.id = $idCotizacion";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function VerEnsayosCotizacionEst($idCotizacion) {
        $query = "SELECT  cot.tipo_estabilidad,  cpe.nom_ensayo,cpe.valor as valorUnit, sum(cpe.valor) as valorTo, enyo.descripcion as ensayo, mtd.id_metodo as idMetodo,me.descripcion as metodoNom,
			   IF(cot.tipo_estabilidad=1,
               (group_concat(case tie.tiempo 
			   when '0t0' then 'Mes0_T30°-65%' 
                            when '1t0' then 'Mes3_T30°-65%' 
                           when '2t0' then 'Mes6_T30°-65%' 
			   when '3t0' then 'Mes9_T30°-65%' 
			   when '4t0' then 'Mes12_T30°-65%' 
			   when '5t0' then 'Mes18_T30°-65%' 
			   when '6t0' then 'Mes24_T30°-65%' 
			   when '7t0' then 'Mes36_T30°-65%' 
			   when '0t1' then 'Mes0_T30°-75%' 
               when '1t1' then 'Mes3_T30°-75%' 
			   when '2t1' then 'Mes6_T30°-75%' 
			   when '3t1' then 'Mes9_T30°-75%' 
			   when '4t1' then 'Mes12_T30°-75%' 
			   when '5t1' then 'Mes18_T30°-75%' 
			   when '6t1' then 'Mes24_T30°-75%' 
			   when '7t1' then 'Mes36_T30°-75%'
			   when '0t2' then 'Mes0_T40°-75%' 
               when '1t2' then 'Mes3_T40°-75%' 
			   when '2t2' then 'Mes6_T40°-75%' 
			   when '3t2' then 'Mes9_T40°-75%' 
			   when '4t2' then 'Mes12_T40°-75%' 
			   when '5t2' then 'Mes18_T40°-75%' 
			   when '6t2' then 'Mes24_T40°-75%' 
			   when '7t2' then 'Mes36_T40°-75%'
			   when '0t3' then 'Mes0_T50°-75%' 
               when '1t3' then 'Mes3_T50°-75%' 
			   when '2t3' then 'Mes6_T50°-75%' 
			   when '3t3' then 'Mes9_T50°-75%' 
			   when '4t3' then 'Mes12_T50°-75%' 
			   when '5t3' then 'Mes18_T50°-75%' 
			   when '6t3' then 'Mes24_T50°-75%' 
			   when '7t3' then 'Mes36_T50°-75%' 
			   end ORDER BY tie.tiempo SEPARATOR ' , ')),IF(cot.tipo_estabilidad=2,
			   (group_concat(case tie.tiempo 
			   when '0t0' then 'Mes0_T30°-65%' 
               when '1t0' then 'Mes1 Mes 30°-65%' 
               when '2t0' then 'Mes2_T30°-65%' 
			   when '3t0' then 'Mes3_T30°-65%' 
			   when '4t0' then 'Mes6_T30°-65%' 
			   when '0t1' then 'Mes0_T30°-75%' 
               when '1t1' then 'Mes1_T30°-75%' 
			   when '2t1' then 'Mes2_T30°-75%' 
			   when '3t1' then 'Mes3_T30°-75%' 
			   when '4t1' then 'Mes6_T30°-75%' 
			   when '0t2' then 'Mes0_T40°-75%' 
               when '1t2' then 'Mes1_T40°-75%' 
			   when '2t2' then 'Mes2_T40°-75%' 
			   when '3t2' then 'Mes3_T40°-75%' 
			   when '4t2' then 'Mes6_T40°-75%' 
			   when '0t3' then 'Mes0_T50°-75%' 
               when '1t3' then 'Mes1_T50°-75%' 
			   when '2t3' then 'Mes2_T50°-75%' 
			   when '3t3' then 'Mes3_T50°-75%' 
			   when '4t3' then 'Mes6_T50°-75%' 
			   end  ORDER BY tie.tiempo SEPARATOR ' , ')),IF(cot.tipo_estabilidad=3,
			   (group_concat(case tie.tiempo 
               when '0t0' then 'Mes0_T30°-65%' 
               when '1t0' then 'Mes1_T30°-65%' 
               when '2t0' then 'Mes2_T30°-65%' 
			   when '3t0' then 'Mes3_T30°-65%' 
			   when '4t0' then 'Mes6_T30°-65%' 
			   when '5t0' then 'Mes9_T30°-65%' 
			   when '6t0' then 'Mes12_T30°-65%' 
			   when '7t0' then 'Mes18_T30°-65%' 
			   when '8t0' then 'Mes24_T30°-65%' 
			   when '9t0' then 'Mes36_T30°-65%' 
			   when '0t1' then 'Mes0_T30°-75%' 
               when '1t1' then 'Mes1_T30°-75%' 
			   when '2t1' then 'Mes2_T30°-75%' 
			   when '3t1' then 'Mes3_T30°-75%' 
			   when '4t1' then 'Mes6_T30°-75%' 
			   when '5t1' then 'Mes9_T30°-75%' 
			   when '6t1' then 'Mes12_T30°-75%' 
			   when '7t1' then 'Mes18_T30°-75%'
			   when '8t1' then 'Mes24_T30°-75%' 
			   when '9t1' then 'Mes36_T30°-75%'
			   when '0t2' then 'Mes0_T40°-75%' 
               when '1t2' then 'Mes1_T40°-75%' 
			   when '2t2' then 'Mes2_T40°-75%' 
			   when '3t2' then 'Mes3_T40°-75%' 
			   when '4t2' then 'Mes6_T40°-75%' 
			   when '5t2' then 'Mes9_T40°-75%' 
			   when '6t2' then 'Mes12_T40°-75%' 
			   when '7t2' then 'Mes18_T40°-75%'
			   when '8t2' then 'Mes24_T40°-75%' 
			   when '9t2' then 'Mes36_T40°-75%'
			   when '0t3' then 'Mes0_T50°-75%' 
               when '1t3' then 'Mes1_T50°-75%' 
			   when '2t3' then 'Mes2_T50°-75%' 
			   when '3t3' then 'Mes3_T50°-75%' 
			   when '4t3' then 'Mes6_T50°-75%' 
			   when '5t3' then 'Mes9_T50°-75%' 
			   when '6t3' then 'Mes12_T50°-75%' 
			   when '7t3' then 'Mes18_T50°-75%' 
			   when '8t3' then 'Mes24_T50°-75%' 
			   when '9t3' then 'Mes36_T50°-75%' 
			   end  ORDER BY tie.tiempo SEPARATOR ' , ')),'Otro'))) as tiempos
		FROM sgm_est_cotizacion cot 
		join sgm_est_cot_ens cpe ON cot.id = cpe.id_cotizacion
		join sgm_ensayo enyo on enyo.id = cpe.id_ensayo 
        join sgm_est_tiempo_cot_ens tie on cpe.id = tie.id_est_cot_ens and tie.is_check = 1
		join sgm_producto_paquete pqt on cot.id_producto = pqt.id_producto AND cpe.id_paquete = pqt.id_ensayo
		join sgm_producto_ensayo mtd on pqt.id = mtd.id_producto_paquete AND cot.id_producto = mtd.id_producto AND cpe.id_ensayo = mtd.id_ensayo
        join sgm_metodo me ON mtd.id_metodo = me.id
		where id_cotizacion = $idCotizacion group by enyo.descripcion";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function valor_cotizadoEst($idCotizacion) {
        $query = "SELECT  sum(cpe.valor) as suma_valor FROM sgm_est_cotizacion cot 
		join sgm_est_cot_ens cpe ON cot.id = cpe.id_cotizacion
		join sgm_ensayo enyo on enyo.id = cpe.id_ensayo 
                join sgm_est_tiempo_cot_ens tie on cpe.id = tie.id_est_cot_ens and tie.is_check = 1
		where id_cotizacion = $idCotizacion";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Fin Reportes de Cotizacion Estabilidades//////
    ///Ver nombre del analista///////////
    function verNombreUsuario($idAnalista) {
        $query = "SELECT nombre FROM sgm_usuario WHERE id = $idAnalista";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Inicio Reporte Disponibilidad de Usuario//////
    function getDisponibilidadUsuario($idAnalista, $inicio, $fin) {
        $query = "SELECT fecha_programada as fecha,t1.id as idProgramacion,t1.fecha_programada,t1.duracion_programada,t2.id_muestra,t2.id_ensayo,t3.descripcion as desEnsayo,t2.id_paquete,t4.descripcion as desPaquete,
t2.fecha_programacion,t2.fecha_compromiso_interno,t2.duracion,t2.equipo as idEquipo,t5.descripcion as desEquipo,t6.id_area_analisis as idAreaAnalisis,t7.descripcion as desAreaAnalisis,
t6.tipo_estabilidad,t1.programado_por as idProgramador,t8.nombre as nomProgramador,t1.id_ensayo_muestra  FROM sgm_programacion_analistas t1 join sgm_ensayo_muestra t2 on t1.id_ensayo_muestra = t2.id
join sgm_ensayo t3 on t2.id_ensayo = t3.id join sgm_ensayo t4 on t2.id_paquete = t4.id join sgm_equipo t5 on t2.equipo = t5.id join sgm_muestra t6 on t2.id_muestra = t6.id
join sgm_areas_analisis t7 on t6.id_area_analisis = t7.id join sgm_usuario t8 on t1.programado_por = t8.id where id_analista = $idAnalista and 
 fecha_programada >= '$inicio' and fecha_programada <= '$fin' group by fecha_programada";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Fin Reporte Disponibilidad de Usuario//////
    ////Inicio Reporte Lista de Precios//////
    function getListadePrecios() {
        $query = "SELECT * FROM sgm_ensayo where es_paquete = 0 and activo=1 order by descripcion ASC";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Fin Reporte Lista de Precios//////
    ////Inicio stikers//////
    function getIdInicio($idInicio) {
        $this->cargarSystemParameters();
        $util = new UtilsController();
        $id = $util->getRealIdMuestra($idInicio);
        return $id;
    }

    function getIdFin($idFin) {
        $this->cargarSystemParameters();
        $util = new UtilsController();
        $id = $util->getRealIdMuestra($idFin);

        return $id;
    }

    ////Inicio stikers//////
    function getSikers($idInicio, $idFin) {
        $query = "SELECT t1.id AS id, t1.fecha_llegada AS fecha, "
                . "t1.prefijo as prefijo ,t1.custom_id AS identificaCliente , "
                . "t2.nombre AS cliente, t3.nombre AS producto, t4.descripcion AS area, "
                . "t5.numero AS lote,t6.descripcion AS FormaFarmaceutica, "
                . "t7.descripcion_especifica  as ensayos "
                . "FROM sgm_muestra t1 "
                . "JOIN sgm_terceros t2 ON t1.id_tercero = t2.id "
                . "JOIN sgm_producto t3 ON t1.id_producto = t3.id "
                . "JOIN sgm_areas_analisis t4 ON t1.id_area_analisis = t4.id "
                . "JOIN sgm_lote t5 ON t1.id = t5.id_muestra "
                . "JOIN sgm_forma_farmaceutica t6 ON t3.id_formula_farma = t6.id "
                . "JOIN sgm_ensayo_muestra t7 ON t7.id_muestra = t1.id "
                . "WHERE t1.id BETWEEN $idInicio AND $idFin AND t7.validacion=1 ";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getSikersLQF($idInicio, $idFin) {
        $query = "SELECT t1.id AS id, t1.fecha_llegada AS fecha,t2.nombre AS cliente, t3.nombre AS producto, t4.descripcion AS area, t5.numero AS lote,t6.descripcion AS FormaFarmaceutica FROM sgm_muestra t1 JOIN sgm_terceros t2 ON t1.id_tercero = t2.id JOIN sgm_producto t3 ON t1.id_producto = t3.id JOIN sgm_areas_analisis t4 ON t1.id_area_analisis = t4.id JOIN sgm_lote t5 ON t1.id = t5.id_muestra JOIN sgm_forma_farmaceutica t6 ON t3.id_formula_farma = t6.id WHERE t1.id BETWEEN $idInicio AND $idFin  group by t1.id order by t1.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getSikersMicro($idInicio, $idFin) {
        $query = "SELECT CONCAT(t1.prefijo, '-', t1.custom_id) AS idPref,  SUBSTRING(t1.fecha_llegada,1,10) AS fecha, t3.descripcion as area,
group_concat(DISTINCT (case t5.id_ensayo 
			   when 1 then 'AM' 
               when 2 then 'HyL' 
			   when 5 then 'CT' 
			   when 6 then 'Ec' 
			   when 7 then 'BTB' 
			   when 8 then 'Sa' 
			   when 9 then 'Sal'
			   when 10 then 'Pse'
			   when 11 then 'Clos'
			   when 13 then 'Efectividad de Preservantes Bacterias' 
			   when 14 then 'Eficacia Antimicrobiana' 
			   when 15 then 'Endotoxinas' 
			   when 16 then 'Validación de Endotoxinas' 
			   when 17 then 'Potencia de Antibióticos' 
			   when 18 then 'Promoción de Crecimiento'
			   when 19 then 'Esterilidad'
			   when 20 then 'Aspecto'
			    when 25 then 'Control de Áreas' 
			   when 26 then 'Cand'
			   when 36 then 'Bac'
			  when 38 then 'Valoración Ampicilina'
			  when 42 then 'Coliformes Fecales' 
			  when 44 then 'NMP Coliformes Totales' 
			   when 45 then 'NMP Coliformes Fecales' 
			   when 46 then 'Esporas Sulfito Reductoras'
		      end)) AS ensayos
FROM sgm_muestra t1 JOIN sgm_muestra_detalle_mic t2 ON t1.id = t2.id_muestra
JOIN sgm_area_microbiologica t3 ON t2.area_microbiologica = t3.id
JOIN sgm_ensayo_muestra t5 ON t1.id = t5.id_muestra
JOIN sgm_ensayo t4 ON t5.id_ensayo = t4.id 
WHERE t5.validacion = 1 AND t1.id BETWEEN $idInicio AND $idFin  group by t1.id order by t1.id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    ////Fin Stikers//////
    ////Inicio Estados de Muestra//////
    function getEstadosdeMuestra($ini, $fin) {
        $query = "select * from sgm_muestras_referencias WHERE fecha_llegada BETWEEN '$ini' AND '$fin' AND id_estado_muestra !=11 order by id";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoReactivosInforme() {
        $SQL = "SELECT tb1.*, tb2.numero,tb2.fecha_vencimiento,tb2.fecha_apertura,tb2.fecha_recibido, tb2.cantidad,tb2.unidad, tb2.id as id_lote_reactivo "
                . "FROM sgm_reactivo tb1 "
                . "join sgm_lote_reactivo tb2 on tb2.id_reactivo=tb1.id "
                . "where tb1.activo = 1 and (tb2.activo = 1 or isnull(tb2.fecha_apertura)) "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoReactivosVencidos($fecha) {
        $SQL = "SELECT tb1.*, tb2.numero,tb2.fecha_vencimiento,tb2.fecha_apertura,tb2.fecha_recibido, tb2.cantidad,tb2.unidad, tb2.id as id_lote_reactivo "
                . "FROM sgm_reactivo tb1 "
                . "join sgm_lote_reactivo tb2 on tb2.id_reactivo=tb1.id "
                . "where tb1.activo = 1 and tb2.fecha_vencimiento < ? and tb2.activo = 0 "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoReactivosFinalizados() {
        $SQL = "SELECT tb1.*, tb2.numero,tb2.fecha_vencimiento,tb2.fecha_apertura,tb2.fecha_recibido, tb2.cantidad,tb2.unidad, tb2.id as id_lote_reactivo "
                . "FROM sgm_reactivo tb1 "
                . "join sgm_lote_reactivo tb2 on tb2.id_reactivo=tb1.id "
                . "where tb1.activo = 1 and tb2.cantidad_final = 0 and tb2.activo = 0 "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoReactivosSinUsar() {
        $SQL = "SELECT tb1.*, tb2.numero,tb2.fecha_vencimiento,tb2.fecha_apertura,tb2.fecha_recibido, tb2.cantidad,tb2.unidad, tb2.id as id_lote_reactivo "
                . "FROM sgm_reactivo tb1 "
                . "join sgm_lote_reactivo tb2 on tb2.id_reactivo=tb1.id "
                . "where tb2.cantidad = tb2.cantidad_final and tb2.activo = 0 "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoEstandares($tipo) {
        $SQL = "SELECT tb1.* , tb2.stock as consecutivo, tb2.codigo as lote, tb2.descripcion as pureza, "
                . "tb2.fecha_vencimiento, tb2.observaciones, tb2.id as idLote, tb2.cantidad_final, tb2.fecha_apertura  "
                . "from sgm_estandar tb1 "
                . "join sgm_lote_estandar tb2 on tb2.id_estandar = tb1.id "
                . "where tb1.activo = 1 and (tb2.activo = 1 or isnull(tb2.fecha_apertura)) "
                . (($tipo !== '' && $tipo !== NULL) ? "and tb1.tipo like '%" . $tipo . "%' " : "")
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoEstandaresVencidos($fecha) {
        $SQL = "SELECT tb1.* , tb2.stock as consecutivo, tb2.codigo as lote, tb2.descripcion as pureza, "
                . "tb2.fecha_vencimiento, tb2.observaciones, tb2.id as idLote, tb2.cantidad_final, tb2.fecha_apertura "
                . "from sgm_estandar tb1 "
                . "join sgm_lote_estandar tb2 on tb2.id_estandar = tb1.id "
                . "where tb1.activo = 1 and tb2.fecha_vencimiento < ? and tb2.activo = 0 "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fecha);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoEstandaresFinalizados() {
        $SQL = "SELECT tb1.* , tb2.stock as consecutivo, tb2.codigo as lote, tb2.descripcion as pureza, "
                . "tb2.fecha_vencimiento, tb2.observaciones, tb2.id as idLote, tb2.cantidad_final, tb2.fecha_apertura "
                . "from sgm_estandar tb1 "
                . "join sgm_lote_estandar tb2 on tb2.id_estandar = tb1.id "
                . "where tb1.activo = 1 and tb2.cantidad_final = 0 and tb2.activo = 0 "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoEstandaresSinUsar() {
        $SQL = "SELECT tb1.* , tb2.stock as consecutivo, tb2.codigo as lote, tb2.descripcion as pureza, "
                . "tb2.fecha_vencimiento, tb2.observaciones, tb2.id as idLote, tb2.cantidad_final, tb2.fecha_apertura "
                . "from sgm_estandar tb1 "
                . "join sgm_lote_estandar tb2 on tb2.id_estandar = tb1.id "
                . "where tb1.activo = 1 and tb2.cantidad_final = tb2.cantidad and tb2.activo = 0 "
                . "order by tb1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoConsumoMuestra($idMuestra) {
        $SQL = "select tbl4.nombre as producto, tbl3.numero as lote, tbl2.nombre as cliente "
                . "from sgm_muestra tbl1 "
                . "join sgm_terceros tbl2 on tbl2.id = tbl1.id_tercero "
                . "join sgm_lote tbl3 on tbl3.id_muestra = tbl1.id "
                . "join sgm_producto tbl4 on tbl4.id = tbl1.id_producto "
                . "where tbl1.id = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getInfoEventoMuestra($idMuestra) {
        $SQL = "SELECT t1.id, DATE_FORMAT(t1.fecha,'%Y-%m-%d') as fecha, t2.nombre, t1.evento, t1.razon "
                . "FROM sgm_muestra_aud t1 "
                . "JOIN sgm_usuario t2 ON t1.id_usuario = t2.id "
                . "WHERE t1.id_muestra = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getJsonNewMuestraAud($idMuestra) {

        $SQL = "SELECT new FROM sgm_muestra_aud where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return json_decode($result[0]["new"]);
        } else {
            $error = $query->errorInfo();
        }
    }

    function getJsonOldMuestraAud($idMuestra) {

        $SQL = "SELECT old FROM sgm_muestra_aud where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return json_decode($result[0]["old"]);
        } else {
            $error = $query->errorInfo();
        }
    }

    function getInfoHistoricoMuestra($idMuestra) {
        $SQL = "select tbl3.*, tbl4.nombre as usuario "
                . "from sgm_muestra tbl1 "
                . "join sgm_historico_estado_muestra tbl3 on tbl3.id_muestra = tbl1.id "
                . "join sgm_usuario tbl4 on tbl4.id = tbl3.id_usuario "
                . "where tbl1.id = ? and tbl3.id_estado in(1,2,12,14,15,17) "
                . "order by tbl3.id_estado asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getEnsayoMuestraTiempo($idMuestra) {
        $SQL = "select tbl2.id, tbl2.descripcion_especifica, tbl2.tiempo "
                . "from sgm_muestra tbl1 "
                . "join sgm_ensayo_muestra tbl2 on tbl2.id_muestra = tbl1.id "
                . "where tbl1.id = ? and tbl2.validacion = 1 "
                . "order by tbl2.descripcion_especifica asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = false;
        }
        return $data;
    }

    function getCondicionesEnsayo($idEnsayo) {
        $SQL = "select tbl2.descripcion_especifica, tbl2.tiempo, 
group_concat(DISTINCT(CONCAT(tbl4.descripcion)) SEPARATOR ', ') as equipos,
group_concat(DISTINCT(CONCAT(tbl6.nombre)) SEPARATOR ', ') as reactivos,
group_concat(DISTINCT(CONCAT(tbl8.nombre)) SEPARATOR ', ') as estandares,
group_concat(DISTINCT(CONCAT(tbl10.serial, ' ',tbl10.marca)) SEPARATOR ', ') as columna
from sgm_ensayo_muestra tbl2 
left join sgm_ensayo_equipo tbl3 on tbl3.id_ensayo = tbl2.id_ensayo
left join sgm_equipo tbl4 on tbl4.id = tbl3.id_equipo
left join sgm_ensayo_muestra_reactivo_lote tbl5 on tbl5.id_ensayo_muestra = tbl2.id
left join sgm_reactivo tbl6 on tbl6.id = tbl5.id_reactivo
left join sgm_ensayo_muestra_estandar_lote tbl7 on tbl7.id_ensayo_muestra = tbl2.id
left join sgm_estandar tbl8 on tbl8.id = tbl7.id_estandar
left join sgm_ensayo_muestra_condicion_cromatografica tbl9 on tbl9.id_ensayo_muestra = tbl2.id
left join sgm_columna tbl10 on tbl10.id = tbl9.id_columna
where tbl2.id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = false;
        }
        return $data;
    }

    function getStickerReactivo($idLote) {
        $query = "select * "
                . "from sgm_lote_reactivo tb1 "
                . "join sgm_reactivo tb2 on tb2.id = tb1.id_reactivo "
                . "where tb1.id = $idLote;";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getUltimaActualizacionReactivos() {
        $SQL = "select MAX(t1.fecha) as fecha_actualizacion from sgm_reactivo_aud t1 ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getUltimaActualizacionEstandares() {
        $SQL = "select MAX(t1.fecha) as fecha_actualizacion from sgm_estandar_aud t1 ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    function getInfoEquiposInforme() {
        $SQL = "SELECT tb1.*, group_concat(DISTINCT (tb3.descripcion) separator ', ') as ensayos "
                . "FROM sgm_equipo tb1 "
                . "LEFT JOIN sgm_ensayo_equipo tb2 on tb2.id_equipo = tb1.id "
                . "LEFT JOIN sgm_ensayo tb3 on tb3.id = tb2.id_ensayo "
                . "where tb1.activo = 1 "
                . "group by tb1.id "
                . "order by tb1.cod_inventario asc ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }
    
    function getInfoColumnasInforme() {
        $SQL = "SELECT * FROM sgm_columna where activo = 1 ORDER BY id DESC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
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
    
    function infoGeneralFirmas($idMuestra) {

        $SQL = "SELECT t2.nombre AS aprobado, t1.fecha_conclusion, t3.nombre AS cargo 
            FROM sgm_muestra t1
JOIN sgm_usuario t2 ON t1.usuario_conclusion = t2.id 
JOIN sgm_cargo t3 ON t2.id_cargo = t3.id 
WHERE t1.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

    ////Fin Estados de Muestra//////
    /////Inicio /////////////////
    ////Fin Reportes de Muestras//////
}
