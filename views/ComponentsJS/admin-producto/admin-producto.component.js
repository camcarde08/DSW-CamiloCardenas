'use strict';

angular.module('CompAdminProducto', [])



        .controller('compAdminProductoCtrl', function (adminProductoService) {
            var vm = this;
            vm.totalProductos = 0;
            vm.maxPage = 1;
            vm.productos = [];

            vm.filter = {
                cantidad: 10,
                pagina: 1,
                nombre: '',
                forma: ''
            };
            vm.$onInit = function () {
                vm.changeFilter();
            };

            vm.changeFilter = function () {
                adminProductoService.changeFilter(vm);
            }

            vm.$postLink = function () {
                adminProductoService.getAllFormaFarmaceutica(vm);
                adminProductoService.getAllMetodos(vm);

                vm.getDescripcionForma = function (idForma) {
                    var result = null;
                    angular.forEach(vm.formas, function (forma) {
                        if (forma.id == idForma) {
                            result = forma;
                        }
                    });
                    return result;
                };

                vm.editarProducto = function (producto) {
                    producto.backup = angular.copy(producto);
                    producto.edit = true;
                };

                // evento descartar cambios ensayo grilla de productos
                vm.descartarCambiosProducto = function (producto) {
                    adminProductoService.descartarCambiosProducto(vm, producto);
                };

                // evento confirmar cambios ensayo grilla de productos
                vm.confirmarCambiosProducto = function (producto) {
                    adminProductoService.confirmarCambiosProducto(vm, producto);
                };


                vm.rowSelectedProducto = function (producto) {
                    adminProductoService.rowSelectedProducto(vm, producto);
                }

                vm.eliminarProducto = function (producto, index) {
                    adminProductoService.eliminarProducto(vm, producto, index);
                }

                // evento abrir modal nuevo prod
                vm.openModalNewProducto = function () {
                    adminProductoService.openModalNewProducto(vm);
                };


                vm.confirmNewProductoModal = function () {
                    adminProductoService.confirmNewProductoModal(vm);
                };

                vm.clickAsociarPaquetes = function () {
                    adminProductoService.clickAsociarPaquetes(vm);
                };

                vm.clickDesasociarPaquetes = function () {
                    adminProductoService.clickDesasociarPaquetes(vm);
                };

                vm.openModalEditarProductoEnsayo = function (ensayo, indicePaquete, indiceEnsayo) {
                    adminProductoService.openModalEditarProductoEnsayo(vm, ensayo, indicePaquete, indiceEnsayo);
                };

                vm.closeModalEditProductoEnsayo = function () {
                    adminProductoService.closeModalEditProductoEnsayo(vm);
                };

                vm.closeModalNewProducto = function () {
                    $('#newProductoModal').modal('hide');
                };

                vm.confirmEditProductoEnsayoModal = function () {
                    adminProductoService.confirmEditProductoEnsayoModal(vm);
                };

                vm.getDescripcionMetodo = function (idMetodo) {
                    var result = null;
                    angular.forEach(vm.metodos, function (metodo) {
                        if (metodo.id == idMetodo) {
                            result = metodo;
                        }
                    });
                    return result;
                };

                vm.clickAsociarPrincipios = function () {
                    adminProductoService.clickAsociarPrincipios(vm);
                };

                vm.clickDesasociarPrincipios = function () {
                    adminProductoService.clickDesasociarPrincipios(vm);
                };

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



        .component('sgmAdminProducto', {
            templateUrl: './views/ComponentsJS/admin-producto/admin-producto.html',
            controller: 'compAdminProductoCtrl',
            controllerAs: 'vm'
        });






