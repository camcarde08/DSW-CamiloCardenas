<?php

require '../TablaEstTipoEstabilidadDbModel.php';
require '../../DbClass.php';


$modelEstTipoEstabilidad = new TablaEstTipoEstabilidadDbModel();


if($_GET['query'] == 'getAllTipoEstabilidad'){
    
    
    $data = $modelEstTipoEstabilidad->getTipos();
            foreach ($data as $tipo) {
               $tipos[] = array(
                   'id' => $tipo['id'],
                   'customId' => $tipo['custom_id'],
                   'tipoEstabilidad' => $tipo['tipo_estabilidad'],
                   
               );
               
            }
            echo json_encode($tipos);
}

