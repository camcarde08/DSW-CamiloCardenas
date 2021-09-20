<?php
    
    require 'controller/basicController.php';
    
    
        
    session_save_path('tmp');
    session_start();
    
    $basicController = new basicController();
    
    $val = substr($_SERVER['REQUEST_URI'],1,9);
    
//    if($val != 'index.php')
//    {
//        header ("Location: http://".$_SERVER['HTTP_HOST']."/index.php");
//    }
//SET_MASTER
   
    $basicController->start();

    