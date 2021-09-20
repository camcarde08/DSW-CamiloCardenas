<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuxiliarMuestra
 *
 * @author Jhoana Chacón
 */
define('ROOTPATH', __DIR__ . "/../../");
require_once ROOTPATH . '/vendor/autoload.php';
require_once ROOTPATH . '/eloquent/database.php';

require_once ROOTPATH . '/eloquent/models/Ciudad.php';
require_once ROOTPATH . '/eloquent/models/Columna.php';
require_once ROOTPATH . '/eloquent/models/CondicionCromatografica.php';
require_once ROOTPATH . '/eloquent/models/Contacto.php';
require_once ROOTPATH . '/eloquent/models/Empaque.php';
require_once ROOTPATH . '/eloquent/models/Ensayo.php';
require_once ROOTPATH . '/eloquent/models/EnsayoEquipo.php';
require_once ROOTPATH . '/eloquent/models/Equipo.php';
require_once ROOTPATH . '/eloquent/models/EnsayoMuestra.php';
require_once ROOTPATH . '/eloquent/models/EnsayoMuestraCondicionCromatografica.php';
require_once ROOTPATH . '/eloquent/models/EnsayoMuestraEstandarLote.php';
require_once ROOTPATH . '/eloquent/models/EnsayoMuestraReactivoLote.php';
require_once ROOTPATH . '/eloquent/models/Envase.php';
require_once ROOTPATH . '/eloquent/models/Estandar.php';
require_once ROOTPATH . '/eloquent/models/Lote.php';
require_once ROOTPATH . '/eloquent/models/LoteCepa.php';
require_once ROOTPATH . '/eloquent/models/LoteMedioCultivo.php';
require_once ROOTPATH . '/eloquent/models/LoteReactivo.php';
require_once ROOTPATH . '/eloquent/models/MedioCultivo.php';
require_once ROOTPATH . '/eloquent/models/Muestra.php';
require_once ROOTPATH . '/eloquent/models/MuestraDetalleMic.php';
require_once ROOTPATH . '/eloquent/models/Producto.php';
require_once ROOTPATH . '/eloquent/models/Reactivo.php';
require_once ROOTPATH . '/eloquent/models/Resultados.php';
require_once ROOTPATH . '/eloquent/models/SystemParameters.php';
require_once ROOTPATH . '/eloquent/models/Tercero.php';
require_once ROOTPATH . '/eloquent/models/TipoMuestra.php';
require_once ROOTPATH . '/eloquent/models/Usuario.php';

class AuxiliarMuestra {

    public $muestra;
    public $showIdMuestra;
    public $mediosAgrupados;
    public $cepasAgrupadas;

    public function __construct($idMuestra) {
        $this->muestra = Muestra::find($idMuestra);
        $this->muestra->contacto;
        $this->muestra->empaque;
        $this->muestra->envase;
        $this->muestra->producto;
        $this->muestra->muestraDetalleMic;
        $this->muestra->lote;
        $this->muestra->tercero->ciudad;
        $this->muestra->usuarioPreConclusion;
        foreach ($this->muestra->ensayosMuestra as $ensayoMuestra) {
            $ensayoMuestra->resultados;
            $ensayoMuestra->analizadoPor;
            $ensayoMuestra->ensayo->equipos;
            foreach ($ensayoMuestra->condicionCromatografica as $condicion) {
                $condicion->columna;
                $condicion->condicionCromatografica;
            }
            foreach ($ensayoMuestra->estandar as $estandar) {
                $estandar->estandar;
                $estandar->lote;
            }
            foreach ($ensayoMuestra->reactivos as $reactivo) {
                $reactivo->reactivo;
                $reactivo->lote;
            }
        }

        $this->setShowIdMuestra();
        $this->setDateFechaFabricacion();
        $this->setDateFechaLlegada();
        $this->setDateFechaMuestreo();
        $this->setDateFechaCompromiso();
        $this->setDateFechaVencimiento();
    }

    public function replaceSpecialCharacters($cadena) {

        $exp_regular = ["/≤/"];
        $cadena_nueva = ["max"];


        return preg_replace($exp_regular, $cadena_nueva, $cadena);
    }

    private function setShowIdMuestra() {

        $separador = SystemParameters::where('propiedad', "prefixMuestraSeparator")->first();
        $cantidadCeros = SystemParameters::where('propiedad', "leftCeroCustomIdMuestra")->first()->valor;

        $aux = $this->muestra->custom_id;

        while (strlen($aux) < $cantidadCeros) {
            $aux = "0" . $aux;
        }

        $this->showIdMuestra = $this->muestra->prefijo . $separador->valor . $aux;
    }

    private function setDateFechaCompromiso() {
        $this->muestra->dateFechaCompromiso = new DateTime($this->muestra->fecha_compromiso);
    }

    private function setDateFechaFabricacion() {
        $this->muestra->dateFechaFabricacion = new DateTime($this->muestra->fecha_fabricacion);
    }

    private function setDateFechaLlegada() {

        $this->muestra->dateFechaLlegada = new DateTime($this->muestra->fecha_llegada);
    }

    private function setDateFechaMuestreo() {
        $this->muestra->mustraDetalleMic->dateFechaMuestreo = new DateTime($this->muestra->mustraDetalleMic->fecha_muestreo);
    }

    private function setDateFechaVencimiento() {
        $this->muestra->dateFechaVencimiento = new DateTime($this->muestra->fecha_vencimiento);
    }

}
