'use strict'

angular.module('CompRegMuestra')

        .factory('regMuestraFactory', function ($q, $timeout, $filter, $window, $location, regMuestraJqxSettings, terceroService, areaAnalisisService, productoService, empaqueService,
                envaseService, metodoService, tipoMuestraService, areaMicrobioloicaService, productoEnsayoMuestraService, muestraService, regMuestraSearchMuestraFactory, regMuestraSaveMuestraFqFactory, tipoEstabilidadService, duracionEstabilidadService, regMuestraSaveMuestraEstFactory) {

            var interfaz = {

                initJqxSettings: function (vm) {
                    // valores default

                    vm.cotizacion = 'N/A';
                    vm.remision = 'N/A';
                    vm.identificadorCliente = 'N/A';
                    vm.EstabilidadMic = 'N/A';
                    vm.puntoToma = 'N/A';
                    vm.plantaArea = 'N/A';
                    vm.plantaTecnicaUsada = 'USP Vigente';
                    vm.responsableToma = 'SFC';
                    vm.superficieEquipo = 'N/A';
                    vm.planta = 'N/A';
                    vm.sanitizante = 'N/A';
                    vm.frotisRealizado = 'N/A';
                    vm.espAerobiosMesofilos = 'N/A';
                    vm.espMohosLevaduras = 'N/A';
                    vm.espEColi = 'N/A';
                    vm.tamanoLote = 'No especificado';
                    vm.cantidadLote = 'N/A';
                    vm.observaciones = 'ESPECIFICACIONES DADAS POR EL CLIENTE';


                    vm.prioridad = {id: 1, descripcion: 'Normal', tiempoEntrega: 3};
                    vm.fechaLlegada = new Date();
                    //vm.fechaCompromiso = new Date();
                    //vm.fechaCompromiso.setDate(vm.fechaLlegada.getDate() + vm.sesionUserData.session.systemsParameters.diasHabilesFechaCompromiso);
                    vm.areaAnalisis = {};
                    vm.createRegMuestraCliente = false;
                    vm.fechaMuestreo = new Date();
                    vm.areaMicro = {};
                    vm.tipoMuestra = {};
                    vm.tecnicaUsada = {};
                    vm.fechaFabricacion = new Date();
                    vm.fechaVencimiento = new Date();
                    vm.empaque = {};
                    vm.envase = {};
                    vm.tipoEstabilidad = {};
                    vm.duracionEstabilidad = {};

                    vm.buttonLimpiarSettings = regMuestraJqxSettings.buttonLimpiarSettings;
                    vm.buttonVerHistorialSettings = regMuestraJqxSettings.buttonVerHistorialSettings;
                    vm.buttonVerEstadosSettings = regMuestraJqxSettings.buttonVerEstadosSettings;
                    vm.buttonRegistrarAnalisisSettings = regMuestraJqxSettings.buttonRegistrarAnalisisSettings;
                    vm.buttonActualizarAnalisisSettings = regMuestraJqxSettings.buttonActualizarAnalisisSettings;
                    vm.inputNumeroAnalisisSettings = regMuestraJqxSettings.inputNumeroAnalisisSettings;
                    vm.buttonSearchAnalisisSettings = regMuestraJqxSettings.buttonSearchAnalisisSettings;
                    vm.checkBoxActivaSettings = regMuestraJqxSettings.checkBoxActivaSettings;
                    vm.inputEstadoActualAnalisisSettings = regMuestraJqxSettings.inputEstadoActualAnalisisSettings;
                    vm.dropDownPrioridadSettings = regMuestraJqxSettings.dropDownPrioridadSettings;
                    vm.inputNumeroCotizacionSettings = regMuestraJqxSettings.inputNumeroCotizacionSettings;
                    vm.inputNumeroRemisionSettings = regMuestraJqxSettings.inputNumeroRemisionSettings;
                    vm.dateInputFechaLlegadaSettings = regMuestraJqxSettings.dateInputFechaLlegadaSettings;
                    vm.dateInputFechaCompromisoSettings = regMuestraJqxSettings.dateInputFechaCompromisoSettings;
                    vm.inputClienteSettings = regMuestraJqxSettings.inputClienteSettings;
                    vm.dropDownListContactoSettings = regMuestraJqxSettings.dropDownListContactoSettings;
                    vm.inputAreaContactoSettings = regMuestraJqxSettings.inputAreaContactoSettings;
                    vm.inputLabFabricanteSettings = regMuestraJqxSettings.inputLabFabricanteSettings;
                    vm.inputProcedenciaSettings = regMuestraJqxSettings.inputProcedenciaSettings;
                    vm.textAreaObservacionesSettings = regMuestraJqxSettings.textAreaObservacionesSettings;
                    vm.dropDownAreaAnalisisSettings = regMuestraJqxSettings.dropDownAreaAnalisisSettings;
                    vm.regMuestraCoordinadorAreaSettings = regMuestraJqxSettings.regMuestraCoordinadorAreaSettings;
                    vm.inputProductoSettings = regMuestraJqxSettings.inputProductoSettings;
                    vm.inputTipoProductoSettings = regMuestraJqxSettings.inputTipoProductoSettings;
                    vm.dropDownEmpaqueSettings = regMuestraJqxSettings.dropDownEmpaqueSettings;
                    vm.buttonAddEmpaqueSettings = regMuestraJqxSettings.buttonAddEmpaqueSettings;
                    vm.dropDownEnvaseSettings = regMuestraJqxSettings.dropDownEnvaseSettings;
                    vm.buttonAddEnvaseSettings = regMuestraJqxSettings.buttonAddEnvaseSettings;
                    vm.dateInputFechaFabricacionSettings = regMuestraJqxSettings.dateInputFechaFabricacionSettings;
                    vm.dateInputFechaVencimientoSettings = regMuestraJqxSettings.dateInputFechaVencimientoSettings;
                    vm.inputTamanoLoteSettings = regMuestraJqxSettings.inputTamanoLoteSettings;
                    vm.inputNumeroLoteSettings = regMuestraJqxSettings.inputNumeroLoteSettings;
                    vm.inputCantidadEnviadaLoteSettings = regMuestraJqxSettings.inputCantidadEnviadaLoteSettings;
                    vm.gridPrincipioActivoSettings = regMuestraJqxSettings.gridPrincipioActivoSettings;
                    vm.gridEnsayosSettings = regMuestraJqxSettings.gridEnsayosSettings;
                    vm.dateInputFechaMuestreoSettings = regMuestraJqxSettings.dateInputFechaMuestreoSettings;
                    vm.dropDownTecnicaUsadaSettings = regMuestraJqxSettings.dropDownTecnicaUsadaSettings;
                    vm.dropDownTipoMuestraSettings = regMuestraJqxSettings.dropDownTipoMuestraSettings;
                    vm.dropDownAreaMicroSettings = regMuestraJqxSettings.dropDownAreaMicroSettings;
                    vm.inputPlantaSettings = regMuestraJqxSettings.inputPlantaSettings;
                    vm.inputSanitizanteSettings = regMuestraJqxSettings.inputSanitizanteSettings;
                    vm.inputFrotisRealizadoSettings = regMuestraJqxSettings.inputFrotisRealizadoSettings;
                    vm.textAreaEspAerobiosMesofilosSettings = regMuestraJqxSettings.textAreaEspAerobiosMesofilosSettings;
                    vm.textAreaEspMohosLevadurasSettings = regMuestraJqxSettings.textAreaEspMohosLevadurasSettings;
                    vm.inputNewEmpaqueSettings = regMuestraJqxSettings.inputNewEmpaqueSettings;
                    vm.inputNewEnvaseSettings = regMuestraJqxSettings.inputNewEnvaseSettings;
                    vm.errorNotificationSettings = regMuestraJqxSettings.errorNotificationSettings;
                    vm.successNotificationSettings = regMuestraJqxSettings.successNotificationSettings;
                    // load Text Area Condiciones Generales
                    vm.textAreaCondicionesGeneralesSettings = regMuestraJqxSettings.textAreaCondicionesGeneralesSettings;
                    vm.condicionesGenerales = 'Registro muestra cumple con las condiciones necesarias para ser analizado.\nCondición de almacenamiento: ambiente.';
                    // load identificador cliente
                    vm.inputIdentificadorClienteSettings = regMuestraJqxSettings.inputIdentificadorClienteSettings;
                    // load estabilidad mic
                    vm.regMuestraEstabilidadMicSettings = regMuestraJqxSettings.regMuestraEstabilidadMicSettings;
                    // load punto de toma 
                    vm.inputPuntoTomaSettings = regMuestraJqxSettings.inputPuntoTomaSettings;
                    // load especificaciones E Coli
                    vm.textAreaEspEColiSettings = regMuestraJqxSettings.textAreaEspEColiSettings;
                    //load planta tecnica usada
                    vm.inputPlantaTecnicaUsadaSettings = regMuestraJqxSettings.inputPlantaTecnicaUsadaSettings;
                    // load responsable toma de muestra
                    vm.inputResponsableTomaSettings = regMuestraJqxSettings.inputResponsableTomaSettings;
                    // load planta superficie equipo
                    vm.inputSuperficieEquipoSettings = regMuestraJqxSettings.inputSuperficieEquipoSettings;
                    // load planta area
                    vm.inputPlantaAreaSettings = regMuestraJqxSettings.inputPlantaAreaSettings;
                    // load tipo estabilidades
                    vm.dropDownTipoEstabilidadSettings = regMuestraJqxSettings.dropDownTipoEstabilidadSettings;
                    // load duracion estabilidad
                    vm.dropDownDuracionEstabilidadSettings = regMuestraJqxSettings.dropDownDuracionEstabilidadSettings;

                    vm.dropDownDuracionEstabilidadSettings.source = vm.tipoEstabilidad.duraciones;
                    vm.dropDownDuracionEstabilidadSettings.displayMember = 'name';
                },
                getActiveMetodo: function (vm) {
                    return metodoService.getActiveMetodo().then(function (response) {
                        if (response.data.code === 0) {
                            vm.dropDownTecnicaUsadaSettings.source = response.data.data;
                            vm.dropDownTecnicaUsadaSettings.displayMember = 'descripcion';
                            vm.dropDownTecnicaUsadaSettings.disabled = false;
                            /*$timeout(function () {
                             console.log('carga valor por defecto campo tecnica usada');
                             vm.status != 'loading' ? vm.dropDownTecnicaUsadaSettings.apply('checkIndex', 1):false;
                             }, 1000);*/
                            try {


                                vm.dropDownTecnicaUsadaSettings.refresh(['source', 'displayMember', 'disabled']);


                            } catch (err) {

                            }

                        }
                    });
                },
                getAllActiveTipoMuestra: getAllActiveTipoMuestra,
                getAreasActivas: function (dropDownAreaMicroSettings) {
                    return areaMicrobioloicaService.getAreasActivas().then(function (response) {
                        if (response.data.code === 0) {
                            dropDownAreaMicroSettings.source = response.data.data;
                            dropDownAreaMicroSettings.displayMember = 'descripcion';
                            dropDownAreaMicroSettings.disabled = false;
                            try {
                                dropDownAreaMicroSettings.refresh(['source', 'displayMember', 'disabled']);
                            } catch (err) {
                                var a = 0;
                            }
                        }
                    });
                },
                getAllEmpaque: function (dropDownEmpaqueSettings) {
                    return empaqueService.getAllEmpaque().then(function (data) {
                        dropDownEmpaqueSettings.source = data.data;
                        dropDownEmpaqueSettings.disabled = false;

                        setTimeout(function(){
                            dropDownEmpaqueSettings.refresh(['source', 'disabled']);
                            return data;
                        },10);
                        // try {
                        //
                        // } catch (err) {
                        //     return data;
                        // }
                        /*dropDownEmpaqueSettings.source = data.data;
                         dropDownEmpaqueSettings.disabled = false;
                         dropDownEmpaqueSettings.displayMember = 'descripcion';
                         dropDownEmpaqueSettings.selectedIndex = 1;
                         try {
                         
                         dropDownEmpaqueSettings.refresh(['source', 'disabled', 'displayMember', 'selectedIndex']);
                         } catch (err) {
                         
                         }*/
                    });
                },
                getAllEnvase: function (dropDownEnvaseSettings) {
                    return envaseService.getAllEnvase().then(function (data) {
                        /*dropDownEnvaseSettings.source = data.data;
                         dropDownEnvaseSettings.disabled = false;
                         dropDownEnvaseSettings.displayMember = 'descripcion';
                         dropDownEnvaseSettings.selectedIndex = 1;
                         try {
                         
                         dropDownEnvaseSettings.refresh(['source', 'disabled', 'displayMember', 'selectedIndex']);
                         } catch (err) {
                         
                         }*/
                        dropDownEnvaseSettings.source = data.data;
                        dropDownEnvaseSettings.disabled = false;


                        try {
                            dropDownEnvaseSettings.refresh(['source', 'disabled']);
                            return data;
                        } catch (err) {
                            return data;
                        }
                    });
                },
                getAreasActivasJoinCoordinador: getAreasActivasJoinCoordinador,
                getProductoJoinTipoProducto: function (inputProductoSettings) {
                    return productoService.getProductoJoinTipoProducto().then(function (data) {
                        inputProductoSettings.source = data.data;
                        inputProductoSettings.disabled = false;
                        try {
                            inputProductoSettings.refresh(['source', 'disabled']);
                            return data;
                        } catch (err) {
                            return data;
                        }
                    });
                },
                getTerceros: function (vm) {
                    return terceroService.getTercerosJoinContactos().then(function (data, status) {

                        vm.inputClienteSettings.source = data.data;
                        vm.inputClienteSettings.disabled = false;


                        try {
                            vm.inputClienteSettings.refresh(['source', 'disabled']);
                            return data;
                        } catch (err) {
                            return data;
                        }

                    });
                },

                loadEnsayosGrid: function (vm) {
                    if (vm.areaAnalisis !== null && typeof vm.areaAnalisis === 'object' && vm.producto !== null && typeof vm.producto === 'object' && vm.statusPantalla !== 'loadMuestra') {
                        if (vm.areaAnalisis.id != 4) {
                            vm.loadingEnsayos = true;
                            vm.loadedEnsayos = false;
                            productoEnsayoMuestraService.getEnsayoByIdProductoIdAreaA(parseInt(vm.producto.value), vm.areaAnalisis.id)
                                    .then(function (data) {
                                        if (data.data.code === 0) {
                                            vm.gridEnsayosSettings.source = data.data.data;
                                            $timeout(function () {
                                                $timeout(function () {
                                                    vm.loadingEnsayos = false;
                                                    vm.loadedEnsayos = true;
                                                }, 2000);
                                                vm.gridEnsayosSettings.apply('addgroup', 'nomPaquete');
                                            }, 1);
                                        } else {
                                            // no se encontraron registros
                                        }
                                    });
                        } else {
                            if (vm.tipoEstabilidad.id && vm.duracionEstabilidad.id) {
                                vm.loadingEnsayos = true;
                                vm.loadedEnsayos = false;
                                productoEnsayoMuestraService.getEnsayoByIdProductoIdAreaA(parseInt(vm.producto.value), vm.areaAnalisis.id)
                                        .then(function (response) {
                                            vm.loadingEnsayos = false;
                                            vm.loadedEnsayos = true;
                                            var contPaq = -1;
                                            var paquetes = [];
                                            var currentPaquete = null;
                                            response.data.data.forEach(function (element, index, array) {
                                                element.temperaturas = {
                                                    t0: true,
                                                    t1: true,
                                                    t2: true,
                                                    t3: true
                                                }
                                                if (element.idPaquete != currentPaquete) {
                                                    currentPaquete = element.idPaquete;
                                                    contPaq++;
                                                    paquetes[contPaq] = {
                                                        idPaquete: element.idPaquete,
                                                        nomPaquete: element.nomPaquete,
                                                        ensayos: []
                                                    };
                                                    paquetes[contPaq].ensayos.push(element);
                                                } else {
                                                    paquetes[contPaq].ensayos.push(element);
                                                }
                                            }, this);

                                            var a = vm;
                                            vm.ensayosEstabilidad = [];
                                            var contador = 0;
                                            for (var i = 0; i < vm.tipoEstabilidad.duraciones.length; i++) {
                                                vm.ensayosEstabilidad[contador] = angular.copy(vm.tipoEstabilidad.duraciones[i]);
                                                vm.ensayosEstabilidad[contador].paquetes = angular.copy(paquetes);
                                                contador++;
                                                if (vm.tipoEstabilidad.duraciones[i].id == vm.duracionEstabilidad.id) {
                                                    break;
                                                }
                                            }

                                            var x = 0;
                                        });
                            }

                        }

                    }
                },
                validateSelectedAreaAnalisis: function (vm) {
                    vm.isInputFechaMuestreo = false;
                    vm.isDropDownTecnicaUsada = false;
                    vm.isInputEstabilidadMic = false;
                    vm.isDropDownTipoMuestra = false;
                    vm.isDropDownAreaMicro = false;
                    switch (vm.areaAnalisis.id) {
                        case '1':
                            vm.rowTipoMuestraStyle = 'sgm-blue-row';
                            vm.isDropDownTipoMuestra = true;
                            break;

                        case '2':

                            vm.rowTipoMuestraStyle = 'sgm-white-row';
                            vm.isInputFechaMuestreo = true;
                            vm.isDropDownTecnicaUsada = true;
                            vm.isInputEstabilidadMic = true;
                            vm.isDropDownTipoMuestra = true;
                            vm.isDropDownAreaMicro = true;
                            break;

                        case '4':
                            vm.rowTipoMuestraStyle = 'sgm-blue-row';
                            vm.isDropDownTipoMuestra = true;
                            break;



                        default:
                            break;
                    }
                },
                test: function (vm) {
                    var log = [];
                    angular.forEach(vm.areaAnalisis.tiposMuestra, function (value, key) {
                        this.push(
                                {
                                    html: "<div><div>Title: Do the Work</div><div>Author: Steven Pressfield</div></div>",
                                    title: "Do the Work",
                                    group: "Business & Investing"
                                }
                        );
                    }, log);
                    //vm.dropDownTipoMuestraSettings.source = log;
                    // vm.dropDownTipoMuestraSettings.source = [
                    // 	// Business & Investing
                    // 	{ html: "<div><div>Title: Do the Work</div><div>Author: Steven Pressfield</div></div>", title: "Do the Work", group: "Business & Investing" },
                    // 	{ html: "<div><div>Title: Think and Grow Rich</div><div>Author: Napoleon Hill</div></div>", title: "Think and Grow Rich", group: "Business & Investing" },
                    // 	{ html: "<div><div>Title: The Toyota Way to Continuous...</div><div>Author: Jeffrey K. Liker</div></div>", title: "The Toyota Way to Continuous...", group: "Business & Investing" },
                    // 	{ html: "<div><div>Title: Redesigning Leadership </div><div>Author: John Maeda</div></div>", title: "Redesigning Leadership ", group: "Business & Investing" },
                    // 	// Computer & Internet Books
                    // 	{ html: "<div><div>Title: MacBook Pro Portable Genius</div><div>Author: Brad Miser</div></div>", title: "MacBook Pro Portable Genius", group: "Computer & Internet Books" },
                    // 	{ html: "<div><div>Title: Social Media Metrics Secrets</div><div>Author: John Lovett</div></div>", title: "Social Media Metrics Secrets", group: "Computer & Internet Books" },
                    // 	{ html: "<div><div>Title: iPad 2: The Missing Manual</div><div>Author: J D Biersdorfer J.D</div></div>", title: "iPad 2: The Missing Manual", group: "Computer & Internet Books" },
                    // 	// History
                    // 	{ html: "<div><div>Lincoln and His Admirals</div><div>Author:Craig L. Symonds</div></div>", title: "Lincoln and His Admirals", group: "History" },
                    // 	{ html: "<div><div>The Dogs of War: 1861</div><div>Author:Emory M. Thomas</div></div>", title: "The Dogs of War: 1861", group: "History" },
                    // 	{ html: "<div><div>Cleopatra: A Life</div><div>Author:Stacy Schiff</div></div>", title: "Cleopatra: A Life", group: "History" },
                    // 	{ html: "<div><div>Mother Teresa: A Biography</div><div>Author:Meg Greene</div></div>", title: "Mother Teresa: A Biography", group: "History" },
                    // 	{ html: "<div><div>The Federalist Papers</div><div>Author:John Jay</div></div>", title: "The Federalist Papers", group: "History" }
                    // ];

                },
                validateIsMicrobiologico: function (vm) {
//                    if (vm.areaAnalisis.id === '2' || vm.areaAnalisis.id === '1') {
//
//
//                        vm.dropDownTipoMuestraSettings.source = vm.areaAnalisis.tiposMuestra;
//                        vm.dropDownTipoMuestraSettings.displayMember = 'descripcion';
//                        vm.dropDownTipoMuestraSettings.disabled = false;
//                        //interfaz.test(vm);
//
//
//
//                        return true;
//                    } else if (vm.areaAnalisis.id === '4') {
//                        vm.dropDownTipoMuestraSettings.source = vm.areaAnalisis.tiposMuestra;
//                        vm.dropDownTipoMuestraSettings.displayMember = 'descripcion';
//                        vm.dropDownTipoMuestraSettings.disabled = false;
//
//                    } else {
//                        return false;
//                    }
                },
                validateIsPlanta: function (vm) {
                    if (vm.tipoMuestra.id === 6) {
                        return true;
                    } else {
                        return false;
                    }
                },
                watcherCliente: function (scope, vm) {
                    scope.$watch(angular.bind(vm, function () {
                        return vm.cliente;
                    }), function (newVal) {
                        vm.dropDownListContactoSettings.source = [];
                        if (newVal !== null && typeof newVal === 'object') {
                            // carga laboratorio fabricante de acuerdo al cliente seleccionado
                            vm.labFabricante = newVal.label;
                            //carga procedencia de acuerdo al cliente seleccionado
                            vm.procedencia = newVal.label;
                            // carga nuevo source para el dropdownlist de contactos
                            var currentClientObject = vm.inputClienteSettings.source.find(function (item) {
                                return item.id === this;
                            }, parseInt(newVal.value));
                            if (currentClientObject !== undefined) {
                                vm.dropDownListContactoSettings.source = currentClientObject.contactos;
                                vm.dropDownListContactoSettings.displayMember = 'nombre';
                                vm.dropDownListContactoSettings.selectedIndex = 0;
                                vm.dropDownListContactoSettings.refresh(['source', 'displayMember', 'selectedIndex']);
                            }

                        }
                    });
                },
                watcherProducto: function (scope, vm) {
                    scope.$watch(angular.bind(vm, function () {
                        return vm.producto;
                    }), function (newVal) {

                        if (newVal !== null && typeof newVal === 'object') {
                            var currentProductoObject = vm.inputProductoSettings.source.find(function (item) {
                                return item.id === this;
                            }, parseInt(newVal.value));
                            if (currentProductoObject !== undefined) {
                                vm.tipoProducto = currentProductoObject.descripcionFormula;
                            }
                            interfaz.loadEnsayosGrid(vm);
                            productoService.getPrincipiosActivosByIdProducto(parseInt(newVal.value))
                                    .then(function (data) {
                                        vm.gridPrincipioActivoSettings.source = data.data;

                                    });
                        }
                    });
                },
                watcherAreaAnalisis: function (scope, vm) {
                    scope.$watch(angular.bind(vm, function () {
                        return vm.areaAnalisis;
                    }), function (newVal) {
                        if (newVal !== null && typeof newVal === 'object') {
                            interfaz.loadEnsayosGrid(vm);
                        }
                    });

                },
                crearNuevoEmpaque: function (vm) {
                    angular.element('#createNewEmpaqueModal').modal('hide');
                    vm.dropDownEmpaqueSettings.disabled = true;
                    vm.dropDownEmpaqueSettings.refresh(['disabled']);
                    empaqueService.createNewEmpaque(vm.nuevoEmpaque).then(function (data) {
                        if (data.data.code === '00000') {
                            vm.nuevoEmpaque = '';
                            interfaz.getAllEmpaque(vm.dropDownEmpaqueSettings);
                        }
                    });
                },
                crearNuevoEnvase: function (vm) {
                    angular.element('#createNewEnvaseModal').modal('hide');
                    vm.dropDownEnvaseSettings.disabled = true;
                    vm.dropDownEnvaseSettings.refresh(['disabled']);
                    envaseService.createNewEnvase(vm.nuevoEnvase).then(function (data) {
                        if (data.data.code === '00000') {
                            vm.nuevoEnvase = '';
                            interfaz.getAllEnvase(vm.dropDownEnvaseSettings);
                        }
                    });
                },
                validarFechaCompromiso: function (vm) {
                    return vm.fechaCompromiso.getTime() < vm.fechaLlegada.getTime() ? (
                            angular.element('#fechaCompromiso').tooltip('show'),
                            interfaz.openErrorNotification(vm, 'Error en la fecha de compromiso seleccionada'),
                            false
                            ) :
                            true;
                },
                validarCliente: function (vm) {

                    return typeof vm.cliente !== 'object' ?
                            (
                                    angular.element('#cliente').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el cliente seleccionado'),
                                    false
                                    ) :
                            true;
                },
                validarContacto: function (vm) {
                    return typeof vm.contacto !== 'object' ?
                            (
                                    angular.element('#contacto').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el contacto seleccionado'),
                                    false
                                    ) :
                            true;
                },
                validarLabFabricante: function (vm) {
                    return vm.labFabricante === "" || vm.labFabricante === null || vm.labFabricante === undefined ?
                            (
                                    angular.element('#labFabricante').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en laboratorio fabricante digitado'),
                                    false
                                    ) :
                            true;
                },
                validarProcedencia: function (vm) {
                    return vm.procedencia === "" || vm.procedencia === null || vm.procedencia === undefined ?
                            (
                                    angular.element('#procedencia').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en procedencia digitada'),
                                    false
                                    ) :
                            true;
                },
                validarAreaAnalisis: function (vm) {
                    return vm.areaAnalisis.id === undefined ?
                            (
                                    angular.element('#areaAnalisis').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el área de análisis seleccionada'),
                                    false
                                    ) :
                            (
                                    vm.areaAnalisis.coordinador === undefined || vm.areaAnalisis.coordinador == null || vm.areaAnalisis.coordinador === '' ?
                                    (
                                            angular.element('#areaAnalisis').tooltip('show'),
                                            interfaz.openErrorNotification(vm, 'Error el área de análisis seleccionada no posee un coordinador asignado'),
                                            false
                                            ) :
                                    true

                                    );
                },
                validarFechaMuestreo: function (vm) {
                    return typeof vm.fechaMuestreo !== 'object' ?
                            (
                                    angular.element('#fechaMuestreo').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la fecha de muestreo'),
                                    false
                                    ) :
                            true;
                },
                validarTecnicaUsada: function (vm) {
                    return interfaz.getTecnicaUsada(vm.dropDownTecnicaUsadaSettings).length === 0 ?
                            (
                                    angular.element('#tecnicaUsada').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la Especificación selecciona'),
                                    false
                                    ) :
                            true
                },
                validarTipoMuestra: function (vm) {
                    return vm.tipoMuestra.id === undefined ?
                            (
                                    angular.element('#tipoMuestra').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el tipo de análisis seleccionado.'),
                                    false
                                    ) :
                            true
                },
                validarAreaMicrobiologica: function (vm) {
                    return vm.areaMicro.id === undefined ?
                            (
                                    angular.element('#areaMicro').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el área microbiologica seleccionada.'),
                                    false
                                    ) :
                            true
                },
                validarPlanta: function (vm) {
                    return true;
                },
                validarSanitizante: function (vm) {
                    return vm.sanitizante === '' || vm.sanitizante === null || vm.sanitizante === undefined ?
                            (
                                    angular.element('#sanitizante').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el sanitizante digitado.'),
                                    false
                                    ) : true;
                },
                validarFrotis: function (vm) {
                    return vm.frotisRealizado === '' || vm.frotisRealizado === null || vm.frotisRealizado === undefined ?
                            (
                                    angular.element('#frotis').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el frotis digitado.'),
                                    false
                                    ) : true;
                },
                validarEspAerobiosMesaofilos: function (vm) {
                    return vm.espAerobiosMesofilos === '' || vm.espAerobiosMesofilos === null || vm.espAerobiosMesofilos === undefined ?
                            (
                                    angular.element('#espAerobiosMesofilos').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la especificación aerobios mesofilos digitada.'),
                                    false
                                    ) : true;
                },
                validarEspMohosLevaduras: function (vm) {
                    return vm.espMohosLevaduras === '' || vm.espMohosLevaduras === null || vm.espMohosLevaduras === undefined ?
                            (
                                    angular.element('#espMohosLevaduras').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la especificación de mohos y levaduras digitada.'),
                                    false
                                    ) : true;
                },
                validarEstabilidadMic: function (vm) {
                    return vm.EstabilidadMic === '' || vm.EstabilidadMic === null || vm.EstabilidadMic === undefined ?
                            (
                                    angular.element('#EstabilidadMic').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la estabilidad microbiologica digitada.'),
                                    false
                                    ) : true;
                },
                validarPlantaTecnicaUsada: function (vm) {
                    return vm.plantaTecnicaUsada === '' || vm.plantaTecnicaUsada === null || vm.plantaTecnicaUsada === undefined ?
                            (
                                    angular.element('#plantaTecnicaUsada').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la tecnica digitada.'),
                                    false
                                    ) : true;
                },
                validarResponsableToma: function (vm) {
                    return vm.responsableToma === '' || vm.responsableToma === null || vm.responsableToma === undefined ?
                            (
                                    angular.element('#responsableToma').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el responsable de toma de muestra digitado.'),
                                    false
                                    ) : true;
                },
                validarSuperficieEquipo: function (vm) {
                    return vm.superficieEquipo === '' || vm.superficieEquipo === null || vm.superficieEquipo === undefined ?
                            (
                                    angular.element('#superficieEquipo').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la superficie o equipo digitado.'),
                                    false
                                    ) : true;
                },
                validarEspEColi: function (vm) {
                    return vm.espEColi === '' || vm.espEColi === null || vm.espEColi === undefined ?
                            (
                                    angular.element('#espEColi').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en las especificaciones E Coli digitadas.'),
                                    false
                                    ) : true;
                },
                validarPlantaArea: function (vm) {
                    return vm.plantaArea === '' || vm.plantaArea === null || vm.plantaArea === undefined ?
                            (
                                    angular.element('#plantaArea').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el responsable de toma de muestra digitado.'),
                                    false
                                    ) : true;
                },
                validarDetalleAreaMicrobiologicaPlanta: function (vm) {
                    return interfaz.validarPlantaArea(vm) &&
                            interfaz.validarPlantaTecnicaUsada(vm) &&
                            interfaz.validarResponsableToma(vm) &&
                            interfaz.validarSuperficieEquipo(vm) &&
                            interfaz.validarPlanta(vm) &&
                            interfaz.validarSanitizante(vm) &&
                            interfaz.validarFrotis(vm) &&
                            interfaz.validarEspAerobiosMesaofilos(vm) &&
                            interfaz.validarEspMohosLevaduras(vm) &&
                            interfaz.validarEspEColi(vm) ?
                            true :
                            false;
                },
                validarPuntoToma: function (vm) {
                    return vm.puntoToma === '' || vm.puntoToma === null || vm.puntoToma === undefined ?
                            (
                                    angular.element('#puntoToma').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el punto de toma digitado.'),
                                    false
                                    ) : true;
                },
                validarDetalleAreaMicrobiologicaAgua: function (vm) {
                    return interfaz.validarPuntoToma(vm) ?
                            true :
                            false;
                },
                validarDetalleAreaAnalisis: function (vm) {

                    switch (vm.areaAnalisis.id) {
                        case '1':
                            return true;

                        case '2':
                            return interfaz.validarFechaMuestreo(vm) &&
                                    interfaz.validarTecnicaUsada(vm) &&
                                    interfaz.validarEstabilidadMic(vm) &&
                                    interfaz.validarTipoMuestra(vm) &&
                                    interfaz.validarAreaMicrobiologica(vm) ?
                                    (
                                            vm.tipoMuestra.id === 6 ?
                                            interfaz.validarDetalleAreaMicrobiologicaPlanta(vm)
                                            : vm.tipoMuestra.id === 5 ?
                                            (
                                                    interfaz.validarDetalleAreaMicrobiologicaAgua(vm)
                                                    ) : (true)
                                            ) :
                                    false;
                        case '4':
                            return true;
                    }
                },
                validarProducto: function (vm) {
                    return typeof vm.producto !== 'object' || vm.producto === null || vm.producto.value === undefined ?
                            (
                                    angular.element('#producto').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el producto seleccionado.'),
                                    false
                                    ) : true;
                },
                validarEmpaque: function (vm) {
                    return typeof vm.empaque !== 'object' || vm.empaque === null || vm.empaque.value === undefined ?
                            (
                                    angular.element('#empaque').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la presentación - envase seleccionado.'),
                                    false
                                    ) : true;
                },
                validarEnvase: function (vm) {
                    return typeof vm.envase !== 'object' || vm.envase === null || vm.envase.value === undefined ?
                            (
                                    angular.element('#envase').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la forma farmacéutica seleccionada.'),
                                    false
                                    ) : true;
                },
                validarFechaFabricacion: function (vm) {
                    return typeof vm.fechaFabricacion !== 'object' || vm.fechaFabricacion === null || vm.fechaFabricacion === undefined ?
                            (
                                    angular.element('#fechaFabricacion').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la fecha de fabricación seleccionada.'),
                                    false
                                    ) : true;
                },
                validarFechaVencimiento: function (vm) {
                    return typeof vm.fechaVencimiento !== 'object' || vm.fechaVencimiento === null || vm.fechaVencimiento === undefined ?
                            (
                                    angular.element('#fechaVencimiento').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la fecha de vencimiento seleccionada.'),
                                    false
                                    ) : true;
                },
                validarTamanoLote: function (vm) {
                    return vm.tamanoLote === '' || vm.tamanoLote === null || vm.tamanoLote === undefined ?
                            (
                                    angular.element('#tamanoLote').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el tamaño de lote digitado.'),
                                    false
                                    ) : true;
                },
                validarNumeroLote: function (vm) {
                    return vm.numeroLote === '' || vm.numeroLote === null || vm.numeroLote === undefined ?
                            (
                                    angular.element('#numeroLote').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el número de lote digitado.'),
                                    false
                                    ) : true;
                },
                validarCantidadLote: function (vm) {
                    return vm.cantidadLote === '' || vm.cantidadLote === null || vm.cantidadLote === undefined ?
                            (
                                    angular.element('#cantidadLote').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en el cantidad de lote digitada.'),
                                    false
                                    ) : true;
                },
                validarEnsayos: function (vm) {
                    var ensayos;
                    var validar;
                    switch (parseInt(vm.areaAnalisis.id)) {

                        case 1:
                            ensayos = vm.gridEnsayosSettings.apply('getrows');
                            validar = ensayos.filter(function (currentValue) {
                                return currentValue.validacion === true;
                            });
                            if (validar <= 0) {
                                interfaz.openErrorNotification(vm, 'Error en los ensayos seleccionados.');
                                return false;
                            } else {
                                return true;
                            }

                        case 2:
                            ensayos = vm.gridEnsayosSettings.apply('getrows');
                            validar = ensayos.filter(function (currentValue) {
                                return currentValue.validacion === true;
                            });
                            if (validar <= 0) {
                                interfaz.openErrorNotification(vm, 'Error en los ensayos seleccionados.');
                                return false;
                            } else {
                                return true;
                            }

                        default:
                            interfaz.openErrorNotification(vm, 'No esta permitido el registro de analisis de un área distinta a microbiologia o fisicoquimico.');
                            return false;
                    }
                    // return parseInt(vm.areaAnalisis.id) === 2 ?
                    // 	(
                    // 		ensayos = vm.gridEnsayosSettings.apply('getrows'),
                    // 		validar = ensayos.filter(function (currentValue) {
                    // 			return currentValue.validacion === true;
                    // 		}),
                    // 		validar.length <= 0 ?
                    // 			(
                    // 				interfaz.openErrorNotification(vm, 'Errror en los ensayos seleccionados.'),
                    // 				false
                    // 			) : true
                    // 	)
                    // 	:
                    // 	(
                    // 		interfaz.openErrorNotification(vm, 'No esta permitido el registro de analisis de un área distinta a microbiologia.'),
                    // 		false
                    // 	);
                },
                validarCondicionesGenerales: function (vm) {
                    return vm.condicionesGenerales == '' ?
                            (
                                    angular.element('#regMuestraCondicionesGenerales').tooltip('show'),
                                    interfaz.openErrorNotification(vm, 'Error en la condiciones generales digitadas.'),
                                    false
                                    )
                            : true;
                },
                validarIdentificadorCliente: function (vm) {
                    return vm.identificadorCliente === '' || vm.identificadorCliente === null || vm.identificadorCliente === undefined ? (
                            angular.element('#regMuestraIdentificadorCliente').tooltip('show'),
                            interfaz.openErrorNotification(vm, 'Error en el identificador de cliente digitados.'),
                            false
                            )
                            : (true);
                },
                validarMuestraData: function (vm) {

                    return interfaz.validarIdentificadorCliente(vm) &&
                            interfaz.validarFechaCompromiso(vm) &&
                            interfaz.validarCliente(vm) &&
                            interfaz.validarContacto(vm) &&
                            //interfaz.validarLabFabricante(vm) &&
                            interfaz.validarProcedencia(vm) &&
                            interfaz.validarCondicionesGenerales(vm) &&
                            interfaz.validarAreaAnalisis(vm) &&
                            interfaz.validarDetalleAreaAnalisis(vm) &&
                            interfaz.validarProducto(vm) &&
                            interfaz.validarEmpaque(vm) &&
                            interfaz.validarEnvase(vm) &&
                            interfaz.validarFechaFabricacion(vm) &&
                            interfaz.validarFechaVencimiento(vm) &&
                            interfaz.validarTamanoLote(vm) &&
                            interfaz.validarNumeroLote(vm) &&
                            interfaz.validarCantidadLote(vm) &&
                            interfaz.validarEnsayos(vm) ?
                            true :
                            false;

                },
                validarMuestraFqData: function (vm) {

                    return interfaz.validarIdentificadorCliente(vm) &&
                            interfaz.validarFechaCompromiso(vm) &&
                            interfaz.validarCliente(vm) &&
                            interfaz.validarContacto(vm) &&
                            //interfaz.validarLabFabricante(vm) &&
                            interfaz.validarProcedencia(vm) &&
                            interfaz.validarCondicionesGenerales(vm) &&
                            interfaz.validarAreaAnalisis(vm) &&
                            interfaz.validarDetalleAreaAnalisis(vm) &&
                            interfaz.validarProducto(vm) &&
                            interfaz.validarEmpaque(vm) &&
                            interfaz.validarEnvase(vm) &&
                            interfaz.validarFechaFabricacion(vm) &&
                            interfaz.validarFechaVencimiento(vm) &&
                            interfaz.validarTamanoLote(vm) &&
                            interfaz.validarNumeroLote(vm) &&
                            interfaz.validarCantidadLote(vm) &&
                            interfaz.validarEnsayos(vm) ?
                            true :
                            false;

                },
                validarMuestraEstData: function (vm) {
                    return interfaz.validarIdentificadorCliente(vm) &&
                            interfaz.validarFechaCompromiso(vm) &&
                            interfaz.validarCliente(vm) &&
                            interfaz.validarContacto(vm) &&
                            //interfaz.validarLabFabricante(vm) &&
                            interfaz.validarProcedencia(vm) &&
                            interfaz.validarCondicionesGenerales(vm) &&
                            interfaz.validarAreaAnalisis(vm) &&
                            interfaz.validarDetalleAreaAnalisis(vm) &&
                            interfaz.validarProducto(vm) &&
                            interfaz.validarEmpaque(vm) &&
                            interfaz.validarEnvase(vm) &&
                            interfaz.validarFechaFabricacion(vm) &&
                            interfaz.validarFechaVencimiento(vm) &&
                            interfaz.validarTamanoLote(vm) &&
                            interfaz.validarNumeroLote(vm) &&
                            interfaz.validarCantidadLote(vm) ?
                            true :
                            false;
                },
                registrarMuestra: function (vm) {


                    switch (parseInt(vm.areaAnalisis.id)) {
                        case 1:
                            if (interfaz.validarMuestraFqData(vm)) {
                                angular.element('#waitRegistroMuestra').modal('show');
                                var muestraData = regMuestraSaveMuestraFqFactory.saveMuestraFQ(vm);
                            }


                            break;
                        case 2:
                            if (interfaz.validarMuestraData(vm)) {
                                angular.element('#waitRegistroMuestra').modal('show');
                                var muestraData = {
                                    idEstadoMuestra: 1,
                                    activa: 1,
                                    prioridad: vm.prioridad.id,
                                    cotizacion: vm.cotizacion,
                                    remision: vm.remision,
                                    identificadorCliente: vm.identificadorCliente,
                                    fechaLlegada: $filter('date')(vm.fechaLlegada, 'yyyy-MM-dd'),
                                    fechaCompromiso: $filter('date')(vm.fechaCompromiso, 'yyyy-MM-dd'),
                                    idTercero: parseInt(vm.cliente.value),
                                    idContacto: vm.contacto.id,
                                    areaContacto: vm.contacto.area,
                                    fabricante: vm.labFabricante,
                                    procedencia: vm.procedencia,
                                    observaciones: vm.observaciones,
                                    condicionesGenerales: vm.condicionesGenerales,
                                    idAreaAnalisis: parseInt(vm.areaAnalisis.id),
                                    idTipoEstabilidad: 1,
                                    idCordinador: 0, // pendiente cargar en el scope
                                    fechaMuestreo: $filter('date')(vm.fechaMuestreo, 'yyyy-MM-dd'),
                                    tecnicaUsada: interfaz.getTecnicaUsada(vm.dropDownTecnicaUsadaSettings),
                                    EstabilidadMic: vm.EstabilidadMic,
                                    idTipoAnalisis: vm.tipoMuestra.id,
                                    prefijo: vm.tipoMuestra.prefijo,
                                    idAreaMicrobiologica: vm.areaMicro.id,
                                    idProducto: parseInt(vm.producto.value),
                                    idEmpaque: parseInt(vm.empaque.id),
                                    idEnvase: parseInt(vm.envase.id),
                                    fechaFabricacion: $filter('date')(vm.fechaFabricacion, 'yyyy-MM-dd'),
                                    fechaVencimiento: $filter('date')(vm.fechaVencimiento, 'yyyy-MM-dd'),
                                    tamanoLote: vm.tamanoLote,
                                    numeroLote: vm.numeroLote,
                                    cantidadLote: vm.cantidadLote,
                                    ensayos: vm.gridEnsayosSettings.apply('getrows'),
                                    plantaTecnicaUsada: vm.plantaTecnicaUsada,
                                    responsableToma: vm.responsableToma,

                                }
                                if (vm.tipoMuestra.id == 6) {
                                    muestraData.planta = vm.planta;
                                    muestraData.sanitizante = vm.sanitizante;
                                    muestraData.frotis = vm.frotisRealizado;
                                    muestraData.espAerobiosMesofilos = vm.espAerobiosMesofilos;
                                    muestraData.espMohosLevaduras = vm.espMohosLevaduras;
                                    muestraData.plantaTecnicaUsada = vm.plantaTecnicaUsada;
                                    muestraData.responsableToma = vm.responsableToma;
                                    muestraData.superficieEquipo = vm.superficieEquipo;
                                    muestraData.espEColi = vm.espEColi;
                                    muestraData.plantaArea = vm.plantaArea;
                                }
                                if (vm.tipoMuestra.id == 5) {
                                    muestraData.puntoToma = vm.puntoToma;
                                }


                                break;

                            }
                        case 4:
                            if (interfaz.validarMuestraEstData(vm)) {
                                angular.element('#waitRegistroMuestra').modal('show');
                                var muestraData = regMuestraSaveMuestraEstFactory.saveMuestraEST(vm);
                            }
                            break;



                    }
                    var tempEnsayos = angular.copy(muestraData.ensayos);
                    muestraData.ensayos = [];
                    angular.forEach(tempEnsayos, function (value) {
                        if (value.validacion) {
                            muestraData.ensayos.push(value);
                        }
                    });

                    muestraService.saveMuestra(muestraData).then(function (data) {
                        angular.element('#waitRegistroMuestra').modal('hide');
                        var message;
                        data.data.code === '00000' ?
                                (
                                        message = 'Se ha registrado la muestra ' + data.data.data.idMuestra.prefijo + '-' + data.data.data.idMuestra.customIdMuestra,
                                        interfaz.openSuccessNotification(vm, message)
                                        //interfaz.limpiarFormulario(vm)
                                        ) : (
                                message = 'Fallo el registro de muestra intentelo nuevamento o comuniquece con el administrador del sistema',
                                interfaz.openErrorNotification(vm, message)
                                );


                        var a = 0;
                    });

                },
                getTecnicaUsada: function (dropDownTecnicaUsadaSettings) {
                    var data = dropDownTecnicaUsadaSettings.apply('getCheckedItems');
                    var tecnicas = [];
                    data.forEach(function (item) {
                        tecnicas.push(item.originalItem);
                    });
                    return tecnicas;
                },
                openErrorNotification: function (vm, message) {
                    angular.element('#errorMessageNotification').html(message);
                    vm.errorNotificationSettings.apply('open');
                },
                openSuccessNotification: function (vm, message) {
                    angular.element('#successMessageNotification').html(message);
                    vm.successNotificationSettings.apply('open');
                },
                searchMuestra: function (vm) {
                    angular.element('#waitSearchMuestra').modal('show');
                    muestraService.getMuestra(vm.idMuestra).then(function (data) {
                        getAllActiveTipoMuestra(vm);
                        //getAreasActivasJoinCoordinador(vm);

                        return data.data[0].code === '00000' ?
                                (
                                        regMuestraSearchMuestraFactory.loadMuestra(vm, data.data[0].data.muestra),
                                        angular.element('#waitSearchMuestra').modal('hide')
                                        ) : (
                                interfaz.openErrorNotification(vm, data.data[0].message + ' ' + vm.idMuestra),
                                angular.element('#waitSearchMuestra').modal('hide')
                                );


                    }, function (data) {
                        interfaz.openErrorNotification(vm, 'Error al consultar los datos del analisis ' + vm.idMuestra)
                        angular.element('#waitSearchMuestra').modal('hide');
                    });


                },
                limpiarFormulario: function (vm) {
                    vm.dropDownTipoMuestraSettings.disabled = false;
                    $timeout(() => {
                     vm.dropDownTipoMuestraSettings.apply('selectIndex', 0);
                     }, 1);

                    //clean boton ver historial
                    vm.buttonVerHistorialSettings.disabled = true;
                    vm.buttonVerHistorialSettings.refresh(['disabled']);
                    // clean boton ver estados
                    vm.buttonVerEstadosSettings.disabled = true;
                    vm.buttonVerEstadosSettings.refresh(['disabled']);
                    // clean boton registrar muestra
                    vm.buttonRegistrarAnalisisSettings.disabled = false;
                    vm.buttonRegistrarAnalisisSettings.refresh(['disabled']);
                    // clean boton actualizar muestra
                    vm.buttonActualizarAnalisisSettings.disabled = true;
                    vm.buttonActualizarAnalisisSettings.refresh(['disabled']);
                    //clean activa
                    vm.activa = false;
                    vm.checkBoxActivaSettings.disabled = true;
                    vm.checkBoxActivaSettings.refresh(['disabled']);
                    // clean id muestra
                    //vm.idMuestra = null;
                    vm.inputNumeroAnalisisSettings.disabled = false;
                    vm.inputNumeroAnalisisSettings.refresh(['disabled']);
                    //clean estado actual
                    vm.estadoActual = null;
                    //clean prioridad
                    vm.dropDownPrioridadSettings.apply('selectIndex', 0);
                    // clean cotizacion
                    vm.cotizacion = null;
                    // clean remision
                    vm.remision = null;
                    // clean fecha llegada
                    vm.fechaLlegada = new Date();
                    // clean fecha compromiso
                    vm.fechaCompromiso = new Date();
                    // clean cliente
                    vm.cliente = null;
                    // clean area contacto
                    vm.contacto.area = null;
                    //clean contacto 
                    vm.contacto = null;
                    //clena laboratorio fabricante
                    vm.labFabricante = null
                    // clean procedencia
                    vm.procedencia = null;
                    // clean observaciones
                    vm.observaciones = '';
                    // clean area de analisis
                    //vm.dropDownAreaAnalisisSettings.apply('selectIndex', 3);
                    // clean fecha de muestreo
                    vm.fechaMuestreo = new Date();
                    // clean tecnica usada
                    //vm.dropDownTecnicaUsadaSettings.apply('uncheckAll');
                    // clean tipo muestra
                    //vm.dropDownTipoMuestraSettings.apply('selectIndex', -1);
                    // clean area microbiologica
                    //vm.dropDownAreaMicroSettings.apply('selectIndex', -1);
                    // clean planta
                    vm.planta = null;
                    //clean 
                    vm.sanitizante = null;
                    // frotis
                    vm.frotisRealizado = null;
                    //clean Espeificaciones Mesofilños aerobios
                    vm.espAerobiosMesofilos = '';
                    // clean especificaciones Mohos y levaduras
                    vm.espMohosLevaduras = '';
                    // clean prodcuto 
                    vm.producto = null;
                    // clean empaque
                    vm.empaque = null;
                    // clean envase
                    vm.envase = null;
                    // clean fecha fabricacion
                    vm.fechaFabricacion = new Date();
                    // clean fecha vencimiento
                    vm.fechaVencimiento = new Date();
                    // clean tamaño lote
                    vm.tamanoLote = null;
                    // clean numero lote
                    vm.numeroLote = null;
                    // clean cantidad lote
                    vm.cantidadLote = null;
                    // clean grid ensayos
                    vm.gridEnsayosSettings.source = null;
                    vm.gridEnsayosSettings.refresh(['source']);
                    vm.gridEnsayosSettings.apply('clear');
                    vm.loadingEnsayos = false;
                    vm.loadedEnsayos = false;
                    vm.condicionesGenerales = null;
                    vm.identificadorCliente = null;
                    vm.EstabilidadMic = null;
                    vm.puntoToma = null;
                    vm.plantaTecnicaUsada = null;
                    vm.responsableToma = null;
                    vm.superficieEquipo = null;
                    vm.espEColi = '';
                    vm.plantaArea = null;


                },
                actualizarMuestra: function (vm) {
                    if (vm.idEstadoActualMuestra == 1) {
                        if (interfaz.validarMuestraData(vm)) {
                            angular.element('#waitRegistroMuestra').modal('show');
                            switch (parseInt(vm.areaAnalisis.id)) {
                                case 1:
                                    var muestraData = {
                                        idMuestra: vm.idMuestra,
                                        idEstadoMuestra: 1,
                                        activa: 1,
                                        prioridad: vm.prioridad.id,
                                        cotizacion: vm.cotizacion,
                                        remision: vm.remision,
                                        identificadorCliente: vm.identificadorCliente,
                                        fechaLlegada: $filter('date')(vm.fechaLlegada, 'yyyy-MM-dd'),
                                        fechaCompromiso: $filter('date')(vm.fechaCompromiso, 'yyyy-MM-dd'),
                                        idTercero: parseInt(vm.cliente.value),
                                        idContacto: vm.contacto.id,
                                        areaContacto: vm.contacto.area,
                                        fabricante: vm.labFabricante,
                                        procedencia: vm.procedencia,
                                        observaciones: vm.observaciones,
                                        condicionesGenerales: vm.condicionesGenerales,
                                        idAreaAnalisis: parseInt(vm.areaAnalisis.id),
                                        idTipoEstabilidad: 1,
                                        EstabilidadMic: vm.EstabilidadMic,
                                        plantaArea: vm.plantaArea,
                                        idCordinador: 0, // pendiente cargar en el scope
                                        //fechaMuestreo: $filter('date')(vm.fechaMuestreo, 'yyyy-MM-dd'),
                                        //tecnicaUsada: interfaz.getTecnicaUsada(vm.dropDownTecnicaUsadaSettings),
                                        //EstabilidadMic: vm.EstabilidadMic,
                                        idTipoAnalisis: vm.tipoMuestra.id,
                                        prefijo: vm.tipoMuestra.prefijo,
                                        //idAreaMicrobiologica: vm.areaMicro.id,
                                        idProducto: parseInt(vm.producto.value),
                                        idEmpaque: parseInt(vm.empaque.value),
                                        idEnvase: parseInt(vm.envase.value),
                                        fechaFabricacion: $filter('date')(vm.fechaFabricacion, 'yyyy-MM-dd'),
                                        fechaVencimiento: $filter('date')(vm.fechaVencimiento, 'yyyy-MM-dd'),
                                        tamanoLote: vm.tamanoLote,
                                        numeroLote: vm.numeroLote,
                                        cantidadLote: vm.cantidadLote,
                                        ensayos: vm.gridEnsayosSettings.apply('getrows'),
                                        fechaMuestreo: $filter('date')(vm.fechaMuestreo, 'yyyy-MM-dd'),
                                        espAerobiosMesofilos: vm.espAerobiosMesofilos
                                    }

                                    break;
                                case 2:
                                    var muestraData = {
                                        idMuestra: vm.idMuestra,
                                        idEstadoMuestra: 1,
                                        activa: 1,
                                        prioridad: vm.prioridad.id,
                                        cotizacion: vm.cotizacion,
                                        remision: vm.remision,
                                        identificadorCliente: vm.identificadorCliente,
                                        fechaLlegada: $filter('date')(vm.fechaLlegada, 'yyyy-MM-dd'),
                                        fechaCompromiso: $filter('date')(vm.fechaCompromiso, 'yyyy-MM-dd'),
                                        idTercero: parseInt(vm.cliente.value),
                                        idContacto: vm.contacto.id,
                                        areaContacto: vm.contacto.area,
                                        fabricante: vm.labFabricante,
                                        procedencia: vm.procedencia,
                                        observaciones: vm.observaciones,
                                        condicionesGenerales: vm.condicionesGenerales,
                                        idAreaAnalisis: parseInt(vm.areaAnalisis.id),
                                        idTipoEstabilidad: 1,
                                        idCordinador: 0, // pendiente cargar en el scope
                                        fechaMuestreo: $filter('date')(vm.fechaMuestreo, 'yyyy-MM-dd'),
                                        tecnicaUsada: interfaz.getTecnicaUsada(vm.dropDownTecnicaUsadaSettings),
                                        EstabilidadMic: vm.EstabilidadMic,
                                        idTipoAnalisis: vm.tipoMuestra.id,
                                        prefijo: vm.tipoMuestra.prefijo,
                                        idAreaMicrobiologica: vm.areaMicro.id,
                                        idProducto: parseInt(vm.producto.value),
                                        idEmpaque: parseInt(vm.empaque.id),
                                        idEnvase: parseInt(vm.envase.id),
                                        fechaFabricacion: $filter('date')(vm.fechaFabricacion, 'yyyy-MM-dd'),
                                        fechaVencimiento: $filter('date')(vm.fechaVencimiento, 'yyyy-MM-dd'),
                                        tamanoLote: vm.tamanoLote,
                                        numeroLote: vm.numeroLote,
                                        cantidadLote: vm.cantidadLote,
                                        ensayos: vm.gridEnsayosSettings.apply('getrows')
                                    }
                                    if (vm.tipoMuestra.id == 6) {
                                        muestraData.planta = vm.planta;
                                        muestraData.sanitizante = vm.sanitizante;
                                        muestraData.frotis = vm.frotisRealizado;
                                        muestraData.espAerobiosMesofilos = vm.espAerobiosMesofilos;
                                        muestraData.espMohosLevaduras = vm.espMohosLevaduras;
                                        muestraData.plantaTecnicaUsada = vm.plantaTecnicaUsada;
                                        muestraData.responsableToma = vm.responsableToma;
                                        muestraData.superficieEquipo = vm.superficieEquipo;
                                        muestraData.espEColi = vm.espEColi;
                                        muestraData.plantaArea = vm.plantaArea;
                                    }
                                    if (vm.tipoMuestra.id == 5) {
                                        muestraData.puntoToma = vm.puntoToma;
                                    }

                                    break;

                            }

                            var tempEnsayos = angular.copy(muestraData.ensayos);
                            muestraData.ensayos = [];
                            angular.forEach(tempEnsayos, function (value) {
                                if (value.validacion) {
                                    muestraData.ensayos.push(value);
                                }
                            });

                            muestraService.updateMuestra(muestraData).then(function (data) {
                                var message;
                                data.data.code === '00000' ?
                                        (
                                                message = 'Se ha actualizado la muestra',
                                                interfaz.openSuccessNotification(vm, message)
                                                ) : (
                                        message = 'Fallo la actualizacion de la muestra',
                                        interfaz.openErrorNotification(vm, message)
                                        );
                                angular.element('#waitRegistroMuestra').modal('hide');
                            });
                        }
                    } else {
                        var message = 'No es posible actualizar una muestra en estado diferente de: "para programación".';
                        interfaz.openErrorNotification(vm, message);
                    }


                },
                verEstados: function (vm) {
                    $window.location.href = 'index.php?action=historicoEstadosMuestra&idMuestra=' + vm.idMuestra;
                },
                verHistorico: function (vm) {
                    $window.location.href = 'index.php?action=almacenmuestra&idMuestra=' + vm.idMuestra;
                },
                preCallAnalisis: function (vm) {
                    var a = $location.absUrl();
                    if (a.includes("&idMuestra=")) {
                        angular.element('#waitSearchMuestra').modal('show');
                        a = a.split('idMuestra=');
                        vm.idMuestra = a[1];
//                        vm.promiseGetAreasActivasMic.then(response => {
//                            vm.promiseGetTerceros.then(reponse2 => {
//                                vm.promiseGetAreasActivas.then(response3 => {
//                                    vm.promiseLoadDefaultAreaAnalisis.then(response4 => {
//                                        vm.promiseGetProducto.then(response5 => {
//                                            vm.promiseGetEmpaques.then(response6 => {
//                                                vm.promiseGetEnvases.then(response7 => {
//                                                    vm.promiseGetMetodos.then(response8 => {
//                                                        vm.promiseGetTipoMuestra.then(response9 => {
//                                                            vm.promiseGetTiposEstabilidad.then(response10 => {
//                                                                console.log('respuesta asociada');
//                                                            })
//                                                        })
//                                                    })
//                                                })
//                                            })
//                                        })
//                                    })
//                                })
//                            })
//                        });

                        var promises = {

                            areasAnalisisMic: vm.promiseGetAreasActivasMic,
                            terceros: vm.promiseGetTerceros,
                            areasAnalisis: vm.promiseGetAreasActivas,
                            p4: vm.promiseLoadDefaultAreaAnalisis,
                            p5: vm.promiseGetProducto,
                            p6: vm.promiseGetEmpaques,
                            p7: vm.promiseGetEnvases,
                            p8: vm.promiseGetMetodos,
                            p9: vm.promiseGetTipoMuestra,
                            //p10: vm.promiseGetTiposEstabilidad
                        };
                        $q.all(promises).then(function () {
                            interfaz.searchMuestra(vm);
                        });

                    }
                    // a.includes("&idMuestra=") ?
                    // 	(
                    // 		a = a.split('idMuestra='),
                    // 		vm.idMuestra = a[1],
                    // 		interfaz.searchMuestra(vm)
                    // 	) : (false);



                },
                unCheckActiva: function (vm) {
                    if (vm.idMuestra != null && vm.idMuestra != undefined && vm.activa != false) {
                        if (vm.status == 'ready') {
                            angular.element('#motivoAnulacionModal').modal('show');
                        }
                    }
                },
                anularMuestra: function (vm) {
                    vm.progressAnulacion = true;
                    muestraService.anularMuestra(vm.idMuestra, vm.motivoAnulacion).then(function (data) {
                        if (data.data.result == 0) {
                            vm.progressAnulacion = false;
                            vm.buttonActualizarAnalisisSettings.disabled = true;
                            vm.buttonActualizarAnalisisSettings.refresh(['disabled']);
                            angular.element('#motivoAnulacionModal').modal('hide');
                            vm.checkBoxActivaSettings.disabled = true;
                            vm.checkBoxActivaSettings.refresh(['disabled']);
                            interfaz.openSuccessNotification(vm, 'Se ha anulado exitosamente el análisis.');
                        } else {
                            vm.progressAnulacion = false;
                            interfaz.openErrorNotification(vm, 'Fallo la anulación deñ análisis, intentelo nuevamente.');
                        }
                    });
                },
                getTiposEstabilidad: function (vm) {
                    var promises = {
                        tiposEstabilidadPromise: tipoEstabilidadService.getAllTipoEstabilidad(),
                        duracionNaturalPromise: duracionEstabilidadService.getDuracionEstabilidadNatural(),
                        duracionAceleradaPromise: duracionEstabilidadService.getDuracionEstabilidadAcelerada(),
                        duracionOngoingPromise: duracionEstabilidadService.getDuracionEstabilidadOngoing()
                    }

                    return $q.all(promises).then(function (responses) {
                        var a = 0;
                        responses.tiposEstabilidadPromise.data.forEach(function (element, index, array) {
                            if (element.id == 1) {
                                element.duraciones = responses.duracionNaturalPromise.data;
                            } else if (element.id == 2) {
                                element.duraciones = responses.duracionAceleradaPromise.data;
                            } else if (element.id == 3) {
                                element.duraciones = responses.duracionOngoingPromise.data;
                            }
                        }, this);
                        vm.dropDownTipoEstabilidadSettings.source = responses.tiposEstabilidadPromise.data;
                        vm.dropDownTipoEstabilidadSettings.disabled = false;
                        vm.dropDownTipoEstabilidadSettings.displayMember = 'tipoEstabilidad';
                        vm.dropDownTipoEstabilidadSettings.selectedIndex = 0;

                    });


                },
                calcularFechaCompromiso: function (vm) {
                    var dias = vm.sesionUserData.session.systemsParameters.diasHabilesFechaCompromiso;
                    var fechaTemp = angular.copy(vm.fechaLlegada);
                    while (dias > 0) {
                        fechaTemp.setDate(fechaTemp.getDate() + 1);
                        var fechaCalc = fechaTemp.getFullYear() + "-" + ('0' + (fechaTemp.getMonth() + 1)).slice(-2) + "-" + fechaTemp.getDate();
                        var existe = vm.festivos.find(function (value) {
                            return value == fechaCalc;
                        });
                        var festivo = existe === undefined ? false : true;
                        if (fechaTemp.getDay() !== 0 && fechaTemp.getDay() !== 6 && festivo === false) {
                            dias--;
                        }
                    }
                    vm.fechaCompromiso = fechaTemp;
                }
            }

            function getAllActiveTipoMuestra(vm) {
                return tipoMuestraService.getAllActiveTipoMuestra().then(function (response) {
                    if (response.data.code === 0) {
                        vm.tiposMuestraActivos = response.data.data;
                        vm.promiseLoadDefaultFormato = $timeout(function () {
                            /*vm.dropDownTipoMuestraSettings.selectedIndex = 0;
                             vm.dropDownTipoMuestraSettings.refresh(['selectedIndex']);*/
                            var tipoMuestraFQ = vm.tiposMuestraActivos.find(function (value) {
                                return value.idAreaAnalisis == 1;
                            });
                            //vm.tipoMuestra = tipoMuestraFQ;
                        }, 1000);
                    }
                });
            }

            function getAreasActivasJoinCoordinador(vm) {
                return areaAnalisisService.getAreasActivasJoinCoordinador().then(function (data) {
                    // console.log('areas', data);
                    vm.dropDownAreaAnalisisSettings.source = data.data.data;
                    //vm.dropDownAreaAnalisisSettings.displayMember = 'descripcion';
                    vm.promiseLoadDefaultAreaAnalisis = $timeout(function () {
                        /*vm.dropDownAreaAnalisisSettings.selectedIndex = 0;
                         vm.dropDownAreaAnalisisSettings.refresh(['selectedIndex']);*/

                        var fisicoquimico = data.data.data.find(function (value) {
                            return value.id == 1 //Encuentra fisicoquimico
                        });
                        vm.areaAnalisis = fisicoquimico;
                        // console.log('areas2', fisicoquimico);
                        vm.dropDownTipoMuestraSettings.source = fisicoquimico.tiposMuestra;
                        vm.dropDownTipoMuestraSettings.displayMember = 'descripcion';
                        vm.dropDownTipoMuestraSettings.disabled = false;

                        vm.dropDownTipoMuestraSettings.refresh(['source', 'displayMember', 'disabled']);
                        $timeout(() => {
                            // console.log('timeout');
                            vm.dropDownTipoMuestraSettings.apply('selectIndex', 0);
                        }, 1);



                    }, 100);

                });
            }

            return interfaz;
        });