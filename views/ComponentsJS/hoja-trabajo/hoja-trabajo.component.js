'use strict';

angular.module('CompHojaTrabajo', [

])



        .controller('compHojaTrabajoCtrl', function ($q, hojaTrabajoService, $location, muestraService, utileService) {
            var vm = this;
            vm.statusScreen = 'start';

            vm.modalAnalizarEnsayoTitulo = 'Resgitro de siembra para el ensayo: '
            utileService.getSessionUserData().then(response => {
                var a = $location.absUrl();
                vm.sesionUserData = response.data.data;
                if (!a.includes("&idMuestra=")) {
                    vm.idMuestra = vm.sesionUserData.session.systemsParameters.defaultSearchText;
                }


            });

            vm.$onInit = function () {
                vm.statusScreen = 'onInit';
                vm.initPromises = {
                    sessionUserInfoPromise: hojaTrabajoService.loadUserInfo(vm)
                };

                $q.all(vm.initPromises).then(function (response) {
                    //console.debug('init info OK');
                    var a = $location.absUrl();
                    if (a.includes("&idMuestra=")) {
                        a = a.split('idMuestra=');
                        vm.idMuestra = a[1];
                        hojaTrabajoService.clickSearchMuestra(vm, null);
                    } else {
                        angular.element(waitModal).modal("hide");
                    }
                });

                $('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow({
                    position: {x: 400, y: 250},
                    showCollapseButton: true,
                    autoOpen: false,
                    isModal: false,
                    height: 400,
                    width: 500,
                    title: 'Anexos de analisis'
                });



            };

            vm.$postLink = function () {
                vm.statusScreen = 'postLink';

                //evento click buscar muestra
                vm.clickSearchMuestra = function (event) {
                    hojaTrabajoService.clickSearchMuestra(vm, event);
                }

                // evento click limpiar
                vm.limpiar = function (event) {
                    hojaTrabajoService.limpiar(vm, event);
                }

                // evento click analizar ensayo

                vm.analizarEnsayo = function (ensayo) {
                    hojaTrabajoService.openModalAnalizarEnsayo(vm);
                }

                // evento click confirmar anlizar ensayo

                vm.eventClickAnalizarEnsayo = function () {
                    hojaTrabajoService.eventClickAnalizarEnsayo(vm);
                }

                // evento click guardar resultado

                vm.eventClickGuardarResultado = function (ensayo) {
                    hojaTrabajoService.eventClickGuardarResultado(vm, ensayo);
                }

                // evento click actualizar resultado

                vm.eventClickActualizarResultado = function (resultado, ensayo) {
                    hojaTrabajoService.actualizarResultado(vm, resultado, ensayo);
                }

                // evento click aprobar ensayo muestra

                vm.eventClickAprobarEnsayoMuestra = function (ensayo) {
                    hojaTrabajoService.aprobarEnsayoMuestra(vm, ensayo);
                }

                // evento click rechazar ensayo muestra

                vm.eventClickRechazarEnsayoMuestra = function (ensayo) {
                    vm.ensayoRechazado = ensayo;
                    $('#rechazarAnalisisMuestraModal').modal('show');
                }

                // evento click verifcar muestra

                vm.eventClickVerificarMuestra = function () {
                    angular.element(verificarMuestraModal).modal('show');

                }

                // evento click confirmar verificar muestra

                vm.eventClickConfirmarVerificarMuestra = function () {
                    hojaTrabajoService.verificarMuestra(vm);
                }

                // evento click revisar muestra

                vm.eventClickRevisarMuestra = function () {
                    vm.currentLoadedMuestra.conclusion_muestra = "CONCEPTO: La muestra cumple las especificaciones del laboratorio propietario para los ensayos realizados."
                    +"\nObservaciones: Ninguna."+
                        "\nNotas:"+
                    "\nNota 1: Sólo se puede hacer reproducción parcial o total de este reporte previa autorización del Laboratorio."+
                        "\nNota 2: El resultado es válido solamente para la muestra analizada."+
                        "\nNota 3: La muestra se guardará por un tiempo de seis (6) meses a partir de la emisión del informe, luego se destruirá."+
                        "\nAnexo: Hoja de cálculo, cromatogramas y datos primarios. Páginas en total incluyendo anexos: __.";
                    angular.element(revisarMuestraModal).modal("show");
                }

                vm.eventClickActualizarRevisarMuestra = function () {
                    angular.element(revisarMuestraModal).modal("show");
                }

                // evento click confirmar revisar muestra
                vm.eventClickConfirmarRevisarMuestra = function () {
                    hojaTrabajoService.revisarMuestra(vm);
                }

                vm.estadoEnsayo = function (ensayo) {
                    if (ensayo.estado_ensayo == 1) {
                        var clase = {parasiembra: true};
                    } else if (ensayo.estado_ensayo == 2) {
                        var clase = {rechazado: true};
                    } else if (ensayo.estado_ensayo == 3) {
                        var clase = {aprobado: true};
                    } else if (ensayo.estado_ensayo == 4) {
                        var clase = {paratranscripcion: true};
                    } else if (ensayo.estado_ensayo == 5) {
                        var clase = {pararevision: true};
                    } else {
                        var clase = {pendiente: true};
                    }


                    return clase;
                }

                vm.calcPromedio = function (resultado) {
                    resultado.promedioCalc = (resultado.resultado_1 + resultado.resultado_2) / 2;
                }

                vm.eventClickInformePrevio = function () {
                    hojaTrabajoService.eventClickInformePrevio(vm);
                }
                
                vm.eventClickButtonHojaAnexo = function () {
                    hojaTrabajoService.eventClickButtonHojaAnexo(vm);
                }

                vm.eventClickButtonHojaDatosPrimarios = function () {
                    hojaTrabajoService.eventClickButtonHojaDatosPrimarios(vm);
                }

                vm.eventClickButttonConsultaAnexosConHojaRutaMuestra = function () {
                    hojaTrabajoService.eventClickButttonConsultaAnexosConHojaRutaMuestra(vm);
                }

                vm.eventClickButttonConsultaAnexosConHojaRutaMuestra = function () {
                    var id = vm.currentLoadedMuestra.prefijo + vm.sesionUserData.session.systemsParameters.prefixMuestraSeparator + vm.currentLoadedMuestra.custom_id;
                    muestraService.scanDirByIdMuestra(id).then(function (response) {
                        if (response.data !== null) {
                            var data = angular.toJson(response.data)
                            vm.loadTreeAnexosConHojaRutaMuestra(data);
                            $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("move", $(window).width() / 2 - $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("width") / 2, $(window).height() / 2 - $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("height") / 2);
                            $('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow('expand');
                            $('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow('open');
                        }
                    });
                };

                vm.loadTreeAnexosConHojaRutaMuestra = function (data) {

                    var source =
                            {
                                datatype: "json",
                                datafields: [
                                    {name: 'id'},
                                    {name: 'parentid'},
                                    {name: 'icon'},
                                    {name: 'text'},
                                    {name: 'value'}
                                ],
                                id: 'id',
                                localdata: data,
                                async: false
                            };
                    var dataAdapter = new $.jqx.dataAdapter(source);

                    dataAdapter.dataBind();

                    var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{name: 'text', map: 'label'}]);
                    $('#treeAnexosConHojaRutaMuestra').jqxTree({source: records, width: '100%', height: '99%'});
                    $('#treeAnexosConHojaRutaMuestra').jqxTree("expandAll");
                    $("#treeAnexosConHojaRutaMuestra li").on('dblclick', function (event) {
                        var target = $(event.target).parents('li:first')[0];
                        if (target != null) {
                            $("#treeAnexosConHojaRutaMuestra").jqxTree('selectItem', target);
                            var selectedItemA = $('#treeAnexosConHojaRutaMuestra').jqxTree('selectedItem');
                            if (selectedItemA.icon == "views/images/file_icon.png") {
                                window.open(selectedItemA.id, '_blank');
                            }
                            return false;
                        }
                    });
                };

                vm.reprogramarEnsayoMuestra = function (ensayo) {
                    vm.ensayoReprogramar = ensayo;
                    angular.element(reprogramarEnsayoModal).modal("show");
                };

                vm.rfeEnsayoMuestra = function (ensayo) {
                    vm.ensayoRfe = ensayo;
                    angular.element(rfeEnsayoModal).modal("show");
                };

                vm.eventClickReprogramarEnsayo = function () {
                    hojaTrabajoService.eventClickReprogramarEnsayo(vm);
                };

                vm.eventClickRfeEnsayo = function () {
                    hojaTrabajoService.eventClickRfeEnsayo(vm);
                };

                vm.cancelarRechazo = function () {
                    $('#rechazarAnalisisMuestraModal').modal('hide');
                }

                vm.rechazarMuestra = function () {
                    hojaTrabajoService.rechazarEnsayoMuestra(vm);
                }

                vm.checkAll = function (event) {
                    var evento = event.target;
                    hojaTrabajoService.checkAll(vm, evento);
                };

                vm.eventClickCondiciones = function () {
                    hojaTrabajoService.eventClickCondiciones(vm);
                }

                vm.eventClickButtonHojaCalculo = function (ensayo) {
                    window.location.href = 'index.php?action=render&page=hojaCalculo&idEnsayoMuestra=' + ensayo.id;
                };
            };
        })



        .component('sgmHojaTrabajo', {
            templateUrl: './views/ComponentsJS/hoja-trabajo/hoja-trabajo.html',
            controller: 'compHojaTrabajoCtrl',
            controllerAs: 'vm'
        });





