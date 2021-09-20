<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaPerfilPermisoDbModelClass
 *
 * @author andres
 */
class TablaPerfilPermisoBandejaEntradaDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getPerfilPermisosBandejaEntrada($idPerfil) {
        $SQL = "SELECT * FROM sgm_perfil_permiso_bandeja_entrada where id_perfil = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPerfil);
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

    function asignarPerfilPermisoBandejaEntrada($idPerfil, $idPermiso) {
        $SQL = "INSERT INTO sgm_perfil_permiso_bandeja_entrada (id_perfil,id_permiso_bandeja) values (?,?)";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPerfil);
        $query->bindParam(2, $idPermiso);
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

    function eliminarPerfilPermisoBandejaEntrada($idPerfil, $idPermiso) {
        $SQL = "DELETE FROM sgm_perfil_permiso_bandeja_entrada where id_perfil = ? and id_permiso_bandeja = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPerfil);
        $query->bindParam(2, $idPermiso);
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

}
