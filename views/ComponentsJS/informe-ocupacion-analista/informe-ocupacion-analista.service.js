'use strict'

angular.module('CompInformeOcupacionAnalista')

        .factory('informeOcupacionAnalistaService', function (utileService, usuariosService) {
            var interfaz = {
                getAllActiveAnalistas: getAllActiveAnalistas,
                eventClickInformeOcupacionAnalista: eventClickInformeOcupacionAnalista
            }

            function getAllActiveAnalistas(vm) {
                usuariosService.getAllActiveAnalistas().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.analistas = response.data.data;
                    } else {
                        console.log('falla en la carga de analistas');
                        console.error(response);
                    }
                });
            }

            function eventClickInformeOcupacionAnalista(vm) {
                if (vm.ensayoMuestra == 'Realizados'){
                    vm.ensayoMuestraId = 1;
                } else {
                    vm.ensayoMuestraId = 0;
                }
                
                $("#fechaInicio").val(utileService.getFechaDateToString(vm.fechaInicio));
                $("#fechaFin").val(utileService.getFechaDateToString(vm.fechaFin));
                $("#idAnalista").val(vm.analista);
                $("#formInformeOcupacionAnalista").submit();
            }



            return interfaz;
        });


