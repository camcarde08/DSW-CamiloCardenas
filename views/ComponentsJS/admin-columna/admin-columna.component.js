'use strict';

angular.module('CompAdminColumna', [])



        .controller('compAdminColumnaCtrl', function (adminColumnaService, columnaService, utileService) {
            var vm = this;
            vm.$onInit = function () {

                vm.dropDownPrincipiosActivosSettings = {
                    disabled: false,
                    checkboxes: true,
                    width: '270px',
                    height: '25px'
                };

                vm.dropDownNewPrincipiosActivosSettings = {
                    disabled: false,
                    checkboxes: true,
                    width: '270px',
                    height: '25px'
                };
            };
            vm.$postLink = function () {
                adminColumnaService.getAllActiveColumnas(vm);
                adminColumnaService.getPrincipiosActivos(vm);

                vm.openModalEditColumna = function (columnaSelected) {
                    adminColumnaService.openModalEditColumna(vm, columnaSelected);
                };
                vm.closeModalEditColumna = function () {
                    $('#editColumnaSelectedModal').modal('hide');
                    vm.dropDownPrincipiosActivosSettings.apply('uncheckAll');
                    vm.columnaSelected = null;
                };
                vm.confirmEditColumnaModal = function () {
                    adminColumnaService.editarColumna(vm);
                };

                vm.eliminarColumna = function (columna, index) {
                    adminColumnaService.eliminarColumna(vm, columna, index);
                };

                vm.openModalNewColumna = function () {
                    adminColumnaService.openModalNewColumna(vm);
                };

                vm.closeModalNewColumna = function () {
                    $('#newColumnaModal').modal('hide');
                    vm.dropDownNewPrincipiosActivosSettings.apply('uncheckAll');
                    $("#newFechaInicio").jqxDateTimeInput({value: null});
                    vm.newColumna = null;
                };

                vm.confirmNewColumnaModal = function () {
                    adminColumnaService.insertarColumna(vm);
                };

                vm.administrarAdjuntos = function (itemSelected) {
                    vm.columnaSelected = itemSelected;
                    
                    console.log(itemSelected);
                    columnaService.scanDirByIdColumna(itemSelected.marca, itemSelected.id).then(function (response) {
                        if (response.data !== null) {
                            var data = angular.toJson(response.data);
                            vm.loadTreeAdjuntos(data);
                            $('#modalAdjuntos').modal('show');
                        }
                    });
                };


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
                    $('#treeDocsColumna').jqxTree({source: records, height: '200px'});
                    $('#treeDocsColumna').jqxTree("expandAll");
                    $("#treeDocsColumna li").on('dblclick', function (event) {
                        var target = $(event.target).parents('li:first')[0];
                        if (target != null) {
                            $("#treeDocsColumna").jqxTree('selectItem', target);
                            var selectedItemA = $('#treeDocsColumna').jqxTree('selectedItem');
                            if (selectedItemA.icon == "views/images/file_icon.png") {
                                window.open(selectedItemA.id, '_blank');
                            }
                            return false;
                        }
                    });
                };

                vm.loadFileUploadDocsColumna =
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
                    var selectedItem = $('#treeDocsColumna').jqxTree('selectedItem');
                    $('#fileUploadDocsColumna').jqxFileUpload({uploadUrl: 'index.php?action=uploadFile&location=' + selectedItem.id});

                }

                vm.onUploadEnd = function () {
                    vm.administrarAdjuntos(vm.columnaSelected);
                }

                vm.eliminarArchivo = function () {
                    var item = $('#treeDocsColumna').jqxTree('getSelectedItem');
                    if (item !== null) {

                        var item = $('#treeDocsColumna').jqxTree('getSelectedItem');
                        var location = item.value;
                        utileService.eliminarArchivo(location).then(function (response) {
                            if (response.data.result === '0') {
                                vm.administrarAdjuntos(vm.columnaSelected);
                            } else {
                                console.log("Error eliminando archivo");
                            }
                        });
                    }
                }
            };
        })



        .component('sgmAdminColumna', {
            templateUrl: './views/ComponentsJS/admin-columna/admin-columna.html',
            controller: 'compAdminColumnaCtrl',
            controllerAs: 'vm'
        });






