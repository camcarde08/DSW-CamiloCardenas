<?php

require '../TablaCotProEnsayoDbModelClass.php';
require '../../DbClass.php';


$modelCotProEnsayo = new TablaCotProEnsayoDbModelClass();


if($_GET['query'] == 'getEnsayosByIdCotizacion'){
    
    
    $data = $modelCotProEnsayo->getEnsayosByidCotizacion($_GET['idCotizacion']);
            foreach ($data as $ensayo) {
               $ensayos[] = array(
                   'idProducto' => $ensayo['id_producto'],
                   'nomProducto' => $ensayo['nombre_producto'],
                   'idPaquete' => $ensayo['id_paquete'],
                   'nomPaquete' => $ensayo['nombre_paquete'],
                   'idEnsayo' => $ensayo['id_ensayo'],
                   'nomEnsayo' => $ensayo['nombre_ensayo'],
                   'idAreaAnalisis' => $ensayo['id_area_analisis'],
                   'nomAreaAnalisis' => $ensayo['nombre_area_analisis'],
                   'duracion' => $ensayo['duracion'],
                   'seleccione' => $ensayo['seleccion'],
                   'valor' => $ensayo['valor'],
                   'metodo' => $ensayo['metodo'],
                   'aprovado' => $ensayo['aprobado']
               );
               
            }
            echo json_encode($ensayos);
}

