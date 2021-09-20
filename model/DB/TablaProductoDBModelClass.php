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
class TablaProductoDBModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    public function updateProducto($idProducto, $nombreProducto, $forma) {
        $SQL = "UPDATE sgm_producto SET nombre = ?,id_formula_farma = ? WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombreProducto);
        $query->bindParam(2, $forma);
        $query->bindParam(3, $idProducto);

        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    public function deleteProducto($idProducto, $activo) {
        $SQL = "UPDATE sgm_producto SET activo = ? WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $activo);
        $query->bindParam(2, $idProducto);

        if ($query->execute()) {
            $data = true;
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllProducto() {
        $query = "select t1.id as idProducto, t1.nombre as nombreProducto, t1.tecnica as tecnicaProducto,
t1.tiempo_entrega as tiemppoEntregaProducto, t2.id as idFormulaFarmaceutica, t2.descripcion as
descripcionFormula, t2.tipo_producto as tipoProducto from sgm_producto t1
inner join sgm_forma_farmaceutica t2 on t1.id_formula_farma = t2.id where t1.estado = 1 and t1.activo = 1";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getTodosProducto() {
        $query = "select t1.id as idProducto, t1.nombre as nombreProducto, t1.tecnica as tecnicaProducto,
t1.tiempo_entrega as tiempoEntregaProducto, t2.id as idFormulaFarmaceutica, t2.descripcion as
descripcionFormula, t2.tipo_producto as tipoProducto, t1.estado as estadoProducto from sgm_producto t1
inner join sgm_forma_farmaceutica t2 on t1.id_formula_farma = t2.id where t1.activo = 1;";

        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    public function insertProducto($nombre, $idFormaFarma, $estado, $tecnica, $timepoEntrega) {
        $SQL = "INSERT INTO sgm_producto (nombre,id_formula_farma,estado,tecnica,tiempo_entrega) VALUES (?,?,?,?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $idFormaFarma);
        $query->bindParam(3, $estado);
        $query->bindParam(4, $tecnica);
        $query->bindParam(5, $timepoEntrega);
        if ($query->execute()) {
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllProducto2() {
        $SQL = "select * from sgm_producto t1 where t1.estado = 1 and t1.activo = 1 order by nombre asc";

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

    public function updateProducto2($idProducto, $nombreProducto, $forma) {
        $SQL = "UPDATE sgm_producto SET nombre = ?,id_formula_farma = ? WHERE id = ?;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombreProducto);
        $query->bindParam(2, $forma);
        $query->bindParam(3, $idProducto);

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

    function insertProducto2($nombre, $idFormaFarma, $estado, $tecnica, $timepoEntrega) {
        $SQL = "INSERT INTO sgm_producto (nombre,id_formula_farma,estado,tecnica,tiempo_entrega) VALUES (?,?,?,?,?);";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $idFormaFarma);
        $query->bindParam(3, $estado);
        $query->bindParam(4, $tecnica);
        $query->bindParam(5, $timepoEntrega);

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

    function deleteProductoById($id) {
        $SQL = "UPDATE sgm_producto SET  activo = 0 WHERE id = ?;";
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

    function getPrincipiosAsociadosByIdProd($idProducto) {
        $SQL = "SELECT t1.id, t1.nombre, t2.id as id_producto_principio_activo, t2.id_producto "
                . "FROM sgm_principio_activo t1 "
                . "join sgm_producto_principio_activo t2 on t2.id_principio_activo = t1.id "
                . "where t2.id_producto=? and t1.activo=1 "
                . "order by t1.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
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

    function getPrincipiosDisponiblesByIdProd($idProducto) {
        $SQL = "SELECT t2.id, t2.nombre "
                . "FROM (SELECT t1.* FROM sgm_producto_principio_activo t1 WHERE t1.id_producto = ?) t3 "
                . "right join sgm_principio_activo t2 ON t3.id_principio_activo = t2.id "
                . "WHERE t3.id IS NULL and t2.activo=1 "
                . "order by t2.nombre asc;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idProducto);
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

    function getProductosPaginacion($cantidad, $pagina, $nombre, $forma) {
        $pagina = $pagina - 1;
        $nombre = "%" . $nombre . "%";
        $forma = "%" . $forma . "%";

        $registroInicial = $pagina * $cantidad;

        $SQL = "SELECT t1.*
            FROM sgm_producto t1 
            LEFT JOIN sgm_forma_farmaceutica t2 on t2.id = t1.id_formula_farma
            WHERE 
            IFNULL(t1.nombre,'') like ? and 
            IFNULL(t2.descripcion,'') like ? and 
            t1.activo = 1 
            order by t1.nombre asc 
            limit $registroInicial, $cantidad ;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $forma);

        if ($query->execute()) {

            $productos = $query->fetchAll(PDO::FETCH_ASSOC);

            $SQL2 = "SELECT 
            count(t1.id) as cantidad_total
            FROM sgm_producto t1  
            LEFT JOIN sgm_forma_farmaceutica t2 on t2.id = t1.id_formula_farma
            WHERE 
            IFNULL(t1.nombre,'') like ? and 
            IFNULL(t2.descripcion,'') like ? and 
            t1.activo = 1;";

            $query2 = $this->dbClass->getConexion()->prepare($SQL2);
            $query2->bindParam(1, $nombre);
            $query2->bindParam(2, $forma);

            if ($query2->execute()) {
                return array(
                    "code" => "00000",
                    "message" => "OK",
                    "data" => array(
                        "productos" => $productos,
                        "cantidad_total" => $query2->fetch(PDO::FETCH_OBJ)->cantidad_total
                    )
                );
            }
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

    function insertProductoAud($old, $new, $idProducto, $evento, $razon) {

        $productoAud = new ProductoAud();
        $productoAud->fecha = new DateTime("now");
        $productoAud->old = $old;
        $productoAud->new = $new;
        $productoAud->id_usuario = $_SESSION['userId'];
        $productoAud->id_producto = $idProducto;
        $productoAud->evento = $evento;
        $productoAud->razon = $razon;
        try {
            $productoAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

    function getProductoByIdToAud($id) {
        $producto = Producto::find($id);
        $producto->paquetes;
        foreach ($producto->productoEnsayos as $keyProductoEnsayo => $valueProductoEnsayo) {



            $valueProductoEnsayo->reactivos;

            $valueProductoEnsayo->estandares;
            $valueProductoEnsayo->condicionCromatografica;
            $valueProductoEnsayo->columna;
            
        }
        $producto->principiosActivos;
        return $producto->toJson();
    }

}
