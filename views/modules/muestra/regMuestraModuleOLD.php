<!--<link rel="stylesheet" href="../../jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
<script type="text/javascript" src="../../jqwidgets/scripts/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../../jqwidgets/scripts/demos.js"></script>
<script type="text/javascript" src="../../jqwidgets/jqwidgets/jqxcore.js"></script>
<script type="text/javascript" src="../../jqwidgets/jqwidgets/jqxbuttons.js"></script>
 <script type="text/javascript" src="../../jqwidgets/jqwidgets/jqxinput.js"></script>-->







<script type="text/javascript">
    
    
    
    
    
    
   
    //Carga la grilla de ensayos
    
    
    

    $(document).ready(function () {
        
        var terceros;
        var productos1;
        var productos2;
        var coordinadores;
       
//        $("#gridEnsayo").on('bindingcomplete', function () {
//            alert('binding is completed');
//        });
        $("#submitButton3").click(function(){
            $("#nomCliente").jqxInput('val','prueba');
        });
        
        $("#submitButton4").click(function(){guardarMuestra();});

        
        
        // Create jqxnotification
        
       createJqxNotificationRespuesta();

        // Create jqxButton widgets.

        $("#submitButton1").jqxButton({width: '100', height: '20'});
        $("#submitButton2").jqxButton({width: '100'});
        $("#submitButton3").jqxButton({width: '100'});
        $("#submitButton4").jqxButton({width: '150'});
        $("#updateMuestraButton").jqxButton({width: '150', disabled: true});
        
        
        $("#buttonCrearEmpaque").jqxButton({width: '100'});
        $("#buttonCancelEmpaque").jqxButton({width: '100'});
        $("#buttonCrearEnvase").jqxButton({width: '100'});
        $("#buttonCancelEnvase").jqxButton({width: '100'});
        $("#buttonAdicionarLote").jqxButton({width: '150'});

        // Create jqxInputs widgets.

        $("#numMuestra").jqxInput({placeHolder: "numero a buscar", height: 20, width: 200, minLength: 1});
        $("#searchNumMuestra").click(function () {
            
            $("#submitButton4").jqxButton({disabled: true});
            $("#updateMuestraButton").jqxButton({disabled: false});
            //$("#numMuestra").jqxInput({disabled: true});
            var value = $('#numMuestra').val();
            
            getMuestraReferenciasById(value)
            
            $('#updateMuestraButton').on('click', function () {
                updateMuestra();
            }); 
            
           
            
                  
        });
        $("#estMuestra").jqxInput({height: 20, width: 200, minLength: 1, disabled: true});
        $("#numCotizacion").jqxInput({height: 20, width: 200, minLength: 1});
        $("#numRemision").jqxInput({height: 20, width: 200, minLength: 1});
        $("#areaContacto").jqxInput({height: 20, width: 200, minLength: 1});
        $("#numInforme").jqxInput({height: 20, width: 200, minLength: 1});
        $("#observaciones").jqxInput({height: 20, width: 500, minLength: 1});
        $("#coorAreaAnalisis").jqxInput({height: 20, width: 200, minLength: 1});
        $("#nomProducto").jqxInput({height: 20, width: 400, minLength: 1});
        $("#formFarmaceutica").jqxInput({height: 20, width: 200, minLength: 1});
        $("#tipoProducto").jqxInput({height: 20, width: 200, minLength: 1});
        $("#numFactura").jqxInput({height: 20, width: 200, minLength: 1,disabled:true});
         $("#descripcionEmpaque").jqxInput({height: 20, width: 200, minLength: 1});
        

       createJqxInputnomCliente();
       selectJqxInputnomCliente();

        



        


        $("#labSolicitante").jqxInput({height: 20, width: 200, minLength: 1});

        $("#procedencia").jqxInput({height: 20, width: 200, minLength: 1});




        var sourceProductos =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'id'},
                        {name: 'nombre'},
                        {name: 'id_formula_farma'},
                        {name: 'des_formula_farma'},
                        {name: 'tipoProducto'}
                    ],
                    url: 'model/DB/jqw/productoData.php?query=producto',
                    async: false
                };

        var pruductoAdapter = new $.jqx.dataAdapter(sourceProductos);
        pruductoAdapter.dataBind();
        productos1 = pruductoAdapter.getRecordsHierarchy('id', 'des_formula_farma');
        productos2 = pruductoAdapter.getRecordsHierarchy('id', 'tipoProducto');


        $("#nomProducto").jqxInput({source: pruductoAdapter, placeHolder: "Product Name:", displayMember: "nombre", valueMember: "id", width: 350, height: 20});
        $('#nomProducto').on('select', function () {
            
            var value = $('#nomProducto').val();
            value = value["value"];
            for (i = 0; i < productos1.length; i++) {
                if (productos1[i]["id"] == value) {
                    
                    var aux = productos1[i]["des_formula_farma"];
                    var aux2 = productos2[i]["tipoProducto"];
                    
                    $('#formFarmaceutica').val(aux);
                    $('#tipoProducto').val(aux2);
                }
                

            }
            
            
            
            
            var principiosActivosSource ={
            
                    datatype: "json",
                    datafields: [
                        { name: 'nombre', type: 'string' },
                        { name: 'principal', type: 'string' },
                        { name: 'trasador', type: 'string' }
                    ],
                    
                    id: 'nombre',
                    url: 'model/DB/jqw/PrincipioActivoData.php?query=principioActivo&producto='+value
                };
        
        
        var principiosActivosAdapter= new $.jqx.dataAdapter(principiosActivosSource);
      
        $("#gridPrincipiosActivos").jqxGrid({
                width: 700,
                columnsresize: true,
                theme: 'personal2',
                source: principiosActivosAdapter,
                autoheight: true,
                columns: [{
                    text: 'Descripción del principio activo',
                    datafield: 'nombre',
                    align: 'center',
                    cellsalign:'center',
                    width: 300
                    
                },
                {
                    text: 'Principal',
                    datafield: 'principal',
                     align: 'center',
                    cellsalign:'center',
                    width: 200
                },
                {
                    text: 'Trazador de estabilidad',
                     align: 'center',
                    cellsalign:'center',
                    datafield: 'trasador',
                    width: 200
                }]
            });
           
           
           
           //Grid Paquetes
            var idAreaAnalisis = $("#areaAnalisis").jqxDropDownList('val');
           
    
        renderEnsayoGrid(value,idAreaAnalisis);
        
         
        });

       
          
        


        // Create jqxDateTimeInput widgets.

        $("#fechaLlegada").jqxDateTimeInput({width: '220px', height: '20px', formatString: "yyyy-MM-dd HH:mm:ss"});
        var fechaLlegada = new Date();
        $("#fechaLlegada").jqxDateTimeInput({value: fechaLlegada});
        $('#fechaLlegada').on('change', function (event) {
            var prioridadActual = $("#prioridad").jqxDropDownList('getSelectedItem');

            var actualFechaLlegada = new Date($('#fechaLlegada').jqxDateTimeInput('getDate'));
            var nuevaFechaCompromiso = new Date(calcularFechaCompromiso(actualFechaLlegada, prioridadActual.label));

            $("#fechaCompromiso").jqxDateTimeInput({value: nuevaFechaCompromiso});


        });

        $("#fechaCompromiso").jqxDateTimeInput({width: '220px', height: '20px', formatString: "yyyy-MM-dd HH:mm:ss"});
        var fechaCompromiso = sumarDias(new Date(), 5);
        $("#fechaCompromiso").jqxDateTimeInput({value: fechaCompromiso});

        $("#fechaFabricacion").jqxDateTimeInput({width: '220px', height: '20px', formatString: "yyyy-MM-dd HH:mm:ss"});
        var fechaFabricacion = new Date();
        $("#fechaFabricacion").jqxDateTimeInput({value: fechaFabricacion});

        $("#fechaVencimiento").jqxDateTimeInput({width: '220px', height: '20px', formatString: "yyyy-MM-dd HH:mm:ss"});
        var fechaVencimiento = new Date();
        $("#fechaVencimiento").jqxDateTimeInput({value: fechaVencimiento});
        
        
        
        
        // Create jqxCheckBox


        $("#activa").jqxCheckBox({width: 120, height: 25, theme: 'bootstrap'});
        $('#activa').jqxCheckBox({checked: true});
        
        $("#facturarMuestra").jqxCheckBox({width: 120, height: 25, theme: 'bootstrap'});
         
         
         $('#facturarMuestra').on('change', function () {
             
             if($("#facturarMuestra").jqxCheckBox('checked')== true){
             
              $("#anticipo").jqxNumberInput({disabled: false});
              $("#descuento").jqxNumberInput({disabled: false});          
              $("#saldo").jqxNumberInput({disabled: false });
              $("#cantidad").jqxNumberInput({disabled: false});
              $("#numFactura").jqxInput({disabled: false});
              
            }else if ($("#facturarMuestra").jqxCheckBox('checked')== false){
                
              $("#anticipo").jqxNumberInput({disabled: true});
              $("#descuento").jqxNumberInput({disabled: true});          
              $("#saldo").jqxNumberInput({disabled: true });
              $("#cantidad").jqxNumberInput({disabled: true});
              $("#numFactura").jqxInput({disabled: true});
//            
         }
        });
        
         
        // Create a jqxDropDownList

        var sourcePrioridad = ["Normal", "Urgente"];
        $("#prioridad").jqxDropDownList({source: sourcePrioridad, selectedIndex: 0, width: '200', height: '20', dropDownHeight: 50});
        $('#prioridad').on('select', function (event) {
            var args = event.args;
            var item = $('#prioridad').jqxDropDownList('getItem', args.index);
            var element1 = document.getElementById('hprioridad');
            element1.value = item.label;
            var actualFechaLlegada = new Date($('#fechaLlegada').jqxDateTimeInput('getDate'));
            var nuevaFechaCompromiso = new Date(calcularFechaCompromiso(actualFechaLlegada, item.label));
            $("#fechaCompromiso").jqxDateTimeInput({value: nuevaFechaCompromiso});
        });

        var dataSourceContactoSolictante = ["contacto solicitante"];
        $("#contactoSolicitante").jqxDropDownList({disabled: true, source: dataSourceContactoSolictante, selectedIndex: 0, width: '200', height: '20', dropDownHeight: 50});
       

        var areaSource =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'id'},
                        {name: 'descripcion'},
                        {name: 'coordinador'}
                    ],
                    url: 'model/DB/jqw/AreasAnalisisData.php?query=activeAreas',
                    async: false
                };

        var areaAdapter = new $.jqx.dataAdapter(areaSource);
        $("#areaAnalisis").jqxDropDownList({source: areaAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 100});
        
        areaAdapter.dataBind();
        var coordinadores = areaAdapter.getRecordsHierarchy('id', 'coordinador');
        $("#coorAreaAnalisis").jqxInput('val', {label: coordinadores[0]['coordinador'], value: coordinadores[0]['coordinador']});

        $('#areaAnalisis').on('change', function (event) {
            var args = event.args;
            var item = args.item;

            var value = item.value;
            if (value == 4) {
                $("#duracion").jqxNumberInput({
                    disabled: false
                });
                
                $("#tipoEstabilidad").jqxDropDownList({disabled:false});
                
                
            }
            else {
                $("#duracion").jqxNumberInput({
                    
                    disabled: true
                });
                
                $("#tipoEstabilidad").jqxDropDownList({selectedIndex: -1 }); 
                $("#tipoEstabilidad").jqxDropDownList({disabled:true});
                
                
            }
            var idProducto = $("#nomProducto").val();
            idProducto = idProducto['value'];
            
            
            
            if(value != ""){
                
                var idAreaAnalisis = $("#areaAnalisis").jqxDropDownList('val');
                renderEnsayoGrid(idProducto,idAreaAnalisis);
                
            }
            
            
            if(args && coordinadores === undefined){
                
            }else{
                if(args){
                    for(i=0;i<coordinadores.length;i++){
                        if(coordinadores[i]["id"]==value){
                            
                            $("#coorAreaAnalisis").jqxInput('val', {label: coordinadores[i]['coordinador'], value: coordinadores[i]['coordinador']});
                            
                        }
                    }
                }
            }
            
        });
   


        var tipoEstabilidadSource =["Acelerada","Natural","Reconstituida"];
        var tipoEstabilidadAdapter =  new $.jqx.dataAdapter(tipoEstabilidadSource);

            $("#tipoEstabilidad").jqxDropDownList({disabled: true, source: tipoEstabilidadAdapter, selectedIndex: -1, width: '200', height: '20', dropDownHeight: 80});
            
            

        var empaqueSource =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'id'},
                        {name: 'descripcion'}
                    ],
                    url: 'model/DB/jqw/empaqueData.php?query=empaque',
                    async: false
                };

        var empaqueAdapter = new $.jqx.dataAdapter(empaqueSource);

        $("#empaque").jqxDropDownList({source: empaqueAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 200});


        $("#empaqueWindow").jqxWindow({
            height: 190,
            width: 400,
            theme: 'personal3',
            autoOpen: false,
            isModal: true,
            showCloseButton:false,
            cancelButton: $('#buttonCancelEmpaque'),
            okButton: $('#buttonCrearEmpaque'),
            position: {x: 570, y: 1000}
        });

        $('#adicionarEmpaque').click(function () {
            $("#descripcionEmpaque").val('');
            $("#empaqueWindow").jqxWindow('open');
        });
        
        $('#buttonCrearEmpaque').click(function (){
           if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4) {
              document.getElementById("contenido").innerHTML = xmlhttp.responseText;
             }
            };
            xmlhttp.open("GET", "model/DB/jqw/empaqueData.php?query=crearEmpaque&nuevoEmpaque="+$('#descripcionEmpaque').val(), true);
            xmlhttp.send(null);
            
            $("#empaque").jqxDropDownList({source: empaqueAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 200});
            
        });       
        
        
        
        var envaseSource =
                {
                    datatype: "json",
                    datafields: [
                        {name: 'id'},
                        {name: 'descripcion'}
                    ],
                    url: 'model/DB/jqw/envaseData.php?query=envase',
                    async: false
                };

        var envaseAdapter = new $.jqx.dataAdapter(envaseSource);

        $("#envase").jqxDropDownList({source: envaseAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 200});
        
        
        $("#envaseWindow").jqxWindow({
            height: 190,
            width: 400,
            theme: 'personal3',
            autoOpen: false,
            isModal: true,
            showCloseButton:false,
            cancelButton: $('#buttonCancelEnvase'),
            okButton: $('#buttonCrearEnvase'),
            position: {x: 570, y: 1000}
        });

        $('#adicionarEnvase').click(function () {
            $("#descripcionEnvase").val('');
            $("#envaseWindow").jqxWindow('open');
        });
        
        $('#buttonCrearEnvase').click(function (){

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
             if (xmlhttp.readyState == 4) {
             }
            };
            xmlhttp.open("GET", "model/DB/jqw/envaseData.php?query=crearEnvase&nuevoEnvase="+$('#descripcionEnvase').val(), true);
            xmlhttp.send(null);
            
            $("#envase").jqxDropDownList({source: envaseAdapter, displayMember: "descripcion", valueMember: "id", selectedIndex: 0, width: '200', height: '20', dropDownHeight: 200});
            
            
        });   
        // Create a jqxEditor

        $('#observaciones').jqxEditor({height: 140, width: 800, tools: "old italic underline | format font size | color background | ul ol | link | clean", theme: 'personal2'});

        // Create a jqxNumberInput     symbolPosition: 'right', symbol: '%',  spinButtons: true

        $("#duracion").jqxNumberInput({
            width: '100px',
            height: '20px',
            decimal: 1,
            spinButtons: true,
            spinMode: 'simple',
            decimalDigits: 0,
            digits: 3,
            min: 1,
            disabled: true
        });
        $("#anticipo").jqxNumberInput({
            width: '100px',
            height: '20px',
            decimal: 1,
            spinButtons: true,
            spinMode: 'simple',
            decimalDigits: 0,
            digits: 3,
            min: 0,
            symbolPosition: 'right',
            symbol: '%',
            max: 100,
            disabled: true
        });
        $("#descuento").jqxNumberInput({
            width: '100px',
            height: '20px',
            decimal: 1,
            spinButtons: true,
            spinMode: 'simple',
            decimalDigits: 0,
            digits: 3,
            min: 0,
            symbolPosition: 'right',
            symbol: '%',
            max: 100,
            disabled: true
        });
        $("#saldo").jqxNumberInput({
            width: '100px',
            height: '20px',
            decimal: 1,
            spinButtons: true,
            spinMode: 'simple',
            decimalDigits: 0,
            digits: 3,
            min: 0,
            symbolPosition: 'right',
            symbol: '%',
            max: 100,
            disabled: true
        });
        $("#cantidad").jqxNumberInput({
            width: '100px',
            height: '20px',
            decimal: 1,
            spinButtons: true,
            spinMode: 'simple',
            digits: 3,
            decimalDigits: 0,
            min: 1,
            disabled: true
        });

        //Create a jqxGrid
        
        var data = {};
       
        var sourceLote = {
            localdata: data,
            datatype: "local",
            datafields: [{
                name: 'tamanoLote',
                type: 'int'
            }, {
                name: 'numLote',
                type: 'string'
            }, {
                name: 'cantEnviadaLote',
                type: 'int'
            }]
        };
        
         var loteAdapter = new $.jqx.dataAdapter(sourceLote);
          $("#gridLotes").jqxGrid({
                width: 700,
                columnsresize: true,
                source: loteAdapter,
                editable: true,
                theme: 'personal2',
                editmode: 'click',
                selectionmode:'checkbox',
                autoheight: true,
                columns: [{
                    text: 'Tamaño de lote',
                    datafield: 'tamanoLote',
                     align: 'center',
                    width: 300
                    
                },
                {
                    text: 'Número de lote',
                     align: 'center',
                    datafield: 'numLote',
                    width: 200
                },
                {
                    text: 'Cantidad enviada por lotes',
                     align: 'center',
                    datafield: 'cantEnviadaLote',
                    width: 200
                },
                ]
            });
            
            $("#buttonAdicionarLote").on('click', function () { 
                
                $('#gridLotes').jqxGrid('addrow', 0, {});
                
                
            }); 
    });






</script>



<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 1; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Registro de Muestra</h1>
</div>
<div style="border-style: solid; border: 0; width: 100%; height: auto">


    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <form id="formRegMuestra" method="post" action="index.php?action=saveMuestra">
            <div id="encabesadoFormMuestra" style=" border-style: solid; border: 0; width: 100%; height: auto">
                <input style='margin-top: 20px;' type="button" value="Limpiar" id='submitButton1' />
                <input style='margin-top: 20px;' type="button" value="Ver Historial" id='submitButton2' />
                <input style='margin-top: 20px;' type="button" value="Ver Estados" id='submitButton3' />
                <input style='margin-top: 20px;' type="button" value="Registrar muestra" id='submitButton4' />
                <input style='margin-top: 20px;' type="button" value="Actualizar muestra" id='updateMuestraButton'disabled="true" />
            </div>
            <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                Datos Generales
            </div>

            <!--            renglon1-->
            
            <div style="border-style: solid; border-bottom: 0;border-top: 1; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Numero de muestra:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div id="numMuestra">
                        <input type="text" name="numMuestra"/>
                        <div id="searchNumMuestra"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                    </div>
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Estado actual de la muestra:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="estMuestra" type="text" name="estMuestra"/>
                </div>

            </div>

            <!--            renglon2-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Activa</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div id="activa" name="activa"></div>

                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Prioridad</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div id='prioridad'>
                    </div>
                    <input id="hprioridad" type="hidden" name="hprioridad" value="Normal"/>
                </div> 
            </div>

            <!--            renglon3-->
            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Numero de cotización:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="numCotizacion" type="text" name="numCotizacion" />
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Numero de Remisión:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="numRemision" type="text" name="numRemision" />
                </div>
            </div>

            <!--            renglon4-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Fecha llegada:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div id="fechaLlegada" name="fechaLlegada"></div>
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Fecha Compromiso:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div id="fechaCompromiso" name="fechaCompromiso"></div>
                </div>
            </div>

            <!--            renglon5-->

            <div style="height: 30px; background-color: #white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Nombre del cliente:</span>
                </div>
                <div style="width: 60%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div style="float: left">
                        <input id="nomCliente" type="text"  />
                        <input id="hnomCliente" type="hidden" name="hnomCliente" />
                    </div>
                    <div id="searchNomCliente" style="float: left; padding-top: 2px; padding-left: 10px">
                        <img alt="search" width="16" height="16" src="views/images/search_lg.png" />
                    </div>
                </div>
            </div>

            <!--            renglon6-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Contacto solicitante:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="contactoSolicitante" id="contactoSolicitante"></div>
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Area solicitante:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="areaContacto" type="text" name="areaContacto" readonly="true"/>
                </div>
            </div>

            <!--            renglon7-->

            <div style="height: 30px; background-color: #white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Laboratorio Fabricante:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="labSolicitante" type="text" name="labSolicitante">
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Procedencia:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="procedencia" type="text" name="procedencia">
                </div>
            </div>
            <!--            renglon 8-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Número de informe:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input id="numInforme" type="text" name="numInforme">
                </div>                
            </div>
            <!--            renglon9-->

            <div style="height: 150px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Observaciones:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <textarea id="observaciones" name="observaciones" ></textarea>
                </div>   
            </div>

            <!--            renglon9-->

            <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                Datos del producto
            </div>

            <!--            renglon10-->
            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Área análisis:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="areaAnalisis" id="areaAnalisis"></div>
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Tipo de estabilidad:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="tipoEstabilidad" id='tipoEstabilidad' ></div>
                </div>
            </div>

            <!--            renglon11-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Coordinador Área de análisis:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input name="coorAreaAnalisis" id="coorAreaAnalisis" type="text">
                    
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Duración:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="duracion"  id="duracion"></div>
                    <input id="hduracion" name="hduracion" type="hidden" />
                </div>
            </div>
            
            <!--            renglon12-->
            
            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Nombre del producto:</span>
                </div>
                <div style="width: 33%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input  id="nomProducto" type="text">
                    <input name="hnomProducto" id="hnomProducto" type="hidden">
                </div>                
            </div>
            <!--            renglon13-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Forma Farmacéutica:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input name="formFarmaceutica" id="formFarmaceutica" type="text">
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Tipo de producto:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input name="tipoProducto" id="tipoProducto" type="text">
                </div>
            </div>
            
            <!--            renglon14-->
            
            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Empaque:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div style="float: left"><div name="empaque" id="empaque" ></div></div>
                    <div id="adicionEmpaque" style="float: left; padding-left: 10px;padding-bottom:5px">
                        <input type="button" id="adicionarEmpaque" name="adicionarEmpaque" src="views/images/mas.jpg"/>
<!--                        <img alt="search" width="23" height="23" src="views/images/mas.jpg" />-->
                    </div>
                </div>

                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Envase:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div style="float: left"><div name="envase" id="envase" ></div></div>
                    <div id="adicionEnvase" style="float: left; padding-left: 10px;padding-bottom:5px">
                        <input type="button" id="adicionarEnvase" name="adicionarEnvase" src="views/images/mas.jpg"/>
<!--                        <img alt="search" width="23" height="23" src="views/images/mas.jpg" />-->
                    </div>
                </div>
                
            </div>
            <!--            renglon15-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Fecha de Fabricación:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="fechaFabricacion" id="fechaFabricacion"></div>
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Fecha de Vencimiento:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="fechaVencimiento" id="fechaVencimiento"></div>
                </div>
            </div>
            
            <!--            renglon16-->
            
            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Principios Activos:</span>
                </div>

            </div>
            <!--            renglon17-->

            <div style="height:auto;min-height: 30px; background-color: #bfbfff; padding-top: 5px; overflow: hidden">
                <div style="width: 80%;  padding-top: 5px;padding-bottom: 5px; padding-left: 250px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <div id="gridPrincipiosActivos" name="gridPrincipiosActivos"></div>    
                </div>
            </div>
            
            <!--            renglon18-->
            
            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Configuracion de Paquetes:</span>
                </div>

            </div>
            <!--            renglon19-->

            <div style="height:auto;min-height: 30px; background-color: #bfbfff; padding-top: 5px; overflow: hidden">
                <div style="width: 80%; margin-left: 10%; margin-right: 10%;  border-style: solid; border: 0;  ; font-family: Verdana; font-size: 13px">
                    <div id="gridEnsayo" name="gridEnsayo"></div> 
                    <input id="hensayo" name="hensayo" type="hidden" />
                </div>
            </div>
            
            <!--            renglon20-->
            
            <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                Configuración de lotes
            </div>
            
            <!--            renglon21-->            

           <div style="height:auto;min-height: 30px; background-color: white; padding-top: 5px; overflow: hidden">
                <div style="width: 80%;  padding-top: 5px;padding-bottom: 5px; padding-left: 250px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <div id="gridLotes" name="gridLotes"></div>
                    <input id="hcantidadLotes" name="hcantidadLotes" type="hidden" />
                    <input id="hlotes" name="hlotes" type="hidden" />
                    <input type="button" style="margin: 10px;" id="buttonAdicionarLote" value="Adicionar Lote" />
                </div>
            </div>
            
            <!--            renglon22-->

            <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                Datos de facturacion
            </div>

            <!--            renglon23-->

            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Facturar Muestra:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div name="facturarMuestra" id="facturarMuestra"></div>
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Cantidad:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div  id="cantidad" ></div>
                    <input id="hcantidad" name="hcantidad" type="hidden" />
                </div>
            </div>

            <!--            renglon24-->

            <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Número de Factura:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <input name="numFactura" id="numFactura" type="text" >
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Anticipo:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div  id="anticipo"  ></div>
                    <input id="hanticipo" name="hanticipo" type="hidden" />
                </div>
            </div>

            <!--            renglon25-->

            <div style="height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Descuento:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div  id="descuento" ></div>
                    <input id="hdescuento" name="hdescuento" type="hidden" />
                </div>
                <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Saldo:</span>
                </div>
                <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div  id="saldo"  ></div>
                    <input id="hsaldo" name="hsaldo" type="hidden" />
                </div>
            </div>
        </form>

<!--PopUp Empaque-->  

        <form>

            <div id='empaqueWindow'>
                <div style="background-color: transparent">
                    <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                        Crear Empaque
                    </div>


                    <div style="height: 40px; background-color: white; padding-top: 5px">
                        <div style="width: 20%; height: 20px; padding-top: 6px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                            <span >Descripción:</span>
                        </div>
                        <div style="width: 25%; padding-top: 4px; border-style: solid; border:0;  float: left ; margin-left: 30px">
                            <input name="descripcionEmpaque" id="descripcionEmpaque" type="text" >
                        </div>
                    </div>

                    <div style="height: 40px; background-color: #bfbfff;  border-radius: 0px 0px 10px 10px;border-style: solid;border: 0">
                        <div style="width: 40%;  border-style: solid; border:0;float: left;padding-left: 70px;padding-top: 8px">
                            <input  type="button" value="Crear" id='buttonCrearEmpaque' />
                        </div>
                        <div style="width: 40%; border-style: solid; border:0;  float: left ;padding-top:8px  ">
                            <input  type="button" value="Cancelar" id='buttonCancelEmpaque' />
                        </div>
                    </div>

                </div>
            </div>

               
        </form>


<!--PopUp Envase-->  

        <form>

            <div id='envaseWindow'>
                <div style="background-color: transparent">
                    <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                        Crear Envase
                    </div>


                    <div style="height: 40px; background-color: white; padding-top: 5px">
                        <div style="width: 20%; height: 20px; padding-top: 6px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                            <span >Descripción:</span>
                        </div>
                        <div style="width: 25%; padding-top: 4px; border-style: solid; border:0;  float: left ; margin-left: 30px">
                            <input name="descripcionEnvase" id="descripcionEnvase" type="text" >
                        </div>
                    </div>

                    <div style="height: 40px; background-color: #bfbfff;  border-radius: 0px 0px 10px 10px;border-style: solid;border: 0">
                        <div style="width: 40%;  border-style: solid; border:0;float: left;padding-left: 70px;padding-top: 8px">
                            <input  type="button" value="Crear" id='buttonCrearEnvase' />
                        </div>
                        <div style="width: 40%; border-style: solid; border:0;  float: left ;padding-top:8px  ">
                            <input  type="button" value="Cancelar" id='buttonCancelEnvase' />
                        </div>
                    </div>

                </div>
            </div>

               
        </form>

<div id="respuesta">test</div>

    </div>   
</div>



