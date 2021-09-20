<?php

require '../TablaTipoAlmacenaminetoDbModelClass.php';
require '../../DbClass.php';

$tablaTipoAlmacenaminetoDbModel = new TablaTipoAlmacenaminetoDbModelClass();

if($_GET['query'] == 'getAllTipoAlamacenamiento'){
    $response = $tablaTipoAlmacenaminetoDbModel->getAllTipoAlamacenamiento();
    if($response != false){
        foreach ($response as $tipoAlmacenamiento) {
            $tiposAlmacenamiento[] = array(
                'id' => $tipoAlmacenamiento['id'],
                'descripcion' => $tipoAlmacenamiento['descripcion']
            );
        }
        
    } else {
        $tiposAlmacenamiento = NULL;
    }
    echo json_encode($tiposAlmacenamiento);  
}


?>
