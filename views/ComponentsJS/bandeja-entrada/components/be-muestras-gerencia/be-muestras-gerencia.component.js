'use strict'

angular.module('CompBandejaEntrada')

        .controller('sgmBeMuestrasGerenciaCtrl', function ($timeout, $http, muestraService, factoryBandejaEntradaService) {
            var vm = this;

            vm.show_id_muestra = '';
            vm.estado_muestra = '';
            vm.fecha_llegada = '';
            vm.cliente = '';
            vm.producto = '';
            vm.lote = '';
            vm.fecha_pre_conclusion = '';
            vm.fecha_conclusion = '';
            vm.responsable_muestra = '';
            vm.ensayo = '';
            vm.estado_ensayo = '';
            vm.especificacion = '';
            vm.resultado = '';
            vm.fecha_programacion = '';
            vm.fecha_analisis = '';
            vm.responsable_ensayo = '';

            vm.pagina = 1;
            vm.cantidad = 10;

            vm.$onInit = function () {

                $timeout(function () {

                    vm.consultarMuestrasFiltro();
                }, 1);

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

            };

            vm.changeFilter = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.pagina = 1;
                vm.consultarMuestrasFiltro();
            }

            vm.formatearFecha = function (fecha, fechaifNull) {
                if (fecha !== '' && fecha !== null && fecha !== undefined) {
                    var anio = fecha.getFullYear();
                    var mes = ('0' + (fecha.getMonth() + 1)).slice(-2);
                    var dia = ('0' + fecha.getDate()).slice(-2);

                    return anio + '-' + mes + '-' + dia;
                } else {
                    return fechaifNull;
                }
            };

            vm.changeFilter2 = function () {
                console.log('cambio de filtro');
                vm.subMuestras = null;
                vm.consultarMuestrasFiltro();
            }

            vm.consultarMuestrasFiltro = function () {
                var fechaLlegadaInicio = vm.formatearFecha(vm.fecha_llegada, null);
                var fechaLlegadaFin = vm.formatearFecha(vm.fecha_llegada_fin, fechaLlegadaInicio);

                var fechaPreConclusionInicio = vm.formatearFecha(vm.fecha_pre_conclusion, null);
                var fechaPreConclusionFin = vm.formatearFecha(vm.fecha_pre_conclusion_fin, fechaPreConclusionInicio);

                var fechaConclusionInicio = vm.formatearFecha(vm.fecha_conclusion, null);
                var fechaConclusionFin = vm.formatearFecha(vm.fecha_conclusion_fin, fechaConclusionInicio);

                var fechaProgramacionInicio = vm.formatearFecha(vm.fecha_programacion, null);
                var fechaProgramacionFin = vm.formatearFecha(vm.fecha_programacion_fin, fechaProgramacionInicio);

                var fechaAnalisisInicio = vm.formatearFecha(vm.fecha_analisis, null);
                var fechaAnalisisFin = vm.formatearFecha(vm.fecha_analisis_fin, fechaAnalisisInicio);

                vm.consultar(vm.pagina, vm.cantidad, vm.show_id_muestra, vm.estado_muestra, fechaLlegadaInicio, fechaLlegadaFin, vm.cliente,
                        vm.producto, vm.lote, fechaPreConclusionInicio, fechaPreConclusionFin,
                        fechaConclusionInicio, fechaConclusionFin, vm.responsable_muestra, vm.ensayo, vm.estado_ensayo,
                        vm.especificacion, vm.resultado,
                        fechaProgramacionInicio, fechaProgramacionFin, fechaAnalisisInicio, fechaAnalisisFin, vm.responsable_ensayo);
            }

            vm.consultar = function (pagina, cantidad, show_id_muestra, estado_muestra, fecha_llegada_inicio,
                    fecha_llegada_fin, cliente, producto, lote, fecha_pre_conclusion_inicio, fecha_pre_conclusion_fin,
                    fecha_conclusion_inicio, fecha_conclusion_fin, responsable_muestra, ensayo,
                    estado_ensayo, especificacion, resultado, fecha_programacion_inicio, fecha_programacion_fin,
                    fecha_analisis_inicio, fecha_analisis_fin, responsable_ensayo) {
                getMuestrasTerminadas(pagina, cantidad, show_id_muestra, estado_muestra, fecha_llegada_inicio,
                        fecha_llegada_fin, cliente, producto, lote, fecha_pre_conclusion_inicio, fecha_pre_conclusion_fin,
                        fecha_conclusion_inicio, fecha_conclusion_fin, responsable_muestra, ensayo,
                        estado_ensayo, especificacion, resultado, fecha_programacion_inicio, fecha_programacion_fin,
                        fecha_analisis_inicio, fecha_analisis_fin, responsable_ensayo)
                        .then((response) => {
                            vm.cantidadTotal = response.data.cantidad_total;
                            vm.muestras = response.data.muestras;
                            vm.setMaxPage();
                            console.log('muestras FQ gerencia', response);
                        });
            }




            vm.firstPage = function () {
                vm.pagina = 1;
                vm.changeFilter2();
            }

            vm.resPage = function () {
                if (vm.pagina > 1) {
                    vm.pagina--;
                    vm.changeFilter2();
                }
            }

            vm.addPage = function () {
                if (vm.pagina < vm.maxPage) {
                    vm.pagina++;
                }
                vm.changeFilter2();
            }

            vm.lastPage = function () {
                vm.pagina = vm.maxPage;
                vm.changeFilter2();
            }

            vm.setMaxPage = function () {
                vm.maxPage = parseInt(vm.cantidadTotal / vm.cantidad);

                if (vm.cantidadTotal % vm.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            vm.showAnexos = function (muestra) {
                console.log('muestra', muestra);
                var id = muestra.show_id_muestra;
                muestraService.scanDirByIdMuestra(id).then(function (response) {
                    if (response.data !== null) {
                        var data = angular.toJson(response.data)
                        vm.loadTreeAnexosConHojaRutaMuestra(data);
                        $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("move", $(window).width() / 2 - $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("width") / 2, $(window).height() / 2 - $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("height") / 2);
                        $('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow('expand');
                        $('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow('open');
                    }
                });
            }

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



            function getMuestrasTerminadas(pagina, cantidad, show_id_muestra, estado_muestra, fecha_llegada_inicio,
                    fecha_llegada_fin, cliente, producto, lote, fecha_pre_conclusion_inicio, fecha_pre_conclusion_fin,
                    fecha_conclusion_inicio, fecha_conclusion_fin, responsable_muestra, ensayo,
                    estado_ensayo, especificacion, resultado, fecha_programacion_inicio, fecha_programacion_fin,
                    fecha_analisis_inicio, fecha_analisis_fin, responsable_ensayo) {
                return $http({
                    method: 'GET',
                    url: 'index.php',
                    params: {
                        action: 'queryDb',
                        query: 'getMuestrasGrillaGerencia',
                        pagina: pagina,
                        cantidad: cantidad,
                        show_id_muestra: show_id_muestra,
                        estado_muestra: estado_muestra,
                        fecha_llegada_inicio: fecha_llegada_inicio,
                        fecha_llegada_fin: fecha_llegada_fin,
                        cliente: cliente,
                        producto: producto,
                        lote: lote,
                        fecha_pre_conclusion_inicio: fecha_pre_conclusion_inicio,
                        fecha_pre_conclusion_fin: fecha_pre_conclusion_fin,
                        fecha_conclusion_inicio: fecha_conclusion_inicio,
                        fecha_conclusion_fin: fecha_conclusion_fin,
                        responsable_muestra: responsable_muestra,
                        ensayo: ensayo,
                        estado_ensayo: estado_ensayo,
                        especificacion: especificacion,
                        resultado: resultado,
                        fecha_programacion_inicio: fecha_programacion_inicio,
                        fecha_programacion_fin: fecha_programacion_fin,
                        fecha_analisis_inicio: fecha_analisis_inicio,
                        fecha_analisis_fin: fecha_analisis_fin,
                        responsable_ensayo: responsable_ensayo
                    }
                });
            }

            vm.evaluarAlertaFechaCompromiso = function (fechaCompromiso, estadoMuestra) {
                return factoryBandejaEntradaService
                        .evaluarAlertaFechaCompromisoGerencia(
                                vm.usuario.session.systemsParameters.diasAnticipacionAlertaBandejaEntrada,
                                fechaCompromiso, estadoMuestra);
            };

        })
        .component('sgmBeMuestrasGerencia', {
            templateUrl: './views/ComponentsJS/bandeja-entrada/components/be-muestras-gerencia/be-muestras-gerencia.html',
            controller: 'sgmBeMuestrasGerenciaCtrl',
            controllerAs: 'vm',
            bindings: {
                usuario: '<',
                nombreBandeja: '<'
            }
        });
