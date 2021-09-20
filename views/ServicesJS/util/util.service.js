'use strict'

angular.module('moduleUtilService', [])

        .factory('utileService', function ($http) {
            var loadedSessionUserData = null;
            var interfaz = {

                getFestivos: function (fechaInicio, dias) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getFestivos'
                        }
                    });
                },

                getLoadedSessionUserData: function () {
                    if (loadedSessionUserData != null) {
                        return loadedSessionUserData;
                    } else {
                        this.getSessionUserData().then(response => {
                            //systemParameters = response.data.data;
                            return loadedSessionUserData;
                        })
                    }
                },

                getSessionUserData: function () {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getSessionUserData'
                        }
                    }).then((response) => {
                        loadedSessionUserData = response.data.data;
                        return response;

                    });
                },
                eliminarArchivo: function (location) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'deleteFile',
                            location: location
                        })
                    });
                },
                getidMuestraSinCeros: getidMuestraSinCeros,
                getidMuestraConCeros: getidMuestraConCeros,
                getInformeTendenciaData: getInformeTendenciaData,
                validarFechaNoAplica: validarFechaNoAplica, 
                getFechaDateToString: getFechaDateToString
            }

            function getInformeTendenciaData(fechaInicial, fechaFinal, idCliente, idProducto) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getInformeTendenciaData',
                        fechaInicial: fechaInicial,
                        fechaFinal: fechaFinal,
                        idCliente: idCliente,
                        idProducto: idProducto
                    }
                });
            }

            function getidMuestraConCeros(idMuestra) {

            }

            function getidMuestraSinCeros(idMuestra) {
                var indice;
                var regex = new RegExp("[a-zA-Z]|[1-9]");
                for (var i = 0; i < idMuestra.length; i++) {
                    if (!regex.test(idMuestra[i])) {
                        indice = i;
                        break;
                    }
                }
                var id = idMuestra.substring(0, indice + 1).toUpperCase() + parseInt(idMuestra.substring(indice + 1, idMuestra.length));
                return id;
            }

            function validarFechaNoAplica(fecha) {
                var anio;
                var total;
                if (fecha !== null && fecha !== "") {
                    if (typeof fecha === "string") {
                        anio = parseInt(fecha.substr(0, 4));
                        total = fecha;
                    } else {
                        var dia = fecha.getDate();
                        var mes = fecha.getMonth() + 1;
                        anio = fecha.getFullYear();

                        if (mes < 10) {
                            mes = "0" + mes;
                        }
                        if (dia < 10) {
                            dia = "0" + dia;
                        }

                        total = anio + "-" + mes + "-" + dia;
                    }
                    if (anio === 2000) {
                        return "N.A";
                    } else {
                        return total;
                    }
                } else {
                    return null;
                }
            }
            
            function getFechaDateToString(fecha) {
                var dia = fecha.getDate();
                var mes = fecha.getMonth() + 1;
                var anio = fecha.getFullYear();

                return anio + '-' + ('0' + mes).slice(-2) + '-' + ('0' + dia).slice(-2);
            }

            return interfaz;
        });