<?php

class TablaAreaMicrobiologicaMedooDbModelClass {

    private $db;

    public function __construct() {
        $DbModelClass = new MedooDbModelClass();
        $this->db = $DbModelClass->conection();
    }

    function getActiveAreasMicrobiologicas() {

        $datas = $this->db->select("area_microbiologica", [
            "id",
            "descripcion",
            "activo"
                ], [
            "activo[=]" => 1,
            "ORDER" => ["descripcion" => "ASC"]
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
