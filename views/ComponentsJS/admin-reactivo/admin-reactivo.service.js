'use strict'

angular.module('CompAdminReactivo')

        .factory('adminReactivoService', function (reactivoService, loteReactivoService) {
            var interfaz = {
                getAllActiveReactivos: getAllActiveReactivos,
                eventClickEditarReactivo: eventClickEditarReactivo,
                eliminarReactivo: eliminarReactivo,
                reactivoGridRowSelected: reactivoGridRowSelected,
                openModalNewReactivo: openModalNewReactivo,
                closeModalNewReactivo: closeModalNewReactivo,
                confirmNewReactivoModal: confirmNewReactivoModal,
                confirmarCambiosReactivo: confirmarCambiosReactivo,
                clickTdGrillaLoteReactivo: clickTdGrillaLoteReactivo,
                clickConfirmActivateLote: clickConfirmActivateLote,
                activarLote: activarLote,
                editarLote: editarLote,
                openModalNewLote: openModalNewLote,
                openModalEliminarReactivo: openModalEliminarReactivo,
                closeModalNewLoteReactivo: closeModalNewLoteReactivo,
                confirmNewLoteReactivoModal: confirmNewLoteReactivoModal,
                desactivarLote: desactivarLote,
                reactivoNotGridRow: reactivoNotGridRow,
                mostrarAlerta: mostrarAlerta,
                loteReactivoNotGridRow: loteReactivoNotGridRow,
                closeModalEditarReactivo: closeModalEditarReactivo,
                generarSticker: generarSticker,
                clickGenerarStickers: clickGenerarStickers,
                scrollToTop: scrollToTop
            }

            function getAllActiveReactivos(vm) {
                vm.waitModalText = 'Cargando datos de reactivos, un momento por favor ...';
                $('#waitModal').modal('show');
                reactivoService.getAllActiveReactivo().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Carga de ensayos OK');
                        vm.reactivos = response.data.data;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de reactivos');
                        console.error(response);
                    }
                });
            }


            function eventClickEditarReactivo(vm, reactivo) {
                vm.reactivoSelected = angular.copy(reactivo);
                $('#editarReactivoModal').modal('show');
            }

            function mostrarAlerta(vm, numAlerta, mensaje) {
                vm.mensajeAlerta = mensaje;
                var alert = $('#alert-' + numAlerta);
                alert.appendTo('.page-alerts');
                alert.slideDown();
                $('#alert-' + numAlerta).delay(3000).fadeOut("slow");
            }

            function openModalEliminarReactivo(vm, reactivo, index) {
                vm.idReactivoEliminacion = reactivo.id;
                vm.indexReactivoEliminacion = index;
                $('#modalRazonEliminacionReactivo').modal('show');
            }

            function eliminarReactivo(vm) {
                $('#modalRazonEliminacionReactivo').modal('hide');
                vm.waitModalText = 'Eliminando Reactivo, un momento por favor ...';
                $('#waitModal').modal('show');
                reactivoService.deleteReactivo(vm.idReactivoEliminacion, vm.razonEliminacion).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el reactivo ' + vm.idReactivoEliminacion);
                        vm.reactivos.splice(vm.indexReactivoEliminacion, 1);
                        vm.razonEliminacion = null;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la eliminación del reactivo');
                        console.error(response);
                    }
                    vm.isSelectedReactivo = false;
                });
            }

            function confirmNewReactivoModal(vm) {
                var newReactivoData = angular.copy(vm.newReactivo);
                closeModalNewReactivo(vm);
                vm.waitModalText = 'Creando nuevo reactivo un momento por favor ...';
                $('#waitModal').modal('show');
                reactivoService.insertReactivo(newReactivoData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de reactivo OK');
                        vm.isSelectedReactivo = false;
                        getAllActiveReactivos(vm);

                        mostrarAlerta(vm, 1, "Registro creado satisfactoriamente");
                    } else {
                        $('#waitModal').modal('hide');
                        if (response.data.data.errorDb[1] == 1062) {
                            mostrarAlerta(vm, 2, "Error, Código de reactivo ya existente");
                        } else {
                            console.log('Falla en la creación del reactivo ');
                            console.error(response);
                            mostrarAlerta(vm, 2, "Error creando registro");
                        }
                    }
                });
            }

            function reactivoGridRowSelected(vm, reactivo) {
                vm.isSelectedReactivo = true;
                vm.loteSelected = null;
                selectReactivo(vm, reactivo);

            }

            function reactivoNotGridRow(vm, reactivo) {
                angular.forEach(vm.reactivos, function (value, key) {
                    value.selected = false;
                });
                vm.isSelectedReactivo = false;
            }

            function loteReactivoNotGridRow(vm) {
                angular.forEach(vm.lotesReactivo, function (value, key) {
                    value.selected = false;
                });
            }

            function selectReactivo(vm, reactivo) {
                vm.reactivoSelected = reactivo;
                angular.forEach(vm.reactivos, function (value, key) {
                    value.id == reactivo.id ? value.selected = true : value.selected = false;
                });
                getLotesReactivoByReactivo(vm, reactivo);
            }

            function getLotesReactivoByReactivo(vm, reactivo) {
                vm.waitModalText = 'Consultando lotes asociados al reactivo, un momento por favor ...';
                angular.element(waitModal).modal('show');
                loteReactivoService.getLotesByIdReactivo(reactivo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        angular.forEach(response.data.data, function (value, key) {
                            formatLote(value);
                        });
                        vm.lotesReactivo = response.data.data;
                        console.log('Consulta lotes del reactivo OK');

                    } else {
                        console.log('Falla en la consulta de lotes del reactivo');
                        console.error(response);
                    }
                    angular.element(waitModal).modal('hide');
                });

            }

            function formatLote(lote) {
                if (lote.fecha_recibido) {
                    lote.fecha_recibido = formatDateString(lote.fecha_recibido);
                } else {
                    lote.fecha_recibido = null;
                }

                if (lote.fecha_apertura) {
                    lote.fecha_apertura = formatDateString(lote.fecha_apertura);
                } else {
                    lote.fecha_apertura = null;
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

            function openModalNewReactivo(vm) {
                $('#newReactivoModal').modal('show');
            }

            function closeModalNewReactivo(vm) {
                vm.newReactivo = null;
                $('#newReactivoModal').modal('hide');
            }


            function confirmarCambiosReactivo(vm) {
                $('#editarReactivoModal').modal('hide');
                vm.waitModalText = 'Editando reactivo, un momento por favor ...';
                angular.element(waitModal).modal('show');
                reactivoService.updateReactivo(vm.reactivoSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de reactivo ' + vm.reactivoSelected.id + 'OK');
                        getAllActiveReactivos(vm);
                    } else {
                        if (response.data.data.errorDb[1] == 1062) {
                            mostrarAlerta(vm, 2, "Error, Código de reactivo ya existente");
                        } else {
                            console.log('falla en la actualización del reactivo ' + vm.reactivoSelected.id);
                            console.error(response);
                            mostrarAlerta(vm, 2, "Error actualizando reactivo");
                        }
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function closeModalEditarReactivo(vm) {
                vm.reactivoSelected = null;
                $('#editarReactivoModal').modal('hide');
            }

            function clickTdGrillaLoteReactivo(vm, index, lote) {
                vm.loteSelected = lote;
                angular.forEach(vm.lotesReactivo, function (value, key) {
                    key == index ? value.selected = true : value.selected = false;
                });
            }

            function clickConfirmActivateLote(vm) {
                $('#modalCofirmmActivarLote').modal('hide');
                vm.waitModalText = 'Activando lote un momento por favor ...';
                angular.element(waitModal).modal('show');
                loteReactivoService.activarLoteReactivo(vm.loteSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Activacion lote OK');
                        vm.reactivoSelected.lote = vm.loteSelected.numero;
                        vm.reactivoSelected.fecha_vencimiento = vm.loteSelected.fecha_vencimiento;
                    } else {
                        console.log('fallo en la activacion de lote');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                    vm.loteSelected = null;
                    selectReactivo(vm, vm.reactivoSelected, vm.indexReactivoSelected);
                });
            }

            function activarLote(vm) {
                angular.element(modalCofirmmActivarLote).modal('show');
            }

            function desactivarLote(vm, loteReactivo) {
                vm.waitModalText = 'Desactivando lote un momento por favor ...';
                angular.element(waitModal).modal('show');
                vm.loteSelected = loteReactivo;
                loteReactivoService.desactivarLoteReactivo(vm.loteSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Desactivacion lote OK');
                        vm.reactivoSelected.lote = null;
                        vm.reactivoSelected.fecha_vencimiento = null;
                    } else {
                        console.log('fallo en la activacion de lote');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                    vm.loteSelected = null;
                    selectReactivo(vm, vm.reactivoSelected, vm.indexReactivoSelected);
                });
            }

            function editarLote(vm, lote) {
                loteReactivoService.updateLoteReactivo(lote).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de reactivo ' + lote.id + 'OK');
                        //$('#waitModal').modal('hide');
                        if (vm.loteSelected.activo == 1) {
                            vm.reactivoSelected.lote = vm.loteSelected.numero;
                            vm.reactivoSelected.fecha_vencimiento = vm.loteSelected.fecha_vencimiento;
                        }
                        mostrarAlerta(vm, 1, "Registro actualizado satisfactoriamente");
                        vm.loteSelected = null;
                        scrollToTop();
                    } else {
                        console.log('falla en la actualización del lote del reactivo ' + lote.id);
                        console.error(response);
                        mostrarAlerta(vm, 2, "Error actualizando lote");
                    }
                });
            }

            function openModalNewLote(vm) {
                $('#newLoteReactivoModal').modal('show');
            }

            function closeModalNewLoteReactivo(vm) {
                vm.newLoteReactivo = null;
                $('#newLoteReactivoModal').modal('hide');
                $(".jqxWidgetDate").jqxDateTimeInput('setDate', null);
            }

            function confirmNewLoteReactivoModal(vm) {
                var newLoteReactivoData = angular.copy(vm.newLoteReactivo);
                var idReactivoLote = vm.reactivoSelected.id;
                closeModalNewLoteReactivo(vm);
                vm.waitModalText = 'Creando nuevo lote asociado a reactivo, un momento por favor ...';
                $('#waitModal').modal('show');
                loteReactivoService.createNewLoteReactivo(newLoteReactivoData, idReactivoLote).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Creacion de lote asociado a reactivo OK');
                        getLotesReactivoByReactivo(vm, vm.reactivoSelected);

                        mostrarAlerta(vm, 1, "Registro creado satisfactoriamente");
                    } else {
                        console.log('Falla en la creación del reactivo ');
                        console.error(response);
                        $('#waitModal').modal('hide');
                        mostrarAlerta(vm, 2, "Error creando lote del reactivo");
                    }
                });
            }

            function scrollToTop() {
                var element = $('body');
                var offset = element.offset();
                var offsetTop = offset.top;
                $('body').animate({scrollTop: offsetTop}, 500, 'linear');
            }

            function generarSticker(vm, lote) {
                vm.loteSelected = lote;
                $('#modalCantidadStickers').modal('show');
            }

            function clickGenerarStickers(vm) {
                $('#modalCantidadStickers').modal('hide');
                $("#idLote").val(vm.loteSelected.id);
                $("#cantidadSticker").val(vm.cantidad_stickers);
                window.open('', 'formStickersReactivo');
                $("#formStickersReactivo").submit();
            }

            return interfaz;
        });



