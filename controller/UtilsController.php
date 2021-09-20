<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilsController
 *
 * @author hruge
 */
class UtilsController {
    //put your code here
    
    function contructCerosIdMuestra(){
        $aux = "";
        for($i = 0; $i < $_SESSION["systemsParameters"]["leftCeroCustomIdMuestra"]; $i++ ){
            $aux = $aux."0";
        }
        return $aux;
    }
    
    function constructComplexIdMuestra($prefix,$customId){
        $aux = (string)$customId;
        for($i = strlen($aux); $i < $_SESSION["systemsParameters"]["leftCeroCustomIdMuestra"]; $i++ ){
            $aux = "0".$aux;
        }
        $aux = $prefix.$_SESSION["systemsParameters"]["prefixMuestraSeparator"].$aux;
        return $aux;
    }
    
    function getRealIdMuestra($idMuestra){
        if ($_SESSION["systemsParameters"]["customIdMuestra"] == "true"){
            $modelMuestra = new TablaMuestraDbModelClass();
            $prefix = substr ( $idMuestra , 0, $_SESSION["systemsParameters"]["prefixMuestraLength"]);
            $customIdMuestra =(int) substr ( $idMuestra , $_SESSION["systemsParameters"]["prefixMuestraLength"]+strlen($_SESSION["systemsParameters"]["prefixMuestraSeparator"]));
            $data = $modelMuestra->getRealIdMuestra($prefix, $customIdMuestra);
            $realIdMuestra = $data[0]["id"];
            return $realIdMuestra;
        } else {
            return $idMuestra;
        }
        
        
    }
    
    function getRealIdMuestraEstabilidad($idMuestra) { 
         
        $prefix = substr($idMuestra, 0, $_SESSION["systemsParameters"]["prefixMuestraLength"]); 
        $customIdMuestra = (int) substr($idMuestra, $_SESSION["systemsParameters"]["prefixMuestraLength"] + strlen($_SESSION["systemsParameters"]["prefixMuestraSeparator"])); 
         
        $tipoMuestra = TipoMuestra::where("prefijo", $prefix)->first(); 
         
        $muestra = EstMuestra::where("id_tipo_muestra", $tipoMuestra->id) 
                ->where("custom_id", $customIdMuestra)->first(); 
         
        return $muestra->id; 
    } 
}
