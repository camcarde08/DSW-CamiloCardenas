<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaProductoEnsayoDbModelClass.php';
require '../../DbClass.php';

$modelProductoEnsayo = new TablaProductoEnsayoDbModelClass();

if($_GET['query'] == 'getProductoEnsayoByIdProducto'){
    
    $idProducto = $_GET['idProducto'];
    $data = $modelProductoEnsayo->getProductoEnsayoByIdProducto($idProducto);
            foreach ($data as $productoEnsayo) {
                
                
               $productoEnsayos[] = array(
                   'idProductoEnsayo' => $productoEnsayo['id'],
                   'idEnsayo' => $productoEnsayo['id_ensayo'],
                   'idProducto' => $productoEnsayo['id_producto'],
                   'tiempo' => $productoEnsayo['tiempo'],
                   'idMetodo' => $productoEnsayo['id_metodo'],
                   'valor' => $productoEnsayo['valor'],
                   'descripcion' => $productoEnsayo['descripcion'],
                   'especificacion' => $productoEnsayo['especificacion'],
                   'idProductoPaquete' => $productoEnsayo['id_producto_paquete'],
                   'tipoResultado' => $productoEnsayo['tipo_resultado'],
                   'metodo' => $productoEnsayo['metodo'],
                   'idPaquete' => $productoEnsayo['idPaquete'],
                   'desPaquete' => $productoEnsayo['desPaquete'],
                   'desOriginal' => $productoEnsayo['desOriginal']
               );
               
            }
            echo json_encode($productoEnsayos);
}


