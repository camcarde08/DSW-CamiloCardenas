'use strict';

angular.module('CompListaEstandares', [

])



        .controller('compListaEstandaresCtrl', function ($q, listaEstandaresService, estandarService) {
            var vm = this;

            vm.$onInit = function () {
                vm.tipos = [];
                estandarService.getTiposEstandar().then(function (response) {

                    angular.forEach(response.data.data, function (item, key) {
                        vm.tipos.push({id: 1, descripcion: item.tipo});
                    });
                    vm.tipos.push(
                            {id: 4, descripcion: 'Vencidos'},
                            {id: 5, descripcion: 'Finalizados'},
                            {id: 6, descripcion: 'Sin usar'});


                    console.log(vm.tipos);
                });
            };

            vm.$postLink = function () {
                vm.eventClickInformeEstandar = function () {
                    listaEstandaresService.eventClickInformeEstandar(vm);
                };
            };
        })



        .component('sgmListaEstandares', {
            templateUrl: './views/ComponentsJS/lista-estandares/lista-estandares.html',
            controller: 'compListaEstandaresCtrl',
            controllerAs: 'vm'
        });





