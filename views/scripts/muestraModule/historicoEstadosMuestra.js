function initialLoadHistoricoEstadosMuestra(idPerfil, idUsuario) {
//load widgets
    loadButtonClearHistoricoEstadosMuestra();
    loadInputNumMuestraHistoricoEstadosMuestra();
    // load events
    eventClickButtonSearchNumMuestraHistoricoEstadosMuestra();
    eventClickButtonLimpiarHistoricoEstadosMuestra();
    // general
    ifComeFromMuestra();
    loadButtonImprimirMuestra(idPerfil); //JP
    eventClickButtonMuestraInformePrint(); //JP
}

function loadButtonClearHistoricoEstadosMuestra() {
    $("#buttonClearHistoricoEstadosMuestra").jqxButton({width: '70'});
}

function loadGridHistoricoEstadosMuestra(idMuestra) {
    var url = "index.php?action=queryDb&query=getHistoricostadoMuestra&idMuestra=" + idMuestra;
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'idMuestra'},
                    {name: 'fecha', type: 'date'},
                    {name: 'idEstado'},
                    {name: 'idUsuario'},
                    {name: 'desEstado'},
                    {name: 'nombreUsuario'},
                    {name: 'observaciones'},
                    {name: 'nombreProducto'}
                ],
                async: false,
                id: 'id',
                url: url
            };
    var dataAdapter = new $.jqx.dataAdapter(source,
            {
                beforeLoadComplete: function (records) {
                    $("#nombreProducto").text(records[0].nombreProducto);
                }
            });
    $("#gridHistoricoEstadosMuestra").jqxGrid(
            {
                width: 560,
                source: dataAdapter,
                columnsresize: true,
                autoheight: true,
                autorowheight: true,
                columns: [
                    {text: 'Fecha Actualización', dataField: 'fecha', cellsformat: 'dd-MM-yyyy HH:mm:ss', width: 180},
                    {text: 'Estado', dataField: 'desEstado', width: 200},
                    {text: 'Usuario', dataField: 'nombreUsuario', width: 180},
                    {text: 'Observaciones', dataField: 'observaciones', width: 300, hidden: true}
                ]
            });
}

function loadInputNumMuestraHistoricoEstadosMuestra() {
    $("#inputNumMuestraHistoricoEstadosMuestra").jqxInput({placeHolder: "Número a Consultar", height: 20, width: 200, minLength: 1});
}

function eventClickButtonSearchNumMuestraHistoricoEstadosMuestra() {

    $("#buttonSearchNumMuestraHistoricoEstadosMuestra").on("click", function () {

        var idMuestra = $("#inputNumMuestraHistoricoEstadosMuestra").val();
        loadGridHistoricoEstadosMuestra(idMuestra);
        var promiseSubMuestra = ajaxLoadGridHistoricoEstadosSubMuestra(idMuestra);
        promiseSubMuestra.success(function (data) {
            var response = JSON.parse(data);
            if (response.result === 0) {
                $("#divEstadosSubMuestra").css('display', 'block');
                loadGridHistoricoSubMuestra(response.historicos);
            }
        });
    });
}

function eventClickButtonLimpiarHistoricoEstadosMuestra() {

    $("#buttonClearHistoricoEstadosMuestra").on("click", function () {

//$("#inputNumMuestraHistoricoEstadosMuestra").val('');
        $("#gridHistoricoEstadosMuestra").jqxGrid('clear');
        $("#gridHistoricoEstadosSubMuestra").jqxGrid('clear');
        $("#divEstadosSubMuestra").css('display', 'none');
        $("#nombreProducto").text("");
    });
}

function loadGridHistoricoSubMuestra(historico) {
    var source =
            {
                datatype: "array",
                datafields: [
                    {name: 'id'},
                    {name: 'duracion'},
                    {name: 'estado'},
                    {name: 'fecha'},
                    {name: 'usuario'}

                ],
                localdata: historico,
                id: 'id'
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#gridHistoricoEstadosSubMuestra").jqxGrid(
            {
                width: 770,
                source: dataAdapter,
                columnsresize: true,
                autoheight: true,
                autorowheight: true,
                groupable: true,
                showgroupsheader: false,
                columns: [
                    {text: 'Sub Muestra', dataField: 'duracion', width: 180},
                    {text: 'Fecha Actualización', dataField: 'fecha', width: 180},
                    {text: 'Estado', dataField: 'estado', width: 200},
                    {text: 'Usuario', dataField: 'usuario', width: 180}
                ],
                groups: ['duracion']
            });
}



function ifComeFromMuestra() {
    var idMuestra = $("#inputNumMuestraHistoricoEstadosMuestra").val();
    if (idMuestra !== '') {
        loadGridHistoricoEstadosMuestra(idMuestra);
    }
}


function loadButtonImprimirMuestra(idPerfil) {
    if (idPerfil == 9) {
        $('#buttonImprimirInformeMuestra').jqxButton({disabled: false});
    } else {
        $('#buttonImprimirInformeMuestra').jqxButton({disabled: true});
    }

}
function eventClickButtonMuestraInformePrint() { //Nuevo JP
    $("#buttonImprimirInformeMuestra").click(function () {
        var idMuestra = $("#inputNumMuestraHistoricoEstadosMuestra").val();
        eventClickImageDetalleGerente(idMuestra, '8');
    });
}
function eventClickImageDetalleGerente(idMuestra, idPer) { //Nuevo JP
    $("#idMuestraHiden").val(idMuestra);
    $("#idPerfilHiden").val(idPer);
    window.open('', 'view');
    $("#formEnvio").submit();
}

function  ajaxLoadGridHistoricoEstadosSubMuestra(idMuestra) {
    var url = "index.php";
    var data = "action=getHistoricoEstadosSubmuestra";
    data = data + "&idMuestra=" + idMuestra;
    return $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false
    });
}