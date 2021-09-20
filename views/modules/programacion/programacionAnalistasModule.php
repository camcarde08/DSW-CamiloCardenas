<script type="text/javascript">
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idMuestra = <?php
            if (isset($_GET['idMuestra'])) {
                echo "'" . $_GET['idMuestra'] . "'";
            } else {
                echo 'null';
            }
            ?>;
        var defaultSearchtext = '<?php echo $_SESSION['systemsParameters']['defaultSearchText']; ?>';
        initialProgramacionAnalistas(idMuestra, idPerfil, defaultSearchtext);
    });
</script>

<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h1>Programación de analistas</h1>
</div>

<div style="border-style: solid; border: 0; width: 100%; height: auto">
    <div style="border-style: solid; border: 0; width: 100%; height: auto">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff;height: 30px;background: linear-gradient(#000087, #8080ff);padding-left: 10px;margin-top: 10px; margin-bottom: 12px;  padding-top: 10px; border-style: solid; border:0; border-radius: 10px 10px 0px 0px">
                    Análisis a programar
                </div>
                <!--            renglon1-->
                <input id="hiddenRealIdMuestraProgAnalistas" type="hidden"/>
                <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span>Número de análisis:</span>
                    </div>
                    <div style="width: 250px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id="numMuestraProgAnalistas">
                            <input type="text" name="numMuestra"/>
                            <div id="searchNumMuestra"><img alt="search" width="16" height="16"
                                                            src="views/images/search_lg.png"/></div>
                        </div>
                    </div>
                    <div style="width: 25%; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="button" name="clearButton" id="clearButton" value="Limpiar"/>
                    </div>
                </div>

                <div id="divClienteProducto"
                     style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span>Cliente:</span>
                    </div>
                    <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="clienteInput" readonly="true"/>
                    </div>
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span>Producto:</span>
                    </div>
                    <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="productoInput" readonly="true"/>
                    </div>

                </div>
                <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 30px; background-color: white; padding-top: 5px">
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span>Fecha de compromiso:</span>
                    </div>
                    <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <div id="fechaCompromisoInputProgAnalistas"></div>
                    </div>
                    <div style="width: 150px; height: 20px; padding-top: 5px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;">
                        <span>Área de análisis:</span>
                    </div>
                    <div style="width: 400px; padding-top: 3px; border-style: solid; border:0;  float: left">
                        <input type="text" id="areaAnalisisInput" readonly="true"/>
                    </div>

                </div>
                <div class="row">
                    <br/>
                    <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
                        <br/>
                        <div style="padding-left: 10px;" id="informacionMuestraDiv">
                        </div>
                        <div id="dataTableAnalistas">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <br/>
                        <button class="btn btn-primary" id="buttonInformePrevio" disabled="disabled">Informe previo
                        </button>
                    </div>
                </div>
                <br/>
            </div>


        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div style="height: auto; background-color: white; padding-top: 5px; padding-left: 5px; border-style: solid; border: 0; overflow: auto">
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 38%; height: auto; border-style: solid; border: 0px;  font-size: 13px; float: left">
                        <div style="height: 30px;background: linear-gradient(#000087, #8080ff);margin-right: 2px;padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">Ensayos</div>
                        </div>
                        <div id="gridEnsayosProgAnalistas"></div>
                    </div>
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 20%; height: auto; margin-left: 6px; margin-right: 6px; border-style: solid; border: 0; font-size: 13px; float: left">
                        <div style="height: 30px;background: linear-gradient(#000087, #8080ff);margin-bottom: 0px; padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">Analistas</div>
                        </div>
                        <div style="height: 30px; margin-bottom: 5px;  padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">
                                <button id="programarButton">Programar analista >></button>
                            </div>
                        </div>
                        <div id="listAnalistas" style="margin-left: 15%"></div>
                    </div>
                    <div style="font-family: Verdana ;font-weight:bold ; color:#ffffff; width: 38%; height: auto; border-style: solid; border: 0; font-size: 13px; float: left">
                        <div style="height: 30px;background: linear-gradient(#000087, #8080ff);padding-top: 2px;border-style: solid; border: 0">
                            <div style="padding-top: 4px; text-align: center;">Programación actual</div>
                        </div>
                        <div id="gridEnsayosProgramados"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="notificationProgAnalistas">
    <span id="messageNotificationProgAnalistas"></span>
</div>
<div id="modalProgramacion">
    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:40px; overflow: auto">
            <div hidden="true"
                 style="padding-top: 12px;border-style: solid; border:0; width: 120px;height:30px; float: left">
                Equipo(s):
            </div>
            <div hidden="true"
                 style="padding-top: 5px; border-style: solid; border:0; width: 600px;height:30px; float: left">
                <div id="dropDownListEquiposProgAnalistas"></div>
            </div>
            <div hidden="true"
                 style="padding-top: 10px;border-style: solid; border:0; width: 140px;height:30px; float: left">Turno:
            </div>
            <div hidden="true"
                 style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <div id="dropDownListTurnosProgAnalistas"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:50px; overflow: auto">
            <div style="border-style: solid; border:0; width: 120px;height:40px; float: left">Fecha de Programación:
            </div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:40px; float: left">
                <div id="inputDateFechaProgramacionProgAnalistas"></div>
            </div>
            <div style="border-style: solid; border:0; width: 130px;height:40px; float: left">Fecha de Compromiso
                Interno:
            </div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 200px;height:40px; float: left">
                <div id="inputDateFechaCompInternoProgAnalistas"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:40px; overflow: auto">
            <div style="padding-top: 12px; border-style: solid; border:0; width: 120px;height:30px; float: left">
                Duración Analisis:
            </div>
            <div style="border-style: solid; border:0; width: 200px;height:30px; float: left">
                <div id="inputNumberDuracionAnalisisProgAnalistas"></div>
            </div>
            <div style="border-style: solid; border:0; width: 130px;height:30px; float: left">Fecha de Compromiso:</div>
            <div style="border-style: solid; border:0; width: 200px;height:30px;margin-left: 10px; float: left">
                <div id="inputDateFechaCompEnsayoProgAnalistas"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-bottom: 5px; border-style: solid; border:0; width: auto;height:20px">Observaciones:</div>
            <div style="border-style: solid; border:0; width: auto;height:auto">
                <textarea id="editorObservacionesProgAnalistas"></textarea>
            </div>
        </div>
        <br>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-bottom: 5px; border-style: solid; border:0; width: auto;height:20px">Especificación:
            </div>
            <div style="border-style: solid; border:0; width: auto;height:auto">
                <input type="text" id="inputEspecificacionProgAnalistas"/>
            </div>
        </div>
        <div style="margin-top: 20px; margin-right: 50px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:40px; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Aceptar" id="buttonOKModalProgAnalistas"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalProgAnalistas"/>
            </div>
        </div>
    </div>
</div>
<div id="windowDetalleEnsayoProgramado">
    <div>
        <!--            renglon2-->
        <div style="height: 40px; background-color: #bfbfff; padding-top: 5px">
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 0px">
                <div>Programación:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <div id="fechaProgDetalleEnsayoProgramado">Turno Asignado:1111</div>
            </div>
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 0px">
                <div>Compromiso interno:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <div id="fechaCompInternoDetalleEnsayoProgramado">Turno Asignado:1111</div>
            </div>
        </div>
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 40px; background-color: white; padding-top: 5px">
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Duración análisis:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <div id="DuracionDetalleEnsayoProgramado">Turno Asignado:1111</div>
            </div>
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 0px">
                <div>Compromiso real:</div>
            </div>
            <div style="width: 25%; border-style: solid; border:0;  float: left;padding-top: 10px">
                <div id="fechaCompMuestraDetalleEnsayoProgramado">Turno Asignado:1111</div>
            </div>
        </div>
        <!--            renglon2-->
        <div style="min-height: 40px; height: auto; background-color: #bfbfff; padding-top: 5px; overflow: hidden;border-style: solid; border: 0">
            <div style="width: 20%; height: 20px; padding-left: 10px; border-style: solid; border: 0;  float: left; font-family: Verdana; font-size: 13px;padding-top: 10px">
                <div>Observaciones:</div>
            </div>
        </div>
        <div style="border-style: solid; border-bottom: 0;border-top: 0; border-left: 0; border-right: 0; height: 40px; background-color: white; padding-top: 5px">
            <div style="width: 60%; border-style: solid; border:0;  float: left;padding-top: 0px; padding-left: 30px">
                <div id="observacionesDetalleEnsayoProgramado">Esta es una Observación Extens</div>
            </div>
        </div>
    </div>

    <form action="pdf/informes/informeAnalisis.php" method="POST" target="informeFinal" id="formEnvioFinal">
        <input name="idMuestra" id="idMuestraFinal" type="hidden"/>
        <input name="idPerfil" id="idPerfilFinal" type="hidden"/>
    </form>


</div>

<div class="modal fade" id="motivoDesasignacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Motivo de desasignación del ensayo:</h4>
            </div>
            <div class="modal-body">
                <textarea id="motivo_input" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" id="button_cancelar_motivo">Cancelar</button>
                <button class="btn btn-primary" id="button_guardar_motivo">Guardar</button>
            </div>
        </div>
    </div>
</div>