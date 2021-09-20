<?php

/**
 * Description of basicController
 *
 * @author hruge

require_once 'vendor/autoload.php';
require_once 'eloquent/database.php';
 */



require 'AdministracionController.php';
require 'ConsultaQrController.php';
require 'ConsultaHojaRutaMuestraController.php';
require 'EnsayoMuestraController.php';
require 'estabilidad/RegEstCotizacionController.php';
require 'informes/informesController.php';
require 'LoginController.php';
require 'MuestraController.php';
require 'ProgramacionController.php';
require 'CotizacionController.php';
require 'GeneralController.php';
require_once 'RenderController.php';
require 'QueryDbController.php';
require 'UtilsController.php';
require 'ResultadoController.php';
require 'AuditoriaController.php';
require 'custom/CustomController.php';
require 'CustomEstadisticaController.php';



require 'model/AdministracionModelClass.php';
require 'model/ConsultaHojaRutaMuestraModelClass.php';
require 'model/estabilidad/RegEstCotizacionModelClass.php';
require 'model/informes/informesModelClass.php';
require 'model/TemplateModelClass.php';
require 'model/MuestraModelClass.php';
require 'model/ProgramacionModelClass.php';
require 'model/CotizacionModelClass.php';
require 'model/LoginModelClass.php';
require 'model/DbClass.php';
require 'model/DB/TablaAlmacenamientoDbModelClass.php';
require 'model/DB/TablaAreaAnalisisEnsayoDbModelClass.php';
require 'model/DB/TablaAreaMicrobiologicaDbModelClass.php';
require 'model/DB/TablaCalendarioBaseDbModelClass.php';
require 'model/DB/TablaCalendarioFestivosDbModelClass.php';
require 'model/DB/TablaCepaDbModelClass.php';
require 'model/DB/TablaCargoDbModelClass.php';
require 'model/DB/TablaContactoDbModel.php';
require 'model/DB/TablaCotizacionDbModelClass.php';
require 'model/DB/TablaEstCotizacionDbModel.php';
require 'model/DB/TablaEstandarAudDbModelClass.php';
require 'model/DB/TablaEmpaqueDbModelClass.php';
require 'model/DB/TablaEnvaseDbModelClass.php';
require 'model/DB/TablaCotizacionProductoDbModelClass.php';
require 'model/DB/TablaCotProEnsayoDbModelClass.php';
require 'model/DB/TablaEnsayoDbModelClass.php';
require 'model/DB/TablaEnsayoMuestraDbModelClass.php';
require 'model/DB/TablaEnsayoPaqueteDbModelClass.php';
require 'model/DB/TablaEnvioCotizacionDbModelClass.php';
require 'model/DB/TablaEquiposDbModelClass.php';
require 'model/DB/TablaEstandarDbModelClass.php';
require 'model/DB/TablaEstCotEnsDbModelClass.php';
require 'model/DB/TablaEstEnsayoSubmuestraDbModelClass.php';
require 'model/DB/TablaEnvioEstCotizacionDbModelClass.php';
require 'model/DB/TablaEstTiemposCotEnsDbModelClass.php';
require 'model/DB/TablaEstTiemposEnsMueDbModelClass.php';
require 'model/DB/TablaFormaDbModelClass.php';
require 'model/DB/TablaHistoricoEstadoMuestraDbModelClass.php';
require 'model/DB/TablaHistoricoEstadoSubMuestraDbModelClass.php';
require 'model/DB/TablaLoteCepaDbModelClass.php';
require 'model/DB/TablaLoteDbModelClass.php';
require 'model/DB/TablaLoteMedioCultivoDbModelClass.php';
require 'model/DB/TablaMetodoDbModelClass.php';
require 'model/DB/TablaMedioCultivoDbModelClass.php';
require 'model/DB/TablaMuestraDbModelClass.php';
require 'model/DB/TablaMuestraDetalleMicDbModelClass.php';
require 'model/DB/TablaMuestraHojaCalculoDbModelClass.php';
require 'model/DB/TablaPerfilDbModelClass.php';
require 'model/DB/TablaPerfilPermisoDbModelClass.php';
require 'model/DB/TablaProductoDBModelClass.php';
require 'model/DB/TablaPlantillaDbModelClass.php';
require 'model/DB/TablaProductoPaqueteDBModelClass.php';
require 'model/DB/TablaProductoEnsayoDbModelClass.php';
require 'model/DB/TablaProgramacionAnalistasDbModelClass.php';
require 'model/DB/TablaPrincipioActivoProductoDbModelClass.php';
require 'model/DB/TablaResultadoDbModelClass.php';
require 'model/DB/TablaResultadoMediosCultivoDbModelClass.php';
require 'model/DB/TablaResultadoCepasDbModelClass.php';
require 'model/DB/TablaReactivoDbModelClass.php';
require 'model/DB/TablaRepositorioDbModelClass.php';
require 'model/DB/TablaSubMuestraEstDbModelClass.php';
require 'model/DB/TablaTecnicaUsadaMuestraMicDbModelClass.php';
require 'model/DB/TablaTerceroDbModelClass.php';
require 'model/DB/TablaUsuariosDbModelClass.php';
require 'model/DB/TablaAreaAnalisisDbModel.php';
require 'model/DB/TablaTipoMuestraDbModelClass.php';
require 'model/DB/TablaLoteReactivoDbModelClass.php';
require 'model/DB/TablaLoteEstandarDbModelClass.php';
require 'model/DB/TablaPermisoBandejaEntradaDbModelClass.php';
require 'model/DB/TablaPerfilPermisoBandejaEntradaDbModelClass.php';
require 'model/DB/TablaEnsayoEquipoDbModelClass.php';
require 'model/DB/TablaProductoEnsayoReactivoDbModelClass.php';
require 'model/DB/TablaProductoEnsayoEstandarDbModelClass.php';
require 'model/DB/TablaColumnaDbModelClass.php';
require 'model/DB/TablaColumnaPrincipioActivoDbModelClass.php';
require 'model/DB/TablaCondicionCromatograficaDbModelClass.php';
require 'model/DB/TablaEnsayoMuestraEstandarLoteDbModelClass.php';
require 'model/DB/TablaEnsayoMuestraReactivoLoteDbModelClass.php';
require 'model/DB/TablaEnsayoMuestraCondicionCromatograficaDbModelClass.php';
require 'model/DB/TablaProductoPrincipioActivoDbModelClass.php';
require 'model/DB/TablaClienteUsuarioDbModelClass.php';
require 'model/DB/TablaClientePermisoDbModelClass.php';
require 'model/DB/TablaFestivosDbModelClass.php';
require 'model/DB/TablaSystemParametersDbModelClass.php';
require 'model/DB/TablaTipoIdentificacionDbModelClass.php';
require 'model/DB/TablaCiudadDbModelClass.php';
require 'model/DB/TablaEstMuestraDbModelClass.php';
require 'model/DB/TablaTipoProductoDbModelClass.php';

//
//Tablas de Auditoria
require 'model/DB/TablaEstandarLoteAudDbModelClass.php';




require 'model/DB/TablaPrincipioActivoDbModelClass.php';
require 'model/DB/ViewEnsayoMuestraReferenciasDbModelClass.php';
require 'model/DB/ViewProductoPrincipioActivoDbModelClass.php';
require 'model/DB/ViewProductoPaquetesEnsayosDbModelClass.php';
require 'model/DB/ViewMuestraReferenciasDbModel.php';
require 'model/DB/storeProcedures/SPInsertEnvioCotizacionDbModel.php';

// Medoo import //
require 'model/DbMedoo/MedooDbModelClass.php';
require 'model/DbMedoo/Tablas/TablaAreaMicrobiologicaMedooDbModelClass.php';
require 'model/DbMedoo/Tablas/TablaMetodoMedooDbModelClass.php';
require 'model/DbMedoo/Tablas/TablaTipoMuestraMedooDbModelClass.php';

require_once 'eloquent/models/Almacenamiento.php';
require_once 'eloquent/models/Cepa.php';
require_once 'eloquent/models/CepaAud.php';
require_once 'eloquent/models/ClienteUsuario.php';
require_once 'eloquent/models/ClienteUsuarioPermiso.php';
require_once 'eloquent/models/Columna.php';
require_once 'eloquent/models/ColumnaAud.php';
require_once 'eloquent/models/ColumnaPrincipioActivo.php';
require_once 'eloquent/models/CondicionCromatografica.php';
require_once 'eloquent/models/CondicionCromatograficaAud.php';
require_once 'eloquent/models/Contacto.php';
require_once 'eloquent/models/Empaque.php';
require_once 'eloquent/models/EmpaqueAud.php';
require_once 'eloquent/models/Ensayo.php';
require_once 'eloquent/models/EnsayoAud.php';
require_once 'eloquent/models/EnsayoEquipo.php';
require_once 'eloquent/models/EnsayoMedioCultivo.php';
require_once 'eloquent/models/EnsayoMuestra.php';
require_once 'eloquent/models/EnsayoMuestraCondicionCromatografica.php';
require_once 'eloquent/models/EnsayoMuestraEstandarLote.php';
require_once 'eloquent/models/EnsayoMuestraHojaCalculo.php';
require_once 'eloquent/models/EnsayoMuestraHojaCalculoAud.php';
require_once 'eloquent/models/EnsayoMuestraReactivoLote.php';
require_once 'eloquent/models/EnsayoPaquete.php';
require_once 'eloquent/models/Envase.php';
require_once 'eloquent/models/EnvaseAud.php';
require_once 'eloquent/models/Equipo.php';
require_once 'eloquent/models/EquipoAud.php';
require_once 'eloquent/models/Estado.php';
require_once 'eloquent/models/EstadoEnsayoMuestra.php';
require_once 'eloquent/models/Estandar.php';
require_once 'eloquent/models/EstandarAud.php';
require_once 'eloquent/models/EstDuracionEstabilidad.php';
require_once 'eloquent/models/EstMuestra.php';
require_once 'eloquent/models/EstSubMuestra.php';
require_once 'eloquent/models/EstEnsayoSubMuestra.php';
require_once 'eloquent/models/EstTemperatura.php';
require_once 'eloquent/models/EstTipoEstabilidad.php';
require_once 'eloquent/models/FormaFarmaceutica.php';
require_once 'eloquent/models/FormaFarmaceuticaAud.php';
require_once 'eloquent/models/Lote.php';
require_once 'eloquent/models/LoteCepa.php';
require_once 'eloquent/models/LoteEstandar.php';
require_once 'eloquent/models/LoteMedioCultivo.php';
require_once 'eloquent/models/LoteReactivo.php';
require_once 'eloquent/models/MedioCultivo.php';
require_once 'eloquent/models/MedioCultivoAud.php';
require_once 'eloquent/models/MedioCultivoCepa.php';
require_once 'eloquent/models/Metodo.php';
require_once 'eloquent/models/MetodoAud.php';
require_once 'eloquent/models/Modulo.php';
require_once 'eloquent/models/Muestra.php';
require_once 'eloquent/models/MuestraAud.php';
require_once 'eloquent/models/MuestraDetalleMic.php';
require_once 'eloquent/models/Paquete.php';
require_once 'eloquent/models/PaqueteAud.php';
require_once 'eloquent/models/Perfil.php';
require_once 'eloquent/models/PerfilAud.php';
require_once 'eloquent/models/Permiso.php';
require_once 'eloquent/models/PermisoBandejaEntrada.php';
require_once 'eloquent/models/PerfilPermiso.php';
require_once 'eloquent/models/PerfilPermisoBandejaEntrada.php';
require_once 'eloquent/models/Plantilla.php';
require_once 'eloquent/models/PrincipioActivo.php';
require_once 'eloquent/models/PrincipioActivoAud.php';
require_once 'eloquent/models/Producto.php';
require_once 'eloquent/models/ProductoAud.php';
require_once 'eloquent/models/ProductoEnsayo.php';
require_once 'eloquent/models/ProductoEnsayoEstandar.php';
require_once 'eloquent/models/ProductoEnsayoReactivo.php';
require_once 'eloquent/models/ProductoPaquete.php';
require_once 'eloquent/models/ProductoPrincipioActivo.php';
require_once 'eloquent/models/ProgramacionAnalistas.php';
require_once 'eloquent/models/Reactivo.php';
require_once 'eloquent/models/ReactivoAud.php';
require_once 'eloquent/models/Resultados.php';
require_once 'eloquent/models/SystemParameters.php';
require_once 'eloquent/models/Tercero.php';
require_once 'eloquent/models/TerceroAud.php';
require_once 'eloquent/models/TipoMuestra.php';
require_once 'eloquent/models/TipoMuestraAud.php';
require_once 'eloquent/models/TipoMuestraEquipo.php';
require_once 'eloquent/models/Usuario.php';
require_once 'eloquent/models/UsuarioAud.php';

class basicController {

    function start() {
        date_default_timezone_set("America/Bogota");
        if ($_SESSION['logued'] == true) {

            if ($_GET['action'] == 'cerrar') {
                $db = new DbClass();
                $db->conexion();
                $db->deleteUidByUser($_SESSION['userId']);
                session_destroy();
                header('Location:index.php');
            } elseif ($_GET["action"] == "render") {
                $render = new RenderController();
            } elseif ($_GET['action'] == 'prueba') {
                \PHPQRCode\QRcode::png("www.google.com", "qrcode.png", 'L', 4, 2);
            }
            ///////Inicio Muestras////////
            elseif ($_GET['action'] == 'regmuestra') {
                if ($_SESSION['RegistrarMuestras'] == 'true') {
                    $muestraController = new MuestraController();
                    $muestraController->regMuestraPaint();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'saveMuestra') {
                if ($_POST['activa'] == 'true') {
                    $activa = 1;
                } else {
                    $activa = 1;
                }
                if ($_POST['facturarMuestra'] == 'true') {
                    $facturaMuestra = 1;
                } else {
                    $facturaMuestra = 0;
                }
                $muestraController = new MuestraController();
                $muestraController->saveMuestra(1, $activa, $_POST['hprioridad'], $_POST['numCotizacion'], $_POST['numRemision'], $_POST['fechaLlegada'], $_POST['fechaCompromiso'], $_POST['hnomCliente'], $_POST['contactoSolicitante'], $_POST['areaContacto'], $_POST['labSolicitante'], $_POST['procedencia'], $_POST['numInforme'], $_POST['observaciones'], $_POST['areaAnalisis'], $_POST['tipoEstabilidad'], $_POST['areaAnalisis'], $_POST['hduracion'], $_POST['hnomProducto'], $_POST['empaque'], $_POST['envase'], $_POST['fechaFabricacion'], $_POST['fechaVencimiento'], 5, $facturaMuestra, $_POST['hcantidad'], 4, $_POST['hanticipo'], $_POST['hdescuento'], $_POST['hsaldo'], $_POST['hensayo'], $_POST['hlotes']);
            } elseif ($_GET['action'] == 'updateMuestra') {
                $muestraController = new MuestraController();
                echo $muestraController->updateMuestra($_POST['idMuestra'], $_POST['activa'], $_POST['prioridad'], $_POST['cotizacion'], $_POST['remision'], $_POST['fechaLlegada'], $_POST['fechaCompromiso'], $_POST['idTercero'], $_POST['idContacto'], $_POST['areaContacto'], $_POST['laboratorio'], $_POST['procedencia'], $_POST['numeroInfo'], $_POST['observaciones'], $_POST['areaAnalisis'], $_POST['tipoEstabilidad'], $_POST['areaAnalisis'], $_POST['duracion'], $_POST['idProducto'], $_POST['idEmpaque'], $_POST['idEnvase'], $_POST['fechaFabricacion'], $_POST['fechaVencimiento'], $_POST['esfacturable'], $_POST['numFactura'], $_POST['descuento'], $_POST['cantidad'], $_POST['anticipo'], $_POST['saldo'], $_POST['infoLotes'], $_POST['infoEnsayos']);
            } elseif ($_POST['action'] == 'updateFechaProgramada') {
                $programacionController = new ProgramacionController();
                echo $programacionController->updateFechaProgramadaActividad($_POST['idProgramacion'], $_POST['newDate'], $_SESSION['userId']);
            } elseif ($_GET['action'] == 'almacenmuestra') {
                if ($_SESSION['HistorialAlmacenamiento'] == 'true') {
                    $muestraController = new MuestraController();
                    $muestraController->almacenMuestraPaint();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'saveAlmacenamiento') {
                $muestraController = new MuestraController();
                $muestraController->saveAlmacenamiento($_POST['idMuestra'], $_POST['fecha'], $_POST['idUbicacion'], $_POST['idTipoAlmacenamiento'], $_POST['nivel'], $_POST['caja'], $_POST['tiempo'], $_POST['fechaSalida'], $_POST['peso'], $_POST['observaciones']);
            } elseif ($_POST['action'] == 'deleteAlmacenamiento') {
                $muestraController = new MuestraController();
                $muestraController->deleteAlmacenamiento($_POST['idAlmacenamiento']);
            } elseif ($_GET['action'] == 'historicoEstadosMuestra') {
                if (1 == 1) {
                    $muestraController = new MuestraController();
                    $muestraController->historicoEstadosMuestraPaint();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'consultaMuestras') {
                if ($_SESSION['ConsultaMuestras'] == 'true') {
                    $muestraController = new MuestraController();
                    $muestraController->consultaMuestrasPaint();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'consultaMuestrasEst') {
                if ($_SESSION['ConsultaMuestrasEst'] == 'true') {
                    $muestraController = new MuestraController();
                    $muestraController->consultaMuestrasEstPaint();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'scanDirByIdMuestra') {
                $muestraController = new MuestraController();
                $muestraController->scanDirByIdMuestra($_GET['idMuestra']);
            } elseif ($_POST['action'] == 'createNewFolderDocsMuestra') {
                $muestraController = new MuestraController();
                $muestraController->createNewFolderByLocation($_POST['location'], $_POST['newFolderName']);
            } elseif ($_POST['action'] == 'deleteOrFileFolder') {
                $muestraController = new MuestraController();
                $muestraController->deleteFileOrFolder($_POST['location']);
            } elseif ($_GET['action'] == 'uploadFile') {
                $muestraController = new MuestraController();
                $muestraController->uploadFile($_GET['location']);
            } elseif ($_GET['action'] == 'docsMuestra') {
                if ($_SESSION['DocsMuestra'] == 'true') {
                    $muestraController = new MuestraController();
                    $muestraController->docsMuestraPaint();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } else if ($_GET['action'] == "getEnsayosMuestraEstabilidad") {
                $muestraController = new MuestraController();
                $muestraController->getEnsayosMuestraEstabilidad($_GET['idMuestra']);
            } else if ($_GET['action'] == "getEstadoMuestra") {
                $muestraController = new MuestraController();
                $muestraController->getEstadoMuestraByIdMuestra($_GET['idMuestra']);
            } else if ($_GET['action'] == "updateFacturacionMuestra") {
                $muestraController = new MuestraController();
                $muestraController->updateFaturacionMuestra($_GET['idMuestra'], $_GET['cantidad'], $_GET['numFactura'], $_GET['anticipo'], $_GET['descuento'], $_GET['saldo']);
            }
            //Fin de Muestras////
            // Inicio de Modulo  de estabilidades ////////////
            elseif ($_GET['action'] == 'regEstCotizacion') {
                if ($_SESSION['regEstCotizacion'] == 'true') {
                    $regEstController = new RegEstCotizacionController();
                    $regEstController->paintRegEstCotizacionModule();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'registrarEstabilidad') {
                $regEstController = new RegEstCotizacionController();
                $regEstController->paintRegistroEstabilidadModule();
            } elseif ($_POST['action'] == 'insertEstCotizacion') {
                $regEstController = new RegEstCotizacionController();
                $regEstController->insertEstCotizacion($_POST['fechaSolicitud'], $_POST['fechaCompromiso'], $_POST['tercero'], $_POST['contacto'], $_POST['telContacto'], $_POST['producto'], $_POST['tipoEstabilidad'], $_POST['tiempos'], $_POST['observaciones'], $_POST['observaciones2'], $_POST['observaciones3'], $_POST['aplicaIva'], $_POST['aplicaRetencion'], $_POST['hensayos']);
            } elseif ($_GET['action'] == 'consultarEstabilidad') {
                $regEstController = new RegEstCotizacionController();
                $regEstController->paintConsultaEstabilidadModule();
            } elseif ($_GET['action'] == 'adjuntarDocsEstabilidad') {
                $regEstController = new RegEstCotizacionController();
                $regEstController->paintDocumentosEstabilidadModule();
            } elseif ($_GET['action'] == 'searchEstCotizacionById') {
                $regEstController = new RegEstCotizacionController();
                $regEstController->searchEstCotizacionById($_GET['id']);
            } elseif ($_POST['action'] == 'guardarEnvioEstCotizacion') {
                $regEstController = new RegEstCotizacionController();
                $regEstController->guardarEnvioEstCotizacion($_POST['idCotizacion'], $_POST['destino'], $_POST['medio'], $_POST['observaciones']);
            } elseif ($_POST['action'] == "updateEstCotizacion") {
                $regEstController = new RegEstCotizacionController();
                $regEstController->updateEstCotizacion($_POST['cotizacion']);
            }
            // Fin de Modulo  de estabilidades ////////////
            //Inicio Modulo de Cotizaciones/////////
            elseif ($_GET['action'] == 'registrarCotizacion') {
                if ($_SESSION['registrarCotizacion'] == 'true') {
                    $cotizacionController = new CotizacionController();
                    $cotizacionController->paintRegistrarCotizacion();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'saveCotizacion') {
                $cotizacionController = new CotizacionController();
                $cotizacionController->saveCotizacion($_POST['estado'], $_POST['fechaSol'], $_POST['fechaCom'], $_POST['idCliente'], $_POST['nomContacto'], $_POST['telContacto'], $_POST['observaciones'], $_POST['observacionesFin'], $_POST['aplicaIva'], $_POST['aplicaRetenciones'], $_POST['ensayos']);
            } elseif ($_POST['action'] == 'updateCotizacion') {
                $cotizacionController = new CotizacionController();
                $cotizacionController->updateCotizacion($_POST['idCotizacion'], $_POST['estado'], $_POST['fechaSol'], $_POST['fechaCom'], $_POST['idCliente'], $_POST['nomContacto'], $_POST['telContacto'], $_POST['observaciones'], $_POST['observacionesFin'], $_POST['ensayos'], $_POST['aplicaIva'], $_POST['aplicaRetencion']);
            } elseif ($_POST['action'] == 'insertEnvioCotizacion') {
                $modelSPInsertEnvioCotizacion = new SPInsertEnvioCotizacionDbModel();
                $data = $modelSPInsertEnvioCotizacion->spConsultaCotizaciones($_POST['idCotizacion'], $_POST['destino'], $_POST['medio'], $_POST['observaciones']);
                echo json_encode($data);
            } elseif ($_GET['action'] == 'consultaCotizacion') {
                if ($_SESSION['consultaCotizacion'] == 'true') {
                    $cotizacionController = new CotizacionController();
                    $cotizacionController->paintConsultaCotizacion();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'rechazarCotizacion') {
                $cotizacionController = new CotizacionController();
                $cotizacionController->rechazarCotizacion($_POST['idCotizacion'], $_POST['motivo']);
            } elseif ($_POST['action'] == 'rechazarEstCotizacion') {
                $estCotizacionController = new RegEstCotizacionController();
                $estCotizacionController->rechazarCotizacion($_POST['idCotizacion'], $_POST['motivo']);
            }
            //////////Fin de modulo de Cotizaciones/////////
            //Inicio de Programacion/////////////
            elseif ($_GET['action'] == 'programacionAnalistas') {
                if ($_SESSION['subMenuProgramacionAnalistas'] == 'true') {
                    $programacionController = new ProgramacionController();
                    $programacionController->paintProgramacionAnalistas();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'programacion-analistas-2') {
                if ($_SESSION['subMenuProgramacionAnalistas'] == 'true') {
                    $renderController = new RenderController();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'programarEnsayoAnalista') {
                $programacionController = new ProgramacionController();
                $programacionController->ProgramarEnsayoMuestraAnalista($_POST['idEnsayoMuestra'], $_POST['equipo'], $_POST['turno'], $_POST['fechaProg'], $_POST['fechaCompInterno'], $_POST['duracion'], $_POST['observaciones'], $_POST['idAnalista'], $_POST['especificacion']);
            } elseif ($_POST['action'] == 'deleteProgramacionByIdEnsayoMuestra') {
                $programacionController = new ProgramacionController();
                $programacionController->deleteProgramacion($_POST['idEnsayoMuestra'], $_POST['motivo']);
            } elseif ($_GET['action'] == 'consultaDisponibilidadUsuarios') {
                if ($_SESSION['subMenuCOnsultaDisponibilidadUsuarios'] == 'true') {
                    $programacionController = new ProgramacionController();
                    $programacionController->paintConsultaDisponibilidadUsuarios();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            }
            //Fin de Programacion/////////////
            //Inicio de Fisicoquimico y Microbiologia/////////////
            elseif ($_GET['action'] == 'ConsultaHojaRutaMuestra') {
                if ($_SESSION['subMenuConHojaRutaMuestra'] == 'true') {
                    $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                    $consultaHojaRutaMuestraController->paintConsultaHojaRutaMuestra();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            }

            //Hoja de trabajo , aprobacion o Rechazo
            elseif ($_POST['action'] == 'reprogramarEnsayoMuestra') {
                $conHojaRutaController = new ConsultaHojaRutaMuestraController();
                $conHojaRutaController->reprogramarEnsayoMuestra($_POST['idEnsayoMuestra'], $_POST['observaciones']);
            } elseif ($_POST['action'] == 'rechazaMuestra') {
                $conHojaRutaController = new ConsultaHojaRutaMuestraController();
                $conHojaRutaController->rechazaMuestra($_POST['idMuestra']);
            } elseif ($_GET['action'] == 'registrarConclusion') {
                $modelTablaMuestra = new TablaMuestraDbModelClass();
                if ($modelTablaMuestra->updateConclusionByIdMuestra($_POST['idMuestra'], $_POST['conclusion'])) {
                    $response = array('result' => 0, 'message' => 'Se registro la conclusion exitosamente');
                } else {
                    $response = array('result' => 1, 'message' => 'Fallo el registro de la conclusion');
                }
                echo json_encode($response);
            } elseif ($_GET['action'] == 'contarEnsayosSinRevision') {
                $modelEnsayoMuestra = new TablaEnsayoMuestraDbModelClass();
                $cantidad = $modelEnsayoMuestra->contarEnsayosSinRevisionByIdMuestra($_GET['idMuestra']);
                echo json_encode($cantidad);
            }

            //Actualizar Resultados
            elseif ($_POST['action'] == 'updateEnsayoConHojaRutaMuestra') {
                $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                $consultaHojaRutaMuestraController->revisarEnsayoMuestraConHojaRutaMuestra($_POST['idEnsayoMuestra'], $_POST['aprobado'], $_POST['tipoRevision'], $_POST['observaciones']);
            } elseif ($_POST['action'] == 'validarEnsayosSubMuestra') {
                $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                $consultaHojaRutaMuestraController->validarEnsayosSubMuestra($_POST["idMuestra"]);
            } elseif ($_POST['action'] == 'registrarConclusionSubmuestra') {
                $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                $consultaHojaRutaMuestraController->registrarConclusionSubmuestra($_POST["idSubMuestra"], $_POST["conclusion"]);
            }
            //Guardar Resultados                
            elseif ($_POST['action'] == 'saveResultado') {
                $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                $consultaHojaRutaMuestraController->saveResultado($_POST['idEnsayoMuestra'], $_POST['idLote'], $_POST['resultado'], $_POST['observaciones'], $_SESSION['userId'], $_POST['fechaRegistro'], $_POST['resultadoNumerico'], $_POST['resultado1'], $_POST['resultado2'], $_POST['mediosCultivo'], $_POST['cepas']);
            }
            // Actualizar Resultado
            elseif ($_POST['action'] == 'updateResultado') {
                $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                $consultaHojaRutaMuestraController->updateResultado($_POST['idResultado'], $_POST['idLote'], $_POST['resultado'], $_POST['observaciones'], $_SESSION['userId'], $_POST['fechaRegistro'], $_POST['resultado1'], $_POST['resultado2'], $_POST['medios'], $_POST['cepas'], $_POST['resultadoNumerico']);
            }
            //Impresion de Hoja de Ruta u Hoja de Trabajo                
            elseif ($_GET['action'] == 'hojaRutaPrint') {
                $consultaHojaRutaMuestraController = new ConsultaHojaRutaMuestraController();
                $consultaHojaRutaMuestraController->paintHojaRutaPrint();
            }
            //Inicio de Fisicoquimico y Microbiologia/////////////
            // Inicio de Modulo  de informes ////////////
            elseif ($_GET['action'] == 'informeDisponibilidadUsuario') {

                $regEstController = new informesController();
                $regEstController->paintinformeDisponibilidadUsuario();
            } elseif ($_GET['action'] == 'verInformeDisponibilidadPDF') {
                //echo 'Hola';
                $regEstController = new informesController();
                //$regEstController->paintinformeDisponibilidadUsuarioPDF($_POST['identidad']);
                $regEstController->paintinformeDisponibilidadUsuarioPDF(23);
            } elseif ($_GET['action'] == 'informeEstadoMuestras') {
                $regEstController = new informesController();
                $regEstController->paintInformeEstadoMuestras();
            } elseif ($_GET['action'] == 'informeListadePrecios') {
                $regEstController = new informesController();
                $regEstController->paintInformeListadePrecios();
            } elseif ($_GET['action'] == 'informeGenerarStikers') {
                $regEstController = new informesController();
                $regEstController->paintInformeGenerarStikers();
            } elseif ($_GET['action'] == 'informeGenerarHCPlanta') {
                $regEstController = new informesController();
                $regEstController->paintInformeGenerarHCPlanta();
            } elseif ($_GET['action'] == 'informeGenerarInformePlanta') {
                $regEstController = new informesController();
                $regEstController->paintInformeGenerarInformePlanta();
            } elseif ($_GET['action'] == 'informeEstadistico') {
                $regEstController = new informesController();
                $regEstController->paintInformeEstadistico();
            }
            // Fin de Modulo  de informes ////////////
            //Inicio modulo Administracion//////////////////
            //Perfiles de usuario
            elseif ($_GET['action'] == 'adminPerfil') {
                if ($_SESSION['adminPerfiles'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintPerfilAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'insertPermision') {
                $administracionController = new AdministracionController();
                $administracionController->createPermision($_POST['idPerfil'], $_POST['idPermiso']);
            } elseif ($_POST['action'] == 'deletePermision') {
                $administracionController = new AdministracionController();
                $administracionController->deletePermision($_POST['idPerfil'], $_POST['idPermiso']);
            }

            //Usuarios
            elseif ($_GET['action'] == 'adminUsuario') {
                if ($_SESSION['adminUsuarios'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintUsuarioAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'deleteUsuario') {
                $administracionController = new AdministracionController();
                $administracionController->deleteUsuario($_POST['idUsuario']);
            } elseif ($_POST['action'] == 'insertUsuario') {
                $administracionController = new AdministracionController();
                $administracionController->insertUsuario($_POST['nombre'], $_POST['email'], $_POST['login'], $_POST['contrasena'], $_POST['cargo'], $_POST['jefe'], $_POST['perfil'], $_POST['calendario']);
            } elseif ($_POST['action'] == 'updateUsuario') {
                $administracionController = new AdministracionController();
                $administracionController->updateUsuario($_POST['idUsuario'], $_POST['nombre'], $_POST['email'], $_POST['login'], $_POST['cargo'], $_POST['jefe'], $_POST['perfil'], $_POST['calendario']);
            }

            //Equipos
            elseif ($_GET['action'] == 'adminEquipo') {
                if ($_SESSION['adminEquipos'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintEquipoAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'deleteEquipo') {
                $administracionController = new AdministracionController();
                $administracionController->deleteEquipo($_POST['idEquipo'], $_POST['activo'], $_POST['nombre']);
            } elseif ($_POST['action'] == 'updateEquipo') {
                $administracionController = new AdministracionController();
                $administracionController->updateEquipo($_POST['idEquipo'], $_POST['codInventario'], $_POST['modelo'], $_POST['serie'], $_POST['referencia'], $_POST['descripcion'], $_POST['marca'], $_POST['provMant'], $_POST['provCali'], $_POST['frecMantpreven'], $_POST['frecCalib'], $_POST['fechaUlimoMant'], $_POST['fechaUltimaCalibracion'], $_POST['calificacion'], $_POST['numDiasAlerta'], $_POST['infoMant'], $_POST['striker']);
            } elseif ($_POST['action'] == 'insertEquipo') {
                $administracionController = new AdministracionController();
                $administracionController->insertEquipo($_POST['codInventario'], $_POST['modelo'], $_POST['serie'], $_POST['referencia'], $_POST['descripcion'], $_POST['marca'], $_POST['provMant'], $_POST['provCali']);
            }

            //Metodos
            elseif ($_GET['action'] == 'adminMetodo') {
                if ($_SESSION['adminMetodos'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintMetodoAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'crearMetodo') {
                $administracionController = new AdministracionController();
                $administracionController->crearMetodo($_POST['nombreMetodo'], $_POST['activo']);
            } elseif ($_POST['action'] == 'deleteMetodo') {
                $administracionController = new AdministracionController();
                $administracionController->deleteMetodo($_POST['idMetodo'], $_POST['activo'], $_POST['nombre']);
            } elseif ($_POST['action'] == 'updateMetodo') {
                $administracionController = new AdministracionController();
                $administracionController->updateMetodo($_POST['nombre'], $_POST['idMetodo']);
            }

            // Principios Activos
            elseif ($_GET['action'] == 'adminPrinActivos') {
                if ($_SESSION['adminPrinActivos'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintPrinActivoAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            }
            ///////Ensayos//////////
            elseif ($_GET['action'] == 'adminEnsayos') {
                if ($_SESSION['adminEnsayos'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintEnsayosAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'crearEnsayo') {
                $administracionController = new AdministracionController();

                $administracionController->crearEnsayo($_POST['precio'], $_POST['tiempo'], $_POST['plantilla'], $_POST['esPaquete'], $_POST['descripcion']);
            } elseif ($_POST['action'] == 'updateEnsayo') {
                $administracionController = new AdministracionController();
                $administracionController->updateEnsayoById($_POST['id'], $_POST['precio'], $_POST['tiempo'], $_POST['plantilla'], $_POST['descripcion']);
            }
            ////////Ensayos//////////////
            elseif ($_GET['action'] == 'adminPaquetes') {
                if ($_SESSION['adminPaquetes'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintPaquetesAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'agregarEnsayoPaquete') {
                $administracionController = new AdministracionController();
                $administracionController->agregarEnsayoPaquete($_POST['idPaquete'], $_POST['idEnsayo']);
            } elseif ($_POST['action'] == 'deleteEnsayoPaquete') {
                $administracionController = new AdministracionController();
                $administracionController->deleteEnsayoPaqueteById($_POST['idEnsayoPaquete']);
            } elseif ($_POST['action'] == 'crearPaquete') {
                $administracionController = new AdministracionController();
                $administracionController->crearPaquete($_POST['codigo'], $_POST['descripcion'], $_POST['idAreaAnalisis']);
            } elseif ($_POST['action'] == 'updateNomPaquete') {
                $administracionController = new AdministracionController();
                $administracionController->editarPaqueteNom($_POST['codigo'], $_POST['id'], $_POST['descripcion']);
            } elseif ($_POST['action'] == 'deletePaquete') {
                $administracionController = new AdministracionController();
                $administracionController->deletePaqueteNom($_POST['idPaquete'], $_POST['activo'], $_POST['nombre']);
            }

            //Estandares
            elseif ($_GET['action'] == 'adminEstandar') {
                if ($_SESSION['adminEstandar'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintEstandarAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'crearEstandar') {
                $administracionController = new AdministracionController();
                $administracionController->crearEstandar($_POST['nombre'], $_POST['lote'], $_POST['cantidad'], $_POST['fecha'], $_POST['tipo'], $_POST['cantidadActual'], $_POST['stock'], $_POST['loteInterno'], $_POST['fechaPreparacion'], $_POST['fechaPromocion'], $_POST['cantidad2'], $_POST['codigo']);
            } elseif ($_POST['action'] == 'crearReactivo') {
                $administracionController = new AdministracionController();
                $administracionController->crearReactivo($_POST['nombre'], $_POST['lote'], $_POST['cantidad'], $_POST['fecha'], $_POST['tipo'], $_POST['cantidadActual'], $_POST['stock'], $_POST['fechaIngreso'], $_POST['fechaApertura'], $_POST['fechaTerminacion'], $_POST['loteIterno'], $_POST['fechaPase']);
            } elseif ($_POST['action'] == 'deleteEstandar') {
                $administracionController = new AdministracionController();
                $administracionController->deleteEstandar($_POST['idEstandar'], $_POST['activo'], $_POST['nombre']);
            } elseif ($_POST['action'] == 'deleteReactivo') {
                $administracionController = new AdministracionController();
                $administracionController->deleteReactivo($_POST['idReactivo'], $_POST['activo'], $_POST['nombre']);
            } elseif ($_POST['action'] == 'updateEstandar') {
                $administracionController = new AdministracionController();
                $administracionController->updateEstandar($_POST['nombre'], $_POST['lote'], $_POST['cantidad'], $_POST['fecVencimiento'], $_POST['fechaIngreso'], $_POST['fechaApertura'], $_POST['fechaTerminacion'], $_POST['idEstandar'], $_POST['tipo'], $_POST['cantidadActual'], $_POST['stock']);
            } elseif ($_POST['action'] == 'updateReactivo') {
                $administracionController = new AdministracionController();
                $administracionController->updateReactivo($_POST['nombre'], $_POST['lote'], $_POST['cantidad'], $_POST['fecVencimiento'], $_POST['fechaIngreso'], $_POST['fechaApertura'], $_POST['fechaTerminacion'], $_POST['idReactivo'], $_POST['tipo'], $_POST['cantidadActual'], $_POST['stock'], $_POST['lote_interno'], $_POST['fecha_pase']);
            }

            //Metodos
            elseif ($_GET['action'] == 'adminMetodo') {
                if ($_SESSION['adminMetodos'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintMetodoAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'crearMetodo') {
                $administracionController = new AdministracionController();
                $administracionController->crearMetodo($_POST['nombreMetodo'], $_POST['activo']);
            } elseif ($_POST['action'] == 'deleteMetodo') {
                $administracionController = new AdministracionController();
                $administracionController->deleteMetodo($_POST['idMetodo'], $_POST['activo'], $_POST['nombre']);
            } elseif ($_POST['action'] == 'updateMetodo') {
                $administracionController = new AdministracionController();
                $administracionController->updateMetodo($_POST['nombre'], $_POST['idMetodo']);
            }





            //Formas Farmaceuticas
            elseif ($_GET['action'] == 'adminForma') {
                if ($_SESSION['adminForma'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintFormaAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'crearForma') {
                $administracionController = new AdministracionController();
                $administracionController->crearForma($_POST['descripcion']);
            } elseif ($_POST['action'] == 'updateForma') {
                $administracionController = new AdministracionController();
                $administracionController->updateForma($_POST['idForma'], $_POST['descripcion']);
            }

            //Productos
            elseif ($_GET['action'] == 'adminProducto') {
                if ($_SESSION['adminProducto'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintProductoAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'insertProductoEnsayo') {
                $administracionController = new AdministracionController();
                $administracionController->insertProductoPaquete($_POST['paqueteDisponiblesData']);
            } elseif ($_POST['action'] == 'deleteProductoPaquete') {
                $administracionController = new AdministracionController();
                $administracionController->deleteProductoPaquete($_POST['productoPaquetesData']);
            } elseif ($_POST['action'] == 'updateProductoEnsayo') {
                $administracionController = new AdministracionController();
                $administracionController->updateProductoEnsayo($_POST['idProductoEnsayo'], $_POST['descripcion'], $_POST['especificacion'], $_POST['idMetodo'], $_POST['tiempo'], $_POST['valor'], $_POST['resultado']);
            } elseif ($_POST['action'] == 'crearProducto') {
                $administracionController = new AdministracionController();
                $administracionController->createProducto($_POST['nombre'], $_POST['idFormaFarma'], $_POST['estado'], $_POST['tecnica'], $_POST['timepoEntrega']);
            } elseif ($_POST['action'] == 'updateProducto') {
                $administracionController = new AdministracionController();
                $administracionController->updateProducto($_POST['idProducto'], $_POST['nombreProducto'], $_POST['formaf']);
            } elseif ($_POST['action'] == 'deleteProducto') {
                $administracionController = new AdministracionController();
                $administracionController->deleteProducto($_POST['idProducto'], $_POST['activo'], $_POST['nombre']);
            }

            //Principios activos por producto
            elseif ($_POST['action'] == 'updatePrincipioActivoProducto') {
                $administracionController = new AdministracionController();
                $administracionController->updatePrincipioActivoProducto($_POST['principal'], $_POST['trasador'], $_POST['cantidad'], $_POST['unidadCantidad'], $_POST['cantidadDecimal'], $_POST['idPrincipioActivoProducto']);
            } elseif ($_POST['action'] == 'insertPrincipioActivoProducto') {
                $administracionController = new AdministracionController();
                $administracionController->insertPrincipioActivoProducto($_POST['principioActivoProductoData']);
            } elseif ($_POST['action'] == 'deleteProductoPrincipioActivo') {
                $administracionController = new AdministracionController();
                $administracionController->deleteProductoPrincipioActivo($_POST['productoPrincipioActivoData']);
            } elseif ($_GET['action'] == 'errorAccess') {
                $administracionController = new AdministracionController();
                $administracionController->paintErrorAccess();
            }
            // Equipos Ensayos MIC
            elseif ($_GET['action'] == 'adminEquiposEnsayos') {
                if (true) {
                    $administracionController = new AdministracionController();
                    $administracionController->paintEquiposEnsayos();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            }

            //Clientes o Terceros
            elseif ($_GET['action'] == 'adminTercero') {
                if ($_SESSION['adminTercero'] == 'true') {
                    $administracionController = new AdministracionController();
                    $administracionController->paintTerceroAdmin();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'adminMedioCultivo') {
                if (true == true) {
                    $this->accesAdminMedioCultivo();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_GET['action'] == 'adminCepa') {
                if (true == true) {
                    $this->accesAdminCepa();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'updateTercero') {
                $administracionController = new AdministracionController();
                $administracionController->updateTerceroById($_POST['id'], $_POST['nombre'], $_POST['tipoIdentificacion'], $_POST['numIdentificacion'], $_POST['representante'], $_POST['direccion'], $_POST['tel1'], $_POST['tel2'], $_POST['fax'], $_POST['email'], $_POST['idCiudad'], $_POST['descuento'], $_POST['porDescuento'], $_POST['contrato'], $_POST['fecContrato'], $_POST['fecVenContrato']);
            } elseif ($_POST['action'] == 'crearTercero') {
                $administracionController = new AdministracionController();
                $administracionController->insertTercero($_POST['nombre'], $_POST['idTipoIdentificacion'], $_POST['numIdentificacion'], $_POST['representante'], $_POST['direccion'], $_POST['tel1'], $_POST['tel2'], $_POST['fax'], $_POST['email'], $_POST['idCiudad'], $_POST['descuento'], $_POST['porDescuento'], $_POST['contrato'], $_POST['fecContrato'], $_POST['fecVenContrato']);
            }

            //Contactos de cliente o tercero
            elseif ($_POST['action'] == 'updateContacto') {
                $administracionController = new AdministracionController();
                $administracionController->updateContacto($_POST['id'], $_POST['nombre'], $_POST['cargo'], $_POST['area'], $_POST['telefono'], $_POST['movil'], $_POST['extencion'], $_POST['email'], $_POST['idTercero'], $_POST['preferencias']);
            } elseif ($_POST['action'] == 'createContacto') {
                $administracionController = new AdministracionController();
                $administracionController->createContacto($_POST['nombre'], $_POST['cargo'], $_POST['area'], $_POST['telefono'], $_POST['movil'], $_POST['extencion'], $_POST['email'], $_POST['idTercero'], $_POST['preferencias']);
            }


            ////Fin de Modulo de Administracion/////////
            //
            //General
            elseif ($_GET['action'] == 'getPermisos') {
                echo json_encode($_SESSION);
            }
            //fin general
            //Inicio de Modulo Nuevo de Documentos Antiguos/////
            elseif ($_GET['action'] == 'repoDocs') {
                if ($_SESSION['repoDocs'] == 'true') {
                    $muestraController = new MuestraController();
                    $muestraController->paintRepoDocs();
                } else {
                    $administracionController = new AdministracionController();
                    $administracionController->paintErrorAccess();
                }
            } elseif ($_POST['action'] == 'crearCarpetaRepoDocs') {
                $muestraController = new MuestraController();
                $muestraController->crearCarpetaRepoDocs($_POST['nombre'], $_POST['selectedId']);
            } elseif ($_POST['action'] == 'getEsCarpetaById') {
                $muestraController = new MuestraController();
                $muestraController->getEsCarpetaById($_POST['id']);
            } elseif ($_GET['action'] == 'scanRepoFolder') {
                $muestraController = new MuestraController();
                $muestraController->scanRepoFolder();
            } elseif ($_GET['action'] == 'getRootsRepoDocs') {
                $muestraController = new MuestraController();
                $muestraController->getRootsRepoDocs();
            } elseif ($_GET['action'] == 'chargeNewRootPathRepoDocs') {
                $muestraController = new MuestraController();
                $muestraController->chargeNewRootPathRepoDocs($_GET['rootPath']);
            } elseif ($_GET['action'] == 'uploadFileRepoDocs') {
                $muestraController = new MuestraController();
                $muestraController->uploadFileRepoDocs($_GET['idParentFolder']);
            } elseif ($_GET['action'] == 'getRepoFileDownloadLinkById') {
                $muestraController = new MuestraController();
                $muestraController->getRepoFileDownloadLinkById($_GET['idFile']);
            } elseif ($_GET['action'] == 'eliminarFileRepoDocsById') {
                $muestraController = new MuestraController();
                $muestraController->eliminarFileRepoDocsById($_GET['idFile']);
            } elseif ($_GET['action'] == 'configuracionPerfil') {
                $modelMuestraClass = new MuestraModelClass();
                $modelMuestraClass->paintConfiguracionPerfil();
            } elseif ($_POST['action'] == 'updatePassword') {
                $administracionController = new AdministracionController();
                $administracionController->updatePassword($_SESSION['userId'], $_POST['newPassword']);
            } elseif ($_POST['action'] == 'getHistoricoEstadosSubmuestra') {
                $modelMuestraController = new MuestraController();
                $modelMuestraController->getHistoricoEstadosSubMuestra($_POST['idMuestra']);
            } elseif ($_POST['action'] == 'resetPassword') {
                $administracionController = new AdministracionController();
                $administracionController->updatePassword($_POST['isUser'], $_POST['newPassword']);
            } elseif ($_POST['action'] == 'anularMuestra') {
                $muestraController = new MuestraController();
                $muestraController->anularMuestra($_POST['idMuestra']);
            } elseif ($_POST['action'] == 'exportData') {
                $data = json_decode($_POST['data'], true);
                $generalController = new GeneralController();
                $generalController->exportXLSData($data);
            } elseif ($_POST['action'] == 'exportEstadosMuestra') {
                $data = json_decode($_POST['data'], true);
                $generalController = new GeneralController();
                $generalController->exportEstadosMuestra($data);
            }
            //////////// nuevo consulta DB /////////////////////////////////////
            elseif ($_GET['action'] == 'queryDb') {
                $queryDbCOntroller = new QueryDBController();
                $queryDbCOntroller->executeGetQuery($_GET['query']);
            } elseif ($_POST['action'] == 'queryDb') {
                $queryDbCOntroller = new QueryDBController();
                $queryDbCOntroller->executePOSTQuery($_POST['query']);
            } elseif ($_POST['action'] == 'saveMuestra2') {
                $muestraController = new MuestraController();
                $muestraController->saveMuestra2($_POST["muestraData"]);
            } elseif ($_GET["action"] == 'searchMuestra') {
                $muestraController = new MuestraController();
                $muestraController->searchMuestra($_GET["idMuestra"]);
            } elseif ($_POST['action'] == 'updateMuestra2') {
                $muestraController = new MuestraController();
                $muestraController->updateMuestra2($_POST["muestraData"]);
            } elseif ($_POST['action'] == 'anularMuestra2') {
                $muestraController = new MuestraController();
                $muestraController->anularMuestra2($_POST['idMuestra'], $_POST["motivoAnulacion"]);
            } elseif ($_GET['action'] == 'scanDirByIdReactivo') {
                $muestraController = new MuestraController();
                $muestraController->scanDirByIdReactivo($_GET['nombreReactivo'], $_GET['idReactivo']);
            } elseif ($_GET['action'] == 'scanDirByIdLoteReactivo') {
                $muestraController = new MuestraController();
                $muestraController->scanDirByIdLoteReactivo($_GET['numeroLoteReactivo'], $_GET['idLoteReactivo'], $_GET['idReactivo']);
            } elseif ($_POST['action'] == 'deleteFile') {
                $muestraController = new MuestraController();
                $muestraController->deleteFile($_POST['location']);
            } elseif ($_GET['action'] == 'scanDirByIdEstandar') {
                $muestraController = new MuestraController();
                $muestraController->scanDirByIdEstandar($_GET['nombreEstandar'], $_GET['idEstandar']);
            } elseif ($_GET['action'] == 'scanDirByIdLoteEstandar') {
                $muestraController = new MuestraController();
                $muestraController->scanDirByIdLoteEstandar($_GET['numeroLoteEstandar'], $_GET['idLoteEstandar'], $_GET['idEstandar']);
            } elseif ($_GET['action'] == 'scanDirByIdColumna') {
                $muestraController = new MuestraController();
                $muestraController->scanDirByIdColumna($_GET['nombreColumna'], $_GET['idColumna']);
            } elseif ($_GET['action'] == 'remake-qr-all-muestras') {
                $consultaQrController = new ConsultaQrController();
                $consultaQrController->remakeQrCodeAllMuestras($_GET['start'], $_GET['end']);
            }
            //Fin de Modulo Nuevo de Documentos Antiguos/////
//            //Inicio de Modulo de Reportes o Informes/////
//            elseif ($_GET['action'] == 'reporteDisponibilidad') {
//                if ($_SESSION['reporteDisponibilidad'] == 'true') {
//                    $administracionController = new AdministracionController();
//                    $administracionController->paintReporteDisponibilidad();
//                } else {
//                    $administracionController = new AdministracionController();
//                    $administracionController->paintErrorAccess();
//                }
//            }
//
//            //Fin de Modulo de Reportes o Informes/////
            else {
                $loginController = new LoginController();
                $loginController->login();
            }
        } else {

            if ($_GET['action'] == 'consultaqr') {
                $consultaQrController = new ConsultaQrController();
                $consultaQrController->consultaByQr();
            } elseif ($_POST['action'] == 'consultaqr'){
                $consultaQrController = new ConsultaQrController();
                $consultaQrController->consultaByQr();

            } else {
                $loginController = new LoginController();
                $loginController->login();
            }
        }
    }

    public function accesAdminMedioCultivo() {
        $administracionController = new AdministracionController();
        $administracionController->paintAdminMedioCultivo();
    }

    public function accesAdminCepa() {
        $administracionController = new AdministracionController();
        $administracionController->paintAdminCepa();
    }

}
