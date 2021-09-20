'use strict';

angular.module('CompInformeEstabilidadSalir', [

])



    .controller('compInformeEstabilidadSalirCtrl', function ($q, informeEstabilidadSalirService) {
        var vm = this;

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

            vm.eventClickInformeEstabilidadSalir = function () {
                informeEstabilidadSalirService.eventClickInformeEstabilidadSalir(vm);
            };
        };
    })



    .component('sgmInformeEstabilidadSalir', {
        templateUrl: './views/ComponentsJS/informe-estabilidad-salir/informe-estabilidad-salir.html',
        controller: 'compInformeEstabilidadSalirCtrl',
        controllerAs: 'vm'
    });