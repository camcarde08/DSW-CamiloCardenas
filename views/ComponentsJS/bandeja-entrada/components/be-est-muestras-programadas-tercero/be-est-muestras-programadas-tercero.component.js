'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeEstMuestrasProgramadasTerceroCtrl', function ($timeout, $http, factoryBandejaEntradaService) {
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

                    vm.consultar(vm.pagina, vm.cantidad, vm.muestra, vm.duracion, vm.temperatura, vm.nombre_cliente, vm.producto, vm.lote, vm.ensayo);
                }, 1);
            };


            vm.$postLink = function () {

            };

            vm.changeFilter = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.pagina = 1;
                vm.consultar(vm.pagina, vm.cantidad, vm.muestra, vm.duracion, vm.temperatura, vm.nombre_cliente, vm.producto, vm.lote, vm.ensayo);
            }

            vm.changeFilter2 = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.consultar(vm.pagina, vm.cantidad, vm.muestra, vm.duracion, vm.temperatura, vm.nombre_cliente, vm.producto, vm.lote, vm.ensayo);
            }

            vm.consultar = function (pagina, cantidad, muestra, duracion, temperatura, nombreCliente, producto, lote, ensayo) {
                getMuestrasEstProgramadasTercero(pagina, cantidad, muestra, duracion, temperatura, nombreCliente, producto, lote, ensayo)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.muestras = response.data.muestras;
                            vm.setMaxPage();
                            console.log('muestras cliente EST prog', response);
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

            vm.eventClickProgramarMuestra = function (subMuestra) {
                var complexIdMuestra = subMuestra.muestra.tipo_muestra.prefijo + '-' + subMuestra.muestra.custom_id;
                var uid = vm.usuario.session.uidSession;
                window.open(vm.usuario.session.systemsParameters.externalRequestSgm2 + uid + '/158/' + complexIdMuestra);
            }

            vm.evaluarAlertaFechaCompromiso = function (fechaCompromiso) {
                return factoryBandejaEntradaService.evaluarAlertaFechaCompromiso(vm.usuario.session.systemsParameters.diasAnticipacionAlertaBandejaEntrada, fechaCompromiso);
            };

            function getMuestrasEstProgramadasTercero(pagina, cantidad, muestra, duracion, temperatura, nombreCliente, producto, lote, ensayo) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getMuestrasEstProgramadasTercero',
                        pagina: pagina,
                        cantidad: cantidad,
                        muestra: muestra,
                        duracion: duracion,
                        temperatura: temperatura,
                        nombreCliente: nombreCliente,
                        producto: producto,
                        lote: lote,
                        ensayo: ensayo
                    }
                });
            }


        })
        .component('sgmBeEstMuestrasProgramadasTercero', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-est-muestras-programadas-tercero/be-est-muestras-programadas-tercero.html',
            controller: 'sgmBeEstMuestrasProgramadasTerceroCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });





