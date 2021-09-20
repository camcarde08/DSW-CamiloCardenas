<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../TablaPrincipioActivoDbModelClass.php';
require '../../DbClass.php';

$modelPrincipioActivo = new TablaPrincipioActivoDbModelClass();


if($_GET['query'] == 'principioActivo' && $_GET['producto'] != NULL){
    
    
    $data = $modelPrincipioActivo->getPrincipioActivoByProducto($_GET['producto']);
            foreach ($data as $principioActivo) {
                
                    if($principioActivo['principal'] == 1){
                        $principal = "Si";
                    } else if($principioActivo['principal'] == 0){
                        $principal = "No";
                    } 
                
                
               
                    if($principioActivo['trasador'] == 1){
                        $trasador = "Si";
                    } else if($principioActivo['trasador'] == 0){
                        $trasador = "No";
                    } 
                
               $principiosActivos[] = array(
                   'nombre' => $principioActivo['nombre_principio'],
                   'principal' => $principal,
                   'trasador' => $trasador
               );
               
            }
            echo json_encode($principiosActivos);
}
