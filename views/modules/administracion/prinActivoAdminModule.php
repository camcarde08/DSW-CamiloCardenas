<!--<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadPrinActivoAdmin(idPerfil, idUsuario);
    
    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración Principios Activos</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 400px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
       
        <div id="gridAllPrinActivosAdministracionPrinActivosEquipo"></div>
    </div>
   
</div>

<div id="windowAddPrinActivoAdministracionPrinActivo">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 200px;height:30px; float: left">Nombre del Principio Activo:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 300px;height:30px; float: left">
                <input type="text" id="inputnomPrincipioActivoAdminPrinActivo" />
            </div>
           
        </div>
        
        
        <div style="margin-top: 20px; margin-right: 50px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearPrinActivoAdminPrinActivo"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearPrinActivoAdminPrinActivo"/>
            </div>
        </div>
    </div>

</div>

<div id="notificationAdminPrinActivo">
    <span id="messageNotificationAdminPrinActivo"></span>
</div>-->

<div ng-app="regMuestraModule" ng-controller="regMuestraController as regMuestra" >
    <sgm-admin-principio-activo></sgm-admin-principio-activo>
</div>










