function initialLoadRepoDocs() {

    //load Items
    loadTreePrincipalRepoDocs();
    //loadButtonCrearCarpetaRepoDocs();
    loadNotificationRepoDocs();
    loadWindowCrearCarpetaRepoDocs();
    //loadButtonSubirArchivoRepoDocs();
    loadButtonConfRepoRepoDocs();
    loadWindowConfRepoRepoDocs();
    loadWindowUploadFileRepoDocs();
    //events
    //eventClickButtonCrearCarpetaRepoDocs();
    eventClickButtonOKCrearCarpetaRepoDocs();
    eventClickButtonConfRepoRepoDocs();
    eventClickButtonOKConfRepoRepoDocs();
    eventUploadEndUploadFileRepoDocs();
    eventUploadStartUploadFileRepoDocs();
    
    $("#windowDeleteFileRepoDocs").jqxWindow({
        position: {x: 300, y: 200},
        resizable: false,
        showCollapseButton: true,
        height: 150,
        width: 500,
        isModal: true,
        title: 'Confirmacion de borrado',
        cancelButton: $("#buttonCancelarwindowDeleteFileRepoDocs"),
        okButton: $("#buttonOKwindowDeleteFileRepoDocs"),
        autoOpen: false,
        initContent: function () {
            $("#buttonOKwindowDeleteFileRepoDocs").jqxButton({width: '100', height: '25px'});
            $("#buttonCancelarwindowDeleteFileRepoDocs").jqxButton({width: '100', height: '25px'});
            
        }
    });
    
    $('#windowDeleteFileRepoDocs').on('close', function (event) {
        if (event.args.dialogResult.OK === true) {
            var selectedItem = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
            var promise = ajaxEliminarFileRepoDocsById(selectedItem.id);
            promise.success(function (data) {
                var response = JSON.parse(data);
                if (response.result === 0) {
                    
                    $('#treePrincipalRepoDocs').jqxTree('removeItem', selectedItem.element, false);
                    eventOpeNotificationRepoDocs('success', response.message);
                } else {
                    eventOpeNotificationRepoDocs('error', response.message);
                }
            });
        }
    });
    
    $("#divGridSearchResultRepoDocs").hide();
    $("#inputSearchRepoDocs").jqxInput({placeHolder: "Buscar ...", height: 23, width: 205, minLength: 1});
    $("#buttonSearchRepoDocs").click(function () {
        var value = $("#inputSearchRepoDocs").val();
        $("#divGridSearchResultRepoDocs").hide("slow",function(){
            utilLoadGridSearchResultRepoDocs(value);
        });

        
    });
    
    

    

    

   
}

function utilLoadGridSearchResultRepoDocs(name) {
    var url = "model/DB/jqw/repositorioData.php?query=searchLikeName&name="+name;
    // prepare the data
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id', type: 'int'},
                    {name: 'esCarpeta', type: 'int'},
                    {name: 'nombre', type: 'string'},
                    {name: 'extension', type: 'string'},
                    {name: 'nombreCompleto', type: 'string'},
                    {name: 'path', type: 'string'},
                    {name: 'icon', type: 'string'},
                    {name: 'link', type: 'string'}
                ],
                id: 'id',
                url: url,
                root: 'data',
                async: false
            };
    var imagerenderer = function (row, datafield, value) {
        return '<img style="margin-left: 5px; margin-top: 5px;" height="16" width="16" src="' + value + '"/>';
    }
    var linkRender = function (row, datafield, value) {
        if(value != ''){
            return '<a href="' + value + '" target="_blank"><img style="margin-left: 5px; margin-top: 5px;" height="16" width="16" src="views/images/downloadimage.png"/></a>';
        } else {
            
        }
        
    }        
    var dataAdapter = new $.jqx.dataAdapter(source, {
        
        loadComplete: function (data) {
            $("#divGridSearchResultRepoDocs").show("slow");
        }
    });
    $("#gridSearchResultRepoDocs").jqxGrid(
            {
                width: 490,
                height: 270,
                source: dataAdapter,
                columnsresize: true,
                columns: [
                    {text: 'id', dataField: 'id', width: 200, hidden: true},
                    {text: '', dataField: 'icon', width: 25, cellsrenderer: imagerenderer},
                    {text: 'Nombre', dataField: 'nombreCompleto', width: 400,cellsalign: 'right'},
                    {text: 'Ext', dataField: 'extension', width: 40, cellsalign: 'center'},
                    {text: '.', dataField: 'link', width: 25, cellsrenderer: linkRender},
                ]
            });
            
            

}



function loadWindowUploadFileRepoDocs(){
    $("#windowUploadFileRepoDocs").jqxWindow({
        position: {x: 300, y: 200},
        resizable: false,
        showCollapseButton: true,
        height: 300,
        width: 500,
        isModal: true,
        title: 'Seleccione los archivos para subir al repositorio',
        cancelButton: $('#buttonCancelarConfRepoRepoDocs'),
        autoOpen: false,
        initContent: function () {
            $('#uploadFileRepoDocs').jqxFileUpload({localization: {browseButton: 'Explorar', uploadButton: 'Subir', cancelButton: 'Cancelar', uploadFileTooltip: 'Subir Archivo', cancelFileTooltip: 'Cancelar'},
                rtl: true, width: 450, fileInputName: 'fileToUpload'});
        }
    });
}

function eventUploadStartUploadFileRepoDocs(){
    $('#uploadFileRepoDocs').on('uploadStart', function (event) {
        var fileName = event.args.file;
        var selectedItem = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
        $('#uploadFileRepoDocs').jqxFileUpload({
            uploadUrl: 'index.php?action=uploadFileRepoDocs&idParentFolder=' + selectedItem.id
        });
    });
}

function eventUploadEndUploadFileRepoDocs(){
    $('#uploadFileRepoDocs').on('uploadEnd', function (event) {
        var args = event.args;
        var fileName = args.file;
        var serverResponce = args.response;
        var response = JSON.parse(serverResponce);
        if (response.result === 0) {
            
            var selectedItem = $('#treePrincipalRepoDocs').jqxTree('getSelectedItem');
             var selectedId = selectedItem.element;
            var elemento = response.nomeArchivo;
                    $('#treePrincipalRepoDocs').jqxTree('addTo', { id: response.idArchivo, label: elemento, icon: "views/images/file_icon.png" }, selectedId);
            eventOpeNotificationRepoDocs('success', response.message);
        } else {
            eventOpeNotificationRepoDocs('error', response.message);
        }
    });
}

function eventClickButtonOKConfRepoRepoDocs() {
    $("#buttonOKConfRepoRepoDocs").on('click', function (event) {
        var item = $('#treeConfRepoRepoDocs').jqxTree('getSelectedItem');

        var promiseChargeNewRepoRepoDocs = ajaxChargeNewRepoRepoDocs(item.value);
        promiseChargeNewRepoRepoDocs.success(function (data) {
            var response = JSON.parse(data);
            if (response.result === 0) {
                $('#windowConfRepoRepoDocs').jqxWindow('close');
                loadTreePrincipalRepoDocs();
                eventOpeNotificationRepoDocs('success', response.message);
            } else {
                eventOpeNotificationRepoDocs('error', response.message);
            }
        });
    });
}

function loadWindowConfRepoRepoDocs() {
    $("#windowConfRepoRepoDocs").jqxWindow({
        position: {x: 300, y: 200},
        showCollapseButton: true,
        maxHeight: 400,
        maxWidth: 700,
        minHeight: 190,
        minWidth: 200,
        height: 700,
        width: 500,
        isModal: true,
        title: 'Configurar repositorio',
        cancelButton: $('#buttonCancelarConfRepoRepoDocs'),
        autoOpen: false,
        initContent: function () {
            $("#buttonCancelarConfRepoRepoDocs").jqxButton({width: '100', height: '25px'});
            $("#buttonOKConfRepoRepoDocs").jqxButton({width: '100', height: '25px'});
            utilLoadTreeConfRepoRepoDocs();
        }
    });
}

function eventClickButtonOKCrearCarpetaRepoDocs() {
    $('#buttonOKCrearCarpetaRepoDocs').on('click', function () {
        var selectedItem = $('#treePrincipalRepoDocs').jqxTree('getSelectedItem');


        var newCarpeta = $("#inputNombreNuevacarpetaCerarCarpetaRepoDocs").jqxInput('val');
        if (newCarpeta == null || newCarpeta == '') {
            eventOpeNotificationRepoDocs('error', 'Debe digitar un nombre valido para la nueva carpeta');
        } else {
            var selectedId = selectedItem.id;
            var promise = ajaxCrearNuevaCarpeta(newCarpeta, selectedId);
            promise.success(function (data) {
                var response = JSON.parse(data);
                if (response.result === 0) {
                    var selectedItem = $('#treePrincipalRepoDocs').jqxTree('getSelectedItem');
                    var selectedId = selectedItem.element;
                    var elemento = $("#inputNombreNuevacarpetaCerarCarpetaRepoDocs").val();
                    $('#treePrincipalRepoDocs').jqxTree('addTo', { id: response.idCarpeta, label: elemento, icon: "views/images/folder.png" }, selectedId);
                     
                    $("#inputNombreNuevacarpetaCerarCarpetaRepoDocs").val('');
                    $('#windowCrearCarpetaRepoDocs').jqxWindow('close');
                    eventOpeNotificationRepoDocs('success', response.message);
                } else {
                    eventOpeNotificationRepoDocs('error', response.message);
                }
            });
        }
    });
}

function loadWindowCrearCarpetaRepoDocs() {
    $("#windowCrearCarpetaRepoDocs").jqxWindow({
        position: {x: 500, y: 200},
        showCollapseButton: true,
        maxHeight: 400,
        maxWidth: 700,
        minHeight: 190,
        minWidth: 200,
        height: 80,
        width: 400,
        isModal: true,
        title: 'Crear nueva Carpeta',
        cancelButton: $('#buttonCancelarCrearCarpetaRepoDocs'),
        autoOpen: false,
        initContent: function () {
            $("#buttonCancelarCrearCarpetaRepoDocs").jqxButton({width: '100', height: '25px'});
            $("#inputNombreNuevacarpetaCerarCarpetaRepoDocs").jqxInput({placeHolder: "Nombre carpeta", height: 25, width: 200});
            $("#buttonOKCrearCarpetaRepoDocs").jqxButton({width: '100', height: '25px'});
        }
    });
}

function loadNotificationRepoDocs() {
    $("#notificationRepoDocs").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function getRepoFileDownloadLinkById(idFile){
    var url = "index.php";
    var data = "action=getRepoFileDownloadLinkById";
    data = data + "&idFile=" + idFile;
    return   $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: true
    });
}

function loadTreePrincipalRepoDocs() {
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'parent'},
                    {name: 'nombre'},
                    {name: 'path'},
                    {name: 'icon'}
                ],
                id: 'id',
                url: 'model/DB/jqw/repositorioData.php?query=all',
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    dataAdapter.dataBind();
    var records = dataAdapter.getRecordsHierarchy('id', 'parent', 'items', [{name: 'nombre', map: 'label'}, {name: 'path', map: 'value'}, {name: 'icon', map: 'icon'}]);
    $('#treePrincipalRepoDocs').jqxTree({source: records, width: '600px', height: '380px'});
    //$('#treePrincipalRepoDocs').jqxTree('expandAll');

    var contextMenu = $("#menuContextPrincipalTreeRepoDocs").jqxMenu({width: '120px', height: '84px', autoOpenPopup: false, mode: 'popup'});
    var clickedItem = null;
    
    $("#treePrincipalRepoDocs li").unbind();
    $("#treePrincipalRepoDocs li").on('dblclick',function(event){
            var target = $(event.target).parents('li:first')[0];
            if (target != null) {
                $("#treePrincipalRepoDocs").jqxTree('selectItem', target);
                var selectedItemA = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
                if (selectedItemA.icon == "views/images/file_icon.png") {
                    var scrollTop = $(window).scrollTop();
                    var scrollLeft = $(window).scrollLeft();
                    var promise = getRepoFileDownloadLinkById(selectedItemA.id);
                    promise.success(function (data) {
                    var response = JSON.parse(data);
                    if (response.result === 0) {
                        window.open(response.message, '_blank');
                    } else {
                        eventOpeNotificationRepoDocs('error', response.message);
                    }
                });
                     
                }
                return false;
            }
        });

    var attachContextMenu = function () {
        // open the context menu when the user presses the mouse right button.
        $("#treePrincipalRepoDocs li").on('mousedown', function (event) {
            var target = $(event.target).parents('li:first')[0];
            var rightClick = isRightClick(event);
            if (rightClick && target != null) {
                $("#treePrincipalRepoDocs").jqxTree('selectItem', target);
                var selectedItem = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
                if (selectedItem.icon == 'views/images/folder.png') {
                    $('#menuContextPrincipalTreeRepoDocs').jqxMenu('disable', 'liCrearCarpetaMenuContextPrincipalTreeRepoDocs', false);
                    $('#menuContextPrincipalTreeRepoDocs').jqxMenu('disable', 'liSubirArchivoMenuContextPrincipalTreeRepoDocs', false);
                    
                    $('#menuContextPrincipalTreeRepoDocs').jqxMenu('disable', 'liEliminarMenuContextPrincipalTreeRepoDocs', false);
                } else {
                    $('#menuContextPrincipalTreeRepoDocs').jqxMenu('disable', 'liCrearCarpetaMenuContextPrincipalTreeRepoDocs', true);
                    $('#menuContextPrincipalTreeRepoDocs').jqxMenu('disable', 'liSubirArchivoMenuContextPrincipalTreeRepoDocs', true);
                    
                    $('#menuContextPrincipalTreeRepoDocs').jqxMenu('disable', 'liEliminarMenuContextPrincipalTreeRepoDocs', false);
                }
                var scrollTop = $(window).scrollTop();
                var scrollLeft = $(window).scrollLeft();
                contextMenu.jqxMenu('open', parseInt(event.clientX) + 5 + scrollLeft, parseInt(event.clientY) + 5 + scrollTop);
                return false;
            }
        });
    }

    attachContextMenu();
    $("#menuContextPrincipalTreeRepoDocs").unbind();
    
    $("#menuContextPrincipalTreeRepoDocs").on('itemclick', function (event) {
        var item = $.trim($(event.args).text());
        switch (item) {
            case "Crear carpeta":
                var selectedItem = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
                if (selectedItem != null) {
                    $('#windowCrearCarpetaRepoDocs').jqxWindow('open');
                    attachContextMenu();
                }
                break;
            case "Subir Archivo":
                var selectedItem = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
                if (selectedItem != null) {
                    $("#windowUploadFileRepoDocs").jqxWindow("move", $(window).width() / 2 - $("#windowUploadFileRepoDocs").jqxWindow("width") / 2, $(window).height() / 2 - $("#windowUploadFileRepoDocs").jqxWindow("height") / 2);
                    $('#windowUploadFileRepoDocs').jqxWindow('expand');
                    $('#windowUploadFileRepoDocs').jqxWindow('open');
                    attachContextMenu();
                }
                break;
            case "Eliminar":
                var selectedItem = $('#treePrincipalRepoDocs').jqxTree('selectedItem');
                if (selectedItem != null) {
                     if (selectedItem.icon == 'views/images/folder.png'){
                         $("#windowDeleteFileRepoDocsTextConfirmation").html('Confirma que desea eliminar la carpeta \"<strong>' + selectedItem.label + '</strong>\" y su contenido ?');
                     } else {
                         $("#windowDeleteFileRepoDocsTextConfirmation").html('Confirma que desea eliminar el archivo \"<strong>' + selectedItem.label + '</strong>\" ?');
                     }
                    
                    $("#windowDeleteFileRepoDocs").jqxWindow("move", $(window).width() / 2 - $("#windowDeleteFileRepoDocs").jqxWindow("width") / 2, $(window).height() / 2 - $("#windowDeleteFileRepoDocs").jqxWindow("height") / 2);
                    $('#windowDeleteFileRepoDocs').jqxWindow('expand');
                    $("#windowDeleteFileRepoDocs").jqxWindow('open');
                    attachContextMenu();
                }
                break;
        }
    });

    // disable the default browser's context menu.
    $(document).on('contextmenu', function (e) {
        if ($(e.target).parents('.jqx-tree').length > 0) {
            return false;
        }
        return true;
    });
    function isRightClick(event) {
        var rightclick;
        if (!event)
            var event = window.event;
        if (event.which)
            rightclick = (event.which == 3);
        else if (event.button)
            rightclick = (event.button == 2);
        return rightclick;
    }


}

function loadButtonCrearCarpetaRepoDocs() {
    $("#buttonCrearCarpetaRepoDocs").jqxButton({width: '150', height: '25px'});

}

function loadButtonSubirArchivoRepoDocs() {
    $("#buttonSubirArchivoRepoDocs").jqxButton({width: '150', height: '25px'});

}

function loadButtonConfRepoRepoDocs() {
    $("#buttonConfRepoRepoDocs").jqxButton({width: '200', height: '25px'});

}

function eventClickButtonCrearCarpetaRepoDocs() {
    $('#buttonCrearCarpetaRepoDocs').on('click', function () {
        var selectedItem = $('#treePrincipalRepoDocs').jqxTree('getSelectedItem');
        if (selectedItem == null) {
            eventOpeNotificationRepoDocs('error', 'Para crear una carpeta debe selccionar la carpeta contenedora.');
        } else {
            var promise = ajaxGetEsCarpetaByID(selectedItem.id);
            promise.success(function (data) {
                var response = JSON.parse(data);
                if (response.esCarpeta === true) {
                    $('#windowCrearCarpetaRepoDocs').jqxWindow('open');
                } else {
                    eventOpeNotificationRepoDocs('error', 'Para crear una carpeta debe selccionar la carpeta contenedora.');
                }
            });
        }

    });
}

function eventOpeNotificationRepoDocs(template, message) {
    $("#messageNotificationRepoDocs").text(message);
    $("#notificationRepoDocs").jqxNotification({template: template});
    $("#notificationRepoDocs").jqxNotification("open");
}

function eventClickButtonConfRepoRepoDocs() {
    $("#buttonConfRepoRepoDocs").on('click', function () {
        utilLoadTreeConfRepoRepoDocs();
        $('#windowConfRepoRepoDocs').jqxWindow('open');
    });
}

function ajaxCrearNuevaCarpeta(nombre, selectedId) {
    var url = "index.php";
    var data = "action=crearCarpetaRepoDocs";
    data = data + "&nombre=" + nombre;
    data = data + "&selectedId=" + selectedId;


    return $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false
    });
}

function ajaxGetEsCarpetaByID(id) {
    var url = "index.php";
    var data = "action=getEsCarpetaById";
    data = data + "&id=" + id;
    return   $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false
    });
}

function utilLoadTreeConfRepoRepoDocs() {
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'parent'},
                    {name: 'nombre'},
                    {name: 'path'},
                    {name: 'icon'}
                ],
                id: 'id',
                url: 'index.php?action=getRootsRepoDocs',
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    dataAdapter.dataBind();
    var records = dataAdapter.getRecordsHierarchy('id', 'parent', 'items', [{name: 'nombre', map: 'label'}, {name: 'path', map: 'value'}, {name: 'icon', map: 'icon'}]);
    $('#treeConfRepoRepoDocs').jqxTree({source: records, width: '300px', height: '300px'});
    $('#treeConfRepoRepoDocs').jqxTree('expandAll');
}

function ajaxChargeNewRepoRepoDocs(rootPath) {
    var url = "index.php";
    var data = "action=chargeNewRootPathRepoDocs";
    data = data + "&rootPath=" + rootPath;
    return   $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false
    });
}

function ajaxEliminarFileRepoDocsById(idFile) {
    var url = "index.php";
    var data = "action=eliminarFileRepoDocsById";
    data = data + "&idFile=" + idFile;
    return   $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false
    });
}

