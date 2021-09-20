'use strict'

angular.module('moduleEnsayoEquipoService', [])

    .factory('ensayoEquipoService', function ($http) {
        var interfaz = {
            getEnsayoEquipoByIdEnsayo: function (idEnsayo) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getEnsayoEquipoByIdEnsayo',
                        idEnsayo: idEnsayo
                    }
                });
            },
            getEnsayoEquipoDisponibleByIdEnsayo: function (idEnsayo) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getEnsayoEquipoDisponibleByIdEnsayo',
                        idEnsayo: idEnsayo
                    }
                });
            },
            createEnsayoEquipos: function(ensayo,equipos){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'createEnsayoEquipos',
                        ensayo: ensayo,
                        equipos: equipos
                    })
                });
            },
            deleteEnsayoEquipos: function(ensayoEquipos){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'deleteEnsayoEquipos',
                        ensayoEquipos: ensayoEquipos
                    })
                });
            },

        }

        return interfaz;
    });