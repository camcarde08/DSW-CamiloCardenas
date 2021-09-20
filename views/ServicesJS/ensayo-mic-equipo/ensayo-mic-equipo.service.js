'use strict'

angular.module('moduleEnsayoMicEquipo', [])

        .factory('ensayoMicEquipoService', function ($http) {
            var interfaz = {
               
                getEnsayosMicEquipo: function (idEnsayo) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEnsayosMicEquipo',
                            idEnsayo: idEnsayo
                        }
                    });
                }
            }

            return interfaz;
        });