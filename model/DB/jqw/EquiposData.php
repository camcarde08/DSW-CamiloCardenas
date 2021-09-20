<?php

require '../TablaEquiposDbModelClass.php';
require '../../DbClass.php';


$modelEquipos = new TablaEquiposDbModelClass();


if($_GET['query'] == 'all'){
    
    
    $data = $modelEquipos->getAllEquipos();
            foreach ($data as $equipo) {
               $equipos[] = array(
                   'id' => $equipo['id'],
                   'descripcion' => $equipo['descripcion'],
                   'referencia' => $equipo['referencia']
               );
               
            }
            echo json_encode($equipos);
}

