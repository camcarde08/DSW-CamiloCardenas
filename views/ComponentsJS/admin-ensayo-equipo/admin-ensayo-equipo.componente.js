'use strict';

angular.module('CompAdminEnsayoEquipo', [])



    .controller('compAdminEnsayoEquipoCtrl', function (adminEnsayoEquipoService) {
        var vm = this;
        var service = adminEnsayoEquipoService;
        vm.$onInit = function () {
            service.getEnsayos(vm);

        };


        vm.$postLink = function () {

            // evento seleccionar row en la grilla de metodos
            vm.SelectRowEnsayoGrid = function(index, item){
                service.SelectRowEnsayoGrid(vm,index, item);
            }

            // evento asociar equipos
            vm.clickAsociarEquipos = function(event){
                service.asociarEquipos(vm);
            }

            // evento desasociar equipos
            vm.clickDesasociarEquipos = function(event){
                service.desasociarEquipos(vm);
            }
            
        };
    })



    .component('sgmAdminEnsayoEquipo', {
        templateUrl: './views/ComponentsJS/admin-ensayo-equipo/admin-ensayo-equipo.html',
        controller: 'compAdminEnsayoEquipoCtrl',
        controllerAs: 'vm'
    });






