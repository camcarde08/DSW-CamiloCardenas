<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    require '../TablaContactoDbModel.php';
require '../../DbClass.php';


$modelContacto = new TablaContactoDbModel();


if($_GET['query'] == 'contactosByTercero' && $_GET['idTercero'] != NULL){
    
    
    $data = $modelContacto->getContactosNameByTerceroId($_GET['idTercero']);
            foreach ($data as $tercero) {
               $terceros[] = array(
                   
                   'id' => $tercero['id'],
                   'nombre' => $tercero['nombre'],
                   'cargo' => $tercero['cargo'],
                   'area' => $tercero['area'],
                   'telefono' => $tercero['telefono'],
                   'movil' => $tercero['movil'],
                   'extencion' => $tercero['extencion'],
                   'email' => $tercero['email'],
                   'idTercero' => $tercero['id_tercero'],
                   'preferencias' => $tercero['preferencias']
               );
               
            }
            echo json_encode($terceros);
}





