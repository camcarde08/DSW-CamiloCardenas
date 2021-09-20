'use strict';
angular.module('CompBandejaEntrada', ['chart.js'])


        .controller('compBandejaEntradaCtrl', function ($q, bandejaEntradaServiceComp, factoryBandejaEntradaService) {
            var vm = this;

            vm.$onInit = function () {
                vm.nombreBandejas = [];
            };

            vm.$postLink = function () {

                bandejaEntradaServiceComp.obtenerInformacionUsuario(vm).then(function () {
                    bandejaEntradaServiceComp.loadNotificationAdminPerfil(vm);
                    if (vm.usuario.permisosBandejaEntrada.muestrasVerificadas)
                        bandejaEntradaServiceComp.getMuestrasVerificadas(vm);
                    if (vm.usuario.permisosBandejaEntrada.muestrasXProgramarFQ)
                        bandejaEntradaServiceComp.getEnsayosPorProgramarFisicoquimicos(vm);
                    if (vm.usuario.permisosBandejaEntrada.muestrasXProgramarMB)
                        bandejaEntradaServiceComp.getEnsayosPorProgramarMicrobiologicos(vm);
                    if (vm.usuario.permisosBandejaEntrada.EnsayosEstadoProgramado)
                        bandejaEntradaServiceComp.getProgramacionAnalista(vm);
                    if (vm.usuario.permisosBandejaEntrada.EnsayosEstadoParaTranscrip)
                        bandejaEntradaServiceComp.getEnsayosParaTranscripcion(vm);
                    if (vm.usuario.permisosBandejaEntrada.ensayosParaRevisionMB)
                        bandejaEntradaServiceComp.getEnsayosParaRevisionMB(vm);
                    if (vm.usuario.permisosBandejaEntrada.ensayosParaRevisionFQ)
                        bandejaEntradaServiceComp.getEnsayosParaRevisionFQ(vm);
                    if (vm.usuario.permisosBandejaEntrada.muestrasParaVerificar)
                        bandejaEntradaServiceComp.getMuestrasParaVerificar(vm);
                    if (vm.usuario.permisosBandejaEntrada.subMuestrasEstabilidadParaProgramar)
                        bandejaEntradaServiceComp.getSubMuestrasEstabilidadParaProgramar(vm);
                    //if (vm.usuario.permisosBandejaEntrada.subMuestrasEstabilidadParaAnalisis)
                    //bandejaEntradaServiceComp.getSubMuestrasEstabilidadParaAnalisis(vm);
                    //manejado por component js
                    //if (vm.usuario.permisosBandejaEntrada.subMuestrasEstabilidadParaTrancripcion)
                    // anejado por compoente js
                    // bandejaEntradaServiceComp.getSubMuestrasEstabilidadParaTranscripcion(vm);
                    //if (vm.usuario.permisosBandejaEntrada.subMuestrasEstabilidadParaRevision)
                    // manejado por componente js
                    //bandejaEntradaServiceComp.getSubMuestrasEstabilidadParaRevision(vm);
                    // manejado por componente js
                    //bandejaEntradaServiceComp.getMuestrasParaFacturacion(vm);
                    // manejado por componente js
                    //if (vm.usuario.permisosBandejaEntrada.muestrasParaEntrega)
                    //bandejaEntradaServiceComp.getMuestrasParaEntrega(vm);
                    if (vm.usuario.permisosBandejaEntrada.muestrasSalida)
                        bandejaEntradaServiceComp.getMuestrasSalida(vm);
                    if (vm.usuario.permisosBandejaEntrada.solicitudesParaRecoleccion)
                        bandejaEntradaServiceComp.getSolicitudesParaRecoleccion(vm);
                    if (vm.usuario.permisosBandejaEntrada.solicitudesProgramadas)
                        bandejaEntradaServiceComp.getSolicitudesProgramadas(vm);
                    if (vm.usuario.permisosBandejaEntrada["19"])
                        bandejaEntradaServiceComp.getSubMuestrasEstabilidadAprobadas(vm);
                    if (vm.usuario.permisosBandejaEntrada["20"])
                        bandejaEntradaServiceComp.getSubMuestrasEstabilidadParaRevision2(vm);
                });


                vm.eventClickImageDetalleInforme = function (idMuestra) {
                    bandejaEntradaServiceComp.eventClickImageDetalleInforme(vm, idMuestra);
                };
                vm.eventClickBtnAlmacenarMuestra = function (idMuestra) {
                    bandejaEntradaServiceComp.eventClickBtnAlmacenarMuestra(vm, idMuestra);
                }

                vm.eventClickProgramarMuestra = function (idMuestra) {
                    bandejaEntradaServiceComp.eventClickProgramarMuestra(vm, idMuestra);
                }

                vm.eventClickHojaTrabajo = function (idMuestra) {
                    bandejaEntradaServiceComp.eventClickHojaTrabajo(vm, idMuestra);
                }

                vm.eventClickInformeCliente = function (idMuestra) {
                    bandejaEntradaServiceComp.eventClickInformeCliente(vm, idMuestra);
                }

                vm.eventClickProgramarSubMuestraEstabilidad = function (subMuestra) {
                    bandejaEntradaServiceComp.eventClickProgramarSubMuestraEstabilidad(vm, subMuestra);
                }

                vm.eventClickResultadosSubMuestraEstabilidad = function (subMuestra) {
                    bandejaEntradaServiceComp.eventClickResultadosSubMuestraEstabilidad(vm, subMuestra);
                }

                vm.eventClickResultadosSubMuestraEstabilidad2 = function (subMuestra) {
                    bandejaEntradaServiceComp.eventClickResultadosSubMuestraEstabilidad2(vm, subMuestra);
                }

                vm.eventClickActualizarFechaEntrega = function (muestraEntrega) {
                    bandejaEntradaServiceComp.eventClickActualizarFechaEntrega(vm, muestraEntrega);
                }

                vm.eventClickDarSalidaMuestra = function (muestraSalida) {
                    bandejaEntradaServiceComp.eventClickDarSalidaMuestra(vm, muestraSalida);
                }

                vm.eventClickModalProgramarSolicitud = function (solicitudRecoleccion) {
                    bandejaEntradaServiceComp.eventClickModalProgramarSolicitud(vm, solicitudRecoleccion);
                }

                vm.eventClickProgramarSolicitud = function () {
                    bandejaEntradaServiceComp.eventClickProgramarSolicitud(vm);
                }

                vm.eventClickSolicitudAtendida = function (solicitud) {
                    bandejaEntradaServiceComp.eventClickSolicitudAtendida(vm, solicitud);
                }

                vm.fechaMinCompromiso = function (muestra) {
                    var fechaCompromiso = muestra.ensayos[0].fecha_comp_internoEnsayo;
                    angular.forEach(muestra.ensayos, function (value, key) {
                        fechaCompromiso = value.fecha_comp_internoEnsayo < fechaCompromiso ? value.fecha_comp_internoEnsayo : fechaCompromiso;
                    });
                    muestra.fecha_compromiso_ensayos = fechaCompromiso;
                    return fechaCompromiso;
                }

                vm.evaluarAlertaFechaCompromiso = function (fechaCompromiso) {
                    return factoryBandejaEntradaService.evaluarAlertaFechaCompromiso(vm.diasAnticipacionAlertaBandejaEntrada, fechaCompromiso);
                };

            }
            ;
        })

        .component('sgmBandejaEntrada', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/bandeja-entrada.html',
            controller: 'compBandejaEntradaCtrl',
            controllerAs: 'vm',
            bindings: {
                evaluarAlertaFechaCompromiso: '&'
            }
        });







