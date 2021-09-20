'use strict';

angular.module('CompAdminMetodo', [

])

        .controller('CompAdminMetodoCtrl', function (adminMetodoService, metodoService) {
            var vm = this;

            vm.$onInit = function () {
                adminMetodoService.consultarMetodos(vm);
            };

            vm.$postLink = function () {

            };
            
            vm.crearNuevoMetodo = function () {  
                $('#createNewMetodoModal').modal('hide');  
                angular.element('#modalespera').modal('show');  
                metodoService.createNewMetodo(vm.nuevoMetodo).then(function (response) {  
                    console.log(response); 
                    adminMetodoService.consultarMetodos(vm);
                    vm.nuevoMetodo = null;  
                    angular.element('#modalespera').modal('hide');  
                });  
            }  
  
            vm.borrarMetodo = function (metodo) {  
                angular.element('#modalespera').modal('show');  
                metodoService.desactivarMetodo(metodo)  
                        .then(function (response) { 
                            adminMetodoService.consultarMetodos(vm);
                            console.log(response);  
                            angular.element('#modalespera').modal('hide');  
                        });  
            }  
  
            vm.showModalEspera = function () {  
                angular.element('#modalespera').modal('show');  
            }  
  
            vm.createNewMetodo = function () {  
                angular.element('#modalespera').modal('show');  
                $('#createNewMetodoModal').modal('show');  
                angular.element('#modalespera').modal('hide');  
            }

            

        })



        .component('sgmAdminMetodo', {
            templateUrl: './views/ComponentsJS/admin-metodo/admin-metodo.html',
            controller: 'CompAdminMetodoCtrl',
            controllerAs: 'vm'
        });