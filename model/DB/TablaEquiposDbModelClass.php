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
class TablaEquiposDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllEquipos() {
        $SQL = "select * from sgm_equipo";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllEquiposActivos() {
        $SQL = "select * from sgm_equipo where activo = 1";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllEquiposActivos2() {
        $SQL = "select * from sgm_equipo where activo = 1 order by descripcion";
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

    function updateActivoById($id, $activo) {
        $SQL = "UPDATE sgm_equipo SET activo = ? WHERE id = ? ;";
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

    function updateEquipoById($idEquipo, $codInventario, $modelo, $serie, $referencia, $descripcion, $marca, $provMant, $provCali, $frecMantpreven, $frecCalib, $fechaUlimoMant, $fechaUltimaCalibracion, $calificacion, $numDiasAlerta, $infoMant, $striker) {

        $SQL = "UPDATE sgm_equipo SET cod_inventario = ?, modelo = ?, serie = ?, referencia = ?, descripcion = ?, marca = ?, proveedor_mant = ?, proveedor_calib = ?, frec_mant_preven = ?, frec_calib = ?, fecha_ult_mant = ?, fecha_ult_calib = ?, calificacion = ?, num_dias_alerta = ?, info_mant = ?, striker = ? WHERE id = ?";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codInventario);
        $query->bindParam(2, $modelo);
        $query->bindParam(3, $serie);
        $query->bindParam(4, $referencia);
        $query->bindParam(5, $descripcion);
        $query->bindParam(6, $marca);
        $query->bindParam(7, $provMant);
        $query->bindParam(8, $provCali);
        $query->bindParam(9, $frecMantpreven);
        $query->bindParam(10, $frecCalib);
        $query->bindParam(11, $fechaUlimoMant);
        $query->bindParam(12, $fechaUltimaCalibracion);
        $query->bindParam(13, $calificacion);
        $query->bindParam(14, $numDiasAlerta);
        $query->bindParam(15, $infoMant);
        $query->bindParam(16, $striker);
        $query->bindParam(17, $idEquipo);

        if ($query->execute()) {
            $data = true;
        } else {
            $arr2 = $query->errorCode();
            $arr = $query->errorInfo();
            $t = $arr[2];
            $data = false;
        }


        return $data;
    }

    function insertEquipo($codInventario, $modelo, $serie, $referencia, $descripcion, $marca, $provMant, $provCali) {

        $SQL = "INSERT INTO sgm_equipo (cod_inventario,modelo,serie,referencia,descripcion,marca,proveedor_mant,proveedor_calib) VALUES (? ,? ,? ,?,? ,? ,? ,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codInventario);
        $query->bindParam(2, $modelo);
        $query->bindParam(3, $serie);
        $query->bindParam(4, $referencia);
        $query->bindParam(5, $descripcion);
        $query->bindParam(6, $marca);
        $query->bindParam(7, $provMant);
        $query->bindParam(8, $provCali);


        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }


        return $data;
    }

    function insertEquipo2($codigo, $modelo, $serie, $descripcion, $marca, $fecha_ult_mant
    , $fecha_ult_calib, $fecha_prox_calibracion, $fecha_prox_mantenimiento
    , $fecha_ult_calificacion, $fecha_prox_calificacion, $proveedor) {

        $fechaNula = NULL;

        $SQL = "INSERT INTO sgm_equipo (cod_inventario,modelo,serie,descripcion,marca,"
                . "fecha_ult_mant,fecha_ult_calib,fecha_prox_calibracion,fecha_prox_mantenimiento,"
                . "fecha_ult_calificacion,fecha_prox_calificacion,proveedor_mant) "
                . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $modelo);
        $query->bindParam(3, $serie);
        $query->bindParam(4, $descripcion);
        $query->bindParam(5, $marca);

        if ($fecha_ult_mant !== null && $fecha_ult_mant !== '') {
            $explodeDate = explode("GMT", $fecha_ult_mant);
            $query->bindParam(6, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(6, $fechaNula);
        }

        if ($fecha_ult_calib !== null && $fecha_ult_calib !== '') {
            $explodeDate = explode("GMT", $fecha_ult_calib);
            $query->bindParam(7, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(7, $fechaNula);
        }

        if ($fecha_prox_calibracion !== null && $fecha_prox_calibracion !== '') {
            $explodeDate = explode("GMT", $fecha_prox_calibracion);
            $query->bindParam(8, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(8, $fechaNula);
        }

        if ($fecha_prox_mantenimiento !== null && $fecha_prox_mantenimiento !== '') {
            $explodeDate = explode("GMT", $fecha_prox_mantenimiento);
            $query->bindParam(9, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(9, $fechaNula);
        }

        if ($fecha_ult_calificacion !== null && $fecha_ult_calificacion !== '') {
            $explodeDate = explode("GMT", $fecha_ult_calificacion);
            $query->bindParam(10, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(10, $fechaNula);
        }

        if ($fecha_prox_calificacion !== null && $fecha_prox_calificacion !== '') {
            $explodeDate = explode("GMT", $fecha_prox_calificacion);
            $query->bindParam(11, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(11, $fechaNula);
        }

        $query->bindParam(12, $proveedor);

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

    function updateEquipo($id, $codigo, $modelo, $serie, $descripcion, $marca, $fecha_ult_mant
    , $fecha_ult_calib, $fecha_prox_calibracion, $fecha_prox_mantenimiento
    , $fecha_ult_calificacion, $fecha_prox_calificacion, $proveedor) {

        $fechaNula = NULL;

        $SQL = "UPDATE sgm_equipo SET cod_inventario=?,modelo=?,serie=?,descripcion=?,marca=?,"
                . "fecha_ult_mant=?,fecha_ult_calib=?,fecha_prox_calibracion=?,fecha_prox_mantenimiento=?,"
                . "fecha_ult_calificacion=?,fecha_prox_calificacion=?, proveedor_mant=? "
                . "where id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $modelo);
        $query->bindParam(3, $serie);
        $query->bindParam(4, $descripcion);
        $query->bindParam(5, $marca);

        if ($fecha_ult_mant !== null && $fecha_ult_mant !== '') {
            $explodeDate = explode("GMT", $fecha_ult_mant);
            $query->bindParam(6, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(6, $fechaNula);
        }

        if ($fecha_ult_calib !== null && $fecha_ult_calib !== '') {
            $explodeDate = explode("GMT", $fecha_ult_calib);
            $query->bindParam(7, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(7, $fechaNula);
        }

        if ($fecha_prox_calibracion !== null && $fecha_prox_calibracion !== '') {
            $explodeDate = explode("GMT", $fecha_prox_calibracion);
            $query->bindParam(8, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(8, $fechaNula);
        }

        if ($fecha_prox_mantenimiento !== null && $fecha_prox_mantenimiento !== '') {
            $explodeDate = explode("GMT", $fecha_prox_mantenimiento);
            $query->bindParam(9, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(9, $fechaNula);
        }

        if ($fecha_ult_calificacion !== null && $fecha_ult_calificacion !== '') {
            $explodeDate = explode("GMT", $fecha_ult_calificacion);
            $query->bindParam(10, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(10, $fechaNula);
        }

        if ($fecha_prox_calificacion !== null && $fecha_prox_calificacion !== '') {
            $explodeDate = explode("GMT", $fecha_prox_calificacion);
            $query->bindParam(11, date('Y-m-d', strtotime($explodeDate[0])));
        } else {
            $query->bindParam(11, $fechaNula);
        }

        $query->bindParam(12, $proveedor);
        $query->bindParam(13, $id);

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

    function deleteEquipo($idEquipo) {

        $SQL = "UPDATE sgm_equipo SET activo = 0 "
                . "where id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEquipo);

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
    
    function getEquipoByIdToAud($idEquipo) {
        $equipo = Equipo::find($idEquipo);
        return $equipo->toJson();
    }

}
