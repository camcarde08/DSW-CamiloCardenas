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
require_once '../../../../eloquent/models/CondicionCromatografica.php';

class AuxListadoCondicionesCromatograficas {

    function getAllCondicionesActivas() {
        $condiciones = CondicionCromatografica::where('activo', 1)->orderBy('nombre', 'asc')->get();
        return $condiciones;
    }

}
