<?php

require_once './../../../vendor/autoload.php';
require_once './../../../eloquent/database.php';
require_once './../../../eloquent/models/Columna.php';
require_once './../../../eloquent/models/CondicionCromatografica.php';
require_once './../../../eloquent/models/EnsayoMuestra.php';
require_once './../../../eloquent/models/EnsayoMuestraCondicionCromatografica.php';
require_once './../../../eloquent/models/Muestra.php';

class AuxInformeCondicionesCromatograficas {

    public function obtenerCondicionesCromatograficasMuestra($idMuestra) {
        $condiciones = array();
        $arrayAux = array();
        try {
            $muestra = Muestra::find($idMuestra);
            $muestra->ensayosMuestra;
            foreach ($muestra->ensayosMuestra as $ensayoMuestra) {
                if ($ensayoMuestra->validacion == 1) {
                    foreach ($ensayoMuestra->condicionCromatografica as $condicion) {
                        if ($condicion->id_condicion_cromatografica !== NULL) {
                            $condicionObj = ['condicionCromatografica' => $condicion->condicionCromatografica,
                                'columna' => $condicion->columna];
                            $idCondicion = $condicion->condicionCromatografica->id;
                            if (!in_array($idCondicion, $arrayAux)) {
                                array_push($condiciones, $condicionObj);
                                array_push($arrayAux, $idCondicion);
                            }
                        }
                    }
                }
            }

            return $condiciones;
        } catch (Exception $ex) {
            return array();
        }
    }

    public function obtenerCondicionCromatograficaById($idCondicion) {
        try {
            $condicion = CondicionCromatografica::find($idCondicion);
            $condicionObj = array(['condicionCromatografica' => $condicion,
                    'columna' => '']);

            return $condicionObj;
        } catch (Exception $ex) {
            return array();
        }
    }

}
