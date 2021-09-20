function initLoadEquipoAdmin(idPerfil, idUsuario){
    
    //load components
    loadGridAllEquiposAdministracionEquipo();
    loadNotificationAdminEquipo();
    loadWindowAddEquipoAdministracionEquipo();
    

    // load Events
    eventClickButtonOKModalCrearEquipoAdminEquipo();
    eventCloseWindowAddEquipoAdministracionEquipo();
    $('#test').on('click', function () {
        window.location.href = 'index.php?action=regmuestra';
    });
}

function loadWindowAddEquipoAdministracionEquipo(){
    $('#windowAddEquipoAdministracionEquipo').jqxWindow({
        height: 300, 
        width: 700,
        isModal: true, 
        resizable: false,
        autoOpen: false,
        title: 'Creación de Nuevo Equipo',
        cancelButton: $('#buttonCancelModalCrearEquipoAdminEquipo'),
        initContent: function () {
            $("#inputCodInventarioAdminEquipo").jqxInput({ height: 25, width: 175, minLength: 1 });
            $("#inputModeloAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#inputSerieAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#inputReferenciaAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#inputDescripcionAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#inputMarcaAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#inputProvMantenimientoAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#inputProvCalibracionAdminEquipo").jqxInput({height: 25, width: 175, minLength: 1 });
            $("#buttonOKModalCrearEquipoAdminEquipo").jqxButton({ width: '150'});
            $("#buttonCancelModalCrearEquipoAdminEquipo").jqxButton({ width: '150'});
            
 
        }
    });
    
}

function loadNotificationAdminUsuario(){
     $("#notificationAdminUsuario").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}


function loadGridAllEquiposAdministracionEquipo(){
    var url = "model/DB/jqw/AdministracionEquipoData.php?query=getAllEquiposActivos";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'codInventario' },
            { name: 'modelo' },
            { name: 'serie' },
            { name: 'referencia' },
            { name: 'descripcion' },
            { name: 'marca' },
            { name: 'proveedorMantenimiento' },
            { name: 'proveedorCalibracion' },
            { name: 'frecuenciaMantenimientoPreventivo' },
            { name: 'frecuenciaCalibracion' },
            { name: 'fechaUltimoMantenimiento', type: 'date'},
            { name: 'fechaUltimaCalibracion', type: 'date' },
            { name: 'calificacion'},
            { name: 'numeroDiasAlerta' },
            { name: 'InfoManteniemiento' },
            { name: 'striker' }
        ],
        id: 'id',
        updaterow: function (rowid, rowdata, commit) {
                    // synchronize with the server - send update command
                    // call commit with parameter true if the synchronization with the server is successful 
                    // and with parameter false if the synchronization failder.
                    //alert(rowdata.fechaUltimaCalibracion);
                    var fechaUltimoMantenimiento = rowdata.fechaUltimoMantenimiento.getFullYear()+'-'+(rowdata.fechaUltimoMantenimiento.getMonth()+1)+'-'+rowdata.fechaUltimoMantenimiento.getDate();
                    var fechaUltimaCalibracion = rowdata.fechaUltimaCalibracion.getFullYear()+'-'+(rowdata.fechaUltimaCalibracion.getMonth()+1)+'-'+rowdata.fechaUltimaCalibracion.getDate();

                    
                    ajaxUpdateEquipo(rowdata.id, rowdata.codInventario, rowdata.modelo, rowdata.serie, rowdata.referencia, rowdata.descripcion, rowdata.marca, rowdata.proveedorMantenimiento, rowdata.proveedorCalibracion, rowdata.frecuenciaMantenimientoPreventivo, rowdata.frecuenciaCalibracion, fechaUltimoMantenimiento, fechaUltimaCalibracion, rowdata.calificacion, rowdata.numeroDiasAlerta, rowdata.InfoManteniemiento, rowdata.striker);
                    commit(true);
                },
        url: url,
        sync: false
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
            
    $("#gridAllEquiposAdministracionEquipo").jqxGrid(
            {
                width: '100%',
                height:'90%',
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
                    addButton.jqxButton({  width: 60, height: 20 });
                    deleteButton.jqxButton({  width: 65, height: 20 });
                    reloadButton.jqxButton({  width: 65, height: 20 });
                    // add new row.
                    addButton.click(function (event) {
                        $("#windowAddEquipoAdministracionEquipo").jqxWindow('open');
                    });
                    // delete selected row.
                    deleteButton.click(function (event) {
                        var selectedIndexes = $('#gridAllEquiposAdministracionEquipo').jqxGrid('getselectedrowindexes');
                        if(selectedIndexes != null){
                            $('#gridAllEquiposAdministracionEquipo').jqxGrid('clearselection');;
                        }
                        for(var i=0; i < selectedIndexes.length; i++){
                            var id = $('#gridAllEquiposAdministracionEquipo').jqxGrid('getrowid', selectedIndexes[i]);
                            var data = $('#gridAllEquiposAdministracionEquipo').jqxGrid('getrowdata', selectedIndexes[i]);
                            ajaxDeleteEquipo (id, 0, data.descripcion);
                            //openNotificationAdminEquipo('success', data.descripcion);
                        }
                        
                       
                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $('#gridAllEquiposAdministracionEquipo').jqxGrid('updatebounddata');
                    });
                    
                    
                },
                columns: [
                  { text: 'id', datafield: 'id', width: 20, hidden: true },
                  { text: 'Código', datafield: 'codInventario', width: 50 },
                  { text: 'Modelo', datafield: 'modelo', width: 200 },
                  { text: 'Serie', datafield: 'serie', width: 100 },
                  { text: 'Referencia', datafield: 'referencia', width: 100 },
                  { text: 'Descripción', datafield: 'descripcion', width: 100 },
                  { text: 'Marca', datafield: 'marca', width: 100 },
                  { text: 'Último Mantenimiento', datafield: 'fechaUltimoMantenimiento', width: 150, cellsformat: 'd', columntype: 'datetimeinput' },
                  { text: 'Última Calibración', datafield: 'fechaUltimaCalibracion', width: 150, cellsformat: 'd', columntype: 'datetimeinput' },
                  
            { text: 'Prov. Mantenimiento', datafield: 'proveedorMantenimiento', width: 100 },
                  { text: 'Prov. Calibracion', datafield: 'proveedorCalibracion', width: 100 },
                  { text: 'frecuenciaMant. Prev', datafield: 'frecuenciaMantenimientoPreventivo', width: 100, hidden: false },
                  { text: 'frecuencia Cal', datafield: 'frecuenciaCalibracion', width: 100, hidden: false },
                  
            { text: 'calificación', datafield: 'calificacion', width: 150},
                  { text: 'Días alerta', datafield: 'numeroDiasAlerta', width: 100, columntype: 'numberinput', hidden: true},
                  { text: 'Info Manteniemiento', datafield: 'InfoManteniemiento', width: 100, hidden: true },
                  { text: 'striker', datafield: 'striker', width: 100, hidden: true }
              ]
            });
}

function loadNotificationAdminEquipo(){
     $("#notificationAdminEquipo").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function eventCloseWindowAddEquipoAdministracionEquipo() {
    $('#windowAddEquipoAdministracionEquipo').on('close', function (event) {
        $("#inputCodInventarioAdminEquipo").val('');
        $("#inputModeloAdminEquipo").val('');
        $("#inputSerieAdminEquipo").val('');
        $("#inputReferenciaAdminEquipo").val('');
        $("#inputDescripcionAdminEquipo").val('');
        $("#inputMarcaAdminEquipo").val('');
        $("#inputProvMantenimientoAdminEquipo").val('');
        $("#inputProvCalibracionAdminEquipo").val('');
    }); 
}

function openNotificationAdminEquipo(template, message){
     $("#messageNotificationAdminEquipo").text(message);
        $("#notificationAdminEquipo").jqxNotification({template: template});
        $("#notificationAdminEquipo").jqxNotification("open");
}

function ajaxDeleteEquipo (idEquipo, activo, nombre){
    var url = "index.php"
    var data = "action=deleteEquipo";
    data = data + "&idEquipo="+idEquipo;
    data = data + "&activo="+activo;
    data = data + "&nombre="+nombre;
    
    
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
             if (response.result == 0){
                
               $('#gridAllEquiposAdministracionEquipo').jqxGrid('updatebounddata');
                openNotificationAdminEquipo('success', response.message)
                
            } else {
                openNotificationAdminEquipo('error', response.message);
                
            }
           
        }
    });
}

function ajaxUpdateEquipo (idEquipo, codInventario, modelo, serie, referencia, descripcion, marca, provMant, provCali, frecMantpreven, frecCalib, fechaUlimoMant, fechaUltimaCalibracion, calificacion, numDiasAlerta, infoMant, striker){
    var url = "index.php"
    var data = "action=updateEquipo";
    data = data + "&idEquipo="+idEquipo;
    data = data + "&codInventario="+codInventario;
    data = data + "&modelo="+modelo;
    data = data + "&serie="+serie;
    data = data + "&referencia="+referencia;
    data = data + "&descripcion="+descripcion;
    data = data + "&marca="+marca;
    data = data + "&provMant="+provMant;
    data = data + "&provCali="+provCali;
    data = data + "&frecMantpreven="+frecMantpreven;
    data = data + "&frecCalib="+frecCalib;
    data = data + "&fechaUlimoMant="+fechaUlimoMant;
    data = data + "&fechaUltimaCalibracion="+fechaUltimaCalibracion;
    data = data + "&calificacion="+calificacion;
    data = data + "&numDiasAlerta="+numDiasAlerta;
    data = data + "&infoMant="+infoMant;
    data = data + "&striker="+striker;
    

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
             if (response.result == 0){
                
               $('#gridAllEquiposAdministracionEquipo').jqxGrid('updatebounddata');
                openNotificationAdminEquipo('success', response.message)
                
            } else {
                openNotificationAdminEquipo('error', response.message);
                
            }
           
        }
    });
}

function ajaxInsertEquipo (codInventario, modelo, serie, referencia, descripcion, marca, provMant, provCali){
    var url = "index.php"
    var data = "action=insertEquipo";
    data = data + "&codInventario="+codInventario;
    data = data + "&modelo="+modelo;
    data = data + "&serie="+serie;
    data = data + "&referencia="+referencia;
    data = data + "&descripcion="+descripcion;
    data = data + "&marca="+marca;
    data = data + "&provMant="+provMant;
    data = data + "&provCali="+provCali;
    
    

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
             if (response.result == 0){
                
               $('#gridAllEquiposAdministracionEquipo').jqxGrid('updatebounddata');
                openNotificationAdminEquipo('success', response.message)
                
            } else {
                openNotificationAdminEquipo('error', response.message);
                
            }
           
        }
    });
}

function eventClickButtonOKModalCrearEquipoAdminEquipo(){
    $('#buttonOKModalCrearEquipoAdminEquipo').on('click', function () {
        if($("#inputCodInventarioAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo codigo de inventario.');
        } else if ($("#inputModeloAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo modelo.');
        } else if ($("#inputSerieAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo serie.');
        } else if ($("#inputReferenciaAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo referencia.');
        } else if ($("#inputDescripcionAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo descripcion.');
        } else if ($("#inputMarcaAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo marca.');
        } else if ($("#inputProvMantenimientoAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo Proveedor de mantenimiento.');
        } else if ($("#inputProvCalibracionAdminEquipo").val() == ''){
            openNotificationAdminEquipo('error', 'Error al crear el equipo, debe diligenciar el campo Proveedor de calibración.');
        } else {
            ajaxInsertEquipo($("#inputCodInventarioAdminEquipo").val(),$("#inputModeloAdminEquipo").val(),$("#inputSerieAdminEquipo").val(),$("#inputReferenciaAdminEquipo").val(),$("#inputDescripcionAdminEquipo").val(),$("#inputMarcaAdminEquipo").val(),$("#inputProvMantenimientoAdminEquipo").val(),$("#inputProvCalibracionAdminEquipo").val());
            $("#windowAddEquipoAdministracionEquipo").jqxWindow('close');
        }

    }); 
}
