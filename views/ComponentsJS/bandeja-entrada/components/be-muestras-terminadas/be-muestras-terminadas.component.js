'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasTerminadasCtrl', function ($timeout, $http) {
            var vm = this;
    
            vm.show_id_muestra = '';
            vm.duracion = '';
            vm.temperatura = '';
            vm.fecha_analisis = '';
            vm.producto = '';
            vm.cliente = '';
            vm.lote = '';
            vm.fecha_llegada = '';
            vm.fecha_conclusion = '';
            vm.fecha_entrega = '';

            vm.pagina = 1;
            vm.cantidad = 10;

            vm.$onInit = function () {

                $timeout(function () {
                    
                    vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.producto
                    , vm.cliente, vm.lote, vm.fecha_llegada, vm.fecha_conclusion, vm.fecha_entrega);
                }, 1);
            };


            vm.$postLink = function () {

            };

            vm.changeFilter = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.pagina = 1;
                vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.producto
                    , vm.cliente, vm.lote, vm.fecha_llegada, vm.fecha_conclusion, vm.fecha_entrega);
            }
            
            vm.changeFilter2 = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.producto
                    , vm.cliente, vm.lote, vm.fecha_llegada, vm.fecha_conclusion, vm.fecha_entrega);
            }

            vm.consultar = function (pagina, cantidad, show_id_muestra, producto, cliente, lote, fecha_llegada, fecha_conclusion, fecha_entrega) {
                getMuestrasTerminadas(pagina, cantidad, show_id_muestra, producto, cliente, lote, fecha_llegada, fecha_conclusion, fecha_entrega)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.muestras = response.data.muestras;
                            vm.setMaxPage();
                            console.log('muestras terminadas2', response);
                        });
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



            function getMuestrasTerminadas(pagina, cantidad, show_id_muestra, producto, cliente, lote, fecha_llegada, fecha_conclusion, fecha_entrega) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getMuestrasTerminadas',
                        pagina: pagina,
                        cantidad: cantidad,
                        show_id_muestra: show_id_muestra,
                        producto: producto,
                        cliente: cliente,
                        lote: lote,
                        fecha_llegada: fecha_llegada,
                        fecha_conclusion: fecha_conclusion,
                        fecha_entrega: fecha_entrega
                    }
                });
            }


        })
        .component('sgmBeMuestrasTerminadas', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-muestras-terminadas/be-muestras-terminadas.html',
            controller: 'sgmBeMuestrasTerminadasCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });





