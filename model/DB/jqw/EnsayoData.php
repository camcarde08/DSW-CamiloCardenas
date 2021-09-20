<?php

require '../TablaEnsayoDbModelClass.php';
require '../../DbClass.php';


$modelEnsayo = new TablaEnsayoDbModelClass();


if($_GET['query'] == 'getAllEnsayo'){
    
    
    $data = $modelEnsayo->getAllEnsayos();
            foreach ($data as $ensayo) {
               $ensayos[] = array(
                   'id' => $ensayo['id'],
                   'precio' => $ensayo['precio_real'],
                   'tiempo' => $ensayo['tiempo'],
                   'plantilla' => $ensayo['id_plantilla'],
                   'descripcion' => $ensayo['descripcion'],
               );
               
            }
            echo json_encode($ensayos);
}

if($_GET['query'] == 'getAllEnsayoSinPaquete'){
    
    
    $data = $modelEnsayo->getAllEnsayosSinPaquetes();
            foreach ($data as $ensayo) {
               $ensayos[] = array(
                   'id' => $ensayo['id'],
                   'precio' => $ensayo['precio_real'],
                   'tiempo' => $ensayo['tiempo'],
                   'plantilla' => $ensayo['id_plantilla'],
                   'descripcion' => $ensayo['descripcion'],
                   'nombrePlantilla' => $ensayo['nombrePlantilla'],
                   
               );
               
            }
            echo json_encode($ensayos);
}



if($_GET['query'] == 'getPaquetes'){
    
    
    $data = $modelEnsayo->getPaquetes();
            foreach ($data as $ensayo) {
               $paquetes[] = array(
                   'id' => $ensayo['id'],
                   'precio' => $ensayo['precio_real'],
                   'tiempo' => $ensayo['tiempo'],
                   'plantilla' => $ensayo['id_plantilla'],
                   'descripcion' => $ensayo['descripcion'],
                   "codigo" => $ensayo["codigo"]
                   
               );
               
            }
            echo json_encode($paquetes);
}

if($_GET['query'] == 'getPaquetesDisponiblesByIdProducto'){
    
    $idProducto =  $_GET['idProducto'];
    $data = $modelEnsayo->getPaqueteDisponiblesByIdProducto($idProducto);
            foreach ($data as $paquete) {
               $paquetes[] = array(
                   'id' => $paquete['id'],
                   'idEnsayo' => $paquete['id'],
                   'precio' => $paquete['precio_real'],
                   'tiempo' => $paquete['tiempo'],
                   'plantilla' => $paquete['id_plantilla'],
                   'descripcion' => $paquete['descripcion'],
               );
               
            }
            echo json_encode($paquetes);
}

