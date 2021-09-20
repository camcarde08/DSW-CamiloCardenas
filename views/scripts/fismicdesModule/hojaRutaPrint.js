function initialHojaRutaPrint(idMuestra){
    
    loadInputNumMuestraHojaRutaPrint(idMuestra);
    loadInputProductoHojaRutaPrint();
    loadInputTipoEstudioHojaRutaPrint();
    loadInputClienteHojaRutaPrint();
    loadEnsayosDiv();
    ajaxLoadMuestraGeneralInfo(idMuestra);
    ajaxLoadEnsayosByMuestra(idMuestra);
}

function loadInputNumMuestraHojaRutaPrint(idMuestra){
    $("#inputNumMuestraHojaRutaPrint").jqxInput({ placeHolder: "Numero de muestra", height: 20, width: 200, minLength: 1});
    $("#inputNumMuestraHojaRutaPrint").jqxInput("val",idMuestra);
    
}

function loadInputProductoHojaRutaPrint(){
    $("#inputProductoHojaRutaPrint").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadInputTipoEstudioHojaRutaPrint(){
    $("#inputTipoEstudioHojaRutaPrint").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadInputClienteHojaRutaPrint(){
    $("#inputClienteHojaRutaPrint").jqxInput({height: 20, width: 350, minLength: 1});
}

function loadEnsayosDiv(){
    $("#ensayosDiv").html("<strong>test test</strong>");
}

function ajaxLoadMuestraGeneralInfo(idMuestra){
    var url = 'model/DB/jqw/muestraData.php?query=GetMuestraReferenciasById&idMuestra='+idMuestra;
    
    $.ajax({
        type: "GET",
        url: url,
        async: false,
        success: function(data){
            
            var response = JSON.parse(data);
            $("#inputProductoHojaRutaPrint").val(response[0].muestra.nombre_producto);
            $("#inputClienteHojaRutaPrint").val(response[0].muestra.nombre_tercero);
            $("#inputTipoEstudioHojaRutaPrint").val(response[0].muestra.des_area_analisis);
            
            
        }
    });
}

function ajaxLoadEnsayosByMuestra(idMuestra){
    var url = "model/DB/jqw/ensayoMuestraReferenciasData.php?query=GetEnsayoMuestraActivosByIdMuestra&estadoEnsayo=1&idMuestra="+idMuestra;
    var aux = "";
    $.ajax({
        type: "GET",
        url: url,
        async: false,
        success: function(data){
            
            var response = JSON.parse(data);
            for(var i = 0; i<response.length; i++){
                aux = aux + "<div style='width: 90%;border: 1px solid black; margin-left: 5%; margin-top: 2%'>";
                aux = aux + "paquete: " + response[i].descripcionPaquete;
                aux = aux + "  Ensayo: " + response[i].descripcionPaquete + "<br><br>"
                aux = aux + "Resultado:<br> <hr style='width: 99%; float: left'><br><hr style='width: 99%; float: left'><br><hr style='width: 99%; float: left'><br><hr style='width: 99%; float: left'><br>"; 
                aux = aux + "</div>";
            }
            
            $("#ensayosDiv").html(aux);
            
        }
    });
}


