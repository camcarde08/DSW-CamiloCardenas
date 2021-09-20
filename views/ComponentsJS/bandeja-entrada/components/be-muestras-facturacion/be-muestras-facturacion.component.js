'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasFacturacionCtrl', function ($filter, $timeout, $http, factoryBandejaEntradaService) {
            var vm = this;



            vm.$onInit = function () {

                $timeout(function () {
                    vm.complexId = '';
                    vm.producto = '';
                    vm.tercero = '';
                    vm.lote = '';
                    vm.pagina = 1;
                    vm.cantidad = 10;
                    vm.consultar(vm.pagina, vm.cantidad, vm.complexId, vm.producto, vm.tercero, vm.lote);
                }, 1);

            };


            vm.$postLink = function () {

            };

            vm.changeFilterHeaderFacturacion = function () {
                vm.pagina = 1;
                vm.consultar(vm.pagina, vm.cantidad, vm.complexId, vm.producto, vm.tercero, vm.lote);
            }

            vm.changeFilterFacturacion = function () {
                vm.consultar(vm.pagina, vm.cantidad, vm.complexId, vm.producto, vm.tercero, vm.lote);
            }

            vm.consultar = function (pagina, cantidad, complex_id, producto, tercero, lote) {
                factoryBandejaEntradaService.getMuestrasParaFacturacion(pagina, cantidad, complex_id, producto, tercero, lote)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.muestrasFacturacion = response.data.muestras;
                            vm.setMaxPage();
                        });
            }

            vm.firstPage = function () {
                vm.pagina = 1;
                vm.changeFilterFacturacion();
            }

            vm.resPage = function () {
                if (vm.pagina > 1) {
                    vm.pagina--;
                    vm.changeFilterFacturacion();
                }
            }

            vm.addPage = function () {
                if (vm.pagina < vm.maxPage) {
                    vm.pagina++;
                }
                vm.changeFilterFacturacion();
            }

            vm.lastPage = function () {
                vm.pagina = vm.maxPage;
                vm.changeFilterFacturacion();
            }

            vm.setMaxPage = function () {
                vm.maxPage = parseInt(vm.cantidadTotal / vm.cantidad);

                if (vm.cantidadTotal % vm.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            vm.eventClickActualizarNumFactura = function (muestraFacturacion) {
                muestraFacturacion.fecha_facturacion_format = $filter('date')(muestraFacturacion.fecha_facturacion, 'yyyy-MM-dd')
                factoryBandejaEntradaService.actualizarNumeroFactura(muestraFacturacion).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización factura OK');
                        var indice = vm.muestrasFacturacion.indexOf(muestraFacturacion);
                        vm.muestrasFacturacion.splice(indice, 1);
                    } else {
                        console.log('Falla en la actualización de factura');
                        console.error(response);
                    }
                });
            }


        })
        .component('sgmBeMuestrasFacturacion', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-muestras-facturacion/be-muestras-facturacion.html',
            controller: 'sgmBeMuestrasFacturacionCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });
