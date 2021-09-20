var meses;
var idTipoAlmacen = 0;
function initialLoadAlmacenMuestra() {
    //load widgets
    loadNumMuestraAlamacenInput();
    loadLimpiarButton();
    loadAreaAnalisisAlmacen();
    loadWindowNewAlmacenamiento();
    loadNumericInputTiempoNewAlmacenamiento();
    loadDropDownListTipoAlmacenMuestra();
    loadDateInputFechaAlmacenMuestra();
    loadDateInputFechaAlmacenSalida();
    loadNumericInputPesoAproximado();
    //loadDropDownListLugarAlmacenMuestra();
    loadNumericInputNivelAlmacenMuestra();
    loadNumericInputLugarAlmacenMuestra();
    loadNumericInputCajaAlmacenMuestra();
    loadButtonGuardarAlmacenMuestra();
    loadButtonCancelarAlmacenMuestra();
    loadNotificationAlmacenMuestra();
    clickEventSearchNumMuestraAlamcenInput();
    clickEventLimpiarButton();
    clickEventbuttonGuaradarAlmacenMuestra();
    eventOpenWindowNewAlamacenamiento();
    // general
    ifComeFromMuestraAlmacen();
}

function loadNumMuestraAlamacenInput() {
    $("#numMuestraAlmacen").jqxInput({placeHolder: "Número a Consultar", height: 20, width: 200, minLength: 1});

}

function loadLimpiarButton() {
    $("#clearButton").jqxButton({width: '70'});

}

function clickEventSearchNumMuestraAlamcenInput() {
    $("#searchNumMuestra").click(function () {
        var value = $("#numMuestraAlmacen").val();
        //alert("Searching for: " + value);
        chargeAlmacenamientoByIdMuestra(value);
    });
}

function clickEventLimpiarButton() {
    $("#clearButton").on('click', function () {
        $("#numMuestraAlmacen").jqxInput({disabled: false});
        $("#numMuestraAlmacen").val('');
        $("#areaAnalisisAlmacen").val('');
        $('#almacenamientosGrid').jqxGrid('clear');
    });
}

function loadAreaAnalisisAlmacen() {
    $("#areaAnalisisAlmacen").jqxInput({height: 20, width: 200, minLength: 1, disabled: true});
}

function loadGridAlamcenamiento(muestraData) {

    var source =
            {
                localdata: muestraData.almacenamiento,
                datatype: "array",
                datafields: [
                    {name: 'tiempo'},
                    {name: 'desTipoAlmacen'},
                    {name: 'fecha', type: 'date'},
                    {name: 'id_ubicacion'},
                    {name: 'nivel'},
                    {name: 'caja'},
                    {name: 'peso_aproximado'},
                    {name: 'fecha_salida', type: 'date'},
                    {name: 'id'},
                    {name: 'observaciones'}
                ],
                id: 'id',
                updaterow: function (rowid, rowdata, commit) {
                    if (idTipoAlmacen !== 0) {
                        rowdata.idTipoAlmacenamiento = idTipoAlmacen;
                    }
                    ajaxUpdateAlmacenamiento(rowdata);
                    commit(true);
                }
            };

    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#almacenamientosGrid").jqxGrid(
            {
                width: 990,
                height: 200,
                editable: true,
                source: dataAdapter,
                showstatusbar: true,
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

                    // add new row.
                    addButton.click(function (event) {
                        $("#windowNewAlmacenamiento").jqxWindow("open");
                    });
                    deleteButton.click(function (event) {
                        var currentIndex = $('#almacenamientosGrid').jqxGrid('getselectedrowindex');
                        var currentId = $('#almacenamientosGrid').jqxGrid('getrowid', currentIndex);
                        ajaxDeleteAlamacenamiento(currentId);
                        $('#almacenamientosGrid').jqxGrid('deleterow', currentId);
                    });
                },
                columns: [
                    //{ text: 'Tiempo', datafield: 'tiempo', width: 70, align: 'center', cellsalign:'center' },
                    {text: 'Tipo de almacenamiento', datafield: 'desTipoAlmacen', width: 200, align: 'center', cellsalign: 'center', columntype: "dropdownlist",
                        initeditor: function (row, cellvalue, editor) {
                            var source = getDropDownListTipoAlmacenMuestra();
                            var dataAdapter = new $.jqx.dataAdapter(source);
                            editor.jqxDropDownList({source: dataAdapter, displayMember: "descripcion", valueMember: "id"});
                        },
                        createeditor: function (row, column, editor) {
                            editor.bind("select", function (event) {
                                idTipoAlmacen = event.args.item.value;
                            });
                        }
                    },
                    {text: 'Fecha de almacenamiento', datafield: 'fecha', width: 200, align: 'center', cellsalign: 'center', columntype: 'datetimeinput', cellsformat: 'yyyy-MM-dd'},
                    {text: 'Estante', datafield: 'id_ubicacion', width: 90, align: 'center', cellsalign: 'center', columntype: 'numberinput',
                        initeditor: function (row, cellvalue, editor) {
                            editor.jqxNumberInput({decimalDigits: 0});
                        }
                    },
                    {text: 'Bandeja', datafield: 'nivel', width: 90, align: 'center', cellsalign: 'center', columntype: 'numberinput',
                        initeditor: function (row, cellvalue, editor) {
                            editor.jqxNumberInput({decimalDigits: 0});
                        }
                    },
                    {text: 'Caja', datafield: 'caja', width: 90, align: 'center', cellsalign: 'center', columntype: 'numberinput',
                        initeditor: function (row, cellvalue, editor) {
                            editor.jqxNumberInput({decimalDigits: 0});
                        }
                    },
                    {text: 'Peso aproximado', datafield: 'peso_aproximado', width: 120, align: 'center', cellsalign: 'center', columntype: 'numberinput',
                        initeditor: function (row, cellvalue, editor) {
                            editor.jqxNumberInput({decimalDigits: 2});
                        }
                    },
                    {text: 'Fecha salida', datafield: 'fecha_salida', width: 200, align: 'center', cellsalign: 'center', columntype: 'datetimeinput', cellsformat: 'yyyy-MM-dd'},
                    {text: 'Observaciones', datafield: 'observaciones', width: 200, align: 'center', cellsalign: 'center'}
                ]
            });
}



function loadNotificationAlmacenMuestra() {
    $("#notificationAlmacenMuestra").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function openNotificationAlmacenMuestra(template, message) {
    $("#messageNotificationAlmacenMuestra").text(message);
    $("#notificationAlmacenMuestra").jqxNotification({template: template});
    $("#notificationAlmacenMuestra").jqxNotification("open");
}

function ifComeFromMuestraAlmacen() {
    var muestra = $("#numMuestraAlmacen").val();
    if (muestra !== '') {
        chargeAlmacenamientoByIdMuestra(muestra);
    }
}



function chargeAlmacenamientoByIdMuestra(idMuestra) {
    $("#numMuestraAlmacen").jqxInput({disabled: true});
    var promiseMuestraData = ajaxGetMuestraData(idMuestra);
    promiseMuestraData.then(function (data) {
        var response = JSON.parse(data);
        if (response[0].code == '00000') {
            currentMuestraData = response[0].data.muestra
            $("#areaAnalisisAlmacen").val(response[0].data.muestra.des_area_analisis);
            loadGridAlamcenamiento(currentMuestraData);
        } else {
            openNotificationAlmacenMuestra('error', 'El analisis consultado se encuentra anulado');

        }
    });


}

function loadWindowNewAlmacenamiento() {
    $('#windowNewAlmacenamiento').jqxWindow({
        height: 320, width: 550, isModal: true, autoOpen: false,
        okButton: $('#buttonGuaradarAlmacenMuestra'),
        cancelButton: $('#buttonCancelarAlmacenMuestra')
    });

}

function eventOpenWindowNewAlamacenamiento() {
    $('#windowNewAlmacenamiento').on('open', function (event) {
        $("#windowNewAlmacenamiento").jqxWindow("setTitle", "Nuevo Almacenamiento para la Muestra " + $("#numMuestraAlmacen").val());
    });
}

function loadNumericInputTiempoNewAlmacenamiento() {
    $("#numericInputTiempoNewAlmacenamiento").jqxNumberInput({
        width: '100px', height: '20px', spinButtons: true, min: 0, spinButtonsStep: 1,
        decimalDigits: 0, digits: 2
    })
    $("#numericInputTiempoNewAlmacenamiento").val('0');
}

function loadDropDownListTipoAlmacenMuestra() {


    var source = getDropDownListTipoAlmacenMuestra();
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#dropDownListTipoAlmacenMuestra").jqxDropDownList({
        selectedIndex: 0, source: dataAdapter, displayMember: "descripcion", valueMember: "id", width: 140, height: 20
    });

}

function getDropDownListTipoAlmacenMuestra() {
    var url = "model/DB/jqw/tipoAlmacenamientoData.php?query=getAllTipoAlamacenamiento";

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'descripcion'}
                ],
                url: url,
                async: false
            };
    return source;

}

function loadDateInputFechaAlmacenMuestra() {
    $("#dateInputFechaAlmacenMuestra").jqxDateTimeInput({width: '140px', height: '20px'});

    $("#dateInputFechaAlmacenMuestra").on("change", function (event) {
        var fechaAlmacen = new Date(event.args.date);
        var fechaSalida = calcularFechaSalida(fechaAlmacen, meses);
        $("#dateInputFechaAlmacenSalida").val(fechaSalida);
    });
}

function calcularFechaSalida(fechaOrigen, mes) {
    console.log(mes);
    fechaOrigen.setMonth(fechaOrigen.getMonth() + mes);
    return fechaOrigen;
}

function loadDateInputFechaAlmacenSalida() {
    var fechaSalida = new Date();
    var mesesPromise = ajaxGetMesesSalida();
    mesesPromise.then(function (data) {
        var response = JSON.parse(data);
        if (response.code == '00000') {
            meses = parseInt(response.data.valor);
            fechaSalida = calcularFechaSalida(fechaSalida, meses);
        } else {
            openNotificationAlmacenMuestra('error', 'No se puede consultar los meses');

        }
    });

    //fechaSalida.setMonth(fechaSalida.getMonth() + )
    $("#dateInputFechaAlmacenSalida").jqxDateTimeInput({width: '140px', height: '20px'});
    $("#dateInputFechaAlmacenSalida").val(fechaSalida);
}

function loadDropDownListLugarAlmacenMuestra() {

    var url = "model/DB/jqw/ubicacionData.php?query=getAllUbicacion";

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'descripcion'}
                ],
                url: url,
                async: false,
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#dropDownListLugarAlmacenMuestra").jqxDropDownList({
        selectedIndex: 0, source: dataAdapter, displayMember: "descripcion", valueMember: "id", width: 140, height: 20
    });
}

function loadNumericInputNivelAlmacenMuestra() {
    $("#numericInputNivelAlmacenMuestra").jqxNumberInput({
        width: '140px', height: '20px', spinButtons: true, min: 1, spinButtonsStep: 1,
        decimalDigits: 0, digits: 3
    })
    $("#numericInputNivelAlmacenMuestra").val('1');
}

function loadNumericInputPesoAproximado() {
    $("#numericInputPesoAproximado").jqxNumberInput({
        width: '140px', height: '20px', spinButtons: true, min: 1, spinButtonsStep: 1,
        decimalDigits: 2, digits: 3
    })
    $("#numericInputPesoAproximado").val('1');
}

function loadNumericInputLugarAlmacenMuestra() {
    $("#numericInputLugarAlmacenMuestra").jqxNumberInput({
        width: '140px', height: '20px', spinButtons: true, min: 1, spinButtonsStep: 1,
        decimalDigits: 0, digits: 3
    })
    $("#numericInputLugarAlmacenMuestra").val('1');
}

function loadNumericInputCajaAlmacenMuestra() {
    $("#numericInputCajaAlmacenMuestra").jqxNumberInput({
        width: '140px', height: '20px', spinButtons: true, min: 1, spinButtonsStep: 1,
        decimalDigits: 0, digits: 3
    })
    $("#numericInputCajaAlmacenMuestra").val('1');
}

function loadButtonGuardarAlmacenMuestra() {
    $("#buttonGuaradarAlmacenMuestra").jqxButton({width: '70'});
}

function loadButtonCancelarAlmacenMuestra() {
    $("#buttonCancelarAlmacenMuestra").jqxButton({width: '70'});
}


function clickEventbuttonGuaradarAlmacenMuestra() {
    $("#buttonGuaradarAlmacenMuestra").on("click", function () {

        var fecha = new Date();
        fecha = $("#dateInputFechaAlmacenMuestra").jqxDateTimeInput("getDate");
        var yearAux = fecha.getFullYear();
        var monthAux = parseInt(fecha.getMonth()) + 1;
        var dayAux = fecha.getDate();
        var fechaAux = yearAux + "-" + monthAux + "-" + dayAux;

        var fechaSalida = new Date();
        fechaSalida = $("#dateInputFechaAlmacenSalida").jqxDateTimeInput("getDate");
        var yearAux2 = fechaSalida.getFullYear();
        var monthAux2 = parseInt(fechaSalida.getMonth()) + 1;
        var dayAux2 = fechaSalida.getDate();
        var fechaAux2 = yearAux2 + "-" + monthAux2 + "-" + dayAux2;

        //var idUbicacion = $("#dropDownListLugarAlmacenMuestra").val();
        var ubicacion = $("#numericInputLugarAlmacenMuestra").val();
        var idTipoAlmacenamiento = $("#dropDownListTipoAlmacenMuestra").val();
        var nivel = $("#numericInputNivelAlmacenMuestra").val();
        var peso = $("#numericInputPesoAproximado").val();
        var caja = $("#numericInputCajaAlmacenMuestra").val();
        var tiempo = $("#numericInputTiempoNewAlmacenamiento").val();
        var observaciones = $("#textInputObservaciones").val();
        $('#almacenamientosGrid').jqxGrid('showloadelement');
        ajaxInsertNewAlamcenamiento(currentMuestraData.id, fechaAux, ubicacion, idTipoAlmacenamiento, nivel, caja, tiempo, fechaAux2, peso, observaciones);
    });
}

function ajaxInsertNewAlamcenamiento(idMuestra, fecha, idUbicacion, idTipoAlmacenamiento, nivel, caja, tiempo, fechaSalida, peso, observaciones) {
    var url = "index.php";
    var data = "action=saveAlmacenamiento";
    data = data + "&idMuestra=" + idMuestra;
    data = data + "&fecha=" + fecha;
    data = data + "&idUbicacion=" + idUbicacion;
    data = data + "&idTipoAlmacenamiento=" + idTipoAlmacenamiento;
    data = data + "&nivel=" + nivel;
    data = data + "&caja=" + caja;
    data = data + "&tiempo=" + tiempo;
    data = data + "&fechaSalida=" + fechaSalida;
    data = data + "&peso=" + peso;
    data = data + "&observaciones=" + observaciones;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.result === '1') {
                var value = $("#numMuestraAlmacen").val();
                //alert("Searching for: " + value);
                chargeAlmacenamientoByIdMuestra(value);
                $('#almacenamientosGrid').jqxGrid('hideloadelement');
            } else {
                //openNotificationProgAnalistas('error', 'fallo al eliminar la progracion del ensayo');
            }
        }
    });
}

function ajaxUpdateAlmacenamiento(dataAlmacenamiento) {
    var url = "index.php";
    var fechaObj = new Date(dataAlmacenamiento.fecha);
    var fecha = fechaObj.getFullYear() + '-' + ('0' + (fechaObj.getMonth() + 1)).slice(-2) + '-' + ('0' + fechaObj.getDate()).slice(-2) + ' '
            + ('0' + fechaObj.getHours()).slice(-2) + ':' + ('0' + fechaObj.getMinutes()).slice(-2) + ':' + ('0' + fechaObj.getSeconds()).slice(-2);
    var fechaSalidaObj = new Date(dataAlmacenamiento.fecha_salida);
    var fechaSalida = fechaSalidaObj.getFullYear() + '-' + ('0' + (fechaSalidaObj.getMonth() + 1)).slice(-2) + '-' + ('0' + fechaSalidaObj.getDate()).slice(-2) + ' '
            + ('0' + fechaSalidaObj.getHours()).slice(-2) + ':' + ('0' + fechaSalidaObj.getMinutes()).slice(-2) + ':' + ('0' + fechaSalidaObj.getSeconds()).slice(-2);
    var data = "action=queryDb&query=updateAlmacenamiento";
    data = data + "&idMuestra=" + currentMuestraData.id;
    data = data + "&fecha=" + fecha;
    data = data + "&idUbicacion=" + dataAlmacenamiento.id_ubicacion;
    data = data + "&idTipoAlmacenamiento=" + dataAlmacenamiento.idTipoAlmacenamiento;
    data = data + "&nivel=" + dataAlmacenamiento.nivel;
    data = data + "&caja=" + dataAlmacenamiento.caja;
    data = data + "&tiempo=" + dataAlmacenamiento.tiempo;
    data = data + "&fechaSalida=" + fechaSalida;
    data = data + "&peso=" + dataAlmacenamiento.peso_aproximado;
    data = data + "&observaciones=" + dataAlmacenamiento.observaciones;
    data = data + "&id=" + dataAlmacenamiento.id;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data) {
            var response = JSON.parse(data);
            console.log(response);
        }
    });
}

function ajaxDeleteAlamacenamiento(idAlmacenamiento) {
    var url = "index.php";
    var data = "action=deleteAlmacenamiento";
    data = data + "&idAlmacenamiento=" + idAlmacenamiento;

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data) {
            var response = JSON.parse(data);
            if (response.result === '1') {
                $('#almacenamientosGrid').jqxGrid('updatebounddata');
            } else {
                //openNotificationProgAnalistas('error', 'fallo al eliminar la progracion del ensayo');
            }
        }
    });
}

function ajaxGetMesesSalida() {

    return $.ajax({
        type: "GET",
        url: 'index.php',
        data: {
            action: 'queryDb',
            query: 'getMesesSalida'
        },
        async: false
    });
}

function ajaxGetMuestraData(idMuestra) {

    return $.ajax({
        type: "GET",
        url: 'index.php',
        data: {
            action: 'queryDb',
            query: 'GetMuestraReferenciasDetalleById',
            idMuestra: idMuestra
        },
        async: false
    });
}