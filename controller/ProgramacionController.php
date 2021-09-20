<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProgramacionController
 *
 * @author andres
 */
class ProgramacionController {

    private $programacionMuestra;

    public function __construct() {
        $this->programacionMuestra = new ProgramacionModelClass();
    }

    public function paintProgramacionAnalistas() {
        $this->programacionMuestra->paintProgramacionAnalistas();
    }

    public function paintConsultaDisponibilidadUsuarios() {
        $this->programacionMuestra->paintDisponibilidadUsuarios();
    }

    public function updateEnsayoMuestraDetalleFromProgAnalistas($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones, $especificacion) {
        $tablaEnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        return $tablaEnsayoMuestraModel->updateDetalleEnsayoMuestraFromProgAnalistas($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones, $especificacion);
    }

    public function createEnsayoMuestraAnalistaFromProgAnalistas($idEnsayoMuestra, $idAnalista, $duracion, $fechaProg, $idProgramador) {
        $ahora = new DateTime($fechaProg);
        $anoAhora = $ahora->format('Y');
        //obtiene el id del calendario del analista
        $tablaUsuarioModel = new TablaUsuariosDbModelClass();
        $data1 = $tablaUsuarioModel->getCalendarIdByUserId($idAnalista);
        $analistaIdCalendar = $data1[0]['id_calendario'];
        //obtiene el calendario del analista.
        $tableCalendarioBaseModel = new TablaCalendarioBaseDbModelClass();
        $data2 = $tableCalendarioBaseModel->getCalendarioById($analistaIdCalendar);
        $analistaCalendar = $data2[0];

        $tablaProgramacionAnalistasDbModel = new TablaProgramacionAnalistasDbModelClass();
        $registro = false;

        if ($duracion <= 0) {
            $duracion = 1;
        }
        while ($duracion > 0) {
            $simpleAhora = $ahora->format('Y-m-d');
            //valida si ahora es festivo para el analista
            $tablaCalendarioFestivosModel = new TablaCalendarioFestivosDbModelClass();
            $ahoraEsFestivo = $tablaCalendarioFestivosModel->isDateHolyDay($analistaIdCalendar, $simpleAhora);
            //valida si el analista trabaja en este dia de la semana y toma la jornada del dia
            $diaSemanaAhora = $ahora->format('w');
            switch ($diaSemanaAhora) {
                case 1:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_lunes];
                    $jornadaAhora = $analistaCalendar[jornada_lunes];
                    break;
                case 2:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_martes];
                    $jornadaAhora = $analistaCalendar[jornada_martes];
                    break;
                case 3:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_miercoles];
                    $jornadaAhora = $analistaCalendar[jornada_miercoles];
                    break;
                case 4:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_jueves];
                    $jornadaAhora = $analistaCalendar[jornada_jueves];
                    break;
                case 5:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_viernes];
                    $jornadaAhora = $analistaCalendar[jornada_viernes];
                    break;
                case 6:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_sabado];
                    $jornadaAhora = $analistaCalendar[jornada_sabado];
                    break;
                case 0:
                    $ahoraEsLaboral = $analistaCalendar[tarabaja_domingo];
                    $jornadaAhora = $analistaCalendar[jornada_domingo];
                    break;
            }
            //valida si el analista tiene disponibilidad ahora
            if ($ahoraEsFestivo == false && $ahoraEsLaboral == 1) {
                if ($jornadaAhora >= $duracion) {
                    //registra la programacion con una duracion = a la duracion.
                    $registro = $tablaProgramacionAnalistasDbModel->insertProgramacionAnalistas($idEnsayoMuestra, $idAnalista, $simpleAhora, $duracion, $idProgramador);
                    if ($registro == false) {
                        return false;
                    }
                    $duracion = 0;
                } else {
                    //registra la programacion con una duracion = a la jornada
                    $registro = $tablaProgramacionAnalistasDbModel->insertProgramacionAnalistas($idEnsayoMuestra, $idAnalista, $simpleAhora, $jornadaAhora, $idProgramador);
                    if ($registro == false) {
                        return false;
                    }
                    $duracion = $duracion - $jornadaAhora;
                    $ahora->add(new DateInterval('P1D'));
                }
            } else {
                $ahora->add(new DateInterval('P1D'));
            }
        }
        return true;
    }

    public function updateEstadoEnsayoMuestra($idEnsayoMuestra) {
        $tablaEnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        return $tablaEnsayoMuestraModel->updateEstadoByIdEnsayoMuestra($idEnsayoMuestra);
    }

    public function ProgramarEnsayoMuestraAnalista($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones, $idAnalista, $especificacion) {

        $ensayoMuestra = EnsayoMuestra::find($idEnsayoMuestra);
        $old = AuditoriaController::getFullMuestraToAud($ensayoMuestra->id_muestra);

        $updateEnsayo = $this->updateEnsayoMuestraDetalleFromProgAnalistas($idEnsayoMuestra, $equipo, $turno, $fechaProg, $fechaCompInterno, $duracion, $observaciones, $especificacion);
        if ($updateEnsayo) {
            if ($this->createEnsayoMuestraAnalistaFromProgAnalistas($idEnsayoMuestra, $idAnalista, $duracion, $fechaProg, $_SESSION['userId'])) {
                if ($this->updateEstadoEnsayoMuestra($idEnsayoMuestra)) {
                    $idMuestra = $this->getIdMuestraByIdEnsayoMuestra($idEnsayoMuestra);
                    //$tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                    //$tablaHistoricoEstadoMuestraModel->insertValidateHistoricoEstadoMuestraByIdMuestra($idMuestra, $_SESSION['userId']);
                    $generalController = new GeneralController();
                    $generalController->updateEstadoByIdMuestra($idMuestra, 2, null, $idEnsayoMuestra);
                    $response = array('result' => '1');

                    $new = AuditoriaController::getFullMuestraToAud($ensayoMuestra->id_muestra);
                    AuditoriaController::insertMuestraAud($old, $new, $ensayoMuestra->id_muestra, "update", "programacion de ensayos");

                    echo json_encode($response);
                } else {
                    $response = array('result' => '0', 'message' => 'error al cambiar el estado del esayo a programado');
                    echo json_encode($response);
                }
            } else {
                $response = array('result' => '0', 'message' => 'error al programar el analista al ensayo');
                echo json_encode($response);
            }
        } else {
            $response = array('result' => '0', 'message' => 'error al actualizar el detalle del ensayo');
            echo json_encode($response);
        }
    }

    public function deleteProgramacionByIdEnsayomuestra($idEnsayoMuestra) {
        $tablaProgramacionAnalistas = new TablaProgramacionAnalistasDbModelClass();
        return $tablaProgramacionAnalistas->deleteProgramacionByIdEnsayoMuestra($idEnsayoMuestra);
    }

    public function updateEstadoEnsayoMuestraTo0($idEnsayoMuestra, $motivo) {
        $tablaEnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        return $tablaEnsayoMuestraModel->updateEstadoByIdEnsayoMuestraTo0($idEnsayoMuestra, $motivo);
    }

    public function deleteProgramacion($idEnsayoMuestra, $motivo) {

        $ensayoMuestra = EnsayoMuestra::find($idEnsayoMuestra);
        $old = AuditoriaController::getFullMuestraToAud($ensayoMuestra->id_muestra);

        if ($this->deleteProgramacionByIdEnsayomuestra($idEnsayoMuestra)) {
            if ($this->updateEstadoEnsayoMuestraTo0($idEnsayoMuestra, $motivo)) {
                $idMuestra = $this->getIdMuestraByIdEnsayoMuestra($idEnsayoMuestra);
                $generalController = new GeneralController();
                $generalController->updateEstadoByIdMuestra($idMuestra, 2, null, $idEnsayoMuestra);
                //$tablaHistoricoEstadoMuestraModel = new TablaHistoricoEstadoMuestraDbModelClass();
                //$tablaHistoricoEstadoMuestraModel->insertValidateHistoricoEstadoMuestraByIdMuestra($idMuestra, $_SESSION['userId']);
                $new = AuditoriaController::getFullMuestraToAud($ensayoMuestra->id_muestra);
                AuditoriaController::insertMuestraAud($old, $new, $ensayoMuestra->id_muestra, "update", "desprogramación de ensayos");

                $response = array('result' => '1', 'message' => 'Se ha eliminado la programacion del ensayo');
                echo json_encode($response);
            } else {
                $response = array('result' => '0', 'message' => 'error al elinar al actualizar el estado del ensayo');
                echo json_encode($response);
            }
        } else {
            $response = array('result' => '0', 'message' => 'error al elinar al programacion del ensayo');
            echo json_encode($response);
        }
    }

    public function updateFechaProgramadaActividad($idProgramacion, $newDate, $programador) {
        $tablaProgramacionAnalistaModel = new TablaProgramacionAnalistasDbModelClass();
        return $tablaProgramacionAnalistaModel->updateFechaProgramada($idProgramacion, $newDate, $programador);
    }

    public function getIdMuestraByIdEnsayoMuestra($idEnsayoMuestra) {
        $tablaEnsayoMuestraModel = new TablaEnsayoMuestraDbModelClass();
        $aux = $tablaEnsayoMuestraModel->getMuestraByIdEnsayoMuestra($idEnsayoMuestra);
        return $aux[0][id_muestra];
    }

}
