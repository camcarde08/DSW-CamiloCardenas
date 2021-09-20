<?php

require_once './../../../vendor/autoload.php';
require_once './../../../eloquent/database.php';
require_once './../../../eloquent/models/Columna.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestra.php';
require_once './../../../eloquent/models/EstSubMuestra.php';
require_once './../../../eloquent/models/CondicionCromatografica.php';
require_once './../../../eloquent/models/EstEnsayoSubMuestraCondicionCromatografica.php';
require_once './../../../eloquent/models/EstMuestra.php';

class AuxInformeCondicionesCromatograficasEstabilidad {

    public function obtenerCondicionesCromatograficasMuestraEstabilidad($idMuestra) {
        $condiciones = array();
        $arrayAux = array();
        try {
            $muestra = EstMuestra::find($idMuestra);


            foreach ($muestra->subMuestras as $submuestra){
                foreach ($submuestra->ensayosSubMuestra as $ensayoSubMuestra) {
                        foreach ($ensayoSubMuestra->condicionesCromatograficas as $condicion) {
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

}
