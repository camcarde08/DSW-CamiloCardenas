'use strict'

angular.module('CompAdminCepa')

    .factory('adminCepaService', function ($filter,$timeout, cepaService, loteCepaService) {
        var interfaz = {
            closeModalNewCepa: closeModalNewCepa,
            closeModalNewLote: closeModalNewLote,
            confirmarCambiosCepa: confirmarCambiosCepa,
            confirmNewCepaModal: confirmNewCepaModal,
            confirmNewLoteModal: confirmNewLoteModal,
            descartarCambiosCepa: descartarCambiosCepa,
            editarCepa: editarCepa,
            eliminarCepa: eliminarCepa,
            getAllActiveCepas: getAllActiveCepas,
            openModalNewCepa: openModalNewCepa,
            openModalNewLote: openModalNewLote,
            SelectRowCepaGrid: SelectRowCepaGrid,
            clickTdGrillaLoteCepa: clickTdGrillaLoteCepa,
            activarLote: activarLote,
            clickConfirmActivateLote: clickConfirmActivateLote,
            


        }

        function confirmNewLoteModal(vm){
            var newLoteData = angular.copy(vm.newLote);
            newLoteData.fecha_vencimiento = $filter('date')(newLoteData.fecha_vencimiento, 'yyyy-MM-dd');
            newLoteData.fecha_ingreso = $filter('date')(newLoteData.fecha_ingreso, 'yyyy-MM-dd');
            newLoteData.fecha_apertura = $filter('date')(newLoteData.fecha_apertura, 'yyyy-MM-dd');
            newLoteData.fecha_terminacion = $filter('date')(newLoteData.fecha_terminacion, 'yyyy-MM-dd');
            newLoteData.fecha_preparacion = $filter('date')(newLoteData.fecha_preparacion, 'yyyy-MM-dd');
            newLoteData.fecha_promocion = $filter('date')(newLoteData.fecha_promocion, 'yyyy-MM-dd');
            closeModalNewLote(vm);
            vm.waitModalText = 'Creando nuevo lote un momento por favor ...';
            angular.element(waitModal).modal('show');
            loteCepaService.createNewLoteCepa(newLoteData,vm.selectedCepa.id).then(function(response){
                if (response.data.code == "00000") {
                    console.log('Creación lote OK');
                    
                } else {
                    console.log('fallo en la creación de lote');
                    console.error(response);
                    angular.element(waitModal).modal('hide');
                }
                vm.selectedLote = null;
                selectCepa(vm, vm.selectedCepaIndex, vm.selectedCepa);
            });
        }

        function openModalNewLote(vm){
            angular.element(newLoteModal).modal('show');
        }

        function closeModalNewLote(vm){
            vm.newLote = {
                codigo: '',
                tipo: '',
                cantidad_preparada: 0,
                lote_interno: '',
                cantidad_actual: 0,
                fecha_vencimiento: new Date(),
                fecha_ingreso: new Date(),
                fecha_apertura: new Date(),
                fecha_terminacion: new Date(),
                fecha_preparacion: new Date(),
                fecha_promocion: new Date()
            };
            angular.element(newLoteModal).modal('hide');
        }

        function clickConfirmActivateLote(vm){
            $('#modalCofirmmActivarLote').modal('hide');
            vm.waitModalText = 'Activando lote un momento por favor ...';
            angular.element(waitModal).modal('show');
            loteCepaService.activarLoteCepa(vm.selectedLote).then(function(response){
                if (response.data.code == "00000") {
                    console.log('Activacion lote OK');
                    
                } else {
                    console.log('fallo en la activacion de lote');
                    console.error(response);
                    angular.element(waitModal).modal('hide');
                }
                vm.selectedLote = null;
                selectCepa(vm, vm.selectedCepaIndex, vm.selectedCepa);
            });
        }

        function activarLote(vm){
            angular.element(modalCofirmmActivarLote).modal('show');
        }

        function clickTdGrillaLoteCepa(vm, index, lote) {
            vm.selectedLote = lote;
            angular.forEach(vm.lotesCepa, function (value, key) {
                key == index ? value.selected = true : value.selected = false;
            });
        }

        function confirmarCambiosCepa(vm, cepa) {
            vm.waitModalText = 'Actualizando cepa un momento por favor ...';
            angular.element(waitModal).modal('show');
            cepaService.updateCepa(cepa).then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Actualización cepa OK');
                    getAllActiveCepas(vm);
                } else {
                    console.log('fallo en la actualización de la cepa');
                    console.error(response);
                    angular.element(waitModal).modal('hide');
                }
            });
        }

        function editarCepa(vm, cepa) {
            cepa.backup = angular.copy(cepa);
            cepa.edit = true;
        }

        function eliminarCepa(vm, cepa, index) {
            vm.waitModalText = 'Eliminando cepa un momento por favor ...';
            angular.element(waitModal).modal('show');
            cepaService.deleteCepa(cepa).then(function (response) {
                if (response.data.code == "00000") {
                    console.log('Eliminación cepa OK');
                    getAllActiveCepas(vm);
                } else {
                    console.log('fallo al eliminar la cepa');
                    console.error(response);
                    angular.element(waitModal).modal('hide');
                }
            });
        }

        function descartarCambiosCepa(vm, cepa) {
            cepa.codigo = cepa.backup.codigo;
            cepa.nombre = cepa.backup.nombre;
            cepa.tipo = cepa.backup.tipo;
            cepa.edit = false;
            cepa.backup = null;

        }

        function closeModalNewCepa(vm) {
            try {
                vm.newCepa = {
                    codigo: '',
                    nombre: '',
                    tipo: ''
                };
            } catch (error) {

            }
            angular.element(newCepaModal).modal('hide');
        }

        function confirmNewCepaModal(vm) {
            var newCepaData = angular.copy(vm.newCepa);
            closeModalNewCepa(vm);
            vm.waitModalText = 'Creando nueva cepa un momento por favor ...';
            angular.element(waitModal).modal('show');
            cepaService.createNewCepa(newCepaData).then(function (response) {
                if (response.data.code == "00000") {

                    console.log('Creación nueva cepa OK');
                    getAllActiveCepas(vm);
                } else {
                    console.log('fallo en la creación de una nueva cepa');
                    console.error(response);
                }
            });
        }

        function getAllActiveCepas(vm) {
            vm.waitModalText = 'consultando las cepas existentes un momento por favor ...';
            angular.element(waitModal).modal('show');
            console.debug("prueba");
            cepaService.getAllActiveCepas().then(function (response) {
                if (response.data.code == "00000") {

                    console.log('Consulta cepas OK');
                    vm.cepas = response.data.data;
                } else {
                    console.log('falla en la consulta de cepas');
                    console.error(response);
                }
                angular.element(waitModal).modal('hide');


            });
        }

        function openModalNewCepa(vm) {
            angular.element(newCepaModal).modal('show');

        }

        function SelectRowCepaGrid(vm, index, cepa) {
            if (vm.selectedCepa != cepa) {
                vm.selectedLote = null;
                selectCepa(vm, index, cepa);
            }
        }

        function selectCepa(vm, index, cepa) {
            vm.selectedCepa = cepa;
            vm.selectedCepaIndex = index;
            angular.forEach(vm.cepas, function (value, key) {
                key == index ? value.selected = true : value.selected = false;
            });
            getEnsayosCepaByCepa(vm, cepa);
        }

        function getEnsayosCepaByCepa(vm, cepaData) {
            vm.waitModalText = 'consultando lotes asociados a la cepa un momento por favor ...';
            angular.element(waitModal).modal('show');
            loteCepaService.getLotesByIdCepa(cepaData.id).then(function (response) {
                if (response.data.code == "00000") {
                    
                    angular.forEach(response.data.data, function (value, key) {
                        formatLote(value);
                    });
                    vm.lotesCepa = response.data.data;
                    console.log('Consulta lotes cepa OK');

                } else {
                    console.log('falla en la consulta de lotes cepas');
                    console.error(response);
                }
                angular.element(waitModal).modal('hide');
            });

        }

        function formatLote(lote) {
            if(lote.fecha_ingreso){
                lote.fecha_ingreso = formatDateString(lote.fecha_ingreso);
            } else {
                lote.fecha_ingreso = null;
            }

            if(lote.fecha_apertura){
                lote.fecha_apertura = formatDateString(lote.fecha_apertura);
            } else {
                lote.fecha_apertura = null;
            }

            if(lote.fecha_terminacion){
                lote.fecha_terminacion = formatDateString(lote.fecha_terminacion);
            } else {
                lote.fecha_terminacion = null;
            }

            if(lote.fecha_preparacion){
                lote.fecha_preparacion = formatDateString(lote.fecha_preparacion);
            } else {
                lote.fecha_preparacion = null;
            }

            if(lote.fecha_promocion){
                lote.fecha_promocion = formatDateString(lote.fecha_promocion);
            } else {
                lote.fecha_promocion = null;
            }

            if(lote.fecha_vencimiento){
                lote.fecha_vencimiento = formatDateString(lote.fecha_vencimiento);
            } else {
                lote.fecha_vencimiento = null;
            }
            
        }

        function formatDateString(dateString) {
            var dateParts = dateString.split("-");
            return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
        }


        return interfaz;
    });

