<script type="text/javascript">
$(document).ready(function () {
    var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
    var idUsuario = <?php echo $_SESSION['userId']; ?>;
    var idMuestra = <?php 
            if(isset($_GET['idMuestra'])){
                echo "'".$_GET['idMuestra']."'";
            } else {
                echo 'null';
            }
        ?>;
    
    initialConsultaHojaRutaMuestra(idPerfil, idUsuario, idMuestra);
      
});
</script>



<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Módulo Hoja de Trabajo</h2>
</div>
<div style="border-style: solid; border: 0; width: 100%; height: auto">
    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Análisis a Consultar
        </div>
        <!--            renglon1-->
        <input id="realIdMuestraConHojaRutaMuestra" type="hidden" />
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Número de Análisis:</span>
            </div>
            <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="inputNumMuestraConHojaRutaMuestra">
                    <input type="text" name="numMuestra"/>
                    <div id="searchNumMuestraConHojaRutaMuestra"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                </div>
            </div>
            <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="buttonLimpiarConHojaRutaMuestra" value="Limpiar" />
            </div>
            <div style="width: 9%; padding-top: 1px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="ButtonHojaRutaPrint1" value="Recuentos" />
            </div>
<!--            <div style="width: 9%; padding-top: 1px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="ButtonHojaRutaPrint2" value="Endotoxinas" />
            </div>-->
<!--            <div style="width: 7%; padding-top: 1px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="ButtonHojaRutaPrint3" value="Estériles" />
            </div>-->
<!--            <div style="width: 7%; padding-top: 1px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="ButtonHojaRutaPrint4" value="Potencia" />
            </div>-->
<!--            <div style="width: 7%; padding-top: 1px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="ButtonHojaRutaPrint5" value="No Estériles" />
            </div>-->
        </div>
       
         <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Producto:</span>
            </div>
            <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <input type="text" id="inputProductoConHojaRutaMuestra" readonly="true"/>
            </div>
             <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Tipo de Análisis:</span>
            </div>
            <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <input type="text" id="inputTipoEstudioConHojaRutaMuestra" readonly="true" />
            </div>
           
        </div>
        
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Cliente:</span>
            </div>
            <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <input type="text" id="inputClienteConHojaRutaMuestra" readonly="true"/>
            </div>
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                
            </div>
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 0px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <input type="button"  id="butttonConsultaAnexosConHojaRutaMuestra" value="Consultar Anexos" />
            </div>
           
        </div>
        
        <div style="height: auto; background-color: white; padding-top: 5px; border-style: solid; border: 0; overflow: auto">
            <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 100%; height: auto; border-style: solid; border: 0;  font-size: 13px; float: left">
                <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-top: 2px;border-style: solid; border: 0">
                    <div style="padding-top: 4px; text-align: center;">Ensayos</div>
                </div>
                
            </div>
            <div style="width: 100%; float: left">
                <div id="gridEnsayosConHojaRutaMuestra"></div>
            </div>
            
        </div>
    </div>
</div>
<div id="notificationConHojaRutaMuestra">
    <span id="messageNotificationConHojaRutaMuestra"></span>
</div>
<div id="windowResultadosConHojaRutaMuestra">
    <div>

        <div style="border-style: solid; border: 0; width: 100%; height: auto">
            <div style="border-style: solid; border: 0; width: 100%; height: auto">
                <div style="height: auto; background-color: white; padding-top: 5px; border-style: solid; border: 0; overflow: auto">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 100%; height: auto; border-style: solid; border: 0;  font-size: 13px; float: left">
                        <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">Resultados</div>
                        </div>

                    </div>
                    <div style="width: 100%; float: left">
                        <div id="gridDetalleResConHojaRutaMuestra"></div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
<div id="windowDetalleResultadosDetalleResConHojaRutaMuestra">
    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px; font-size: 12px">
            Detalle Resultados
        </div>
        <!--            renglon1-->
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Número de Muestra:</span>
            </div>
            <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <input id="inputNumMestraDetalleResConHojaRutaMuestra" type="text" />
            </div>
            <input type="hidden" id="hiddenIdResultadoConHojaRutaMuestra" />
            <input type="hidden" id="hiddenIdEnsayoMuestraDetalleResConHojaRutaMuestra" />
            <input id="realIdMuestraConHojaRutaMuestra2" type="hidden" />
        </div>

        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Ensayo:</span>
            </div>
            <div style="width: 220px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <input type="text" id="inputEnsayoDetalleResConHojaRutaMuestra" />
            </div>
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 30px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Analista Responsable:</span>
            </div>
            <div style="width: 200px; padding-top: 3px;  padding-left: 10px; border-style: solid; border:0;  float: left">
                <input type="text" id="inputAnalistaResponsableDetalleResConHojaRutaMuestra" />
            </div>
        </div>
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Fecha de Registro:</span>
            </div>
            <div style="width: 220px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="inputDateFechaRegistroDetalleResConHojaRutaMuestra" ></div>
            </div>
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 30px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Número de Lote:</span>
            </div>
            <div style="width: 200px; padding-top: 3px;  padding-left: 10px; border-style: solid; border:0;  float: left">
                <div id="dropDownListLoteDetalleResConHojaRutaMuestra" ></div>
            </div>
        </div>
        
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 50px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 40px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Medios de cultivo:</span>
            </div>
            <div style="width: 570px; height: 20px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="dropDownMediosCultivoResConHojaRutaMuestra" ></div>
            </div>
           </div>
        
         <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 50px; background-color: white; padding-top: 5px">
         <div style="width: 150px; height: 40px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Cepas control de calidad:</span>
            </div>
            <div style="width: 570px; padding-top: 3px;  border-style: solid; border:0;  float: left">
                <div id="dropDownCepasControlCalidadResConHojaRutaMuestra" ></div>
            </div>
        </div>
        
        
        
        
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 60px; background-color: white; padding-top: 5px; margin-top: 10px;" hidden="true">
            <div style="width: 150px; height: 50px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Resultado numérico:</span>
            </div>
            <div style="width: 605px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="inputNumberResultadoNumericoResConHojaRutaMuestra"></div>
            </div>
        </div>
         <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 70px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 50px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Descripción:</span>
            </div>
            <div style="width: 605px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="AeditorDescripcionDetalleResConHojaRutaMuestra" >test</div>
            </div>
        </div>
        <div id="resultadoMesAerRow" style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 120px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 100px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >resultado de MESÓFILOS AEROBIOS U.F.C/m3 :</span>
            </div>
            <div style="width: 605px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="editorResultado1ResConHojaRutaMuestra" ></div>
            </div>
        </div>
        <div id="resultadoHonLevRow" style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 120px; background-color: white; padding-top: 5px" hidden="true">
            <div style="width: 150px; height: 100px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >resultado de HONGOS Y LEVADURAS U.F.C / m3:</span>
            </div>
            <div style="width: 605px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="editorResultado2ResConHojaRutaMuestra" ></div>
            </div>
        </div>
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 120px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 100px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Resultado:</span>
            </div>
            <div style="width: 605px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="editorResultadoDetalleResConHojaRutaMuestra" ></div>
            </div>
        </div>
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 120px; background-color: white; padding-top: 5px" hidden="true">
            <div style="width: 150px; height: 100px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Observaciones Adicionales:</span>
            </div>
            <div style="width: 605px; padding-top: 3px; border-style: solid; border:0;  float: left" >
                <div id="editorObservacionesDetalleResConHojaRutaMuestra" ></div>
            </div>
        </div>
        
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: right; font-family: Verdana; font-size: 13px;">
                <input id="buttonGuardarDetalleResConHojaRutaMuestra" type="button" value="Guardar" />
                <input id="buttonActualizarDetalleResConHojaRutaMuestra" type="button" value="Actualizar" />
            </div>
            
        </div>




    </div>
    
    
</div>

<div id="windowobservacionesReprogramarMuestra">
    <div>
        <div style="margin-bottom: 10px;">
            <h2>Motivo de Reprogramación.</h2>
        </div>
        <div style="margin-bottom: 10px;">
            <textarea id="editorMotivoReprogramacion"></textarea>
        </div>
        <div>
            <div style="float: right">
                <button id="buttonCancelWindowObservacionesReprogramarMuestra" >Cancelar</button>
                <button id="buttonOKWindowObservacionesReprogramarMuestra" >Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="windowObservacionesAprobacionEnsayoMuestra">
    <div>
        <input id="hIdEnsayoMuestraConHojaRutaMuestra" type="hidden" />
        <input id="hMetodoConHojaRutaMuestra" type="hidden" />
        <input id="hAprobadoConHojaRutaMuestra" type="hidden" />
        <input id="hInfoEnsayoConHojaRutaMuestra" type="hidden" />
        <div style="margin-bottom: 10px;">
            <div style="float: left; padding-top: 4px">Tipo de Revisión:</div>
            <div style="float: left; margin-left: 10px">
                <div id="dropDownListTipoRevisionEnsayoHojaRutaMuestra"></div>
            </div>
            
        </div>
        <div style="margin-top: 30px; margin-bottom: 20px;">
            <p>Observaciones:</p>
            <textarea id="editorMotivoAprovacion"></textarea>
        </div>
        <div>
            <div style="float: right">
                <button id="buttonCancelWindowObservacionesAprobacionEnsayo" >Cancelar</button>
                <button id="buttonOKWindowObservacionesAprobacionEnsayo" >Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="windowConsultaAnexosConHojaRutaMuestra">
    <div>
        <div id="treeAnexosConHojaRutaMuestra"></div>
    </div>
</div>

<div id="windowRegistroConclusionMuestraConHojaRutaMuestra">
    <div>
        <div>
            <p>Se han revisado todos los ensayos en análisis, por favor diligencie la conclusión correspopndiente. </p>
            <textarea id="editorConclusionMuestraConHojaRutaMuestra"></textarea>
        </div>
        <div>
            <div style="float: right; margin-top: 10px">
                <button id="buttonOKWindowRegistroConclusionMuestraConHojaRutaMuestra" >Aceptar</button>
            </div>
        </div>
    </div>
</div>

<div id="windowRegistroConclusionSubMuestraConHojaRutaMuestra">
    <div>
        <div>
            <input id="hissubmuestra" type="hidden" />
            <p>Se han revisado todos los ensayos en análisis, por favor diligencie la conclusión correspopndiente. </p>
            <textarea id="editorConclusionSubMuestraConHojaRutaMuestra"></textarea>
        </div>
        <div>
            <div style="float: right; margin-top: 10px">
                <button id="buttonOKWindowRegistroConclusionSubMuestraConHojaRutaMuestra" >Aceptar</button>
            </div>
        </div>
    </div>
</div>
