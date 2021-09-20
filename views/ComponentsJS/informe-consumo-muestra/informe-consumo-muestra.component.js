'use strict';

angular.module('CompInformeConsumoMuestra', [

])



        .controller('compInformeConsumoMuestraCtrl', function ($q, informeConsumoMuestraService) {
            var vm = this;

            vm.$onInit = function () {
                informeConsumoMuestraService.cargarPrefijoDefecto(vm);
            };

            vm.$postLink = function () {
                vm.eventClickInformeMuestra = function () {
                    informeConsumoMuestraService.eventClickInformeMuestra(vm);
                };
            };
        })



        .component('sgmInformeConsumoMuestra', {
            templateUrl: './views/ComponentsJS/informe-consumo-muestra/informe-consumo-muestra.html',
            controller: 'compInformeConsumoMuestraCtrl',
            controllerAs: 'vm'
        });





