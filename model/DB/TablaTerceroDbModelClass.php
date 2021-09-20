<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaTerceroDbModelClass
 *
 * @author hruge
 */
class TablaTerceroDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllTercero() {

        $query = "SELECT * FROM sgm_terceros";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function updateTerceroById($id, $nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato) {

        $SQL = "UPDATE sgm_terceros SET nombre = ?, tipo_identificacion = ?, numero_identificacion = ?, nombre_representante = ?, direccion = ?, telefono1 = ?, telefono2 = ?, fax = ?, email = ?, id_ciudad = ?, descuento_pronto_pago = ?, porcent_descuento = ?, tiene_contrato = ?, fecha_vencimiento_contrato = ?, fecha_contrato = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $tipoIdentificacion);
        $query->bindParam(3, $numIdentificacion);
        $query->bindParam(4, $representante);
        $query->bindParam(5, $direccion);
        $query->bindParam(6, $tel1);
        $query->bindParam(7, $tel2);
        $query->bindParam(8, $fax);
        $query->bindParam(9, $email);
        $query->bindParam(10, $idCiudad);
        $query->bindParam(11, $descuento);
        $query->bindParam(12, $porDescuento);
        $query->bindParam(13, $contrato);
        $fecVenContrato = $fecVenContrato == 'null' ? NULL : $fecVenContrato;
        $fecContrato = $fecContrato == 'null' ? NULL : $fecVenContrato;
        $query->bindParam(14, $fecVenContrato);
        $query->bindParam(15, $fecContrato);
        $query->bindParam(16, $id);

        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function insertTercero($nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato) {

        $SQL = "INSERT INTO sgm_terceros (nombre,tipo_identificacion,numero_identificacion, nombre_representante, direccion, telefono1, telefono2, fax, email, id_ciudad, descuento_pronto_pago, porcent_descuento, tiene_contrato, fecha_vencimiento_contrato, fecha_contrato) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $tipoIdentificacion);
        $query->bindParam(3, $numIdentificacion);
        $query->bindParam(4, $representante);
        $query->bindParam(5, $direccion);
        $query->bindParam(6, $tel1);
        $query->bindParam(7, $tel2);
        $query->bindParam(8, $fax);
        $query->bindParam(9, $email);
        $query->bindParam(10, $idCiudad);
        $query->bindParam(11, $descuento);
        $query->bindParam(12, $porDescuento);
        $query->bindParam(13, $contrato);
        $fecVenContrato = $fecVenContrato == 'null' ? NULL : $fecVenContrato;
        $fecContrato = $fecContrato == 'null' ? NULL : $fecVenContrato;
        $query->bindParam(14, $fecVenContrato);
        $query->bindParam(15, $fecContrato);

        if ($query->execute()) {
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }

    function getClientesActivos() {
        $SQL = "SELECT * FROM sgm_terceros ORDER BY nombre ASC;";
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

    function getTerceroByIdToAud($id) {
        $tercero = Tercero::find($id);
        $tercero->contactos;

        foreach ($tercero->usuariosCliente as $usuario) {
            $usuario->usuarioPermisos;
        }

        return $tercero->toJson();
    }

    function updateTerceroById2($id, $nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato) {

        $SQL = "UPDATE sgm_terceros SET nombre = ?, tipo_identificacion = ?, numero_identificacion = ?, nombre_representante = ?, direccion = ?, telefono1 = ?, telefono2 = ?, fax = ?, email = ?, id_ciudad = ?, descuento_pronto_pago = ?, porcent_descuento = ?, tiene_contrato = ?, fecha_vencimiento_contrato = ?, fecha_contrato = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $tipoIdentificacion);
        $query->bindParam(3, $numIdentificacion);
        $query->bindParam(4, $representante);
        $query->bindParam(5, $direccion);
        $query->bindParam(6, $tel1);
        $query->bindParam(7, $tel2);
        $query->bindParam(8, $fax);
        $query->bindParam(9, $email);
        $query->bindParam(10, $idCiudad);
        $query->bindParam(11, $descuento);
        $query->bindParam(12, $porDescuento);
        $query->bindParam(13, $contrato);
        $fecVenContrato = $fecVenContrato == '' ? NULL : $fecVenContrato;
        $fecContrato = $fecContrato == '' ? NULL : $fecContrato;
        $query->bindParam(14, $fecVenContrato);
        $query->bindParam(15, $fecContrato);
        $query->bindParam(16, $id);

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

    function insertTercero2($nombre, $tipoIdentificacion, $numIdentificacion, $representante, $direccion, $tel1, $tel2, $fax, $email, $idCiudad, $descuento, $porDescuento, $contrato, $fecContrato, $fecVenContrato) {

        $SQL = "INSERT INTO sgm_terceros (nombre, tipo_identificacion, numero_identificacion, nombre_representante, "
                . "direccion, telefono1, telefono2, fax, email, id_ciudad, descuento_pronto_pago, "
                . "porcent_descuento, tiene_contrato, fecha_vencimiento_contrato, fecha_contrato) "
                . "VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $tipoIdentificacion);
        $query->bindParam(3, $numIdentificacion);
        $query->bindParam(4, $representante);
        $query->bindParam(5, $direccion);
        $query->bindParam(6, $tel1);
        $query->bindParam(7, $tel2);
        $query->bindParam(8, $fax);
        $query->bindParam(9, $email);
        $query->bindParam(10, $idCiudad);
        $descuento = $descuento == null || $descuento == "" ? 0 : $descuento;
        $query->bindParam(11, $descuento);
        $query->bindParam(12, $porDescuento);
        $contrato = $contrato == null || $contrato == "" ? 0 : $contrato;
        $query->bindParam(13, $contrato);
        $fecVenContrato = $fecVenContrato == '' ? NULL : $fecVenContrato;
        $fecContrato = $fecContrato == '' ? NULL : $fecContrato;
        $query->bindParam(14, $fecVenContrato);
        $query->bindParam(15, $fecContrato);

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

    function insertTerceroAud($old, $new, $idTercero, $evento, $razon) {

        $terceroAud = new TerceroAud();
        $terceroAud->fecha = new DateTime("now");
        $terceroAud->old = $old;
        $terceroAud->new = $new;
        $terceroAud->id_usuario = $_SESSION['userId'];
        $terceroAud->id_tercero = $idTercero;
        $terceroAud->evento = $evento;
        $terceroAud->razon = $razon;
        try {
            $terceroAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

}
