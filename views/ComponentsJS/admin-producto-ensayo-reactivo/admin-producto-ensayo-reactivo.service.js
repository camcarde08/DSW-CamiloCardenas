'use strict'

angular.module('CompAdminProdEnsReactivo')

        .factory('adminProdEnsReactivoService', function ($q, $filter, condicionCromatograficaService, columnaService, productoService, productoEnsayoMuestraService, productoEnsayoEstandarService, productoEnsayoReactivoService) {
            var interfaz = {
                getAllActiveProductos: getAllActiveProductos,
                getAllHojasCalculo: getAllHojasCalculo,
                getAllCondicionesCromatograficas: getAllCondicionesCromatograficas,
                getAllColumnas: getAllColumnas,
                rowSelectedProducto: rowSelectedProducto,
                getEnsayosPaquetesProducto: getEnsayosPaquetesProducto,
                rowSelectedEnsayo: rowSelectedEnsayo,
                getReactivosAsociados: getReactivosAsociados,
                getReactivosDisponibles: getReactivosDisponibles,
                clickDesasociarReactivos: clickDesasociarReactivos,
                clickAsociarReactivos: clickAsociarReactivos,
                clickDesasociarEstandares: clickDesasociarEstandares,
                clickAsociarEstandares: clickAsociarEstandares,
                selectHojaCalculo: selectHojaCalculo,
                selectCondicionCromatografica: selectCondicionCromatografica,
                selectColumna: selectColumna
            };

            function getAllHojasCalculo(vm) {
                productoEnsayoMuestraService.getAllHojasCalculo().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.hojasCalculo = response.data.data;
                    } else {
                        console.log('Falla en la carga de hoja de calculo');
                        console.error(response);
                    }
                });
            }

            function getAllCondicionesCromatograficas(vm) {
                condicionCromatograficaService.getAllCondicionCromatografica().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.condicionesCromatograficas = response.data.data;
                    } else {
                        console.log('Falla en la carga de condiciones');
                        console.error(response);
                    }
                });
            }

            function getAllColumnas(vm) {
                columnaService.getAllActiveColumnas().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.columnas = response.data.data;
                    } else {
                        console.log('Falla en la carga de columnas');
                        console.error(response);
                    }
                });
            }

            function getAllActiveProductos(vm) {
                vm.waitModalText = 'Cargando datos de productos, un momento por favor ...';
                $('#waitModal').modal('show');
                productoService.getProductosActivos().then(function (response) {
                    if (response.data.code == "00000") {
                        vm.productos = response.data.data;
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de productos');
                        console.error(response);
                    }
                });
            }

            function rowSelectedProducto(vm, producto) {
                vm.productoSelected = producto;
                angular.forEach(vm.productos, function (value, key) {
                    value.id == producto.id ? value.selected = true : value.selected = false;
                });
                getEnsayosPaquetesProducto(vm, producto.id);
            }

            function getEnsayosPaquetesProducto(vm, idProducto) {
                vm.waitModalText = 'Cargando datos del producto, un momento por favor ...';
                $('#waitModal').modal('show');
                productoEnsayoMuestraService.getEnsayosPaquetesProducto(idProducto).then(function (response) {
                    if (response.data !== null) {
                        vm.paquetesEnsayos = response.data;
                    } else {
                        console.log('Falla en la carga de paquetes y ensayos');
                        console.error(response);
                    }
                    $('#waitModal').modal('hide');
                });
            }


            function rowSelectedEnsayo(vm, ensayo, paqueteEnsayo) {
                vm.waitModalText = 'Consultando información del ensayo seleccionado...';
                angular.element(waitModal).modal('show');
                vm.ensayoSelected = ensayo;
                angular.forEach(vm.paquetesEnsayos, function (value, key) {
                    if (value.id == paqueteEnsayo.id) {
                        angular.forEach(value.ensayos, function (value, key) {
                            value.id == ensayo.id ? value.selected = true : value.selected = false;
                            if (value.id == ensayo.id) {
                                value.multiSelect = true;
                            }
                        });
                    }
                });

                var promises = {
                    getReactivosAsociados: getReactivosAsociados(vm),
                    getReactivosDisponibles: getReactivosDisponibles(vm),
                    getEstandaresAsociados: getEstandaresAsociados(vm),
                    getEstandaresDisponibles: getEstandaresDisponibles(vm)
                }
                $q.all(promises).then(function () {
                    angular.element(waitModal).modal('hide');
                });
            }



            function getReactivosAsociados(vm) {
                return productoEnsayoReactivoService.getReactivosAsociadosByIdEnsayoProd(vm.ensayoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.reactivosAsociados = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar reactivos asociados');
                        console.error(response);
                    }
                });
            }

            function getReactivosDisponibles(vm) {
                return productoEnsayoReactivoService.getReactivosDisponiblesByIdEnsayoProd(vm.ensayoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.reactivosDisponibles = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar reactivos disponibles');
                        console.error(response);
                    }
                });
            }

            function crearArrayEnsayosSeleccionados(vm) {
                var aux = [];
                angular.forEach(vm.paquetesEnsayos, function (value, key) {
                    var temp = $filter('filter')(value.ensayos, {multiSelect: true});
                    aux = aux.concat(temp);
                });
                return aux;
            }

            function clickDesasociarReactivos(vm) {
                vm.waitModalText = 'Desasociando reactivos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.reactivosAsociados, {selected: true});
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                console.log(ensayosSelected);
                productoEnsayoReactivoService.deleteProductoEnsayoReactivos(aux, ensayosSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            getReactivosAsociados: getReactivosAsociados(vm),
                            getReactivosDisponibles: getReactivosDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al desasociar reactivos');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function clickAsociarReactivos(vm) {
                vm.waitModalText = 'Asociando reactivos seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.reactivosDisponibles, {selected: true});
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                productoEnsayoReactivoService.createProductoEnsayoReactivos(ensayosSelected, aux).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            getReactivosAsociados: getReactivosAsociados(vm),
                            getReactivosDisponibles: getReactivosDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al asociar reactivos');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }


            function getEstandaresAsociados(vm) {
                return productoEnsayoEstandarService.getEstandaresAsociadosByIdEnsayoProd(vm.ensayoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.estandaresAsociados = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar estandares asociados');
                        console.error(response);
                    }
                });
            }

            function getEstandaresDisponibles(vm) {
                return productoEnsayoEstandarService.getEstandaresDisponiblesByIdEnsayoProd(vm.ensayoSelected.id).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.estandaresDisponibles = response.data.data;
                        console.debug(response.data.data);
                    } else {
                        console.error('error al consultar estandares disponibles');
                        console.error(response);
                    }
                });
            }




            function clickDesasociarEstandares(vm) {
                vm.waitModalText = 'Desasociando estandares seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.estandaresAsociados, {selected: true});
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                productoEnsayoEstandarService.deleteProductoEnsayoEstandares(aux, ensayosSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            getEstandaresAsociados: getEstandaresAsociados(vm),
                            getEstandaresDisponibles: getEstandaresDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al desasociar estándares');
                        console.error(response);
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function clickAsociarEstandares(vm) {
                vm.waitModalText = 'Asociando estándares seleccionados...';
                angular.element(waitModal).modal('show');
                var aux = $filter('filter')(vm.estandaresDisponibles, {selected: true});
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                productoEnsayoEstandarService.createProductoEnsayoEstandares(ensayosSelected, aux).then(function (response) {
                    if (response.data.code == "00000") {
                        vm.waitModalText = 'Actualizando datos del ensayo seleccionado...';
                        var promises = {
                            getEstandaresAsociados: getEstandaresAsociados(vm),
                            getEstandaresDisponibles: getEstandaresDisponibles(vm)
                        };
                        $q.all(promises).then(function () {
                            angular.element(waitModal).modal('hide');
                        });
                    } else {
                        console.error('error al asociar estandares');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function selectHojaCalculo(vm) {
                vm.waitModalText = 'Asociando hoja cálculo...';
                angular.element(waitModal).modal('show');
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                for (var i = 0; i < ensayosSelected.length; i++) {
                    ensayosSelected[i].id_hoja_calculo = vm.ensayoSelected.id_hoja_calculo;
                }
                productoEnsayoMuestraService.updateHojaCalculoProdEnsayo(ensayosSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        angular.element(waitModal).modal('hide');
                    } else {
                        console.error('error al actualizar hoja cálculo');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function selectCondicionCromatografica(vm) {
                vm.waitModalText = 'Asociando condición cromatográfica...';
                angular.element(waitModal).modal('show');
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                for (var i = 0; i < ensayosSelected.length; i++) {
                    ensayosSelected[i].id_condicion_cromatografica = vm.ensayoSelected.id_condicion_cromatografica;
                }
                productoEnsayoMuestraService.updateCondicionCromatograficaProdEnsayo(ensayosSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        angular.element(waitModal).modal('hide');
                    } else {
                        console.error('error al actualizar condición');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }

            function selectColumna(vm) {
                vm.waitModalText = 'Asociando columna...';
                angular.element(waitModal).modal('show');
                var ensayosSelected = crearArrayEnsayosSeleccionados(vm);
                for (var i = 0; i < ensayosSelected.length; i++) {
                    ensayosSelected[i].id_columna = vm.ensayoSelected.id_columna;
                }
                productoEnsayoMuestraService.updateColumnaProdEnsayo(ensayosSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        angular.element(waitModal).modal('hide');
                    } else {
                        console.error('error al actualizar columna');
                        angular.element(waitModal).modal('hide');
                    }
                });
            }


            return interfaz;
        });



