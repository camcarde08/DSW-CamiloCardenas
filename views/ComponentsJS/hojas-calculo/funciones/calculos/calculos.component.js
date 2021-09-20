'use strict'

angular.module('CompHojaCalculo')

    .controller('hojaCalculoFuncionCalculoCtrl', function ($scope) {
        var vm = this;

        vm.calculos = {
            id: '3',
            calculos: [
                {mg: 0, porcentaje: 0, porcentajeBh: 0, porcentajeBs: 0},
                {mg: 0, porcentaje: 0, porcentajeBh: 0, porcentajeBs: 0},
                {mg: 0, porcentaje: 0, porcentajeBh: 0, porcentajeBs: 0}

            ],
            promedios: [
                {promedio: 0, cv: 0},
                {promedio: 0, cv: 0},
                {promedio: 0, cv: 0},
                {promedio: 0, cv: 0}
            ]
        }

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };

        $scope.$on('deleteMuestraCalculoEmit', function(event, keyCalculo){
            vm.calculos.calculos.splice(keyCalculo, 1);
        });

        $scope.$on('addMuestraCalculoEmit', function(event, data){
            vm.calculos.calculos.push(
                {mg: 0, porcentaje: 0, porcentajeBh: 0, porcentajeBs: 0}
            );
        });

    })
    .component('sgmHojaCalculoFuncionCalculo', {
        templateUrl: './views/ComponentsJS/hojas-calculo/funciones/calculos/calculos.html',
        controller: 'hojaCalculoFuncionCalculoCtrl',
        controllerAs: 'vm',
        bindings: {
            calculos: '='
        }
    });