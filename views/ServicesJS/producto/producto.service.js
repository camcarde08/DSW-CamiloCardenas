'use strict'

angular.module('moduleProductoService', [])

        .factory('productoService', function ($http) {
            var interfaz = {
                getProductoJoinTipoProducto: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getActiveProductoJoinTipoProducto'
                        }
                    });
                },
                getPrincipiosActivosByIdProducto: function (idProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPrincipiosActivosByIdProducto',
                            idProducto: idProducto
                        }
                    });
                },
                getProductosActivos: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getProductosActivos'
                        }
                    });
                },
                getAllFormaFarmaceutica: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getAllFormaFarmaceutica'
                        }
                    });
                },
                updateProducto: function (productoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateProducto',
                            productoData: productoData
                        })
                    });
                },
                deleteProducto: function (idProducto) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteProducto',
                            idProducto: idProducto
                        })
                    });
                },
                insertProducto: function (productoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'insertProducto',
                            productoData: productoData
                        })
                    });
                },
                getPaquetesAsociadosByIdProd: function (idProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPaquetesAsociadosByIdProd',
                            idProducto: idProducto
                        }
                    });
                },
                getPaquetesDisponiblesByIdProd: function (idProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPaquetesDisponiblesByIdProd',
                            idProducto: idProducto
                        }
                    });
                },
                createProductoPaquetes: function (producto, paquetes) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createProductoPaquetes',
                            producto: producto,
                            paquetes: paquetes
                        })
                    });
                },
                deleteProductoPaquetes: function (productoPaquetes) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteProductoPaquetes',
                            productoPaquetes: productoPaquetes
                        })
                    });
                },
                editarProductoEnsayo: function (productoEnsayoData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'editarProductoEnsayo',
                            productoEnsayoData: productoEnsayoData
                        })
                    });
                },
                getPrincipiosAsociadosByIdProd: function (idProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPrincipiosAsociadosByIdProd',
                            idProducto: idProducto
                        }
                    });
                },
                getPrincipiosDisponiblesByIdProd: function (idProducto) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getPrincipiosDisponiblesByIdProd',
                            idProducto: idProducto
                        }
                    });
                },
                createProductoPrincipios: function (producto, principios) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createProductoPrincipios',
                            producto: producto,
                            principios: principios
                        })
                    });
                },
                deleteProductoPrincipios: function (productoPrincipios) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'deleteProductoPrincipios',
                            productoPrincipios: productoPrincipios
                        })
                    });
                },
                getProductosPaginacion: function (data) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getProductosPaginacion',
                            cantidad: data.cantidad,
                            pagina: data.pagina,
                            nombre: data.nombre,
                            forma: data.forma
                        }
                    });
                }
            };

            return interfaz;
        });


