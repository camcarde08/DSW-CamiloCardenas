'use strict';

angular.module('CompAdminTercero', [])

        .controller('compAdminTerceroCtrl', function (terceroService) {
            var vm = this;

            vm.$onInit = function () {

            };

            vm.$postLink = function () {
                getAllClientes();
                getTipoIdentificaciones();
                getCiudades();
                loadNotification();

                vm.rowSelectedCliente = function (cliente) {
                    vm.clienteSelected = cliente;
                    angular.forEach(vm.clientes, function (value, key) {
                        value.id == cliente.id ? value.selected = true : value.selected = false;
                    });
                }

                vm.actualizarCliente = function () {
                    vm.waitModalText = 'Cargando datos, un momento por favor ...';
                    $('#waitModal').modal('show');
                    vm.clienteSelected.fecha_contrato_temp = vm.clienteSelected.fecha_contrato !== undefined
                            && vm.clienteSelected.fecha_contrato !== null
                            ? formatearFecha(vm.clienteSelected.fecha_contrato) : null;
                    vm.clienteSelected.fecha_vencimiento_contrato_temp = vm.clienteSelected.fecha_vencimiento_contrato !== undefined
                            && vm.clienteSelected.fecha_vencimiento_contrato !== null
                            ? formatearFecha(vm.clienteSelected.fecha_vencimiento_contrato) : null;
                    terceroService.actualizarCliente(vm.clienteSelected).then(function (response) {
                        if (response.data.code === '00000') {
                            openNotification('success', 'Cliente actualizado satisfactoriamente');
                        }
                        vm.clienteSelected = null;
                        $('#waitModal').modal('hide');
                    });
                }

                vm.openModalNewCliente = function () {
                    $('#newTerceroModal').modal('show');
                }

                vm.closeModalNewTercero = function () {
                    vm.newCliente = null;
                    $('#newTerceroModal').modal('hide');
                }

                vm.confirmNewTerceroModal = function () {
                    $('#newTerceroModal').modal('hide');
                    vm.waitModalText = 'Creando cliente, un momento por favor ...';
                    $('#waitModal').modal('show');
                    console.log(vm.newCliente.fecha_contrato);
                    vm.newCliente.fecha_contrato_temp = vm.newCliente.fecha_contrato !== undefined
                            && vm.newCliente.fecha_contrato !== null
                            ? formatearFecha(vm.newCliente.fecha_contrato) : null;
                    vm.newCliente.fecha_vencimiento_contrato_temp = vm.newCliente.fecha_vencimiento_contrato !== undefined
                            && vm.newCliente.fecha_vencimiento_contrato !== null
                            ? formatearFecha(vm.newCliente.fecha_vencimiento_contrato) : null;
                    terceroService.insertarCliente(vm.newCliente).then(function (response) {
                        if (response.data.code === '00000') {
                            openNotification('success', 'Cliente creado satisfactoriamente');
                            getAllClientes();
                        }
                        $('#waitModal').modal('hide');
                    });
                }

                vm.openModalContactos = function () {
                    terceroService.consultarContactosCliente(vm.clienteSelected.id).then(function (response) {
                        if (response.data.code === '00000') {
                            vm.clienteSelected.contactos = response.data.data;
                            $('#contactosModal').modal('show');
                        }
                        $('#waitModal').modal('hide');
                    });
                }

                vm.adicionarContacto = function () {
                    var objContacto = {
                        nombre: '',
                        cargo: '',
                        area: '',
                        telefono: '',
                        movil: '',
                        extension: '',
                        email: '',
                        preferencias: ''
                    };

                    vm.clienteSelected.contactos.push(objContacto);
                }

                vm.guardarContactos = function () {
                    terceroService.actualizarCrearContactos(vm.clienteSelected.contactos, vm.clienteSelected.id).then(function (response) {
                        if (response.data.code === '00000') {
                            $('#contactosModal').modal('hide');
                            openNotification('success', 'Contactos actualizados satisfactoriamente');
                        }
                    });
                }

                function formatearFecha(fecha) {
                    fecha = new Date(fecha);
                    var fechaString = fecha.getFullYear() + '-' + (fecha.getMonth() + 1) + '-' + fecha.getDate();
                    return fechaString;
                }

                function getAllClientes() {
                    vm.waitModalText = 'Consultando clientes, un momento por favor ...';
                    $('#waitModal').modal('show');
                    terceroService.getClientesActivos().then(function (response) {
                        if (response.data.code === '00000') {
                            vm.clientes = response.data.data;
                            $('#waitModal').modal('hide');
                        }
                    });
                }

                function getTipoIdentificaciones() {
                    terceroService.getTipoIdentificaciones().then(function (response) {
                        if (response.data.code === '00000') {
                            vm.identificaciones = response.data.data;
                        }
                    });
                }

                function getCiudades() {
                    terceroService.getCiudades().then(function (response) {
                        if (response.data.code === '00000') {
                            vm.ciudades = response.data.data;
                        }
                    });
                }

                function openNotification(template, message) {
                    $("#messageNotification").text(message);
                    $("#notification").jqxNotification({template: template});
                    $("#notification").jqxNotification("open");
                }

                function loadNotification() {
                    $("#notification").jqxNotification({
                        width: 250, position: "top-right", opacity: 0.9,
                        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
                    });
                }
            };
        })

        .component('sgmAdminTercero', {
            templateUrl: './views/ComponentsJS/admin-tercero/admin-tercero.html',
            controller: 'compAdminTerceroCtrl',
            controllerAs: 'vm'
        })
