'use strict'

angular.module('moduleLoteReactivo', [])

        .factory('loteReactivoService', function ($http) {
            var interfaz = {

                getLotesByIdReactivo: function (idReactivo) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getLotesByIdReactivo',
                            idReactivo: idReactivo
                        }
                    });
                },
                activarLoteReactivo: function (loteReactivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'activarLoteReactivo',
                            loteReactivoData: loteReactivoData
                        })
                    });
                },
                desactivarLoteReactivo: function (loteReactivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'desactivarLoteReactivo',
                            loteReactivoData: loteReactivoData
                        })
                    });
                },
                createNewLoteReactivo: function (newLoteData, idReactivo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createNewLoteReactivo',
                            newLoteData: newLoteData,
                            idReactivo: idReactivo
                        })
                    });
                },

                updateLoteReactivo: function (loteReactivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateLoteReactivo',
                            loteReactivoData: loteReactivoData
                        })
                    });
                },
                scanDirByIdLoteReactivo: function (numeroLoteReactivo, idLoteReactivo, idReactivo) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'scanDirByIdLoteReactivo',
                            idReactivo: idReactivo,
                            numeroLoteReactivo: numeroLoteReactivo,
                            idLoteReactivo: idLoteReactivo
                        }
                    });
                }
            }

            return interfaz;
        });