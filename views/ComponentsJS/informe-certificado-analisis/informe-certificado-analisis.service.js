'use strict'

angular.module('CompInformeCertificadoAnalisis')

        .factory('informeCertificadoAnalisisService', function (utileService) {
            var interfaz = {
                cargarPrefijoDefecto: cargarPrefijoDefecto,
                eventClickInformeCertificado: eventClickInformeCertificado
            }

            function cargarPrefijoDefecto(vm) {
                utileService.getSessionUserData().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.systemsParameters = response.data.data.session.systemsParameters;
                        vm.muestra = response.data.data.session.systemsParameters.defaultSearchText;
                    }
                });
            }
            function eventClickInformeCertificado(vm) {
                $("#filtroNumero").val(vm.muestra);
                window.open('', 'informeCertificado');
                $("#formInformeCertificado").submit();
            }



            return interfaz;
        });