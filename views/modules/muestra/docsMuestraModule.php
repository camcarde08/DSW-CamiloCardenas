<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadDocsMuestra(idPerfil, idUsuario);

    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Módulo Adjuntar y/o Eliminar Documentos</h2>
</div>
<div style="border:0; border-style: solid; width: 100%; height: 380px">
    <div style=" border: #000 0 solid; width: 100%; height: 300px">
        <div style="width: 420px; border: #000 0 solid; height: 100%; background-color: white; padding-top: 5px; float: left">
            <div style="width: 500px; border: #000 0 solid; height: 30px; background-color: white; padding-top: 5px">
                <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                    <span >Número de análisis:</span>
                </div>
                <div style="width: 200px; padding-top: 3px; border-style: solid; border:0;  float: left">
                    <div id="inputNumMuestraDocsMuestra">
                        <input type="text" name="numMuestra" value="<?php echo $_SESSION['systemsParameters']['defaultSearchText']; ?>"/>
                        <div id="searchNumMuestraConHojaRutaMuestra"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                    </div>
                </div>
                <div style="width: 50px; padding-top: 3px; border-style: solid; border:0;  float: left"> 
                    <input type="button" name="clearButton" id="buttonClearDocsMuestra" value="Limpiar" />
                </div>
            </div>
            <div style="width: 500px; border: #000 0 solid; height: 30px; background-color: white; padding-top: 5px">
                <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
                    <h3>Adjuntar archivos</h3>
                </div>
                <div id="fileUploadDocsMuestra333"></div>
            </div>



        </div>
        <div style="width: 650px; border:0; border-style: solid;  height: 350px; background-color: white; float: left; padding-top: 12px">

            <div style="width: 410px; border:0; border-style: solid; height: 100%; background-color: white; float: left; margin-left: 20px;">
                <div id="treeDocsMuestra"></div>
            </div>
            <div style="width: 120px; border:0; border-style: solid; height: auto; background-color: white; padding-top: 5px; float: left">
                <div>
                    <input id="buttonCrearCarpetaDocsMuestra" type="button" value="Crear carpeta" />
                    <br>
                    <br>
                    <input id="buttonEliminarArchivoDocsMuestra" type="button" value="Eliminar archivo" />
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalCreateNewFolder">
    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; margin-top: 15px;">
        <div style="float: left">
            <img src="views/images/notificacion.png"> 
        </div>
        <div style="float: left; margin-top: 20px; margin-left: 20px;">
            Nombre:
            <input style="margin-left: 5px" id="inputNombreNuevaCarpetaDocsMuestra"type="text" />
        </div>
        <div style="float: left; margin-top: 20px; margin-left: 20px;">
            <input id="buttonAceptarNewFolderDocsMuestra"type="button" value="Aceptar" />
        </div>

    </div>

</div>

<div id="notificationDocsMuestra">
    <span id="messageNotificationDocsMuestra"></span>
</div>






