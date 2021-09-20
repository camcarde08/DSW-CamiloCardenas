<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    require '../TablaRepositorioDbModelClass.php';
require '../../DbClass.php';


$modelRepositorio = new TablaRepositorioDbModelClass();


if($_GET['query'] == 'all'){
    
    
    $data = $modelRepositorio->getRepositorio();
            foreach ($data as $registro) {
                if($registro['es_carpeta'] == 1){
                 $icon = 'views/images/folder.png';        
                } else {
                    $icon = 'views/images/file_icon.png';        
                }
               $registros[] = array(
                   'id' => $registro['id'],
                   'nombre' => $registro['nombre'],
                   'extension' => $registro['extension'],
                   'esCarpeta' => $registro['es_carpeta'],
                   'path' => $registro['path'],
                   'parent' => $registro['parent'],
                   'icon' => $icon
               );
               
            }
            echo json_encode($registros);
}

if($_GET['query'] == 'searchLikeName'){
    
    
    $data = $modelRepositorio->searchLikeName($_GET['name']);
            foreach ($data as $registro) {
                if($registro['es_carpeta'] == 1){
                 $icon = 'views/images/folder.png';  
                 $nombreCompleto = $registro['nombre'];
                 $link = "";
                } else {
                    $icon = 'views/images/file_icon.png';        
                    $nombreCompleto = $registro['nombre'].".".$registro['extension'];
                    $fullPath = $registro["path"] . DIRECTORY_SEPARATOR . $nombreCompleto;
                    $link = str_replace(DIRECTORY_SEPARATOR, "/", $fullPath);
                }
               $registros[] = array(
                   'id' => $registro['id'],
                   'nombre' => $registro['nombre'],
                   'extension' => $registro['extension'],
                   'nombreCompleto' => $nombreCompleto,
                   'esCarpeta' => $registro['es_carpeta'],
                   'path' => $registro['path'],
                   'parent' => $registro['parent'],
                   'icon' => $icon,
                   'link' => $link
                   
               );
               
            }
            echo json_encode($registros);
}

if ($_GET['query'] == 'fullScanRepoById') {


    $data = $modelRepositorio->scanRepoById($_GET['idPath']);
    if ($data != false) {
        foreach ($data as $registro) {
            if ($registro['es_carpeta'] == 1) {
                $icon = 'views/images/folder.png';
                $nombreCompleto = $registro['nombre'];
                $esCarpeta = true;
            } else {
                $icon = 'views/images/file_icon.png';
                $nombreCompleto = $registro['nombre'] . "." . $registro['extension'];
                $esCarpeta = false;
            }
            $fullPath = $registro["path"] . DIRECTORY_SEPARATOR . $nombreCompleto;
            $link = str_replace(DIRECTORY_SEPARATOR, "/", $fullPath);
            $link = str_replace("./docs/repositorio/Antiguos", "", $link);

            $registros[] = array(
                'id' => $registro['id'],
                'nombre' => $registro['nombre'],
                'extension' => $registro['extension'],
                'nombreCompleto' => $nombreCompleto,
                'esCarpeta' => $esCarpeta,
                'path' => $registro['path'],
                'parent' => $registro['parent'],
                'icon' => $icon,
                'link' => $fullPath
            );
        }
    } else {
        $registros = null;
    }
    
    $data = $modelRepositorio->getitemById($_GET['idPath']);
    if(data != fasle){
        foreach ($data as $registro) {
            if ($registro['es_carpeta'] == 1) {
                $icon = 'views/images/folder.png';
                $nombreCompleto = $registro['nombre'];
                $esCarpeta = true;
            } else {
                $icon = 'views/images/file_icon.png';
                $nombreCompleto = $registro['nombre'] . "." . $registro['extension'];
                $esCarpeta = false;
            }
            $fullPath = $registro["path"] . DIRECTORY_SEPARATOR . $nombreCompleto;
            $link = str_replace(DIRECTORY_SEPARATOR, "/", $fullPath);
            $link = str_replace("./docs/repositorio/Antiguos", "", $link);

            $current[] = array(
                'id' => $registro['id'],
                'nombre' => $registro['nombre'],
                'extension' => $registro['extension'],
                'nombreCompleto' => $nombreCompleto,
                'esCarpeta' => $esCarpeta,
                'path' => $registro['path'],
                'parent' => $registro['parent'],
                'icon' => $icon,
                'link' => $fullPath
            );
        }
    } else {
        $current = null;
    }
    
    $data = $modelRepositorio->getParentById($_GET['idPath']);
    if(data != false){
        foreach ($data as $registro) {
            if ($registro['es_carpeta'] == 1) {
                $icon = 'views/images/folder.png';
                $nombreCompleto = $registro['nombre'];
                $esCarpeta = true;
            } else {
                $icon = 'views/images/file_icon.png';
                $nombreCompleto = $registro['nombre'] . "." . $registro['extension'];
                $esCarpeta = false;
            }
            $fullPath = $registro["path"] . DIRECTORY_SEPARATOR . $nombreCompleto;
            $link = str_replace(DIRECTORY_SEPARATOR, "/", $fullPath);
            $link = str_replace("./docs/repositorio/Antiguos", "", $link);

            $parent[] = array(
                'id' => $registro['id'],
                'nombre' => $registro['nombre'],
                'extension' => $registro['extension'],
                'nombreCompleto' => $nombreCompleto,
                'esCarpeta' => $esCarpeta,
                'path' => $registro['path'],
                'parent' => $registro['parent'],
                'icon' => $icon,
                'link' => $fullPath
            );
        }
    } else {
        $parent = null;
    }
    
    $response = array('current' => $current, 'parent' => $parent, 'childs' => $registros);
    echo json_encode($response);
}



