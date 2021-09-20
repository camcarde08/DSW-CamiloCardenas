<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadPaqueteAdmin(idPerfil, idUsuario);
    
    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de paquetes</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 480px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 350px; height: 480px; float: left">
        
        <div style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 20px;">
            <div id="gridAllPaquetesAdminPaquete"></div>
        </div>
    </div>
     <div style="border: #000 0px solid; width: 350px; height: 480px; float: left">
        
        <div style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 20px;">
            <div id="gridAllPaqueteEnsayosAdminPaquete"></div>
        </div>
    </div>
    <div style="border: #000 0px solid; width: 150px; height: 480px; float: left">
        
        <div style="margin-left: 10px; margin-top: 200px;">
            <button id="buttonAgregarEnsayosAdminPaquete"><< Agregar</button>
        </div>
        <div style="margin-left: 10px; margin-top: 20px;">
            <button id="buttonEliminarEnsayosAdminPaquete">Eliminar >></button>
        </div>
        
    </div>
    <div style="border: #000 0px solid; width: 350px; height: 480px; float: left">
        
        <div style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 20px;">
            <div id="gridEnsayosDisponiblesAdminPaquete"></div>
        </div>
    </div>
    
</div>

<div id="windowAddApaueteAdminPaquete">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Código Paquete:</div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputCodPaqueteAdminPaquete" />
            </div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Nombre del Paquete:</div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputDesPaqueteAdminPaquete" />
            </div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Área de análisis:</div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="dropDownAreaAnalisisAdminPaquete" ></div>
            </div>
        </div>
       
       
        
         
        
        
        <div style="margin-top: 20px; margin-right:20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearPaqueteAdminpaquete"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelarModalCrearPaqueteAdminpaquete"/>
            </div>
        </div>
    </div>

</div>



<div id="notificationAdminEnsayo">
    <span id="messageNotificationAdminEnsayo"></span>
</div>










