"use strict";
angular.module('moduleColumnaService', [])
        .factory('columnaService', function ($http) {
            var interfaz = {
                getAllActiveColumnas: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllColumnas'
                        }
                    });
                },
                updateColumna: function (columnaData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateColumna',
                            columnaData: columnaData
                        })
                    });
                },
                getPrincipiosActivosDisponibles: function (idColumna) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPrincipiosActivosDisponibles',
                            idColumna: idColumna
                        }
                    });
                },
                deleteColumna: function (idColumna) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteColumna',
                            idColumna: idColumna
                        })
                    });
                },
                insertColumna: function (columnaData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertColumna',
                            columnaData: columnaData
                        })
                    });
                },
                scanDirByIdColumna: function (nombre, idColumna) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'scanDirByIdColumna',
                            idColumna: idColumna,
                            nombreColumna: nombre
                        }
                    });
                }
            }

            return interfaz;
        });