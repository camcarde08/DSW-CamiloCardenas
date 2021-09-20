<?php

require_once '../../../model/DbClass.php';
require_once './../../../vendor/autoload.php';
require_once './../../../eloquent/database.php';
require_once './../../../eloquent/models/Muestra.php';
require_once './../../../eloquent/models/Tercero.php';
require_once './../../../eloquent/models/EnsayoMuestra.php';
require_once './../../../eloquent/models/ProgramacionAnalistas.php';
require_once './../../../eloquent/models/Usuario.php';

class AuxInformeEstadistico {

    private $dbClass;

    public function __construct() {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
    }

    function getEstadisticasMuestra($fechaInicio, $fechaFin) {

        $muestras = Muestra::where("fecha_llegada", ">=", $fechaInicio)->where("fecha_llegada", "<=", $fechaFin)->get();

        $muestrasCompletas = Muestra::all();

        $aux = [];

        foreach ($muestras as $muestra) {
            $a = $muestra->toArray();
            if (!isset($aux[$a["fecha_llegada"]])) {
                $aux[$a["fecha_llegada"]] = [];
            }

            array_push($aux[$a["fecha_llegada"]], $muestra);
        }
        
        $aux1 = [];

        foreach ($muestrasCompletas as $muestra) {
            $a = $muestra->toArray();
            if (!isset($aux1[$a["id_estado_muestra"]])) {
                $aux1[$a["id_estado_muestra"]] = [];
            }

            array_push($aux1[$a["id_estado_muestra"]], $muestra);
        }

        $aux2 = [];

        foreach ($aux1 as $key => $value) {
            array_push($aux2, ["estado" => $key, "muestras" => $value, "cantidad" => count($value)]);
        }

        $aux5 = [];

        foreach ($aux as $key => $value) {
            array_push($aux5, ["fecha" => $key, "muestras" => $value, "cantidad" => count($value)]);
        }

        foreach ($aux5 as $keyFechas => $fecha) {
            foreach ($fecha['muestras'] as $keyMuestra => $muestra) {
                if (!isset($aux5[$keyFechas]["estados"])) {
                    $aux5[$keyFechas]["estados"] = [];
                }
                if (!isset($aux5[$keyFechas]["estados"][$muestra->id_estado_muestra])) {
                    $aux5[$keyFechas]["estados"][$muestra->id_estado_muestra] = 0;
                }
                $aux5[$keyFechas]["estados"][$muestra->id_estado_muestra] ++;
            }
        }
        
        $conteoRecibidas = 0;
        
        foreach($aux5 as $conteoRecibido){
            $conteoRecibidas = $conteoRecibido["cantidad"] + $conteoRecibidas;
        }

        $aux3 = [];
        foreach ($muestrasCompletas as $muestra) {
//            $a = $muestra->toArray();
            $tercero1 = Tercero::find($muestra->id_tercero);
            $tercero = $tercero1->nombre;
            if (!isset($aux3[$tercero])) {
                $aux3[$tercero] = [];
            }
            if (!isset($aux3[$tercero]["muestras"])) {
                $aux3[$tercero]["muestras"] = [];
            }

            array_push($aux3[$tercero]["muestras"], $muestra);
        }

        $auxClientes = [];

        foreach ($aux3 as $keyCliente => $valueCliente) {
            array_push($auxClientes, ["cliente" => $keyCliente, "muestras" => $valueCliente["muestras"]]);
        }

        foreach ($auxClientes as $keyClientes => $valueClientes) {
            foreach ($valueClientes['muestras'] as $keyMuestraCliente => $muestraCliente) {
                if (!isset($auxClientes[$keyClientes]["estados"])) {
                    $auxClientes[$keyClientes]["estados"] = [];
                }
                if (!isset($auxClientes[$keyClientes]["estados"][$muestraCliente->id_estado_muestra])) {
                    $auxClientes[$keyClientes]["estados"][$muestraCliente->id_estado_muestra] = 0;
                }
                $auxClientes[$keyClientes]["estados"][$muestraCliente->id_estado_muestra] ++;
            }
        }

        $aux4 = [];

        foreach ($muestras as $muestra) {
            $ensayosMuestra = EnsayoMuestra::find($muestra["id"]);
            $programacionAnalistas = ProgramacionAnalistas::where("id_ensayo_muestra", "=", $ensayosMuestra["id"])->get();
            foreach ($programacionAnalistas as $programacionAnalista) {
                $usuario = Usuario::where("id", "=", $programacionAnalista["id_analista"])->get();
                $analista = $usuario[0]->nombre;
                if (!isset($aux4[$analista])) {
                    $aux4[$analista] = [];
                }
                if (!isset($aux4[$analista]["muestras"])) {
                    $aux4[$analista]["muestras"] = [];
                }
            }
            array_push($aux4[$analista]["muestras"], $muestra);
        }

        $auxAnalistas = [];

        foreach ($aux4 as $keyAnalista => $valueAnalista) {
            array_push($auxAnalistas, ["analista" => $keyAnalista, "muestras" => $valueAnalista["muestras"]]);
        }

        foreach ($auxAnalistas as $keyAnalistas => $valueAnalistas) {
            foreach ($valueAnalistas['muestras'] as $keyMuestraAnalista => $muestraAnalista) {
                if (!isset($auxAnalistas[$keyAnalistas]["fechas"])) {
                    $auxAnalistas[$keyAnalistas]["fechas"] = [];
                }
                if (!isset($auxAnalistas[$keyAnalistas]["fechas"][$muestraAnalista->fecha_llegada])) {
                    $auxAnalistas[$keyAnalistas]["fechas"][$muestraAnalista->fecha_llegada] = 0;
                }
                $auxAnalistas[$keyAnalistas]["fechas"][$muestraAnalista->fecha_llegada] ++;
            }
        }

        $response = ["aux" => $aux, "auxiliarConteo" => $aux2, "auxiliarConteoRecibidas" => $conteoRecibidas, "auxClientes" => $auxClientes, "auxAnalistas" => $auxAnalistas];
//        echo $response;
        return $response;
    }

}
