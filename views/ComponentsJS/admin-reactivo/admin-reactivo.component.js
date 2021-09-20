'use strict';

angular.module('CompAdminReactivo', [])



        .controller('compAdminReactivoCtrl', function (adminReactivoService, utileService, loteReactivoService, reactivoService) {
            var vm = this;

            utileService.getSessionUserData().then(response => {
                vm.sesionUserData = response.data.data;
            });

            vm.$onInit = function () {
                $('.page-alert').hide();
                vm.newReactivo = null;
                vm.newLoteReactivo = null;
                vm.cantidad_stickers = 1;

                vm.grados = ['HPLC', 'Reactivo', 'Síntesis', 'Solución volumétrica', 'Solución reactivo'];
                vm.clasificaciones = ['Amarillo', 'Amarillo Rayado', 'Azul', 'Blanco', 'Blanco Rayado', 'Rojo Rayado', 'Rojo', 'Verde'];

            };


            vm.$postLink = function () {
                //Se cargan los reactivos
                adminReactivoService.getAllActiveReactivos(vm);

                vm.eventClickEditarReactivo = function (reactivo) {
                    adminReactivoService.eventClickEditarReactivo(vm, reactivo);
                }

                vm.eliminarReactivo = function () {
                    adminReactivoService.eliminarReactivo(vm);
                }

                vm.closeModalEditarReactivo = function () {
                    adminReactivoService.closeModalEditarReactivo(vm);
                }

                vm.confirmarCambiosReactivo = function () {
                    adminReactivoService.confirmarCambiosReactivo(vm);
                }

                vm.reactivoGridRowSelected = function (reactivo, index) {
                    adminReactivoService.reactivoGridRowSelected(vm, reactivo);
                }

                vm.openModalNewReactivo = function () {
                    adminReactivoService.openModalNewReactivo(vm);
                }

                vm.closeModalNewReactivo = function () {
                    adminReactivoService.closeModalNewReactivo(vm);
                }

                $('.page-alert .close').click(function (e) {
                    e.preventDefault();
                    $(this).closest('.page-alert').slideUp();
                });

                vm.confirmNewReactivoModal = function () {
                    adminReactivoService.confirmNewReactivoModal(vm);
                }

                vm.clickTdGrillaLoteReactivo = function (index, lote) {
                    adminReactivoService.clickTdGrillaLoteReactivo(vm, index, lote);
                }

                vm.activarLote = function () {
                    if (vm.sesionUserData.session.activarLoteReactivo == "true") {
                        adminReactivoService.activarLote(vm);
                    } else {
                        adminReactivoService.mostrarAlerta(vm, 2, "No tiene permisos para activar lote");
                        adminReactivoService.scrollToTop();
                    }
                }

                vm.desactivarLote = function (loteReactivo) {
                    if (vm.sesionUserData.session.activarLoteReactivo == "true") {
                        adminReactivoService.desactivarLote(vm, loteReactivo);
                    } else {
                        adminReactivoService.mostrarAlerta(vm, 2, "No tiene permisos para desactivar lote");
                        adminReactivoService.scrollToTop();
                    }
                }

                vm.clickConfirmActivateLote = function () {
                    adminReactivoService.clickConfirmActivateLote(vm);
                }

                vm.editarLote = function (lote) {
                    adminReactivoService.editarLote(vm, lote);

                }

                vm.openModalNewLote = function () {
                    adminReactivoService.openModalNewLote(vm);
                }

                vm.openModalEliminarReactivo = function (reactivo, index) {
                    adminReactivoService.openModalEliminarReactivo(vm, reactivo, index);
                }

                vm.closeModalNewLoteReactivo = function () {
                    adminReactivoService.closeModalNewLoteReactivo(vm);
                }

                vm.confirmNewLoteReactivoModal = function () {
                    adminReactivoService.confirmNewLoteReactivoModal(vm);
                }

                vm.administrarAdjuntos = function (esReactivo, itemSelected) {
                    vm.esReactivo = esReactivo;
                    if (vm.esReactivo === 1) {
                        vm.administrarAdjuntosReactivo(itemSelected);
                    } else {
                        vm.administrarAdjuntosLote(itemSelected);
                    }

                    $('#modalAdjuntos').modal('show');
                }

                vm.administrarAdjuntosLote = function (loteSelected) {
                    adminReactivoService.loteReactivoNotGridRow(vm);
                    vm.loteSelected = loteSelected;
                    loteReactivoService.scanDirByIdLoteReactivo(vm.loteSelected.numero, vm.loteSelected.id, vm.loteSelected.id_reactivo).then(function (response) {
                        if (response.data !== null) {
                            var data = angular.toJson(response.data);
                            vm.loadTreeAdjuntos(data);
                        }
                    });
                }

                vm.administrarAdjuntosReactivo = function (reactivoSelected) {
                    vm.reactivoSelected = reactivoSelected;
                    adminReactivoService.reactivoNotGridRow(vm);
                    reactivoService.scanDirByIdReactivo(vm.reactivoSelected.nombre, vm.reactivoSelected.id).then(function (response) {
                        if (response.data !== null) {
                            var data = angular.toJson(response.data);
                            vm.loadTreeAdjuntos(data);
                        }
                    });
                }

                vm.loadTreeAdjuntos = function (data) {

                    var source =
                            {
                                datatype: "json",
                                datafields: [
                                    {name: 'id'},
                                    {name: 'parentid'},
                                    {name: 'icon'},
                                    {name: 'text'},
                                    {name: 'value'}
                                ],
                                id: 'id',
                                localdata: data,
                                async: false
                            };
                    var dataAdapter = new $.jqx.dataAdapter(source);

                    dataAdapter.dataBind();

                    var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{name: 'text', map: 'label'}]);
                    $('#treeDocsReactivo').jqxTree({source: records, height: '200px'});
                    $('#treeDocsReactivo').jqxTree("expandAll");
                    $("#treeDocsReactivo li").on('dblclick', function (event) {
                        var target = $(event.target).parents('li:first')[0];
                        if (target != null) {
                            $("#treeDocsReactivo").jqxTree('selectItem', target);
                            var selectedItemA = $('#treeDocsReactivo').jqxTree('selectedItem');
                            if (selectedItemA.icon == "views/images/file_icon.png") {
                                window.open(selectedItemA.id, '_blank');
                            }
                            return false;
                        }
                    });
                };

                vm.loadFileUploadDocsReactivo =
                        {
                            fileInputName: 'fileToUpload',
                            localization: {
                                browseButton: 'Examinar',
                                uploadButton: 'Adjuntar',
                                cancelButton: 'Cancelar',
                                uploadFileTooltip: 'Datei hochladen',
                                cancelFileTooltip: 'aufheben'
                            }
                        };

                vm.onUploadStart = function (event) {
                    var selectedItem = $('#treeDocsReactivo').jqxTree('selectedItem');
                    $('#fileUploadDocsReactivo').jqxFileUpload({uploadUrl: 'index.php?action=uploadFile&location=' + selectedItem.id});

                }

                vm.onUploadEnd = function () {
                    if (vm.esReactivo) {
                        vm.administrarAdjuntosReactivo(vm.reactivoSelected);
                    } else {
                        vm.administrarAdjuntosLote(vm.loteSelected);
                    }
                }

                vm.eliminarArchivo = function () {
                    var item = $('#treeDocsReactivo').jqxTree('getSelectedItem');
                    if (item === null) {
                        adminReactivoService.mostrarAlerta(vm, 5, "Debe seleccionar un archivo a eliminar");
                    } else {

                        var item = $('#treeDocsReactivo').jqxTree('getSelectedItem');
                        var location = item.value;
                        utileService.eliminarArchivo(location).then(function (response) {
                            if (response.data.result === '0') {
                                if (vm.esReactivo) {
                                    vm.administrarAdjuntosReactivo(vm.reactivoSelected);
                                } else {
                                    vm.administrarAdjuntosLote(vm.loteSelected);
                                }
                            } else {
                                console.log("Error eliminando archivo");
                            }
                        });
                    }
                }

                vm.generarSticker = function (item) {
                    adminReactivoService.generarSticker(vm, item);
                }

                vm.clickGenerarStickers = function () {
                    adminReactivoService.clickGenerarStickers(vm);
                }

                vm.validarFecha = function (fecha) {
                    return utileService.validarFechaNoAplica(fecha);
                }
            };
        })



        .component('sgmAdminReactivo', {
            templateUrl: './views/ComponentsJS/admin-reactivo/admin-reactivo.html',
            controller: 'compAdminReactivoCtrl',
            controllerAs: 'vm'
        });






