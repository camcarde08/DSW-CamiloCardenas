'use strict'

angular.module('CompAdminMedioCultivo')

        .factory('adminMedioCultivoService', function ($timeout, $q, $filter, medioCultivoService, loteMedioCultivoService, cepaService) {
            var interfaz = {
                // carga parametros de la grilla de medios de cultivo
                getAllMediosCultivo: function (vm) {
                    vm.waitModalText = 'Cargando datos de medios de cultivo, un momento por favor ...';
                    $('#waitModal').modal('show');
                    medioCultivoService.getAllMedioCultivo().then(function (response) {
                        $('#waitModal').modal('hide');
                        if (response.data.code == "00000") {
                            vm.sourceGridMediosCultivo = response.data.data;
                        } else {
                            console.log('Error consultando medios de cultivo')
                        }
                    });
                },
                clickCrearMedio: function (vm) {
                    console.log(vm.newMedio);
                    medioCultivoService.saveNewMedioCultivo(vm.newMedio).then(function (response) {
                        if (response.data.code == "00000") {
                            interfaz.closeNewMedioModal(vm);
                            interfaz.getAllMediosCultivo(vm);
                            vm.medioCultivoSelected = null;
                        }

                    });
                },
                closeNewMedioModal: function (vm) {
                    try {
                        interfaz.cleanFormNewMedio(vm);
                    } catch (error) {

                    }
                    $('#myModal').modal('hide');
                },
                cleanFormNewMedio: function (vm) {
                    vm.newMedio.codigo = "";
                    vm.newMedio.nombre = "";
                    vm.newMedio.tipo = "";
                    vm.newMedio.temperatura = "";
                },
                clickCrearLote: crearLote,
                desasociarCepas: desasociarCepas,
                asociarCepas: asociarCepas,
                openModalNewMedio: openModalNewMedio,
                gridMediosCultivoSelectRowEvent: gridMediosCultivoSelectRowEvent,
                confirmarCambiosMediosCultivo: confirmarCambiosMediosCultivo,
                descartarCambiosMediosCultivo: descartarCambiosMediosCultivo,
                editarMedioCultivo: editarMedioCultivo,
                eliminarMedioCultivo: eliminarMedioCultivo,
                openModalNewLote: openModalNewLote,
                clickTdGrillaLoteMedioCultivo: clickTdGrillaLoteMedioCultivo,
                clickConfirmActivateLote: clickConfirmActivateLote,
                activarLote: activarLote,
                editarLote: editarLote
            };

            function asociarCepas(vm) {
                vm.waitModalText = 'Actualizando informacion del medio de cultivo un momento por favor ...';
                $('#waitModal').modal('show');
                var asociacion = $filter('filter')(vm.cepasDisponibles, {select: true});
                cepaService.asociarCepas(vm.medioCultivoSelected.id, asociacion).then(function (response) {
                    if (response.data.code == '00000') {

                    } else {
                        console.error(response);
                    }
                    loadDatosMediosCultivo(vm);
                });
            }

            function desasociarCepas(vm) {
                vm.waitModalText = 'Actualizando informacion del medio de cultivo un momento por favor ...';
                $('#waitModal').modal('show');
                var asociacionBorrar = $filter('filter')(vm.cepasAsociadas, {select: true});
                cepaService.desasociarCepas(asociacionBorrar).then(function (response) {
                    if (response.data.code == '00000') {

                    } else {
                        console.error(response);
                    }
                    loadDatosMediosCultivo(vm);
                });

            }

            function clickConfirmActivateLote(vm) {
                $('#modalCofirmmActivarLote').modal('hide');
                vm.waitModalText = 'Activando lote un momento por favor ...';
                $('#waitModal').modal('show');
                loteMedioCultivoService.activateLoteMedioCultivo(vm.loteSelected.id, vm.medioCultivoSelected.id).then(function (response) {
                    //$('#waitModal').modal('hide');
                    if (response.data.code == '00000') {
                        //loadLotes(vm);
                        loadDatosMediosCultivo(vm);
                    } else {
                        console.error(response);
                    }
                });
            }

            function activarLote(vm) {
                angular.element(modalCofirmmActivarLote).modal('show');
            }

            function crearLote(vm) {

                $('#modalNewLote').modal('hide');
                vm.waitModalText = 'Creando nuevo lote un momento por favor ...';
                $('#waitModal').modal('show');
                var newLoteData = {
                    codigo: vm.newLote.codigo,
                    descripcion: vm.newLote.descripcion,
                    fecha_vencimiento: $filter('date')(vm.newLote.fechaVencimiento, 'yyyy-MM-dd'),
                    activo: 0,
                    tipo: vm.newLote.tipo,
                    cantidad_actual: vm.newLote.cantidadActual,
                    fecha_ingreso: $filter('date')(vm.newLote.fechaIngreso, 'yyyy-MM-dd'),
                    fecha_apertura: $filter('date')(vm.newLote.fechaApertura, 'yyyy-MM-dd'),
                    fecha_terminacion: $filter('date')(vm.newLote.fechaTerminacion, 'yyyy-MM-dd'),
                    fecha_preparacion: $filter('date')(vm.newLote.fechaPreparacion, 'yyyy-MM-dd'),
                    fecha_promocion: $filter('date')(vm.newLote.fechaPromocion, 'yyyy-MM-dd'),
                    cantidad_preparada: vm.newLote.cantidadPreparada,
                    id_medio_cultivo: vm.medioCultivoSelected.id,
                    lote_interno: vm.newLote.lote_interno
                }

                loteMedioCultivoService.saveNewLoteMedioCultivo(newLoteData).then(function (response) {
                    console.log(response);
                    //$('#waitModal').modal('hide');
                    if (response.data.code == '00000') {
                        //loadLotes(vm);
                        loadDatosMediosCultivo(vm);
                        vm.instanceMessageSuccessAddLote.open();
                    } else {
                        vm.instanceMessageErrorAddLote2.open();
                    }

                });
                //loadLotes(vm);
            }

            function openModalNewMedio(vm) {
                $('#myModal').modal('show');
            }

            function gridMediosCultivoSelectRowEvent(vm, medioCultivo, index) {
                angular.forEach(vm.sourceGridMediosCultivo, function (value, key) {
                    key == index ? value.selected = true : value.selected = false;
                });
                selectMedioCultivo(vm, medioCultivo);
            }

            function selectMedioCultivo(vm, medioCultivo) {
                vm.medioCultivoSelected = medioCultivo;
                vm.waitModalText = 'Activando datos de medio del cultivo un momento por favor ...';
                $('#waitModal').modal('show');
                var promises = {
                    lotes: loadLotes(vm),
                    cepasAsocidas: loadCepasAsociadasMedioCultivo(vm),
                    cepasDisponibles: loadCepasDisponibles(vm)
                }
                $q.all(promises).then(function () {
                    $('#waitModal').modal('hide');
                });
            }

            function loadDatosMediosCultivo(vm) {
                vm.waitModalText = 'Activando datos de medio del cultivo un momento por favor ...';
                $('#waitModal').modal('show');
                var promises = {
                    lotes: loadLotes(vm),
                    cepasAsocidas: loadCepasAsociadasMedioCultivo(vm),
                    cepasDisponibles: loadCepasDisponibles(vm)
                }

                $q.all(promises).then(function () {

                    $('#waitModal').modal('hide');


                });

            }

            function loadCepasDisponibles(vm) {
                return cepaService.getCepasDisponiblesByIdMedioCultivo(vm.medioCultivoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.cepasDisponibles = angular.copy(response.data.data);
                        console.debug('Carga de cepas ok');
                    } else {
                        vm.sourceGridLoteMediosCultivo = [];
                        console.error(response);
                    }
                });
            }

            function loadCepasAsociadasMedioCultivo(vm) {
                return cepaService.getActiveCepasByIdMediCultivo(vm.medioCultivoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.cepasAsociadas = angular.copy(response.data.data);
                    } else {
                        vm.sourceGridLoteMediosCultivo = [];
                        console.error(response);
                    }
                });
            }

            function loadLotes(vm) {
                return loteMedioCultivoService.getLotesByIdMedioCultivo(vm.medioCultivoSelected.id).then(function (response) {
                    console.log(response);
                    if (response.data.code == "00000") {
                        angular.forEach(response.data.data, function (value, key) {
                            formatLote(value);
                        });
                        vm.sourceGridLoteMediosCultivo = response.data.data;
                    } else {
                        vm.sourceGridLoteMediosCultivo = [];
                        console.error(response);
                    }
                });
            }

            function formatLote(lote) {
                if (lote.fecha_ingreso) {
                    lote.fecha_ingreso = formatDateString(lote.fecha_ingreso);
                } else {
                    lote.fecha_ingreso = null;
                }

                if (lote.fecha_apertura) {
                    lote.fecha_apertura = formatDateString(lote.fecha_apertura);
                } else {
                    lote.fecha_apertura = null;
                }

                if (lote.fecha_terminacion) {
                    lote.fecha_terminacion = formatDateString(lote.fecha_terminacion);
                } else {
                    lote.fecha_terminacion = null;
                }

                if (lote.fecha_preparacion) {
                    lote.fecha_preparacion = formatDateString(lote.fecha_preparacion);
                } else {
                    lote.fecha_preparacion = null;
                }

                if (lote.fecha_promocion) {
                    lote.fecha_promocion = formatDateString(lote.fecha_promocion);
                } else {
                    lote.fecha_promocion = null;
                }

                if (lote.fecha_vencimiento) {
                    lote.fecha_vencimiento = formatDateString(lote.fecha_vencimiento);
                } else {
                    lote.fecha_vencimiento = null;
                }

            }

            function formatDateString(dateString) {
                var dateParts = dateString.split("-");
                return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
            }

            function descartarCambiosMediosCultivo(vm, medioCultivo) {
                medioCultivo.edit = false;
                medioCultivo.codigo = medioCultivo.backup.codigo;
                medioCultivo.nombre = medioCultivo.backup.nombre;
                medioCultivo.tipo = medioCultivo.backup.tipo;
                medioCultivo.backup = null;
            }


            function confirmarCambiosMediosCultivo(vm, medioCultivo) {
                medioCultivoService.updateMedioCultivoData(medioCultivo).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de reactivo ' + medioCultivo.id + 'OK');
                        medioCultivo.backup = null;
                        //$('#waitModal').modal('hide');
                        medioCultivo.edit = false;
                    } else {
                        console.log('falla en la actualización del reactivo ' + medioCultivo.id);
                        console.error(response);
                        descartarCambiosMediosCultivo(vm, medioCultivo);
                    }
                });
            }

            function editarMedioCultivo(vm, medioCultivo) {
                medioCultivo.backup = angular.copy(medioCultivo);
                medioCultivo.edit = true;
            }

            function eliminarMedioCultivo(vm, medioCultivo, index) {
                vm.waitModalText = 'Eliminando medio de cultivo, un momento por favor ...';
                $('#waitModal').modal('show');
                medioCultivoService.deleteMedioCultivo(medioCultivo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el medio de cultivo ' + medioCultivo.id);
                        vm.sourceGridMediosCultivo.splice(index, 1);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la eliminación del medio de cultivo');
                        console.error(response);
                    }
                });
            }

            function openModalNewLote(vm) {
                cleanModalNewLote(vm);
                $('#modalNewLote').modal('show');
            }

            function cleanModalNewLote(vm) {
                vm.newLote = {
                    fechaVencimiento: new Date(),
                    fechaIngreso: new Date(),
                    fechaApertura: new Date(),
                    fechaTerminacion: new Date(),
                    fechaPreparacion: new Date(),
                    fechaPromocion: new Date(),
                }
            }

            function clickTdGrillaLoteMedioCultivo(vm, index, lote) {
                vm.loteSelected = lote;
                angular.forEach(vm.sourceGridLoteMediosCultivo, function (value, key) {
                    key == index ? value.selected = true : value.selected = false;
                });
            }

            function editarLote(vm, lote) {
                vm.waitModalText = 'Actualizando lote un momento por favor ...';
                angular.element(waitModal).modal('show');
                loteMedioCultivoService.updateLoteMedioCultivo(lote).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de lote medio cultivo ' + lote.id + 'OK');
                        angular.element(waitModal).modal('hide');
                        vm.loteSelected = null;
                    } else {
                        console.log('falla en la actualización del lote del medio de cultivo ' + lote.id);
                        console.error(response);
                    }
                });
            }

            return interfaz;
        });

