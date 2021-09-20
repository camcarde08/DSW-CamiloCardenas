'use strict'

angular.module('CompAdminColumna')

        .factory('adminColumnaService', function ($q, columnaService, principioActivoService, $timeout) {
            var interfaz = {
                getAllActiveColumnas: getAllActiveColumnas,
                editarColumna: editarColumna,
                openModalEditColumna: openModalEditColumna,
                eliminarColumna: eliminarColumna,
                openModalNewColumna: openModalNewColumna,
                insertarColumna: insertarColumna,
                getPrincipiosActivos: getPrincipiosActivos
            }

            function getAllActiveColumnas(vm) {
                vm.waitModalText = 'Cargando datos de columnas, un momento por favor ...';
                $('#waitModal').modal('show');
                columnaService.getAllActiveColumnas().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Carga de columna OK');
                        vm.columnas = response.data.data;
                        angular.forEach(vm.columnas, function (value, key) {
                            value.fecha_inicio_uso = formatDateString(value.fecha_inicio_uso);
                        });
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de columnas');
                        console.error(response);
                    }
                });
            }

            function openModalEditColumna(vm, columnaSelected) {
                vm.columnaSelected = angular.copy(columnaSelected);
                settingsDropDownPrincipiosActivos(vm);
                getPrincipiosActivosAsociados(vm);
                $('#editColumnaSelectedModal').modal('show');

            }

            function getPrincipiosActivosAsociados(vm) {
                $timeout(function () {
                    vm.columnaSelected.principios_activos.forEach(function (item, index, array) {
                        vm.dropDownPrincipiosActivosSettings.apply('checkIndex', vm.dropDownPrincipiosActivosSettings.source.findIndex(function (item1, index1, array1) {
                            return item.id_principio_activo == item1.id;
                        }));

                    });
                }, 800);
            }

            function getPrincipiosActivos(vm) {
                principioActivoService.getAllPrincipioActivo().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Carga de columna OK');
                        vm.principiosActivos = response.data.data;
                    } else {
                        console.log('falla en la carga de principios activos disponibles');
                        console.error(response);
                    }
                });
            }

            function settingsDropDownPrincipiosActivos(vm) {
                vm.dropDownPrincipiosActivosSettings.source = vm.principiosActivos;
                vm.dropDownPrincipiosActivosSettings.displayMember = 'nombre';
                vm.dropDownPrincipiosActivosSettings.refresh(['source', 'displayMember']);
                getPrincipiosActivosAsociados(vm);
            }

            function formatDateString(dateString) {
                if (dateString !== null) {
                    var dateParts = dateString.split("-");
                    return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
                } else {
                    return null;
                }
            }

            function obtenerPrincipiosSeleccionados(vm) {
                var data = vm.dropDownPrincipiosActivosSettings.apply('getCheckedItems');
                var principios = [];
                data.forEach(function (item) {
                    principios.push(item.originalItem);
                });
                console.log(principios);
                return principios;
            }

            function editarColumna(vm) {
                vm.waitModalText = 'Actualizando columna, un momento por favor ...';
                $('#waitModal').modal('show');
                $('#editColumnaSelectedModal').modal('hide');
                vm.columnaSelected.principios_activos = obtenerPrincipiosSeleccionados(vm);

                columnaService.updateColumna(vm.columnaSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de columna OK');
                        vm.columnaSelected = null;
                        vm.dropDownPrincipiosActivosSettings.apply('uncheckAll');
                        getAllActiveColumnas(vm);
                    } else {
                        console.log('falla en la actualización del lote del columna ');
                        console.error(response);
                    }
                });
            }

            function eliminarColumna(vm, columna, index) {
                vm.waitModalText = 'Eliminando registro, un momento por favor ...';
                $('#waitModal').modal('show');
                columnaService.deleteColumna(columna.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el columna ' + columna.id);
                        vm.columnas.splice(index, 1);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('Falla en la eliminación del columna');
                        console.error(response);
                    }
                    vm.isSelected = false;
                });
            }

            function openModalNewColumna(vm) {
                settingsDropDownNewPrincipiosActivos(vm);
                $('#newColumnaModal').modal('show');
            }

            function settingsDropDownNewPrincipiosActivos(vm) {
                vm.dropDownNewPrincipiosActivosSettings.source = vm.principiosActivos;
                vm.dropDownNewPrincipiosActivosSettings.displayMember = 'nombre';
                vm.dropDownNewPrincipiosActivosSettings.refresh(['source', 'displayMember']);
            }

            function insertarColumna(vm) {
                vm.waitModalText = 'Creando columna, un momento por favor ...';
                $('#waitModal').modal('show');
                $('#newColumnaModal').modal('hide');
                vm.newColumna.principios_activos = obtenerNewPrincipiosSeleccionados(vm);

                columnaService.insertColumna(vm.newColumna).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de columna OK');
                        vm.newColumna = null;
                        vm.dropDownNewPrincipiosActivosSettings.apply('uncheckAll');
                        $("#newFechaInicio").jqxDateTimeInput({value: null});
                        getAllActiveColumnas(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la actualización del lote del columna ');
                        console.error(response);
                    }
                });
            }

            function obtenerNewPrincipiosSeleccionados(vm) {
                var data = vm.dropDownNewPrincipiosActivosSettings.apply('getCheckedItems');
                var principios = [];
                data.forEach(function (item) {
                    principios.push(item.originalItem);
                });
                console.log(principios);
                return principios;
            }


            return interfaz;
        });



