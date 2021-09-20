<?php

require '../TablaMetodoDbModelClass.php';
require '../../DbClass.php';


$metodoModel = new TablaMetodoDbModelClass();

if($_GET['query']=='getAllMetodo'){
    $data = $metodoModel->getAllMetodo();
    if($data != false){
        foreach ($data as $metodo) {
            $response[] = array(
                'id' => $metodo['id'],
                'descripcion' => $metodo['descripcion'],
                'activo' => $metodo['activo']
            );
        }
        echo json_encode($response);
    } else {
        echo json_encode(NULL);
    }
}

