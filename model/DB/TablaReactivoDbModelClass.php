<?php

class TablaReactivoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllReactivo() {
        $SQL = "SELECT * FROM sgm_reactivo where activo = 1;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAllReactivosPorMuestra() {
        $SQL = "SELECT * FROM sgm_reactivo where activo = 1";
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

    function getAllReactivo2() {
        $SQL = "SELECT tbl1.*, tbl2.numero as lote, tbl2.fecha_vencimiento "
                . "FROM sgm_reactivo tbl1 "
                . "LEFT JOIN sgm_lote_reactivo tbl2 on tbl2.id_reactivo = tbl1.id and tbl2.activo = 1 "
                . "where tbl1.activo = 1 "
                . "order by tbl1.codigo asc;";
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

    function updateActivoReactivoById($id, $activo) {
        $SQL = "UPDATE sgm_reactivo SET activo = ? WHERE id = ? ;";
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

    function insertReactivo($nombre, $lote, $cantidad, $fechaVencimiento, $tipo, $cantidadActual, $stock, $fechaIngreso, $fechaApertura, $fechaTerminacion, $loteIterno, $fechaPase) {
        $SQL = "INSERT INTO sgm_reactivo (nombre,lote,cantidad,fecha_vencimiento,tipo,cantidad_actual,stock,fecha_ingreso,fecha_apertura,fecha_terminacion,lote_interno,fecha_pase) VALUES (?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $nombre);
        $query->bindParam(2, $lote);
        $query->bindParam(3, $cantidad);
        $query->bindParam(4, $fechaVencimiento);
        $query->bindParam(5, $tipo);
        $query->bindParam(6, $cantidadActual);
        $query->bindParam(7, $stock);
        $query->bindParam(8, $fechaIngreso);
        $query->bindParam(9, $fechaApertura);
        $query->bindParam(10, $fechaTerminacion);
        $query->bindParam(11, $loteIterno);
        $query->bindParam(12, $fechaPase);

        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $a = $this->dbClass->getConexion()->errorInfo();
            return false;
        }
    }

    function insertReactivo2($codigo, $nombre, $grado, $ubicacion, $clasificacion, $controlado, $stock_minimo, $condicion_almacenamiento) {
        $SQL = "INSERT INTO sgm_reactivo (codigo,nombre,grado,ubicacion,clasificacion,controlado,stock_minimo,condicion_almacenamiento) "
                . "VALUES (?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $grado);
        $query->bindParam(4, $ubicacion);
        if ($controlado == NULL) {
            $controlado = 0;
        }
        $query->bindParam(5, $clasificacion);
        $query->bindParam(6, $controlado);
        $query->bindParam(7, $stock_minimo);
        $query->bindParam(8, $condicion_almacenamiento);

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

    function updateReactivoById($codigo, $nombre, $grado, $ubicacion, $clasificacion, $controlado, $stock_minimo, $id, $condicion_almacenamiento) {
        $SQL = "UPDATE sgm_reactivo SET codigo = ?, nombre = ?, grado = ?, "
                . "ubicacion = ?, clasificacion = ?, controlado = ?, stock_minimo = ?, "
                . "condicion_almacenamiento = ? "
                . "WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $grado);
        $query->bindParam(4, $ubicacion);
        $query->bindParam(5, $clasificacion);
        $query->bindParam(6, $controlado);
        $query->bindParam(7, $stock_minimo);
        $query->bindParam(8, $condicion_almacenamiento);
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

    /*
     * Adición de método para eliminar reactivo
     */

    function deleteReactivoById($id) {
        $SQL = "UPDATE sgm_reactivo SET  activo = 0 WHERE id = ?;";
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

    function getReactivosAsociadosByIdEnsayoProd($idEnsayoProducto) {
        $SQL = "SELECT t1.*, t2.id as id_prod_ens_reactivo FROM sgm_reactivo t1 join sgm_producto_ensayo_reactivo t2 on t2.id_reactivo = t1.id where t2.id_producto_ensayo = ? order by t1.nombre asc;";
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

    function getReactivosDisponiblesByIdEnsayoProd($idEnsayoProducto) {
        $SQL = "SELECT t2.* FROM (SELECT t1.* FROM sgm_producto_ensayo_reactivo t1 WHERE t1.id_producto_ensayo = ?) t3"
                . " right join sgm_reactivo t2 ON t3.id_reactivo = t2.id "
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

    function getInfoReactivosInforme() {
        $SQL = "SELECT tb1.*, tb2.numero,tb2.fecha_vencimiento,tb2.fecha_apertura,tb2.fecha_recibido, tb2.cantidad,tb2.unidad, tb2.id as id_lote_reactivo "
                . "FROM sgm_reactivo tb1 "
                . "join sgm_lote_reactivo tb2 on tb2.id_reactivo=tb1.id "
                . "where tb2.activo = 1 or isnull(tb2.fecha_apertura);";
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

    function getInfoEstandares() {
        $SQL = "SELECT * from sgm_estandar";
        $query = $this->dbClass->getConexion()->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function obtenerDocumentoRuta($dir) {
        $dirContent = scandir($dir);
        $archivo = "";
        foreach ($dirContent as $file) {
            if (($file != "." && $file != "..") && !is_dir($dir . "/" . $file)) {
                $archivo = $file;
                break;
            }
        }
        return $archivo;
    }
    
    function getReactivoByIdToAud($id){
        $reactivo = Reactivo::find($id);
        $reactivo->lotes;
        return $reactivo->toJson();
    }

}
