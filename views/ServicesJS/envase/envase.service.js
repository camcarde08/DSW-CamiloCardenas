'use strict'

angular.module('moduleEnvaseService', [])

        .factory('envaseService', function ($http) {
            var interfaz = {
                getAllEnvase: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllEnvase'
                        }
                    });
                },
                createNewEnvase: function (newEnvase) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createNewEnvase',
                            newEnvase: newEnvase
                        })
                    });
                },
                getAllFormasFarmaceuticasAsociadas: function () { 
                    return $http({ 
                        method: 'GET', 
                        url: 'index.php', 
                        params: { 
                            action: 'queryDb', 
                            query: 'getAllFormasFarmaceuticasAsociadas' 
                        } 
                    }); 
                },
                actualizarFormaFarmaceutica: function (forma) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarFormaFarmaceutica',
                            forma: forma
                        })
                    });
                },
                borrarFormaFarmaceutica: function (forma) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'borrarFormaFarmaceutica',
                            forma: forma
                        })
                    });
                }
            };

            return interfaz;
        });


