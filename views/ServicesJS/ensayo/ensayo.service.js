'use strict'

angular.module('moduleEnsayoService', [])

        .factory('ensayoService', function ($http) {
            var interfaz = {

                getEnsayosMic: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosMic'
                        }
                    });
                },
                getAllActiveEnsayo: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllActiveEnsayo'
                        }
                    });
                },
                updateEnsayo: function (ensayoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateEnsayo',
                            ensayoData: ensayoData
                        })
                    });
                },
                deleteEnsayo: function (idEnsayo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteEnsayo',
                            idEnsayo: idEnsayo
                        })
                    });
                },
                insertEnsayo: function (ensayoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertEnsayo',
                            ensayoData: ensayoData
                        })
                    });
                },
                getEnsayosPaginacion: function (data) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosPaginacion',
                            cantidad: data.cantidad,
                            pagina: data.pagina,
                            descripcion: data.descripcion,
                            precio_real: data.precio_real,
                            tiempo: data.tiempo,
                            plantilla: data.plantilla,
                            codinterno: data.codinterno,
                            orden: data.orden
                        }
                    });
                }
            }

            return interfaz;
        });

