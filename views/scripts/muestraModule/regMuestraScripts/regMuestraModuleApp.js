'use strict'

angular.module('regMuestraModule', [
    'ngLocale',
    'jqwidgets',
    'ngSanitize',
    'mgcrea.ngStrap',
    'angularUtils.directives.dirPagination',
    'CompAdminMedioCultivo',
    'CompRegMuestra',
    'CompAdminEnsayoEquipo',
    'CompAdminEnsayo',
    'CompAdminCepa',
    'CompHojaTrabajo',
    'CompAdminReactivo',
    'CompAdminEstandar',
    'CompAdminBandejaEntrada',
    'CompBandejaEntrada',
    'CompAdminPrincipioActivo',
    'CompAdminPaquete',
    'CompAdminProdEnsReactivo',
    'CompAdminColumna',
    'CompAdminCondicionCromatografica',
    'CompAdminProducto',
    'CompListaEstandares',
    'CompAdminUsuarioCliente',
    'CompAdminEquipo',
    'CompInformeConsumoMuestra',
    'CompListaReactivos',
    'CompInformeEventoMuestra',
    'CompAdminTercero',
    'CompAdminEnvase',
    'CompInformeReanalisis',
    'CompInformeOcupacionAnalista',
    'moduleTerceroService',
    'moduleCompSgmJqxTypeahead',
    'moduleAreaAnalisisService',
    'moduleAreaMicrobiologicaService',
    'moduleProductoService',
    'moduleEmpaqueService',
    'moduleEnvaseService',
    'moduleProductoEnsayoMuestraService',
    'moduleMetodoService',
    'moduleTipoMuestraService',
    'moduleMuestraService',
    'moduleTipoEstabilidadService',
    'moduleDuracionEstabilidadService',
    'moduleEnsayoService',
    'moduleEnsayoEquipoService',
    'moduleMedioCultivo',
    'moduleLoteCepa',
    'moduleLoteMedioCultivo',
    'moduleCepa',
    'moduleUtilService',
    'modulePlantillaService',
    'moduleReactivoService',
    'moduleEstandarService',
    'moduleEnsayoMuestraService',
    'moduleLoteReactivo',
    'moduleResultadoService',
    'moduleLoteEstandar',
    'moduleAdminBandejaEntradaService',
    'moduleBandejaEntradaService',
    'modulePrincipioActivoService',
    'modulePaqueteService',
    'moduleMuestraEstandarLoteService',
    'moduleProductoEnsayoReactivoService',
    'moduleProductoEnsayoEstandarService',
    'moduleColumnaService',
    'moduleCondicionCromatograficaService',
    'moduleEquipoService',
    'ModuleAdminPerfil',
    'modulePerfilService',
    'googlechart',
    'moduleInformeTendencia',
    'moduleConsultaMuestras',
    'ProgramacionAnalistasModule',
    'CompAdminMetodo',
    'CompAdminFormaFarmaceutica',
    'moduleUsuariosService',
    'CompAdminUsuario',
    'moduleTipoProductoService',
    'CompListaColumnas',
    'CompInformeCertificadoAnalisis',
    'CompAdminTipoProducto',
    'informeEventoMuestraEstabilidadModule',
    'CompInformeAnalista',
    'CompInformeEstadisticoMuestra',
    'CompInformeEstabilidadSalir',
    'CompInformeUsoReactivosMuestra',
    'CompInformeResumenMuestras',
    'CompHistoricoEstados',
    'CompHojaCalculo'

])


        .controller('regMuestraController', function () {
            var scope = this;
            scope.prueba = 'hola mundo';
        })

        .directive('stringToNumber', function () {
            return {
                require: 'ngModel',
                link: function (scope, element, attrs, ngModel) {
                    ngModel.$parsers.push(function (value) {
                        return '' + value;
                    });
                    ngModel.$formatters.push(function (value) {
                        return parseFloat(value);
                    });
                }
            };
        });





