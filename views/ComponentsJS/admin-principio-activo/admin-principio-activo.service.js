'use strict'

angular.module('CompAdminPrincipioActivo')

        .factory('adminPrincipioActivoService', function (principioActivoService, estandarService) {
            var interfaz = {
                consultarPrincipiosActivos: consultarPrincipiosActivos,
                editarPrincipioActivo: editarPrincipioActivo,
                confirmarCambiosPrincipioActivo: confirmarCambiosPrincipioActivo,
                descartarCambiosPrincipioActivo: descartarCambiosPrincipioActivo,
                eliminarPrincipioActivo: eliminarPrincipioActivo,
                openModalNewPrincipioActivo: openModalNewPrincipioActivo,
                closeModalNewPrincipioActivo: closeModalNewPrincipioActivo,
                confirmNewPrincipioActivoModal: confirmNewPrincipioActivoModal,
                principioActivoGridRowSelected: principioActivoGridRowSelected
            }

            function consultarPrincipiosActivos(vm) {
                vm.waitModalText = 'Cargando datos de principios activos, un momento por favor ...';
                $('#waitModal').modal('show');
                principioActivoService.getAllPrincipioActivo().then(function (response) {
                    if (response.data.code == "00000") {
                        consultarEnsayos(vm);
                        console.log('Carga de principios activos OK');
                        vm.principiosActivos = response.data.data;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de principios activos');
                        console.error(response);
                    }
                });
            }

            function consultarEnsayos(vm) {
                estandarService.getAllActiveEstandares().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.estandares = response.data.data;
                    } else {
                        console.log('falla en la consulta de estándares');
                        console.error(response);
                    }
                });
            }

            function editarPrincipioActivo(vm, principioActivo) {
                principioActivo.backup = angular.copy(principioActivo);
                principioActivo.edit = true;
            }

            function confirmarCambiosPrincipioActivo(vm, principioActivo) {
                vm.waitModalText = 'Actualizando principio activo, un momento por favor ...';
                $('#waitModal').modal('show');
                principioActivoService.updatePrincipioActivo(principioActivo).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización del principio activo ' + principioActivo.id + 'OK');
                        principioActivo.backup = null;
                        $('#waitModal').modal('hide');
                        principioActivo.edit = false;
                        vm.principioActivoSelected = null;
                        vm.isSelectedPrincipioActivo = false;
                    } else {
                        console.log('falla en la actualización del principio activo ' + principioActivo.id);
                        console.error(response);
                        descartarCambiosPrincipioActivo(vm, principioActivo);
                    }
                });
            }

            function descartarCambiosPrincipioActivo(vm, principioActivo) {
                principioActivo.edit = false;
                principioActivo.codigo = principioActivo.backup.codigo;
                principioActivo.nombre = principioActivo.backup.nombre;
                principioActivo.tipo = principioActivo.backup.tipo;
                principioActivo.backup = null;
            }

            function eliminarPrincipioActivo(vm, principioActivo, index) {
                vm.waitModalText = 'Eliminando Reactivo, un momento por favor ...';
                $('#waitModal').modal('show');
                principioActivoService.deletePrincipioActivo(principioActivo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el principio activo ' + principioActivo.id);
                        vm.principiosActivos.splice(index, 1);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la eliminación del principio activo');
                        console.error(response);
                    }
                    vm.isSelectedReactivo = false;
                });
            }

            function openModalNewPrincipioActivo(vm) {
                vm.newPrincipioActivo.valor_tr = 0;
                vm.newPrincipioActivo.valor_stop_time = 0;
                vm.newPrincipioActivo.valor_sol_fase = 0;
                vm.newPrincipioActivo.por_sol_fase = 0;
                vm.newPrincipioActivo.valor_sol_disolucion = 0;
                vm.newPrincipioActivo.por_sol_disolucion = 0;
                vm.newPrincipioActivo.valor_flujo = 0;
                vm.newPrincipioActivo.cantidad_muestra = 0;
                vm.newPrincipioActivo.cantidad_x_estandar = 0;
                vm.newPrincipioActivo.cantidad_estandar = 0;
                $('#newPrincipioActivoModal').modal('show');
            }

            function closeModalNewPrincipioActivo(vm) {
                vm.newPrincipioActivo = {};
                $('#newPrincipioActivoModal').modal('hide');
            }

            function confirmNewPrincipioActivoModal(vm) {
                var newPrincipioActivoData = angular.copy(vm.newPrincipioActivo);
                closeModalNewPrincipioActivo(vm);
                vm.waitModalText = 'Creando nuevo principio activo, un momento por favor ...';
                $('#waitModal').modal('show');
                principioActivoService.insertPrincipioActivo(newPrincipioActivoData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de reactivo OK');
                        vm.isSelectedPrincipioActivo = false;
                        consultarPrincipiosActivos(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('Falla en la creación del principio activo ');
                        console.error(response);
                        $('#waitModal').modal('hide');
                    }
                });
            }

            function principioActivoGridRowSelected(vm, principioActivo, index) {
                vm.isSelectedPrincipioActivo = true;
                if (vm.principioActivoSelected != principioActivo) {
                    selectPrincipioActivo(vm, principioActivo, index);
                }
            }

            function selectPrincipioActivo(vm, principioActivo, index) {
                vm.principioActivoSelected = principioActivo;
                vm.indexPrincipioActivoSelected = index;
                angular.forEach(vm.principiosActivos, function (value, key) {
                    value.id == principioActivo.id ? value.selected = true : value.selected = false;
                });
            }


            return interfaz;
        });



