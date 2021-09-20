<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil'];
?>;
        var idUsuario = <?php echo $_SESSION['userId'];
?>;
        initLoadEstandarAdmin(idPerfil, idUsuario);
    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2> Administración Reactivos y Medios de Cultivo</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 370px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
        <div id="gridAllEstandarlAdminEstandar"></div>
    </div>
</div>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de Estándares y Cepas</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 370px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
        <div id="gridAllReactivoAdminEstandar"></div>
    </div>
</div>
<div id="windowAddGridAdminEstandar">
    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Nombre:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputNombreEstandarAdminEstandar" />
            </div>
           </div>
       <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Lote:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputLoteEstandarAdminEstandar" />
            </div>
           </div>
               <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Cantidad:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputCantidadEstandarAdminEstandar" />
            </div>
           </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Fecha de vencimiento:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputDateFechaVencimientoEstandarAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Tipo:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputTipoEstandarAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Cantidad actual:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputCantidadActualEstandarAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Stock:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputStockEstandarAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Lote Interno:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputLoteInternoEstandarAdminEstandar" />
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Fecha de preparacion:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputDateFechaPreparacionEstandarAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Fecha de promoción:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputDateFechaPromocionEstandarAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Cantidad:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputCantidad2EstandarAdminEstandar" />
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Código:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputCodigoEstandarAdminEstandar" />
            </div>
        </div>
        <div style="margin-top: 20px; margin-right:20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearEstandarAdminEstandar"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearEstandarAdminEstandar"/>
            </div>
        </div>
    </div>
</div>
<div id="windowAddGridAdminReactivo">
    <div style="margin-left: 30px">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Nombre:</label>
                    <input type="text" id="inputNombreReactivoAdminEstandar" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Lote:</label>
                    <input type="text" id="inputLoteReactivoAdminEstandar" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cantidad:</label>
                    <input type="text" id="inputCantidadReactivoAdminEstandar" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha ingreso:</label>
                    <div id="inputDateFechaIngresoReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha apertura:</label>
                    <div id="inputDateFechaAperturaReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha terminacion:</label>
                    <div id="inputDateFechaTerminacionReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha vencimiento:</label>
                    <div id="inputDateFechaVencimientoReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Tipo:</label>
                    <div id="inputTipoReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Cantidad actual:</label>
                    <div id="inputCantidadActualReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Stock:</label>
                    <div id="inputStockReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">lote Interno:</label>
                    <input type="text" id="inputLoteInternoReactivoAdminEstandar" />
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="exampleInputEmail1">Fecha pase:</label>
                    <div id="inputDateFechaPaseReactivoAdminEstandar" ></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <input type="button" value="Crear" id="buttonOKModalCrearReactivoAdminEstandar"/>
                    <input type="button" value="Cancelar" id="buttonCancelModalCrearReactivoAdminEstandar"/>
                </div>
            </div>
        </div>
    <div>
</div>
        <!--<div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Nombre:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputNombreReactivoAdminEstandar" />
            </div>
           </div>
       <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Lote:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputLoteReactivoAdminEstandar" />
            </div>
           </div>
               <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Cantidad:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputCantidadReactivoAdminEstandar" />
            </div>
           </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Fecha de vencimiento:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputDateFechaVencimientoReactivoAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Tipo:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputTipoReactivoAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Cantidad actual:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputCantidadActualReactivoAdminEstandar" ></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Stock:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputStockReactivoAdminEstandar" ></div>
            </div>
        </div>
        <div style="margin-top: 20px; margin-right:20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearReactivoAdminEstandar"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearReactivoAdminEstandar"/>
            </div>
        </div>
    </div>
</div>-->
<div id="notificationAdminEstandar">
    <span id="messageNotificationAdminEstandar"></span>
</div>
