angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasEstadoCtrl', function ($filter, $http, factoryBandejaEntradaService) {
            var vm = this;
            vm.labels = [];
            vm.data = [];
            vm.showInfoGeneral = false;
            vm.showDetalleEstado = false;

            vm.form = {
                fechaInicial: new Date(),
                fechaFinal: new Date()
            }

            vm.options = {
                onClick: function (event, data) {

                    const index = data[0]._index;
                    vm.selectedEstado = vm.estados[index];
                    consultarDetalleEstadoMuestra($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'), vm.estados[index].id)

                }
            }

            vm.backToGeneral = function(){
                vm.showInfoGeneral = true;
                vm.showDetalleEstado = false;
            }

            vm.onSubmit = function () {
                factoryBandejaEntradaService.getMuestrasEstados($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'))
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
                            ] ;

                            for (let estado of response.data.data) {
                                vm.labels.push(estado.estado);
                                vm.data.push(estado.muestras);
                                //vm.colors.push('#803690');
                            }
                            vm.estados = response.data.data;
                            vm.showInfoGeneral = true;

                        });
            }

            function consultarDetalleEstadoMuestra(fecha_inicial, fecha_final, id_estado){
                getDetalleEstadoMuestras(fecha_inicial, fecha_final,id_estado).then((response) => {
                    if(response.data.code == "00000") {
                        vm.showInfoGeneral = false;
                        vm.showDetalleEstado = true;
                        vm.selectedEstado.muestras = response.data.data;
                    }
                });
            }

            function getDetalleEstadoMuestras(fecha_inicial, fecha_final,id_estado){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getDetalleEstadoMuestras',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final,
                        id_estado: id_estado
                    }
                });
            }



        })
        .component('sgmBeMuestrasEstado', {
            templateUrl: './views/ComponentsJS/be-muestras-estado/be-muestras-estado.html',
            controller: 'sgmBeMuestrasEstadoCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


