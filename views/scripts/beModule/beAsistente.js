function initLoadBeAsistente(idPerfil, idUsuario) {
    loadGridPrincipalBeAsistente(idPerfil);

}

function loadGridPrincipalBeAsistente(idPerfil) {
     idPer = idPerfil;
    var url = 'index.php?action=queryDb&query=getMuestrasBandejaAsistente';
    var source =
        {
            datatype:
            "json",
            datafields: [
                { name: 'customId', type: 'string' },
                { name: 'idMuestra', type: 'string' },
                { name: 'cantidadTotal', type: 'string' },
                { name: 'cantidadAprobado', type: 'string' },
                { name: 'cantidadNoAprobado', type: 'string' },
                { name: 'porcentajeAprobacion', type: 'string' },
                { name: 'idProducto', type: 'string' },
                { name: 'nomProducto', type: 'string' },
                { name: 'idTercero', type: 'string' },
                { name: 'nomTercero', type: 'string' },
                { name: 'lote', type: 'string' },
                { name: 'estado', type: 'string' },
                { name: 'idEestado', type: 'int' }
            ],
            url: url,
            async: false
        };

    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#gridPrincipalBeAsistente").jqxGrid(
        {
            width: '100%',
            height: '95%',
            source: dataAdapter,
            filterable: true,
            altrows: true,
            showfilterrow: true,
            columns: [

                {
                    text: 'Link',
                    cellsrenderer: function (row) {
                        return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleAsistente(' + row + ',' + idPer + ')"/>';
                    }, datafield: '', width: 50
                },
                { text: 'Muestra', datafield: 'customId', width: 70 },
                { text: 'Muestrax', datafield: 'idMuestra', width: 70, hidden: true },
                { text: 'Cliente', datafield: 'nomTercero', width: 250 },
                { text: 'Producto', datafield: 'nomProducto', width: 250 },
                { text: 'Lote', datafield: 'lote', width: 100 },
                { text: 'Estado', datafield: 'estado', width: 100 },
                { text: '% Aprobación', datafield: 'porcentajeAprobacion', width: 110 },
                //{ text: 'Cantidad Ensayos', datafield: 'cantidadTotal', width: 100},
                { text: 'Revisados', datafield: 'cantidadAprobado', width: 100 },
                { text: 'Pendientes', datafield: 'cantidadNoAprobado', width: 50 },
                { text: 'idProducto', datafield: 'idProducto', width: 250, hidden: true },
                { text: 'idTercero', datafield: 'idTercero', width: 250, hidden: true },
                {
                    text: 'Almacenar',
                    cellsrenderer: function (row) {
                        return '<button class="btn btn-primary" onClick="eventClickBtnAlmacenarMuestra(' + row + ')">Almacenar</button>';
                    }, datafield: 'almacenamiento', width: 90
                },

            ]
        });


    //alert (idPer);
}

function eventClickBtnAlmacenarMuestra(row) {
    var data = $('#gridPrincipalBeAsistente').jqxGrid('getrowdata', row);
    var idMuestra = data.idMuestra;
    alamcenarMuestra(idMuestra);
}


function eventClickImageDetalleAsistente(row, idPer) {

    var data = $('#gridPrincipalBeAsistente').jqxGrid('getrowdata', row);
    $("#idMuestraHiden").val(data.idMuestra);
    $("#idPerfilHiden").val(idPer);
    window.open('', 'view');
    $("#formEnvio").submit();

}

function alamcenarMuestra(idMuestra) {
    var auxDate = new Date();
    var ano = auxDate.getFullYear();
    var mes = auxDate.getMonth();
    mes++;
    var dia = auxDate.getDate();
    var fecha = ano + '-' + mes + '-' + dia;
    var url = "index.php"
    data = $.param({
        action: 'queryDb',
        query: 'alamacenarMuestra',
        almacenData: {
            fecha: fecha,
            idUbicación: 1,
            nivel: 1,
            tiempo: 0,
            caja: 1,
            idTIpoAlmacenamineto: 1
        },
        idMuestra: idMuestra

    });
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.code == "00000") {

                loadGridPrincipalBeAsistente(8);

            } else {
                

            }

        }
    });

}


