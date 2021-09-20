'use strict';

angular.module('CompAdminMedioCultivo', [

])



        .controller('compAdminMedioCultivoCtrl', function (adminMedioCultivoService) {
            var vm = this;





            vm.$onInit = function () {

                vm.newLote = {
                    fechaVencimiento: new Date(),
                    fechaIngreso: new Date(),
                    fechaApertura: new Date(),
                    fechaTerminacion: new Date(),
                    fechaPreparacion: new Date(),
                    fechaPromocion: new Date(),
                }
            };

            vm.$postLink = function () {

                vm.test = function (param) {
                    //alert(param);

                }
                //valores iniciales jqwidgets

                // instancias jqwidgets
                vm.instanceMessageErrorAddLote = {};
                vm.instanceMessageErrorAddLote2 = {};
                vm.instanceMessageSuccessAddLote = {};
                vm.instanceGridMediosCultivo = {};

                //consulta de los medios de cultivo.
                adminMedioCultivoService.getAllMediosCultivo(vm);

                vm.gridMediosCultivoSelectRowEvent = function (medioCultivo, index) {
                    adminMedioCultivoService.gridMediosCultivoSelectRowEvent(vm, medioCultivo, index);
                }

                vm.openModalNewMedio = function () {
                    adminMedioCultivoService.openModalNewMedio(vm);
                }
                // evento para crear servicio
                vm.clickCrearServicio = function (event) {
                    adminMedioCultivoService.clickCrearMedio(vm);
                }

                // evento para cerrar la venta modal de nuevo medio
                vm.closeModelNewMedio = function () {
                    adminMedioCultivoService.closeNewMedioModal(vm);
                }

                //
                vm.editarMedioCultivo = function (medioCultivoSelected) {
                    adminMedioCultivoService.editarMedioCultivo(vm, medioCultivoSelected);
                }

                vm.eliminarMedioCultivo = function (medioCultivo, index) {
                    adminMedioCultivoService.eliminarMedioCultivo(vm, medioCultivo, index);
                }

                vm.descartarCambiosMediosCultivo = function (medioCultivo) {
                    adminMedioCultivoService.descartarCambiosMediosCultivo(vm, medioCultivo);
                }

                vm.confirmarCambiosMediosCultivo = function (medioCultivo) {
                    adminMedioCultivoService.confirmarCambiosMediosCultivo(vm, medioCultivo);
                }

                vm.clickTdGrillaLoteMedioCultivo = function (index, lote) {
                    adminMedioCultivoService.clickTdGrillaLoteMedioCultivo(vm, index, lote);
                }

                vm.openModalNewLote = function () {
                    adminMedioCultivoService.openModalNewLote(vm);
                }
                // evento para crear lote
                vm.clickCrearLote = function () {
                    adminMedioCultivoService.clickCrearLote(vm);
                }

                vm.activarLote = function () {
                    adminMedioCultivoService.activarLote(vm);
                }
                // evento confirmar activacion de lote
                vm.clickConfirmActivateLote = function () {
                    adminMedioCultivoService.clickConfirmActivateLote(vm);
                }

                //evento desasociar cepas
                vm.clickDesasociarCepas = function (event) {
                    adminMedioCultivoService.desasociarCepas(vm);
                }

                // evento asociar cepas
                vm.clickAsociarCepas = function (event) {
                    adminMedioCultivoService.asociarCepas(vm);
                }

                // evento cancelar creacion lote
                vm.closeModalNewLote = function () {
                    vm.newLote = {
                        fechaVencimiento: new Date(),
                        fechaIngreso: new Date(),
                        fechaApertura: new Date(),
                        fechaTerminacion: new Date(),
                        fechaPreparacion: new Date(),
                        fechaPromocion: new Date(),
                    }
                    angular.element(modalNewLote).modal('hide');
                }

                vm.editarLote = function (lote) {
                    adminMedioCultivoService.editarLote(vm, lote);
                }


            };
        })



        .component('sgmAdminMedioCultivo', {
            templateUrl: './views/ComponentsJS/admin-medio-cultivo/admin-medio-cultivo.html',
            controller: 'compAdminMedioCultivoCtrl',
            controllerAs: 'vm'
        });





