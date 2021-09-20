<?php

class TablaMuestraDetalleMicDbModelClass {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function insertMuestraDetalleMic($idMuestra, $fechaMuestreo, $areaMicrobiologica, $planta, $sanitizante, $frotis, $espAerobiosMesofilos, $espMohosLevaduras, $estabilidadMic, $puntoToma, $plantaTecnicaUsada, $responsableToma, $superficieEquipo, $espEColi, $plantaArea) {
        $SQL = "INSERT INTO sgm_muestra_detalle_mic (id_muestra,fecha_muestreo,area_microbiologica,planta,sanitizante,frotis,esp_aer_mes,esp_moh_lev,estabilidad, punto_toma, planta_tec_usada, responsable_toma, superficie_equipo,esp_ecoli, planta_area) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        $query->bindParam(2, $fechaMuestreo);
        $query->bindParam(3, $areaMicrobiologica);
        $query->bindParam(4, $planta);
        $query->bindParam(5, $sanitizante);
        $query->bindParam(6, $frotis);
        $query->bindParam(7, $espAerobiosMesofilos);
        $query->bindParam(8, $espMohosLevaduras);
        $query->bindParam(9, $estabilidadMic);
        $query->bindParam(10, $puntoToma);
        $query->bindParam(11, $plantaTecnicaUsada);
        $query->bindParam(12, $responsableToma);
        $query->bindParam(13, $superficieEquipo);
        $query->bindParam(14, $espEColi);
        $query->bindParam(15, $plantaArea);
        if ($query->execute()) {
            $response = array(
                "code" => "0",
                "message" => "Insert muestra detalle microbiologica success",
                "data" => array(
                    "idMuestraDetalleMic" => $this->dbClass->getConexion()->lastInsertId()
                )
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "RM-IDMM-00001", "message" => "error en insert de la tabla sgm_muestra_detalle_mic", "data" => $error
            );
        }
        return $response;
    }
    
    function getMuestraDetalleMicByIdMuestra($idMuestra){
        $SQL = "SELECT * FROM sgm_muestra_detalle_mic WHERE id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK",
                "data" =>  $query->fetchAll(PDO::FETCH_ASSOC)
                
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en select de la tabla sgm_muestra_detalle_mic", "data" => $error
            );
        }
        return $response;
    }
    
    function deleteMuestraDetalleMicByIdMuestra($idMuestra){
        $SQL = "DELETE FROM sgm_muestra_detalle_mic WHERE id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idMuestra);
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en delete de la tabla sgm_muestra_detalle_mic", "data" => $error
            );
        }
        return $response;
    }
    
    function updateMuestraDetalleMicByIdMuestra($fechaMuestreo,$areaMicrobiologica,$planta,$sanitizante,$frotis,$espEerMes,$espMohLev,$estabilidadMic,$plantaArea,$plantaTecnicaUsada,$responsableToma,$superficieEquipo,$espEColi,$puntoToma,$idMuestra){
        $SQL = "UPDATE sgm_muestra_detalle_mic SET fecha_muestreo = ?,area_microbiologica = ?,planta = ?,sanitizante = ?,frotis = ?,esp_aer_mes = ?,esp_moh_lev = ?, estabilidad = ?, planta_area = ?, planta_tec_usada = ?, responsable_toma = ?, superficie_equipo = ?, esp_ecoli = ?, punto_toma = ? WHERE id_muestra = ? ;";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $fechaMuestreo);
        $query->bindParam(2, $areaMicrobiologica);
        $query->bindParam(3, $planta);
        $query->bindParam(4, $sanitizante);
        $query->bindParam(5, $frotis);
        $query->bindParam(6, $espEerMes);
        $query->bindParam(7, $espMohLev);
        $query->bindParam(8, $estabilidadMic);
        $query->bindParam(9, $plantaArea);
        $query->bindParam(10, $plantaTecnicaUsada);
        $query->bindParam(11, $responsableToma);
        $query->bindParam(12, $superficieEquipo);
        $query->bindParam(13, $espEColi);
        $query->bindParam(14, $puntoToma);
        $query->bindParam(15, $idMuestra);
        
        if ($query->execute()) {
            $response = array(
                "code" => "00000",
                "message" => "OK"
            );
        } else {
            $error = $query->errorInfo();
            $response = array(
                "code" => "PEND", "message" => "error en update de la tabla sgm_muestra_detalle_mic", "data" => $error
            );
        }
        return $response;
    }

}
