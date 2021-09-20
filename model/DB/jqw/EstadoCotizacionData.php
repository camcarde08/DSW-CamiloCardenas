<?php

require '../TablaEstadoCotizacionDbModelClass.php';
require '../../DbClass.php';


$modelEstadoCotizacion = new TablaEstadoCotizacionDbModelClass();
 
 
if($_GET['query'] == 'getAllEstado'){
    
    
    $data = $modelEstadoCotizacion->getAllEstados();
    if($data != false){
        foreach ($data as $estado) {
           
            $estados[] = array(
                'id' => $estado['id'],
                'estado' => $estado['estado']
            ); 
        }
        echo json_encode($estados);
    } else 
        echo null;
           
            
}


