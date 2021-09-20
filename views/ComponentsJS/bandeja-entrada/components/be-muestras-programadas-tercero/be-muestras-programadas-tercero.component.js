'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasProgramadasTerceroCtrl', function ($timeout, $http, factoryBandejaEntradaService) {
            var vm = this;

            vm.muestra = '';
            vm.fecha_llegada = '';
            vm.nombre_cliente = '';
            vm.producto = '';
            vm.lote = '';
            vm.ensayo = '';

            vm.pagina = 1;
            vm.cantidad = 10;

            vm.$onInit = function () {

                $timeout(function () {

                    vm.consultar(vm.pagina, vm.cantidad, vm.muestra, vm.fecha_llegada, vm.nombre_cliente, vm.producto, vm.lote, vm.ensayo);
                }, 1);
            };


            vm.$postLink = function () {

            };

            vm.changeFilter = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.pagina = 1;
                vm.consultar(vm.pagina, vm.cantidad, vm.muestra, vm.fecha_llegada, vm.nombre_cliente, vm.producto, vm.lote, vm.ensayo);
            }

            vm.changeFilter2 = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.consultar(vm.pagina, vm.cantidad, vm.muestra, vm.fecha_llegada, vm.nombre_cliente, vm.producto, vm.lote, vm.ensayo);
            }

            vm.consultar = function (pagina, cantidad, muestra, fechaLlegada, nombreCliente, producto, lote, ensayo, fechaCompromiso) {
                getMuestrasProgramadasTercero(pagina, cantidad, muestra, fechaLlegada, nombreCliente, producto, lote, ensayo, fechaCompromiso)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.muestras = response.data.muestras;
                            vm.setMaxPage();
                            console.log('muestras cliente prog', response);
                        });
            }

            vm.firstPage = function () {
                vm.pagina = 1;
                vm.changeFilter2();
            }

            vm.resPage = function () {
                if (vm.pagina > 1) {
                    vm.pagina--;
                    vm.changeFilter2();
                }
            }

            vm.addPage = function () {
                if (vm.pagina < vm.maxPage) {
                    vm.pagina++;
                }
                vm.changeFilter2();
            }

            vm.lastPage = function () {
                vm.pagina = vm.maxPage;
                vm.changeFilter2();
            }

            vm.setMaxPage = function () {
                vm.maxPage = parseInt(vm.cantidadTotal / vm.cantidad);

                if (vm.cantidadTotal % vm.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            vm.eventClickProgramarMuestra = function (idMuestra) {
                window.location.href = 'index.php?action=programacionAnalistas&idMuestra=' + idMuestra;
            }

            vm.evaluarAlertaFechaCompromiso = function (fechaCompromiso) {
                return factoryBandejaEntradaService.evaluarAlertaFechaCompromiso(vm.usuario.session.systemsParameters.diasAnticipacionAlertaBandejaEntrada, fechaCompromiso);
            };

            function getMuestrasProgramadasTercero(pagina, cantidad, muestra, fechaLlegada, nombreCliente, producto, lote, ensayo, fechaCompromiso) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getMuestrasProgramadasTercero',
                        pagina: pagina,
                        cantidad: cantidad,
                        muestra: muestra,
                        fechaLlegada: fechaLlegada,
                        nombreCliente: nombreCliente,
                        producto: producto,
                        lote: lote,
                        ensayo: ensayo,
                        fechaCompromiso: fechaCompromiso
                    }
                });
            }


        })
        .component('sgmBeMuestrasProgramadasTercero', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-muestras-programadas-tercero/be-muestras-programadas-tercero.html',
            controller: 'sgmBeMuestrasProgramadasTerceroCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });





