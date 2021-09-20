function initLoadUsuarioAdmin(idPerfil, idUsuario){
    
    //load components
    loadGridAllUsuariosAdministracionUsuario();
    loadWindowAddUsuarioAdministracionUsuario();
    loadWindowResetContraseñaAdministracionUsuario();
    
    loadInputNombreAdminUsuario();
    $("#inputLoginAdminUsuario").jqxInput({placeHolder: "Login", height: 25, width: 175, minLength: 1 });
    $("#inputEmailAdminUsuario").jqxInput({placeHolder: "Email", height: 25, width: 175, minLength: 1 });
    $("#passwordConfirmarContrasenaAdminUsuario").jqxPasswordInput({  width: 175, height: 25, });
    $("#inputNuevoPassAdminUsuario").jqxPasswordInput({  width: 175, height: 25, });
    $("#inputConfNuevoPassAdminUsuario").jqxPasswordInput({  width: 175, height: 25, });
    loadInputPasswordContrasenaAdminUsuario();
    loadDropDownListCargosAdminUsuario();
    loadDropDownListJefeAdminUsuario();
    loadDropDownListPerfilAdminUsuario();
    loadDropDownListCalendarioAdminUsuario();

    // load Events
    eventClickButtonOKModalCrearUsuarioAdminUsuario();
    
    eventClickButtonCancelModalCrearUsuarioAdminUsuario();
    eventCloseWindowAddUsuarioAdministracionUsuario();
    eventClickButtonUpdateModalCrearUsuarioAdminUsuario();
    eventClickButtonOKModalResetPassAdminUsuario();
    
    
}

function eventClickImgDetalleUsuarioAdminUsuario(idUsuario){
    $("#buttonOKModalCrearUsuarioAdminUsuario").jqxButton({disabled: true});
    $("#buttonUpdatelModalCrearUsuarioAdminUsuario").jqxButton({disabled: false});
    var dataUsuario = $('#gridAllUsuariosAdministracionUsuario').jqxGrid('getrowdatabyid', idUsuario);
    $('#inputNombreAdminUsuario').val(dataUsuario.nombre);
    $('#inputEmailAdminUsuario').val(dataUsuario.email);
    $('#inputLoginAdminUsuario').val(dataUsuario.usuario);
    $('#passwordContrasenaAdminUsuario').val(idUsuario);
    $('#passwordConfirmarContrasenaAdminUsuario').val(idUsuario);
    $('#passwordContrasenaAdminUsuario').jqxPasswordInput({ disabled: true });
    $('#passwordConfirmarContrasenaAdminUsuario').jqxPasswordInput({ disabled: true });
    $('#dropDownListCargosAdminUsuario').jqxDropDownList('selectItem', dataUsuario.idCargo ); 
    if(dataUsuario.idJefe == null){
        var idJefe = -1;
    } else {
        var idJefe = dataUsuario.idJefe;
    }
    $('#dropDownListJefeAdminUsuario').jqxDropDownList('selectItem', idJefe ); 
    $('#dropDownListPerfilAdminUsuario').jqxDropDownList('selectItem', dataUsuario.idPerfil );
    $('#dropDownListCalendarioAdminUsuario').jqxDropDownList('selectItem', dataUsuario.idCalendario );
    $("#windowAddUsuarioAdministracionUsuario").jqxWindow('open');


}

function eventClickButtonUpdateModalCrearUsuarioAdminUsuario(){
    
    $('#buttonUpdatelModalCrearUsuarioAdminUsuario').on('click', function () { 
        var nombre = $('#inputNombreAdminUsuario').val();
        var email = $('#inputEmailAdminUsuario').val();
        var login = $('#inputLoginAdminUsuario').val();
        var cargo = $('#dropDownListCargosAdminUsuario').val();
        var jefe = $('#dropDownListJefeAdminUsuario').val();
        var perfil = $('#dropDownListPerfilAdminUsuario').val();
        var calendario = $('#dropDownListCalendarioAdminUsuario').val();
        var idUsuario = $('#passwordContrasenaAdminUsuario').val();
        
        if(nombre == ""){
            openNotificationAdminUsuario('error', 'El campo nombre es obligatorio');
        } else if (login == ''){
            openNotificationAdminUsuario('error', 'El campo login es obligatorio');
        } else {
            ajaxUpdateUsuario (idUsuario, nombre, email, login, cargo, jefe, perfil, calendario);
        }
        
        
    
    });
}

function eventClickButtonOKModalCrearUsuarioAdminUsuario(){
    $('#buttonOKModalCrearUsuarioAdminUsuario').on('click', function () { 
        var nombre = $('#inputNombreAdminUsuario').val();
        var email = $('#inputEmailAdminUsuario').val();
        var login = $('#inputLoginAdminUsuario').val();
        var con = $('#passwordContrasenaAdminUsuario').val();
        var con2 = $('#passwordConfirmarContrasenaAdminUsuario').val();
        var cargo = $('#dropDownListCargosAdminUsuario').val();
        var jefe = $('#dropDownListJefeAdminUsuario').val();
        var perfil = $('#dropDownListPerfilAdminUsuario').val();
        var calendario = $('#dropDownListCalendarioAdminUsuario').val();
        
        if(nombre == ""){
            openNotificationAdminUsuario('error', 'El campo nombre es obligatorio');
        } else if (login == ''){
            openNotificationAdminUsuario('error', 'El campo login es obligatorio');
        } else if (con == ''){
            openNotificationAdminUsuario('error', 'El campo contrasdeña es obligatorio');
        } else if (con2 == ''){
            openNotificationAdminUsuario('error', 'El campo confirmar contrasdeña es obligatorio');
        } else if (con2 != con){
            openNotificationAdminUsuario('error', 'Los campos contraseña y confirmar contraseña deben ser iguales');
        } else {
            ajaxInsertUsuario (nombre, email, login, con, cargo, jefe, perfil, calendario)
            //openNotificationAdminUsuario('success', 'Datos enviados con exito');
        }
        
        
    
    }); 
}

function eventClickButtonCancelModalCrearUsuarioAdminUsuario(){
    $('#buttonCancelModalCrearUsuarioAdminUsuario').on('click', function () { 
        
            $('#inputNombreAdminUsuario').jqxInput('val','');
            $('#inputEmailAdminUsuario').jqxInput('val','');
            $('#inputLoginAdminUsuario').jqxInput('val','');
            $('#passwordContrasenaAdminUsuario').jqxPasswordInput('val','');
            $('#passwordConfirmarContrasenaAdminUsuario').jqxPasswordInput('val','');
        
    
    });
}

function loadDropDownListCalendarioAdminUsuario(){
    var url = "model/DB/jqw/CalendarioData.php?query=getAllCalendario";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'nombre' }
        ],
        url: url,
        async: false
    };
    
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#dropDownListCalendarioAdminUsuario").jqxDropDownList({
        selectedIndex: 0, 
        source: dataAdapter, 
        displayMember: "nombre", 
        valueMember: "id", 
        width: 200, 
        height: 25
    });
}

function loadDropDownListPerfilAdminUsuario(){
    var url = "model/DB/jqw/perfilData.php?query=getAllPerfil";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'nombre' },
            { name: 'estado' }
        ],
        url: url,
        async: false
    };
    
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#dropDownListPerfilAdminUsuario").jqxDropDownList({
        selectedIndex: 0, 
        source: dataAdapter, 
        displayMember: "nombre", 
        valueMember: "id", 
        width: 200, 
        height: 25
    });
}

function loadDropDownListJefeAdminUsuario(){
    var url = "model/DB/jqw/usuarioData.php?query=getAllUsuario";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'nombre' }
        ],
        url: url,
        async: false
    };
    $("#dropDownListJefeAdminUsuario").on('bindingComplete', function (event) { 
        
        $("#dropDownListJefeAdminUsuario").jqxDropDownList('addItem', { label: 'N/A', value: '-1'});
    });
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#dropDownListJefeAdminUsuario").jqxDropDownList({
        selectedIndex: 0, 
        source: dataAdapter, 
        displayMember: "nombre", 
        valueMember: "id", 
        width: 200, 
        height: 25
    });
    
    
}

function loadDropDownListCargosAdminUsuario(){
    
    var url = "model/DB/jqw/CargoData.php?query=getAll";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'idCargo' },
            { name: 'nombreCargo' }
        ],
        url: url,
        async: false
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    
    $("#dropDownListCargosAdminUsuario").jqxDropDownList({
        selectedIndex: 0, 
        source: dataAdapter, 
        displayMember: "nombreCargo", 
        valueMember: "idCargo", 
        width: 200, 
        height: 25
    });
}

function loadInputPasswordContrasenaAdminUsuario(){
    $("#passwordContrasenaAdminUsuario").jqxPasswordInput({  width: 175, height: 25, showStrength: true, showStrengthPosition: "right" });
}

function loadInputNombreAdminUsuario(){
    $("#inputNombreAdminUsuario").jqxInput({placeHolder: "Nombre de usuario", height: 25, width: 175, minLength: 1 });
}

function loadGridAllUsuariosAdministracionUsuario(){
    var url = "model/DB/jqw/AdministracionUsuarioData.php?query=getUsuariosActivosDependencias";
    var source =
    {
        datatype: "json",
        datafields: [
            { name: 'cantidad' },
            { name: 'id' },
            { name: 'nombre' },
            { name: 'usuario' },
            { name: 'caduca' },
            { name: 'fechaCaduca' },
            { name: 'estado' },
            { name: 'idPerfil' },
            { name: 'idJefe' },
            { name: 'idCargo' },
            { name: 'esJefe' },
            { name: 'email' },
            { name: 'aplicacion' },
            { name: 'bloqueado' },
            { name: 'fechaCreacion' },
            { name: 'ultimoIngreso' },
            { name: 'intentosFallidos' },
            { name: 'idCalendario' },
            { name: 'nomPerfil' },
            { name: 'nomCargo' },
            { name: 'nomCalendario' }
        ],
        id: 'id',
        url: url,
        sync: false
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
            
    $("#gridAllUsuariosAdministracionUsuario").jqxGrid(
            {
                width: '100%',
                height:'100%',
                source: dataAdapter,
                showstatusbar: true,
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
                        //var datarow = generatedata(1);
                        //$("#jqxgrid").jqxGrid('addrow', null, datarow[0]);
                        $('#passwordContrasenaAdminUsuario').jqxPasswordInput({ disabled: false });
                        $('#passwordConfirmarContrasenaAdminUsuario').jqxPasswordInput({disabled: false});
                        $("#buttonOKModalCrearUsuarioAdminUsuario").jqxButton({disabled: false});
                        $("#buttonUpdatelModalCrearUsuarioAdminUsuario").jqxButton({disabled: true});
                        $("#windowAddUsuarioAdministracionUsuario").jqxWindow('open');
                        //alert("agregar");
                    });
                    // delete selected row.
                    deleteButton.click(function (event) {
                        //var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        //var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                        //var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                        //$("#jqxgrid").jqxGrid('deleterow', id);
                        var rowindex = $('#gridAllUsuariosAdministracionUsuario').jqxGrid('getselectedrowindex');
                        var data = $('#gridAllUsuariosAdministracionUsuario').jqxGrid('getrowdata', rowindex);
                        //alert(data.nombre);
                        ajaxDeleteUsuario(data.uid);
                    });
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $('#gridAllUsuariosAdministracionUsuario').jqxGrid('updatebounddata');
                    });
                    
                    
                },
                columns: [
                  { text: 'No.', datafield: 'cantidad', width: 50 },
                  { text: 'ID', datafield: 'id', width: 100, hidden: true },
                  { text: 'Nombre Completo', datafield: 'nombre', width: 150 },
                  { text: 'Perfil de Usuario', datafield: 'usuario', width: 150 },
                  { text: 'caduca', datafield: 'caduca', width: 150, hidden: true },
                  { text: 'fechaCaduca', datafield: 'fechaCaduca', width: 150, hidden: true },
                  { text: 'estado', datafield: 'estado', width: 150, hidden: true },
                  { text: 'idPerfil', datafield: 'idPerfil', width: 150, hidden: true },
                  { text: 'idJefe', datafield: 'idJefe', width: 150, hidden: true },
                  { text: 'idCargo', datafield: 'idCargo', width: 150, hidden: true },
                  { text: 'esJefe', datafield: 'esJefe', width: 150, hidden: true },
                  { text: 'E-Mail', datafield: 'email', width: 150 },
                  { text: 'aplicacion', datafield: 'aplicacion', width: 150, hidden: true },
                  { text: 'bloqueado', datafield: 'bloqueado', width: 150, hidden: true },
                  { text: 'Fechade Creación', datafield: 'fechaCreacion', width: 150 },
                  { text: 'ultimoIngreso', datafield: 'ultimoingreso', width: 150, hidden: true },
                  { text: 'intentosFallidos', datafield: 'intentosFallidos', width: 150, hidden: true },
                  { text: 'idCalendario', datafield: 'idCalendario', width: 150, hidden: true },
                  { text: 'Cargo', datafield: 'nomCargo', width: 150 },
                  { text: 'Perfil', datafield: 'nomPerfil', width: 150 },
                  { text: 'Calendario', datafield: 'nomCalendario', width: 150 },
                  { text: '',   width: 30, cellsrenderer: function (row) {
                          var dataRecord = $("#gridAllUsuariosAdministracionUsuario").jqxGrid('getrowdata', row); 
                          var idUsuario = "'"+dataRecord.id+"'";
                          
                          return '<img style="margin-left: 8px;margin-top: 3px;" src="views/images/detalle.png" onClick="eventClickImgDetalleUsuarioAdminUsuario('+idUsuario+');"/>';
                      }
                  },
                  { text: '',   width: 30, cellsrenderer: function (row) {
                          var dataRecord = $("#gridAllUsuariosAdministracionUsuario").jqxGrid('getrowdata', row); 
                          var idUsuario = "'"+dataRecord.id+"'";
                          
                          return '<img style="margin-left: 8px;margin-top: 3px; width: 16px; height: 21px; cursor: pointer;" src="views/images/llave.png" onClick="eventClickImgPasswordAdminUsuario('+idUsuario+');"/>';
                      }
                  }
              ]
            });
}

function loadWindowAddUsuarioAdministracionUsuario(){
    $('#windowAddUsuarioAdministracionUsuario').jqxWindow({
        height: 300, 
        width: 700,
        isModal: true, 
        resizable: false,
        autoOpen: false,
        title: 'Crear un Nuevo Usuario',
        cancelButton: $('#buttonCancelModalCrearUsuarioAdminUsuario'),
        initContent: function () {
            $("#buttonOKModalCrearUsuarioAdminUsuario").jqxButton({ width: '150'});
            $("#buttonCancelModalCrearUsuarioAdminUsuario").jqxButton({ width: '150'});
            $("#buttonUpdatelModalCrearUsuarioAdminUsuario").jqxButton({ width: '150'});
            
             
        }
    });
    
}
function loadWindowResetContraseñaAdministracionUsuario(){
    $('#windowResetPasswordAdministracionUsuario').jqxWindow({
        height: 200, 
        width: 400,
        isModal: true, 
        resizable: false,
        autoOpen: false,
        title: 'Resetear contraseña',
        cancelButton: $('#buttonCancelModalResetPassAdminUsuario'),
        initContent: function () {
            
            $("#buttonOKModalResetPassAdminUsuario").jqxButton({ width: '150'});
            $("#buttonCancelModalResetPassAdminUsuario").jqxButton({ width: '150'});
            
             
        }
    });
    
}

function loadNotificationAdminUsuario(){
     $("#notificationAdminUsuario").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function openNotificationAdminUsuario(template, message){
     $("#messageNotificationAdminUsuario").text(message);
        $("#notificationAdminUsuario").jqxNotification({template: template});
        $("#notificationAdminUsuario").jqxNotification("open");
}

function ajaxDeleteUsuario (idUsuario){
    var url = "index.php"
    var data = "action=deleteUsuario";
    data = data + "&idUsuario="+idUsuario;
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
             if (response.result == 0){
                $('#gridAllUsuariosAdministracionUsuario').jqxGrid('updatebounddata');
                openNotificationAdminUsuario('success', response.message)
                
            } else {
                openNotificationAdminUsuario('error', response.message);
                
            }
           
        }
    });
}

function ajaxInsertUsuario (nombre, email, login, contrasena, cargo, jefe, perfil, calendario){
    var url = "index.php"
    var data = "action=insertUsuario";
    data = data + "&nombre="+nombre;
    data = data + "&email="+email;
    data = data + "&login="+login;
    data = data + "&contrasena="+contrasena;
    data = data + "&cargo="+cargo;
    data = data + "&jefe="+jefe;
    data = data + "&perfil="+perfil;
    data = data + "&calendario="+calendario;
    
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
             if (response.result == 0){
                
                $('#windowAddUsuarioAdministracionUsuario').jqxWindow('close');
                $('#gridAllUsuariosAdministracionUsuario').jqxGrid('updatebounddata');
                openNotificationAdminUsuario('success', response.message)
                
            } else {
                openNotificationAdminUsuario('error', response.message);
                
            }
           
        }
    });
}

function ajaxUpdateUsuario (idUsuario, nombre, email, login, cargo, jefe, perfil, calendario){
    var url = "index.php"
    var data = "action=updateUsuario";
    data = data + "&idUsuario="+idUsuario;
    data = data + "&nombre="+nombre;
    data = data + "&email="+email;
    data = data + "&login="+login;
    data = data + "&cargo="+cargo;
    data = data + "&jefe="+jefe;
    data = data + "&perfil="+perfil;
    data = data + "&calendario="+calendario;
    
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
             if (response.result == 0){
                
                $('#windowAddUsuarioAdministracionUsuario').jqxWindow('close');
                $('#gridAllUsuariosAdministracionUsuario').jqxGrid('updatebounddata');
                openNotificationAdminUsuario('success', response.message)
                
            } else {
                openNotificationAdminUsuario('error', response.message);
                
            }
           
        }
    });
}

function eventCloseWindowAddUsuarioAdministracionUsuario(){
    $('#windowAddUsuarioAdministracionUsuario').on('close', function (event) {
        $('#inputNombreAdminUsuario').val('');
        $('#inputEmailAdminUsuario').val('');
        $('#inputLoginAdminUsuario').val('');
        $('#passwordContrasenaAdminUsuario').val('');
        $('#passwordConfirmarContrasenaAdminUsuario').val('');
    }); 
}

function eventClickImgPasswordAdminUsuario(idUsuario){
    $('#hidUsuarioResetPassAdminusuario').val(idUsuario);
    $('#windowResetPasswordAdministracionUsuario').jqxWindow('open');
    
}

function eventClickButtonOKModalResetPassAdminUsuario(){
    $('#buttonOKModalResetPassAdminUsuario').on('click', function () { 
        var pass = $('#inputNuevoPassAdminUsuario').jqxPasswordInput('val');
        var confPass = $('#inputConfNuevoPassAdminUsuario').jqxPasswordInput('val');
        if( pass !== confPass){
            openNotificationAdminUsuario('error', 'Las contraseñas digitadas no coinciden');
        } else {
            var idUsuario = $('#hidUsuarioResetPassAdminusuario').val();
            var resetPasswordPromise = ajaxResetPasswordAdminusuario(idUsuario, pass);
            resetPasswordPromise.then(function (data) {
                var response = JSON.parse(data);
                if (response.result == 0) {
                    $('#inputNuevoPassAdminUsuario').jqxPasswordInput('val', '');
                    $('#inputConfNuevoPassAdminUsuario').jqxPasswordInput('val', '');
                    $('#windowResetPasswordAdministracionUsuario').jqxWindow('close');
                    openNotificationAdminUsuario('success', 'Se ha actualizado la contraseña correctamente.');
                } else {
                    openNotificationAdminUsuario('error', 'Fallo la actualización de la contraseña intentelo nuevamente.');
                }

            });
        }
    });
}

function ajaxResetPasswordAdminusuario(idUsuario, password) {
    return $.ajax({
        type: "POST",
        url: 'index.php',
        data: {
            action: 'resetPassword',
            isUser: idUsuario,
            newPassword: password
        },
        async: false
    });
}