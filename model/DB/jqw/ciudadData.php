<?php

require '../TablaCiudadDbModelClass.php';
require '../../DbClass.php';

$ciudadModel = new TablaCiudadDbModelClass();

if($_GET['query'] == 'getAllCiudad'){
    $data = $ciudadModel->getAllCiuidad();
    if($data != false){
        foreach ($data as $ciudad) {
            $ciudades[] = array(
                'id' => $ciudad['id'],
                'nombre' => $ciudad['nombre']
            );
        }
        
    } else {
        $ciudades = NULL;
    }
    echo json_encode($ciudades);  
}

