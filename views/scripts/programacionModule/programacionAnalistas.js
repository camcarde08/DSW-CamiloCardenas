var ensayoDesasignar = null;

function initialProgramacionAnalistas(idMuestra, idPerfil, defaultSearchtext) {
    //elements
    var editrow = -1;
    loadNumMuestraProgAnalistasInput();
    loadListAnalistas();
    loadClienteProgAnalistasInput();
    loadFechaCompromisoProgAnalistasInput();
    loadProductoProgAnalistasInput();
    loadProgramarButton();
    loadAreaAnalisisProgAnalistasInput();
    loadNotificationProgAnalistas();
    loadWindowModalProgramacion();
    loadWindowDetalleEnsayoProgramado();

    loadDropDownListEquiposProgAnalistas();
    loadDropDownListTurnosProgAnalistas();
    loadinputDateFechaProgramacionProgAnalistas();
    loadinputDateFechaCompInternoProgAnalistas();
    loadInputNumberDuracionAnalisisProgAnalistas();
    loadInputDateFechaCompEnsayoProgAnalistas();
    loadEditorObservacionesProgAnalistas();
    loadButtonOKModalProgAnalistas();
    loadButtonCancelModalProgAnalistas();
    loadInputEspecificacionProgAnalistas();
    loadDivClienteProducto(idPerfil);

    //events
    eventClickSearchMuestraProgAnalistas();
    eventClearButton();
    eventClickProgramarButton();
    eventBindingCompleteGridEnsayos();
    eventBindingCompleteGridEnsayosProgramados();
    eventClickButtonOKModalProgAnalistas();
    eventClickButtonCancelModalProgAnalistas();
    eventClickButtonInformePrevio();
    eventClickButtonGuardarMotivo();
    eventClickButtonCancelarMotivo();
    eventSelectListBoxListaAnalistas();
    if (idMuestra != null) {
        $("#numMuestraProgAnalistas").val(idMuestra);
        var value = $("#numMuestraProgAnalistas").val();
        ajaxGetMuestraReferenciasById(value);
        $('#buttonInformePrevio').prop('disabled', false);
    } else {
        $("#numMuestraProgAnalistas").val(defaultSearchtext);
    }
}

function loadNumMuestraProgAnalistasInput() {
    $("#numMuestraProgAnalistas").jqxInput({placeHolder: "Número a Consultar", height: 20, width: 200, minLength: 1});

    $("#numMuestraProgAnalistas").bind('keydown', function (event) {
        if (event.keyCode === 13) {
            $("#searchNumMuestra").click();
        }
    });
}

function loadListAnalistas() {
    var analistasSource;

    analistasSource = {
        datatype: "json",
        datafields: [
            {name: 'id'},
            {name: 'nombre'}
        ],
        id: 'id',
        url: 'model/DB/jqw/usuarioData.php?query=getAnalistasProgramables'
    };
    var analistasAdapter = new $.jqx.dataAdapter(analistasSource);
    $("#listAnalistas").jqxListBox({
        width: '70%',
        height: '355',
        disabled: true,
        source: analistasAdapter,
        displayMember: "nombre",
        valueMember: "id"
    });

    $("div#dataTableAnalistas").hide();
}

function loadClienteProgAnalistasInput() {
    $("#clienteInput").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadFechaCompromisoProgAnalistasInput() {
    $("#fechaCompromisoInputProgAnalistas").jqxDateTimeInput({
        width: '350px',
        height: '20px',
        showCalendarButton: true,
        disabled: true
    });
    $("#fechaCompromisoInputProgAnalistas").val('');
}

function loadProductoProgAnalistasInput() {
    $("#productoInput").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadAreaAnalisisProgAnalistasInput() {
    $("#areaAnalisisInput").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadNotificationProgAnalistas() {
    $("#notificationProgAnalistas").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function loadProgramarButton() {
    $("#programarButton").jqxButton({template: "primary", disabled: true});
}

function loadEnsayosGridbyIdMuestra(idMuestra) {
    var url = 'model/DB/jqw/ensayoMuestraReferenciasData.php?query=GetEnsayoMuestraActivosByIdMuestra2&idMuestra=';
    var EnsayosActivosSource =
        {
            datatype: "json",
            datafields: [
                {name: 'id_muestra', type: 'int'},
                {name: 'idEnsayoPaquete', type: 'int'},
                {name: 'idEnsayo', type: 'int'},
                {name: 'validacion', type: 'int'},
                {name: 'areaAnalisis', type: 'string'},
                {name: 'tiempo', type: 'int'},
                {name: 'duracion', type: 'int'},
                {name: 'analizar_tercero', type: 'string'},
                {name: 'descripcionPaquete', type: 'string'},
                {name: 'desEnsayo', type: 'string'},
                {name: 'equipo', type: 'int'},
                {name: 'turno', type: 'string'},
                {name: 'fechaProg', type: 'string'},
                {name: 'fechaComInterno', type: 'string'},
                {name: 'observaciones', type: 'string'},
                {name: 'especificacion', type: 'string'}
            ],
            id: 'id',
            url: url + idMuestra + '&estadoEnsayo=0',
            root: 'data'
        };
    var ensayosActivosAdapter = new $.jqx.dataAdapter(EnsayosActivosSource);
    $("#gridEnsayosProgAnalistas").jqxGrid(
        {
            width: '99%',
            source: ensayosActivosAdapter,
            columnsresize: true,
            groupable: true,
            showgroupsheader: false,
            rowsheight: 40,
            columns: [
                {text: 'idMuestra', dataField: 'id_muestra', width: 200, groupable: false, hidden: true},
                {text: 'idEnsayoPaquete', dataField: 'idEnsayoPaquete', width: 200, groupable: false, hidden: true},
                {text: 'Paquete', dataField: 'descripcionPaquete', width: 200, hidden: true},
                {text: 'idEnsayo', dataField: 'idEnsayo', width: 200, groupable: false, hidden: true},
                {text: 'Ensayo', dataField: 'desEnsayo', width: '62%', groupable: false},
                {text: 'Duración', dataField: 'duracion', width: '10%', groupable: false, hidden: true},
                {text: 'Tercero', dataField: 'analizar_tercero', width: '15%', groupable: false},
                {text: 'Equipo', dataField: 'equipo', width: '20%', groupable: false, hidden: true},
                {text: 'Turno', dataField: 'turno', width: '20%', groupable: false, hidden: true},
                {text: 'fechaProg', dataField: 'fechaProg', width: '20%', groupable: false, hidden: true},
                {text: 'fechaComInterno', dataField: 'fechaComInterno', width: '20%', groupable: false, hidden: true},
                {text: 'Observaciones', dataField: 'observaciones', width: '20%', groupable: false, hidden: true},
                {text: 'Especificación', dataField: 'especificacion', width: '20%', groupable: false, hidden: true},
                {
                    text: 'Editar', datafield: 'Edit', width: '15%', columntype: 'button', cellsrenderer: function () {
                        return "Detalle";
                    }, buttonclick: function (row) {
                        editrow = row;
                        var dataRecord = $("#gridEnsayosProgAnalistas").jqxGrid('getrowdata', editrow);
                        $('#modalProgramacion').jqxWindow('setTitle', 'Detalle De Ensayo: ' + dataRecord.desEnsayo + ' Para La Muestra: ' + dataRecord.id_muestra);

                        $('#modalProgramacion').jqxWindow('open');
                        //carga el equipo de la fila
                        var equipo = $("#dropDownListEquiposProgAnalistas").jqxDropDownList('getItemByValue', dataRecord.equipo);
                        $("#dropDownListEquiposProgAnalistas").jqxDropDownList('selectIndex', equipo.index);

                        //carga el turno de la fila

                        var turno = $("#dropDownListTurnosProgAnalistas").jqxDropDownList('getItemByValue', dataRecord.turno);
                        if (turno == undefined) {
                            var turno = {
                                value: null
                            };
                            turno.value = 'Sin Turno';
                        }
                        var itemsTurno = $("#dropDownListTurnosProgAnalistas").jqxDropDownList('getItems');
                        for (var k = 0; k < itemsTurno.length; k++) {
                            if (itemsTurno[k].label == turno.value) {
                                $("#dropDownListTurnosProgAnalistas").jqxDropDownList('selectIndex', itemsTurno[k].index);
                                break;
                            }
                        }

                        //cargar fecha de programacion
                        var fechaProg = dataRecord.fechaProg;
                        //alert(fechaProg);
                        var arrayFechaProg = fechaProg.split("-");
                        $("#inputDateFechaProgramacionProgAnalistas").jqxDateTimeInput('setDate', new Date(arrayFechaProg[0], arrayFechaProg[1] - 1, arrayFechaProg[2]));
                        //$("#inputDateFechaProgramacionProgAnalistas").jqxDateTimeInput('setDate', new Date(2000,01,01));
                        //cargar fecha de compromiso interno
                        var fechaCompInterno = dataRecord.fechaComInterno;
                        var arrayFechaCompInterno = fechaCompInterno.split("-");
                        $("#inputDateFechaCompInternoProgAnalistas").jqxDateTimeInput('setDate', new Date(arrayFechaCompInterno[0], arrayFechaCompInterno[1] - 1, arrayFechaCompInterno[2]));
                        //Cargar duracion del ensayo
                        $("#inputNumberDuracionAnalisisProgAnalistas").jqxNumberInput('val', dataRecord.duracion);
                        //Cargar observaciones del ensayo
                        $("#editorObservacionesProgAnalistas").jqxEditor('val', dataRecord.observaciones);
                        //cargar fecha compromiso en modal
                        var fechaCompromiso = $("#fechaCompromisoInputProgAnalistas").jqxDateTimeInput('getDate');
                        $("#inputDateFechaCompEnsayoProgAnalistas").jqxDateTimeInput('setDate', fechaCompromiso);


                        $('#inputEspecificacionProgAnalistas').jqxInput('val', dataRecord.especificacion);
                    }
                }
            ]
        });


}

function loadEnsayosGridbyIdMuestraEst(idMuestra) {

    var url = 'model/DB/jqw/ensayoMuestraReferenciasData.php?query=GetEnsayoMuestraActivosByIdMuestra&idMuestra=';
    var EnsayosActivosSource =
        {
            datatype: "json",
            datafields: [
                {name: 'id_muestra', type: 'int'},
                {name: 'idEnsayoPaquete', type: 'int'},
                {name: 'idEnsayo', type: 'int'},
                {name: 'validacion', type: 'int'},
                {name: 'areaAnalisis', type: 'string'},
                {name: 'tiempo', type: 'int'},
                {name: 'duracion', type: 'int'},
                {name: 'descripcionPaquete', type: 'string'},
                {name: 'desEnsayo', type: 'string'},
                {name: 'equipo', type: 'int'},
                {name: 'turno', type: 'string'},
                {name: 'fechaProg', type: 'string'},
                {name: 'fechaComInterno', type: 'string'},
                {name: 'observaciones', type: 'string'},
                {name: 'idSubMuestra', type: 'int'},
                {name: 'duracionEstabilidad', type: 'string'},
                {name: 'temperaturaEstabilidad', type: 'string'},
                {name: 'analizar_tercero', type: 'string'}
            ],
            id: 'id',
            url: url + idMuestra + '&estadoEnsayo=0',
            root: 'data'
        };
    var ensayosActivosAdapter = new $.jqx.dataAdapter(EnsayosActivosSource);
    $("#gridEnsayosProgAnalistas").jqxGrid(
        {
            width: '99%',
            source: ensayosActivosAdapter,
            columnsresize: true,
            groupable: true,
            showgroupsheader: false,
            showfilterrow: true,
            filterable: true,
            rowsheight: 40,
            columns: [
                {text: 'idMuestra', dataField: 'id_muestra', width: 200, groupable: false, hidden: true},
                {text: 'idEnsayoPaquete', dataField: 'idEnsayoPaquete', width: 200, groupable: false, hidden: true},
                {text: 'Paquete', dataField: 'descripcionPaquete', width: 200, hidden: true},
                {text: 'idEnsayo', dataField: 'idEnsayo', width: 200, groupable: false, hidden: true},
                {text: 'Ensayo', dataField: 'desEnsayo', width: '67%', groupable: false, filtertype: 'checkedlist'},
                {text: 'Duración', dataField: 'duracion', width: '10%', groupable: false, filtertype: 'checkedlist', hidden: true},
                {text: 'Tercero', dataField: 'analizar_tercero', width: '10%', groupable: false},
                {text: 'Equipo', dataField: 'equipo', width: '20%', groupable: false, hidden: true},
                {text: 'Turno', dataField: 'turno', width: '20%', groupable: false, hidden: true},
                {text: 'fechaProg', dataField: 'fechaProg', width: '20%', groupable: false, hidden: true},
                {text: 'fechaComInterno', dataField: 'fechaComInterno', width: '20%', groupable: false, hidden: true},
                {text: 'Observaciones', dataField: 'observaciones', width: '20%', groupable: false, hidden: true},
                {text: 'idSubMuestra', dataField: 'idSubMuestra', width: '20%', groupable: false, hidden: true},
                {
                    text: 'Mes',
                    dataField: 'duracionEstabilidad',
                    width: '20%',
                    groupable: false,
                    filtertype: 'checkedlist',
                    hidden: false
                },
                {
                    text: 'temperatura',
                    dataField: 'temperaturaEstabilidad',
                    width: '20%',
                    groupable: false,
                    filtertype: 'checkedlist',
                    hidden: false
                },
                {
                    text: 'Editar', width: '15%', columntype: 'button', cellsrenderer: function () {
                        return "Detalle";
                    }, buttonclick: function (row) {
                        editrow = row;
                        var dataRecord = $("#gridEnsayosProgAnalistas").jqxGrid('getrowdata', editrow);
                        $('#modalProgramacion').jqxWindow('setTitle', 'Detalle Ensayo: ' + dataRecord.desEnsayo + ' de la muestra: ' + dataRecord.id_muestra);

                        $('#modalProgramacion').jqxWindow('open');
                        //carga el equipo de la fila
                        var equipo = $("#dropDownListEquiposProgAnalistas").jqxDropDownList('getItemByValue', dataRecord.equipo);
                        $("#dropDownListEquiposProgAnalistas").jqxDropDownList('selectIndex', equipo.index);

                        //carga el turno de la fila

                        var turno = $("#dropDownListTurnosProgAnalistas").jqxDropDownList('getItemByValue', dataRecord.turno);
                        if (turno == undefined) {
                            var turno = {
                                value: null
                            };
                            turno.value = 'Sin Turno';
                        }
                        var itemsTurno = $("#dropDownListTurnosProgAnalistas").jqxDropDownList('getItems');
                        for (var k = 0; k < itemsTurno.length; k++) {
                            if (itemsTurno[k].label == turno.value) {
                                $("#dropDownListTurnosProgAnalistas").jqxDropDownList('selectIndex', itemsTurno[k].index);
                                break;
                            }
                        }

                        //cargar fecha de programacion
                        var fechaProg = dataRecord.fechaProg;
                        var arrayFechaProg = fechaProg.split("-");
                        //alert(fechaProg);
                        $("#inputDateFechaProgramacionProgAnalistas").jqxDateTimeInput('setDate', new Date(arrayFechaProg[0], arrayFechaProg[1] - 1, arrayFechaProg[2]));
                        //cargar fecha de compromiso interno
                        var fechaCompInterno = dataRecord.fechaComInterno;
                        var arrayFechaCompInterno = fechaCompInterno.split("-");
                        $("#inputDateFechaCompInternoProgAnalistas").jqxDateTimeInput('setDate', new Date(arrayFechaCompInterno[0], arrayFechaCompInterno[1] - 1, arrayFechaCompInterno[2]));
                        //Cargar duracion del ensayo
                        $("#inputNumberDuracionAnalisisProgAnalistas").jqxNumberInput('val', dataRecord.duracion);
                        //Cargar observaciones del ensayo
                        $("#editorObservacionesProgAnalistas").jqxEditor('val', dataRecord.observaciones);
                        //cargar fecha compromiso en modal
                        var fechaCompromiso = $("#fechaCompromisoInputProgAnalistas").jqxDateTimeInput('getDate');
                        $("#inputDateFechaCompEnsayoProgAnalistas").jqxDateTimeInput('setDate', fechaCompromiso);
                    }
                }
            ]
        });
    $("#gridEnsayosProgAnalistas").on("filter", function (event) {
        $('#gridEnsayosProgAnalistas').jqxGrid('expandallgroups');
    });

}

function loadDropDownListEquiposProgAnalistas() {

    var url = "model/DB/jqw/EquiposData.php?query=all";
    var source =
        {
            datatype: "json",
            datafields: [
                {name: 'id'},
                {name: 'descripcion'},
                {name: 'referencia'}
            ],
            url: url,
            async: false
        };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#dropDownListEquiposProgAnalistas").jqxDropDownList({
        selectedIndex: 0,
        source: dataAdapter,
        displayMember: "referencia",
        valueMember: "id",
        width: 350,
        height: 25
    });
}

function loadDropDownListTurnosProgAnalistas() {
    var source = [
        "Sin Turno",
        "Turno 1",
        "Turno 2",
        "Turno 3"
    ];
    $("#dropDownListTurnosProgAnalistas").jqxDropDownList({
        source: source,
        selectedIndex: 0,
        width: '150',
        height: '25'
    });
}

function loadinputDateFechaProgramacionProgAnalistas() {
    $("#inputDateFechaProgramacionProgAnalistas").jqxDateTimeInput({width: '150px', height: '25px'});
}

function loadinputDateFechaCompInternoProgAnalistas() {
    $("#inputDateFechaCompInternoProgAnalistas").jqxDateTimeInput({width: '150px', height: '25px'});
}

function loadInputNumberDuracionAnalisisProgAnalistas() {
    $("#inputNumberDuracionAnalisisProgAnalistas").jqxNumberInput({
        width: '150px',
        height: '25px',
        inputMode: 'simple',
        spinButtons: true,
        decimalDigits: 0,
        min: 1
    });
    $("#inputNumberDuracionAnalisisProgAnalistas").val('0');
}

function loadInputEspecificacionProgAnalistas() {
    $("#inputEspecificacionProgAnalistas").jqxInput({width: '80%', height: '25px',});
}
;

function loadDivClienteProducto(idPerfil) {
    if (idPerfil != 2 && idPerfil != 3 && idPerfil != 4 && idPerfil != 5 && idPerfil != 6 && idPerfil != 7) {
        $("#divClienteProducto").show();
    } else {
        $("#divClienteProducto").hide();
    }
}
;

function loadInputDateFechaCompEnsayoProgAnalistas() {
    $("#inputDateFechaCompEnsayoProgAnalistas").jqxDateTimeInput({
        width: '150px',
        height: '25px',
        showCalendarButton: true,
        disabled: true
    });
}

function loadEditorObservacionesProgAnalistas() {
    $("#editorObservacionesProgAnalistas").jqxEditor({
        height: 140,
        width: 610,
        tools: "old italic underline | format font size | color background | ul ol | link | clean"
    });
}

function loadButtonOKModalProgAnalistas() {
    $("#buttonOKModalProgAnalistas").jqxButton({width: '100'});
}

function loadButtonCancelModalProgAnalistas() {
    $("#buttonCancelModalProgAnalistas").jqxButton({width: '100'});
}

function loadWindowModalProgramacion() {
    $('#modalProgramacion').jqxWindow({
        position: {x: 400, y: 300},
        height: 440,
        width: 800,
        isModal: true,
        resizable: false,
        autoOpen: false
    });
}

function loadWindowDetalleEnsayoProgramado() {
    $('#windowDetalleEnsayoProgramado').jqxWindow({
        position: {x: 300, y: 200},
        height: 250,
        width: 700,
        title: 'Características del ensayo programado',
        isModal: true,
        resizable: false,
        autoOpen: false
    });
}


function loadGridEnsayosProgramados(idMuestra, idAnalista) {
    var url = 'model/DB/jqw/programacionAnalistasData.php?query=getProgramacionByIdMuestraAndIdAnalista';
    var EnsayosProgramadosSource =
        {
            datatype: "json",
            datafields: [
                {name: 'idEnsayoMuestra', type: 'string'},
                {name: 'idAnalista', type: 'string'},
                {name: 'idEnsayo', type: 'string'},
                {name: 'desEnsayo', type: 'string'},
                {name: 'duracion', type: 'string'},
                {name: 'equipo', type: 'string'},
                {name: 'turno', type: 'string'},
                {name: 'fechaProg', type: 'string'},
                {name: 'fechaCompInterno', type: 'string'},
                {name: 'observaciones', type: 'string'},
                {name: 'idPaquete', type: 'string'},
                {name: 'desPaquete', type: 'string'},
                {name: 'idMuestra', type: 'string'},
                {name: 'desEquipo', type: 'string'},
                {name: 'aprobado', type: 'string'},
                {name: 'refEquipo', type: 'string'},
                {name: 'idEstado', type: 'number'},
                {name: 'analizar_tercero', type: 'string'}
            ],
            id: 'idEnsayoMuestra',
            url: url + '&idMuestra=' + idMuestra + '&idAnalista=' + idAnalista,
            root: 'data',
            async: false
        };
    var ensayosProgramadosAdapter = new $.jqx.dataAdapter(EnsayosProgramadosSource);
    $("#gridEnsayosProgramados").jqxGrid(
        {
            width: '99%',
            source: ensayosProgramadosAdapter,
            columnsresize: true,
            groupable: true,
            showgroupsheader: false,
            rowsheight: 40,
            columns: [
                {text: 'Aprobado', dataField: 'aprobado', hidden: true},
                {text: 'idEstado', dataField: 'idEstado', hidden: true},
                {text: 'desPaquete', dataField: 'desPaquete', width: 200, groupable: true, hidden: true},
                {text: 'Ensayo', dataField: 'desEnsayo', width: 280, groupable: false, hidden: false},
                {text: 'Duración', dataField: 'duracion', width: 61, groupable: false, hidden: true},
                {text: 'Tercero', dataField: 'analizar_tercero', width: 61, groupable: false, hidden: false},
                {text: 'idEnsayoMuestra', dataField: 'idEnsayoMuestra', width: 200, groupable: false, hidden: true},
                {text: 'idMuestra', dataField: 'idMuestra', width: 200, groupable: false, hidden: true},
                {text: 'Equipo', dataField: 'equipo', width: 200, groupable: false, hidden: true},
                {text: 'Turno', dataField: 'turno', width: 200, groupable: false, hidden: true},
                {text: 'FechaProg', dataField: 'fechaProg', width: 200, groupable: false, hidden: true},
                {text: 'FechaCompInterno', dataField: 'fechaCompInterno', width: 200, groupable: false, hidden: true},
                {text: 'Observaciones', dataField: 'observaciones', width: 200, groupable: false, hidden: true},
                {text: 'refEquipo', dataField: 'refEquipo', width: 200, groupable: false, hidden: true},
                {text: 'desEquipo', dataField: 'desEquipo', width: 200, groupable: false, hidden: true},
                {
                    text: '', width: 30, cellsrenderer: function (row) {
                        var dataRecord = $("#gridEnsayosProgramados").jqxGrid('getrowdata', row);
                        var equipo = "'" + dataRecord.refEquipo + "'";
                        var turno = "'" + dataRecord.turno + "'";
                        var fechaProg = "'" + dataRecord.fechaProg + "'";
                        var fechaCompInterno = "'" + dataRecord.fechaCompInterno + "'";
                        var duracion = "'" + dataRecord.duracion + "'";

                        var observaciones = "'" + dataRecord.observaciones + "'";
                        return '<img style="margin-left: 8px;margin-top: 3px"src="views/images/detalle.png" onClick="eventOpenDetalleEnsayoProgramado(' + dataRecord.idEnsayoMuestra + ',' + equipo + ',' + turno + ',' + fechaProg + ',' + fechaCompInterno + ',' + duracion + ',' + observaciones + ')"/>';
                    }
                },
                {
                    text: '', width: 30, cellsrenderer: function (row) {
                        var dataRecord = $("#gridEnsayosProgramados").jqxGrid('getrowdata', row);
                        if (dataRecord.idEstado == 1) {
                            return '<img style="margin-left: 8px;margin-top: 3px"src="views/images/papelera.png" onClick="eventEliminarProgramacion(' + dataRecord.idEnsayoMuestra + ')"/>';
                        } else {
                            return ''
                        }

                    }
                }
            ]
        });
    $('#gridEnsayosProgramados').jqxGrid('addgroup', 'desPaquete');
    $('#gridEnsayosProgramados').jqxGrid('expandallgroups');
}

function eventClickSearchMuestraProgAnalistas() {
    $("#searchNumMuestra").click(function () {
        var value = $("#numMuestraProgAnalistas").val();
        ajaxGetMuestraReferenciasById(value);
    });
}


function eventBindingCompleteGridEnsayos() {
    $("#gridEnsayosProgAnalistas").on("bindingcomplete", function (event) {

        var rows = $('#gridEnsayosProgAnalistas').jqxGrid('getrows');
        var today = new Date();
        var ano = today.getFullYear();
        var mes = today.getMonth() + 1;

        var dia = today.getDate();
        var hoy = ano + '-' + mes + '-' + dia;
        var fechaCompInterno = $("#fechaCompromisoInputProgAnalistas").jqxDateTimeInput('getDate');
        var anoC = fechaCompInterno.getFullYear();
        var mesC = fechaCompInterno.getMonth() + 1;

        var diaC = fechaCompInterno.getDate();
        fechaCompInterno = anoC + '-' + mesC + '-' + diaC;
        for (var i = 0; i < rows.length; i++) {
            $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', i, "turno", rows[i].turno);
            //$("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', i, "fechaProg", hoy);
            $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', i, "fechaComInterno", fechaCompInterno);
        }
        $('#gridEnsayosProgAnalistas').jqxGrid('addgroup', 'descripcionPaquete');
        $('#gridEnsayosProgAnalistas').jqxGrid({selectionmode: 'checkbox'});
        $('#gridEnsayosProgAnalistas').jqxGrid('expandallgroups');

        $("#listAnalistas").jqxListBox({disabled: false});
    });
}

function eventBindingCompleteGridEnsayosProgramados() {
    $("#gridEnsayosProgramados").on("bindingcomplete", function (event) {
        //$('#gridEnsayosProgramados').jqxGrid('addgroup', 'desPaquete');
        //$('#gridEnsayosProgramados').jqxGrid('expandallgroups'); 
    });
}

function eventClearButton() {
    $('#clearButton').on('click', function () {
        //lipiar campo numero de muestra
        //$("#numMuestraProgAnalistas").val('');
        $("#dataTableAnalistas").jqxDataTable('clear');
        $("div#dataTableAnalistas").hide();

        $('#informacionMuestraDiv').text('');
        $("#numMuestraProgAnalistas").jqxInput({disabled: false});
        //limpiar campo de cliente.
        $("#clienteInput").val('');
        //Limpiar campo fecha de compromiso
        $("#fechaCompromisoInputProgAnalistas").val('');
        //limpiar campo de producto.
        $("#productoInput").val('');
        //Limpiar campo de area de analisis.
        $("#areaAnalisisInput").val('');
        //bloquear boton programar muestra
        $("#programarButton").jqxButton({disabled: true});
        //Limpiar seleccion de analistas
        $("#listAnalistas").jqxListBox('clearSelection');
        //Bloquear lista de analistas
        $("#listAnalistas").jqxListBox({disabled: true});
        //Limpiar grilla Ensayos Programados
        $("#gridEnsayosProgramados").jqxGrid('clear');
        //Limpiar grilla Ensayos
        $("#gridEnsayosProgAnalistas").jqxGrid('clear');
        $('#buttonInformePrevio').prop('disabled', true);

    });

}

function eventClickProgramarButton() {

    $("#programarButton").click(function () {


        var selectedEnsayos = $('#gridEnsayosProgAnalistas').jqxGrid('getselectedrowindexes');

        if (selectedEnsayos.length > 0) {
            var programacionPromises = [];
            for (var i = 0; i < selectedEnsayos.length; i++) {
                if (selectedEnsayos[i] != null) {
                    var id = $('#gridEnsayosProgAnalistas').jqxGrid('getrowid', selectedEnsayos[i]);
                    var desEnsayo = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "desEnsayo");
                    var equipo = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "equipo");
                    var turno = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "turno");
                    var fechaProg = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "fechaProg");
                    var fechaCompInterno = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "fechaComInterno");
                    var duracion = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "duracion");
                    var observaciones = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "observaciones");
                    var especificacion = $('#gridEnsayosProgAnalistas').jqxGrid('getcellvalue', selectedEnsayos[i], "especificacion");
                    var idAnalista = $("#listAnalistas").jqxListBox('val');
                    var itemAnalista = $("#listAnalistas").jqxListBox('getItemByValue', idAnalista);
                    var nombreAnalista = itemAnalista.label;
                    //            alert("idMuestraMuestra: "+id
                    //                    +"\nEquipo: "+equipo
                    //                    +"\nTurno: "+turno
                    //                    +"\nFecha Programacion: "+fechaProg
                    //                    +"\nFecha Interno: "+fechaCompInterno
                    //                    +"\nDuracion: "+duracion
                    //                    +"\nObservaciones: "+observaciones
                    //                    +"\nidAnalista: "+idAnalista);

                    programacionPromises[i] = ajaxProgramarEnsayoMuestraAnalista(id, equipo, turno, fechaProg, fechaCompInterno, duracion, observaciones, idAnalista, desEnsayo, nombreAnalista, especificacion);
                }

            }
            $.when(programacionPromises).done(function (data) {
                $('#gridEnsayosProgAnalistas').jqxGrid('updatebounddata');
                $('#gridEnsayosProgAnalistas').jqxGrid('selectallrows');
                var idMuestra = $("#hiddenRealIdMuestraProgAnalistas").val();
                loadGridEnsayosProgramados(idMuestra, idAnalista);
            });


        } else {
            openNotificationProgAnalistas('error', 'No ha seleccionado ningun ensayo para programar');
        }


    });

}

function eventClickButtonOKModalProgAnalistas() {
    $("#buttonOKModalProgAnalistas").click(function () {
        //alert(editrow);
        /*var newEquipo = $("#dropDownListEquiposProgAnalistas").jqxDropDownList('val');
         $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'equipo', newEquipo);*/

        var newTurno = $("#dropDownListTurnosProgAnalistas").jqxDropDownList('val');
        $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'turno', newTurno);

        var newfechaProg = $("#inputDateFechaProgramacionProgAnalistas").jqxDateTimeInput('getDate');
        var ano = newfechaProg.getFullYear();
        var mes = newfechaProg.getMonth() + 1;
        var dia = newfechaProg.getDate()

        newfechaProg = ano + "-" + mes + "-" + dia;
        $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'fechaProg', newfechaProg);

        var newfechaCompInterno = $("#inputDateFechaCompInternoProgAnalistas").jqxDateTimeInput('getDate');
        var anoC = newfechaCompInterno.getFullYear();
        var mesC = newfechaCompInterno.getMonth() + 1;
        var diaC = newfechaCompInterno.getDate()

        newfechaCompInterno = anoC + "-" + mesC + "-" + diaC;
        $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'fechaComInterno', newfechaCompInterno);

        var newDuracion = $("#inputNumberDuracionAnalisisProgAnalistas").jqxNumberInput('val');
        $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'duracion', newDuracion);

        var newObservaciones = $("#editorObservacionesProgAnalistas").jqxEditor('val');
        $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'observaciones', newObservaciones);

        var newEspecificacion = $('#inputEspecificacionProgAnalistas').jqxInput('val');
        $("#gridEnsayosProgAnalistas").jqxGrid('setcellvalue', editrow, 'especificacion', newEspecificacion);

        $("#modalProgramacion").jqxWindow('close');
        $("#editorObservacionesProgAnalistas").jqxEditor('val', '');
    });
}

function eventClickButtonCancelModalProgAnalistas() {
    $("#buttonCancelModalProgAnalistas").click(function () {
        $("#modalProgramacion").jqxWindow('close');
    });
}

function eventClickButtonCancelarMotivo() {
    $("#button_cancelar_motivo").click(function () {
        $("#motivo_input").val(null);
        $("#motivoDesasignacion").modal('hide');
    });
}

function eventClickButtonGuardarMotivo() {
    $("#button_guardar_motivo").click(function () {
        var motivo = $("#motivo_input").val();
        if (motivo === null || motivo === '') {
            openNotificationProgAnalistas('error', 'Debe ingresar un motivo de desasignación.');
        } else {
            ajaxDeleteProgramacionByIdEnsayoMuestra(ensayoDesasignar, motivo);
            $('#gridEnsayosProgAnalistas').jqxGrid('updatebounddata');
            $('#gridEnsayosProgramados').jqxGrid('updatebounddata');
            $('#gridEnsayosProgramados').jqxGrid('addgroup', 'desPaquete');
            $('#gridEnsayosProgramados').jqxGrid('expandallgroups');
            $("#motivo_input").val(null);
            $("#motivoDesasignacion").modal('hide');
            ;
        }
    });
}

function eventClickButtonInformePrevio() {
    $("#buttonInformePrevio").click(function () {
        $("#idPerfilFinal").val(false);
        var idMuestra = $('#hiddenRealIdMuestraProgAnalistas').val();
        $("#idMuestraFinal").val(idMuestra);
        window.open('', 'informeFinal');
        $("#formEnvioFinal").submit();
    });
}

function eventSelectListBoxListaAnalistas() {
    $('#listAnalistas').on('select', function (event) {
        $("#programarButton").jqxButton({disabled: false})
        var args = event.args;
        if (args) {
            var index = args.index;
            var item = args.item;
            var originalEvent = args.originalEvent;
            // get item's label and value.
            var label = item.label;
            var value = item.value;


            //$("#listAnalistas").jqxListBox('clearSelection');

            //var idMuestra = $("#numMuestraProgAnalistas").jqxInput('val');
            var idMuestra = $('#hiddenRealIdMuestraProgAnalistas').val();

        }
        loadGridEnsayosProgramados(idMuestra, value);
    });
}

function eventEliminarProgramacion(idEnsayoMuestra) {
    ensayoDesasignar = idEnsayoMuestra;
    $("#motivoDesasignacion").modal('show');

}

function eventOpenDetalleEnsayoProgramado(idEnsayoMuestra, desEquipo, turno, fechaProg, fechaCompInterno, duracion, observaciones) {

    //$("#equipoAsignadoDetalleEnsayoProgramado").text(desEquipo);
    $("#turnoAsignadoDetalleEnsayoProgramado").text(turno);
    $("#fechaProgDetalleEnsayoProgramado").text(fechaProg);
    $("#fechaCompInternoDetalleEnsayoProgramado").text(fechaCompInterno);
    $("#DuracionDetalleEnsayoProgramado").text(duracion);

    var fechaCompMuestra = $("#fechaCompromisoInputProgAnalistas").jqxDateTimeInput('getDate');
    var formattedDate = $.jqx.dataFormat.formatdate(fechaCompMuestra, 'yyyy-MM-dd');
    $("#fechaCompMuestraDetalleEnsayoProgramado").text(formattedDate);


    $("#observacionesDetalleEnsayoProgramado").html(observaciones);


    $('#windowDetalleEnsayoProgramado').jqxWindow('open');
}

function ajaxGetMuestraReferenciasById(idMuestra) {
    // var url = 'model/DB/jqw/muestraData.php';
    var url = 'index.php';
    $.ajax({
        type: "GET",
        url: url,
        data: 'query=GetMuestraReferenciasById&action=queryDb&idMuestra=' + idMuestra,
        success: function (data) {
            var response = JSON.parse(data);

            if (response[0].response === 1) {
                $('#hiddenRealIdMuestraProgAnalistas').val(response[0].muestra.id);
                if (response[0].muestra.id_estado_muestra == 11) {
                    openNotificationProgAnalistas('error', 'El analisis ' + idMuestra + ' se encuentra anulado');
                } else {
                    $("#numMuestraProgAnalistas").jqxInput({disabled: true});
                    chargeMuestraData(response);
                    $('#buttonInformePrevio').prop('disabled', false);

                    if (response[0].muestra.id_estado_muestra != 1 && response[0].muestra.id_estado_muestra != 2) {
                        var detalleMuestra = 'Muestra en estado: ' + response[0].muestra.estado + '\n';
                        ajaxConsultarAnalistasProgramadosMuestra(response[0].muestra.id).then(function (otro) {
                            $("#dataTableAnalistas").show();
                            var jsonResponse = JSON.parse(otro);
                            if (jsonResponse.code == '00000') {
                                var source = {
                                    dataType: 'json',
                                    localData: jsonResponse.data,
                                    dataFields:
                                        [
                                            {name: 'nombre', type: 'string'},
                                            {name: 'fecha_programacion', type: 'string'}
                                        ]
                                };
                                var dataAdapter = new $.jqx.dataAdapter(source);
                                $("#dataTableAnalistas").jqxDataTable(
                                    {
                                        source: dataAdapter,
                                        columns: [
                                            {text: 'Analista', dataField: 'nombre', width: '60%'},
                                            {text: 'Fecha programación', dataField: 'fecha_programacion', width: '40%'}
                                        ],
                                        width: "100%"
                                    });
                                $('#informacionMuestraDiv').text(detalleMuestra);
                            }
                        })

                    }

                    if (response[0].muestra.id_area_analisis != 4) {
                        loadEnsayosGridbyIdMuestra(response[0].muestra.id);
                    } else {
                        loadEnsayosGridbyIdMuestraEst(response[0].muestra.id);
                    }
                }
            } else {
                openNotificationProgAnalistas('error', 'fallo la consulta de la muestra ' + idMuestra);
                //alert("fallo");
            }


        }
    });

}

function ajaxConsultarAnalistasProgramadosMuestra(idMuestra) {
    var url = 'index.php';
    var data = 'query=consultarAnalistasProgramadosMuestra&action=queryDb&idMuestra=' + idMuestra;

    return $.ajax({
        type: "GET",
        url: url,
        data: data
    });
}

function chargeMuestraData(response) {

    $("#clienteInput").val(response[0].muestra.nombre_tercero);
    $("#productoInput").val(response[0].muestra.nombre_producto);
    $("#areaAnalisisInput").val(response[0].muestra.des_area_analisis);
    var t = response[0].muestra.fecha_compromiso.split(/[- :]/);
    $("#fechaCompromisoInputProgAnalistas").jqxDateTimeInput('setDate', new Date(t[0], t[1] - 1, t[2], t[3], t[4], t[5]));

}

function openNotificationProgAnalistas(template, message) {
    $("#messageNotificationProgAnalistas").text(message);
    $("#notificationProgAnalistas").jqxNotification({template: template});
    $("#notificationProgAnalistas").jqxNotification("open");
}

function ajaxProgramarEnsayoMuestraAnalista(idEnsayoMuestra, equipo, turno, fechaProg, fechaCompInterno, duracion, observaciones, idAnalista, desEnsayo, nombreAnalista, especificacion) {
    var url = 'index.php';
    var data = {
        action: 'programarEnsayoAnalista',
        idEnsayoMuestra: idEnsayoMuestra,
        equipo: equipo,
        turno: turno,
        fechaProg: fechaProg,
        fechaCompInterno: fechaCompInterno,
        duracion: duracion,
        observaciones: observaciones,
        idAnalista: idAnalista,
        especificacion: especificacion
    };

    return $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.result === '1') {

                openNotificationProgAnalistas('success', 'Se programa exitosamente el ensayo: ' + desEnsayo + ' al analista: ' + nombreAnalista);
            } else {
                openNotificationProgAnalistas('error', 'fallo la asignacion del ensayo: ' + desEnsayo + ' para el analista: ' + nombreAnalista);
            }
        }
    });
}

function ajaxDeleteProgramacionByIdEnsayoMuestra(idEnsayoMuestra, motivo) {
    var url = 'index.php';
    var data = 'action=deleteProgramacionByIdEnsayoMuestra';
    data = data + '&idEnsayoMuestra=' + idEnsayoMuestra + '&motivo=' + motivo;

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.result === '1') {

                openNotificationProgAnalistas('success', 'Se elimino la programacion del ensayo');
            } else {
                openNotificationProgAnalistas('error', 'fallo al eliminar la progracion del ensayo');
            }
        }
    });
}
