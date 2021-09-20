'use strict'

angular.module('moduleTipoEstabilidadService', [])

        .factory('tipoEstabilidadService', function ($http) {
            var interfaz = {
                getAllTipoEstabilidad: function () {
                    return $http({
                        method: 'GET',
                        url: 'model/DB/jqw/EstTipoEstabilidadData.php?query=getAllTipoEstabilidad'
                    })
                }
            }

            return interfaz;
        });