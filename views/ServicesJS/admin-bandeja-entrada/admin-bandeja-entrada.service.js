'use strict'

angular.module('moduleAdminBandejaEntradaService', [])

        .factory('bandejaEntradaService', function ($http) {
            var interfaz = {
                getPerfilPermisosBandejaEntrada: function (idPerfil) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPerfilPermisosBandejaEntrada',
                            idPerfil: idPerfil
                        }
                    });
                },
                getAllPerfil: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllPerfil'
                        }
                    });
                },
                getAllPermisosBandejaEntrada: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllPermisosBandejaEntrada'
                        }
                    });
                },

                asignarPerfilPermisoBandejaEntrada: function (idPerfil, idPermiso) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'asignarPerfilPermisoBandejaEntrada',
                            idPerfil: idPerfil,
                            idPermiso: idPermiso
                        })
                    });
                },

                eliminarPerfilPermisoBandejaEntrada: function (idPerfil, idPermiso) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'eliminarPerfilPermisoBandejaEntrada',
                            idPerfil: idPerfil,
                            idPermiso: idPermiso
                        }
                    });
                },

            };

            return interfaz;
        });

