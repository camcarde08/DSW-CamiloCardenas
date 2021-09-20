<script>
<?php
if (isset($_GET['idEstCotizacion'])) {
    $idEstCotizacion = $_GET['idEstCotizacion'];
} else {
    $idEstCotizacion = "''";
}
?>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        var idCotizacion = <?php echo $idEstCotizacion; ?>;

        initLoadRegEstCotizacion(idPerfil, idUsuario, idCotizacion);
        
        if(idCotizacion != ""){
            $("#numCotizacionRegEstCotizacion").jqxInput("val", idCotizacion);
            ajaxSearchEstCotizacionById2(idCotizacion);
            
    }
    
       
    
        
        
        
        
            
        

    });

</script>
<div ng-app="regEstCotizacionModuleApp">
    <div ng-controller="regEstCotizacionModuleController">
        <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
            <h1>Registro de Cotización de Estabilidad</h1>
            <form name="tt" id="formulario33" method="post" action="index.php?action=saveMuestra">
                <input id="ensayosRegCotizacion" type="hidden" name="ensayos" />
            </form>

        </div>
        <div style="border-style: solid; border: 0; width: 100%; height: auto">


            <div style="border-style: solid; border: 0; width: 100%; height: auto">

                <div id="encabesadoFormMuestra" style=" border-style: solid; border: 0; width: 100%; height: auto">


                    <input style='margin-top: 20px;' type="button" value="Registrar Cot." id='buttonRegistrarRegEstCotizacion' />
                    <input style='margin-top: 20px;' type="button" value="Limpiar" id='buttonLimpiarRegEstCotizacion'/>
                    <jqx-button id="buttonUpdateCotizacionRegCotizacion" ng-click="buttonActualizarCot.events.click()" jqx-settings="buttonActualizarCot.settings" jqx-watch-settings>Actualizar</jqx-button>
                    <jqx-button id="buttonEnviarCotizacionRegCotizacion" ng-click="buttonEnviarCotizacionRegCotizacion.events.click(event)" jqx-settings="buttonEnviarCotizacionRegCotizacion.settings">{{buttonEnviarCotizacionRegCotizacion.label}}</jqx-button>
                    <jqx-button id="buttonConsultaEnviosRegEstCotizacion" ng-click="buttonConsultaEnvios.events.click(event)" jqx-settings="buttonConsultaEnvios.settings">{{buttonConsultaEnvios.label}}</jqx-button>
                    <input style='margin-top: 20px;' type="button" value="Generar Muestra" id='buttonGenerarMuestraRegEstCotizacion'disabled="true" />
                    <input style='margin-top: 20px;' type="button" value="Imprimir" id='buttonImprimirEstCotizacion'disabled="true" />
                    <jqx-button id="buttonRechazarEstCotizacion" jqx-on.click="buttonRechazarEstCot.events.click()" jqx-settings="buttonRechazarEstCot.settings">Rechazar Cot.</jqx-button>
                </div>
                <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                    Datos Generales
                </div>

                <!--            renglon1-->

                <div style="border-style: solid; border-bottom: 0;border-top: 1; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Numero de cotización:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id="numCotizacionRegEstCotizacion" >
                            <input type="text" ng-model="inputNumeroCotizacion.model"  name="numCotizacion" value="<?php echo $idEstCotizacion; ?> "/>
                            <div id="searchNumEstCotizacion"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                        </div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Estado cotizacion:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="estadoRegEstCotizacion"/>
                    </div>

                </div>

                <!--            renglon2-->

                <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Fecha solicitud:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='fechaSolicitudRegEstCotizacion'></div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Fecha compromiso:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='fechaCompromisoRegEstCotizacion'></div>
                    </div> 
                </div>

                <!--            renglon3-->
                <div style="height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Nombre de cliente:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="nombreClienteRegEstCotizacion" type="text"  />
                    </div>
                </div>

                <!--            renglon4-->

                <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Nombre Contacto:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="nomContactoRegEstCotizacion" type="text"  />
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Tel. Contacto:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="telContactoRegEstCotizacion" type="text"  />
                    </div>
                </div>

                <!--            renglon5-->

                <div style="height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Producto:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="inputProductoRegEstCotizacion" type="text"  />
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Tipo estabilidad:</span>
                    </div>
                    <div style="width: 25%; padding-top: 0px; border-style: solid; border:0;  float: left">
                        <div id="dropDownTipoEstabilidadRegEstCotizacion"></div>
                    </div>
                </div>

                <!--            renglon6-->

                <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Tiempos:</span>
                    </div>
                    <div style="width: 25%; padding-top: 0px; border-style: solid; border:0;  float: left">
                        <div id="dropDownTiemposRegEstCotizacion" type="text"></div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span ></span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div style='margin-top: 10px; overflow: hidden;' id='jqxProgressBar'></div>
                    </div>
                </div>
                <div style="height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Aplica Iva:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='CheckBoxAplicaIvaRegEstCotizacion' style='margin-left: 10px; float: left;'> </div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Aplica Retención:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='CheckBoxAplicaRetencionRegEstCotizacion' style='margin-left: 10px; float: left;'> </div>
                    </div>
                </div>


                <div style="height: 150px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Observaciones Iniciales:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <textarea id="observacionesRegEstCotizacion" ></textarea>
                    </div>   
                </div>

                <div style="height: 150px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Requisitos:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <textarea id="observaciones2RegEstCotizacion" ></textarea>
                    </div>   
                </div>


                <div style="height: 150px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Observaciones Finales:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <textarea id="observaciones3RegEstCotizacion" ></textarea>
                    </div>   
                </div>

                <!--            renglon9-->

                <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                    Productos y ensayos 
                    <input style='margin-left: 10px;' type="button" value="Generar Ensayos" id='buttonGenerarEnsayosRegEstCotizacion' />
                </div>

                <div id="gridProductosEnsayosRegEstCotizacion"></div>
                <input id="hDataGridProductosEnsayosRegEstCotizacion" name="hensayos" type="hidden" />
                <div id="notificationRegEstCotizacion">
                    <span id="messageNotificationRegEstCotizacion"></span>
                </div>

                <div id="windowLoadTiemposRegEstCotizacion">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; margin-top: 20px; margin-left: 20px">
                        <div align="center" style="padding-bottom: 25px">Cargando Tiempos</div>
                        <div align="center"><img src="views/images/load.gif"  /></div>
                    </div>
                </div>

                <jqx-window jqx-settings="windowEnviarEnsayoRegEstCotizacion.settings" jqx-on-close="windowEnviarEnsayoRegEstCotizacion.events.close()" >
                    <div style="font-family: Verdana ;font-weight:bold ; font-size: 12px; margin-top: 20px; margin-left: 20px">
                        <div>Destino: <jqx-input style="margin-left: 20px" ng-model="inputDestinoRegEstCotizacion.model" jqx-settings="inputDestinoRegEstCotizacion.settings"  id="inputDestinoRegEstCotizacion"/></div>
                        <div style="margin-top: 20px">Medio: <jqx-input style="margin-left: 30px" ng-model="inputMedioRegEstCotizacion.model" jqx-settings="inputMedioRegEstCotizacion.settings" id="inputMedioRegEstCotizacion"/></div>
                        <div style="margin-top: 20px">Observaciones: </div>
                        <div style="margin-top: 20px"><jqx-editor id="editorObservacioneswindowEnviarEnsayoRegEstCotizacion"  ng-model="textAreaObservacionesEnvioRegEstCotizacion.model" jqx-settings="textAreaObservacionesEnvioRegEstCotizacion.settings" jqx-create="textAreaObservacionesEnvioRegEstCotizacion.settings" ></jqx-editor></div>
                        <div style="margin-top: 20px; margin-right: 20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                                <jqx-button id="buttonOKwindowEnviarEnsayoRegEstCotizacion" jqx-width="150" >Aceptar</jqx-button>
                            </div>
                            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                                <jqx-button id="buttonCancelwindowEnviarEnsayoRegEstCotizacion" jqx-width="150" >Cancelar</jqx-button>
                            </div>
                        </div>
                    </div>
                </jqx-window>
                
                <jqx-window jqx-settings="windowConsultaEnviosRegEstCotizacion.settings" jqx-watch="[windowConsultaEnviosRegEstCotizacion.settings.title]">
                    <div style="font-family: Verdana ;font-weight:bold ; font-size: 12px; margin-top: 20px; margin-left: 20px">
                         <jqx-grid jqx-settings="gridEnviosEstCotizacion.settings" jqx-create="gridEnviosEstCotizacion.settings"></jqx-grid>
                    </div>
                </jqx-window>
            </div>  
        </div>
        <jqx-window  jqx-settings="windowrechazarCot.settings" jqx-on-close="windowrechazarCot.events.close(event)">
            <div style="font-family: Verdana ; border-style: solid; border: 0; width: 100%; height: 60px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                <div style="width: 100%">
                    <p>Digite el motivo de rechazo:</p>
                    <div style="width: auto;">
                        <jqx-editor id="editorRechazoCotRegCotizacion" ng-model="editorMotivoRechazo.model"   jqx-settings="editorMotivoRechazo.settings"  jqx-create="editorMotivoRechazo.settings"></jqx-editor>
                    </div>
                    <div style="overflow: hidden; width: 400px; margin-left: 10px; margin-top: 10px; border-style: solid; border: 0;">
                        <div style=" float: right; font-family: Verdana; border-style: solid; border: 0; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                            <jqx-button id="buttonOKRechazarCotRegCotizacion" jqx-width="75" jqx-height="25">Aceptar</jqx-button>
                        </div>
                        <div style="float: right; padding-right: 10px; font-family: Verdana; border-style: solid; border: 0; height: 40px; margin-top: 0px; margin-left: 0%; margin-right: 0%">
                            <jqx-button id="buttonCancelarRechazarCotRegCotizacion" jqx-width="75" jqx-height="25">Cancelar</jqx-button>
                        </div>
                    </div>
                </div>
            </div>
        </jqx-window>
    </div>
</div>
