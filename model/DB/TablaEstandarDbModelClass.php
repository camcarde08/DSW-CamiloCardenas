<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaEquiposDbModelClass
 *
 * @author andres
 */
class TablaEstandarDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllEstandares() {
        $SQL = "SELECT * FROM sgm_estandar where activo = 1;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllEstandares2() {
        $SQL = "SELECT est.*, concat(ifnull(est.codigo,''),' ',ifnull(est.nombre,'')) as nombre_concatenado, "
                . "lote.codigo as lote, lote.fecha_vencimiento, lote.descripcion as potencia "
                . "FROM sgm_estandar est "
                . "left join sgm_lote_estandar lote on lote.id_estandar = est.id "
                . "and lote.activo = 1 "
                . "where est.activo = 1 "
                . "ORDER BY est.codigo ASC;";
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

    function insertEstandar($nombre, $lote, $cantidad, $fechaVencimiento, $tipo, $cantidadActual, $stock, $loteInterno, $fechaPreparacion, $fechaPromocion, $cantidad2, $codigo, $fechaIngreso, $fechaApertura, $fechaTerminacion) {
        $SQL = "INSERT INTO sgm_estandar (nombre,lote,cantidad,fecha_vencimiento,tipo,cantidad_actual,stock,lote_interno,fecha_preparacion,fecha_promocion,cantidad_preparada,codigo,fecha_ingreso,fecha_apertura,fecha_terminacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $lote);
        $query->bindParam(3, $cantidad);
        $query->bindParam(4, $fechaVencimiento);
        $query->bindParam(5, $tipo);
        $query->bindParam(6, $cantidadActual);
        $query->bindParam(7, $stock);
        $query->bindParam(8, $loteInterno);
        $query->bindParam(9, $fechaPreparacion);
        $query->bindParam(10, $fechaPromocion);
        $query->bindParam(11, $cantidad2);
        $query->bindParam(12, $codigo);
        $query->bindParam(13, $fechaIngreso);
        $query->bindParam(14, $fechaApertura);
        $query->bindParam(15, $fechaTerminacion);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $query->errorInfo();
            return false;
        }
    }

    function updateActivoById($id, $activo) {
        $SQL = "UPDATE sgm_estandar SET activo = ? WHERE id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $activo);
        $query->bindParam(2, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function updateEstandarById($nombre, $lote, $cantidad, $fecha, $fechaIngreso, $fechaApertura, $fechaTerminacion, $id, $tipo, $cantidadActual, $stock) {
        $SQL = "UPDATE sgm_estandar SET nombre = ?, lote = ?, cantidad = ?, fecha_vencimiento = ?, tipo = ?, cantidad_actual = ?, stock = ?, fecha_ingreso = ?, fecha_apertura = ?, fecha_terminacion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $lote);
        $query->bindParam(3, $cantidad);
        $query->bindParam(4, $fecha);
        $query->bindParam(5, $tipo);
        $query->bindParam(6, $cantidadActual);
        $query->bindParam(7, $stock);
        $query->bindParam(8, $fechaIngreso);
        $query->bindParam(9, $fechaApertura);
        $query->bindParam(10, $fechaTerminacion);
        $query->bindParam(11, $id);
        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    /*
     * Función adicionada para eliminar estándar -> Módulo estándar
     */

    function deleteEstandarById($idEstandar) {
        $SQL = "UPDATE sgm_estandar SET  activo = 0 WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEstandar);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $idEstandar
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

    /*
     * Función adicionada para actualizar estándar -> Módulo estándar
     */

    function updateEstandarById2($codigo, $nombre, $tipo, $origen, $almacenamiento
    , $uso_previsto, $propiedades, $ubicacion, $id) {
        $SQL = "UPDATE sgm_estandar SET codigo = ?, nombre = ?, tipo = ?, "
                . "origen = ?, almacenamiento = ?, uso_previsto = ?, propiedades = ?, "
                . "ubicacion = ? "
                . "WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $tipo);
        $query->bindParam(4, $origen);
        $query->bindParam(5, $almacenamiento);
        $query->bindParam(6, $uso_previsto);
        $query->bindParam(7, $propiedades);
        $query->bindParam(8, $ubicacion);
        $query->bindParam(9, $id);
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

    function insertEstandar2($codigo, $nombre, $tipo, $origen, $almacenamiento, $uso_previsto, $propiedades
    , $ubicacion) {
        $SQL = "INSERT INTO sgm_estandar (codigo,nombre,tipo,origen,almacenamiento"
                . ",uso_previsto,propiedades, ubicacion) "
                . "VALUES (?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $tipo);
        $query->bindParam(4, $origen);
        $query->bindParam(5, $almacenamiento);
        $query->bindParam(6, $uso_previsto);
        $query->bindParam(7, $propiedades);
        $query->bindParam(8, $ubicacion);

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

    function getEstandarById($idEstandar) {
        $SQL = "select * FROM sgm_estandar where id = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEstandar);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            return array(
                "code" => "00001",
                "message" => "ERROR",
                "data" => array(
                    "errorDb" => $query->errorInfo()
                )
            );
        }
    }

    function getEstandaresAsociadosByIdEnsayoProd($idEnsayoProducto) {
        $SQL = "SELECT t1.*, t2.id as id_prod_ens_estandar FROM sgm_estandar t1 join sgm_producto_ensayo_estandar t2 on t2.id_estandar = t1.id where t2.id_producto_ensayo = ? order by t1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoProducto);
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

    function getEstandaresDisponiblesByIdEnsayoProd($idEnsayoProducto) {
        $SQL = "SELECT t2.* FROM (SELECT t1.* FROM sgm_producto_ensayo_estandar t1 WHERE t1.id_producto_ensayo = ?) t3"
                . " right join sgm_estandar t2 ON t3.id_estandar = t2.id "
                . "WHERE t3.id IS NULL and t2.activo = 1 order by t2.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoProducto);
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

    function getEstandarByIdToAud($id) {
        $estandar = Estandar::find($id);
        $estandar->lotes;
        return $estandar->toJson();
    }

    function getTiposEstandar() {
        $SQL = "SELECT distinct tipo FROM sgm_estandar where !isnull(tipo) and tipo <> '' order by tipo asc;";
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

}
