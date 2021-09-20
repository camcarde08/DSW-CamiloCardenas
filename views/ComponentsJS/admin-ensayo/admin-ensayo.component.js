'use strict';

angular.module('CompAdminEnsayo', [])



        .controller('compAdminEnsayoCtrl', function ($filter, adminEnsayoService) {
            var vm = this;
            vm.loading = true;
            vm.totalEnsayos = 0;
            vm.maxPage = 1;
            vm.ensayos = [];

            vm.filter = {
                cantidad: 10,
                pagina: 1,
                descripcion: '',
                precio_real: '',
                tiempo: '',
                plantilla: '',
                codinterno: '',
                orden: ''
            };


            vm.$onInit = function () {

                vm.changeFilter();
                vm.newEnsayo = {
                    descripcion: "",
                    precio: 0,
                    duracion: 0,
                    id_plantilla: '1'
                }
            };

            vm.changeFilter = function () {
                adminEnsayoService.changeFilter(vm);
            }

            vm.$postLink = function () {

                // consulta perfil usuario 
                adminEnsayoService.getSessionUserData(vm);

                // carga plantillas
                adminEnsayoService.getAllPlantilla(vm);

                // evento click boton editar grilla de ensayos
                vm.editarEnsayo = function (ensayo) {
                    adminEnsayoService.editarEnsayo(vm, ensayo);
                }

                // evento descartar cambios ensayo grilla de ensayos
                vm.descartarCambiosEnsayo = function (ensayo) {
                    adminEnsayoService.descartarCambiosEnsayo(vm, ensayo);
                }

                // evento confirmar cambios ensayo grilla de ensayos
                vm.confirmarCambiosEnsayo = function (ensayo) {
                    adminEnsayoService.confirmarCambiosEnsayo(vm, ensayo);
                }

                // evento eliminar ensayo grilla de ensayos
                vm.eliminarEnsayo = function (ensayo, index) {
                    adminEnsayoService.eliminarEnsayo(vm, ensayo, index);
                }

                // evento abrir modal nuevo ensayo
                vm.openModalNewEnsayo = function () {
                    adminEnsayoService.openModalNewEnsayo(vm);
                }

                // evento cerrar modal nuevo ensayo

                vm.closeModalNewEnsayo = function () {
                    adminEnsayoService.closeModalNewEnsayo(vm);
                }

                // evento confirmar nuevo ensayo en formulario modal
                vm.confirmNewEnsayoModal = function () {
                    adminEnsayoService.confirmNewEnsayoModal(vm);
                }

                // evento seleccionar fila de la grilla de ensayos
                vm.selectRow = function (index, ensayo) {
                    adminEnsayoService.selectRow(vm, index, ensayo);
                }

                // evento click desasociar medio de cultivo
                vm.desasociarMedioCultivo = function () {
                    adminEnsayoService.desasociarMedioCultivo(vm);
                }

                // evento click asociar medios de cultivo
                vm.asociarMedioCultivo = function () {
                    adminEnsayoService.asociarMedioCultivo(vm);
                }


                vm.getDescripcionPlantilla = function (idPlantilla) {
                    var result = null;
                    angular.forEach(vm.plantillas, function (plantilla) {
                        if (plantilla.id == idPlantilla) {
                            result = plantilla;
                        }
                    });
                    return result;

                }

                vm.changeFilterHeader = function () {
                    vm.firstPage();
                }


                vm.firstPage = function () {
                    vm.filter.pagina = 1;
                    vm.changeFilter();
                }

                vm.resPage = function () {
                    if (vm.filter.pagina > 1) {
                        vm.filter.pagina--;
                    }
                    vm.changeFilter();
                }

                vm.addPage = function () {
                    if (vm.filter.pagina < vm.maxPage) {
                        vm.filter.pagina++;
                    }
                    vm.changeFilter();
                }

                vm.lastPage = function () {
                    vm.filter.pagina = vm.maxPage;
                    vm.changeFilter();
                }

            };
        })



        .component('sgmAdminEnsayo', {
            templateUrl: './views/ComponentsJS/admin-ensayo/admin-ensayo.html',
            controller: 'compAdminEnsayoCtrl',
            controllerAs: 'vm'
        });


// .directive('stringToNumber', function () {
//     return {
//         require: 'ngModel',
//         link: function (scope, element, attrs, ngModel) {
//             ngModel.$parsers.push(function (value) {
//                 return '' + value;
//             });
//             ngModel.$formatters.push(function (value) {
//                 return parseFloat(value);
//             });
//         }
//     };
// });





