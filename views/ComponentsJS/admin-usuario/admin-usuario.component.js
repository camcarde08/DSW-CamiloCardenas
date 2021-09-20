'use strict';

angular.module('CompAdminUsuario', [

])

        .controller('CompAdminUsuarioCtrl', function (adminUsuarioService, usuariosService) {
            var vm = this;

            vm.$onInit = function () {
                loadNotification();
                function loadNotification() {
                    $("#notification").jqxNotification({
                        width: 250, position: "top-right", opacity: 0.9,
                        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
                    });
                }

                adminUsuarioService.consultarUsuario(vm);
                adminUsuarioService.consultarjefe(vm);
                adminUsuarioService.consultarCargo(vm);
                adminUsuarioService.consultarPerfil(vm);
            };

            vm.$postLink = function () {

            };

            vm.mostrarNotification = function (template, message) {
                $("#messageNotification").text(message);
                $("#notification").jqxNotification({template: template});
                $("#notification").jqxNotification("open");
            };

            vm.crearNuevoUsuario = function () {
                $('#createNewUsuarioModal').modal('hide');
                angular.element('#modalespera').modal('show');
                if (vm.nuevoUsuarioPassword == vm.nuevoUsuarioConfirmarPassword) {
                    usuariosService.createNewUsuario(vm.nuevoUsuarioNombre, vm.nuevoUsuarioCargo, vm.nuevoUsuarioEmail, vm.nuevoUsuarioJefe, vm.nuevoUsuarioLogin, vm.nuevoUsuarioPerfil, vm.nuevoUsuarioConfirmarPassword).then(function (response) {
                        console.log(response);
                        vm.mostrarNotification("success", "Usuario Creado Correctamente");
                        adminUsuarioService.consultarUsuario(vm);
                        vm.nuevoUsuarioNombre = null;
                        vm.nuevoUsuarioCargo = null;
                        vm.nuevoUsuarioEmail = null;
                        vm.nuevoUsuarioJefe = null;
                        vm.nuevoUsuarioLogin = null;
                        vm.nuevoUsuarioPerfil = null;
                        vm.nuevoUsuarioPassword = null;
                        vm.nuevoUsuarioConfirmarPassword = null;
                        angular.element('#modalespera').modal('hide');
                    });
                } else {
                    angular.element('#modalespera').modal('hide');
                    vm.mostrarNotification("error", "Las Contraseñas No Coinciden");
                }
            }

            vm.borrarUsuario = function (usuario) {
                usuariosService.borrarUsuario(usuario).then(function (response) {
                    console.log(response);
                    adminUsuarioService.consultarUsuario(vm);
                });
            }

            vm.showModalEspera = function () {
                angular.element('#modalespera').modal('show');
            }

            vm.createNewUsuario = function () {
                angular.element('#modalespera').modal('show');
                $('#createNewUsuarioModal').modal('show');
                angular.element('#modalespera').modal('hide');
            }

            vm.editarUsuario = function (usuario) {
                angular.element('#modalespera').modal('show');
                $('#actualizarUsuarioModal').modal('show');
                vm.actualizacionUsuarioNombre = usuario.nombre;
                vm.actualizacionUsuarioCargo = usuario.id_cargo;
                vm.actualizacionUsuarioEmail = usuario.email;
                vm.actualizacionUsuarioJefe = usuario.id_jefe;
                vm.actualizacionUsuarioLogin = usuario.login;
                vm.actualizacionUsuarioPerfil = usuario.id_perfil;
                vm.usuarioSeleccionado = usuario;

                angular.element('#modalespera').modal('hide');
            }

            vm.actualizarUsuario = function () {
                let dataActualizar = {
                    nombre: vm.actualizacionUsuarioNombre,
                    cargo: vm.actualizacionUsuarioCargo,
                    email: vm.actualizacionUsuarioEmail,
                    jefe: vm.actualizacionUsuarioJefe,
                    login: vm.actualizacionUsuarioLogin,
                    perfil: vm.actualizacionUsuarioPerfil

                };
                $('#actualizarUsuarioModal').modal('hide');
                angular.element('#modalespera').modal('show');
                console.log(dataActualizar);
                console.log(vm.usuarioSeleccionado);
                usuariosService.updateUsuario(vm.usuarioSeleccionado, dataActualizar).then(function (response) {
                    //vm.actualizar = response.data.data;
                    angular.element('#modalespera').modal('hide');
                    console.log('actualizar', response);
                    if (response.data.code == "0") {
                        adminUsuarioService.consultarUsuario(vm); 
                        adminUsuarioService.consultarjefe(vm); 
                        adminUsuarioService.consultarCargo(vm); 
                        adminUsuarioService.consultarPerfil(vm);
                        vm.mostrarNotification("success", "Usuario Actualizado Correctamente");
                    } else {
                        vm.mostrarNotification("error", "Usuario No Actualizado Correctamente");
                    }
                });
            }

            vm.editarPassword = function (usuario) {
                angular.element('#modalespera').modal('show');
                $('#actualizarPasswordModal').modal('show');
                vm.usuarioSelected = usuario;
                angular.element('#modalespera').modal('hide');
            }

            vm.actualizacionPasswordUsuario = function () {
                $('#actualizarPasswordModal').modal('hide');
                if (vm.actualizacionPassword == vm.actualizacionConfirmacionPassword) {
                    usuariosService.updatePasswordUsuario(vm.usuarioSelected, vm.actualizacionConfirmacionPassword).then(function (response) {
                        console.log(response);
                        vm.mostrarNotification("success", "Contraseña Actualizada Correctamente");
                        adminUsuarioService.consultarUsuario(vm);
                        vm.actualizacionPassword = null;
                        vm.actualizacionConfirmacionPassword = null;
                        angular.element('#modalespera').modal('hide');
                    });
                } else {
                    angular.element('#modalespera').modal('hide');
                    vm.mostrarNotification("error", "Las Contraseñas No Coinciden");
                }
            }



        })



        .component('sgmAdminUsuario', {
            templateUrl: './views/ComponentsJS/admin-usuario/admin-usuario.html',
            controller: 'CompAdminUsuarioCtrl',
            controllerAs: 'vm'
        });