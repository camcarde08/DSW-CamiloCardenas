function initLoadPaqueteAdmin(idPerfil, idUsuario){
    //load components
    loadgridAllPaquetesAdminPaquete();
    loadGridAllPaqueteEnsayosAdminPaquete();
    loadGridEnsayosDisponiblesAdminPaquete();
    loadButtonAgregarEnsayosAdminPaquete();
    loadButtonEliminarEnsayosAdminPaquete();
    loadWindowAddApaueteAdminPaquete();
    loadInputDesPaqueteAdminPaquete();
    loadInputCodPaqueteAdminPaquete();
    loadDropDownAreaAnalisisAdminPaquete();
    // load Events
    eventSelectRowGridAllPaquetesAdminPaquete();
    eventClickButtonAgregarEnsayosAdminPaquete();
    eventClickButtonEliminarEnsayosAdminPaquete();
    eventClickButtonOKModalCrearPaqueteAdminpaquete();
    eventCloseWindowAddApaueteAdminPaquete();
    //$('#gridAllPaquetesAdminPaquete').jqxGrid('updatebounddata');

}

function loadDropDownAreaAnalisisAdminPaquete(){
    var url = "model/DB/jqw/AreasAnalisisData.php?query=getAreas";
                // prepare the data
                var source =
                {
                    datatype: "json",
                    datafields: [
                        { name: 'id', type: 'int' },
                        { name: 'descripcion', type: 'string' }
                    ],
                    url: url,
                    async: true
                };
                var dataAdapter = new $.jqx.dataAdapter(source);
                // Create a jqxDropDownList
                $("#dropDownAreaAnalisisAdminPaquete").jqxDropDownList({
                    selectedIndex: 0, source: dataAdapter, displayMember: "descripcion", valueMember: "id", width: 400, height: 25
                });
}

function loadInputDesPaqueteAdminPaquete(){
    $("#inputDesPaqueteAdminPaquete").jqxInput({height: 25, width: 400});
}

function loadInputCodPaqueteAdminPaquete(){
    $("#inputCodPaqueteAdminPaquete").jqxInput({height: 25, width: 400});
}

function loadWindowAddApaueteAdminPaquete(){
    $('#windowAddApaueteAdminPaquete').jqxWindow({ isModal: true, 
        height: 270, 
        width: 460, 
        title: 'Agregar Nuevo Paquete',
        autoOpen: false,
        cancelButton: $('#buttonCancelarModalCrearPaqueteAdminpaquete'),
        position: { x: 400, y: 100 },
        initContent: function() {
             
                $("#buttonOKModalCrearPaqueteAdminpaquete").jqxButton({ width: '70'});
                $("#buttonCancelarModalCrearPaqueteAdminpaquete").jqxButton({ width: '70'});
                //loadGridAreasAnalisisWindowAddGridAdminEnsayo();
                
        }
    });
}

function loadButtonEliminarEnsayosAdminPaquete(){
    $("#buttonEliminarEnsayosAdminPaquete").jqxButton({template: "danger",width: '130px'});
}

function loadButtonAgregarEnsayosAdminPaquete(){
    $("#buttonAgregarEnsayosAdminPaquete").jqxButton({template: "primary",width: '130px'});
}

function loadgridAllPaquetesAdminPaquete(){
    var url = "model/DB/jqw/EnsayoData.php?query=getPaquetes";
    
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id', type: 'int'},
            { name: 'descripcion', type: 'string' },
            { name: 'tiempo', type: 'int'},
            { name: 'codigo', type: 'string'}
        ],
        id: 'id',
                updaterow: function (rowid, rowdata, commit) {
                    var id = rowdata.id;
                    var descripcion = rowdata.descripcion;
                    var codigo = rowdata.codigo;
                    
                    var newPaquete = {
                        codigo: codigo,
                        id: id,
                        descripcion: descripcion
                    };

                    var paquetesData = $("#gridAllPaquetesAdminPaquete").jqxGrid('getrows');
                    var validacionReperido = paquetesData.find(function (paquete) {
                        return this.descripcion == paquete.descripcion && this.id != paquete.id;
                    }, newPaquete);
                    if (validacionReperido != undefined) {
                        eventOpenNotificationAdminEnsayo('error', "Ya existe un paquete con el nombre " + descripcion + '.');
                        commit(false);
                    } else {
                        if(codigo != ''){
                            ajaxUpdateNomPaquete(codigo,id, descripcion);
                        } else {
                            eventOpenNotificationAdminEnsayo('error', 'No es posible actualizar el paquete con el codigo digitado');
                        }
                        
                    commit(true);
                    }
                },
        url: url
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#gridAllPaquetesAdminPaquete").jqxGrid(
    {
        width: 330,
        height: 420,
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
        //selectionmode: 'checkbox',

        
         renderstatusbar: function (statusbar) {
            // appends buttons to the status bar.
            var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
            var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
            var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'></span></div>");
            var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'></span></div>");
            container.append(addButton);
            container.append(deleteButton);
            container.append(reloadButton);
            statusbar.append(container);
            addButton.jqxButton({  width: 60, height: 20 });
            deleteButton.jqxButton({  width: 60, height: 20 });
            reloadButton.jqxButton({  width: 60, height: 20 });
            addButton.click(function (event) {
                $('#windowAddApaueteAdminPaquete').jqxWindow('open');
                
            });
            // delete selected row.
                    deleteButton.click(function (event) {
                       var cell = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedcell');
                        //var rowindex = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedrowindex');
                        var selectedIndex =  cell.rowindex;
                        if(selectedIndex != null){
                           var id = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowid', selectedIndex);
                            var data = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowdata', selectedIndex);
                           
                            ajaxDeletePaquete(id,0,data.descripcion);
          
                        }
                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $('#gridAllPaquetesAdminPaquete').jqxGrid('updatebounddata');
                    });
        },
        columns: [
          { text: 'idPaquete', dataField: 'id', filtertype: 'input', width: 700, hidden:true },
          { text: 'Codigo', dataField: 'codigo', filtertype: 'input', width: '20%' },
          { text: 'Paquetes', dataField: 'descripcion', filtertype: 'input', width: '80%' },
          { text: 'Tiempo Paquete', dataField: 'tiempo', filtertype: 'number', width: 180, hidden:true }
        ]
    });
       
}

function loadGridAllPaqueteEnsayosAdminPaquete() {


    var source =
            {
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'descripcion', type: 'string'},
                    {name: 'tiempo', type: 'int'}
                ],
                id: 'id',
                root: 'data'
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    $("#gridAllPaqueteEnsayosAdminPaquete").jqxGrid(
            {
                width: 330,
                height: 420,
                source: dataAdapter,
                columnsresize: false,
                showstatusbar: false,
                sortable: true,
                filterable: true,
                showfilterrow: true,
                columns: [
                    {text: 'idpaqueteEnsayo', dataField: 'id', filtertype: 'input', width: 700, hidden: true},
                    {text: 'Ensayos del Paquete', dataField: 'descripcion', filtertype: 'number', width: '100%'},
                    {text: 'Tiempo Paquete', dataField: 'tiempo', filtertype: 'number', width: 180, hidden: true}
                ]
            });

}

function eventSelectRowGridAllPaquetesAdminPaquete() {
    $('#gridAllPaquetesAdminPaquete').on('cellselect', function (event)
    {

        var args = event.args;

        var dataField = event.args.datafield;

        var rowBoundIndex = event.args.rowindex;
        
        var rowData = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowdata', rowBoundIndex);
        $("#gridAllPaqueteEnsayosAdminPaquete").on("bindingcomplete", function (event) {
       // $('#gridAllPaquetesAdminPaquete').jqxGrid('selectcell', 0, 'descripcion');
            utilBoundDataGridEnsayosDisponiblesAdminPaquete(rowData.id);
        });
        utilBoundDataGridAllPaqueteEnsayosAdminPaquete(rowData.id);

        




    });
}

function loadGridEnsayosDisponiblesAdminPaquete(){
    //var url2 = "model/DB/jqw/EnsayoPaqueteData.php?query=getEnsayosPaqueteByIdPaquete&idPaquete="+idPaquete;
    var source2 =
    {
        //datatype: "json",
        datafields: [
            { name: 'idEnsayo', type: 'int'},
            { name: 'desEnsayo', type: 'string'},
            { name: 'tiempoEnsayo', type: 'int'},
        ],
        id: 'idEnsayoPaquete',
        //url: url2,
        root: 'data'
    };
    var dataAdapter2 = new $.jqx.dataAdapter(source2);
    
    $("#gridEnsayosDisponiblesAdminPaquete").jqxGrid(
    {
        width: 330,
        height: 420,
        source: dataAdapter2,
        columnsresize: false,
        showstatusbar: false,
        sortable: true,
        filterable: true,
        showfilterrow: true,
        selectionmode: 'checkbox',
        columns: [
          { text: 'idEnsayo', dataField: 'idEnsayo', filtertype: 'number', width: 180, hidden:true },
          { text: 'Ensayos Disponibles', dataField: 'desEnsayo', filtertype: 'number', width: 234, hidden:false },
          { text: 'Tiempo', dataField: 'tiempoEnsayo', filtertype: 'number', width: '20%', hidden:false }
        ]
    });
}

function utilBoundDataGridAllPaqueteEnsayosAdminPaquete(idPaquete){
    var cell = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedcell');
    var selectedrowindex = cell.rowindex;
    var data = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowdata', selectedrowindex);
    idPaquete = data.id;
    var url2 = "model/DB/jqw/EnsayoPaqueteData.php?query=getEnsayosPaqueteByIdPaquete&idPaquete="+idPaquete;
    var source2 =
    {
        datatype: "json",
        datafields: [
            { name: 'idEnsayoPaquete', type: 'int'},
            { name: 'idPaquete', type: 'int' },
            { name: 'idEnsayo', type: 'int'},
            { name: 'valorPaquete', type: 'int'},
            { name: 'desEnsayo', type: 'string'},
            { name: 'tiempoEnsayo', type: 'int'},
        ],
        async: true,
        id: 'idEnsayoPaquete',
        url: url2,
        root: 'data'
    };
    var dataAdapter2 = new $.jqx.dataAdapter(source2);
    
    $("#gridAllPaqueteEnsayosAdminPaquete").jqxGrid(
    {
        width: 330,
        height: 420,
        source: dataAdapter2,
        columnsresize: false,
        showstatusbar: false,
        sortable: true,
        filterable: true,
        showfilterrow: true,
        selectionmode: 'checkbox',
        columns: [
          { text: 'idEnsayoPaquete', dataField: 'idEnsayoPaquete', filtertype: 'input', width: 700, hidden:true },
          { text: 'idPaquete', dataField: 'idPaquete', filtertype: 'number', width: 100, hidden:true },
          { text: 'idEnsayo', dataField: 'idEnsayo', filtertype: 'number', width: 180, hidden:true },
          { text: 'valorPaquete', dataField: 'valorPaquete', filtertype: 'input', width: 700, hidden:true },
          { text: 'Ensayos', dataField: 'desEnsayo', filtertype: 'number', width: 234, hidden:false },
          { text: 'Tiempo', dataField: 'tiempoEnsayo', filtertype: 'number', width: '20%', hidden:false }
        ]
    });
}

function utilBoundDataGridEnsayosDisponiblesAdminPaquete(idPaquete){
    var cell = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedcell');
    var selectedrowindex = cell.rowindex;
    var data = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowdata', selectedrowindex);
    idPaquete = data.id;
    var url2 = "model/DB/jqw/EnsayoPaqueteData.php?query=getEnsayosDisponiblesByIdPaquete&idPaquete="+idPaquete;
    var source2 =
    {
        datatype: "json",
        datafields: [
            { name: 'idEnsayo', type: 'int'},
            { name: 'desEnsayo', type: 'string'},
            { name: 'tiempoEnsayo', type: 'int'},
        ],
        id: 'idEnsayo',
        url: url2,
        root: 'data',
        async: true,
    };
    var dataAdapter2 = new $.jqx.dataAdapter(source2);
    
    $("#gridEnsayosDisponiblesAdminPaquete").jqxGrid(
    {
         width: 350,
        height: 420,
        source: dataAdapter2,
        columnsresize: false,
        showstatusbar: false,
        sortable: true,
        filterable: true,
        showfilterrow: true,
        selectionmode: 'checkbox',
        columns: [
          { text: 'idEnsayo', dataField: 'idEnsayo', filtertype: 'number', width: 180, hidden:true },
          { text: 'Ensayos', dataField: 'desEnsayo', filtertype: 'number', width: 234, hidden:false },
          { text: 'Tiempo', dataField: 'tiempoEnsayo', filtertype: 'number', width: '20%', hidden:false }
        ]
    });
  
}

function eventClickButtonAgregarEnsayosAdminPaquete() {
    $('#buttonAgregarEnsayosAdminPaquete').on('click', function () {
        var cellData = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedcell');
        var dataPaquete = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowdata', cellData.rowindex);
        var idPaquete = dataPaquete.id;
        var rowindexes = $('#gridEnsayosDisponiblesAdminPaquete').jqxGrid('getselectedrowindexes');
        var data = [];
        for (var i = 0; i < rowindexes.length; i++) {
            data[i] = $('#gridEnsayosDisponiblesAdminPaquete').jqxGrid('getrowdata', rowindexes[i]);
            var idEnsayo = data[i].idEnsayo

            ajaxAgregarEnsayoPaquete(idPaquete, idEnsayo);
        }
        $('#gridEnsayosDisponiblesAdminPaquete').jqxGrid('clearselection');
        $('#gridAllPaqueteEnsayosAdminPaquete').jqxGrid('clearselection');
        utilBoundDataGridAllPaqueteEnsayosAdminPaquete(idPaquete)



    });
}

function eventClickButtonOKModalCrearPaqueteAdminpaquete() {
    $('#buttonOKModalCrearPaqueteAdminpaquete').on('click', function () {
        var codigo = $("#inputCodPaqueteAdminPaquete").jqxInput('val');
        var descripcion = $("#inputDesPaqueteAdminPaquete").jqxInput('val');
        var idAreaAnalisis = $("#dropDownAreaAnalisisAdminPaquete").jqxDropDownList('val');

        if(codigo == ''){
            eventOpenNotificationAdminEnsayo('error', "No es posible crear un paquete sin código.");
            return false;
        }

        if(descripcion == ''){
            eventOpenNotificationAdminEnsayo('error', "No es posible crear un paquete sin nombre.");
            return false;
        }
        
        
        var paquetesData = $("#gridAllPaquetesAdminPaquete").jqxGrid('getrows');
        var validacionReperido = paquetesData.find(function(paquete){
            return this == paquete.descripcion;
        }, descripcion);
        if(validacionReperido != undefined){
            eventOpenNotificationAdminEnsayo('error', "Ya existe un ensayo con el nombre " + descripcion + '.');
            return false;
        }
        $('#windowAddApaueteAdminPaquete').jqxWindow('close');
        
        ajaxCrearPaquete(codigo, descripcion, idAreaAnalisis);
    });
}

function eventCloseWindowAddApaueteAdminPaquete(){
    $('#windowAddApaueteAdminPaquete').on('close', function (event) {
        $("#inputCodPaqueteAdminPaquete").jqxInput('val','');
        $("#inputDesPaqueteAdminPaquete").jqxInput('val','');
        $("#dropDownAreaAnalisisAdminPaquete").jqxDropDownList('val','');
    });
}

function eventClickButtonEliminarEnsayosAdminPaquete(){
    $('#buttonEliminarEnsayosAdminPaquete').on('click', function () {
        var rowData;
        var idEnsayoPaquete;
        var rowindexes = $('#gridAllPaqueteEnsayosAdminPaquete').jqxGrid('getselectedrowindexes');
        for(var i = 0; i < rowindexes.length; i++){
            rowData = $('#gridAllPaqueteEnsayosAdminPaquete').jqxGrid('getrowdata', rowindexes[i]);
            idEnsayoPaquete = rowData.idEnsayoPaquete;
            ajaxDeleteEnsayoPaquete(idEnsayoPaquete);
        }
        
        $('#gridEnsayosDisponiblesAdminPaquete').jqxGrid('clearselection');
        $('#gridAllPaqueteEnsayosAdminPaquete').jqxGrid('clearselection');
        var cellData = $('#gridAllPaquetesAdminPaquete').jqxGrid('getselectedcell');
        var dataPaquete = $('#gridAllPaquetesAdminPaquete').jqxGrid('getrowdata', cellData.rowindex);
        var idPaquete = dataPaquete.id;
        utilBoundDataGridAllPaqueteEnsayosAdminPaquete(idPaquete)



    });
}

function ajaxAgregarEnsayoPaquete(idPaquete, idEnsayo){
    var url = "index.php";
    var data = "action=agregarEnsayoPaquete";
    data = data + "&idPaquete=" + idPaquete;
    data = data + "&idEnsayo=" + idEnsayo;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            
            var response = JSON.parse(data);
            if (response != null) {
                //$('#gridAllEnsayoslAdminEnsayo').jqxGrid('updatebounddata');
                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxDeleteEnsayoPaquete(idEnsayoPaquete){
    var url = "index.php";
    var data = "action=deleteEnsayoPaquete";
    data = data + "&idEnsayoPaquete=" + idEnsayoPaquete;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            
            var response = JSON.parse(data);
            if (response != null) {
                //$('#gridAllEnsayoslAdminEnsayo').jqxGrid('updatebounddata');
                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function ajaxCrearPaquete(codigo, descripcion, idAreaAnalisis){
    var url = "index.php";
    // var data = "action=crearPaquete";
    // data = data + "&descripcion=" + descripcion;
    // data = data + "&idAreaAnalisis=" + idAreaAnalisis;

    var data = {
        action: 'crearPaquete',
        codigo: codigo,
        descripcion: descripcion,
        idAreaAnalisis: idAreaAnalisis
    }
    
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            $('#gridAllPaquetesAdminPaquete').jqxGrid('updatebounddata');
            var response = JSON.parse(data);
            if (response != null) {
                //$('#gridAllEnsayoslAdminEnsayo').jqxGrid('updatebounddata');
                //eventOpenNotificationAdminEnsayo('success', "Se ha registrado exitosamente el ensayo.");
            } else {
                //eventOpenNotificationAdminEnsayo('error', "Fallo en la creación del ensayo.");
            }
        }
    });
}

function eventOpenNotificationAdminEnsayo(template, message){
     $("#messageNotificationAdminEnsayo").text(message);
        $("#notificationAdminEnsayo").jqxNotification({template: template});
        $("#notificationAdminEnsayo").jqxNotification("open");
}

function ajaxUpdateNomPaquete(codigo,id, descripcion){
    //alert(id);alert(descripcion);
    var url = "index.php";
    // var data = "action=updateNomPaquete";
    // data = data + "&id=" + id;
    // data = data + "&descripcion=" + descripcion;

    data = {
        action: 'updateNomPaquete',
        codigo: codigo,
        id:id,
        descripcion: descripcion
    }
    
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
function ajaxDeletePaquete (idPaquete, activo, nombre){
    var url = "index.php"
    var data = "action=deletePaquete";
    data = data + "&idPaquete="+idPaquete;
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
                
               $('#gridAllPaquetesAdminPaquete').jqxGrid('updatebounddata');
               setTimeout(function(){ $('#gridAllPaquetesAdminPaquete').jqxGrid('selectcell', 0, 'descripcion');  }, 2000);
               eventOpenNotificationAdminEnsayo('success', response.message);
            } else {
                eventOpenNotificationAdminEnsayo('error', response.message);
            }
           
        }
    });
}