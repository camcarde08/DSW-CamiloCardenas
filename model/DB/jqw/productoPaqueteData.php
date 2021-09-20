<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaProductoPaqueteDBModelClass.php';
require '../../DbClass.php';

$modelProductoPaquete = new TablaProductoPaqueteDBModelClass();

if($_GET['query'] == 'getProductoPaqueteByIdProducto'){
    
    $idProducto = $_GET['idProducto'];
    $data = $modelProductoPaquete->getAllProductoPaquete($idProducto);
            foreach ($data as $productoPaquete) {
                
                
               $productoPaquetes[] = array(
                   'idProductoPaquete' => $productoPaquete['id'],
                   'idProducto' => $productoPaquete['id_producto'],
                   'idEnsayo' => $productoPaquete['id_ensayo'],
                   'nomProducto' => $productoPaquete['producto'],
                   'nomEnsayo' => $productoPaquete['ensayo']
               );
               
            }
            echo json_encode($productoPaquetes);
}


