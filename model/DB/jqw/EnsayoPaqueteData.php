<?php

require '../TablaEnsayoPaqueteDbModelClass.php';
require '../../DbClass.php';


$modelEnsayoPaquete = new TablaEnsayoPaqueteDbModelClass();

if($_GET['query'] == 'getEnsayosDisponiblesByIdPaquete'){
    
    $idPaquete = $_GET['idPaquete'];
    $data = $modelEnsayoPaquete->getEnsayosDisponiblesByIdPaquete($idPaquete);
            foreach ($data as $ensayo) {
               $ensayos[] = array(
                   'idEnsayo' => $ensayo['id'],
                   'desEnsayo' => $ensayo['descripcion'],
                   'tiempoEnsayo' => $ensayo['tiempo']
               );
               
            }
            echo json_encode($ensayos);
}

if($_GET['query'] == 'getEnsayosPaqueteByIdPaquete'){
    
    $idPaquete = $_GET['idPaquete'];
    $data = $modelEnsayoPaquete->getEnsayosPaquetesByIdPaquete($idPaquete);
            foreach ($data as $ensayoPaquete) {
               $ensayosPaquete[] = array(
                   'idEnsayoPaquete' => $ensayoPaquete['id'],
                   'idPaquete' => $ensayoPaquete['id_paquete'],
                   'idEnsayo' => $ensayoPaquete['id_ensayo'],
                   'valorPaquete' => $ensayoPaquete['valor_paquete'],
                   'desEnsayo' => $ensayoPaquete['descripcion'],
                   'tiempoEnsayo' => $ensayoPaquete['tiempo']
               );
               
            }
            echo json_encode($ensayosPaquete);
}

if($_GET['query'] == 'getPaquetes'){
    
    
    $data = $modelEnsayo->getPaquetes();
            foreach ($data as $paquete) {
               $paquetes[] = array(
                   'id' => $paquete['id'],
                   'descripcion' => $paquete['descripcion'],
                   'tiempo' => $paquete['tiempo'],
               );
               
            }
            echo json_encode($paquetes);
}

