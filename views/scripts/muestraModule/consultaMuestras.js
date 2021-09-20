function initialLoadConsultaMuestras(idPerfilA) {
    idPerfil = idPerfilA
    loadGridMuestras();
}

function loadGridMuestras() {

    var url = 'index.php?action=queryDb&query=getMuestrasRefrencias';

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
                    {name: 'observacion', type: 'string'}
                ],
                id: 'idMuestra',
                url: url

            };
    var renderer = function (row, column, value) {
        return '<div style="white-space: normal;">' + value + '</div>';
    };

    var muestrasAdapter = new $.jqx.dataAdapter(muestrasSource);
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
                        text: 'Número',
                        dataField: 'complexId',
                        width: 90,
                        align: 'center',
                        cellsalign: 'center',
                        pinned: true,
                        filtertype: 'input'
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
                        width: 200,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
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
                        text: 'Lote',
                        dataField: 'lote',
                        width: 150,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
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
                        text: 'Fecha Llegada',
                        dataField: 'fechaLlegada',
                        width: 110,
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
                        text: 'F. Almacenamiento',
                        dataField: 'fechaAlmacenamiento',
                        width: 140,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'range',
                        cellsformat: 'yyyy-MM-dd'
                    },
                    {
                        text: 'Observaciones internas',
                        dataField: 'observacion',
                        width: 300,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input',
                        cellsrenderer: renderer
                    },
                    {
                        text: 'Prioridad',
                        dataField: 'prioridad',
                        width: 80,
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
}


