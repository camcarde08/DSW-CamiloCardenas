'use strict'

angular.module('moduleMetodoService', [])

        .factory('metodoService', function ($http) {
            var interfaz = {
                getActiveMetodo: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getActiveMetodo'
                        }
                    });
                },
                createNewMetodo: function (metodo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createNewMetodo',
                            metodo: metodo
                        })
                    });
                },
                getAllMetodo: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllMetodo'
                        }
                    });
                },
                desactivarMetodo: function (metodo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'desactivarMetodo',
                            metodo: metodo
                        })
                    });
                }
            }

            return interfaz;
        });



