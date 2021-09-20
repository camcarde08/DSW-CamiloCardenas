<?php

require '../TablaMuestraDbModelClass.php';
require '../../DbClass.php';



if($_GET['query'] == 'GetMuestraReferenciasById'){
    $modelMuestra = new TablaMuestraDbModelClass();
    $data = $modelMuestra->getMuestraReferenciasById($_GET['idMuestra']);
    if($data !=  false && count($data)>0){
        $response[] = array(
            'idConsultado' => $_GET['idMuestra'],
            'response' => 1,
            'muestra' => $data[0]
        );
        
       echo json_encode($response);
    }
    else {
        $response[] = array(
            'idConsultado' => $_GET['idMuestra'],
            'response' => 0
        );
        echo json_encode($response);
    }
    
}



