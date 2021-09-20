'use strict'

angular.module('moduleMuestraService', [])

        .factory('muestraService', function ($http, $timeout) {
            var currentMuestra = {
                status: 'empty',
            }

            var interfaz = {
                saveMuestra: function (muestraData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'saveMuestra2',
                            muestraData: muestraData
                        })
                    });
                },
                getMuestra: function (idMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'GetMuestraReferenciasDetalleById',
                            idMuestra: idMuestra
                        }
                    });
                },
                updateMuestra: function (muestraData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'updateMuestra2',
                            muestraData: muestraData
                        })
                    });
                },
                anularMuestra: function (idMuestra, motivoAnulacion, usuario) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'anularMuestra',
                            idMuestra: idMuestra,
                            motivoAnulacion: motivoAnulacion,
                            usuario: usuario
                        })
                    });
                },
                verificarMuestra: function (muestra, conclusion, fecha_conclusion, observacion) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'verificarMuestra',
                            muestra: muestra,
                            conclusion: conclusion,
                            fecha_conclusion: fecha_conclusion,
                            observacion: observacion
                        })
                    });
                },
                scanDirByIdMuestra: function (idMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'scanDirByIdMuestra',
                            idMuestra: idMuestra
                        }
                    });
                },
                revisarMuestra: function (muestra, conclusion, fecha_pre_conclusion, observacion) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'revisarMuestra',
                            muestra: muestra,
                            conclusion: conclusion,
                            fecha_pre_conclusion: fecha_pre_conclusion,
                            observacion: observacion
                        })
                    });
                },
                exportExcelUsoReactivosMuestra: function (idReactivos, fechaInicial, fechaFin) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'exportExcelUsoReactivosMuestra',
                            idReactivos: idReactivos,
                            fechaInicial: fechaInicial,
                            fechaFin: fechaFin
                        })
                    });
                },
                exportExcelResumenMuestra: function (data) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'exportExcelResumenMuestra',
                            muestra: data.muestra,
                            producto: data.producto,
                            analista: data.analista,
                            ensayos: data.ensayos,
                            estadoMuestra: data.estadoMuestra,
                            cliente: data.cliente
                        })
                    });
                },
                getMuestrasToConsultaMuetras: function (data) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getMuestrasToConsultaMuetras',
                            cantidad: data.cantidad,
                            pagina: data.pagina,
                            prefijo: data.prefijo,
                            customId: data.customId,
                            producto: data.producto,
                            tercero: data.tercero,
                            lote: data.lote,
                            estadoMuestra: data.estadoMuestra,
                            fechaLlegada: data.fechaLlegada,
                            fechaCompromiso: data.fechaCompromiso,
                            observacion: data.observacion,
                            contacto: data.contacto,
                            numFactura: data.numFactura,
                            fechaEntrega: data.fechaEntrega
                        }
                    });
                },
                getResumenMuestras: function (data) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getResumenMuestras',
                            cantidad: data.cantidad,
                            pagina: data.pagina,
                            muestra: data.muestra,
                            producto: data.producto,
                            analista: data.analista,
                            ensayos: data.ensayos,
                            estadoMuestra: data.estadoMuestra,
                            cliente: data.cliente
                        }
                    });
                },
                
                consultaAuditoriaMuestra: function (idMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'consultaAuditoriaMuestra',
                            idMuestra: idMuestra
                        }
                    });
                },

                consultaMuestraAuditoria: function (muestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'consultaMuestraAuditoria',
                            muestra: muestra
                        }
                    });
                },
                
                consultaAuditoriaMuestraDetallada: function (idMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'consultaAuditoriaMuestraDetallada',
                            idMuestra: idMuestra
                        }
                    });
                },

                getEnsayoMuestraInformacionGeneralHojaCalculo: function (idEnsayoMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayoMuestraInformacionGeneralHojaCalculo',
                            idEnsayoMuestra: idEnsayoMuestra
                        }
                    });
                },

                getFuncionesHojaCalculo: function (idEnsayoMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getFuncionesHojaCalculo',
                            idEnsayoMuestra: idEnsayoMuestra
                        }
                    });
                },

                getHojaCalculoEnsayoMuestra: function (idEnsayoMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getHojaCalculoEnsayoMuestra',
                            idEnsayoMuestra: idEnsayoMuestra
                        }
                    });
                },

                saveEnsayoMuestraHojaCalculo: function (idEnsayoMuestra, data) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'saveEnsayoMuestraHojaCalculo',
                            idEnsayoMuestra: idEnsayoMuestra,
                            data: data
                        })
                    });
                },

                updateEnsayoMuestraHojaCalculo: function (idEnsayoMuestra, data, idHojaCalculoEnsayoMuestra) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateEnsayoMuestraHojaCalculo',
                            idEnsayoMuestra: idEnsayoMuestra,
                            data: data,
                            idHojaCalculoEnsayoMuestra: idHojaCalculoEnsayoMuestra
                        })
                    });
                },
            }

            return interfaz;
        });