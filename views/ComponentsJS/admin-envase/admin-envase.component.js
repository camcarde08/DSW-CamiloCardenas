'use strict';

angular.module('CompAdminEnvase', [

])

        .controller('compAdminEnvaseCtrl', function (adminEnvaseService, empaqueService) {
            var vm = this;

            vm.$onInit = function () {
                adminEnvaseService.consultarEnvases(vm);
            };

            vm.$postLink = function () {

            };

            vm.crearNuevoEnvase = function () {
                $('#createNewEmpaqueModal').modal('hide');
                angular.element('#modalespera').modal('show');
                empaqueService.createNewEmpaque(vm.nuevoEmpaque).then(function (response) {
                    console.log(response);
                    adminEnvaseService.consultarEnvases(vm);
                    vm.nuevoEmpaque = null;
                    angular.element('#modalespera').modal('hide');
                });
            }

            vm.editarEnvase = function (envase) {
                angular.element('#modalespera').modal('show');
                envase.edit = true;
                angular.element('#modalespera').modal('hide');
            }

            vm.actualizarEnvase = function (envase) {
                angular.element('#modalespera').modal('show');
                empaqueService.actualizarEnvase(envase)
                        .then(function (response) {
                            envase.edit = false;
                            console.log(response);
                            angular.element('#modalespera').modal('hide');
                        });
            }

            vm.borrarEnvase = function (envase) {
                angular.element('#modalespera').modal('show');
                empaqueService.borrarEnvase(envase)
                        .then(function (response) {
                            adminEnvaseService.consultarEnvases(vm);
                            console.log(response);
                            angular.element('#modalespera').modal('hide');
                        });
            }

            vm.showModalEspera = function () {
                angular.element('#modalespera').modal('show');
            }

            vm.createNewEmpaque = function () {
                angular.element('#modalespera').modal('show');
                $('#createNewEmpaqueModal').modal('show');
                angular.element('#modalespera').modal('hide');
            }

        })



        .component('sgmAdminEnvase', {
            templateUrl: './views/ComponentsJS/admin-envase/admin-envase.html',
            controller: 'compAdminEnvaseCtrl',
            controllerAs: 'vm'
        });