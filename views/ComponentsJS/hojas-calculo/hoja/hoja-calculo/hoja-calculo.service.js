'use strict'

angular.module('CompHojaCalculo')

    .factory('hojaCalculoService', function (utileService, muestraService) {
        var interfaz = {
            eventClickConsultarInformacionGeneral: eventClickConsultarInformacionGeneral,
            eventClickSaveEnsayoMuestraHojaCalculo: eventClickSaveEnsayoMuestraHojaCalculo,
            eventClickUpdateEnsayoMuestraHojaCalculo: eventClickUpdateEnsayoMuestraHojaCalculo,
            consultaFuncionesHojaCalculo: consultaFuncionesHojaCalculo

        };

        function eventClickConsultarInformacionGeneral(vm) {
            muestraService.getEnsayoMuestraInformacionGeneralHojaCalculo(vm.numEnsayoMuestra).then(function (response) {
                if (response.data.code == "00000") {
                    console.log(response);
                    vm.muestra = response.data.data[0];
                }
            });
        }

        function consultaFuncionesHojaCalculo(vm) {
            muestraService.getFuncionesHojaCalculo(vm.numEnsayoMuestra).then(function (response) {
                if (response.data.code == "00000") {
                    vm.funciones = response.data.data;
                    console.log('FUNCIONES', vm.funciones);
                }
            });
        }

        function eventClickSaveEnsayoMuestraHojaCalculo(vm) {
            console.log(vm.data);
            muestraService.saveEnsayoMuestraHojaCalculo(vm.numEnsayoMuestra, vm.data).then(function (response) {
                if (response.data.code == "00000") {
                    vm.idHojaCalculoEnsayoMuestra = response.data.data[0];
                    consultaHojaCalculoGuardada(vm);
                }
            });
        }

        function eventClickUpdateEnsayoMuestraHojaCalculo(vm) {
            console.log(vm.data);
            muestraService.updateEnsayoMuestraHojaCalculo(vm.numEnsayoMuestra, vm.data, vm.idHojaCalculoEnsayoMuestra).then(function (response) {
                if (response.data.code == "00000") {
                    consultaHojaCalculoGuardada(vm);
                }
            });
        }

        return interfaz;
    });


