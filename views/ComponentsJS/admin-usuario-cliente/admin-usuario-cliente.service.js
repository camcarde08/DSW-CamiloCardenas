'use strict'

angular.module('CompAdminUsuarioCliente')

        .factory('adminUsuarioClienteService', function ($q, $filter, terceroService) {
            var interfaz = {
                getAllActiveClientes: getAllActiveClientes,
                getAllPermisosUsuarioCliente: getAllPermisosUsuarioCliente,
                eventClickCrearUsuario: eventClickCrearUsuario,
                crearUsuario: crearUsuario,
                eventClickEditarUsuario: eventClickEditarUsuario,
                editarUsuario: editarUsuario,
                eventClickFormatearContrasena: eventClickFormatearContrasena,
                formatearContrasena: formatearContrasena,
                eliminarUsuario: eliminarUsuario,
                rowSelectedUsuarioCliente: rowSelectedUsuarioCliente,
                rowSelectedCliente: rowSelectedCliente,
                cancelarEdicionPermisos: cancelarEdicionPermisos,
                guardarPermisos: guardarPermisos

            };

            function getAllActiveClientes(vm) {
                vm.waitModalText = 'Cargando datos de clientes, un momento por favor ...';
                $('#waitModal').modal('show');
                terceroService.getClientesActivos().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.clientes = response.data.data;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de productos');
                        console.error(response);
                    }
                });
            }

            function getAllPermisosUsuarioCliente(vm) {
                terceroService.getAllPermisosUsuarioCliente().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.permisos = response.data.data;
                    } else {
                        console.log('falla en la carga de productos');
                        console.error(response);
                    }
                });
            }

            function rowSelectedCliente(vm, cliente) {
                vm.clienteSelected = cliente;
                angular.forEach(vm.clientes, function (value, key) {
                    value.id == cliente.id ? value.selected = true : value.selected = false;
                });
                vm.usuarioSelected = null;
                getUsuariosCliente(vm, cliente.id);
            }

            function rowSelectedUsuarioCliente(vm, usuarioSelected) {
                vm.usuarioSelected = usuarioSelected;
                angular.forEach(vm.usuariosCliente, function (value, key) {
                    value.id == usuarioSelected.id ? value.selected = true : value.selected = false;
                });
                getPermisosUsuarioCliente(vm, usuarioSelected.id);
            }

            function getUsuariosCliente(vm, idCliente) {
                vm.waitModalText = 'Cargando datos del cliente, un momento por favor ...';
                $('#waitModal').modal('show');
                terceroService.getUsuariosCliente(idCliente).then(function (response) {
                    if (response.data.code === '00000') {
                        if (response.data.data != null) {
                            vm.usuariosCliente = response.data.data;
                        } else {
                            vm.usuariosCliente = [];
                        }
                    } else {
                        console.log('Falla en la carga de paquetes y ensayos');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
            }


            function eventClickCrearUsuario(vm) {
                angular.element(nuevoUsuarioModal).modal('show');
            }

            function crearUsuario(vm) {
                angular.element(nuevoUsuarioModal).modal('hide');
                vm.waitModalText = 'Creando usuario, un momento por favor...';
                $('#waitModal').modal('show');
                vm.newUsuario.idCliente = vm.clienteSelected.id;
                terceroService.insertUsuarioCliente(vm.newUsuario).then(function (response) {
                    if (response.data.code === '00000') {
                        getUsuariosCliente(vm, vm.clienteSelected.id);
                    } else {
                        console.log('Falla en la creación de usuario');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
            }

            function eventClickEditarUsuario(vm, usuarioSelected) {
                vm.usuarioSelected = usuarioSelected;
                angular.element(editarUsuarioModal).modal('show');
            }

            function editarUsuario(vm) {
                angular.element(editarUsuarioModal).modal('hide');
                vm.waitModalText = 'Editando usuario, un momento por favor...';
                $('#waitModal').modal('show');
                vm.usuarioSelected.idCliente = vm.clienteSelected.id;
                terceroService.updateUsuarioClienteInfo(vm.usuarioSelected).then(function (response) {
                    if (response.data.code === '00000') {
                        getUsuariosCliente(vm, vm.clienteSelected.id);
                    } else {
                        console.log('Falla en la creación de usuario');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
            }

            function eventClickFormatearContrasena(vm, usuarioSelected) {
                vm.usuarioSelected = usuarioSelected;
                angular.element(resetContrasenaUsuarioModal).modal('show');
            }

            function formatearContrasena(vm) {
                angular.element(resetContrasenaUsuarioModal).modal('hide');
                vm.waitModalText = 'Formateando contraseña de usuario, un momento por favor...';
                $('#waitModal').modal('show');
                vm.usuarioSelected.idCliente = vm.clienteSelected.id;
                terceroService.updateUsuarioClienteContrasena(vm.usuarioSelected).then(function (response) {
                    if (response.data.code !== '00000') {
                        console.log('Falla en la actualización de contraseña');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
            }

            function limpiarPermisos(vm) {
                angular.forEach(vm.permisos, function (permiso) {
                    permiso.checked = false;
                });
            }

            function eliminarUsuario(vm, usuarioSelected) {
                angular.element(resetContrasenaUsuarioModal).modal('hide');
                vm.waitModalText = 'Eliminando usuario, un momento por favor...';
                $('#waitModal').modal('show');
                terceroService.eliminarUsuarioCliente(usuarioSelected.id).then(function (response) {
                    if (response.data.code === '00000') {
                        var indice = vm.usuariosCliente.indexOf(usuarioSelected);
                        vm.usuariosCliente.splice(indice, 1);
                    } else {
                        console.log('Falla en la eliminación de usuario');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
                vm.usuarioSelected = null;
            }

            function getPermisosUsuarioCliente(vm, idUsuario) {
                vm.editarPermisos = true;
                limpiarPermisos(vm);
                terceroService.getPermisosUsuarioCliente(idUsuario).then(function (response) {
                    if (response.data.code === '00000') {
                        vm.usuarioSelected.permisos = response.data.data;
                        angular.forEach(vm.permisos, function (permiso) {
                            angular.forEach(vm.usuarioSelected.permisos, function (usuarioPermiso) {
                                if (permiso.id == usuarioPermiso.id_permiso)
                                    permiso.checked = true;
                            });
                        });
                    } else {
                        console.log('Falla obteniendo permisos usuario');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
            }

            function cancelarEdicionPermisos(vm) {
                vm.editaraPermisos = true;
                getPermisosUsuarioCliente(vm, vm.usuarioSelected.id);
            }

            function guardarPermisos(vm) {
                vm.waitModalText = 'Actualizando permisos, un momento por favor...';
                $('#waitModal').modal('show');
                var permisosSelected = []; //array, you were using object
                angular.forEach(vm.permisos, function (value) {
                    if (value.checked === true) {
                        permisosSelected.push(value.id);
                    }
                });

                terceroService.actualizarPermisosUsuarioCliente(permisosSelected, vm.usuarioSelected.id).then(function (response) {
                    if (response.data.code === '00000') {
                        vm.editarPermisos = true;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('Falla guardando permisos');
                        console.error(response);
                        $('#waitModal').modal('hide');
                    }

                });

            }


            return interfaz;
        });



