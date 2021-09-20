function initialLoadConsultaMuestrasEst(){
    
    loadGridMuestrasEst();

}

function loadGridMuestrasEst(){
    var url = "index.php?action=queryDb&query=getAllEstablidadesTiempos";
    
    var muestrasSource =
    {
        datatype: "json",
        datafields: [
            { name: 'idMuestra', type: 'string' },
            { name: 'fechaLlegada',type: 'date'},
            { name: 'producto',type: 'string' },
            { name: 'cliente',type: 'string' },
            { name: 'tipoEstabilidad',type: 'string' },
            { name: 'lote',type: 'string' },
            { name: 'fechaProgramacion',type: 'string' },
            { name: 'tiempo',type: 'string' },
            { name: 'tiempotemp',type: 'string' },
            { name: 'estado',type: 'string' }
        ],
        //id: 'idMuestra',
        url: url
        
    };
    var muestrasAdapter = new $.jqx.dataAdapter(muestrasSource);
    $("#gridMuestrasEst").jqxGrid(
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
                        text: 'PDF', 
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
                            var dataRecord = $("#gridMuestrasEst").jqxGrid('getrowdata', editrow);
                            //alert(dataRecord.idMuestra);
                            //window.location.href = 'index.php?action=regmuestra&idMuestra='+dataRecord.idMuestra;
                            eventClickPDFInformeEstabilidad(dataRecord.idMuestra, dataRecord.tiempotemp,dataRecord.tiempo, dataRecord.tipoEstabilidad);
                    
                        }
                    }, 
                    { 
                        text: 'Número', 
                        dataField: 'idMuestra', 
                        width: 70,
                        align: 'center',
                        cellsalign:'center',
                        pinned: true,
                        filtertype: 'input'
                    },
                    { 
                        text: 'Producto', 
                        dataField: 'producto', 
                        width: 180, 
                        align: 'center',
                        cellsalign:'left',
                        filtertype: 'input'
                    },
                    { 
                        text: 'Cliente', 
                        dataField: 'cliente', 
                        width: 150, 
                        align: 'center',
                        cellsalign:'left',
                        filtertype: 'input'
                    },
                    { 
                        text: 'Fecha Llegada', 
                        dataField: 'fechaLlegada', 
                        width: 120, 
                        align: 'center',
                        cellsalign:'center',
                        filtertype: 'range',
                        cellsformat : 'yyyy-MM-dd'
                    },
                                        
            { 
                        text: 'Tipo de Estabilidad', 
                        dataField: 'tipoEstabilidad', 
                        width: 150, 
                        align: 'center',
                        cellsalign:'center',
                        filtertype: 'input'
                    },
                    
                      { 
                        text: 'Tiempo', 
                        dataField: 'tiempo', 
                        width: 140, 
                        align: 'center',
                        cellsalign:'center',
                        filtertype: 'input'
                    },
            
            { 
                        text: 'Fecha de Programación', 
                        dataField: 'fechaProgramacion', 
                        width: 160, 
                        align: 'center',
                        cellsalign:'center',
                        filtertype: 'range',
                        cellsformat : 'yyyy-MM-dd'
                    },
                   
                    
                    
                    { 
                        text: 'Lote', 
                        dataField: 'lote', 
                        width: 90, 
                        align: 'center',
                        cellsalign:'center',
                        filtertype: 'input'
                    },
                    { 
                        text: 'Estado', 
                        dataField: 'estado', 
                        width: 20, 
                        align: 'center',
                        cellsalign:'center',
                        filtertype: 'input'
                    }


                ]
            });
}

function eventClickPDFInformeEstabilidad(NumMuestra,TiempoTemp,TiempoEst, TipoEst){
// Creamos el formulario auxiliar
var form = document.createElement( "form" );
// Le añadimos atributos como el name, action y el method
form.setAttribute( "name", "formulario" );
form.setAttribute( "action", "pdf/informes/informeAnalisisEstab.php" );
form.setAttribute( "method", "post" );
// Creamos un input para enviar el valor
var input = document.createElement( "input" );
var input1 = document.createElement( "input" );
var input2 = document.createElement( "input" );
var input3 = document.createElement( "input" );
// Le añadimos atributos como el name, type y el value
input.setAttribute( "name", "idMuestra" );
input.setAttribute( "type", "hidden" );
input.setAttribute( "value", NumMuestra );
input1.setAttribute( "name", "TiempoEstPost" );
input1.setAttribute( "type", "hidden" );
input1.setAttribute( "value", TiempoEst );
input2.setAttribute( "name", "TipoEstPost" );
input2.setAttribute( "type", "hidden" );
input2.setAttribute( "value", TipoEst );
input3.setAttribute( "name", "TiempoTemp" );
input3.setAttribute( "type", "hidden" );
input3.setAttribute( "value", TiempoTemp );
// Añadimos el input al formulario
form.appendChild(input);
form.appendChild(input1);
form.appendChild(input2);
form.appendChild(input3);
// Añadimos el formulario al documento
document.getElementsByTagName( "body" )[0].appendChild( form );
// Hacemos submit
document.formulario.submit();


 
}


