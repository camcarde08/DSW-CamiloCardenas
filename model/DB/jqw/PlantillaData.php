<?php

    require '../TablaPlantillaDbModelClass.php';
require '../../DbClass.php';


$modelForma = new TablaPlantillaDbModelClass();


if($_GET['query'] == 'allPlantillas'){
    
    
    $data = $modelForma->getAllPlantillas();
            foreach ($data as $forma) {
               $formas[] = array(
                   'idPlantilla' => $forma['id'],
                   'nomPlantilla' => $forma['descripcion']
               );
               
            }
            echo json_encode($formas);
}

