angular.module('CompBandejaEntrada')

        .controller('sgmBeGraficaDesempenoAnalistasCtrl', function ($filter, factoryBandejaEntradaService) {
            var vm = this;
            vm.showInfoGeneral = false;
            vm.showDetalleAnalista = false;
            vm.selectedAnalista = null;
            vm.labels = [];
            vm.data = [];

            vm.form = {
                fechaInicial: new Date(),
                fechaFinal: new Date()
            }

            vm.options = {
                onClick: function (event, data) {

                    const index = data[0]._index;

                    vm.selectedAnalista = vm.analistas[index];
                    consultarDetalleDesempenoAnalista($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'), vm.selectedAnalista.id_analista)

                }
            }

            vm.cantidadTotalMuestras = function () {
                return vm.data.reduce(function (prev, curr) {
                    return parseInt(prev, 10) + parseInt(curr, 10);
                });
            }

            vm.backToGeneral = function () {
                vm.showInfoGeneral = true;
                vm.showDetalleAnalista = false;
            }

            vm.onSubmit = function () {
                factoryBandejaEntradaService.getDatosGraficaDesempenoAnalistas($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'))
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
                            vm.analistas = response.data.data;
                            for (let analista of response.data.data) {
                                vm.labels.push(analista.nombre);
                                vm.data.push(analista.cantidad);

                            }
                            vm.showInfoGeneral = true;



                        });
            }



            function consultarDetalleDesempenoAnalista(fechaInicial, fechaFinal, idAnalista) {
                factoryBandejaEntradaService.getDatosGraficaDesempenoByIdAnalista(fechaInicial, fechaFinal, idAnalista)
                        .then((response) => {
                            vm.showInfoGeneral = false;
                            vm.showDetalleAnalista = true;
                            vm.selectedAnalista.muestras = response.data.data;
                            console.log('test22', vm.selectedAnalista);
                        });
            }

        })
        .component('sgmBeGraficaDesempenoAnalistas', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-grafica-desempeno-analistas/be-grafica-desempeno-analistas.html',
            controller: 'sgmBeGraficaDesempenoAnalistasCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


