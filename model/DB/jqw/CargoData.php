<?php

require '../TablaCargoDbModelClass.php';
require '../../DbClass.php';


$modelCargo = new TablaCargoDbModelClass();
 
 
if($_GET['query'] == 'getAll'){
    $data = $modelCargo->getAllCargo();
    
    if($data != false){
        foreach ($data as $cargo) {
            $cargos[] = array(
                'idCargo' => $cargo['id'],
                'nombreCargo' => $cargo['nombre']
            ); 
        }
        echo json_encode($cargos);
    } else 
        echo null;
           
            
}


