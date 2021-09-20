<?php

require '../TablaUbicacionDbModelClass.php';
require '../../DbClass.php';

$tablaUbicacionDbModel = new TablaUbicacionDbModelClass();

if($_GET['query'] == 'getAllUbicacion'){
    $response = $tablaUbicacionDbModel->getAllUbicacion();
    if($response != false){
        foreach ($response as $ubicacion) {
            $ubicaciones[] = array(
                'id' => $ubicacion['id'],
                'descripcion' => $ubicacion['descripcion']
            );
        }
        
    } else {
        $ubicaciones = NULL;
    }
    echo json_encode($ubicaciones);  
}

