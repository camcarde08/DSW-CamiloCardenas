<?php

require '../TablaEstandarDbModelClass.php';
require '../../DbClass.php';


$modelEstandar = new TablaEstandarDbModelClass();


if($_GET['query'] == 'all'){
    
    
    $data = $modelEstandar->getAllEstandares();
            foreach ($data as $estandar) {
               $estandares[] = array(
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
                   'loteInterno' => $estandar['lote_interno'],
                   'fechaPreparacion' => $estandar['fecha_preparacion'],
                   'fechaPromocion' => $estandar['fecha_promocion'],
                   'cantidadPreparada' => $estandar['cantidad_preparada'],
                   'codigo' => $estandar['codigo'],
               );
               
            }
            echo json_encode($estandares);
}

