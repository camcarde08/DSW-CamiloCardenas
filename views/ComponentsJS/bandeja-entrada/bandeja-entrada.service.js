'use strict'

angular.module('CompBandejaEntrada')

    .factory('bandejaEntradaServiceComp', function ($q, factoryBandejaEntradaService, utileService) {
        var interfaz = {
            getMuestrasVerificadas: getMuestrasVerificadas,
            eventClickImageDetalleInforme: eventClickImageDetalleInforme,
            eventClickBtnAlmacenarMuestra: eventClickBtnAlmacenarMuestra,
            loadNotificationAdminPerfil: loadNotificationAdminPerfil,
            getEnsayosPorProgramarFisicoquimicos: getEnsayosPorProgramarFisicoquimicos,
            getEnsayosPorProgramarMicrobiologicos: getEnsayosPorProgramarMicrobiologicos,
            eventClickProgramarMuestra: eventClickProgramarMuestra,
            obtenerInformacionUsuario: obtenerInformacionUsuario,
            getProgramacionAnalista: getProgramacionAnalista,
            eventClickHojaTrabajo: eventClickHojaTrabajo,
            getEnsayosParaTranscripcion: getEnsayosParaTranscripcion,
            getEnsayosParaRevisionFQ: getEnsayosParaRevisionFQ,
            getEnsayosParaRevisionMB: getEnsayosParaRevisionMB,
            getMuestrasParaVerificar: getMuestrasParaVerificar,
            eventClickInformeCliente: eventClickInformeCliente,
            getSubMuestrasEstabilidadParaProgramar: getSubMuestrasEstabilidadParaProgramar,
            eventClickProgramarSubMuestraEstabilidad: eventClickProgramarSubMuestraEstabilidad,
            getSubMuestrasEstabilidadParaAnalisis: getSubMuestrasEstabilidadParaAnalisis,
            eventClickResultadosSubMuestraEstabilidad: eventClickResultadosSubMuestraEstabilidad,
            getSubMuestrasEstabilidadParaTranscripcion: getSubMuestrasEstabilidadParaTranscripcion,
            getSubMuestrasEstabilidadParaRevision: getSubMuestrasEstabilidadParaRevision,
            //getMuestrasParaFacturacion: getMuestrasParaFacturacion,
            //eventClickActualizarNumFactura: eventClickActualizarNumFactura,
            //getMuestrasParaEntrega: getMuestrasParaEntrega,
            //eventClickActualizarFechaEntrega: eventClickActualizarFechaEntrega,
            getMuestrasSalida: getMuestrasSalida,
            eventClickDarSalidaMuestra: eventClickDarSalidaMuestra,
            getSolicitudesParaRecoleccion: getSolicitudesParaRecoleccion,
            eventClickModalProgramarSolicitud: eventClickModalProgramarSolicitud,
            eventClickProgramarSolicitud: eventClickProgramarSolicitud,
            getSolicitudesProgramadas: getSolicitudesProgramadas,
            eventClickSolicitudAtendida: eventClickSolicitudAtendida,
            getSubMuestrasEstabilidadAprobadas: getSubMuestrasEstabilidadAprobadas,
            getSubMuestrasEstabilidadParaRevision2: getSubMuestrasEstabilidadParaRevision2,
            eventClickResultadosSubMuestraEstabilidad2: eventClickResultadosSubMuestraEstabilidad2
        }

        function getSubMuestrasEstabilidadAprobadas(vm) {
            factoryBandejaEntradaService.getSubMuestrasEstabilidadAprobadas().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de sub muestras estabilidad aprobadasOK', response);
                    if (response.data.data != null) {
                        vm.subMuestrasEstabilidadAprobadas = response.data.data;
                    } else {
                        vm.subMuestrasEstabilidadAprobadas = [];
                    }

                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad aprobadas');
                    console.error(response);
                }
            });
        }

        function getSubMuestrasEstabilidadParaRevision(vm) {
            factoryBandejaEntradaService.getSubMuestrasEstabilidadParaRevision().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de sub muestras estabilidad para revisión OK');
                    if (response.data.data != null) {
                        vm.subMuestrasEstabilidadParaRevision = response.data.data;
                    } else {
                        vm.subMuestrasEstabilidadParaRevision = [];
                    }

                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad para revisión');
                    console.error(response);
                }
            });
        }

        function getSubMuestrasEstabilidadParaRevision2(vm) {
            factoryBandejaEntradaService.getSubMuestrasEstabilidadParaRevision2().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de sub muestras estabilidad para revisión sin ensayos OK', response);
                    if (response.data.data != null) {
                        vm.subMuestrasEstabilidadParaRevisionSinEnsayos = response.data.data;
                    } else {
                        vm.subMuestrasEstabilidadParaRevisionSinEnsayos = [];
                    }

                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad para revisión');
                    console.error(response);
                }
            });
        }

        function getSubMuestrasEstabilidadParaTranscripcion(vm) {
            factoryBandejaEntradaService.getSubMuestrasEstabilidadParaTranscripcion().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de sub muestras estabilidad para transcripción OK', response);
                    if (response.data.data != null) {
                        vm.subMuestrasEstabilidadParaTranscripcion = response.data.data;
                    } else {
                        vm.subMuestrasEstabilidadParaTranscripcion = [];
                    }

                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad para transcripción');
                    console.error(response);
                }
            });
        }

        function eventClickResultadosSubMuestraEstabilidad(vm, ensayo) {
            var complexIdMuestra = ensayo.prefijo + '-' + ensayo.custom_id;
            var uid = vm.usuario.session.uidSession;
            window.open(vm.usuario.session.systemsParameters.externalRequestSgm2 + uid + '/159/' + complexIdMuestra);
            //console.log(vm.usuario);
        }

        function eventClickResultadosSubMuestraEstabilidad2(vm, subMuestra) {
            var complexIdMuestra = subMuestra.muestra.tipo_muestra.prefijo + '-' + subMuestra.muestra.custom_id;
            var uid = vm.usuario.session.uidSession;
            window.open(vm.usuario.session.systemsParameters.externalRequestSgm2 + uid + '/159/' + complexIdMuestra);
            //console.log(vm.usuario);
        }

        function getSubMuestrasEstabilidadParaAnalisis(vm) {
            factoryBandejaEntradaService.getEnsayosSubMuestraEstabilidadParaAnalisis().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de sub muestras estabilidad para analisis OK', response);
                    if (response.data.data != null) {
                        vm.ensayosSubMuestraEstabilidadParaAnalisis = response.data.data;
                        console.log('Consulta de sub muestras estabilidad para analisis OK', vm.ensayosSubMuestraEstabilidadParaAnalisis);
                    } else {
                        vm.ensayosSubMuestraEstabilidadParaAnalisis = [];
                    }

                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad para analisis');
                    console.error(response);
                }
            });
        }

        function eventClickProgramarSubMuestraEstabilidad(vm, subMuestra) {
            var complexIdMuestra = subMuestra.muestra.tipo_muestra.prefijo + '-' + subMuestra.muestra.custom_id;
            var uid = vm.usuario.session.uidSession;
            window.open(vm.usuario.session.systemsParameters.externalRequestSgm2 + uid + '/158/' + complexIdMuestra);
            //console.log(vm.usuario);
        }

        function getSubMuestrasEstabilidadParaProgramar(vm) {
            factoryBandejaEntradaService.getSubMuestrasEstabilidadParaProgramar().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de sub muestras estabilidad para programacion OK', response);
                    if (response.data.data != null) {
                        vm.subMuestrasEstabilidadParaProgramacion = response.data.data;
                    } else {
                        response.data.data = [];
                    }
                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad para programacion');
                    console.error(response);
                }
            });
        }

        function getMuestrasVerificadas(vm) {

            factoryBandejaEntradaService.getMuestrasVerificadas().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de muestras verificadas OK');
                    if (response.data.data != null) {
                        vm.verificadas = response.data.data;

                    } else {
                        vm.verificadas = [];
                    }
                } else {
                    console.log('Falla en la consulta de perfiles');
                    console.error(response);
                }
            });

        }

        function obtenerInformacionUsuario(vm) {
            var promises = {
                getAllPermisosBandejaEntrada: getAllPermisosBandejaEntrada(vm)
            };
            return $q.all(promises).then(function () {
                return factoryBandejaEntradaService.getSessionUserData().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Consulta de usuario OK');
                        console.log(response.data.data);
                        vm.usuario = response.data.data;
                        vm.diasAnticipacionAlertaBandejaEntrada = response.data.data.session.systemsParameters.diasAnticipacionAlertaBandejaEntrada;
                        vm.veProgramacion = (vm.usuario.userIdPerfil == '6' || vm.usuario.userIdPerfil == '7') ? false : true;


                    } else {
                        console.log('Falla en la consulta de usuario');
                        console.error(response);
                    }
                })
            });

        }

        function getAllPermisosBandejaEntrada(vm) {
            return factoryBandejaEntradaService.getAllPermisosBandejaEntrada().then(function (response) {
                if (response.data.code == "00000") {
                    response.data.data.forEach(function (item) {
                        vm.nombreBandejas[item.id] = item.nombre;
                    });
                }
            });
        }

        function eventClickImageDetalleInforme(vm, idMuestra) {
            $("#idMuestraHiden").val(idMuestra);
            $("#idPerfilHiden").val(true);
            window.open('', 'view');
            $("#formEnvio").submit();
        }

        function eventClickInformeCliente(vm, idMuestra) {
            var idAjustado = utileService.getidMuestraSinCeros(idMuestra);
            var idSinAnio = idMuestra.replace(/LQF[1-9]{2}/gi, "LQF");
            var anio = idMuestra.substr(3, 2);
            window.open("docs/muestra/" + idAjustado + "/Informes Cliente/" + idSinAnio + "-" + anio + ".pdf");
        }

        function eventClickBtnAlmacenarMuestra(vm, idMuestra) {
            var auxDate = new Date();
            var ano = auxDate.getFullYear();
            var mes = auxDate.getMonth();
            mes++;
            var dia = auxDate.getDate();
            var fecha = ano + '-' + mes + '-' + dia;
            vm.almacenData = {};
            vm.almacenData.fecha = fecha;
            vm.almacenData.idUbicación = 1;
            vm.almacenData.nivel = 1;
            vm.almacenData.tiempo = 0;
            vm.almacenData.caja = 1;
            vm.almacenData.idTIpoAlmacenamineto = 1;
            factoryBandejaEntradaService.alamacenarMuestra(vm.almacenData, idMuestra).then(function (response) {
                if (response.data.code == "00000") {
                    openNotificationAdminPerfil('success', 'Se ha almacenado la muestra satisfactoriamente');
                    getMuestrasVerificadas(vm);
                } else {
                    openNotificationAdminPerfil('error', 'Error almacenando la muestra');
                    console.error(response);
                }
            });
        }

        function loadNotificationAdminPerfil() {
            $("#notificationAlmacenamiento").jqxNotification({
                width: 250, position: "top-right", opacity: 0.9,
                autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
            });
        }

        function openNotificationAdminPerfil(template, message) {
            $("#messageNotificationAlmacenamiento").text(message);
            $("#notificationAlmacenamiento").jqxNotification({template: template});
            $("#notificationAlmacenamiento").jqxNotification("open");
        }

        function getEnsayosPorProgramarFisicoquimicos(vm) {
            factoryBandejaEntradaService.getEnsayosPorProgramarFisicoquimicos().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de muestras por programar FQ OK');
                    if (response.data.data != null) {
                        vm.programFisicoquimicos = response.data.data;
                    } else {
                        vm.programFisicoquimicos = [];
                    }

                } else {
                    console.log('Falla en la consulta de muestras por programar FQ');
                    console.error(response);
                }
            });
        }

        function getEnsayosPorProgramarMicrobiologicos(vm) {
            factoryBandejaEntradaService.getEnsayosPorProgramarMicrobiologicos().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de muestras por programar MB OK');
                    if (response.data.data != null) {
                        vm.programMicrobiologicos = response.data.data;

                    } else {
                        vm.programMicrobiologicos = [];
                    }
                } else {
                    console.log('Falla en la consulta de muestras por programar MB');
                    console.error(response);
                }
            });
        }

        function eventClickProgramarMuestra(vm, idMuestra) {
            window.location.href = 'index.php?action=programacionAnalistas&idMuestra=' + idMuestra;
        }

        function eventClickHojaTrabajo(vm, idMuestra) {
            window.location.href = 'index.php?action=render&page=hoja-trabajo&idMuestra=' + idMuestra;
        }

        function getProgramacionAnalista(vm) {
            var idAnalista = (vm.usuario.userIdPerfil !== "6" && vm.usuario.userIdPerfil !== "7") ? "0" : vm.usuario.userId;
            factoryBandejaEntradaService.getProgramacionAnalista(idAnalista).then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de programacion OK');
                    if (response.data.data != null) {
                        vm.programacionEnsayos = response.data.data;
                    } else {
                        vm.programacionEnsayos = [];
                    }

                } else {
                    console.log('Falla en la consulta de programación');
                    console.error(response);
                }
            });
        }

        function getEnsayosParaTranscripcion(vm) {
            factoryBandejaEntradaService.getEnsayosParaTranscripcion().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de ensayos para transcripcion OK');
                    if (response.data.data != null) {
                        vm.ensayosTranscrip = response.data.data;
                    } else {
                        vm.ensayosTranscrip = [];
                    }

                } else {
                    console.log('Falla en la consulta de ensayos para transcripcion');
                    console.error(response);
                }
            });
        }


        function getEnsayosParaRevisionFQ(vm) {
            factoryBandejaEntradaService.getEnsayosParaRevisionFQ().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de ensayos para transcripcion OK');
                    if (response.data.data != null) {
                        vm.ensayosRevisionFQ = response.data.data;
                    } else {
                        vm.ensayosRevisionFQ = [];
                    }

                } else {
                    console.log('Falla en la consulta de ensayos para transcripcion');
                    console.error(response);
                }
            });
        }

        function getEnsayosParaRevisionMB(vm) {
            factoryBandejaEntradaService.getEnsayosParaRevisionMB().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de ensayos para transcripcion OK');
                    if (response.data.data != null) {
                        vm.ensayosRevisionMB = response.data.data;
                    } else {
                        vm.ensayosRevisionMB = [];
                    }

                } else {
                    console.log('Falla en la consulta de ensayos para transcripcion');
                    console.error(response);
                }
            });
        }

        function getMuestrasParaVerificar(vm) {

            factoryBandejaEntradaService.getMuestrasParaVerificar().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de muestras para verificar OK');
                    if (response.data.data != null) {
                        vm.muestrasParaVerificar = response.data.data;
                    } else {
                        vm.muestrasParaVerificar = [];
                    }

                } else {
                    console.log('Falla en la consulta de muestras para verificar');
                    console.error(response);
                }
            });

        }

        function getMuestrasSalida(vm) {
            factoryBandejaEntradaService.getMuestrasSalida().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de muestras para entrega OK');
                    if (response.data.data != null) {
                        vm.muestrasSalida = response.data.data;
                        var date = new Date();
                        angular.forEach(vm.muestrasSalida, function (value, key) {
                            var fecha_salida = new Date(value.fecha_salida);
                            if (fecha_salida < date) {
                                value.class = 'danger';
                            } else {
                                value.class = 'warning';
                            }
                        });
                    } else {
                        vm.muestrasSalida = [];
                    }

                } else {
                    console.log('Falla en la consulta de sub muestras estabilidad para revisión');
                    console.error(response);
                }
            });
        }

        function eventClickDarSalidaMuestra(vm, muestraSalida) {
            factoryBandejaEntradaService.actualizarEstadoSalidaMuestra(muestraSalida.id_almacenamiento).then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Actualización estado salida OK');
                    var indice = vm.muestrasSalida.indexOf(muestraSalida);
                    vm.muestrasSalida.splice(indice, 1);
                } else {
                    console.log('Falla en la actualización de fecha entrega');
                    console.error(response);
                }
            });
        }


        function getSolicitudesParaRecoleccion(vm) {
            factoryBandejaEntradaService.getSolicitudesParaRecoleccion().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de solicitudes para recolección OK');
                    if (response.data.data != null) {
                        vm.solicitudesParaRecoleccion = response.data.data;
                    } else {
                        vm.solicitudesParaRecoleccion = [];
                    }
                } else {
                    console.log('Falla en la consulta de solicitudes para recolección');
                    console.error(response);
                }
            });
        }

        function eventClickModalProgramarSolicitud(vm, solicitudRecoleccion) {

            vm.solicitudRecoleccionTemp = angular.copy(solicitudRecoleccion);
            angular.element(confirmarFechaRecoleccionModal).modal("show");
        }

        function eventClickProgramarSolicitud(vm) {
            angular.element(confirmarFechaRecoleccionModal).modal("hide");
            factoryBandejaEntradaService.programarSolicitudRecoleccion(vm.solicitudRecoleccionTemp).then(function (response) {
                if (response.data.code == "00000") {
                    getSolicitudesParaRecoleccion(vm);
                } else {
                    console.log('Error programando solicitud');
                }
            });
        }

        function getSolicitudesProgramadas(vm) {
            factoryBandejaEntradaService.getSolicitudesProgramadas().then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Consulta de solicitudes programdas OK');
                    if (response.data.data != null) {
                        vm.solicitudesProgramadas = response.data.data;
                    } else {
                        vm.solicitudesProgramadas = [];
                    }
                } else {
                    console.log('Falla en la consulta de solicitudes programadas');
                    console.error(response);
                }
            });
        }

        function eventClickSolicitudAtendida(vm, solicitud) {
            factoryBandejaEntradaService.eventClickSolicitudAtendida(solicitud).then(function (response) {
                if (response.data.code == "00000") {
                    var indice = vm.solicitudesProgramadas.indexOf(solicitud);
                    vm.solicitudesProgramadas.splice(indice, 1);
                } else {
                    console.log('Error programando solicitud');
                }
            });
        }

        return interfaz;
    });

