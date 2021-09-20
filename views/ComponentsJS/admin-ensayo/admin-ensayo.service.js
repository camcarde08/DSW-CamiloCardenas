'use strict'

angular.module('CompAdminEnsayo')

        .factory('adminEnsayoService', function ($filter, $q, ensayoService, medioCultivoService, utileService, plantillaService) {
            var interfaz = {
                editarEnsayo: editarEnsayo,
                descartarCambiosEnsayo: descartarCambiosEnsayo,
                confirmarCambiosEnsayo: confirmarCambiosEnsayo,
                eliminarEnsayo: eliminarEnsayo,
                openModalNewEnsayo: openModalNewEnsayo,
                closeModalNewEnsayo: closeModalNewEnsayo,
                confirmNewEnsayoModal: confirmNewEnsayoModal,
                selectRow: selectRow,
                desasociarMedioCultivo: desasociarMedioCultivo,
                asociarMedioCultivo: asociarMedioCultivo,
                getSessionUserData: getSessionUserData,
                getAllPlantilla: getAllPlantilla,
                changeFilter: changeFilter
            }

            function getAllPlantilla(vm) {
                plantillaService.getPlantillas().then(function (response) {
                    if (response.data.code == "00000") {
                        console.debug(response);
                        console.log('Consulta plantillas OK');
                        vm.plantillas = response.data.data;
                    } else {
                        console.log('falla en la consulta de plantillas');
                        console.error(response);
                    }
                });
            }

            function getSessionUserData(vm) {
                utileService.getSessionUserData().then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Consulta datos session del usuario OK');
                        vm.sessionUserData = response.data.data;
                    } else {
                        console.log('falla en la consulta datos session del usuario');
                        console.error(response);
                    }
                });
            }

            function asociarMedioCultivo(vm) {
                $('#waitModal').modal('show');
                vm.waitModalText = 'Asociando medios de cultivo seleccionados un momento por favor ...';
                var ensayosAsociar = $filter('filter')(vm.mediosDisponiblesEnsayoSeleccionado, {select: true});
                medioCultivoService.asociarMediosCultivo(vm.selectedEnsayo.id, ensayosAsociar).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('asociacion de medios de cultivo OK');
                    } else {
                        console.log('falla en la asociacion de medios de cultivo');
                        console.error(response);
                    }
                    refreshMediosCultivoEnsayo(vm);
                });
            }

            function desasociarMedioCultivo(vm) {
                $('#waitModal').modal('show');
                vm.waitModalText = 'Eliminando medios de cultivo seleccionados un momento por favor ...';
                var ensayosDesasociar = $filter('filter')(vm.mediosAsociadosEnsayoSeleccionado, {select: true});
                medioCultivoService.desasociarMediosCultivo(ensayosDesasociar).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('des asociacion de medios de cultivo OK');


                    } else {
                        console.log('falla en la des asociacion de medios de cultivo');
                        console.error(response);

                    }
                    refreshMediosCultivoEnsayo(vm);
                });
            }

            function selectRow(vm, index, ensayo) {
                if (vm.selectedEnsayo != ensayo) {
                    selectEnsayo(vm, index, ensayo)
                }

            }

            function selectEnsayo(vm, index, ensayo) {
                vm.selectedEnsayo = ensayo;
                angular.forEach(vm.ensayos, function (value, key) {
                    value.id == ensayo.id ? value.selected = true : value.selected = false;
                });
                refreshMediosCultivoEnsayo(vm);
            }

            function refreshMediosCultivoEnsayo(vm) {
                $('#waitModal').modal('show');
                vm.waitModalText = 'Consultado medios de cultivo asociados al ensayo seleccionado un momento por favor ...';
                var promises = {
                    consultarMediosCultivoAsociadosByIdEnsayo: consultarMediosCultivoAsociadosByIdEnsayo(vm),
                    consultarMediosCultivoDisponiblesByIdEnsayo: consultarMediosCultivoDisponiblesByIdEnsayo(vm)
                }
                return $q.all(promises).then(function (response) {
                    $('#waitModal').modal('hide');
                });
            }

            function consultarMediosCultivoDisponiblesByIdEnsayo(vm) {
                return medioCultivoService.getMediosCultivoDisponiblesByIdEnsayo(vm.selectedEnsayo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('consulta medios de cultivo disponibles al ensayo OK');
                        vm.mediosDisponiblesEnsayoSeleccionado = response.data.data;

                    } else {
                        console.log('falla en la consulta medios de cultivo disponibles al ensayo');
                        console.error(response);

                    }
                });
            }

            function consultarMediosCultivoAsociadosByIdEnsayo(vm, ensayo) {
                return medioCultivoService.getMediosCultivoByIdEnsayo(vm.selectedEnsayo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('consulta medios de cultivo asociados al ensayo OK');
                        vm.mediosAsociadosEnsayoSeleccionado = response.data.data;

                    } else {
                        console.log('falla en la consulta medios de cultivo asociados al ensayo');
                        console.error(response);

                    }
                });
            }

            function confirmNewEnsayoModal(vm) {
                var newEnsayoData = angular.copy(vm.newEnsayo);
                closeModalNewEnsayo(vm);
                vm.waitModalText = 'Creando nuevo ensayo un momento por favor ...';
                $('#waitModal').modal('show');
                ensayoService.insertEnsayo(newEnsayoData).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('creacion de ensayo OK');
                        changeFilter(vm);
                        $('#waitModal').modal('hide');
                    } else {
                        console.log('falla en la creación del ensayo ');
                        console.error(response);
                        $('#waitModal').modal('hide');
                    }
                });
            }

            function closeModalNewEnsayo(vm) {

                vm.newEnsayo = {
                    descripcion: "",
                    precio: 0,
                    duracion: 0
                }
                $('#newEnsayoModal').modal('hide');
            }

            function openModalNewEnsayo(vm) {
                $('#newEnsayoModal').modal('show');
            }

            function eliminarEnsayo(vm, ensayo, index) {
                vm.waitModalText = 'Eliminando Ensayo un momento por favor ...';
                $('#waitModal').modal('show');
                ensayoService.deleteEnsayo(ensayo.id).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Eliminacion de ensayo ' + ensayo.id + 'OK');
                        vm.ensayos.splice(index, 1);
                        $('#waitModal').modal('hide');

                    } else {
                        console.log('falla en la eliminación del ensayo ' + ensayo.id);
                        console.error(response);
                        ensayo.edit = false;
                    }
                });


            }

            function confirmarCambiosEnsayo(vm, ensayo) {
                vm.waitModalText = 'Actualizando Ensayo un momento por favor ...';
                $('#waitModal').modal('show');
                ensayoService.updateEnsayo(ensayo).then(function (response) {
                    if (response.data.code == "00000") {
                        console.log('Actualización de ensayo ' + ensayo.id + 'OK');
                        ensayo.backup = null;
                        $('#waitModal').modal('hide');
                        ensayo.edit = false;
                    } else {
                        console.log('falla en la actualización de ensayo ' + ensayo.id);
                        console.error(response);
                        descartarCambiosEnsayo(vm, ensayo);
                    }
                }
                );

            }

            function descartarCambiosEnsayo(vm, ensayo) {

                ensayo.descripcion = ensayo.backup.descripcion;
                ensayo.precio_real = ensayo.backup.precio_real;
                ensayo.tiempo = ensayo.backup.tiempo;
                ensayo.codinterno = ensayo.backup.codinterno;
                ensayo.orden = ensayo.backup.orden;
                ensayo.backup = null;
                ensayo.edit = false;
            }

            function editarEnsayo(vm, ensayo) {

                ensayo.backup = angular.copy(ensayo);
                ensayo.edit = true;
            }

            function changeFilter(vm) {
                ensayoService.getEnsayosPaginacion(vm.filter).then((response) => {
                    vm.ensayos = response.data.data.ensayos;
                    vm.totalEnsayos = response.data.data.cantidad_total;
                    console.log(vm.totalEnsayos);
                    vm.loading = false;
                    setMaxPage(vm);
                });
            }

            function setMaxPage(vm) {
                vm.maxPage = parseInt(vm.totalEnsayos / vm.filter.cantidad);

                if (vm.totalEnsayos % vm.filter.cantidad > 0) {
                    vm.maxPage++;
                }
            }

            return interfaz;
        });

