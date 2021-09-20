'use strict'

angular.module('moduleDuracionEstabilidadService', [])

        .factory('duracionEstabilidadService', function ($http) {
            var interfaz = {
                getDuracionEstabilidadNatural: function () {
                    return $http({
                        method: 'GET',
                        url: 'config/tiemposEstabilidadNatural.json'
                    })
                },
                getDuracionEstabilidadAcelerada: function () {
                    return $http({
                        method: 'GET',
                        url: 'config/tiemposEstabilidadAcelerada.json'
                    })
                },
                getDuracionEstabilidadOngoing: function () {
                    return $http({
                        method: 'GET',
                        url: 'config/tiemposEstabilidadOnGoing.json'
                    })
                }
            }

            return interfaz;
        });