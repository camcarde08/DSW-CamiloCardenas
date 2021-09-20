'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasEntregaCtrl', function ($timeout, $http, factoryBandejaEntradaService) {
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

            vm.changeFilterHeaderEntrega = function () {
                vm.pagina = 1;
                vm.consultar(vm.pagina, vm.cantidad, vm.complexId, vm.producto, vm.tercero, vm.lote);
            }

            vm.changeFilterEntrega = function () {
                vm.consultar(vm.pagina, vm.cantidad, vm.complexId, vm.producto, vm.tercero, vm.lote);
            }

            vm.consultar = function (pagina, cantidad, complex_id, producto, tercero, lote) {
                factoryBandejaEntradaService.getMuestrasParaEntrega(pagina, cantidad, complex_id, producto, tercero, lote)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.muestrasEntrega = response.data.muestras;
                            vm.setMaxPage();
                        });
            }

            vm.firstPage = function () {
                vm.pagina = 1;
                vm.changeFilterEntrega();
            }

            vm.resPage = function () {
                if (vm.pagina > 1) {
                    vm.pagina--;
                    vm.changeFilterEntrega();
                }
            }

            vm.addPage = function () {
                if (vm.pagina < vm.maxPage) {
                    vm.pagina++;
                }
                vm.changeFilterEntrega();
            }

            vm.lastPage = function () {
                vm.pagina = vm.maxPage;
                vm.changeFilterEntrega();
            }

            vm.setMaxPage = function () {
                vm.maxPage = parseInt(vm.cantidadTotal / vm.cantidad);

                if (vm.cantidadTotal % vm.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            vm.eventClickActualizarFechaEntrega = function (muestraEntrega) {
                var fechaEntrega = muestraEntrega.fecha_entrega.getDate() + '-' + (muestraEntrega.fecha_entrega.getMonth() + 1) + '-' + muestraEntrega.fecha_entrega.getFullYear();
                muestraEntrega.fechaEntregaFormateada = fechaEntrega;
                factoryBandejaEntradaService.actualizarFechaEntrega(muestraEntrega).then(function (response) {
                    if (response.data.code == "00000") {
                        var indice = vm.muestrasEntrega.indexOf(muestraEntrega);
                        vm.muestrasEntrega.splice(indice, 1);
                    } else {
                        console.log('Falla en la actualización de la fecha');
                        console.error(response);
                    }
                });
            }


        })
        .component('sgmBeMuestrasEntrega', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-muestras-entrega/be-muestras-entrega.html',
            controller: 'sgmBeMuestrasEntregaCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });
