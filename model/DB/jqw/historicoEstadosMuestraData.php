<?php

require '../TablaHistoricoEstadoMuestraDbModelClass.php';
require '../../DbClass.php';



if($_GET['query'] == 'getHistoricoEstadosMuestraByIdMuestra'){
    $idMuestra = $_GET['idMuestra'];
    $tablaHistoricoEstadosMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
    $data = $tablaHistoricoEstadosMuestraModel->getHistoricoEstadosMuestraByIdMuestra($idMuestra);
    
    if($data !=  false){
        foreach ($data as $estado) {
            $response[] = array(
                'id' => $estado['id'],
                'idMuestra' => $estado['id_muestra'],
                'fecha' => $estado['fecha'],
                'idEstado' => $estado['id_estado'],
                'idUsuario' => $estado['id_usuario'],
                'desEstado' => $estado['des_estado'],
                'nombreUsuario' => $estado['nombre_usuario'],
                'observaciones' => $estado['observaciones']
            );
        }
        
        
       echo json_encode($response);
    }
    else {
        $response = null ;
        echo json_encode($response);
    }
    
}



