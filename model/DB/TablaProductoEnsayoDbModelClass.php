<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaProductoDBModelClass
 *
 * @author lvelasquez
 */
class TablaProductoEnsayoDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function getProductoEnsayoByIdProducto($idProducto) {
        $SQL = "SELECT t1.*, t2.descripcion as metodo, t3.id_ensayo as idPaquete, t4.descripcion as desPaquete, t5.descripcion as desOriginal FROM sgm_producto_ensayo t1  join sgm_metodo t2 on t1.id_metodo = t2.id  join sgm_producto_paquete t3 on t1.id_producto_paquete = t3.id join sgm_ensayo t4 on t3.id_ensayo = t4.id join sgm_ensayo t5 on t1.id_ensayo = t5.id where t1.id_producto = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function updateProductoEnsayoById($idProductoEnsayo, $descripcion, $especificacion, $idMetodo, $tiempo, $valor, $resultado) {
        $SQL = "UPDATE sgm_producto_ensayo SET descripcion = ?,especificacion = ?,id_metodo = ?,tiempo = ?,valor = ?,tipo_resultado = ? WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);
        $query->bindParam(2, $especificacion);
        $query->bindParam(3, $idMetodo);
        $query->bindParam(4, $tiempo);
        $query->bindParam(5, $valor);
        $query->bindParam(6, $resultado);
        $query->bindParam(7, $idProductoEnsayo);
        if ($query->execute()) {
            $data = true;
        } else {
            $error = $query->errorInfo();
            $data = false;
        }
        return $data;
    }

    public function insertProductoEnsayo($idEnsayo, $idProducto, $tiempo, $idMetodo, $valor, $descripcion, $especificacion, $idProductoPaquete, $prinId, $tipoResultado) {
        $SQL = "INSERT INTO sgm_producto_ensayo (id_ensayo,id_producto,tiempo,id_metodo,valor,descripcion,especificacion,id_producto_paquete,prin_id,tipo_resultado) VALUES (?,?,?,?,?,?,?,?,?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        $query->bindParam(2, $idProducto);
        $query->bindParam(3, $tiempo);
        $query->bindParam(4, $idMetodo);
        $query->bindParam(5, $valor);
        $query->bindParam(6, $descripcion);
        $query->bindParam(7, $especificacion);
        $query->bindParam(8, $idProductoPaquete);
        $query->bindParam(9, $prinId);
        $query->bindParam(10, $tipoResultado);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    public function deleteProductoEnsayo($idEnsayo, $idProducto, $idProductoPaquete) {
        $SQL = "DELETE FROM sgm_producto_ensayo WHERE id_ensayo = ? AND id_producto = ? AND id_producto_paquete = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        $query->bindParam(2, $idProducto);
        $query->bindParam(3, $idProductoPaquete);

        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    public function getProductoEnsayoByProductoPaqueteEnsayo($idProducto, $idPaquete, $idEnsayo) {
        $SQL = "select t2.* from sgm_producto_paquete t1 join sgm_producto_ensayo t2 on t2.id_producto_paquete = t1.id where t1.id_producto = ? and t1.id_ensayo = ? and t2.id_ensayo = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idPaquete);
        $query->bindParam(3, $idEnsayo);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function getProductoEnsayoByProductoPaquete($idProducto, $idPaquete) {
        $SQL = "SELECT t1.*
FROM sgm_producto_ensayo t1  
join sgm_producto_paquete t3 on t1.id_producto_paquete = t3.id 
join sgm_ensayo t4 on t3.id_ensayo = t4.id 
join sgm_ensayo t5 on t1.id_ensayo = t5.id 
where t1.id_producto = ? and t3.id=? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
        $query->bindParam(2, $idPaquete);
        if ($query->execute()) {
            $data = $query->fetchAll(PDO::FETCH_OBJ);
        } else {
            $data = false;
        }
        return $data;
    }

    function updateCondicionCromatograficaProdEnsayo($idProdEnsayo, $condicion_cromatografica) {
        $SQL = "UPDATE sgm_producto_ensayo SET id_condicion_cromatografica = ? WHERE id = ?;";

        $condicionCromatografica = $condicion_cromatografica == "" ? null : $condicion_cromatografica;

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $condicionCromatografica);
        $query->bindParam(2, $idProdEnsayo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId());
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

    function getCondicionCromatograficaProductoEnsayo($idProductoEnsayo) {
        $SQL = "SELECT tb1.id_condicion_cromatografica, tb1.id_columna "
                . "FROM sgm_producto_ensayo tb1 "
                . "where tb1.id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);

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

    function updateColumnaProdEnsayo($idProdEnsayo, $idColumna) {
        $SQL = "UPDATE sgm_producto_ensayo SET id_columna = ? WHERE id = ?;";

        $idColumna = $idColumna == "" ? null : $idColumna;

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idColumna);
        $query->bindParam(2, $idProdEnsayo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId());
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

    function deleteProductoEnsayoById($idProductoEnsayo) {
        $SQL = "DELETE FROM sgm_producto_ensayo "
                . "WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProductoEnsayo);

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

    public function deleteProductoEnsayo2($idEnsayo, $idProducto, $idProductoPaquete) {
        $SQL = "DELETE FROM sgm_producto_ensayo "
                . "WHERE id_ensayo = ? "
                . "AND id_producto = ? "
                . "AND id_producto_paquete = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        $query->bindParam(2, $idProducto);
        $query->bindParam(3, $idProductoPaquete);

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

    function getEnsayosProductoByIdPaqueteIdProducto($idPaquete, $idProducto) {
        $SQL = "SELECT t1.*, t2.descripcion, t3.descripcion as descripcion_especifica, "
                . "t3.especificacion, t3.tiempo, t3.id_metodo, t3.id as id_producto_ensayo "
                . "FROM sgm_ensayo_paquete t1 "
                . "JOIN sgm_ensayo t2 on t1.id_ensayo = t2.id "
                . "LEFT JOIN sgm_producto_ensayo t3 on t3.id_ensayo = t2.id "
                . "JOIN sgm_producto_paquete t4 on t4.id = t3.id_producto_paquete and t4.id_ensayo = t1.id_paquete "
                . "WHERE t1.id_paquete = ? AND t3.id_producto=? "
                . "ORDER BY t2.orden;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idPaquete);
        $query->bindParam(2, $idProducto);
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

    public function updateProductoEnsayoById2($idProductoEnsayo, $descripcion, $especificacion, $idMetodo, $tiempo) {
        $SQL = "UPDATE sgm_producto_ensayo SET descripcion = ?,especificacion = ?,id_metodo = ?,tiempo = ? WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $descripcion);
        $query->bindParam(2, $especificacion);
        $query->bindParam(3, $idMetodo);
        $query->bindParam(4, $tiempo);
        $query->bindParam(5, $idProductoEnsayo);

        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId());
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

    function updateHojaCalculoProdEnsayo($idProdEnsayo, $hoja_calculo) {
        $SQL = "UPDATE sgm_producto_ensayo SET id_hoja_calculo = ? WHERE id = ?;";

        $hojaCalculo = $hoja_calculo == "" ? null : $hoja_calculo;

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $hojaCalculo);
        $query->bindParam(2, $idProdEnsayo);
        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId());
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
