<?php
if (isset($_GET['idMuestra'])) {
    $idMuestra = $_GET['idMuestra'];
} else {
    $idMuestra = $_SESSION['systemsParameters']['defaultSearchText'];
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initialLoadHistoricoEstadosMuestra(idPerfil, idUsuario);

    });
</script>



<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Histórico de estados</h1>
</div>
<div style="border-style: solid; border: 0; width: 100%; height: auto">
    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Análisis a Consultar
        </div>
        <!--            renglon1-->
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Número de Análisis:</span>
            </div>
            <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="inputNumMuestraHistoricoEstadosMuestra">
                    <input type="text" name="numMuestra" value="<?php echo $idMuestra; ?>"/>
                    <div id="buttonSearchNumMuestraHistoricoEstadosMuestra"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                </div>
            </div>
            <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left"> 
                <input type="button"  id="buttonClearHistoricoEstadosMuestra" value="Limpiar" />
            </div>
        </div>
        <!--            renglon1-->
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Historial de Almacenamiento
        </div>
        <!--            renglon2-->
        <div style="height: 30px; background-color: white; padding-top: 5px">
            <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; width: 80%; margin-left: 20%; margin-right: 20; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <h2>Histórico de Estados</h2>
            </div>
        </div>
    </div>

    <div style="height: 30px; background-color: white; padding-top: 50px">
        <div style="font-family: Verdana ;  color: #000087; width: 80%; margin-left: 20%; margin-right: 20; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
            <span>Producto: </span>
            <span type="text" disabled="true" id="nombreProducto"></span>
        </div>
    </div>

    <div style="height: 300px; background-color: white; padding-top: 5px; width: 80%; margin-left: 20%; margin-right: 20%">
        <br>
        <div style="width: 100%; height: 20px; padding-top: 20px; padding-left: 10px; border-style: solid; border: 0; font-family: Verdana; font-size: 13px;">
            <div id="gridHistoricoEstadosMuestra"></div>

            <form action="pdf/informes/informeAnalisis.php" method="POST" target="view" id="formEnvio">
                <input name="idMuestra" id="idMuestraHiden" type="hidden"/>
                <input name="idPerfil" id="idPerfilHiden" type="hidden"/>
                <input style='margin-top: 20px;' type="button" value="Imprimir Informe" id='buttonImprimirInformeMuestra'  />
            </form>
        </div>

    </div>
    <div id="divEstadosSubMuestra" style="display: none;">
        <div style="height: 30px; background-color: white; padding-top: 5px">
            <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; width: 80%; margin-left: 20%; margin-right: 20; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <h2>Histórico de Estados Sub Muestras</h2>
            </div>
        </div>
        <div style="height: 300px; background-color: white; padding-top: 5px; width: 80%; margin-left: 20%; margin-right: 20%">
            <br>
            <div style="width: 100%; height: 20px; padding-top: 20px; padding-left: 10px; border-style: solid; border: 0; font-family: Verdana; font-size: 13px;">
                <div id="gridHistoricoEstadosSubMuestra"></div>
            </div>

        </div>
    </div>
</div>
</div>


