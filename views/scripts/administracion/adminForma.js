function initLoadFormaFarAdmin(idPerfil, idUsuario){
    loadGridAllFormaAdminFormaFar();
    loadWindowAddGridAdminFormaFar();
    loadNotificationAdminFormaFar();

    eventClosewindowAddGridAdminFormaFar();
    eventClickButtonOKModalCrearFormaAdminFormaFar();

    
}

function loadWindowAddGridAdminFormaFar(){
    $('#windowAddGridAdminFormaFar').jqxWindow({ isModal: true, 
        height: 180, 
        width: 460, 
        title: 'Agregar',
        autoOpen: false,
        cancelButton: $('#buttonCancelModalCrearFormaAdminFormaFar'),
        position: { x: 500, y: 300 },
        initContent: function() {
             
                $("#buttonOKModalCrearFormaAdminFormaFar").jqxButton({ width: '70'});
                $("#buttonCancelModalCrearFormaAdminFormaFar").jqxButton({ width: '70'});
                $("#inputNombreFormaAdminFormaFar").jqxInput({width: '400', height: '25'});
                
                //loadGridAreasAnalisisWindowAddGridAdminEnsayo();
                
        }
    });
}



function loadGridAllFormaAdminFormaFar(){
    var url = "model/DB/jqw/FormaData.php?query=all";
    
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'int'},
            { name: 'descripcion', type: 'string' }
        ],
        id: 'id',
        url: url,
        root: 'data',
                updaterow: function (rowid, rowdata, commit) {
                    
                    var newForma = {
                        id: rowdata.id,
                        descripcion: rowdata.descripcion
                    };

                    var formasData = $("#gridAllFormaAdminFormaFar").jqxGrid('getrows');
                    var validarRep = formasData.find(function (forma) {
                        return forma.descripcion == this.descripcion && forma.id != this.id;
                    }, newForma);
                    if (validarRep == undefined) {
                        ajaxUpdateForma(rowdata.id, rowdata.descripcion);
                        commit(true);
                    } else {
                        eventOpenNotificationAdminFormaFar('error', "ya existe un tipo de producto con el nombre " + rowdata.descripcion + ".");
                        commit(false);
                    }

                    
                }
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#gridAllFormaAdminFormaFar").jqxGrid(
    {
        width: 400,
        height: 300,
        source: dataAdapter,
        editable: true,
        columnsresize: true,
        showstatusbar: true,
        sortable: true,
        filterable: true,
        showfilterrow: true,
        renderstatusbar: function (statusbar) {
            // appends buttons to the status bar.
            var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
            var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");

            container.append(addButton);

            statusbar.append(container);
            addButton.jqxButton({  width: 60, height: 20 });

            addButton.click(function (event) {
                $('#windowAddGridAdminFormaFar').jqxWindow('open');
                
            });




        },
        columns: [
          { text: 'idForma', dataField: 'id', filtertype: 'number', width: 700, hidden: true },
          { text: 'Tipo de Producto', dataField: 'descripcion', filtertype: 'input', width: '100%' }
        ]
    });
}

function eventClosewindowAddGridAdminFormaFar() {
    $('#windowAddGridAdminFormaFar').on('close', function (event) {
        $("#inputNombreFormaAdminFormaFar").jqxInput('val', '');
    });
}

function eventClickButtonOKModalCrearFormaAdminFormaFar() {
    $("#buttonOKModalCrearFormaAdminFormaFar").click(function (event) {

        //alert("hola");
        var descripcion =  $("#inputNombreFormaAdminFormaFar").jqxInput('val');
        if(descripcion == ''){
            eventOpenNotificationAdminFormaFar('error', "No es posible registrar un tipo de producto sin nombre.");
            return false;
        }
        
        var formasData = $("#gridAllFormaAdminFormaFar").jqxGrid('getrows');
        var validarRep = formasData.find(function (forma){
            return forma.descripcion == this;
        }, descripcion);
        if(validarRep == undefined){
            ajaxCrearForma(descripcion);
        } else {
            eventOpenNotificationAdminFormaFar('error', "ya existe un tipo de producto con el nombre "+  descripcion + ".");
            return false;
        }
        

    });
}

function loadNotificationAdminFormaFar(){
     $("#notificationAdminFormaFar").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function eventOpenNotificationAdminFormaFar(template, message){
     $("#messageNotificationAdminFormaFar").text(message);
        $("#notificationAdminFormaFar").jqxNotification({template: template});
        $("#notificationAdminFormaFar").jqxNotification("open");
}

function ajaxCrearForma(descripcion){
    var url = "index.php";
    var data = "action=crearForma";
    data = data + "&descripcion=" + descripcion;
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#windowAddGridAdminFormaFar').jqxWindow('close');
            $('#gridAllFormaAdminFormaFar').jqxGrid('updatebounddata');
            var response = JSON.parse(data);
            if (response != null) {
                
                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxUpdateForma(idForma, descripcionForma){
    var url = "index.php";
    var data = "action=updateForma";
    data = data + "&idForma=" + idForma;
    data = data + "&descripcion=" + descripcionForma;
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            //$('#windowAddGridAdminFormaFar').jqxWindow('close');
            $('#gridAllFormaAdminFormaFar').jqxGrid('updatebounddata');
            var response = JSON.parse(data);
            if (response != null) {
                
                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

