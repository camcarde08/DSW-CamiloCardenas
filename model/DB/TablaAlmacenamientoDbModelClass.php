<?php

class TablaAlmacenamientoDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAlmacenamientosByIdMuestra($idMuestra) {
        $SQL = "SELECT t1.*, t2.descripcion as desUbicacion, t3.descripcion as desTipoAlmacen FROM sgm_almacenamiento t1 join sgm_ubicacion t2 on t1.id_ubicacion = t2.id join sgm_tipo_almacenamiento t3 on t1.id_tipo_almacenamiento = t3.id where t1.id_muestra = ? ORDER BY t1.id ASC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getAlmacenamientosByIdMuestra2($idMuestra) {
        $SQL = "SELECT t1.*, t3.descripcion as desTipoAlmacen FROM sgm_almacenamiento t1 join sgm_tipo_almacenamiento t3 on t1.id_tipo_almacenamiento = t3.id where t1.id_muestra = ? ORDER BY t1.id ASC;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll(PDO::FETCH_ASSOC)
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_almacenamiento", "data" => $error
            );
        }
        return $response;
    }

    function insertAlamacenamiento($idMuestra, $fecha, $idUbicacion, $idTipoAlmacenamiento, $nivel, $caja, $tiempo, $fechaSalida, $peso, $observaciones) {
        $SQL = "insert into sgm_almacenamiento "
                . "(id_muestra,fecha, id_ubicacion, id_tipo_almacenamiento, nivel, tiempo,caja, fecha_salida, peso_aproximado, observaciones) "
                . "values "
                . "(? , ? , ? , ? , ?, ? ,?,?,?,?); ";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $fecha);
        $query->bindParam(3, $idUbicacion);
        $query->bindParam(4, $idTipoAlmacenamiento);
        $query->bindParam(5, $nivel);
        $query->bindParam(6, $tiempo);
        $query->bindParam(7, $caja);
        $query->bindParam(8, $fechaSalida);
        $query->bindParam(9, $peso);
        $query->bindParam(10, $observaciones);
        if ($query->execute()) {
            return $this->dbClass->getConexion()->lastInsertId();
        } else {
            $error = $query->errorInfo();
            return false;
        }
    }

    function insertAlamacenamiento2($idMuestra, $fecha, $idUbicacion, $idTipoAlmacenamiento, $nivel, $caja, $tiempo) {
        $SQL = "insert into sgm_almacenamiento "
                . "(id_muestra,fecha, id_ubicacion, id_tipo_almacenamiento, nivel, tiempo,caja) "
                . "values "
                . "(? , ? , ? , ? , ?, ? ,?); ";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $fecha);
        $query->bindParam(3, $idUbicacion);
        $query->bindParam(4, $idTipoAlmacenamiento);
        $query->bindParam(5, $nivel);
        $query->bindParam(6, $tiempo);
        $query->bindParam(7, $caja);
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

    function deleteAlmacenamiento($idAlmacenamiento) {
        $SQL = "DELETE FROM sgm_almacenamiento
            WHERE id = ? ;";

        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAlmacenamiento);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function actualizarEstadoSalidaMuestra($idAlmacenamiento) {
        $SQL = "UPDATE sgm_almacenamiento "
                . "SET estado_salida = 1 "
                . "WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAlmacenamiento);
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

    function updateAlmacenamientoConIdTipo($idMuestra, $fecha, $idUbicacion
    , $idTipoAlmacenamiento, $nivel, $caja
    , $tiempo, $fechaSalida, $peso, $observaciones, $id) {
        $SQL = "UPDATE sgm_almacenamiento "
                . "SET id_muestra = ?, fecha = ?, id_ubicacion = ?, "
                . "id_tipo_almacenamiento = ?, nivel = ?, tiempo = ?, "
                . "caja = ?, fecha_salida = ?, "
                . "peso_aproximado = ?, observaciones = ? "
                . "where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $fecha);
        $query->bindParam(3, $idUbicacion);
        $query->bindParam(4, $idTipoAlmacenamiento);
        $query->bindParam(5, $nivel);
        $query->bindParam(6, $tiempo);
        $query->bindParam(7, $caja);
        $query->bindParam(8, $fechaSalida);
        $query->bindParam(9, $peso);
        $query->bindParam(10, $observaciones);
        $query->bindParam(11, $id);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_almacenamiento", "data" => $error
            );
        }
        return $response;
    }

    function updateAlmacenamiento($idMuestra, $fecha, $idUbicacion
    , $nivel, $caja
    , $tiempo, $fechaSalida, $peso, $observaciones, $id) {
        $SQL = "UPDATE sgm_almacenamiento "
                . "SET id_muestra = ?, fecha = ?, id_ubicacion = ?, "
                . "nivel = ?, tiempo = ?, "
                . "caja = ?, fecha_salida = ?, "
                . "peso_aproximado = ?, observaciones = ? "
                . "where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $fecha);
        $query->bindParam(3, $idUbicacion);
        $query->bindParam(4, $nivel);
        $query->bindParam(5, $tiempo);
        $query->bindParam(6, $caja);
        $query->bindParam(7, $fechaSalida);
        $query->bindParam(8, $peso);
        $query->bindParam(9, $observaciones);
        $query->bindParam(10, $id);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $this->dbClass->getConexion()->lastInsertId()
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_almacenamiento", "data" => $error
            );
        }
        return $response;
    }

    function getMuestraByIdAlmacenamiento($idAlmacenamiento) {
        $SQL = "SELECT id_muestra FROM sgm_almacenamiento "
                . "where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idAlmacenamiento);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" => $query->fetchAll()
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_almacenamiento", "data" => $error
            );
        }
        return $response;
    }

}
