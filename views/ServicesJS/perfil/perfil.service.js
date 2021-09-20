'use strict'

angular.module('modulePerfilService', [])

        .factory('perfilService', function ($http) {
            var interfaz = {

                getPerfiles: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPerfiles'
                        }
                    });
                },
                
                getPermisos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPermisos'
                        }
                    });
                },

                getPermisosModulo: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPermisosModulo'
                        }
                    });
                },
                
                createPerfilPermiso: function (idPerfil, idPermiso) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createPerfilPermiso',
                            idPerfil: idPerfil,
                            idPermiso: idPermiso
                        })
                    });
                },
                
                removePerfilPermiso: function (idPerfil, idPermiso) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'removePerfilPermiso',
                            idPerfil: idPerfil,
                            idPermiso: idPermiso
                        })
                    });
                }
            };

            return interfaz;
        });

