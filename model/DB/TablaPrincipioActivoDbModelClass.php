<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaPrincipioActivoDbModelClass
 *
 * @author lvelasquez
 */
class TablaPrincipioActivoDbModelClass {

    //put your code here

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getPrincipioActivoByProducto($producto) {
//               
        $query = " select t1.id_principio_activo as id_principio_activo,
                        t2.id as id_principio,
                        t1.id_producto as id_producto,
                        t1.principal as principal,
                        t1.trasador as trasador,
                        t2.nombre as nombre_principio
        from sgm_producto_principio_activo t1 inner join sgm_principio_activo t2 where t1.id_principio_activo  = t2.id and t1.id_producto='$producto'";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllPrincipioActivo() {
        $SQL = "SELECT t1.*, t2.nombre as nombre_estandar FROM sgm_principio_activo t1 left join sgm_estandar t2 on t1.id_estandar = t2.id "
                . "where t1.activo = 1 ORDER BY t1.nombre ASC;";
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

    function insertPrincioActivo($nombre, $valorTR, $valorStopTime, $valorSolFase, $porSolFase, $valorSolDisolucion, $porSolDisolucion, $valorFlujo, $cantidadMuestra, $cantidadxEstandar, $cantidadEstandar) {
        $SQL = "INSERT INTO sgm_principio_activo "
                . "(nombre,valor_tr,valor_stop_time,valor_sol_fase,por_sol_fase,valor_sol_disolucion,por_sol_disolucion,"
                . "valor_flujo,cantidad_muestra,cantidad_x_estandar,cantidad_estandar,activo) VALUES (?,?,?,?,?,?,?,?,?,?,?,1);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $valorTR);
        $query->bindParam(3, $valorStopTime);
        $query->bindParam(4, $valorSolFase);
        $query->bindParam(5, $porSolFase);
        $query->bindParam(6, $valorSolDisolucion);
        $query->bindParam(7, $porSolDisolucion);
        $query->bindParam(8, $valorFlujo);
        $query->bindParam(9, $cantidadMuestra);
        $query->bindParam(10, $cantidadxEstandar);
        $query->bindParam(11, $cantidadEstandar);
        //$query->bindParam(12, $idEstandar);

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

    function deletePrincioActivo($id) {
        $SQL = "UPDATE sgm_principio_activo SET activo = 0 WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $id);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $id
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

    function updatePrincipioActivo($id, $nombre, $valorTR, $valorStopTime, $valorSolFase, $porSolFase, $valorSolDisolucion, $porSolDisolucion, $valorFlujo, $cantidadMuestra, $cantidadxEstandar, $cantidadEstandar) {
        $SQL = "UPDATE sgm_principio_activo SET nombre = ?, valor_tr = ?, valor_stop_time = ?, valor_sol_fase = ?, por_sol_fase = ?, valor_sol_disolucion = ?, por_sol_disolucion = ?, valor_flujo = ?, cantidad_muestra = ?, cantidad_x_estandar = ?, cantidad_estandar = ? WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $valorTR);
        $query->bindParam(3, $valorStopTime);
        $query->bindParam(4, $valorSolFase);
        $query->bindParam(5, $porSolFase);
        $query->bindParam(6, $valorSolDisolucion);
        $query->bindParam(7, $porSolDisolucion);
        $query->bindParam(8, $valorFlujo);
        $query->bindParam(9, $cantidadMuestra);
        $query->bindParam(10, $cantidadxEstandar);
        $query->bindParam(11, $cantidadEstandar);
        $query->bindParam(12, $id);

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
    
    function getPrincipioActivoByIdToAud($id) {
        $principiActivo = PrincipioActivo::find($id);
        return $principiActivo->toJson();
    }

}
