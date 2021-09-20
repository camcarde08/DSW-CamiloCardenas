'use strict'

angular.module('CompInformeEstadisticoMuestra')

        .factory('informeEstadisticoMuestraService', function (utileService) {
            var interfaz = {
                eventClickInformeEstadistico: eventClickInformeEstadistico
            }

            function eventClickInformeEstadistico(vm) {
                
                $("#fechaInicio").val(utileService.getFechaDateToString(vm.fechaInicio));
                $("#fechaFin").val(utileService.getFechaDateToString(vm.fechaFin));
                $("#formInformeEstadistico").submit();
            }



            return interfaz;
        });


