'use strict'

angular.module('CompInformeEstabilidadSalir')

    .factory('informeEstabilidadSalirService', function (utileService) {
        var interfaz = {
            eventClickInformeEstabilidadSalir: eventClickInformeEstabilidadSalir
        }

        function eventClickInformeEstabilidadSalir(vm) {

            $("#fechaInicio").val(utileService.getFechaDateToString(vm.fechaInicio));
            $("#fechaFin").val(utileService.getFechaDateToString(vm.fechaFin));
            $("#formInformeEstabilidadSalir").submit();
        }



        return interfaz;
    });


