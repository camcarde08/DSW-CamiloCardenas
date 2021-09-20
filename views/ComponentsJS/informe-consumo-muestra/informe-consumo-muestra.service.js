'use strict'

angular.module('CompInformeConsumoMuestra')

        .factory('informeConsumoMuestraService', function (utileService) {
            var interfaz = {
                cargarPrefijoDefecto: cargarPrefijoDefecto,
                eventClickInformeMuestra: eventClickInformeMuestra
            }

            function cargarPrefijoDefecto(vm) {
                utileService.getSessionUserData().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.systemsParameters = response.data.data.session.systemsParameters;
                        vm.muestra = response.data.data.session.systemsParameters.defaultSearchText;
                    }
                });
            }
            function eventClickInformeMuestra(vm) {
                $("#filtroNumero").val(vm.muestra);
                window.open('', 'informeMuestra');
                $("#formInformeMuestra").submit();
            }



            return interfaz;
        });

