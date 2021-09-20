function initLoadCOnsultaCotizacion() {

    //load components
    loadGridAllCotizacionesConsultaCotizacion();
}

function loadGridAllCotizacionesConsultaCotizacion() {
    var url = "model/DB/jqw/spConsultaCotizacionesData.php";

    var cotizacionSource =
            {
                datatype: "json",
                datafields: [
                    {name: 'idCotizacion', type: 'int'},
                    {name: 'idEstadoCotizacion', type: 'int'},
                    {name: 'descripcionEstado', type: 'string'},
                    {name: 'fechaSolicitud', type: 'date'},
                    {name: 'fechaCompromiso', type: 'date'},
                    {name: 'idCliente', type: 'int'},
                    {name: 'nombreCliente', type: 'string'},
                    {name: 'nombreContacto', type: 'string'},
                    {name: 'telContacto', type: 'int'},
                    {name: 'observaciones', type: 'string'}
                ],
                id: 'idCotizacion',
                url: url

            };
    var cotizacionAdapter = new $.jqx.dataAdapter(cotizacionSource);
    $("#gridAllCotizacionesConsultaCotizacion").jqxGrid(
            {
                width: 1000,
                autoheight: true,
                altrows: true,
                filterable: true,
                showfilterrow: true,
                pageable: true,
                columnsreorder: true,
                columnsresize: true,
                pagermode: 'simple',
                sortable: true,
                source: cotizacionAdapter,
                columns: [
                    {
                        text: 'Ver',
                        dataField: 'id',
                        width: 50,
                        columntype: 'button',
                        align: 'center',
                        filtertype: false,
                        pinned: true,
                        cellsrenderer: function (id) {
                            return "Edit";
                        },
                        buttonclick: function (row) {
                            var editrow = row;
                            var dataRecord = $("#gridAllCotizacionesConsultaCotizacion").jqxGrid('getrowdata', editrow);
                            //alert(dataRecord.idMuestra);
                            window.location.href = 'index.php?action=registrarCotizacion&idCotizacion=' + dataRecord.idCotizacion;
                        }
                    },
                    {
                        text: 'Cotización',
                        dataField: 'idCotizacion',
                        width: 80,
                        align: 'center',
                        cellsalign: 'center',
                        pinned: true,
                        filtertype: 'input'
                    },
                    {
                        text: 'idEstadoCotizacion',
                        dataField: 'idEstadoCotizacion',
                        width: 70,
                        align: 'center',
                        cellsalign: 'center',
                        pinned: true,
                        filtertype: 'input',
                        hidden: true
                    },
                    {
                        text: 'Cliente',
                        dataField: 'nombreCliente',
                        width: 150,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    {
                        text: 'Estado',
                        dataField: 'descripcionEstado',
                        width: 100,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'input'
                    },
                    
                                       {
                        text: 'Contacto',
                        dataField: 'nombreContacto',
                        width: 150,
                        align: 'center',
                        cellsalign: 'left',
                        filtertype: 'input'
                    },
                    { text: 'Tel. Contacto', dataField: 'telContacto',width: 150,align: 'center', cellsalign: 'left',filtertype: 'input' },
                     
                    {
                        text: 'Fecha Solicitud',
                        dataField: 'fechaSolicitud',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'date',
                        columntype: 'datetimeinput',
                        cellsformat: 'dd-MM-yyyy'
                    },
                    {
                        text: 'Fecha Compromiso',
                        dataField: 'fechaCompromiso',
                        width: 150,
                        align: 'center',
                        cellsalign: 'center',
                        filtertype: 'date',
                        columntype: 'datetimeinput',
                        cellsformat: 'dd-MM-yyyy'
                    },
                    {
                        text: 'idCliente',
                        dataField: 'idCliente',
                        width: 150,
                        align: 'center',
                        cellsalign: 'right',
                        filtertype: 'checkedlist',
                        hidden: true
                    }
//                    {
//                        text: 'observaciones',
//                        dataField: 'observaciones',
//                        width: 200,
//                        align: 'center',
//                        cellsalign: 'right',
//                        filtertype: 'input'
//                    }
                ]
            });
}

var consultaCotizacionApp = angular.module("consultaCotizacionApp", ["jqwidgets"]);
consultaCotizacionApp.controller("gridCotizacionEstController", function ($scope, $http) {

    $scope.sourceAdapter = new $.jqx.dataAdapter({
        //localdata: null,
        datafields:
                [
                    {name: 'id', type: 'int'},
                    {name: "estado", type: "string"},
                    {name: "fechaSolicitud", type: "date"},
                    {name: "fechaCompromiso", type: "date"},
                    {name: "idTercero", type: "int"},
                    {name: "nomTercero", type: "string"},
                    {name: "contacto", type: "string"},
                    {name: "telContacto", type: "string"},
                    {name: "idProducto", type: "int"},
                    {name: "nomProducto", type: "string"},
                    {name: "tipoEstabilidad", type: "string"},
                    {name: "observaciones", type: "string"},
                    {name: "observaciones2", type: "string"},
                    {name: "observaciones3", type: "string"},
                    {name: "tiempos", type: "string"},
                    {name: "desEstado", type: "string"}
                ],
               // id:id
    });

    $scope.settings = {
        altrows: true,
        width: 1000,
        height: 300,
        filterable: true,
        showfilterrow: true,
        pageable: true,
        columnsreorder: true,
        columnsresize: true,
        sortable: true,
        source: $scope.sourceAdapter,
        columns: [
                    {
                        text: 'Ver',
                        dataField: 'uid',
                        width: 50,
                        columntype: 'button',
                        align: 'center',
                        filtertype: false,
                        pinned: true,
                        cellsrenderer: function (id) {
                            return "Edit";
                        },
                        buttonclick: function (row) {
                            var editrow = row;
                            //var dataRecord = $("#gridCotizacionEstController").jqxGrid('getrowdata', editrow);
                            var dataRecord = $scope.settings.apply('getrowdata', editrow);
                            //alert(dataRecord.id);
                            window.location.href = 'index.php?action=regEstCotizacion&idEstCotizacion=' + dataRecord.id;
                        }
                    },
            {text: 'Cotización', datafield: 'id',  align: 'center', cellsalign: 'center', width: 80},
            {text: 'Cliente', datafield: 'nomTercero',align: 'center', cellsalign: 'left', width: 150},
            {text: 'Estado', datafield: 'desEstado', align: 'center', cellsalign: 'center', width: 100},
            {text: 'Contacto', datafield: 'contacto',align: 'center', cellsalign: 'left', width: 150},
            {text: 'Teléfono', datafield: 'telContacto',align: 'center', cellsalign: 'left', width: 150},
            {text: 'Fecha Solicitud', datafield: 'fechaSolicitud', align: 'center', cellsalign: 'center', width: 150,cellsformat: 'dd-MM-yyyy'},
            {text: 'Fecha Compromiso', datafield: 'fechaCompromiso', align: 'center', cellsalign: 'center', width: 150,cellsformat: 'dd-MM-yyyy'},
            {text: 'idTercero', datafield: 'idTercero', width: 150, hidden: true},
            {text: 'idProducto', datafield: 'idProducto', width: 150, hidden: true},
            {text: 'nomProducto', datafield: 'nomProducto', width: 150, hidden: true},
            {text: 'tipoEstabilidad', datafield: 'tipoEstabilidad', width: 150, hidden: true},
            {text: 'observaciones', datafield: 'observaciones', width: 150, hidden: true},
            {text: 'observaciones2', datafield: 'observaciones2', width: 150, hidden: true},
            {text: 'observaciones3', datafield: 'observaciones3', width: 150, hidden: true},
            {text: 'estado', datafield: 'estado', width: 150, hidden: true},
            {text: 'tiempos', datafield: 'tiempos', width: 150 , hidden: true}
            
        ]
    };

    var config = {
        method: "GET",
        url: "model/DB/jqw/EstCotizacionData.php?query=getAllEstCotizacion"
    };

    var response = $http(config);

    response.success(function (data1, status, headers, config) {
        $scope.sourceAdapter = new $.jqx.dataAdapter({
            localdata: data1,
            datafields:
                    [
                        {name: 'id', type: 'int'},
                        {name: "estado", type: "string"},
                        {name: "fechaSolicitud", type: "date"},
                        {name: "fechaCompromiso", type: "date"},
                        {name: "idTercero", type: "int"},
                        {name: "nomTercero", type: "string"},
                        {name: "contacto", type: "string"},
                        {name: "telContacto", type: "string"},
                        {name: "idProducto", type: "int"},
                        {name: "nomProducto", type: "string"},
                        {name: "tipoEstabilidad", type: "string"},
                        {name: "observaciones", type: "string"},
                        {name: "observaciones2", type: "string"},
                        {name: "observaciones3", type: "string"},
                        {name: "tiempos", type: "string"},
                        {name: "desEstado", type: "string"}
                    ]
        });
    });
});