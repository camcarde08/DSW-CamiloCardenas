function initLoadBeDirectorTecnico(idPerfil, idUsuario){
    
    
    loadGridPrincipalBeDirectorTecnico();
}

function loadGridPrincipalBeDirectorTecnico(){
    var url = 'index.php?action=queryDb&query=getEnsayosCountAprobacionAndResultadosGroupByMuestra';
    var source =
            {
                datatype:
                        "json",
                datafields: [
                    {name: 'customId', type: 'string'},
                    {name: 'idMuestra', type: 'string'},
                    {name: 'cantidadTotal', type: 'string'},
                    {name: 'cantidadAprobado', type: 'string'},
                    {name: 'cantidadNoAprobado', type: 'string'},
                    {name: 'porcentajeAprobacion', type: 'string'},
                   {name: 'nomProducto', type: 'string'},
                    {name: 'nomTercero', type: 'string'},
                   {name: 'lote', type: 'string'}
                ],
                url: url,
                async: false
            };
    
    var dataAdapter = new $.jqx.dataAdapter(source);
            $("#gridPrincipalBeDirectorTecnico").jqxGrid(
            {
                width: '100%',
                height:'95%',
                source: dataAdapter,
                showfilterrow: true,
                altrows: true,
                filterable: true,
                columns: [
                  { text: 'Link', 
                    cellsrenderer: function (row) {  
                        return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleDirTec('+row+')"/>';
                    }, datafield: '', width: 50 
                  },  
                  { text: 'Muestra', datafield: 'customId', width: 70 },
                  { text: 'Muestrax', datafield: 'idMuestra', width: 70, hidden :true },
                  { text: 'Cliente', datafield: 'nomTercero', width: 260 },
                  { text: 'Producto', datafield: 'nomProducto', width: 260 },
                  { text: 'Lote', datafield: 'lote', width: 110 },
                  { text: 'Cant. Ensayos', datafield: 'cantidadTotal', width: 110},
                  { text: 'Revisados', datafield: 'cantidadAprobado', width: 100 },
                  { text: 'Sin Revisar', datafield: 'cantidadNoAprobado', width: 100 },
                  { text: '% Aprobación', datafield: 'porcentajeAprobacion', width: 100 }
                                  
            
                  
              ]
            });
}

function eventClickImageDetalleDirTec(row){
    
    var data = $('#gridPrincipalBeDirectorTecnico').jqxGrid('getrowdata', row);
    
    window.location.href = 'index.php?action=ConsultaHojaRutaMuestra&idMuestra='+data.customId;
}


