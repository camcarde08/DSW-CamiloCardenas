'use strict';

angular.module('CompHistoricoEstados', [

])



    .controller('compHistoricoEstadosCtrl', function ($q, historicoEstadosService, muestraService) {
        var vm = this;

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };

        vm.consultaMuestraAuditoria = function () {
            angular.element('#modalespera').modal('show');
            muestraService.consultaMuestraAuditoria(vm.muestra).then(function (response) {
                if (response.data.code == '00000') {
                    vm.historicoEstadosMuestra = response.data.data;
                    console.log('HOLA', vm.historicoEstadosMuestra);
                    angular.element('#modalespera').modal('hide');
                } else {
                    angular.element('#modalespera').modal('hide');
                    openNotificationAdminPerfil('error', 'Error');
                }
            });

        }

        vm.regresarHistoricoEstados = function () {
            angular.element(auditoriaMuestraModal).modal("hide");
            vm.selectedMuestraDetalle = null;
        }

        vm.limpiar = function () {
            vm.muestra = null;
            vm.historicoEstadosMuestra = null;
            vm.selectedMuestraDetalle = null;
        }

        vm.selectedMuestraAud = function (auditoria) {
            console.log(auditoria);
            angular.element(auditoriaMuestraModal).modal("show");
            vm.selectedMuestraDetalle = auditoria;
            muestraService.consultaAuditoriaMuestraDetallada(auditoria.id).then(function (response) {
                if (response.data.code == '00000') {
                    vm.muestraHistoricoEstadosDetallado = response.data.data[0];
                    console.log('DETALLE', vm.muestraHistoricoEstadosDetallado);
                } else {
                    openNotificationAdminPerfil('error', 'Error');
                }
            });
        }

        vm.loadNotificationAdminPerfil = function () {
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
    })



    .component('sgmHistoricoEstados', {
        templateUrl: './views/ComponentsJS/historico-estados/historico-estados.html',
        controller: 'compHistoricoEstadosCtrl',
        controllerAs: 'vm'
    });