'use strict'

angular.module('CompAdminEquipo')

        .factory('adminEquipoService', function (equipoService) {
            var interfaz = {
                getAllActiveEquipos: getAllActiveEquipos,
                openModalNewEquipo: openModalNewEquipo,
                insertarEquipo: insertarEquipo,
                openModalEditEquipo: openModalEditEquipo,
                editarEquipo: editarEquipo,
                eliminarEquipo: eliminarEquipo
            }

            function getAllActiveEquipos(vm) {
                vm.waitModalText = 'Cargando datos de equipos, un momento por favor ...';
                $('#waitModal').modal('show');
                equipoService.getEquiposActivos().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Carga de equipo OK');
                        vm.equipos = response.data.data;
                        angular.forEach(vm.equipos, function (value, key) {
                            formatFechas(vm, value);
                        });
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la carga de equipos');
                        console.error(response);
                    }
                });
            }

            function openModalNewEquipo(vm) {
                $('#newEquipoModal').modal('show');
            }

            function insertarEquipo(vm) {
                vm.waitModalText = 'Creando equipo, un momento por favor ...';
                $('#waitModal').modal('show');
                $('#newEquipoModal').modal('hide');
                equipoService.insertEquipo(vm.newEquipo).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de equipo OK');
                        vm.newEquipo = null;
                        $("#fecha_ult_mantenimiento1").jqxDateTimeInput({value: null});
                        $("#fecha_prox_mantenimiento1").jqxDateTimeInput({value: null});
                        $("#fecha_ult_calibracion1").jqxDateTimeInput({value: null});
                        $("#fecha_prox_calibracion1").jqxDateTimeInput({value: null});
                        $("#fecha_ult_calificacion1").jqxDateTimeInput({value: null});
                        $("#fecha_prox_calificacion1").jqxDateTimeInput({value: null});
                        getAllActiveEquipos(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la actualización del lote del equipo ');
                        console.error(response);
                    }
                });
            }

            function openModalEditEquipo(vm, equipoSelected) {
                vm.equipoSelected = angular.copy(equipoSelected);
                $('#editEquipoSelectedModal').modal('show');

            }

            function formatFechas(vm, equipo) {
                if (equipo.fecha_ult_mant) {
                    equipo.fecha_ult_mant = formatDateString(equipo.fecha_ult_mant);
                } else {
                    equipo.fecha_ult_mant = null;
                }
                if (equipo.fecha_ult_calib) {
                    equipo.fecha_ult_calib = formatDateString(equipo.fecha_ult_calib);
                } else {
                    equipo.fecha_ult_calib = null;
                }
                if (equipo.fecha_prox_calibracion) {
                    equipo.fecha_prox_calibracion = formatDateString(equipo.fecha_prox_calibracion);
                    validarFechaProximaCalibracion(vm, equipo);
                } else {
                    equipo.fecha_prox_calibracion = null;
                }
                if (equipo.fecha_prox_mantenimiento) {
                    equipo.fecha_prox_mantenimiento = formatDateString(equipo.fecha_prox_mantenimiento);
                    validarFechaProximoMantenimieto(vm, equipo);
                } else {
                    equipo.fecha_prox_mantenimiento = null;
                }
                if (equipo.fecha_ult_calificacion) {
                    equipo.fecha_ult_calificacion = formatDateString(equipo.fecha_ult_calificacion);
                } else {
                    equipo.fecha_ult_calificacion = null;
                }
                if (equipo.fecha_prox_calificacion) {
                    equipo.fecha_prox_calificacion = formatDateString(equipo.fecha_prox_calificacion);
                    validarFechaProximaCalificacion(vm, equipo);
                } else {
                    equipo.fecha_prox_calificacion = null;
                }
            }

            function diferenciaFechas(fecha) {
                var hoy = new Date();
                var timeDiff = fecha.getTime() - hoy.getTime();
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

                return diffDays;
            }

            function validarFechaProximaCalibracion(vm, equipo) {
                var diffDays = diferenciaFechas(equipo.fecha_prox_calibracion);
                var yyy= equipo.fecha_prox_calibracion.getFullYear();
                if (diffDays <= 0 && yyy!==2000) {
                    equipo.prox_calibracion = vm.fechaVencidaClase;
                } else if (diffDays > 0 && diffDays <= vm.systemsParameters.diasAnticipacionAlertaCalibracion) {
                    equipo.prox_calibracion = vm.fechaProximaClase;
                }
            }

            function validarFechaProximoMantenimieto(vm, equipo) {
                var diffDays = diferenciaFechas(equipo.fecha_prox_mantenimiento);
                var yyy= equipo.fecha_prox_mantenimiento.getFullYear();
                if (diffDays <= 0 && yyy!==2000) {
                    equipo.prox_mantenimiento = vm.fechaVencidaClase;
                } else if (diffDays > 0 && diffDays <= vm.systemsParameters.diasAnticipacionAlertaMantenimiento) {
                    equipo.prox_mantenimiento = vm.fechaProximaClase;
                }
            }

            function validarFechaProximaCalificacion(vm, equipo) {
                var diffDays = diferenciaFechas(equipo.fecha_prox_calificacion);
                var yyy= equipo.fecha_prox_calificacion.getFullYear();
                if (diffDays <= 0 && yyy!==2000) {
                    equipo.prox_calificacion = vm.fechaVencidaClase;
                } else if (diffDays > 0 && diffDays <= vm.systemsParameters.diasAnticipacionAlertaCalificacion) {
                    equipo.prox_calificacion = vm.fechaProximaClase;
                }
            }

            function formatDateString(dateString) {
                var dateParts = dateString.split("-");
                return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
            }

            function editarEquipo(vm) {
                vm.waitModalText = 'Actualizando equipo, un momento por favor ...';
                $('#waitModal').modal('show');
                $('#editEquipoSelectedModal').modal('hide');

                equipoService.updateEquipo(vm.equipoSelected).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de equipo OK');
                        vm.equipoSelected = null;
                        getAllActiveEquipos(vm);
                    } else {
                        console.log('falla en la actualización del lote del equipo ');
                        console.error(response);
                    }
                });
            }

            function eliminarEquipo(vm, equipo, index) {
                vm.waitModalText = 'Eliminando equipo, un momento por favor ...';
                $('#waitModal').modal('show');
                equipoService.deleteEquipo(equipo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Se eliminó correctamente el equipo ' + equipo.id);
                        vm.equipos.splice(index, 1);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('Falla en la eliminación del equipo');
                        console.error(response);
                    }
                });
            }



            /*
             
             
             function getPrincipiosActivosAsociados(vm) {
             $timeout(function () {
             vm.equipoSelected.principios_activos.forEach(function (item, index, array) {
             vm.dropDownPrincipiosActivosSettings.apply('checkIndex', vm.dropDownPrincipiosActivosSettings.source.findIndex(function (item1, index1, array1) {
             return item.id_principio_activo == item1.id;
             }));
             
             });
             }, 800);
             }
             
             function getPrincipiosActivos(vm) {
             principioActivoService.getAllPrincipioActivo().then(function (response) {
             if (response.data.code == "00000") {
             console.log('Carga de equipo OK');
             vm.principiosActivos = response.data.data;
             } else {
             console.log('falla en la carga de principios activos disponibles');
             console.error(response);
             }
             });
             }
             
             function settingsDropDownPrincipiosActivos(vm) {
             vm.dropDownPrincipiosActivosSettings.source = vm.principiosActivos;
             vm.dropDownPrincipiosActivosSettings.displayMember = 'nombre';
             vm.dropDownPrincipiosActivosSettings.refresh(['source', 'displayMember']);
             getPrincipiosActivosAsociados(vm);
             }
             
             function formatDateString(dateString) {
             if (dateString !== null) {
             var dateParts = dateString.split("-");
             return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
             } else {
             return null;
             }
             }
             
             function obtenerPrincipiosSeleccionados(vm) {
             var data = vm.dropDownPrincipiosActivosSettings.apply('getCheckedItems');
             var principios = [];
             data.forEach(function (item) {
             principios.push(item.originalItem);
             });
             console.log(principios);
             return principios;
             }
             
             
             
             
             
             
             function settingsDropDownNewPrincipiosActivos(vm) {
             vm.dropDownNewPrincipiosActivosSettings.source = vm.principiosActivos;
             vm.dropDownNewPrincipiosActivosSettings.displayMember = 'nombre';
             vm.dropDownNewPrincipiosActivosSettings.refresh(['source', 'displayMember']);
             }
             
             
             
             function obtenerNewPrincipiosSeleccionados(vm) {
             var data = vm.dropDownNewPrincipiosActivosSettings.apply('getCheckedItems');
             var principios = [];
             data.forEach(function (item) {
             principios.push(item.originalItem);
             });
             console.log(principios);
             return principios;
             }
             
             */
            return interfaz;
        });



