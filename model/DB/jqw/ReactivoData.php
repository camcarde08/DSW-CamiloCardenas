<?php

require '../TablaReactivoDbModelClass.php';
require '../../DbClass.php';


$modelReactivo = new TablaReactivoDbModelClass();


if($_GET['query'] == 'all'){
    
    
    $data = $modelReactivo->getAllReactivo();
            foreach ($data as $estandar) {
               $reactivos[] = array(
                   'id' => $estandar['id'],
                   'nombre' => $estandar['nombre'],
                   'lote' => $estandar['lote'],
                   'cantidad' => $estandar['cantidad'],
                   'fecVencimiento' => $estandar['fecha_vencimiento'],
                   'activo' => $estandar['activo'],
                   'tipo' => $estandar['tipo'],
                   'cantidadActual' => $estandar['cantidad_actual'],
                   'stock' => $estandar['stock'],
                   'fechaIngreso' => $estandar['fecha_ingreso'],
                   'fechaApertura' => $estandar['fecha_apertura'],
                   'fechaTerminacion' => $estandar['fecha_terminacion'],
                   'lote_interno' => $estandar['lote_interno'],
                   'fecha_pase' => $estandar['fecha_pase'],
               );
               
            }
            echo json_encode($reactivos);
}