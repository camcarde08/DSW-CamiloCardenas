'use strict'

angular.module('moduleMuestraEstandarLoteService', [])

        .factory('muestraEstandarLoteService', function ($http) {
            var interfaz = {
                registrarMuestraEstandarLote: function (idMuestra) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'registrarMuestraEstandarLote',
                            idMuestra: idMuestra
                        })
                    });
                }
            };

            return interfaz;
        });