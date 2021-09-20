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
class TablaMuestraHojaCalculoDbModelClass
{

    //put your code here

    private $dbClass;

    public function __construct()
    {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getEnsayoMuestraInformacionGeneralHojaCalculo($idEnsayoMuestra)
    {
        $SQL = "SELECT t2.id AS id_muestra,
                CONCAT(t2.prefijo,'-',t2.custom_id) AS muestra,
                t3.nombre AS cliente, t4.nombre AS producto, 
                t1.descripcion_especifica AS ensayoMuestra, 
                GROUP_CONCAT(DISTINCT(t6.nombre) SEPARATOR ', ') AS principiosActivos
                FROM sgm_ensayo_muestra t1 
                JOIN sgm_muestra t2 ON t2.id = t1.id_muestra 
                JOIN sgm_terceros t3 ON t3.id = t2.id_tercero 
                JOIN sgm_producto t4 ON t4.id = t2.id_producto 
                JOIN sgm_producto_principio_activo t5 ON t5.id_producto = t2.id_producto 
                JOIN sgm_principio_activo t6 ON t6.id = t5.id_principio_activo 
                WHERE t1.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);

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

    function getHojaCalculoEnsayoMuestra($idEnsayoMuestra)
    {
        $SQL = "SELECT id, id_ensayo_muestra, data, id_estado 
                FROM sgm_ensayo_muestra_hoja_calculo 
                WHERE id_ensayo_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);

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

    function getFuncionesHojaCalculo($idEnsayoMuestra)
    {
        $SQL = "SELECT t2.id_funcion AS funcion 
                FROM sgm_ensayo_muestra t1 
                JOIN sgm_funcion_hoja_calculo t2 ON t2.id_hoja_calculo = t1.id_hoja_calculo 
                WHERE t1.id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_COLUMN, 0)
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

    function getAllHojasCalculo()
    {
        $SQL = "SELECT * FROM sgm_hoja_calculo WHERE activo = 1";
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

    function saveEnsayoMuestraHojaCalculo($idEnsayoMuestra, $data, $usuarioGuardado)
    {
        $data = json_encode($data);
        $idEstado = 1;
        $SQL = "INSERT INTO sgm_ensayo_muestra_hoja_calculo (id_ensayo_muestra, data, id_estado, id_usuario_guardado, fecha_guardado)VALUES(?, ?, ?, ?, NOW())";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        $query->bindParam(2, $data);
        $query->bindParam(3, $idEstado);
        $query->bindParam(4, $usuarioGuardado);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "idMuestraHojaCalculo" => $this->dbClass->getConexion()->lastInsertId()
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

    function updateEnsayoMuestraHojaCalculo($idEnsayoMuestra, $data)
    {
        $data = json_encode($data);
        $SQL = "UPDATE sgm_ensayo_muestra_hoja_calculo SET data = ? WHERE id_ensayo_muestra = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $data);
        $query->bindParam(2, $idEnsayoMuestra);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "idMuestraHojaCalculo" => $this->dbClass->getConexion()->lastInsertId()
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

    function getEnsayoMuestraHojaCalculoByIdToAud($id) {
        $ensayoMuestraHojaCalculo = EnsayoMuestraHojaCalculo::find($id);
        $ensayoMuestraHojaCalculo->data = json_decode($ensayoMuestraHojaCalculo->data);
        return $ensayoMuestraHojaCalculo->toJson();
    }

    function insertEnsayoMuestraHojaCalculoAud($old, $new, $idEnsayoMuestra, $idHojaCalculoEnsayoMuestra, $evento, $razon) {

        $ensayoMuestraHojaCalculoAud = new EnsayoMuestraHojaCalculoAud();
        $ensayoMuestraHojaCalculoAud->fecha = new DateTime("now");
        $ensayoMuestraHojaCalculoAud->old = $old;
        $ensayoMuestraHojaCalculoAud->new = $new;
        $ensayoMuestraHojaCalculoAud->id_usuario = $_SESSION['userId'];
        $ensayoMuestraHojaCalculoAud->id_ensayo_muestra = $idEnsayoMuestra;
        $ensayoMuestraHojaCalculoAud->id_hoja_calculo_ensayo_muestra = $idHojaCalculoEnsayoMuestra;
        $ensayoMuestraHojaCalculoAud->evento = $evento;
        $ensayoMuestraHojaCalculoAud->razon = $razon;
        try {
            $ensayoMuestraHojaCalculoAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

}
