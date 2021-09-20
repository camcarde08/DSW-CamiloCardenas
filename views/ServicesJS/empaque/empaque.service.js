'use strict'

angular.module('moduleEmpaqueService', [])

        .factory('empaqueService', function ($http) {
            var interfaz = {
                getAllEmpaque: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllEmpaque'
                        }
                    });
                },
                getAllEmpaqueAsociado: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllEmpaqueAsociado'
                        }
                    });
                },
                createNewEmpaque: function (newEmpaque) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createNewEmpaque',
                            newEmpaque: newEmpaque
                        })
                    });
                },
                actualizarEnvase: function (envase) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarEnvase',
                            envase: envase
                        })
                    });
                },
                borrarEnvase: function (envase) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'borrarEnvase',
                            envase: envase
                        })
                    });
                }
            };

            return interfaz;
        });