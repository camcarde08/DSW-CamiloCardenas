'use strict'

angular.module('modulePrincipioActivoService', [])

    .factory('principioActivoService', function ($http) {
        var interfaz = {

            getAllPrincipioActivo: function () {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getAllPrincipioActivo'
                    }
                });
            },
            updatePrincipioActivo: function (principioActivoData) {
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'updatePrincipioActivo',
                        principioActivoData: principioActivoData
                    })
                });
            },
            
            deletePrincipioActivo: function(idPrincipioActivo){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'deletePrincipioActivo',
                        idPrincipioActivo: idPrincipioActivo
                    })
                });
            },
            insertPrincipioActivo: function(principioActivoData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'insertPrincipioActivo',
                        principioActivoData: principioActivoData
                    })
                });
            }
        }

        return interfaz;
    });

