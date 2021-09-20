var regEstCotizacionModuleApp = angular.module("regEstCotizacionModuleApp", ["jqwidgets"]);

regEstCotizacionModuleApp.controller("regEstCotizacionModuleController", function ($scope, $http, $location) {
    
    $scope.buttonRechazarEstCot = {
        settings : {
            width: "130",
            disabled: true
        },
        events : {
            click : function(event){
                $scope.windowrechazarCot.settings.apply("open");
            }
        }
    }
            
            
            

    $scope.buttonActualizarCot = {
        settings : {
            width: "130",
            disabled: true
        },
        events : {
            click : function(event){
                var fechaSolicitud = $("#fechaSolicitudRegEstCotizacion").jqxDateTimeInput('val', 'date').getFullYear() + "-" + (parseInt($("#fechaSolicitudRegEstCotizacion").jqxDateTimeInput('val', 'date').getMonth())+1) + "-" + $("#fechaSolicitudRegEstCotizacion").jqxDateTimeInput('val', 'date').getDate();
                var fechaCompromiso = $("#fechaCompromisoRegEstCotizacion").jqxDateTimeInput('val', 'date').getFullYear() + "-" + (parseInt($("#fechaCompromisoRegEstCotizacion").jqxDateTimeInput('val', 'date').getMonth())+1) + "-" + $("#fechaCompromisoRegEstCotizacion").jqxDateTimeInput('val', 'date').getDate();
                var cotizacion = {
                    idCotizacion : $scope.inputNumeroCotizacion.model,
                    fechaSolicitud : fechaSolicitud,
                    fechaCompromiso : fechaCompromiso,
                    idtercero : $("#nombreClienteRegEstCotizacion").val().value,
                    nomTercero : $("#nombreClienteRegEstCotizacion").val().label,
                    nomContacto : $("#nomContactoRegEstCotizacion").val(),
                    telContacto : $("#telContactoRegEstCotizacion").val(),
                    idProducto : $("#inputProductoRegEstCotizacion").val().value,
                    nomProducto : $("#inputProductoRegEstCotizacion").val().label,
                    tipoEstabilidadValue : $("#dropDownTipoEstabilidadRegEstCotizacion").jqxDropDownList('getSelectedItem').value,
                    tipoEstabilidadLabel : $("#dropDownTipoEstabilidadRegEstCotizacion").jqxDropDownList('getSelectedItem').label,
                    tiemposEstabilidadValue : $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('getSelectedItem').value,
                    tiemposEstabilidadLabel : $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('getSelectedItem').label,
                    aplicaIva: $("#CheckBoxAplicaIvaRegEstCotizacion").val(),
                    aplicaRetencion: $("#CheckBoxAplicaRetencionRegEstCotizacion").val(),
                    observacion1: $("#observacionesRegEstCotizacion").jqxEditor('val'),
                    observacion2: $("#observaciones2RegEstCotizacion").jqxEditor('val'),
                    observacion3: $("#observaciones3RegEstCotizacion").jqxEditor('val'),
                    ensayos : $("#gridProductosEnsayosRegEstCotizacion").jqxGrid('getrows')
                    
                };
                var promiseUpdateCotizacion = ajaxUpdateEstCotizacion(cotizacion);
                promiseUpdateCotizacion.success(function (response) {
                    
                    var respuesta = JSON.parse(response);
                    if (respuesta != null) {
                        eventOpenNotificationRegEstCotizacion('success', respuesta.message);
                            
                    } else {
                        eventOpenNotificationRegEstCotizacion('error', respuesta.message);
                    }
                });
            }
        }
    };


    $scope.buttonConsultaEnvios = {
        label: "Consultar envios",
        settings: {
            width: "130",
            disabled: true
        },
        events: {
            click: function (event) {
                $scope.windowConsultaEnviosRegEstCotizacion.settings.title = "Envios Cotización " + $scope.inputNumeroCotizacion.model;

                var newSource = {
                    datatype: "json",
                    url: "model/DB/jqw/EnvioEstCotizacionData.php?query=getEnvioEstCotizacionByIdCotizacion&idCotizacion=" + $scope.inputNumeroCotizacion.model,
                    datafields: [
                        {name: 'id', type: 'int'},
                        {name: 'idCotizacion', type: 'int'},
                        {name: 'destino', type: 'string'},
                        {name: 'medio', type: 'string'},
                        {name: 'observaciones', type: 'string'},
                        {name: 'fecha', type: 'date'}
                    ]
                };

                var newDataAdapter = new $.jqx.dataAdapter(newSource);
                $scope.windowConsultaEnviosRegEstCotizacion.settings.apply('open');
                $scope.gridEnviosEstCotizacion.settings.source = newDataAdapter;
                
            }
        }
    }

    $scope.buttonEnviarCotizacionRegCotizacion = {
        label: "Enviar",
        settings: {
            width: "130",
            disabled: true
        },
        events: {
            click: function (event) {
                $scope.windowEnviarEnsayoRegEstCotizacion.settings.apply('open');
            }
        }

    };

    $scope.gridEnviosEstCotizacion = {
        source: {
            datatype: "json",
            datafields: [
                {name: 'id', type: 'int'},
                {name: 'idCotizacion', type: 'int'},
                {name: 'destino', type: 'string'},
                {name: 'medio', type: 'string'},
                {name: 'observaciones', type: 'string'},
                {name: 'fecha', type: 'date'}
            ]
        },
        settings: {
            altrows: true,
            width: 800,
            height: 250,
            columns: [
                {text: 'id', datafield: 'id', width: 50, hidden: true},
                {text: 'Cotizacion', datafield: 'idCotizacion', width: 100},
                {text: 'Destino', datafield: 'destino', width: 150},
                {text: 'Medio', datafield: 'medio', width: 150},
                {text: 'Observaciones', datafield: 'observaciones', width: 300},
                {text: 'Fecha Envio', datafield: 'fecha', columntype: 'datetimeinput', cellsformat: 'dd-MM-yyyy', width: 100}
            ],
        }
    }

    $scope.inputDestinoRegEstCotizacion = {
        settings: {
            width: 350,
            height: 20
        }
    };

    $scope.inputMedioRegEstCotizacion = {
        settings: {
            width: 350,
            height: 20
        }
    };
 
    
//    $scope.inputNumeroCotizacion = {
//        //model: $("#numCotizacionRegEstCotizacion").jqxInput("val").value
//        //model : getIdcotizacion()
//    };

    $scope.windowConsultaEnviosRegEstCotizacion = {
        content: {
        },
        settings: {
            title: "Consulta de envios cotización",
            position: "center",
            height: 350,
            width: 850,
            maxWidth: 1000,
            autoOpen: false,
            isModal: true,
            resizable: false,
            initContent: function () {

            }
        },
        events: {
            close: function (event) {

            }
        }
    };

    $scope.windowEnviarEnsayoRegEstCotizacion = {
        content: {
        },
        settings: {
            title: "Envio de cotizacion",
            position: "center",
            height: 450,
            width: 500,
            autoOpen: false,
            isModal: true,
            resizable: false,
            okButton: $("#buttonOKwindowEnviarEnsayoRegEstCotizacion"),
            cancelButton: $("#buttonCancelwindowEnviarEnsayoRegEstCotizacion"),
            initContent: function () {
                $scope.textAreaObservacionesEnvioRegEstCotizacion = {
                    //model: "<div>Text is synchronized on blur.</div>",
                    html: "",
                    settings: {
                        height: "200px",
                        width: '450px',
                        tools: "old italic underline | format font size | color background | ul ol | link | clean"
                    }
                };
            }
        },
        events: {
            close: function (event) {
                if (event.args.dialogResult.OK === true) {
                    var observaciones = $("#editorObservacioneswindowEnviarEnsayoRegEstCotizacion").jqxEditor('val');
                    var response = $scope.guardarEnvio($scope.inputNumeroCotizacion.model, $scope.inputDestinoRegEstCotizacion.model, $scope.inputMedioRegEstCotizacion.model, observaciones);
                    response.success(function (data) {
                        if (data.result === 0) {
                            var idCotizacion = $("#numCotizacionRegEstCotizacion").jqxInput('val');
                            ajaxSearchEstCotizacionById(idCotizacion);
                            eventOpenNotificationRegEstCotizacion('success', data.message);
                        } else {
                            eventOpenNotificationRegEstCotizacion('error', data.message);
                        }
                    });
                }
                $scope.inputDestinoRegEstCotizacion.model = "";
                $scope.inputMedioRegEstCotizacion.model = "";
                $("#editorObservacioneswindowEnviarEnsayoRegEstCotizacion").jqxEditor('val', '');
            }
        }
    };

    $scope.guardarEnvio = function (idCotizacion, destino, medio, observaciones) {

        var data = {
            action: "guardarEnvioEstCotizacion",
            idCotizacion: idCotizacion,
            destino: destino,
            medio: medio,
            observaciones: observaciones
        }

        return $http({
            method: "POST",
            url: "index.php",
            data: $.param(data),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });



    };
    
    $scope.windowrechazarCot = {
        settings : {
            maxHeight: 1000,
            maxWidth: 1000,
            minHeight: 30,
            minWidth: 250,
            height: 320,
            width: 450,
            resizable: false,
            isModal: true,
            autoOpen: false,
            title: "Rechazar cotizacion",
            okButton: $("#buttonOKRechazarCotRegCotizacion"),
            cancelButton: $("#buttonCancelarRechazarCotRegCotizacion"),
            initContent: function () {
                $scope.editorMotivoRechazo = {
                    model: "",
                    settings: {
                        height: 200,
                        width: 410,
                        tools: ""
                    }
                }
            }
        },
        events : {
            close : function(event){
                if (event.args.dialogResult.OK === true) {
                    
                    
                    var data = {
                        action : "rechazarEstCotizacion",
                        idCotizacion : $("#numCotizacionRegEstCotizacion").jqxInput("val"),
                        motivo : $("#editorRechazoCotRegCotizacion").jqxEditor("val")
                    };
                    
                    var url = "index.php";
                    
                    var rechazarCotPromise = callPost(url, data);
                    
                    rechazarCotPromise.then(function successCallback(response) {
                        if (response.data.result === 0) {
                            var idCotizacion = $("#numCotizacionRegEstCotizacion").jqxInput('val');
                            ajaxSearchEstCotizacionById(idCotizacion);
                            eventOpenNotificationRegEstCotizacion('success', response.data.message);
                        } else {
                            eventOpenNotificationRegEstCotizacion('error', response.data.message);
                        }

                    });
                } 
                
            }
        }
    };
    
    function callPost(url, data) {
        return $http({
            method: "POST",
            url: url,
            data: $.param(data),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        });
    }

});

function initLoadRegEstCotizacion(idPerfil, idUsuario, idCotizacion) {
     
        function getIdcotizacion(){
            return idCotizacion;
        }
    //load components
    loadCheckBoxAplicaIvaRegEstCotizacion();
    loadCheckBoxAplicaRetencionRegEstCotizacion();
    loadNumCotizacionRegEstCotizacion();
    loadEstadoRegEstCotizacion();
    loadDateInputFechaSolicitudRegEstCotizacion();
    loadDateInputFechaCompromisoRegEstCotizacion();
    loadInputNombreClienteRegEstCotizacion();
    loadInputNomContactoRegEstCotizacion();
    loadInputTelContactoRegEstCotizacion();
    loadEditorObservacionesRegEstCotizacion();
    loadEditorObservaciones2RegEstCotizacion();
    loadEditorObservaciones3RegEstCotizacion();
    loadInputProductoRegEstCotizacion();
    loadDropDownTipoEstabilidadRegEstCotizacion();
    loadDropDownTiemposRegEstCotizacion();
    loadNotificationRegEstCotizacion();
    loadWindowLoadTiemposRegEstCotizacion();
    loadButtonRegistrarRegEstCotizacion();
    loadButtonLimpiarRegEstCotizacion();
    loadButtonGenerarEnsayosRegEstCotizacion();
    loadButtonGenerarMuestraRegEstCotizacion();
    loadButtonImprimirCotizacionEst();

    // load Events

    eventSelectInputProductoRegEstCotizacion();
    eventChangeDropDownTipoEstabilidadRegEstCotizacion();
    eventSelectDropDownTiemposRegEstCotizacion();
    eventOpenwindowLoadTiemposRegEstCotizacion();
    eventClickButtonGenerarCotizacionRegEstCotizacion();
    eventClickButtonLimpiarRegEstCotizacion();
    eventClickButtonGenerarMuestraRegEstCotizacion();
    eventClickButtonInformeEstPrint();


    $("#searchNumEstCotizacion").click(function () {
        var idCotizacion = $("#numCotizacionRegEstCotizacion").jqxInput('val');
        ajaxSearchEstCotizacionById(idCotizacion);
        

    });


    $("#buttonGenerarEnsayosRegEstCotizacion").click(function () {



        $('#windowLoadTiemposRegEstCotizacion').jqxWindow('open');

    });





}

function eventClickButtonGenerarMuestraRegEstCotizacion() {
    $("#buttonGenerarMuestraRegEstCotizacion").click(function () {

        var idCotizacion = $("#numCotizacionRegEstCotizacion").jqxInput('val');
        idCotizacion += '|a|a|4';
        window.location.href = 'index.php?action=regmuestra&idCotizacion=' + idCotizacion;
    });
}
function loadCheckBoxAplicaIvaRegEstCotizacion() {
    $("#CheckBoxAplicaIvaRegEstCotizacion").jqxCheckBox({width: 120, height: 25});
}
function loadCheckBoxAplicaRetencionRegEstCotizacion() {
    $("#CheckBoxAplicaRetencionRegEstCotizacion").jqxCheckBox({width: 120, height: 25});
}
function loadButtonGenerarMuestraRegEstCotizacion() {
    $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({width: '130', disabled: true});
}
//JP
function loadButtonImprimirCotizacionEst() {
    $("#buttonImprimirEstCotizacion").jqxButton({width: '130', disabled: true});
}

function loadButtonGenerarEnsayosRegEstCotizacion() {
    $("#buttonGenerarEnsayosRegEstCotizacion").jqxButton({width: '130'});
}


function loadButtonLimpiarRegEstCotizacion() {
    $("#buttonLimpiarRegEstCotizacion").jqxButton({width: '130'});


}

function loadButtonRegistrarRegEstCotizacion() {
    $("#buttonRegistrarRegEstCotizacion").jqxButton({width: '130'});
}

function loadWindowLoadTiemposRegEstCotizacion() {
    $('#windowLoadTiemposRegEstCotizacion').jqxWindow({
        position: 'center',
        maxHeight: 400,
        maxWidth: 700,
        minHeight: 200,
        minWidth: 200,
        height: 300, width: 500,
        autoOpen: false,
        isModal: true,
        //initContent: function () {

        //}
    });
}

function loadNumCotizacionRegEstCotizacion() {
    $("#numCotizacionRegEstCotizacion").jqxInput({placeHolder: "numero a buscar", height: 20, width: 200, minLength: 1});
}

function loadEstadoRegEstCotizacion() {
    $("#estadoRegEstCotizacion").jqxInput({height: 20, width: 200, disabled: true});
}

function loadDateInputFechaSolicitudRegEstCotizacion() {
    $("#fechaSolicitudRegEstCotizacion").jqxDateTimeInput({width: '200px', height: '20px'});
}

function loadDateInputFechaCompromisoRegEstCotizacion() {
    $("#fechaCompromisoRegEstCotizacion").jqxDateTimeInput({width: '200px', height: '20px'});
}

function loadInputNombreClienteRegEstCotizacion() {
    var source = {
        datatype: "json",
        datafields: [
            {name: 'id'},
            {name: 'nombre'},
        ],
        url: 'model/DB/jqw/terceroData.php?query=all',
        async: false
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#nombreClienteRegEstCotizacion").jqxInput({source: dataAdapter, placeHolder: "nombre cliente", displayMember: "nombre", valueMember: "id", width: 350, height: 20});
}

function loadInputNomContactoRegEstCotizacion() {
    $("#nomContactoRegEstCotizacion").jqxInput({height: 20, width: 200, minLength: 1});
}

function loadInputTelContactoRegEstCotizacion() {
    $("#telContactoRegEstCotizacion").jqxInput({height: 20, width: 200, minLength: 1});
}

function loadEditorObservacionesRegEstCotizacion() {
    $('#observacionesRegEstCotizacion').jqxEditor({height: 140, width: 800, tools: "old italic underline | format font size | color background | ul ol | link | clean", theme: 'personal2'});
    $('#observacionesRegEstCotizacion').jqxEditor('val', 'A CONTINUACIÓN COTIZAMOS LOS SERVICIOS REQUERIDOS POR USTED');
}


function loadEditorObservaciones2RegEstCotizacion() {
    $('#observaciones2RegEstCotizacion').jqxEditor({height: 140, width: 800, tools: "old italic underline | format font size | color background | ul ol | link | clean", theme: 'personal2'});
    $('#observaciones2RegEstCotizacion').jqxEditor('val', 'CANTIDAD DE MUESTRAS REQUERIDAS PARA LOS ESTUDIOS DE ESTABILIDAD ACELERADA Y NATURAL');
}

function loadEditorObservaciones3RegEstCotizacion() {
    $('#observaciones3RegEstCotizacion').jqxEditor({height: 140, width: 800, tools: "old italic underline | format font size | color background | ul ol | link | clean", theme: 'personal2'});
    $('#observaciones3RegEstCotizacion').jqxEditor('val', 'TESLA CHEMICAL podra adquirir los reactivos y los insumos necesarios para analisis previo acuerdo y negociacion. Si se ha llegado a un acuerdo previamente, TESLA CHEMICAL esta en la capacidad de subcontratar analisis para tercerizarlos. 8 días hábiles después de cumplido el tiempo de estabilidad correspondiente. Esta oferta tiene validez hasta el 31 de Diciembre del 2016 y reemplaza cualquier otra emitida con anterioridad. Pago a 30 días después de la entrega de resultados y radicación de la factura. TESLA CHEMICAL realiza la recepción de las muestras en el lugar que especifique el cliente en el perímetro urbano de la ciudad de BOGOTA D.C sin costo adicional. Para empezar el trabajo de validacion se requiere el envio del placebo preparado o las materias primas y la formula cualicuantativa.');
}

function loadInputProductoRegEstCotizacion() {
    var source = {
        datatype: "json",
        datafields: [
            {name: 'id'},
            {name: 'nombre'},
        ],
        url: 'model/DB/jqw/productoData.php?query=producto',
        async: false
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#inputProductoRegEstCotizacion").jqxInput({source: dataAdapter, displayMember: "nombre", valueMember: "id", height: 20, width: 200, minLength: 1});
}

function loadDropDownTipoEstabilidadRegEstCotizacion() {
    var url = "model/DB/jqw/EstTipoEstabilidadData.php?query=getAllTipoEstabilidad";
    // prepare the data
    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'id'},
                    {name: 'tipoEstabilidad'}
                ],
                url: url,
                async: false
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxDropDownList
    $("#dropDownTipoEstabilidadRegEstCotizacion").jqxDropDownList({
        autoDropDownHeight: true, selectedIndex: 0, source: dataAdapter, displayMember: "tipoEstabilidad", valueMember: "id", width: 200, height: 25
    });
}

function loadDropDownTiemposRegEstCotizacion() {
    var idTipoEstabilidad = $("#dropDownTipoEstabilidadRegEstCotizacion").jqxDropDownList('val');
    if (idTipoEstabilidad == 1) {
        var url = 'config/tiemposEstabilidadNatural.json';
    } else if (idTipoEstabilidad == 2) {
        var url = 'config/tiemposEstabilidadAcelerada.json';
    } else if (idTipoEstabilidad == 3) {
        var url = 'config/tiemposEstabilidadOnGoing.json';
    }

    var source =
            {
                datatype: "json",
                datafields: [
                    {name: 'name', type: 'string'},
                    {name: 'value', type: 'int'}
                ],
                url: url,
                id: 'id',
                async: false
            };

    var dataAdapter = new $.jqx.dataAdapter(source);
    // Create a jqxDropDownList
    $("#dropDownTiemposRegEstCotizacion").jqxDropDownList({
        autoDropDownHeight: true, selectedIndex: 0, source: dataAdapter, displayMember: "name", valueMember: "value", width: 200, height: 25
    });

}



function loadNotificationRegEstCotizacion() {
    $("#notificationRegEstCotizacion").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}

function eventOpenNotificationRegEstCotizacion(template, message) {
    $("#messageNotificationRegEstCotizacion").text(message);
    $("#notificationRegEstCotizacion").jqxNotification({template: template});
    $("#notificationRegEstCotizacion").jqxNotification("open");
}

function eventSelectInputProductoRegEstCotizacion() {
    $('#inputProductoRegEstCotizacion').on('select', function () {

        $('#gridProductosEnsayosRegEstCotizacion').jqxGrid('clear');

    });
}

function eventChangeDropDownTipoEstabilidadRegEstCotizacion() {
    $('#dropDownTipoEstabilidadRegEstCotizacion').on('change', function (event)
    {
        loadDropDownTiemposRegEstCotizacion();
    });
}

function eventSelectDropDownTiemposRegEstCotizacion() {
    $('#dropDownTiemposRegEstCotizacion').on('select', function (event)
    {
        $('#gridProductosEnsayosRegEstCotizacion').jqxGrid('clear');
    });
}

function eventOpenwindowLoadTiemposRegEstCotizacion() {
    $('#windowLoadTiemposRegEstCotizacion').on('open', function (event) {
        var value = $('#inputProductoRegEstCotizacion').val();
        if (value != null && value != '') {
            setTimeout(function () {
                ajaxGetEnsayosByProductoRegEstCotizacion(value.value);
            }, 500);
        } else {
            $('#windowLoadTiemposRegEstCotizacion').jqxWindow('close');
        }

    });
}
function eventClickButtonInformeEstPrint() { //Nuevo JP
    $("#buttonImprimirEstCotizacion").click(function () {
        var idCotizacion = $('#numCotizacionRegEstCotizacion').jqxInput('val');
        window.open("pdf/informes/informeCotizacionEst.php?idCotizacion=" + idCotizacion);

    });

}
function eventClickButtonGenerarCotizacionRegEstCotizacion() {
    $("#buttonRegistrarRegEstCotizacion").on('click', function () {
        var date = new Date();
        var fechaSolicitud = $('#fechaSolicitudRegEstCotizacion').jqxDateTimeInput('val', 'date');
        fechaSolicitud = fechaSolicitud.getFullYear() + "-" + (fechaSolicitud.getMonth() + 1) + "-" + fechaSolicitud.getDate();
        var fechaCompromiso = $('#fechaCompromisoRegEstCotizacion').jqxDateTimeInput('val', 'date');
        fechaCompromiso = fechaCompromiso.getFullYear() + "-" + (fechaCompromiso.getMonth() + 1) + "-" + fechaCompromiso.getDate();
        // alert(fechaSolicitud);
        var tercero = $('#nombreClienteRegEstCotizacion').jqxInput('val');
        if(tercero.value == undefined){
            eventOpenNotificationRegEstCotizacion('error', 'Debe seleccionar un cliente valido para el registro de la cotización');
            return false;
        }
        var contacto = $('#nomContactoRegEstCotizacion').jqxInput('val');
        if(contacto == ''){
            eventOpenNotificationRegEstCotizacion('error', 'Debe digitar un contacto para el registro de la cotización');
            return false;
        }
        var telContacto = $('#telContactoRegEstCotizacion').jqxInput('val');
        var producto = $('#inputProductoRegEstCotizacion').jqxInput('val');
        if(producto.value == undefined){
            eventOpenNotificationRegEstCotizacion('error', 'Debe seleccionar un producto valido para el registro de la cotización');
            return false;
        }
        var tipoEstabilidad = $('#dropDownTipoEstabilidadRegEstCotizacion').jqxDropDownList('getSelectedItem');
        var tiempos = $('#dropDownTiemposRegEstCotizacion').jqxDropDownList('getSelectedItem');
        var observaciones = $('#observacionesRegEstCotizacion').jqxEditor('val');
        var observaciones2 = $('#observaciones2RegEstCotizacion').jqxEditor('val');
        var observaciones3 = $('#observaciones3RegEstCotizacion').jqxEditor('val');
        var aplicaIva = $('#CheckBoxAplicaIvaRegEstCotizacion').jqxCheckBox('val');
        var aplicaRetencion = $('#CheckBoxAplicaRetencionRegEstCotizacion').jqxCheckBox('val');
        var rows = $('#gridProductosEnsayosRegEstCotizacion').jqxGrid('getrows');
        if(rows == undefined){
            eventOpenNotificationRegEstCotizacion('error', 'Debe generar los ensayos para el registro de la cotización');
            return false;
        }
        var validarEnsayos = rows.find(function(ensayo){
            return (ensayo['0t0'] == true || ensayo['0t1'] == true || ensayo['0t2'] == true || ensayo['0t3'] == true );
        });
        
        if(validarEnsayos == undefined){
            eventOpenNotificationRegEstCotizacion('error', 'Debe seleccionar almenos un ensayo para el registro de la cotización');
            return false;
        }
        
        var ensayos = JSON.stringify(rows);
        $('#hDataGridProductosEnsayosRegEstCotizacion').val(ensayos);
        ensayos = $('#hDataGridProductosEnsayosRegEstCotizacion').serialize();
        ajaxinsertExtCotizacion(fechaSolicitud, fechaCompromiso, tercero.value, contacto, telContacto, producto.value, tipoEstabilidad.value, tiempos.value, observaciones, observaciones2, observaciones3, aplicaIva, aplicaRetencion, ensayos);

    });
}

function eventClickButtonLimpiarRegEstCotizacion() {
    $("#buttonLimpiarRegEstCotizacion").on('click', function () {
        utilClearpage();
    });
}

function utilClearpage() {

    $('#fechaSolicitudRegEstCotizacion').jqxDateTimeInput('val', new Date());
    $('#fechaCompromisoRegEstCotizacion').jqxDateTimeInput('val', new Date());
    $('#nombreClienteRegEstCotizacion').jqxInput('val', '');
    $('#nomContactoRegEstCotizacion').jqxInput('val', '');
    $('#telContactoRegEstCotizacion').jqxInput('val', '');
    $('#inputProductoRegEstCotizacion').jqxInput('val', '');
    $('#dropDownTipoEstabilidadRegEstCotizacion').jqxDropDownList('selectIndex', 0);
    $('#dropDownTiemposRegEstCotizacion').jqxDropDownList('selectIndex', 0);
    $('#observacionesRegEstCotizacion').jqxEditor('val', '');
    $('#observaciones2RegEstCotizacion').jqxEditor('val', '');
    $('#observaciones3RegEstCotizacion').jqxEditor('val', '');
    $('#gridProductosEnsayosRegEstCotizacion').jqxGrid('clear');
    $('#CheckBoxAplicaIvaRegEstCotizacion').jqxCheckBox('val', false);
    $('#CheckBoxAplicaRetencionRegEstCotizacion').jqxCheckBox('val', false);
    $("#numCotizacionRegEstCotizacion").jqxInput('val', '');
    $("#numCotizacionRegEstCotizacion").jqxInput({disabled: false});
    $("#estadoRegEstCotizacion").jqxInput("val","");

    $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: false});
    $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
    $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: true});
    $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: true});
    $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: true});
    $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: true});
    $("#buttonImprimirEstCotizacion").jqxButton({disabled: true});
    $("#buttonRechazarEstCotizacion").jqxButton({disabled: true});
}

function utilLoadGridProductosEnsayosRegEstCotizacion(dataArray) {


    var cantidadTiempos = $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('val');
    var datafields = [];
    var columns = [];
    var nombreColumna;
    var contador = 5;
    var columngroups = [];

    datafields[0] = {name: 'idPaquete', type: 'int'};
    columns[0] = {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true, editable: false};
    datafields[1] = {name: 'nomPaquete', type: 'string'};
    columns[1] = {text: 'Paquete', datafield: 'nomPaquete', align: 'center', width: 200, hidden: false, editable: false};
    datafields[2] = {name: 'idEnsayo', type: 'int'};
    columns[2] = {text: 'idEnsayo', datafield: 'idEnsayo', width: 200, hidden: true, editable: false};
    datafields[3] = {name: 'nomEnsayo', type: 'string'};
    columns[3] = {text: 'Ensayo', datafield: 'nomEnsayo', align: 'center', width: 300, hidden: false, editable: false};
    datafields[4] = {name: 'valor', type: 'string'};
    columns[4] = {text: 'Valor', datafield: 'valor', align: 'center', width: 70, hidden: false, editable: true, columntype: 'numberinput', aggregates: ['sum', 'avg']};

    var columnasAdicionar = cantidadTiempos * 4;

    var datosTiempos = $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('getItems');
    for (var i = 0; i < cantidadTiempos; i++) {
        var nomMes = datosTiempos[i].label;
        columngroups[i] = {text: nomMes, align: 'center', name: 'cg' + i};
        for (var j = 0; j < 4; j++) {

            if (j == 0) {
                nombreColumna = '30º 65%';
            } else if (j == 1) {
                nombreColumna = '30º 75%';
            } else if (j == 2) {
                nombreColumna = '40º 75%';
            } else {
                nombreColumna = '50º 85%';
            }

            datafields[contador] = {name: i + 't' + j, type: 'bool'};
            columns[contador] = {text: nombreColumna, datafield: i + 't' + j, columngroup: 'cg' + i, cellsalign: 'center', columntype: 'checkbox', width: 50, hidden: false, editable: true};
            for (var h = 0; h < dataArray.length; h++) {
                dataArray[h][i + 't' + j] = 0;
            }
            contador++;
        }
    }

    var source =
            {
                datafields: datafields,
                datatype: "array",
                localdata: dataArray
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    var groupcolumnrenderer2 = function (text) {
        return '<div style="padding: 5px; float: left; color: Blue;">' + text + '</div>';
    }
    $("#gridProductosEnsayosRegEstCotizacion").jqxGrid(
            {
                width: '100%',
                autorowheight: true,
                source: dataAdapter,
                pageable: true,
                showgroupmenuitems: false,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                editable: true,
                altrows: true,
                columnsresize: true,
                columns: columns,
                groupable: true,
                groups: ['nomPaquete'],
                columngroups: columngroups
            });
    $('#windowLoadTiemposRegEstCotizacion').jqxWindow('close');
}

function utilLoadGridProductosEnsayosRegEstCotizacion2(dataArray) {


    var cantidadTiempos = $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('val');
    var datafields = [];
    var columns = [];
    var nombreColumna;
    var contador = 5;
    var columngroups = [];

    datafields[0] = {name: 'idPaquete', type: 'int'};
    columns[0] = {text: 'idPaquete', datafield: 'idPaquete', width: 100, hidden: true, editable: false};
    datafields[1] = {name: 'nomPaquete', type: 'string'};
    columns[1] = {text: 'Paquete', datafield: 'nomPaquete', align: 'center', width: 200, hidden: false, editable: false};
    datafields[2] = {name: 'idEnsayo', type: 'int'};
    columns[2] = {text: 'idEnsayo', datafield: 'idEnsayo', width: 200, hidden: true, editable: false};
    datafields[3] = {name: 'nomEnsayo', type: 'string'};
    columns[3] = {text: 'Ensayo', datafield: 'nomEnsayo', align: 'center', width: 300, hidden: false, editable: false};
    datafields[4] = {name: 'valor', type: 'string'};
    columns[4] = {text: 'Valor', datafield: 'valor', align: 'center', width: 70, hidden: false, editable: true, columntype: 'numberinput', aggregates: ['sum', 'avg']};

    var columnasAdicionar = cantidadTiempos * 4;

    var datosTiempos = $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('getItems');
    for (var i = 0; i < cantidadTiempos; i++) {
        var nomMes = datosTiempos[i].label;
        columngroups[i] = {text: nomMes, align: 'center', name: 'cg' + i};
        for (var j = 0; j < 4; j++) {

            if (j == 0) {
                nombreColumna = '30º 65%';
            } else if (j == 1) {
                nombreColumna = '30º 75%';
            } else if (j == 2) {
                nombreColumna = '40º 75%';
            } else {
                nombreColumna = '50º 85%';
            }

            datafields[contador] = {name: i + 't' + j, type: 'bool'};
            columns[contador] = {text: nombreColumna, datafield: i + 't' + j, columngroup: 'cg' + i, cellsalign: 'center', columntype: 'checkbox', width: 50, hidden: false, editable: true};
//                for (var h = 0; h < dataArray.length; h++) {
//                    dataArray[h][i + 't' + j] = 0;
//                }
            contador++;
        }
    }

    var source =
            {
                datafields: datafields,
                datatype: "array",
                localdata: dataArray
            };
    var dataAdapter = new $.jqx.dataAdapter(source);
    var groupcolumnrenderer2 = function (text) {
        return '<div style="padding: 5px; float: left; color: Blue;">' + text + '</div>';
    };
    $("#gridProductosEnsayosRegEstCotizacion").jqxGrid(
            {
                width: '100%',
                autorowheight: true,
                source: dataAdapter,
                pageable: true,
                showgroupmenuitems: false,
                showgroupsheader: false,
                groupsexpandedbydefault: true,
                editable: true,
                altrows: true,
                columnsresize: true,
                columns: columns,
                groupable: true,
                groups: ['nomPaquete'],
                columngroups: columngroups
            });
    $('#windowLoadTiemposRegEstCotizacion').jqxWindow('close');
}

function ajaxGetEnsayosByProductoRegEstCotizacion(idProducto) {
    //model/DB/jqw/productosPaquetesEnsayosData.php?query=ProductoPaquetesEnsayos&producto='+idProducto+'&idAreaAnalisis='+idAreaAnalisis
    var url = "model/DB/jqw/productosPaquetesEnsayosData.php";
    var data = "query=NomProductoPaquetesEnsayos";
    data = data + "&producto=" + idProducto;
    data = data + "&idAreaAnalisis=4";

    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                var data = new Array();
                for (var i = 0; i < response.length; i++) {
                    data[i] = response[i];
                    data[i].duracion = parseInt(data[i].duracion);
                    data[i].idAreaAnalisis = parseInt(data[i].idAreaAnalisis);
                    data[i].idEnsayo = parseInt(data[i].idEnsayo);
                    data[i].idPaquete = parseInt(data[i].idPaquete);
                    data[i].idProducto = String(data[i].idProducto);
                    data[i].valor = parseInt(data[i].valor);
                }
                utilLoadGridProductosEnsayosRegEstCotizacion(data);
            } else {
                $('#gridProductosEnsayosRegEstCotizacion').jqxGrid('clear');

                $('#windowLoadTiemposRegEstCotizacion').jqxWindow('close');
                eventOpenNotificationRegEstCotizacion('error', 'El producto seleccionado no posee paquetes de Estabilidad');
            }
        }
    });
}

function ajaxinsertExtCotizacion(fechaSolicitud, fechaCompromiso, tercero, contacto, telContacto, producto, tipoEstabilidad, tiempos, observaciones, observaciones2, observaciones3, aplicaIva, aplicaRetencion, ensayos) {
    var url = "index.php";
    var data = "action=insertEstCotizacion";
    data = data + "&fechaSolicitud=" + fechaSolicitud;
    data = data + "&fechaCompromiso=" + fechaCompromiso;
    data = data + "&tercero=" + tercero;
    data = data + "&contacto=" + contacto;
    data = data + "&telContacto=" + telContacto;
    data = data + "&producto=" + producto;
    data = data + "&tipoEstabilidad=" + tipoEstabilidad;
    data = data + "&tiempos=" + tiempos;
    data = data + "&observaciones=" + observaciones;
    data = data + "&observaciones2=" + observaciones2;
    data = data + "&observaciones3=" + observaciones3;
    data = data + "&aplicaIva=" + aplicaIva;
    data = data + "&aplicaRetencion=" + aplicaRetencion;
    data = data + "&" + ensayos;


    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: true,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                eventOpenNotificationRegEstCotizacion('success', response.message);
                utilClearpage();
            } else {
                eventOpenNotificationRegEstCotizacion('error', response.message);
            }
        }
    });
}

function ajaxSearchEstCotizacionById(idCotizacion) {
    var url = "model/DB/jqw/EstCotizacionData.php";
    var data = "query=getEstCotizacionById";
    data = data + "&idCotizacion=" + idCotizacion;



    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                
                
                
                switch(response[0].estado){
                    case "1":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: false});
                        break;
                    case "2":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: false});
                        break;
                    case "3":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: true});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: true});
                        break;
                    case "4":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: true});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: true});
                        break;
                      
                }

                
               
                
                
                
                $("#numCotizacionRegEstCotizacion").jqxInput({disabled: true});
                $("#estadoRegEstCotizacion").jqxInput("val",response[0].nomEstado);

                if (response[0].aplicaIva == 1) {
                    $("#CheckBoxAplicaIvaRegEstCotizacion").jqxCheckBox({checked: true});
                } else {
                    $("#CheckBoxAplicaIvaRegEstCotizacion").jqxCheckBox({checked: false});
                }
                
                if(response[0].aplicaRetencion == 1){
                    $("#CheckBoxAplicaRetencionRegEstCotizacion").jqxCheckBox({checked:true});
                } else {
                    $("#CheckBoxAplicaRetencionRegEstCotizacion").jqxCheckBox({checked:false});
                }
                
                var fechaSolicitud = response[0].fechaSolicitud.split(" ");
                fechaSolicitud = fechaSolicitud[0].split("-");
                fechaSolicitud[1] = fechaSolicitud[1]-1;
                
                 var fechaCompromiso = response[0].fechaCompromiso.split(" ");
                fechaCompromiso = fechaCompromiso[0].split("-");
                fechaCompromiso[1] = fechaCompromiso[1]-1;


                
                $('#fechaSolicitudRegEstCotizacion').jqxDateTimeInput('val', new Date(fechaSolicitud[0],fechaSolicitud[1],fechaSolicitud[2],0,0,0,0));
                $('#fechaCompromisoRegEstCotizacion').jqxDateTimeInput('val', new Date(fechaCompromiso[0],fechaCompromiso[1],fechaCompromiso[2],0,0,0,0));
                $('#nombreClienteRegEstCotizacion').jqxInput('val', {label: response[0].nomTercero, value: response[0].idTercero});
                $('#nomContactoRegEstCotizacion').jqxInput('val', response[0].contacto);
                $('#telContactoRegEstCotizacion').jqxInput('val', response[0].telContacto);
                $('#inputProductoRegEstCotizacion').jqxInput('val', {label: response[0].nomProducto, value: response[0].idProducto});
                var itemTipoEstabilidad = $("#dropDownTipoEstabilidadRegEstCotizacion").jqxDropDownList('getItemByValue', response[0].tipoEstabilidad);
                $('#dropDownTipoEstabilidadRegEstCotizacion').jqxDropDownList('selectIndex', itemTipoEstabilidad.index);
                var itemTiempos = $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('getItemByValue', response[0].tiempos);


                $('#dropDownTiemposRegEstCotizacion').jqxDropDownList('selectIndex', itemTiempos.index);
                $('#observacionesRegEstCotizacion').jqxEditor('val', response[0].observaciones);
                $('#observaciones2RegEstCotizacion').jqxEditor('val', response[0].observaciones2);
                $('#observaciones3RegEstCotizacion').jqxEditor('val', response[0].observaciones3);
                ajaxSearchEstCotizacionEnsayosByIdCotizacion(idCotizacion);
            } else {

            }
        }

    });
}

function ajaxSearchEstCotizacionById2(idCotizacion) {
    var url = "model/DB/jqw/EstCotizacionData.php";
    var data = "query=getEstCotizacionById";
    data = data + "&idCotizacion=" + idCotizacion;



    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {
                
                
                
                switch(response[0].estado){
                    case "1":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: false});
                        break;
                    case "2":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: false});
                        break;
                    case "3":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: true});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: true});
                        break;
                    case "4":
                        $("#buttonRegistrarRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonLimpiarRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonUpdateCotizacionRegCotizacion").jqxButton({disabled: true});
                        $("#buttonEnviarCotizacionRegCotizacion").jqxButton({disabled: false});
                        $("#buttonConsultaEnviosRegEstCotizacion").jqxButton({disabled: false});
                        $("#buttonGenerarMuestraRegEstCotizacion").jqxButton({disabled: true});
                        $("#buttonImprimirEstCotizacion").jqxButton({disabled: false});
                        $("#buttonRechazarEstCotizacion").jqxButton({disabled: true});
                        break;
                      
                }

                
               
                
                
                
                $("#numCotizacionRegEstCotizacion").jqxInput({disabled: true});
                $("#estadoRegEstCotizacion").jqxInput("val",response[0].nomEstado);

                if (response[0].aplicaIva == 1) {
                    $("#CheckBoxAplicaIvaRegEstCotizacion").jqxCheckBox({checked: true});
                } else {
                    $("#CheckBoxAplicaIvaRegEstCotizacion").jqxCheckBox({checked: false});
                }
                
                if(response[0].aplicaRetencion == 1){
                    $("#CheckBoxAplicaRetencionRegEstCotizacion").jqxCheckBox({checked:true});
                } else {
                    $("#CheckBoxAplicaRetencionRegEstCotizacion").jqxCheckBox({checked:false});
                }
                
                var fechaSolicitud = response[0].fechaSolicitud.split(" ");
                fechaSolicitud = fechaSolicitud[0].split("-");
                fechaSolicitud[1] = fechaSolicitud[1]-1;
                
                 var fechaCompromiso = response[0].fechaCompromiso.split(" ");
                fechaCompromiso = fechaCompromiso[0].split("-");
                fechaCompromiso[1] = fechaCompromiso[1]-1;


                
                $('#fechaSolicitudRegEstCotizacion').jqxDateTimeInput('val', new Date(fechaSolicitud[0],fechaSolicitud[1],fechaSolicitud[2],0,0,0,0));
                $('#fechaCompromisoRegEstCotizacion').jqxDateTimeInput('val', new Date(fechaCompromiso[0],fechaCompromiso[1],fechaCompromiso[2],0,0,0,0));
                $('#nombreClienteRegEstCotizacion').jqxInput('val', {label: response[0].nomTercero, value: response[0].idTercero});
                $('#nomContactoRegEstCotizacion').jqxInput('val', response[0].contacto);
                $('#telContactoRegEstCotizacion').jqxInput('val', response[0].telContacto);
                $('#inputProductoRegEstCotizacion').jqxInput('val', {label: response[0].nomProducto, value: response[0].idProducto});
                var itemTipoEstabilidad = $("#dropDownTipoEstabilidadRegEstCotizacion").jqxDropDownList('getItemByValue', response[0].tipoEstabilidad);
                $('#dropDownTipoEstabilidadRegEstCotizacion').jqxDropDownList('selectIndex', itemTipoEstabilidad.index);
                var itemTiempos = $("#dropDownTiemposRegEstCotizacion").jqxDropDownList('getItemByValue', response[0].tiempos);


                $('#dropDownTiemposRegEstCotizacion').jqxDropDownList('selectIndex', itemTiempos.index);
                $('#observacionesRegEstCotizacion').jqxEditor('val', response[0].observaciones);
                $('#observaciones2RegEstCotizacion').jqxEditor('val', response[0].observaciones2);
                $('#observaciones3RegEstCotizacion').jqxEditor('val', response[0].observaciones3);
                ajaxSearchEstCotizacionEnsayosByIdCotizacion(idCotizacion);
            } else {

            }
        }

    });
}

function ajaxSearchEstCotizacionEnsayosByIdCotizacion(idCotizacion) {
    var url = "model/DB/jqw/EstCotEnsData.php";
    var data = "query=selectEstCotizacionById";
    data = data + "&idCotizacion=" + idCotizacion;



    $.ajax({
        type: "GET",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response != null) {



                utilLoadGridProductosEnsayosRegEstCotizacion2(response);
            } else {

            }
        }

    });
}

function ajaxUpdateEstCotizacion(cotizacion) {
    var url = "index.php";
    var infoCotizacion = JSON.stringify(cotizacion);
    var data = {
        action : "updateEstCotizacion",
        cotizacion : infoCotizacion
    };
    var data = $.param(data);

    return $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false
    });
}

