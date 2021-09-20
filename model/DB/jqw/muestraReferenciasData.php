<?php

require '../../DbClass.php';
require '../ViewMuestraReferenciasDbModel.php';
require '../../../controller/UtilsController.php';



if($_GET['query'] == 'getAll'){
    $viewMuestraReferenciasModel = new ViewMuestraReferenciasDbModel();
    $data = $viewMuestraReferenciasModel->getAllMuestras();
    if($data != false){
        $utilController = new UtilsController();
        
        foreach ($data as $muestra) {
            $auxIdMuestra = $utilController->contructCerosIdMuestra().$muestra['id'];
            $response[] = array(
                'idMuestra' => $auxIdMuestra,
                'activa' => $muestra['activa'],
                'prioridad' => $muestra['prioridad'],
                'cotizacion' => $muestra['id_cotizacion'],
                'remision' => $muestra['numero_remision'],
                'producto' => $muestra['nombre_producto'],
                'tercero' => $muestra['nombre_tercero'],
                'contacto' => $muestra['nombre_contacto'],
                'informe' => $muestra['num_informe'],
                'estado' => $muestra['descripcion_estado_muestra'],
                'factura' => $muestra['num_factura'],
                'fechaLlegada' => $muestra['fecha_llegada'],
                'fechaCompromiso' => $muestra['fecha_compromiso'],
                'areaAnalisis' => $muestra['des_area_analisis'],
                'coordinador' => $muestra['des_area_analisis'],
                'lote' => $muestra['lote'],
                'complexId' => $muestra['complex_id']
                    
                
                
               
            );
            
        }
        echo json_encode($response);
    } else {
        echo json_encode(NULL);
    }
        
}



if($_GET['query'] == 'getAllEstablidadesTiempos'){
    $viewMuestraReferenciasModel = new ViewMuestraReferenciasDbModel();
    $data = $viewMuestraReferenciasModel->getAllMuestrasEstablidadesTiempos();
    if($data != false){
        foreach ($data as $muestra) {
            $response[] = array(
                'idMuestra' => $muestra['id'],
                'fechaLlegada' => $muestra['fecha_llegada'],
                'producto' => $muestra['producto'],
                'cliente' => $muestra['cliente'],
                'tipoEstabilidad' => $muestra['tipoEstabilidad'],
                'lote' => $muestra['lote'],
                'fechaProgramacion' => $muestra['fecha_referencia'],
                'tiempo' => $muestra['tiempos'],
                'tiempotemp' => $muestra['tiempotemp'],
                'estado' => $muestra['estado_ensayo']
           );
            
        }
        echo json_encode($response);
    } else {
        echo json_encode(NULL);
    }
        
}
