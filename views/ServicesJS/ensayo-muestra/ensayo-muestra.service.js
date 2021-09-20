'use strict'

angular.module('moduleEnsayoMuestraService', [])

        .factory('ensayoMuestraService', function ($http) {
            var interfaz = {
                analizarEnsayoMuestra: function (muestra, ensayos, fecha) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'analizarEnsayoMuestra',
                            muestra: muestra,
                            ensayos: ensayos,
                            fechaAnalisis: fecha
                        })
                    });
                },
                aprobarEnsayoMuestra: function (ensayo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'aprobarEnsayoMuestra',
                            ensayo: ensayo,
                        })
                    });
                },
                rechazarEnsayoMuestra: function (ensayo) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'rechazarEnsayoMuestra',
                            ensayo: ensayo,
                        })
                    });
                },
                reprogramarEnsayoMuestra: function (ensayo, fecha) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'reprogramarEnsayoMuestra',
                            ensayo: ensayo
                        })
                    });
                },
                rfeEnsayoMuestra: function (ensayo, fecha) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'rfeEnsayoMuestra',
                            ensayo: ensayo
                        })
                    });
                },
                obtenerEnsayosAsignados: function (idUsuario, idMuestra) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'obtenerEnsayosAsignados',
                            idUsuario: idUsuario,
                            idMuestra: idMuestra
                        })
                    });
                },
                consultaInfoIdHojaCalculo: function (idEnsayoMuestra) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'consultaInfoIdHojaCalculo',
                            idEnsayoMuestra: idEnsayoMuestra
                        }
                    });
                },
            };

            return interfaz;
        });