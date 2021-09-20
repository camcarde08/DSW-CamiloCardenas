function initLoadProductoAdmin(idPerfil, idUsuario) {
    //load components
    loadGridAllProductoAdminProducto();
    loadButtonAgregarPaqueteAdminProducto();
    loadButtonEliminarPaqueteAdminProducto();
    loadWindowAddProductoAdminProducto();
    loadNotificationAdminProducto();
    loadButtonAgregarPrinActivoAdminProducto();
    loadButtonEliminarPrinActivoAdminProducto();
    loadTabsDetalleProductoAdminProducto();
    // load Events
    eventRowSelectGridAllProductoAdminProducto();
    eventBindingGridProductoPaquetesAdminProducto();
    eventBindingGridPaquetesDisponiblesAdminProducto();
    eventBindingGridProductoEnsayosAdminProducto();
    eventBindingGridProductoPrinActivoAdminProducto();
    eventClickButtonAgregarPaqueteAdminProducto();
    eventClickButtonEliminarPaqueteAdminProducto();
    eventCloseWindowAddProductoAdminProducto();
    eventClickButtonOKModalAddProductoAdminProducto();
    eventClickButtonAgregarPrinActivoAdminProducto();
    eventClickButtonEliminarPrinActivoAdminProducto();

}

function loadTabsDetalleProductoAdminProducto() {
    $('#tabsDetalleProductoAdminProducto').jqxTabs({
        width: 1200,
        height: 450,
        position: 'top',
        collapsible: true
    });
}

function eventClickButtonOKModalAddProductoAdminProducto() {
    $('#buttonOKModalAddProductoAdminProducto').on('click', function () {

        var nombre = $("#inputNomProductoAddProductoAdminProducto").jqxInput('val');
        var idFormaFarma = $("#dropDownFormaAddProductoAdminProducto").jqxDropDownList('getSelectedItem').value;
        var estado = 1;
        if (nombre == '') {
            openNotificationAdminProducto('error', 'No es posible crear un producto sin nombre');
            return false;
        }

        var productosData = $("#gridAllProductoAdminProducto").jqxGrid('getrows');
        var validarRep = productosData.find(function (producto) {
            return producto.nombre == this;
        }, nombre);
        if (validarRep == undefined) {
            $('#windowAddProductoAdminProducto').jqxWindow('close');
            ajaxCreateProducto(nombre, idFormaFarma, estado, '1', 1);
        } else {
            openNotificationAdminProducto('error', 'Ya existe un producto con el nombre ' + nombre + '.');
            return false;
        }

    });
}

function loadWindowAddProductoAdminProducto() {
    $('#windowAddProductoAdminProducto').jqxWindow({isModal: true,
        height: 380,
        width: 460,
        title: 'Agregar Nuevo Producto',
        autoOpen: false,
        resizable: false,
        cancelButton: $('#buttonCancelarModalAddProductoAdminProducto'),
        position: {x: 400, y: 100},
        initContent: function () {

            $("#inputNomProductoAddProductoAdminProducto").jqxInput({width: '400', height: 25});
            var url = "model/DB/jqw/FormaData.php?query=all";

            var source =
                    {
                        datatype: "json",
                        datafields: [
                            {name: 'id', type: 'int'},
                            {name: 'descripcion', type: 'string'}
                        ],
                        url: url,
                        async: false
                    };
            var dataAdapter = new $.jqx.dataAdapter(source);
            // Create a jqxDropDownList
            $("#dropDownFormaAddProductoAdminProducto").jqxDropDownList({
                selectedIndex: 0, source: dataAdapter, displayMember: "descripcion", valueMember: "id", width: 200, height: 25
            });
            //$("#inputTecnicaAddProductoAdminProducto").jqxInput({ width: '400', height: 25});
            //$("#numberInputTiempoAddProductoAdminProducto").jqxNumberInput({groupSize: 0, width: '400', height: '25', decimalDigits: 0});

            $("#buttonOKModalAddProductoAdminProducto").jqxButton({width: '70'});
            $("#buttonCancelarModalAddProductoAdminProducto").jqxButton({width: '70'});


        }
    });
}

function eventUpdateGridProductoEnsayosAdminProducto(rowData) {

    var idProductoEnsayo = rowData.idProductoEnsayo;
    var descripcion = rowData.descripcion;
    var especificacion = rowData.especificacion;
    var idMetodo = rowData.idMetodo;
    var tiempo = rowData.tiempo;
    var valor = rowData.valor;
    var resultado = rowData.tipoResultado;

    ajaxUpdateProductoEnsayo(idProductoEnsayo, descripcion, especificacion, idMetodo, tiempo, valor, resultado)

}

function loadButtonEliminarPaqueteAdminProducto() {
    $("#buttonEliminarPaqueteAdminProducto").jqxButton({template: "danger", width: 100, height: 55});
}

function loadButtonAgregarPaqueteAdminProducto() {
    $("#buttonAgregarPaqueteAdminProducto").jqxButton({template: "primary", width: 100, height: 55});
}

function loadButtonAgregarPrinActivoAdminProducto() {
    $("#buttonAgregarPrinActivoAdminProducto").jqxButton({template: "primary", width: 150, height: 75});
}

function loadButtonEliminarPrinActivoAdminProducto() {
    $("#buttonEliminarPrinActivoAdminProducto").jqxButton({template: "danger", width: 150, height: 75});
}

function loadGridAllProductoAdminProducto() {

    var urlDropDownListForma = "model/DB/jqw/FormaData.php?query=combo";

    var sourceDropDownListForma =
            {
                datatype: "json",
                datafields: [
                    {name: 'idFormaf', type: 'int'},
                    {name: 'descripcionFormaf', type: 'string'}
                ],
                url: urlDropDownListForma,
                async: false
            };
    var dataAdapterDropDownListForma = new $.jqx.dataAdapter(sourceDropDownListForma);



    var url = "model/DB/jqw/productoData.php?query=todos";

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'nombre', type: 'string'},
                    //{ name: 'tecnica', type: 'string'},
                    //{ name: 'tiempoEntrega', type: 'int'},
                    {name: 'idFormulaFarma', type: 'int'},
                    {name: 'desFormulaFarma', type: 'string'},
                    {name: 'idTipoProducto', type: 'int'},
                    {name: 'tipoProducto', type: 'string'},
                    {name: 'activo', type: 'int'}
                ],
                id: 'id',
                url: url,
                root: 'data',
                updaterow: function (rowid, rowdata, commit) {
                    var id = rowdata.id;
                    var nombre = rowdata.nombre;
                    var formaf = rowdata.idFormulaFarma;
                    
                    var newProducto = {
                        id: id,
                        nombre: nombre
                    }

                    var productosData = $("#gridAllProductoAdminProducto").jqxGrid('getrows');
                    var validarRep = productosData.find(function (producto) {
                        return producto.nombre == this.nombre && producto.id != this.id;
                    }, newProducto);
                    if (validarRep == undefined) {
                        ajaxUpdateProducto(id, nombre, formaf);
                        commit(true);
                    } else {
                        openNotificationAdminProducto('error', 'Ya existe un principio activo, con el nombre ' + nombre + '.');
                        commit(false);
                    }

                    
                    commit(true);
                }
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridAllProductoAdminProducto").jqxGrid(
            {
                width: 1000,
                height: 300,
                source: dataAdapter,
                columnsresize: true,
                showstatusbar: true,
                sortable: true,
                filterable: true,
                showfilterrow: true,
                selectionmode: 'singlecell',
                editable: true,
                editmode: 'dblclick',
                enabletooltips: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'></span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'></span></div>");
                    container.append(addButton);
                    statusbar.append(container);
                    container.append(deleteButton);
                    container.append(reloadButton);
                    addButton.jqxButton({width: 60, height: 20});
                    deleteButton.jqxButton({width: 60, height: 20});
                    reloadButton.jqxButton({width: 60, height: 20});
                    addButton.click(function (event) {
                        $('#windowAddProductoAdminProducto').jqxWindow('open');
                    });
                    // delete selected row.
                    deleteButton.click(function (event) {
                        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
                        //var rowindex = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedrowindex');
                        var selectedIndex = cell.rowindex;
                        if (selectedIndex != null) {
                            var id = $('#gridAllProductoAdminProducto').jqxGrid('getrowid', selectedIndex);
                            var data = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', selectedIndex);
                            ajaxDeleteProducto(id, 0, data.nombre);

                        }
                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $('#gridAllProductoAdminProducto').jqxGrid('updatebounddata');
                    });


                },
                columns: [
                    {text: 'idProducto', dataField: 'id', filtertype: 'input', width: 20, hidden: true},
                    {text: 'Nombre del Producto', dataField: 'nombre', filtertype: 'input', width: '700'},
                    {text: 'Técnica', dataField: 'tecnica', filtertype: 'input', width: '120', editable: true, hidden: true},
                    {text: 'Tiempo Entrega', dataField: 'tiempoEntrega', filtertype: 'number', width: '120', hidden: true, editable: true},
                    //{ text: 'idFormaFarma', dataField: 'idFormulaFarma', filtertype: 'number', width: '20%', hidden: true, editable:false },
                    //         { text: 'Forma Farmacéutica', dataField: 'desFormulaFarma', filtertype: 'input', width: '280', editable:false},

                    {text: 'Forma Farmacéutica', dataField: 'idFormulaFarma', displayfield: 'desFormulaFarma', columntype: 'dropdownlist', width: '280', hidden: false,
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({source: dataAdapterDropDownListForma, displayMember: 'descripcionFormaf', valueMember: 'idFormaf'});
                        }
                    },
                    {text: 'idTipoProducto', dataField: 'idTipoProducto', filtertype: 'number', width: '10%', hidden: true, editable: false},
                    {text: 'Tipo Producto', dataField: 'tipoProducto', filtertype: 'input', width: '10%', hidden: true, editable: false},
                    {text: 'activo', dataField: 'activo', filtertype: 'number', width: '20%', hidden: true, editable: false}
                ]
            });
}

function eventRowSelectGridAllProductoAdminProducto() {
    $('#gridAllProductoAdminProducto').on('cellselect', function (event)
    {
        $('#tabsDetalleProductoAdminProducto').jqxTabs('select', 0);

        var args = event.args;

        var dataField = event.args.datafield;

        var rowBoundIndex = event.args.rowindex;

        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        $("#tituloDetalleProductoAdminProducto").text("Detalle del Producto: " + rowData.nombre);
        utilLoadGridProductoPaquetesAdminProducto(rowData.id);
        //utilLoadGridProductoPrinActivoAdminProducto(rowData.id);


    });
}

function eventBindingGridProductoPaquetesAdminProducto() {
    $("#gridProductoPaquetesAdminProducto").on("bindingcomplete", function (event) {
        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
        var rowBoundIndex = cell.rowindex;

        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        utilLoadgridPaquetesDisponiblesAdminProducto(rowData.id);
    });
}

function eventBindingGridPaquetesDisponiblesAdminProducto() {
    $("#gridPaquetesDisponiblesAdminProducto").on("bindingcomplete", function (event) {
        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
        var rowBoundIndex = cell.rowindex;

        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        utilLoadGridProductoEnsayosAdminProducto(rowData.id);
    });
}

function eventBindingGridProductoEnsayosAdminProducto() {
    $("#gridProductoEnsayosAdminProducto").on("bindingcomplete", function (event) {
        $('#gridProductoEnsayosAdminProducto').jqxGrid('addgroup', 'desPaquete');

        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
        var rowBoundIndex = cell.rowindex;
        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        utilLoadGridProductoPrinActivoAdminProducto(rowData.id);
    });
}

function eventBindingGridProductoPrinActivoAdminProducto() {
    $("#gridProductoPrinActivoAdminProducto").on("bindingcomplete", function (event) {


        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
        var rowBoundIndex = cell.rowindex;
        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        utilLoadGridPrinActivoDisponiblesAdminProducto(rowData.id);
    });
}

function eventClickButtonAgregarPaqueteAdminProducto() {
    $('#buttonAgregarPaqueteAdminProducto').on('click', function () {
        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
        var rowBoundIndex = cell.rowindex;
        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        var idProducto = rowData.id;

        var rowindexes = $('#gridPaquetesDisponiblesAdminProducto').jqxGrid('getselectedrowindexes');
        var data = [];
        for (var i = 0; i < rowindexes.length; i++) {
            data[i] = $('#gridPaquetesDisponiblesAdminProducto').jqxGrid('getrowdata', rowindexes[i]);
            data[i].idProducto = idProducto;

        }
        var myJsonString = JSON.stringify(data);
        // alert(myJsonString);
        $("#hgridPaquetesDisponiblesAdminProducto").val(myJsonString);
        var ensayosAsignar = $("#hgridPaquetesDisponiblesAdminProducto").serialize();
        //alert(ensayosAsignar);
        ajaxInsertProductoPaquete(ensayosAsignar);
    });
}

function eventClickButtonEliminarPaqueteAdminProducto() {
    $('#buttonEliminarPaqueteAdminProducto').on('click', function () {


        var rowindexes = $('#gridProductoPaquetesAdminProducto').jqxGrid('getselectedrowindexes');
        var data = [];
        for (var i = 0; i < rowindexes.length; i++) {
            data[i] = $('#gridProductoPaquetesAdminProducto').jqxGrid('getrowdata', rowindexes[i]);
        }
        var myJsonString = JSON.stringify(data);
        $("#hgridProductoPaquetesAdminProducto").val(myJsonString);
        var ensayosEliminar = $("#hgridProductoPaquetesAdminProducto").serialize();
        ajaxDeleteProductoPaquete(ensayosEliminar);
    });
}

function eventClickButtonAgregarPrinActivoAdminProducto() {
    $('#buttonAgregarPrinActivoAdminProducto').on('click', function () {

        var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
        var rowBoundIndex = cell.rowindex;
        var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
        var idProducto = rowData.id;

        var rowindexes = $('#gridPrinActivoDisponiblesAdminProducto').jqxGrid('getselectedrowindexes');
        var data = [];
        var aux;
        for (var i = 0; i < rowindexes.length; i++) {
            data[i] = new Object();
            aux = $('#gridPrinActivoDisponiblesAdminProducto').jqxGrid('getrowdata', rowindexes[i]);
            data[i].idProducto = idProducto;
            data[i].idPrincipioActivo = aux.id;
        }
        var myJsonString = JSON.stringify(data);
        $("#hgridPrinActivoDisponiblesAdminProducto").val(myJsonString);
        var principiosActivosAsignar = $("#hgridPrinActivoDisponiblesAdminProducto").serialize();
        ajaxInsertPrincipioActivoProducto(principiosActivosAsignar);
    });
}

function eventClickButtonEliminarPrinActivoAdminProducto() {
    $('#buttonEliminarPrinActivoAdminProducto').on('click', function () {

        //alert("delete principio activo");
        var rowindexes = $('#gridProductoPrinActivoAdminProducto').jqxGrid('getselectedrowindexes');
        var data = [];
        var aux;
        for (var i = 0; i < rowindexes.length; i++) {
            data[i] = new Object();
            aux = $('#gridProductoPrinActivoAdminProducto').jqxGrid('getrowdata', rowindexes[i]);
            data[i].idProductoPrincipioActivo = aux.id;
        }
        var myJsonString = JSON.stringify(data);
        $("#hgridProductoPrinActivoAdminProducto").val(myJsonString);
        var productoPrincipioActivoEliminar = $("#hgridProductoPrinActivoAdminProducto").serialize();
        ajaxDeleteProductoPrincipioActivo(productoPrincipioActivoEliminar);
    });
}

function eventCloseWindowAddProductoAdminProducto() {
    $('#windowAddProductoAdminProducto').on('close', function (event) {
        $("#inputNomProductoAddProductoAdminProducto").jqxInput('val', '');

        $("#dropDownFormaAddProductoAdminProducto").jqxDropDownList('selectIndex', 0);
        //$("#inputTecnicaAddProductoAdminProducto").jqxInput('val','');
        //$("#numberInputTiempoAddProductoAdminProducto").jqxNumberInput('val','');
    });
}

function utilUpdateGrids() {
    $('#gridProductoPaquetesAdminProducto').jqxGrid('clearselection');
    $('#gridPaquetesDisponiblesAdminProducto').jqxGrid('clearselection');
    $('#gridProductoEnsayosAdminProducto').jqxGrid('clearselection');


    var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
    var rowBoundIndex = cell.rowindex;
    var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
    var idProducto = rowData.id;

    utilLoadGridProductoPaquetesAdminProducto(idProducto);

}

function utilUpdateGridsDos() {

    try {
        $('#gridProductoPaquetesAdminProducto').jqxGrid('clearselection');
        $('#gridPaquetesDisponiblesAdminProducto').jqxGrid('clearselection');
        $('#gridProductoEnsayosAdminProducto').jqxGrid('clearselection');
        $('#gridProductoPrinActivoAdminProducto').jqxGrid('clearselection');
        $('#gridPrinActivoDisponiblesAdminProducto').jqxGrid('clearselection');
    } catch (err) {

    }


    var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
    var rowBoundIndex = cell.rowindex;
    var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
    var idProducto = rowData.id;
    $("#tituloDetalleProductoAdminProducto").text("Detalle del Producto: " + rowData.nombre);
    utilLoadGridProductoPrinActivoAdminProducto(idProducto);

}

function utilLoadGridProductoPaquetesAdminProducto(idProducto) {
    var url = "model/DB/jqw/productoPaqueteData.php?query=getProductoPaqueteByIdProducto&idProducto=" + idProducto;

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'idProductoPaquete', type: 'int'},
                    {name: 'idProducto', type: 'int'},
                    {name: 'idEnsayo', type: 'int'},
                    {name: 'nomProducto', type: 'string'},
                    {name: 'nomEnsayo', type: 'string'}
                ],
                id: 'idProductoPaquete',
                url: url,
                root: 'data',
                async: true
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridProductoPaquetesAdminProducto").jqxGrid(
            {
                width: 500,
                height: 300,
                source: dataAdapter,
                columnsresize: true,
                showstatusbar: true,
                sortable: true,
                filterable: true,
                showfilterrow: true,
                selectionmode: 'checkbox',
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    //var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");

                    container.append(addButton);

                    statusbar.append(container);
                    addButton.jqxButton({width: 60, height: 20});

                    addButton.click(function (event) {
                        $('#windowAddGridAdminEstandar').jqxWindow('open');

                    });
                },
                columns: [
                    {text: 'idProductoPaquete', dataField: 'idProductoPaquete', filtertype: 'number', width: 20, hidden: true},
                    {text: 'idProducto', dataField: 'idProducto', filtertype: 'number', width: '60%', hidden: true},
                    {text: 'idEnsayo', dataField: 'idEnsayo', filtertype: 'number', width: '10%', hidden: true},
                    {text: 'nomProducto', dataField: 'nomProducto', filtertype: 'input', width: '10%', hidden: true},
                    {text: 'Nombre del Paquete', dataField: 'nomEnsayo', filtertype: 'input', width: '600'}
                ]
            });
}

function utilLoadgridPaquetesDisponiblesAdminProducto(idProducto) {
    var url = "model/DB/jqw/EnsayoData.php?query=getPaquetesDisponiblesByIdProducto&idProducto=" + idProducto;

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'idEnsayo', type: 'int'},
                    {name: 'descripcion', type: 'string'}
                ],
                id: 'idEnsayo',
                url: url,
                root: 'data',
                async: true
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridPaquetesDisponiblesAdminProducto").jqxGrid(
            {
                width: 500,
                height: 300,
                source: dataAdapter,
                columnsresize: true,
                showstatusbar: true,
                sortable: true,
                filterable: true,
                showfilterrow: true,
                selectionmode: 'checkbox',
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    //var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");

                    container.append(addButton);

                    statusbar.append(container);
                    addButton.jqxButton({width: 60, height: 20});

                    addButton.click(function (event) {
                        $('#windowAddGridAdminEstandar').jqxWindow('open');

                    });
                },
                columns: [
                    {text: 'idPaquete', dataField: 'idEnsayo', filtertype: 'number', width: 20, hidden: true},
                    {text: 'Paquete', dataField: 'descripcion', filtertype: 'input', width: '600'}
                ]
            });
}

function utilLoadGridProductoEnsayosAdminProducto(idProducto) {

    var urlDropDownListMetodo = "model/DB/jqw/metodoData.php?query=getAllMetodo";

    var sourceDropDownListMetodo =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'descripcion', type: 'string'}
                ],
                url: urlDropDownListMetodo,
                async: false
            };
    var dataAdapterDropDownListMetodo = new $.jqx.dataAdapter(sourceDropDownListMetodo);


    var url = "model/DB/jqw/productoEnsayoData.php?query=getProductoEnsayoByIdProducto&idProducto=" + idProducto;

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'idProductoEnsayo', type: 'int'},
                    {name: 'idEnsayo', type: 'int'},
                    {name: 'idProducto', type: 'int'},
                    {name: 'tiempo', type: 'int'},
                    {name: 'idMetodo', type: 'int'},
                    {name: 'valor', type: 'int'},
                    {name: 'descripcion', type: 'string'},
                    {name: 'especificacion', type: 'string'},
                    {name: 'idProductoPaquete', type: 'int'},
                    {name: 'tipoResultado', type: 'string'},
                    {name: 'metodo', type: 'string'},
                    {name: 'idPaquete', type: 'int'},
                    {name: 'desPaquete', type: 'string'},
                    {name: 'desOriginal', type: 'string'},
                ],
                id: 'idProductoEnsayo',
                url: url,
                root: 'data',
                async: true,
                updaterow: function (rowid, rowdata, commit) {

                    eventUpdateGridProductoEnsayosAdminProducto(rowdata);
                    commit(true);
                },
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridProductoEnsayosAdminProducto").jqxGrid(
            {
                width: 1100,
                height: 300,
                source: dataAdapter,
                columnsresize: false,
                editable: true,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                columns: [
                    {text: 'Paquete', dataField: 'desPaquete', width: 150, hidden: true},
                    {text: 'Descripción General', dataField: 'desOriginal', width: 200, hidden: false, editable: false},
                    {text: 'Descripción Especifica', dataField: 'descripcion', width: 200, hidden: false, },
                    {text: 'Especificación', dataField: 'especificacion', width: 600, editable: true},
                    {text: 'Método', dataField: 'idMetodo', displayfield: 'metodo', columntype: 'dropdownlist', width: 100, hidden: false,
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({source: dataAdapterDropDownListMetodo, displayMember: 'descripcion', valueMember: 'id'});
                        }
                    },
                    {text: 'Tiempo', dataField: 'tiempo', width: 100, columntype: 'numberinput'},
                    {text: 'Valor', dataField: 'valor', width: 100, columntype: 'numberinput' , hidden: true},
                    {text: 'Tipo de Resultado', dataField: 'tipoResultado', width: 100},
                    {text: 'idProductoEnsayo', dataField: 'idProductoEnsayo', width: 100, hidden: true, editable: false},
                    {text: 'idEnsayo', dataField: 'idEnsayo', width: 100, hidden: true, editable: false},
                    {text: 'idProducto', dataField: 'idProducto', width: 100, hidden: true},
                    {text: 'idProductoPaquete', dataField: 'idProductoPaquete', width: 100, hidden: true, editable: false},
                    {text: 'idPaquete', dataField: 'idPaquete', width: 100, hidden: true, editable: false}
                ],
                groupable: true,
                groups: ['desPaquete']
            });
}

function utilLoadGridProductoPrinActivoAdminProducto(idProducto) {


    var url = "model/DB/jqw/principioActivoProductoData.php?query=getPrincipioActivoProductoByIdProducto&idProducto=" + idProducto;

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'idProducto', type: 'int'},
                    {name: 'idPrincipioActivo', type: 'int'},
                    {name: 'principal', type: 'int'},
                    {name: 'trasador', type: 'int'},
                    {name: 'cantidad', type: 'int'},
                    {name: 'unidadCantidad', type: 'int'},
                    {name: 'cantidadDecimal', type: 'int'},
                    {name: 'nomPrincipioActivo', type: 'int'}
                ],
                id: 'id',
                url: url,
                root: 'data',
                async: true,
                filterable: true,
                updaterow: function (rowid, rowdata, commit) {

                    //eventUpdateGridProductoEnsayosAdminProducto(rowdata);
                    var principal = rowdata.principal;
                    var trasador = rowdata.trasador;
                    var cantidad = rowdata.cantidad;
                    var unidadCantidad = rowdata.unidadCantidad;
                    var cantidadDecimal = rowdata.cantidadDecimal;
                    var idPrincipioActivoProducto = rowdata.id;

                    ajaxUpdatePrincipioActivoProducto(principal, trasador, cantidad, unidadCantidad, cantidadDecimal, idPrincipioActivoProducto);
                    // alert("update principio activo producto");
                    commit(true);
                },
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridProductoPrinActivoAdminProducto").jqxGrid(
            {
                width: 620,
                height: 300,
                source: dataAdapter,
                columnsresize: false,
                editable: true,
                selectionmode: 'checkbox',
                columns: [
                    {text: 'id', dataField: 'id', width: 150, hidden: true},
                    {text: 'idProducto', dataField: 'idProducto', width: 250, hidden: true, editable: false},
                    {text: 'idPrincipioActivo', dataField: 'idPrincipioActivo', width: 250, hidden: true},
                    {text: 'Principio Activo', dataField: 'nomPrincipioActivo', width: 150, columntype: 'numberinput', editable: false},
                    {text: 'Principal', dataField: 'principal', width: 80, columntype: 'numberinput'},
                    {text: 'Trazador', dataField: 'trasador', width: 80, columntype: 'numberinput'},
                    {text: 'Cantidad', dataField: 'cantidad', width: 80, columntype: 'numberinput'},
                    {text: 'Uni. Cantidad', dataField: 'unidadCantidad', width: 100, columntype: 'numberinput'},
                    {text: 'Cant. Decimal', dataField: 'cantidadDecimal', width: 100, columntype: 'numberinput'}
                ]
            });
}

function utilLoadGridPrinActivoDisponiblesAdminProducto(idProducto) {


    var url = "model/DB/jqw/principioActivoProductoData.php?query=getPrincipioActivoDisponibleByIdProducto&idProducto=" + idProducto;

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'nombre', type: 'string'}
                ],
                id: 'id',
                url: url,
                root: 'data',
                async: true
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridPrinActivoDisponiblesAdminProducto").jqxGrid(
            {
                width: 240,
                height: 300,
                source: dataAdapter,
                selectionmode: 'checkbox',
                filterable: true,
                showfilterrow: true,
                columns: [
                    {text: 'id', dataField: 'id', width: 150, filtertype: 'number', hidden: true},
                    {text: 'nombre', dataField: 'nombre', width: 200, filtertype: 'input', hidden: false}
                ]
            });
}

function ajaxDeleteProductoPaquete(dataProductoPaquete) {
    var url = "index.php";
    var data = "action=deleteProductoPaquete";
    data = data + "&" + dataProductoPaquete;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            utilUpdateGrids();
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxInsertProductoPaquete(dataProductoEnsayo) {
    var url = "index.php";
    var data = "action=insertProductoEnsayo";
    //alert(dataProductoEnsayo);
    data = data + "&" + dataProductoEnsayo;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            utilUpdateGrids();
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxUpdateProductoEnsayo(idProductoEnsayo, descripcion, especificacion, idMetodo, tiempo, valor, resultado) {
    var url = "index.php";
    var data = "action=updateProductoEnsayo";
    data = data + "&idProductoEnsayo=" + idProductoEnsayo;
    data = data + "&descripcion=" + descripcion;
    data = data + "&especificacion=" + especificacion;
    data = data + "&idMetodo=" + idMetodo;
    data = data + "&tiempo=" + tiempo;
    data = data + "&valor=" + valor;
    data = data + "&resultado=" + resultado;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            //utilUpdateGrids();
//            var response = JSON.parse(data);
//            if (response != null) {
//                
//                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
//            } else {
//                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
//            }
        }
    });
}

function loadNotificationAdminProducto() {
    $("#notificationAdminProducto").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function openNotificationAdminProducto(template, message) {
    $("#messageNotificationAdminProducto").text(message);
    $("#notificationAdminProducto").jqxNotification({template: template});
    $("#notificationAdminProducto").jqxNotification("open");
}

function ajaxCreateProducto(nombre, idFormaFarma, estado, tecnica, timepoEntrega) {

    var url = "index.php";
    var data = "action=crearProducto";
    data = data + "&nombre=" + nombre;
    data = data + "&idFormaFarma=" + idFormaFarma;
    data = data + "&estado=" + estado;
    data = data + "&tecnica=" + tecnica;
    data = data + "&timepoEntrega=" + timepoEntrega;


    $.ajax({
        type: "POST",
        url: url,
        data: {
            action: 'crearProducto',
            nombre: nombre,
            idFormaFarma: idFormaFarma,
            estado: estado,
            tecnica: tecnica,
            timepoEntrega: timepoEntrega
        },
        async: false,
        success: function (data, textStatus, jqXHR) {

            var response = JSON.parse(data);
            if (response != null) {
                if (response.result == 0) {
                    $('#gridAllProductoAdminProducto').jqxGrid('clearselection');
                    $('#gridAllProductoAdminProducto').jqxGrid('updatebounddata');

                    openNotificationAdminProducto('success', "Se ha registrado exitosamente el producto.");
                } else {
                    eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del producto.");
                }
            } else {
                eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del producto.");
            }
        }
    });
}

function ajaxUpdatePrincipioActivoProducto(principal, trasador, cantidad, unidadCantidad, cantidadDecimal, idPrincipioActivoProducto) {
    var url = "index.php";
    var data = "action=updatePrincipioActivoProducto";
    data = data + "&principal=" + principal;
    data = data + "&trasador=" + trasador;
    data = data + "&cantidad=" + cantidad;
    data = data + "&unidadCantidad=" + unidadCantidad;
    data = data + "&cantidadDecimal=" + cantidadDecimal;
    data = data + "&idPrincipioActivoProducto=" + idPrincipioActivoProducto;



    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var cell = $('#gridAllProductoAdminProducto').jqxGrid('getselectedcell');
            var rowBoundIndex = cell.rowindex;
            var rowData = $('#gridAllProductoAdminProducto').jqxGrid('getrowdata', rowBoundIndex);
            utilLoadGridProductoPrinActivoAdminProducto(rowData.id);
            var response = JSON.parse(data);
            if (response != null) {
                if (response.result == 0) {

                } else {

                }
            } else {

            }
        }
    });
}

function ajaxInsertPrincipioActivoProducto(dataPrincipioActivoProducto) {
    var url = "index.php";
    var data = "action=insertPrincipioActivoProducto";
    data = data + "&" + dataPrincipioActivoProducto;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            utilUpdateGridsDos();
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxDeleteProductoPrincipioActivo(dataProductoPrincipioActivo) {
    var url = "index.php";
    var data = "action=deleteProductoPrincipioActivo";
    data = data + "&" + dataProductoPrincipioActivo;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            utilUpdateGridsDos();
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxUpdateProducto(idProducto, nombreProducto, formaf) {
    //alert(idProducto);alert(nombreProducto);alert(formaf);
    var url = "index.php";
    var data = "action=updateProducto";
    data = data + "&idProducto=" + idProducto;
    data = data + "&nombreProducto=" + nombreProducto;
    data = data + "&formaf=" + formaf;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#gridAllProductoAdminProducto').jqxGrid('updatebounddata');
            //utilUpdateGridsDos();
            setTimeout(function () {
                utilUpdateGridsDos();
            }, 500);

            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxDeleteProducto(idProducto, activo, nombre) {
    alert(idProducto);
    alert(activo);
    alert(nombre);
    var url = "index.php"
    var data = "action=deleteProducto";
    data = data + "&idProducto=" + idProducto;
    data = data + "&activo=" + activo;
    data = data + "&nombre=" + nombre;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllPaquetesAdminPaquete').jqxGrid('updatebounddata');
                setTimeout(function () {
                    $('#gridAllPaquetesAdminPaquete').jqxGrid('selectcell', 0, 'descripcion');
                }, 2000);
                eventOpenNotificationAdminEnsayo('success', response.message);
            } else {
                eventOpenNotificationAdminEnsayo('error', response.message);
            }

        }
    });
}





