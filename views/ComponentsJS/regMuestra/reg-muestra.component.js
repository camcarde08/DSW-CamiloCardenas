'use strict';

angular.module('CompRegMuestra', [

])



        .controller('compRegMuestraCtrl', function ($scope, $element, regMuestraFactory, $location, utileService) {
            var vm = this;
            vm.dropDownDuracionEstInstance = {};
            vm.pruebaSettings = {};
            // vm.fechaLlegadaDomElement = $('#regMuestraFechaLlegada');
            utileService.getSessionUserData().then(response => {
                var a = $location.absUrl();
                vm.sesionUserData = response.data.data;
                vm.showCampoTipoMuestra = vm.sesionUserData.session.systemsParameters.campoTipoMuestraRegistroMuestra == 'true' ? true : false;
                vm.showCampoRemision = vm.sesionUserData.session.systemsParameters.campoRemisionRegistroMuestra == 'true' ? true : false;
                // console.log('session',vm.sesionUserData)
                if (!a.includes("&idMuestra=")) {
                    vm.idMuestra = vm.sesionUserData.session.systemsParameters.defaultSearchText;
                }

                utileService.getFestivos().then(function (response) {
                    if (response.data.code === "00000") {
                        vm.festivos = response.data.data;
                        regMuestraFactory.calcularFechaCompromiso(vm);
                        //vm.fechaLlegada, vm.sesionUserData.session.systemsParameters.diasHabilesFechaCompromiso
                    }
                });
            });


            // vm.contactoDomElement = $('#contacto');
            // vm.labFabricanteDomElement = $('#labFabricante');

            // vm.errorMessageNotification = $('#errorMessageNotification');
            vm.$postLink = function () {
                regMuestraFactory.preCallAnalisis(vm);
                // var a = $location.absUrl();
                // a = a.split('idMuestra=');
                // vm.idMuestra= a[1];
                // regMuestraFactory.searchMuestra(vm);
            };
            vm.$onInit = function () {
                // Carga parametrtos iniciales componentes jqwidgets
                regMuestraFactory.initJqxSettings(vm);
                // Llamada asincrona tercero service obtener listado de terceros
                vm.promiseGetTerceros = regMuestraFactory.getTerceros(vm);
                // Llamada asincrona Area Analisis service obtener las areas activas
                vm.promiseGetAreasActivas = regMuestraFactory.getAreasActivasJoinCoordinador(vm);
                // Llamada asincrona productos
                vm.promiseGetProducto = regMuestraFactory.getProductoJoinTipoProducto(vm.inputProductoSettings);
                // Llamada asincrona Empaque
                vm.promiseGetEmpaques = regMuestraFactory.getAllEmpaque(vm.dropDownEmpaqueSettings);
                // Llamada asincrona Envase
                vm.promiseGetEnvases = regMuestraFactory.getAllEnvase(vm.dropDownEnvaseSettings);
                // Llamada asincrona Metodo
                vm.promiseGetMetodos = regMuestraFactory.getActiveMetodo(vm);
                // Llamada asincrona Tipo Muestra
                vm.promiseGetTipoMuestra = regMuestraFactory.getAllActiveTipoMuestra(vm, vm.dropDownTipoMuestraSettings);
                // Llamada asincrona Areas microbiologicas
                vm.promiseGetAreasActivasMic = regMuestraFactory.getAreasActivas(vm.dropDownAreaMicroSettings);
                // Lamamda asincrona Tipos de estabilidad 
                vm.promiseGetTiposEstabilidad = regMuestraFactory.getTiposEstabilidad(vm);
                // watcher cambio de cliente
                regMuestraFactory.watcherCliente($scope, vm);
                // Watcher para el cambio de producto
                regMuestraFactory.watcherProducto($scope, vm);
                // Watcher para el area de analisis
                regMuestraFactory.watcherAreaAnalisis($scope, vm);
                // validacion para mostrar el campo de area microbiologica
                vm.isMicrobiologico = function () {
                    return regMuestraFactory.validateIsMicrobiologico(vm);
                };

                // validacio para mostrar campos de tipo planta
                vm.isPLanta = function () {
                    return regMuestraFactory.validateIsPlanta(vm);
                };

                vm.openCreateNewEmpaqueModal = function () {
                    angular.element('#createNewEmpaqueModal').modal('show');
                };

                vm.crearNuevoEmpaque = function () {
                    regMuestraFactory.crearNuevoEmpaque(vm);
                };

                vm.openCreateNewEnvaseModal = function () {
                    angular.element('#createNewEnvaseModal').modal('show');
                };

                vm.crearNuevoEnvase = function () {
                    regMuestraFactory.crearNuevoEnvase(vm);
                };

                vm.registrarMuestra = function () {
                    regMuestraFactory.registrarMuestra(vm);
                };

                vm.changeFechaLlegada = function () {
                    /*vm.fechaCompromiso = new Date();
                    vm.fechaCompromiso.setDate(vm.fechaLlegada.getDate() + vm.prioridad.tiempoEntrega);*/
                    regMuestraFactory.calcularFechaCompromiso(vm);
                    $('#regMuestraFechaLlegada').tooltip('hide');
                };
                vm.changeFechaCompromiso = function () {
                    angular.element('#fechaCompromiso').tooltip('hide');
                };
                vm.changeCliente = function () {
                    angular.element('#cliente').tooltip('hide');
                };
                vm.changeContacto = function () {
                    angular.element('#contacto').tooltip('hide');
                };
                vm.changeLabFabricante = function () {
                    angular.element('#labFabricante').tooltip('hide');
                };
                vm.changeProcedencia = function () {
                    angular.element('#procedencia').tooltip('hide');
                };
                vm.changeAreasAnalisis = function () {
                    angular.element('#areaAnalisis').tooltip('hide');
                    regMuestraFactory.validateSelectedAreaAnalisis(vm);


                };
                vm.changeFechaMuestreo = function () {
                    angular.element('#fechaMuestreo').tooltip('hide');
                };
                vm.changeTecnicaUsada = function () {
                    angular.element('#tecnicaUsada').tooltip('hide');
                };
                vm.changeTipoMuestra = function () {
                    angular.element('#tipoMuestra').tooltip('hide');
                };
                vm.changeAreaMicro = function () {
                    angular.element('#areaMicro').tooltip('hide');
                };
                vm.changeSanitizante = function () {
                    angular.element('#sanitizante').tooltip('hide');
                };
                vm.changeFrotis = function () {
                    angular.element('#frotis').tooltip('hide');
                };
                vm.changeEspAerobiosMesofilos = function () {
                    angular.element('#espAerobiosMesofilos').tooltip('hide');
                };
                vm.changeEspMohosLevaduras = function () {
                    angular.element('#espMohosLevaduras').tooltip('hide');
                };
                vm.changeProducto = function () {
                    angular.element('#producto').tooltip('hide');
                };
                vm.changeEmpaque = function () {
                    angular.element('#empaque').tooltip('hide');
                };
                vm.changeEnvase = function () {
                    angular.element('#empaque').tooltip('hide');
                };
                vm.changeFechaFabricacion = function () {
                    angular.element('#fechaFabricacion').tooltip('hide');
                };
                vm.changeFechaVencimiento = function () {
                    angular.element('#fechaVencimiento').tooltip('hide');
                };
                vm.changeTamanoLote = function () {
                    angular.element('#tamanoLote').tooltip('hide');
                };
                vm.changeNumeroLote = function () {
                    angular.element('#numeroLote').tooltip('hide');
                };
                vm.changeCantidadLote = function () {
                    angular.element('#cantidadLote').tooltip('hide');
                };
                vm.changeCondicionesGenerales = function () {
                    angular.element('#regMuestraCondicionesGenerales').tooltip('hide');
                };
                vm.changeIdentificadorCliente = function () {
                    angular.element('#regMuestraIdentificadorCliente').tooltip('hide');
                };
                vm.changeEstabilidadMic = function () {
                    angular.element('#EstabilidadMic').tooltip('hide');
                };
                vm.changePuntoToma = function () {
                    angular.element('#puntoToma').tooltip('hide');
                };
                vm.changePlantaTecnicaUsada = function () {
                    angular.element('#plantaTecnicaUsada').tooltip('hide');
                };
                vm.changeResponsableToma = function () {
                    angular.element('#responsableToma').tooltip('hide');
                };
                vm.changeSuperficieEquipo = function () {
                    angular.element('#superficieEquipo').tooltip('hide');
                };
                vm.changeEspEColi = function () {
                    angular.element('#espEColi').tooltip('hide');
                };
                vm.searchMuestra = function () {
                    regMuestraFactory.searchMuestra(vm);
                };
                vm.limpiarFormulario = function () {
                    regMuestraFactory.limpiarFormulario(vm);
                };
                vm.actualizarMuestra = function () {
                    regMuestraFactory.actualizarMuestra(vm);
                };
                vm.verEstados = function () {
                    regMuestraFactory.verEstados(vm);
                };
                vm.verHistorico = function () {
                    regMuestraFactory.verHistorico(vm);
                };
                vm.unCheckActiva = function () {
                    regMuestraFactory.unCheckActiva(vm);
                };
                vm.anularMuestra = function () {
                    regMuestraFactory.anularMuestra(vm);
                };
                vm.changeTipoEstabilidad = function () {
                    regMuestraFactory.loadEnsayosGrid(vm);
                };
                vm.changeDuracionEstabilidad = function () {
                    regMuestraFactory.loadEnsayosGrid(vm);
                }
                vm.testa = function () {
                    var a = 0;
                }

            };
        })



        .component('sgmRegMuestra', {
            templateUrl: './views/ComponentsJS/regMuestra/regMuestra.html',
            controller: 'compRegMuestraCtrl'
        });


