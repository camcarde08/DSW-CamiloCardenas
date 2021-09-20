<?php

require '../../DbClass.php';
require '../TablaReportesDbModelClass.php';
if($_GET['query'] == 'getAll'){
    $viewMuestraReferenciasModel = new TablaReportesDbModelClass();
    $data = $viewMuestraReferenciasModel->getAllMuestrasEstadisticas();
    if($data != false){
        foreach ($data as $muestra) {
            $response[] = array(
                'idMuestra' => $muestra['elnum'],
                'fechaLlegada' => $muestra['fecha_llegada'],
                'lote' => $muestra['lote'],
                'cliente' => $muestra['cliente'],
                'producto' => $muestra['producto'],
                'idEnsayo' => $muestra['id_ensayo'],
                'nombreEnsayo' => $muestra['nombreensayo'],
                'ensayoEspecifico' => $muestra['desespecifica'],
                'especificacion' => $muestra['especificacion'],
                'resultado' => $muestra['resultado'],
                "resultadoNumerico" => (double)$muestra["resultado_numerico"] ,
                'conclusion' => $muestra['conclusion'],
                'obsrevision' => $muestra['obsrevision']
             );
            
        }
        echo json_encode($response);
    } else {
        echo json_encode(NULL);
    }
        
}


