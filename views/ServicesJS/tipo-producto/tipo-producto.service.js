'use strict'

angular.module('moduleTipoProductoService', [])

        .factory('tipoProductoService', function ($http) {
            var interfaz = {

                actualizarTipoProducto: function (tipo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarTipoProducto',
                            tipo: tipo
                        })
                    });
                },
                createNewTipoProducto: function (codigo,nombre) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createNewTipoProducto',
                            codigo: codigo,
                            nombre: nombre
                            
                        })
                    });
                },
                getAllTipoProducto: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllTipoProducto'
                        }
                    });
                }
            }

            return interfaz;
        });


