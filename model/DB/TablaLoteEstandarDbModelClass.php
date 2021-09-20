<?php

/**
 * Created by PhpStorm.
 * User: jchacon
 * Date: 13/03/2017
 */
class TablaLoteEstandarDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function insertNewLote($codigo, $descripcion, $cantidad, $fechaVencimiento
    , $activo, $tipo, $cantidadActual, $stock, $fechaIngreso
    , $fechaApertura, $fechaTerminacion, $loteInterno, $fechaPreparacion
    , $fechaPromocion, $idEstandar, $cantidadPreparada, $observaciones
    , $numCas, $humedad, $basePotencia, $cantInicial, $cantFinal) {
        $SQL = "INSERT INTO sgm_lote_estandar (codigo,descripcion,cantidad, "
                . "fecha_vencimiento,activo,tipo,cantidad_actual,stock,fecha_ingreso, "
                . "fecha_apertura,fecha_terminacion,lote_interno,fecha_preparacion, "
                . "fecha_promocion,id_estandar,cantidad_preparada,observaciones,"
                . "num_cas,humedad,base_potencia,cantidad_inicial,cantidad_final) "
                . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $fechaNula = null;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);
        $query->bindParam(3, $cantidad);


        if ($fechaVencimiento !== null && $fechaVencimiento !== '') {
            $explodeDate = explode("GMT", $fechaVencimiento);
            $query->bindParam(4, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(4, $fechaNula);
        }

        $query->bindParam(5, $activo);
        $query->bindParam(6, $tipo);
        $query->bindParam(7, $cantidadActual);
        $query->bindParam(8, $stock);

        if ($fechaIngreso !== null && $fechaIngreso !== '') {
            $explodeDate = explode("GMT", $fechaIngreso);
            $query->bindParam(9, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(9, $fechaNula);
        }

        if ($fechaApertura !== null && $fechaApertura !== '') {
            $explodeDate = explode("GMT", $fechaApertura);
            $query->bindParam(10, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(10, $fechaNula);
        }

        if ($fechaTerminacion !== null && $fechaTerminacion !== '') {
            $explodeDate = explode("GMT", $fechaTerminacion);
            $query->bindParam(11, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(11, $fechaNula);
        }

        $query->bindParam(12, $loteInterno);

        if ($fechaPreparacion !== null && $fechaPreparacion !== '') {
            $explodeDate = explode("GMT", $fechaPreparacion);
            $query->bindParam(13, date('Y-m-d', strtotime($explodeDate[0])));
        } else {

            $query->bindParam(13, $fechaNula);
        }

        if ($fechaPromocion !== null && $fechaPromocion !== '') {
            $explodeDate = explode("GMT", $fechaPromocion);
            $query->bindParam(14, date('Y-m-d', strtotime($explodeDate[0])));
        } else {

            $query->bindParam(14, $fechaNula);
        }

        $query->bindParam(15, $idEstandar);
        $query->bindParam(16, $cantidadPreparada);
        $query->bindParam(17, $observaciones);
        $query->bindParam(18, $numCas);
        $query->bindParam(19, $humedad);
        $query->bindParam(20, $basePotencia);
        $query->bindParam(21, $cantInicial);
        $query->bindParam(22, $cantFinal);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
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

    public function getLotesByIdEstandar($idEstandar) {
        $SQL = "SELECT * FROM sgm_lote_estandar WHERE id_estandar = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEstandar);
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

    public function deactivateLotesByIdEstandar($idEstandar) {
        $SQL = "UPDATE sgm_lote_estandar SET activo = 0 WHERE id_estandar = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEstandar);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
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

    public function updateLoteEstandar($codigo, $descripcion, $cantidad, $fecha_ingreso
    , $fecha_apertura, $fecha_terminacion, $fecha_vencimiento
    , $cantidad_actual, $stock, $lote_interno, $fecha_preparacion
    , $fecha_promocion, $idEstandar, $tipo, $cantidad_preparada, $observaciones
    , $numCas, $humedad, $basePotencia, $cantInicial, $cantFinal, $id) {
        $SQL = "UPDATE sgm_lote_estandar SET codigo = ?, descripcion = ?, "
                . "cantidad = ?, fecha_ingreso = ?, fecha_apertura = ?, "
                . "fecha_terminacion = ?, fecha_vencimiento = ?, "
                . "cantidad_actual = ?, stock = ?, lote_interno = ?, "
                . "fecha_preparacion = ?,fecha_promocion = ?, "
                . "tipo = ?,cantidad_preparada = ?, observaciones = ?,"
                . "num_cas = ?, humedad = ?, base_potencia = ?, cantidad_inicial = ?, "
                . "cantidad_final = ? "
                . "WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $campoNulo = null;
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $descripcion);

        if ($cantidad == '' || $cantidad == 'null') {
            $query->bindParam(3, $campoNulo);
        } else {
            $query->bindParam(3, $cantidad);
        }

        if ($fecha_ingreso !== null && $fecha_ingreso !== '') {
            $explodeDate = explode("GMT", $fecha_ingreso);
            $query->bindParam(4, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(4, $campoNulo);
        }

        if ($fecha_apertura !== null && $fecha_apertura !== '') {
            $explodeDate = explode("GMT", $fecha_apertura);
            $query->bindParam(5, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(5, $campoNulo);
        }

        if ($fecha_terminacion !== null && $fecha_terminacion !== '') {
            $explodeDate = explode("GMT", $fecha_terminacion);
            $query->bindParam(6, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(6, $campoNulo);
        }

        if ($fecha_vencimiento !== null && $fecha_vencimiento !== '') {
            $explodeDate = explode("GMT", $fecha_vencimiento);
            $query->bindParam(7, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(7, $campoNulo);
        }

        if ($cantidad_actual == '' || $cantidad_actual == 'null') {
            $query->bindParam(8, $campoNulo);
        } else {
            $query->bindParam(8, $cantidad_actual);
        }

        if ($stock == '' || $stock == 'null') {
            $query->bindParam(9, $campoNulo);
        } else {
            $query->bindParam(9, $stock);
        }

        $query->bindParam(10, $lote_interno);

        if ($fecha_preparacion !== null && $fecha_preparacion !== '') {
            $explodeDate = explode("GMT", $fecha_preparacion);
            $query->bindParam(11, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(11, $campoNulo);
        }

        if ($fecha_promocion !== null && $fecha_promocion !== '') {
            $explodeDate = explode("GMT", $fecha_promocion);
            $query->bindParam(12, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(12, $campoNulo);
        }

        $query->bindParam(13, $tipo);

        if ($cantidad_preparada == '' || $cantidad_preparada == 'null') {
            $query->bindParam(14, $campoNulo);
        } else {
            $query->bindParam(14, $cantidad_preparada);
        }

        $query->bindParam(15, $observaciones);
        $query->bindParam(16, $numCas);
        $query->bindParam(17, $humedad);
        $query->bindParam(18, $basePotencia);
        $cantInicial = $cantInicial !== "" && $cantInicial !== "null" ? $cantInicial : null;
        $cantFinal = $cantFinal !== "" && $cantFinal !== "null" ? $cantFinal : null;
        $query->bindParam(19, $cantInicial);
        $query->bindParam(20, $cantFinal);

        $query->bindParam(21, $id);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
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

    public function activateLoteById($idLote) {
        $SQL = "UPDATE sgm_lote_estandar SET activo = 1 WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idLote);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
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

    function obtenerLoteEstandarMuestraActivo($idEnsayoMuestra) {
        $SQL = "SELECT t2.nombre as nombre_estandar, t2.codigo as codigo_estandar, 
                t3.codigo as lote_estandar, t3.descripcion as pureza, DATE_FORMAT(t3.fecha_vencimiento,'%m-%Y') as fecha_vencimiento,
                t3.stock
                FROM sgm_ensayo_muestra_estandar_lote t1 
                JOIN sgm_estandar t2 ON t2.id = t1.id_estandar
                JOIN sgm_lote_estandar t3 ON t3.id=t1.id_lote
                WHERE t1.id_ensayo_muestra=?";
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

    //Trae los datos de un id especifico
    function getLoteEstandarById($idLoteEstandar) {
        $SQL = "SELECT * FROM sgm_lote_estandar WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idLoteEstandar);

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

    public function deactivateLoteById($id) {
        $SQL = "UPDATE sgm_lote_estandar SET activo = 0 WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => true
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
