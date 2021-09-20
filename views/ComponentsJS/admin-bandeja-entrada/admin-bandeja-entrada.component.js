'use strict';

angular.module('CompAdminBandejaEntrada', [])



        .controller('compAdminBandejaEntradaCtrl', function (adminBandejaEntradaService) {
            var vm = this;
            vm.$onInit = function () {
                vm.perfil = {};
            };


            vm.$postLink = function () {
                //vm.obtenerDatosSesionUsuario(vm);

                adminBandejaEntradaService.obtenerPerfiles(vm);
                adminBandejaEntradaService.obtenerPermisosBandejaEntrada(vm);

                vm.obtenerPermisosUsuario = function (perfil) {
                    adminBandejaEntradaService.obtenerPermisosUsuario(vm, perfil);
                }
                vm.cambiarPermiso = function (idPermiso, checked) {
                    adminBandejaEntradaService.cambiarPermiso(vm, idPermiso, checked);
                }
            }
            ;
        })



        .component('sgmAdminBandejaEntrada', {
            templateUrl: './views/ComponentsJS/admin-bandeja-entrada/admin-bandeja-entrada.html',
            controller: 'compAdminBandejaEntradaCtrl',
            controllerAs: 'vm'
        });







