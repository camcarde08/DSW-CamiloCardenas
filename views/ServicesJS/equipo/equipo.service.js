'use strict'

angular.module('moduleEquipoService', [])

        .factory('equipoService', function ($http) {
            var interfaz = {

                getEquiposActivos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getEquiposActivos'
                        }
                    });
                },
                insertEquipo: function (equipoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertEquipo',
                            equipoData: equipoData
                        })
                    });
                },
                updateEquipo: function (equipoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateEquipo',
                            equipoData: equipoData
                        })
                    });
                },
                deleteEquipo: function (idEquipo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteEquipo',
                            idEquipo: idEquipo
                        })
                    });
                }
            }

            return interfaz;
        });


