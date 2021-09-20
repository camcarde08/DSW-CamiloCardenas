'use strict';

angular.module('CompAdminEnvase')

        .factory('adminEnvaseService', function (empaqueService) {
            var interfaz = {
                consultarEnvases: consultarEnvases
            }

            function consultarEnvases(vm) {
                empaqueService.getAllEmpaque().then(function (response) {
                    console.log('EMPAQUES', response);
                    vm.consultaEnvases = response.data;
                    consultarEnvasesAsociados(vm);
                });
            }

            function consultarEnvasesAsociados(vm) {
                empaqueService.getAllEmpaqueAsociado().then(function (response) {
                    console.log('ASOCIADOS', response);
                    vm.consultaEnvasesAsociados = response.data;
                    angular.forEach(vm.consultaEnvases, function (envase) {
                        angular.forEach(vm.consultaEnvasesAsociados, function (envaseAsociado) {
                            if (envaseAsociado.id == envase.id) {
                                envase.asociado = true;
                            }
                        })
                    })
                });
            }



            return interfaz;
        });


