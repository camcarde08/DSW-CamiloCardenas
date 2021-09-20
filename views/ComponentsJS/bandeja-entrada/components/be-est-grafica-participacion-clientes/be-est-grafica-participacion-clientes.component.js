angular.module('CompBandejaEntrada')

        .controller('sgmBeEstParticipacionClientesCtrl', function ($filter, $http, factoryBandejaEntradaService) {
            var vm = this;
            vm.labels = [];
            vm.data = [];
            vm.showInfoGeneral = false;
            vm.showDetalleReactivo = false;

            vm.form = {
                fechaInicial: new Date(),
                fechaFinal: new Date()
            }

            vm.cantidadTotalMuestras = function(){
                return vm.data.reduce(function(prev, curr){
                    return parseInt(prev,10) + parseInt(curr,10);
                });
            }

            vm.options = {
                onClick: function (event, data) {

                    const index = data[0]._index;
                    vm.selectedCliente = vm.clientes[index];
                    consultarDetalleParticipacionCliente($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'), vm.clientes[index].id)

                }
            }

            vm.backToGeneral = function(){
                vm.showInfoGeneral = true;
                vm.showDetalleCliente = false;
            }

            vm.onSubmit = function () {
                factoryBandejaEntradaService.getDatosGraficaParticipacionClientesEst($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'))
                        .then((response) => {

                            vm.labels = [];
                            vm.data = [];
                            vm.colors = [
                                '#2d1eda',
                                '#0cb700',
                                '#ffe714',
                                '#ffa514',
                                '#d481ee',
                                '#ea1e5b',
                                '#e18157',
                                '#d88125',
                                '#d48190',
                                '#83827b',
                                '#8b3737',
                                '#e6e19f',
                                '#be5512',
                                '#eca171',
                                '#b3e69c',
                                '#8ed9ec',
                                '#1c8ca8',

                                '#6b8ed6',
                                '#8d8da8',
                                '#cdc11e',
                                '#36818f',
                                '#2481ff',
                                '#1481aa',
                                '#f951bb',
                                '#a481cc',
                                '#d481dd',
                                '#83828c',
                                '#8b3748',
                                '#e6e100',
                                '#be5523',
                                '#eca182',
                                '#b3e60d',
                                '#8ed9fd',
                                '#1c8cb9',
                            ];

                            for (let cliente of response.data.data) {
                                vm.labels.push(cliente.cliente);
                                vm.data.push(cliente.cantidad);
                                //vm.colors.push('#803690');
                            }

                            vm.clientes = response.data.data;
                            vm.showInfoGeneral = true;

                        });
            }

            function consultarDetalleParticipacionCliente(fecha_inicial, fecha_final, id_cliente){
                getDetalleParticipacionCliente(fecha_inicial, fecha_final,id_cliente).then((response) => {
                    if(response.data.code == "00000") {
                        vm.showInfoGeneral = false;
                        vm.showDetalleCliente = true;
                        vm.selectedCliente.participacion = response.data.data;
                    }
                });
            }

            function getDetalleParticipacionCliente(fecha_inicial, fecha_final,id_cliente){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getDetalleParticipacionClienteEst',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final,
                        id_cliente: id_cliente
                    }
                });
            }



        })
        .component('sgmBeEstParticipacionClientes', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-est-grafica-participacion-clientes/be-est-grafica-participacion-clientes.html',
            controller: 'sgmBeEstParticipacionClientesCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


