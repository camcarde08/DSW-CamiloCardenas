<?php


class TablaTipoMuestraMedooDbModelClass {
    private $db;

    public function __construct() {
        $DbModelClass = new MedooDbModelClass();
        $this->db = $DbModelClass->conection();
    }

    function getActiveTipoMuestra() {

        $datas = $this->db->select("tipo_muestra", [
            "id",
            "descripcion",
            "prefijo",
            "activo",
            "id_area_analisis"
                ], [
            "activo[=]" => 1
                ]
        );
        $ERROR = $this->db->error();
        if($ERROR[0] === "00000"){
            return array(
                "query" => true,
                "data" => $datas
            );
        } else {
            return array(
                "query" => false,
                "data" => $ERROR
            );
        }
    }
}
