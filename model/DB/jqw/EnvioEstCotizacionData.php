<?php

require '../TablaEnvioEstCotizacionDbModelClass.php';
require '../../DbClass.php';


$modelEnvioCotizacion = new TablaEnvioEstCotizacionDbModelClass();


if($_GET['query'] == 'getEnvioEstCotizacionByIdCotizacion'){
    
    
    $data = $modelEnvioCotizacion->getEnvioCotizacionByIdCotizacion($_GET['idCotizacion']);
            foreach ($data as $envio) {
               $envios[] = array(
                   'id' => $envio['id'],
                   'idCotizacion' => $envio['id_cotizacion'],
                   'destino' => $envio['destino'],
                   'medio' => $envio['medio'],
                   'observaciones' => $envio['observaciones'],
                   'fecha' => $envio['fecha']
               );
            }
            echo json_encode($envios);
}

