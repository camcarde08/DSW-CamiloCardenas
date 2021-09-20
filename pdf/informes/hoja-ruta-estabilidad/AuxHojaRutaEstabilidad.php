<?php

require_once './../../../vendor/autoload.php';
require_once './../../../eloquent/database.php';
require_once './../../../eloquent/models/Equipo.php';
require_once './../../../eloquent/models/Ensayo.php';
require_once './../../../eloquent/models/EnsayoEquipo.php';
require_once './../../../eloquent/models/Estandar.php';
require_once './../../../eloquent/models/EstDuracionEstabilidad.php';
require_once './../../../eloquent/models/EstMuestra.php';
require_once './../../../eloquent/models/EstSubMuestra.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestra.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestraEstandarLote.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestraReactivoLote.php';
require_once './../../../eloquent/models/EstTemperatura.php';
require_once './../../../eloquent/models/FormaFarmaceutica.php';
require_once './../../../eloquent/models/LoteEstandar.php';
require_once './../../../eloquent/models/LoteReactivo.php';
require_once './../../../eloquent/models/Metodo.php';
require_once './../../../eloquent/models/Producto.php';
require_once './../../../eloquent/models/Reactivo.php';
require_once './../../../eloquent/models/TipoMuestra.php';

class AuxHojaRutaEstabilidad {

    public $subMuestra;

    public function __construct($idSubmuestra, $idTemperatura) {
        try {
            $subMuestra = EstSubMuestra::find($idSubmuestra);
            $subMuestra->muestra->producto;
            $subMuestra->muestra->tipoMuestra;
            $subMuestra->duracion;
            $subMuestra->temperatura;
            $subMuestra->ensayosSubMuestra = EstEnsayoSubMuestra::
                    join('sgm_ensayo', 'sgm_ensayo.id', '=', 'sgm_est_ensayo_sub_muestra.id_ensayo')
                    ->where('id_sub_muestra', $subMuestra->id)
                    ->select('sgm_est_ensayo_sub_muestra.*')
                    ->orderBy('sgm_ensayo.orden', 'asc')
                    ->get();
            $ensayosRealizar = [];
            $metodos = [];
            foreach ($subMuestra->ensayosSubMuestra as $key => $ensayoSubmestra) {
                $ensayoSubmestra->metodo;
                $ensayoSubmestra->ensayo;
                $ensayoSubmestra->paquete;
                $ensayoSubmestra->estandaresLote;

                foreach ($ensayoSubmestra->estandaresLote as $estandarLote) {
                    $estandarLote->estandar;
                    $estandarLote->lote;
                }
                $descripcion = $ensayoSubmestra->descripcion_especifica;
                array_push($ensayosRealizar, $descripcion);
                if (!in_array($ensayoSubmestra->metodo->descripcion, $metodos)) {
                    array_push($metodos, $ensayoSubmestra->metodo->descripcion);
                }
            }


            $this->subMuestra = $subMuestra;
            $this->subMuestra->ensayosRealizar = $ensayosRealizar;
            $this->subMuestra->metodos = $metodos;

            $test = $subMuestra->toArray();
        } catch (Exception $ex) {
            $a = 0;
        }
        $a = 0;
    }

    public function obtenerLoteReactivoMuestraActivo() {
        $reactivos = [];
        $reactivosId = [];
        foreach ($this->subMuestra->ensayosSubMuestra as $ensayoSubmestra) {
            $ensayoSubmestra->reactivosLote;

            foreach ($ensayoSubmestra->reactivosLote as $reactivoLote) {
                $reactivoLote->reactivo;

                $reactivoLote->lote = $this->loteReactivoActivo($reactivoLote->reactivo->id);

                if (!in_array($reactivoLote->reactivo->id, $reactivosId)) {
                    array_push($reactivos, $reactivoLote);
                    array_push($reactivosId, $reactivoLote->reactivo->id);
                }
            }
        }

        return $reactivos;
    }

    public function loteReactivoActivo($idReactivo) {
        $loteActivo = LoteReactivo::where('id_reactivo', $idReactivo)
            ->where('activo', 1)->first();

        return $loteActivo;
    }

    public function obtenerEquiposEnsayo($idEnsayo) {
        $ensayoEquipos = EnsayoEquipo::where('id_ensayo', $idEnsayo)->get();
        $equipos = [];
        foreach ($ensayoEquipos as $ensayoEquipo) {
            $ensayoEquipo->equipo;
            array_push($equipos, $ensayoEquipo->equipo);
        }

        return $equipos;
    }
    
    function numeroCliente($prefijo, $custom_id) {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
        $this->dbClass->loadSystemParameters();
        $utilsController = new UtilsController();
        $ident = $utilsController->constructComplexIdMuestra($prefijo, $custom_id);
        return $ident;
    }

}
