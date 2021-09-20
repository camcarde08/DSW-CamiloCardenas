<?php

require_once './../../../vendor/autoload.php';
require_once './../../../eloquent/database.php';
require_once './../../../eloquent/models/Empaque.php';
require_once './../../../eloquent/models/Ensayo.php';
require_once './../../../eloquent/models/Envase.php';
require_once './../../../eloquent/models/EstDuracionEstabilidad.php';
require_once './../../../eloquent/models/EstMuestra.php';
require_once './../../../eloquent/models/EstSubMuestra.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestra.php';
require_once './../../../eloquent/models/FormaFarmaceutica.php';
require_once './../../../eloquent/models/Metodo.php';
require_once './../../../eloquent/models/Perfil.php';
require_once './../../../eloquent/models/Producto.php';
require_once './../../../eloquent/models/EstTemperatura.php';
require_once './../../../eloquent/models/EstTipoEstabilidad.php';
require_once './../../../eloquent/models/TipoMuestra.php';
require_once './../../../eloquent/models/Tercero.php';
require_once './../../../eloquent/models/Usuario.php';

class AuxInformeAnalisisEstabilidad {

    public $subMuestra;
    public $temperatura;

    public function __construct($idSubmuestra, $idTemperatura) {
        try {



            $subMuestra = EstSubMuestra::find($idSubmuestra);
            $subMuestra->duracionEstabilidad;
            $subMuestra->temperatura;
            $subMuestra->muestra->producto->formaFarmaceutica;
            $subMuestra->muestra->tipoMuestra;
            $subMuestra->muestra->tipoEstabilidad;
            $subMuestra->muestra->tercero;
            $subMuestra->muestra->envase;
            $subMuestra->muestra->empaque;
            $subMuestra->usuarioAprobacion->perfil;
            $fechaAnalisis;
            foreach ($subMuestra->ensayosSubMuestra as $ensayoSubmestra) {
                $ensayoSubmestra->metodo;
                $ensayoSubmestra->ensayo;
                $ensayoSubmestra->paquete;
                $ensayoSubmestra->usuarioProgramado;
                $fecha = $ensayoSubmestra->fecha_analisis ? new DateTime($ensayoSubmestra->fecha_analisis) : null;
                $fechaAnalisis = max($fechaAnalisis, $fecha);
            }

            $this->subMuestra = $subMuestra;
            $this->subMuestra->fecha_analisis_ensayo = $fechaAnalisis;

            $test = $subMuestra->toArray();
        } catch (Exception $ex) {
            $a = 0;
        }
        $a = 0;
    }

    public function getAnalistaFirma() {

        $aux = [];
        foreach ($this->subMuestra->ensayosSubMuestra as $value) {
            $value->usuarioProgramado->perfil;
            array_push($aux, $value->usuarioProgramado);
        }


        return $aux[0];
    }

    function numeroCliente($prefijo, $custom_id) {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
        $this->dbClass->loadSystemParameters();
        $utilsController = new UtilsController();
        $ident = $utilsController->constructComplexIdMuestra($prefijo, $custom_id);
        return $ident;
    }

    function getusuarioById($idUsuario) {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
        $SQL = "SELECT * FROM sgm_usuario where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idUsuario);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        }
    }

    function getFirmas($idUsuario) {
        $this->dbClass = new DbClass();
        $this->dbClass->conexion();
        $SQL = "SELECT * FROM sgm_usuario where id = ?";
        $query = $this->dbClass->getConexion()->prepare($SQL);
        $query->bindParam(1, $idUsuario);
        if ($query->execute()) {
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            return $result[0];
        }
    }

    public function getEnsayosSubMuestraOrdenados(){

        $array  = $this->subMuestra->ensayosSubMuestra->toArray();
        usort($array, function($a, $b){

            if ($a["ensayo"]["orden"] == $b["ensayo"]["orden"]) {
                return 0;
            }
            return ($a["ensayo"]["orden"] < $b["ensayo"]["orden"]) ? -1 : 1;

        });

        return $array;
    }

}
