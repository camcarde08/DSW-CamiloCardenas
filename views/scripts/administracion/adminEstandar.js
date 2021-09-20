function initLoadEstandarAdmin(idPerfil, idUsuario) {
    //load components
    loadGridAllEstandarlAdminEstandar();
    loadGridAllReactivoAdminEstandar();
    loadWindowAddGridAdminEstandar();
    loadWindowAddGridAdminReactivo();
    // load Events
    eventCloseWindowAddGridAdminEstandar();
    eventCloseWindowAddGridAdminReactivo();
    eventClickButtonOKModalCrearEstandarAdminEstandar();
    eventClickButtonOKModalCrearReactivoAdminEstandar();

}

function loadWindowAddGridAdminEstandar() {
    $('#windowAddGridAdminEstandar').jqxWindow({
        isModal: true,
        height: 520,
        width: 460,
        title: 'Agregar Estándar',
        autoOpen: false,
        cancelButton: $('#buttonCancelModalCrearEstandarAdminEstandar'),
        position: { x: 400, y: 100 },
        initContent: function () {
            $("#buttonOKModalCrearEstandarAdminEstandar").jqxButton({ width: '70' });
            $("#buttonCancelModalCrearEstandarAdminEstandar").jqxButton({ width: '70' });
            $("#inputNombreEstandarAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputLoteEstandarAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputCantidadEstandarAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputDateFechaVencimientoEstandarAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            //$("#inputTipoEstandarAdminEstandar").jqxInput({width: '400', height: '25'});
            var source = ['Estandar', 'Cepa'];
            $("#inputTipoEstandarAdminEstandar").jqxDropDownList({ source: source, selectedIndex: 0, width: '400', height: '25', dropDownHeight: 55 });
            $("#inputCantidadActualEstandarAdminEstandar").jqxNumberInput({ width: '400', height: '25px', spinButtons: false, decimalDigits: 0 });
            $("#inputStockEstandarAdminEstandar").jqxNumberInput({ width: '400', height: '25px', spinButtons: false, decimalDigits: 0 });
            //loadGridAreasAnalisisWindowAddGridAdminEnsayo();
            $("#inputLoteInternoEstandarAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputDateFechaPreparacionEstandarAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            $("#inputDateFechaPromocionEstandarAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            $("#inputCantidad2EstandarAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputCodigoEstandarAdminEstandar").jqxInput({ width: '400', height: '25' });
        }
    });
}

function loadWindowAddGridAdminReactivo() {
    $('#windowAddGridAdminReactivo').jqxWindow({
        isModal: true,
        height: 520,
        width: 460,
        title: 'Agregar Reactivo',
        autoOpen: false,
        cancelButton: $('#buttonCancelModalCrearReactivoAdminEstandar'),
        position: { x: 400, y: 600 },
        initContent: function () {
            $("#buttonOKModalCrearReactivoAdminEstandar").jqxButton({ width: '70' });
            $("#buttonCancelModalCrearReactivoAdminEstandar").jqxButton({ width: '70' });
            $("#inputNombreReactivoAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputLoteReactivoAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputCantidadReactivoAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputDateFechaVencimientoReactivoAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            var source = ['Reactivo', 'Medio'];
            $("#inputTipoReactivoAdminEstandar").jqxDropDownList({ source: source, selectedIndex: 0, width: '400', height: '25', dropDownHeight: 55 });
            $("#inputCantidadActualReactivoAdminEstandar").jqxNumberInput({ width: '400', height: '25px', spinButtons: false, decimalDigits: 0 });
            $("#inputStockReactivoAdminEstandar").jqxNumberInput({ width: '400', height: '25px', spinButtons: false, decimalDigits: 0 });
            $("#inputLoteInternoReactivoAdminEstandar").jqxInput({ width: '400', height: '25' });
            $("#inputDateFechaPaseReactivoAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            $("#inputDateFechaIngresoReactivoAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            $("#inputDateFechaAperturaReactivoAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            $("#inputDateFechaTerminacionReactivoAdminEstandar").jqxDateTimeInput({ width: '400', height: '25' });
            //loadGridAreasAnalisisWindowAddGridAdminEnsayo();

        }
    });
}

function loadGridAllReactivoAdminEstandar() {
    var url = "model/DB/jqw/ReactivoData.php?query=all";

    var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'int' },
                { name: 'nombre', type: 'string' },
                { name: 'lote', type: 'string' },
                { name: 'cantidad', type: 'string' },
                { name: 'fecVencimiento', type: 'date' },
                { name: 'activo', type: 'int' },
                { name: 'tipo', type: 'string' },
                { name: 'cantidadActual', type: 'int' },
                { name: 'fechaIngreso', type: 'date' },
                { name: 'fechaApertura', type: 'date' },
                { name: 'fechaTerminacion', type: 'date' },
                { name: 'stock', type: 'int' },
                { name: 'lote_interno', type: 'string' },
                { name: 'fecha_pase', type: 'date' }
            ],
            id: 'id',
            url: url,
            root: 'data',
            sync: false,
            updaterow: function (rowid, rowdata, commit) {

                var newReactivo = {
                    id: rowdata.id,
                    nombre: rowdata.nombre
                };
                var reactivosData = $("#gridAllReactivoAdminEstandar").jqxGrid('getrows');
                var validacionRepetido = reactivosData.find(function (reactivo) {
                    return this.nombre == reactivo.nombre && this.id != reactivo.id;
                }, newReactivo);
                if (validacionRepetido == undefined) {
                    ajaxUpdateReactivo(rowdata.id, rowdata.nombre, rowdata.lote, rowdata.cantidad, rowdata.fecVencimiento,rowdata.fechaIngreso,rowdata.fechaApertura,rowdata.fechaTerminacion, rowdata.tipo, rowdata.cantidadActual, rowdata.stock, rowdata.lote_interno, rowdata.fecha_pase);
                    commit(true);
                } else {
                    openNotificationAdminEstandar('error', "Ya existe un reactivo con el nombre " + rowdata.nombre + ".");
                    commit(false);
                }

            }
        };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridAllReactivoAdminEstandar").jqxGrid(
        {
            width: 1200,
            height: 300,
            source: dataAdapter,
            columnsresize: true,
            editable: true,
            enabletooltips: true,
            selectionmode: 'checkbox',
            showstatusbar: true,
            editmode: 'dblclick',
            renderstatusbar: function (statusbar) {
                // appends buttons to the status bar.
                var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");
                var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");
                container.append(addButton);
                container.append(deleteButton);
                container.append(reloadButton);
                statusbar.append(container);
                addButton.jqxButton({ width: 60, height: 20 });
                deleteButton.jqxButton({ width: 65, height: 20 });
                reloadButton.jqxButton({ width: 65, height: 20 });
                // add new row.
                addButton.click(function (event) {
                    $('#windowAddGridAdminReactivo').jqxWindow('open');

                });
                // delete selected row.
                deleteButton.click(function (event) {
                    var selectedIndexes = $('#gridAllReactivoAdminEstandar').jqxGrid('getselectedrowindexes');
                    if (selectedIndexes != null) {
                        $('#gridAllReactivoAdminEstandar').jqxGrid('clearselection');
                        ;
                    }
                    for (var i = 0; i < selectedIndexes.length; i++) {
                        var id = $('#gridAllReactivoAdminEstandar').jqxGrid('getrowid', selectedIndexes[i]);
                        var data = $('#gridAllReactivoAdminEstandar').jqxGrid('getrowdata', selectedIndexes[i]);
                        ajaxDeleteReactivo(id, 0, data.nombre);
                        //openNotificationAdminEquipo('success', data.descripcion);
                    }


                });
                // reload grid data.
                reloadButton.click(function (event) {
                    $('#gridAllReactivoAdminEstandar').jqxGrid('updatebounddata');
                });




            },
            columns: [
                { text: 'idEstandar', dataField: 'id', filtertype: 'input', width: 1200, hidden: true },
                { text: 'Nombre Reactivo o Medio', dataField: 'nombre', filtertype: 'number', width: '20%' },
                { text: 'Lote', dataField: 'lote', filtertype: 'number', width: '10%' },
                { text: 'Cantidad', dataField: 'cantidad', filtertype: 'number', width: '10%' },
                             { text: 'Fecha de Ingreso', dataField: 'fechaIngreso', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha de Apertura', dataField: 'fechaApertura', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha de Terminacion', dataField: 'fechaTerminacion', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha de Vencimiento', dataField: 'fecVencimiento', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'tipo', dataField: 'tipo', filtertype: 'input', width: '7%', columntype: 'dropdownlist',
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({ source: ['Reactivo', 'Medio'] });
                        } },
                { text: 'cantidad actual', dataField: 'cantidadActual', filtertype: 'number', width: '10%' },
                { text: 'stock', dataField: 'stock', filtertype: 'number', width: '10%' },
                { text: 'Lote Interno', dataField: 'lote_interno', filtertype: 'input', width: '10%' },
                { text: 'Fecha pase', dataField: 'fecha_pase', filtertype: 'range', width: '10%',columntype: 'datetimeinput', cellsformat: 'yy/MM/dd'},

            ]
        });
}



function loadGridAllEstandarlAdminEstandar() {
    var url = "model/DB/jqw/EstandarData.php?query=all";

    var source =
        {
            datatype: "json",
            datafields: [
                { name: 'id', type: 'int' },
                { name: 'nombre', type: 'string' },
                { name: 'lote', type: 'string' },
                { name: 'cantidad', type: 'string' },
                { name: 'fecVencimiento', type: 'date' },
                { name: 'activo', type: 'int' },
                { name: 'tipo', type: 'string' },
                { name: 'cantidadActual', type: 'int' },
                { name: 'fechaIngreso', type: 'date' },
                { name: 'fechaApertura', type: 'date' },
                { name: 'fechaTerminacion', type: 'date' },
                { name: 'stock', type: 'int' },
                { name: 'loteInterno', type: 'int' },
                { name: 'fechaPreparacion', type: 'date' },
                { name: 'fechaPromocion', type: 'date' },
                { name: 'cantidadPreparada', type: 'date' },
                { name: 'codigo', type: 'int' }
            ],
            id: 'id',
            url: url,
            root: 'data',
            sync: false,
            updaterow: function (rowid, rowdata, commit) {

                var newStandar = {
                    id: rowdata.id,
                    nombre: rowdata.nombre
                };
                var estandaresData = $("#gridAllEstandarlAdminEstandar").jqxGrid('getrows');
                var validacionRepetido = estandaresData.find(function (estandar) {
                    return this.nombre == estandar.nombre && this.id != estandar.id;
                }, newStandar);
                if (validacionRepetido == undefined) {
                     ajaxUpdateEstandar(rowdata.id, rowdata.nombre, rowdata.lote, rowdata.cantidad, rowdata.fecVencimiento, rowdata.fechaIngreso,rowdata.fechaApertura,rowdata.fechaTerminacion,rowdata.tipo, rowdata.cantidadActual, rowdata.stock);
                    commit(true);
                } else {
                    openNotificationAdminEstandar('error', "Ya existe un estandar con el nombre " + rowdata.nombre + ".");
                    commit(false);
                }

            }
        };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridAllEstandarlAdminEstandar").jqxGrid(
        {
            width: 1200,
            height: 300,
            source: dataAdapter,
            columnsresize: true,
            editable: true,
            enabletooltips: true,
            selectionmode: 'checkbox',
            showstatusbar: true,
            editmode: 'dblclick',
            renderstatusbar: function (statusbar) {
                // appends buttons to the status bar.
                var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");
                var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");
                container.append(addButton);
                container.append(deleteButton);
                container.append(reloadButton);
                statusbar.append(container);
                addButton.jqxButton({ width: 60, height: 20 });
                deleteButton.jqxButton({ width: 65, height: 20 });
                reloadButton.jqxButton({ width: 65, height: 20 });
                // add new row.
                addButton.click(function (event) {
                    $('#windowAddGridAdminEstandar').jqxWindow('open');

                });
                // delete selected row.
                deleteButton.click(function (event) {
                    var selectedIndexes = $('#gridAllEstandarlAdminEstandar').jqxGrid('getselectedrowindexes');
                    if (selectedIndexes != null) {
                        $('#gridAllEstandarlAdminEstandar').jqxGrid('clearselection');
                        ;
                    }
                    for (var i = 0; i < selectedIndexes.length; i++) {
                        var id = $('#gridAllEstandarlAdminEstandar').jqxGrid('getrowid', selectedIndexes[i]);
                        var data = $('#gridAllEstandarlAdminEstandar').jqxGrid('getrowdata', selectedIndexes[i]);
                        ajaxDeleteEstandar(id, 0, data.nombre);
                        //openNotificationAdminEquipo('success', data.descripcion);
                    }


                });
                // reload grid data.
                reloadButton.click(function (event) {
                    $('#gridAllEstandarlAdminEstandar').jqxGrid('updatebounddata');
                });




            },
            columns: [
                { text: 'idEstandar', dataField: 'id', filtertype: 'input', width: 1200, hidden: true },
                { text: 'Nombre Estándar o Cepa', dataField: 'nombre', filtertype: 'number', width: '20%' },
                { text: 'Lote', dataField: 'lote', filtertype: 'number', width: '10%' },
                { text: 'Cantidad', dataField: 'cantidad', filtertype: 'number', width: '10%' },
                { text: 'Fecha de Ingreso', dataField: 'fechaIngreso', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha de Apertura', dataField: 'fechaApertura', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha de Terminacion', dataField: 'fechaTerminacion', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha de Vencimiento', dataField: 'fecVencimiento', filtertype: 'range', width: '10%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'tipo', dataField: 'tipo', filtertype: 'input', width: '7%', columntype: 'dropdownlist',
                        createeditor: function (row, value, editor) {
                        editor.jqxDropDownList({ source: ['Estandar', 'Cepa'] });
                } },
                { text: 'cantidad actual', dataField: 'cantidadActual', filtertype: 'number', width: '7%' },
                { text: 'stock', dataField: 'stock', filtertype: 'number', width: '7%' },
                { text: 'Lote Interno', dataField: 'loteInterno', filtertype: 'number', width: '7%' },
                { text: 'Fecha Preparacion', dataField: 'fechaPreparacion', filtertype: 'range', width: '7%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Fecha Promocion', dataField: 'fechaPromocion', filtertype: 'range', width: '7%', columntype: 'datetimeinput', cellsformat: 'yy/MM/dd' },
                { text: 'Cantidad Preparada', dataField: 'cantidadPreparada', filtertype: 'number', width: '7%' },
                { text: 'Codigo', dataField: 'codigo', filtertype: 'number', width: '7%' },

            ]
        });
}

function eventCloseWindowAddGridAdminEstandar() {
    $('#windowAddGridAdminEstandar').on('close', function (event) {
        $("#inputNombreEstandarAdminEstandar").jqxInput('val', '');
        $("#inputLoteEstandarAdminEstandar").jqxInput('val', '');
        $("#inputCantidadEstandarAdminEstandar").jqxInput('val', '');
        $("#inputDateFechaVencimientoEstandarAdminEstandar").jqxDateTimeInput('val', new Date());
        $("#inputTipoEstandarAdminEstandar").jqxDropDownList('selectIndex', 0 );
        $("#inputCantidadActualEstandarAdminEstandar").jqxNumberInput('val', 0);
        $("#inputStockEstandarAdminEstandar").jqxNumberInput('val', 0);
    });
}

function eventCloseWindowAddGridAdminReactivo() {
    $('#windowAddGridAdminReactivo').on('close', function (event) {
        $("#inputNombreReactivoAdminEstandar").jqxInput('val', '');
        $("#inputLoteReactivoAdminEstandar").jqxInput('val', '');
        $("#inputCantidadReactivoAdminEstandar").jqxInput('val', '');
        $("#inputDateFechaVencimientoReactivoAdminEstandar").jqxDateTimeInput('val', new Date());
        $("#inputTipoReactivoAdminEstandar").jqxDropDownList('selectIndex', 0 );
        $("#inputCantidadActualReactivoAdminEstandar").jqxNumberInput('val', 0);
        $("#inputStockReactivoAdminEstandar").jqxNumberInput('val', 0);
    });
}

function eventClickButtonOKModalCrearEstandarAdminEstandar() {
    $("#buttonOKModalCrearEstandarAdminEstandar").click(function (event) {

        //alert("hola");
        var nombreEstandar = $("#inputNombreEstandarAdminEstandar").jqxInput('val');
        if (nombreEstandar == '') {
            openNotificationAdminEstandar('error', "Debe digitar un nombre valido");
            return false;
        }
        var loteEstandar = $("#inputLoteEstandarAdminEstandar").jqxInput('val');
        if (loteEstandar == '') {
            openNotificationAdminEstandar('error', "Debe digitar un lote valido");
            return false;
        }
        var cantidadEstandar = $("#inputCantidadEstandarAdminEstandar").jqxInput('val');
        if (cantidadEstandar == '') {
            openNotificationAdminEstandar('error', "Debe digitar una cantidad valida");
            return false;
        }
        var tipo = $("#inputTipoEstandarAdminEstandar").jqxDropDownList('val');
        var cantidadActual = $("#inputCantidadActualEstandarAdminEstandar").jqxNumberInput('val');
        var stock = $("#inputStockEstandarAdminEstandar").jqxNumberInput('val');  
        
            
        var fechaVencimiento = $("#inputDateFechaVencimientoEstandarAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha = fechaVencimiento.getFullYear();
        var mesFecha = fechaVencimiento.getMonth() + 1;
        var diaFecha = fechaVencimiento.getDate();
        fechaVencimiento = anoFecha + "-" + mesFecha + "-" + diaFecha;

        var loteInterno = $("#inputLoteInternoEstandarAdminEstandar").jqxInput('val');
        if (loteInterno == '') {
            openNotificationAdminEstandar('error', "Debe digitar un lote interno valido.");
            return false;
        }

        var fechaPreparacion = $("#inputDateFechaPreparacionEstandarAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha2 = fechaPreparacion.getFullYear();
        var mesFecha2 = fechaPreparacion.getMonth() + 1;
        var diaFecha2 = fechaPreparacion.getDate();
        fechaPreparacion = anoFecha2 + "-" + mesFecha2 + "-" + diaFecha2;

        var fechaPromocion = $("#inputDateFechaPromocionEstandarAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha3 = fechaPromocion.getFullYear();
        var mesFecha3 = fechaPromocion.getMonth() + 1;
        var diaFecha3 = fechaPromocion.getDate();
        fechaPromocion = anoFecha3 + "-" + mesFecha3 + "-" + diaFecha3;

        var cantidad2 = $("#inputCantidad2EstandarAdminEstandar").jqxInput('val');
        if (cantidad2 == '') {
            openNotificationAdminEstandar('error', "Debe digitar una cantidad valida.");
            return false;
        }

        var codigo = $("#inputCodigoEstandarAdminEstandar").jqxInput('val');
        if (codigo == '') {
            openNotificationAdminEstandar('error', "Debe digitar un codigo valido.");
            return false;
        }

        var estandaresData = $("#gridAllEstandarlAdminEstandar").jqxGrid('getrows');
        var validacionRepetido = estandaresData.find(function (estandar) {
            return nombreEstandar == estandar.nombre;
        });
        if (validacionRepetido == undefined) {
            ajaxCrearEstandar(nombreEstandar, loteEstandar, cantidadEstandar, fechaVencimiento, tipo, cantidadActual, stock,loteInterno,fechaPreparacion,fechaPromocion,cantidad2,codigo);
        } else {
            openNotificationAdminEstandar('error', "Ya existe un estandar con el nombre " + nombreEstandar + ".");
            return false;
        }



        //var ensayos = $( "#ensayosRegCotizacion" ).serialize();
        //ajaxCrearEnsayo(descripcion, tiempo, esPaquete, areas);


    });
}

function eventClickButtonOKModalCrearReactivoAdminEstandar() {
    $("#buttonOKModalCrearReactivoAdminEstandar").click(function (event) {

        //alert("hola");
        var nombreReactivo = $("#inputNombreReactivoAdminEstandar").jqxInput('val');
        if (nombreReactivo == '') {
            openNotificationAdminEstandar('error', "Debe digitar un nombre valido");
            return false;
        }
        var loteReactivo = $("#inputLoteReactivoAdminEstandar").jqxInput('val');
        if (loteReactivo == '') {
            openNotificationAdminEstandar('error', "Debe digitar un lote valido");
            return false;
        }
        var cantidadReactivo = $("#inputCantidadReactivoAdminEstandar").jqxInput('val');
        if (cantidadReactivo == '') {
            openNotificationAdminEstandar('error', "Debe digitar una cantidad valida");
            return false;
        }
        var fechaVencimiento = $("#inputDateFechaVencimientoReactivoAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha = fechaVencimiento.getFullYear();
        var mesFecha = fechaVencimiento.getMonth() + 1;
        var diaFecha = fechaVencimiento.getDate();
        fechaVencimiento = anoFecha + "-" + mesFecha + "-" + diaFecha;

         var tipo = $("#inputTipoReactivoAdminEstandar").jqxDropDownList('val');
        var cantidadActual = $("#inputCantidadActualReactivoAdminEstandar").jqxNumberInput('val');
        var stock = $("#inputStockReactivoAdminEstandar").jqxNumberInput('val');

        var fechaIngreso = $("#inputDateFechaIngresoReactivoAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha = fechaIngreso.getFullYear();
        var mesFecha = fechaIngreso.getMonth() + 1;
        var diaFecha = fechaIngreso.getDate();
        fechaIngreso = anoFecha + "-" + mesFecha + "-" + diaFecha; 

        var fechaApertura = $("#inputDateFechaAperturaReactivoAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha = fechaApertura.getFullYear();
        var mesFecha = fechaApertura.getMonth() + 1;
        var diaFecha = fechaApertura.getDate();
        fechaApertura = anoFecha + "-" + mesFecha + "-" + diaFecha;

        var fechaTerminacion = $("#inputDateFechaTerminacionReactivoAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha = fechaTerminacion.getFullYear();
        var mesFecha = fechaTerminacion.getMonth() + 1;
        var diaFecha = fechaTerminacion.getDate();
        fechaTerminacion = anoFecha + "-" + mesFecha + "-" + diaFecha;

        var loteIterno = $("#inputLoteInternoReactivoAdminEstandar").jqxInput('val');

        var fechaPase = $("#inputDateFechaPaseReactivoAdminEstandar").jqxDateTimeInput('getDate');
        var anoFecha = fechaPase.getFullYear();
        var mesFecha = fechaPase.getMonth() + 1;
        var diaFecha = fechaPase.getDate();
        fechaPase = anoFecha + "-" + mesFecha + "-" + diaFecha; 

        var reactivosData = $("#gridAllReactivoAdminEstandar").jqxGrid('getrows');
        var validacionRepetido = reactivosData.find(function (reactivo) {
            return nombreReactivo == reactivo.nombre;
        });
        if (validacionRepetido == undefined) {
            ajaxCrearReactivo(nombreReactivo, loteReactivo, cantidadReactivo, fechaVencimiento, tipo, cantidadActual, stock,fechaIngreso,fechaApertura,fechaTerminacion,loteIterno,fechaPase);
        } else {
            openNotificationAdminEstandar('error', "Ya existe un estandar con el nombre " + nombreEstandar + ".");
            return false;
        }



        //var ensayos = $( "#ensayosRegCotizacion" ).serialize();
        //ajaxCrearEnsayo(descripcion, tiempo, esPaquete, areas);


    });
}

function openNotificationAdminEstandar(template, message) {
    $("#messageNotificationAdminEstandar").text(message);
    $("#notificationAdminEstandar").jqxNotification({ template: template });
    $("#notificationAdminEstandar").jqxNotification("open");
}
function ajaxUpdateEstandar(idEstandar, nombre, lote, cantidad, fecVencimiento,nuevaFechaIngreso,nuevaFechaApertura,nuevaFechaTerminacion, tipo, cantidadActual, stock) {

    var nuevaFecha = fecVencimiento.getFullYear() + "-" + (fecVencimiento.getMonth() + 1) + "-" + fecVencimiento.getDate();
    var nuevaFechaIngreso1 = nuevaFechaIngreso.getFullYear() + "-" + (nuevaFechaIngreso.getMonth() + 1) + "-" + nuevaFechaIngreso.getDate();
    var nuevaFechaApertura1 = nuevaFechaApertura.getFullYear() + "-" + (nuevaFechaApertura.getMonth() + 1) + "-" + nuevaFechaApertura.getDate();
    var nuevaFechaTerminacion1 = nuevaFechaTerminacion.getFullYear() + "-" + (nuevaFechaTerminacion.getMonth() + 1) + "-" + nuevaFechaTerminacion.getDate();
    
    var url = "index.php"
    var data = "action=updateEstandar";
    data = data + "&idEstandar=" + idEstandar;
    data = data + "&nombre=" + nombre;
    data = data + "&lote=" + lote;
    data = data + "&cantidad=" + cantidad;
    data = data + "&fecVencimiento=" + nuevaFecha;
    data = data + "&fechaIngreso=" + nuevaFechaIngreso1;
    data = data + "&fechaApertura=" + nuevaFechaApertura1;
    data = data + "&fechaTerminacion=" + nuevaFechaTerminacion1;
    data = data + "&tipo=" + tipo;
    data = data + "&cantidadActual=" + cantidadActual;
    data = data + "&stock=" + stock;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllEstandarlAdminEstandar').jqxGrid('updatebounddata');
                openNotificationAdminEstandar('success', response.message)

            } else {
                openNotificationAdminEstandar('error', response.message);

            }

        }
    });
}

function ajaxUpdateReactivo(idReactivo, nombre, lote, cantidad, fecVencimiento,nuevaFechaIngreso,nuevaFechaApertura,nuevaFechaTerminacion, tipo, cantidadActual, stock,lote_interno, fecha_pase) {

    var nuevaFecha = fecVencimiento.getFullYear() + "-" + (fecVencimiento.getMonth() + 1) + "-" + fecVencimiento.getDate();
    var nuevaFechaIngreso1 = nuevaFechaIngreso.getFullYear() + "-" + (nuevaFechaIngreso.getMonth() + 1) + "-" + nuevaFechaIngreso.getDate();
    var nuevaFechaApertura1 = nuevaFechaApertura.getFullYear() + "-" + (nuevaFechaApertura.getMonth() + 1) + "-" + nuevaFechaApertura.getDate();
    var nuevaFechaTerminacion1 = nuevaFechaTerminacion.getFullYear() + "-" + (nuevaFechaTerminacion.getMonth() + 1) + "-" + nuevaFechaTerminacion.getDate();

    var nuevaFechaPase = fecha_pase.getFullYear() + "-" + (fecha_pase.getMonth() + 1) + "-" + fecha_pase.getDate();
    
    
    var url = "index.php"
    var data = "action=updateReactivo";
    data = data + "&idReactivo=" + idReactivo;
    data = data + "&nombre=" + nombre;
    data = data + "&lote=" + lote;
    data = data + "&cantidad=" + cantidad;
    data = data + "&fecVencimiento=" + nuevaFecha;
    data = data + "&fechaIngreso=" + nuevaFechaIngreso1;
    data = data + "&fechaApertura=" + nuevaFechaApertura1;
    data = data + "&fechaTerminacion=" + nuevaFechaTerminacion1;
    data = data + "&tipo=" + tipo;
    data = data + "&cantidadActual=" + cantidadActual;
    data = data + "&stock=" + stock;
    data = data + "&lote_interno=" + lote_interno;
    data = data + "&fecha_pase=" + nuevaFechaPase;

    
//    alert(nuevaFechaIngreso1);
//    alert(nuevaFechaApertura1);
//    alert(nuevaFechaTerminacion1);
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllReactivoAdminEstandar').jqxGrid('updatebounddata');
                openNotificationAdminEstandar('success', response.message)

            } else {
                openNotificationAdminEstandar('error', response.message);

            }

        }
    });
}







function ajaxDeleteEstandar(idEstandar, activo, nombre) {
    var url = "index.php"
    var data = "action=deleteEstandar";
    data = data + "&idEstandar=" + idEstandar;
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

                $('#gridAllEstandarlAdminEstandar').jqxGrid('updatebounddata');
                openNotificationAdminEstandar('success', response.message)
            } else {
                openNotificationAdminEstandar('error', response.message);
            }

        }
    });
}

function ajaxDeleteReactivo(idReactivo, activo, nombre) {
    var url = "index.php"
    var data = "action=deleteReactivo";
    data = data + "&idReactivo=" + idReactivo;
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

                $('#gridAllReactivoAdminEstandar').jqxGrid('updatebounddata');
                openNotificationAdminEstandar('success', response.message)
            } else {
                openNotificationAdminEstandar('error', response.message);
            }

        }
    });
}

function ajaxCrearEstandar(nombre, lote, cantidad, fecha, tipo, cantidadActual, stock,loteInterno,fechaPreparacion,fechaPromocion,cantidad2,codigo) {
    var url = "index.php";
    var data = "action=crearEstandar";
    data = data + "&nombre=" + nombre;
    data = data + "&lote=" + lote;
    data = data + "&cantidad=" + cantidad;
    data = data + "&fecha=" + fecha;
    data = data + "&tipo=" + tipo;
    data = data + "&cantidadActual=" + cantidadActual;
    data = data + "&stock=" + stock;

    var data = {
        action: 'crearEstandar',
        nombre: nombre,
        lote: lote,
        cantidad: cantidad,
        fecha: fecha,
        tipo: tipo,
        cantidadActual: cantidadActual, 
        stock: stock,
        loteInterno: loteInterno,
        fechaPreparacion: fechaPreparacion,
        fechaPromocion: fechaPromocion,
        cantidad2: cantidad2,
        codigo: codigo
    }


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#windowAddGridAdminEstandar').jqxWindow('close');
            $('#gridAllEstandarlAdminEstandar').jqxGrid('updatebounddata');
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxCrearReactivo(nombre, lote, cantidad, fecha, tipo, cantidadActual, stock,fechaIngreso,fechaApertura,fechaTerminacion,loteIterno,fechaPase) {
    var url = "index.php";
    var data = "action=crearReactivo";
    data = data + "&nombre=" + nombre;
    data = data + "&lote=" + lote;
    data = data + "&cantidad=" + cantidad;
    data = data + "&fecha=" + fecha;
    data = data + "&tipo=" + tipo;
    data = data + "&cantidadActual=" + cantidadActual;
    data = data + "&stock=" + stock;
    data = data + "&fechaIngreso=" + fechaIngreso;
    data = data + "&fechaApertura=" + fechaApertura;
    data = data + "&fechaTerminacion=" + fechaTerminacion;
    data = data + "&loteIterno=" + loteIterno;
    data = data + "&fechaPase=" + fechaPase;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#windowAddGridAdminReactivo').jqxWindow('close');
            $('#gridAllReactivoAdminEstandar').jqxGrid('updatebounddata');
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

