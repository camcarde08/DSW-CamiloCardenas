<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaProductoDBModelClass.php';
require '../../DbClass.php';

$modelProducto = new TablaProductoDBModelClass();

if($_GET['query'] == 'producto'){
    
    
    $data = $modelProducto->getAllProducto();
            foreach ($data as $producto) {
                if($producto['tipoProducto'] == 1){
                    $tipoProducto = "Materia Prima";
                } else if($producto['tipoProducto'] == 2){
                    $tipoProducto = "Producto en proceso";
                } else if($producto['tipoProducto'] == 3){
                    $tipoProducto = "Producto terminado";
                }
                
               $productos[] = array(
                   'id' => $producto['idProducto'],
                   'nombre' => $producto['nombreProducto'],
                   'id_formula_farma' => $producto['idFormulaFarmaceutica'],
                   'des_formula_farma' => $producto['descripcionFormula'],
                   'tipoProducto' => $tipoProducto
               );
               
            }
            echo json_encode($productos);
}

if($_GET['query'] == 'todos'){
    
    
    $data = $modelProducto->getTodosProducto();
            foreach ($data as $producto) {
                if($producto['tipoProducto'] == 1){
                    $tipoProducto = "Materia Prima";
                } else if($producto['tipoProducto'] == 2){
                    $tipoProducto = "Producto en proceso";
                } else if($producto['tipoProducto'] == 3){
                    $tipoProducto = "Producto terminado";
                }
                
               $productos[] = array(
                   'id' => $producto['idProducto'],
                   'nombre' => $producto['nombreProducto'],
                   'tecnica' => $producto['tecnicaProducto'],
                   'tiempoEntrega' => $producto['tiempoEntregaProducto'],
                   'idFormulaFarma' => $producto['idFormulaFarmaceutica'],
                   'desFormulaFarma' => $producto['descripcionFormula'],
                   'idTipoProducto' => $producto['tipoProducto'],
                   'tipoProducto' => $tipoProducto,
                   'activo' => $producto['estadoProducto'],
               );
               
            }
            echo json_encode($productos);
}
