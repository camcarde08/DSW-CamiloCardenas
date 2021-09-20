<?php

require_once '../TablaCalendarioBaseDbModelClass.php';
require_once '../../DbClass.php';

if($_GET['query']== 'getCalendarioById'){
    $tablaCalendarioModel = new TablaCalendarioBaseDbModelClass();
    $data = $tablaCalendarioModel->getCalendarioById($_GET['idCalendario']);
    if(data != false){
        foreach ($data as $calendario) {
            $calendarios[] = array (
                'id' => $calendario['id'],
                'nombre' => $calendario['nombre'],
                'descripcion' => $calendario['descripcion'],
                'trabajaLunes' => $calendario['tarabaja_lunes'],
                'inicioLunes' => $calendario['inicio_lunes'],
                'finLunes' => $calendario['fin_lunes'],
                'jornadaLunes' => $calendario['jornada_lunes'],
                'trabajaMartes' => $calendario['tarabaja_martes'],
                'inicioMartes' => $calendario['inicio_martes'],
                'finMartes' => $calendario['fin_martes'],
                'jornadaMartes' => $calendario['jornada_martes'],
                'trabajaMiercoles' => $calendario['tarabaja_miercoles'],
                'inicioMiercoles' => $calendario['inicio_miercoles'],
                'finMiercoles' => $calendario['fin_miercoles'],
                'jornadaMiercoles' => $calendario['jornada_miercoles'],
                'trabajaJueves' => $calendario['tarabaja_jueves'],
                'inicioJueves' => $calendario['inicio_jueves'],
                'finJueves' => $calendario['fin_jueves'],
                'jornadaJueves' => $calendario['jornada_jueves'],
                'trabajaViernes' => $calendario['tarabaja_viernes'],
                'inicioViernes' => $calendario['inicio_viernes'],
                'finViernes' => $calendario['fin_viernes'],
                'jornadaViernes' => $calendario['jornada_viernes'],
                'trabajaSabado' => $calendario['tarabaja_sabado'],
                'inicioSabado' => $calendario['inicio_sabado'],
                'finSabado' => $calendario['fin_sabado'],
                'jornadaSabado' => $calendario['jornada_sabado'],
                'trabajaDomingo' => $calendario['tarabaja_domingo'],
                'inicioDomingo' => $calendario['inicio_domingo'],
                'jornadaDomingo' => $calendario['jornada_domingo'],
                'finDomingo' => $calendario['fin_domingo']
            );
        }
        $response = $calendarios;
    } else {
        $response = null;
    }
    echo json_encode($response);
}

if($_GET['query']== 'getAllCalendario'){
    $tablaCalendarioModel = new TablaCalendarioBaseDbModelClass();
    $data = $tablaCalendarioModel->getAllCalendario();
    if(data != false){
        foreach ($data as $calendario) {
            $calendarios[] = array (
                'id' => $calendario['id'],
                'nombre' => $calendario['nombre'],
                'descripcion' => $calendario['descripcion'],
                'trabajaLunes' => $calendario['tarabaja_lunes'],
                'inicioLunes' => $calendario['inicio_lunes'],
                'finLunes' => $calendario['fin_lunes'],
                'jornadaLunes' => $calendario['jornada_lunes'],
                'trabajaMartes' => $calendario['tarabaja_martes'],
                'inicioMartes' => $calendario['inicio_martes'],
                'finMartes' => $calendario['fin_martes'],
                'jornadaMartes' => $calendario['jornada_martes'],
                'trabajaMiercoles' => $calendario['tarabaja_miercoles'],
                'inicioMiercoles' => $calendario['inicio_miercoles'],
                'finMiercoles' => $calendario['fin_miercoles'],
                'jornadaMiercoles' => $calendario['jornada_miercoles'],
                'trabajaJueves' => $calendario['tarabaja_jueves'],
                'inicioJueves' => $calendario['inicio_jueves'],
                'finJueves' => $calendario['fin_jueves'],
                'jornadaJueves' => $calendario['jornada_jueves'],
                'trabajaViernes' => $calendario['tarabaja_viernes'],
                'inicioViernes' => $calendario['inicio_viernes'],
                'finViernes' => $calendario['fin_viernes'],
                'jornadaViernes' => $calendario['jornada_viernes'],
                'trabajaSabado' => $calendario['tarabaja_sabado'],
                'inicioSabado' => $calendario['inicio_sabado'],
                'finSabado' => $calendario['fin_sabado'],
                'jornadaSabado' => $calendario['jornada_sabado'],
                'trabajaDomingo' => $calendario['tarabaja_domingo'],
                'inicioDomingo' => $calendario['inicio_domingo'],
                'jornadaDomingo' => $calendario['jornada_domingo'],
                'finDomingo' => $calendario['fin_domingo']
            );
        }
        $response = $calendarios;
    } else {
        $response = null;
    }
    echo json_encode($response);
}

