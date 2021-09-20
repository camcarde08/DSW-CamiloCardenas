angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasTipoProductoCtrl', function ($filter, $http, factoryBandejaEntradaService) {
            var vm = this;
            vm.labels = [];
            vm.data = [];
            vm.showInfoGeneral = false;
            vm.showDetalleTipo = false;

            vm.form = {
                fechaInicial: new Date(),
                fechaFinal: new Date()
            }

            vm.options = {
                onClick: function (event, data) {

                    const index = data[0]._index;
                    vm.selectedTipo = vm.tipos[index];
                    consultarDetalleTipoProducto($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'), vm.tipos[index].id)

                }
            }

            vm.backToGeneral = function(){
                vm.showInfoGeneral = true;
                vm.showDetalleTipo = false;
            }

            vm.onSubmit = function () {
                factoryBandejaEntradaService.getDatosGraficaMuestrasPorTipoProducto($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'))
                        .then((response) => {
                            console.log('muestras por tipo', response);
                    
                            vm.labels = [];
                            vm.data = [];
                            vm.colors = [ 
                                '#2d1eda', 
                                '#8d8de9', 
                                '#cdc10f', 
                                '#368113', 
                                '#d481ee', 
                                '#d481ee', 
                                '#d481ee', 
                                '#d481ee', 
                                '#d481ee', 
                                '#83827b', 
                                '#8b3737', 
                                '#e6e19f', 
                                '#be5512', 
                                '#eca171', 
                                '#b3e69c', 
                                '#8ed9ec', 
                                '#1c8ca8', 
                            ] ;
                            
                            for (let tipoProducto of response.data.data) {
                                vm.labels.push(tipoProducto.tipo_producto);
                                vm.data.push(tipoProducto.cantidad);
                                //vm.colors.push('#803690');
                            }
                            vm.tipos = response.data.data;
                            vm.showInfoGeneral = true;

                            

                        });
            }


            function consultarDetalleTipoProducto(fecha_inicial, fecha_final, id_estado){
                getDetalleTipoProducto(fecha_inicial, fecha_final,id_estado).then((response) => {
                    if(response.data.code == "00000") {
                        vm.showInfoGeneral = false;
                        vm.showDetalleTipo = true;
                        vm.selectedTipo.muestras = response.data.data;
                    }
                });
            }

            function getDetalleTipoProducto(fecha_inicial, fecha_final,id_tipo_producto){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getDetalleTipoProducto',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final,
                        id_tipo_producto: id_tipo_producto
                    }
                });
            }


        })
        .component('sgmBeMuestrasPorTipoProducto', {
            templateUrl: './views/ComponentsJS/be-muestras-por-tipo-producto/be-muestras-por-tipo-producto.html',
            controller: 'sgmBeMuestrasTipoProductoCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


