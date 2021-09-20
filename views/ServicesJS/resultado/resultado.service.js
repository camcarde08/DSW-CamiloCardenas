'use strict'

angular.module('moduleResultadoService', [])

.factory('resultadoService', function ($http) {
    var interfaz = {
        guardarResultado: function (muestra,ensayo) {
            return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'insertResultado',
                        ensayo: ensayo,
                        muestra: muestra
                    })
                });
        },
        actualizarResultado: function (resultado,muestra,ensayo) {
            return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'updateResultado',
                        resultado: resultado,
                        muestra: muestra,
                        ensayo:ensayo
                    })
                });
        },
    };

    return interfaz;
});