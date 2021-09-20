'use strict'

angular.module('CompListaReactivos')

        .factory('listaReactivosService', function () {
            var interfaz = {
                eventClickInformeReactivo: eventClickInformeReactivo
            }

            function eventClickInformeReactivo(vm) {
                $("#filtroTipo").val(vm.tipoSelected);
                console.log(vm.tipoSelected);
                window.open('', 'informeReactivo');
                $("#formInformeReactivo").submit();
            }



            return interfaz;
        });

