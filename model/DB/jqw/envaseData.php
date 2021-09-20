<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaEnvaseDbModelClass.php';
require '../../DbClass.php';

$modelEnvase= new TablaEnvaseDbModelClass();


if($_GET['query'] == 'envase'){
    
    
    $data = $modelEnvase->getAllEnvase();
            foreach ($data as $envase) {
               $envases[] = array(
                   'id' => $envase['id'],
                   'descripcion' => $envase['descripcion']
               );
               
            }
            echo json_encode($envases);
}

if($_GET['query']=="crearEnvase"&&$_GET['nuevoEnvase']!= NULL){
    
    $modelEnvase->insertEnvase($_GET['nuevoEnvase']);
    
}