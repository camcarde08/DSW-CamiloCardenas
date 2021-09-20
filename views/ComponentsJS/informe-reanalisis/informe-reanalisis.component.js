'use strict';

angular.module('CompInformeReanalisis', [

])



        .controller('compInformeReanalisisCtrl', function ($q, informeReanalisisService) {
            var vm = this;

            vm.$onInit = function () {
            };

            vm.$postLink = function () {
                vm.eventClickInformeReanalisis = function () {
                    informeReanalisisService.eventClickInformeReanalisis(vm);
                };
            };
        })



        .component('sgmInformeReanalisis', {
            templateUrl: './views/ComponentsJS/informe-reanalisis/informe-reanalisis.html',
            controller: 'compInformeReanalisisCtrl',
            controllerAs: 'vm'
        });





