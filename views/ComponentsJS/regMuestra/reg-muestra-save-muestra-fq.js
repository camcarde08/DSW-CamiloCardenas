'use strict'

angular.module('CompRegMuestra')

        .factory('regMuestraSaveMuestraFqFactory', function (muestraService, $filter) {
            var interfaz = {
                saveMuestraFQ: function (vm) {
                    console.log('prefijo', vm.tipoMuestra);
                    return  {
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
                        idTipoAnalisis: vm.tipoMuestra.id,
                        prefijo: vm.tipoMuestra.prefijo,
                        idProducto: parseInt(vm.producto.value),
                        idEmpaque: parseInt(vm.empaque.value),
                        idEnvase: parseInt(vm.envase.value),
                        fechaFabricacion: $filter('date')(vm.fechaFabricacion, 'yyyy-MM-dd'),
                        fechaVencimiento: $filter('date')(vm.fechaVencimiento, 'yyyy-MM-dd'),
                        tamanoLote: vm.tamanoLote,
                        numeroLote: vm.numeroLote,
                        cantidadLote: vm.cantidadLote,
                        ensayos: vm.gridEnsayosSettings.apply('getrows'),
                        EstabilidadMic: vm.EstabilidadMic,
                        plantaArea: vm.plantaArea,
                        fechaMuestreo: $filter('date')(vm.fechaMuestreo, 'yyyy-MM-dd'),
                        espAerobiosMesofilos: vm.espAerobiosMesofilos
                    };

                }
            };

            return interfaz;
        });