function initLoadDocsMuestra(idPerfil, idUsuario) {
    //alert("test");

    loadButtonClearDocsMuestra();
    loadButtonAceptarNewFolderDocsMuestra();
    loadModalCreateNewFolder();
    loadButtonCrearCarpetaDocsMuestra();
    loadButtonEliminarArchivoDocsMuestra();
    loadFileUploadDocsMuestra333();
    loadInputNombreNuevaCarpetaDocsMuestra();

    loadInputNumMuestraDocsMuestra();
    loadNotificationDocsMuestra();



    //eventos
    eventClickButtonAceptarNewFolderDocsMuestra()
    eventClickButtonCrearCarpetaDocsMuestra();
    eventClickButtonEliminarArchivoDocsMuestra();
    eventClickSearchNumMuestraDocsMuestra();
    eventCLickButtonUploadFileDocsMuestra();
    eventEndUpLoadFileDocsMuestra();
    eventClickButtonClearDocsMuestra();
    //eventClickTreeDocsMuestra();

}

function eventClickButtonClearDocsMuestra() {
    $("#buttonClearDocsMuestra").on('click', function (event) {
        //$('#inputNumMuestraDocsMuestra').jqxInput('val', '');
        $('#fileUploadDocsMuestra333').jqxFileUpload('cancelAll');
        $('#treeDocsMuestra').jqxTree('clear');
        $('#buttonCrearCarpetaDocsMuestra').jqxButton({disabled: true});
        $('#buttonEliminarArchivoDocsMuestra').jqxButton({disabled: true});
    });
}

function loadButtonAceptarNewFolderDocsMuestra() {
    $("#buttonAceptarNewFolderDocsMuestra").jqxButton();
}

function loadButtonClearDocsMuestra() {
    $("#buttonClearDocsMuestra").jqxButton({height: 25});
}

function loadButtonCrearCarpetaDocsMuestra() {
    $("#buttonCrearCarpetaDocsMuestra").jqxButton({width: 200, disabled: true});
}

function loadButtonEliminarArchivoDocsMuestra() {
    $("#buttonEliminarArchivoDocsMuestra").jqxButton({width: 200, disabled: true});
}

function loadFileUploadDocsMuestra333() {
    $('#fileUploadDocsMuestra333').jqxFileUpload({width: 420, fileInputName: 'fileToUpload',
        localization: {
            browseButton: 'Examinar',
            uploadButton: 'Adjuntar',
            cancelButton: 'Cancelar',
            uploadFileTooltip: 'Datei hochladen',
            cancelFileTooltip: 'aufheben'
        }});
}

function loadModalCreateNewFolder() {
    $("#modalCreateNewFolder").jqxWindow({height: 150, width: 420, title: "Crear nueva carpeta", isModal: true, okButton: $("#buttonAceptarNewFolderDocsMuestra"), autoOpen: false});
}

function loadNotificationDocsMuestra() {
    $("#notificationDocsMuestra").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function loadInputNumMuestraDocsMuestra() {
    $("#inputNumMuestraDocsMuestra").jqxInput({placeHolder: "Número a Consultar", height: 25, width: 200, minLength: 1});
}

function loadInputNombreNuevaCarpetaDocsMuestra() {
    $("#inputNombreNuevaCarpetaDocsMuestra").jqxInput({placeHolder: "Nombre del folder", height: 20, width: 170, minLength: 1});
}

function loadTreeDocsMuestra(data) {

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'parentid'},
                    {name: 'icon'},
                    {name: 'text'},
                    {name: 'value'}
                ],
                id: 'id',
                localdata: data,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);

    dataAdapter.dataBind();

    var records = dataAdapter.getRecordsHierarchy('id', 'parentid', 'items', [{name: 'text', map: 'label'}]);
    $('#treeDocsMuestra').jqxTree({source: records, width: '400px', height: '100%'});
    $('#treeDocsMuestra').jqxTree("expandAll");

    $("#buttonCrearCarpetaDocsMuestra").jqxButton({disabled: false});
    ajaxGetPermisosDocsMuestra();


}

function eventClickButtonAceptarNewFolderDocsMuestra() {
    $("#buttonAceptarNewFolderDocsMuestra").click(function () {
        var item = $('#treeDocsMuestra').jqxTree('getSelectedItem');
        var location = item.value;
        var nameNewFolder = $("#inputNombreNuevaCarpetaDocsMuestra").val();
        if (nameNewFolder == "") {
            eventOpenNotificationDocsMuestra('error', 'No ha escrito un nombre valido parra la nueva carpeta');
        } else {
            ajaxCreateForlderDocsMuestra(location, nameNewFolder);
        }
        var nameNewFolder = $("#inputNombreNuevaCarpetaDocsMuestra").val("");
    });
}

function eventClickButtonCrearCarpetaDocsMuestra() {
    $("#buttonCrearCarpetaDocsMuestra").click(function () {
        var item = $('#treeDocsMuestra').jqxTree('getSelectedItem');
        if (item === null) {
            eventOpenNotificationDocsMuestra('error', 'No ha seleccionado una ubicacionvalida para crear una nueva carpeta');
        } else {
            $('#modalCreateNewFolder').jqxWindow('open');
        }

    });
}

function eventClickButtonEliminarArchivoDocsMuestra() {
    $("#buttonEliminarArchivoDocsMuestra").click(function () {
        var item = $('#treeDocsMuestra').jqxTree('getSelectedItem');
        if (item === null) {
            eventOpenNotificationDocsMuestra('error', 'No se ha seleccionado un archivo o carpeta');
        } else {

            var item = $('#treeDocsMuestra').jqxTree('getSelectedItem');
            var location = item.value;
            ajaxDeleteFileOrFolderDocsMuestra(location);
        }

    });
}

function eventCLickButtonUploadFileDocsMuestra() {
    $("#fileUploadDocsMuestra333").on('uploadStart', function (event) {
        var item = $('#treeDocsMuestra').jqxTree('getSelectedItem');
        $('#fileUploadDocsMuestra333').jqxFileUpload({uploadUrl: 'index.php?action=uploadFile&location=' + item.value});

        if (item.icon == "views/images/folder.png") {

        } else {

        }


    });
}

function eventEndUpLoadFileDocsMuestra() {
    $('#fileUploadDocsMuestra333').on('uploadEnd', function (event) {
        var args = event.args;
        var fileName = args.file;
        var serverResponce = args.response;
        var idMuestra = $("#inputNumMuestraDocsMuestra").val();
        ajaxScanDirByIdMuestra(idMuestra);
    });
}


function eventClickSearchNumMuestraDocsMuestra() {
    $("#searchNumMuestraConHojaRutaMuestra").click(function () {
        var idMuestra = $("#inputNumMuestraDocsMuestra").val();
        ajaxScanDirByIdMuestra(idMuestra);
    });
}

//function eventClickTreeDocsMuestra(){
//    $('#treeDocsMuestra').on('select',function (event)
//    {
//        var args = event.args;
//        var item = $('#treeDocsMuestra').jqxTree('getItem', args.element);
//        var label = item.value; 
//        alert(label);
//    });
//}

function eventOpenNotificationDocsMuestra(template, message) {
    $("#messageNotificationDocsMuestra").text(message);
    $("#notificationDocsMuestra").jqxNotification({template: template});
    $("#notificationDocsMuestra").jqxNotification("open");
}

function ajaxScanDirByIdMuestra(idMuestra) {
    var indice;

    var url = "index.php?action=scanDirByIdMuestra";
    var data = "idMuestra=" + idMuestra;
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (response) {
            
            var aux = JSON.parse(response);
            if (aux.code == "00000") {
                var data = JSON.stringify(aux.data) ;
                loadTreeDocsMuestra(data);
                $("#treeDocsMuestra li").unbind();
                $("#treeDocsMuestra li").on('dblclick', function (event) {
                    var target = $(event.target).parents('li:first')[0];
                    if (target != null) {
                        $("#treeDocsMuestra").jqxTree('selectItem', target);
                        var selectedItemA = $('#treeDocsMuestra').jqxTree('selectedItem');
                        if (selectedItemA.icon == "views/images/file_icon.png") {
                            var scrollTop = $(window).scrollTop();
                            var scrollLeft = $(window).scrollLeft();
                            window.open(selectedItemA.id, '_blank');
                        }
                        return false;
                    }
                });
            } else {
                eventOpenNotificationDocsMuestra('error', 'No fue posible consultar la carpeta asociada a l muestra');
            }

        }
    });
}

function ajaxCreateForlderDocsMuestra(location, newFolderName) {
    var url = "index.php";
    var data = "action=createNewFolderDocsMuestra";
    data = data + "&location=" + location;
    data = data + "&newFolderName=" + newFolderName;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data) {
            //alert(data);
            var response = JSON.parse(data);
            if (response.result === '1') {
                var idMuestra = $("#inputNumMuestraDocsMuestra").val();
                ajaxScanDirByIdMuestra(idMuestra);
                eventOpenNotificationDocsMuestra('success', 'Se creo exitosamente la carpeta');
            } else {
                eventOpenNotificationDocsMuestra('error', 'Fallo en la creación de la carpeta');
            }

        }
    });
}

function ajaxDeleteFileOrFolderDocsMuestra(location) {
    var url = "index.php";
    var data = "action=deleteOrFileFolder";
    data = data + "&location=" + location;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data) {
            //alert(data);
            var response = JSON.parse(data);
            if (response.result === '1') {
                var idMuestra = $("#inputNumMuestraDocsMuestra").val();
                ajaxScanDirByIdMuestra(idMuestra);
                eventOpenNotificationDocsMuestra('success', response.message);
            } else {
                eventOpenNotificationDocsMuestra('error', response.message);
            }

        }
    });
}

function ajaxGetPermisosDocsMuestra() {
    var url = "index.php";
    var data = "action=getPermisos";
    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: true,
        success: function (data) {
            //alert(data);
            var response = JSON.parse(data);
            if (response.muestraDocsBotonEliminarArchivos == "true") {
                $("#buttonEliminarArchivoDocsMuestra").jqxButton({disabled: false});
            } else {
                $("#buttonEliminarArchivoDocsMuestra").jqxButton({disabled: true});
            }

        }
    });
}

