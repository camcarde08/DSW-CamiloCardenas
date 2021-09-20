<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaPerfilPermisoDbModelClass.php';
require '../../DbClass.php';

$modelPerfilPermiso = new TablaPerfilPermisoDbModelClass();

if($_GET['query'] == 'getPermisionsByPerfilId'){
    
    
    $data = $modelPerfilPermiso->getPermisionsByPerfilId($_GET['IdPerfil']);
    if($data != null){
        foreach($data as $permiso){
            $permisos[] = array(
                'idPermiso' => $permiso["id_permiso"]
            );     
        }
    } else {
        $permisos = null;
    }
    echo json_encode($permisos);
}
