'use strict';

angular.module('CompListaColumnas', [

])



        .controller('compListaColumnasCtrl', function ($q, listaColumnasService) {
            var vm = this;

            vm.$onInit = function () {
                vm.tipos = [
                ];
            };

            vm.$postLink = function () {
                vm.eventClickInformeColumna = function () {
                    listaColumnasService.eventClickInformeColumna(vm);
                };
            };
        })



        .component('sgmListaColumnas', {
            templateUrl: './views/ComponentsJS/lista-columnas/lista-columnas.html',
            controller: 'compListaColumnasCtrl',
            controllerAs: 'vm'
        });





