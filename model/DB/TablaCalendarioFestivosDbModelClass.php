<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TablaCalendarioFestivosDbModelClass
 *
 * @author andres
 */
class TablaCalendarioFestivosDbModelClass {
    private $dbClass;
    
    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }
    
    function isDateHolyDay($idCalendario, $date){
        $SQL = 
        "select t1.id,".
        "t1.id_calendario_base,".
        "t1.id_festivo,".
        "t2.fecha from sgm_calendario_festivos t1 ".
        "join sgm_festivos t2 on t1.id_festivo = t2.id ".
        "where id_calendario_base = ? ".
        "and fecha = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL) ;
        $query->bindParam(1, $idCalendario);
        $query->bindParam(2, $date);
        if($query->execute()){
            if($query->fetchColumn() > 0){
                $data = true;
            } else {
                $data = false;
            }
        } else {
            $data = true;
        }
        return $data;
    }
}
