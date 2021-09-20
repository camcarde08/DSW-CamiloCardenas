 function initialInformeDisponibilidadUsuarios(){
    loadInputAnalistaNombre();
    //events
    eventButtonClickChargeAnalistaInfoPDF();
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
        placeHolder: "Nombre de Analista a Consultar", 
        height: 25, 
        width: 300, 
        minLength: 1, 
        source:dataAdapterAnalistas,
        displayMember: "nombre", 
        valueMember: "id"
    });
}
function eventButtonClickChargeAnalistaInfoPDF(){
    $("#inputButtonChargeAnalistaInfo").click(function () {
       
        var analistaObject = $("#inputAnalistaNombre").jqxInput('val');
        if(analistaObject.value != null){
        $idUsuario = analistaObject.value;
        window.open("pdf/informes/disponibilidadUsuarios.php?idUsuario="+$idUsuario);
        } else {
            alert('Analista a Consultar Invalido');
        }
   });
}
