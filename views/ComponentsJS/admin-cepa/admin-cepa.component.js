'use strict';

angular.module('CompAdminCepa', [])



    .controller('compAdminCepaCtrl', function (adminCepaService) {
        var vm = this;
        vm.test = 'prueba';






        vm.$onInit = function () {
            vm.filter = {};
            vm.myStyle = {
                width: vm.filter.codigo,
                position: 'fixed'
            }
            vm.newLote = {
                codigo: '',
                tipo: '',
                cantidad_preparada: 0,
                lote_interno: '',
                cantidad_actual: 0,
                fecha_vencimiento: new Date(),
                fecha_ingreso: new Date(),
                fecha_apertura: new Date(),
                fecha_terminacion: new Date(),
                fecha_preparacion: new Date(),
                fecha_promocion: new Date()
            };


        };

        vm.$postLink = function () {


            // carga de cepas activas exixtentes
            adminCepaService.getAllActiveCepas(vm);

            // evento click crear nueva cepa
            vm.openModalNewCepa = function () {
                adminCepaService.openModalNewCepa(vm);
            }

            // evento cerrar ventana modal nueva cepa 
            vm.closeModalNewCepa = function () {
                adminCepaService.closeModalNewCepa(vm);
            }

            // evento confirmar creacion de nueva cepa
            vm.confirmNewCepaModal = function () {
                adminCepaService.confirmNewCepaModal(vm);
            }

            // evento editar cepa
            vm.editarCepa = function (cepa) {
                adminCepaService.editarCepa(vm, cepa);
            }

            // evento descartar cambios edicion cepa
            vm.descartarCambiosCepa = function (cepa) {
                adminCepaService.descartarCambiosCepa(vm, cepa);
            }

            // evento confirmar cambios cepa
            vm.confirmarCambiosCepa = function (cepa) {
                adminCepaService.confirmarCambiosCepa(vm, cepa);
            }

            // evento eliminar cepa 
            vm.eliminarCepa = function (cepa, index) {
                adminCepaService.eliminarCepa(vm, cepa, index);
            }

            // evento seleccionar fila grilla cepas
            vm.SelectRowCepaGrid = function (index, cepa) {
                adminCepaService.SelectRowCepaGrid(vm, index, cepa);
            }

            // evento click TD grilla lote cepa
            vm.clickTdGrillaLoteCepa = function (index, lote) {
                adminCepaService.clickTdGrillaLoteCepa(vm,index, lote);
            }

            // evento click activar lote
            vm.activarLote = function(item){
                adminCepaService.activarLote(vm);
            }

            // evento click confirmar activacion de lote
            vm.clickConfirmActivateLote = function(event){
                adminCepaService.clickConfirmActivateLote(vm);
            }

            // evento click crear nuevo lote cepa
            vm.openModalNewLote = function(){
                adminCepaService.openModalNewLote(vm);
            }

            // evento cancelar modal nuevo lote
            vm.closeModalNewLote = function(){
                adminCepaService.closeModalNewLote(vm);
            }

            // evento confirmar creacion nuevo lote cepa
            vm.confirmNewLoteModal = function(){
                adminCepaService.confirmNewLoteModal(vm);
            }




        };
    })



    .component('sgmAdminCepa', {
        templateUrl: './views/ComponentsJS/admin-cepa/admin-cepa.html',
        controller: 'compAdminCepaCtrl',
        controllerAs: 'vm'
    })


    .directive('stringToNumber', function () {
        return {
            require: 'ngModel',
            link: function (scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function (value) {
                    return '' + value;
                });
                ngModel.$formatters.push(function (value) {
                    return parseFloat(value);
                });
            }
        };
    });





