'use strict'

angular.module('moduleTipoMuestraService', [])

        .factory('tipoMuestraService', function ($http) {
            var interfaz = {
                getAllActiveTipoMuestra: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getActiveTipoMuestra'
                        }
                    });
                }
            }

            return interfaz;
        });