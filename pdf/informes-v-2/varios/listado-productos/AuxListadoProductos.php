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
require_once '../../../../eloquent/models/Producto.php';
require_once '../../../../eloquent/models/FormaFarmaceutica.php';

class AuxListadoProductos {

    function getAllProductosActivos() {
        $items = Producto::where('activo', 1)->orderBy('id_formula_farma', 'asc')->orderBy('nombre', 'asc')->get();

        foreach ($items as $producto) {
            $producto->formaFarmaceutica;
        }
        return $items;
    }

}
