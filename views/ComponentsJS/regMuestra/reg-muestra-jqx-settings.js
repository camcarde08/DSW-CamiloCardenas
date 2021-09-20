'use strict'

angular.module('CompRegMuestra')

        .value('regMuestraJqxSettings', {
            buttonLimpiarSettings: {
                width: '100%',
                height: '30px',
                disabled: false
            },
            buttonVerHistorialSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            buttonVerEstadosSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            buttonRegistrarAnalisisSettings: {
                width: '100%',
                height: '30px',
                disabled: false
            },
            buttonActualizarAnalisisSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            inputNumeroAnalisisSettings: {
                width: '88%',
                height: '30px',
                placeHolder: 'Numero de Análisis'
            },
            buttonSearchAnalisisSettings: {
                width: '10%',
                height: '30px'
            },
            checkBoxActivaSettings: {
                disabled: true,
                //checked: false,
            },
            inputEstadoActualAnalisisSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            dropDownPrioridadSettings: {
                width: '100%',
                height: '30px',
                source: [{id: 1, descripcion: 'Normal', tiempoEntrega: 12}, {id: 2, descripcion: 'Media', tiempoEntrega: 6}, {id: 3, descripcion: 'Alta', tiempoEntrega: 3}],
                selectedIndex: 0,
                autoDropDownHeight: true,
                displayMember: 'descripcion',
                change: function (e) {
                    //alert(this.$ctrl.fechaLlegada);
                    //this.$ctrl.fechaCompromiso = new Date();
                    //this.$ctrl.fechaCompromiso.setDate(this.$ctrl.fechaLlegada.getDate() + e.args.item.originalItem.tiempoEntrega);
                }
            },
            inputNumeroCotizacionSettings: {
                width: '100%',
                height: '30px'
            },
            inputNumeroRemisionSettings: {
                width: '100%',
                height: '30px'
            },
            inputIdentificadorClienteSettings: {
                width: '100%',
                height: '30px'
            },
            dateInputFechaLlegadaSettings: {
                width: '100%',
                height: '30px',
                change: function (e) {
                    //alert(this.$ctrl.fechaLlegada);
                    //this.$ctrl.fechaCompromiso = new Date();
                    //this.$ctrl.fechaCompromiso.setDate(this.$ctrl.fechaLlegada.getDate() + this.$ctrl.prioridad.tiempoEntrega);
                }
            },
            dateInputFechaCompromisoSettings: {
                width: '100%',
                height: '30px'
            },
            inputClienteSettings: {
                width: '100%',
                height: '30px',
                disabled: true,
                displayMember: 'nombre',
                valueMember: 'id'

            },
            dropDownListContactoSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true,
                placeHolder: 'Seleccione'
            },
            inputAreaContactoSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            inputLabFabricanteSettings: {
                width: '100%',
                height: '30px'
            },
            inputProcedenciaSettings: {
                width: '100%',
                height: '30px'
            },
            textAreaObservacionesSettings: {
                width: '100%',
                height: '120px'
            },
            textAreaCondicionesGeneralesSettings: {
                width: '100%',
                height: '120px'
            },
            dropDownAreaAnalisisSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true,
                selectedIndex: 3
            },
            regMuestraCoordinadorAreaSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            inputProductoSettings: {
                width: '100%',
                height: '30px',
                disabled: true,
                displayMember: 'nombreProducto',
                valueMember: 'id',
                items: 20
            },
            inputTipoProductoSettings: {
                width: '100%',
                height: '30px',
                disabled: true
            },
            dropDownEmpaqueSettings: {
                width: '100%',
                height: '30px',
                disabled: true,
                displayMember: 'descripcion',
                valueMember: 'id'
            },
            buttonAddEmpaqueSettings: {
                width: '50%',
                height: '32px',
                template: 'success',
            },
            dropDownEnvaseSettings: {
                width: '100%',
                height: '30px',
                disabled: true,
                displayMember: 'descripcion',
                valueMember: 'id'
            },
            buttonAddEnvaseSettings: {
                width: '50%',
                height: '32px',
                template: 'success'
            },
            dateInputFechaFabricacionSettings: {
                width: '100%',
                height: '30px'
            },
            dateInputFechaVencimientoSettings: {
                width: '100%',
                height: '30px'
            },
            inputTamanoLoteSettings: {
                width: '100%',
                height: '30px'
            },
            inputNumeroLoteSettings: {
                width: '100%',
                height: '30px'
            },
            inputCantidadEnviadaLoteSettings: {
                width: '100%',
                height: '30px'
            },
            gridPrincipioActivoSettings: {
                altrows: true,
                width: '100%',
                sortable: true,
                columns: [
                    {text: 'Principio Activo', align: 'center', datafield: 'nombrePrincipioActivo', width: '100%'},
                    {text: 'Principal', datafield: 'principal', width: '33%', hidden: true},
                    {text: 'Trazador', datafield: 'trazador', width: '33%', hidden: true}
                ],
                autoheight: true
            },
            gridEnsayosSettings: {
                altrows: true,
                width: '100%',
                height: '300px',
                columns: [
                    {text: 'idPaquete', datafield: 'idPaquete', editable: false, width: '34%', hidden: true},
                    {text: 'Paquete', datafield: 'nomPaquete', editable: false, width: '34%', hidden: true},
                    {text: 'idEnsayo', datafield: 'idEnsayo', editable: false, width: '33%', hidden: true},
                    {text: 'Ensayo', datafield: 'nomEnsayo', editable: true, width: '30%'},
                    {text: 'Especificación', datafield: 'especificacion', editable: true, width: '60%'},
                    {text: 'Seleccione', datafield: 'validacion', columntype: 'checkbox', editable: true, width: '10%'},
                    {text: 'tiempo', datafield: 'tiempo', editable: true, width: '20%', hidden: true},
                    {text: 'idMetodo', datafield: 'idMetodo', editable: false, width: '33%', hidden: true},
                    {text: 'idProductoEnsayo', datafield: 'idProductoEnsayo', editable: false, width: '33%', hidden: true},
                    {text: 'idHojaCalculo', datafield: 'idHojaCalculo', editable: false, width: '33%', hidden: true}
                ],
                autoheight: true,
                editable: true,
                groupable: true,
                groupsexpandedbydefault: true,
                showgroupsheader: false,
                showgroupmenuitems: false
            },
            dateInputFechaMuestreoSettings: {
                width: '100%',
                height: '30px'
            },
            dropDownTecnicaUsadaSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true,
                disabled: true,
                checkboxes: true
            },
            regMuestraEstabilidadMicSettings: {
                width: '100%',
                height: '30px'
            },
            dropDownTipoEstabilidadSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true
            },
            dropDownDuracionEstabilidadSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true
            },
            dropDownTipoMuestraSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true,
                disabled: true
            },
            dropDownAreaMicroSettings: {
                width: '100%',
                height: '30px',
                autoDropDownHeight: true,
                disabled: false
            },
            inputPuntoTomaSettings: {
                width: '100%',
                height: '30px'
            },
            inputPlantaTecnicaUsadaSettings: {
                width: '100%',
                height: '30px'
            },
            inputResponsableTomaSettings: {
                width: '100%',
                height: '30px'
            },
            inputSuperficieEquipoSettings: {
                width: '100%',
                height: '30px'
            },
            inputPlantaSettings: {
                width: '100%',
                height: '30px'
            },
            inputSanitizanteSettings: {
                width: '100%',
                height: '30px'
            },
            inputPlantaAreaSettings: {
                width: '100%',
                height: '30px'
            },
            inputFrotisRealizadoSettings: {
                width: '100%',
                height: '30px'
            },
            textAreaEspAerobiosMesofilosSettings: {
                width: '100%',
                height: '40px'
            },
            textAreaEspMohosLevadurasSettings: {
                width: '100%',
                height: '60px'
            },
            textAreaEspEColiSettings: {
                width: '100%',
                height: '60px'
            },
            inputNewEmpaqueSettings: {
                width: '100%',
                height: '30px'
            },
            inputNewEnvaseSettings: {
                width: '100%',
                height: '30px'
            },
            errorNotificationSettings: {
                width: "auto",
                position: "top-right",
                opacity: 0.9,
                template: 'error'
            },
            successNotificationSettings: {
                width: "auto",
                position: "top-right",
                opacity: 0.9,
                template: 'success'
            }
        });