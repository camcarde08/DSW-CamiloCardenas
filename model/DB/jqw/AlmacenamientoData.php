<?php

require '../TablaAlmacenamientoDbModelClass.php';
require '../../DbClass.php';


$modelAlmacenamiento = new TablaAlmacenamientoDbModelClass();
 
 
if($_GET['query'] == 'getAlmacenamientoByIdMuestra'){
    
    
    $data = $modelAlmacenamiento->getAlmacenamientosByIdMuestra($_GET['idMuestra']);
           foreach ($data as $almacenamiento) {
               
               $almacenamientos[] = array(
                   'id' => $almacenamiento['id'],
                   'idMuestra' => $almacenamiento['id_muestra'],
                   'idUbicacion' => $almacenamiento['id_ubicacion'],
                   'desUbicacion' => $almacenamiento['desUbicacion'],
                   'idTipoAlmacen' => $almacenamiento['id_tipo_almacenamiento'],
                   'desTipoAlmacen' => $almacenamiento['desTipoAlmacen'],
                   'fecha' => $almacenamiento['fecha'],
                   'nivel' => $almacenamiento['nivel'],
                   'tiempo' => $almacenamiento['tiempo'],
                   'caja' => $almacenamiento['caja']
               );
               
            }
            echo json_encode($almacenamientos);
}

