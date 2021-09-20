'use strict'

angular.module('moduleBandejaEntradaService', [])

        .factory('factoryBandejaEntradaService', function ($http, utileService) {


            var interfaz = {

                getSubMuestrasEstabilidadAprobadas: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getSubMuestrasEstabilidadAprobadas'
                        }
                    });
                },
                getSolicitudesParaRecoleccion: function () {
                    var sesionUserData = utileService.getLoadedSessionUserData();
                    return $http({
                        method: 'GET',
                        url: sesionUserData.session.systemsParameters.urlApi + '/bandeja-entrada/consulta-solicitudes-recoleccion'
                    });
                },
                programarSolicitudRecoleccion: function (solicitud) {
                    var sesionUserData = utileService.getLoadedSessionUserData();
                    return $http({
                        method: 'POST',
                        url: sesionUserData.session.systemsParameters.urlApi + '/modulo-cliente/solicitud_recoleccion/programar-solicitud-recoleccion',
                        headers: {'Content-Type': 'application/json'},
                        data: {
                            solicitud
                        }
                    });
                },
                getSolicitudesProgramadas: function () {
                    var sesionUserData = utileService.getLoadedSessionUserData();
                    return $http({
                        method: 'GET',
                        url: sesionUserData.session.systemsParameters.urlApi + '/bandeja-entrada/consulta-solicitudes-programadas'
                    });
                },
                eventClickSolicitudAtendida: function (solicitud) {
                    var sesionUserData = utileService.getLoadedSessionUserData();
                    return $http({
                        method: 'POST',
                        url: sesionUserData.session.systemsParameters.urlApi + '/modulo-cliente/solicitud_resoleccion/atender-solicitud-recoleccion',
                        headers: {'Content-Type': 'application/json'},
                        data: {
                            solicitud
                        }
                    });
                },
                actualizarNumeroFactura: function (muestra) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarNumeroFactura',
                            muestra: muestra
                        })
                    });
                },
                actualizarFechaEntrega: function (muestra) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarFechaEntrega',
                            muestra: muestra
                        })
                    });
                },
                getMuestrasParaEntrega: function (pagina, cantidad, complex_id, producto, tercero, lote) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasParaEntrega',
                            pagina: pagina,
                            cantidad: cantidad,
                            complex_id: complex_id,
                            producto: producto,
                            tercero: tercero,
                            lote: lote
                        }
                    });
                },
                getMuestrasParaFacturacion: function (pagina, cantidad, complex_id, producto, tercero, lote) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasParaFacturacion',
                            pagina: pagina,
                            cantidad: cantidad,
                            complex_id: complex_id,
                            producto: producto,
                            tercero: tercero,
                            lote: lote
                        }
                    });
                },
                getSubMuestrasEstabilidadParaRevision: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getSubMuestraEstabilidadParaRevision'
                        }
                    });
                },

                getSubMuestrasEstabilidadParaTranscripcion: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getSubMuestraEstabilidadParaTranscripcion'
                        }
                    });
                },

                getSubMuestrasEstabilidadParaAnalisis: function () {
                    var sesionUserData = utileService.getLoadedSessionUserData();
                    return $http({
                        method: 'GET',
                        url: sesionUserData.session.systemsParameters.urlApi + '/estabilidad/bandeja-entrada/consulta-sub-muestras-para-analisis'
                    });
                },

                getEnsayosSubMuestraEstabilidadParaAnalisis: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getSubMuestraEstabilidadParaAnalisis'
                        }
                    });
                },

                getEstEnsayosProgramados: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEstEnsayosProgramados'
                        }
                    });
                },

                getSubMuestrasEstabilidadParaProgramar: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestraEstabilidadParaProgramacion'
                        }
                    });
                },
                getMuestrasSalida: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasSalida'
                        }
                    });
                },

                actualizarEstadoSalidaMuestra: function (idAlmacenamiento) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarEstadoSalidaMuestra',
                            idAlmacenamiento: idAlmacenamiento
                        })
                    });
                },

                getMuestrasVerificadas: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasVerificadas'
                        }
                    });
                },

                alamacenarMuestra: function (almacenData, idMuestra) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'alamacenarMuestra',
                            almacenData: almacenData,
                            idMuestra: idMuestra
                        })
                    });
                },

                getEnsayosPorProgramarFisicoquimicos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosPorProgramarFisicoquimicos'
                        }
                    });
                },

                getEnsayosPorProgramarMicrobiologicos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosPorProgramarMicrobiologicos'
                        }
                    });
                },
                getProgramacionAnalista: function (idAnalista) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getProgramacionAnalista',
                            idAnalista: idAnalista
                        }
                    });
                },

                getEnsayosParaTranscripcion: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosParaTranscripcion'
                        }
                    });
                },

                getSessionUserData: function () {
                    return utileService.getSessionUserData();
//                    return $http({
//                        method: 'GET',
//                        url: 'index.php',
//                        params: {
//                            action: 'queryDb',
//                            query: 'getSessionUserData'
//                        }
//                    });
                },

                getEnsayosParaRevisionMB: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosParaRevisionMB'
                        }
                    });
                },

                getEnsayosParaRevisionFQ: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosParaRevisionFQ'
                        }
                    });
                },

                getMuestrasParaVerificar: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasParaVerificar'
                        }
                    });
                },
                getSubMuestrasEstabilidadParaRevision2: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getSubMuestraEstabilidadParaRevision2'
                        }
                    });
                },
                getMuestrasEstados: function (fechaInicial, fechaFinal) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasEstados',
                            fecha_inicial: fechaInicial,
                            fecha_final: fechaFinal
                        }
                    });
                },
                getDatosGraficaMuestrasPorTipoProducto: function (fechaInicial, fechaFinal) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getDatosGraficaMuestrasPorTipoProducto',
                            fecha_inicial: fechaInicial,
                            fecha_final: fechaFinal
                        }
                    });
                },
                getDatosGraficaParticipacionClientes: function (fechaInicial, fechaFinal) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getDatosGraficaParticipacionClientes',
                            fecha_inicial: fechaInicial,
                            fecha_final: fechaFinal
                        }
                    });
                },
                getDatosGraficaParticipacionClientesEst: function (fechaInicial, fechaFinal) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getDatosGraficaParticipacionClientesEst',
                            fecha_inicial: fechaInicial,
                            fecha_final: fechaFinal
                        }
                    });
                },
                evaluarAlertaFechaCompromiso: evaluarAlertaFechaCompromiso,
                evaluarAlertaFechaCompromisoGerencia: evaluarAlertaFechaCompromisoGerencia,
                getDatosGraficaDesempenoAnalistas: getDatosGraficaDesempenoAnalistas,
                getDatosGraficaDesempenoByIdAnalista: getDatosGraficaDesempenoByIdAnalista,
                getAllPermisosBandejaEntrada:getAllPermisosBandejaEntrada
            };

            function evaluarAlertaFechaCompromiso(diasAnticipacionAlertaBandejaEntrada, fechaCompromiso) {
                var hoy = new Date();
                if (fechaCompromiso !== null && fechaCompromiso !== undefined) {
                    var fechaCompr = formatDateString(fechaCompromiso);
                    var timeDiff = fechaCompr.getTime() - hoy.getTime();
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    if (diffDays <= diasAnticipacionAlertaBandejaEntrada) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }

            function evaluarAlertaFechaCompromisoGerencia(diasAnticipacionAlertaBandejaEntrada, fechaCompromiso, idEstado) {
                if (idEstado !== 10 && idEstado !== 17) {
                    return evaluarAlertaFechaCompromiso(diasAnticipacionAlertaBandejaEntrada, fechaCompromiso);
                } else {
                    return false;
                }
            }

            function formatDateString(dateString) {
                var dateParts;
                if (dateString.includes("/")) {
                    dateParts = dateString.split("/");
                } else if (dateString.includes("-")) {
                    dateParts = dateString.split("-");
                }

                if (dateParts[0].length === 4) {
                    return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
                } else {
                    return new Date(dateParts[2].substr(0, 4), dateParts[1] - 1, dateParts[0]);
                }
            }

            function getDatosGraficaDesempenoByIdAnalista(fechaInicial, fechaFinal, idAnalista) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getDatosGraficaDesempenoByIdAnalista',
                        fecha_inicial: fechaInicial,
                        fecha_final: fechaFinal,
                        id_analista: idAnalista
                    }
                });
            }

            function getDatosGraficaDesempenoAnalistas(fechaInicial, fechaFinal) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        //query: 'getDatosGraficaParticipacionClientes',
                        query: 'getDatosGraficaDesempenoAnalistas',
                        fecha_inicial: fechaInicial,
                        fecha_final: fechaFinal
                    }
                });
            }
            function getAllPermisosBandejaEntrada() {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        //query: 'getDatosGraficaParticipacionClientes',
                        query: 'getAllPermisosBandejaEntrada'
                    }
                });
            }

            return interfaz;
        });

