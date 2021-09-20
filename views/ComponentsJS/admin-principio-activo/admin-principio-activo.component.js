'use strict';

angular.module('CompAdminPrincipioActivo', [])



        .controller('compAdminPrincipioActivoCtrl', function (adminPrincipioActivoService) {
            var vm = this;
            vm.$onInit = function () {
                vm.newPrincipioActivo = {};
            };


            vm.$postLink = function () {
                adminPrincipioActivoService.consultarPrincipiosActivos(vm);

                vm.editarPrincipioActivo = function (principioActivo) {
                    adminPrincipioActivoService.editarPrincipioActivo(vm, principioActivo);
                }

                vm.eliminarPrincipioActivo = function (principioActivo, index) {
                    adminPrincipioActivoService.eliminarPrincipioActivo(vm, principioActivo, index);
                }

                vm.descartarCambiosPrincipioActivo = function (principioActivo) {
                    adminPrincipioActivoService.descartarCambiosPrincipioActivo(vm, principioActivo);
                }

                vm.confirmarCambiosPrincipioActivo = function (principioActivo) {
                    adminPrincipioActivoService.confirmarCambiosPrincipioActivo(vm, principioActivo);
                }

                vm.openModalNewPrincipioActivo = function () {
                    adminPrincipioActivoService.openModalNewPrincipioActivo(vm);
                }

                vm.closeModalNewPrincipioActivo = function () {
                    adminPrincipioActivoService.closeModalNewPrincipioActivo(vm);
                }

                vm.confirmNewPrincipioActivoModal = function () {
                    adminPrincipioActivoService.confirmNewPrincipioActivoModal(vm);
                }

                vm.principioActivoGridRowSelected = function (principioActivo, index) {
                    adminPrincipioActivoService.principioActivoGridRowSelected(vm, principioActivo, index);
                }
            }
            ;
        })



        .component('sgmAdminPrincipioActivo', {
            templateUrl: './views/ComponentsJS/admin-principio-activo/admin-principio-activo.html',
            controller: 'compAdminPrincipioActivoCtrl',
            controllerAs: 'vm'
        });






