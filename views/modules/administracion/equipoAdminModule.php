<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadEquipoAdmin(idPerfil, idUsuario);
    
    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de equipos</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 400px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
         <div id="gridAllEquiposAdministracionEquipo"></div>
    </div>
   
</div>

<div id="windowAddEquipoAdministracionEquipo">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 120px;height:30px; float: left">Código:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input type="text" id="inputCodInventarioAdminEquipo" />
            </div>
            <div style="padding-top: 10px;border-style: solid; border:0; width: 90px;height:30px; float: left">Modelo:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 220px;height:30px; float: left">
                <input type="text" id="inputModeloAdminEquipo" />
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 15px; border-style: solid; border:0; width: 120px;height:30px; float: left">Serie:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="inputSerieAdminEquipo" type="text" />
            </div>
            <div style="padding-top: 15px;border-style: solid; border:0; width: 80px;height:30px; float: left">Referencia:</div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 220px;height:30px; float: left">
                <input id="inputReferenciaAdminEquipo" type="text" />
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 15px; border-style: solid; border:0; width: 120px;height:30px; float: left">Descripción:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="inputDescripcionAdminEquipo" type="text" />
            </div>
            <div style="padding-top: 10px;border-style: solid; border:0; width: 80px;height:30px; float: left">Marca:</div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 220px;height:30px; float: left">
                <input id="inputMarcaAdminEquipo" type="text" />
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 120px;height:30px; float: left">Prov. Mantenimiento:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="inputProvMantenimientoAdminEquipo" type="text" />
            </div>
            <div style="padding-top: 0px;border-style: solid; border:0; width: 80px;height:30px; float: left">Prov. Calibración:</div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 220px;height:30px; float: left">
                <input id="inputProvCalibracionAdminEquipo" type="text" />
            </div>
        </div>
         
        
        
        <div style="margin-top: 40px; margin-right: 50px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearEquipoAdminEquipo"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearEquipoAdminEquipo"/>
            </div>
        </div>
    </div>

</div>

<div id="notificationAdminEquipo">
    <span id="messageNotificationAdminEquipo"></span>
</div>









