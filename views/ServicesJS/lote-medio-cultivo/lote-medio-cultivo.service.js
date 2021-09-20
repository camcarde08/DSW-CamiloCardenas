'use strict'

angular.module('moduleLoteMedioCultivo', [])

        .factory('loteMedioCultivoService', function ($http) {
            var interfaz = {

                getLotesByIdMedioCultivo: function (idMedioCultivo) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getLotesByIdMedioCultivo',
                            idMedioCultivo: idMedioCultivo
                        }
                    });
                },
                saveNewLoteMedioCultivo: function (loteMedioCultivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'saveNewLoteMedioCultivo',
                            loteMedioCultivoData: loteMedioCultivoData
                        })
                    });
                },
                activateLoteMedioCultivo: function (idLote, idMedioCultivo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'activateLoteMedioCultivo',
                            idLote: idLote,
                            idMedioCultivo: idMedioCultivo
                        })
                    });
                },

                updateLoteMedioCultivo: function (loteMedioCultivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateLoteMedioCultivo',
                            loteMedioCultivoData: loteMedioCultivoData
                        })
                    });
                }

            }

            return interfaz;
        });