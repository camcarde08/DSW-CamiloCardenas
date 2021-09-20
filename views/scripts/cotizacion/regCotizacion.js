function initLoadRegCotizacion(idPerfil, idUsuario) {
    //load components
    loadCheckBoxAplicaIvaRegCotizacion();
    loadCheckBoxAplicaRetencionaRegCotizacion();
    loadNumCotizacionRegCotizacion();
    loadDropDownListEstadoRegCotizacion();
    loadDateInputFechaSolicitudRegCotizacion();
    loadDateInputFechaCompromisoRegCotizacion();
    loadInputNombreClienteRegCotizacion();
    loadInputNomContactoRegCotizacion();
    loadInputTelContactoRegCotizacion();
    loadEditorObservacionesRegCotizacion();
    loadEditorObservacionesRegCotizacionFin();
    loadGridProductosEnsayosRegCotizacion(idPerfil);
    loadWindowAddGridProductosEnsayosRegCotizacion();
    loadWindowDeleteGridProductosEnsayosRegCotizacion();
    loadWindowEnviarCotizacionRegCotizacion();
    loadWindowProductosMuestraRegCotizacion();
    loadDropDownListAreaAnalisisAddProductoRegCotizacion();
    loadDropDownListAreaAnalisisDeleteProductoRegCotizacion();
    loadNotificationRegCotizacion();
    loadButtonRegistrarRegCotizacion();
    loadButtonUpdateCotizacionRegCotizacion();
    loadButtonEnviarCotizacionRegCotizacion();
    loadButtonLimpiarRegCotizacion();
    loadButtonGenerarMuestraRegCotizacion();
    loadButtonImprimirCotizacion();
    loadButtonconsultaEnvioRegCotizacion();
    loadWindowEnviosaRegCotizacion();

    // load Events
    eventClickButtonOKWindowProductosMuestraRegCotizacion();
    eventClickButtonGenerarMuestraRegCotizacion();
    eventClickButtonInformePrint();
    eventClickButtonCancelWindowEnviarCotizacionRegCotizacion();
    eventClickButtonOKWindowEnviarCotizacionRegCotizacion();
    eventClickButtonLimpiarRegCotizacion();
    eventClickButtonEnviarCotizacionRegCotizacion();
    eventClickButtonUpdateCotizacionRegCotizacion();
    eventClickSearchNumCotizacion();
    eventOnChangeDateInputFechaSolicitudTegCotizacion();
    eventClickButtonOKWindowAddGridProductosEnsayosRegCotizacion();
    eventClickButtonOKWindowDeleteGridProductosEnsayosRegCotizacion();
    eventCloseWindowAddGridProductosEnsayosRegCotizacion();
    eventClickButtonRegistrarRegCotizacion();
    eventCloseWindowDeleteGridProductosEnsayosRegCotizacion();
    eventClickButtonconsultaEnvioRegCotizacion();


}
function loadCheckBoxAplicaIvaRegCotizacion() {
    $("#CheckBoxAplicaIvaRegCotizacion").jqxCheckBox({width: 120, height: 25});
}
function loadCheckBoxAplicaRetencionaRegCotizacion() {
    $("#CheckBoxAplicaRetencionRegCotizacion").jqxCheckBox({width: 120, height: 25});
}

function loadNumCotizacionRegCotizacion() {
    $("#numCotizacionRegCotizacion").jqxInput({placeHolder: "número a Buscar", height: 20, width: 200, minLength: 1});
}

function loadDropDownListEstadoRegCotizacion() {

    var url = 'model/DB/jqw/EstadoCotizacionData.php?query=getAllEstado';
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'estado'}
                ],
                url: url,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#estadoRegCotizacion").jqxDropDownList({source: dataAdapter, displayMember: "estado", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 100, disabled: true});
}

function loadDateInputFechaSolicitudRegCotizacion() {
    $("#fechaSolicitudRegCotizacion").jqxDateTimeInput({width: '190px', height: '20px'});
}

function loadDateInputFechaCompromisoRegCotizacion() {
    $("#fechaCompromisoRegCotizacion").jqxDateTimeInput({width: '190', height: '20'});
}

function loadInputNombreClienteRegCotizacion() {
    var source = {
        datatype: "json",
        datafields: [
            {name: 'id'},
            {name: 'nombre'},
        ],
        url: 'model/DB/jqw/terceroData.php?query=all',
        async: false
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#nombreClienteRegCotizacion").jqxInput({source: dataAdapter, placeHolder: "Nombre del Cliente", displayMember: "nombre", valueMember: "id", width: 350, height: 20});
}

function loadInputNomContactoRegCotizacion() {
    $("#nomContactoRegCotizacion").jqxInput({height: 20, width: 200, minLength: 1});
}

function loadInputTelContactoRegCotizacion() {
    $("#telContactoRegCotizacion").jqxInput({height: 20, width: 200, minLength: 1});
}

function loadEditorObservacionesRegCotizacion() {

    $('#observacionesRegCotizacion').jqxEditor({height: 140, width: 800, tools: "old italic underline | format font size | color background | ul ol | link | clean", theme: 'personal2'});
    $('#observacionesRegCotizacion').jqxEditor('val', 'A CONTINUACIÓN COTIZAMOS LOS SERVICIOS REQUERIDOS POR USTED');
}
function loadEditorObservacionesRegCotizacionFin() {
    $('#observacionesRegCotizacionFin').jqxEditor({height: 140, width: 800, tools: "old italic underline | format font size | color background | ul ol | link | clean", theme: 'personal2'});
    $('#observacionesRegCotizacionFin').jqxEditor('val', 'Insumos especiales (Reactivos, columnas): TESLA CHEMICAL podrá adquirir los reactivos y los insumos necesarios para análisis previo acuerdo y negociación. Análisis subcontratados: Si se ha llegado a un acuerdo previamente, TESLA CHEMICAL está en la capacidad de subcontratar análisis para tercerizarlos. Tiempo de entrega: 5 días hábiles después de la llegada de la muestra a las instalaciones de TESLA CHEMICAL SAS. Validez de la oferta: Esta oferta tiene validez hasta el 31 de Diciembre del 2016 y reemplaza cualquier otra emitida con anterioridad. Forma de pago: Pago a 30 días después de la entrega de resultados y radicación de la factura. Entrega de muestras: TESLA CHEMICAL realiza la recepción de las muestras en el lugar que especifique el cliente en el perímetro urbano de la ciudad de BOGOTA D.C sin costo adicional.');
}

function loadGridProductosEnsayosRegCotizacion(idPerfil) {
    if (idPerfil == 1) {
        var test = true;
    } else {
        var test = false;
    }

    var source =
            {
                datafields: [
                    {name: 'idProducto', type: 'string'},
                    {name: 'nomProducto', type: 'string'},
                    {name: 'idPaquete', type: 'string'},
                    {name: 'nomPaquete', type: 'string'},
                    {name: 'idEnsayo', type: 'string'},
                    {name: 'nomEnsayo', type: 'string'},
                    {name: 'idAreaAnalisis', type: 'string'},
                    {name: 'nomAreaAnalisis', type: 'string'},
                    {name: 'duracion', type: 'string'},
                    {name: 'metodo', type: 'string'},
                    {name: 'seleccione', type: 'bool'},
                    {name: 'valor', type: 'string'},
                    {name: 'aprovado', type: 'bool'}


                ]
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#gridProductosEnsayosRegCotizacion").jqxGrid(
            {
                width: '100%',
                height: '500',
                source: dataAdapter,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                showstatusbar: true,
                editable: true,
                renderstatusbar: function (statusbar) {

                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");

                    container.append(addButton);
                    container.append(deleteButton);

                    statusbar.append(container);
                    addButton.jqxButton({width: 60, height: 20});
                    deleteButton.jqxButton({width: 65, height: 20});

                    addButton.click(function (event) {
                        $('#windowAddGridProductosEnsayosRegCotizacion').jqxWindow('open');
                        //ajaxGetEnsayosByProducto (44, 1);
                    });

                    deleteButton.click(function (event) {
                        $('#windowDeleteGridProductosEnsayosRegCotizacion').jqxWindow('open');
                    });




                },
                columns: [
                    {text: 'idProducto', datafield: 'idProducto', width: 50, hidden: true, editable: false},
                    {text: 'Producto', datafield: 'nomProducto', width: 264, hidden: true, editable: false},
                    {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true, editable: false},
                    {text: 'Paquete', datafield: 'nomPaquete', width: 180, hidden: true, editable: false},
                    {text: 'idEnsayo', datafield: 'idEnsayo', width: 200, hidden: true, editable: false},
                    {text: 'Ensayos', datafield: 'nomEnsayo', width: 600, hidden: false, editable: false},
                    {text: 'idAreaAnalisis', datafield: 'idAreaAnalisis', width: 200, hidden: true, editable: false, columntype: 'text'},
                    {text: 'Área de Análisis', datafield: 'nomAreaAnalisis', width: 150, hidden: true, editable: false},
                    {text: 'Método', datafield: 'metodo', width: 250, hidden: false, editable: false},
                    {text: 'Duración', datafield: 'duracion', width: 80, hidden: true, editable: false},
                    {text: 'Valor', datafield: 'valor', width: 200, hidden: false, editable: true, columntype: 'numberinput', aggregates: ['sum', 'avg']},
                    {text: 'Seleccione', datafield: 'seleccione', width: 100, hidden: false, columntype: 'checkbox', editable: true},
                    {text: 'Aprobado', datafield: 'aprovado', width: 80, hidden: true, columntype: 'checkbox', editable: test}


                ],
                groupable: true,
                groups: ['nomProducto', 'nomPaquete']
            });

}

function loadWindowAddGridProductosEnsayosRegCotizacion() {
    $('#windowAddGridProductosEnsayosRegCotizacion').jqxWindow({isModal: true,
        height: 170,
        width: 460,
        title: 'Agregar producto',
        autoOpen: false,
        cancelButton: $('#buttonCancelWindowAddGridProductosEnsayosRegCotizacion'),
        position: {x: 400, y: 700},
        initContent: function () {
            var sourceProductos =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'id'},
                            {name: 'nombre'},
                            {name: 'id_formula_farma'},
                            {name: 'des_formula_farma'},
                            {name: 'tipoProducto'}
                        ],
                        url: 'model/DB/jqw/productoData.php?query=producto',
                        async: false
                    };

            var pruductoAdapter = new $.jqx.dataAdapter(sourceProductos);
            $("#inputAddProductoRegCotizacion").jqxInput({source: pruductoAdapter, placeHolder: "Product Name:", displayMember: "nombre", valueMember: "id", width: 350, height: 20});
            $("#buttonOKWindowAddGridProductosEnsayosRegCotizacion").jqxButton({width: '70'});
            $("#buttonCancelWindowAddGridProductosEnsayosRegCotizacion").jqxButton({width: '70'});
        }
    });
}

function loadWindowDeleteGridProductosEnsayosRegCotizacion() {
    $('#windowDeleteGridProductosEnsayosRegCotizacion').jqxWindow({isModal: true,
        height: 170,
        width: 460,
        title: 'Agregar producto',
        autoOpen: false,
        cancelButton: $('#buttonCancelWindowDeleteGridProductosEnsayosRegCotizacion'),
        position: {x: 400, y: 700},
        initContent: function () {
            var sourceProductos =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'id'},
                            {name: 'nombre'},
                            {name: 'id_formula_farma'},
                            {name: 'des_formula_farma'},
                            {name: 'tipoProducto'}
                        ],
                        url: 'model/DB/jqw/productoData.php?query=producto',
                        async: false
                    };

            var pruductoAdapter = new $.jqx.dataAdapter(sourceProductos);
            $("#inputDeleteProductoRegCotizacion").jqxInput({source: pruductoAdapter, placeHolder: "Product Name:", displayMember: "nombre", valueMember: "id", width: 350, height: 20});
            $("#buttonOKWindowDeleteGridProductosEnsayosRegCotizacion").jqxButton({width: '70'});
            $("#buttonCancelWindowDeleteGridProductosEnsayosRegCotizacion").jqxButton({width: '70'});
        }
    });
}

function loadWindowEnviarCotizacionRegCotizacion() {
    $('#windowEnviarCotizacionRegCotizacion').jqxWindow({isModal: true,
        height: 430,
        width: 460,
        title: 'Enviar cotización',
        autoOpen: false,
        resizable: false,
        cancelButton: $('#buttonCancelWindowEnviarCotizacionRegCotizacion'),
        position: {x: 400, y: 300},
        initContent: function () {

            $("#inputDestinoRegCotizacion").jqxInput({width: 350, height: 20});
            $("#inputMedioRegCotizacion").jqxInput({width: 350, height: 20});
            $("#textAreaObservacionesEnvioRegCotizacion").jqxEditor({height: "200px", width: '400px', tools: "old italic underline | format font size | color background | ul ol | link | clean"});
            $("#buttonOKWindowEnviarCotizacionRegCotizacion").jqxButton({width: '70'});
            $("#buttonCancelWindowEnviarCotizacionRegCotizacion").jqxButton({width: '70'});
        }
    });
}

function loadWindowProductosMuestraRegCotizacion() {
    $('#windowProductosMuestraRegCotizacion').jqxWindow({isModal: true,
        height: 350,
        width: 460,
        title: 'Registro Muestra',
        autoOpen: false,
        resizable: false,
        cancelButton: $('#buttonCancelWindowProductosMuestraRegCotizacion'),
        position: {x: 400, y: 300},
        initContent: function () {




            $("#buttonOKWindowProductosMuestraRegCotizacion").jqxButton({width: '70'});
            $("#buttonCancelWindowProductosMuestraRegCotizacion").jqxButton({width: '70'});
        }
    });
}

function loadWindowEnviosaRegCotizacion() {
    $('#windowEnviosaRegCotizacion').jqxWindow({isModal: true,
        maxWidth: 1000,
        height: 350,
        width: 900,
        title: 'Envios cotización',
        autoOpen: false,
        resizable: false,
        position: {x: 200, y: 300},
        initContent: function () {





        }
    });
}

function loadDropDownListAreaAnalisisAddProductoRegCotizacion() {

    var areaSource =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'descripcion'},
                    {name: 'coordinador'}
                ],
                url: 'model/DB/jqw/AreasAnalisisData.php?query=getAreasWithOutEstabilidad',
                async: false
            };

    var areaAdapter = new $.jqx.dataAdapter(areaSource);
    $("#dropDownListAreaAnalisisAddProductoRegCotizacion").jqxDropDownList({source: areaAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '150', height: '20', dropDownHeight: 100});
}

function loadDropDownListAreaAnalisisDeleteProductoRegCotizacion() {

    var areaSource =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'descripcion'},
                    {name: 'coordinador'}
                ],
                url: 'model/DB/jqw/AreasAnalisisData.php?query=getAreasWithOutEstabilidad',
                async: false
            };

    var areaAdapter = new $.jqx.dataAdapter(areaSource);
    $("#dropDownListAreaAnalisisDeleteProductoRegCotizacion").jqxDropDownList({source: areaAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '150', height: '20', dropDownHeight: 100});
}

function loadNotificationRegCotizacion() {
    $("#notificationRegCotizacion").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function loadButtonRegistrarRegCotizacion() {
    $("#buttonRegistrarRegCotizacion").jqxButton({width: '130'});
}

function loadButtonUpdateCotizacionRegCotizacion() {
    $("#buttonUpdateCotizacionRegCotizacion").jqxButton({width: '130', disabled: true});
}

function loadButtonconsultaEnvioRegCotizacion() {
    $("#buttonconsultaEnvioRegCotizacion").jqxButton({width: '130', disabled: true});
}

function loadButtonGenerarMuestraRegCotizacion() {
    $("#buttonGenerarMuestraRegCotizacion").jqxButton({width: '130', disabled: true});
}

//JP
function loadButtonImprimirCotizacion() {
    $("#buttonImprimirCotizacion").jqxButton({width: '130', disabled: true});
}

function loadButtonEnviarCotizacionRegCotizacion() {
    $("#buttonEnviarCotizacionRegCotizacion").jqxButton({width: '130', disabled: true});
}

function loadButtonLimpiarRegCotizacion() {
    $("#buttonLimpiarRegCotizacion").jqxButton({width: '130'});
}

function eventClickSearchNumCotizacion() {
    $("#searchNumCotizacion").click(function () {
        //alert("hola mundo");
        var idCotizacion = $("#numCotizacionRegCotizacion").jqxInput('val');
        var scope = angular.element($("#divRegCotizacionController")).scope();
        scope.$apply(function () {
            //scope.buttonRechazarCotizacion.disabled = false;
            //scope.prueba(idCotizacion);
        });
        ajaxSearchCotizacionByIdRegCot(idCotizacion);
    });
}



function eventOnChangeDateInputFechaSolicitudTegCotizacion() {
    $('#fechaSolicitudRegCotizacion').on('change', function (event) {


        var fechaSolicitud = new Date($('#fechaSolicitudRegCotizacion').jqxDateTimeInput('getDate'));
        var fechaCompromiso = new Date(calcularFechaCompromiso(fechaSolicitud, 'Normal'));

        $("#fechaCompromisoRegCotizacion").jqxDateTimeInput({value: fechaCompromiso});


    });
}

function eventClickButtonOKWindowAddGridProductosEnsayosRegCotizacion() {
    $("#buttonOKWindowAddGridProductosEnsayosRegCotizacion").on('click', function () {
        var idProducto = $("#inputAddProductoRegCotizacion").val().value;
        var idAreaAnalisis = $("#dropDownListAreaAnalisisAddProductoRegCotizacion").val();
        var nomProducto = $("#inputAddProductoRegCotizacion").val().label;
        // gets all rows loaded from the data source.
        var rows = $('#gridProductosEnsayosRegCotizacion').jqxGrid('getboundrows');
        var aux = true;
        for (i = 0; i < rows.length; i++) {
            var rowData = rows[i];
            var rowIdProducto = rowData.idProducto;
            var rowIdArea = rowData.idAreaAnalisis;
            if (rowIdProducto == idProducto && rowIdArea == idAreaAnalisis) {
                var aux = false;
            }
        }
        if (aux == true) {
            ajaxGetEnsayosByProducto(idProducto, idAreaAnalisis);
            eventOpenNotificationRegCotizacion('success', 'Los ensayos delproducto ' + nomProducto + ' se cargaron a la grilla');
        } else {
            eventOpenNotificationRegCotizacion('error', 'Los ensayos delproducto ' + nomProducto + ' ya se encuentran cargados en la grilla');
        }
        $('#windowAddGridProductosEnsayosRegCotizacion').jqxWindow('close');
        $('#gridProductosEnsayosRegCotizacion').jqxGrid('refreshdata');

    });

}

function eventClickButtonOKWindowDeleteGridProductosEnsayosRegCotizacion() {
    $("#buttonOKWindowDeleteGridProductosEnsayosRegCotizacion").on('click', function () {
        var idProducto = $("#inputDeleteProductoRegCotizacion").val().value;
        var idAreaAnalisis = $("#dropDownListAreaAnalisisDeleteProductoRegCotizacion").val();
        var nomProducto = $("#inputDeleteProductoRegCotizacion").val().label;
        // gets all rows loaded from the data source.
        var rows = $('#gridProductosEnsayosRegCotizacion').jqxGrid('getboundrows');
        var array = new Array();
        ;
        for (i = 0; i < rows.length; i++) {
            var rowData = rows[i];
            var rowIdProducto = rowData.idProducto;
            var rowIdArea = rowData.idAreaAnalisis;
            if (rowIdProducto == idProducto && rowIdArea == idAreaAnalisis) {
                array.push(rows[i].uid);
            }
        }
        $("#gridProductosEnsayosRegCotizacion").jqxGrid('deleterow', array);
        $('#windowDeleteGridProductosEnsayosRegCotizacion').jqxWindow('close');
        $('#gridProductosEnsayosRegCotizacion').jqxGrid('refreshdata');

    });

}

function eventCloseWindowAddGridProductosEnsayosRegCotizacion() {
    $('#windowAddGridProductosEnsayosRegCotizacion').on('close', function (event) {
        $("#inputAddProductoRegCotizacion").val("");
        $("#dropDownListAreaAnalisisAddProductoRegCotizacion").jqxDropDownList({selectedIndex: 0});
    });
}

function eventCloseWindowDeleteGridProductosEnsayosRegCotizacion() {
    $('#windowDeleteGridProductosEnsayosRegCotizacion').on('close', function (event) {
        $("#inputDeleteProductoRegCotizacion").val("");
        $("#dropDownListAreaAnalisisDeleteProductoRegCotizacion").jqxDropDownList({selectedIndex: 0});
    });
}

function eventOpenNotificationRegCotizacion(template, message) {
    $("#messageNotificationRegCotizacion").text(message);
    $("#notificationRegCotizacion").jqxNotification({template: template});
    $("#notificationRegCotizacion").jqxNotification("open");
}

function eventClickButtonRegistrarRegCotizacion() {
    $("#buttonRegistrarRegCotizacion").on('click', function () {
        //alert("registrar cotizacion");

        var fechaSolicitud = $('#fechaSolicitudRegCotizacion').jqxDateTimeInput('value');
        var fechaCompromiso = $('#fechaCompromisoRegCotizacion').jqxDateTimeInput('value');
        var idCliente = $('#nombreClienteRegCotizacion').jqxInput('val').value;
        if (idCliente == undefined) {
            eventOpenNotificationRegCotizacion('error', 'Debe seleccionar un cliente valido.');
            return false;
        }
        var nomContacto = $('#nomContactoRegCotizacion').jqxInput('val');
        if (nomContacto == '') {
            eventOpenNotificationRegCotizacion('error', 'No es posible registrar la cotizacion sin nombre de contacto.');
            return false;
        }
        var telContacto = $('#telContactoRegCotizacion').jqxInput('val');
        var observaciones = $("#observacionesRegCotizacion").jqxEditor('val');
        var observacionesFin = $("#observacionesRegCotizacionFin").jqxEditor('val');
        var aplicaIva = $("#CheckBoxAplicaIvaRegCotizacion").jqxCheckBox('val')
        var aplicaRetencion = $("#CheckBoxAplicaRetencionRegCotizacion").jqxCheckBox('val')
        try {
            var gridData = $("#gridProductosEnsayosRegCotizacion").jqxGrid('exportdata', 'json', null, true, null, true);
        } catch (err) {
            eventOpenNotificationRegCotizacion('error', 'No se cargado ningun producto a la grilla.');
            return false;
        }
        
        var jsonGridData = JSON.parse(gridData);
        var validarEnsayos = jsonGridData.find(function (ensayo) {
            return ensayo.Seleccione == 1;
        });
        if (validarEnsayos == undefined) {
            eventOpenNotificationRegCotizacion('error', 'Debe seleccionar almenos un ensayo para registrar la cotización.');
            return false;
        }



        $("#ensayosRegCotizacion").val(gridData);


        var ensayos = $("#ensayosRegCotizacion").serialize();
        ajaxSaveCotizacion(fechaSolicitud, fechaCompromiso, idCliente, nomContacto, telContacto, observaciones, observacionesFin, ensayos, aplicaIva, aplicaRetencion);
        //alert("registrar cotizacion");
    });
}

function eventClickButtonUpdateCotizacionRegCotizacion() {
    $("#buttonUpdateCotizacionRegCotizacion").on('click', function () {


        var idCotizacion = $('#numCotizacionRegCotizacion').jqxInput('val');
        var estado = $('#estadoRegCotizacion').jqxDropDownList('val');
        var fechaSolicitud = $('#fechaSolicitudRegCotizacion').jqxDateTimeInput('value');
        var fechaCompromiso = $('#fechaCompromisoRegCotizacion').jqxDateTimeInput('value');
        var idCliente = $('#nombreClienteRegCotizacion').jqxInput('val').value;
        var nomContacto = $('#nomContactoRegCotizacion').jqxInput('val');
        var telContacto = $('#telContactoRegCotizacion').jqxInput('val');
        var observaciones = $("#observacionesRegCotizacion").jqxEditor('val');
        var observacionesFin = $("#observacionesRegCotizacionFin").jqxEditor('val');
        var gridData = $("#gridProductosEnsayosRegCotizacion").jqxGrid('exportdata', 'json', null, true, null, true);
        var aplicaIva = $("#CheckBoxAplicaIvaRegCotizacion").jqxCheckBox('val');
        var aplicaRetencion = $("#CheckBoxAplicaRetencionRegCotizacion").jqxCheckBox('val');


        $("#ensayosRegCotizacion").val(gridData);


        var ensayos = $("#ensayosRegCotizacion").serialize();

        ajaxUpdateCotizacion(idCotizacion, estado, fechaSolicitud, fechaCompromiso, idCliente, nomContacto, telContacto, observaciones, observacionesFin, ensayos, aplicaIva, aplicaRetencion);

    });
}

function eventClickButtonEnviarCotizacionRegCotizacion() {
    $("#buttonEnviarCotizacionRegCotizacion").on('click', function () {
        $('#windowEnviarCotizacionRegCotizacion').jqxWindow('open');
    });
}

function eventClickButtonLimpiarRegCotizacion() {
    $("#buttonLimpiarRegCotizacion").on('click', function () {
        $("#estadoRegCotizacion").jqxDropDownList({disabled: false});
        $("#estadoRegCotizacion").jqxDropDownList('selectIndex', 0);
        $("#estadoRegCotizacion").jqxDropDownList({disabled: true});
        $('#numCotizacionRegCotizacion').jqxInput('val', '');
        $('#numCotizacionRegCotizacion').jqxInput('disabled', false);
        $("#estadoRegCotizacion").jqxDropDownList('selectIndex', 0);
        $('#fechaSolicitudRegCotizacion').jqxDateTimeInput('value', new Date());
        $('#nombreClienteRegCotizacion').jqxInput('val', '');
        $('#nombreClienteRegCotizacion').jqxInput({disabled: false});
        $('#nomContactoRegCotizacion').jqxInput('val', '');
        $('#telContactoRegCotizacion').jqxInput('val', '');
        $('#observacionesRegCotizacion').jqxEditor('val', '');
        $('#observacionesRegCotizacionFin').jqxEditor('val', '');
        $('#ensayosRegCotizacion').val('');
        $('#CheckBoxAplicaIvaRegCotizacion').jqxCheckBox('uncheck');

        $('#CheckBoxAplicaRetencionRegCotizacion').jqxCheckBox('uncheck');
        $('#gridProductosEnsayosRegCotizacion').jqxGrid('clear');

        $('#buttonUpdateCotizacionRegCotizacion').jqxButton({disabled: true});
        $('#buttonEnviarCotizacionRegCotizacion').jqxButton({disabled: true});
        $('#buttonRegistrarRegCotizacion').jqxButton({disabled: false});
        $('#buttonGenerarMuestraRegCotizacion').jqxButton({disabled: true});
        $('#buttonImprimirCotizacion').jqxButton({disabled: true});
        $('#buttonconsultaEnvioRegCotizacion').jqxButton({disabled: true});
        var scope = angular.element($("#divRegCotizacionController")).scope();
        scope.$apply(function () {
            scope.cotizacion.estado = null;
        });
    });
}

function eventClickButtonconsultaEnvioRegCotizacion() {
    $("#buttonconsultaEnvioRegCotizacion").on('click', function () {
        var idCotizacion = $("#numCotizacionRegCotizacion").jqxInput('val');
        $('#windowEnviosaRegCotizacion').jqxWindow({title: 'Envíos de Cotización ' + idCotizacion});

        var url = 'model/DB/jqw/EnvioCotizacionData.php?query=getEnvioCotizacionByIdCotizacion&idCotizacion=' + idCotizacion;
        var source =
                {
                    datatype: "json",
                    url: url,
                    datafields: [
                        {name: 'id', type: 'int'},
                        {name: 'idCotizacion', type: 'int'},
                        {name: 'destino', type: 'string'},
                        {name: 'medio', type: 'string'},
                        {name: 'observaciones', type: 'string'},
                        {name: 'fecha', type: 'date'}
                    ]
                };
        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#gridEnviosRegCotizacion").jqxGrid(
                {
                    width: '850',
                    height: '200',
                    source: dataAdapter,
                    selectionmode: 'none',
                    columns: [
                        {text: 'id', datafield: 'id', width: 50, hidden: true},
                        {text: 'Cotización', datafield: 'idCotizacion', width: 100},
                        {text: 'Destino', datafield: 'destino', width: 150},
                        {text: 'Medio', datafield: 'medio', width: 150},
                        {text: 'Observaciones', datafield: 'observaciones', width: 300},
                        {text: 'Fecha Envío', datafield: 'fecha', columntype: 'datetimeinput', cellsformat: 'dd-MM-yyyy', width: 150}
                    ]
                });

        $('#windowEnviosaRegCotizacion').jqxWindow('open');
    });
}

function eventClickButtonInformePrint() { //Nuevo JP
    $("#buttonImprimirCotizacion").click(function () {
        // var idMuestra = $("#inputNumMuestraConHojaRutaMuestra").val();
        var idCotizacion = $('#numCotizacionRegCotizacion').jqxInput('val');
        window.open("pdf/informes/informeCotizacion.php?idCotizacion=" + idCotizacion);

    });

}


function eventClickButtonGenerarMuestraRegCotizacion() {
    $("#buttonGenerarMuestraRegCotizacion").on('click', function () {
        var idCotizacion = $("#numCotizacionRegCotizacion").jqxInput('val');
        var url = 'model/DB/jqw/CotizacionProductoData.php?query=getProductosByIdCotizacion&idCotizacion=' + idCotizacion;
        var source =
                {
                    datatype: "json",
                    url: url,
                    datafields: [
                        {name: 'idProducto', type: 'string'},
                        {name: 'nomProducto', type: 'string'},
                        {name: 'idAreaAnalisis', type: 'string'},
                        {name: 'nomAreaAnalisis', type: 'string'}
                    ]
                };
        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#gridProductosMuestraRegCotizacion").jqxGrid(
                {
                    width: '400',
                    height: '200',
                    source: dataAdapter,
                    selectionmode: 'singlerow',
                    columns: [
                        {text: 'idProducto', datafield: 'idProducto', width: 50, hidden: false},
                        {text: 'Producto', datafield: 'nomProducto', width: 264},
                        {text: 'idAreaAnalisis', datafield: 'idAreaAnalisis', width: 264},
                        {text: 'nomAreaAnalisis', datafield: 'nomAreaAnalisis', width: 264}
                    ]
                });
        $('#windowProductosMuestraRegCotizacion').jqxWindow('open');

    });
}

function eventClickButtonOKWindowEnviarCotizacionRegCotizacion() {
    $("#buttonOKWindowEnviarCotizacionRegCotizacion").on('click', function () {
        var idCotizacion = $('#numCotizacionRegCotizacion').jqxInput('val');
        var destino = $('#inputDestinoRegCotizacion').jqxInput('val');
        var medio = $('#inputMedioRegCotizacion').jqxInput('val');
        var obsEnvio = $('#textAreaObservacionesEnvioRegCotizacion').jqxEditor('val');
        $('#windowEnviarCotizacionRegCotizacion').jqxWindow('close');

        $('#inputDestinoRegCotizacion').jqxInput('val', '');
        $('#inputMedioRegCotizacion').jqxInput('val', '');
        $('#textAreaObservacionesEnvioRegCotizacion').jqxEditor('val', '');
        ajaxInsertEnvioCotizacion(idCotizacion, destino, medio, obsEnvio);

    });
}

function eventClickButtonOKWindowProductosMuestraRegCotizacion() {
    $("#buttonOKWindowProductosMuestraRegCotizacion").on('click', function () {

        var idCotizacion = $("#numCotizacionRegCotizacion").jqxInput('val');
        idCotizacion += '|';

        var rowindex = $('#gridProductosMuestraRegCotizacion').jqxGrid('getselectedrowindex');
        var data = $('#gridProductosMuestraRegCotizacion').jqxGrid('getrowdata', rowindex);
        idCotizacion += data.idProducto;
        idCotizacion += '|';
        idCotizacion += data.nomProducto;
        idCotizacion += '|';
        idCotizacion += data.idAreaAnalisis;

        window.location.href = 'index.php?action=regmuestra&idCotizacion=' + idCotizacion;
    });
}

function eventClickButtonCancelWindowEnviarCotizacionRegCotizacion() {
    $("#buttonCancelWindowEnviarCotizacionRegCotizacion").on('click', function () {
        $('#inputDestinoRegCotizacion').jqxInput('val', '');
        $('#inputMedioRegCotizacion').jqxInput('val', '');
        $('#textAreaObservacionesEnvioRegCotizacion', '').jqxEditor('val');
    });
}

function ajaxGetEnsayosByProducto(idProducto, idAreaAnalisis) {
    //model/DB/jqw/productosPaquetesEnsayosData.php?query=ProductoPaquetesEnsayos&producto='+idProducto+'&idAreaAnalisis='+idAreaAnalisis
    var url = "model/DB/jqw/productosPaquetesEnsayosData.php";
    var data = "query=NomProductoPaquetesEnsayos";
    data = data + "&producto=" + idProducto;
    data = data + "&idAreaAnalisis=" + idAreaAnalisis;




    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                var data = new Array();
                for (var i = 0; i < response.length; i++) {
                    data[i] = response[i];
                    data[i].duracion = parseInt(data[i].duracion);
                    data[i].idAreaAnalisis = parseInt(data[i].idAreaAnalisis);
                    data[i].idEnsayo = parseInt(data[i].idEnsayo);
                    //data[i].metodo = parseInt(data[i].metodo);
                    data[i].idPaquete = parseInt(data[i].idPaquete);
                    data[i].idProducto = String(data[i].idProducto);
                    data[i].valor = parseInt(data[i].valor);
                }
                $('#gridProductosEnsayosRegCotizacion').jqxGrid('addrow', null, data);
            }
        }
    });
}

function ajaxSaveCotizacion(fechaSol, fechaCom, idCliente, nomContacto, telContacto, observaciones, observacionesFin, ensayos, aplicaIva, aplicaRetencion) {
    var url = "index.php";

    var data = "action=saveCotizacion";
    var fechaSolx = fechaSol.getFullYear() + "-" + (parseInt(fechaSol.getMonth()) + 1) + "-" + fechaSol.getDate();
    var fechaComx = fechaCom.getFullYear() + "-" + (parseInt(fechaCom.getMonth()) + 1) + "-" + fechaCom.getDate();

    data = data + "&estado=1";
    data = data + "&fechaSol=" + fechaSolx;
    data = data + "&fechaCom=" + fechaComx;
    data = data + "&idCliente=" + idCliente;
    data = data + "&nomContacto=" + nomContacto;
    data = data + "&telContacto=" + telContacto;
    data = data + "&observaciones=" + observaciones;
    data = data + "&observacionesFin=" + observacionesFin;
    data = data + "&aplicaIva=" + aplicaIva;
    data = data + "&aplicaRetenciones=" + aplicaRetencion;
    data = data + "&" + ensayos;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                if (response.result == 1) {
                    eventOpenNotificationRegCotizacion('success', response.message);
                    $('#fechaSolicitudRegCotizacion').jqxDateTimeInput('val', new Date());
                    //$('#fechaCompromisoRegCotizacion').jqxDateTimeInput('val', new Date());
                    $('#nombreClienteRegCotizacion').jqxInput('val', '');
                    $('#nomContactoRegCotizacion').jqxInput('val', '');
                    $('#telContactoRegCotizacion').jqxInput('val', '');
                    $('#observacionesRegCotizacion').jqxEditor('val', '');
                    $('#observacionesRegCotizacionFin').jqxEditor('val', '');
                    $('#ensayosRegCotizacion').val('');
                    $('#CheckBoxAplicaRetencionRegCotizacion').jqxCheckBox('val', false);
                    $('#CheckBoxAplicaRIvaRegCotizacion').jqxCheckBox('val', false);
                } else {
                    eventOpenNotificationRegCotizacion('error', response.message);
                }
            }
        }
    });
}
//idCotizacion, estado, fechaSolicitud, fechaCompromiso, idCliente, nomContacto, telContacto, observaciones, observacionesFin, ensayos, aplicaIva, aplicaRetencion);
function ajaxUpdateCotizacion(idCotizacion, estado, fechaSol, fechaCom, idCliente, nomContacto, telContacto, observaciones, observacionesFin, ensayos, aplicaIva, aplicaRetencion) {
    var url = "index.php";
    var data = "action=updateCotizacion";
    // alert(fechaSol);

    var fechaSolx = fechaSol.getFullYear() + "-" + (parseInt(fechaSol.getMonth()) + 1) + "-" + fechaSol.getDate();
    var fechaComx = fechaCom.getFullYear() + "-" + (parseInt(fechaCom.getMonth()) + 1) + "-" + fechaCom.getDate();


//alert(fechaSol.getFullYear() + "-" + fechaSol.getMonth() + 1 + "-" + fechaSol.getDate());
    data = data + "&idCotizacion=" + idCotizacion;
    data = data + "&estado=" + estado;
    data = data + "&fechaSol=" + fechaSolx;
    data = data + "&fechaCom=" + fechaComx;
    data = data + "&idCliente=" + idCliente;
    data = data + "&nomContacto=" + nomContacto;
    data = data + "&telContacto=" + telContacto;
    data = data + "&observaciones=" + observaciones;
    data = data + "&observacionesFin=" + observacionesFin;
    data = data + "&" + ensayos;
    data = data + "&aplicaIva=" + aplicaIva;
    data = data + "&aplicaRetencion=" + aplicaRetencion;



    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                if (response.result == 1) {
                    eventOpenNotificationRegCotizacion('success', response.message);

                } else {
                    eventOpenNotificationRegCotizacion('error', response.message);
                }
            }
        }
    });
}

function ajaxSearchCotizacionByIdRegCot(idCotizacion) {
    var url = "model/DB/jqw/CotizacionData.php";
    var data = "query=getCotizacionById";
    data = data + "&idCotizacion=" + idCotizacion;

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                var estado = response[0].estado;


                var items = $("#estadoRegCotizacion").jqxDropDownList('getItems');
                for (var i = 0; i < items.length; i++) {
                    if (items[i].value == estado) {
                        $("#estadoRegCotizacion").jqxDropDownList({disabled: false});
                        $("#estadoRegCotizacion").jqxDropDownList('selectIndex', items[i].index);
                        $("#estadoRegCotizacion").jqxDropDownList({disabled: true});
                        break;
                    }
                }

                if (estado > 2) {
                    $('#buttonUpdateCotizacionRegCotizacion').jqxButton({disabled: true});
                } else {
                    $('#buttonUpdateCotizacionRegCotizacion').jqxButton({disabled: false});
                }

                if (estado == 4) {
                    $('#buttonGenerarMuestraRegCotizacion').jqxButton({disabled: true});
                } else {
                    $('#buttonGenerarMuestraRegCotizacion').jqxButton({disabled: false});
                }

                var fechaSolicitud = response[0].fecSolicitud;
                var fechaSolicitud = fechaSolicitud.split("/");
                var anoSol = fechaSolicitud[0];
                var mesSol = fechaSolicitud[1] - 1;
                var diaSol = fechaSolicitud[2];
                $('#fechaSolicitudRegCotizacion').jqxDateTimeInput('val', new Date(anoSol, mesSol, diaSol));

                var fechaCompromiso = response[0].fecCompromiso;
                var fechaCompromiso = fechaCompromiso.split("/");
                var anoCom = fechaCompromiso[0] - 0;
                var mesCom = fechaCompromiso[1] - 1;
                var diaCom = fechaCompromiso[2] - 0;
                $('#fechaCompromisoRegCotizacion').jqxDateTimeInput('val', new Date(anoCom, mesCom, diaCom));

                var idCliente = response[0].idCliente;
                var nomCliente = response[0].nombreCliente;
                $('#nombreClienteRegCotizacion').jqxInput('val', {label: nomCliente, value: idCliente});
                var nomContacto = response[0].nombreContacto;
                $('#nomContactoRegCotizacion').jqxInput('val', nomContacto);
                var observaciones = response[0].observaciones;
                $('#observacionesRegCotizacion').jqxEditor('val', observaciones);
                var observacionesFin = response[0].observacionesFin;
                $('#observacionesRegCotizacionFin').jqxEditor('val', observacionesFin);
                var telContacto = response[0].telContacto;
                $('#telContactoRegCotizacion').jqxInput('val', telContacto);
                var scope = angular.element($("#divRegCotizacionController")).scope();
                scope.$apply(function () {

                    scope.cotizacion.estado = estado;
                });
                if (response[0].aplicaIva == 1) {
                    $('#CheckBoxAplicaIvaRegCotizacion').jqxCheckBox('check');
                } else {
                    $('#CheckBoxAplicaIvaRegCotizacion').jqxCheckBox('uncheck');
                }
                if (response[0].aplicaRetencion == 1) {
                    $('#CheckBoxAplicaRetencionRegCotizacion').jqxCheckBox('check');
                } else {
                    $('#CheckBoxAplicaRetencionRegCotizacion').jqxCheckBox('uncheck');
                }
                ajaxSearchEnsayosByIdCotizacion(idCotizacion);
                $('#buttonRegistrarRegCotizacion').jqxButton({disabled: true});
                $('#numCotizacionRegCotizacion').jqxInput({disabled: true});
                $('#nombreClienteRegCotizacion').jqxInput({disabled: false});

                $('#buttonEnviarCotizacionRegCotizacion').jqxButton({disabled: false});

                $('#buttonImprimirCotizacion').jqxButton({disabled: false});
                $('#buttonconsultaEnvioRegCotizacion').jqxButton({disabled: false});
            }
        }
    });
}

function ajaxSearchEnsayosByIdCotizacion(idCotizacion) {
    var url = "model/DB/jqw/CotProEnsayoData.php";
    var data = "query=getEnsayosByIdCotizacion";
    data = data + "&idCotizacion=" + idCotizacion;

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                $('#gridProductosEnsayosRegCotizacion').jqxGrid('clear');
                $('#gridProductosEnsayosRegCotizacion').jqxGrid('addrow', null, response);
            }
        }
    });
}

function ajaxInsertEnvioCotizacion(idCotizacion, destino, medio, observaciones) {
    var url = "index.php";
    var data = "action=insertEnvioCotizacion";
    data = data + "&idCotizacion=" + idCotizacion;
    data = data + "&destino=" + destino;
    data = data + "&medio=" + medio;
    data = data + "&observaciones=" + observaciones;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                var estadoActual = $("#estadoRegCotizacion").jqxDropDownList('val');
                if (estadoActual == 1) {
                    var items = $("#estadoRegCotizacion").jqxDropDownList('getItems');
                    for (var i = 0; i < items.length; i++) {
                        if (items[i].value == 2) {
                            $("#estadoRegCotizacion").jqxDropDownList({disabled: false});
                            $("#estadoRegCotizacion").jqxDropDownList('selectIndex', items[i].index);
                            $("#estadoRegCotizacion").jqxDropDownList({disabled: true});
                            break;
                        }
                    }
                }

                eventOpenNotificationRegCotizacion('success', "Se ha registrado exitosamente el envio de la cotización.");

            } else {
                eventOpenNotificationRegCotizacion('error', "Fallo el registro del envio de la cotización.");
            }
        }
    });
}

var appRegCotizacion = angular.module("regCotizacionApp", ["jqwidgets"]);

appRegCotizacion.controller("recotizacionController", function ($scope, $http) {



    $scope.buttonRechazarCotizacion = {
        disabled: true,
        events: {
            click: function () {
                $scope.windowrechazarCot.settings.apply("open");
            }
        }
    };



    $scope.windowrechazarCot = {
        settings: {
            maxHeight: 1000,
            maxWidth: 1000,
            minHeight: 30,
            minWidth: 250,
            height: 320,
            width: 450,
            resizable: false,
            isModal: true,
            autoOpen: false,
            title: "Rechazar cotizacion",
            okButton: $("#buttonOKRechazarCotRegCotizacion"),
            cancelButton: $("#buttonCancelarRechazarCotRegCotizacion"),
            initContent: function () {
                $scope.editorMotivoRechazo = {
                    model: "",
                    settings: {
                        height: 200,
                        width: 410,
                        tools: ""
                    }
                }
            }
        },
        events: {
            close: function (event) {
                if (event.args.dialogResult.OK === true) {


                    var data = {
                        action: "rechazarCotizacion",
                        idCotizacion: $("#numCotizacionRegCotizacion").jqxInput("val"),
                        motivo: $("#editorRechazoCotRegCotizacion").jqxEditor("val")
                    };

                    var url = "index.php";

                    var rechazarCotPromise = callPost(url, data);

                    rechazarCotPromise.then(function successCallback(response) {
                        if (response.data.result === 0) {
                            $('#buttonEnviarCotizacionRegCotizacion').jqxButton({disabled: true});
                            $('#buttonGenerarMuestraRegCotizacion').jqxButton({disabled: true});
                            $('#buttonUpdateCotizacionRegCotizacion').jqxButton({disabled: true});

                            $scope.cotizacion.estado = 4;
                            var items = $("#estadoRegCotizacion").jqxDropDownList('getItems');
                            for (var i = 0; i < items.length; i++) {
                                if (items[i].value == 4) {
                                    $("#estadoRegCotizacion").jqxDropDownList({disabled: false});
                                    $("#estadoRegCotizacion").jqxDropDownList('selectIndex', items[i].index);
                                    $("#estadoRegCotizacion").jqxDropDownList({disabled: true});
                                    break;
                                }
                            }
                            eventOpenNotificationRegCotizacion('success', response.data.message);
                        } else {
                            eventOpenNotificationRegCotizacion('error', response.data.message);
                        }

                    });
                }

            }
        }
    };



    $scope.functions = {
    };

    $scope.cotizacion = {
        estado: null
    };

    $scope.prueba = function (texto) {
        alert(texto);
    };

    $scope.$watch("cotizacion.estado", function (newValue, oldValue) {
        //alert("hola mundo");
        if ($scope.cotizacion.estado == 1 || $scope.cotizacion.estado == 2) {
            $scope.buttonRechazarCotizacion.disabled = false;
        } else {
            $scope.buttonRechazarCotizacion.disabled = true;
        }
    });

    function callPost(url, data) {
        return $http({
            method: "POST",
            url: url,
            data: $.param(data),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
    }
});