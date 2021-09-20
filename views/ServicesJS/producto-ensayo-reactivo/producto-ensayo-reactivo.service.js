'use strict'

angular.module('moduleProductoEnsayoReactivoService', [])

        .factory('productoEnsayoReactivoService', function ($http) {
            var interfaz = {
                getReactivosAsociadosByIdEnsayoProd: function (idEnsayoProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getReactivosAsociadosByIdEnsayoProd',
                            idEnsayoProducto: idEnsayoProducto
                        }
                    });
                },
                getReactivosDisponiblesByIdEnsayoProd: function (idEnsayoProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getReactivosDisponiblesByIdEnsayoProd',
                            idEnsayoProducto: idEnsayoProducto
                        }
                    });
                },
                createProductoEnsayoReactivos: function (ensayoProducto, reactivos) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createProductoEnsayoReactivos',
                            ensayoProducto: ensayoProducto,
                            reactivos: reactivos
                        })
                    });
                },
                deleteProductoEnsayoReactivos: function (reactivos, ensayoProductoReactivos) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteProductoEnsayoReactivos',
                            reactivos: reactivos,
                            ensayoProductoReactivos: ensayoProductoReactivos
                        })
                    });
                },

            }

            return interfaz;
        });