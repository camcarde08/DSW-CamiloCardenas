'use strict';

angular.module('CompAdminEquipo', [])



        .controller('compAdminEquipoCtrl', function (adminEquipoService, utileService) {
            var vm = this;
            vm.$onInit = function () {
                vm.fechaVencidaClase = 'fecha-vencida';
                vm.fechaProximaClase = 'fecha-proxima';

            };
            vm.$postLink = function () {
                utileService.getSessionUserData().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.systemsParameters = response.data.data.session.systemsParameters;
                        adminEquipoService.getAllActiveEquipos(vm);
                    }
                });

                vm.openModalNewEquipo = function () {
                    adminEquipoService.openModalNewEquipo(vm);
                };

                vm.closeModalNewEquipo = function () {
                    $('#newEquipoModal').modal('hide');
                    $("#fecha_ult_mantenimiento1").jqxDateTimeInput({value: null});
                    $("#fecha_prox_mantenimiento1").jqxDateTimeInput({value: null});
                    $("#fecha_ult_calibracion1").jqxDateTimeInput({value: null});
                    $("#fecha_prox_calibracion1").jqxDateTimeInput({value: null});
                    $("#fecha_ult_calificacion1").jqxDateTimeInput({value: null});
                    $("#fecha_prox_calificacion1").jqxDateTimeInput({value: null});
                    vm.newEquipo = null;
                };

                vm.confirmNewEquipoModal = function () {
                    adminEquipoService.insertarEquipo(vm);
                };

                vm.openModalEditEquipo = function (equipoSelected) {
                    adminEquipoService.openModalEditEquipo(vm, equipoSelected);
                };

                vm.closeModalEditEquipo = function () {
                    $('#editEquipoSelectedModal').modal('hide');
                    vm.equipoSelected = null;
                };

                vm.confirmEditEquipoModal = function () {
                    adminEquipoService.editarEquipo(vm);
                };

                vm.eliminarEquipo = function (equipo, index) {
                    adminEquipoService.eliminarEquipo(vm, equipo, index);
                };

                vm.validarFecha = function (fecha) {
                    return utileService.validarFechaNoAplica(fecha);
                }

            };
        })



        .component('sgmAdminEquipo', {
            templateUrl: './views/ComponentsJS/admin-equipo/admin-equipo.html',
            controller: 'compAdminEquipoCtrl',
            controllerAs: 'vm'
        });






