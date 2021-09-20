function initLoadTerceroAdmin(idPerfil, idUsuario) {
    //alert("tercero");

    //load components
    loadGridTercerosAdminTercero();
    loadInputNombreterceroAdminTercero();
    eventClickGridTercerosAdminTercero();
    loadDropDownTipoIdentificacionAdminTercero();
    loadInputNumeroIdentificacionAdminTercero();
    loadInputRepresentanteAdminTercero();
    loadInputDireccionAdminTercero();
    loadInputTelefono1AdminTercero();
    loadInputTelefono2AdminTercero();
    loadInputEmailAdminTercero();
    loadInputFaxAdminTercero();
    loadDropDownCiudadAdminTercero();
    loadCheckBoxDescuentoAdminTercero();
    loadNumberInputPorcentajeAdminTercero();
    loadCheckBoxPorcentajeAdminTercero();
    loadDateInputFechaContratoAdminTercero();
    loadDateInputFechaVenContratoAdminTercero();
    loadButtonActualizarTerceroAdminTercero();
    loadButtonEditarTerceroAdminTercero();
    loadButtonCrearTerceroAdminTercero();
    loadNotificationAdminTercero();
    loadButtonContactosTerceroAdminTercero();
    loadWindowAddContactoAdminTercero();



    // load Events
    eventClickGridTercerosAdminTercero();
    eventClickButtonEditarTerceroAdminTercero();
    eventClickButtonActualizarTerceroAdminTercero();
    eventClickButtonCrearTerceroAdminTercero();
    eventClickButtonContactosTerceroAdminTercero();



}

function loadGridContactosAdminTercero(idTercero) {
    var url = "model/DB/jqw/contactoData.php?query=contactosByTercero&idTercero=" + idTercero;
    // prepare the data
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'nombre', type: 'string'},
                    {name: 'cargo', type: 'string'},
                    {name: 'area', type: 'string'},
                    {name: 'telefono', type: 'int'},
                    {name: 'movil', type: 'int'},
                    {name: 'extencion', type: 'int'},
                    {name: 'email', type: 'string'},
                    {name: 'idTercero', type: 'int'},
                    {name: 'preferencias', type: 'string'},
                ],
                id: 'id',
                updaterow: function (rowid, rowdata, commit) {

                    ajaxUpdateContacto(rowdata.id, rowdata.nombre, rowdata.cargo, rowdata.area, rowdata.telefono, rowdata.movil, rowdata.extencion, rowdata.email, rowdata.idTercero, rowdata.preferencias)
                    commit(true);
                },
                url: url
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#gridContactosAdminTercero").jqxGrid(
            {
                width: 1200,
                height: 300,
                source: dataAdapter,
                editable: true,
                editmode: 'dblclick',
                showstatusbar: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");

                    container.append(addButton);

                    statusbar.append(container);
                    addButton.jqxButton({width: 60, height: 20});

                    // add new row.
                    addButton.click(function (event) {
                        var rowindex = $('#gridTercerosAdminTercero').jqxGrid('getselectedrowindex');
                        var data = $('#gridTercerosAdminTercero').jqxGrid('getrowdata', rowindex);
                        ajaxCreateContacto('Nuevo Contacto', 'Cargo', 'Área', 'Teléfono', 'Movil', 'Extensión', 'Email', data.id, 'Preferencias');

                    });



                },
                columns: [
                    {text: 'id', datafield: 'id', width: 50, hidden: true},
                    {text: 'Nombre', datafield: 'nombre', width: 180},
                    {text: 'Cargo', datafield: 'cargo', width: 100},
                    {text: 'Área', datafield: 'area', width: 150},
                    {text: 'Teléfono', datafield: 'telefono', width: 100},
                    {text: 'Movil', datafield: 'movil', width: 100},
                    {text: 'Extensión', datafield: 'extencion', width: 70},
                    {text: 'Email', datafield: 'email', width: 200},
                    {text: 'idTercero', datafield: 'idTercero', width: 10, hidden: true},
                    {text: 'preferencias', datafield: 'preferencias', width: 200}
                ]
            });
}

function loadWindowAddContactoAdminTercero() {
    $('#windowAddContactoAdminTercero').jqxWindow({isModal: true,
        height: 380,
        width: 1230,
        title: 'Gestión de Contactos',
        autoOpen: false,
        maxWidth: 2000,
        position: {x: 50, y: 100}
    });
}

function loadButtonContactosTerceroAdminTercero() {
    $("#buttonContactosTerceroAdminTercero").jqxButton({width: '180', disabled: true});
}

function loadButtonCrearTerceroAdminTercero() {
    $("#buttonCrearTerceroAdminTercero").jqxButton({width: '100', disabled: true});
}


function loadButtonEditarTerceroAdminTercero() {
    $("#buttonEditarTerceroAdminTercero").jqxButton({width: '100', disabled: true});
}

function loadButtonActualizarTerceroAdminTercero() {
    $("#buttonActualizarTerceroAdminTercero").jqxButton({width: '100', disabled: true});
}

function loadDateInputFechaVenContratoAdminTercero() {
    $("#dateInputFechaVenContratoAdminTercero").jqxDateTimeInput({width: '250px', height: '25px', disabled: true, enableBrowserBoundsDetection: true});
}

function loadDateInputFechaContratoAdminTercero() {
    $("#dateInputFechaContratoAdminTercero").jqxDateTimeInput({width: '250px', height: '25px', disabled: true, enableBrowserBoundsDetection: true});
}

function loadCheckBoxPorcentajeAdminTercero() {
    $("#checkBoxContratoAdminTercero").jqxCheckBox({width: 120, height: 25, disabled: true, checked: false});
}

function loadNumberInputPorcentajeAdminTercero() {
    $("#numberInputPorcentajeAdminTercero").jqxNumberInput({width: 250, height: '25px', digits: 3, symbolPosition: 'right', symbol: '%', spinButtons: true, disabled: true});
}

function loadCheckBoxDescuentoAdminTercero() {
    $("#checkBoxDescuentoAdminTercero").jqxCheckBox({width: 120, height: 25, disabled: true, checked: false});
}

function loadDropDownCiudadAdminTercero() {
    var url = "model/DB/jqw/ciudadData.php?query=getAllCiudad";
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'nombre', type: 'string'}
                ],
                url: url,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxDropDownList
    $("#dropDownCiudadAdminTercero").jqxDropDownList({
        selectedIndex: 0, source: dataAdapter, displayMember: "nombre", valueMember: "id", width: 200, height: 25, disabled: true
    });

}

function loadInputEmailAdminTercero() {
    $("#inputEmailAdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadInputFaxAdminTercero() {
    $("#inputFaxAdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadInputTelefono2AdminTercero() {
    $("#inputTelefono2AdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadInputTelefono1AdminTercero() {
    $("#inputTelefono1AdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadInputDireccionAdminTercero() {
    $("#inputDireccionAdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadInputRepresentanteAdminTercero() {
    $("#inputRepresentanteAdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadInputNumeroIdentificacionAdminTercero() {
    $("#inputNumeroIdentificacionAdminTercero").jqxInput({height: 25, width: 250, disabled: true});
}

function loadDropDownTipoIdentificacionAdminTercero() {
    var url = "model/DB/jqw/tipoIdentificacionData.php?query=getAllTipo";
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'tipoIdentificacion', type: 'string'}
                ],
                url: url,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxDropDownList
    $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList({
        selectedIndex: 0, source: dataAdapter, displayMember: "tipoIdentificacion", valueMember: "id", width: 200, height: 25, disabled: true
    });
}

function loadInputNombreterceroAdminTercero() {
    $("#inputNombreterceroAdminTercero").jqxInput({height: 25, width: 390, disabled: true});
}

function loadGridTercerosAdminTercero() {
    var url = "model/DB/jqw/terceroData.php?query=all";

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'nombre', type: 'string'},
                    {name: 'tipoIdentificacion', type: 'int'},
                    {name: 'numeroIdentificacion', type: 'string'},
                    {name: 'representante', type: 'string'},
                    {name: 'direccion', type: 'string'},
                    {name: 'telefono1', type: 'int'},
                    {name: 'telefono2', type: 'int'},
                    {name: 'fax', type: 'int'},
                    {name: 'email', type: 'string'},
                    {name: 'idCiudad', type: 'int'},
                    {name: 'porDescuento', type: 'number'},
                    {name: 'contrato', type: 'int'},
                    {name: 'venContrato', type: 'int'},
                    {name: 'fechaVenContrato', type: 'date'},
                    {name: 'fechaContrato', type: 'date'},
                    {name: 'estado', type: 'int'},
                    {name: 'descuento', type: 'int'}
                ],
                id: 'id',
                url: url,
                root: 'data'
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridTercerosAdminTercero").jqxGrid(
            {
                width: 400,
                height: 345,
                source: dataAdapter,
                columnsresize: true,
                showstatusbar: true,
                sortable: true,
                filterable: true,
                showfilterrow: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");

                    container.append(addButton);

                    statusbar.append(container);
                    addButton.jqxButton({width: 60, height: 20});

                    addButton.click(function (event) {
                        eventClickButtonAddGridTercerosAdminTercero();

                    });
                },
                columns: [
                    {text: 'idtercero', dataField: 'id', width: 100, hidden: true},
                    {text: 'Nombre del Cliente', dataField: 'nombre', filtertype: 'input', width: 380},
                    {text: 'Representante', dataField: 'representante', filtertype: 'input', width: 300, hidden: true},
                    {text: 'tipoIdentificacion', dataField: 'tipoIdentificacion', filtertype: 'number', width: 300, hidden: true},
                    {text: 'numeroIdentificacion', dataField: 'numeroIdentificacion', filtertype: 'number', width: 300, hidden: true},
                    {text: 'direccion', dataField: 'direccion', filtertype: 'number', width: 300, hidden: true},
                    {text: 'telefono1', dataField: 'telefono1', filtertype: 'number', width: 300, hidden: true},
                    {text: 'telefono2', dataField: 'telefono2', filtertype: 'number', width: 300, hidden: true},
                    {text: 'fax', dataField: 'fax', filtertype: 'number', width: 300, hidden: true},
                    {text: 'email', dataField: 'email', filtertype: 'number', width: 300, hidden: true},
                    {text: 'idCiudad', dataField: 'idCiudad', filtertype: 'number', width: 300, hidden: true},
                    {text: 'porDescuento', dataField: 'porDescuento', filtertype: 'number', width: 300, hidden: true},
                    {text: 'contrato', dataField: 'contrato', filtertype: 'number', width: 300, hidden: true},
                    {text: 'venContrato', dataField: 'venContrato', filtertype: 'number', width: 300, hidden: true},
                    {text: 'fechaVenContrato', dataField: 'fechaVenContrato', filtertype: 'number', width: 300, hidden: true},
                    {text: 'fechaContrato', dataField: 'fechaContrato', filtertype: 'number', width: 300, hidden: true},
                    {text: 'estado', dataField: 'estado', filtertype: 'number', width: 300, hidden: true},
                    {text: 'descuento', dataField: 'descuento', filtertype: 'number', width: 300, hidden: true}
                ]
            });
}




function loadNotificationAdminTercero() {
    $("#notificationAdminTercero").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function openNotificationAdminTercero(template, message) {
    $("#messageNotificationAdminTercero").text(message);
    $("#notificationAdminTercero").jqxNotification({template: template});
    $("#notificationAdminTercero").jqxNotification("open");
}



function eventClickGridTercerosAdminTercero() {
    $('#gridTercerosAdminTercero').on('rowselect', function (event)
    {
        $("#buttonContactosTerceroAdminTercero").jqxButton({disabled: false});
        $("#buttonCrearTerceroAdminTercero").jqxButton({disabled: true});
        utilDisableForm();

        // event arguments.
        var args = event.args;
        // row's bound index.
        var rowBoundIndex = args.rowindex;
        // row's data. The row's data object or null(when all rows are being selected or unselected with a single action). If you have a datafield called "firstName", to access the row's firstName, use var firstName = rowData.firstName;
        var rowData = args.row;
        $("#inputNombreterceroAdminTercero").jqxInput('val', rowData.nombre);
        var items = $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList('getItems');
        for (var i = 0; i < items.length; i++) {

            if (items[i].value == rowData.tipoIdentificacion) {
                $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList({disabled: false});
                $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList('selectIndex', items[i].index);
                $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList({disabled: true});
                break;
            }
        }
        $("#inputNumeroIdentificacionAdminTercero").jqxInput('val', rowData.numeroIdentificacion);
        $("#inputRepresentanteAdminTercero").jqxInput('val', rowData.representante);
        $("#inputDireccionAdminTercero").jqxInput('val', rowData.direccion);
        $("#inputTelefono1AdminTercero").jqxInput('val', rowData.telefono1);
        $("#inputTelefono2AdminTercero").jqxInput('val', rowData.telefono2);
        $("#inputFaxAdminTercero").jqxInput('val', rowData.fax);
        $("#inputEmailAdminTercero").jqxInput('val', rowData.email);
        var items = $("#dropDownCiudadAdminTercero").jqxDropDownList('getItems');
        for (var i = 0; i < items.length; i++) {

            if (items[i].value == rowData.idCiudad) {
                $("#dropDownCiudadAdminTercero").jqxDropDownList({disabled: false});
                $("#dropDownCiudadAdminTercero").jqxDropDownList('selectIndex', items[i].index);
                $("#dropDownCiudadAdminTercero").jqxDropDownList({disabled: true});
                break;
            }
        }
        if (rowData.descuento == 1) {
            $('#checkBoxDescuentoAdminTercero').jqxCheckBox('check');
        } else {
            $('#checkBoxDescuentoAdminTercero').jqxCheckBox('uncheck');
        }
        $("#numberInputPorcentajeAdminTercero").jqxNumberInput({disabled: false});
        if (rowData.porDescuento == null) {
            $("#numberInputPorcentajeAdminTercero").jqxNumberInput('val', 0);
        } else {
            $("#numberInputPorcentajeAdminTercero").jqxNumberInput('val', rowData.porDescuento);
        }
        $("#numberInputPorcentajeAdminTercero").jqxNumberInput({disabled: true});
        if (rowData.contrato == 1) {
            $('#checkBoxContratoAdminTercero').jqxCheckBox('check');
        } else {
            $('#checkBoxContratoAdminTercero').jqxCheckBox('uncheck');
        }
        $('#dateInputFechaContratoAdminTercero').jqxDateTimeInput('val', rowData.fechaContrato);
        $('#dateInputFechaVenContratoAdminTercero').jqxDateTimeInput('val', rowData.fechaVenContrato);
        $("#buttonEditarTerceroAdminTercero").jqxButton({disabled: false});
        $("#buttonActualizarTerceroAdminTercero").jqxButton({disabled: true});

    });
}

function eventClickButtonEditarTerceroAdminTercero() {
    $('#buttonEditarTerceroAdminTercero').on('click', function () {
        utilEnableForm();
        $("#buttonActualizarTerceroAdminTercero").jqxButton({disabled: false});
        $("#buttonContactosTerceroAdminTercero").jqxButton({disabled: true});

    });

}

function eventClickButtonContactosTerceroAdminTercero() {
    $('#buttonContactosTerceroAdminTercero').on('click', function () {

        $('#windowAddContactoAdminTercero').jqxWindow('open');
        var rowindex = $('#gridTercerosAdminTercero').jqxGrid('getselectedrowindex');
        var data = $('#gridTercerosAdminTercero').jqxGrid('getrowdata', rowindex);

        loadGridContactosAdminTercero(data.id);
    });

}

function eventClickButtonActualizarTerceroAdminTercero() {
    $('#buttonActualizarTerceroAdminTercero').on('click', function () {
        utilDisableForm();
        $("#buttonActualizarTerceroAdminTercero").jqxButton({disabled: true});
        $("#buttonEditarTerceroAdminTercero").jqxButton({disabled: false});
        var rowindex = $('#gridTercerosAdminTercero').jqxGrid('getselectedrowindex');
        var data = $('#gridTercerosAdminTercero').jqxGrid('getrowdata', rowindex);
        var id = data.id;
        var nombre = $("#inputNombreterceroAdminTercero").jqxInput('val');

        var tercerosData = $('#gridTercerosAdminTercero').jqxGrid('getrows');
        var validaRep = tercerosData.find(function (tercero) {
            return tercero.nombre == this;
        }, nombre);

        /*if(validaRep != undefined){
         eventOpenNotificationAdminTercero('error', 'Ya existe un cliente con el nombre ' + nombre + '.');
         return false;
         }*/

        var idTipoIdentificacion = $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList('val');
        var numIdentificacion = $("#inputNumeroIdentificacionAdminTercero").jqxInput('val');
        var representante = $("#inputRepresentanteAdminTercero").jqxInput('val');
        var direccion = $("#inputDireccionAdminTercero").jqxInput('val');
        var tel1 = $("#inputTelefono1AdminTercero").jqxInput('val');
        var tel2 = $("#inputTelefono2AdminTercero").jqxInput('val');
        var fax = $("#inputFaxAdminTercero").jqxInput('val');
        var email = $("#inputEmailAdminTercero").jqxInput('val');
        var idCiudad = $("#dropDownCiudadAdminTercero").jqxDropDownList('val');
        var descuento = $('#checkBoxDescuentoAdminTercero').jqxCheckBox('val');
        if (descuento == true) {
            descuento = 1;
        } else {
            descuento = 0;
        }
        var porDescuento = $("#numberInputPorcentajeAdminTercero").jqxNumberInput('val');
        var contrato = $('#checkBoxContratoAdminTercero').jqxCheckBox('val');
        if (contrato == true) {
            contrato = 1;
        } else {
            contrato = 0;
        }
        var fechaContrato = $('#dateInputFechaContratoAdminTercero').jqxDateTimeInput('getDate');
        var fechaVenContrato = $('#dateInputFechaVenContratoAdminTercero').jqxDateTimeInput('getDate');
        var fecContrato = fechaContrato !== null ? fechaContrato.getFullYear() + "-" + (fechaContrato.getMonth() + 1) + "-" + fechaContrato.getDate() : null;
        var fecVenContrato = fechaVenContrato !== null ? fechaVenContrato.getFullYear() + "-" + (fechaVenContrato.getMonth() + 1) + "-" + fechaVenContrato.getDate() : null;
        if (nombre !== '' && nombre !== null && numIdentificacion !== '' && numIdentificacion !== null
                && direccion !== '' && direccion !== null && tel1 !== '' && tel1 !== null
                && representante !== '' && representante !== null) {
            ajaxUpdateTerceroById(id, nombre, idTipoIdentificacion, numIdentificacion, representante, direccion, tel1, tel2, fax, email, idCiudad, descuento, porDescuento, contrato, fecContrato, fecVenContrato);
        } else {
            eventOpenNotificationAdminTercero('error', 'Los campos nombre, representante dirección, email y teléfono 1 son obligatorios.' + nombre + '.');
        }

    });

}

function eventClickButtonCrearTerceroAdminTercero() {
    $('#buttonCrearTerceroAdminTercero').on('click', function () {


        $("#buttonActualizarTerceroAdminTercero").jqxButton({disabled: true});
        $("#buttonEditarTerceroAdminTercero").jqxButton({disabled: true});

        var nombre = $("#inputNombreterceroAdminTercero").jqxInput('val');
        if (nombre == '') {
            eventOpenNotificationAdminTercero('error', 'No es posible crear un cliente sin nombre');
            return false;
        }

        var tercerosData = $('#gridTercerosAdminTercero').jqxGrid('getrows');
        var validarRep = tercerosData.find(function (tercero) {
            return tercero.nombre == this;
        }, nombre);
        if (validarRep != undefined) {
            eventOpenNotificationAdminTercero('error', 'Ya existe un cliente con el nombre ' + nombre + '.');
            return false;
        }
        var idTipoIdentificacion = $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList('val');
        var numIdentificacion = $("#inputNumeroIdentificacionAdminTercero").jqxInput('val');
        if (numIdentificacion == '') {
            eventOpenNotificationAdminTercero('error', 'No es posible crear un cliente sin número de identificación.');
            return false;
        }
        var representante = $("#inputRepresentanteAdminTercero").jqxInput('val');
        if (representante == '') {
            eventOpenNotificationAdminTercero('error', 'No es posible crear un cliente sin representante.');
            return false;
        }
        var direccion = $("#inputDireccionAdminTercero").jqxInput('val');
        var tel1 = $("#inputTelefono1AdminTercero").jqxInput('val');
        if (tel1 == '') {
            eventOpenNotificationAdminTercero('error', 'No es posible crear un cliente sin telefono.');
            return false;
        }
        var tel2 = $("#inputTelefono2AdminTercero").jqxInput('val');
        var fax = $("#inputFaxAdminTercero").jqxInput('val');
        var email = $("#inputEmailAdminTercero").jqxInput('val');
        var idCiudad = $("#dropDownCiudadAdminTercero").jqxDropDownList('val');
        var descuento = $('#checkBoxDescuentoAdminTercero').jqxCheckBox('val');
        if (descuento == true) {
            descuento = 1;
        } else {
            descuento = 0;
        }
        var porDescuento = $("#numberInputPorcentajeAdminTercero").jqxNumberInput('val');
        var contrato = $('#checkBoxContratoAdminTercero').jqxCheckBox('val');
        if (contrato == true) {
            contrato = 1;
        } else {
            contrato = 0;
        }
        var fechaContrato = $('#dateInputFechaContratoAdminTercero').jqxDateTimeInput('getDate');
        var fechaVenContrato = $('#dateInputFechaVenContratoAdminTercero').jqxDateTimeInput('getDate');
        var fecContrato = fechaContrato !== null ? fechaContrato.getFullYear() + "-" + (fechaContrato.getMonth() + 1) + "-" + fechaContrato.getDate() : null;
        var fecVenContrato = fechaVenContrato !== null ? fechaVenContrato.getFullYear() + "-" + (fechaVenContrato.getMonth() + 1) + "-" + fechaVenContrato.getDate() : null;
        ajaxCrearTercero(nombre, idTipoIdentificacion, numIdentificacion, representante, direccion, tel1, tel2, fax, email, idCiudad, descuento, porDescuento, contrato, fecContrato, fecVenContrato);
    });

}

function eventClickButtonAddGridTercerosAdminTercero() {
    utilClearForm();
    utilEnableForm();
    $("#buttonActualizarTerceroAdminTercero").jqxButton({disabled: true});
    $("#buttonEditarTerceroAdminTercero").jqxButton({disabled: true});
    $("#buttonCrearTerceroAdminTercero").jqxButton({disabled: false});
}


function utilClearForm() {
    $("#inputNombreterceroAdminTercero").jqxInput('val', '');
    $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList('selectIndex', 0);
    $("#inputNumeroIdentificacionAdminTercero").jqxInput('val', '');
    $("#inputRepresentanteAdminTercero").jqxInput('val', '');
    $("#inputDireccionAdminTercero").jqxInput('val', '');
    $("#inputTelefono1AdminTercero").jqxInput('val', '');
    $("#inputTelefono2AdminTercero").jqxInput('val', '');
    $("#inputFaxAdminTercero").jqxInput('val', '');
    $("#inputEmailAdminTercero").jqxInput('val', '');
    $("#dropDownCiudadAdminTercero").jqxDropDownList('selectIndex', 0);
    $('#checkBoxDescuentoAdminTercero').jqxCheckBox('uncheck');
    $("#numberInputPorcentajeAdminTercero").jqxNumberInput('val', '');
    $('#checkBoxContratoAdminTercero').jqxCheckBox('uncheck');
    $('#dateInputFechaContratoAdminTercero').jqxDateTimeInput('val', new Date());
    $('#dateInputFechaVenContratoAdminTercero').jqxDateTimeInput('val', new Date());

}
function utilEnableForm() {
    $("#inputNombreterceroAdminTercero").jqxInput({disabled: false});
    $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList({disabled: false});
    $("#inputNumeroIdentificacionAdminTercero").jqxInput({disabled: false});
    $("#inputRepresentanteAdminTercero").jqxInput({disabled: false});
    $("#inputDireccionAdminTercero").jqxInput({disabled: false});
    $("#inputTelefono1AdminTercero").jqxInput({disabled: false});
    $("#inputTelefono2AdminTercero").jqxInput({disabled: false});
    $("#inputFaxAdminTercero").jqxInput({disabled: false});
    $("#inputEmailAdminTercero").jqxInput({disabled: false});
    $("#dropDownCiudadAdminTercero").jqxDropDownList({disabled: false});
    $('#checkBoxDescuentoAdminTercero').jqxCheckBox({disabled: false});
    $("#numberInputPorcentajeAdminTercero").jqxNumberInput({disabled: false});
    $('#checkBoxContratoAdminTercero').jqxCheckBox({disabled: false});
    $('#dateInputFechaContratoAdminTercero').jqxDateTimeInput({disabled: false});
    $('#dateInputFechaVenContratoAdminTercero').jqxDateTimeInput({disabled: false});
}

function utilDisableForm() {
    $("#inputNombreterceroAdminTercero").jqxInput({disabled: true});
    $("#dropDownTipoIdentificacionAdminTercero").jqxDropDownList({disabled: true});
    $("#inputNumeroIdentificacionAdminTercero").jqxInput({disabled: true});
    $("#inputRepresentanteAdminTercero").jqxInput({disabled: true});
    $("#inputDireccionAdminTercero").jqxInput({disabled: true});
    $("#inputTelefono1AdminTercero").jqxInput({disabled: true});
    $("#inputTelefono2AdminTercero").jqxInput({disabled: true});
    $("#inputFaxAdminTercero").jqxInput({disabled: true});
    $("#inputEmailAdminTercero").jqxInput({disabled: true});
    $("#dropDownCiudadAdminTercero").jqxDropDownList({disabled: true});
    $('#checkBoxDescuentoAdminTercero').jqxCheckBox({disabled: true});
    $("#numberInputPorcentajeAdminTercero").jqxNumberInput({disabled: true});
    $('#checkBoxContratoAdminTercero').jqxCheckBox({disabled: true});
    $('#dateInputFechaContratoAdminTercero').jqxDateTimeInput({disabled: true});
    $('#dateInputFechaVenContratoAdminTercero').jqxDateTimeInput({disabled: true});
}

function ajaxUpdateTerceroById(id, nombre, tipoIdentificacion, numIdentificacion, representante, direccion, tel1, tel2, fax, email, idCiudad, descuento, porDescuento, contrato, fecContrato, fecVenContrato) {
    var url = "index.php"
    var data = "action=updateTercero";
    data = data + "&id=" + id;
    data = data + "&nombre=" + nombre;
    data = data + "&tipoIdentificacion=" + tipoIdentificacion;
    data = data + "&numIdentificacion=" + numIdentificacion;
    data = data + "&representante=" + representante;
    data = data + "&direccion=" + direccion;
    data = data + "&tel1=" + tel1;
    data = data + "&tel2=" + tel2;
    data = data + "&fax=" + fax;
    data = data + "&email=" + email;
    data = data + "&idCiudad=" + idCiudad;
    data = data + "&descuento=" + descuento;
    data = data + "&porDescuento=" + porDescuento;
    data = data + "&contrato=" + contrato;
    data = data + "&fecContrato=" + fecContrato;
    data = data + "&fecVenContrato=" + fecVenContrato;




    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,

        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {
                $('#gridTercerosAdminTercero').jqxGrid('updatebounddata');
                eventOpenNotificationAdminTercero('success', response.message)

            } else {
                eventOpenNotificationAdminTercero('error', response.message);

            }

        }
    });
}

function ajaxCrearTercero(nombre, idTipoIdentificacion, numIdentificacion, representante, direccion, tel1, tel2, fax, email, idCiudad, descuento, porDescuento, contrato, fecContrato, fecVenContrato) {
    var url = "index.php"
    var data = "action=crearTercero";
    data = data + "&nombre=" + nombre;
    data = data + "&idTipoIdentificacion=" + idTipoIdentificacion;
    data = data + "&numIdentificacion=" + numIdentificacion;
    data = data + "&representante=" + representante;
    data = data + "&direccion=" + direccion;
    data = data + "&tel1=" + tel1;
    data = data + "&tel2=" + tel2;
    data = data + "&fax=" + fax;
    data = data + "&email=" + email;
    data = data + "&idCiudad=" + idCiudad;
    data = data + "&descuento=" + descuento;
    data = data + "&porDescuento=" + porDescuento;
    data = data + "&contrato=" + contrato;
    data = data + "&fecContrato=" + fecContrato;
    data = data + "&fecVenContrato=" + fecVenContrato;




    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,

        success: function (data, textStatus, jqXHR) {
            utilClearForm();
            utilDisableForm();
            var response = JSON.parse(data);
            if (response.result == 0) {
                $('#gridTercerosAdminTercero').jqxGrid('updatebounddata');
                eventOpenNotificationAdminTercero('success', response.message)
                $("#buttonCrearTerceroAdminTercero").jqxButton({disabled: true});
            } else {
                eventOpenNotificationAdminTercero('error', response.message);

            }

        }
    });
}

function ajaxUpdateContacto(id, nombre, cargo, area, telefono, movil, extencion, email, idTercero, preferencias) {
    var url = "index.php"
    var data = "action=updateContacto";
    data = data + "&id=" + id;
    data = data + "&nombre=" + nombre;
    data = data + "&cargo=" + cargo;
    data = data + "&area=" + area;
    data = data + "&telefono=" + telefono;
    data = data + "&movil=" + movil;
    data = data + "&extencion=" + extencion;
    data = data + "&email=" + email;
    data = data + "&idTercero=" + idTercero;
    data = data + "&preferencias=" + preferencias;





    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,

        success: function (data, textStatus, jqXHR) {
            utilClearForm();
            utilDisableForm();
            var response = JSON.parse(data);
            if (response.result == 0) {
                $('#gridContactosAdminTercero').jqxGrid('updatebounddata');
                eventOpenNotificationAdminTercero('success', 'Se actualizado exitosamente el contacto');

            } else {
                eventOpenNotificationAdminTercero('error', response.message);

            }

        }
    });
}

function ajaxCreateContacto(nombre, cargo, area, telefono, movil, extencion, email, idTercero, preferencias) {
    var url = "index.php"
    var data = "action=createContacto";
    data = data + "&nombre=" + nombre;
    data = data + "&cargo=" + cargo;
    data = data + "&area=" + area;
    data = data + "&telefono=" + telefono;
    data = data + "&movil=" + movil;
    data = data + "&extencion=" + extencion;
    data = data + "&email=" + email;
    data = data + "&idTercero=" + idTercero;
    data = data + "&preferencias=" + preferencias;





    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,

        success: function (data, textStatus, jqXHR) {
            utilClearForm();
            utilDisableForm();
            var response = JSON.parse(data);
            if (response.result == 0) {
                $('#gridContactosAdminTercero').jqxGrid('updatebounddata');
                eventOpenNotificationAdminTercero('success', 'test');

            } else {
                eventOpenNotificationAdminTercero('error', response.message);

            }

        }
    });
}


function eventOpenNotificationAdminTercero(template, message) {
    $("#messageNotificationAdminTercero").text(message);
    $("#notificationAdminTercero").jqxNotification({template: template});
    $("#notificationAdminTercero").jqxNotification("open");
}