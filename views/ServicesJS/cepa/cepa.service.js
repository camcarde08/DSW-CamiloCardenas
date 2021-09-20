'use strict'

angular.module('moduleCepa', [])

    .factory('cepaService', function ($http) {
        var interfaz = {

            createNewCepa: function(cepaData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'createNewCepa',
                        cepaData: cepaData
                    })
                });
            },
            getAllActiveCepas: function(){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getAllActiveCepas'
                    }
                });
            },
            getActiveCepasByIdMediCultivo: function (idMedioCultivo) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getActiveCepasByIdMedioCultivo',
                        idMedioCultivo: idMedioCultivo
                    }
                });
            },
            getCepasDisponiblesByIdMedioCultivo: function(idMedioCultivo){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getCepasDisponiblesByIdMedioCultivo',
                        idMedioCultivo: idMedioCultivo
                    }
                });
            },
            desasociarCepas: function(cepasData){
                 return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'desasociarCepas',
                        cepasData: cepasData
                    })
                });
            },
            asociarCepas: function(idMedioCultivo, cepasData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'asociarCepas',
                        idMedioCultivo: idMedioCultivo,
                        cepasData: cepasData
                    })
                });
            },
            updateCepa: function(cepaData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'updateCepa',
                        cepaData: cepaData
                    })
                });
            },
            deleteCepa: function(cepaData){
                cepaData.activo = 0;
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'updateCepa',
                        cepaData: cepaData
                    })
                });
            }
           

        }

        return interfaz;
    });