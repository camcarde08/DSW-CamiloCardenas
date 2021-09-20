'use strict';  
  
angular.module('CompAdminTipoProducto', [  
  
])  
  
        .controller('CompAdminTipoProductoCtrl', function (adminTipoProductoService, tipoProductoService) {  
            var vm = this;  
  
            vm.$onInit = function () {  
                adminTipoProductoService.consultarTiposProducto(vm);  
            };  
  
            vm.$postLink = function () {  
  
            };  
  
            vm.crearNuevoTipoProducto = function () {  
                $('#createNewTipoProductoModal').modal('hide');  
                angular.element('#modalespera').modal('show');  
                tipoProductoService.createNewTipoProducto(vm.nuevoTipoProductoCodigo, vm.nuevoTipoProductoNombre).then(function (response) {  
                    console.log(response); 
                    adminTipoProductoService.consultarTiposProducto(vm)
                    vm.nuevoTipoProductoCodigo = null;  
                    vm.nuevoTipoProductoNombre = null;  
                    angular.element('#modalespera').modal('hide');  
                });  
            }  
  
            vm.editarTipoProducto = function (tipo) {  
                angular.element('#modalespera').modal('show');  
                tipo.edit = true;  
                angular.element('#modalespera').modal('hide');  
            }  
  
            vm.actualizarTipoProducto = function (tipo) {  
                angular.element('#modalespera').modal('show');  
                tipoProductoService.actualizarTipoProducto(tipo)  
                        .then(function (response) {
                            tipo.edit = false;
                            console.log(response);  
                            angular.element('#modalespera').modal('hide');  
                        });  
            }  
  
            vm.showModalEspera = function () {  
                angular.element('#modalespera').modal('show');  
            }  
  
            vm.createNewTipoProducto = function () {  
                angular.element('#modalespera').modal('show');  
                $('#createNewTipoProductoModal').modal('show');  
                angular.element('#modalespera').modal('hide');  
            }  
  
        })  
  
  
  
        .component('sgmAdminTipoProducto', {  
            templateUrl: './views/ComponentsJS/admin-tipo-producto/admin-tipo-producto.html',  
            controller: 'CompAdminTipoProductoCtrl',  
            controllerAs: 'vm'  
        });


