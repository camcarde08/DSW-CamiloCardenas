function initialLoadResultadosEstadistica() {
    loadGridEstadisticas();
    loadButtonExportData();
    eventClickLoadButtonExportData();
    eventClickButtonCreateGrafica();
}

function eventClickButtonCreateGrafica() {
    $("#crearGrafica").on('click', function () {
        var filtersinfo = $('#gridResultados').jqxGrid('getfilterinformation');

        var indiceFiltroProducto = filtersinfo.findIndex(function (data) {
            return data.datafield == 'producto';
        });
        if (indiceFiltroProducto != -1) {
            var productoFilterDetail = filtersinfo[indiceFiltroProducto].filter.getfilters();
            if (productoFilterDetail.length > 1) {
                alert("Debe aplicar un unico filtro de producto para generar la grafica");
            } else {
                var rows = $('#gridResultados').jqxGrid('getrows');
                var rows2 = [];
                rows.forEach(function(item, index){
                    var aux = {
                        idMuestra: item.idMuestra,
                        resultadoNumerico: parseInt(item.resultadoNumerico)
                    };
                    rows2.push(aux);
                });
                
                
                // var rows2 = [
                // {
                //     idMuestra: '24160348',
                //     resultadoNumerico: 10},
                // {
                //     idMuestra: '24160393',
                //     resultadoNumerico: 20
                // },
                // {
                //     idMuestra: '24160504',
                //     resultadoNumerico: 30
                // }
                // ];
             
            var settings = {
                title: "Tendencias de la muestras",
                description: "Análisis estadístico de tendencia para ensayos de muestras realizadas",
                showLegend: true,
                enableAnimations: true,
                padding: { left: 20, top: 5, right: 20, bottom: 5 },
                titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
                source: rows,
                xAxis:
                {
                    type: 'basic',
                    dataField: 'idMuestra',
                    gridLines: { visible: true },
                    flip: false,
                    visible: true,
                    labels: {visible:true}
                },
                colorScheme: 'scheme01',
                seriesGroups:
                    [
                        {
                            type: 'column',
                            orientation: 'vertical',
                            columnsGapPercent: 50,
                            toolTipFormatSettings: { thousandsSeparator: ',' },
                            series: [
                                    { dataField: 'resultadoNumerico', displayText: 'resultadoNumerico', labels: {visible:true, class: 'prueba'} }
                                ]
                        }
                    ]
            };
                // setup the chart
                $('#chartContainer').jqxChart(settings);



                var a = 0;
            }
        } else {
            alert("Debe aplicar un filtro de producto para generar la grafica");
        }
        var a = 0;
    });
}

function loadButtonCreateGrafica() {
    $("#crearGrafica").jqxButton({width: 120, height: 25});
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
        var rows = $("#gridResultados").jqxGrid('exportdata', 'json');

        var prom = ajaxExportData(rows);
        prom.then(function (data) {
            var response = JSON.parse(data);
            window.open(response.fileName);
        });
    });
}



function loadGridEstadisticas() {
    var url = "model/DB/jqw/resultadosEstadisticaData.php?query=getAll";

    var muestrasSource =
    {
        datatype: "json",
        datafields: [
        {name: 'idMuestra', type: 'string'},
        {name: 'fechaLlegada', type: 'date'},
        {name: 'lote', type: 'string'},
        {name: 'cliente', type: 'string'},
        {name: 'producto', type: 'string'},
        {name: 'idEnsayo', type: 'string'},
        {name: 'nombreEnsayo', type: 'string'},
        {name: 'ensayoEspecifico', type: 'string'},
        {name: 'especificacion', type: 'string'},
        {name: 'resultado', type: 'string'},
        {name: 'resultadoNumerico', type: 'number'},
        {name: 'conclusion', type: 'string'},
        {name: 'obsrevision', type: 'string'}
        ],
                // id: 'idMuestra',
                url: url

            };
            var muestrasAdapter = new $.jqx.dataAdapter(muestrasSource);
            $("#gridResultados").jqxGrid(
            {
                width: 1200,
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
                    text: 'Número',
                    dataField: 'idMuestra',
                    width: 90,
                    align: 'center',
                    cellsalign: 'center',
                    pinned: true,
                    filtertype: 'input'
                },
                {
                    text: 'Fecha Llegada',
                    dataField: 'fechaLlegada',
                    width: 90,
                    align: 'center',
                    cellsalign: 'right',
                    filtertype: 'range',
                    cellsformat: 'yyyy-MM-dd'
                },
                {
                    text: 'Lote',
                    dataField: 'lote',
                    width: 90,
                    align: 'center',
                    cellsalign: 'left',
                    filtertype: 'input'
                },
                {
                    text: 'Cliente',
                    dataField: 'cliente',
                    width: 120,
                    align: 'center',
                    cellsalign: 'left',
                    filtertype: 'checkedlist'
                },
                {
                    text: 'Producto',
                    dataField: 'producto',
                    width: 160,
                    align: 'center',
                    cellsalign: 'left',
                    filtertype: 'checkedlist'
                },
                {
                    text: 'Descripción',
                    dataField: 'nombreEnsayo',
                    width: 160,
                    align: 'center',
                    cellsalign: 'left',
                    filtertype: 'input'
                },
                {
                    text: 'Desc. Especifica',
                    dataField: 'ensayoEspecifico',
                    width: 180,
                    align: 'center',
                    cellsalign: 'left',
                    filtertype: 'input'
                },
                {
                    text: 'Especificación',
                    dataField: 'especificacion',
                    width: 180,
                    align: 'center',
                    cellsalign: 'left',
                    filtertype: 'input'
                },
//                    { 
//                        text: 'Área de Análisis', 
//                        dataField: 'areaAnalisis', 
//                        width: 150, 
//                        align: 'center',
//                        cellsalign:'center',
//                        filtertype: 'checkedlist'
//                    },
{
    text: 'Resultado',
    dataField: 'resultado',
    width: 150,
    align: 'center',
    cellsalign: 'left',
    filtertype: 'input'
},
{
    text: 'Resultado Numerico',
    dataField: 'resultadoNumerico',
    width: 150,
    align: 'center',
    cellsalign: 'left',
    filtertype: 'number'
},
{
    text: 'Conclusión',
    dataField: 'conclusion',
    width: 100,
    align: 'center',
    cellsalign: 'left',
    filtertype: 'checkedlist'
},
{
    text: 'Observaciones',
    dataField: 'obsrevision',
    width: 100,
    align: 'center',
    cellsalign: 'left',
    filtertype: 'input'
}
]
});
        }


