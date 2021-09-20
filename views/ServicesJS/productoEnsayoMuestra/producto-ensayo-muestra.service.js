'use strict'

angular.module('moduleProductoEnsayoMuestraService', [])

        .factory('productoEnsayoMuestraService', function ($http) {
            var interfaz = {
                getEnsayoByIdProductoIdAreaA: function (idProducto, idAreaA) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getProductoPaqueteEnsayoByidProdidAreaA',
                            idProducto: idProducto,
                            idAreaA: idAreaA
                        }
                    });
                },
                getAllHojasCalculo: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllHojasCalculo'
                        }
                    });
                },
                getEnsayosPaquetesProducto: function (idProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosPaquetesProducto',
                            idProducto: idProducto
                        }
                    });
                },
                updateHojaCalculoProdEnsayo: function (productoEnsayoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateHojaCalculoProdEnsayo',
                            productoEnsayoData: productoEnsayoData
                        })
                    });
                },
                updateCondicionCromatograficaProdEnsayo: function (productoEnsayoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateCondicionCromatograficaProdEnsayo',
                            productoEnsayoData: productoEnsayoData
                        })
                    });
                },
                updateColumnaProdEnsayo: function (productoEnsayoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateColumnaProdEnsayo',
                            productoEnsayoData: productoEnsayoData
                        })
                    });
                }
            }

            return interfaz;
        });


