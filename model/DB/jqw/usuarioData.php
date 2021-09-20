<?php

require '../TablaUsuariosDbModelClass.php';
require '../TablaSystemParametersDbModelClass.php';
require '../../DbClass.php';

if($_GET['query'] == 'getAllAnalistas'){
    $usuarioModel = new TablaUsuariosDbModelClass();
    $data = $usuarioModel->getAllAnalistas();
    if($data != false){
        foreach ($data as $analista) {
            $response[] = array(
                'id' => $analista['id'],
                'nombre' => $analista['nombre']
            );
        }
    } else {
        $response = null;
    }
    echo json_encode($response);
}

if($_GET['query'] == 'getAnalistasProgramables'){
    
    $tablaSystemParameters = new TablaSystemParametersDbModelClass();
    $result = $tablaSystemParameters->getSystemParameterByPropiedad("perfilesProgramableFisicoQuimico");
    $idsAnalistas = explode(",", $result["data"]["valor"]);
    
    $usuarioModel = new TablaUsuariosDbModelClass();
    $data = $usuarioModel->getAnalistasProgramables($idsAnalistas);
    if($data != false){
        foreach ($data as $analista) {
            $response[] = array(
                'id' => $analista['id'],
                'nombre' => $analista['nombre']
            );
        }
    } else {
        $response = null;
    }
    echo json_encode($response);
}

if($_GET['query'] == 'getCalendarIdByUserId'){
    $usuarioModel = new TablaUsuariosDbModelClass();
    $data = $usuarioModel->getCalendarIdByUserId($_GET['userId']);
    if($data != false){
        foreach ($data as $analista) {
            $response[] = array(
                'idCalendario' => $analista['id_calendario'],
            );
        }
    } else {
        $response = null;
    }
    echo json_encode($response);
}

if($_GET['query'] == 'getAllUsuario'){
    $usuarioModel = new TablaUsuariosDbModelClass();
    $data = $usuarioModel->getAllUsuario();
    if($data != false){
        foreach ($data as $unUsuario) {
            $response[] = array(
                'id' => $unUsuario['id'],
                'nombre' => $unUsuario['nombre'],
                'usuario' => $unUsuario['login'],
                'caduca' => $unUsuario['caduca'],
                'fecha_caduca' => $unUsuario['fecha_caduca'],
                'estado' => $unUsuario['estado'],
                'id_perfil' => $unUsuario['id_perfil'],
                'id_jefe' => $unUsuario['id_jefe'],
                'id_cargo' => $unUsuario['id_cargo'],
                'es_jefe' => $unUsuario['es_jefe'],
                'email' => $unUsuario['email'],
                'aplicacion' => $unUsuario['aplicacion'],
                'bloqueado' => $unUsuario['bloqueado'],
                'fecha_creacion' => $unUsuario['fecha_creacion'],
                'ultimo_ingreso' => $unUsuario['ultimo_ingreso'],
                'intentos_fallidos' => $unUsuario['intentos_fallidos'],
                'id_calendario' => $unUsuario['id_calendario'],
            );
        }
    } else {
        $response = null;
    }
    echo json_encode($response);
}

