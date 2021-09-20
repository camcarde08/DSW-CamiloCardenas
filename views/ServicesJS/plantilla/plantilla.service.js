'use strict'

angular.module('modulePlantillaService', [])

    .factory('plantillaService', function ($http) {
        var interfaz = {

            getPlantillas: function () {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getPlantillas'
                    }
                });
            }
        }

        return interfaz;
    });

