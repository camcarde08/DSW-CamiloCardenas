'use strict';

angular.module('CompAdminUsuarioCliente', [])



        .controller('compAdminUsuarioClienteCtrl', function (adminUsuarioClienteService) {
            var vm = this;
            vm.$onInit = function () {

            };


            vm.$postLink = function () {
                adminUsuarioClienteService.getAllActiveClientes(vm);
                adminUsuarioClienteService.getAllPermisosUsuarioCliente(vm);

                vm.rowSelectedCliente = function (cliente) {
                    adminUsuarioClienteService.rowSelectedCliente(vm, cliente);
                }

                vm.eventClickCrearUsuario = function () {
                    adminUsuarioClienteService.eventClickCrearUsuario(vm);
                }

                vm.crearUsuario = function () {
                    adminUsuarioClienteService.crearUsuario(vm);
                }

                vm.eventClickEditarUsuario = function (usuarioSelected) {
                    adminUsuarioClienteService.eventClickEditarUsuario(vm, usuarioSelected);
                }

                vm.editarUsuario = function () {
                    adminUsuarioClienteService.editarUsuario(vm);
                }

                vm.eventClickFormatearContrasena = function (usuarioSelected) {
                    adminUsuarioClienteService.eventClickFormatearContrasena(vm, usuarioSelected);
                }

                vm.formatearContrasena = function () {
                    adminUsuarioClienteService.formatearContrasena(vm);
                }

                vm.eliminarUsuario = function (usuarioSelected) {
                    adminUsuarioClienteService.eliminarUsuario(vm, usuarioSelected);
                }

                vm.rowSelectedUsuarioCliente = function (usuarioSelected) {
                    adminUsuarioClienteService.rowSelectedUsuarioCliente(vm, usuarioSelected);
                }

                vm.cancelarEdicionPermisos = function () {
                    adminUsuarioClienteService.cancelarEdicionPermisos(vm);
                }

                vm.guardarPermisos = function () {
                    adminUsuarioClienteService.guardarPermisos(vm);
                }

            };
        })

        .directive("validPasswordC", function () {
            return {
                require: "ngModel",
                scope: {
                    validPasswordC: '='
                },
                link: function (scope, element, attrs, ctrl) {
                    scope.$watch(function () {
                        var combined;

                        if (scope.passwordVerify || ctrl.$viewValue) {
                            combined = scope.validPasswordC + '_' + ctrl.$viewValue;
                        }
                        return combined;
                    }, function (value) {
                        if (value) {
                            ctrl.$parsers.unshift(function (viewValue) {
                                var origin = scope.validPasswordC.$viewValue;
                                if (origin !== viewValue) {
                                    ctrl.$setValidity("validPasswordC", false);
                                    return undefined;
                                } else {
                                    ctrl.$setValidity("validPasswordC", true);
                                    return viewValue;
                                }
                            });
                        }
                    });
                }
            };
        })


        .component('sgmAdminUsuarioCliente', {
            templateUrl: './views/ComponentsJS/admin-usuario-cliente/admin-usuario-cliente.html',
            controller: 'compAdminUsuarioClienteCtrl',
            controllerAs: 'vm'
        });






