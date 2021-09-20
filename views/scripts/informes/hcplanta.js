 function initialInformeHCPlanta(){
    eventButtonClickChargeHCPlantaPDF();
   }

function eventButtonClickChargeHCPlantaPDF(){
    $("#inputButtonGeneraHCPlantaInfo").click(function () {
        var muestraIniObject = $("#textInputMuestraInicial").val();
        var muestraFinObject = $("#textInputMuestraFinal").val();
        if(muestraIniObject != ''){
         if(muestraFinObject != ''){
        window.open("pdf/informes/hojaRutaPlanta.php?idInicio="+muestraIniObject+"&idFinal="+muestraFinObject);
        } else {
            alert('Campo Vacio o Invalido en Muestra Final');
        }
        } else {
            alert('Campo Vacio o Invalido en Muestra Inicial');
        }
   });
}

