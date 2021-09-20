'use strict'

angular.module('moduleProductoEnsayoEstandarService', [])

        .factory('productoEnsayoEstandarService', function ($http) {
            var interfaz = {
                getEstandaresAsociadosByIdEnsayoProd: function (idEnsayoProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEstandaresAsociadosByIdEnsayoProd',
                            idEnsayoProducto: idEnsayoProducto
                        }
                    });
                },
                getEstandaresDisponiblesByIdEnsayoProd: function (idEnsayoProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEstandaresDisponiblesByIdEnsayoProd',
                            idEnsayoProducto: idEnsayoProducto
                        }
                    });
                },
                createProductoEnsayoEstandares: function (ensayoProducto, estandares) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createProductoEnsayoEstandares',
                            ensayoProducto: ensayoProducto,
                            estandares: estandares
                        })
                    });
                },
                deleteProductoEnsayoEstandares: function (estandares, ensayoProductoEstandares) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteProductoEnsayoEstandares',
                            ensayoProductoEstandares: ensayoProductoEstandares,
                            estandares: estandares
                        })
                    });
                },

            }

            return interfaz;
        });