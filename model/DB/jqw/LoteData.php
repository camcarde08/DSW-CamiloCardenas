<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require '../TablaLoteDbModelClass.php';
require '../../DbClass.php';


$modelLote = new TablaLoteDbModelClass();


if($_GET['query'] == 'getLotesByIdMuestra'){
    
    
    $data = $modelLote->getLotesByidMuestra($_GET['idMuestra']);
            foreach ($data as $lote) {
               $lotes[] = array(
                   'id' => $lote['id'],
                   'id_muestra' => $lote['id_muestra'],
                   'indice' => $lote['indice'],
                   'tamanoLote' => $lote['tamano'],
                   'numLote' => $lote['numero'],
                   'cantEnviadaLote' => $lote['cantidad_enviada'],
                   'estado' => $lote['estado']
                   
               );
               
            }
            echo json_encode($lotes);
}
