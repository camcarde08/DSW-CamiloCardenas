<?php
if (isset($_GET['idMuestra'])) {
    $idMuestra = $_GET['idMuestra'];
} else {
    $idMuestra = "";
}
?>

<script type="text/javascript">
    $(document).ready(function () {

        initialLoadAlmacenMuestra();

    });
</script>



<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Historial de Almacenamiento</h1>
</div>
<div style="border-style: solid; border: 0; width: 100%; height: auto">
    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <div style=" font-family: Verdana;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Análisis a Consultar
        </div>
        <!--            renglon1-->
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Número de Análisis:</span>
            </div>
            <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                <div id="numMuestraAlmacen">
                    <input type="text" name="numMuestra" value="<?php echo $idMuestra; ?>"/>
                    <div id="searchNumMuestra"><img alt="search" width="16" height="16" src="views/images/search_lg.png" /></div>
                </div>
            </div>
            <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left"> 
                <input type="button" name="clearButton" id="clearButton" value="Limpiar" />
            </div>
        </div>
        <!--            renglon1-->
        <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
            Historial de Almacenamiento
        </div>
        <!--            renglon2-->
        <div style="height: 30px; background-color: white; padding-top: 5px">
            <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <span >Área de Análisis:</span>
            </div>
            <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                <input id="areaAnalisisAlmacen" type="text" name="areaAnalisisAlmacen"/>
            </div>
        </div>
        <div style="height: 30px; background-color: white; padding-top: 5px">
            <div style="font-family: Verdana ;font-weight:bold ;  color: #000087; width: 80%; margin-left: 25%; margin-right: 20; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                <h2>Almacenamientos Registrados</h2>
            </div>

        </div>
        <div style="height: 250px; background-color: white; padding-top: 5px; width: 80%; margin-left: 10%; margin-right: 20%">
            <br>
            <div style="width: 100%; height: 20px; padding-top: 20px; padding-left: 10px; border-style: solid; border: 0; font-family: Verdana; font-size: 13px;">
                <div id="almacenamientosGrid"></div>
            </div>
        </div>

    </div>
</div>


<div id="windowNewAlmacenamiento">
    <div>
        <input type="hidden" id="hiddenIdAlmacenMuestra" />
        <div style="border-style: solid; border: 0; width: 100%; height: auto">
            <div style="border-style: solid; border: 0; width: 100%; height: auto">
                <div style="height: auto; background-color: white; padding-top: 5px; border-style: solid; border: 0; overflow: auto">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 100%; height: auto; border-style: solid; border: 0;  font-size: 13px; float: left">
                        <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">Datos de almacenamiento</div>
                        </div>

                    </div>
                    <div style="width: 100%; float: left">
                        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 70px;height:30px; float: left">Fecha:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="dateInputFechaAlmacenMuestra"></div>
                            </div>
                            <div style="padding-top: 10px;border-style: solid; border:0; width: 70px;height:30px; float: left">Tipo:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="dropDownListTipoAlmacenMuestra"></div>
                            </div>
                        </div>
                        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="padding-top: 10px;border-style: solid; border:0; width: 70px;height:30px; float: left">Estantes:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="numericInputLugarAlmacenMuestra"></div>
                            </div>
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 70px;height:30px; float: left">Bandeja:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="numericInputNivelAlmacenMuestra"></div>
                            </div>
                        </div>
                        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 70px;height:30px; float: left">Caja:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="numericInputCajaAlmacenMuestra"></div>
                            </div>
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 110px;height:30px; float: left">Tiempo(Estab.):</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="numericInputTiempoNewAlmacenamiento"></div>
                            </div>
                        </div>

                        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 70px;height:60px; float: left">Fecha salida:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:60px; float: left">
                                <div id="dateInputFechaAlmacenSalida"></div>
                            </div>
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 70px;height:60px; float: left">Peso aproximado:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 150px;height:30px; float: left">
                                <div id="numericInputPesoAproximado"></div>
                            </div>
                        </div>


                        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
                            <div style="padding-top: 12px;border-style: solid; border:0; width: 120px;height:60px; float: left">Observaciones:</div>
                            <div style="padding-top: 5px; border-style: solid; border:0; width: 100px;height:60px; float: left">
                                <input id="textInputObservaciones" type="text"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <input  style="float: right; margin-right: 20px" type="button" id="buttonGuaradarAlmacenMuestra" value="Guardar" />
        <input  style="float: right; margin-right: 10px" type="button" id="buttonCancelarAlmacenMuestra" value="Cancelar" />
    </div>


</div>
<div id="notificationAlmacenMuestra">
    <span id="messageNotificationAlmacenMuestra"></span>
</div>


