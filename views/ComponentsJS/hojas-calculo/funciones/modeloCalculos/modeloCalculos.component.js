'use strict'

angular.module('CompHojaCalculo')

    .controller('hojaCalculoFuncionModeloCalculoCtrl', function () {
        var vm = this;

        vm.modelocalculo = {
            id: '5',
            calculo: 'AreaMta / AreaStd x PStd / VolStd1 x AliStd1 / VolStd2 x AliStd2 / VolStd3 x PurStd / 100 x VolMta1 / PMtaxVolMta2 / AliMta1 x VolMta3 / AliMta2 x (PProm o Densd) / Ct x FeqMol x FeqConv'
        };

        vm.$onInit = function () {

        };

        vm.$postLink = function () {

        };
    })
    .component('sgmHojaCalculoFuncionModeloCalculo', {
        templateUrl: './views/ComponentsJS/hojas-calculo/funciones/modeloCalculos/modeloCalculos.html',
        controller: 'hojaCalculoFuncionModeloCalculoCtrl',
        controllerAs: 'vm',
        bindings: {
            modelocalculo: '='
        }
    });


