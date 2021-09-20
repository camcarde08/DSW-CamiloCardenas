<?php

require '../TablaEstCotEnsDbModelClass.php';
require '../TablaEstTiemposCotEnsDbModelClass.php';
require '../TablaProductoEnsayoDbModelClass.php';
require '../../DbClass.php';


$modelEstCotEns = new TablaEstCotEnsDbModelClass();
$modelTiemposEstCotEns = new TablaEstTiemposCotEnsDbModelClass();


if($_GET['query'] == 'selectEstCotizacionById'){
    
    
    $data = $modelEstCotEns->selectEstCotEnsByIdCotizacion($_GET['idCotizacion']);
   
    foreach ($data as $ensayo) {
       $ensayos[] = array(
           'id' => $ensayo['id'],
           'idCotizacion' => $ensayo['id_cotizacion'],
           'idPaquete' => $ensayo['id_paquete'],
           'nomPaquete' => $ensayo['nom_paquete'],
           'idEnsayo' => $ensayo['id_ensayo'],
           'nomEnsayo' => $ensayo['nom_ensayo'],
           'valor' => $ensayo['valor']
       );

    }
    for($i = 0; $i < count($ensayos); $i++){
        $tiempos = $modelTiemposEstCotEns->selectTiemposByIdEstCotEns($ensayos[$i]['id']);
        for($j = 0; $j < count($tiempos); $j++){
            $ensayos[$i][$tiempos[$j]['tiempo']] = (int)$tiempos[$j]['is_check'];
        }
        
    }
    
    
    

    echo json_encode($ensayos);
}

if ($_GET['query'] == 'GetEnsayosCotizacionToGridEstMuestra') {

    $modelProductoEnsayo = new TablaProductoEnsayoDbModelClass();
    $data = $modelEstCotEns->selectEstCotEnsByIdCotizacion($_GET['idCotizacion']);
    $idProducto = $_GET['idProducto'];

    foreach ($data as $ensayo) {
        $currentProductoEnsayo = $modelProductoEnsayo->getProductoEnsayoByProductoPaqueteEnsayo($idProducto, $ensayo['id_paquete'], $ensayo['id_ensayo']);
        $ensayos[] = array(
            'id' => $ensayo['id'],
            'idCotizacion' => $ensayo['id_cotizacion'],
            'idPaquete' => $ensayo['id_paquete'],
            'nomPaquete' => $ensayo['nom_paquete'],
            'idEnsayo' => $ensayo['id_ensayo'],
            'nomEnsayo' => $currentProductoEnsayo[0]["descripcion"],
            'duracion' => $currentProductoEnsayo[0]["tiempo"],
            'nomAreaAnalisis' => 'Estabilidad'
        );
    }
    for ($i = 0; $i < count($ensayos); $i++) {
        $tiempos = $modelTiemposEstCotEns->selectTiemposByIdEstCotEns($ensayos[$i]['id']);
        for ($j = 0; $j < count($tiempos); $j++) {
            $ensayos[$i][$tiempos[$j]['tiempo']] = (int) $tiempos[$j]['is_check'];
        }
    }




    echo json_encode($ensayos);
}



