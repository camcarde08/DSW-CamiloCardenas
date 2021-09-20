'use strict';

angular.module('CompInformeAnalista', [

])



        .controller('compInformeAnalistaCtrl', function ($q, informeAnalistaService) {
            var vm = this;

            vm.$onInit = function () {

                vm.ensayosMuestra = ['Realizados', 'Sin realizar'];

            };

            vm.$postLink = function () {
                informeAnalistaService.getAllActiveAnalistas(vm);
                
                vm.eventClickInformeReanalisis = function () {
                    informeAnalistaService.eventClickInformeAnalista(vm);
                };
            };
        })



        .component('sgmInformeAnalista', {
            templateUrl: './views/ComponentsJS/informe-analista/informe-analista.html',
            controller: 'compInformeAnalistaCtrl',
            controllerAs: 'vm'
        });