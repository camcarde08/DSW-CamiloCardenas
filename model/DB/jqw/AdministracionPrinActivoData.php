<?php

require '../TablaPrincipioActivoDbModelClass.php';
require '../../DbClass.php';


$modelPrincipioActivo = new TablaPrincipioActivoDbModelClass();
 
 
if($_GET['query'] == 'getAllPrincipiosActivos'){
    
    
    $data = $modelPrincipioActivo->getAllPrincipioActivo();
    if($data != false){
        foreach ($data as $principioActivo) {
           
            $princiosActivos[] = array(
                'id' => $principioActivo['id'],
                'nombre' => $principioActivo['nombre'],
                'valorTR' => $principioActivo['valor_tr'],
                'valorStopTime' => $principioActivo['valor_stop_time'],
                'valorSolFase' => $principioActivo['valor_sol_fase'],
                'porSolFase' => $principioActivo['por_sol_fase'],
                'valorSolDisolucion' => $principioActivo['valor_sol_disolucion'],
                'porSolDisolucion' => $principioActivo['por_sol_disolucion'],
                'valorFlujo' => $principioActivo['valor_flujo'],
                'cantidadMuestra' => $principioActivo['cantidad_muestra'],
                'cantidadxEstandar' => $principioActivo['cantidad_x_estandar'],
                'cantidadEstandar' => $principioActivo['cantidad_estandar'],
                'activo' => $principioActivo['activo'],
                'idEstandar' => $principioActivo['id_estandar'],
                'estandar' => $principioActivo['nombre_estandar']
            ); 
        }
        echo json_encode($princiosActivos);
    } else 
        echo null;
           
            
}


