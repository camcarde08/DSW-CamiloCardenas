'use strict'

angular.module('modulePaqueteService', [])

        .factory('paqueteService', function ($http) {
            var interfaz = {

                getPaquetes: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPaquetes'
                        }
                    });
                },
                getEnsayosByIdPaquete: function (idPaquete) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosByIdPaquete',
                            idPaquete: idPaquete
                        }
                    });
                },
                getEnsayosDisponiblesByIdPaquete: function (idPaquete) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosDisponiblesByIdPaquete',
                            idPaquete: idPaquete
                        }
                    });
                },
                createPaqueteEnsayos: function (paquete, ensayos) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createPaqueteEnsayos',
                            paquete: paquete,
                            ensayos: ensayos
                        })
                    });
                },
                deletePaqueteEnsayos: function (paqueteEnsayos) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deletePaqueteEnsayos',
                            paqueteEnsayos: paqueteEnsayos
                        })
                    });
                },
                deletePaquete: function (idPaquete) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deletePaquete',
                            idPaquete: idPaquete
                        })
                    });
                },
                updatePaquete: function (paquete) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updatePaquete',
                            paqueteData: paquete
                        })
                    });
                },
                insertPaquete: function (paqueteData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertPaquete',
                            paqueteData: paqueteData
                        })
                    });
                },
                getPaquetesPaginacion: function (data) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPaquetesPaginacion',
                            cantidad: data.cantidad,
                            pagina: data.pagina,
                            codigo: data.codigo,
                            descripcion: data.descripcion
                        }
                    });
                }
            };

            return interfaz;
        });

