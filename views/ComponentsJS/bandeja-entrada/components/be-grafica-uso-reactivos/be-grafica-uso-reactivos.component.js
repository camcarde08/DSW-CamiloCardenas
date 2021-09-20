angular.module('CompBandejaEntrada')

        .controller('sgmBeGraficaUsoReactivosCtrl', function ($filter, $http) {
            var vm = this;
    
            vm.showInfoGeneral = false;
            vm.showDetalleReactivo = false;
            vm.selectedReactivo = null;
    
            vm.reactivos = [];
            vm.labels = [];
            vm.data = [];
            vm.options = {
                onClick: function (event, data) {

                    const index = data[0]._index;

                    console.log(vm.reactivos[index]);
                    vm.selectedReactivo = vm.reactivos[index];
                    consultarDetalleUsoReactivo($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'), vm.reactivos[index].id_reactivo)

                }
            }

            vm.form = {
                fechaInicial: new Date(),
                fechaFinal: new Date()
            }
            
            vm.backToGeneral = function(){
                vm.showInfoGeneral = true;
                vm.showDetalleReactivo = false;
            }

            vm.onSubmit = function () {
                getUsoReactivos($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'))
                        .then((response) => {
                            console.log('Uso de reactivos', response);

                            vm.labels = [];
                            vm.data = [];
                            vm.reactivos = response.data.reactivos;

                            for (let reactivo of response.data.reactivos) {
                                vm.labels.push(reactivo.nombre);
                                vm.data.push(reactivo.cantidad_usada);
                                //vm.colors.push('#803690');
                            }

                            vm.showInfoGeneral = true;

                        });
            }
            
            function consultarDetalleUsoReactivo(fecha_inicial, fecha_final, id_reactivo){
                getDetalleUsoReactivo(fecha_inicial, fecha_final,id_reactivo).then((response) => {
                    vm.showInfoGeneral = false;
                    vm.showDetalleReactivo = true;
                    vm.selectedReactivo.uso = response.data;
                    console.log(vm.selectedReactivo);
                });
            }

            function getDetalleUsoReactivo(fecha_inicial, fecha_final,id_reactivo){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getDetalleUsoReactivos',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final,
                        id_reactivo: id_reactivo
                    }
                });
            }

            function getUsoReactivos(fecha_inicial, fecha_final) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getUsoReactivos',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final
                    }
                });
            }





        })
        .component('sgmBeGraficaUsoReactivos', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-grafica-uso-reactivos/be-grafica-uso-reactivos.html',
            controller: 'sgmBeGraficaUsoReactivosCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


