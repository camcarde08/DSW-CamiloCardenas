'use strict'

angular.module('moduleLoteCepa', [])

    .factory('loteCepaService', function ($http) {
        var interfaz = {

            getLotesByIdCepa: function (idCepa) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getLotesByIdCepa',
                        idCepa: idCepa
                    }
                });
            },
            activarLoteCepa: function(loteCepaData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'activarLoteCepa',
                        loteCepaData: loteCepaData
                    })
                });
            },
            createNewLoteCepa: function(newLoteData,idCepa){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'createNewLoteCepa',
                        newLoteData: newLoteData,
                        idCepa: idCepa
                    })
                });
            }
        }

        return interfaz;
    });