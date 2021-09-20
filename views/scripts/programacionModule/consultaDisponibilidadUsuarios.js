function initialConsultaDisponibilidadUsuarios(){
    
    
    $("#divNomenclaturaCalendar").hide();
    $("#principalDivCalendar").hide();
    $("#divProncipalGridProgramacionOnDateByIdAnalista").hide();
    loadInputAnalistaNombre();
    loadWindowDetalleActividad();
    loadWindowAlertDeleteActividad();
     
    
    
    //events
    eventButtonClickChargeAnalistaInfo();
    eventsCustomCalendar();
    //eventBindingcompleteGridProgramacionOndateByIdAnalista();
    
    
    
    
    
   
    
}

function loadCustomeCalendar(idAnalista){
    
    var idCalendarioAnalista = ajaxGetCalendarIdByUserId(idAnalista);
    var calendarAnalista = ajaxGetCalendarByIdCalendar(idCalendarioAnalista);
    calendarAnalista = calendarAnalista[0];
    var today = new Date();
    var yearToday = today.getFullYear();
    var numberMonthToday = today.getMonth();
    var textMonthToday = getTextMonthFromNumber(numberMonthToday);
   
    
    $("#hiddenInputYear").val(yearToday);
    $("#hiddenInputmonth").val(numberMonthToday);
    
    $("#textHeaderCalendar").html(textMonthToday+' '+yearToday);
    
    renderCalendarDays();
    
   
}

function loadInputAnalistaNombre(){
    var url = 'model/DB/jqw/usuarioData.php?query=getAllAnalistas';
    var sourceAnalistas =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'nombre' }
        ],
        url: url,
        async: false
    };
    var dataAdapterAnalistas = new $.jqx.dataAdapter(sourceAnalistas);
    $("#inputAnalistaNombre").jqxInput({
        placeHolder: "Nombre analista a consultar", 
        height: 25, 
        width: 300, 
        minLength: 1, 
        source:dataAdapterAnalistas,
        displayMember: "nombre", 
        valueMember: "id"
    });
}

function loadGridProgramacionOndateByIdAnalista(idAnalista, onDate){
    
    var url = "model/DB/jqw/programacionAnalistasData.php?query=getProgramacionByIdAnalistaOnDate&idAnalista="+idAnalista+"&onDate="+onDate;
    var ProgramacionOndateByIdAnalistaSource =
    {
        datatype: "json",
        datafields: [
            { name: 'id' },
            { name: 'fechaProgramada' },
            { name: 'duracionActividad' },
            { name: 'idMuestra' },
            { name: 'idEnsayo' },
            { name: 'desEnsayo' },
            { name: 'idPaquete' },
            { name: 'desPaquete' },
            { name: 'fechaProgramacionEnsayo', type:'string'},
            { name: 'fechaCompInternoEnsayo' },
            { name: 'duracion' },
            { name: 'idEquipo' },
            { name: 'desEquipo' },
            { name: 'idAreaAnalisis' },
            { name: 'desAreaAnalisis' },
            { name: 'tipoEstabilidad' },
            { name: 'idProgramador' },
            { name: 'nomProgramador' },
            { name: 'aprobadoEnsMue' },
            { name: 'idEnsayoMuestra' }
        ],
        id: 'id',
        url: url,
        async: false,
        

    };
    var ProgramacionOndateByIdAnalistaAdapter = new $.jqx.dataAdapter(ProgramacionOndateByIdAnalistaSource);
     $("#gridProgramacionOnDateByIdAnalista").jqxGrid(
    {
        width: '100%',
        height: '90%',
        source: ProgramacionOndateByIdAnalistaAdapter,
        groupable: true,
        showgroupsheader: false,
        groupsexpandedbydefault: true,
        showgroupmenuitems: false,
        columns: [
          { text: 'idProgramacion', dataField: 'id', width: 200, hidden:true },
          { text: 'Ensayo', dataField: 'desEnsayo', width: 210 },
          { text: 'Programador', dataField: 'nomProgramador', width: 200 },
          { text: 'Fecha actividad', dataField: 'fechaProgramada', width: 120, cellsformat: 'd' },
          { text: 'Fecha Compromiso', dataField: 'fechaCompInternoEnsayo', width: 130 },
          { text: 'Muestra No', dataField: 'idMuestra', width: 200, hidden:true },
          { text: 'idEnsayo', dataField: 'idEnsayo', width: 200, hidden:true },
          { text: 'idPaquete', dataField: 'idPaquete', width: 200, hidden:true },
          { text: 'Paquete', dataField: 'desPaquete', width: 200, hidden:true },
          { text: 'Dur. Ens.', dataField: 'duracion', width: 70, hidden:true },
          { text: 'Duración (Min.)', dataField: 'duracionActividad', width: 120 },
          { text: 'aprobadoEnsMue', dataField: 'aprobadoEnsMue', width: 120, hidden:true },
          { text: 'idEquipo', dataField: 'idEquipo', width: 200, hidden:true },
          { text: 'desEquipo', dataField: 'desEquipo', width: 200, hidden:true },
          { text: 'idAreaAnalisis', dataField: 'idAreaAnalisis', width: 200, hidden:true },
          { text: 'desAreaAnalisis', dataField: 'desAreaAnalisis', width: 200, hidden:true },
          { text: 'tipoEstabilidad', dataField: 'tipoEstabilidad', width: 200, hidden:true },
          { text: 'idProgramador', dataField: 'idProgramador', width: 200, hidden:true },
          
          { text: 'Fecha Programacion', dataField: 'fechaProgramacionEnsayo', width: 120, hidden:true },
          
          { text: 'idEnsayoMuestra', dataField: 'idEnsayoMuestra', width: 120, hidden:true },
          { text: '',   width: 30, cellsrenderer: function (row) {
        return '<img style="margin-left: 8px;margin-top: 3px"src="views/images/detalle.png" onClick="eventClickImageDetalleActividad('+row+')"/>';
              }
          },
          { text: '',   width: 30, cellsrenderer: function (row) {
                  var dataRecord = $("#gridProgramacionOnDateByIdAnalista").jqxGrid('getrowdata', row); 
                  if(dataRecord.aprobadoEnsMue == 0){
                                return '<img style="margin-left: 8px;margin-top: 3px"src="views/images/papelera.png" onClick="eventClickImageDeleteActividad(' + dataRecord.idEnsayoMuestra + ')"/>';

                            } else {
                                return '';
                            }
              }
          }
        ],
        groups: ['idMuestra','desPaquete']
    });
}

function loadWindowDetalleActividad(){
    $('#windowDetalleActividad').jqxWindow({
        
        height: 320, 
        width: 1000,
        isModal: true,
        autoOpen: false,
        position: { x: 300, y: 400 }
    });
    $("#inputMuestraWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#inputEnsayoWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#inputCalendarFechaProgramacionWindowDetalleActividad").jqxDateTimeInput({width: 180, height: 20});
    $("#inputDuracionWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#inputCalendarFechaFinaliazacionWindowDetalleActividad").jqxDateTimeInput({width: 180, height: 20, disabled:true});
    $("#inputEquipoWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#inputAreaAnalisisWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#inputTipoEstabilidadWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#inputProgramadorWindowDetalleActividad").jqxInput({width: 180, height: 20, disabled:true});
    $("#buttonOKWindowDetalleActividad").jqxButton({width:100});
    $("#buttonCancelWindowDetalleActividad").jqxButton({width:100});
    $('#windowDetalleActividad').jqxWindow({ okButton: $('#buttonOKWindowDetalleActividad')});
    $('#windowDetalleActividad').jqxWindow({ cancelButton: $('#buttonCancelWindowDetalleActividad')});
    $('#inputCalendarFechaProgramacionWindowDetalleActividad').on('valueChanged', function (event){  
        $("#inputHiddenWindowDetalleActividadChangeDateFlag").val('1');
    });
    eventClickButtonOKWindowDetalleActividad();
}

function loadWindowAlertDeleteActividad(){
    $('#windowAlertDeleteActividad').jqxWindow({
        
        height: 100, 
        width: 200,
        isModal: true,
        autoOpen: false,
        title: 'Precaución',
        position: { x: 750, y: 500 }
    });
}

function eventButtonClickChargeAnalistaInfo(){
    $("#inputButtonChargeAnalistaInfo").click(function () {
        $("#divProncipalGridProgramacionOnDateByIdAnalista").hide();
        var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
        if(analistaObject.value != null){
            $("#headerCalendarioAnalista").html('Calendario Analista: <strong>'+analistaObject.label+'</strong>')
            
            //alert(calendarAnalista.i);
            $("#principalDivCalendar").hide(function(){
                loadCustomeCalendar(analistaObject.value);
            });
            
            $("#principalDivCalendar").show('slow', function(){
                
                $("#divNomenclaturaCalendar").show('slow');
            });
            
        } else {
            alert('Analista a Consultar Invalido');
        }
        
        
        
        
    });
}

function eventClickButtonOKWindowDetalleActividad(){
    $("#buttonOKWindowDetalleActividad").on('click', function(){
       var flag = $("#inputHiddenWindowDetalleActividadChangeDateFlag").val();
       var idActividad = $("#inputHiddenWindowDetalleActividadIdActividad").val();
       var newDate = $("#inputCalendarFechaProgramacionWindowDetalleActividad").jqxDateTimeInput('getDate');
       var newYear = newDate.getFullYear();
       var newMonth = newDate.getMonth() + 1;
       var newDay = newDate.getDate();
       var newSimpleDate = newYear+"-"+newMonth+"-"+newDay;
       if(flag !== '0'){
           
           var update = ajaxUpdateFechaProgramadaActividad(idActividad, newSimpleDate);
           if (update == 1){
               var idAnalista = $("#inputAnalistaNombre").val();
               var onDate = $("#inputHiddenSelectedDate").val();
               $("#calendarPrincipal").hide(function(){
                   renderCalendarDays();
                   $("#calendarPrincipal").show("slow", function(){
                       loadGridProgramacionOndateByIdAnalista(idAnalista.value, onDate);
                   });
               });
               
           }
           //alert("actualizar el id; "+idActividad+"\n Nueva fecha:"+newDate );
       }
    });
}

function eventClickImageAvansarCalendario(){
    var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
    var idCalendarioAnalista = ajaxGetCalendarIdByUserId(analistaObject.value);
    var calendarAnalista = ajaxGetCalendarByIdCalendar(idCalendarioAnalista);
    calendarAnalista = calendarAnalista[0];
    var currentYear = $("#hiddenInputYear").val();
    var currentMonth = $("#hiddenInputmonth").val();
    var newMonth = parseInt(currentMonth)+1;
    if(newMonth >= 12){
        newMonth = 0;
        currentYear++;
    }
    var textNewMonth =  getTextMonthFromNumber(newMonth);
    $("#hiddenInputYear").val(currentYear);
    $("#hiddenInputmonth").val(newMonth);
    $("#textHeaderCalendar").html(textNewMonth+' '+currentYear);
    $("#calendarPrincipal").hide();
    renderCalendarDays();
    $("#calendarPrincipal").show("slow");
}

function eventClickImageDeleteActividad(idEnsayoMuestra){
    //alert(idEnsayoMuestra);
    ajaxDeleteProgramacionByIdEnsayoMuestra2(idEnsayoMuestra);
    //$('#windowAlertDeleteActividad').jqxWindow('open');
}

function eventClickImageDetalleActividad(row){
    var data = $('#gridProgramacionOnDateByIdAnalista').jqxGrid('getrowdata', row);
    
    $('#windowDetalleActividad').jqxWindow('setTitle', 'Detalle de actividad para el ensayo:'+data.desEnsayo);
    $('#inputMuestraWindowDetalleActividad').jqxInput('val', data.idMuestra);
    $("#inputEnsayoWindowDetalleActividad").jqxInput('val', data.desEnsayo);
    var fechaActividad = data.fechaProgramada;
    fechaActividad = fechaActividad.split("/");
    $("#inputCalendarFechaProgramacionWindowDetalleActividad").jqxDateTimeInput('setDate', new Date(fechaActividad[2],(fechaActividad[1]-1),fechaActividad[0]));
    $("#inputDuracionWindowDetalleActividad").jqxInput('val', data.duracionActividad+" Minutos");
    var fechaFinalizacion = data.fechaCompInternoEnsayo;
    fechaFinalizacion = fechaFinalizacion.split("/");
    $("#inputCalendarFechaFinaliazacionWindowDetalleActividad").jqxDateTimeInput('setDate', new Date(fechaFinalizacion[2],(fechaFinalizacion[1]-1),fechaFinalizacion[0]));
    $("#inputEquipoWindowDetalleActividad").jqxInput('val',data.desEquipo);
    $("#inputAreaAnalisisWindowDetalleActividad").jqxInput('val',data.desAreaAnalisis);
    $("#inputTipoEstabilidadWindowDetalleActividad").jqxInput('val',data.tipoEstabilidad);
    $("#inputProgramadorWindowDetalleActividad").jqxInput('val',data.nomProgramador);
    $("#inputHiddenWindowDetalleActividadChangeDateFlag").val('0');
    $("#inputHiddenWindowDetalleActividadIdActividad").val(data.id);
    
    $('#windowDetalleActividad').jqxWindow('open');
}

function eventClickImageRetrocederCalendario(){
    var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
    var idCalendarioAnalista = ajaxGetCalendarIdByUserId(analistaObject.value);
    var calendarAnalista = ajaxGetCalendarByIdCalendar(idCalendarioAnalista);
    calendarAnalista = calendarAnalista[0];
    var currentYear = $("#hiddenInputYear").val();
    var currentMonth = $("#hiddenInputmonth").val();
    var newMonth = parseInt(currentMonth)-1;
    if(newMonth < 0){
        newMonth = 11;
        currentYear--;
    }
    var textNewMonth =  getTextMonthFromNumber(newMonth);
    $("#hiddenInputYear").val(currentYear);
    $("#hiddenInputmonth").val(newMonth);
    $("#textHeaderCalendar").html(textNewMonth+' '+currentYear);
    $("#calendarPrincipal").hide();
    renderCalendarDays();
    $("#calendarPrincipal").show("slow");
}

function eventsCustomCalendar(){
    $("div.divCalendarDay").on("click", function(){
        
        $("#tittleGridProgramacionOnDateByIdAnalista").hide('slow',function(){
            $("#tittleGridProgramacionOnDateByIdAnalista").html("Programación del analista <strong>"+analistaObject.label+"</strong> el día <strong>"+simpleDay+"/"+simpleMonth+"/"+simpleYear)+"</strong>";
            $("#tittleGridProgramacionOnDateByIdAnalista").show('slow');
        });
        var thisId = $(this).attr("value");
        var simpleDate = new Date(thisId);
        var simpleYear = simpleDate.getFullYear();
        var simpleMonth = simpleDate.getMonth()+1;
        if(simpleMonth < 10){
            simpleMonth = simpleMonth.toString();
            simpleMonth = "0"+simpleMonth;
        } 
        var simpleDay = simpleDate.getDate();
         if(simpleDay < 10){
            simpleDay = simpleDay.toString();
            simpleDay = "0"+simpleDay;
        } 
        simpleDate = simpleYear+"-"+simpleMonth+"-"+simpleDay;
        var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
        var idAnalista = analistaObject.value;
        $("#inputHiddenSelectedDate").val(simpleYear+"-"+simpleMonth+"-"+simpleDay);
        
        $("#divProncipalGridProgramacionOnDateByIdAnalista").show("slow", function(){
            loadGridProgramacionOndateByIdAnalista(idAnalista, simpleDate)
        });
        
    });
    
    $("div.divCalendarDay")
        .on("mouseenter", function(){
            
            $(this).css({
                
                "border":"1px solid #999",
                
            })
        })
        .on("mouseleave", function(){
            $(this).css({
                "border":"1px solid transparent"
            });
        });
    
}

function getTextMonthFromNumber(monthNumber){
    var textMonthToday;
     switch(monthNumber){
        case 0:
            var textMonthToday = 'Enero';
            break;
        case 1:
            var textMonthToday = 'Febrero';
            break;
        case 2:
            var textMonthToday = 'Marzo';
            break;
        case 3:
            var textMonthToday = 'Abril';
            break;
        case 4:
            var textMonthToday = 'Mayo';
            break;
        case 5:
            var textMonthToday = 'Junio';
            break;
        case 6:
            var textMonthToday = 'Julio';
            break;
        case 7:
            var textMonthToday = 'Agosto';
            break;
        case 8:
            var textMonthToday = 'Septiembre';
            break;
        case 9:
            var textMonthToday = 'Octubre';
            break;
        case 10:
            var textMonthToday = 'Noviembre';
            break;
        case 11:
            var textMonthToday = 'Diciembre';
            break;
    }
    return textMonthToday;
}

function renderCalendarDays(){
    
    var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
    var idAnalista = analistaObject.value;
    
    var idCalendarioAnalista = ajaxGetCalendarIdByUserId(idAnalista);
    var calendarAnalista = ajaxGetCalendarByIdCalendar(idCalendarioAnalista);
    calendarAnalista = calendarAnalista[0];
    
    var jornadas = [];
    jornadas[0] = calendarAnalista.jornadaDomingo;
    jornadas[1] = calendarAnalista.jornadaLunes;
    jornadas[2] = calendarAnalista.jornadaMartes;
    jornadas[3] = calendarAnalista.jornadaMiercoles;
    jornadas[4] = calendarAnalista.jornadaJueves;
    jornadas[5] = calendarAnalista.jornadaViernes;
    jornadas[6] = calendarAnalista.jornadaSabado;
    
    var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
    var idAnalista = analistaObject.value;
    var currentYear = $("#hiddenInputYear").val();
    var currenteMonth = $("#hiddenInputmonth").val();
    var currentDate = new Date(currentYear,currenteMonth,1);
    var firstWeekDay = currentDate.getDay();
    
    var pointerDate = new Date(currentDate);
    var pointerDay = pointerDate.getDate();
    pointerDay = pointerDay - firstWeekDay;
    pointerDate.setDate(pointerDay);
    
    var initialPointerDate = new Date(pointerDate);
    var startYear = initialPointerDate.getFullYear();
    var startMonth = initialPointerDate.getMonth() + 1;
    var startDay = initialPointerDate.getDate();
    var startDate = startYear+"-"+startMonth+"-"+startDay;
    var aux = initialPointerDate.getDate()+41;
    var finalPointerDate = new Date(pointerDate);
    finalPointerDate.setDate(aux);
    var finalYear = finalPointerDate.getFullYear();
    var finalMonth = finalPointerDate.getMonth() + 1;
    var finalDay = finalPointerDate.getDate();
    var finalDate = finalYear+"-"+finalMonth+"-"+finalDay;
    var programacion = ajaxGetProgramacionByIdAnalistaAndRangeTime(idAnalista,startDate,finalDate);
    
    
    
    var idCalendarDay;
   
    for(var i = 0; i< 6; i++){
        for(var j = 0; j < 7; j++){
            idCalendarDay = "#calendarR"+i+"C"+j;
            $(idCalendarDay).html(pointerDate.getDate());
            $(idCalendarDay).attr('value',pointerDate);
            var ahoraYear = pointerDate.getFullYear();
            var ahoraMonth = pointerDate.getMonth() + 1;
            if(ahoraMonth < 10){
                ahoraMonth = ahoraMonth.toString();
                ahoraMonth = "0"+ahoraMonth;
            } else {
                ahoraMonth = ahoraMonth.toString();
            }
            var ahoraDay = pointerDate.getDate();
            if(ahoraDay < 10){
                ahoraDay = ahoraDay.toString();
                ahoraDay = "0"+ahoraDay;
            } else {
                ahoraDay = ahoraDay.toString();
            }
            
            var ahoraDate = ahoraYear+"-"+ahoraMonth+"-"+ahoraDay;
            var jornadaAhora = jornadas[pointerDate.getDay()];
            var programacionAhora = null;
            if(programacion != null){
                for(var h = 0 ; h < programacion.length; h++){
                    if(programacion[h].fecha == ahoraDate){
                        programacionAhora = programacion[h].tiempoProgramado;
                        break;
                    }
                }
            }
            
            
            
            if(currenteMonth != pointerDate.getMonth()){
                $(idCalendarDay).css({
                    "color":"#999",
                    "background":"white"
                });
            } else {
                if(programacionAhora != null){
                    programacionAhora = parseInt(programacionAhora);
                    if(programacionAhora == jornadaAhora){
                        $(idCalendarDay).css({
                            "background":"#000087"
                        });
                    }
                    if(programacionAhora > jornadaAhora){
                        $(idCalendarDay).css({
                            "background":"red"
                        });
                    }
                    if(programacionAhora < jornadaAhora){
                        $(idCalendarDay).css({
                            "background":"blue"
                        });
                    }
                    if(programacionAhora == 0 ){
                        $(idCalendarDay).css({
                            "background":"white"
                        });
                    }
                    //alert("hola mundo");
                } else {
                     $(idCalendarDay).css({
                            "background":"white"
                        });
                }
                $(idCalendarDay).css({
                    "color":"black"
                });
            }
            pointerDay = pointerDate.getDate() +1;
            pointerDate.setDate(pointerDay);
        }
    }
    
}

function ajaxGetCalendarIdByUserId(userId){
    var url='model/DB/jqw/usuarioData.php';
    var response;
    $.ajax({
        type: "GET",
        url:url,
        data: "query=getCalendarIdByUserId&userId="+userId,
        async: false,
        success: function (data, textStatus, jqXHR) {
             response = JSON.parse(data);
            
        }
    });
    return response[0].idCalendario;
}

function ajaxGetCalendarByIdCalendar(calendarId){
    var url='model/DB/jqw/CalendarioData.php';
    var response;
    $.ajax({
        type: "GET",
        url:url,
        data: "query=getCalendarioById&idCalendario="+calendarId,
        async: false,
        success: function (data, textStatus, jqXHR) {
             response = JSON.parse(data);
            
        }
    });
    return response;
}

function ajaxGetProgramacionByIdAnalistaAndRangeTime(idAnalista, startDate, endDate){
    var url='model/DB/jqw/programacionAnalistasData.php';
    var response;
    $.ajax({
        type: "GET",
        url:url,
        data: "query=getProgramacionByIdAnalistaAndRangeTime&idAnalista="+idAnalista+"&stratDate="+startDate+"&endDate="+endDate,
        async: false,
        success: function (data, textStatus, jqXHR) {
             response = JSON.parse(data);
            
        }
    });
    return response;
}

function ajaxUpdateFechaProgramadaActividad(idActividad, newDate){
    var url='index.php';
    var response;
    $.ajax({
        type: "POST",
        url:url,
        data: "action=updateFechaProgramada&idProgramacion="+idActividad+"&newDate="+newDate,
        async: false,
        success: function (data, textStatus, jqXHR) {
             response = JSON.parse(data);
            
        }
    });
    return response;
}

function ajaxDeleteProgramacionByIdEnsayoMuestra2(idEnsayoMuestra){
    var url = 'index.php';
    var data = 'action=deleteProgramacionByIdEnsayoMuestra';
    data = data + '&idEnsayoMuestra='+idEnsayoMuestra;
    
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function(data){
            var response = JSON.parse(data);
            if(response.result === '1'){
                
                 var idAnalista = $("#inputAnalistaNombre").val();
               var onDate = $("#inputHiddenSelectedDate").val();
               $("#calendarPrincipal").hide(function(){
                   renderCalendarDays();
                   $("#calendarPrincipal").show("slow", function(){
                       loadGridProgramacionOndateByIdAnalista(idAnalista.value, onDate);
                   });
               });
            } else {
                alert("fallo");
            }
        }
    });
}



