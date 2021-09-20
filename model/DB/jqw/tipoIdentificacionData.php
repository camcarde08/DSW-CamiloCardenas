<?php

require '../TablaTipoIdentificacionDbModelClass.php';
require '../../DbClass.php';

$tipoIdentificacionModel = new TablaTIpoIdentificacionDbModelClass();

if($_GET['query'] == 'getAllTipo'){
    $data = $tipoIdentificacionModel->getAllTipo();
    if($data != false){
        foreach ($data as $tipo) {
            $tipos[] = array(
                'id' => $tipo['id'],
                'tipoIdentificacion' => $tipo['tipo_identificacion']
            );
        }
        
    } else {
        $tipos = null;
    }
    echo json_encode($tipos);  
}

