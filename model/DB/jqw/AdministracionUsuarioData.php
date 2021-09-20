<?php

require '../TablaUsuariosDbModelClass.php';
require '../../DbClass.php';


$modelUsuario = new TablaUsuariosDbModelClass();
 
 
if($_GET['query'] == 'getUsuariosActivosDependencias'){
    
    $count = 1;
    $data = $modelUsuario->getUsuariosActivosDependencias();
    if($data != false){
        foreach ($data as $usuario) {
            $usuarios[] = array(
                'cantidad' => $count,
                'id' => $usuario['id'],
                'nombre' => $usuario['nombre'],
                'usuario' => $usuario['login'],
                'caduca' => $usuario['caduca'],
                'fechaCaduca' => $usuario['fecha_caduca'],
                'estado' => $usuario['estado'],
                'idPerfil' => $usuario['id_perfil'],
                'idJefe' => $usuario['id_jefe'],
                'idCargo' => $usuario['id_cargo'],
                'esJefe' => $usuario['es_jefe'],
                'email' => $usuario['email'],
                'aplicacion' => $usuario['aplicacion'],
                'bloqueado' => $usuario['bloqueado'],
                'fechaCreacion' => $usuario['fecha_creacion'],
                'ultimoIngreso' => $usuario['ultimo_ingreso'],
                'intentosFallidos' => $usuario['intentos_fallidos'],
                'idCalendario' => $usuario['id_calendario'],
                'nomPerfil' => $usuario['nom_perfil'],
                'nomCargo' => $usuario['nom_cargo'],
                'nomCalendario' => $usuario['nom_calendario']
            ); 
            $count++;
        }
        echo json_encode($usuarios);
    } else 
        echo null;
           
            
}


