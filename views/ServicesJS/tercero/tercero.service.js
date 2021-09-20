'use strict'

angular.module('moduleTerceroService', [])

        .factory('terceroService', function ($http) {
            var interfaz = {
                getTercerosJoinContactos: function () {
                    return $http({
                        method: 'GET',
                        url: 'model/DB/jqw/terceroData.php?query=getTercerosJoinArayContactos'
                    });
                },
                getClientesActivos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getClientesActivos'
                        }
                    });
                },
                getAllPermisosUsuarioCliente: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllPermisosUsuarioCliente'
                        }
                    });
                },
                getPermisosUsuarioCliente: function (idUsuario) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPermisosUsuarioCliente',
                            idUsuario: idUsuario
                        }
                    });
                },
                actualizarPermisosUsuarioCliente: function (permisosData, idUsuario) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarPermisosUsuarioCliente',
                            permisosData: permisosData,
                            idUsuario: idUsuario
                        })
                    });
                },
                insertUsuarioCliente: function (usuarioData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertUsuarioCliente',
                            usuarioData: usuarioData
                        })
                    });
                },

                updateUsuarioClienteInfo: function (usuarioData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateUsuarioClienteInfo',
                            usuarioData: usuarioData
                        })
                    });
                },

                updateUsuarioClienteContrasena: function (usuarioData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateUsuarioClienteContrasena',
                            usuarioData: usuarioData
                        })
                    });
                },

                eliminarUsuarioCliente: function (idUsuario) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'eliminarUsuarioCliente',
                            idUsuario: idUsuario
                        })
                    });
                },
                getUsuariosCliente: function (idCliente) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getUsuariosCliente',
                            idCliente: idCliente
                        }
                    });
                },
                getTipoIdentificaciones: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getTipoIdentificaciones'
                        }
                    });
                },
                getCiudades: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getCiudades'
                        }
                    });
                },
                actualizarCliente: function (cliente) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarCliente',
                            cliente: cliente
                        })
                    });
                },
                insertarCliente: function (cliente) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertarCliente',
                            cliente: cliente
                        })
                    });
                },
                consultarContactosCliente: function (idCliente) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'consultarContactosCliente',
                            idCliente: idCliente
                        }
                    });
                },
                actualizarCrearContactos: function (contactos, idTercero) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'actualizarCrearContactos',
                            contactos: contactos,
                            idTercero: idTercero
                        })
                    });
                }
            }

            return interfaz;
        });

