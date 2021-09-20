<?php

class AuditoriaController {

    function getFullMuestraToAud($id) {

        try {
            $muestra = Muestra::find($id);
            $muestra->mustraDetalleMic;
            $muestra->lote;
            $muestra->almacenamientos;

            foreach ($muestra->ensayosMuestra as $ensayoMuestra) {

                $ensayoMuestra->condicionCromatografica;
                $ensayoMuestra->reactivos;
                $ensayoMuestra->estandares;
                $ensayoMuestra->programacion;
                $ensayoMuestra->resultados;
            }

            $test = $muestra->toArray();
        } catch (Exception $ex) {
            $test = $ex;
        }


        return $muestra->toJson();
    }

    function insertMuestraAud($old, $new, $idMuestra, $evento, $razon) {

        $fecha = new DateTime("now");

        try {
            $muestraAud = new MuestraAud();
            $muestraAud->fecha = $fecha->format("Y-m-d H:i:s");
            $muestraAud->old = $old;
            $muestraAud->new = $new;
            $muestraAud->id_usuario = $_SESSION["userId"];
            $muestraAud->id_muestra = $idMuestra;
            $muestraAud->evento = $evento;
            $muestraAud->razon = $razon;
            $muestraAud->save();
        } catch (Exception $ex) {
            $e = $ex;
        }
    }

    function insertAudEnsayo($old, $new, $idEnsayo, $evento, $razon) {

        $ensayoAud = new EnsayoAud();
        $ensayoAud->fecha = new DateTime("now");
        $ensayoAud->old = $old;
        $ensayoAud->new = $new;
        $ensayoAud->id_usuario = $_SESSION['userId'];
        $ensayoAud->id_ensayo = $idEnsayo;
        $ensayoAud->evento = $evento;
        $ensayoAud->razon = $razon;
        try {
            $ensayoAud->save();
        } catch (Exception $ex) {
            $a = 0;
        }
    }

}
