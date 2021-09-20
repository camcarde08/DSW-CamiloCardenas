'use strict';

angular.module('CompAdminPaquete', [])



        .controller('compAdminPaqueteCtrl', function (adminPaqueteService) {
            var vm = this;

            vm.totalPaquetes = 0;
            vm.maxPage = 1;
            vm.paquetes = [];

            vm.filter = {
                cantidad: 10,
                pagina: 1,
                codigo: '',
                descripcion: ''
            };

            vm.$onInit = function () {
                vm.changeFilter();
                vm.newPaquete = {
                    codigo: "",
                    descripcion: "",
                    id_area: '1'

                };

                adminPaqueteService.getAllAreas(vm);

            };

            vm.changeFilter = function () {
                adminPaqueteService.changeFilter(vm);
            }

            vm.$postLink = function () {

                // evento seleccionar row en la grilla de metodos
                vm.SelectRowPaqueteGrid = function (index, item) {
                    adminPaqueteService.SelectRowPaqueteGrid(vm, index, item);
                };

                // evento asociar ensayos
                vm.clickAsociarEnsayos = function () {
                    adminPaqueteService.asociarEnsayos(vm);
                };

                // evento desasociar ensayos
                vm.clickDesasociarEnsayos = function () {
                    adminPaqueteService.desasociarEnsayos(vm);
                };

                vm.editarPaquete = function (item) {
                    adminPaqueteService.editarPaquete(vm, item);
                };

                vm.eliminarPaquete = function (item, index) {
                    adminPaqueteService.eliminarPaquete(vm, item, index);
                };

                vm.confirmarCambiosPaquete = function (item) {
                    adminPaqueteService.confirmarCambiosPaquete(vm, item);
                };

                vm.descartarCambiosPaquete = function (item) {
                    adminPaqueteService.descartarCambiosPaquete(vm, item);
                };

                vm.openModalNewPaquete = function () {
                    adminPaqueteService.openModalNewPaquete(vm);
                };

                vm.closeModalNewPaquete = function () {
                    adminPaqueteService.closeModalNewPaquete(vm);
                };

                vm.confirmNewPaqueteModal = function () {
                    adminPaqueteService.confirmNewPaqueteModal(vm);
                };

                vm.getDescripcionArea = function (idArea) {
                    var result = null;
                    angular.forEach(vm.areasAnalisis, function (area) {
                        if (area.id == idArea) {
                            result = area;
                        }
                    });
                    return result;

                };

                vm.changeFilterHeader = function () {
                    vm.firstPage();
                }


                vm.firstPage = function () {
                    vm.filter.pagina = 1;
                    vm.changeFilter();
                }

                vm.resPage = function () {
                    if (vm.filter.pagina > 1) {
                        vm.filter.pagina--;
                    }
                    vm.changeFilter();
                }

                vm.addPage = function () {
                    if (vm.filter.pagina < vm.maxPage) {
                        vm.filter.pagina++;
                    }
                    vm.changeFilter();
                }

                vm.lastPage = function () {
                    vm.filter.pagina = vm.maxPage;
                    vm.changeFilter();
                }

            };
        })



        .component('sgmAdminPaquete', {
            templateUrl: './views/ComponentsJS/admin-paquete/admin-paquete.html',
            controller: 'compAdminPaqueteCtrl',
            controllerAs: 'vm'
        });






