<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaCondicionCromatograficaDbModelClass
 *
 * @author lvelasquez
 */
class TablaCondicionCromatograficaDbModelClass {

    //put your code here

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllCondicionCromatografica() {
        $SQL = "SELECT t1.* FROM sgm_condicion_cromatografica t1 where t1.activo = 1 ORDER BY t1.codigo ASC;";
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

    function updateCondicionCromatografica($id, $codigo, $nombre
    , $longitud_onda, $diluyente_valoracion, $diluyente_disolucion, $fase_movil
    , $concentracion, $flujo, $volumen_inyeccion, $temperatura, $aptitud_sistema
    , $tr, $observaciones, $disolucion_condiciones, $disolucion_medio
    , $disolucion_longitud_onda, $disolucion_observaciones
    , $ecuacion_calculo, $disolucion_flujo, $disolucion_volumen_inyeccion, $disolucion_tr
    , $disolucion_temperatura, $disolucion_aptitud_sistema
    , $disolucion_fase_movil, $disolucion_ecuacion_calculo
    , $referencia, $disolucion_referencia, $disolucion_concentracion
    , $elaborado_por, $revisado_por, $aprobado_por) {
        $SQL = "UPDATE sgm_condicion_cromatografica SET codigo = ?, nombre = ?, longitud_onda = ?, "
                . "diluyente_valoracion = ?, diluyente_disolucion = ?, fase_movil = ?, "
                . "concentracion = ?, flujo = ?, volumen_inyeccion = ?, temperatura = ?, "
                . "aptitud_sistema = ?, tr = ?, observaciones = ?, disolucion_condiciones = ?, "
                . "disolucion_medio = ?, disolucion_longitud_onda = ?, disolucion_observaciones = ?, "
                . "ecuacion_calculo = ?, disolucion_flujo = ?, disolucion_volumen_inyeccion = ?, disolucion_tr = ?,"
                . "disolucion_temperatura = ?, disolucion_aptitud_sistema = ?, "
                . "disolucion_fase_movil = ?, disolucion_ecuacion_calculo = ?, "
                . "referencia = ?, disolucion_referencia = ?, disolucion_concentracion = ?,"
                . "elaborado_por = ?, revisado_por = ?, aprobado_por = ? "
                . "WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $longitud_onda);
        $query->bindParam(4, $diluyente_valoracion);
        $query->bindParam(5, $diluyente_disolucion);
        $query->bindParam(6, $fase_movil);
        $query->bindParam(7, $concentracion);
        $query->bindParam(8, $flujo);
        $query->bindParam(9, $volumen_inyeccion);
        $query->bindParam(10, $temperatura);
        $query->bindParam(11, $aptitud_sistema);
        $query->bindParam(12, $tr);
        $query->bindParam(13, $observaciones);
        $query->bindParam(14, $disolucion_condiciones);
        $query->bindParam(15, $disolucion_medio);
        $query->bindParam(16, $disolucion_longitud_onda);
        $query->bindParam(17, $disolucion_observaciones);
        $query->bindParam(18, $ecuacion_calculo);
        $query->bindParam(19, $disolucion_flujo);
        $query->bindParam(20, $disolucion_volumen_inyeccion);
        $query->bindParam(21, $disolucion_tr);
        $query->bindParam(22, $disolucion_temperatura);
        $query->bindParam(23, $disolucion_aptitud_sistema);
        $query->bindParam(24, $disolucion_fase_movil);
        $query->bindParam(25, $disolucion_ecuacion_calculo);
        $query->bindParam(26, $referencia);
        $query->bindParam(27, $disolucion_referencia);
        $query->bindParam(28, $disolucion_concentracion);
        $query->bindParam(29, $elaborado_por);
        $query->bindParam(30, $revisado_por);
        $query->bindParam(31, $aprobado_por);
        $query->bindParam(32, $id);


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

    function insertCondicionCromatografica($codigo, $nombre
    , $longitud_onda, $diluyente_valoracion, $diluyente_disolucion, $fase_movil
    , $concentracion, $flujo, $volumen_inyeccion, $temperatura, $aptitud_sistema
    , $tr, $observaciones, $disolucion_condiciones, $disolucion_medio
    , $disolucion_longitud_onda, $disolucion_observaciones
    , $ecuacion_calculo, $disolucion_flujo, $disolucion_volumen_inyeccion, $disolucion_tr
    , $disolucion_temperatura, $disolucion_aptitud_sistema
    , $disolucion_fase_movil, $disolucion_ecuacion_calculo
    , $referencia, $disolucion_referencia, $disolucion_concentracion
    , $elaborado_por, $revisado_por, $aprobado_por) {
        $SQL = "INSERT INTO sgm_condicion_cromatografica "
                . "(codigo, nombre, longitud_onda, diluyente_valoracion, diluyente_disolucion, fase_movil, "
                . "concentracion, flujo, volumen_inyeccion, temperatura, aptitud_sistema, tr, observaciones, "
                . "disolucion_condiciones, disolucion_medio, disolucion_longitud_onda, "
                . "disolucion_observaciones, "
                . "ecuacion_calculo, disolucion_flujo, disolucion_volumen_inyeccion, disolucion_tr, "
                . "disolucion_temperatura, disolucion_aptitud_sistema, "
                . "disolucion_fase_movil, disolucion_ecuacion_calculo, "
                . "referencia, disolucion_referencia, disolucion_concentracion,"
                . "elaborado_por, revisado_por, aprobado_por)"
                . " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $longitud_onda);
        $query->bindParam(4, $diluyente_valoracion);
        $query->bindParam(5, $diluyente_disolucion);
        $query->bindParam(6, $fase_movil);
        $query->bindParam(7, $concentracion);
        $query->bindParam(8, $flujo);
        $query->bindParam(9, $volumen_inyeccion);
        $query->bindParam(10, $temperatura);
        $query->bindParam(11, $aptitud_sistema);
        $query->bindParam(12, $tr);
        $query->bindParam(13, $observaciones);
        $query->bindParam(14, $disolucion_condiciones);
        $query->bindParam(15, $disolucion_medio);
        $query->bindParam(16, $disolucion_longitud_onda);
        $query->bindParam(17, $disolucion_observaciones);
        $query->bindParam(18, $ecuacion_calculo);
        $query->bindParam(19, $disolucion_flujo);
        $query->bindParam(20, $disolucion_volumen_inyeccion);
        $query->bindParam(21, $disolucion_tr);
        $query->bindParam(22, $disolucion_temperatura);
        $query->bindParam(23, $disolucion_aptitud_sistema);
        $query->bindParam(24, $disolucion_fase_movil);
        $query->bindParam(25, $disolucion_ecuacion_calculo);
        $query->bindParam(26, $referencia);
        $query->bindParam(27, $disolucion_referencia);
        $query->bindParam(28, $disolucion_concentracion);
        $query->bindParam(29, $elaborado_por);
        $query->bindParam(30, $revisado_por);
        $query->bindParam(31, $aprobado_por);

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

    function deleteCondicionCromatografica($id) {
        $SQL = "UPDATE sgm_condicion_cromatografica SET activo = 0 WHERE id = ?;";

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

    function getCondicionCromatograficaByIdToAud($id) {
        $condicioncromatografica = CondicionCromatografica::find($id);

        return $condicioncromatografica->toJson();
    }

}
