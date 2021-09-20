'use strict'

angular.module('moduleAreaAnalisisService', [])

        .factory('areaAnalisisService', function ($http) {
            var interfaz = {
                // getAreasActivasJoinCoordinador: function () {
                //     return $http({
                //         method: 'GET',
                //         url: 'model/DB/jqw/AreasAnalisisData.php?query=activeAreas'
                //     })
                // },
                getAreasActivasJoinCoordinador: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAreasActivasReferencias'
                        }
                    });
                }
            }

            return interfaz;
        });


