<?php

/**
 * Created by PhpStorm.
 * User: jchacon
 * Date: 13/03/2017
 */
class TablaLoteReactivoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function insertNewLote($numero, $fechaVencimiento, $fechaRecibido
    , $fechaApertura, $cantidad, $unidad, $idReactivo, $observaciones
    , $cantidadInicial, $cantidadFinal, $fabricante, $concentracion) {
        $SQL = "INSERT INTO sgm_lote_reactivo (numero,fecha_vencimiento,"
                . "fecha_recibido,fecha_apertura,activo,cantidad,"
                . "unidad,id_reactivo,observaciones,cantidad_inicial,cantidad_final,fabricante,concentracion) "
                . "VALUES (?,?,?,?,0,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $fechaNula = null;
        $query->bindParam(1, $numero);

        if ($fechaVencimiento !== null && $fechaVencimiento !== '') {
            $explodeDate = explode("GMT", $fechaVencimiento);
            $query->bindParam(2, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(2, $fechaNula);
        }

        if ($fechaRecibido !== null && $fechaRecibido !== '') {
            $explodeDate = explode("GMT", $fechaRecibido);
            $query->bindParam(3, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(3, $fechaNula);
        }

        if ($fechaApertura !== null && $fechaApertura !== '') {
            $explodeDate = explode("GMT", $fechaApertura);
            $query->bindParam(4, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(4, $fechaNula);
        }

        $query->bindParam(5, $cantidad);
        $query->bindParam(6, $unidad);
        $query->bindParam(7, $idReactivo);
        $query->bindParam(8, $observaciones);
        $query->bindParam(9, $cantidadInicial);
        $query->bindParam(10, $cantidadFinal);
        $query->bindParam(11, $fabricante);
        $query->bindParam(12, $concentracion);

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

    public function getLotesByIdReactivo($idReactivo) {
        $SQL = "SELECT * FROM sgm_lote_reactivo WHERE id_reactivo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idReactivo);
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

    public function deactivateLotesByIdReactivo($idReactivo) {
        $SQL = "UPDATE sgm_lote_reactivo SET activo = 0 WHERE id_reactivo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idReactivo);
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

    public function updateLoteReactivo($numero, $fecha_vencimiento, $fecha_recibido
    , $fecha_apertura, $cantidad, $unidad, $observaciones
    , $cantidadInicial, $cantidadFinal, $fabricante, $concentracion, $id) {
        $SQL = "UPDATE sgm_lote_reactivo SET "
                . "numero = ?, fecha_vencimiento = ?, fecha_recibido = ?, fecha_apertura = ?, "
                . "cantidad = ?, unidad = ?, observaciones = ?, "
                . "cantidad_inicial = ?, cantidad_final = ?, fabricante = ?, concentracion = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $campoNulo = null;
        $query->bindParam(1, $numero);

        if ($fecha_vencimiento !== null && $fecha_vencimiento !== '') {
            $explodeDate = explode("GMT", $fecha_vencimiento);
            $query->bindParam(2, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(2, $campoNulo);
        }
        if ($fecha_recibido !== null && $fecha_recibido !== '') {
            $explodeDate = explode("GMT", $fecha_recibido);
            $query->bindParam(3, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(3, $campoNulo);
        }

        if ($fecha_apertura !== null && $fecha_apertura !== '') {
            $explodeDate = explode("GMT", $fecha_apertura);
            $query->bindParam(4, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(4, $campoNulo);
        }
        $cantidad = $cantidad !== "" && $cantidad !== "null" ? $cantidad : null;
        $query->bindParam(5, $cantidad);
        $query->bindParam(6, $unidad);
        $query->bindParam(7, $observaciones);
        $cantidadInicial = $cantidadInicial !== "" && $cantidadFinal !== "null" ? $cantidadInicial : null;
        $cantidadFinal = $cantidadFinal !== "" && $cantidadFinal !== "null" ? $cantidadFinal : null;
        $query->bindParam(8, $cantidadInicial);
        $query->bindParam(9, $cantidadFinal);
        $query->bindParam(10, $fabricante);
        $query->bindParam(11, $concentracion);
        $query->bindParam(12, $id);

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
        $SQL = "UPDATE sgm_lote_reactivo SET activo = 1 WHERE id = ?;";
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

    public function deactivateLoteById($id) {
        $SQL = "UPDATE sgm_lote_reactivo SET activo = 0 WHERE id = ?;";
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

    function obtenerLoteReactivoMuestraActivo($idMuestra) {
        $SQL = "SELECT DISTINCT(t2.nombre) as nombre_reactivo, t2.codigo as codigo_reactivo, 
                t3.numero as lote_reactivo, DATE_FORMAT(t3.fecha_vencimiento,'%m-%Y') as fecha_vencimiento, 
                t2.grado
                FROM sgm_ensayo_muestra_reactivo_lote t1 
                JOIN sgm_ensayo_muestra t4 on t1.id_ensayo_muestra = t4.id
                JOIN sgm_reactivo t2 ON t2.id = t1.id_reactivo
                JOIN sgm_lote_reactivo t3 ON t3.id=t1.id_lote
                WHERE t4.id_muestra=?";
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

}
