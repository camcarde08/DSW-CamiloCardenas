'use strict'

angular.module('moduleCondicionCromatograficaService', [])

        .factory('condicionCromatograficaService', function ($http) {
            var interfaz = {

                getAllCondicionCromatografica: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllCondicionCromatografica'
                        }
                    });
                },
                updateCondicionCromatografica: function (condicionCromatograficaData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateCondicionCromatografica',
                            condicionCromatograficaData: condicionCromatograficaData
                        })
                    });
                },
                insertCondicionCromatografica: function (condicionCromatograficaData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertCondicionCromatografica',
                            condicionCromatograficaData: condicionCromatograficaData
                        })
                    });
                },
                deleteCondicionCromatografica: function (idCondicionCromatografica) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteCondicionCromatografica',
                            idCondicionCromatografica: idCondicionCromatografica
                        })
                    });
                }
            }

            return interfaz;
        });

