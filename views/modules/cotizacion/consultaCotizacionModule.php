
<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        
        initLoadCOnsultaCotizacion(idPerfil, idUsuario);
        
        

    });
   
</script>
<div ng-app="consultaCotizacionApp">
<div style="font-family: Verdana ; font-size: 10px; font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Cotizaciones FQ y Mic</h1>
</div>
<div id="gridAllCotizacionesConsultaCotizacion"></div>

<div ng-controller="gridCotizacionEstController">
    <div style="font-family: Verdana ;font-size: 10px; font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Cotizaciones Estabilidad</h1>
</div>
    <p ng-bind="prueba"></p>
   <jqx-grid jqx-settings="settings"></jqx-grid>
<!--    <jqx-button jqx-on-click="refresh()">Refresh Source</jqx-button>-->
</div>

<div id="notificationRegCotizacion">
            <span id="messageNotificationRegCotizacion"></span>
        </div>

</div>




