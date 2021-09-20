<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaEmpaqueDbModelClass.php';
require '../../DbClass.php';

$modelEmpaque = new TablaEmpaqueDbModelClass();


if($_GET['query'] == 'empaque'){
    
    
    $data = $modelEmpaque->getAllEmpaques();
            foreach ($data as $empaque) {
               $empaques[] = array(
                   'id' => $empaque['id'],
                   'descripcion' => $empaque['descripcion']
               );
               
            }
            echo json_encode($empaques);
}

if($_GET['query']=="crearEmpaque"&&$_GET['nuevoEmpaque']!= NULL){
    
    $modelEmpaque->insertEmpaque($_GET['nuevoEmpaque']);
    
}
