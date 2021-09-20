function initialInformeStikers() {
    $("#textInputCantidad").val(1);
    eventButtonClickChargeGenerarStikersPDF();
}

function eventButtonClickChargeGenerarStikersPDF() {
    $("#inputButtonGeneraStikerInfo").click(function () {
        var muestraIniObject = $("#textInputMuestraInicial").val();
        var muestraFinObject = $("#textInputMuestraFinal").val();
        var cantidadObject = $("#textInputCantidad").val();
        if (muestraIniObject != '') {
            if (muestraFinObject != '' && cantidadObject != '') {
                window.open("pdf/informes/stikers.php?idInicio=" + muestraIniObject
                        + "&idFinal=" + muestraFinObject
                        + "&cantidad=" + cantidadObject);
            } else {
                alert('Campo Vacio o Invalido en Muestra Final');
            }
        } else {
            alert('Campo Vacio o Invalido en Muestra Inicial');
        }
    });
}

