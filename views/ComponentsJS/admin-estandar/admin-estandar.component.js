'use strict';

angular.module('CompAdminEstandar', [])



        .controller('compAdminEstandarCtrl', function (adminEstandarService, utileService, loteEstandarService, estandarService) {
            var vm = this;

            utileService.getSessionUserData().then(response => {
                vm.sesionUserData = response.data.data;
            });

            vm.$onInit = function () {
                $('.page-alert').hide();
                vm.newEstandar = null;

                vm.tipos = ['Primario', 'Secundario', 'Referencia'];
            };


            vm.$postLink = function () {
                adminEstandarService.getAllActiveEstandares(vm);

                vm.openModalEliminarEstandar = function (estandar, index) {
                    adminEstandarService.openModalEliminarEstandar(vm, estandar, index);
                }

                vm.eliminarEstandar = function () {
                    adminEstandarService.eliminarEstandar(vm);
                }

                vm.rowSelectedEstandar = function (estandar, index) {
                    adminEstandarService.rowSelectedEstandar(vm, estandar, index);
                }

                vm.eventClickEditarEstandar = function (estandarSelected) {
                    adminEstandarService.eventClickEditarEstandar(vm, estandarSelected);
                }

                vm.closeModalEditarEstandar = function () {
                    adminEstandarService.closeModalEditarEstandar(vm);
                }

                vm.editarEstandar = function (estandarSelected) {
                    adminEstandarService.editarEstandar(vm, estandarSelected);
                }
                vm.openModalNewEstandar = function () {
                    adminEstandarService.openModalNewEstandar(vm);
                }
                vm.closeModalNewEstandar = function () {
                    adminEstandarService.closeModalNewEstandar(vm);
                }
                vm.confirmNewEstandarModal = function () {
                    adminEstandarService.confirmNewEstandarModal(vm);
                }

                vm.clickTdGrillaLoteEstandar = function (index, lote) {
                    adminEstandarService.clickTdGrillaLoteEstandar(vm, index, lote);
                }

                vm.activarLote = function () {
                    if (vm.sesionUserData.session.activarLoteEstandar === "true") {
                        adminEstandarService.activarLote(vm);
                    } else {
                        adminEstandarService.mostrarAlerta(vm, 2, "No tiene permisos para activar lote");
                        adminEstandarService.scrollToTop();
                    }
                }

                vm.desactivarLote = function (loteEstandar) {
                    if (vm.sesionUserData.session.activarLoteEstandar === "true") {
                        adminEstandarService.desactivarLote(vm, loteEstandar);
                    } else {
                        adminEstandarService.mostrarAlerta(vm, 2, "No tiene permisos para desactivar lote");
                        adminEstandarService.scrollToTop();
                    }
                }

                vm.clickConfirmActivateLote = function () {
                    adminEstandarService.clickConfirmActivateLote(vm);
                }

                vm.openModalNewLote = function () {
                    adminEstandarService.openModalNewLote();
                }

                vm.closeModalNewLoteEstandar = function () {
                    adminEstandarService.closeModalNewLoteEstandar(vm);
                }

                vm.confirmNewLoteEstandarModal = function () {
                    adminEstandarService.confirmNewLoteEstandarModal(vm);
                }

                vm.editarLote = function (lote) {
                    adminEstandarService.editarLote(vm, lote);
                }

                vm.confirmarCambiosEstandar = function () {
                    adminEstandarService.confirmarCambiosEstandar(vm);
                }

                vm.descartarCambiosEstandar = function (estandar) {
                    adminEstandarService.descartarCambiosEstandar(vm, estandar);
                }
                vm.editarEstandar = function (estandar) {
                    adminEstandarService.editarEstandar(vm, estandar);
                }


                vm.administrarAdjuntos = function (esEstandar, itemSelected) {
                    vm.esEstandar = esEstandar;
                    if (vm.esEstandar === 1) {
                        vm.administrarAdjuntosEstandar(itemSelected);
                    } else {
                        vm.administrarAdjuntosLote(itemSelected);
                    }

                    $('#modalAdjuntos').modal('show');
                }

                vm.administrarAdjuntosLote = function (loteSelected) {
                    adminEstandarService.loteEstandarNotGridRow(vm);
                    vm.loteSelected = loteSelected;
                    loteEstandarService.scanDirByIdLoteEstandar(vm.loteSelected.numero, vm.loteSelected.id, vm.loteSelected.id_estandar).then(function (response) {
                        if (response.data !== null) {
                            var data = angular.toJson(response.data);
                            vm.loadTreeAdjuntos(data);
                        }
                    });
                }

                vm.administrarAdjuntosEstandar = function (estandarSelected) {
                    vm.estandarSelected = estandarSelected;
                    adminEstandarService.estandarNotGridRow(vm);
                    estandarService.scanDirByIdEstandar(vm.estandarSelected.nombre, vm.estandarSelected.id).then(function (response) {
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
                    $('#treeDocsEstandar').jqxTree({source: records, height: '200px'});
                    $('#treeDocsEstandar').jqxTree("expandAll");
                    $("#treeDocsEstandar li").on('dblclick', function (event) {
                        var target = $(event.target).parents('li:first')[0];
                        if (target != null) {
                            $("#treeDocsEstandar").jqxTree('selectItem', target);
                            var selectedItemA = $('#treeDocsEstandar').jqxTree('selectedItem');
                            if (selectedItemA.icon == "views/images/file_icon.png") {
                                window.open(selectedItemA.id, '_blank');
                            }
                            return false;
                        }
                    });
                };

                vm.loadFileUploadDocsEstandar =
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
                    var selectedItem = $('#treeDocsEstandar').jqxTree('selectedItem');
                    $('#fileUploadDocsEstandar').jqxFileUpload({uploadUrl: 'index.php?action=uploadFile&location=' + selectedItem.id});

                }

                vm.onUploadEnd = function () {
                    if (vm.esEstandar) {
                        vm.administrarAdjuntosEstandar(vm.estandarSelected);
                    } else {
                        vm.administrarAdjuntosLote(vm.loteSelected);
                    }
                }

                vm.eliminarArchivo = function () {
                    var item = $('#treeDocsEstandar').jqxTree('getSelectedItem');
                    if (item === null) {
                        adminEstandarService.mostrarAlerta(vm, 5, "Debe seleccionar un archivo a eliminar");
                    } else {

                        var item = $('#treeDocsEstandar').jqxTree('getSelectedItem');
                        var location = item.value;
                        utileService.eliminarArchivo(location).then(function (response) {
                            if (response.data.result === '0') {
                                if (vm.esEstandar) {
                                    vm.administrarAdjuntosEstandar(vm.estandarSelected);
                                } else {
                                    vm.administrarAdjuntosLote(vm.loteSelected);
                                }
                            } else {
                                console.log("Error eliminando archivo");
                            }
                        });
                    }
                }

                vm.validarFecha = function (fecha) {
                    return utileService.validarFechaNoAplica(fecha);
                }
            };
        })



        .component('sgmAdminEstandar', {
            templateUrl: './views/ComponentsJS/admin-estandar/admin-estandar.html',
            controller: 'compAdminEstandarCtrl',
            controllerAs: 'vm'
        });






