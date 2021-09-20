<?php

require '../TablaCotizacionProductoDbModelClass.php';
require '../../DbClass.php';


$modelCotizacionProducto = new TablaCotizacionProductoDbModelClass();


if($_GET['query'] == 'getProductosByIdCotizacion'){
    
    
    $data = $modelCotizacionProducto->getProductsByIdCotizacion($_GET['idCotizacion']);
            foreach ($data as $producto) {
               $productos[] = array(
                   'idProducto' => $producto['id'],
                   'nomProducto' => $producto['nombre'],
                   'idAreaAnalisis' => $producto['id_area_analisis'],
                   'nomAreaAnalisis' => $producto['nom_area']
               );
               
            }
            echo json_encode($productos);
}

