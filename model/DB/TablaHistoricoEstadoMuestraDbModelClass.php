<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaHistoricoEstadoMuestraDbModelClass
 *
 * @author andres
 */
class TablaHistoricoEstadoMuestraDbModelClass {

    //put your code here
    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function insertHistoricoEstadoMuestra($idMuestra, $idEstado, $idUsuario) {
        $SQL = "insert into sgm_historico_estado_muestra (id_muestra, id_estado, id_usuario) values ( ?, ? , ? );";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $idEstado);
        $query->bindParam(3, $idUsuario);
        if ($query->execute()) {
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }

    function insertHistoricoEstadoMuestraObservaciones($idMuestra, $idEstado, $idUsuario, $observaciones) {
        $SQL = "insert into sgm_historico_estado_muestra (id_muestra, id_estado, id_usuario, observaciones) values ( ?, ? , ?,? );";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $idEstado);
        $query->bindParam(3, $idUsuario);
        $query->bindParam(4, $observaciones);
        if ($query->execute()) {
            $data = $this->dbClass->getConexion()->lastInsertId();
        } else {
            $data = false;
        }
        return $data;
    }

    function insertValidateHistoricoEstadoMuestraByIdMuestra($idMuestra, $idUsuario) {
        $SQL2 = "SELECT * FROM sgm_historico_estado_muestra where id_muestra = ? order by fecha desc limit 0,1;";
        $query2 = $this->dbClass->getConexion()->prepare($SQL2);
        $query2->bindParam(1, $idMuestra);
        if ($query2->execute()) {
            $data2 = $query2->fetchAll();
            $estadoActual = $data2[0]['id_estado'];
        } else {
            $data2 = false;
        }
        if ($data2 != false) {
            $countEnsayos[0] = 0;
            $countEnsayos[1] = 0;
            $SQL1 = "SELECT * FROM sgm_ensayo_muestra where id_muestra = ? ";
            $query = $this->dbClass->getConexion()->prepare($SQL1);
            $query->bindParam(1, $idMuestra);
            if ($query->execute()) {
                $data1 = $query->fetchAll();
            } else {
                $data1 = false;
            }
            if ($data1 != false) {
                foreach ($data1 as $EnsayoMuestra) {
                    if ($EnsayoMuestra['estado_ensayo'] == 0) {
                        $countEnsayos[0] ++;
                    }
                    if ($EnsayoMuestra['estado_ensayo'] == 1) {
                        $countEnsayos[1] ++;
                    }
                }
            }
            if ($countEnsayos[0] > 0) {
                if ($estadoActual != 6) {
                    $this->insertHistoricoEstadoMuestra($idMuestra, 6, $idUsuario);
                }
            } elseif ($countEnsayos[1] > 0) {
                if ($estadoActual != 7) {
                    $this->insertHistoricoEstadoMuestra($idMuestra, 7, $idUsuario);
                }
            }
        }
    }

    function getHistoricoEstadosMuestraByIdMuestra($idMuestra) {
        $SQL = "SELECT t1.*, t2.descripcion as des_estado, t3.nombre as nombre_usuario FROM sgm_historico_estado_muestra t1 join sgm_estado t2 on t1.id_estado = t2.id join sgm_usuario t3 on t1.id_usuario = t3.id WHERE id_muestra = ? ORDER BY t1.fecha ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $data = $query->fetchAll();
        } else {
            $data = false;
        }
        return $data;
    }

    function getHistoricoEstadosMuestraByIdMuestra2($idMuestra) {
        $SQL = "SELECT t1.*, t2.descripcion as des_estado, t3.nombre as nombre_usuario, t5.nombre as nombre_producto
FROM sgm_historico_estado_muestra t1 
join sgm_estado t2 on t1.id_estado = t2.id 
join sgm_usuario t3 on t1.id_usuario = t3.id 
join sgm_muestra t4 on t4.id = t1.id_muestra
join sgm_producto t5 on t4.id_producto = t5.id
WHERE t1.id_muestra = ? ORDER BY t1.fecha ;";
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
                "code" => "PEND", "message" => "error en select de la tabla sgm_muestra_detalle_mic", "data" => $error
            );
        }
        return $response;
    }

}
