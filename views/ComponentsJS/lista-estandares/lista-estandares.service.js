'use strict'

angular.module('CompListaEstandares')

        .factory('listaEstandaresService', function () {
            var interfaz = {
                eventClickInformeEstandar: eventClickInformeEstandar
            }

            function eventClickInformeEstandar(vm) {
                if (vm.tipoSelected == null || vm.tipoSelected == '') {
                    $("#filtroTipo").val(null);
                    $("#filtroNombre").val(null);
                } else {
                    $("#filtroTipo").val(vm.tipoSelected.id);
                    $("#filtroNombre").val(vm.tipoSelected.descripcion);
                }
                console.log(vm.tipoSelected);
                window.open('', 'informeEstandar');
                $("#formInformeEstandar").submit();
            }



            return interfaz;
        });

