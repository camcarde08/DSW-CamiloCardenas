 function initialInformePlanta(){
    eventButtonClickChargeInformePlantaPDF();
   }

function eventButtonClickChargeInformePlantaPDF(){
    
    $("#inputButtonGeneraInformePlantaInfo").click(function () {
        //alert('entro a funcion');
        var muestraIniObject = $("#textInputMuestraInicial").val();
        var muestraFinObject = $("#textInputMuestraFinal").val();
        if(muestraIniObject != ''){
         if(muestraFinObject != ''){
        window.open("pdf/informes/informeAnalisisPlantas.php?idInicio="+muestraIniObject+"&idFinal="+muestraFinObject);
        } else {
            alert('Campo Vacio o Invalido en Muestra Final');
        }
        } else {
            alert('Campo Vacio o Invalido en Muestra Inicial');
        }
   });
}

