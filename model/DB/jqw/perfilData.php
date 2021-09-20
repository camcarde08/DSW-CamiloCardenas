<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaPerfilDbModelClass.php';
require '../../DbClass.php';

$modelPerfil = new TablaPerfilDbModelClass();

if($_GET['query'] == 'getAllPerfil'){
    
    
    $data = $modelPerfil->getAllPerfil();
    if($data != null){
        foreach($data as $perfil){
            $perfiles[] = array(
                'id' => $perfil["id"],
                'nombre' => $perfil["nombre"],
                'estado' => $perfil["estado"],
            );     
        }
    } else {
        $perfiles = null;
    }
    echo json_encode($perfiles);
}
