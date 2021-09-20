<?php
if (isset($_GET['idCotizacion'])) {
    $idCotizacion = $_GET['idCotizacion'];
} else {
    $idCotizacion = "";
}
?>
<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;

        initLoadRegCotizacion(idPerfil, idUsuario);
        
        var idCotizacion = $("#numCotizacionRegCotizacion").jqxInput('val');
        if (idCotizacion !== '') {
            ajaxSearchCotizacionByIdRegCot(idCotizacion);
        }



    });

</script>
<div ng-app="regCotizacionApp">
    <div id="divRegCotizacionController" ng-controller="recotizacionController">
        <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
            <h1>Registro de Cotización</h1>
            <form name="tt" id="formulario33" method="post" action="index.php?action=saveMuestra">


                <input id="ensayosRegCotizacion" type="hidden" name="ensayos" />
            </form>

        </div>
        <div style="border-style: solid; border: 0; width: 100%; height: auto">


            <div style="border-style: solid; border: 0; width: 100%; height: auto">

                <div id="encabesadoFormMuestra" style=" border-style: solid; border: 0; width: 100%; height: auto">


                    <input style='margin-top: 20px;' type="button" value="Registrar Cot." id='buttonRegistrarRegCotizacion' />
                    <input style='margin-top: 20px;' type="button" value="Limpiar" id='buttonLimpiarRegCotizacion'/>
                    <input style='margin-top: 20px;' type="button" value="Actualizar Cot." id='buttonUpdateCotizacionRegCotizacion'  />
                    <input style='margin-top: 20px;' type="button" value="Enviar Cot." id='buttonEnviarCotizacionRegCotizacion'disabled="true" />
                    <input style='margin-top: 20px;' type="button" value="Consultar Envíos" id='buttonconsultaEnvioRegCotizacion'disabled="true" />
                    <input style='margin-top: 20px;' type="button" value="Generar Muestra" id='buttonGenerarMuestraRegCotizacion'disabled="true" />
                    <input style='margin-top: 20px;' type="button" value="Imprimir Cotización" id='buttonImprimirCotizacion'disabled="true" />
                    <jqx-button jqx-width="130" jqx-height="25" jqx-disabled="buttonRechazarCotizacion.disabled" jqx-on-click="buttonRechazarCotizacion.events.click()" jqx-watch-settings>Rechazar Cot.</jqx-button>
                </div>
                <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                    Datos Generales de la Cotización
                </div>

                <!--            renglon1-->

                <div style="border-style: solid; border-bottom: 0;border-top: 1; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Número de Cotización:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id="numCotizacionRegCotizacion">
                            <input type="text" name="numCotizacion" value="<?php echo $idCotizacion; ?>" />
                            <div id="searchNumCotizacion"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                        </div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Estado de Cotización:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id="estadoRegCotizacion"> </div>
                    </div>

                </div>

                <!--            renglon2-->

                <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Fecha de Solicitud:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='fechaSolicitudRegCotizacion'></div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Fecha de Compromiso:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='fechaCompromisoRegCotizacion'></div>
                    </div> 
                </div>

                <!--            renglon3-->
                <div style="height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Nombre de Cliente:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="nombreClienteRegCotizacion" type="text"  />
                    </div>
                </div>

                <!--            renglon4-->

                <div style="height: 30px; background-color: #bfbfff; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Nombre del Contacto:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="nomContactoRegCotizacion" type="text"  />
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Teléfono del Contacto:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input id="telContactoRegCotizacion" type="text"  />
                    </div>
                </div>
                <!--            renglon5-->
                <div style="height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Aplica Iva:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='CheckBoxAplicaIvaRegCotizacion' style='margin-left: 10px; float: left;'> </div>
                    </div>
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Aplica Retención:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id='CheckBoxAplicaRetencionRegCotizacion' style='margin-left: 10px; float: left;'> </div>
                    </div>
                </div>

                <div style="height: 150px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Observaciones Iniciales:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <textarea id="observacionesRegCotizacion" ></textarea>
                    </div>   
                </div>
                <div style="height: 150px; background-color: white; padding-top: 5px">
                    <div style="width: 20%; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span >Observaciones Finales:</span>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <textarea id="observacionesRegCotizacionFin" ></textarea>
                    </div>   
                </div>

                <!--            renglon9-->

                <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                    Productos y Ensayos
                </div>

                <div id="gridProductosEnsayosRegCotizacion"></div>

                <div id="windowAddGridProductosEnsayosRegCotizacion">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; font-size: 12px; margin-top: 20px; margin-left: 20px">
                        <div>Producto: <input type="text" id="inputAddProductoRegCotizacion"/></div>
                        <div style="margin-top: 10px"><div style="float: left; margin-right: 5px;margin-top: 5px">Area Analisis:</div> <div id="dropDownListAreaAnalisisAddProductoRegCotizacion"></div></div>
                        <div style="margin-top: 20px; margin-right: 20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                                <input type="button" value="Agregar" id="buttonOKWindowAddGridProductosEnsayosRegCotizacion"/>
                            </div>
                            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                                <input type="button" value="Cancelar" id="buttonCancelWindowAddGridProductosEnsayosRegCotizacion"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="windowDeleteGridProductosEnsayosRegCotizacion">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; font-size: 12px; margin-top: 20px; margin-left: 20px">
                        <div>Producto: <input type="text" id="inputDeleteProductoRegCotizacion"/></div>
                        <div style="margin-top: 10px"><div style="float: left; margin-right: 5px;margin-top: 5px">Area Analisis:</div> <div id="dropDownListAreaAnalisisDeleteProductoRegCotizacion"></div></div>
                        <div style="margin-top: 20px; margin-right: 20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                                <input type="button" value="Borrar" id="buttonOKWindowDeleteGridProductosEnsayosRegCotizacion"/>
                            </div>
                            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                                <input type="button" value="Cancelar" id="buttonCancelWindowDeleteGridProductosEnsayosRegCotizacion"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="windowEnviarCotizacionRegCotizacion">
                    <div style="font-family: Verdana ;font-weight:bold ; font-size: 12px; margin-top: 20px; margin-left: 20px">
                        <div>Destino: <input type="text" id="inputDestinoRegCotizacion"/></div>
                        <div style="margin-top: 20px">Medio: <input type="text" id="inputMedioRegCotizacion"/></div>
                        <div style="margin-top: 20px">Observaciones: </div>
                        <div style="margin-top: 20px"><textarea id="textAreaObservacionesEnvioRegCotizacion"></textarea></div>
                        <div style="margin-top: 20px; margin-right: 20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                                <input type="button" value="Aceptar" id="buttonOKWindowEnviarCotizacionRegCotizacion"/>
                            </div>
                            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                                <input type="button" value="Cancelar" id="buttonCancelWindowEnviarCotizacionRegCotizacion"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="windowProductosMuestraRegCotizacion">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; font-size: 12px; margin-top: 20px; margin-left: 20px">
                        <div>Seleccione el producto del cual desea generar la muestra</div>
                        <div id="gridProductosMuestraRegCotizacion" style="margin-top: 20px"></div>

                        <div style="margin-top: 20px; margin-right: 20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                                <input type="button" value="Aceptar" id="buttonOKWindowProductosMuestraRegCotizacion"/>
                            </div>
                            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                                <input type="button" value="Cancelar" id="buttonCancelWindowProductosMuestraRegCotizacion"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="windowEnviosaRegCotizacion">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; font-size: 12px; margin-top: 20px; margin-left: 20px">

                        <div id="gridEnviosRegCotizacion" style="margin-top: 20px"></div>

                    </div>
                </div>

                <div id="notificationRegCotizacion">
                    <span id="messageNotificationRegCotizacion"></span>
                </div>

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