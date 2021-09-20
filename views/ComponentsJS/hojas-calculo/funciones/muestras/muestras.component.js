'use strict'

angular.module('CompHojaCalculo')

    .controller('hojaCalculoFuncionMuestraCtrl', function ($scope) {
        var vm = this;

        vm.muestras = {
            id: '2',
            muestras: [
                {
                    label: 'M1',
                    areas: [0,0],
                    promedio: 0,
                    cv: 0
                },
                {
                    label: 'M2',
                    areas: [0,0],
                    promedio: 0,
                    cv: 0
                },
                {
                    label: 'M3',
                    areas: [0,0],
                    promedio: 0,
                    cv: 0
                }]
        };

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };

        vm.adicionarmuestra = function() {
            vm.muestras.muestras.push(
                {
                    label: 'M' + (vm.muestras.muestras.length + 1),
                    areas: vm.muestras.muestras[0].areas.map(function (a) {
                        return a;
                    }),
                    promedio: 0,
                    cv: 0
                });
            $scope.$emit('addMuestraEmit', '');
        };

        vm.eliminarLecturaMuestra = function (keyArea) {
            vm.muestras.muestras.forEach( function(muestra){
                muestra.areas.splice(keyArea, 1);
            });
        };

        vm.eliminarMuestra = function (muestra) {
            var variableMuestra = '';
            variableMuestra = vm.muestras.muestras.findIndex(function(item){
                return item == muestra;
            });
            $scope.$emit('deleteMuestraEmit', variableMuestra);
            vm.muestras.muestras.splice(variableMuestra, 1);
        };

        vm.adicionarLecturaMuestra = function () {
            vm.muestras.muestras.forEach( function(muestra){
                muestra.areas.push(0);
            });
        };
    })
    .component('sgmHojaCalculoFuncionMuestra', {
        templateUrl: './views/ComponentsJS/hojas-calculo/funciones/muestras/muestras.html',
        controller: 'hojaCalculoFuncionMuestraCtrl',
        controllerAs: 'vm',
        bindings: {
            muestras: '='
        }
    });


