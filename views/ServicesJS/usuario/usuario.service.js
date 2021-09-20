'use strict'

angular.module('moduleUsuariosService', [])

        .factory('usuariosService', function ($http) {
            var interfaz = {
                getAllUsuarios: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllUsuarios'
                        }
                    });
                },
                getAllActiveAnalistas: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllActiveAnalistas'
                        }
                    });
                },
                getAllJefes: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllJefes'
                        }
                    });
                },
                getAllCargos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllCargos'
                        }
                    });
                },
                getAllPerfiles: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllPerfiles'
                        }
                    });
                },
                createNewUsuario: function (nombre, idCargo, email, idJefe, login, idPerfil, password) { 
                    return $http({ 
                        method: 'POST', 
                        url: 'index.php', 
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
                        data: $.param({ 
                            action: 'queryDb', 
                            query: 'createNewUsuario', 
                            nombre: nombre, 
                            idCargo: idCargo, 
                            email: email, 
                            idJefe: idJefe, 
                            login: login, 
                            idPerfil: idPerfil, 
                            password: password
                        }) 
                    }); 
                },
                updateUsuario: function (idUsuario, data) { 
                    return $http({ 
                        method: 'POST', 
                        url: 'index.php', 
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
                        data: $.param({ 
                            action: 'queryDb', 
                            query: 'updateUsuario1', 
                            idUsuario: idUsuario, 
                            data: data
                        }) 
                    }); 
                },
                updatePasswordUsuario: function (idUsuario, password) { 
                    return $http({ 
                        method: 'POST', 
                        url: 'index.php', 
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
                        data: $.param({ 
                            action: 'queryDb', 
                            query: 'updatePasswordUsuario', 
                            idUsuario: idUsuario, 
                            password: password
                        }) 
                    }); 
                },
                borrarUsuario: function (usuario) { 
                    return $http({ 
                        method: 'POST', 
                        url: 'index.php', 
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
                        data: $.param({ 
                            action: 'queryDb', 
                            query: 'borrarUsuario', 
                            usuario: usuario
                        }) 
                    }); 
                }
            }

            return interfaz;
        });