'use strict'

angular.module('CompInformeReanalisis')

        .factory('informeReanalisisService', function (utileService) {
            var interfaz = {
                eventClickInformeReanalisis: eventClickInformeReanalisis
            }

            function eventClickInformeReanalisis(vm) {
                $("#fechaInicio").val(utileService.getFechaDateToString(vm.fechaInicio));
                $("#fechaFin").val(utileService.getFechaDateToString(vm.fechaFin));
                $("#formInformeReanalisis").submit();
            }



            return interfaz;
        });

