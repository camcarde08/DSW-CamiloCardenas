<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './TablaEnsayoMuestraDbModelClass.php';
require '../DbClass.php';


$lote = new TablaEnsayoMuestraDbModelClass();

echo $lote->insertEnsayoMuestra(42, 109,5, 1);
