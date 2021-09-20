<?php

require '../TablaEnsayoMuestraDbModelClass.php';
require '../../DbClass.php';
require '../../../controller/UtilsController.php';


$EnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();


if($_GET['query'] == "updateDetalleEnsayoMuestraFromProgAnalistas"){
    $idEnsayoMuestra = $_GET['idEnsayoMuestra'];
    $duracion = $_GET['duracion'];
    $equipo = $_GET['equipo'];
    $turno = $_GET['turno'];
    $fechaProg = $_GET['fechaProg'];
    $fechaCompInterno = $_GET['fechaCompInterno'];
    $observaciones = $_GET['observaciones'];
    
    echo $EnsayoMuestraModel->updateDetalleEnsayoMuestraFromProgAnalistas($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones);
}

if($_GET['query'] == "getEnsayoMuestraByIdMuestra"){
    $idMuestra = $_GET['idMuestra'];
    
    $data = $EnsayoMuestraModel->getEnsayoMuestraByIdMuestraForConsultaHojaRuta($idMuestra);
    if($data != false){
        foreach ($data as $ensayoMuestra) {
            if($ensayoMuestra['aprobado']==1){
                    $aprobado = true;
                } else {
                    $aprobado = false;
                }
            if($ensayoMuestra["des_ensayo_est"] == ""){
                $desEnsayo = $ensayoMuestra['descripcionEnsayo'];
            } else {
                $desEnsayo = $ensayoMuestra['des_ensayo_est'];
            }
            switch ($ensayoMuestra['temperatura_est']) {
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

                default:
                    break;
            }
            $response[] = array(
                'idEnsayoMuestra' => $ensayoMuestra['id'],
                'idMuestra' => $ensayoMuestra['id_muestra'],
                'idPaquete' => $ensayoMuestra['id_paquete'],
                'idEnsayo' => $ensayoMuestra['id_ensayo'],
                'validacion' => $ensayoMuestra['validacion'],
                'areaAnalisis' => $ensayoMuestra['area_analisis'],
                'tiempo' => $ensayoMuestra['tiempo'],
                'duracion' => $ensayoMuestra['duracion'],
                'equipo' => $ensayoMuestra['equipo'],
                'turno' => $ensayoMuestra['turno'],
                'fechaProgramacion' => $ensayoMuestra['fecha_programacion'],
                'fechaCompInterno' => $ensayoMuestra['fecha_compromiso_interno'],
                'observaciones' => $ensayoMuestra['observaciones'],
                'descripcionEnsayo' => $desEnsayo,
                'descripcionPaquete' => $ensayoMuestra['descripcionPaquete'],
                'desMetodo' => $ensayoMuestra['des_metodo'],
                'desEspecifica' => $ensayoMuestra['desEspecifica'],
                'especificacion' => $ensayoMuestra['especificacion'],
                'aprobado' => $aprobado,
                'nombreAnalistaAsignado' => $ensayoMuestra['nombreAnalistaAsignado'],
                'idEstadoEnsayoMuestra' => $ensayoMuestra['estado_ensayo'],
                'nomEstadoEnsayoMuestra' => $ensayoMuestra['nom_estado_ensayo'],
                'cantidadResultados' => $ensayoMuestra['cant_resultados'],
                'idSubMuestra' => (int)$ensayoMuestra['id_sub_muestra'],
                'duracionEstabilidad' => $ensayoMuestra['duracion_est'],
                'temperaturaEstabilidad' => $temperatura,
                'especificacion_ensayo_muestra' => $ensayoMuestra['especificacion_ensayo_muestra'],

            );
        }
        echo json_encode($response);
    } else {
        echo json_encode(NULL);
    }
}

if($_GET['query'] == "getEnsayoMuestraByIdMuestraIdAnalista"){
    $idMuestra = $_GET['idMuestra'];
    $idAnalista = $_GET['idAnalista'];
    
    $data = $EnsayoMuestraModel->getEnsayoMuestraByIdMuestraIdAnalistaForConsultaHojaRuta($idMuestra, $idAnalista);
    if($data != false){
        foreach ($data as $ensayoMuestra) {
            if($ensayoMuestra['aprobado']==1){
                    $aprobado = true;
                } else {
                    $aprobado = false;
                }
            if($ensayoMuestra["des_ensayo_est"] == ""){
                $desEnsayo = $ensayoMuestra['descripcionEnsayo'];
            } else {
                $desEnsayo = $ensayoMuestra['des_ensayo_est'];
            }
            switch ($ensayoMuestra['temperatura_est']) {
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

                default:
                    break;
            }
            $response[] = array(
                'idEnsayoMuestra' => $ensayoMuestra['id'],
                'idMuestra' => $ensayoMuestra['id_muestra'],
                'idPaquete' => $ensayoMuestra['id_paquete'],
                'idEnsayo' => $ensayoMuestra['id_ensayo'],
                'validacion' => $ensayoMuestra['validacion'],
                'areaAnalisis' => $ensayoMuestra['area_analisis'],
                'tiempo' => $ensayoMuestra['tiempo'],
                'duracion' => $ensayoMuestra['duracion'],
                'equipo' => $ensayoMuestra['equipo'],
                'turno' => $ensayoMuestra['turno'],
                'fechaProgramacion' => $ensayoMuestra['fecha_programacion'],
                'fechaCompInterno' => $ensayoMuestra['fecha_compromiso_interno'],
                'observaciones' => $ensayoMuestra['observaciones'],
                'descripcionEnsayo' => $desEnsayo,
                'descripcionPaquete' => $ensayoMuestra['descripcionPaquete'],
                'desMetodo' => $ensayoMuestra['des_metodo'],
                'desEspecifica' => $ensayoMuestra['desEspecifica'],
                'especificacion' => $ensayoMuestra['especificacion'],
                'aprobado' => $aprobado,
                'nombreAnalistaAsignado' => $ensayoMuestra['nombreAnalistaAsignado'],
                'idEstadoEnsayoMuestra' => $ensayoMuestra['estado_ensayo'],
                'nomEstadoEnsayoMuestra' => $ensayoMuestra['nom_estado_ensayo'],
                'cantidadResultados' => $ensayoMuestra['cant_resultados'],
                'idSubMuestra' => (int)$ensayoMuestra['id_sub_muestra'],
                'duracionEstabilidad' => $ensayoMuestra['duracion_est'],
                'temperaturaEstabilidad' => $temperatura,
                'especificacion_ensayo_muestra' => $ensayoMuestra['especificacion_ensayo_muestra']
            );
        }
        echo json_encode($response);
    } else {
        echo json_encode(NULL);
    }
}

if($_GET['query'] == "getEnsayosCountAporbacionesGroupByMuestra"){
    
    $data = $EnsayoMuestraModel->getEnsayosCountAporbacionesGroupByMuestra();
    if($data != false){
        foreach ($data as $ensayo) {
            if($ensayo['cant_aprobado'] == null){
                $cantidadAprobado= 0;
                $porcentajeAprobacion = 0;
            } else {
                $cantidadAprobado= $ensayo['cant_aprobado']; 
               
            }
          
            if($ensayo['cant_no_aprobado'] == null){
                $cantidadNoAprobado= 0;
            } else {
                $cantidadNoAprobado= $ensayo['cant_no_aprobado'];
            }
            $porcentajeAprobacion = ($cantidadAprobado * 100)/($cantidadAprobado + $cantidadNoAprobado);
            $porcentajeAprobacion = number_format($porcentajeAprobacion,2)."%";
            $ensayos[] = array(
                'idMuestra' => $ensayo['id_muestra'],
                'cantidadTotal' => $ensayo['cantidad_total'],
                'cantidadAprobado' => $cantidadAprobado,
                'cantidadNoAprobado' => $cantidadNoAprobado,
                'porcentajeAprobacion' => $porcentajeAprobacion,
                'idProducto' => $ensayo['id_producto'],
                'nomProducto' => $ensayo['nom_producto'],
                'idTercero' => $ensayo['id_tercero'],
                'nomTercero' => $ensayo['nom_tercero'],
                'lote' => $ensayo['lote'],
                'estado' => $ensayo['estado'],
                'fcompromiso' => $ensayo['fecha_compromiso'],
                'fllegada' => $ensayo['fecha_llegada'],
                'idEstado' => $ensayo['idEstado']
                    
            );
        }
        
        echo json_encode($ensayos);
    } else {
        echo json_encode(NULL);
    }
}
if($_GET['query'] == "getMuestrasBandejaAsistente"){
    
    $data = $EnsayoMuestraModel->getMuestrasBandejaAsistente();
    if($data != false){
        foreach ($data as $ensayo) {
            if($ensayo['cant_aprobado'] == null){
                $cantidadAprobado= 0;
                $porcentajeAprobacion = 0;
            } else {
                $cantidadAprobado= $ensayo['cant_aprobado']; 
               
            }
          
            if($ensayo['cant_no_aprobado'] == null){
                $cantidadNoAprobado= 0;
            } else {
                $cantidadNoAprobado= $ensayo['cant_no_aprobado'];
            }
            $porcentajeAprobacion = ($cantidadAprobado * 100)/($cantidadAprobado + $cantidadNoAprobado);
            $porcentajeAprobacion = number_format($porcentajeAprobacion,2)."%";
            $ensayos[] = array(
                'customId' => $ensayo['customId'],
                'idMuestra' => $ensayo['id_muestra'],
                'cantidadTotal' => $ensayo['cantidad_total'],
                'cantidadAprobado' => $cantidadAprobado,
                'cantidadNoAprobado' => $cantidadNoAprobado,
                'porcentajeAprobacion' => $porcentajeAprobacion,
                'idProducto' => $ensayo['id_producto'],
                'nomProducto' => $ensayo['nom_producto'],
                'idTercero' => $ensayo['id_tercero'],
                'nomTercero' => $ensayo['nom_tercero'],
                'lote' => $ensayo['lote'],
                'estado' => $ensayo['estado'],
                'idEstado' => $ensayo['idEstado']
                    
            );
        }
        
        echo json_encode($ensayos);
    } else {
        echo json_encode(NULL);
    }
}





if($_GET['query'] == "getEnsayosWithOutProgramacionByidAreaAnalisis"){
    
    $idAreAnalisis = $_GET['idAreaAnalisis']; 
    $data = $EnsayoMuestraModel->getEnsayosWithOutProgramacionByidAreaAnalisis($idAreAnalisis);
    if($data != false){
        $utilController = new UtilsController();
        foreach ($data as $ensayo) {
           $fechaLlegada = new DateTime($ensayo['fecha_llegada']);
            $fechaLlegada = $fechaLlegada->format("d/m/Y");
            $auxIdMuestra = $utilController->constructComplexIdMuestra("-", $ensayo["customId"]);
            
            $ensayos[] = array(
                'customId' => $auxIdMuestra,
                'idMuestra' => $ensayo['id_muestra'],
                'estadoMuestra' => $ensayo['estado_muestra'],
                'fechaLlegada' => $fechaLlegada,
                'nombreTercero' => $ensayo['nombre_tercero'],
                     'producto' => $ensayo['producto'],
                     'lote' => $ensayo['lote']
            );
        }
        echo json_encode($ensayos);
    } else {
        echo json_encode(NULL);
    }
}

if($_GET['query'] == "getEnsayosCountAprobacionAndResultadosGroupByMuestra"){
    
    $data = $EnsayoMuestraModel->getEnsayosCountAprobacionAndResultadosGroupByMuestra();
    if($data != false){
        foreach ($data as $ensayo) {
            if($ensayo['cant_aprobado'] == null){
                $cantidadAprobado= 0;
                $porcentajeAprobacion = 0;
            } else {
                $cantidadAprobado= $ensayo['cant_aprobado'];
                $porcentajeAprobacion = ($cantidadAprobado * 100)/$ensayo['cantidad_total'];
            }
            $porcentajeAprobacion = number_format($porcentajeAprobacion,2)."%";
            if($ensayo['cant_no_aprobado'] == null){
                $cantidadNoAprobado= 0;
            } else {
                $cantidadNoAprobado= $ensayo['cant_no_aprobado'];
            }
            
            $ensayos[] = array(
                'customId' => $ensayo['customId'],
                'idMuestra' => $ensayo['id_muestra'],
                'cantidadTotal' => $ensayo['cantidad_total'],
                'cantidadAprobado' => $cantidadAprobado,
                'cantidadNoAprobado' => $cantidadNoAprobado,
                'porcentajeAprobacion' => $porcentajeAprobacion,
                'nomProducto' => $ensayo['nom_producto'],
                'nomTercero' => $ensayo['nom_tercero'],
                'lote' => $ensayo['lote']
            );
        }
        echo json_encode($ensayos);
    } else {
        echo json_encode(NULL);
    }
}

if($_GET['query'] == 'getBECordEst'){
    $modelEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
    $ensayosData = $modelEnsayoMuestra->getBECordEst();
    if($ensayosData != false){
        foreach ($ensayosData as $ensayo) {
            switch($ensayo["temperatura_est"]){
                case 0: $temperatura = "30ºC-65%HR"; break;
                case 1: $temperatura = "30ºC-75%HR"; break;
                case 2: $temperatura = "40ºC-75%HR"; break;
                case 3: $temperatura = "50°C-80%HR"; break;
            }
            $ensayos[]= array(
                "idMuestra" => (int) $ensayo["id_muestra"],
                "producto" => $ensayo["producto"],
                "tiempo" => $ensayo["tiempo_est"],
                "temperatura" => $temperatura,
                "lote" => $ensayo["lote"],
                "fecha" => $ensayo["fecha_referencia"]
            );
            
        }
    }
    echo json_encode($ensayos);
}

