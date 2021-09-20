function initialLoadRegistroMuestra() {



    //load elements
    loadButtonGenerarEnsayosRegMuestra();
    loadButtonRegistrarFacturacionRegMuestra();


    //inicializacion Eventos

    eventUncheckedActiva();

    eventClickSearchMuestraButton();
    eventChangeDropDownListDuracion();

    eventClickButtonGenerarEnsayosRegMuestra();
    eventClickButtonRegistrarFacturacionRegMuestra();
    eventClickSubmitButton1();
    
    $("#submitButton4").click(function () {

        $("#submitButton4").jqxButton({disabled: true});
        if(!guardarMuestra()){
            $("#submitButton4").jqxButton({disabled: false});
        }

    });

    var searchMuestra = validateSearchMuestra();
    if (searchMuestra) {
        //alert("hola mundo");
        searchMuestraClickButton();

    } else {
        //alert("adios");


    }
}
function eventClickSubmitButton1() {
    $("#submitButton1").on('click', function (event) {
        $("#submitButton2").jqxButton({disabled: true});
        $("#submitButton3").jqxButton({disabled: true});
        $("#submitButton4").jqxButton({disabled: false});
        $("#updateMuestraButton").jqxButton({disabled: true});
        ////////////////////////////////////////////////////////////////////
        $("#numMuestra").jqxInput({disabled: false});
        $("#numMuestra").jqxInput("val", "");
        ////////////////////////////////////////////////////////////////////
        $("#estMuestra").jqxInput('val', '');
        ////////////////////////////////////////////////////////////////////
        $("#activa").jqxCheckBox('val', true);
        $("#prioridad").jqxDropDownList('selectIndex', 0);
        $("#numCotizacion").jqxInput('val', '');
        $("#numRemision").jqxInput('val', '');
        $("#fechaLlegada").jqxDateTimeInput('val', new Date());
        $("#nomCliente").jqxInput('val', null);
        $("#areaContacto").jqxInput('val', null);
        $("#labSolicitante").jqxInput('val', null);
        $("#procedencia").jqxInput('val', null);
        $("#observaciones").jqxEditor('val', '');
        $("#nomProducto").jqxInput('val', null);
        $("#tipoEstabilidad").jqxDropDownList('selectIndex', 0);
        $("#duracion").jqxDropDownList('selectIndex', 0);
        $("#areaAnalisis").jqxDropDownList('selectIndex', 0);

        $("#formFarmaceutica").jqxInput('val', null);
        $("#empaque").jqxDropDownList('selectIndex', 0);
        $("#envase").jqxDropDownList('selectIndex', 0);
        $("#fechaFabricacion").jqxDateTimeInput('val', new Date());
        $("#fechaVencimiento").jqxDateTimeInput('val', new Date());
        $("#gridPrincipiosActivos").jqxGrid('clear');
        $("#gridEnsayo").jqxGrid('clear');
        $("#gridEstEnsayo").jqxGrid('clear');
        $("#gridLotes").jqxGrid('clear');
        $('#gridLotes').jqxGrid('addrow', null, {});
        $('#buttonRegistrarFacturacionRegMuestra').jqxButton({disabled: true});
        $("#facturarMuestra").jqxCheckBox('val', false);
        $("#cantidad").jqxNumberInput('val', 1);
        $("#numFactura").jqxInput('val', '');
        $("#anticipo").jqxNumberInput('val', 1);
        $("#descuento").jqxNumberInput('val', 1);
        $("#saldo").jqxNumberInput('val', 1);
    });
}





function eventUncheckedActiva() {
    $('#activa').on('unchecked', function (event) {
        var anular = confirm("Confirma que desea anular la muestra");
        if (anular == true) {
            var idMuestra = $('#numMuestra').jqxInput('val');
            if (idMuestra != undefined && idMuestra != '') {
                var promiseAnularMuestra = ajaxAnularMuestra(idMuestra);
                promiseAnularMuestra.then(function (data) {
                    var response = JSON.parse(data);
                    if (response.result === 0) {
                        $('#estMuestra').jqxInput('val', 'Anulada');
                        $('#updateMuestraButton').jqxButton({disabled: true});
                        $('#respuesta').jqxNotification({template: 'success'});
                        $("#activa").jqxCheckBox({disabled: true});

                    } else {
                        $('#respuesta').jqxNotification({template: 'error'});
                        $("#activa").jqxCheckBox('val', true);
                    }
                    $("#respuesta").html(response.message);
                    $("#respuesta").jqxNotification("open");
                });
            } else {
                $("#activa").jqxCheckBox('val', true);
            }
        } else {
            $("#activa").jqxCheckBox('val', true);
        }
    });
}

function ajaxAnularMuestra(idMuestra) {


    return $.ajax({
        type: "POST",
        url: 'index.php',
        data: {
            action: 'anularMuestra',
            idMuestra: idMuestra
        },
        async: false
    });
}

function loadButtonRegistrarFacturacionRegMuestra() {
    $("#buttonRegistrarFacturacionRegMuestra").jqxButton({width: 150, height: 25, disabled: true});
}

function eventClickButtonRegistrarFacturacionRegMuestra() {
    $("#buttonRegistrarFacturacionRegMuestra").on("click", function (event) {
        var idMuestra = $("#numMuestra").jqxInput("val");
        var cantidad = $("#cantidad").jqxNumberInput("val");
        var numFactura = $("#numFactura").jqxInput("val");
        var anticipo = $("#anticipo").jqxNumberInput("val");
        var descuento = $("#descuento").jqxNumberInput("val");
        var saldo = $("#saldo").jqxNumberInput("val");
        var promiseFacturaMuestra = ajaxUpdateFaturacionMuestra(idMuestra, cantidad, numFactura, anticipo, descuento, saldo);
        promiseFacturaMuestra.success(function (response) {
            var response = JSON.parse(response);
            if (response != null) {
                if (response.result == 0) {
                    $('#respuesta').jqxNotification({template: 'success'});
                    $("#respuesta").html(response.message);
                    $("#respuesta").jqxNotification("open");
                } else {
                    $('#respuesta').jqxNotification({template: 'error'});
                    $("#respuesta").html(response.message);
                    $("#respuesta").jqxNotification("open");
                }
            }
        });
    });
}

function ajaxUpdateFaturacionMuestra(idMuestra, cantidad, numFactura, anticipo, descuento, saldo) {

    var url = "index.php";
    var data = "action=updateFacturacionMuestra";
    data = data + "&idMuestra=" + idMuestra;
    data = data + "&cantidad=" + cantidad;
    data = data + "&numFactura=" + numFactura;
    data = data + "&anticipo=" + anticipo;
    data = data + "&descuento=" + descuento;
    data = data + "&saldo=" + saldo;
    return $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false
    });
}

function eventClickButtonGenerarEnsayosRegMuestra() {
    $('#buttonGenerarEnsayosRegMuestra').on('click', function () {
        var value = $('#nomProducto').val();
        ajaxGetEnsayosByProductoRegEstMuestra(value.value);
        $("#gridEstEnsayo").show();
    });
}

function loadButtonGenerarEnsayosRegMuestra() {
    $("#buttonGenerarEnsayosRegMuestra").jqxButton({width: '130', height: '20', disabled: true});
}

function eventChangeDropDownListDuracion() {
    $('#duracion').on('change', function (event)
    {

        $("#gridEstEnsayo").hide(400, function () {
            $("#gridEstEnsayo").jqxGrid('clear');
        });


    });
}

function loadDropDownListDuracion(tipo, disabled) {
    if (tipo == 0) {
        var url = 'config/tiemposEstabilidadNatural.json';
    } else {
        var idTipoEstabilidad = $("#tipoEstabilidad").jqxDropDownList('val');
        if (idTipoEstabilidad == 1) {
            var url = 'config/tiemposEstabilidadNatural.json';
        } else if (idTipoEstabilidad == 2) {
            var url = 'config/tiemposEstabilidadAcelerada.json';
        } else if (idTipoEstabilidad == 3) {
            var url = 'config/tiemposEstabilidadOnGoing.json';
        }
    }
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'name', type: 'string'},
                    {name: 'value', type: 'int'}
                ],
                url: url,
                id: 'id',
                async: false
            };

    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxDropDownList
    $("#duracion").jqxDropDownList({
        disabled: disabled, autoDropDownHeight: true, selectedIndex: 0, source: dataAdapter, displayMember: "name", valueMember: "value", width: 200, height: 20
    });
}

function validateSearchMuestra() {
    var numMuestra = $("#numMuestra").val();
    if (numMuestra !== '') {
        return true;
    } else {
        return false;
    }
}

function chargeMuestra(muestra) {

    if (muestra[0].response === 1) {
        $("#duracion").unbind();
        $("#activa").unbind('unchecked');
        $("#estMuestra").jqxInput('val', muestra[0].muestra.descripcion_estado_muestra);
        if (muestra[0].muestra.id_estado_muestra != 1) {
            $("#updateMuestraButton").jqxButton({disabled: true});
        }
        $("#activa").jqxCheckBox({disabled: false});
        if (muestra[0].muestra.activa == 1) {
            $("#activa").jqxCheckBox('val', true);
        } else {
            $("#activa").jqxCheckBox('val', false);
            $("#activa").jqxCheckBox({disabled: true});
            $("#updateMuestraButton").jqxButton({disabled: true});
        }

        var prioridadItems = $("#prioridad").jqxDropDownList('getItems');
        for (var i = 0; i < prioridadItems.length; i++) {
            if (prioridadItems[i].label == muestra[0].muestra.prioridad) {
                $("#prioridad").jqxDropDownList('selectIndex', prioridadItems[i].index);
                break;
            }
        }
        if (muestra[0].muestra.id_cotizacion == 0) {
            $("#numCotizacion").jqxInput('val', '');
        } else {
            $("#numCotizacion").jqxInput('val', muestra[0].muestra.id_cotizacion);
        }
        document.getElementById('numCotizacion').readonly = true;

        $("#numRemision").jqxInput('val', muestra[0].muestra.numero_remision);

        var t = muestra[0].muestra.fecha_llegada.split(/[- :]/);
        $("#fechaLlegada").jqxDateTimeInput('setDate', new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

        var t = muestra[0].muestra.fecha_compromiso.split(/[- :]/);
        $("#fechaCompromiso").jqxDateTimeInput('setDate', new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

        $('#nomCliente').jqxInput('val', {label: muestra[0].muestra.nombre_tercero, value: muestra[0].muestra.id_tercero});
        var value = $('#nomCliente').val();
        var contactosSource =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'id'},
                        {name: 'nombre'},
                        {name: 'area'}
                    ],
                    url: 'model/DB/jqw/contactoData.php?query=contactosByTercero&idTercero=' + value["value"],
                    async: false
                };
        var contactosAdapter = new $.jqx.dataAdapter(contactosSource);


        $("#contactoSolicitante").jqxDropDownList({disabled: false, source: contactosAdapter, displayMember: "nombre", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 200});
        var contactosItems = $("#contactoSolicitante").jqxDropDownList('getItems');
        for (var i = 0; i < contactosItems.length; i++) {
            if (contactosItems[i].value == muestra[0].muestra.id_contacto) {
                $("#contactoSolicitante").jqxDropDownList('selectIndex', contactosItems[i].index);
                break;
            }
        }

        $("#areaContacto").jqxInput('val', muestra[0].muestra.area_contacto)

        $("#labSolicitante").jqxInput('val', muestra[0].muestra.fabricante);

        $("#procedencia").jqxInput('val', muestra[0].muestra.procedencia);

        $("#numInforme").jqxInput('val', muestra[0].muestra.num_informe);

        $("#observaciones").val(muestra[0].muestra.observacion);

        var areaItems = $("#areaAnalisis").jqxDropDownList('getItems');
        for (var i = 0; i < areaItems.length; i++) {
            if (areaItems[i].value == muestra[0].muestra.id_area_analisis) {
                $("#areaAnalisis").jqxDropDownList('selectIndex', areaItems[i].index);
                break;
            }
        }


        var areaValue = $("#areaAnalisis").jqxDropDownList('getSelectedItem');
        if (areaValue.label == 'Estabilidad') {
            var tipoEstItems = $("#tipoEstabilidad").jqxDropDownList('getItems');
            for (var i = 0; i < tipoEstItems.length; i++) {
                if (tipoEstItems[i].value == muestra[0].muestra.tipo_estabilidad) {
                    $("#tipoEstabilidad").jqxDropDownList('selectIndex', tipoEstItems[i].index);
                    break;
                }
            }
            var duracionItems = $("#duracion").jqxDropDownList('getItems');
            for (var w = 0; w < duracionItems.length; w++) {
                if (duracionItems[w].value == muestra[0].muestra.duracion) {
                    $selectDuracionIndex = duracionItems[w].index;
                }
            }

            $("#duracion").jqxDropDownList('selectIndex', $selectDuracionIndex);
        }



        $('#nomProducto').jqxInput('val', {label: muestra[0].muestra.nombre_producto, value: muestra[0].muestra.id_producto});





        $("#formFarmaceutica").jqxInput('val', {label: muestra[0].muestra.formula_farma, value: muestra[0].muestra.formula_farma});


        if (muestra[0].muestra.tipo_producto == 1) {
            $("#tipoProducto").jqxInput('val', {label: 'Materia Prima', value: 'Materia Prima'});
        }
        if (muestra[0].muestra.tipo_producto == 2) {
            $("#tipoProducto").jqxInput('val', {label: 'Producto en proceso', value: 'Producto en proceso'});
        }
        if (muestra[0].muestra.tipo_producto == 3) {
            $("#tipoProducto").jqxInput('val', {label: 'Producto terminado', value: 'Producto terminado'});
        }


        var empaqueItems = $("#empaque").jqxDropDownList('getItems');
        for (var i = 0; i < empaqueItems.length; i++) {
            if (empaqueItems[i].value == muestra[0].muestra.id_empaque) {
                $("#empaque").jqxDropDownList('selectIndex', empaqueItems[i].index);
                break;
            }
        }


        var envaseItems = $("#envase").jqxDropDownList('getItems');
        for (var i = 0; i < envaseItems.length; i++) {
            if (envaseItems[i].value == muestra[0].muestra.id_envase) {
                $("#envase").jqxDropDownList('selectIndex', envaseItems[i].index);
                break;
            }
        }


        var t = muestra[0].muestra.fecha_fabricacion.split(/[- :]/);
        $("#fechaFabricacion").jqxDateTimeInput('setDate', new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

        var t = muestra[0].muestra.fecha_vencimiento.split(/[- :]/);
        $("#fechaVencimiento").jqxDateTimeInput('setDate', new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));


        var value = $('#nomProducto').val();
        value = value["value"];
        var principiosActivosSource = {
            datatype: "json",
            datafields: [
                {name: 'nombre', type: 'string'},
                {name: 'principal', type: 'string'},
                {name: 'trasador', type: 'string'}
            ],
            async: false,
            id: 'nombre',
            url: 'model/DB/jqw/PrincipioActivoData.php?query=principioActivo&producto=' + value
        };
        var principiosActivosAdapter = new $.jqx.dataAdapter(principiosActivosSource);
        $("#gridPrincipiosActivos").jqxGrid({
            width: 700,
            columnsresize: true,
            theme: 'personal2',
            source: principiosActivosAdapter,
            autoheight: true,
            columns: [{
                    text: 'Descripción del principio activo',
                    datafield: 'nombre',
                    align: 'center',
                    cellsalign: 'center',
                    width: 300

                },
                {
                    text: 'Principal',
                    datafield: 'principal',
                    align: 'center',
                    cellsalign: 'center',
                    width: 200
                },
                {
                    text: 'Trazador de estabilidad',
                    align: 'center',
                    cellsalign: 'center',
                    datafield: 'trasador',
                    width: 200
                }]
        });


        if (muestra[0].muestra.id_area_analisis != 4) {
            var sourceEnsayo = {
                datatype: "json",
                async: false,
                datafields: [
                    {name: 'idEnsayoPaquete', type: 'string'},
                    {name: 'descripcionPaquete', type: 'string'},
                    {name: 'areaAnalisis', type: 'string'},
                    {name: 'tiempo', type: 'int'},
                    {name: 'idEnsayo', type: 'string'},
                    {name: 'desEnsayo', type: 'string'},
                    {name: 'duracion', type: 'int'},
                    {name: 'validacion', type: 'boolean'},
                    {name: 'idMetodo', type: 'string'}
                ],
                url: 'model/DB/jqw/ensayoMuestraReferenciasData.php?query=GetEnsayoMuestraByIdMuestra&idMuestra=' + muestra[0].muestra.id
            };
            var adapterEnsayo = new $.jqx.dataAdapter(sourceEnsayo);
            $("#gridEnsayo").jqxGrid({
                width: 960,
                columnsresize: true,
                source: adapterEnsayo,
                theme: 'personal2',
                showgroupsheader: false,
                editmode: 'click',
                selectionmode: 'singlecell',
                editable: true,
                groupable: true,
                autoheight: true,
                columns: [
                    {
                        text: 'Cod. Paquete',
                        align: 'center',
                        datafield: 'idEnsayoPaquete',
                        editable: false,
                        width: 100,
                        cellsalign: 'center',
                        hidden: true
                    },
                    {
                        text: 'Descripción del paquete',
                        align: 'center',
                        datafield: 'descripcionPaquete',
                        editable: false,
                        width: 380,
                        hidden: true
                    },
                    {
                        text: 'Área de análisis',
                        groupable: false,
                        align: 'center',
                        cellsalign: 'center',
                        editable: false,
                        datafield: 'areaAnalisis',
                        width: 160,
                        hidden: true
                    },
                    {
                        text: 'Duración',
                        datafield: 'tiempo',
                        align: 'center',
                        editable: false,
                        cellsalign: 'center',
                        groupable: false,
                        width: 80,
                        hidden: true
                    },
                    {
                        text: 'idEnsayo',
                        cellsalign: 'center',
                        datafield: 'idEnsayo',
                        align: 'center',
                        editable: false,
                        groupable: false,
                        width: 80,
                        hidden: true
                    },
                    {
                        text: 'Descripción del ensayo',
                        cellsalign: 'center',
                        datafield: 'desEnsayo',
                        align: 'center',
                        editable: false,
                        groupable: false,
                        width: 680
                    },
                    {
                        text: 'Seleccione',
                        datafield: 'validacion',
                        align: 'center',
                        cellsalign: 'center',
                        columntype: 'checkbox',
                        width: 90
                    },
                    {
                        text: 'Duración (En Minutos)',
                        editable: false,
                        datafield: 'duracion',
                        cellsalign: 'center',
                        groupable: false,
                        width: 155
                    },
                    {
                        text: 'idMetodo',
                        datafield: 'idMetodo',
                        align: 'center',
                        cellsalign: 'center',
                        width: 90,
                        hidden: true
                    }
                ],
                groups: ['descripcionPaquete']
            });
        } else {

            ajaxGetEnsayosMuestraEstabilidad(muestra[0].muestra);
            $('#duracion').on('change', function (event)
            {
                $("#gridEstEnsayo").hide(400, function () {
                    $("#gridEstEnsayo").jqxGrid('clear');
                });

            });

        }

        var sourceLote = {
            datatype: "json",
            datafields: [
                {name: 'tamanoLote', type: 'string'},
                {name: 'numLote', type: 'string'},
                {name: 'cantEnviadaLote', type: 'string'},
            ],
            url: 'model/DB/jqw/LoteData.php?query=getLotesByIdMuestra&idMuestra=' + muestra[0].muestra.id
        };
        var adapterlote = new $.jqx.dataAdapter(sourceLote);
        $("#gridLotes").jqxGrid({
            width: 730,
            columnsresize: true,
            source: adapterlote,
            editable: true,
            theme: 'personal2',
            editmode: 'click',
            selectionmode: 'checkbox',
            autoheight: true,
            columns: [{
                    text: 'Tamaño de lote',
                    datafield: 'tamanoLote',
                    align: 'center',
                    width: 300

                },
                {
                    text: 'Número de lote',
                    align: 'center',
                    datafield: 'numLote',
                    width: 200
                },
                {
                    text: 'Cantidad enviada por lotes',
                    align: 'center',
                    datafield: 'cantEnviadaLote',
                    width: 200
                },
            ]
        });
        if (muestra[0].muestra.es_facturable == 1) {
            $("#facturarMuestra").jqxCheckBox('val', true);
            $("#numFactura").jqxInput('val', muestra[0].muestra.num_factura);
            $("#descuento").jqxNumberInput('val', muestra[0].muestra.descuento);
            $("#cantidad").jqxNumberInput('val', muestra[0].muestra.cantidad);
            $("#anticipo").jqxNumberInput('val', muestra[0].muestra.anticipo);
            $("#saldo").jqxNumberInput('val', muestra[0].muestra.saldo);
        } else {
            $("#facturarMuestra").jqxCheckBox('val', false);
        }
        eventUncheckedActiva();
    } else {

        $('#respuesta').jqxNotification({template: 'error'});
        $("#respuesta").html('Error al consultar la muestra numero: <strong>' + muestra[0].idConsultado + '</strong>');
        $("#respuesta").jqxNotification("open");
    }
    if (muestra[0].muestra.id_area_analisis == 4) {
        $("#gridEstEnsayo").show();
    }

}

function getMuestraReferenciasById(idMuestra) {

    var url = 'model/DB/jqw/muestraData.php';
    var muestra;
    $.ajax({
        type: "GET",
        url: url,
        data: "query=GetMuestraReferenciasById&idMuestra=" + idMuestra,
        async: false,
        success: function (data) {

            muestra = JSON.parse(data);
            chargeMuestra(muestra);



        },
    });
}

function renderEnsayoGrid(idProducto, idAreaAnalisis) {

    if (idAreaAnalisis != 4) {
        $("#gridEstEnsayo").hide(400, function () {
            $("#gridEnsayo").show(400, function () {
                $("#gridEstEnsayo").jqxGrid('clear');
            });
        });


        var sourceEnsayo = {
            datatype: "json",
            datafields: [
                {name: 'idEnsayoPaquete', type: 'string'},
                {name: 'descripcionPaquete', type: 'string'},
                {name: 'areaAnalisis', type: 'string'},
                {name: 'tiempo', type: 'int'},
                {name: 'idEnsayo', type: 'string'},
                {name: 'desEnsayo', type: 'string'},
                {name: 'duracion', type: 'int'},
                {name: 'validacion', type: 'boolean'},
                {name: 'idMetodo', type: 'string'}
            ],
            url: 'model/DB/jqw/productosPaquetesEnsayosData.php?query=ProductoPaquetesEnsayos&producto=' + idProducto + '&idAreaAnalisis=' + idAreaAnalisis
        };
        var settingsEnsayo = {
            async: false
        };
        var loteEnsayo = new $.jqx.dataAdapter(sourceEnsayo, settingsEnsayo);
        $("#gridEnsayo").jqxGrid({
            width: 960,
            columnsresize: true,
            source: loteEnsayo,
            theme: 'personal2',
            showgroupsheader: false,
            editmode: 'click',
            selectionmode: 'singlecell',
            editable: true,
            groupable: true,
            autoheight: true,
            columns: [
                {
                    text: 'Cod. Paquete',
                    align: 'center',
                    datafield: 'idEnsayoPaquete',
                    editable: false,
                    width: 100,
                    cellsalign: 'center',
                    hidden: true
                },
                {
                    text: 'Descripción del paquete',
                    align: 'center',
                    datafield: 'descripcionPaquete',
                    editable: false,
                    width: 300,
                    hidden: true
                },
                {
                    text: 'idEnsayo',
                    cellsalign: 'center',
                    datafield: 'idEnsayo',
                    align: 'center',
                    editable: false,
                    groupable: false,
                    width: 80,
                    hidden: true
                },
                {
                    text: 'Descripción del ensayo',
                    cellsalign: 'center',
                    datafield: 'desEnsayo',
                    align: 'center',
                    editable: false,
                    groupable: false,
                    width: 680
                },
                {
                    text: 'Seleccione',
                    datafield: 'validacion',
                    align: 'center',
                    cellsalign: 'center',
                    columntype: 'checkbox',
                    width: 90
                },
                {
                    text: 'Duración',
                    editable: false,
                    datafield: 'duracion',
                    cellsalign: 'center',
                    groupable: false,
                    width: 156
                },
                {
                    text: 'Área de análisis',
                    groupable: false,
                    align: 'center',
                    cellsalign: 'center',
                    editable: false,
                    datafield: 'areaAnalisis',
                    width: 0
                },
                {
                    text: 'Tiempo',
                    datafield: 'tiempo',
                    align: 'center',
                    editable: false,
                    cellsalign: 'center',
                    groupable: false,
                    width: 0
                            //hidden: true
                },
                {
                    text: 'idMetodo',
                    datafield: 'idMetodo',
                    align: 'center',
                    cellsalign: 'center',
                    width: 90,
                    hidden: true
                }
            ],
            groups: ['descripcionPaquete']
        });
        var rows = $('#gridEnsayo').jqxGrid('getrows');
        if (rows.length == 0 && idProducto !== undefined) {
            $('#respuesta').jqxNotification({template: 'error'});
            $("#respuesta").html("No existen ensayos para el producto seleccionado en esta area de analisis.");
            $("#respuesta").jqxNotification("open");
        }
    } else {
        // oculta grilla 
        $("#gridEnsayo").hide(400, function () {
            $("#gridEstEnsayo").show(400, function () {
                $("#gridEnsayo").jqxGrid('clear');
            });
        });




        // 
    }




}

function ajaxGetEnsayosByProductoRegEstMuestra(idProducto) {
    //model/DB/jqw/productosPaquetesEnsayosData.php?query=ProductoPaquetesEnsayos&producto='+idProducto+'&idAreaAnalisis='+idAreaAnalisis
    var url = "model/DB/jqw/productosPaquetesEnsayosData.php";
    var data = "query=NomProductoPaquetesEnsayos";
    data = data + "&producto=" + idProducto;
    data = data + "&idAreaAnalisis=4";

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
                    data[i].idPaquete = parseInt(data[i].idPaquete);
                    data[i].idProducto = String(data[i].idProducto);
                    data[i].valor = parseInt(data[i].valor);
                }

                utilLoadGridProductosEnsayosRegEstMuestra(data);
            } else {
                $('#respuesta').jqxNotification({template: 'error'});
                $("#respuesta").html("No existen ensayos para el producto seleccionado en esta area de analisis.");
                $("#respuesta").jqxNotification("open");
            }
        }
    });
}

function utilLoadGridProductosEnsayosRegEstMuestra(dataArray) {


    var cantidadTiempos = $("#duracion").jqxDropDownList('val');
    var datafields = [];
    var columns = [];
    var nombreColumna;
    var contador = 6;
    var columngroups = [];

    datafields[0] = {name: 'idPaquete', type: 'int'};
    columns[0] = {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true, editable: false};
    datafields[1] = {name: 'nomPaquete', type: 'string'};
    columns[1] = {text: 'Paquete', datafield: 'nomPaquete', align: 'center', width: 200, hidden: false, editable: false};
    datafields[2] = {name: 'idEnsayo', type: 'int'};
    columns[2] = {text: 'idEnsayo', datafield: 'idEnsayo', width: 200, hidden: true, editable: false};
    datafields[3] = {name: 'nomEnsayo', type: 'string'};
    columns[3] = {text: 'Ensayo', datafield: 'nomEnsayo', align: 'center', width: 300, hidden: false, editable: false};
    datafields[4] = {name: 'duracion', type: 'int'};
    columns[4] = {text: 'Duracion', datafield: 'duracion', align: 'center', width: 70, hidden: false, editable: true, columntype: 'numberinput', aggregates: ['sum', 'avg']};
    datafields[5] = {name: 'nomAreaAnalisis', type: 'string'};
    columns[5] = {text: 'nomArea', datafield: 'nomAreaAnalisis', align: 'center', width: 70, hidden: true, editable: true};

    var columnasAdicionar = cantidadTiempos * 4;

    var datosTiempos = $("#duracion").jqxDropDownList('getItems');
    for (var i = 0; i < cantidadTiempos; i++) {
        var nomMes = datosTiempos[i].label;
        columngroups[i] = {text: nomMes, align: 'center', name: 'cg' + i};
        for (var j = 0; j < 4; j++) {

            if (j == 0) {
                nombreColumna = '30º 65%';
            } else if (j == 1) {
                nombreColumna = '30º 75%';
            } else if (j == 2) {
                nombreColumna = '40º 75%';
            } else {
                nombreColumna = '50° 75%';
            }

            datafields[contador] = {name: i + 't' + j, type: 'bool'};
            columns[contador] = {text: nombreColumna, datafield: i + 't' + j, columngroup: 'cg' + i, cellsalign: 'center', columntype: 'checkbox', width: 50, hidden: false, editable: true};
            for (var h = 0; h < dataArray.length; h++) {
                dataArray[h][i + 't' + j] = 0;
            }
            contador++;
        }
    }

    var source =
            {
                datafields: datafields,
                datatype: "array",
                localdata: dataArray
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    var groupcolumnrenderer2 = function (text) {
        return '<div style="padding: 5px; float: left; color: Blue;">' + text + '</div>';
    }
    $("#gridEstEnsayo").jqxGrid(
            {
                width: '100%',
                autoheight: true,
                autorowheight: true,
                source: dataAdapter,
                pageable: true,
                showgroupmenuitems: false,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                editable: true,
                altrows: true,
                columnsresize: true,
                columns: columns,
                groupable: true,
                groups: ['nomPaquete'],
                columngroups: columngroups
            });
    //$('#windowLoadTiemposRegEstCotizacion').jqxWindow('close');
}


//function eventClickButtonInformePrint() { //Nuevo JP
//    $("#imprimirInformeButton").click(function () {
//        // var idMuestra = $("#inputNumMuestraConHojaRutaMuestra").val();
//        var idMuestra = $('#numMuestra').val();
//        window.open("pdf/informes/informeAnalisis.php?idMuestra=" + idMuestra);
//
//    });
//
//}



function updateMuestra() {
    var areaAnalisis = $("#areaAnalisis").jqxDropDownList('val');
    var url = 'index.php?action=updateMuestra';
    if (areaAnalisis != 4) {



        //numero de muestra a actualizar
        var idMuestra = $("#numMuestra").jqxInput('val');
        var dataO = 'idMuestra=' + idMuestra;
        //valor muestra activa/////////////////////////////////////////
        var activa = $("#activa").jqxCheckBox('checked');
        if (activa === true) {
            activa = 1;
        } else {
            activa = 0;
        }
        dataO += '&activa=' + activa;
        //valor prioridad//////////////////////////////////////////
        var prioridad = $("#prioridad").jqxDropDownList('val');
        dataO += '&prioridad=' + prioridad;
        //valor numero de cotizacion///////////////////////////////
        var cotizacion = $("#numCotizacion").val();
        dataO += '&cotizacion=' + cotizacion;
        //numero de remision///////////////////////////////
        var remision = $("#numRemision").val();
        dataO += '&remision=' + remision;
        //fecha llegada///////////////////////////////
        var fechaLlegada = $("#fechaLlegada").val();
        dataO += '&fechaLlegada=' + fechaLlegada;
        //fecha Compromiso///////////////////////////////
        var fechaCompromiso = $("#fechaCompromiso").val();
        dataO += '&fechaCompromiso=' + fechaCompromiso;
        //tercero///////////////////////////////
        var idTercero = $("#nomCliente").val();
        idTercero = idTercero['value'];
        dataO += '&idTercero=' + idTercero;
        //Contacto///////////////////////////////
        var idContacto = $("#contactoSolicitante").val();
        dataO += '&idContacto=' + idContacto;
        //Area contacto///////////////////////////////
        var areaContacto = $("#areaContacto").val();
        dataO += '&areaContacto=' + areaContacto;
        //Area contacto///////////////////////////////
        var laboratorio = $("#labSolicitante").val();
        dataO += '&laboratorio=' + laboratorio;
        //ProcedenciaArea contacto///////////////////////////////
        var procedencia = $("#procedencia").val();
        dataO += '&procedencia=' + procedencia;
        //ProcedenciaArea contacto///////////////////////////////
        var numeroInfo = $("#numInforme").val();
        dataO += '&numeroInfo=' + numeroInfo;
        //Observaciones///////////////////////////////
        var observaciones = $("#observaciones").val();
        dataO += '&observaciones=' + observaciones;
        //Area de analisis///////////////////////////////
        var areaAnalisis = $("#areaAnalisis").jqxDropDownList('val');
        dataO += '&areaAnalisis=' + areaAnalisis;
        //Area de analisis///////////////////////////////
        var tipoEstabilidad = $("#tipoEstabilidad").jqxDropDownList('val');
        dataO += '&tipoEstabilidad=' + tipoEstabilidad;
        // Duracion///////////////////////////////
        var duracion = $("#duracion").val();
        dataO += '&duracion=' + duracion;
        // Producto///////////////////////////////
        var idProducto = $("#nomProducto").val();
        idProducto = idProducto['value'];
        dataO += '&idProducto=' + idProducto;
        // empaque///////////////////////////////
        var idEmpaque = $("#empaque").val();
        dataO += '&idEmpaque=' + idEmpaque;
        //envase///////////////////////////////
        var idEnvase = $("#envase").val();
        dataO += '&idEnvase=' + idEnvase;
        //fecha de fabricacion///////////////////////////////
        var fechaFabricacion = $("#fechaFabricacion").val();
        dataO += '&fechaFabricacion=' + fechaFabricacion;
        //fecha de vencimiento///////////////////////////////
        var fechaVencimiento = $("#fechaVencimiento").val();
        dataO += '&fechaVencimiento=' + fechaVencimiento;
        //facturar muestra///////////////////////////////
        var esfacturable = $("#facturarMuestra").val();
        if (esfacturable === true) {
            esfacturable = 1;
        } else {
            esfacturable = 0;
        }
        dataO += '&esfacturable=' + esfacturable;
        //numero factura///////////////////////////////
        var numFactura = $("#numFactura").val();
        dataO += '&numFactura=' + numFactura;
        //descuento///////////////////////////////
        var descuento = $("#descuento").val();
        dataO += '&descuento=' + descuento;
        //cantidad///////////////////////////////
        var cantidad = $("#cantidad").val();
        dataO += '&cantidad=' + cantidad;
        //anticipo///////////////////////////////
        var anticipo = $("#anticipo").val();
        dataO += '&anticipo=' + anticipo;
        //Saldo///////////////////////////////
        var saldo = $("#saldo").val();
        dataO += '&saldo=' + saldo;
        //Lotes///////////////////////////////
        var rows = $('#gridLotes').jqxGrid('getrows');
        if (rows.length > 0) {
            var infoLotes = $("#gridLotes").jqxGrid('exportdata', 'json');
        } else {
            var infoLotes = 0;
        }

        dataO += '&infoLotes=' + infoLotes;
        //Ensayos///////////////////////////////
        $('#gridEnsayo').jqxGrid('showcolumn', 'idEnsayoPaquete');
        $('#gridEnsayo').jqxGrid('showcolumn', 'idEnsayo');
        $('#gridEnsayo').jqxGrid('showcolumn', 'idMetodo');
        var infoEnsayos = $("#gridEnsayo").jqxGrid('exportdata', 'json');
        var infoEnsayos = $('#gridEnsayo').jqxGrid('getrows');
        var infoEnsayos = JSON.stringify(infoEnsayos);
        $('#gridEnsayo').jqxGrid('hidecolumn', 'idEnsayoPaquete');
        $('#gridEnsayo').jqxGrid('hidecolumn', 'idEnsayo');
        $('#gridEnsayo').jqxGrid('hidecolumn', 'idMetodo');
        dataO += '&infoEnsayos=' + infoEnsayos;
        $.ajax({
            type: "POST",
            url: url,
            data: dataO,
            success: function (data) {
                //alert(data);
                messageNotificationUpdateMuestra(data);
            }
        });
    } else {
        //alert("update muestra de estabilidades");



        //numero de muestra a actualizar
        var idMuestra = $("#numMuestra").jqxInput('val');
        var dataO = 'idMuestra=' + idMuestra;
        //valor muestra activa/////////////////////////////////////////
        var activa = $("#activa").jqxCheckBox('checked');
        if (activa === true) {
            activa = 1;
        } else {
            activa = 0;
        }
        dataO += '&activa=' + activa;
        //valor prioridad//////////////////////////////////////////
        var prioridad = $("#prioridad").jqxDropDownList('val');
        dataO += '&prioridad=' + prioridad;
        //valor numero de cotizacion///////////////////////////////
        var cotizacion = $("#numCotizacion").val();
        dataO += '&cotizacion=' + cotizacion;
        //numero de remision///////////////////////////////
        var remision = $("#numRemision").val();
        dataO += '&remision=' + remision;
        //fecha llegada///////////////////////////////
        var fechaLlegada = $("#fechaLlegada").val();
        dataO += '&fechaLlegada=' + fechaLlegada;
        //fecha Compromiso///////////////////////////////
        var fechaCompromiso = $("#fechaCompromiso").val();
        dataO += '&fechaCompromiso=' + fechaCompromiso;
        //tercero///////////////////////////////
        var idTercero = $("#nomCliente").val();
        idTercero = idTercero['value'];
        dataO += '&idTercero=' + idTercero;
        //Contacto///////////////////////////////
        var idContacto = $("#contactoSolicitante").val();
        dataO += '&idContacto=' + idContacto;
        //Area contacto///////////////////////////////
        var areaContacto = $("#areaContacto").val();
        dataO += '&areaContacto=' + areaContacto;
        //Area contacto///////////////////////////////
        var laboratorio = $("#labSolicitante").val();
        dataO += '&laboratorio=' + laboratorio;
        //ProcedenciaArea contacto///////////////////////////////
        var procedencia = $("#procedencia").val();
        dataO += '&procedencia=' + procedencia;
        //ProcedenciaArea contacto///////////////////////////////
        var numeroInfo = $("#numInforme").val();
        dataO += '&numeroInfo=' + numeroInfo;
        //Observaciones///////////////////////////////
        var observaciones = $("#observaciones").val();
        dataO += '&observaciones=' + observaciones;
        //Area de analisis///////////////////////////////
        var areaAnalisis = $("#areaAnalisis").jqxDropDownList('val');
        dataO += '&areaAnalisis=' + areaAnalisis;
        //Area de analisis///////////////////////////////
        var tipoEstabilidad = $("#tipoEstabilidad").jqxDropDownList('val');
        dataO += '&tipoEstabilidad=' + tipoEstabilidad;
        // Duracion///////////////////////////////
        var duracion = $("#duracion").val();
        dataO += '&duracion=' + duracion;
        // Producto///////////////////////////////
        var idProducto = $("#nomProducto").val();
        idProducto = idProducto['value'];
        dataO += '&idProducto=' + idProducto;
        // empaque///////////////////////////////
        var idEmpaque = $("#empaque").val();
        dataO += '&idEmpaque=' + idEmpaque;
        //envase///////////////////////////////
        var idEnvase = $("#envase").val();
        dataO += '&idEnvase=' + idEnvase;
        //fecha de fabricacion///////////////////////////////
        var fechaFabricacion = $("#fechaFabricacion").val();
        dataO += '&fechaFabricacion=' + fechaFabricacion;
        //fecha de vencimiento///////////////////////////////
        var fechaVencimiento = $("#fechaVencimiento").val();
        dataO += '&fechaVencimiento=' + fechaVencimiento;
        //facturar muestra///////////////////////////////
        var esfacturable = $("#facturarMuestra").val();
        if (esfacturable === true) {
            esfacturable = 1;
        } else {
            esfacturable = 0;
        }
        dataO += '&esfacturable=' + esfacturable;
        //numero factura///////////////////////////////
        var numFactura = $("#numFactura").val();
        dataO += '&numFactura=' + numFactura;
        //descuento///////////////////////////////
        var descuento = $("#descuento").val();
        dataO += '&descuento=' + descuento;
        //cantidad///////////////////////////////
        var cantidad = $("#cantidad").val();
        dataO += '&cantidad=' + cantidad;
        //anticipo///////////////////////////////
        var anticipo = $("#anticipo").val();
        dataO += '&anticipo=' + anticipo;
        //Saldo///////////////////////////////
        var saldo = $("#saldo").val();
        dataO += '&saldo=' + saldo;
        //Lotes///////////////////////////////
        var rows = $('#gridLotes').jqxGrid('getrows');
        if (rows.length > 0) {
            var infoLotes = $("#gridLotes").jqxGrid('exportdata', 'json');
        } else {
            var infoLotes = 0;
        }

        dataO += '&infoLotes=' + infoLotes;
        //Ensayos///////////////////////////////

        var rows = $('#gridEstEnsayo').jqxGrid('getrows');


        var infoEnsayos = JSON.stringify(rows);

        dataO += '&infoEnsayos=' + infoEnsayos;
        $.ajax({
            type: "POST",
            url: url,
            data: dataO,
            success: function (data) {
                //alert(data);
                messageNotificationUpdateMuestra(data);
            }
        });
    }
}

function messageNotificationUpdateMuestra(data) {

    var response = JSON.parse(data);
    if (response.result === '1') {

        $('#respuesta').jqxNotification({template: 'success'});

    } else {
        $('#respuesta').jqxNotification({template: 'error'});
    }

    $("#respuesta").html(response.message);
    $("#respuesta").jqxNotification("open");

}

function searchMuestraClickButton() {
    $("#submitButton4").jqxButton({disabled: true});

    $("#submitButton2").jqxButton({disabled: false});
    $("#submitButton3").jqxButton({disabled: false});
    $("#updateMuestraButton").jqxButton({disabled: false});
    //$("#imprimirInformeButton").jqxButton({disabled: false}); //Nuevo JP
    $("#numMuestra").jqxInput({disabled: true});
    var value = $('#numMuestra').val();



    $('#updateMuestraButton').on('click', function () {
        $('#updateMuestraButton').unbind();
        updateMuestra();
    });

//    $('#imprimirInformeButton').on('click', function () {
//        eventClickButtonInformePrint();
//    });
    getMuestraReferenciasById(value);
}

function eventClickSearchMuestraButton() {
    $("#searchNumMuestra").click(function () {
        searchMuestraClickButton()
    });
}

function    guardarMuestra() {



    var nomCliente = $('#nomCliente').val();
    var hnomCliente = document.getElementById('hnomCliente');
    hnomCliente.value = nomCliente['value'];

    if (nomCliente['value'] == undefined) {
        $('#respuesta').jqxNotification({template: 'error'});
        $("#respuesta").html('Debe seleccionar un cliente valido para registrar la muestra');
        $("#respuesta").jqxNotification("open");
        return false;
    }

    var duracion = $('#duracion').val();
    var hduracion = document.getElementById('hduracion');
    hduracion.value = duracion;



    var producto = $('#nomProducto').val();
    var hProducto = document.getElementById('hnomProducto');
    if (producto['value'] == undefined) {
        $('#respuesta').jqxNotification({template: 'error'});
        $("#respuesta").html('Debe seleccionar un producto valido para registrar la muestra');
        $("#respuesta").jqxNotification("open");
        return false;
    }
    hProducto.value = producto['value'];

    var cantidad = $('#cantidad').val();
    var hcantidad = document.getElementById('hcantidad');
    hcantidad.value = cantidad;
    var anticipo = $('#anticipo').val();
    var hanticipo = document.getElementById('hanticipo');
    hanticipo.value = anticipo;
    var descuento = $('#descuento').val();
    var hdescuento = document.getElementById('hdescuento');
    hdescuento.value = descuento;
    var saldo = $('#saldo').val();
    var hsaldo = document.getElementById('hsaldo');
    hsaldo.value = saldo;
    var cantidadLotes = $("#gridLotes").jqxGrid('getrows');
    cantidadLotes = cantidadLotes.length;
    var hcantidadLotes = document.getElementById('hcantidadLotes');
    hcantidadLotes.value = cantidadLotes;
    var hlotes = document.getElementById('hlotes');
    if (cantidadLotes > 0) {
        var infoLotes = $("#gridLotes").jqxGrid('exportdata', 'json');
        var auxLotes = JSON.parse(infoLotes);
        if (auxLotes[0]['Cantidad enviada por lotes'] == '' || auxLotes[0]['Número de lote'] == '' || auxLotes[0]['Tamaño de lote'] == '') {
            $('#respuesta').jqxNotification({template: 'error'});
            $("#respuesta").html('Debe digitar los parametros del lote para registrar la muestra');
            $("#respuesta").jqxNotification("open");
            return false;
        }
        hlotes.value = infoLotes;
    } else {
        hlotes.value = "0";
    }

    var idAreaAnalisis = $("#areaAnalisis").val();

    if (idAreaAnalisis != 4) {


        $('#gridEnsayo').jqxGrid('showcolumn', 'idEnsayoPaquete');
        $('#gridEnsayo').jqxGrid('showcolumn', 'idEnsayo');
        $('#gridEnsayo').jqxGrid('showcolumn', 'idMetodo');

        var infoEnsayos = $("#gridEnsayo").jqxGrid('exportdata', 'json');
        var hensayo = document.getElementById('hensayo');
        hensayo.value = infoEnsayos;
        $('#gridEnsayo').jqxGrid('hidecolumn', 'idEnsayoPaquete');
        $('#gridEnsayo').jqxGrid('hidecolumn', 'idEnsayo');
        $('#gridEnsayo').jqxGrid('hidecolumn', 'idMetodo');
        var auxEnsayos = JSON.parse(infoEnsayos);
        var validarEnsayos = false;
        for (var i = 0; i < auxEnsayos.length; i++) {
            if (auxEnsayos[i].Seleccione == true) {
                validarEnsayos = true;
                break;
            }
        }
        if (validarEnsayos == false) {
            $('#respuesta').jqxNotification({template: 'error'});
            $("#respuesta").html('Debe seleccionar al menos un ensayo para la muestra');
            $("#respuesta").jqxNotification("open");
            return false;
        }

    } else {

        var rows = $('#gridEstEnsayo').jqxGrid('getrows');
        var validarEnsayos = false;
        if (rows == undefined) {
            $('#respuesta').jqxNotification({template: 'error'});
            $("#respuesta").html('Debe generar los ensayos para la muestra');
            $("#respuesta").jqxNotification("open");
            return false;
        }
        for (var i = 0; i < rows.length; i++) {
            if (rows[i]['0t0'] == true || rows[i]['0t1'] == true || rows[i]['0t2'] == true || rows[i]['0t3'] == true ||
                rows[i]['1t0'] == true || rows[i]['1t1'] == true || rows[i]['1t2'] == true || rows[i]['1t3'] == true ||
                rows[i]['2t0'] == true || rows[i]['2t1'] == true || rows[i]['2t2'] == true || rows[i]['2t3'] == true ||
                rows[i]['3t0'] == true || rows[i]['3t1'] == true || rows[i]['3t2'] == true || rows[i]['3t3'] == true ||    
                rows[i]['3t0'] == true || rows[i]['4t1'] == true || rows[i]['4t2'] == true || rows[i]['4t3'] == true ||    
                rows[i]['5t0'] == true || rows[i]['5t1'] == true || rows[i]['5t2'] == true || rows[i]['5t3'] == true ||
                rows[i]['6t0'] == true || rows[i]['6t1'] == true || rows[i]['6t2'] == true || rows[i]['6t3'] == true ||
                rows[i]['7t0'] == true || rows[i]['7t1'] == true || rows[i]['7t2'] == true || rows[i]['7t3'] == true ||
                rows[i]['8t0'] == true || rows[i]['8t1'] == true || rows[i]['8t2'] == true || rows[i]['8t3'] == true ||
                rows[i]['9t0'] == true || rows[i]['9t1'] == true || rows[i]['9t2'] == true || rows[i]['9t3'] == true 
                    ) {
                validarEnsayos = true;
                break;
            }
        }
        var ensayos = JSON.stringify(rows);
        $('#hensayo').val(ensayos);
        if (validarEnsayos == false) {
            $('#respuesta').jqxNotification({template: 'error'});
            $("#respuesta").html('Debe seleccionar al menos un ensayo para la muestra');
            $("#respuesta").jqxNotification("open");
            return false;
        }

    }
    var url = 'index.php?action=saveMuestra';
    var test = $("#formRegMuestra").serialize();
    $.ajax({
        type: "POST",
        url: url,
        data: $("#formRegMuestra").serialize(),
        success: function (data) {
            if (messageNotificationSaveMuestra(data)) {
                $("#submitButton4").jqxButton({disabled: false});
            }


        }
    });
    return true;


}

function messageNotificationSaveMuestra(data) {

    var response = JSON.parse(data);
    if (response.result === '1') {

        $('#respuesta').jqxNotification({template: 'success'});
        document.getElementById('formRegMuestra').reset();
        $("#numMuestra").jqxInput({disabled: false});
        $("#numMuestra").jqxInput("val", "");
        $('#activa').jqxCheckBox({checked: true});
        $("#numCotizacion").jqxInput('val', '');
        $("#prioridad").jqxDropDownList('selectIndex', 0);
        var fechaCompromiso = sumarDias(new Date(), 5);

        $("#fechaCompromiso").jqxDateTimeInput({value: fechaCompromiso});
        var dataSourceContactoSolictante = ["contacto solicitante"];
        $("#contactoSolicitante").jqxDropDownList({disabled: true, source: dataSourceContactoSolictante, selectedIndex: 0, width: '200', height: '20', dropDownHeight: 50});
        $("#observaciones").val('');
        $("#areaAnalisis").jqxDropDownList('selectIndex', 0);
        $("#duracion").jqxNumberInput('val', 1);
        $("#empaque").jqxDropDownList('selectIndex', 0);
        $("#envase").jqxDropDownList('selectIndex', 0);
        $("#descuento").jqxNumberInput('val', 1);
        $("#cantidad").jqxNumberInput('val', 1);
        $("#anticipo").jqxNumberInput('val', 1);
        $("#saldo").jqxNumberInput('val', 1);



        $("#gridEnsayo").jqxGrid('clear');
        $("#gridLotes").jqxGrid('clear');
        $('#gridLotes').jqxGrid('addrow', null, {});
        $('#facturarMuestra').jqxCheckBox({checked: false});

        $("#gridPrincipiosActivos").jqxGrid('clear');




    } else {
        $('#respuesta').jqxNotification({template: 'error'});
    }

    $("#respuesta").html(response.message);
    $("#respuesta").jqxNotification("open");

    return true;
}

function createJqxNotificationRespuesta() {
    $("#respuesta").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function createJqxInputnomCliente() {
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
    $("#nomCliente").jqxInput({source: dataAdapter, placeHolder: "Nombre del Contacto:", displayMember: "nombre", valueMember: "id", width: 350, height: 20});
}

function eventSelectJqxInputnomCliente() {
    var value = $('#nomCliente').val();
    //alert(value["label"]);
    var hnomCliente = document.getElementById('hnomCliente');
    hnomCliente.value = value['value'];


    var contactosSource =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'nombre'},
                    {name: 'area'}
                ],
                url: 'model/DB/jqw/contactoData.php?query=contactosByTercero&idTercero=' + value["value"],
                async: false
            };

    var contactosAdapter = new $.jqx.dataAdapter(contactosSource);

    $("#contactoSolicitante").jqxDropDownList({disabled: false, source: contactosAdapter, displayMember: "nombre", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 200});

    contactosAdapter.dataBind();
    terceros = contactosAdapter.getRecordsHierarchy('id', 'area');


    $("#areaContacto").jqxInput('val', {label: terceros[0]['area'], value: terceros[0]['area']});

    $("#labSolicitante").jqxInput('val', {label: value['label'], value: value['value']})

    $("#procedencia").jqxInput('val', {label: value['label'], value: value['value']})

    $('#contactoSolicitante').on('select', function (event)
    {


        var args = event.args;
        if (args && terceros === undefined) {



        } else {
            if (args) {
                var item = args.item;
                var value = item.value;
                for (i = 0; i < terceros.length; i++) {
                    if (terceros[i]["id"] == value) {
                        $("#areaContacto").jqxInput('val', {label: terceros[i]["area"], value: terceros[i]["area"]});
                        //alert (terceros[i]["area"]);
                    }
                }
            }

        }
    });
}

function selectJqxInputnomCliente() {
    $('#nomCliente').on('select', function () {
        eventSelectJqxInputnomCliente();

    });
}

function generarMuestraDesdeCotizacion(idCotizacion) {
    var data = idCotizacion.split("|");
    idCotizacion = data[0];
    var idProducto = data[1]
    var nomProducto = data[2];
    var idAreaAnalisis = data[3];

    if (idAreaAnalisis != 4) {
        ajaxSearchCotizacionById(idCotizacion);
        eventSelectJqxInputnomCliente();
        var itemAreaAnalisis = $("#areaAnalisis").jqxDropDownList('getItemByValue', idAreaAnalisis);
        $("#areaAnalisis").jqxDropDownList('selectItem', itemAreaAnalisis);
        $("#numCotizacion").jqxInput('val', idCotizacion);
        $('#nomProducto').jqxInput('val', {label: nomProducto, value: idProducto});
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
        pruductoAdapter.dataBind();
        var productos1 = pruductoAdapter.getRecordsHierarchy('id', 'des_formula_farma');
        var productos2 = pruductoAdapter.getRecordsHierarchy('id', 'tipoProducto');
        var value = $('#nomProducto').val();
        value = value["value"];
        for (i = 0; i < productos1.length; i++) {
            if (productos1[i]["id"] == value) {

                var aux = productos1[i]["des_formula_farma"];
                var aux2 = productos2[i]["tipoProducto"];

                $('#formFarmaceutica').val(aux);
                $('#tipoProducto').val(aux2);
            }


        }
        var principiosActivosSource = {
            datatype: "json",
            datafields: [
                {name: 'nombre', type: 'string'},
                {name: 'principal', type: 'string'},
                {name: 'trasador', type: 'string'}
            ],
            id: 'nombre',
            url: 'model/DB/jqw/PrincipioActivoData.php?query=principioActivo&producto=' + value
        };


        var principiosActivosAdapter = new $.jqx.dataAdapter(principiosActivosSource);
        $("#gridPrincipiosActivos").jqxGrid({
            width: 700,
            columnsresize: true,
            theme: 'personal2',
            source: principiosActivosAdapter,
            autoheight: true,
            columns: [{
                    text: 'Descripción del principio activo',
                    datafield: 'nombre',
                    align: 'center',
                    cellsalign: 'center',
                    width: 300

                },
                {
                    text: 'Principal',
                    datafield: 'principal',
                    align: 'center',
                    cellsalign: 'center',
                    width: 200
                },
                {
                    text: 'Trazador de estabilidad',
                    align: 'center',
                    cellsalign: 'center',
                    datafield: 'trasador',
                    width: 200
                }]
        });

        renderEnsayoGrid(idProducto, idAreaAnalisis);
        ajaxSearchEnsayosByIdCotizacion(idCotizacion, idProducto, idAreaAnalisis);

    } else {
        ajaxSearchEstCotizacionById(idCotizacion);


    }
}

function chargeEstMuestraFromCotizacion(cotizacion) {

    $('#nomCliente').jqxInput('val', {label: cotizacion.nomTercero, value: cotizacion.idTercero});
    eventSelectJqxInputnomCliente();
    $("#observaciones").jqxEditor('val', cotizacion.observaciones + "<br>" + cotizacion.observaciones2 + "<br>" + cotizacion.observaciones3);


    var itemAreaAnalisis = $("#areaAnalisis").jqxDropDownList('getItemByValue', 4);
    $("#areaAnalisis").jqxDropDownList('selectItem', itemAreaAnalisis);
    $("#numCotizacion").jqxInput('val', cotizacion.id);

    $('#duracion').unbind();
    var itemTipoEstabilidad = $("#tipoEstabilidad").jqxDropDownList('getItemByValue', cotizacion.tipoEstabilidad);
    $("#tipoEstabilidad").jqxDropDownList('selectItem', itemTipoEstabilidad);
    $('#tipoEstabilidad').on('change', function (event)
    {
        loadDropDownListDuracion(1, false);
    });


    var itemDuracionEstabilidad = $("#duracion").jqxDropDownList('getItemByValue', cotizacion.tiempos);
    $("#duracion").jqxDropDownList('selectItem', itemDuracionEstabilidad);
    eventChangeDropDownListDuracion();


    $('#nomProducto').jqxInput('val', {label: cotizacion.nomProducto, value: cotizacion.idProducto});
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
    pruductoAdapter.dataBind();
    var productos1 = pruductoAdapter.getRecordsHierarchy('id', 'des_formula_farma');
    var productos2 = pruductoAdapter.getRecordsHierarchy('id', 'tipoProducto');
    var value = $('#nomProducto').val();
    value = value["value"];
    for (i = 0; i < productos1.length; i++) {
        if (productos1[i]["id"] == value) {

            var aux = productos1[i]["des_formula_farma"];
            var aux2 = productos2[i]["tipoProducto"];

            $('#formFarmaceutica').val(aux);
            $('#tipoProducto').val(aux2);
        }


    }
    var principiosActivosSource = {
        datatype: "json",
        datafields: [
            {name: 'nombre', type: 'string'},
            {name: 'principal', type: 'string'},
            {name: 'trasador', type: 'string'}
        ],
        id: 'nombre',
        url: 'model/DB/jqw/PrincipioActivoData.php?query=principioActivo&producto=' + value
    };


    var principiosActivosAdapter = new $.jqx.dataAdapter(principiosActivosSource);
    $("#gridPrincipiosActivos").jqxGrid({
        width: 700,
        columnsresize: true,
        theme: 'personal2',
        source: principiosActivosAdapter,
        autoheight: true,
        columns: [{
                text: 'Descripción del principio activo',
                datafield: 'nombre',
                align: 'center',
                cellsalign: 'center',
                width: 300

            },
            {
                text: 'Principal',
                datafield: 'principal',
                align: 'center',
                cellsalign: 'center',
                width: 200
            },
            {
                text: 'Trazador de estabilidad',
                align: 'center',
                cellsalign: 'center',
                datafield: 'trasador',
                width: 200
            }]
    });

    var duracionEstabilidad = cotizacion.tiempos;

    var promise = ajaxGetEnsayosCotizacionToGridEstMuestra(cotizacion.id, cotizacion.idProducto);
    promise.success(function (data) {
        var ensayos = JSON.parse(data);
        utilLoadGridgridEstEnsayo(duracionEstabilidad, ensayos);
        $("#gridEstEnsayo").show();
    });




}

function utilLoadGridgridEstEnsayo(duracionEstabilidad, ensayos) {

    var datafields = [];
    var columns = [];
    var nombreColumna;
    var contador = 6;
    var columngroups = [];

    datafields[0] = {name: 'idPaquete', type: 'int'};
    columns[0] = {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true, editable: false};
    datafields[1] = {name: 'nomPaquete', type: 'string'};
    columns[1] = {text: 'Paquete', datafield: 'nomPaquete', align: 'center', width: 200, hidden: false, editable: false};
    datafields[2] = {name: 'idEnsayo', type: 'int'};
    columns[2] = {text: 'idEnsayo', datafield: 'idEnsayo', width: 200, hidden: true, editable: false};
    datafields[3] = {name: 'nomEnsayo', type: 'string'};
    columns[3] = {text: 'Ensayo', datafield: 'nomEnsayo', align: 'center', width: 300, hidden: false, editable: false};
    datafields[4] = {name: 'duracion', type: 'int'};
    columns[4] = {text: 'Duracion', datafield: 'duracion', align: 'center', width: 70, hidden: false, editable: true, columntype: 'numberinput', aggregates: ['sum', 'avg']};
    datafields[5] = {name: 'nomAreaAnalisis', type: 'string'};
    columns[5] = {text: 'nomArea', datafield: 'nomAreaAnalisis', align: 'center', width: 70, hidden: true, editable: true};

    var cantidadTiempos = duracionEstabilidad;
    var datosTiempos = $("#duracion").jqxDropDownList('getItems');

    for (var i = 0; i < cantidadTiempos; i++) {
        var nomMes = datosTiempos[i].label;
        columngroups[i] = {text: nomMes, align: 'center', name: 'cg' + i};
        for (var j = 0; j < 4; j++) {

            if (j == 0) {
                nombreColumna = '30ºC-65%HR';
            } else if (j == 1) {
                nombreColumna = '30ºC-75%HR';
            } else if (j == 2) {
                nombreColumna = '40ºC-75%HR';
            } else {
                nombreColumna = '50°C-80%HR';
            }

            datafields[contador] = {name: i + 't' + j, type: 'bool'};
            columns[contador] = {text: nombreColumna, datafield: i + 't' + j, columngroup: 'cg' + i, cellsalign: 'center', columntype: 'checkbox', width: 50, hidden: false, editable: true};

            contador++;
        }
    }

    var source =
            {
                datafields: datafields,
                datatype: "array",
                localdata: ensayos,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridEstEnsayo").jqxGrid(
            {
                width: '100%',
                autoheight: true,
                autorowheight: true,
                source: dataAdapter,
                pageable: true,
                showgroupmenuitems: false,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                editable: true,
                altrows: true,
                columnsresize: true,
                columns: columns,
                groupable: true,
                groups: ['nomPaquete'],
                columngroups: columngroups
            });

    $("#gridEstEnsayo").show();
}

function ajaxGetEnsayosCotizacionToGridEstMuestra(idCotizacion, idProducto) {
    var url = "model/DB/jqw/EstCotEnsData.php";
    var data = "query=GetEnsayosCotizacionToGridEstMuestra";
    var data = data + "&idCotizacion=" + idCotizacion;
    var data = data + "&idProducto=" + idProducto;
    return $.ajax({type: "GET", url: url, data: data});
}

function ajaxSearchEstCotizacionById(idCotizacion) {
    var url = "model/DB/jqw/EstCotizacionData.php";
    var data = "query=getEstCotizacionById";
    var data = data + "&idCotizacion=" + idCotizacion;
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                chargeEstMuestraFromCotizacion(response[0]);
            }
        }
    });
}

function ajaxSearchCotizacionById(idCotizacion) {
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
                var idCliente = response[0].idCliente;
                var nomCliente = response[0].nombreCliente;
                var observaciones = response[0].observaciones;
                $('#nomCliente').jqxInput('val', {label: nomCliente, value: idCliente});
                $("#observaciones").jqxEditor('val', observaciones);
                //$("#numCotizacionRegCotizacion").jqxInput('val',idCotizacion);
            }
        }
    });
}

function ajaxSearchEnsayosByIdCotizacion(idCotizacion, idProducto, idAreaAnalisis) {
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
                var idPro = idProducto;
                var idArea = idAreaAnalisis;

                var gridData = $("#gridEnsayo").jqxGrid('exportdata', 'json', null, true, null, true);
                gridData = JSON.parse(gridData);
                for (var i = 0; i < gridData.length; i++) {
                    var idPaquete = gridData[i]["Cod. Paquete"];
                    var idEnsayo = gridData[i]["idEnsayo"];
                    for (var j = 0; j < response.length; j++) {
                        var responseIdProducto = response[j]["idProducto"];
                        var responseIdArea = response[j]["idAreaAnalisis"];
                        var responseIdPaquete = response[j]["idPaquete"];
                        var responseIdEnsayo = response[j]["idEnsayo"];
                        //  
                        if (idPro == responseIdProducto && idArea == responseIdArea && idPaquete == responseIdPaquete && idEnsayo == responseIdEnsayo) {
                            var sel = responseIdEnsayo = response[j]["seleccione"];
                            if (sel == "0") {
                                $("#gridEnsayo").jqxGrid('setcellvalue', i, "validacion", 0);
                            }
                            break;
                        }
                    }

                }
            }
        }
    });
}

function utilLoadGridgridEstEnsayobyIdMuestra(muestra, ensayos) {

    var datafields = [];
    var columns = [];
    var nombreColumna;
    var contador = 6;
    var columngroups = [];

    datafields[0] = {name: 'idPaquete', type: 'int'};
    columns[0] = {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true, editable: false};
    datafields[1] = {name: 'nomPaquete', type: 'string'};
    columns[1] = {text: 'Paquete', datafield: 'nomPaquete', align: 'center', width: 200, hidden: false, editable: false};
    datafields[2] = {name: 'idEnsayo', type: 'int'};
    columns[2] = {text: 'idEnsayo', datafield: 'idEnsayo', width: 200, hidden: true, editable: false};
    datafields[3] = {name: 'nomEnsayo', type: 'string'};
    columns[3] = {text: 'Ensayo', datafield: 'nomEnsayo', align: 'center', width: 300, hidden: false, editable: false};
    datafields[4] = {name: 'duracion', type: 'int'};
    columns[4] = {text: 'Duracion', datafield: 'duracion', align: 'center', width: 70, hidden: false, editable: true, columntype: 'numberinput', aggregates: ['sum', 'avg']};
    datafields[5] = {name: 'nomAreaAnalisis', type: 'string'};
    columns[5] = {text: 'nomArea', datafield: 'nomAreaAnalisis', align: 'center', width: 70, hidden: true, editable: true};

    var cantidadTiempos = muestra.duracion;
    var datosTiempos = $("#duracion").jqxDropDownList('getItems');

    for (var i = 0; i < cantidadTiempos; i++) {
        var nomMes = datosTiempos[i].label;
        columngroups[i] = {text: nomMes, align: 'center', name: 'cg' + i};
        for (var j = 0; j < 4; j++) {

            if (j == 0) {
                nombreColumna = '30ºC-65%HR';
            } else if (j == 1) {
                nombreColumna = '30ºC-75%HR';
            } else if (j == 2) {
                nombreColumna = '40ºC-75%HR';
            } else {
                nombreColumna = '50°C-80%HR';
            }

            datafields[contador] = {name: i + 't' + j, type: 'bool'};
            columns[contador] = {text: nombreColumna, datafield: i + 't' + j, columngroup: 'cg' + i, cellsalign: 'center', columntype: 'checkbox', width: 50, hidden: false, editable: true};

            contador++;
        }
    }

    var source =
            {
                datafields: datafields,
                datatype: "array",
                localdata: ensayos,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridEstEnsayo").jqxGrid(
            {
                width: '100%',
                autoheight: true,
                autorowheight: true,
                source: dataAdapter,
                pageable: true,
                showgroupmenuitems: false,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                editable: true,
                altrows: true,
                columnsresize: true,
                columns: columns,
                groupable: true,
                groups: ['nomPaquete'],
                columngroups: columngroups
            });

    $("#gridEstEnsayo").show();
}

function ajaxGetEnsayosMuestraEstabilidad(muestra) {
    var idMuestra = muestra.id;
    var url = "index.php";
    var data = "action=getEnsayosMuestraEstabilidad";
    data = data + "&idMuestra=" + idMuestra;

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data) {
            var response = JSON.parse(data);
            if (response != null) {
                utilLoadGridgridEstEnsayobyIdMuestra(muestra, response);

            }
        }
    });
}

