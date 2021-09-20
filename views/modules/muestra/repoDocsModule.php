<!--<script type="text/javascript">
    $(document).ready(function () {
        initialLoadRepoDocs();

    });
</script>-->
<link rel="stylesheet" href="views/css/styleRepoDocs.css">
<div ng-app="repoDocs">
    <div ng-controller="repoDocsController">
        <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%">
            <h1>Repositorio de Documentos Antiguos</h1>
        </div>
        <div style="border-style: solid; border: 0; width: 100%; height: 320px; overflow: hidden" >
            <div style="border-style: solid; border: 0; width: 400px; height: auto;margin-left: 10px; margin-top: 50px;float: left">
                <div>

                </div>
                <div>
                    <jqx-button jqx-on-click="repositorio.configurarRepositorio(event)" id="buttonConfRepoRepoDocs" jqx-width="200" jqx-height="25">Configurar Repositorio</jqx-button>
                </div>
                <div style="margin-top: 15px; font-family: Verdana ;font-weight:bolder; font-size: 12px;  color: #000087;">
                    Crear nueva carpeta:
                </div>
                <div style="margin-top: 10px; overflow: hidden">
                    <jqx-input style="float: left" ng-model="crearCarpeta.nombreNuevaCarpeta" FileUpload jqx-height="25" jqx-place-holder="'Nombre de la carpeta'"></jqx-input>
                    <jqx-button style="float: left; margin-left: 10px" ng-click="crearCarpeta.crear(event)" jqx-width="75" jqx-height="27">Crear</jqx-button>
                </div>
                <div style="margin-top: 15px; font-family: Verdana ;font-weight:bolder; font-size: 12px;  color: #000087;">
                    Subir Archivo:
                </div>
                <div style="margin-top: 10px; overflow: hidden">

                    <jqx-file-upload jqx-settings="fileUpload.settings" jqx-on-upload-start="fileUpload.events.uploadStart(event)" jqx-on-upload-end="fileUpload.events.uploadEnd(event)" jqx-watch-settings></jqx-file-upload>
                </div>
                
            </div>
            <div style="border-style: solid; border: 0; width: 800px; height: 100%;float: left">
                <div style="float: left">
                    <img style="cursor: pointer" ng-click="functions.clickSearchIcon()"  ng-src="views/images/search_lg.png" width="20px" height="20px"  />
                </div>
                <div id="myModal" class="modal" ng-style="{display :searchModal}">
                    <div class="modal-content">
                        <div class="modal-header">
                            <span class="close" ng-click="functions.closeModal()">×</span>
                            <h2>Busqueda de archivos</h2>
                        </div>
                        <div class="modal-body">
                            <div id="gridSearchResultRepoDocs"></div>
                        </div>
                    </div>
                </div>
                <div style="margin-left: 20px;border-style: solid; border: 0; width: 90%; height: 30px;float: left;font-family: Verdana ;font-weight:bolder; font-size: 12px;  color: #000087;" ng-bind="nombreMostrar">

                </div>
                <div style=" position: relative;border-style: solid; border: 0; width: 98%; height: 98%;float: left; overflow: scroll">
                    <table ng-show="repositorio.show">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="tr-repo" ng-if="repositorio.isShow(repositorio.dataCurrentParent.id)">
                                <td class="td-nombre"><a class="nombreCarpeta"  href="" ng-click="functions.link(repositorio.dataCurrentParent)" >{{ ".."}}</a></td>
                                <td class="td-acciones"> </td>
                            </tr>
                            <tr class="tr-repo" ng-repeat="data in repositorio.dataCurrentChilds| orderBy : ['-esCarpeta', 'nombre'] track by data.id" >
                                <td class="td-nombre"><a ng-class="{nombreCarpeta:data.esCarpeta,nombreArchivo: !data.esCarpeta}" href="#" ng-click="functions.link(data)">{{data.nombre}}</a></td>
                                <td class="td-acciones" align="center">  

                                    <div>
                                        <img style="cursor: pointer" ng-click="functions.eliminarPath(data)"  ng-src="views/images/papelera.png" width="20px" height="20px"  />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div ng-show="loader.show"  style="position: absolute;left: 250px;top: 40px;z-index: 10000;">
                        <img   ng-src="views/images/circle-loading-animation.gif" width="200px" height="200px"  />
                    </div>
                </div>
            </div>

        </div>

        <jqx-window id="windowConfRepoRepoDocs" jqx-settings="windowConfRepoRepoDocs.settings" jqx-on-close="windowConfRepoRepoDocs.events.close()">
            <div style="font-family: Verdana ; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 10px; margin-left: 0%; margin-right: 0%">
                <div style="width: 100%">
                    <p>Seleccione la carpeta para el repositorio:</p>
                    <div style="width: auto; float: left">
                        <jqx-tree   jqx-settings="treeConfRepoRepoDocs.settings"  jqx-create="treeConfRepoRepoDocs.settings"></jqx-tree>
                    </div>
                    <div style="width: 80px; margin-left: 10px; float: left">
                        <div style="padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 100%; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                            <jqx-button id="buttonOKConfRepoRepoDocs" jqx-width="75" jqx-height="25">Aceptar</jqx-button>
                        </div>
                        <div style="padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; width: 100%; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                            <jqx-button id="buttonCancelarConfRepoRepoDocs" jqx-width="75" jqx-height="25">Cancelar</jqx-button>
                        </div>
                    </div>
                </div>
            </div>
        </jqx-window>






        <!--<div id="windowConfRepoRepoDocs">
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
        </div>-->


    </div>
</div>