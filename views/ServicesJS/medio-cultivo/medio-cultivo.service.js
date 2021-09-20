'use strict'

angular.module('moduleMedioCultivo', [])

    .factory('medioCultivoService', function ($http) {
        var interfaz = {

            getAllMedioCultivo: function () {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getAllMedioCultivo'
                    }
                });
            },
            saveNewMedioCultivo: function (medioCultivoData) {
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'saveNewMedioCultivo',
                        medioCultivoData: medioCultivoData
                    })
                });
            },
            getMediosCultivoByIdEnsayo: function (idEnsayo){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getMediosCultivoByIdEnsayo',
                        idEnsayo: idEnsayo
                    }
                });
            },
            getMediosCultivoDisponiblesByIdEnsayo: function (idEnsayo){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getMediosCultivoDisponiblesByIdEnsayo',
                        idEnsayo: idEnsayo
                    }
                });
            },
            desasociarMediosCultivo: function(asociacionesData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'desasociarMediosCultivo',
                        asociacionesData: asociacionesData
                    })
                });
            },
            asociarMediosCultivo: function(idEnsayo,meiosCultivoData){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'asociarMediosCultivo',
                        idEnsayo: idEnsayo,
                        meiosCultivoData: meiosCultivoData
                    })
                });
            },
            
            updateMedioCultivoData: function (medioCultivoData) {
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'updateMedioCultivo',
                        medioCultivoData: medioCultivoData
                    })
                });
            },
            
            deleteMedioCultivo: function(idMedioCultivo){
                return $http({
                    method: 'POST',
                    url: 'index.php',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    data: $.param({
                        action: 'queryDb',
                        query: 'deleteMedioCultivo',
                        idMedioCultivo: idMedioCultivo
                    })
                });
            }
        }

        return interfaz;
    });