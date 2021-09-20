'use strict';

angular.module('CompInformeOcupacionAnalista', [

])



        .controller('compInformeOcupacionAnalistaCtrl', function ($q, informeOcupacionAnalistaService) {
            var vm = this;

            vm.$onInit = function () {

            };

            vm.$postLink = function () {
                informeOcupacionAnalistaService.getAllActiveAnalistas(vm);
                
                vm.eventClickInformeReanalisis = function () {
                    informeOcupacionAnalistaService.eventClickInformeOcupacionAnalista(vm);
                };
            };
        })



        .component('sgmInformeOcupacionAnalista', {
            templateUrl: './views/ComponentsJS/informe-ocupacion-analista/informe-ocupacion-analista.html',
            controller: 'compInformeOcupacionAnalistaCtrl',
            controllerAs: 'vm'
        });