<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../TablaAreaAnalisisDbModel.php';
require '../../DbClass.php';


$modelAreasAnalisis = new TablaAreaAnalisisDbModel();
$modelCoordinador= new TablaAreaAnalisisDbModel();

if($_GET['query'] == 'getAreasWithOutEstabilidad'){
    
    
    $data = $modelAreasAnalisis->getAreasWithOutEstabilidad();
            foreach ($data as $areaActiva) {
               $areasActivas[] = array(
                   'id' => $areaActiva['id'],
                   'descripcion' => $areaActiva['descripcion']
               );
               
            }
            echo json_encode($areasActivas);
}

if($_GET['query'] == 'getAreas'){
    
    
    $data = $modelAreasAnalisis->getAreas();
            foreach ($data as $areaActiva) {
               $areasActivas[] = array(
                   'id' => $areaActiva['id'],
                   'descripcion' => $areaActiva['descripcion']
               );
               
            }
            echo json_encode($areasActivas);
}

if($_GET['query'] == 'activeAreas'){
    
    
    $data = $modelAreasAnalisis->getAreasActivas();
            foreach ($data as $areaActiva) {
               $areasActivas[] = array(
                   'id' => $areaActiva['id'],
                   'descripcion' => $areaActiva['descripcion'],
                   'coordinador'=>$areaActiva['cordinador']
               );
               
            }
            echo json_encode($areasActivas);
}

if($_GET['query'] == 'areasDescriptionByIdMuestra'){
    
    
    $data = $modelAreasAnalisis->getAreaDescriptionByIdMuestra($_GET['idMuestra']);       
    echo json_encode($data);
}



