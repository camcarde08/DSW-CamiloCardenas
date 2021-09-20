'use strict'

angular.module('moduleReactivoService', [])

        .factory('reactivoService', function ($http) {
            var interfaz = {

                getAllActiveReactivo: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllReactivos2'
                        }
                    });
                },
                getAllReactivosPorMuestra: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllReactivosPorMuestra'
                        }
                    });
                },
                updateReactivo: function (reactivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateReactivo',
                            reactivoData: reactivoData
                        })
                    });
                },
                deleteReactivo: function (idReactivo, razon) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteReactivo',
                            idReactivo: idReactivo,
                            razon: razon
                        })
                    });
                },
                insertReactivo: function (reactivoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertReactivo2',
                            reactivoData: reactivoData
                        })
                    });
                },
                scanDirByIdReactivo: function (nombreReactivo, idReactivo) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'scanDirByIdReactivo',
                            idReactivo: idReactivo,
                            nombreReactivo: nombreReactivo
                        }
                    });
                }
            }

            return interfaz;
        });

