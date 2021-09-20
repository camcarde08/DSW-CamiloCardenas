function initialConsultaHojaRutaMuestra(idPerfil, idUsuario, idMuestra) {

	ensayos = [];
	loadButtonGuardarDetalleResConHojaRutaMuestra();
	loadButtonActualizarDetalleResConHojaRutaMuestra();
	loadInputAnalistaResponsableDetalleResConHojaRutaMuestra();
	loadInputNumMuestraConsultaHojaDeRuta();
	loadInputClienteHojaRutaMuestraHojaDeRuta();
	loadInputDateFechaRegistroDetalleResConHojaRutaMuestra();
	loadInputEnsayoDetalleResConHojaRutaMuestra();
	loadInputNumMestraDetalleResConHojaRutaMuestra();
	loadInputProductoHojaRutaMuestraHojaDeRuta();
	loadInputTipoEstudioHojaRutaMuestraHojaDeRuta();
	loadNotificationConHojaRutaMuestra();
	loadWindowResultadosConHojaRutaMuestra();
	loadWindowDetalleResultadosDetalleResConHojaRutaMuestra();
	loadButttonConsultaAnexosConHojaRutaMuestra();
	loadWindowobservacionesReprogramarMuestra();
	loadEditorMotivoReprogramacion();
	loadButtonOKWindowObservacionesReprogramarMuestra();
	loadButtonCancelWindowObservacionesReprogramarMuestra();
	loadButtonLimpiarConHojaRutaMuestra();
	loadWindowConsultaAnexosConHojaRutaMuestra();
	loadWindowObservacionesAprobacionEnsayoMuestra();
	loadWindowRegistroConclusionMuestraConHojaRutaMuestra();
	loadWindowRegistroConclusionSubMuestraConHojaRutaMuestra();
	loadInputNumberResultadoNumericoResConHojaRutaMuestra();
	loadDropDownMediosCultivoResConHojaRutaMuestra();
	LoadDropDownCepasControlCalidadResConHojaRutaMuestra();

	//events
	eventClickSearchMuestraHojaDeRuta(idPerfil, idUsuario);
	eventClickButtonGuardarDetalleResConHojaRutaMuestra();
	eventClickButtonHojaRutaPrint1();
	eventClickButtonHojaRutaPrint2();
	eventClickButtonHojaRutaPrint3();
	eventClickButtonHojaRutaPrint4();
	eventClickButtonHojaRutaPrint5();
	eventClickButttonConsultaAnexosConHojaRutaMuestra();
	eventClosewindowobservacionesReprogramarMuestra();
	eventClickButtonOKWindowObservacionesAprobacionEnsayo();
	eventCloseWindowObservacionesAprobacionEnsayoMuestra(idPerfil, idUsuario);
	eventClickButtonLimpiarConHojaRutaMuestra();
	eventCloseWindowResultadosConHojaRutaMuestra(idPerfil, idUsuario);
	eventClickButtonOKWindowRegistroConclusionMuestraConHojaRutaMuestra();
	eventCloseWindowRegistroConclusionMuestraConHojaRutaMuestra();
	eventClickButtonActualizarDetalleResConHojaRutaMuestra();
	eventClickButtonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra();
	eventCloseWindowRegistroConclusionSubMuestraConHojaRutaMuestra();

	if (idMuestra != null) {
		$("#inputNumMuestraConHojaRutaMuestra").val(idMuestra);
		var value = $("#inputNumMuestraConHojaRutaMuestra").val();
		ajaxSearchMuestraHojaDeRuta(value, idPerfil, idUsuario);
	}
}

function LoadDropDownCepasControlCalidadResConHojaRutaMuestra(){
	var url = 'index.php?action=queryDb&query=getReactivos';
	var source = {
		datatype: "json",
		datafields: [
		{name: 'id'},
		{name: 'descripcion'}
		],
		url: url,
		async: false
	};
	var dataAdapter = new $.jqx.dataAdapter(source);
	$("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList({
		selectedIndex: 0, source: dataAdapter, displayMember: "descripcion", valueMember: "id", width: '100%', height: 40, dropDownHeight: 250, checkboxes: true
	});
}

function loadDropDownMediosCultivoResConHojaRutaMuestra(){
	var url = 'index.php?action=queryDb&query=getEstandaresMediosCultivo';
	var source = {
		datatype: "json",
		datafields: [
		{name: 'id'},
		{name: 'descripcion'}
		],
		url: url,
		async: false
	};
	var dataAdapter = new $.jqx.dataAdapter(source);
	$("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList({
		selectedIndex: 0, source: dataAdapter, displayMember: "descripcion", valueMember: "id", width: '100%', height: 40, dropDownHeight: 250, checkboxes: true
	});
}

function loadInputNumberResultadoNumericoResConHojaRutaMuestra(){
	$('#inputNumberResultadoNumericoResConHojaRutaMuestra').jqxNumberInput({ width: '250px', height: '25px', inputMode: 'simple', spinButtons: true });
}

function eventClickButtonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra() {

    $("#buttonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra").on('click', function (event) {
        var idSubMuestra = $("#hissubmuestra").val();
        var conclusion = $("#editorConclusionSubMuestraConHojaRutaMuestra").val();
        var promiseRegistrarConclusionesSubMuestra = ajaxRegistrarConclusionSubMuestra(idSubMuestra, conclusion);
        promiseRegistrarConclusionesSubMuestra.success(function (data) {
            var response = JSON.parse(data);
            if (response.result == 0) {
                openNotificationConHojaRutaMuestra('success', 'La registro la conclusion con exito');
                $("#hissubmuestra").val('');
                $("#editorConclusionSubMuestraConHojaRutaMuestra").val('LA MUESTRA ANALIZADA CUMPLE CON LAS ESPECIFICACIONES DE CONTROL DE CALIDAD MICROBIOLÓGICO.');
                $('#windowRegistroConclusionSubMuestraConHojaRutaMuestra').jqxWindow('close');
            } else {
                openNotificationConHojaRutaMuestra('error', 'Fallo el registro de la conclusion');
            }
        });

	});
}

function ajaxRegistrarConclusionSubMuestra(idSubMuestra, conclusion) {
	var url = "index.php";
	var data = "action=registrarConclusionSubmuestra";
	var data = data + "&idSubMuestra=" + idSubMuestra;
	var data = data + "&conclusion=" + conclusion;
	return $.ajax({
		type: "POST",
		url: url,
		data: data,
		async: false
	});
}

function loadDropDownListTipoRevisionEnsayoHojaRutaMuestra() {
	var source = [
	"Aprobar",
	"Rechazar"
	];

	$("#dropDownListTipoRevisionEnsayoHojaRutaMuestra").jqxDropDownList({
		source: source,
		selectedIndex: 0,
		width: '200',
		height: '25',
		dropDownHeight: 50
	});
}

function loadButtonOKWindowObservacionesAprobacionEnsayo() {
	$("#buttonOKWindowObservacionesAprobacionEnsayo").jqxButton({width: '150'});
}

function loadButtonOKWindowRegistroConclusionMuestraConHojaRutaMuestra() {
	$("#buttonOKWindowRegistroConclusionMuestraConHojaRutaMuestra").jqxButton({width: '150'});
}

function loadButtonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra() {
	$("#buttonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra").jqxButton({width: '150'});
}

function loadButtonCancelWindowObservacionesAprobacionEnsayo() {
	$("#buttonCancelWindowObservacionesAprobacionEnsayo").jqxButton({width: '150'});
}

function loadButtonCancelWindowRegistroConclusionMuestraConHojaRutaMuestra() {
	$("#buttonCancelWindowRegistroConclusionMuestraConHojaRutaMuestra").jqxButton({width: '150'});
}

function loadEditorMotivoAprovacion() {
	$('#editorMotivoAprovacion').jqxEditor({
		height: "200px",
		width: '430px',
		tools: ""
	});
	$('#editorMotivoAprovacion').jqxEditor('val', '');
}

function loadEditorConclusionMuestraConHojaRutaMuestra() {
    $('#editorConclusionMuestraConHojaRutaMuestra').jqxEditor({
        height: "200px",
        width: '430px',
        tools: ""
    });
    $('#editorConclusionMuestraConHojaRutaMuestra').jqxEditor('val', 'LA MUESTRA ANALIZADA CUMPLE CON LAS ESPECIFICACIONES DE CONTROL DE CALIDAD MICROBIOLÓGICO.');
}

function loadEditorConclusionSubMuestraConHojaRutaMuestra() {
    $('#editorConclusionSubMuestraConHojaRutaMuestra').jqxEditor({
        height: "200px",
        width: '430px',
        tools: ""
    });
    $('#editorConclusionSubMuestraConHojaRutaMuestra').jqxEditor('val', 'LA MUESTRA ANALIZADA CUMPLE CON LAS ESPECIFICACIONES DE CONTROL DE CALIDAD MICROBIOLÓGICO.');
}

function loadWindowConsultaAnexosConHojaRutaMuestra() {
	$('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow({
		position: {x: 400, y: 250},
		showCollapseButton: true,
		autoOpen: false,
		isModal: false,
		height: 400,
		width: 500,
		title: 'Anexos de analisis'
	});
}

function loadWindowObservacionesAprobacionEnsayoMuestra() {
	$('#windowObservacionesAprobacionEnsayoMuestra').jqxWindow({
		//var jqxWidget = $('#windowobservacionesReprogramarMuestra');
		//var offset = jqxWidget.offset();
		position: {x: 400, y: 250},
		title: 'Observaciones revisión ensayo',
		showCollapseButton: false,
		autoOpen: false,
		isModal: true,
		height: 350,
		width: 500,
		cancelButton: $("#buttonCancelWindowObservacionesAprobacionEnsayo"),
		initContent: function () {
			loadEditorMotivoAprovacion();
			loadButtonCancelWindowObservacionesAprobacionEnsayo();
			loadButtonOKWindowObservacionesAprobacionEnsayo();
			loadDropDownListTipoRevisionEnsayoHojaRutaMuestra();
		}

	});
}

function loadWindowRegistroConclusionMuestraConHojaRutaMuestra() {
	$('#windowRegistroConclusionMuestraConHojaRutaMuestra').jqxWindow({
		position: {x: 400, y: 250},
		title: 'Clonclusión de la Muestra',
		showCollapseButton: false,
		autoOpen: false,
		isModal: true,
		height: 350,
		width: 500,
		cancelButton: $("#buttonCancelWindowRegistroConclusionMuestraConHojaRutaMuestra"),
		initContent: function () {
			loadEditorConclusionMuestraConHojaRutaMuestra();

			loadButtonOKWindowRegistroConclusionMuestraConHojaRutaMuestra();
		}

	});
}

function loadWindowRegistroConclusionSubMuestraConHojaRutaMuestra() {
	$('#windowRegistroConclusionSubMuestraConHojaRutaMuestra').jqxWindow({
		position: {x: 400, y: 250},
		title: 'Clonclusión de la SubMuestra',
		showCollapseButton: false,
		autoOpen: false,
		isModal: true,
		height: 350,
		width: 500,
		initContent: function () {
			loadEditorConclusionSubMuestraConHojaRutaMuestra();

			loadButtonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra();
		}

	});
}

function loadButtonLimpiarConHojaRutaMuestra() {
	$("#buttonLimpiarConHojaRutaMuestra").jqxButton({width: '100'});
}

function eventClickButtonLimpiarConHojaRutaMuestra() {
	$("#buttonLimpiarConHojaRutaMuestra").click(function () {

		$("#inputNumMuestraConHojaRutaMuestra").jqxInput('val', '');
		$("#inputNumMuestraConHojaRutaMuestra").jqxInput({disabled: false});
		$("#inputProductoConHojaRutaMuestra").jqxInput('val', '');
		$("#inputTipoEstudioConHojaRutaMuestra").jqxInput('val', '');
		$("#inputClienteConHojaRutaMuestra").jqxInput('val', '');
		$("#butttonConsultaAnexosConHojaRutaMuestra").jqxButton({disabled: true});
		$("#gridEnsayosConHojaRutaMuestra").jqxGrid('clear');
		$("#treeAnexosConHojaRutaMuestra").jqxTree('clear');
		$("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow('close');




	});
}

function loadButtonCancelWindowObservacionesReprogramarMuestra() {
	$("#buttonCancelWindowObservacionesReprogramarMuestra").jqxButton({width: '150'});
}

function loadButtonOKWindowObservacionesReprogramarMuestra() {
	$("#buttonOKWindowObservacionesReprogramarMuestra").jqxButton({width: '150'});
}

function loadEditorMotivoReprogramacion() {
	$('#editorMotivoReprogramacion').jqxEditor({
		height: "200px",
		width: '430px',
		tools: ""
	});
}

function loadWindowobservacionesReprogramarMuestra() {
	$('#windowobservacionesReprogramarMuestra').jqxWindow({
		//var jqxWidget = $('#windowobservacionesReprogramarMuestra');
		//var offset = jqxWidget.offset();
		position: {x: 400, y: 250},
		showCollapseButton: false,
		autoOpen: false,
		isModal: true,
		height: 350,
		width: 500,
		cancelButton: $("#buttonCancelWindowObservacionesReprogramarMuestra")

	});
}

function loadButttonConsultaAnexosConHojaRutaMuestra() {
	$("#butttonConsultaAnexosConHojaRutaMuestra").jqxButton({width: '150', disabled: true});
}

function loadButtonLimpiarDetalleResConHojaRutaMuestra() {
	$("#buttonLimpiarDetalleResConHojaRutaMuestra").jqxButton({width: '150'});
}

function loadButtonGuardarDetalleResConHojaRutaMuestra() {
	$("#buttonGuardarDetalleResConHojaRutaMuestra").jqxButton({width: '150'});
}

function loadButtonActualizarDetalleResConHojaRutaMuestra() {
	$("#buttonActualizarDetalleResConHojaRutaMuestra").jqxButton({width: '150'});
}

function loadDropDownListLoteDetalleResConHojaRutaMuestra(idMuestra) {
	var url = 'model/DB/jqw/LoteData.php?query=getLotesByIdMuestra&idMuestra=' + idMuestra;
	var source = {
		datatype: "json",
		datafields: [
		{name: 'id'},
		{name: 'numLote'}
		],
		url: url,
		async: false
	};
	var dataAdapter = new $.jqx.dataAdapter(source);
	$("#dropDownListLoteDetalleResConHojaRutaMuestra").jqxDropDownList({
		selectedIndex: 0, source: dataAdapter, displayMember: "numLote", valueMember: "id", width: 200, height: 20, dropDownHeight: 100
	});
}

function loadInputAnalistaResponsableDetalleResConHojaRutaMuestra() {
	$("#inputAnalistaResponsableDetalleResConHojaRutaMuestra").jqxInput({height: 20, width: 200, minLength: 1, disabled: true});
}

function loadInputNumMuestraConsultaHojaDeRuta() {
	$("#inputNumMuestraConHojaRutaMuestra").jqxInput({placeHolder: "Número de Análisis", height: 20, width: 200, minLength: 1});
}

function loadInputClienteHojaRutaMuestraHojaDeRuta() {
	$("#inputClienteConHojaRutaMuestra").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadInputDateFechaRegistroDetalleResConHojaRutaMuestra() {
	$("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput({width: '200px', height: '20px'});
}

function loadInputEnsayoDetalleResConHojaRutaMuestra() {
	$("#inputEnsayoDetalleResConHojaRutaMuestra").jqxInput({height: 20, width: 200, minLength: 1, disabled: true});
}

function loadInputNumMestraDetalleResConHojaRutaMuestra() {
	$("#inputNumMestraDetalleResConHojaRutaMuestra").jqxInput({height: 20, width: 200, minLength: 1, disabled: true});
}

function loadInputProductoHojaRutaMuestraHojaDeRuta() {
	$("#inputProductoConHojaRutaMuestra").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadInputTipoEstudioHojaRutaMuestraHojaDeRuta() {
	$("#inputTipoEstudioConHojaRutaMuestra").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadNotificationConHojaRutaMuestra() {
	$("#notificationConHojaRutaMuestra").jqxNotification({
		width: 250, position: "top-right", opacity: 0.9,
		autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
	});
}

function loadWindowResultadosConHojaRutaMuestra() {
	$("#windowResultadosConHojaRutaMuestra").jqxWindow({
		height: 200, width: 1000,
		autoOpen: false,
		isModal: true,
		resizable: false,
		title: "Resultados",
		position: {x: 300, y: 150}


	});
}

function eventCloseWindowResultadosConHojaRutaMuestra(idPerfil, idUsuario) {
	$("#windowResultadosConHojaRutaMuestra").on('close', function (event) {
		var idMuestra = $('#realIdMuestraConHojaRutaMuestra').val();
		var areaAnalisis = $("#inputTipoEstudioConHojaRutaMuestra").jqxInput('val');
		if (areaAnalisis === "Estabilidad") {
			chargeGridEnsayosHojaDeRuta(idMuestra, idPerfil, idUsuario, 4);
		} else {
			chargeGridEnsayosHojaDeRuta(idMuestra, idPerfil, idUsuario, 0);
		}

	});
}

function loadWindowDetalleResultadosDetalleResConHojaRutaMuestra() {
	$("#windowDetalleResultadosDetalleResConHojaRutaMuestra").jqxWindow({
		height: 530, width: 1000,
                
		autoOpen: false,
		isModal: true,
                title: 'Registro de Resultados',
		resizable: false,
		position: {x: 300, y: 10},
		maxHeight:2000,
		initContent: function () {
			$("#editorResultado1ResConHojaRutaMuestra").jqxEditor({
				height: "100px",
				width: '100%',
				tools: 'bold italic underline',
				pasteMode: 'text'
			});
			$("#editorResultado2ResConHojaRutaMuestra").jqxEditor({
				height: "100px",
				width: '100%',
				tools: 'bold italic underline'
			});
			$("#editorResultadoDetalleResConHojaRutaMuestra").jqxEditor({
				height: "100px",
				width: '100%',
				tools: 'bold italic underline'
			});
			$("#editorObservacionesDetalleResConHojaRutaMuestra").jqxEditor({
				height: "100px",
				width: '100%',
				tools: 'bold italic underline'
			});
		}

	});
}

function getCepasResultado(){
	var cepas = [];
	$("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList('getCheckedItems').forEach(function(item,index,array){
		cepas.push(item.originalItem);
	});
	return cepas;
}

function getMediosCultivoResultado(){
	var medios = [];
	$("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList('getCheckedItems').forEach(function(item,index,array){
		medios.push(item.originalItem);
	});
	return medios;
}

function eventClickButtonActualizarDetalleResConHojaRutaMuestra() {
	$('#buttonActualizarDetalleResConHojaRutaMuestra').on('click', function (event) {

		var idResultado = $('#hiddenIdResultadoConHojaRutaMuestra').val();
		var idLote = $("#dropDownListLoteDetalleResConHojaRutaMuestra").jqxDropDownList('getSelectedItem');
		if (idLote == null) {
			idLote = 0;
		} else {
			idLote = idLote.value;
		}
		var resultado = $("#editorResultadoDetalleResConHojaRutaMuestra").jqxEditor('val');
		var observaciones = $("#editorObservacionesDetalleResConHojaRutaMuestra").jqxEditor('val');
		var fechaRegistro = $("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput("val");
		fechaRegistro = fechaRegistro.split('/');
		fechaRegistro = fechaRegistro[2] + '-' + fechaRegistro[1] + '-' + fechaRegistro[0];

		var resultado1 = $("#editorResultado1ResConHojaRutaMuestra").jqxEditor('val');
		var resultado2 = $("#editorResultado2ResConHojaRutaMuestra").jqxEditor('val');

		var medios = getMediosCultivoResultado();

		var cepas = getCepasResultado();

		var resultadoNumerico = $('#inputNumberResultadoNumericoResConHojaRutaMuestra').jqxNumberInput('val');



		var promiseUpdateResultado = ajaxUpdateResultado(idResultado, idLote, resultado, observaciones, fechaRegistro,  resultado1, resultado2, medios,cepas,resultadoNumerico);
		promiseUpdateResultado.success(function (data) {
			var response = JSON.parse(data);
			if (response.result === 0) {
				openNotificationConHojaRutaMuestra('success', response.message);
			} else {
				openNotificationConHojaRutaMuestra('error', response.message);
			}
		});
	});
}

function ajaxUpdateResultado(idResultado, idLote, resultado, observaciones, fechaRegistro, resultado1, resultado2, medios,cepas,resultadoNumerico) {
	medios = JSON.stringify(medios);
	cepas = JSON.stringify(cepas);
	var url = "index.php";
	var data = {
		action: 'updateResultado',
		idResultado: idResultado,
		idLote: idLote,
		resultado: resultado,
		observaciones: observaciones,
		fechaRegistro: fechaRegistro,
		resultado1: resultado1,
		resultado2: resultado2,
		medios: medios,
		cepas: cepas,
		resultadoNumerico: resultadoNumerico
	};
	return $.ajax({
		type: "POST",
		url: url,
		data: $.param(data, true),
		async: false
	});
}

function eventClickButtonGuardarDetalleResConHojaRutaMuestra() {
	$("#buttonGuardarDetalleResConHojaRutaMuestra").on('click', function () {
		$("#windowDetalleResultadosDetalleResConHojaRutaMuestra").jqxWindow("close");


		var idEnsayoMuestra = $("#hiddenIdEnsayoMuestraDetalleResConHojaRutaMuestra").val();

		var idLote = $("#dropDownListLoteDetalleResConHojaRutaMuestra").val();
		var resultado = $("#editorResultadoDetalleResConHojaRutaMuestra").val();
		if(resultado == undefined || resultado == ''){
			openNotificationConHojaRutaMuestra('error', 'No es posible registrar un resultado sin  detalle');
			return false;
		}
		var observaciones = $("#editorObservacionesDetalleResConHojaRutaMuestra").val();
		// if(observaciones == undefined || observaciones == ''){
		//     openNotificationConHojaRutaMuestra('error', 'No es posible registrar un resultado sin  observaciones');
		//     return false;
		// }
		//var fecha2 = new Date();
		var fecha = $("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput("val", "date");
		var year = fecha.getFullYear();
		var month = fecha.getMonth() + 1;
		var day = fecha.getDate();
		var hour = fecha.getHours();
		var min = fecha.getMinutes();
		var fechaRegistro = year + "-" + month + "-" + day;
		var resultadoNumerico = $('#inputNumberResultadoNumericoResConHojaRutaMuestra').jqxNumberInput('val');
		var resultado1 = $('#editorResultado1ResConHojaRutaMuestra').val();
		var resultado2 = $('#editorResultado2ResConHojaRutaMuestra').val();
		var mediosCultivo = [];
		$("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList('getCheckedItems').forEach(function(item,index){
			mediosCultivo.push(item.value);
		});
		var cepas = [];
		$("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList('getCheckedItems').forEach(function(item,index){
			cepas.push(item.value);
		});

		ajaxSaveResultadoConHojaRutamuestra(idEnsayoMuestra, idLote, resultado, observaciones, fechaRegistro, resultadoNumerico, resultado1, resultado2,mediosCultivo,cepas);

	});
}

function eventClickButttonConsultaAnexosConHojaRutaMuestra() {
	$("#butttonConsultaAnexosConHojaRutaMuestra").click(function () {

		var idMuestra = $("#inputNumMuestraConHojaRutaMuestra").jqxInput('val');
	   //alert(idMuestra);
	   var promise = ajaxScanDirByIdMuestraConHojaRutaMuestra(idMuestra);
	   promise.success(function (data) {

	   	loadTreeAnexosConHojaRutaMuestra(data);
	   	$("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("move", $(window).width() / 2 - $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("width") / 2, $(window).height() / 2 - $("#windowConsultaAnexosConHojaRutaMuestra").jqxWindow("height") / 2);
	   	$('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow('expand');
	   	$('#windowConsultaAnexosConHojaRutaMuestra').jqxWindow('open');

	   });





	});

}

function loadTreeAnexosConHojaRutaMuestra(data) {

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
	$('#treeAnexosConHojaRutaMuestra').jqxTree({source: records, width: '100%', height: '99%'});
	$('#treeAnexosConHojaRutaMuestra').jqxTree("expandAll");
	$("#treeAnexosConHojaRutaMuestra li").on('dblclick', function (event) {
		var target = $(event.target).parents('li:first')[0];
		if (target != null) {
			$("#treeAnexosConHojaRutaMuestra").jqxTree('selectItem', target);
			var selectedItemA = $('#treeAnexosConHojaRutaMuestra').jqxTree('selectedItem');
			if (selectedItemA.icon == "views/images/file_icon.png") {
				var scrollTop = $(window).scrollTop();
				var scrollLeft = $(window).scrollLeft();
				window.open(selectedItemA.id, '_blank');
			}
			return false;
		}
	});
}

function limpiar() {
	$("#inputNumMuestraConHojaRutaMuestra").jqxInput('val', '');
	$("#inputProductoConHojaRutaMuestra").jqxInput('val', '');
	$("#inputTipoEstudioConHojaRutaMuestra").jqxInput('val', '');
	$("#inputClienteConHojaRutaMuestra").jqxInput('val', '');
	$("#butttonConsultaAnexosConHojaRutaMuestra").jqxButton({disabled: true});
	$('#gridEnsayosConHojaRutaMuestra').jqxGrid('clear');
}

function eventClickButtonHojaRutaPrint1() {
	$("#ButtonHojaRutaPrint1").click(function () {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var idMuestraPref = $("#inputNumMuestraConHojaRutaMuestra").val();
		window.open("pdf/informes/hojaRutaRecuento.php?idMuestra=" + idMuestra);
	});
}
function eventClickButtonHojaRutaPrint2() {
	$("#ButtonHojaRutaPrint2").click(function () {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var idMuestraPref = $("#inputNumMuestraConHojaRutaMuestra").val();
		window.open("pdf/informes/hojaRutaEndotoxinas.php?idMuestra=" + idMuestra);
	});
}
function eventClickButtonHojaRutaPrint3() {
	$("#ButtonHojaRutaPrint3").click(function () {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var idMuestraPref = $("#inputNumMuestraConHojaRutaMuestra").val();
		window.open("pdf/informes/hojaRutaEsteriles.php?idMuestra=" + idMuestra);
	});
}
function eventClickButtonHojaRutaPrint4() {
	$("#ButtonHojaRutaPrint4").click(function () {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var idMuestraPref = $("#inputNumMuestraConHojaRutaMuestra").val();
		window.open("pdf/informes/hojaRutaPotencia.php?idMuestra=" + idMuestra);
	});
}
function eventClickButtonHojaRutaPrint5() {
	$("#ButtonHojaRutaPrint5").click(function () {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var idMuestraPref = $("#inputNumMuestraConHojaRutaMuestra").val();
		window.open("pdf/informes/hojaRutaNoEsteriles.php?idMuestra=" + idMuestra);
	});
}







function eventClickSearchMuestraHojaDeRuta(idPerfil, idUsuario) {

	$("#searchNumMuestraConHojaRutaMuestra").click(function () {
		var value = $("#inputNumMuestraConHojaRutaMuestra").val();
		ajaxSearchMuestraHojaDeRuta(value, idPerfil, idUsuario);
	});
}
//click imagen resultado grilla principal
function eventClickImageResultado(row, esCordinador) {
	var data = $('#gridEnsayosConHojaRutaMuestra').jqxGrid('getrowdata', row);
	$('#windowResultadosConHojaRutaMuestra').on('open', function (event) {
		$("#hiddenIdEnsayoMuestraDetalleResConHojaRutaMuestra").val(data.uid);
		$('#inputNumMestraDetalleResConHojaRutaMuestra').val($('#inputNumMuestraConHojaRutaMuestra').jqxInput('val'));
		$("#inputEnsayoDetalleResConHojaRutaMuestra").val(data.desEspecifica);
		$("#inputAnalistaResponsableDetalleResConHojaRutaMuestra").val(data.nombreAnalistaAsignado);
		$("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput({disabled: true});
		$("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput("val", new Date());
		loadDropDownListLoteDetalleResConHojaRutaMuestra(data.idMuestra);
		$("#AeditorDescripcionDetalleResConHojaRutaMuestra").html(data.especificacion_ensayo_muestra);
		$("#editorResultadoDetalleResConHojaRutaMuestra").val("");
		$("#editorObservacionesDetalleResConHojaRutaMuestra").val("");

	});

	$('#windowResultadosConHojaRutaMuestra').jqxWindow('open');
	if (data.idEstadoEnsayoMuestra == 2 || data.idEstadoEnsayoMuestra == 3) {
		chargeGridDetalleResConHojaRutaMuestra(data.uid, false);
	} else {
		chargeGridDetalleResConHojaRutaMuestra(data.uid, esCordinador);
	}



}

function chargeMuestraDataHojaDeRuta(data) {
	$("#inputProductoConHojaRutaMuestra").jqxInput("val", data[0].muestra.nombre_producto);
	$("#inputTipoEstudioConHojaRutaMuestra").jqxInput("val", data[0].muestra.des_area_analisis);
	$("#inputClienteConHojaRutaMuestra").jqxInput("val", data[0].muestra.nombre_tercero);
}

function    chargeGridEnsayosHojaDeRuta(idMuestra, idPerfil, idUsuario, idAreaAnalisis) {

	var promiseGetPermisos = ajaxGetPermisos();

	promiseGetPermisos.success(function (data) {
		if (idPerfil == 6 || idPerfil == 7) {
			var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getEnsayoMuestraByIdMuestraIdAnalista&idMuestra=' + idMuestra + '&idAnalista=' + idUsuario;
			//var esCordinador = false;
		} else {
			var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getEnsayoMuestraByIdMuestra&idMuestra=' + idMuestra;
			//var esCordinador = true;
		}

		var source = {
			datatype: "json",
			datafields: [
			{name: 'descripcionEnsayo'},
			{name: 'desEspecifica'},
			{name: 'descripcionPaquete'},
			{name: 'desMetodo'},
			{name: 'especificacion'},
			{name: 'aprobado'},
			{name: 'idMuestra'},
			{name: 'nombreAnalistaAsignado'},
			{name: 'nomEstadoEnsayoMuestra'},
			{name: 'cantidadResultados', type: 'int'},
			{name: 'idEstadoEnsayoMuestra', type: 'int'},
			{name: 'mes', type: 'int'},
			{name: 'idEstadoEnsayoMuestra', type: 'int'},
			{name: 'idSubMuestra', type: 'int'},
			{name: 'duracionEstabilidad', type: 'string'},
			{name: 'temperaturaEstabilidad', type: 'string'},
			{name: 'especificacion_ensayo_muestra', type: 'string'},
			
			],
			id: 'idEnsayoMuestra',
			url: url,
			async: false
		};
		var showfilterrow = false;
		var filterable = false;
		var columnDuracionEst = null;
		var columnTemperaturaEst = null;
		if (idAreaAnalisis == '4') {
			showfilterrow = true;
			filterable = true;
			columnDuracionEst = {
				text: 'Dur. Est.',
				dataField: 'duracionEstabilidad',
				hidden: false,
				editable: false,
				filtertype: 'checkedlist'
			};
			columnTemperaturaEst = {
				text: 'Temperatura',
				dataField: 'temperaturaEstabilidad',
				hidden: false,
				editable: false,
				filtertype: 'checkedlist'
			};
		}


		var permisos = JSON.parse(data);

		var permisoRevision = permisos.revisionEnsayoHojaTrabajo;
		var permisoConsultaResultado = permisos.consultaResultadoHojaTrabajo;
		var permisoRegistroResultados = permisos.registroResultadoHojaTrabajo;
		var permisoReprogramacion = permisos.reprogramacionEnsayoHojaTrabajo;



		var columnResutados = null;
		if (permisoConsultaResultado) {
			columnResutados = {
				text: 'Resultados',
				cellsrenderer: function (row) {
					return '<img style="position: absolute; top: 20%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageResultado(' + row + ',' + permisoRegistroResultados + ')"/>';
				},
				width: '7%',
				editable: false
			};
		}

		var columnRevision = null;
		if (permisoRevision) {

			columnRevision = {
				text: 'Revisado',
				dataField: 'aprobado',
				columntype: 'checkbox',
				width: '8%',
				editable: true,
				cellbeginedit: function (row, datafield, columntype) {
					var rowData = $('#gridEnsayosConHojaRutaMuestra').jqxGrid('getrowdata', row);
					if (rowData.aprobado == false) {
						if (rowData.cantidadResultados == 0) {
							openNotificationConHojaRutaMuestra('error', 'No es posible revisar un ensayo sin resultados.');
							return false
						} else {
							var infoEnsayo = 'Paquete: ' + rowData.descripcionPaquete + ' Ensayo: ' + rowData.desEspecifica;
							revisarEnsayo(rowData.uid, infoEnsayo);
						}
					} else {
						openNotificationConHojaRutaMuestra('error', 'No es posible eliminar la revisión de un ensayo.');
						return false
					}

				}
			};
		}

		var columnReprogramacion = null;
		if (permisoReprogramacion) {
			columnReprogramacion = {
				text: 'Reprogramar',
				cellsrenderer: function (row) {
					return '<img style="position: absolute; top: 20%; left: 50%;" src="views/jqwidgets/jqwidgets/styles/images/icon-calendar.png" onClick="eventClickImageReprogramar(' + row + ')"/>';
				},
				width: '7%',
				editable: false
			};
		}

		var dataAdapter = new $.jqx.dataAdapter(source);
		$("#gridEnsayosConHojaRutaMuestra").jqxGrid(
		{
			width: '99.8%',
			source: dataAdapter,
			autoheight: true,
			autorowheight: true,
			groupable: true,
			showgroupsheader: false,
			groupsexpandedbydefault: true,
			showgroupmenuitems: false,
			editable: true,
			editmode: 'dblclick',
			showfilterrow: showfilterrow,
			filterable: filterable,
			columns: [
			{
				text: 'Nombre',
				dataField: 'desEspecifica',
				width: '25%',
				editable: false
			},
			{
				text: 'Paquete',
				dataField: 'descripcionPaquete',
				hidden: true,
				editable: false

			},
			{
				text: 'Método',
				dataField: 'desMetodo',
				columntype: 'dropdownlist',
				width: '10%',
				editable: false
			},
			{
				text: 'Especificación',
				dataField: 'especificacion_ensayo_muestra',
				width: '18%',
				editable: false
			},
			columnDuracionEst,
			columnTemperaturaEst,
			columnRevision,
			columnResutados,
			columnReprogramacion,
			{
				text: 'Resultados',
				dataField: 'cantidadResultados',
				cellsalign: 'center',
				hidden: true,
				editable: false
			}, {
				text: 'Número',
				dataField: 'idMuestra',
				hidden: true,
				editable: false
			},
			{
				text: 'Nombre de Analista',
				dataField: 'nombreAnalistaAsignado',
				hidden: true,
				editable: false
			},
			{
				text: 'idEstado',
				dataField: 'idEstadoEnsayoMuestra',
				width: '10%',
				hidden: true,
				editable: false

			},
			{
				text: 'Estado',
				dataField: 'nomEstadoEnsayoMuestra',
				width: '10%',
				hidden: false,
				editable: false
			}
			],
			groups: ['descripcionPaquete']
		});
	});

}


function revisarEnsayo(idEnsayoMuestra, infoEnsayo) {
	$('#hIdEnsayoMuestraConHojaRutaMuestra').val(idEnsayoMuestra);
	$('#hInfoEnsayoConHojaRutaMuestra').val(infoEnsayo);
	$('#windowObservacionesAprobacionEnsayoMuestra').jqxWindow('open');
}



function eventClickButtonOKWindowObservacionesAprobacionEnsayo() {
	$('#buttonOKWindowObservacionesAprobacionEnsayo').on('click', function () {

		var tipoRevision = $("#dropDownListTipoRevisionEnsayoHojaRutaMuestra").jqxDropDownList('val');
		var idEnsayoMuestra = $('#hIdEnsayoMuestraConHojaRutaMuestra').val();
		var infoEnsayo = $('#hInfoEnsayoConHojaRutaMuestra').val(infoEnsayo);
		var observaciones = $("#editorMotivoAprovacion").jqxEditor('val');
		var observaciones2 = observaciones;

		if (tipoRevision == 'Aprobar') {
			var promiseRevisarEnsayo = ajaxUpdateEnsayoCoHojaRutamuestra(idEnsayoMuestra, true, tipoRevision, observaciones2);

			promiseRevisarEnsayo.success(function (data) {
				var response = JSON.parse(data);
				if (response.result === 0) {
					openNotificationConHojaRutaMuestra('success', response.message);
				} else {
					openNotificationConHojaRutaMuestra('error', response.message);
				}
				$('#windowObservacionesAprobacionEnsayoMuestra').jqxWindow('close');
			});
		} else {
			if (observaciones != '<div></div>' && observaciones != '<br>' && observaciones != '') {
				var promiseRevisarEnsayo = ajaxUpdateEnsayoCoHojaRutamuestra(idEnsayoMuestra, true, tipoRevision, observaciones2);

				promiseRevisarEnsayo.success(function (data) {
					var response = JSON.parse(data);
					if (response.result === 0) {
						openNotificationConHojaRutaMuestra('success', response.message);
					} else {
						openNotificationConHojaRutaMuestra('error', response.message);
					}
					$('#windowObservacionesAprobacionEnsayoMuestra').jqxWindow('close');
				});
			} else {
				openNotificationConHojaRutaMuestra('error', 'no es posible registrar un rechazo sin observaciones');
			}
		}


	});
}

function eventClickButtonOKWindowRegistroConclusionMuestraConHojaRutaMuestra() {
	$('#buttonOKWindowRegistroConclusionMuestraConHojaRutaMuestra').on('click', function () {
		$('#windowRegistroConclusionMuestraConHojaRutaMuestra').jqxWindow('close');
	});
}

function eventCloseWindowRegistroConclusionMuestraConHojaRutaMuestra() {
    $('#windowRegistroConclusionMuestraConHojaRutaMuestra').on('close', function (event) {
        var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
        var conclusion = $('#editorConclusionMuestraConHojaRutaMuestra').val();
        var promiseRegistroConclusion = ajaxRegistrarCon(idMuestra, conclusion);
        $('#editorConclusionMuestraConHojaRutaMuestra').jqxEditor('val', 'LA MUESTRA ANALIZADA CUMPLE CON LAS ESPECIFICACIONES DE CONTROL DE CALIDAD MICROBIOLÓGICO.')
        promiseRegistroConclusion.success(function (data) {
            var response = JSON.parse(data);
            if (response.result === 0) {
                //chargeGridDetalleResConHojaRutaMuestra(idEnsayoMuestra, false);
                openNotificationConHojaRutaMuestra('success', response.message);
            } else {
                openNotificationConHojaRutaMuestra('error', response.message);
            }
        });
    });
	$('#windowRegistroConclusionMuestraConHojaRutaMuestra').on('close', function (event) {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var conclusion = $('#editorConclusionMuestraConHojaRutaMuestra').val();
		var promiseRegistroConclusion = ajaxRegistrarCon(idMuestra, conclusion);
		$('#editorConclusionMuestraConHojaRutaMuestra').jqxEditor('val', 'La muestra CUMPLE con las especificaciones del cliente.')
		promiseRegistroConclusion.success(function (data) {
			var response = JSON.parse(data);
			if (response.result === 0) {
				//chargeGridDetalleResConHojaRutaMuestra(idEnsayoMuestra, false);
				openNotificationConHojaRutaMuestra('success', response.message);
			} else {
				openNotificationConHojaRutaMuestra('error', response.message);
			}
		});
	});
}

function ajaxRegistrarCon(idMuestra, conclusion) {
	var url = "index.php?action=registrarConclusion";
	var data = "idMuestra=" + idMuestra;
	var data = data + "&conclusion=" + conclusion;
	return $.ajax({
		type: "POST",
		url: url,
		data: data,
		async: true
	});
}

function ajaxGetResultadoByIdEnsayoMuestra(idEnsayoMuestra){
	return $.ajax({
		type: 'GET',
		url: 'model/DB/jqw/ResultadoData.php',
		data: {
			query: 'getResultadoByIdEnsayoMuestra',
			idEnsayoMuestra: idEnsayoMuestra
		},
		async: true
	});
}

function chargeGridDetalleResConHojaRutaMuestra(idEnsayoMuestra, esCoordinador) {

	var resultadosPromise = ajaxGetResultadoByIdEnsayoMuestra(idEnsayoMuestra);
	resultadosPromise.then(function(data){
		resultados = JSON.parse(data);
		source.localdata = resultados;
		$("#gridDetalleResConHojaRutaMuestra").jqxGrid('updatebounddata');

	});
	
	
	//var url = "model/DB/jqw/ResultadoData.php?query=getResultadoByIdEnsayoMuestra&idEnsayoMuestra=" + idEnsayoMuestra;

	var source = {
		datatype: "array",
		datafields: [
		{name: 'id'},
		{name: 'idEnsayoMuestra'},
		{name: 'idLote'},
		{name: 'resultado'},
		{name: 'observaciones'},
		{name: 'idUsuarioRegistro'},
		{name: 'fechaRegistro'},
		{name: 'nombreAnalistaAsignado'},
		{name: 'numeroLote'},
		{name: 'resultadoNumerico', type: 'number'},
		{name: 'resultado1'},
		{name: 'resultado2'}
		],
		id: 'id',
		localdata: ensayos
	};
	var dataAdapter = new $.jqx.dataAdapter(source);
	$("#gridDetalleResConHojaRutaMuestra").jqxGrid(
	{
		width: '99.8%',
		source: dataAdapter,
		height: '100px',
		showstatusbar: esCoordinador,
		renderstatusbar: function (statusbar) {
					// appends buttons to the status bar.
					if (esCoordinador) {
						var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
						var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='views/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
						container.append(addButton);
						statusbar.append(container);
						addButton.jqxButton({width: 60, height: 20});
						addButton.click(function (event) {
							$("#buttonActualizarDetalleResConHojaRutaMuestra").hide();
							$("#buttonGuardarDetalleResConHojaRutaMuestra").show();
							$('#windowDetalleResultadosDetalleResConHojaRutaMuestra').on('open', function (event) {
								$('#realIdMuestraConHojaRutaMuestra2').val($('#realIdMuestraConHojaRutaMuestra').val());
								$("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput("val", new Date());
								$("#dropDownListLoteDetalleResConHojaRutaMuestra").jqxDropDownList('selectIndex', 0);
								$("#editorResultadoDetalleResConHojaRutaMuestra").val("");
								$("#editorObservacionesDetalleResConHojaRutaMuestra").val("");
								$("#inputNumberResultadoNumericoResConHojaRutaMuestra").val(0);
								$("#editorResultado1ResConHojaRutaMuestra").val("");
								$("#editorResultado2ResConHojaRutaMuestra").val("");
								$("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList('uncheckAll'); 
								$("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList('uncheckAll'); 
							});
							$("#windowDetalleResultadosDetalleResConHojaRutaMuestra").jqxWindow('open');
							$('#windowDetalleResultadosDetalleResConHojaRutaMuestra').on('open', function (event) {});
						});
					}

				},
				columns: [
				{
					text: 'idResultado',
					dataField: 'id',
					width: '35%',
					hidden: true
				},
				{
					text: 'Fecha de Registro',
					dataField: 'fechaRegistro',
					width: '30%'
				},
				{
					text: 'Número Lote',
					dataField: 'numeroLote',
					width: '20%'
				},
				{
					text: 'Analista Asignado',
					dataField: 'nombreAnalistaAsignado',
					width: '35%'
				},
				{
					text: 'Detalle',
					cellsrenderer: function (row) {
						return '<img style="position: absolute; top: 10%; left: 50%;" src="views/images/detalle.png" onClick="eventClickDetalleResultado(' + row + ')"/>';
					},
					width: '15%',
					editable: false
				},
				{
					text: 'Número',
					dataField: 'idEnsayoMuestra',
					width: '35%',
					hidden: true
				},
				{
					text: 'Lote',
					dataField: 'idLote',
					width: '35%',
					hidden: true
				},
				{
					text: 'Resultado',
					dataField: 'resultado',
					width: '35%',
					hidden: true
				},
				{
					text: 'Observaciones',
					dataField: 'observaciones',
					width: '35%',
					hidden: true
				},
				{
					text: 'Usuario que Registra',
					dataField: 'idUsuarioRegistro',
					width: '35%',
					hidden: true
				},
				{
					text: 'Resultado Numerico',
					dataField: 'resultadoNumerico',
					width: '35%',
					hidden: true
				},
//                    {
//                        text: 'medios',
//                        dataField: 'mediosCultivo',
//                        width: '35%',
//                        hidden: false
//                    },
//                    {
//                        text: 'cepas',
//                        dataField: 'cepas',
//                        width: '35%',
//                        hidden: false
//                    },
{
	text: 'resultado1',
	dataField: 'resultado1',
	width: '35%',
	hidden: false
},
{
	text: 'Resultado2',
	dataField: 'resultado2',
	width: '35%',
	hidden: false
}

]
});
	$('#gridDetalleResConHojaRutaMuestra').jqxGrid('showloadelement');
}

function ajaxSearchMuestraHojaDeRuta(idMuestra, idPerfil, idUsuario) {
	//var url = 'model/DB/jqw/muestraData.php';
	var url = 'index.php';
	$.ajax({
		type: "GET",
		url: url,
		
		data: 'action=queryDb&query=GetMuestraReferenciasById&idMuestra=' + idMuestra,
		async: false,
		success: function (data) {
			var response = JSON.parse(data);
			if (response[0].response === 1) {
				if (response[0].muestra.id_estado_muestra == 11) {
					openNotificationConHojaRutaMuestra('error', 'El analisis consultado se encuentra anulado');
				} else {
					if(response[0].muestra.prefijo === 'PL'){
						$('#resultadoMesAerRow').css('display', 'block');
						$('#resultadoHonLevRow').css('display', 'block');
					} else {
						$('#resultadoMesAerRow').css('display', 'none');
						$('#resultadoHonLevRow').css('display', 'none');
					}
					$('#realIdMuestraConHojaRutaMuestra').val(response[0].muestra.id);
					$("#butttonConsultaAnexosConHojaRutaMuestra").jqxButton({disabled: false});
					chargeMuestraDataHojaDeRuta(response);
					chargeGridEnsayosHojaDeRuta(response[0].muestra.id, idPerfil, idUsuario, response[0].muestra.id_area_analisis);
					$("#inputNumMuestraConHojaRutaMuestra").jqxInput({disabled: true});
				}

			} else {
			}
		}
	});
}

function RechargeEnsayosGridPosRevision(idMuestra, idPerfil, idUsuario, idAreaAnalisis) {
	var promiseGetPermisos = ajaxGetPermisos();

	promiseGetPermisos.success(function (data) {
		var recargandoGrilla = $.Deferred();

		if (idPerfil == 6 || idPerfil == 7) {
			var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getEnsayoMuestraByIdMuestraIdAnalista&idMuestra=' + idMuestra + '&idAnalista=' + idUsuario;
			//var esCordinador = false;
		} else {
			var url = 'model/DB/jqw/EnsayoMuestraData.php?query=getEnsayoMuestraByIdMuestra&idMuestra=' + idMuestra;
			//var esCordinador = true;
		}

		var source = {
			datatype: "json",
			datafields: [
			{name: 'descripcionEnsayo'},
			{name: 'desEspecifica'},
			{name: 'descripcionPaquete'},
			{name: 'desMetodo'},
			{name: 'especificacion'},
			{name: 'aprobado'},
			{name: 'idMuestra'},
			{name: 'nombreAnalistaAsignado'},
			{name: 'nomEstadoEnsayoMuestra'},
			{name: 'cantidadResultados', type: 'int'},
			{name: 'idEstadoEnsayoMuestra', type: 'int'},
			{name: 'mes', type: 'int'},
			{name: 'idEstadoEnsayoMuestra', type: 'int'},
			{name: 'idSubMuestra', type: 'int'},
			{name: 'duracionEstabilidad', type: 'string'},
			{name: 'temperaturaEstabilidad', type: 'string'},
			],
			id: 'idEnsayoMuestra',
			url: url,
			async: false
		};
		var showfilterrow = false;
		var filterable = false;
		var columnDuracionEst = null;
		var columnTemperaturaEst = null;
		if (idAreaAnalisis == '4') {
			showfilterrow = true;
			filterable = true;
			columnDuracionEst = {
				text: 'Dur. Est.',
				dataField: 'duracionEstabilidad',
				hidden: false,
				editable: false,
				filtertype: 'checkedlist'
			};
			columnTemperaturaEst = {
				text: 'Temperatura',
				dataField: 'temperaturaEstabilidad',
				hidden: false,
				editable: false,
				filtertype: 'checkedlist'
			};
		}


		var permisos = JSON.parse(data);

		var permisoRevision = permisos.revisionEnsayoHojaTrabajo;
		var permisoConsultaResultado = permisos.consultaResultadoHojaTrabajo;
		var permisoRegistroResultados = permisos.registroResultadoHojaTrabajo;
		var permisoReprogramacion = permisos.reprogramacionEnsayoHojaTrabajo;



		var columnResutados = null;
		if (permisoConsultaResultado) {
			columnResutados = {
				text: 'Resultados',
				cellsrenderer: function (row) {
					return '<img style="position: absolute; top: 20%; left: 50%;" src="views/images/detalle.png" onClick="eventClickImageResultado(' + row + ',' + permisoRegistroResultados + ')"/>';
				},
				width: '7%',
				editable: false
			};
		}

		var columnRevision = null;
		if (permisoRevision) {

			columnRevision = {
				text: 'Revisado',
				dataField: 'aprobado',
				columntype: 'checkbox',
				width: '8%',
				editable: true,
				cellbeginedit: function (row, datafield, columntype) {
					var rowData = $('#gridEnsayosConHojaRutaMuestra').jqxGrid('getrowdata', row);
					if (rowData.aprobado == false) {
						if (rowData.cantidadResultados == 0) {
							openNotificationConHojaRutaMuestra('error', 'No es posible revisar un ensayo sin resultados.');
							return false
						} else {
							var infoEnsayo = 'Paquete: ' + rowData.descripcionPaquete + ' Ensayo: ' + rowData.desEspecifica;
							revisarEnsayo(rowData.uid, infoEnsayo);
						}
					} else {
						openNotificationConHojaRutaMuestra('error', 'No es posible eliminar la revisión de un ensayo.');
						return false
					}

				}
			};
		}

		var columnReprogramacion = null;
		if (permisoReprogramacion) {
			columnReprogramacion = {
				text: 'Reprogramar',
				cellsrenderer: function (row) {
					return '<img style="position: absolute; top: 20%; left: 50%;" src="views/jqwidgets/jqwidgets/styles/images/icon-calendar.png" onClick="eventClickImageReprogramar(' + row + ')"/>';
				},
				width: '7%',
				editable: false
			};
		}

		var dataAdapter = new $.jqx.dataAdapter(source);
		recargandoGrilla.resolve($("#gridEnsayosConHojaRutaMuestra").jqxGrid(
		{
			width: '99.8%',
			source: dataAdapter,
			autoheight: true,
			autorowheight: true,
			groupable: true,
			showgroupsheader: false,
			groupsexpandedbydefault: true,
			showgroupmenuitems: false,
			editable: true,
			editmode: 'dblclick',
			showfilterrow: showfilterrow,
			filterable: filterable,
			columns: [
			{
				text: 'Nombre',
				dataField: 'desEspecifica',
				width: '35%',
				editable: false
			},
			{
				text: 'Paquete',
				dataField: 'descripcionPaquete',
				hidden: true,
				editable: false

			},
			{
				text: 'Método',
				dataField: 'desMetodo',
				columntype: 'dropdownlist',
				width: '10%',
				editable: false
			},
			{
				text: 'Especificación',
				dataField: 'especificacion',
				width: '33%',
				editable: false
			},
			columnDuracionEst,
			columnTemperaturaEst,
			columnRevision,
			columnResutados,
			columnReprogramacion,
			{
				text: 'Resultados',
				dataField: 'cantidadResultados',
				cellsalign: 'center',
				hidden: true,
				editable: false
			}, {
				text: 'Número',
				dataField: 'idMuestra',
				hidden: true,
				editable: false
			},
			{
				text: 'Nombre de Analista',
				dataField: 'nombreAnalistaAsignado',
				hidden: true,
				editable: false
			},
			{
				text: 'idEstado',
				dataField: 'idEstadoEnsayoMuestra',
				width: '10%',
				hidden: true,
				editable: false

			},
			{
				text: 'Estado',
				dataField: 'nomEstadoEnsayoMuestra',
				width: '10%',
				hidden: false,
				editable: false
			}
			],
			groups: ['descripcionPaquete']
		}));
		recargandoGrilla.done(regitrarConclusionMuestra());
	});



}

function ajaxContarEnsayosSinRevisarByIdMuestra(idMuestra) {
	var url = 'index.php';
	var data = 'action=contarEnsayosSinRevision';
	data = data + '&idMuestra=' + idMuestra;

	return $.ajax({
		type: "GET",
		url: url,
		data: data,
		async: true
	});
}

function regitrarConclusionMuestra() {
	//alert("hola mundooooo");
	var areaAnalisis = $("#inputTipoEstudioConHojaRutaMuestra").jqxInput('val');
	if (areaAnalisis === "Estabilidad") {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var promiseValidarEnsayos = ajaxValidarEnsayosSubMuestra(idMuestra);
		promiseValidarEnsayos.success(function (data) {
			var response = JSON.parse(data);
			if (response.result === 0) {
				$("#hissubmuestra").val(response.idSubMuestra);
				$('#windowRegistroConclusionSubMuestraConHojaRutaMuestra').jqxWindow({title: 'Clonclusión de la SubMuestra ' + response.duracion});
				$('#windowRegistroConclusionSubMuestraConHojaRutaMuestra').jqxWindow('open');
			}

		});
	} else {
		var idMuestra = $("#realIdMuestraConHojaRutaMuestra").val();
		var promiseContarEnsayosSinRevisar = ajaxContarEnsayosSinRevisarByIdMuestra(idMuestra);
		promiseContarEnsayosSinRevisar.success(function (data) {
			var response = JSON.parse(data);
			if (response[0].cantidad == 0) {
				$('#windowRegistroConclusionMuestraConHojaRutaMuestra').jqxWindow('open');
			}
		});
	}
}

function eventCloseWindowRegistroConclusionSubMuestraConHojaRutaMuestra() {
	$('#windowRegistroConclusionSubMuestraConHojaRutaMuestra').on('close', function (event) {
		//alert("prueba");
		var idMuestra = $("#inputNumMuestraConHojaRutaMuestra").jqxInput('val');
		var promiseContarEnsayosSinRevisar = ajaxContarEnsayosSinRevisarByIdMuestra(idMuestra);
		promiseContarEnsayosSinRevisar.success(function (data) {
			var response = JSON.parse(data);
			if (response[0].cantidad == 0) {
				$('#windowRegistroConclusionMuestraConHojaRutaMuestra').jqxWindow('open');
			}
		});
	});
}

function ajaxValidarEnsayosSubMuestra(idMuestra) {
	var url = 'index.php';
	var data = 'action=validarEnsayosSubMuestra';
	data = data + '&idMuestra=' + idMuestra;
	return $.ajax({
		type: "POST",
		url: url,
		data: data,
		async: true
	});
}

function ajaxUpdateEnsayoCoHojaRutamuestra(idEnsayoMuestra, aprobado, tipoRevision, observaciones) {
	var url = 'index.php';
	var data = 'action=updateEnsayoConHojaRutaMuestra';
	data = data + '&idEnsayoMuestra=' + idEnsayoMuestra;
	data = data + '&aprobado=' + aprobado;
	data = data + '&tipoRevision=' + tipoRevision;
	data = data + '&observaciones=' + observaciones;
	return $.ajax({
		type: "POST",
		url: url,
		data: data,
		async: true
	});
}

function ajaxSaveResultadoConHojaRutamuestra(idEnsayoMuestra, idLote, resultado, observaciones, fechaRegistro, resultadoNumerico, resultado1, resultado2,mediosCultivo,cepas) {
	var url = 'index.php';

	if (resultado === '') {
		openNotificationConHojaRutaMuestra('error', 'No es posible guardar resultados en blanco');
	} else {
		$.ajax({
			type: "POST",
			url: url,
			data: {
				action: 'saveResultado',
				idEnsayoMuestra: idEnsayoMuestra,
				idLote: idLote,
				resultado: resultado,
				observaciones: observaciones,
				fechaRegistro: fechaRegistro,
				resultadoNumerico: resultadoNumerico,
				resultado1: resultado1,
				resultado2: resultado2,
				mediosCultivo: mediosCultivo,
				cepas: cepas
			},
			async: false,
			success: function (data) {
				//alert("test");
				var response = JSON.parse(data);
				if (response.result === 0) {
					chargeGridDetalleResConHojaRutaMuestra(idEnsayoMuestra, true);
					openNotificationConHojaRutaMuestra('success', response.message);
				} else {
					openNotificationConHojaRutaMuestra('error', response.message);
				}
			}
		});
	}


}

function openNotificationConHojaRutaMuestra(template, message) {
	$("#messageNotificationConHojaRutaMuestra").text(message);
	$("#notificationConHojaRutaMuestra").jqxNotification({template: template});
	$("#notificationConHojaRutaMuestra").jqxNotification("open");
}

function eventClickDetalleResultado(row) {

	$("#buttonGuardarDetalleResConHojaRutaMuestra").hide();
	
	var externalGridData = $('#gridEnsayosConHojaRutaMuestra').jqxGrid('getrows');
	var data = $('#gridDetalleResConHojaRutaMuestra').jqxGrid('getrowdata', row);

	$.ajax({
		type: "GET",
		url: 'index.php',
		data: {
			action: 'queryDb',
			query: 'getResultadoReferenciasByIdResultado',
			idResultado: data.id
		},
		async: false,
		success: function (response) {
			var resultadoDetalle = JSON.parse(response);

			

			//load data
			$('#windowDetalleResultadosDetalleResConHojaRutaMuestra').on('open', function (event) {

				if(resultadoDetalle.data[0].aprobado == 0){
					$("#buttonActualizarDetalleResConHojaRutaMuestra").show();
				} else {
					$("#buttonActualizarDetalleResConHojaRutaMuestra").hide();
				}

			// load fecha de registro
			var realDate = resultadoDetalle.data[0].fecha_registro;
			var realDate = realDate.split(" ");
			var realDate = realDate[0].split("-");
			var realYear = realDate[0];
			var realMonth = realDate[1] - 1;
			var realDay = realDate[2];
			$("#inputDateFechaRegistroDetalleResConHojaRutaMuestra").jqxDateTimeInput("val", new Date(realYear, realMonth, realDay));

			
			$('#hiddenIdResultadoConHojaRutaMuestra').val(resultadoDetalle.data[0].id);


			$("#editorResultadoDetalleResConHojaRutaMuestra").val(resultadoDetalle.data[0].resultado);
			$("#editorObservacionesDetalleResConHojaRutaMuestra").val(resultadoDetalle.data[0].observaciones);
			$("#inputNumberResultadoNumericoResConHojaRutaMuestra").val(resultadoDetalle.data[0].resultado_numerico);
			$("#editorResultado1ResConHojaRutaMuestra").val(resultadoDetalle.data[0].resultado_1);
			$("#editorResultado2ResConHojaRutaMuestra").val(resultadoDetalle.data[0].resultado_2);
				// load medios de cultivo
				var totalMedios = $("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList('getItems'); 

				$("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList('uncheckAll'); 
				resultadoDetalle.data[0].medios.forEach(function(element, index, array){
					totalMedios.forEach(function(element1, index1, array1){
						element.id_estandar == element1.value ? 
						($("#dropDownMediosCultivoResConHojaRutaMuestra").jqxDropDownList('checkIndex', element1.index) ):(false);
					});
				});
			// load cepas
			var totalCepas = $("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList('getItems'); 
			$("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList('uncheckAll'); 
			resultadoDetalle.data[0].cepas.forEach(function(element, index, array){
				totalCepas.forEach(function(element1, index1, array1){
					element.id_reactivo == element1.value ? 
					($("#dropDownCepasControlCalidadResConHojaRutaMuestra").jqxDropDownList('checkIndex', element1.index) ):(false);
				});
			});



		});

			

			$("#windowDetalleResultadosDetalleResConHojaRutaMuestra").jqxWindow('open');
		}
	});

	


}

function eventClickImageReprogramar(row) {

	var data = $('#gridEnsayosConHojaRutaMuestra').jqxGrid('getrowdata', row);

	if (data.idEstadoEnsayoMuestra == 2 || data.idEstadoEnsayoMuestra == 3) {
		openNotificationConHojaRutaMuestra('error', 'No es posible reprogramar un ensayo en estado ' + data.nomEstadoEnsayoMuestra);
	} else {
		$('#windowobservacionesReprogramarMuestra').jqxWindow('open');
		$('#buttonOKWindowObservacionesReprogramarMuestra').unbind();
		$('#buttonOKWindowObservacionesReprogramarMuestra').on('click', function () {

			$('#gridEnsayosConHojaRutaMuestra').jqxGrid('deleterow', data.uid);
			var observaciones = $("#editorMotivoReprogramacion").jqxEditor('val');
			$('#windowobservacionesReprogramarMuestra').jqxWindow('close');
			ajaxReprogramarEnsayoMuestra(data.uid, observaciones);
		});
	}
}

function eventCloseWindowObservacionesAprobacionEnsayoMuestra(idPerfil, idUsuario) {
	$('#windowObservacionesAprobacionEnsayoMuestra').on('close', function (event) {
		//alert("prueba");
		$('#editorMotivoAprovacion').jqxEditor('val', '');

		$('#hIdEnsayoMuestraConHojaRutaMuestra').val('');
		$('#hMetodoConHojaRutaMuestra').val('');
		$('#hAprobadoConHojaRutaMuestra').val('');
		var value = $("#realIdMuestraConHojaRutaMuestra").val();
		var areaAnalisis = $("#inputTipoEstudioConHojaRutaMuestra").jqxInput('val');
		if (areaAnalisis === "Estabilidad") {
			var p = RechargeEnsayosGridPosRevision(value, idPerfil, idUsuario, 4);
		} else {
			var p = RechargeEnsayosGridPosRevision(value, idPerfil, idUsuario, 0);
		}


//        setTimeout(function () {
//            //ajaxSearchMuestraHojaDeRuta(value,idPerfil,idUsuario);
//            RechargeEnsayosGridPosRevision(value, idPerfil, idUsuario);
//            
//        }, 200);


});

}

function eventClosewindowobservacionesReprogramarMuestra() {
	$('#windowobservacionesReprogramarMuestra').on('close', function (event) {
		$('#editorMotivoReprogramacion').jqxEditor('val', '');
	});
}

function ajaxReprogramarEnsayoMuestra(idEnsayoMuestra, observaciones) {
	var url = 'index.php';
	var data = 'action=reprogramarEnsayoMuestra';
	data = data + '&idEnsayoMuestra=' + idEnsayoMuestra;
	data = data + '&observaciones=' + observaciones;


	$.ajax({
		type: "POST",
		url: url,
		data: data,
		async: false,
		success: function (data) {
			//alert("test");
			var response = JSON.parse(data);
			if (response.result === '1') {
				//chargeGridDetalleResConHojaRutaMuestra(idEnsayoMuestra, false);
				openNotificationConHojaRutaMuestra('success', 'Se registro el ensayo para Reprogramación');
			} else {
				openNotificationConHojaRutaMuestra('error', 'Fallo el registro del ensayo Para Reprogramacion');
			}
		}
	});
}

function ajaxRechazaMuestra(idMuestra) {
	var url = 'index.php';
	var data = 'action=rechazaMuestra';
	data = data + '&idMuestra=' + idMuestra;


	$.ajax({
		type: "POST",
		url: url,
		data: data,
		async: false,
		success: function (data) {
			//alert("test");
			var response = JSON.parse(data);
			if (response.result === '1') {
				//chargeGridDetalleResConHojaRutaMuestra(idEnsayoMuestra, false);
				openNotificationConHojaRutaMuestra('success', 'La muestra se ha rechazado');
			} else {
				openNotificationConHojaRutaMuestra('error', 'Fallo el rechazo de la muestra');
			}
		}
	});
}

function ajaxScanDirByIdMuestraConHojaRutaMuestra(idMuestra) {
	var url = "index.php?action=scanDirByIdMuestra&idMuestra=" + idMuestra;
	var data = "idMuestra=" + idMuestra;
	return $.ajax({
		type: "GET",
		url: url,
		data: data,
		async: false,
		success: function (data) {
			//loadTreeDocsMuestra(data);
		}
	});
}

function ajaxGetPermisos() {
	var url = "index.php?action=getPermisos";

	return $.ajax({
		type: "GET",
		url: url,
		async: true,
	});
}