'use strict'

angular.module('CompHojaTrabajo')

        .factory('hojaTrabajoService', function ($q, $filter, ensayoMuestraService, muestraService, resultadoService, utileService) {
            var interfaz = {
                clickSearchMuestra: clickSearchMuestra,
                limpiar: limpiar,
                loadUserInfo: loadUserInfo,
                openModalAnalizarEnsayo: openModalAnalizarEnsayo,
                eventClickAnalizarEnsayo: eventClickAnalizarEnsayo,
                eventClickGuardarResultado: eventClickGuardarResultado,
                actualizarResultado: actualizarResultado,
                aprobarEnsayoMuestra: aprobarEnsayoMuestra,
                rechazarEnsayoMuestra: rechazarEnsayoMuestra,
                verificarMuestra: verificarMuestra,
                eventClickInformePrevio: eventClickInformePrevio,
                eventClickButtonHojaAnexo: eventClickButtonHojaAnexo,
                eventClickButtonHojaDatosPrimarios: eventClickButtonHojaDatosPrimarios,
                revisarMuestra: revisarMuestra,
                eventClickReprogramarEnsayo: eventClickReprogramarEnsayo,
                eventClickRfeEnsayo: eventClickRfeEnsayo,
                checkAll: checkAll,
                eventClickCondiciones: eventClickCondiciones
            }

            function revisarMuestra(vm) {
                angular.element(revisarMuestraModal).modal("hide");
                vm.waitModalText = 'Revisando muestra...'
                angular.element(waitModal).modal("show");
                var fecha_pre_conclusion = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
                muestraService.revisarMuestra(vm.currentLoadedMuestra, vm.currentLoadedMuestra.conclusion_muestra, fecha_pre_conclusion, vm.currentLoadedMuestra.observacion).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                    } else {
                        console.log('Error al revisar muestra');
                        console.error(response.data);
                    }
                });
            }

            function verificarMuestra(vm) {
                angular.element(verificarMuestraModal).modal("hide");
                vm.waitModalText = 'Verificando muestra...'
                angular.element(waitModal).modal("show");
                var fecha_conclusion = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
                muestraService.verificarMuestra(vm.currentLoadedMuestra, vm.currentLoadedMuestra.conclusion_muestra, fecha_conclusion, vm.currentLoadedMuestra.observacion).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                    } else {
                        console.log('Error al verificar muestra');
                        console.error(response.data);
                    }
                });
            }

            function eventClickReprogramarEnsayo(vm) {
                angular.element(reprogramarEnsayoModal).modal("hide");
                vm.waitModalText = 'Reprogramando ensayo...'
                angular.element(waitModal).modal("show");
                vm.ensayoReprogramar.fecha_reprogramacion = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
                ensayoMuestraService.reprogramarEnsayoMuestra(vm.ensayoReprogramar).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                    } else {
                        console.log('Error al reprogramar muestra');
                        console.error(response.data);
                    }
                });
            }

            function eventClickRfeEnsayo(vm) {
                angular.element(rfeEnsayoModal).modal("hide");
                vm.waitModalText = 'RFE ensayo...'
                angular.element(waitModal).modal("show");
                vm.ensayoRfe.fecha_reprogramacion = $filter('date')(new Date(), 'yyyy-MM-dd HH:mm:ss');
                ensayoMuestraService.rfeEnsayoMuestra(vm.ensayoRfe).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                    } else {
                        console.log('Error al reprogramar muestra');
                        console.error(response.data);
                    }
                });
            }

            function rechazarEnsayoMuestra(vm) {
                $('#rechazarAnalisisMuestraModal').modal('hide');
                vm.waitModalText = 'Rechazando Ensayo...'
                angular.element(waitModal).modal("show");
                ensayoMuestraService.rechazarEnsayoMuestra(vm.ensayoRechazado).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                    } else {
                        console.log('Error al rechazar resultado resultado');
                        console.error(response.data);
                    }
                });
            }

            function aprobarEnsayoMuestra(vm, ensayo) {
                vm.waitModalText = 'Aprobado Ensayo...'
                angular.element(waitModal).modal("show");
                ensayoMuestraService.aprobarEnsayoMuestra(ensayo).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                    } else {
                        console.log('Error al aprobar resultado resultado');
                        console.error(response.data);
                    }
                });
            }

            function actualizarResultado(vm, resultado, ensayo) {
                if (ensayo.resultados[0].resultado !== '' && ensayo.resultados[0].resultado !== null) {
                    vm.waitModalText = 'Actualizando Resultado...'
                    angular.element(waitModal).modal("show");
                    resultado.fecha_registro = $filter('date')(new Date(), 'yyyy-MM-dd');
                    resultadoService.actualizarResultado(resultado, vm.currentLoadedMuestra, ensayo).then(function (response) {
                        if (response.data.code == '00000') {
                            clickSearchMuestra(vm, null);
                        } else {
                            console.log('Error al actualizar resultado');
                            console.error(response.data);
                        }
                    });
                } else {
                    openNotification('error', 'Debe ingresar un valor en el campo Resultado');
                }
            }

            function eventClickGuardarResultado(vm, ensayo) {
                var resultado = ensayo.resultados[0].resultado;
                if (resultado !== '' && resultado !== null) {
                    vm.waitModalText = 'Registrando resultado...'
                    angular.element(waitModal).modal("show");
                    ensayo.resultados[0].fecha_registro = $filter('date')(new Date(), 'yyyy-MM-dd');
                    resultadoService.guardarResultado(vm.currentLoadedMuestra, ensayo).then(function (response) {
                        if (response.data.code == '00000') {
                            clickSearchMuestra(vm, null);
                        } else {
                            console.log('Error al registrar resultado');
                            console.error(response.data);
                        }
                    });
                } else {
                    openNotification('error', 'Debe ingresar un valor en el campo Resultado');
                }
            }

            function loadNotification() {
                $("#notificationAdminPerfil").jqxNotification({
                    width: 250, position: "top-right", opacity: 0.9,
                    autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
                });
            }

            function openNotification(template, message) {
                $("#messageNotificationAdminPerfil").text(message);
                $("#notificationAdminPerfil").jqxNotification({template: template});
                $("#notificationAdminPerfil").jqxNotification("open");
            }


            function eventClickAnalizarEnsayo(vm) {
                angular.element(analizarEnsayoModal).modal("hide");
                vm.waitModalText = 'Actualizando Ensayo...'
                angular.element(waitModal).modal("show");
                //var ensayosAnalizados = vm.currentLoadedMuestra.ensayos.filter((elem) => elem.checked === true);
                var auxFecha = $filter('date')(vm.analizarEnsayoDate, 'yyyy-MM-dd HH:mm:ss');
                var ensayosAnalizados = []; //array, you were using object
                angular.forEach(vm.currentLoadedMuestra.ensayos, function (value) {
                    if (value.checked === true) {
                        ensayosAnalizados.push(value.id);
                    }

                });
                console.log(ensayosAnalizados);
                var muestra = angular.copy(vm.currentLoadedMuestra);
                muestra.ensayos = [];
                ensayoMuestraService.analizarEnsayoMuestra(muestra, ensayosAnalizados, auxFecha).then(function (response) {
                    if (response.data.code == '00000') {
                        clickSearchMuestra(vm, null);
                        vm.checkAllElem = false;
                    } else {
                        console.log('Error marcar analisis de ensayo');
                        console.error(response.data);
                    }
                });
            }

            function openModalAnalizarEnsayo(vm) {
                //vm.selectedEnsayoAnalisis = ensayo;
                vm.modalAnalizarEnsayoTitulo = 'Análisis del ensayo';
                vm.analizarEnsayoDate = new Date();
                angular.element(analizarEnsayoModal).modal('show');
            }

            function loadUserInfo(vm) {
                return utileService.getSessionUserData().then(function (response) {
                    vm.sessionUserData = response.data.data;
                });
            }

            function limpiar(vm, event) {
                vm.currentLoadedMuestra = null;
                vm.currentLoadedMuestra = null;
            }

            function buscarEnsayosAsignadosAnalista(vm) {
                if (vm.sessionUserData.userIdPerfil == '6' && vm.currentLoadedMuestra.id_estado_muestra != 17 && vm.currentLoadedMuestra.id_estado_muestra != 11 && vm.currentLoadedMuestra.id_estado_muestra != 10) {
                    return ensayoMuestraService.obtenerEnsayosAsignados(vm.sessionUserData.userId, vm.currentLoadedMuestra.id).then(function (response) {
                        vm.ensayosAsignados = response.data.data;
                    });
                } else {
                    return $q.when(vm.sessionUserData);
                }
            }

            function clickSearchMuestra(vm, event) {
                vm.statusScreen = 'loadingAnalisis';
                vm.waitModalText = 'Consultado datos de análisis un momento por favor...'
                loadNotification();
                angular.element(waitModal).modal("show");
                muestraService.getMuestra(vm.idMuestra).then(function (response) {
                    console.log('sessionUserData', vm.sessionUserData);
                    var data = response.data[0];
                    if (data.code == '00000') {

                        if (data.data.muestra.id_estado_muestra !== '11') {

                            vm.currentLoadedMuestra = data.data.muestra;
                            vm.currentLoadedMuestra.ensayos = filtrarEnsayos(vm, vm.currentLoadedMuestra.ensayos);
                            console.log('ENSAYOS', vm.currentLoadedMuestra.ensayos);

                            buscarEnsayosAsignadosAnalista(vm).then(function () {
                                angular.forEach(vm.currentLoadedMuestra.ensayos, function (value, key) {
                                    if (vm.sessionUserData.userId == 1) {
                                        value.asignado = true;
                                    }
                                    try {
                                        if (value.fecha_analisis) {
                                            var dateParts = value.fecha_analisis.split("-");
                                            value.fecha_analisis = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
                                        }
                                        angular.forEach(vm.ensayosAsignados, function (ensayoAsignado, keyAsignado) {
                                            if (value.id == ensayoAsignado.id) {
                                                value.asignado = true;

                                            }
                                        });

                                        vm.currentLoadedMuestra.ensayos[key].resultados[0].resultado_1 = parseInt(vm.currentLoadedMuestra.ensayos[key].resultados[0].resultado_1);
                                        vm.currentLoadedMuestra.ensayos[key].resultados[0].resultado_2 = parseInt(vm.currentLoadedMuestra.ensayos[key].resultados[0].resultado_2);

                                        vm.currentLoadedMuestra.ensayos[key].resultados[0].promedioCalc = (vm.currentLoadedMuestra.ensayos[key].resultados[0].resultado_1 + vm.currentLoadedMuestra.ensayos[key].resultados[0].resultado_2) / 2;
                                    } catch (e) {
                                        vm.currentLoadedMuestra.ensayos[key].resultados[0] = {
                                            resultado_1: 0,
                                            resultado_2: 0,
                                            promedioCalc: 0,
                                            resultado_numerico: 0,
                                            resultado: ""
                                        }

                                    }

                                });
                            });

                            vm.currentLoadedMuestra.yaRevisada = (vm.currentLoadedMuestra.usuario_pre_conclusion !== null && vm.currentLoadedMuestra.fecha_pre_conclusion !== null) ? true : false;

                            console.log(vm.currentLoadedMuestra);
                        } else {
                            openNotification('error', 'No se puede consultar una muestra anulada en este módulo');
                        }
                    } else {
                        console.log('Error en al consulta de muestra');
                        console.error(response.data);
                    }
                    angular.element(waitModal).modal("hide");
                    vm.statusScreen = 'ready';
                });
            }



            function filtrarEnsayos(vm, ensayos) {
                var ensayosAfiltrar = angular.copy(ensayos);
                var ensayosFiltrados = null;
                ensayosFiltrados = filtrarEnsayosSeleccionados(ensayosAfiltrar);
                ensayosFiltrados = filtrarEnsayosLabor(vm, ensayosFiltrados);
                return ensayosFiltrados;
            }

            function filtrarEnsayosSeleccionados(ensayos) {
                return $filter('filter')(ensayos, {validacion: true});
            }

            function filtrarEnsayosLabor(vm, ensayos) {
                if (vm.sessionUserData.permisos.consultaResultadoHojaTrabajo || vm.sessionUserData.permisos.registroResultadoHojaTrabajo || vm.sessionUserData.permisos.reprogramacionEnsayoHojaTrabajo || vm.sessionUserData.permisos.revisionEnsayoHojaTrabajo || vm.sessionUserData.permisos.aprobarMuestraHojaTrabajo) {
                    return ensayos;
                } else if (vm.sessionUserData.permisos.checkAnalisisRealizadoHojaTrabajo) {
                    return $filter('filter')(ensayos, {programacion: {id_analista: vm.sessionUserData.userId}});
                }


            }

            function eventClickInformePrevio(vm) {
                var tienePermiso = validarExistePermiso(vm, vm.sesionUserData.session.systemsParameters.perfilesImpresionInforme);
                if (tienePermiso) {
                    $("#idPerfilFinal").val(true);

                } else {
                    $("#idPerfilFinal").val(false);
                }
                $("#idMuestraFinal").val(vm.currentLoadedMuestra.id);
                window.open('', 'informeFinal');
                $("#formEnvioFinal").submit();
            }

            function eventClickButtonHojaAnexo(vm) {
                var tienePermiso = validarExistePermiso(vm, vm.sesionUserData.session.systemsParameters.perfilesImpresionHojaTrabajo);
                if (tienePermiso) {
                    console.log("entró");
                    $("#idPerfilHA").val(true);

                } else {
                    $("#idPerfilHA").val(false);
                }
                $("#idMuestraHA").val(vm.currentLoadedMuestra.id);
                window.open('', 'hojaTrabajoAnexo');
                $("#formHojaAnexo").submit();
            }

            function validarExistePermiso(vm, perfiles) {
                var arrayPerfiles = perfiles.split(",");
                var existe = arrayPerfiles.find(function (value) {
                    return value == vm.sessionUserData.userIdPerfil;
                });
                var tienePermiso = existe === undefined ? false : true;
                return tienePermiso;
            }

            function eventClickButtonHojaDatosPrimarios(vm) {
                var tienePermiso = validarExistePermiso(vm, vm.sesionUserData.session.systemsParameters.perfilesImpresionHojaTrabajo);
                if (tienePermiso) {
                    console.log("entró");
                    $("#idPerfilHT").val(true);

                } else {
                    $("#idPerfilHT").val(false);
                }
                $("#idMuestraHT").val(vm.currentLoadedMuestra.id);
                window.open('', 'hojaTrabajoFinal');
                $("#formHojaTrabajo").submit();
            }

            function checkAll(vm, evento) {
                angular.forEach(vm.currentLoadedMuestra.ensayos, function (ensayo, key) {

                    if (ensayo.asignado && vm.sessionUserData.permisos.checkAnalisisRealizadoHojaTrabajo && ensayo.estado_ensayo == 1 && (vm.currentLoadedMuestra.id_estado_muestra != 17 && vm.currentLoadedMuestra.id_estado_muestra != 11 && vm.currentLoadedMuestra.id_estado_muestra != 10)) {
                        if (evento.checked) {
                            ensayo.checked = true;
                        } else {
                            ensayo.checked = false;
                        }
                    }
                });
            }

            function eventClickCondiciones(vm) {
                var tienePermiso = validarExistePermiso(vm, vm.sesionUserData.session.systemsParameters.perfilesImpresionHojaTrabajo);
                if (tienePermiso) {
                    $("#idPerfilCondiciones").val(true);

                } else {
                    $("#idPerfilCondiciones").val(false);
                }
                $("#idMuestraCondiciones").val(vm.currentLoadedMuestra.id);
                $("#opcion").val(1);
                $("#formCondiciones").submit();
            }

            return interfaz;
        });

