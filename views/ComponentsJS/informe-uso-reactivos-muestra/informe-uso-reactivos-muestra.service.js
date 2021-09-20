'use strict'

angular.module('CompInformeUsoReactivosMuestra')

    .factory('informeUsoReactivosMuestraService', function (utileService, reactivoService, muestraService) {
        var interfaz = {
            eventClickInformeUsoReactivosMuestra: eventClickInformeUsoReactivosMuestra,
            eventClickExcelUsoReactivosMuestra: eventClickExcelUsoReactivosMuestra,
            getReactivos: getReactivos
        }

        function getReactivos(vm) {
            reactivoService.getAllReactivosPorMuestra().then(function (response) {
                console.log('REACTIVOS', response);
                vm.reactivos = response.data.data;
            });
        }

        function eventClickInformeUsoReactivosMuestra(vm) {

            $("#idReactivos").val(vm.reactivosSelected);
            $("#fechaInicio").val(utileService.getFechaDateToString(vm.fechaInicio));
            $("#fechaFin").val(utileService.getFechaDateToString(vm.fechaFin));
            $("#formInformeUsoReactivosMuestra").submit();
        }

        function eventClickExcelUsoReactivosMuestra(vm) {
            vm.fecha_inicial = utileService.getFechaDateToString(vm.fechaInicio);
            vm.fecha_fin = utileService.getFechaDateToString(vm.fechaFin);

            muestraService.exportExcelUsoReactivosMuestra(vm.reactivosSelected, vm.fecha_inicial, vm.fecha_fin).then(function (response) {
                console.log(response);
                window.open(response.data.fileName);
            });
        }



        return interfaz;
    });


