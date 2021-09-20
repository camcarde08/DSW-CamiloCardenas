<?php

require '../ViewEnsayoMuestraReferenciasDbModelClass.php';
require '../../DbClass.php';

if($_GET['query'] == 'GetEnsayoMuestraByIdMuestra'){
    $modelEnsayoMuestra = new ViewEnsayoMuestraReferenciasDbModelClass();
    $data = $modelEnsayoMuestra->getEnsayoMuestraByIdMuestra($_GET['idMuestra']);
    foreach ($data as $ensayoMuestra) {
            $response[] = array(
                'id_muestra' => $ensayoMuestra['id_muestra'],
                'idEnsayoPaquete' => $ensayoMuestra['id_paquete'],
                'idEnsayo' => $ensayoMuestra['id_ensayo'],
                'validacion' => $ensayoMuestra['validacion'],
                'areaAnalisis' => $ensayoMuestra['area_analisis'],
                'tiempo' => $ensayoMuestra['tiempo'],
                'duracion' => $ensayoMuestra['duracion'],
                'descripcionPaquete' => $ensayoMuestra['des_paquete'],
                'desEnsayo' => $ensayoMuestra['desEspecifica'],
                'idMetodo' => $ensayoMuestra['id_metodo']
                
            );
    
    }
     echo json_encode($response);
}

if($_GET['query'] == 'GetEnsayoMuestraActivosByIdMuestra'){
    $modelEnsayoMuestra = new ViewEnsayoMuestraReferenciasDbModelClass();
    $data = $modelEnsayoMuestra->getEnsayoMuestraActivosByIdMuestraAndEstadoEnsayo($_GET['idMuestra'],$_GET['estadoEnsayo']);
    foreach ($data as $ensayoMuestra) {
        $d1= new DateTime($ensayoMuestra['fecha_programacion']);
        if($ensayoMuestra['area_analisis'] != "Estabilidad"){
            $descripcionEnsayo = $ensayoMuestra['desEspecifica'];
            $print = true;
        } else {
            $descripcionEnsayo = $ensayoMuestra['des_ensayo_est'];
            //$currentDate = new DateTime();
            //$fechaProgramacion = new DateTime($ensayoMuestra['fecha_programacion']);
            switch($ensayoMuestra['temperatura_est']){
                case 0:
                    $temperatura = "30ºC-65%HR";
                    break;
                case 1:
                    $temperatura = "30ºC-75%HR";
                    break;
                case 2:
                    $temperatura = "40ºC-75%HR";
                    break;
                case 3:
                    $temperatura = "50°C-80%HR";
                    break;
            }
            $print = true;
        }
        
        if($print == true){
            $response[] = array(
                'id' => $ensayoMuestra['id'],
                'id_muestra' => $ensayoMuestra['id_muestra'],
                'idEnsayoPaquete' => $ensayoMuestra['id_paquete'],
                'idEnsayo' => $ensayoMuestra['id_ensayo'],
                'validacion' => $ensayoMuestra['validacion'],
                'areaAnalisis' => $ensayoMuestra['area_analisis'],
                'tiempo' => $ensayoMuestra['tiempo'],
                'duracion' => $ensayoMuestra['duracion'],
                'descripcionPaquete' => $ensayoMuestra['des_paquete'],
                'desEnsayo' => $ensayoMuestra['desEspecifica'],
                'equipo' => $ensayoMuestra['equipo'],
                'turno' => $ensayoMuestra['turno'],
                'fechaProg' => $d1->format('Y-m-d'),
                //'fechaProg' => "prueba",
                'fechaComInterno' => $ensayoMuestra['fecha_compromiso_interno'],
                'observaciones' => $ensayoMuestra['observaciones'],
                'idSubMuestra' => (int)$ensayoMuestra['id_sub_muestra'],
                'duracionEstabilidad' => $ensayoMuestra['duracion_est'],
                'temperaturaEstabilidad' => $temperatura,
                'especificacion' => $ensayoMuestra['especificacion'],
                'analizar_tercero' => $ensayoMuestra['analizar_tercero']
            );
        }
    }
     echo json_encode($response);
}

if($_GET['query'] == 'GetEnsayoMuestraActivosByIdMuestra2'){
    $modelEnsayoMuestra = new ViewEnsayoMuestraReferenciasDbModelClass();
    $data = $modelEnsayoMuestra->getEnsayoMuestraActivosByIdMuestraAndEstadoEnsayo2($_GET['idMuestra'],$_GET['estadoEnsayo']);
    foreach ($data as $ensayoMuestra) {
        $d1= new DateTime($ensayoMuestra['fecha_programacion']);
        if($ensayoMuestra['area_analisis'] != "Estabilidad"){
            $descripcionEnsayo = $ensayoMuestra['desEspecifica'];
            $print = true;
        } else {
            $descripcionEnsayo = $ensayoMuestra['des_ensayo_est'];
            //$currentDate = new DateTime();
            //$fechaProgramacion = new DateTime($ensayoMuestra['fecha_programacion']);
            switch($ensayoMuestra['temperatura_est']){
                case 0:
                    $temperatura = "30ºC-65%HR";
                    break;
                case 1:
                    $temperatura = "30ºC-75%HR";
                    break;
                case 2:
                    $temperatura = "40ºC-75%HR";
                    break;
                case 3:
                    $temperatura = "50°C-80%HR";
                    break;
            }
            $print = true;
        }

        if($print == true){
            $response[] = array(
                'id' => $ensayoMuestra['id'],
                'id_muestra' => $ensayoMuestra['id_muestra'],
                'idEnsayoPaquete' => $ensayoMuestra['id_paquete'],
                'idEnsayo' => $ensayoMuestra['id_ensayo'],
                'validacion' => $ensayoMuestra['validacion'],
                'areaAnalisis' => $ensayoMuestra['area_analisis'],
                'tiempo' => $ensayoMuestra['tiempo'],
                'duracion' => $ensayoMuestra['duracion'],
                'descripcionPaquete' => $ensayoMuestra['des_paquete'],
                'desEnsayo' => $ensayoMuestra['desEspecifica'],
                'equipo' => $ensayoMuestra['equipo'],
                'turno' => $ensayoMuestra['turno'],
                'fechaProg' => $d1->format('Y-m-d'),
                //'fechaProg' => "prueba",
                'fechaComInterno' => $ensayoMuestra['fecha_compromiso_interno'],
                'observaciones' => $ensayoMuestra['observaciones'],
                'idSubMuestra' => (int)$ensayoMuestra['id_sub_muestra'],
                'duracionEstabilidad' => $ensayoMuestra['duracion_est'],
                'temperaturaEstabilidad' => $temperatura,
                'especificacion' => $ensayoMuestra['especificacion'],
                'analizar_tercero' => $ensayoMuestra['analizar_tercero']
            );
        }
    }
    echo json_encode($response);
}


