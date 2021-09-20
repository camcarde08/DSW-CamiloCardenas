'use strict';

angular.module('CompListaReactivos', [

])



        .controller('compListaReactivosCtrl', function ($q, listaReactivosService) {
            var vm = this;

            vm.$onInit = function () {
                vm.tipos = [
                    {id: 4, descripcion: 'Vencidos'},
                    {id: 5, descripcion: 'Finalizados'},
                    {id: 6, descripcion: 'Sin usar'}
                ];
            };

            vm.$postLink = function () {
                vm.eventClickInformeReactivo = function () {
                    listaReactivosService.eventClickInformeReactivo(vm);
                };
            };
        })



        .component('sgmListaReactivos', {
            templateUrl: './views/ComponentsJS/lista-reactivos/lista-reactivos.html',
            controller: 'compListaReactivosCtrl',
            controllerAs: 'vm'
        });





