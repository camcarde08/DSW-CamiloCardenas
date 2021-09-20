<script type="text/javascript">
    $(document).ready(function () {
        initialLoadRepoDocs();

    });
</script>

<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Repositorio de Documentos Antiguos.</h1>
</div>
<div style="border-style: solid; border: 0; width: 100%; height: auto; overflow: hidden" >
    <div style="border-style: solid; border: 0; width: 600px; height: auto;margin-left: 30px;float: left">

        <div id='treePrincipalRepoDocs'></div>


    </div>
    <div style="border-style: solid; border: 0; width: 200px; height: auto;margin-left: 10px;float: left">
        <div>
            <input id="buttonConfRepoRepoDocs" type="button" value="Configurar repositorio"/>
        </div>
        <div style="margin-top: 10px">
            <div id="inputSearchRepoDocs">
                <input type="text"/>
                <div id="buttonSearchRepoDocs"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
            </div>
        </div>
        <div id="divGridSearchResultRepoDocs" style="width: 500px; height: 300px; margin-top: 10px;border-style: solid; border: 0">
            
            <div id="gridSearchResultRepoDocs"></div>
        </div>
        
        
    </div>
    
</div>


<div id="windowCrearCarpetaRepoDocs">
    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%">

        <div style="padding-left: 10px; padding-top: 5px; font-family: Verdana; border-style: solid; border: 0; width: 160px; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%; float: left">
            Nombre de Nueva Carpeta: 
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; border-style: solid; border: 0; width: 100px; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%; float: left">
            <input id="inputNombreNuevacarpetaCerarCarpetaRepoDocs" type="text" />
        </div>
        <div style="float: left; width: 100%">
        <div style="padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 100; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%; float: right">
            <input id="buttonOKCrearCarpetaRepoDocs" type="button" value="Aceptar" />
        </div>
            <div style="padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 100; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%; float: right">
            <input id="buttonCancelarCrearCarpetaRepoDocs" type="button" value="Cancelar" />
        </div>
            </div>
    </div>

</div>

<div id="windowConfRepoRepoDocs">
    <div style="font-family: Verdana ; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%">
        <div style="width: 100%">
            <p>Seleccione la carpeta para el repositorio:</p>
            <div style="width: auto; float: left">
                <div id='treeConfRepoRepoDocs'></div>
            </div>
            <div style="width: 80px; margin-left: 10px; float: left">
                <div style="padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 100%; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                    <input id="buttonOKConfRepoRepoDocs" type="button" value="Aceptar" />
                </div>
                <div style="padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 100%; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                    <input id="buttonCancelarConfRepoRepoDocs" type="button" value="Cancelar" />
                </div>
            </div>
        </div>
    </div>

</div>

<div id="notificationRepoDocs">
    <span id="messageNotificationRepoDocs"></span>
</div>

<div id='menuContextPrincipalTreeRepoDocs'>
    <ul>
        
        <li id="liCrearCarpetaMenuContextPrincipalTreeRepoDocs">Crear carpeta</li>
        <li id="liSubirArchivoMenuContextPrincipalTreeRepoDocs">Subir Archivo</li>
        
        <li id="liEliminarMenuContextPrincipalTreeRepoDocs">Eliminar</li>
        
    </ul>
</div>

<div id="windowUploadFileRepoDocs">
    <div>
        Seleccione sus documentos.
        <div id="uploadFileRepoDocs"></div>
    </div>
</div>

<div id="windowDeleteFileRepoDocs">
    <div>
        <div id="windowDeleteFileRepoDocsTextConfirmation"></div>
        <br>
        <div style="width: 90%; margin-left: 10px">
            <div style="float: right;padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 20%; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0px">
                <input id="buttonOKwindowDeleteFileRepoDocs" type="button" value="Aceptar" />
            </div>
            <div style="float: right; padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 20%; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 20px">
                <input id="buttonCancelarwindowDeleteFileRepoDocs" type="button" value="Cancelar" />
            </div>
        </div>
    </div>
</div>


