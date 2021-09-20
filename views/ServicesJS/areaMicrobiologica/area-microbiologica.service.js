'use strict'

angular.module('moduleAreaMicrobiologicaService', [])

        .factory('areaMicrobioloicaService', function ($http) {
            var interfaz = {
                getAreasActivas: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getActiveAreasMicrobiologicas'
                        }
                    });
                }
            };

            return interfaz;
        });

