<?php

require '../TablaEquiposDbModelClass.php';
require '../../DbClass.php';


$modelEquipo = new TablaEquiposDbModelClass();
 
 
if($_GET['query'] == 'getAllEquiposActivos'){
    
    
    $data = $modelEquipo->getAllEquiposActivos();
    if($data != false){
        foreach ($data as $equipo) {
           
            $equipos[] = array(
                'id' => $equipo['id'],
                'codInventario' => $equipo['cod_inventario'],
                'modelo' => $equipo['modelo'],
                'serie' => $equipo['serie'],
                'referencia' => $equipo['referencia'],
                'descripcion' => $equipo['descripcion'],
                'marca' => $equipo['marca'],
                'proveedorMantenimiento' => $equipo['proveedor_mant'],
                'proveedorCalibracion' => $equipo['proveedor_calib'],
                'frecuenciaMantenimientoPreventivo' => $equipo['frec_mant_preven'],
                'frecuenciaCalibracion' => $equipo['frec_calib'],
                'fechaUltimoMantenimiento' => $equipo['fecha_ult_mant'],
                'fechaUltimaCalibracion' => $equipo['fecha_ult_calib'],
                'calificacion' => $equipo['calificacion'],
                'numeroDiasAlerta' => $equipo['num_dias_alerta'],
                'InfoManteniemiento' => $equipo['info_mant'],
                'InfoManteniemiento' => $equipo['info_mant'],
                'striker' => $equipo['striker']
                
                
            ); 
            $count++;
        }
        echo json_encode($equipos);
    } else 
        echo null;
           
            
}


