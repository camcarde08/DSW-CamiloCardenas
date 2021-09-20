function initLoadBeAnalista(idPerfil, idUsuario) {

    loadGridPrincipalBeAnalista(idUsuario);
    loadButtonExportData();
    eventClickLoadButtonExportData();
}

function ajaxExportData(data) {
    var url = "index.php";
    //var data = JSON.stringify(data);
    var data = {
        action: "exportData",
        data: data
    };
    var data = $.param(data);

    return $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false
    });
}

function loadButtonExportData() {
    $("#loadButtonExportData").jqxButton({width: 120, height: 25});
}

function eventClickLoadButtonExportData() {
    $("#loadButtonExportData").on('click', function () {

        //var rows = $('#gridPrincipalBeAnalista').jqxGrid('getrows');
        var rows = $("#gridPrincipalBeAnalista").jqxGrid('exportdata', 'json');

        var prom = ajaxExportData(rows);
        prom.then(function (data) {
            var response = JSON.parse(data);
            window.open(response.fileName);
        });
    });
}

function loadGridPrincipalBeAnalista(idAnalista) {
    var url = 'index.php?action=queryDb&query=getBeAnalistaByIdAnalista&idAnalista=' + idAnalista;

    var source =
            {
                datatype:
                        "json",
                datafields: [
                    {name: 'customId', type: 'string'},
                    {name: 'muestra', type: 'string'},
                    {name: 'idPaquete', type: 'string'},
                    {name: 'desPaquete', type: 'string'},
                    {name: 'idEnsayo', type: 'string'},
                    {name: 'desEnsayo', type: 'string'},
                    {name: 'desEspecifica', type: 'string'},
                    {name: 'fechaProgramada', type: 'string'},
                    {name: 'fechaCompInternoEnsayo', type: 'string'},
                    {name: 'idTercero', type: 'string'},
                    {name: 'nomTercero', type: 'string'},
                    {name: 'desAreaAnalisis', type: 'string'},
                    {name: 'tipoEstabilidad', type: 'string'},
                    {name: 'idEquipo', type: 'string'},
                    {name: 'desEquipo', type: 'string'},
                    {name: 'turno', type: 'string'},
                    {name: 'duracion', type: 'string'},
                    {name: 'observaciones', type: 'string'},
                    {name: 'especificacionEnsayoMuestra', type: 'string'},
                    {name: 'nombreProducto', type: 'string'},
                    {name: 'numeroLote', type: 'string'}
                ],
                url: url,
                async: false
            };
    var cellclass = function (row, columnfield, value) {
        if (value != "") {
            var dateArray = value.split("/");
            var dateCompromiso = new Date(dateArray[2], (dateArray[1] - 1), dateArray[0]);

            var today = new Date();
            var diaAlerta = today.getDate() + 3;
            var limiteAlerta = new Date(today.getFullYear(), today.getMonth(), diaAlerta);

            if (today > dateCompromiso) {
                return 'red';
            } else if (limiteAlerta >= dateCompromiso) {
                return 'yellow';
            }

        }

    }
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#gridPrincipalBeAnalista").jqxGrid(
            {
                width: '100%',
                height: '100%',
                source: dataAdapter,
                groupable: true,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                showgroupmenuitems: false,
                filterable: true,
                showfilterrow: true,
                columns: [
                    {text: 'Link',
                        cellsrenderer: function (row) {
                            return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleAnalista(' + row + ')"/>';
                        }, datafield: '', width: 50
                    },
                    {text: 'Muestrax', datafield: 'customId', width: 100},
                    {text: 'Muestra', datafield: 'muestra', width: 100, hidden: true},
                    {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true},
                    {text: 'Paquete', datafield: 'desPaquete', width: 250, hidden: true},
                    {text: 'idEnsayo', datafield: 'idEnsayo', width: 250, hidden: true},
                    {text: 'Ensayo', datafield: 'desEspecifica', width: 410},
                    {text: 'Fecha Programacion', datafield: 'fechaProgramada', width: 150},
                    {text: 'Fecha Compromiso', datafield: 'fechaCompInternoEnsayo', width: 150, cellclassname: cellclass},
                    {text: 'idTercero', datafield: 'idTercero', width: 250, hidden: true},
                    //Se oculta columna para rol de analista
                    {text: 'Cliente', datafield: 'nomTercero', width: 150, hidden: true},
                    {text: 'Area', datafield: 'desAreaAnalisis', width: 130},
                    {text: 'T. Estabilidad', datafield: 'tipoEstabilidad', width: 150},
                    {text: 'idEquipo', datafield: 'idEquipo', width: 250, hidden: true},
                    {text: 'Equipo', datafield: 'desEquipo', width: 100},
                    {text: 'Turno', datafield: 'turno', width: 100},
                    {text: 'Duración', datafield: 'duracion', width: 70},
                    {text: 'Observaciones', datafield: 'observaciones', width: 250},
                    {text: 'especificacion', datafield: 'especificacionEnsayoMuestra', width: 200},
                    //Se oculta columna para rol de analista
                    {text: 'producto', datafield: 'nombreProducto', width: 250, hidden: true},
                    {text: 'lote', datafield: 'numeroLote', width: 100},
                ],
                groups: ['customId', 'desPaquete']
            });
}

function eventClickImageDetalleAnalista(row) {
    var data = $('#gridPrincipalBeAnalista').jqxGrid('getrowdata', row);
    window.location.href = 'index.php?action=ConsultaHojaRutaMuestra&idMuestra=' + data.customId;
}


