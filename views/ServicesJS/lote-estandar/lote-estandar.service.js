
angular.module('moduleLoteEstandar', [])

        .factory('loteEstandarService', function ($http) {
            var interfaz = {

                getLotesByIdEstandar: function (idEstandar) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'queryDb',
                            query: 'getLotesByIdEstandar',
                            idEstandar: idEstandar
                        }
                    });
                },
                activarLoteEstandar: function (loteEstandarData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'activarLoteEstandar',
                            loteEstandarData: loteEstandarData
                        })
                    });
                },
                createNewLoteEstandar: function (newLoteData, idEstandar) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'createNewLoteEstandar',
                            newLoteData: newLoteData,
                            idEstandar: idEstandar
                        })
                    });
                },
                desactivarLoteEstandar: function (loteEstandarData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'desactivarLoteEstandar',
                            loteEstandarData: loteEstandarData
                        })
                    });
                },
                updateLoteEstandar: function (loteEstandarData) {
                    return $http({
                        method: 'POST',
                        url: 'index.php',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                        data: $.param({
                            action: 'queryDb',
                            query: 'updateLoteEstandar',
                            loteEstandarData: loteEstandarData
                        })
                    });
                },
                scanDirByIdLoteEstandar: function (numeroLoteEstandar, idLoteEstandar, idEstandar) {
                    return $http({
                        method: 'GET',
                        url: 'index.php',
                        params: {
                            action: 'scanDirByIdLoteEstandar',
                            idEstandar: idEstandar,
                            numeroLoteEstandar: numeroLoteEstandar,
                            idLoteEstandar: idLoteEstandar
                        }
                    });
                }
            };

            return interfaz;
        });