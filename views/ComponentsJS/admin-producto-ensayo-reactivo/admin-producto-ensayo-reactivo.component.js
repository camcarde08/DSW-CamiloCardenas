'use strict';

angular.module('CompAdminProdEnsReactivo', [])



        .controller('compAdminProdEnsReactivoCtrl', function (adminProdEnsReactivoService) {
            var vm = this;
            vm.$onInit = function () {
                vm.reactivosDisponibles = [];
                vm.reactivosAsociados = [];

            };


            vm.$postLink = function () {
                adminProdEnsReactivoService.getAllActiveProductos(vm);
                adminProdEnsReactivoService.getAllHojasCalculo(vm);
                adminProdEnsReactivoService.getAllCondicionesCromatograficas(vm);
                adminProdEnsReactivoService.getAllColumnas(vm);

                vm.rowSelectedProducto = function (producto) {
                    adminProdEnsReactivoService.rowSelectedProducto(vm, producto);
                }

                vm.rowSelectedEnsayo = function (ensayo, paqueteEnsayo) {
                    adminProdEnsReactivoService.rowSelectedEnsayo(vm, ensayo, paqueteEnsayo);
                }

                vm.clickAsociarReactivos = function () {
                    adminProdEnsReactivoService.clickAsociarReactivos(vm);
                }

                vm.clickDesasociarReactivos = function () {
                    adminProdEnsReactivoService.clickDesasociarReactivos(vm);
                }

                vm.clickAsociarEstandares = function () {
                    adminProdEnsReactivoService.clickAsociarEstandares(vm);
                }

                vm.clickDesasociarEstandares = function () {
                    adminProdEnsReactivoService.clickDesasociarEstandares(vm);
                }

                vm.selectHojaCalculo = function () {
                    adminProdEnsReactivoService.selectHojaCalculo(vm);
                }
                vm.selectCondicionCromatografica = function () {
                    adminProdEnsReactivoService.selectCondicionCromatografica(vm);
                }
                vm.selectColumna = function () {
                    adminProdEnsReactivoService.selectColumna(vm);
                }

            };
        })



        .component('sgmAdminProductoEnsayoReactivo', {
            templateUrl: './views/ComponentsJS/admin-producto-ensayo-reactivo/admin-producto-ensayo-reactivo.html',
            controller: 'compAdminProdEnsReactivoCtrl',
            controllerAs: 'vm'
        });






