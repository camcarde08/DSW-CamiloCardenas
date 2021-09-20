'use strict'

angular.module('CompAdminCondicionCromatografica')

        .factory('adminCondicionCromatograficaService', function (condicionCromatograficaService) {
            var interfaz = {
                consultarCondicionesCromatograficas: consultarCondicionesCromatograficas,
                condicionCromatograficaGridRowSelected: condicionCromatograficaGridRowSelected,
                confirmarCambiosCondicionCromatografica: confirmarCambiosCondicionCromatografica,
                openModalNewCondicionCromatografica: openModalNewCondicionCromatografica,
                confirmNewCondicionCromatograficaModal: confirmNewCondicionCromatograficaModal,
                closeModalNewCondicionCromatografica: closeModalNewCondicionCromatografica,
                eliminarCondicionCromatografica: eliminarCondicionCromatografica
            }

            function consultarCondicionesCromatograficas(vm) {
                vm.waitModalText = 'Cargando datos de condiciones cromatograficas, un momento por favor ...';
                $('#waitModal').modal('show');
                condicionCromatograficaService.getAllCondicionCromatografica().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Carga de condiciones cromatograficas OK');
                        vm.condicionesCromatograficas = response.data.data;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de condiciones cromatograficas');
                        console.error(response);
                    }
                });
            }

            function condicionCromatograficaGridRowSelected(vm, condicionCromatografica, index) {
                vm.isSelectedCondicionCromatografica = true;
                if (vm.condicionCromatograficaSelected != condicionCromatografica) {
                    selectCondicionCromatografica(vm, condicionCromatografica, index);
                }
            }

            function selectCondicionCromatografica(vm, condicionCromatografica, index) {
                vm.condicionCromatograficaSelected = condicionCromatografica;
                vm.indexCondicionCromatograficaSelected = index;
                angular.forEach(vm.condicionesCromatograficas, function (value, key) {
                    value.id == condicionCromatografica.id ? value.selected = true : value.selected = false;
                });
            }

            function confirmarCambiosCondicionCromatografica(vm, condicionCromatografica) {
                vm.waitModalText = 'Actualizando condicion Cromatografica, un momento por favor ...';
                $('#waitModal').modal('show');
                condicionCromatograficaService.updateCondicionCromatografica(condicionCromatografica).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización del condicion Cromatografica ' + condicionCromatografica.id + 'OK');
                        condicionCromatografica.backup = null;
                        $('#waitModal').modal('hide');
                        vm.condicionCromatograficaSelected = null;
                        vm.isSelectedCondicionCromatografica = false;
                    } else {
                        console.log('falla en la actualización del condicion Cromatografica ' + condicionCromatografica.id);
                        console.error(response);
                        descartarCambiosCondicionCromatografica(vm, condicionCromatografica);
                    }
                });
            }

            function descartarCambiosCondicionCromatografica(vm, condicionCromatografica) {
                condicionCromatografica.nombre = condicionCromatografica.backup.nombre;
                condicionCromatografica.codigo = condicionCromatografica.backup.codigo;
                condicionCromatografica.backup = null;
            }

            function openModalNewCondicionCromatografica(vm) {
                $('#newCondicionCromatograficaModal').modal('show');
            }

            function confirmNewCondicionCromatograficaModal(vm) {
                var newCondicionCromatograficaData = angular.copy(vm.newCondicionCromatografica);
                closeModalNewCondicionCromatografica(vm);
                vm.waitModalText = 'Creando nuevo condicion Cromatografica, un momento por favor ...';
                $('#waitModal').modal('show');
                condicionCromatograficaService.insertCondicionCromatografica(newCondicionCromatograficaData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de reactivo OK');
                        vm.isSelectedCondicionCromatografica = false;
                        consultarCondicionesCromatograficas(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('Falla en la creación del condicion Cromatografica ');
                        console.error(response);
                        $('#waitModal').modal('hide');
                    }
                });
            }

            function closeModalNewCondicionCromatografica(vm) {
                vm.newCondicionCromatografica = {};
                $('#newCondicionCromatograficaModal').modal('hide');
            }

            function eliminarCondicionCromatografica(vm, condicionCromatografica, index) {
                vm.waitModalText = 'Eliminando condición, un momento por favor ...';
                $('#waitModal').modal('show');
                condicionCromatograficaService.deleteCondicionCromatografica(condicionCromatografica.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el condicion Cromatografica ' + condicionCromatografica.id);
                        vm.condicionesCromatograficas.splice(index, 1);
                        vm.condicionCromatograficaSelected = null;
                        vm.isSelectedCondicionCromatografica = false;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la eliminación del condicion Cromatografica');
                        console.error(response);
                    }
                });
            }



            return interfaz;
        });



