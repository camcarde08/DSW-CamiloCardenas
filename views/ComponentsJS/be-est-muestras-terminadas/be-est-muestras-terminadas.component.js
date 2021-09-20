'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeEstMuestrasTerminadasCtrl', function ($timeout, $http) {
            var vm = this;
    
            vm.show_id_muestra = '';
            vm.duracion = '';
            vm.temperatura = '';
            vm.fecha_analisis = '';

            vm.pagina = 1;
            vm.cantidad = 10;

            vm.$onInit = function () {

                $timeout(function () {
                    
                    vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.duracion, vm.temperatura, vm.fecha_analisis);
                }, 1);
            };


            vm.$postLink = function () {

            };

            vm.changeFilter = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.pagina = 1;
                vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.duracion, vm.temperatura, vm.fecha_analisis);
            }
            
            vm.changeFilter2 = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.duracion, vm.temperatura, vm.fecha_analisis);
            }

            vm.consultar = function (pagina, cantidad, show_id_muestra, duracion, temperatura, fecha_analisis) {
                getEstMuestrasTerminadas(pagina, cantidad, show_id_muestra, duracion, temperatura, fecha_analisis)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.subMuestras = response.data.subMuestras;
                            vm.setMaxPage();
                            //console.log('est muestras terminadas', response);
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



            function getEstMuestrasTerminadas(pagina, cantidad, show_id_muestra, duracion, temperatura, fecha_analisis) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getEstMuestrasTerminadas',
                        pagina: pagina,
                        cantidad: cantidad,
                        show_id_muestra: show_id_muestra,
                        duracion: duracion,
                        temperatura: temperatura,
                        fecha_analisis: fecha_analisis
                    }
                });
            }


        })
        .component('sgmBeEstMuestrasTerminadas', {
            templateUrl: './views/ComponentsJS/be-est-muestras-terminadas/be-est-muestras-terminadas.html',
            controller: 'sgmBeEstMuestrasTerminadasCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


