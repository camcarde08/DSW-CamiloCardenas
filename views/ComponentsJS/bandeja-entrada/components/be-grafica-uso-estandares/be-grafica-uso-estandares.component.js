angular.module('CompBandejaEntrada')

        .controller('sgmBeGraficaUsoEstandaresCtrl', function ($filter, $http) {
            var vm = this;
    
            vm.showInfoGeneral = false;
            vm.showDetalleEstandar = false;
            vm.selectedEstandar = null;
    
            vm.estandares = [];
            vm.labels = [];
            vm.data = [];
            vm.options = {
                onClick: function (event, data) {

                    const index = data[0]._index;

                    console.log(vm.estandares[index]);
                    vm.selectedEstandar = vm.estandares[index];
                    consultarDetalleUsoEstandar($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'), vm.estandares[index].id_estandar)

                }
            }

            vm.form = {
                fechaInicial: new Date(),
                fechaFinal: new Date()
            }
            
            vm.backToGeneral = function(){
                vm.showInfoGeneral = true;
                vm.showDetalleEstandar = false;
            }

            vm.onSubmit = function () {
                getUsoEstandares($filter('date')(vm.form.fechaInicial, 'yyyy-MM-dd'), $filter('date')(vm.form.fechaFinal, 'yyyy-MM-dd'))
                        .then((response) => {
                            console.log('Uso de estandares', response);

                            vm.labels = [];
                            vm.data = [];
                            vm.estandares = response.data.estandares;

                            for (let estandar of response.data.estandares) {
                                vm.labels.push(estandar.nombre);
                                vm.data.push(estandar.cantidad_usada);
                                //vm.colors.push('#803690');
                            }

                            vm.showInfoGeneral = true;

                        });
            }
            
            function consultarDetalleUsoEstandar(fecha_inicial, fecha_final, id_estandar){
                getDetalleUsoEstandar(fecha_inicial, fecha_final,id_estandar).then((response) => {
                    vm.showInfoGeneral = false;
                    vm.showDetalleEstandar = true;
                    vm.selectedEstandar.uso = response.data;
                    console.log(vm.selectedEstandar);
                });
            }

            function getDetalleUsoEstandar(fecha_inicial, fecha_final,id_estandar){
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getDetalleUsoEstandares',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final,
                        id_estandar: id_estandar
                    }
                });
            }

            function getUsoEstandares(fecha_inicial, fecha_final) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getUsoEstandares',
                        fecha_inicial: fecha_inicial,
                        fecha_final: fecha_final
                    }
                });
            }





        })
        .component('sgmBeGraficaUsoEstandares', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-grafica-uso-estandares/be-grafica-uso-estandares.html',
            controller: 'sgmBeGraficaUsoEstandaresCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });


