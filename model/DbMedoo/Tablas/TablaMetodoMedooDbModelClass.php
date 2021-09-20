<?php

class TablaMetodoMedooDbModelClass {
   private $db;

    public function __construct() {
        $DbModelClass = new MedooDbModelClass();
        $this->db = $DbModelClass->conection();
    }

    function getActiveMetodo() {

        $datas = $this->db->select("metodo", [
            "id",
            "descripcion",
            "activo"
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
