'use strict'

angular.module('CompAdminBandejaEntrada')

        .factory('adminBandejaEntradaService', function (bandejaEntradaService) {
            var interfaz = {
                obtenerPermisosUsuario: obtenerPermisosUsuario,
                obtenerPerfiles: obtenerPerfiles,
                obtenerPermisosBandejaEntrada: obtenerPermisosBandejaEntrada,
                cambiarPermiso: cambiarPermiso,
            }

            function obtenerPermisosUsuario(vm, idPerfil) {

                bandejaEntradaService.getPerfilPermisosBandejaEntrada(idPerfil).then(function (response) {
                    limpiarPermisos(vm);

                    vm.perfil = {};
                    angular.forEach(vm.perfiles, function (perfilGroup) {
                        if (perfilGroup.id == idPerfil) {
                            perfilGroup.clase = 'list-group-item-info';
                        } else {
                            perfilGroup.clase = '';
                        }

                    });
                    if (response.data.code == "00000") {
                        console.log('Consulta de permisos de usuario OK');
                        if (idPerfil == '1') {
                            vm.disabled = true;
                        } else {
                            vm.disabled = false;
                        }
                        vm.perfil.id = idPerfil;
                        vm.perfil.permisos = response.data.data;
                        angular.forEach(vm.permisos, function (permiso) {
                            angular.forEach(vm.perfil.permisos, function (perfilPermiso) {
                                if (permiso.id == perfilPermiso.id_permiso_bandeja)
                                    permiso.checked = true;
                            });
                        });
                    } else {
                        console.log('Falla en la consulta de permisos de usuario');
                        console.error(response);
                    }
                });

            }

            function limpiarPermisos(vm) {
                angular.forEach(vm.permisos, function (permiso) {
                    permiso.checked = false;
                });
            }

            function obtenerPerfiles(vm) {

                bandejaEntradaService.getAllPerfil().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Consulta de perfiles OK');
                        vm.perfiles = response.data.data;
                        vm.disabled = true;
                        loadNotificationAdminPerfil();
                    } else {
                        console.log('Falla en la consulta de perfiles');
                        console.error(response);
                    }
                });

            }

            function obtenerPermisosBandejaEntrada(vm) {

                bandejaEntradaService.getAllPermisosBandejaEntrada().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Consulta de permisos OK');
                        vm.permisos = response.data.data;
                    } else {
                        console.log('Falla en la consulta de permisos');
                        console.error(response);
                    }
                });

            }

            function cambiarPermiso(vm, idPermiso, checked) {
                if (checked == true) {
                    bandejaEntradaService.asignarPerfilPermisoBandejaEntrada(vm.perfil.id, idPermiso).then(function (response) {
                        if (response.data.code == "00000") {
                            console.log('Asignación de permisos correctamente realizada');
                            openNotificationAdminPerfil('success', 'Se ha ajustado el permiso correctamente');
                        } else {
                            console.log('Falla en la asignación de permisos');
                            openNotificationAdminPerfil('error', 'Error ajustando el permiso');
                            console.error(response);
                        }
                    });
                } else {
                    bandejaEntradaService.eliminarPerfilPermisoBandejaEntrada(vm.perfil.id, idPermiso).then(function (response) {
                        if (response.data.code == "00000") {
                            console.log('Permisos eliminados correctamente');
                            openNotificationAdminPerfil('success', 'Se ha ajustado el permiso correctamente');
                        } else {
                            console.log('Falla en la eliminación de permisos');
                            openNotificationAdminPerfil('error', 'Error ajustando el permiso');
                            console.error(response);
                        }
                    })
                }

            }

            function loadNotificationAdminPerfil() {
                $("#notificationAdminPerfil").jqxNotification({
                    width: 250, position: "top-right", opacity: 0.9,
                    autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
                });
            }

            function openNotificationAdminPerfil(template, message) {
                $("#messageNotificationAdminPerfil").text(message);
                $("#notificationAdminPerfil").jqxNotification({template: template});
                $("#notificationAdminPerfil").jqxNotification("open");
            }

            return interfaz;
        });

