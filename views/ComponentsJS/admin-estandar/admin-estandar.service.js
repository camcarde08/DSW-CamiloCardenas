'use strict'

angular.module('CompAdminEstandar')

        .factory('adminEstandarService', function (estandarService, loteEstandarService) {
            var interfaz = {
                getAllActiveEstandares: getAllActiveEstandares,
                openModalEliminarEstandar: openModalEliminarEstandar,
                eliminarEstandar: eliminarEstandar,
                rowSelectedEstandar: rowSelectedEstandar,
                editarEstandar: editarEstandar,
                openModalNewEstandar: openModalNewEstandar,
                closeModalNewEstandar: closeModalNewEstandar,
                confirmNewEstandarModal: confirmNewEstandarModal,
                clickTdGrillaLoteEstandar: clickTdGrillaLoteEstandar,
                activarLote: activarLote,
                clickConfirmActivateLote: clickConfirmActivateLote,
                openModalNewLote: openModalNewLote,
                closeModalNewLoteEstandar: closeModalNewLoteEstandar,
                confirmNewLoteEstandarModal: confirmNewLoteEstandarModal,
                editarLote: editarLote,
                confirmarCambiosEstandar: confirmarCambiosEstandar,
                desactivarLote: desactivarLote,
                estandarNotGridRow: estandarNotGridRow,
                loteEstandarNotGridRow: loteEstandarNotGridRow,
                closeModalEditarEstandar: closeModalEditarEstandar,
                eventClickEditarEstandar: eventClickEditarEstandar,
                mostrarAlerta: mostrarAlerta,
                scrollToTop: scrollToTop
            }

            function getAllActiveEstandares(vm) {
                vm.waitModalText = 'Cargando datos de estándares, un momento por favor ...';
                $('#waitModal').modal('show');
                estandarService.getAllActiveEstandares().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Carga de estándar OK');
                        vm.estandares = response.data.data;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de estandares');
                        console.error(response);
                    }
                });
            }

            function openModalEliminarEstandar(vm, estandar, index) {
                vm.idEstandarEliminacion = estandar.id;
                vm.indexEstandarEliminacion = index;
                $('#modalRazonEliminacionEstandar').modal('show');
            }

            function eliminarEstandar(vm) {
                $('#modalRazonEliminacionEstandar').modal('hide');
                vm.waitModalText = 'Eliminando registro, un momento por favor ...';
                $('#waitModal').modal('show');
                estandarService.deleteEstandar(vm.idEstandarEliminacion, vm.razonEliminacion).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el estandar ' + vm.idEstandarEliminacion);
                        vm.estandares.splice(vm.indexEstandarEliminacion, 1);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('Falla en la eliminación del estándar');
                        console.error(response);
                    }
                    vm.isSelected = false;
                })
            }

            function rowSelectedEstandar(vm, estandar, index) {
                vm.isSelectedEstandar = true;
                vm.loteSelected = null;
                selectEstandar(vm, estandar, index);
            }

            function selectEstandar(vm, estandar, index) {
                vm.estandarSelected = estandar;
                vm.indexEstandarSelected = index;
                angular.forEach(vm.estandares, function (value, key) {
                    key == index ? value.selected = true : value.selected = false;
                });
                getLotesEstandarByEstandar(vm, estandar);
            }

            function getLotesEstandarByEstandar(vm, estandar) {
                vm.waitModalText = 'Consultando lotes asociados al estandar, un momento por favor ...';
                angular.element(waitModal).modal('show');
                loteEstandarService.getLotesByIdEstandar(estandar.id).then(function (response) {
                    if (response.data.code == "00000") {
                        angular.forEach(response.data.data, function (value, key) {
                            formatLote(value);
                        });
                        vm.lotesEstandar = response.data.data;
                        console.log('Consulta lotes del estandar OK');

                    } else {
                        console.log('Falla en la consulta de lotes del estándar');
                        console.error(response);
                    }
                    angular.element(waitModal).modal('hide');
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

            function mostrarAlerta(vm, numAlerta, mensaje) {
                vm.mensajeAlerta = mensaje;
                var alert = $('#alert-' + numAlerta);
                alert.appendTo('.page-alerts');
                alert.slideDown();
                $('#alert-' + numAlerta).delay(3000).fadeOut("slow");
            }

            function openModalNewEstandar(vm) {
                $('#newEstandarModal').modal('show');
            }

            function closeModalNewEstandar(vm) {
                vm.newEstandar = null;
                $('#newEstandarModal').modal('hide');
            }

            function confirmNewEstandarModal(vm) {
                var newEstandarData = angular.copy(vm.newEstandar);
                closeModalNewEstandar(vm);
                vm.waitModalText = 'Creando nuevo estándar un momento por favor ...';
                $('#waitModal').modal('show');
                estandarService.insertEstandar(newEstandarData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de estándar OK');
                        vm.isSelected = false;
                        getAllActiveEstandares(vm);

                        mostrarAlerta(vm, 1, "Registro creado satisfactoriamente");
                    } else {
                        $('#waitModal').modal('hide');
                        if (response.data.data.errorDb[1] == 1062) {
                            mostrarAlerta(vm, 2, "Error, Código de estándar ya existente");
                        } else {
                            console.log('Falla en la creación del estándar ');
                            console.error(response);
                            mostrarAlerta(vm, 2, "Error creando estándar");
                        }
                    }
                });
            }

            function clickTdGrillaLoteEstandar(vm, index, lote) {
                vm.loteSelected = lote;
                angular.forEach(vm.lotesEstandar, function (value, key) {
                    key == index ? value.selected = true : value.selected = false;
                });
            }

            function activarLote(vm) {
                angular.element(modalCofirmmActivarLote).modal('show');
            }

            function clickConfirmActivateLote(vm) {
                $('#modalCofirmmActivarLote').modal('hide');
                vm.waitModalText = 'Activando lote un momento por favor ...';
                angular.element(waitModal).modal('show');
                loteEstandarService.activarLoteEstandar(vm.loteSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Activacion lote OK');
                        vm.estandarSelected.lote = vm.loteSelected.codigo;
                        vm.estandarSelected.fecha_vencimiento = vm.loteSelected.fecha_vencimiento;
                        vm.estandarSelected.potencia = vm.loteSelected.descripcion;
                    } else {
                        console.log('fallo en la activacion de lote');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                    vm.loteSelected = null;
                    selectEstandar(vm, vm.estandarSelected, vm.indexEstandarSelected);
                });
            }

            function openModalNewLote(vm) {
                $('#newLoteEstandarModal').modal('show');
            }

            function closeModalNewLoteEstandar(vm) {
                vm.newLoteEstandar = null;
                $('#newLoteEstandarModal').modal('hide');
                $(".jqxWidgetDate").jqxDateTimeInput('setDate', null);
            }

            function confirmNewLoteEstandarModal(vm) {
                var newLoteEstandarData = angular.copy(vm.newLoteEstandar);
                var idEstandarLote = vm.estandarSelected.id;
                closeModalNewLoteEstandar(vm);
                vm.waitModalText = 'Creando nuevo lote asociado a estándar, un momento por favor ...';
                $('#waitModal').modal('show');
                loteEstandarService.createNewLoteEstandar(newLoteEstandarData, idEstandarLote).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Creacion de lote asociado a estandar OK');
                        getLotesEstandarByEstandar(vm, vm.estandarSelected);

                        mostrarAlerta(vm, 1, "Lote creado satisfactoriamente");
                    } else {
                        $('#waitModal').modal('hide');
                        scrollToTop();
                        if (response.data.data.errorDb[1] == 1062) {
                            mostrarAlerta(vm, 2, "Error, Consecutivo de lote ya existente");
                        } else {
                            console.log('Falla en la creación del lote del estandar ');
                            console.error(response);
                            mostrarAlerta(vm, 2, "Error creando registro");
                        }
                    }
                });
            }

            function editarLote(vm, lote) {
                loteEstandarService.updateLoteEstandar(lote).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de estandar ' + lote.id + 'OK');
                        //$('#waitModal').modal('hide');
                        mostrarAlerta(vm, 1, "Lote actualizado satisfactoriamente");
                        if (vm.loteSelected.activo == 1) {
                            vm.estandarSelected.lote = vm.loteSelected.codigo;
                            vm.estandarSelected.fecha_vencimiento = vm.loteSelected.fecha_vencimiento;
                            vm.estandarSelected.potencia = vm.loteSelected.descripcion;
                        }
                        vm.loteSelected = null;
                        scrollToTop();
                    } else {
                        scrollToTop();
                        if (response.data.data.errorDb[1] == 1062) {
                            mostrarAlerta(vm, 2, "Error, Consecutivo de lote ya existente");
                        } else {
                            console.log('Falla en la actualización del lote del estandar ');
                            console.error(response);
                            mostrarAlerta(vm, 2, "Error actualizando lote");
                        }


                    }
                });
            }



            function confirmarCambiosEstandar(vm) {
                $('#editarEstandarModal').modal('hide');
                vm.waitModalText = 'Editando estándar, un momento por favor ...';
                $('#waitModal').modal('show');
                estandarService.updateEstandar(vm.estandarSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de estandar ' + vm.estandarSelected.id + ' OK');
                        getAllActiveEstandares(vm);
                    } else {

                        if (response.data.data.errorDb[1] == 1062) {
                            mostrarAlerta(vm, 2, "Error, Consecutivo de estándar ya existente");
                        } else {
                            console.log('falla en la actualización del estandar ' + vm.estandarSelected.id);
                            console.error(response);
                            mostrarAlerta(vm, 2, "Error actualizando estándar");
                        }
                    }
                });
            }

            function eventClickEditarEstandar(vm, estandar) {
                vm.estandarSelected = angular.copy(estandar);
                $('#editarEstandarModal').modal('show');
            }

            function closeModalEditarEstandar(vm) {
                vm.estandarSelected = null;
                $('#editarEstandarModal').modal('hide');
            }

            function editarEstandar(vm, estandar) {
                /*estandar.backup = angular.copy(estandar);
                 estandar.edit = true;*/
            }

            function scrollToTop() {
                var element = $('body');
                var offset = element.offset();
                var offsetTop = offset.top;
                $('body').animate({scrollTop: offsetTop}, 500, 'linear');
            }

            function desactivarLote(vm, loteEstandar) {
                vm.waitModalText = 'Desactivando lote un momento por favor ...';
                angular.element(waitModal).modal('show');
                vm.loteSelected = loteEstandar;
                loteEstandarService.desactivarLoteEstandar(vm.loteSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Desactivacion lote OK');
                        vm.estandarSelected.lote = null;
                        vm.estandarSelected.fecha_vencimiento = null;
                        vm.estandarSelected.potencia = null;
                    } else {
                        console.log('fallo en la desactivacion de lote');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                    vm.loteSelected = null;
                    selectEstandar(vm, vm.estandarSelected, vm.indexEstandarSelected);
                });
            }

            function estandarNotGridRow(vm, reactivo) {
                angular.forEach(vm.estandares, function (value, key) {
                    value.selected = false;
                });
                vm.isSelectedEstandar = false;
            }

            function loteEstandarNotGridRow(vm) {
                angular.forEach(vm.lotesEstandar, function (value, key) {
                    value.selected = false;
                });
            }

            return interfaz;
        });



