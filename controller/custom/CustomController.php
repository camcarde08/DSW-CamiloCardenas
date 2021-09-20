<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomController
 *
 * @author Jhoana Chacón
 */
class CustomController
{

    public function generarPrefijo($muestraData)
    {
        if ($_SESSION["systemsParameters"]["dynamicPrefix"] == 'true') {
            $producto = Producto::find($muestraData["idProducto"]);
            $tipoProducto = $producto->formaFarmaceutica->tipo_producto;
            $fechaLlegada = new DateTime($muestraData["fechaLlegada"]);
            $prefijo = $tipoProducto . $fechaLlegada->format('y') . $fechaLlegada->format('m');

            $tipoMuestra = TipoMuestra::where('prefijo', $prefijo)->get();
            if (count($tipoMuestra) == 0) {
                $tipo = new TipoMuestra();
                $tipo->prefijo = $prefijo;
                $tipo->descripcion = 'Prefijo generado dinámicamente';
                $tipo->save();
            }
            $muestraData['prefijo'] = $prefijo;

            return $muestraData;
        } else {
            return $muestraData;
        }
    }

}
