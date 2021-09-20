'use strict'

angular.module('CompAdminPaquete')

        .factory('adminPaqueteService', function ($q, $filter, paqueteService, areaAnalisisService) {
            var interfaz = {
                SelectRowPaqueteGrid: SelectRowPaqueteGrid,
                asociarEnsayos: asociarEnsayos,
                desasociarEnsayos: desasociarEnsayos,
                editarPaquete: editarPaquete,
                eliminarPaquete: eliminarPaquete,
                confirmarCambiosPaquete: confirmarCambiosPaquete,
                descartarCambiosPaquete: descartarCambiosPaquete,
                closeModalNewPaquete: closeModalNewPaquete,
                openModalNewPaquete: openModalNewPaquete,
                confirmNewPaqueteModal: confirmNewPaqueteModal,
                getAllAreas: getAllAreas,
                changeFilter: changeFilter
            }

            function SelectRowPaqueteGrid(vm, index, paquete) {
                if (vm.selectedPaquete != paquete) {
                    vm.waitModalText = 'Consultado datos del paquete seleccionado...'
                    angular.element(waitModal).modal('show');
                    vm.selectedPaquete = paquete;
                    angular.forEach(vm.paquetes, function (value, key) {
                        value.id == paquete.id ? value.selected = true : value.selected = false;
                    });
                    var promises = {
                        promiseEnsayosAsociados: getEnsayosAsociados(vm),
                        promiseEnsayosDisponibles: getEnsayosDisponiblesByIdPaquete(vm)
                    }
                    $q.all(promises).then(function () {
                        angular.element(waitModal).modal('hide');
                    });
                }
            }

            function getAllAreas(vm) {
                areaAnalisisService.getAreasActivasJoinCoordinador().then(function (response) {
                    if (response.data.code == "00000") {
                        console.debug(response);
                        console.log('Consulta plantillas OK');
                        vm.areasAnalisis = response.data.data;
                    } else {
                        console.log('falla en la consulta de plantillas');
                        console.error(response);
                    }
                });
            }

            function getEnsayosAsociados(vm) {
                return paqueteService.getEnsayosByIdPaquete(vm.selectedPaquete.id).then(function (response) {
                    if (response.data.code = "00000") {
                        vm.ensayosAsociados = response.data.data;
                        console.info('carga ensayos asociados OK');
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar ensayos asociados');
                        console.error(response);
                    }
                });
            }

            function getEnsayosDisponiblesByIdPaquete(vm) {
                return paqueteService.getEnsayosDisponiblesByIdPaquete(vm.selectedPaquete.id).then(function (response) {
                    if (response.data.code = "00000") {
                        vm.ensayosDisponibles = response.data.data;
                        console.info('carga ensayos disponibles OK');
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar ensayos disponibles');
                        console.error(response);
                    }
                });
            }


            function desasociarEnsayos(vm) {
                vm.waitModalText = 'Desasociando ensayos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.ensayosAsociados, {selected: true});
                console.info('Equipos a desasociar');
                console.debug(aux);
                paqueteService.deletePaqueteEnsayos(aux).then(function (response) {
                    if (response.data.code = "00000") {
                        console.info('Desasociacion de ensayos OK');
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            promiseEnsayosAsociados: getEnsayosAsociados(vm),
                            promiseEnsayosDisponibles: getEnsayosDisponiblesByIdPaquete(vm)
                        }
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al desasociar equipos');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function asociarEnsayos(vm) {
                vm.waitModalText = 'Asociando ensayos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.ensayosDisponibles, {selected: true});
                console.info('Ensayos a asociar');
                console.debug(aux);
                paqueteService.createPaqueteEnsayos(vm.selectedPaquete, aux).then(function (response) {
                    if (response.data.code = "00000") {
                        console.info('Asociacion de ensayos OK');
                        vm.waitModalText = 'Actualizando datos del paquete seleccionado...';
                        var promises = {
                            promiseEnsayosAsociados: getEnsayosAsociados(vm),
                            promiseEnsayosDisponibles: getEnsayosDisponiblesByIdPaquete(vm)
                        }
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al asociar ensayos');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function editarPaquete(vm, paquete) {
                paquete.backup = angular.copy(paquete);
                paquete.edit = true;
            }

            function eliminarPaquete(vm, paquete, index) {
                vm.waitModalText = 'Eliminando paquete, un momento por favor ...';
                $('#waitModal').modal('show');
                paqueteService.deletePaquete(paquete.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Eliminacion de paquete ' + paquete.id + 'OK');
                        vm.paquetes.splice(index, 1);
                        $('#waitModal').modal('hide');
                        vm.selectedPaquete = null;
                    } else {
                        console.log('Falla en la eliminación del paquete ' + paquete.id);
                        console.error(response);
                        paquete.edit = false;
                    }
                });
            }


            function confirmarCambiosPaquete(vm, paquete) {
                vm.waitModalText = 'Actualizando paquete, un momento por favor ...';
                $('#waitModal').modal('show');
                paqueteService.updatePaquete(paquete).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de paquete ' + paquete.id + 'OK');
                        paquete.backup = null;
                        $('#waitModal').modal('hide');
                        paquete.edit = false;
                    } else {
                        console.log('falla en la actualización de paquete ' + paquete.id);
                        console.error(response);
                        descartarCambiosPaquete(vm, paquete);
                    }
                }
                );

            }

            function descartarCambiosPaquete(vm, paquete) {

                paquete.descripcion = paquete.backup.descripcion;
                paquete.codigo = paquete.backup.codigo;
                paquete.backup = null;
                paquete.edit = false;
            }

            function closeModalNewPaquete(vm) {

                vm.newPaquete = {
                    descripcion: "",
                    codigo: "",
                    id_area: '1'
                };
                $('#newPaqueteModal').modal('hide');
            }

            function openModalNewPaquete(vm) {
                $('#newPaqueteModal').modal('show');
            }


            function confirmNewPaqueteModal(vm) {
                var newPaqueteData = angular.copy(vm.newPaquete);
                closeModalNewPaquete(vm);
                vm.waitModalText = 'Creando nuevo paquete, un momento por favor ...';
                $('#waitModal').modal('show');
                paqueteService.insertPaquete(newPaqueteData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de paquete OK');
                        changeFilter(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la creación del paquete');
                        console.error(response);
                        $('#waitModal').modal('hide');
                    }
                });
            }

            function changeFilter(vm) {
                paqueteService.getPaquetesPaginacion(vm.filter).then((response) => {
                    console.log(response);
                    vm.paquetes = response.data.data.paquetes;
                    vm.totalPaquetes = response.data.data.cantidad_total;
                    console.log(vm.totalPaquetes);
                    setMaxPage(vm);
                });
            }

            function setMaxPage(vm) {
                vm.maxPage = parseInt(vm.totalPaquetes / vm.filter.cantidad);

                if (vm.totalPaquetes % vm.filter.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            return interfaz;
        });


