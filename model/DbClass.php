<?php

/**
 * Description of DbClass
 *
 * @author hruge
 */
//require 'DB/TablaPerfilDbModelClass.php';

class DbClass {

    //put your code here
    private $dbName;
    private $conexion;
    private $host;
    private $dbPort;
    private $user;
    private $password;

    public function __construct() {
        $xml = simplexml_load_file('config/systemParameters.xml');
        if ($xml === (boolean) 0) {
            $xml = simplexml_load_file('../config/systemParameters.xml');
        }
        if ($xml === (boolean) 0) {
            $xml = simplexml_load_file('../../config/systemParameters.xml');
        }
        if ($xml === (boolean) 0) {
            $xml = simplexml_load_file('../../../config/systemParameters.xml');
        }
        $this->dbName = (string) $xml->dbParameters->dbName;
        $this->host = (string) $xml->dbParameters->dbHost;
        $this->dbPort = (string) $xml->dbParameters->dbPort;
        $this->user = (string) $xml->dbParameters->userDb;
        $this->password = (string) $xml->dbParameters->passwordDb;
    }

    function conexion() {
        try {
            $this->conexion = new PDO('mysql:host=' . $this->host . ';port=' . $this->dbPort . ';dbname=' . $this->dbName, $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\''));
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    function login($user, $pass) {
        $query = "SELECT * from sgm_usuario where login='$user' and aes_decrypt(clave,'SGM') = '$pass' and estado = 1 and bloqueado = 0";
        $query = $this->conexion->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
            if (count($data) >= 1) {
                $_SESSION['logued'] = true;
                $this->loadSystemParameters();
                $this->loadUserData($data[0]);
                $this->loadPermisions($_SESSION['user_id_perfil']);
                $this->loadPermisionsBandejaEntrada($_SESSION['user_id_perfil']);
                $this->initCustomUserSession($_SESSION['userId']);
            } else {
                
            }
        }
    }

    function login2($user, $pass) {
        $query = "SELECT * from sgm_usuario where login='$user' and aes_decrypt(clave,'SGM') = '$pass' and estado = 1 and bloqueado = 0";
        $query = $this->conexion->prepare($query);
        if ($query->execute()) {
            $data = $query->fetchAll();
            if (count($data) >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function initCustomUserSession($idUser) {
        $this->deleteUidByUser($idUser);
        $this->createUidSession($idUser);
    }

    function deleteUidByUser($idUser) {
        $SQL = "DELETE FROM sgm_session WHERE id_usuario = ?;";
        $query = $this->getConexion()->prepare($SQL);

        $query->bindParam(1, $idUser);


        $query->execute();
    }

    function createUidSession($idUsuario) {

        $bytes = openssl_random_pseudo_bytes(8, $cstrong);
        $uid = bin2hex($bytes);

        $fecha = new DateTime("now", new DateTimeZone("America/Lima"));
        $stringFecha = $fecha->format("Y-m-d H:i:s");

        $estado = 1;

        $SQL = "insert into sgm_session (session_uid,fecha,id_usuario,estado) values (?,?,?,?);";
        $query = $this->getConexion()->prepare($SQL);

        $query->bindParam(1, $uid);
        $query->bindParam(2, $stringFecha);
        $query->bindParam(3, $idUsuario);
        $query->bindParam(4, $estado);

        $query->execute();
        $_SESSION['uidSession'] = $uid;
    }

    function loadUserData($userQuery) {

        $_SESSION['user_nombre'] = $userQuery['nombre'];
        $_SESSION['user_login'] = $userQuery['login'];
        $_SESSION['user_id_perfil'] = $userQuery['id_perfil'];
        $_SESSION['user_id_jefe'] = $userQuery['id_jefe'];
        $_SESSION['user_id_cargo'] = $userQuery['id_cargo'];
        $_SESSION['user_es_jefe'] = $userQuery['es_jefe'];
        $_SESSION['user_email'] = $userQuery['email'];
        $_SESSION['userId'] = $userQuery['id'];

        $tPerfilDbModel = new TablaPerfilDbModelClass();
        $perfil = $tPerfilDbModel->getPerfilByID($_SESSION['user_id_perfil']);
        if ($perfil != false) {
            $_SESSION['user_nom_perfil'] = $perfil[0][nombre];
        }
    }

    function loadSystemParameters() {
        $SQL = "SELECT id, propiedad, valor FROM sgm_system_parameters";
        $query = $this->getConexion()->prepare($SQL);
        if ($query->execute()) {
            $data = $query->fetchAll();
            foreach ($data as $propiedad) {
                $_SESSION["systemsParameters"][$propiedad["propiedad"]] = $propiedad["valor"];
            }
        }
    }

    function loadPermisions($userPerfil) {

        $SQL = "SELECT * from sgm_perfil_permiso where id_perfil = ?";
        $query = $this->getConexion()->prepare($SQL);
        $query->bindParam(1, $userPerfil);
        if ($query->execute()) {
            $data = $query->fetchAll();
            $_SESSION['aprobarMuestraHojaTrabajo'] = 'false';
            $_SESSION['RegistroDeMuestra'] = 'false';
            $_SESSION['RegistrarMuestras'] = 'false';
            $_SESSION['ConsultaMuestras'] = 'false';
            $_SESSION['ConsultaMuestrasEst'] = 'false'; //en BD el Numero 28
            $_SESSION['HistorialAlmacenamiento'] = 'false';
            $_SESSION['Programacion'] = 'false';
            $_SESSION['subMenuProgramacionAnalistas'] = 'false';
            $_SESSION['subMenuCOnsultaDisponibilidadUsuarios'] = 'false';
            $_SESSION['FissMicroDes'] = 'false';
            $_SESSION['subMenuConHojaRutaMuestra'] = 'false';
            $_SESSION['DocsMuestra'] = 'false';
            $_SESSION['adminSistema'] = 'false';
            $_SESSION['adminPerfiles'] = 'false';
            $_SESSION['adminUsuarios'] = 'false';
            $_SESSION['adminEquipos'] = 'false';
            $_SESSION['adminMetodos'] = 'false';
            $_SESSION['adminPrinActivos'] = 'false';
            $_SESSION['registrarCotizacion'] = 'false';
            $_SESSION['adminEnsayos'] = 'false';
            $_SESSION['adminPaquetes'] = 'false';
            $_SESSION['adminEstandar'] = 'false';
            $_SESSION['adminForma'] = 'false';
            $_SESSION['adminProducto'] = 'false';
            $_SESSION['adminTercero'] = 'false';
            $_SESSION['consultaCotizacion'] = 'false';
            $_SESSION['repoDocs'] = 'false';
            $_SESSION['historicoEstadosMuestra'] = 'false';

            $_SESSION['adminReactivos'] = 'false';
            $_SESSION['adminCepas'] = 'false';
            $_SESSION['adminMediosCultivo'] = 'false';

            //estabilidades

            $_SESSION['adminEstabilidades'] = 'false';
            $_SESSION['registrarEstabilidad'] = 'false';
            $_SESSION['programarEstabilidad'] = 'false';
            $_SESSION['resultadosEstabilidad'] = 'false';

            $_SESSION['regEstCotizacion'] = 'false'; // subMenuRegCotEst
            $_SESSION['registrarEstabilidad'] = 'false'; // subMenuRegistroEst
            $_SESSION['consultarEstabilidad'] = 'false'; //subMenuConsultaEstab
            $_SESSION['documentosEstabilidad'] = 'false'; //subMenuAdjuntarDocsEst
            // Informes

            $_SESSION['adminInformes'] = 'false'; //MenuPrincipalInformes
            $_SESSION['informeDisponibilidad'] = 'false'; //subMenuDisponibilidadUsuarios
            $_SESSION['informeEstadoMuestras'] = 'false'; //subMenuEstadosDeMuestras
            $_SESSION['informeListadePrecios'] = 'false'; //subMenuListaDePrecios
            $_SESSION['informeGenerarStikers'] = 'false'; //subMenuGenerarStikers
            $_SESSION['informeGenerarHCPlanta'] = 'false'; //informeGenerarHCPlanta
            $_SESSION['informeGenerarInformePlanta'] = 'false'; //informeGenerarInformePlanta
            $_SESSION['informeEstadistico'] = 'false'; //subMenu informeEstadistico

            $_SESSION['muestraDocsBotonEliminarArchivos'] = 'false'; //subMenuGenerarStikers

            $_SESSION['informeReactivos'] = 'false';
            $_SESSION['informeEstandares'] = 'false';

            $_SESSION['checkAnalisisRealizadoHojaTrabajo'] = false;
            $_SESSION['aprobarMuestraHojaTrabajo'] = false;
            $_SESSION['revisarMuestraHojaTrabajo'] = false;

            $_SESSION['adminBandejasEntrada'] = 'false';
            $_SESSION['adminEnsayoEquipo'] = 'false';

            $_SESSION['adminColumnas'] = 'false';
            $_SESSION['adminCondiciones'] = 'false';
            $_SESSION['adminProductoCondiciones'] = 'false';

            $_SESSION['eventoMuestra'] = 'false';

            $_SESSION['adminEditarMuestra'] = 'false';
            $_SESSION['adminUsuarioCliente'] = 'false';

            $_SESSION['activarLoteReactivo'] = 'false';
            $_SESSION['activarLoteEstandar'] = 'false';

            $_SESSION['anularMuestra'] = false;

            $_SESSION['botonInformePrevio'] = false;
            $_SESSION['botonHojaRuta'] = false;
            $_SESSION['botonAnexos'] = false;

            foreach ($data as $unDato) {
                if ($unDato['id_permiso'] === '1') {
                    $_SESSION['RegistroDeMuestra'] = 'true';
                }
                if ($unDato['id_permiso'] === '2') {
                    $_SESSION['RegistrarMuestras'] = 'true';
                }
                if ($unDato['id_permiso'] === '3') {
                    $_SESSION['ConsultaMuestras'] = 'true';
                }
                if ($unDato['id_permiso'] === '4') {
                    $_SESSION['HistorialAlmacenamiento'] = 'true';
                }
                if ($unDato['id_permiso'] === '5') {
                    $_SESSION['Programacion'] = 'true';
                }
                if ($unDato['id_permiso'] === '6') {
                    $_SESSION['subMenuProgramacionAnalistas'] = 'true';
                }
                if ($unDato['id_permiso'] === '7') {
                    $_SESSION['subMenuCOnsultaDisponibilidadUsuarios'] = 'true';
                }
                if ($unDato['id_permiso'] === '8') {
                    $_SESSION['FissMicroDes'] = 'true';
                }
                if ($unDato['id_permiso'] === '9') {
                    $_SESSION['subMenuConHojaRutaMuestra'] = 'true';
                }
                if ($unDato['id_permiso'] === '10') {
                    $_SESSION['DocsMuestra'] = 'true';
                }
                if ($unDato['id_permiso'] === '11') {
                    $_SESSION['adminSistema'] = 'true';
                }
                if ($unDato['id_permiso'] === '12') {
                    $_SESSION['adminPerfiles'] = 'true';
                }
                if ($unDato['id_permiso'] === '13') {
                    $_SESSION['adminUsuarios'] = 'true';
                }
                if ($unDato['id_permiso'] === '14') {
                    $_SESSION['adminEquipos'] = 'true';
                }
                if ($unDato['id_permiso'] === '15') {
                    $_SESSION['adminPrinActivos'] = 'true';
                }
                if ($unDato['id_permiso'] === '16') {
                    $_SESSION['adminEnsayos'] = 'true';
                }
                if ($unDato['id_permiso'] === '17') {
                    $_SESSION['adminPaquetes'] = 'true';
                }
                if ($unDato['id_permiso'] === '18') {
                    $_SESSION['adminEstandar'] = 'true';
                }
                if ($unDato['id_permiso'] === '19') {
                    $_SESSION['adminForma'] = 'true';
                }
                if ($unDato['id_permiso'] === '20') {
                    $_SESSION['adminProducto'] = 'true';
                }
                if ($unDato['id_permiso'] === '21') {
                    $_SESSION['adminTercero'] = 'true';
                }
                if ($unDato['id_permiso'] === '22') {
                    $_SESSION['consultaCotizacion'] = 'true';
                }
                if ($unDato['id_permiso'] === '23') {
                    $_SESSION['repoDocs'] = 'true';
                }
                if ($unDato['id_permiso'] === '24') {
                    $_SESSION['revisionEnsayoHojaTrabajo'] = true;
                }
                if ($unDato['id_permiso'] === '25') {
                    $_SESSION['consultaResultadoHojaTrabajo'] = true;
                }
                if ($unDato['id_permiso'] === '26') {
                    $_SESSION['registroResultadoHojaTrabajo'] = true;
                }
                if ($unDato['id_permiso'] === '27') {
                    $_SESSION['reprogramacionEnsayoHojaTrabajo'] = true;
                }
                if ($unDato['id_permiso'] === '28') {
                    $_SESSION['ConsultaMuestrasEst'] = true;
                }
                if ($unDato['id_permiso'] === '29') {
                    $_SESSION['historicoEstadosMuestra'] = true;
                }
                if ($unDato['id_permiso'] === '30') {
                    $_SESSION['registrarCotizacion'] = 'true';
                }

                if ($unDato['id_permiso'] === '31') {
                    $_SESSION['regEstCotizacion'] = 'true';
                }

                if ($unDato['id_permiso'] === '32') {
                    $_SESSION['adminMetodos'] = 'true';
                }
                if ($unDato['id_permiso'] === '35') {
                    $_SESSION['muestraDocsBotonEliminarArchivos'] = 'true';
                }
                if ($unDato['id_permiso'] === '36') {
                    $_SESSION['registrarEstabilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '37') {
                    $_SESSION['consultarEstabilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '38') {
                    $_SESSION['documentosEstabilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '39') {
                    $_SESSION['adminInformes'] = 'true';
                }
                if ($unDato['id_permiso'] === '40') {
                    $_SESSION['informeDisponibilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '41') {
                    $_SESSION['informeEstadoMuestras'] = 'true';
                }
                if ($unDato['id_permiso'] === '42') {
                    $_SESSION['informeListadePrecios'] = 'true';
                }
                if ($unDato['id_permiso'] === '43') {
                    $_SESSION['informeGenerarStikers'] = 'true';
                }


                if ($unDato['id_permiso'] === '44') {
                    $_SESSION['informeEstadistico'] = 'true';
                }
                if ($unDato['id_permiso'] === '46') {
                    $_SESSION['informeGenerarHCPlanta'] = 'true';
                }
                if ($unDato['id_permiso'] === '47') {
                    $_SESSION['informeGenerarInformePlanta'] = 'true';
                }

                if ($unDato['id_permiso'] === '48') {
                    $_SESSION['adminReactivos'] = 'true';
                }
                if ($unDato['id_permiso'] === '49') {
                    $_SESSION['adminMediosCultivo'] = 'true';
                }
                if ($unDato['id_permiso'] === '50') {
                    $_SESSION['adminCepas'] = 'true';
                }

                if ($unDato['id_permiso'] === '51') {
                    $_SESSION['checkAnalisisRealizadoHojaTrabajo'] = true;
                }

                if ($unDato['id_permiso'] === '52') {
                    $_SESSION['aprobarMuestraHojaTrabajo'] = true;
                }

                if ($unDato['id_permiso'] === '53') {
                    $_SESSION['adminBandejasEntrada'] = 'true';
                }

                if ($unDato['id_permiso'] === '54') {
                    $_SESSION['adminEnsayoEquipo'] = 'true';
                }
                if ($unDato['id_permiso'] === '55') {
                    $_SESSION['revisarMuestraHojaTrabajo'] = true;
                }
                if ($unDato['id_permiso'] === '56') {
                    $_SESSION['adminEditarMuestra'] = 'true';
                }
                if ($unDato['id_permiso'] === '57') {
                    $_SESSION['adminColumnas'] = 'true';
                }
                if ($unDato['id_permiso'] === '58') {
                    $_SESSION['adminCondiciones'] = 'true';
                }
                if ($unDato['id_permiso'] === '59') {
                    $_SESSION['adminProductoCondiciones'] = 'true';
                }
                if ($unDato['id_permiso'] === '157') {
                    $_SESSION['registrarEstabilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '158') {
                    $_SESSION['programarEstabilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '159') {
                    $_SESSION['resultadosEstabilidad'] = 'true';
                }
                if ($unDato['id_permiso'] === '160') {
                    $_SESSION['adminEstabilidades'] = 'true';
                }
                if ($unDato['id_permiso'] === '161') {
                    $_SESSION['informeReactivos'] = 'true';
                }
                if ($unDato['id_permiso'] === '162') {
                    $_SESSION['informeEstandares'] = 'true';
                }
                if ($unDato['id_permiso'] === '60') {
                    $_SESSION['adminUsuarioCliente'] = 'true';
                }
                if ($unDato['id_permiso'] === '163') {
                    $_SESSION['permiso-163'] = 'true';
                }
                if ($unDato['id_permiso'] === '61') {
                    $_SESSION['activarLoteReactivo'] = 'true';
                }
                if ($unDato['id_permiso'] === '62') {
                    $_SESSION['activarLoteEstandar'] = 'true';
                }
                if ($unDato['id_permiso'] === '63') {
                    $_SESSION['anularMuestra'] = true;
                }
                if ($unDato['id_permiso'] === '64') {
                    $_SESSION['botonInformePrevio'] = true;
                }
                if ($unDato['id_permiso'] === '65') {
                    $_SESSION['botonHojaRuta'] = true;
                }
                if ($unDato['id_permiso'] === '66') {
                    $_SESSION['botonAnexos'] = true;
                }
                if ($unDato['id_permiso'] === '171') {
                    $_SESSION['eventoMuestra'] = 'true';
                }
            }
        }
    }

    function loadPermisionsBandejaEntrada($userPerfil) {
        $tabla = new TablaPerfilPermisoBandejaEntradaDbModelClass();
        $result = $tabla->getPerfilPermisosBandejaEntrada($userPerfil);

        $_SESSION['muestrasVerificadas'] = false;
        $_SESSION['muestrasXProgramarFQ'] = false;
        $_SESSION['muestrasXProgramarMB'] = false;
        $_SESSION['EnsayosEstadoProgramado'] = false;
        $_SESSION['EnsayosEstadoParaTranscrip'] = false; //en BD el Numero 28
        $_SESSION['ensayosParaRevisionFQ'] = false;
        $_SESSION['ensayosParaRevisionMB'] = false;
        $_SESSION['muestrasParaVerificar'] = false;

        $_SESSION['subMuestrasEstabilidadParaProgramar'] = false;
        $_SESSION['subMuestrasEstabilidadParaAnalisis'] = false;
        $_SESSION['subMuestrasEstabilidadParaTrancripcion'] = false;
        $_SESSION['subMuestrasEstabilidadParaRevision'] = false;
        $_SESSION['muestrasParaFacturacion'] = false;
        $_SESSION['muestrasParaEntrega'] = false;
        $_SESSION['muestrasSalida'] = false;

        $_SESSION['solicitudesParaRecoleccion'] = false;
        $_SESSION['solicitudesProgramadas'] = false;

        $_SESSION['subMuestrasEstabilidadAprobadas'] = false;
        $_SESSION['subMuestrasEstabilidadRevisionSinEnsayos'] = false;
        $_SESSION['graficaMuestrasPorEstado'] = false;
        $_SESSION['graficaMuestrasPorTipoProducto'] = false;

        $_SESSION['subMuestrasEstabilidadTerminadas'] = false;
        $_SESSION['muestrasTerminadas'] = false;
        $_SESSION['muestrasGrillaGerencial'] = false;
        $_SESSION['muestrasEstabilidadGrillaGerencial'] = false;
        $_SESSION['graficaUsoReactivos'] = false;
        $_SESSION['graficaUsoEstandares'] = false;
        $_SESSION['graficaParticipacionClientes'] = false;
        $_SESSION['graficaParticipacionClientesEst'] = false;
        $_SESSION['muestrasProgramadasTercero'] = false;
        $_SESSION['muestrasEstProgramadasTercero'] = false;
        $_SESSION['graficaDesempenoAnalistas'] = false;


        $bandejaPermisos = $result['data'];

        foreach ($bandejaPermisos as $permisoBE) {
            if ($permisoBE->id_permiso_bandeja == '1') {
                $_SESSION['muestrasVerificadas'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '2') {
                $_SESSION['muestrasXProgramarFQ'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '3') {
                $_SESSION['muestrasXProgramarMB'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '4') {
                $_SESSION['EnsayosEstadoProgramado'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '5') {
                $_SESSION['EnsayosEstadoParaTranscrip'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '6') {
                $_SESSION['ensayosParaRevisionFQ'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '7') {
                $_SESSION['ensayosParaRevisionMB'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '8') {
                $_SESSION['muestrasParaVerificar'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '10') {
                $_SESSION['subMuestrasEstabilidadParaProgramar'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '11') {
                $_SESSION['subMuestrasEstabilidadParaAnalisis'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '12') {
                $_SESSION['subMuestrasEstabilidadParaTrancripcion'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '13') {
                $_SESSION['subMuestrasEstabilidadParaRevision'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '14') {
                $_SESSION['muestrasParaFacturacion'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '15') {
                $_SESSION['muestrasParaEntrega'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '16') {
                $_SESSION['muestrasSalida'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '17') {
                $_SESSION['solicitudesParaRecoleccion'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '18') {
                $_SESSION['solicitudesProgramadas'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '19') {
                $_SESSION['subMuestrasEstabilidadAprobadas'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '20') {
                $_SESSION['subMuestrasEstabilidadRevisionSinEnsayos'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '21') {
                $_SESSION['graficaMuestrasPorEstado'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '22') {
                $_SESSION['graficaMuestrasPorTipoProducto'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '23') {
                $_SESSION['subMuestrasEstabilidadTerminadas'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '24') {
                $_SESSION['muestrasTerminadas'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '25') {
                $_SESSION['muestrasGrillaGerencial'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '26') {
                $_SESSION['muestrasEstabilidadGrillaGerencial'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '27') {
                $_SESSION['graficaUsoReactivos'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '28') {
                $_SESSION['graficaUsoEstandares'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '29') {
                $_SESSION['graficaParticipacionClientes'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '30') {
                $_SESSION['graficaParticipacionClientesEst'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '31') {
                $_SESSION['muestrasProgramadasTercero'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '32') {
                $_SESSION['muestrasEstProgramadasTercero'] = true;
            }
            if ($permisoBE->id_permiso_bandeja == '33') {
                $_SESSION['graficaDesempenoAnalistas'] = true;
            }
        }
    }

    function getDbName() {
        return $this->dbName;
    }

    function getConexion() {
        return $this->conexion;
    }

    function getHost() {
        return $this->host;
    }

    function getDbPort() {
        return $this->dbPort;
    }

    function getUser() {
        return $this->user;
    }

    function getPassword() {
        return $this->password;
    }

///obfustation
    function aleatorio($id) {
        $a = date("i");
        $b = 'soulsystemsas';
        $e = date("s");
        $f = date("is");
        $x = ($id * 21);
        $u = strlen($x);
        $aleatorium = base64_encode($e . $u . $a . $f . $x . $b . $f);
        return $aleatorium;
    }

    function oirotaela($id) {
        $elemento = base64_decode($id);
        $e = substr($elemento, 2, 1);
        $val = substr($elemento, 9, $e);
        $result = $val / 21;
        return $result;
    }

    function getParametrosExisten() {
        return $this->parametrosExisten;
    }

}
