'use strict';

angular.module('CompInformeUsoReactivosMuestra', [

])



    .controller('compInformeUsoReactivosMuestraCtrl', function ($q, informeUsoReactivosMuestraService) {
        var vm = this;

        vm.$onInit = function () {
            informeUsoReactivosMuestraService.getReactivos(vm);
        };

        vm.$postLink = function () {

            vm.eventClickInformeUsoReactivosMuestra = function () {
                informeUsoReactivosMuestraService.eventClickInformeUsoReactivosMuestra(vm);
            };
            vm.eventClickExcelUsoReactivosMuestra = function () {
                informeUsoReactivosMuestraService.eventClickExcelUsoReactivosMuestra(vm);
            };
        };
    })



    .component('sgmInformeUsoReactivosMuestra', {
        templateUrl: './views/ComponentsJS/informe-uso-reactivos-muestra/informe-uso-reactivos-muestra.html',
        controller: 'compInformeUsoReactivosMuestraCtrl',
        controllerAs: 'vm'
    });