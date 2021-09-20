<?php

require '../TablaCotizacionDbModelClass.php';
require '../../DbClass.php';


$modelCotizacion = new TablaCotizacionDbModelClass();


if($_GET['query'] == 'getCotizacionById'){
    
    
    $data = $modelCotizacion->getCotizacionById($_GET['idCotizacion']);
            foreach ($data as $cotizacion) {
               $cotizaciones[] = array(
                   'id' => $cotizacion['id'],
                   'estado' => $cotizacion['estado'],
                   'fecSolicitud' => $cotizacion['fechaSol'],
                   'fecCompromiso' => $cotizacion['fechaCom'],
                   'idCliente' => $cotizacion['cliente'],
                   'nombreCliente' => $cotizacion['nombre'],
                   'nombreContacto' => $cotizacion['nombre_contacto'],
                   'telContacto' => $cotizacion['tel_contacto'],
                   'observaciones' => $cotizacion['observaciones'],
                   'observacionesFin' => $cotizacion['observacionesFin'],
                   'aplicaIva' => $cotizacion['aplica_iva'],
                   'aplicaRetencion' => $cotizacion['aplica_retencion']
               );
               
            }
            echo json_encode($cotizaciones);
}

