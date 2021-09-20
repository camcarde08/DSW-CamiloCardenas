'use strict'; 
 
angular.module('CompAdminFormaFarmaceutica', [ 
 
]) 
 
        .controller('CompAdminFormaFarmaceuticaCtrl', function (adminFormaFarmaceuticaService, envaseService) { 
            var vm = this; 
 
            vm.$onInit = function () { 
                adminFormaFarmaceuticaService.consultarFormasFarmaceuticas(vm); 
            }; 
 
            vm.$postLink = function () { 
 
            }; 
 
            vm.crearNuevaFormaFamaceutica = function () { 
                $('#createNewEmpaqueModal').modal('hide'); 
                angular.element('#modalespera').modal('show'); 
                envaseService.createNewEnvase(vm.nuevaFormaFarmaceutica).then(function (response) { 
                    console.log(response); 
                    adminFormaFarmaceuticaService.consultarFormasFarmaceuticas(vm);
                    vm.nuevaFormaFarmaceutica = null; 
                    angular.element('#modalespera').modal('hide'); 
                }); 
            } 
 
            vm.editarFormaFarmaceutica = function (forma) { 
                angular.element('#modalespera').modal('show'); 
                forma.edit = true; 
                angular.element('#modalespera').modal('hide'); 
            } 
 
            vm.actualizarFormaFarmaceutica = function (forma) { 
                angular.element('#modalespera').modal('show'); 
                envaseService.actualizarFormaFarmaceutica(forma) 
                        .then(function (response) {
                            forma.edit = false;
                            console.log(response); 
                            angular.element('#modalespera').modal('hide'); 
                        }); 
            } 
 
            vm.borrarFormaFarmaceutica = function (forma) { 
                angular.element('#modalespera').modal('show'); 
                envaseService.borrarFormaFarmaceutica(forma) 
                        .then(function (response) { 
                            adminFormaFarmaceuticaService.consultarFormasFarmaceuticas(vm);
                            console.log(response); 
                            angular.element('#modalespera').modal('hide'); 
                        }); 
            } 
 
            vm.showModalEspera = function () { 
                angular.element('#modalespera').modal('show'); 
            } 
 
            vm.createNewFormaFarmaceutica = function () { 
                angular.element('#modalespera').modal('show'); 
                $('#createNewEmpaqueModal').modal('show'); 
                angular.element('#modalespera').modal('hide'); 
            } 
 
        }) 
 
 
 
        .component('sgmAdminFormaFarmaceutica', { 
            templateUrl: './views/ComponentsJS/admin-forma-farmaceutica/admin-forma-farmaceutica.html', 
            controller: 'CompAdminFormaFarmaceuticaCtrl', 
            controllerAs: 'vm' 
        });
