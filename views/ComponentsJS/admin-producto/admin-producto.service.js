'use strict'

angular.module('CompAdminProducto')

        .factory('adminProductoService', function ($q, $filter, productoService, metodoService) {
            var interfaz = {
                getAllFormaFarmaceutica: getAllFormaFarmaceutica,
                getAllMetodos: getAllMetodos,
                rowSelectedProducto: rowSelectedProducto,
                confirmarCambiosProducto: confirmarCambiosProducto,
                descartarCambiosProducto: descartarCambiosProducto,
                eliminarProducto: eliminarProducto,
                openModalNewProducto: openModalNewProducto,
                confirmNewProductoModal: confirmNewProductoModal,
                clickDesasociarPaquetes: clickDesasociarPaquetes,
                clickAsociarPaquetes: clickAsociarPaquetes,
                openModalEditarProductoEnsayo: openModalEditarProductoEnsayo,
                closeModalEditProductoEnsayo: closeModalEditProductoEnsayo,
                confirmEditProductoEnsayoModal: confirmEditProductoEnsayoModal,
                clickDesasociarPrincipios: clickDesasociarPrincipios,
                clickAsociarPrincipios: clickAsociarPrincipios,
                changeFilter: changeFilter
            };

            function getAllFormaFarmaceutica(vm) {
                productoService.getAllFormaFarmaceutica().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.formas = response.data.data;
                    } else {
                        console.log('falla en la carga de formas');
                        console.error(response);
                    }
                });
            }

            function getAllMetodos(vm) {
                metodoService.getActiveMetodo().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.metodos = response.data.data;
                    } else {
                        console.log('falla en la carga de formas');
                        console.error(response);
                    }
                });
            }


            function rowSelectedProducto(vm, producto) {
                vm.waitModalText = 'Consultando información del producto, un momento por favor...';
                $('#waitModal').modal('show');
                vm.productoSelected = producto;
                angular.forEach(vm.productos, function (value, key) {
                    value.id == producto.id ? value.selected = true : value.selected = false;
                });
                var promises = {
                    getPaquetesAsociados: getPaquetesAsociados(vm),
                    getPaquetesDisponibles: getPaquetesDisponibles(vm),
                    getPrincipiosAsociados: getPrincipiosAsociados(vm),
                    getPrincipiosDisponibles: getPrincipiosDisponibles(vm)
                };
                $q.all(promises).then(function () {
                    angular.element(waitModal).modal('hide');
                });
            }

            function confirmarCambiosProducto(vm, producto) {
                vm.waitModalText = 'Actualizando Producto un momento por favor ...';
                $('#waitModal').modal('show');
                productoService.updateProducto(producto).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de producto ' + producto.id + 'OK');
                        producto.backup = null;
                        $('#waitModal').modal('hide');
                        producto.edit = false;
                    } else {
                        console.log('falla en la actualización de producto ' + producto.id);
                        console.error(response);
                        descartarCambiosProducto(vm, producto);
                    }
                }
                );

            }

            function descartarCambiosProducto(vm, producto) {

                producto.nombre = producto.backup.nombre;
                producto.id_formula_farma = producto.backup.id_formula_farma;
                producto.backup = null;
                producto.edit = false;
            }

            function openModalNewProducto(vm) {
                $('#newProductoModal').modal('show');
            }

            function eliminarProducto(vm, producto, index) {
                vm.waitModalText = 'Eliminando Producto un momento por favor ...';
                $('#waitModal').modal('show');
                productoService.deleteProducto(producto.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Eliminacion de producto ' + producto.id + 'OK');
                        vm.productos.splice(index, 1);
                        $('#waitModal').modal('hide');

                    } else {
                        console.log('falla en la eliminación del producto ' + producto.id);
                        console.error(response);
                        producto.edit = false;
                    }
                });
            }

            function confirmNewProductoModal(vm) {
                var newProductoData = angular.copy(vm.newProducto);
                closeModalNewProducto(vm);
                vm.waitModalText = 'Creando nuevo producto un momento por favor ...';
                $('#waitModal').modal('show');
                productoService.insertProducto(newProductoData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de producto OK');
                        changeFilter(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la creación del producto ');
                        console.error(response);
                        $('#waitModal').modal('hide');
                    }
                });
            }

            function closeModalNewProducto(vm) {

                vm.newProducto = {
                    nombre: "",
                    id_formula_farma: 0
                }
                $('#newProductoModal').modal('hide');
            }

            function getPaquetesAsociados(vm) {
                return productoService.getPaquetesAsociadosByIdProd(vm.productoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.paquetesAsociados = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar paquetes asociados');
                        console.error(response);
                    }
                });
            }

            function getPaquetesDisponibles(vm) {
                return productoService.getPaquetesDisponiblesByIdProd(vm.productoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.paquetesDisponibles = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar paquetes disponibles');
                        console.error(response);
                    }
                });
            }

            function clickDesasociarPaquetes(vm) {
                vm.waitModalText = 'Desasociando paquetes seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.paquetesAsociados, {selected: true});
                productoService.deleteProductoPaquetes(aux).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del producto seleccionado...';
                        var promises = {
                            getPaquetesAsociados: getPaquetesAsociados(vm),
                            getPaquetesDisponibles: getPaquetesDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al desasociar paquetes');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function clickAsociarPaquetes(vm) {
                vm.waitModalText = 'Asociando paquetes seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.paquetesDisponibles, {selected: true});
                productoService.createProductoPaquetes(vm.productoSelected, aux).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del producto seleccionado...';
                        var promises = {
                            getPaquetesAsociados: getPaquetesAsociados(vm),
                            getPaquetesDisponibles: getPaquetesDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al asociar paquetes');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function openModalEditarProductoEnsayo(vm, ensayo, indicePaquete, indiceEnsayo) {
                ensayo.backup = angular.copy(ensayo);
                vm.productoEnsayoEdit = ensayo;
                vm.productoEnsayoEdit.indicePaquete = indicePaquete;
                vm.productoEnsayoEdit.indiceEnsayo = indiceEnsayo;
                $('#editProductoEnsayoModal').modal('show');
            }

            function closeModalEditProductoEnsayo(vm) {
                $('#editProductoEnsayoModal').modal('hide');
                var ensayo = vm.paquetesAsociados[vm.productoEnsayoEdit.indicePaquete].ensayos[vm.productoEnsayoEdit.indiceEnsayo];
                ensayo.descripcion_especifica = vm.productoEnsayoEdit.backup.descripcion_especifica;
                ensayo.especificacion = vm.productoEnsayoEdit.backup.especificacion;
                ensayo.tiempo = vm.productoEnsayoEdit.backup.tiempo;
                ensayo.id_metodo = vm.productoEnsayoEdit.backup.id_metodo;
                vm.productoEnsayoEdit = null;
            }

            function confirmEditProductoEnsayoModal(vm) {
                $('#editProductoEnsayoModal').modal('hide');
                vm.waitModalText = 'Actualizando ensayo del producto...';
                angular.element(waitModal).modal('show');
                productoService.editarProductoEnsayo(vm.productoEnsayoEdit).then(function (response) {
                    if (response.data.code == "00000") {
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function getPrincipiosAsociados(vm) {
                return productoService.getPrincipiosAsociadosByIdProd(vm.productoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.principiosAsociados = response.data.data;
                    } else {
                        console.error('error al consultar paquetes asociados');
                        console.error(response);
                    }
                });
            }

            function getPrincipiosDisponibles(vm) {
                return productoService.getPrincipiosDisponiblesByIdProd(vm.productoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.principiosDisponibles = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar paquetes disponibles');
                        console.error(response);
                    }
                });
            }

            function clickDesasociarPrincipios(vm) {
                vm.waitModalText = 'Desasociando principios activos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.principiosAsociados, {selected: true});
                productoService.deleteProductoPrincipios(aux).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del producto seleccionado...';
                        var promises = {
                            getPrincipiosAsociados: getPrincipiosAsociados(vm),
                            getPrincipiosDisponibles: getPrincipiosDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al desasociar principios');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function clickAsociarPrincipios(vm) {
                vm.waitModalText = 'Asociando principios activos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.principiosDisponibles, {selected: true});
                productoService.createProductoPrincipios(vm.productoSelected, aux).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del producto seleccionado...';
                        var promises = {
                            getPrincipiosAsociados: getPrincipiosAsociados(vm),
                            getPrincipiosDisponibles: getPrincipiosDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al asociar principios');
                        console.error(response.data.data);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function changeFilter(vm) {
                productoService.getProductosPaginacion(vm.filter).then((response) => {
                    console.log(response);
                    vm.productos = response.data.data.productos;
                    vm.totalProductos = response.data.data.cantidad_total;
                    setMaxPage(vm);
                });
            }

            function setMaxPage(vm) {
                vm.maxPage = parseInt(vm.totalProductos / vm.filter.cantidad);

                if (vm.totalProductos % vm.filter.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            return interfaz;
        });



