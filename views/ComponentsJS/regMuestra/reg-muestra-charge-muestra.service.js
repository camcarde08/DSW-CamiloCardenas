'use strict'

angular.module('CompRegMuestra')

        .factory('regMuestraSearchMuestraFactory', function (muestraService, $timeout) {

            var cliente = null;
            var producto = null;
            var ensayos = [];


            var interfaz = {
                loadMuestra: function (vm, muestraData) {
                    vm.statusPantalla = 'loadMuestra';
                    //load activa
                    vm.status = 'loading';
                    switch (muestraData.id_area_analisis) {
                        case '1':
                            interfaz.loadMuestrFQ(vm, muestraData);
                            break;
                        case '2':
                            interfaz.loadCampoActiva(vm, muestraData);
                            interfaz.loadCampoEstadoAnalisis(vm, muestraData);
                            interfaz.loadCampoPrioridad(vm, muestraData);
                            interfaz.loadCampoCotizacion(vm, muestraData);
                            interfaz.loadCampoRemision(vm, muestraData);
                            interfaz.loadCampoFechaLlegada(vm, muestraData);
                            interfaz.loadCampoFechaCompromiso(vm, muestraData);
                            interfaz.loadCampoCliente(vm, muestraData);
                            interfaz.loadCampoContacto(vm, muestraData);
                            interfaz.loadCampoObservaciones(vm, muestraData);
                            //interfaz.loadCampoAreaAnalisis(vm, muestraData);
                            interfaz.loadCampoFechaMuestreo(vm, muestraData);
                            interfaz.loadCampoTecnicaUsada(vm, muestraData);
                            //interfaz.loadCampoTipoMuestra(vm, muestraData);
                            interfaz.loadCampoAreaMic(vm, muestraData);
                            interfaz.loadCampoPlanta(vm, muestraData);
                            interfaz.loadCampoSanitizante(vm, muestraData);
                            interfaz.loadCampoFrotis(vm, muestraData);
                            interfaz.loadCampoEspMesofilos(vm, muestraData);
                            interfaz.loadCampoEspMohos(vm, muestraData);
                            interfaz.loadCampoProducto(vm, muestraData);
                            interfaz.loadCampoEmpaque(vm, muestraData);
                            interfaz.loadCampoEnvase(vm, muestraData);
                            interfaz.loadCampoFechaFabricacion(vm, muestraData);
                            interfaz.loadCampoFechaVencimiento(vm, muestraData);
                            interfaz.loadCampoTamanoLote(vm, muestraData);
                            interfaz.loadCampoNumLote(vm, muestraData);
                            interfaz.loadCampoCantidadLote(vm, muestraData);
                            interfaz.loadGridEnsayos(vm, muestraData);
                            interfaz.loadCampoIdmuestra(vm, muestraData);
                            interfaz.loadButtonVerHistorial(vm, muestraData);
                            interfaz.loadButtonverEstados(vm, muestraData);
                            interfaz.loadButtonRegistrarMuestra(vm, muestraData);
                            interfaz.loadButtonActualizarAnalisis(vm, muestraData);
                            interfaz.loadCampoLabFabricante(vm, muestraData);
                            interfaz.loadCampoProcedencia(vm, muestraData);
                            interfaz.loadCampoCondicionesGenerales(vm, muestraData);
                            interfaz.loadCampoIdentificadorCliente(vm, muestraData);
                            interfaz.loadCampoEstabilidadMic(vm, muestraData);
                            interfaz.loadCampoPuntoToma(vm, muestraData);
                            interfaz.loadCampoPlantaTecnicaUsada(vm, muestraData);
                            interfaz.loadCampoResponsableToma(vm, muestraData);
                            interfaz.loadCampoSuperficieEquipo(vm, muestraData);
                            interfaz.loadCampoEspEColi(vm, muestraData);
                            interfaz.loadCampoPlantaArea(vm, muestraData);
                            $timeout(function () {
                                vm.dropDownTipoMuestraSettings.disabled = true;
                                vm.status = 'ready';
                            }, 1800);
                            break;
                        case '4':
                            interfaz.loadMuestraEST(vm, muestraData);
                            break;
                    }














                },
                loadMuestraEST: function (vm, muestraData) {
                    interfaz.loadCampoActiva(vm, muestraData);
                    interfaz.loadCampoEstadoAnalisis(vm, muestraData);
                    interfaz.loadCampoPrioridad(vm, muestraData);
                    interfaz.loadCampoCotizacion(vm, muestraData);
                    interfaz.loadCampoRemision(vm, muestraData);
                    interfaz.loadCampoFechaLlegada(vm, muestraData);
                    interfaz.loadCampoFechaCompromiso(vm, muestraData);
                    interfaz.loadCampoCliente(vm, muestraData);
                    interfaz.loadCampoContacto(vm, muestraData);
                    interfaz.loadCampoObservaciones(vm, muestraData);
                    interfaz.loadCampoAreaAnalisis(vm, muestraData);

                    interfaz.loadCampoTipoMuestra(vm, muestraData);

                    interfaz.loadCampoProducto(vm, muestraData);
                    interfaz.loadCampoEmpaque(vm, muestraData);
                    interfaz.loadCampoEnvase(vm, muestraData);
                    interfaz.loadCampoFechaFabricacion(vm, muestraData);
                    interfaz.loadCampoFechaVencimiento(vm, muestraData);
                    interfaz.loadCampoTamanoLote(vm, muestraData);
                    interfaz.loadCampoNumLote(vm, muestraData);
                    interfaz.loadCampoCantidadLote(vm, muestraData);

                    interfaz.loadCampoIdmuestra(vm, muestraData);
                    interfaz.loadButtonVerHistorial(vm, muestraData);
                    interfaz.loadButtonverEstados(vm, muestraData);
                    interfaz.loadButtonRegistrarMuestra(vm, muestraData);
                    interfaz.loadButtonActualizarAnalisis(vm, muestraData);
                    interfaz.loadCampoLabFabricante(vm, muestraData);
                    interfaz.loadCampoProcedencia(vm, muestraData);
                    interfaz.loadCampoCondicionesGenerales(vm, muestraData);
                    interfaz.loadCampoIdentificadorCliente(vm, muestraData);

                    if (interfaz.loadTipoEstabilidad(vm, muestraData)) {

                    }

                    $timeout(function () {
                        vm.dropDownTipoMuestraSettings.disabled = true;
                        vm.status = 'ready';
                    }, 1800);
                },
                loadMuestrFQ: function (vm, muestraData) {
                    interfaz.loadCampoActiva(vm, muestraData);
                    interfaz.loadCampoEstadoAnalisis(vm, muestraData);
                    interfaz.loadCampoPrioridad(vm, muestraData);
                    interfaz.loadCampoCotizacion(vm, muestraData);
                    interfaz.loadCampoRemision(vm, muestraData);
                    interfaz.loadCampoFechaLlegada(vm, muestraData);
                    interfaz.loadCampoFechaCompromiso(vm, muestraData);
                    interfaz.loadCampoCliente(vm, muestraData);
                    interfaz.loadCampoContacto(vm, muestraData);
                    interfaz.loadCampoObservaciones(vm, muestraData);
                    //interfaz.loadCampoAreaAnalisis(vm, muestraData);
                    interfaz.loadCampoFechaMuestreo(vm, muestraData);
                    //interfaz.loadCampoTecnicaUsada(vm, muestraData);
                    interfaz.loadCampoTipoMuestra(vm, muestraData);
                    //interfaz.loadCampoAreaMic(vm, muestraData);
                    //interfaz.loadCampoPlanta(vm, muestraData);
                    //interfaz.loadCampoSanitizante(vm, muestraData);
                    //interfaz.loadCampoFrotis(vm, muestraData);
                    interfaz.loadCampoEspMesofilos(vm, muestraData);
                    //interfaz.loadCampoEspMohos(vm, muestraData);
                    interfaz.loadCampoProducto(vm, muestraData);
                    interfaz.loadCampoEmpaque(vm, muestraData);
                    interfaz.loadCampoEnvase(vm, muestraData);
                    interfaz.loadCampoFechaFabricacion(vm, muestraData);
                    interfaz.loadCampoFechaVencimiento(vm, muestraData);
                    interfaz.loadCampoTamanoLote(vm, muestraData);
                    interfaz.loadCampoNumLote(vm, muestraData);
                    interfaz.loadCampoCantidadLote(vm, muestraData);
                    interfaz.loadGridEnsayos(vm, muestraData);
                    interfaz.loadCampoIdmuestra(vm, muestraData);
                    interfaz.loadButtonVerHistorial(vm, muestraData);
                    interfaz.loadButtonverEstados(vm, muestraData);
                    interfaz.loadButtonRegistrarMuestra(vm, muestraData);
                    interfaz.loadButtonActualizarAnalisis(vm, muestraData);
                    interfaz.loadCampoLabFabricante(vm, muestraData);
                    interfaz.loadCampoProcedencia(vm, muestraData);
                    interfaz.loadCampoCondicionesGenerales(vm, muestraData);
                    interfaz.loadCampoIdentificadorCliente(vm, muestraData);
                    interfaz.loadCampoEstabilidadMic(vm, muestraData);
                    //interfaz.loadCampoPuntoToma(vm, muestraData);
                    //interfaz.loadCampoPlantaTecnicaUsada(vm, muestraData);
                    //interfaz.loadCampoResponsableToma(vm, muestraData);
                    //interfaz.loadCampoSuperficieEquipo(vm, muestraData);
                    //interfaz.loadCampoEspEColi(vm, muestraData);
                    interfaz.loadCampoPlantaArea(vm, muestraData);
                    $timeout(function () {
                        vm.dropDownTipoMuestraSettings.disabled = true;
                        vm.status = 'ready';
                    }, 1800);
                },

                loadTipoEstabilidad: function (vm, muestraData) {
                    $timeout(function () {
                        var index = vm.dropDownTipoEstabilidadSettings.source.findIndex(function (item, index, array) {
                            return item.id == muestraData.tipo_estabilidad;
                        });
                        vm.dropDownTipoEstabilidadSettings.selectedIndex = index;
                        var index2 = vm.dropDownTipoEstabilidadSettings.source[index].duraciones.findIndex(function (item, index, array) {
                            return item.id == muestraData.duracion;
                        });
                        $timeout(function () {
                            vm.pruebaSettings.apply('selectIndex', index2);
                        }, 500);
                    }, 500);




                    return true;
                },
                loadCampoPlantaArea: function (vm, muestraData) {
                    vm.plantaArea = muestraData.detalleMic.planta_area;
                },
                loadCampoEspEColi: function (vm, muestraData) {
                    vm.espEColi = muestraData.detalleMic.esp_ecoli;
                },
                loadCampoSuperficieEquipo: function (vm, muestraData) {
                    vm.superficieEquipo = muestraData.detalleMic.superficie_equipo;
                },
                loadCampoResponsableToma: function (vm, muestraData) {
                    vm.responsableToma = muestraData.detalleMic.responsable_toma;
                },
                loadCampoPlantaTecnicaUsada: function (vm, muestraData) {
                    vm.plantaTecnicaUsada = muestraData.detalleMic.planta_tec_usada;
                },
                loadCampoPuntoToma: function (vm, muestraData) {
                    vm.puntoToma = muestraData.detalleMic.punto_toma;
                },
                loadCampoEstabilidadMic: function (vm, muestraData) {
                    if (muestraData.detalleMic !== null) {
                        vm.EstabilidadMic = muestraData.detalleMic.estabilidad;
                    } else {
                        vm.EstabilidadMic = "";
                    }
                },
                loadCampoIdentificadorCliente: function (vm, muestraData) {
                    vm.identificadorCliente = muestraData.identificador_cliente;
                },
                loadCampoCondicionesGenerales: function (vm, muestraData) {
                    vm.condicionesGenerales = muestraData.condiciones_generales;
                },
                loadCampoProcedencia: function (vm, muestraData) {
                    $timeout(function () {
                        vm.procedencia = muestraData.procedencia;
                        vm.statusPantalla = 'ready';
                    }, 1700);

                },
                loadCampoLabFabricante: function (vm, muestraData) {
                    $timeout(function () {
                        vm.labFabricante = muestraData.fabricante;
                    }, 1600);

                },
                loadButtonActualizarAnalisis: function (vm, muestraData) {
                    if (muestraData.activa) {
                        vm.buttonActualizarAnalisisSettings.disabled = false;
                        vm.buttonActualizarAnalisisSettings.refresh(['disabled']);
                    } else {
                        vm.buttonActualizarAnalisisSettings.disabled = true;
                        vm.buttonActualizarAnalisisSettings.refresh(['disabled']);
                    }

                },
                loadButtonRegistrarMuestra: function (vm, muestraData) {
                    vm.buttonRegistrarAnalisisSettings.disabled = true;
                    vm.buttonRegistrarAnalisisSettings.refresh(['disabled']);
                },
                loadButtonverEstados: function (vm, muestraData) {
                    vm.buttonVerEstadosSettings.disabled = false;
                    vm.buttonVerEstadosSettings.refresh(['disabled']);
                },
                loadButtonVerHistorial: function (vm, muestraData) {
                    vm.buttonVerHistorialSettings.disabled = false;
                    vm.buttonVerHistorialSettings.refresh(['disabled']);
                },
                loadCampoIdmuestra: function (vm, muestraData) {
                    vm.realIdMuestra = muestraData.id;
                    vm.inputNumeroAnalisisSettings.disabled = true;
                    vm.inputNumeroAnalisisSettings.refresh(['disabled']);
                },
                loadGridEnsayos: function (vm, muestraData) {
                    vm.loadingEnsayos = true;
                    vm.loadedEnsayos = false;
                    ensayos = [];
                    muestraData.ensayos.forEach(function (item, index, array) {
                        ensayos[index] = {
                            idPaquete: item.id_paquete,
                            nomPaquete: item.des_paquete,
                            idEnsayo: item.id_ensayo,
                            nomEnsayo: item.desEspecifica,
                            validacion: item.validacion,
                            tiempo: item.tiempo,
                            idMetodo: item.id_metodo,
                            nomAreaAnalisis: item.area_analisis,
                            duracion: item.duracion,
                            especificacion: item.especificacion
                        }
                    });

                    $timeout(function () {
                        vm.gridEnsayosSettings.source = ensayos;
                        $timeout(function () {
                            vm.loadingEnsayos = false;
                            vm.loadedEnsayos = true;
                            vm.gridEnsayosSettings.apply('addgroup', 'nomPaquete');
                        }, 100);
                    }, 1400);

                },
                loadCampoCantidadLote: function (vm, muestraData) {
                    vm.cantidadLote = muestraData.lote.cantidad_enviada;
                },
                loadCampoNumLote: function (vm, muestraData) {
                    vm.numeroLote = muestraData.lote.numero;
                },
                loadCampoTamanoLote: function (vm, muestraData) {
                    vm.tamanoLote = muestraData.lote.tamano;
                },
                loadCampoFechaVencimiento: function (vm, muestraData) {
                    vm.fechaVencimiento = new Date(muestraData.fecha_vencimiento);
                },
                loadCampoFechaFabricacion: function (vm, muestraData) {
                    vm.fechaFabricacion = new Date(muestraData.fecha_fabricacion);
                },
                loadCampoEnvase: function (vm, muestraData) {
                    var envase = vm.dropDownEnvaseSettings.source.find(function (item, index, array) {
                        return item.id == muestraData.id_envase;
                    });
                    vm.dropDownEnvaseSettings.apply('val', {label: envase.descripcion, value: envase.id});
                    vm.envase = {label: envase.descripcion, value: envase.id};
                },
                loadCampoEmpaque: function (vm, muestraData) {
                    var empaque = vm.dropDownEmpaqueSettings.source.find(function (item, index, array) {
                        return item.id == muestraData.id_empaque;
                    });
                    console.log(empaque);
                    vm.dropDownEmpaqueSettings.apply('val', {label: empaque.descripcion, value: empaque.id});
                    vm.empaque = {label: empaque.descripcion, value: empaque.id};
                },
                loadCampoProducto: function (vm, muestraData) {
                    producto = vm.inputProductoSettings.source.find(function (item, index, array) {
                        return item.id == muestraData.id_producto;
                    });
                    vm.inputProductoSettings.apply('val', {label: producto.nombreProducto, value: producto.id});
                    vm.producto = {label: producto.nombreProducto, value: producto.id};
                },
                loadCampoEspMohos: function (vm, muestraData) {
                    vm.espMohosLevaduras = muestraData.detalleMic.esp_moh_lev;
                },
                loadCampoEspMesofilos: function (vm, muestraData) {
                    vm.espAerobiosMesofilos = muestraData.detalleMic.esp_aer_mes;
                },
                loadCampoFrotis: function (vm, muestraData) {
                    vm.frotisRealizado = muestraData.detalleMic.frotis;
                },
                loadCampoSanitizante: function (vm, muestraData) {
                    vm.sanitizante = muestraData.detalleMic.sanitizante;
                },
                loadCampoPlanta: function (vm, muestraData) {
                    vm.planta = muestraData.detalleMic.planta;
                },
                loadCampoAreaMic: function (vm, muestraData) {
                    $timeout(function () {
                        vm.dropDownAreaMicroSettings.apply('selectIndex', vm.dropDownAreaMicroSettings.source.findIndex(function (item, index, array) {
                            return item.id == muestraData.detalleMic.area_microbiologica;
                        }));
                    }, 1300);
                },
                loadCampoTipoMuestra: function (vm, muestraData) {
                    $timeout(function () {
                        vm.dropDownTipoMuestraSettings.apply('selectIndex', vm.dropDownTipoMuestraSettings.source.findIndex(function (item, index, array) {
                            return item.prefijo == muestraData.prefijo;
                        }));

                    }, 1200);

                },
                loadCampoTecnicaUsada: function (vm, muestraData) {
                    $timeout(function () {
                        muestraData.detalleMic.tecnicaUsada.forEach(function (item, index, array) {
                            vm.dropDownTecnicaUsadaSettings.apply('checkIndex', vm.dropDownTecnicaUsadaSettings.source.findIndex(function (item1, index1, array1) {
                                return item.id_metodo == item1.id;
                            }));
                        });
                    }, 1100);
                },
                loadCampoFechaMuestreo: function (vm, muestraData) {
                    vm.fechaMuestreo = new Date(muestraData.detalleMic.fecha_muestreo);
                },
                loadCampoAreaAnalisis: function (vm, muestraData) {
                    /*vm.dropDownAreaAnalisisSettings.apply('selectIndex', vm.dropDownAreaAnalisisSettings.source.findIndex(function (item, index, array) {
                     return item.id == muestraData.id_area_analisis;
                     }));*/
                },
                loadCampoObservaciones: function (vm, muestraData) {
                    vm.observaciones = muestraData.observacion;
                },
                loadCampoContacto: function (vm, muestraData) {
                    $timeout(function () {
                        vm.dropDownListContactoSettings.apply('selectIndex', cliente.contactos.findIndex(function (item, index, array) {
                            return item.id == muestraData.id_contacto
                        }));
                    }, 1000);
                },
                loadCampoCliente: function (vm, muestraData) {
                    cliente = vm.inputClienteSettings.source.find(function (item, index, array) {
                        return item.id == muestraData.id_tercero;
                    });
                    vm.inputClienteSettings.apply('val', {label: cliente.nombre, value: cliente.id});
                    vm.cliente = {label: cliente.nombre, value: cliente.id};
                },
                loadCampoFechaCompromiso: function (vm, muestraData) {
                    vm.fechaCompromiso = new Date(muestraData.fecha_compromiso);
                },
                loadCampoFechaLlegada: function (vm, muestraData) {
                    vm.fechaLlegada = new Date(muestraData.fecha_llegada);
                },
                loadCampoRemision: function (vm, muestraData) {
                    vm.remision = muestraData.numero_remision;
                },
                loadCampoCotizacion: function (vm, muestraData) {
                    vm.cotizacion = muestraData.id_cotizacion;
                },
                loadCampoPrioridad: function (vm, muestraData) {
                    try {
                        vm.dropDownPrioridadSettings.apply('selectIndex', muestraData.prioridad - 1);
                    } catch (e) {

                    }
                },
                loadCampoEstadoAnalisis: function (vm, muestraData) {
                    vm.idEstadoActualMuestra = muestraData.id_estado_muestra;
                    vm.estadoActual = muestraData.descripcion_estado_muestra;
                },
                loadCampoActiva: function (vm, muestraData) {

                    vm.activa = muestraData.activa;
                    if (muestraData.activa) {
                        vm.checkBoxActivaSettings.disabled = false;
                        vm.checkBoxActivaSettings.refresh(['disabled']);
                    } else {
                        vm.checkBoxActivaSettings.disabled = true;
                        vm.checkBoxActivaSettings.refresh(['disabled']);
                    }

                }





            }

            return interfaz;
        })