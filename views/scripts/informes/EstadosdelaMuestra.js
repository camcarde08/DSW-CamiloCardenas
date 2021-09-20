function initialInformeEstadosMuestra() {
    //eventButtonClickChargeEstadosMuestraPDF();
    loadGridMuestrasEstado();

    eventClickLoadButtonExportMuestras();
}

function eventClickLoadButtonExportMuestras() {
    $("#loadButtonExportData").on('click', function () {

        //var rows = $('#gridPrincipalBeAnalista').jqxGrid('getrows');
        var rows = $("#gridMuestras").jqxGrid('exportdata', 'json', null, true, null, true);

        var prom = ajaxExportEstadosMuestra(rows);
        prom.then(function (data) {
            var response = JSON.parse(data);
            window.open(response.fileName);
        });
    });
}

function ajaxExportEstadosMuestra(data) {
    var url = "index.php";
    //var data = JSON.stringify(data);
    var data = {
        action: "exportEstadosMuestra",
        data: data
    };
    data = $.param(data);

    return $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false
    });
}

function loadGridMuestrasEstado() {

    var url = 'index.php?action=queryDb&query=getEstadoMuestrasReferencia';

    var muestrasSource =
            {
                datatype: "json",
                datafields: [
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
                    {name: 'fechaAlmacenamiento', type: 'date'},
                    {name: 'areaAnalisis', type: 'string'},
                    {name: 'complexId', type: 'string'},
                    {name: 'lote', type: 'string'},
                    {name: 'observacion', type: 'string'},
                    {name: 'nombre_analista', type: 'string'},
                    {name: 'fecha_programada', type: 'date'},
                    {name: 'fecha_resultado', type: 'date'},
                    {name: 'fecha_pre_conclusion', type: 'date'},
                    {name: 'fecha_conclusion', type: 'date'},
                    {name: 'fecha_analisis', type: 'date'},
                    {name: 'fecha_fabricacion', type: 'date'},
                    {name: 'fecha_vencimiento', type: 'date'},
                    {name: 'fecha_muestreo', type: 'date'},
                    {name: 'diferenciaFechas', type: 'int'},
                    {name: 'ensayos', type: 'string'},
                    {name: 'propietario', type: 'string'},
                    {name: 'envase', type: 'string'},
                    {name: 'forma_farmaceutica', type: 'string'},
                    {name: 'proveedor', type: 'string'}
                ],
                id: 'idMuestra',
                url: url

            };
    var renderer = function (row, column, value) {
        return '<div style="white-space: normal;">' + value + '</div>';
    };

    var cellclass = function (row, columnfield, value) {
        if (value === null || value === "") {
            return '';
        } else if (value < 0) {
            return 'red';
        } else if (value >= 0) {
            return 'green';
        } else {
            return '';
        }

    };

    var muestrasAdapter = new $.jqx.dataAdapter(muestrasSource,
            {
                beforeLoadComplete: function (records) {
                    for (var i = 0; i < records.length; i++) {
                        var date1 = new Date(records[i].fechaCompromiso);
                        if (records[i].fecha_conclusion !== null) {
                            var date2 = new Date(records[i].fecha_conclusion);
                            var timeDiff = date1.getTime() - date2.getTime();
                            records[i].diferenciaFechas = Math.ceil(timeDiff / (1000 * 3600 * 24));
                        } else {
                            records[i].diferenciaFechas = null;
                        }
                    }
                }
            });

    $("#gridMuestras").jqxGrid(
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
                pagesize: 20,
                enabletooltips: true,
                columns: [
                    {
                        text: 'Editar',
                        dataField: 'id',
                        width: 60,
                        columntype: 'button',
                        // align: 'center',
                        filtertype: false,
                        pinned: true,
                        exportable: false,
                        cellsrenderer: function (id) {
                            return "Editar";
                        },
                        buttonclick: function (row) {
                            var editrow = row;
                            var dataRecord = $("#gridMuestras").jqxGrid('getrowdata', editrow);
                            window.location.href = 'index.php?action=regmuestra&idMuestra=' + dataRecord.complexId;
                        }
                    },
                    {
                        text: 'Producto',
                        dataField: 'producto',
                        width: 200,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    {
                        text: 'Número',
                        dataField: 'complexId',
                        width: 90,
                        align: 'center',
                        cellsalign: 'center',
                        pinned: true,
                        filtertype: 'input'
                    },
                    {
                        text: 'Nombre Analista',
                        dataField: 'nombre_analista',
                        width: 200,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    {
                        text: 'Ensayos a realizar',
                        dataField: 'ensayos',
                        width: 270,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input',
                        cellsrenderer: renderer
                    },
                    {
                        text: 'Estado',
                        dataField: 'estado',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist'
                    },
                    {
                        text: 'Cliente',
                        dataField: 'tercero',
                        width: 180,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    {
                        text: 'F. Llegada',
                        dataField: 'fechaLlegada',
                        width: 100,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Fecha Programación',
                        dataField: 'fecha_programada',
                        width: 110,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Fecha Análisis',
                        dataField: 'fecha_analisis',
                        width: 110,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Fecha Transcripción',
                        dataField: 'fecha_resultado',
                        width: 110,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Fecha Aprobación',
                        dataField: 'fecha_conclusion',
                        width: 110,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Fecha Compromiso',
                        dataField: 'fechaCompromiso',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Días de retraso',
                        dataField: 'diferenciaFechas',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input',
                        cellclassname: cellclass,
                        hidden: true
                    },
                    {
                        text: 'Lote',
                        dataField: 'lote',
                        width: 150,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input',
                        hidden: true
                    },
                    {
                        text: 'Propietario',
                        dataField: 'propietario',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist',
                        hidden: true
                    },
                    {
                        text: 'Proveedor',
                        dataField: 'proveedor',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist',
                        hidden: true
                    },
                    {
                        text: 'Envase',
                        dataField: 'envase',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist',
                        hidden: true
                    },
                    {
                        text: 'Forma farmacéutica',
                        dataField: 'forma_farmaceutica',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'checkedlist',
                        hidden: true
                    },
                    {
                        text: 'F. Almacenamiento',
                        dataField: 'fechaAlmacenamiento',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'F. Fabricación',
                        dataField: 'fecha_fabricacion',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'F. Vencimiento',
                        dataField: 'fecha_vencimiento',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'F. Muestreo',
                        dataField: 'fecha_muestreo',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd',
                        hidden: true
                    },
                    {
                        text: 'Observaciones internas',
                        dataField: 'observacion',
                        width: 300,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input',
                        cellsrenderer: renderer,
                        hidden: true
                    },
                    {
                        text: 'Contacto',
                        dataField: 'contacto',
                        width: 200,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input',
                        hidden: true
                    },
                    {
                        text: 'No. Factura',
                        dataField: 'factura',
                        width: 200,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'input',
                        hidden: true
                    }


                ]
            });
}
