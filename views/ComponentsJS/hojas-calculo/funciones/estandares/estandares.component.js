'use strict'

angular.module('CompHojaCalculo')

    .controller('hojaCalculoFuncionEstandarCtrl', function ($scope) {
        var vm = this;

        vm.standar = {
            id: '1',
            areas: [
                0,
                0,
                0,
                0,
                0,
            ],
            promedio: 0,
            cv: 0

        }

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };

        vm.eliminarLectura = function (keyArea) {
            vm.standar.areas.splice(keyArea, 1);
            $scope.$emit('deleteEstandarEmit', keyArea);
        }

        vm.adicionarLectura = function () {
            vm.standar.areas.push(
               {area: 0}
            );
            $scope.$emit('addEstandarEmit', '');
        };
    })
    .component('sgmHojaCalculoFuncionEstandar', {
        templateUrl: './views/ComponentsJS/hojas-calculo/funciones/estandares/estandares.html',
        controller: 'hojaCalculoFuncionEstandarCtrl',
        controllerAs: 'vm',
        bindings: {
            standar: '='
        }
    });


