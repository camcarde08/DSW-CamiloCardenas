function initLoadBeCoordinador(idPerfil, idUsuario) {

    switch (idPerfil) {
        case 2:
            var idAreaAnalisis = 1;
            break;
        case 3:
            var idAreaAnalisis = 4;
            break;
        case 4:
            var idAreaAnalisis = 2;
            break;
        case 5:
            var idAreaAnalisis = 4;
            break;
    }
    loadGridPrincipalBeCoordinador(idAreaAnalisis);
}

function loadGridPrincipalBeCoordinador(idAreaAnalisis) {
    if (idAreaAnalisis != 4) {
        //var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getEnsayosWithOutProgramacionByidAreaAnalisis&idAreaAnalisis=' + idAreaAnalisis;
        var url = 'index.php?action=queryDb&query=getEnsayosWithOutProgramacionByidAreaAnalisis&idAreaAnalisis=' + idAreaAnalisis;
        var source =
                {
                    datatype:
                            "json",
                    datafields: [
                        {name: 'customId', type: 'string'},
                        {name: 'idMuestra', type: 'string'},
                        {name: 'estadoMuestra', type: 'string'},
                        {name: 'fechaLlegada', type: 'string'},
                        {name: 'nombreTercero', type: 'string'},
                        {name: 'producto', type: 'string', hidden: true},
                        {name: 'lote', type: 'string'}
                    ],
                    url: url,
                    async: false
                };

        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#gridPrincipalBeCoordinador").jqxGrid(
                {
                    width: '100%',
                    height: '95%',
                    filterable: true,
                    showfilterrow: true,
                    source: dataAdapter,
                    columns: [
                        {text: 'Link',
                            cellsrenderer: function (row) {
                                return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleCoordinador(' + row + ')"/>';
                            }, datafield: '', width: 50
                        },
                        {text: 'Muestra', datafield: 'customId', width: 150},
                        {text: 'Muestra', datafield: 'idMuestra', width: 10, hidden: true},
                        //Se ocultan columnas para rol de coordinador
                        {text: 'Cliente', datafield: 'nombreTercero', width: 300, hidden: true},
                        {text: 'Producto', datafield: 'producto', width: 270, hidden: true},
                        {text: 'Lote', datafield: 'lote', width: 300},
                        {text: 'F. Llegada', datafield: 'fechaLlegada', width: 150},
                        {text: 'Estado Muestra', datafield: 'estadoMuestra', width: 200}
                    ]
                });
    } else {
        var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getBECordEst';
        var source =
                {
                    datatype:
                            "json",
                    datafields: [
                        {name: 'idMuestra', type: 'int'},
                        {name: 'producto', type: 'string'},
                        {name: 'tiempo', type: 'string'},
                        {name: 'temperatura', type: 'string'},
                        {name: 'lote', type: 'string'},
                        {name: 'fecha', type: 'string'}
                    ],
                    url: url,
                    async: false
                };

        var dataAdapter = new $.jqx.dataAdapter(source);
        $("#gridPrincipalBeCoordinador").jqxGrid(
                {
                    width: '100%',
                    height: '95%',
                    filterable: true,
                    showfilterrow: true,
                    source: dataAdapter,
                    columns: [
                        {text: 'Link',
                            cellsrenderer: function (row) {
                                return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleCoordinador(' + row + ')"/>';
                            }, datafield: '', width: 50
                        },
                        {text: 'Muestra', datafield: 'idMuestra', width: 150},
                        //Se oculta columna para rol de coordinador
                        {text: 'Producto', datafield: 'producto', width: 260, hidden: true},
                        {text: 'Tiempo', datafield: 'tiempo', width: 200},
                        {text: 'Temperatura', datafield: 'temperatura', width: 200},
                        {text: 'Lote', datafield: 'lote', width: 300},
                        {text: 'Fecha Programada', datafield: 'fecha', width: 200}
                    ]
                });
    }

}

function eventClickImageDetalleCoordinador(row) {
    var data = $('#gridPrincipalBeCoordinador').jqxGrid('getrowdata', row);
    window.location.href = 'index.php?action=programacionAnalistas&idMuestra=' + data.customId;
}


