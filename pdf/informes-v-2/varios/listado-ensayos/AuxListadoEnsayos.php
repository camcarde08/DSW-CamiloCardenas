<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuxListadoCondicionesCromatograficas
 *
 * @author Jhoana Chacón
 */
require_once '../../../../vendor/autoload.php';
require_once '../../../../eloquent/database.php';
require_once '../../../../eloquent/models/Ensayo.php';

class AuxListadoEnsayos {

    function getAllEnsayosActivos() {
        $items = Ensayo::where('activo', 1)
                        ->where('es_paquete', 0)
                        ->orderBy('descripcion', 'asc')->get();
        return $items;
    }

}
