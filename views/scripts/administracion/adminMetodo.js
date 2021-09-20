function initLoadMetodoAdmin(idPerfil, idUsuario) {
    //load components
    loadGridAllMetodolAdminMetodo();
    loadWindowAddGridAdminMetodo();
    // load Events
    eventCloseWindowAddGridAdminMetodo();
    eventClickButtonOKModalCrearMetodoAdminMetodo();

}

function loadWindowAddGridAdminMetodo() {
    $('#windowAddGridAdminMetodo').jqxWindow({isModal: true,
        height: 200,
        width: 460,
        title: 'Agregar Método',
        autoOpen: false,
        cancelButton: $('#buttonCancelModalCrearMetodoAdminMetodo'),
        position: {x: 400, y: 100},
        initContent: function () {
            $("#buttonOKModalCrearMetodoAdminMetodo").jqxButton({width: '70'});
            $("#buttonCancelModalCrearMetodoAdminMetodo").jqxButton({width: '70'});
            $("#inputNombreMetodoAdminMetodo").jqxInput({width: '400', height: '25'});
            $("#inputActivoMetodoAdminMetodo").jqxInput({width: '400', height: '25'});
        }
    });
}



function loadGridAllMetodolAdminMetodo() {
    var url = "model/DB/jqw/metodoData.php?query=getAllMetodo";
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'descripcion', type: 'string'},
                    {name: 'activo', type: 'int'}

                ],
                id: 'id',
                url: url,
                root: 'data',
                sync: false,
                updaterow: function (rowid, rowdata, commit) {
                    
                    var newMetodo = {
                        id: rowdata.id,
                        descripcion: rowdata.descripcion
                    };

                    var metodosData = $("#gridAllMetodolAdminMetodo").jqxGrid('getrows');
                    var validacionRepetido = metodosData.find(function (metodo) {
                        return this.descripcion == metodo.descripcion && this.id != metodo.id;
                    },newMetodo);
                    if (validacionRepetido == undefined) {
                        ajaxUpdateMetodo(rowdata.descripcion, rowdata.id);
                        commit(true);
                    } else {
                        openNotificationAdminMetodo('error', 'Ya existe un metodo con el nombre ' + rowdata.descripcion + '.');
                        commit(false);
                    }

                    
                }
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridAllMetodolAdminMetodo").jqxGrid(
            {
                width: 900,
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
                    addButton.jqxButton({width: 60, height: 20});
                    deleteButton.jqxButton({width: 65, height: 20});
                    reloadButton.jqxButton({width: 65, height: 20});
                    // add new row.
                    addButton.click(function (event) {
                        $('#windowAddGridAdminMetodo').jqxWindow('open');

                    });
                    // delete selected row.
                    deleteButton.click(function (event) {
                        var selectedIndexes = $('#gridAllMetodolAdminMetodo').jqxGrid('getselectedrowindexes');
                        if (selectedIndexes != null) {
                            $('#gridAllMetodolAdminMetodo').jqxGrid('clearselection');
                            ;
                        }
                        for (var i = 0; i < selectedIndexes.length; i++) {
                            var id = $('#gridAllMetodolAdminMetodo').jqxGrid('getrowid', selectedIndexes[i]);
                            var data = $('#gridAllMetodolAdminMetodo').jqxGrid('getrowdata', selectedIndexes[i]);
                            ajaxDeleteMetodo(id, 0, data.descripcion);
                            //openNotificationAdminEquipo('success', data.descripcion);
                        }


                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $('#gridAllMetodolAdminMetodo').jqxGrid('updatebounddata');
                    });




                },
                columns: [
                    {text: 'idMetodo', dataField: 'id', filtertype: 'input', width: 700, hidden: true},
                    {text: 'Nombre Estándar', dataField: 'descripcion', filtertype: 'number', width: '100%'},
                    {text: 'Activo', dataField: 'activo', filtertype: 'number', width: '10%', hidden: true}
                ]
            });
}

function eventCloseWindowAddGridAdminMetodo() {
    $('#windowAddGridAdminMetodo').on('close', function (event) {
        $("#inputNombreMetodoAdminMetodo").jqxInput('val', '');
        // $("#inputActivoMetodoAdminMetodo").jqxInput('val', '');
    });
}

function eventClickButtonOKModalCrearMetodoAdminMetodo() {
    $("#buttonOKModalCrearMetodoAdminMetodo").click(function (event) {


        var nombreMetodo = $("#inputNombreMetodoAdminMetodo").jqxInput('val');
        //var activo = $("#inputActivoMetodoAdminMetodo").jqxInput('val');
        if (nombreMetodo == '') {
            openNotificationAdminMetodo('error', 'No es posible crear un metodo sin nombre.');
            return false;
        }
        var metodosData = $("#gridAllMetodolAdminMetodo").jqxGrid('getrows');
        var validacionRepetido = metodosData.find(function (metodo) {
            return nombreMetodo == metodo.descripcion;
        });
        if (validacionRepetido == undefined) {
            ajaxCrearMetodo(nombreMetodo, '1');
        } else {
            openNotificationAdminMetodo('error', 'Ya existe un metodo con el nombre ' + nombreMetodo + '.');
            return false;
        }


    });
}
function openNotificationAdminMetodo(template, message) {
    $("#messageNotificationAdminMetodo").text(message);
    $("#notificationAdminMetodo").jqxNotification({template: template});
    $("#notificationAdminMetodo").jqxNotification("open");
}
function ajaxUpdateMetodo(nombre, idMetodo) {


    var url = "index.php"
    var data = "action=updateMetodo";
    data = data + "&nombre=" + nombre;
    data = data + "&idMetodo=" + idMetodo;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllMetodolAdminMetodo').jqxGrid('updatebounddata');
                openNotificationAdminMetodo('success', response.message)

            } else {
                openNotificationAdminMetodo('error', response.message);

            }

        }
    });
}

function ajaxDeleteMetodo(idMetodo, activo, nombre) {
    var url = "index.php"
    var data = "action=deleteMetodo";
    data = data + "&idMetodo=" + idMetodo;
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

                $('#gridAllMetodolAdminMetodo').jqxGrid('updatebounddata');
                openNotificationAdminMetodo('success', response.message)
            } else {
                openNotificationAdminMetodo('error', response.message);
            }

        }
    });
}

function ajaxCrearMetodo(nombreMetodo, activo) {
    var url = "index.php";
    var data = "action=crearMetodo";
    data = data + "&nombreMetodo=" + nombreMetodo;
    data = data + "&activo=" + activo;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#windowAddGridAdminMetodo').jqxWindow('close');
            $('#gridAllMetodolAdminMetodo').jqxGrid('updatebounddata');
            var response = JSON.parse(data);
            if (response != null) {

                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

