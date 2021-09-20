'use strict'

angular.module('CompListaColumnas')

        .factory('listaColumnasService', function () {
            var interfaz = {
                eventClickInformeColumna: eventClickInformeColumna
            }

            function eventClickInformeColumna(vm) {
                $("#filtroTipo").val(vm.tipoSelected);
                console.log(vm.tipoSelected);
                window.open('', 'informeColumna');
                $("#formInformeColumna").submit();
            }



            return interfaz;
        });

