<?php

require '../TablaEstCotizacionDbModel.php';
require '../../DbClass.php';


$modelEstCotizacion = new TablaEstCotizacionDbModel();


if ($_GET['query'] == 'getEstCotizacionById') {


    $data = $modelEstCotizacion->selectEstCotizacionById($_GET['idCotizacion']);
    foreach ($data as $cotizacion) {
        $cotizaciones[] = array(
            'id' => $cotizacion['id'],
            'estado' => $cotizacion['estado'],
            'fechaSolicitud' => $cotizacion['fecha_solicitud'],
            'fechaCompromiso' => $cotizacion['fecha_compromiso'],
            'idTercero' => $cotizacion['id_tercero'],
            'nomTercero' => $cotizacion['nom_tercero'],
            'contacto' => $cotizacion['contacto'],
            'telContacto' => $cotizacion['tel_contacto'],
            'idProducto' => $cotizacion['id_producto'],
            'nomProducto' => $cotizacion['nom_producto'],
            'tipoEstabilidad' => $cotizacion['tipo_estabilidad'],
            'observaciones' => $cotizacion['observaciones'],
            'observaciones2' => $cotizacion['onservaciones2'],
            'observaciones3' => $cotizacion['observaciones3'],
            'tiempos' => $cotizacion['tiempos'],
            'aplicaIva' => $cotizacion['aplica_iva'],
            'aplicaRetencion' => $cotizacion['aplica_retencion'],
            'nomEstado' => $cotizacion['nom_estado'],
        );
    }
    echo json_encode($cotizaciones);
}

if ($_GET['query'] == 'getAllEstCotizacion') {


    $data = $modelEstCotizacion->selectAllEstCotizaciones();
    if ($data != false) {
        foreach ($data as $cotizacion) {
            $cotizaciones[] = array(
                'id' => $cotizacion['id'],
                'estado' => $cotizacion['estado'],
                'fechaSolicitud' => $cotizacion['fecha_solicitud'],
                'fechaCompromiso' => $cotizacion['fecha_compromiso'],
                'idTercero' => $cotizacion['id_tercero'],
                'nomTercero' => $cotizacion['des_tercero'],
                'contacto' => $cotizacion['contacto'],
                'telContacto' => $cotizacion['tel_contacto'],
                'idProducto' => $cotizacion['id_producto'],
                'nomProducto' => $cotizacion['nom_producto'],
                'tipoEstabilidad' => $cotizacion['tipo_estabilidad'],
                'observaciones' => $cotizacion['observaciones'],
                'observaciones2' => $cotizacion['onservaciones2'],
                'observaciones3' => $cotizacion['observaciones3'],
                'tiempos' => $cotizacion['tiempos'],
                'desEstado' => $cotizacion['des_estado'],
                
            );
        }
    } else {
        $cotizaciones = null;
    }

    echo json_encode($cotizaciones);
}





