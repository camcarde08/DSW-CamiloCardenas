'use strict';
angular.module('moduleInformeTendencia', ['chart.js'])



        .controller('compInformeTendenciaCtrl', function (terceroService, productoService, ensayoService, utileService) {
            var vm = this;

            vm.chartOptions1 = {

                legend: {
                    position: 'top',
                },
                scales: {
                    xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Fecha y No. De Análisis'
                        }
                    }],
                    yAxes: [
                        {
                            id: 'y-axis-1',
                            type: 'linear',
                            position: 'left',
                            ticks: {min: 10, max: 100},
                            scaleLabel: {
                                display: true,
                                labelString: 'Valor del Resultado'
                            }
                        }
                    ]
                }
            };

            vm.chartOptions2 = {

                legend: {
                    display: true,
                    labels: {
                        fontColor: 'rgb(255, 99, 132)'
                    }
                }
            };

            vm.showReporte1 = false;
            vm.showReporte2 = false;

            vm.fechaInicial = new Date();
            vm.fechaFinal = new Date();
            vm.ensayosFiltrados = [];
            vm.muestras = [];




            vm.labels = [];
            vm.series = ['Resultado'];

            vm.data = [0, 100];

            vm.show = false;

            vm.$onInit = function () {

                terceroService.getClientesActivos().then((response) => {
                    console.log(response);
                    vm.terceros = response.data.data;
                });

                productoService.getProductosActivos().then((response) => {
                    console.log(response);
                    vm.productos = response.data.data;
                });

                ensayoService.getAllActiveEnsayo().then((response) => {
                    console.log(response);
                    vm.ensayos = response.data.data;
                });
            };


            vm.$postLink = function () {

            };

            vm.search = function () {
                vm.show = "false"
                vm.labels = [];
                vm.series = [['Resultado']];

                vm.data = [];
                console.log(vm.selectedCliente);
                utileService.getInformeTendenciaData(vm.fechaInicial, vm.fechaFinal, vm.selectedCliente.id, vm.selectedProducto.id).then((response) => {
                    console.log(response);

                    vm.muestras = response.data.data;

                    response.data.data.forEach((element) => {

                        element.ensayos_muestra.forEach((ensayo) => {

                            var auxEnsayo = vm.ensayosFiltrados.find((item) => {
                                return item.id == ensayo.ensayo.id;
                            })

                            auxEnsayo ? null : vm.ensayosFiltrados.push(ensayo.ensayo);

                        })


//
//                        console.log(element);
//
//                        if (element.ensayos[0].resultados[0] != undefined && element.ensayos[0].resultados[0] != null) {
//                            vm.labels.push(element.prefijo + element.custom_id);
//                            vm.data.push(element.ensayos[0].resultados[0].resultado_numerico);
//                        }
//
//
                    });
                    console.log('ensayos filtrados', vm.ensayosFiltrados);

//                    vm.show = "true"
                });
            }

            vm.selectEnsayo = function () {
                vm.labels = [];
                vm.data = [];
                vm.muestras.forEach((muestra) => {
                    muestra.ensayos_muestra.forEach((ensayoMuestra) => {
                        if (ensayoMuestra.id_ensayo == vm.selectedEnsayo.id) {
                            if(ensayoMuestra.resultados[0]){
                                var fecha_llegada = muestra.fecha_llegada.substring(0 ,10);
                                vm.labels.push([muestra.prefijo + muestra.custom_id , fecha_llegada]);
                                vm.data.push(ensayoMuestra.resultados[0].resultado_numerico);
                            }

                        }
                    })
                })

                vm.chartOptions1.scales.yAxes[0].ticks.min = Math.min(...vm.data);
                vm.chartOptions1.scales.yAxes[0].ticks.max = Math.max(...vm.data);
            }

        })



        .component('sgmInformeTendencia', {
            templateUrl: './views/ComponentsJS/infrome-tendencia/informe-tendencia.html',
            controller: 'compInformeTendenciaCtrl',
            controllerAs: 'vm'
        });










