'use strict';

angular.module('CompAdminCondicionCromatografica', [])



        .controller('compAdminCondicionCromatograficaCtrl', function ($window, adminCondicionCromatograficaService) {
            var vm = this;
            vm.$onInit = function () {
                vm.newCondicionCromatografica = {};
            };


            vm.$postLink = function () {
                adminCondicionCromatograficaService.consultarCondicionesCromatograficas(vm);

                vm.condicionCromatograficaGridRowSelected = function (condicionCromatografica, index) {
                    adminCondicionCromatograficaService.condicionCromatograficaGridRowSelected(vm, condicionCromatografica, index);
                }

                vm.confirmarCambiosCondicionCromatografica = function (condicionCromatografica) {
                    adminCondicionCromatograficaService.confirmarCambiosCondicionCromatografica(vm, condicionCromatografica);
                }

                vm.descartarCambiosCondicionCromatografica = function (condicionCromatografica) {
                    adminCondicionCromatograficaService.descartarCambiosCondicionCromatografica(vm, condicionCromatografica);
                }

                vm.openModalNewCondicionCromatografica = function () {
                    adminCondicionCromatograficaService.openModalNewCondicionCromatografica(vm);
                }

                vm.closeModalNewCondicionCromatografica = function () {
                    adminCondicionCromatograficaService.closeModalNewCondicionCromatografica(vm);
                }

                vm.eliminarCondicionCromatografica = function (condicionCromatografica, index) {
                    adminCondicionCromatograficaService.eliminarCondicionCromatografica(vm, condicionCromatografica, index);
                }

                vm.confirmNewCondicionCromatograficaModal = function () {
                    adminCondicionCromatograficaService.confirmNewCondicionCromatograficaModal(vm);
                }

                vm.imprimircondicionCromatografica = function (condicionCromatografica) {
                    $("#idPerfilCondiciones").val(true);
                    $("#idCondicion").val(condicionCromatografica.id);
                    $("#opcion").val(0);
                    $("#formCondiciones").submit();
                }

            }
            ;
        })



        .component('sgmAdminCondicionCromatografica', {
            templateUrl: './views/ComponentsJS/admin-condicion-cromatografica/admin-condicion-cromatografica.html',
            controller: 'compAdminCondicionCromatograficaCtrl',
            controllerAs: 'vm'
        });






