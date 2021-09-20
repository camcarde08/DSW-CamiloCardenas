function initLoadEnsayoAdmin(idPerfilA, idUsuario){
    idPerfil = idPerfilA;
    //load components
    loadGridAllEnsayoslAdminEnsayo();
    loadWindowAddGridAdminEnsayo();
    loadInputDesEnsayoAdminEnsayo();
    loadInputNumberPrecioEnsayoAdminEnsayo();
    loadInputNumberTiempoEnsayoAdminEnsayo();
    //loadCheckboxEsPaqueteAdminEnsayo();
    loadNotificationAdminEnsayo();
    // load Events
    eventCloseWindowAddGridAdminEnsayo();
    eventClickButtonOKModalCrearEnsayoAdminEnsayo();
}

function loadCheckboxEsPaqueteAdminEnsayo(){
    $("#checkboxEsPaqueteAdminEnsayo").jqxCheckBox({ width: 30, height: 25 });
}

function loadGridAllEnsayoslAdminEnsayo(){

    if(idPerfil == 9 || idPerfil == 1){
        var isDirTec = true;
    }
    
    
    ///////Combo de Plantillas/////////
    var urlDropDownListPlantillas = "model/DB/jqw/PlantillaData.php?query=allPlantillas";
                
    var sourceDropDownListPlantilla =
    {
        datatype: "json",
        datafields: [
            { name: 'idPlantilla', type: 'int' },
            { name: 'nomPlantilla', type: 'string' }
        ],
        url: urlDropDownListPlantillas,
        async: false
    };
    var dataAdapterDropDownListPlantilla = new $.jqx.dataAdapter(sourceDropDownListPlantilla);
    ///////Fin Combo de Plantillas//////
    var url = "model/DB/jqw/EnsayoData.php?query=getAllEnsayoSinPaquete";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'int'},
            { name: 'precio', type: 'float' },
            { name: 'tiempo', type: 'int'},
            { name: 'plantilla', type: 'int' },
            { name: 'descripcion', type: 'string' },
            { name: 'nombrePlantilla', type: 'string' }
           ],
        id: 'id',
        updaterow: function (rowid, rowdata, commit) {
                    var id = rowdata.id;
                    var precio = rowdata.precio;
                    var tiempo = rowdata.tiempo;
                    var plantilla = rowdata.plantilla;
                    var descripcion = rowdata.descripcion;
                    
                    var newData = {
                        id: id,
                        descripcion: descripcion
                    };
                    
                    var ensayosData = $("#gridAllEnsayoslAdminEnsayo").jqxGrid('getrows');
        
                    
                    var validate = ensayosData.find(
                        function (ensayo) {
                            
                            return (this.descripcion == ensayo.descripcion && this.id != ensayo.id);
                        },newData
                    );
                    if(validate == undefined){
                        ajaxUpdateEnsayo(id, precio,tiempo,plantilla,descripcion);
                        commit(true);
                    } else {
                        eventOpenNotificationAdminEnsayo('error', 'Ya existe un ensayo con el nombre digitado.');
                        commit(false);
                    }
                    
                      
                    
                },
        url: url
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#gridAllEnsayoslAdminEnsayo").jqxGrid(
    {
        width: 1000,
        height: 300,
        source: dataAdapter,
        columnsresize: true,
        showstatusbar: true,
        sortable: true,
        filterable: true,
        showfilterrow: true,
        editable: true,
        editmode: 'dblclick',
        renderstatusbar: function (statusbar) {
            // appends buttons to the status bar.
            var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
            var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
            container.append(addButton);
            statusbar.append(container);
            addButton.jqxButton({  width: 60, height: 20 });
            addButton.click(function (event) {
                $('#windowAddGridAdminEnsayo').jqxWindow('open'); 
            });
        },
        columns: [
          { text: 'Descripción', dataField: 'descripcion', filtertype: 'input', width: 380, columntype: 'textbox' },
          { text: 'Precio', dataField: 'precio', filtertype: 'number', width: 110, columntype: 'numberinput' },
          { text: 'Tiempo', dataField: 'tiempo', filtertype: 'number', width: 110, columntype: 'numberinput', hidden: !isDirTec },
          { text: 'Plantilla', dataField: 'plantilla', displayfield: 'nombrePlantilla', columntype: 'dropdownlist', width: 380, hidden: false,
            createeditor: function (row, value, editor) {
                editor.jqxDropDownList({ source: dataAdapterDropDownListPlantilla, displayMember: 'nomPlantilla', valueMember: 'idPlantilla' });
            }
          }
          
        ]
    });
}

function loadWindowAddGridAdminEnsayo(){
    $('#windowAddGridAdminEnsayo').jqxWindow({ isModal: true, 
        height: 490, 
        width: 460, 
        title: 'Agregar Ensayo',
        autoOpen: false,
        cancelButton: $('#buttonCancelModalCrearEnsayoAdminEnsayo'),
        position: { x: 400, y: 100 },
        initContent: function() {
             
                $("#buttonOKModalCrearEnsayoAdminEnsayo").jqxButton({ width: '70'});
                $("#buttonCancelModalCrearEnsayoAdminEnsayo").jqxButton({ width: '70'});
                //loadGridAreasAnalisisWindowAddGridAdminEnsayo();
                
        }
    });
}

function loadInputDesEnsayoAdminEnsayo(){
    $("#inputDesEnsayoAdminEnsayo").jqxInput({width: '400', height: '25'});
}
function loadInputNumberPrecioEnsayoAdminEnsayo(){
    $("#inputNumberPrecioEnsayoAdminEnsayo").jqxNumberInput({groupSize: 0, width: '400', height: '25', decimalDigits: 0});
}
function loadInputNumberTiempoEnsayoAdminEnsayo(){
    $("#inputNumberTiempoEnsayoAdminEnsayo").jqxNumberInput({groupSize: 0, width: '400', height: '25', decimalDigits: 0});
}


function eventCloseWindowAddGridAdminEnsayo(){
    $('#windowAddGridAdminEnsayo').on('close', function (event) { 
        $("#inputDesEnsayoAdminEnsayo").jqxInput('val', '');
        $("#inputNumberPrecioEnsayoAdminEnsayo").jqxNumberInput('val', 0);
        $("#inputNumberTiempoEnsayoAdminEnsayo").jqxNumberInput('val', 0);
        
    });  
}

function eventClickButtonOKModalCrearEnsayoAdminEnsayo() {
    $("#buttonOKModalCrearEnsayoAdminEnsayo").click(function (event) {
        var precio = $("#inputNumberPrecioEnsayoAdminEnsayo").jqxNumberInput('val');
        var tiempo = $("#inputNumberTiempoEnsayoAdminEnsayo").jqxNumberInput('val');
        var descripcion = $("#inputDesEnsayoAdminEnsayo").jqxInput('val');
        if(descripcion == ''){
            eventOpenNotificationAdminEnsayo('error', "Debe seleccionar un nombre valido para el ensayo.");
            return false;
        }
        try {
            var ensayosData = $("#gridAllEnsayoslAdminEnsayo").jqxGrid('exportdata', 'json');
        } catch (err){
            var ensayosData = [];
            ensayosData = JSON.stringify(ensayosData);
        }
        
        
        ensayosData = JSON.parse(ensayosData);
        var validate = ensayosData.find(
                function (ensayo) {
                    return descripcion == ensayo['Descripción'];
                }
        );
        if(validate == undefined){
            ajaxCrearEnsayo(precio, tiempo,1, 0,descripcion);
        } else {
            eventOpenNotificationAdminEnsayo('error', "Ya existe un ensayo co0n el nombre digtado");
            return false;
        }
        
    });
}

function loadGridAreasAnalisisWindowAddGridAdminEnsayo(){
    var url = "model/DB/jqw/AreasAnalisisData.php?query=activeAreas";
    
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'int'},
            { name: 'descripcion', type: 'string' }
        ],
        id: 'id',
        url: url,
        root: 'data'
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#gridAreasAnalisisWindowAddGridAdminEnsayo").jqxGrid(
    {
        width: 180,
        height: 126,
        source: dataAdapter,
        selectionmode: 'checkbox',
        columns: [
          { text: 'id', dataField: 'id', width: 150, hidden: true },
          { text: 'Descripcion', dataField: 'descripcion', width: 150 }
        ]
    });
}
                                   
function ajaxCrearEnsayo(precio,tiempo,plantilla,esPaquete,descripcion){
    var url = "index.php";
    var data = "action=crearEnsayo";
    data = data + "&precio=" + precio;
    data = data + "&tiempo=" + tiempo;
    data = data + "&plantilla=" + plantilla;
    data = data + "&esPaquete=" + esPaquete;
    data = data + "&descripcion=" + descripcion;
    //data = data + "&" + areas;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#windowAddGridAdminEnsayo').jqxWindow('close');
            var response = JSON.parse(data);
            if (response != null) {
                $('#gridAllEnsayoslAdminEnsayo').jqxGrid('updatebounddata');
                eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function loadNotificationAdminEnsayo(){
     $("#notificationAdminEnsayo").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function eventOpenNotificationAdminEnsayo(template, message){
     $("#messageNotificationAdminEnsayo").text(message);
        $("#notificationAdminEnsayo").jqxNotification({template: template});
        $("#notificationAdminEnsayo").jqxNotification("open");
}

function ajaxUpdateEnsayo(id, precio,tiempo,plantilla,descripcion){
    //alert(precio);alert(tiempo);alert(plantilla);alert(descripcion);
    var url = "index.php";
    var data = "action=updateEnsayo";
    data = data + "&id=" + id;
    data = data + "&precio=" + precio;
    data = data + "&tiempo=" + tiempo;
    data = data + "&plantilla=" + plantilla;
    data = data + "&descripcion=" + descripcion;
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                
                eventOpenNotificationAdminEnsayo('success', response.message);
            } else {
                eventOpenNotificationAdminEnsayo('error', response.message);
            }
        }
    });
}