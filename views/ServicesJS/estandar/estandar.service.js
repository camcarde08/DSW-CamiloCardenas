"use strict";
angular.module('moduleEstandarService', [])
        .factory('estandarService', function ($http) {
            var interfaz = {
                getAllActiveEstandares: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllEstandares2'
                        }
                    });
                },
                updateEstandar: function (estandarData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateEstandar',
                            estandarData: estandarData
                        })
                    });
                },
                deleteEstandar: function (idEstandar, razon) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteEstandar',
                            idEstandar: idEstandar,
                            razon: razon
                        })
                    });
                },
                insertEstandar: function (estandarData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertEstandar',
                            estandarData: estandarData
                        })
                    });
                },
                scanDirByIdEstandar: function (nombreEstandar, idEstandar) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'scanDirByIdEstandar',
                            idEstandar: idEstandar,
                            nombreEstandar: nombreEstandar
                        }
                    });
                },
                getTiposEstandar: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getTiposEstandar'
                        }
                    });
                }
            }

            return interfaz;
        });