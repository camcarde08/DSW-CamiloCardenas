<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../ViewProductoPaquetesEnsayosDbModelClass.php';
require '../../DbClass.php';

$modelProductoPaquetesEnsayos = new ViewProductoPaquetesEnsayosDbModelClass();

if($_GET['query'] == 'ProductoPaquetesEnsayos' && $_GET['producto'] != NULL &&  $_GET['idAreaAnalisis'] != NULL){
    
     $data = $modelProductoPaquetesEnsayos->getPaquetesEnsayosByProductos($_GET['producto'],$_GET['idAreaAnalisis']);
     foreach ($data as $ProductoPaqueteEnsayo) {
         
                    if($ProductoPaqueteEnsayo['validacion'] == 1){
                        $validacion = "true";
                    } else if($ProductoPaqueteEnsayo['validacion'] == 0){
                        $validacion = "false";
                    } 
                   $ProductoPaquetesEnsayos[] = array(
                   'idEnsayoPaquete'=> $ProductoPaqueteEnsayo['idEnsayoPaquete'],
                   'descripcionPaquete' => $ProductoPaqueteEnsayo['descripcionPaquete'],
                   'areaAnalisis' => $ProductoPaqueteEnsayo['descripcionAreaAnalisis'],
                   'tiempo' => $ProductoPaqueteEnsayo['tiempo'],
                   'idEnsayo' => $ProductoPaqueteEnsayo['idEnsayo'],    
                   'desEnsayo' => $ProductoPaqueteEnsayo['descripcionEnsayo'],
                   'duracion' => $ProductoPaqueteEnsayo['duracion'],
                   'validacion'=>$validacion,
                   'idMetodo'=>$ProductoPaqueteEnsayo['id_metodo']
                       
                 );
     }
     echo json_encode($ProductoPaquetesEnsayos);
} 

if($_GET['query'] == 'NomProductoPaquetesEnsayos' && $_GET['producto'] != NULL &&  $_GET['idAreaAnalisis'] != NULL){
    
     $data = $modelProductoPaquetesEnsayos->getNomProductoPaqueteEnsayoByIdProducto($_GET['producto'],$_GET['idAreaAnalisis']);
     foreach ($data as $ProductoPaqueteEnsayo) {
         
                    $aux = 0;
                   $ProductoPaquetesEnsayos[] = array(
                       'idProducto'=> $ProductoPaqueteEnsayo['idProducto'],
                       'nomProducto'=> $ProductoPaqueteEnsayo['nombre'],
                       'idPaquete'=> $ProductoPaqueteEnsayo['idEnsayoPaquete'],
                       'nomPaquete'=> $ProductoPaqueteEnsayo['descripcionPaquete'],
                       'idEnsayo'=> $ProductoPaqueteEnsayo['idEnsayo'],
                       'nomEnsayo'=> $ProductoPaqueteEnsayo['descripcionEnsayo'],
                       'idAreaAnalisis'=> $ProductoPaqueteEnsayo['idAreaAnalisis'],
                       'nomAreaAnalisis'=> $ProductoPaqueteEnsayo['descripcionAreaAnalisis'],
                       'duracion'=> $ProductoPaqueteEnsayo['duracion'],
                       'metodo'=> $ProductoPaqueteEnsayo['metodo'],
                       'seleccione'=> $aux,
                       'valor'=> $ProductoPaqueteEnsayo['precio_real'],
                       'aprovado'=> $aux
                       
                       
                        
                  
                       
                 );
     }
     echo json_encode($ProductoPaquetesEnsayos);
} 
    
    

