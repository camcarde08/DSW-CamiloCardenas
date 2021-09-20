<?php

class TablaMedioCultivoDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getAllMedioCultivo() {
        $SQL = "SELECT * FROM sgm_medio_cultivo where activo=1;";
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

    function insertMedioCultivo($codigo, $nombre, $tipo, $temperatura, $activo) {
        $SQL = "INSERT INTO sgm_medio_cultivo (codigo,nombre,tipo,temperatura,activo) VALUES (?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $tipo);
        $query->bindParam(4, $temperatura);
        $query->bindParam(5, $activo);


        if ($query->execute()) {
            return array(
                "code" => "00000",
                "message" => "OK",
                "data" => array(
                    "insertId" => $this->dbClass->getConexion()->lastInsertId()
                )
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

    function getMediosCultivoAndActiveLoteByIdEnsayo($idEnsayo) {
        $SQL = "SELECT t1.*, t2.id as id_lote_activo FROM  sgm_ensayo_medio_cultivo t1 JOIN sgm_lote_mc t2 ON t1.id_medio_cultivo = t2.id_medio_cultivo AND t2.activo = 1 WHERE t1.id_ensayo = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);

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

    function insertEnsayoMuestraMedioCultivoLote($idEnsayoMuestra, $idMedioCultivo, $idLote) {
        $SQL = "INSERT INTO sgm_ens_mue_med_cul (id_ensayo_muestra,id_medio_cultivo,id_lote_medio_cultivo) VALUES (?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayoMuestra);
        $query->bindParam(2, $idMedioCultivo);
        $query->bindParam(3, $idLote);

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

    function getMediosCultivoByIdEnsayo($idEnsayo) {
        $SQL = "SELECT t1.id as id_asociacion, t3.* FROM sgm_ensayo_medio_cultivo t1 JOIN (SELECT * FROM sgm_ensayo WHERE id = ?) t2 ON t1.id_ensayo = t2.id JOIN sgm_medio_cultivo t3 ON t1.id_medio_cultivo = t3.id;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
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

    function getMediosCultivoDisponiblesByIdEnsayo($idEnsayo) {
        $SQL = "SELECT t1.* FROM sgm_medio_cultivo t1 left JOIN (SELECT * FROM sgm_ensayo_medio_cultivo  WHERE id_ensayo = ? ) t2 ON t1.id = t2.id_medio_cultivo WHERE t2.id is null;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
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

    function deleteAsociacionEnsayoMedioCultivoById($id) {
        $SQL = "DELETE FROM sgm_ensayo_medio_cultivo WHERE id = ?;";
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

    function insertAsociacionEnsayoMedioCultivo($idEnsayo, $idMedioCultivo) {
        $SQL = "INSERT INTO sgm_ensayo_medio_cultivo (id_ensayo,id_medio_cultivo) VALUES (?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idEnsayo);
        $query->bindParam(2, $idMedioCultivo);
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

    function updateMedioCultivoById($codigo, $nombre, $tipo, $temperatura, $id) {
        $SQL = "UPDATE sgm_medio_cultivo SET codigo = ?, nombre = ?, tipo = ?, temperatura = ? WHERE id = ?;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $codigo);
        $query->bindParam(2, $nombre);
        $query->bindParam(3, $tipo);
        $query->bindParam(4, $temperatura);
        $query->bindParam(5, $id);

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

    function deleteMedioCultivoById($id) {
        $SQL = "UPDATE sgm_medio_cultivo SET  activo = 0 WHERE id = ?;";
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

}

class medioCultivo {

    public $id;
    public $nombre;

    public function __construct() {
        $this->id = (int) $this->id;
        $a = 0;
    }

}
