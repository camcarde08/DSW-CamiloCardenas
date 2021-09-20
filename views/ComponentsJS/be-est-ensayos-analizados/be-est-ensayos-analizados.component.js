'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeEstEnsyosAnalizadosCtrl', function ($timeout, $http, factoryBandejaEntradaService) {
            var vm = this;

            vm.pagina = 1;
            vm.cantidad = 10;

            vm.$onInit = function () {





//                while (vm.usuario == undefined) {
//                    console.log('usuario', vm.usuario);
//                }



                $timeout(function () {
                    if (vm.usuario.permisos[163]) {
                        vm.consultaTodos = 1;
                    } else {
                        vm.consultaTodos = 0;
                    }
                    vm.consultar(vm.consultaTodos, vm.usuario.userId, vm.pagina, vm.cantidad, vm.showIdMuestra, vm.duracion, vm.temperatura, vm.fechaAnalisis, vm.cliente, vm.producto, vm.numeroLote, vm.analista, vm.ensayo);
                }, 1);
            };


            vm.$postLink = function () {

            };

            vm.changeFilter = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.pagina = 1;
                vm.consultar(vm.consultaTodos, vm.usuario.userId, vm.pagina, vm.cantidad, vm.showIdMuestra, vm.duracion, vm.temperatura, vm.fechaAnalisis, vm.cliente, vm.producto, vm.numeroLote, vm.analista, vm.ensayo);
            }

            vm.changeFilter2 = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.consultar(vm.consultaTodos, vm.usuario.userId, vm.pagina, vm.cantidad, vm.showIdMuestra, vm.duracion, vm.temperatura, vm.fechaAnalisis, vm.cliente, vm.producto, vm.numeroLote, vm.analista, vm.ensayo);
            }

            vm.consultar = function (consultaTodos, idUsuario, pagina, cantidad, showIdMuestra, duracion, temperatura, fechaAnalisis, cliente, producto, numeroLote, analista, ensayo) {
                getEstEnsayosAnalizados(consultaTodos, idUsuario, pagina, cantidad, showIdMuestra, duracion, temperatura, fechaAnalisis, cliente, producto, numeroLote, analista, ensayo)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.subMuestras = response.data.subMuestras;
                            vm.setMaxPage();
                            console.log('est ensayos analizados', response);
                        })
            }


            vm.eventClickResultadosSubMuestraEstabilidad = function (submuestra) {

                var uid = vm.usuario.session.uidSession;
                window.open(vm.usuario.session.systemsParameters.externalRequestSgm2 + uid + '/159/' + submuestra.muestra.show_id_muestra);
                //console.log(vm.usuario);
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



            function getEstEnsayosAnalizados(consultaTodos, idUsuario, pagina, cantidad, showIdMuestra, duracion, temperatura, fechaAnalisis, cliente, producto, numeroLote, analista, ensayo) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getEstEnsayosAnalizados',
                        consultaTodos: consultaTodos,
                        idUsuario: idUsuario,
                        pagina: pagina,
                        cantidad: cantidad,
                        showIdMuestra: showIdMuestra,
                        duracion: duracion,
                        temperatura: temperatura,
                        fechaAnalisis: fechaAnalisis,
                        cliente: cliente,
                        producto: producto,
                        numeroLote: numeroLote,
                        analista: analista,
                        ensayo: ensayo
                    }
                });
            }

            vm.evaluarAlertaFechaCompromiso = function (fechaCompromiso) {
                return factoryBandejaEntradaService.evaluarAlertaFechaCompromiso(vm.usuario.session.systemsParameters.diasAnticipacionAlertaBandejaEntrada, fechaCompromiso);
            };


        })
        .component('sgmBeEstEnsayosAnalizados', {
            templateUrl: './views/ComponentsJS/be-est-ensayos-analizados/be-est-ensayos-analizados.html',
            controller: 'sgmBeEstEnsyosAnalizadosCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


