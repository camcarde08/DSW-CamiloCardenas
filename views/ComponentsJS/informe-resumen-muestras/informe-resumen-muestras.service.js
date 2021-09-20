'use strict'

angular.module('CompInformeResumenMuestras')

    .factory('informeResumenMuestrasService', function (utileService, muestraService) {
        var interfaz = {
            eventClickExcelResumenMuestra: eventClickExcelResumenMuestra
        }

        function eventClickExcelResumenMuestra(vm) {
            angular.element('#modalesperaexport').modal("show");
            muestraService.exportExcelResumenMuestra(vm.filter).then(function (response) {
                console.log(response);
                angular.element('#modalesperaexport').modal("hide");
                window.open(response.data.fileName);
            });
        }

        return interfaz;
    });


