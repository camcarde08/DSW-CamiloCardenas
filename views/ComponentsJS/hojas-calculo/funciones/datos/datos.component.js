'use strict'

angular.module('CompHojaCalculo')

    .controller('hojaCalculoFuncionDatoCtrl', function ($scope) {
        var vm = this;

        vm.pesos = ['g', 'mg', 'mL', '%'];

        vm.pesosProm = ['mg/Cap', 'mg/Tab', '%', 'g/mL', 'No Aplica'];

        vm.pureza = ['%', 'ug/mg', 'mg/g'];

        vm.cantidadTeorica = ['mg/Cap', 'mg/Tab', 'mg/100mL', 'mg/mL', 'mg/g', 'g/100g', '%', 'g/100mL'];

        vm.conversiones = [
            {nombre: 'mg a g', value: 1000},
            {nombre: 'g a mg', value: 0.001},
            {nombre: 'No Aplica', value: 1}
        ];

        vm.datos = {
            id: '4',
            pesoEstandar: {peso: 0, cantidad: ''},
            purezaEstandar: {pureza: 0, cantidad: ''},
            cantidadTeorica: {porcentaje: 0, cantidad: ''},
            factorEquivalenciaConversion: {factor: 0, cantidad: ''},
            muestras: [
                {muestra: 0, cantidad: ''},
                {muestra: 0, cantidad: ''},
                {muestra: 0, cantidad: ''}
            ],
            loteEstandar: {lote: 0},
            pesoMolecularSal: {peso: 0, cantidad: 'mg/mol'},
            pesoMolecularBase: {peso: 0, cantidad: 'mg/mol'},
            factorEquivalenciaPeso: {factor: 0},
            factorDilucion: {factor: 0},
            pesoPromedio: {peso: 0, cantidad: ''},
            humedad: {humedad: 0, cantidad: ''},
        }

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };

        $scope.$on('deleteMuestraDatoEmit', function(event, keyDato){
            vm.datos.muestras.splice(keyDato, 1);
        });

        $scope.$on('addMuestraDatoEmit', function(event, data){
            vm.datos.muestras.push(
                {muestra: 0, cantidad: ''}
            );
        });
    })
    .component('sgmHojaCalculoFuncionDato', {
        templateUrl: './views/ComponentsJS/hojas-calculo/funciones/datos/datos.html',
        controller: 'hojaCalculoFuncionDatoCtrl',
        controllerAs: 'vm',
        bindings: {
            datos: '='
        }
    });


