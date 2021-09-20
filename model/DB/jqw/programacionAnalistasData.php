<?php

require '../TablaProgramacionAnalistasDbModelClass.php';
require '../../DbClass.php';

$tablaProgramacionAnalistasDbModel = new TablaProgramacionAnalistasDbModelClass();

if($_GET['query']=='getProgramacionByIdMuestraAndIdAnalista'){
    
    $response = $tablaProgramacionAnalistasDbModel->getProgramacionByIdMuestraAndIdAnalista($_GET['idMuestra'], $_GET['idAnalista']);
    if($response != false){
        foreach ($response as $ensayoMuestra) {
            if($ensayoMuestra['des_ensayo_est']!= ""){
                $descripcionEnsayo = $ensayoMuestra['des_ensayo_est'];
            } else {
                $descripcionEnsayo = $ensayoMuestra['desEspecifica'];
            }
            $ensayos[] = array(
                'idEnsayoMuestra' => $ensayoMuestra['id_ensayo_muestra'],
                'idAnalista' => $ensayoMuestra['id_analista'],
                'idEnsayo' => $ensayoMuestra['id_ensayo'],
                'desEnsayo' => $descripcionEnsayo,
                'duracion' => $ensayoMuestra['duracion'],
                'equipo' => $ensayoMuestra['equipo'],
                'turno' => $ensayoMuestra['turno'],
                'fechaProg' => $ensayoMuestra['fecha_programacion'],
                'fechaCompInterno' => $ensayoMuestra['fecha_compromiso_interno'],
                'observaciones' => $ensayoMuestra['observaciones'],
                'idPaquete' => $ensayoMuestra['id_paquete'],
                'desPaquete' => $ensayoMuestra['descripcion_paquete'],
                'idMuestra' => $ensayoMuestra['id_muestra'],
                'desEquipo' => $ensayoMuestra['descripcion_equipo'],
                'refEquipo' => $ensayoMuestra['referencia_equipo'],
                'aprobado' => $ensayoMuestra['aprobado'],
                'idEstado' => $ensayoMuestra['estado_ensayo'],
                'analizar_tercero' => $ensayoMuestra['analizar_tercero']
           );
        }
    } else {
        $ensayos = NULL;
    }
    echo json_encode($ensayos);  
}

if($_GET['query']=='getProgramacionByIdAnalistaAndRangeTime'){
    
    $response = $tablaProgramacionAnalistasDbModel->getProgramacionByIdAnalistaAndRangeTime($_GET['idAnalista'], $_GET['stratDate'], $_GET['endDate']);
    if($response != false){
        foreach ($response as $fecha) {
            $fechas[] = array(
                'fecha' => $fecha['fecha'],
                'tiempoProgramado' => $fecha['tiempo_programado']
           );
        }
    } else {
        $fechas = NULL;
    }
    echo json_encode($fechas);  
}

if($_GET['query']=='getProgramacionByIdAnalistaOnDate'){
    $response = $tablaProgramacionAnalistasDbModel->getProgramacionByIdAnalistaOnDate($_GET['idAnalista'], $_GET['onDate']);
    if($response != false){
        foreach ($response as $programacion) {
            $fechaProgramada = new DateTime($programacion['fecha_programada']);
            $fechaProgramada = $fechaProgramada->format("d/m/Y");
            
            $fechaProgEnsayo = new DateTime($programacion['fecha_programacion']);
            $fechaProgEnsayo = $fechaProgEnsayo->format("d/m/Y");
            
            $fechaCompInterno = new DateTime($programacion['fecha_compromiso_interno']);
            $fechaCompInterno = $fechaCompInterno->format("d/m/Y");
            $programaciones[] = array(
                'id' => $programacion['idProgramacion'],
                'fechaProgramada' => $fechaProgramada,
                'duracionActividad' => $programacion['duracion_programada'],
                'idMuestra' => $programacion['id_muestra'],
                'idEnsayo' => $programacion['id_ensayo'],
                'desEnsayo' => $programacion['desEnsayo'],
                'idPaquete' => $programacion['id_paquete'],
                'desPaquete' => $programacion['desPaquete'],
                'fechaProgramacionEnsayo' => $fechaProgEnsayo,
                'fechaCompInternoEnsayo' => $fechaCompInterno,
                'duracion' => $programacion['duracion'],
                'idEquipo' => $programacion['idEquipo'],
                'desEquipo' => $programacion['desEquipo'],
                'idAreaAnalisis' => $programacion['idAreaAnalisis'],
                'desAreaAnalisis' => $programacion['desAreaAnalisis'],
                'tipoEstabilidad' => $programacion['tipo_estabilidad'],
                'idProgramador' => $programacion['idProgramador'],
                'nomProgramador' => $programacion['nomProgramador'],
                'aprobadoEnsMue' => $programacion['aprobadoEnsMue'],
                'idEnsayoMuestra' => $programacion['id_ensayo_muestra']
           );
        }
    } else {
        $programaciones = NULL;
    }
    echo json_encode($programaciones);
}

if($_GET['query']=='getBeAnalistaByIdAnalista'){
    $response = $tablaProgramacionAnalistasDbModel->getBeAnalistaByIdAnalista($_GET['idAnalista']);
    if($response != false){
        foreach ($response as $ensayo) {
            $fechaProgramacion = new DateTime($ensayo['fecha_programacion']);
            $fechaProgramacion = $fechaProgramacion->format("d/m/Y");
            
            $fechaCompInterno = new DateTime($ensayo['fecha_compromiso_interno']);
            $fechaCompInterno = $fechaCompInterno->format("d/m/Y");
            $ensayos[] = array(
                'customId' => $ensayo['customId'],
                'muestra' => $ensayo['id_muestra'],
                'idPaquete' => $ensayo['id_paquete'],
                'desPaquete' => $ensayo['des_paquete'],
                'idEnsayo' => $ensayo['id_ensayo'],
                'desEnsayo' => $ensayo['des_ensayo'],
                'desEspecifica' => $ensayo['desEspecifica'],
                'fechaProgramada' => $fechaProgramacion,
                'fechaCompInternoEnsayo' => $fechaCompInterno,
                'idTercero' => $ensayo['id_tercero'],
                'nomTercero' => $ensayo['nombre'],
                'desAreaAnalisis' => $ensayo['des_area'],
                'tipoEstabilidad' => $ensayo['tipo_estabilidad'],
                'idEquipo' => $ensayo['equipo'],
                'desEquipo' => $ensayo['des_equipo'],
                'turno' => $ensayo['turno'],
                'duracion' => $ensayo['duracion'],
                'observaciones' => $ensayo['observaciones'],
                'especificacionEnsayoMuestra' => $ensayo['especificacion_ensayo_muestra'],
                'nombreProducto' => $ensayo['nombre_producto'],
                'numeroLote' => $ensayo['numero_lote'],
                
                
           );
        }
    } else {
        $ensayos = NULL;
    }
    echo json_encode($ensayos);
}

