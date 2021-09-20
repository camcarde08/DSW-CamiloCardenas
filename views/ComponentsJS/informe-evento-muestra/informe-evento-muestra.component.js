'use strict';

angular.module('CompInformeEventoMuestra', [

])



        .controller('compInformeEventoMuestraCtrl', function ($q, informeEventoMuestraService) {
            var vm = this;

            vm.$onInit = function () {
                informeEventoMuestraService.cargarPrefijoDefecto(vm);
            };

            vm.$postLink = function () {
                vm.eventClickInformeMuestra = function () {
                    informeEventoMuestraService.eventClickInformeMuestra(vm);
                };
            };
        })



        .component('sgmInformeEventoMuestra', {
            templateUrl: './views/ComponentsJS/informe-evento-muestra/informe-evento-muestra.html',
            controller: 'compInformeEventoMuestraCtrl',
            controllerAs: 'vm'
        });





