<?php

    require '../TablaFormaDbModelClass.php';
require '../../DbClass.php';


$modelForma = new TablaFormaDbModelClass();


if($_GET['query'] == 'all'){
    
    
    $data = $modelForma->getAllFormas();
            foreach ($data as $forma) {
               $formas[] = array(
                   'id' => $forma['id'],
                   'descripcion' => $forma['descripcion']
               );
               
            }
            echo json_encode($formas);
}
if($_GET['query'] == 'combo'){
    
    
    $data = $modelForma->getAllFormas();
            foreach ($data as $forma) {
               $formas[] = array(
                   'idFormaf' => $forma['id'],
                   'descripcionFormaf' => $forma['descripcion']
               );
               
            }
            echo json_encode($formas);
}

