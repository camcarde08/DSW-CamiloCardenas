'use strict';

angular.module('CompInformeEstadisticoMuestra', [

])



        .controller('compInformeEstadisticoMuestraCtrl', function ($q, informeEstadisticoMuestraService) {
            var vm = this;

            vm.$onInit = function () {

            };

            vm.$postLink = function () {
                
                vm.eventClickInformeEstadistico = function () {
                    informeEstadisticoMuestraService.eventClickInformeEstadistico(vm);
                };
            };
        })



        .component('sgmInformeEstadisticoMuestra', {
            templateUrl: './views/ComponentsJS/informe-estadistico-muestra/informe-estadistico-muestra.html',
            controller: 'compInformeEstadisticoMuestraCtrl',
            controllerAs: 'vm'
        });