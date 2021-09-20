<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaPrincipioActivoProductoDbModelClass.php';
require '../../DbClass.php';

$modelPrincipioActivoProducto = new TablaPrincipioActivoProductoDbModelClass();

if($_GET['query'] == 'getPrincipioActivoProductoByIdProducto'){
    
    
    $data = $modelPrincipioActivoProducto->getPrincipioActivoProductoByIdProducto($_GET['idProducto']);
            foreach ($data as $principioActivoProducto) {
                
                
               $principioActivoProductos[] = array(
                   'id' => $principioActivoProducto['id'],
                   'idProducto' => $principioActivoProducto['id_producto'],
                   'idPrincipioActivo' => $principioActivoProducto['id_principio_activo'],
                   'principal' => $principioActivoProducto['principal'],
                   'trasador' => $principioActivoProducto['trasador'],
                   'cantidad' => $principioActivoProducto['cantidad'],
                   'unidadCantidad' => $principioActivoProducto['unidad_cantidad'],
                   'cantidadDecimal' => $principioActivoProducto['cantidad_decimal'],
                   'nomPrincipioActivo' => $principioActivoProducto['nomPrincipioActivo']
               );
               
            }
            echo json_encode($principioActivoProductos);
}

if($_GET['query'] == 'getPrincipioActivoDisponibleByIdProducto'){
    
    
    $data = $modelPrincipioActivoProducto->getPrincipioActivoProductoDisponiblesByIdProducto($_GET['idProducto']);
            foreach ($data as $principioActivo) {
                
                
               $principioActivos[] = array(
                   'id' => $principioActivo['id'],
                   'nombre' => $principioActivo['nombre']
               );
               
            }
            echo json_encode($principioActivos);
}
