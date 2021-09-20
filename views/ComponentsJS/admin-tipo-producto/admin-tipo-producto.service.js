'use strict';

angular.module('CompAdminTipoProducto')

        .factory('adminTipoProductoService', function (tipoProductoService) {
            var interfaz = {
                consultarTiposProducto: consultarTiposProducto
            }

            function consultarTiposProducto(vm) {
                tipoProductoService.getAllTipoProducto().then(function (response) {
                    console.log('Tipos', response);
                    vm.consultaTipoProducto = response.data.data;
                });
            }

            return interfaz;
        });

