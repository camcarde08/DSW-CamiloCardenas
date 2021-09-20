<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadMetodoAdmin(idPerfil, idUsuario);
    
    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de Métodos</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 370px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
        
        <div id="gridAllMetodolAdminMetodo"></div>
    </div>
</div>

<div id="windowAddGridAdminMetodo">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Nombre:</div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputNombreMetodoAdminMetodo" />
            </div>
           </div>
<!--       <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Activo:</div>
            
        </div>-->
<!--        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputActivoMetodoAdminMetodo" />
            </div>
           </div>
               
    
        -->
          <div style="margin-top: 20px; margin-right:20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearMetodoAdminMetodo"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearMetodoAdminMetodo"/>
            </div>
        </div>
    </div>

</div>

<div id="notificationAdminMetodo">
    <span id="messageNotificationAdminMetodo"></span>
</div>






