'use strict'

angular.module('CompAdminEnsayoEquipo')

        .factory('adminEnsayoEquipoService', function ($q, $filter, ensayoService, ensayoEquipoService) {
            var interfaz = {
                
                getEnsayos: getEnsayos,
                SelectRowEnsayoGrid: SelectRowEnsayoGrid,
                asociarEquipos: asociarEquipos,
                desasociarEquipos: desasociarEquipos

            }

            function desasociarEquipos(vm) {
                vm.waitModalText = 'Desasociando equipos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.equiposAsociados, {selected: true});
                console.info('Equipos a desasociar');
                console.debug(aux);
                ensayoEquipoService.deleteEnsayoEquipos(aux).then(function (response) {
                    if (response.data.code = "00000") {
                        console.info('Desasociacion de equipos OK');
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            promiseEquiposAsociados: getEnsayoEquipoAsociados(vm),
                            promiseEquiposDisponibles: getEquiposDisponiblesByIdEnsayo(vm)
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

            function asociarEquipos(vm) {
                vm.waitModalText = 'Asociando equipos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.equiposDisponibles, {selected: true});
                console.info('Equipos a asociar');
                console.debug(aux);
                ensayoEquipoService.createEnsayoEquipos(vm.selectedEnsayo, aux).then(function (response) {
                    if (response.data.code = "00000") {
                        console.info('Asociacion de equipos OK');
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            promiseEquiposAsociados: getEnsayoEquipoAsociados(vm),
                            promiseEquiposDisponibles: getEquiposDisponiblesByIdEnsayo(vm)
                        }
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al asociar equipos');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function SelectRowEnsayoGrid(vm, index, ensayo) {
                if (vm.selectedEnsayo != ensayo) {
                    vm.waitModalText = 'Consultado datos del ensayo seleccionado...'
                    angular.element(waitModal).modal('show');
                    vm.selectedEnsayo = ensayo;
                    angular.forEach(vm.ensayos, function (value, key) {
                        value.id == ensayo.id ? value.selected = true : value.selected = false;
                    });
                    var promises = {
                        promiseEquiposAsociados: getEnsayoEquipoAsociados(vm),
                        promiseEquiposDisponibles: getEquiposDisponiblesByIdEnsayo(vm)
                    }
                    $q.all(promises).then(function () {
                        angular.element(waitModal).modal('hide');
                    });
                }
            }

            function getEnsayos(vm) {
                vm.waitModalText = 'Consultado Ensayos Activos un momento por favor...'
                angular.element(waitModal).modal('show');
                ensayoService.getAllActiveEnsayo().then(function (response) {
                    if (response.data.code = "00000") {
                        vm.ensayos = response.data.data;
                        console.info('carga ensayos activos OK');
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar ensayos activos');
                        console.error(response);
                    }
                    angular.element(waitModal).modal('hide');
                });
            }

            function getEnsayoEquipoAsociados(vm) {
                return ensayoEquipoService.getEnsayoEquipoByIdEnsayo(vm.selectedEnsayo.id).then(function (response) {
                    if (response.data.code = "00000") {
                        vm.equiposAsociados = response.data.data;
                        console.info('carga equipos asociados OK');
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar equipos asociados');
                        console.error(response);
                    }
                });
            }

            function getEquiposDisponiblesByIdEnsayo(vm) {
                return ensayoEquipoService.getEnsayoEquipoDisponibleByIdEnsayo(vm.selectedEnsayo.id).then(function (response) {
                    if (response.data.code = "00000") {
                        vm.equiposDisponibles = response.data.data;
                        console.info('carga equipos disponibles OK');
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar equipos disponibles');
                        console.error(response);
                    }
                });
            }




            return interfaz;
        });


