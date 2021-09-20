<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaMuestraDbModelClass
 *
 * @author lvelasquez
 */
class TablaMuestraDbModelClass
{

    //put your code here

    private $dbClass;

    public function __construct()
    {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getRealIdMuestra($prefijo, $customId)
    {

        $SQL = "SELECT id FROM sgm_muestra WHERE prefijo = ? AND custom_id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $prefijo);
        $query->bindParam(2, $customId);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $query = $this->dbClass->getConexion()->errorInfo();
            $data = false;
        }
        return $data;
    }

    function anularMuestra($idMuestra)
    {
        $SQL = "UPDATE sgm_muestra SET activa = 0 WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }

        return data;
    }

    function anularMuestra2($idMuestra, $motivoAnulacion, $usuario)
    {
        $SQL = "UPDATE sgm_muestra SET activa = 0, observacion = concat(IFNULL(concat(observacion,'\n'), ''),?), "
            . "id_estado_muestra=11, usuario_conclusion = ?, "
            . "fecha_conclusion = ? "
            . "WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $motivoAnulacion);
        $query->bindParam(2, $usuario);
        $hoy = new DateTime();
        $query->bindParam(3, $hoy->format('Y-m-d'));
        $query->bindParam(4, $idMuestra);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $idMuestra
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

    function insertMuestra($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $FechaLlegada, $FechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $fechaInicio)
    {

        $query = "INSERT sgm_muestra
(
`id_estado_muestra`,
`activa`,
`prioridad`,
`id_cotizacion`,
`numero_remision`,
`fecha_llegada`,
`fecha_compromiso`,
`id_tercero`,
`id_contacto`,
`area_contacto`,
`fabricante`,
`procedencia`,
`num_informe`,
`observacion`,
`id_area_analisis`,
`tipo_estabilidad`,
`id_corinador`,
`duracion`,
`id_producto`,
`id_empaque`,
`id_envase`,
`fecha_fabricacion`,
`fecha_vencimiento`,
`cantidad_lotes`,
`es_facturable`,
`cantidad`,
`num_factura`,
`anticipo`,
`descuento`,
`saldo`,
`fecha_inicio`)
VALUES
(?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?,
?
);
 ";
        $query = $this->dbClass->getConexion()->prepare($query);
        $query->bindParam(1, $idEstadoMuestra);
        $query->bindParam(2, $activa);
        $query->bindParam(3, $prioridad);
        $query->bindParam(4, $idCotizacion);
        $query->bindParam(5, $numeroRemision);
        $query->bindParam(6, $FechaLlegada);
        $query->bindParam(7, $FechaCompromiso);
        $query->bindParam(8, $idTercero);
        $query->bindParam(9, $idContacto);
        $query->bindParam(10, $areaContacto);
        $query->bindParam(11, $labFabricante);
        $query->bindParam(12, $procedencia);
        $query->bindParam(13, $numInforme);
        $query->bindParam(14, $observacion);
        $query->bindParam(15, $idAreaAnalisis);
        $query->bindParam(16, $tipoEstabilidad);
        $query->bindParam(17, $idCoordinador);
        $query->bindParam(18, $duracion);
        $query->bindParam(19, $idProducto);
        $query->bindParam(20, $idEmpaque);
        $query->bindParam(21, $idEnvase);
        $query->bindParam(22, $fechaFabricacion);
        $query->bindParam(23, $fechaVencimiento);
        $query->bindParam(24, $cantidadLotes);
        $query->bindParam(25, $esFacturable);
        $query->bindParam(26, $cantidad);
        $query->bindParam(27, $numFacturas);
        $query->bindParam(28, $anticipo);
        $query->bindParam(29, $descuento);
        $query->bindParam(30, $saldo);
        $query->bindParam(31, $fechaInicio);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            return false;
        }
    }

    function updateMuestra2($activa, $prioridad, $idCotizacion, $numeroRemision, $fechaLlegada, $fechaCompromiso, $idTercero, $idContacto, $areaContacto, $fabricante, $procedencia, $observacion, $idAreaAnalisis, $tipoEstabilidad, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $identificadorCliente, $condicionesGenerales, $idMuestra)
    {
        $SQL = "UPDATE sgm_muestra SET activa = ?,prioridad = ?,id_cotizacion = ?,numero_remision = ?,fecha_llegada = ?,fecha_compromiso = ?,id_tercero = ?,id_contacto = ?,area_contacto = ?,fabricante = ?,procedencia = ?,observacion = ?,id_area_analisis = ?,tipo_estabilidad = ?,duracion = ?,id_producto = ?,id_empaque = ?,id_envase = ?,fecha_fabricacion = ?,fecha_vencimiento = ?, identificador_cliente = ?, condiciones_generales = ? WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $activa);
        $query->bindParam(2, $prioridad);
        $query->bindParam(3, $idCotizacion);
        $query->bindParam(4, $numeroRemision);
        $query->bindParam(5, $fechaLlegada);
        $query->bindParam(6, $fechaCompromiso);
        $query->bindParam(7, $idTercero);
        $query->bindParam(8, $idContacto);
        $query->bindParam(9, $areaContacto);
        $query->bindParam(10, $fabricante);
        $query->bindParam(11, $procedencia);
        $query->bindParam(12, $observacion);
        $query->bindParam(13, $idAreaAnalisis);
        $query->bindParam(14, $tipoEstabilidad);
        $query->bindParam(15, $duracion);
        $query->bindParam(16, $idProducto);
        $query->bindParam(17, $idEmpaque);
        $query->bindParam(18, $idEnvase);
        $query->bindParam(19, $fechaFabricacion);
        $query->bindParam(20, $fechaVencimiento);
        $query->bindParam(21, $identificadorCliente);
        $query->bindParam(22, $condicionesGenerales);
        $query->bindParam(23, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "update muestra success",
                "data" => "OK"
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en update tabla sgm_muestra", "data" => $error
            );
        }
        return $response;
    }

    function insertMuestra2($idEstadoMuestra, $activa, $prioridad, $idCotizacion, $numeroRemision, $fechaLlegada, $fechaCompromiso, $idTercero, $idContacto, $areaContacto, $labFabricante, $procedencia, $numInforme, $observacion, $idAreaAnalisis, $tipoEstabilidad, $idCoordinador, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $cantidadLotes, $esFacturable, $cantidad, $numFacturas, $anticipo, $descuento, $saldo, $fechaInicio, $prefijo, $identificadorCiente, $condicionesGenerales)
    {

        $prefijoCons = substr($prefijo, 0, intval($_SESSION["systemsParameters"]["prefixMuestraLengthConsecutivo"])) . "%";
        $SQL = "SELECT IFNULL((SELECT max(sgm_muestra.custom_id) + 1 from sgm_muestra where prefijo like ?), 1);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $prefijoCons);
        if ($query->execute()) {
            $data = $query->fetchAll();
            $customId = $data[0][0];

            $SQL2 = "INSERT sgm_muestra(`id_estado_muestra`,`activa`,`prioridad`,`id_cotizacion`,`numero_remision`,`fecha_llegada`,`fecha_compromiso`,`id_tercero`,`id_contacto`,`area_contacto`,`fabricante`,`procedencia`,`num_informe`,`observacion`,`id_area_analisis`,`tipo_estabilidad`,`id_corinador`,`duracion`,`id_producto`,`id_empaque`,`id_envase`,`fecha_fabricacion`,`fecha_vencimiento`,`cantidad_lotes`,`es_facturable`,`cantidad`,`anticipo`,`descuento`,`saldo`,`fecha_inicio`,`prefijo`,`custom_id`, `identificador_cliente`, `condiciones_generales`)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
            $query = $this->dbClass->getConexion()->prepare($SQL2);
            $query->bindParam(1, $idEstadoMuestra);
            $query->bindParam(2, $activa);
            $query->bindParam(3, $prioridad);
            $query->bindParam(4, $idCotizacion);
            $query->bindParam(5, $numeroRemision);
            $query->bindParam(6, $fechaLlegada);
            $query->bindParam(7, $fechaCompromiso);
            $query->bindParam(8, $idTercero);
            $query->bindParam(9, $idContacto);
            $query->bindParam(10, $areaContacto);
            $query->bindParam(11, $labFabricante);
            $query->bindParam(12, $procedencia);
            $query->bindParam(13, $numInforme);
            $query->bindParam(14, $observacion);
            $query->bindParam(15, $idAreaAnalisis);
            $query->bindParam(16, $tipoEstabilidad);
            $query->bindParam(17, $idCoordinador);
            $query->bindParam(18, $duracion);
            $query->bindParam(19, $idProducto);
            $query->bindParam(20, $idEmpaque);
            $query->bindParam(21, $idEnvase);
            $query->bindParam(22, $fechaFabricacion);
            $query->bindParam(23, $fechaVencimiento);
            $query->bindParam(24, $cantidadLotes);
            $query->bindParam(25, $esFacturable);
            $query->bindParam(26, $cantidad);
            $query->bindParam(27, $anticipo);
            $query->bindParam(28, $descuento);
            $query->bindParam(29, $saldo);
            $query->bindParam(30, $fechaInicio);
            $query->bindParam(31, $prefijo);
            $query->bindParam(32, $customId);
            $query->bindParam(33, $identificadorCiente);
            $query->bindParam(34, $condicionesGenerales);

            if ($query->execute()) {
                $response = array(
                    "code" => "0",
                    "message" => "Insert muestra success",
                    "data" => array(
                        "idMuestra" => $this->dbClass->getConexion()->lastInsertId(),
                        "prefijo" => $prefijo,
                        "customIdMuestra" => $customId
                    )
                );
            } else {
                $error = $query->errorInfo();
                $response = array(
                    "code" => "RM-ITB-00001", "message" => "error en insert de la tabla sgm_muestra", "data" => $error
                );
            }
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "RM-ITB-00002", "message" => "error al obtener el customId", "data" => $error
            );
        }
        return $response;
    }

    function getMuestraReferenciasById($idMuestra)
    {
        $SQL = "select t1.*, t2.descripcion as estado from sgm_muestras_referencias t1 
                JOIN sgm_estado t2 ON t1.id_estado_muestra = t2.id
                where t1.id = ? ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getMuestraReferenciasDetalleById($idMuestra)
    {
        $SQL = "select * from sgm_muestras_referencias where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $data = false;
        }
        return $data;
    }

    function updateFaturacionMuestra($idMuestra, $cantidad, $numFactura, $anticipo, $descuento, $saldo)
    {
        $SQL = "UPDATE sgm_muestra SET es_facturable = 1,cantidad = ?,num_factura = ?,anticipo = ?,descuento = ?,saldo = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $cantidad);
        $query->bindParam(2, $numFactura);
        $query->bindParam(3, $anticipo);
        $query->bindParam(4, $descuento);
        $query->bindParam(5, $saldo);
        $query->bindParam(6, $idMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function updateMuestra($idMuestra, $activa, $prioirdad, $cotizacion, $remision, $fechaLlegada, $fechaCompromiso, $idTercero, $idContacto, $areaContacto, $laboratorio, $procedencia, $numeroInfo, $observaciones, $areaAnalisis, $tipoEstabilidad, $coordArea, $duracion, $idProducto, $idEmpaque, $idEnvase, $fechaFabricacion, $fechaVencimiento, $esfacturable, $numFactura, $descuento, $cantidad, $anticipo, $saldo)
    {
        $SQL = "update sgm_muestra set activa = ? ,
            prioridad = ?,
            id_cotizacion = ?,
            numero_remision = ?,
            fecha_llegada = ?,
            fecha_compromiso = ?,
            id_tercero = ?,
            id_contacto = ?,
            area_contacto = ?,
            fabricante = ?,
            procedencia = ?,
            num_informe = ?,
            observacion = ?,
            id_area_analisis = ?,
            tipo_estabilidad = ?,
            id_corinador = ?,
            duracion = ?,
            id_producto = ?,
            id_empaque = ?,
            id_envase = ?,
            fecha_fabricacion = ?,
            fecha_vencimiento = ?,
            es_facturable = ?,
            num_factura = ?,
            descuento = ?,
            cantidad = ?,
            anticipo = ?,
            saldo = ?
            where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $activa);
        $query->bindParam(2, $prioirdad);
        $query->bindParam(3, $cotizacion);
        $query->bindParam(4, $remision);
        $query->bindParam(5, $fechaLlegada);
        $query->bindParam(6, $fechaCompromiso);
        $query->bindParam(7, $idTercero);
        $query->bindParam(8, $idContacto);
        $query->bindParam(9, $areaContacto);
        $query->bindParam(10, $laboratorio);
        $query->bindParam(11, $procedencia);
        $query->bindParam(12, $numeroInfo);
        $query->bindParam(13, $observaciones);
        $query->bindParam(14, $areaAnalisis);
        $query->bindParam(15, $tipoEstabilidad);
        $query->bindParam(16, $coordArea);
        $query->bindParam(17, $duracion);
        $query->bindParam(18, $idProducto);
        $query->bindParam(19, $idEmpaque);
        $query->bindParam(20, $idEnvase);
        $query->bindParam(21, $fechaFabricacion);
        $query->bindParam(22, $fechaVencimiento);
        $query->bindParam(23, $esfacturable);
        $query->bindParam(24, $numFactura);
        $query->bindParam(25, $descuento);
        $query->bindParam(26, $cantidad);
        $query->bindParam(27, $anticipo);
        $query->bindParam(28, $saldo);
        $query->bindParam(29, $idMuestra);


        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function updateEstadoByIdMuestra($idMuestra, $idEstado)
    {
        $SQL = "update sgm_muestra set id_estado_muestra = ? WHERE  id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEstado);
        $query->bindParam(2, $idMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    public function updateFechaConclusionByIdMuestra($idMuestra, $fechaConclusion)
    {
        $SQL = "update sgm_muestra set fecha_conclusion = ? WHERE  id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaConclusion);
        $query->bindParam(2, $idMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    public function updateConclusionByIdMuestra($idMuestra, $conclusion)
    {
        $SQL = "UPDATE sgm_muestra SET conclusion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $conclusion);
        $query->bindParam(2, $idMuestra);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    public function verificarMuestra($idMuestra, $conclusion, $fechaConclusion, $usuarioConclusion, $observacion)
    {
        $SQL = "UPDATE sgm_muestra SET conclusion = ?, fecha_conclusion = ?, usuario_conclusion = ?, observacion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $conclusion);
        $query->bindParam(2, $fechaConclusion);
        $query->bindParam(3, $usuarioConclusion);
        $query->bindParam(4, $observacion);
        $query->bindParam(5, $idMuestra);
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

    function getMuestrasParaVerificar()
    {
        $SQL = "SELECT t2m.prefijo, t2m.custom_id, t2m.id, t2m.id_tercero,t7.nombre, "
            . "t8.descripcion as des_area, t2m.tipo_estabilidad, "
            . "test.tipo_estabilidad as nombre_estabilidad,t13.numero as numero_lote, "
            . "sum(case when estado_ensayo = 3 then 1 else 0 end) as aprobados, "
            . "sum(case when estado_ensayo = 2 then 1 else 0 end) as rechazados,t2m.id_producto, "
            . "t5.nombre as nom_producto, t2m.fecha_compromiso "
            . "FROM sgm_muestra t2m "
            . "join sgm_ensayo_muestra t2 on t2.id_muestra = t2m.id "
            . "join sgm_est_tipo_estabilidad test on test.id= t2m.tipo_estabilidad "
            . "join sgm_terceros t7 on t2m.id_tercero = t7.id "
            . "join sgm_areas_analisis t8 on t2m.id_area_analisis = t8.id "
            . "JOIN sgm_lote t13 ON t2m.id = t13.id_muestra "
            . "join sgm_producto t5 on t2m.id_producto = t5.id "
            . "where t2m.activa = 1 and t2m.id_estado_muestra=16 and !isnull( t2m.fecha_pre_conclusion) "
            . "and !ISNULL(t2m.usuario_pre_conclusion) "
            . "group by t2m.id order by t2m.fecha_llegada desc;";
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

    function getMuestrasVerificadas()
    {
        $SQL = "SELECT t2m.prefijo, t2m.custom_id, t2m.id,t2m.id_tercero,t7.nombre, "
            . "t8.descripcion as des_area, t2m.tipo_estabilidad, "
            . "test.tipo_estabilidad as nombre_estabilidad,t13.numero as numero_lote, "
            . "sum(case when estado_ensayo = 3 then 1 else 0 end) as aprobados, "
            . "sum(case when estado_ensayo = 2 then 1 else 0 end) as rechazados,t2m.id_producto, "
            . "t5.nombre as nom_producto "
            . "FROM sgm_muestra t2m "
            . "join sgm_ensayo_muestra t2 on t2.id_muestra = t2m.id "
            . "join sgm_est_tipo_estabilidad test on test.id= t2m.tipo_estabilidad "
            . "join sgm_terceros t7 on t2m.id_tercero = t7.id "
            . "join sgm_areas_analisis t8 on t2m.id_area_analisis = t8.id "
            . "JOIN sgm_lote t13 ON t2m.id = t13.id_muestra "
            . "join sgm_producto t5 on t2m.id_producto = t5.id "
            . "where t2m.activa = 1 and t2m.id_estado_muestra=17 "
            . "group by t2m.id  "
            . "order by t2m.fecha_llegada desc";
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

    public function revisarMuestra($idMuestra, $conclusion, $fechaPreConclusion, $usuarioPreConclusion, $observacion)
    {
        $SQL = "UPDATE sgm_muestra SET conclusion = ?, fecha_pre_conclusion = ?, usuario_pre_conclusion = ?, observacion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $conclusion);
        $query->bindParam(2, $fechaPreConclusion);
        $query->bindParam(3, $usuarioPreConclusion);
        $query->bindParam(4, $observacion);
        $query->bindParam(5, $idMuestra);
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

    function getMuestrasSalida($numDias)
    {
        $SQL = "SELECT tb2.id as id_almacenamiento, tb1.prefijo, tb1.custom_id, tb2.fecha_salida, tb3.numero, tb4.nombre as tercero,tb5.nombre as producto "
            . "FROM sgm_muestra tb1 "
            . "JOIN sgm_almacenamiento tb2 ON tb1.id = tb2.id_muestra "
            . "JOIN sgm_lote tb3 ON tb1.id = tb3.id_muestra "
            . "JOIN sgm_terceros tb4 ON tb1.id_tercero = tb4.id "
            . "JOIN sgm_producto tb5 ON tb1.id_producto = tb5.id "
            . "WHERE ((tb2.fecha_salida between NOW() AND NOW() + INTERVAL " . $numDias . " DAY) "
            . "OR tb2.fecha_salida < NOW()) "
            . "AND ISNULL(tb2.estado_salida);";
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

    function getMuestrasToConsultaMuetras($cantidad, $pagina, $prefijo, $customId, $producto, $tercero, $lote, $estadoMuestra, $fechaLlegada, $fechaCompromiso, $observacion, $contacto, $numFatura, $fechaEntrega)
    {


        $pagina = $pagina - 1;
        $prefijo = "%" . $prefijo . "%";
        $customId = "%" . $customId . "%";
        $producto = "%" . $producto . "%";
        $tercero = "%" . $tercero . "%";
        $lote = "%" . $lote . "%";
        $estadoMuestra = "%" . $estadoMuestra . "%";
        $fechaLlegada = "%" . $fechaLlegada . "%";
        $fechaCompromiso = "%" . $fechaCompromiso . "%";
        $observacion = "%" . $observacion . "%";
        $contacto = "%" . $contacto . "%";
        $numFatura = "%" . $numFatura . "%";
        $fechaEntrega = "%" . $fechaEntrega . "%";


        $registroInicial = $pagina * $cantidad;

        $SQL = "SELECT 
            t1.id,
            t1.prefijo,
            t1.custom_id,
            t2.nombre as producto,
            t3.nombre as tercero,
            t4.numero as lote,
            t5.descripcion as estado_muestra,
            t1.id_estado_muestra,
            DATE_FORMAT(t1.fecha_llegada,'%Y-%m-%d') as fecha_llegada,
            DATE_FORMAT(t1.fecha_compromiso,'%Y-%m-%d') as fecha_compromiso,
            t1.observacion,
            t6.nombre as contacto,
            t1.num_factura,
            t1.fecha_entrega
            
            FROM sgm_muestra t1 
            JOIN sgm_producto t2 ON t1.id_producto = t2.id 
            JOIN sgm_terceros t3 ON t1.id_tercero = t3.id 
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra 
            JOIN sgm_estado t5 ON t1.id_estado_muestra = t5.id 
            JOIN sgm_contacto t6 ON t1.id_contacto = t6.id 

            WHERE 
            t1.prefijo like ? and 
            t1.custom_id like ? and 
            t2.nombre like ? and 
            t3.nombre like ? and  
            t4.numero like ? and  
            t5.descripcion like ? and 
            t1.fecha_llegada like ? and 
            t1.fecha_compromiso like ? and  
            ifnull(t1.observacion,'') like ? and  
            t6.nombre like ? and  
            ifnull(t1.num_factura,'')  like ? and
            ifnull(t1.fecha_entrega,'')  like ? 

            order by t1.id desc 
            
            limit $registroInicial, $cantidad ;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $prefijo);
        $query->bindParam(2, $customId);
        $query->bindParam(3, $producto);
        $query->bindParam(4, $tercero);
        $query->bindParam(5, $lote);
        $query->bindParam(6, $estadoMuestra);
        $query->bindParam(7, $fechaLlegada);
        $query->bindParam(8, $fechaCompromiso);
        $query->bindParam(9, $observacion);
        $query->bindParam(10, $contacto);
        $query->bindParam(11, $numFatura);
        $query->bindParam(12, $fechaEntrega);

        if ($query->execute()) {

            $muestras = $query->fetchAll(PDO::FETCH_ASSOC);

            $SQL2 = "SELECT 
            count(t1.id) as cantidad_total
            
            FROM sgm_muestra t1 
            JOIN sgm_producto t2 ON t1.id_producto = t2.id 
            JOIN sgm_terceros t3 ON t1.id_tercero = t3.id 
            JOIN sgm_lote t4 ON t1.id = t4.id_muestra 
            JOIN sgm_estado t5 ON t1.id_estado_muestra = t5.id 
            JOIN sgm_contacto t6 ON t1.id_contacto = t6.id 

            WHERE 
            t1.prefijo like ? and 
            t1.custom_id like ? and 
            t2.nombre like ? and 
            t3.nombre like ? and  
            t4.numero like ? and  
            t5.descripcion like ? and 
            t1.fecha_llegada like ? and 
            t1.fecha_compromiso like ? and  
            ifnull(t1.observacion,'') like ? and  
            t6.nombre like ? and  
            ifnull(t1.num_factura,'')  like ? and
            ifnull(t1.fecha_entrega,'')  like ?;";

            $query2 = $this->dbClass->getConexion()->prepare($SQL2);
            $query2->bindParam(1, $prefijo);
            $query2->bindParam(2, $customId);
            $query2->bindParam(3, $producto);
            $query2->bindParam(4, $tercero);
            $query2->bindParam(5, $lote);
            $query2->bindParam(6, $estadoMuestra);
            $query2->bindParam(7, $fechaLlegada);
            $query2->bindParam(8, $fechaCompromiso);
            $query2->bindParam(9, $observacion);
            $query2->bindParam(10, $contacto);
            $query2->bindParam(11, $numFatura);
            $query2->bindParam(12, $fechaEntrega);


            if ($query2->execute()) {


                return array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => array(
                        "muestras" => $muestras,
                        "cantidad_total" => $query2->fetch(PDO::FETCH_OBJ)->cantidad_total
                    )
                );
            }
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

    function getDatosGraficaMuestrasPorTipoProdcuto($fechaInicial, $fechaFinal)
    {
        $SQL = "SELECT t3.descripcion as 'tipo_producto', count(t1.id) as 'cantidad', t3.id FROM sgm_muestra t1 JOIN sgm_producto t2 ON t1.id_producto = t2.id JOIN sgm_forma_farmaceutica t3 ON t2.id_formula_farma = t3.id where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? group by t3.descripcion UNION select 'estabilidad' as 'tipo_producto',count(t4.id), 0 from sgm_est_muestra t4 where t4.fecha_llegada >= ? and t4.fecha_llegada <= ? ";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicial);
        $query->bindParam(2, $fechaFinal);
        $query->bindParam(3, $fechaInicial);
        $query->bindParam(4, $fechaFinal);

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

    function actualizarNumeroFactura($muestra)
    {
        $SQL = "UPDATE sgm_muestra SET num_factura = ?, fecha_facturacion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $muestra['numfactura']);
        $query->bindParam(2, $muestra['fecha_facturacion_format']);
        $query->bindParam(3, $muestra['id']);
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

    function actualizarFechaEntrega($muestra)
    {
        $SQL = "UPDATE sgm_muestra SET fecha_entrega = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $fechaEntrega = new DateTime($muestra["fechaEntregaFormateada"]);
        $query->bindParam(1, $fechaEntrega->format('Y-m-d'));
        $query->bindParam(2, $muestra['id']);
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

    function getDatosGraficaParticipacionClientes($fechaInicial, $fechaFinal)
    {
        $SQL = "SELECT t2.nombre as 'cliente', count(t1.id) as 'cantidad', t2.id FROM sgm_muestra t1 JOIN sgm_terceros t2 ON t2.id = t1.id_tercero where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? group by t2.nombre";
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

    function getDetalleParticipacionCliente($fechaInicial, $fechaFinal, $idCliente)
    {
        $SQL = "SELECT t1.id as id_muestra,
                CONCAT(t1.prefijo,'-',t1.custom_id) as show_id_muestra,
                t3.nombre as producto
                FROM sgm_muestra t1 
                JOIN sgm_terceros t2 ON t2.id = t1.id_tercero 
                JOIN sgm_producto t3 ON t3.id = t1.id_producto
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

    function consultaAuditoriaMuestra($idMuestra)
    {
        $SQL = "SELECT t1.id, DATE_FORMAT(t1.fecha,'%Y-%m-%d') as fecha, t2.nombre, t1.evento, t1.razon "
            . "FROM sgm_muestra_aud t1 "
            . "JOIN sgm_usuario t2 ON t1.id_usuario = t2.id "
            . "WHERE t1.id_muestra = ?";
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

    function consultaAuditoriaMuestraDetallada($idMuestra)
    {
        $SQL = "SELECT t1.id_muestra AS id, DATE_FORMAT(t1.fecha,'%Y-%m-%d') as fecha, t2.nombre, t1.evento, t1.razon, t1.old, t1.new "
            . "FROM sgm_muestra_aud t1 "
            . "JOIN sgm_usuario t2 ON t1.id_usuario = t2.id "
            . "WHERE t1.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
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

    function getDatosGraficaDesempenoAnalistas($fechaInicial, $fechaFinal)
    {
        $SQL = "select id_analista, t3.nombre, count(id_muestra) as cantidad from (select DISTINCT * from (select t2.id_analista, t1.id_muestra from sgm_ensayo_muestra t1 JOIN sgm_programacion_analistas t2 ON t1.id = t2.id_ensayo_muestra where t1.fecha_programacion >= ? and t1.fecha_programacion <= ? GROUP BY t2.id_ensayo_muestra)sel1 ) sel2 JOIN sgm_usuario t3 ON sel2.id_analista = t3.id GROUP BY id_analista;";
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

    function getDatosGraficaDesempenoByIdAnalista($fechaInicial, $fechaFinal, $idAnalista)
    {
        $SQL = "SELECT t4.prefijo, t4.custom_id, t5.nombre as producto      
            FROM (select DISTINCT * from      
                    (select t2.id_analista, t1.id_muestra      
                    from sgm_ensayo_muestra t1      
                    JOIN sgm_programacion_analistas t2 ON t1.id = t2.id_ensayo_muestra      
                    where t1.fecha_programacion >= ? and t1.fecha_programacion <= ? AND t2.id_analista = ?     
                    GROUP BY t2.id_ensayo_muestra     
                    )sel1      
                ) sel2      
            JOIN sgm_muestra t4 ON t4.id = sel2.id_muestra     
            JOIN sgm_producto t5 ON t5.id = t4.id_producto;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicial);
        $query->bindParam(2, $fechaFinal);
        $query->bindParam(3, $idAnalista);

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

    function getResumenMuestras($cantidad, $pagina, $muestra, $producto, $analista, $ensayos, $estadoMuestra, $tercero)
    {


        $pagina = $pagina - 1;
        $muestra = "%" . $muestra . "%";
        $producto = "%" . $producto . "%";
        $analista = "%" . $analista . "%";
        $ensayos = "%" . $ensayos . "%";
        $estadoMuestra = "%" . $estadoMuestra . "%";
        $tercero = "%" . $tercero . "%";

        $registroInicial = $pagina * $cantidad;

        $SQL = "SELECT CONCAT(t1.prefijo,'-',t1.custom_id) AS muestra, 
            group_concat(DISTINCT(t3.descripcion_especifica) SEPARATOR ', ') as ensayos, 
            group_concat(DISTINCT(t5.nombre) SEPARATOR ', ') as analista, 
            t2.nombre AS producto, t6.nombre AS cliente, t7.descripcion AS estadoMuestra 
            
            FROM sgm_muestra t1 
            JOIN sgm_producto t2 ON t2.id = t1.id_producto 
            JOIN sgm_ensayo_muestra t3 ON t3.id_muestra = t1.id 
            LEFT JOIN sgm_programacion_analistas t4 ON t4.id_ensayo_muestra = t2.id 
            LEFT JOIN sgm_usuario t5 ON t5.id = t4.id_analista 
            JOIN sgm_terceros t6 ON t6.id = t1.id_tercero 
            JOIN sgm_estado t7 ON t7.id = t1.id_estado_muestra 

            WHERE 
            IFNULL(CONCAT(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND 
            IFNULL(t3.descripcion_especifica,'') LIKE ? AND 
            IFNULL(t5.nombre,'') LIKE ? AND 
            IFNULL(t2.nombre,'') LIKE ? AND 
            IFNULL(t6.nombre,'') LIKE ? AND 
            IFNULL(t7.descripcion,'') LIKE ? 
            GROUP BY t1.id 

            order by t1.id desc 
            
            limit $registroInicial, $cantidad ;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $muestra);
        $query->bindParam(2, $ensayos);
        $query->bindParam(3, $analista);
        $query->bindParam(4, $producto);
        $query->bindParam(5, $tercero);
        $query->bindParam(6, $estadoMuestra);

        if ($query->execute()) {

            $muestras = $query->fetchAll(PDO::FETCH_ASSOC);

            $SQL2 = "SELECT COUNT(t1.id) AS cantidad_total FROM (SELECT t1.id 
            FROM sgm_muestra t1 
            JOIN sgm_producto t2 ON t2.id = t1.id_producto 
            JOIN sgm_ensayo_muestra t3 ON t3.id_muestra = t1.id 
            LEFT JOIN sgm_programacion_analistas t4 ON t4.id_ensayo_muestra = t2.id 
            LEFT JOIN sgm_usuario t5 ON t5.id = t4.id_analista 
            JOIN sgm_terceros t6 ON t6.id = t1.id_tercero 
            JOIN sgm_estado t7 ON t7.id = t1.id_estado_muestra 

            WHERE 
            IFNULL(CONCAT(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND 
            IFNULL(t3.descripcion_especifica,'') LIKE ? AND 
            IFNULL(t5.nombre,'') LIKE ? AND 
            IFNULL(t2.nombre,'') LIKE ? AND 
            IFNULL(t6.nombre,'') LIKE ? AND 
            IFNULL(t7.descripcion,'') LIKE ? group by t1.id) t1";

            $query2 = $this->dbClass->getConexion()->prepare($SQL2);
            $query2->bindParam(1, $muestra);
            $query2->bindParam(2, $ensayos);
            $query2->bindParam(3, $analista);
            $query2->bindParam(4, $producto);
            $query2->bindParam(5, $tercero);
            $query2->bindParam(6, $estadoMuestra);


            if ($query2->execute()) {


                return array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => array(
                        "muestras" => $muestras,
                        "cantidad_total" => $query2->fetch(PDO::FETCH_OBJ)->cantidad_total
                    )
                );
            }
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

    function exportExcelResumenMuestras($muestra, $producto, $analista, $ensayos, $estadoMuestra, $cliente)
    {


        $muestra = "%" . $muestra . "%";
        $producto = "%" . $producto . "%";
        $analista = "%" . $analista . "%";
        $ensayos = "%" . $ensayos . "%";
        $estadoMuestra = "%" . $estadoMuestra . "%";
        $cliente = "%" . $cliente . "%";

        $SQL = "SELECT CONCAT(t1.prefijo,'-',t1.custom_id) AS muestra, 
            group_concat(DISTINCT(t3.descripcion_especifica) SEPARATOR ', ') AS ensayos, 
            group_concat(DISTINCT(t5.nombre) SEPARATOR ', ') as analista, 
            t2.nombre AS producto, t6.nombre AS cliente, t7.descripcion AS estadoMuestra, 
            DATE_FORMAT(t1.fecha_llegada,'%Y-%m-%d') AS fecha_llegada, 
            DATE_FORMAT(t3.fecha_programacion,'%Y-%m-%d') AS fecha_programacion, 
            DATE_FORMAT(t3.fecha_analisis,'%Y-%m-%d') AS fecha_analisis, 
            DATE_FORMAT(t1.fecha_compromiso,'%Y-%m-%d') AS fecha_compromiso, 
            t8.numero AS lote, t1.fabricante AS proveedor, 
            t1.procedencia AS propietario, t9.descripcion AS envase, t10.descripcion AS formaFarma, 
            DATE_FORMAT(t11.fecha,'%Y-%m-%d') AS fecha_almacenamiento, 
            DATE_FORMAT(t1.fecha_fabricacion,'%Y-%m-%d') AS fecha_fabricacion, 
            DATE_FORMAT(t1.fecha_vencimiento,'%Y-%m-%d') AS fecha_vencimiento, 
            DATE_FORMAT(t12.fecha_muestreo,'%Y-%m-%d') AS fecha_muestreo, 
            t13.nombre AS contacto, t1.num_factura, t14.observaciones, 
            DATE_FORMAT(t1.fecha_conclusion,'%Y-%m-%d') AS fecha_aprobacion 
            
            
            FROM sgm_muestra t1 
            JOIN sgm_producto t2 ON t2.id = t1.id_producto 
            JOIN sgm_ensayo_muestra t3 ON t3.id_muestra = t1.id 
            LEFT JOIN sgm_programacion_analistas t4 ON t4.id_ensayo_muestra = t2.id 
            LEFT JOIN sgm_usuario t5 ON t5.id = t4.id_analista 
            JOIN sgm_terceros t6 ON t6.id = t1.id_tercero 
            JOIN sgm_estado t7 ON t7.id = t1.id_estado_muestra 
            JOIN sgm_lote t8 ON t8.id_muestra = t1.id 
            LEFT JOIN sgm_empaque t9 ON t9.id = t1.id_envase 
            LEFT JOIN sgm_envase t10 ON t10.id = t1.id_empaque 
            LEFT JOIN sgm_almacenamiento t11 ON t11.id_muestra = t1.id 
            JOIN sgm_muestra_detalle_mic t12 ON t12.id_muestra = t1.id 
            JOIN sgm_contacto t13 ON t13.id = t1.id_contacto 
            JOIN sgm_historico_estado_muestra t14 ON t14.id_muestra = t1.id 

            WHERE 
            IFNULL(CONCAT(t1.prefijo, '-', t1.custom_id),'') LIKE ? AND 
            IFNULL(t3.descripcion_especifica,'') LIKE ? AND 
            IFNULL(t5.nombre,'') LIKE ? AND 
            IFNULL(t2.nombre,'') LIKE ? AND 
            IFNULL(t6.nombre,'') LIKE ? AND 
            IFNULL(t7.descripcion,'') LIKE ? 
            GROUP BY t1.id 

            order by t1.id desc;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $muestra);
        $query->bindParam(2, $ensayos);
        $query->bindParam(3, $analista);
        $query->bindParam(4, $producto);
        $query->bindParam(5, $cliente);
        $query->bindParam(6, $estadoMuestra);

        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

    function exportExcelUsoReactivosMuestra($idReactivos, $fechaInicio, $fechaFin)
    {
        $idReactivos = implode(',', $idReactivos);
        $SQL = "SELECT CONCAT(t1.prefijo, '-', t1.custom_id) AS muestra, 
                t5.nombre AS reactivo, t6.nombre AS producto, t4.descripcion AS ensayo 
                FROM sgm_muestra t1 
                JOIN sgm_ensayo_muestra t2 ON t2.id_muestra = t1.id 
                JOIN sgm_ensayo_muestra_reactivo_lote t3 ON t3.id_ensayo_muestra = t2.id 
                JOIN sgm_ensayo t4 ON t4.id = t2.id_ensayo 
                JOIN sgm_reactivo t5 ON t5.id = t3.id_reactivo 
                JOIN sgm_producto t6 ON t6.id = t1.id_producto 
                WHERE t1.fecha_llegada BETWEEN ? AND ? AND t3.id_reactivo in(?)";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicio);
        $query->bindParam(2, $fechaFin);
        $query->bindParam(3, $idReactivos);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return $result;
        } else {
            $error = $query->errorInfo();
        }
    }

    function consultarAnalistasProgramadosMuestra($idMuestra)
    {
        $SQL = "SELECT DATE_FORMAT(MIN(t2.fecha_programacion), '%Y-%m-%d') as fecha_programacion, t4.nombre FROM sgm_muestra t1
                JOIN sgm_ensayo_muestra t2 ON t2.id_muestra = t1.id
                JOIN sgm_programacion_analistas t3 ON t3.id_ensayo_muestra = t2.id
                JOIN sgm_usuario t4 ON t4.id = t3.id_analista
                WHERE t1.id=?
                GROUP BY t3.id_analista;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_OBJ);
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $result
            );
        } else {
            $error = $query->errorInfo();
            return array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => $error
            );
        }
    }

    function getDetalleEstadoMuestras($fechaInicial, $fechaFinal, $idEstado)
    {
        $SQL = "SELECT t1.id as id_muestra,
                CONCAT(t1.prefijo,'-',t1.custom_id) as show_id_muestra,
                t3.nombre as producto
                FROM sgm_muestra t1 
                JOIN sgm_estado t2 ON t2.id = t1.id_estado_muestra 
                JOIN sgm_producto t3 ON t3.id = t1.id_producto
                where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? AND t2.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicial);
        $query->bindParam(2, $fechaFinal);
        $query->bindParam(3, $idEstado);

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

    function getDetalleTipoProducto($fechaInicial, $fechaFinal, $idTipoProducto)
    {
        $SQL = "SELECT t1.id as id_muestra,
                CONCAT(t1.prefijo,'-',t1.custom_id) as show_id_muestra,
                t3.nombre as producto
                FROM sgm_muestra t1  
                JOIN sgm_producto t3 ON t3.id = t1.id_producto
                JOIN sgm_forma_farmaceutica t4 ON t4.id = t3.id_formula_farma
                where t1.fecha_llegada >= ? and t1.fecha_llegada <= ? AND t4.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaInicial);
        $query->bindParam(2, $fechaFinal);
        $query->bindParam(3, $idTipoProducto);

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

    function getDetalleTipoProductoEst($fechaInicial, $fechaFinal)
    {
        $SQL = "SELECT t1.id as id_muestra,
                CONCAT(t2.prefijo,'-',t1.custom_id) as show_id_muestra,
                t3.nombre as producto
                FROM sgm_est_muestra t1  
                JOIN sgm_tipo_muestra t2 ON t2.id = t1.id_tipo_muestra
                JOIN sgm_producto t3 ON t3.id = t1.id_producto
                where t1.fecha_llegada >= ? and t1.fecha_llegada <= ?";
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

}
