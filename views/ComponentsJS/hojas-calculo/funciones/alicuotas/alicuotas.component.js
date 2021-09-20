'use strict'

angular.module('CompHojaCalculo')

    .controller('hojaCalculoFuncionAlicuotaCtrl', function ($scope) {
        var vm = this;

        vm.pesos = ['g', 'mg', 'mL', '%'];

        vm.alicuotas = {
            id: '6',
            estandares: [
                {volumen: 0, cantidad: ''},
                {volumen: 0, cantidad: ''},
                {volumen: 0, cantidad: ''},
                {volumen: 0, cantidad: ''},
                {volumen: 0, cantidad: ''}
            ],
            aluciotasEstandar: [
                {alicuota: 0, cantidad: ''},
                {alicuota: 0, cantidad: ''},
                {alicuota: 0, cantidad: ''},
                {alicuota: 0, cantidad: ''}
            ],
            factorDilucionEstandar: {factor: 0},
            muestras: [
                {volumen: 0, cantidad: ''},
                {volumen: 0, cantidad: ''},
                {volumen: 0, cantidad: ''},
            ],
            aluciotasMuestra: [
                {alicuota: 0, cantidad: ''},
                {alicuota: 0, cantidad: ''}
            ],
            factorDilucionMuestra: {factor: 0},
        }

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };

        $scope.$on('deleteEstandarAlicuotaEmit', function(event, keyDato){
            vm.alicuotas.estandares.splice(keyDato, 1);
            vm.alicuotas.aluciotasEstandar.splice(keyDato - 1, 1);
        });

        $scope.$on('deleteMuestraAlicuotaEmit', function(event, keyDato){
            vm.alicuotas.muestras.splice(keyDato, 1);
            vm.alicuotas.aluciotasMuestra.splice(keyDato - 1, 1);
        });

        $scope.$on('addMuestraAlicuotaEmit', function(event, data){
            vm.alicuotas.muestras.push(
                {muestraVolumen: 0, cantidad: ''}
            );
            vm.alicuotas.aluciotasMuestra.push(
                {muestraAlicuota: 0, cantidad: ''}
            );
        });

        $scope.$on('addEstandarAlicuotaEmit', function(event, data){
            vm.alicuotas.estandares.push(
                {estandarVolumen: 0, cantidad: ''}
            );
            vm.alicuotas.aluciotasEstandar.push(
                {estandarAlicuota: 0, cantidad: ''}
            );
        });
    })
    .component('sgmHojaCalculoFuncionAlicuota', {
        templateUrl: './views/ComponentsJS/hojas-calculo/funciones/alicuotas/alicuotas.html',
        controller: 'hojaCalculoFuncionAlicuotaCtrl',
        controllerAs: 'vm',
        bindings: {
            alicuotas: '='
        }
    });


