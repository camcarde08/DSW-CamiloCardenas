'use strict';

angular.module('CompAdminFormaFarmaceutica')

        .factory('adminFormaFarmaceuticaService', function (envaseService) {
            var interfaz = {
                consultarFormasFarmaceuticas: consultarFormasFarmaceuticas,
            }

            function consultarFormasFarmaceuticas(vm) {
                envaseService.getAllEnvase().then(function (response) {
                    console.log('FORMAS', response);
                    vm.consultaFormaFarmaceutica = response.data;
                    consultarFormasFarmaceuticasAsociadas(vm);
                });
            }

            function consultarFormasFarmaceuticasAsociadas(vm) {
                envaseService.getAllFormasFarmaceuticasAsociadas().then(function (response) {
                    console.log('ASOCIADOS', response);
                    vm.consultarFormasFarmaceuticasAsociadas = response.data;
                    angular.forEach(vm.consultaFormaFarmaceutica, function (forma) {
                        angular.forEach(vm.consultarFormasFarmaceuticasAsociadas, function (formaAsociada) {
                            if (formaAsociada.id == forma.id) {
                                forma.asociada = true;
                            }
                        })
                    })
                });
            }



            return interfaz;
        });

