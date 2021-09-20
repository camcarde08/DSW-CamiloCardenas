function initLoadBeGerente(idPerfil, idUsuario) {
    loadGridPrincipalBeGerente(idPerfil);

}

function loadGridPrincipalBeGerente(idPerfil) {

    var url = "index.php?action=queryDb&query=getAllMuestraReferenciasData";

    var muestrasSource =
            {
                datatype: "json",
                datafields: [
                    {name: 'complexId', type: 'string'},
                    {name: 'idMuestra', type: 'string'},
                    {name: 'activa', type: 'boolean'},
                    {name: 'prioridad', type: 'string'},
                    {name: 'cotizacion', type: 'string'},
                    {name: 'remision', type: 'string'},
                    {name: 'producto', type: 'string'},
                    {name: 'tercero', type: 'string'},
                    {name: 'contacto', type: 'string'},
                    {name: 'informe', type: 'string'},
                    {name: 'estado', type: 'string'},
                    {name: 'factura', type: 'string'},
                    {name: 'fechaLlegada', type: 'date'},
                    {name: 'fechaCompromiso', type: 'date'},
                    {name: 'areaAnalisis', type: 'string'}
                ],
                id: 'idMuestra',
                url: url

            };
    var muestrasAdapter = new $.jqx.dataAdapter(muestrasSource);
    $("#gridPrincipalBeGerente").jqxGrid(
            {
                width: 1150,
                autoheight: true,
                altrows: true,
                filterable: true,
                showfilterrow: true,
                pageable: true,
                columnsreorder: true,
                columnsresize: true,
                pagermode: 'simple',
                sortable: true,
                source: muestrasAdapter,
                columns: [
                    {
                        text: 'Editar',
                        dataField: 'id',
                        width: 50,
                        columntype: 'button',
                        // align: 'center',
                        filtertype: false,
                        pinned: true,
                        cellsrenderer: function (id) {
                            return "Editar";
                        },
                        buttonclick: function (row) {
                            var editrow = row;
                            var dataRecord = $("#gridPrincipalBeGerente").jqxGrid('getrowdata', editrow);
                            //alert(dataRecord.idMuestra);
                            window.location.href = 'index.php?action=regmuestra&idMuestra=' + dataRecord.complexId;
                        }
                    },

//                 { text: 'Link', 
//                    cellsrenderer: function (row) {  
//                        return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleGerente('+row+','+idPer+')"/>';
//                    }, datafield: '', width: 50 
//                  }
//                    
                    {
                        text: 'Muestra',
                        dataField: 'complexId',
                        width: 90,
                        align: 'center',
                        cellsalign: 'center',
                        pinned: true,
                        filtertype: 'input'
                    },
                    {
                        text: 'Número',
                        dataField: 'idMuestra',
                        width: 70,
                        align: 'center',
                        cellsalign: 'center',
                        pinned: true,
                        filtertype: 'input',
                        hidden: true
                    },
                    {
                        text: 'Activa',
                        dataField: 'activa',
                        width: 50,
                        columntype: 'checkbox',
                        align: 'center',
                        filtertype: 'bool'
                    },
                    {
                        text: 'Producto',
                        dataField: 'producto',
                        width: 180,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    {
                        text: 'Cliente',
                        dataField: 'tercero',
                        width: 150,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    {
                        text: 'Estado',
                        dataField: 'estado',
                        width: 120,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'Fecha Llegada',
                        dataField: 'fechaLlegada',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd'
                    },
                    {
                        text: 'Fecha Compromiso',
                        dataField: 'fechaCompromiso',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd'
                    },
                    {
                        text: 'Prioridad',
                        dataField: 'prioridad',
                        width: 100,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'Área de Análisis',
                        dataField: 'areaAnalisis',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'No. Informe',
                        dataField: 'informe',
                        width: 100,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input'
                    },
                    {
                        text: 'Cotización',
                        dataField: 'cotizacion',
                        width: 100,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input'
                    },
                    {
                        text: 'No. Remisión',
                        dataField: 'remision',
                        width: 100,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input'
                    },
                    {
                        text: 'Contacto',
                        dataField: 'contacto',
                        width: 200,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input'
                    },
                    {
                        text: 'No. Factura',
                        dataField: 'factura',
                        width: 200,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input'
                    }


                ]
            });
//    var idPer = idPerfil;
//    var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getEnsayosCountAporbacionesGroupByMuestra';
//    var source =
//            {
//                datatype:
//                        "json",
//                datafields: [
//                    {name: 'idMuestra', type: 'string'},
//                    {name: 'cantidadTotal', type: 'string'},
//                    {name: 'cantidadAprobado', type: 'string'},
//                    {name: 'cantidadNoAprobado', type: 'string'},
//                    {name: 'porcentajeAprobacion', type: 'string'},
//                    {name: 'idProducto', type: 'string'},
//                    {name: 'nomProducto', type: 'string'},
//                    {name: 'idTercero', type: 'string'},
//                    {name: 'nomTercero', type: 'string'},
//                    {name: 'lote', type: 'string'},
//                    {name: 'estado', type: 'string'},
//                    {name: 'idEestado', type: 'int'},
//                    {name: 'fllegada', type: 'string'},
//                    {name: 'fcompromiso', type: 'string'}
//                    
//                ],
//                url: url,
//                async: false
//            };
//    
//    
//        var cellclass = function (row, columnfield, value) {
//        if (value != ""){
//            var dateArray = value.split("/");
//            var dateCompromiso = new Date (dateArray[2],(dateArray[1]-1),dateArray[0]);
//            
//            var today = new Date();
//            var diaAlerta = today.getDate() + 3;
//            var limiteAlerta = new Date(today.getFullYear(),today.getMonth(),diaAlerta);
//                    
//            if(today>dateCompromiso   ){
//                return 'red';
//            } else if ( limiteAlerta >= dateCompromiso){
//                return 'yellow';
//            }
//            
//        }
//        
//    }
//    var dataAdapter = new $.jqx.dataAdapter(source);
//            $("#gridPrincipalBeGerente").jqxGrid(
//            {
//                columnsreorder: true,
//                columnsresize: true,
//                pagermode: 'simple',
//                sortable: true,
//                pageable: true,
//                autoheight: true,
//                width: '100%',
//                height:'100%',
//                source: dataAdapter,
//                filterable: true,
//                altrows: true,
//                showfilterrow: true,
//                columns: [
//                    
//                 { text: 'Link', 
//                    cellsrenderer: function (row) {  
//                        return '<img style="position: absolute; top: 5%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageDetalleGerente('+row+','+idPer+')"/>';
//                    }, datafield: '', width: 50 
//                  } 
//                        
//                   
//                  ,  
//                  { text: 'Muestra', datafield: 'idMuestra', width: 70 },
//                  { text: 'Cliente', datafield: 'nomTercero', width: 250 },
//                  { text: 'Producto', datafield: 'nomProducto', width: 250 },
//                  { text: 'Lote', datafield: 'lote', width: 100 },
//                  { text: 'Estado', datafield: 'estado', width: 120 },
//                  { text: '% Aprobación', datafield: 'porcentajeAprobacion', width: 110 },
//                  { text: 'Fecha llegada', datafield: 'fllegada', width: 100 },
//                  { text: 'Fecha Compromiso', datafield: 'fcompromiso', width: 100, cellclassname: cellclass },
//                 //{ text: 'Cantidad Ensayos', datafield: 'cantidadTotal', width: 100},
//                  { text: 'Revisados', datafield: 'cantidadAprobado', width: 100 },
//                  { text: 'Pendientes', datafield: 'cantidadNoAprobado', width: 100 },
//                  { text: 'idProducto', datafield: 'idProducto', width: 250, hidden: true },
//                  { text: 'idTercero', datafield: 'idTercero', width: 250, hidden: true}
//                  
//              ]
//            });


}
function eventClickImageDetalleGerente(row, idPer) {
    var data = $('#gridPrincipalBeGerente').jqxGrid('getrowdata', row);
    $("#idMuestraHiden").val(data.complexId);
    $("#idPerfilHiden").val(idPer);
    window.open('', 'view');
    $("#formEnvio").submit();
}


