function initLoadPrinActivoAdmin(idPerfil, idUsuario) {
    //load components
    loadGridAllPrinActivosAdministracionPrinActivosEquipo();
    loadWindowAddPrinActivoAdministracionPrinActivo();
    loadNotificationAdminPrinActivo();
    // load Events
    eventCloseWindowAddPrinActivoAdministracionPrinActivo();
    eventClickButtonOKModalCrearPrinActivoAdminPrinActivo();


}

function loadGridAllPrinActivosAdministracionPrinActivosEquipo() {

    var urlDropDownListEstandar = "model/DB/jqw/EstandarData.php?query=all";

    var sourceDropDownListMetodo =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'nombre', type: 'string'}
                ],
                url: urlDropDownListEstandar,
                async: false
            };
    var dataAdapterDropDownListEstandar = new $.jqx.dataAdapter(sourceDropDownListMetodo);

    var url = "model/DB/jqw/AdministracionPrinActivoData.php?query=getAllPrincipiosActivos";
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'nombre'},
                    {name: 'valorTR'},
                    {name: 'valorStopTime'},
                    {name: 'valorSolFase'},
                    {name: 'porSolFase'},
                    {name: 'valorSolDisolucion'},
                    {name: 'porSolDisolucion'},
                    {name: 'valorFlujo'},
                    {name: 'cantidadMuestra'},
                    {name: 'cantidadxEstandar'},
                    {name: 'cantidadEstandar'},
                    {name: 'activo'},
                    {name: 'idEstandar'},
                    {name: 'estandar'}
                ],
                id: 'id',
                updaterow: function (rowid, rowdata, commit) {
                    var newPrincipio = {
                        id: rowdata.id,
                        nombre: rowdata.nombre
                    };

                    var principiosData = $("#gridAllPrinActivosAdministracionPrinActivosEquipo").jqxGrid('getrows');
                    var validarRep = principiosData.find(function (principio) {
                        return principio.nombre == this.nombre && principio.id != this.id;
                    }, newPrincipio);
                    if (validarRep == undefined) {
                        ajaxUpdatePrinActivo(rowdata.id, rowdata.nombre, rowdata.valorTR, rowdata.valorStopTime, rowdata.valorSolFase, rowdata.porSolFase, rowdata.valorSolDisolucion, rowdata.porSolDisolucion, rowdata.valorFlujo, rowdata.cantidadMuestra, rowdata.cantidadxEstandar, rowdata.cantidadEstandar, rowdata.idEstandar);
                        commit(true);
                    } else {
                        openNotificationAdminPrinActivo('error', 'Ya existe un principio activo, con el nombre ' + rowdata.nombre + '.');
                        commit(false);
                    }
                    
                },
                url: url,
                sync: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridAllPrinActivosAdministracionPrinActivosEquipo").jqxGrid(
            {
                width: '98%',
                height: '90%',
                source: dataAdapter,
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
                        $("#windowAddPrinActivoAdministracionPrinActivo").jqxWindow('open');
                    });
                    // delete selected row.
                    deleteButton.click(function (event) {
                        var selectedIndexes = $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('getselectedrowindexes');
                        if (selectedIndexes != null) {
                            $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('clearselection');
                            ;
                        }
                        for (var i = 0; i < selectedIndexes.length; i++) {
                            var id = $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('getrowid', selectedIndexes[i]);
                            var data = $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('getrowdata', selectedIndexes[i]);
                            ajaxDeletePrinActivo(id, data.nombre);

                        }


                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('updatebounddata');
                    });


                },
                columns: [
                    {text: 'id', datafield: 'id', width: 50, hidden: true},
                    {text: 'nombre', datafield: 'nombre', width: 191, hidden: false},
                    {text: 'Valor TR', datafield: 'valorTR', width: 70, hidden: false},
                    {text: 'Val. Stop Time', datafield: 'valorStopTime', width: 80, hidden: false},
                    {text: 'Val. Sol. Fase', datafield: 'valorSolFase', width: 80, hidden: false},
                    {text: '% Solucion Fase', datafield: 'porSolFase', width: 80, hidden: false},
                    {text: 'Val. Sol. Disolucion', datafield: 'valorSolDisolucion', width: 80, hidden: false},
                    {text: '% Sol. Disolucion', datafield: 'porSolDisolucion', width: 100, hidden: false},
                    {text: 'Valor Flujo', datafield: 'valorFlujo', width: 100, hidden: false},
                    {text: 'Cant. Muestra', datafield: 'cantidadMuestra', width: 100, hidden: false},
                    {text: 'Cant. X Estandar', datafield: 'cantidadxEstandar', width: 120, hidden: false},
                    {text: 'Cant. Estandar', datafield: 'cantidadEstandar', width: 80, hidden: false},
                    {text: 'activo', datafield: 'activo', width: 70, hidden: true},
                    //{ text: 'Estandar', datafield: 'idEstandar', width: 70, hidden: false },
                    //{ text: 'Estandar', datafield: 'estandar', width: 70, hidden: false },
                    {text: 'Estandar', dataField: 'idEstandar', displayfield: 'estandar', columntype: 'dropdownlist', width: 80, hidden: false,
                        createeditor: function (row, value, editor) {
                            editor.jqxDropDownList({source: dataAdapterDropDownListEstandar, displayMember: 'nombre', valueMember: 'id'});
                        }
                    },
                ]
            });
}

function loadWindowAddPrinActivoAdministracionPrinActivo() {
    $('#windowAddPrinActivoAdministracionPrinActivo').jqxWindow({
        height: 150,
        width: 550,
        isModal: true,
        resizable: false,
        autoOpen: false,
        title: 'Crear nuevo principio activo',
        cancelButton: $('#buttonCancelModalCrearPrinActivoAdminPrinActivo'),
        initContent: function () {
            $("#inputnomPrincipioActivoAdminPrinActivo").jqxInput({height: 25, width: 275, minLength: 1});

            $("#buttonOKModalCrearPrinActivoAdminPrinActivo").jqxButton({width: '150'});
            $("#buttonCancelModalCrearPrinActivoAdminPrinActivo").jqxButton({width: '150'});


        }
    });

}

function eventCloseWindowAddPrinActivoAdministracionPrinActivo() {
    $('#windowAddPrinActivoAdministracionPrinActivo').on('close', function (event) {
        $("#inputnomPrincipioActivoAdminPrinActivo").val('');

    });
}

function eventClickButtonOKModalCrearPrinActivoAdminPrinActivo() {
    $('#buttonOKModalCrearPrinActivoAdminPrinActivo').on('click', function () {
        var nombre = $("#inputnomPrincipioActivoAdminPrinActivo").val();
        if (nombre == '') {
            openNotificationAdminPrinActivo('error', 'Error al crear el principio activo, debe diligenciar el campo nombre principio activo.');
            return false;
        }

        var principiosData = $("#gridAllPrinActivosAdministracionPrinActivosEquipo").jqxGrid('getrows');
        var validarRep = principiosData.find(function (principio) {
            return principio.nombre == this;
        }, nombre);
        if (validarRep == undefined) {
            ajaxInsertPrinActivo($("#inputnomPrincipioActivoAdminPrinActivo").val());
            $("#windowAddPrinActivoAdministracionPrinActivo").jqxWindow('close');
        } else {
            openNotificationAdminPrinActivo('error', 'Ya existe un principio activo, con el nombre ' + nombre + '.');
            return false;
        }
    });
}

function loadNotificationAdminPrinActivo() {
    $("#notificationAdminPrinActivo").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function openNotificationAdminPrinActivo(template, message) {
    $("#messageNotificationAdminPrinActivo").text(message);
    $("#notificationAdminPrinActivo").jqxNotification({template: template});
    $("#notificationAdminPrinActivo").jqxNotification("open");
}

function ajaxInsertPrinActivo(nombre) {
    var url = "index.php"
    var data = "action=insertPrinActivo";
    data = data + "&nombre=" + nombre;

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('updatebounddata');
                openNotificationAdminPrinActivo('success', response.message)

            } else {
                openNotificationAdminPrinActivo('error', response.message);

            }

        }
    });
}

function ajaxDeletePrinActivo(id, nombre) {
    var url = "index.php"
    var data = "action=deletePrinActivo";
    data = data + "&id=" + id;
    data = data + "&nombre=" + nombre;

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('updatebounddata');
                openNotificationAdminPrinActivo('success', response.message)

            } else {
                openNotificationAdminPrinActivo('error', response.message);

            }

        }
    });
}

function ajaxUpdatePrinActivo(id, nombre, valorTR, valorStopTime, valorSolFase, porSolFase, valorSolDisolucion, porSolDisolucion, valorFlujo, cantidadMuestra, cantidadxEstandar, cantidadEstandar, idEstandar) {
    var url = "index.php"
    var data = "action=updatePrinActivo";
    data = data + "&id=" + id;
    data = data + "&nombre=" + nombre;
    data = data + "&valorTR=" + valorTR;
    data = data + "&valorStopTime=" + valorStopTime;
    data = data + "&valorSolFase=" + valorSolFase;
    data = data + "&porSolFase=" + porSolFase;
    data = data + "&valorSolDisolucion=" + valorSolDisolucion;
    data = data + "&porSolDisolucion=" + porSolDisolucion;
    data = data + "&valorFlujo=" + valorFlujo;
    data = data + "&cantidadMuestra=" + cantidadMuestra;
    data = data + "&cantidadxEstandar=" + cantidadxEstandar;
    data = data + "&cantidadEstandar=" + cantidadEstandar;
    data = data + "&idEstandar=" + idEstandar;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result == 0) {

                $('#gridAllPrinActivosAdministracionPrinActivosEquipo').jqxGrid('updatebounddata');
                openNotificationAdminPrinActivo('success', response.message)

            } else {
                openNotificationAdminPrinActivo('error', response.message);

            }

        }
    });
}