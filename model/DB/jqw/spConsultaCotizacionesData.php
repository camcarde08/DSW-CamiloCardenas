<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../storeProcedures/SPConsultaCotizacionesDbModel.php';
require '../../DbClass.php';


$model = new SPConsultaCotizacionesDbModel();

$data = $model->spConsultaCotizaciones();
foreach ($data as $cotizacion) {
    $cotizaciones[]  = array(
        'idCotizacion' => $cotizacion['id'],
        'idEstadoCotizacion' => $cotizacion['estado'],
        'descripcionEstado' => $cotizacion['des_estado'],
        'fechaSolicitud' => $cotizacion['fecha_solicitud'],
        'fechaCompromiso' => $cotizacion['fecha_compromiso'],
        'idCliente' => $cotizacion['cliente'],
        'nombreCliente' => $cotizacion['nombre_cliente'],
        'nombreContacto' => $cotizacion['nombre_contacto'],
        'telContacto' => $cotizacion['tel_contacto'],
        'observaciones' => $cotizacion['observaciones']
    );
    
}
echo json_encode($cotizaciones);
