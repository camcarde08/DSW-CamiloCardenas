<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil'];
?>;
        var idUsuario = <?php echo $_SESSION['userId'];
?>;
        initLoadEnsayoAdmin(idPerfil, idUsuario);
    });

</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de ensayos</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 370px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
        <div id="gridAllEnsayoslAdminEnsayo"></div>
    </div>
</div>
<div class="row">
    <div style="font-family: Verdana ;font-weight:bold ;  color: #000087;" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2>Medios de cultivo asociados</h2>
    </div>
</div>
<div class="row">
    <div class="sgm-titulo col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">Medios de cultivo asociados</div>
            <div class="panel-body">
                <div style="height: 320px;">
                    <div class="row">
                        <div class="sgm-titulo col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sel.</th>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" ng-model="cepaAsociada.select">
                                        </td>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sgm-titulo col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <br>
        <br>
        <br>
        <br>
        <br>
        <button type="button" class="btn btn-default" style="width: 100%;">Eliminar <i class="fa fa-forward" aria-hidden="true"></i></button>
        <br>
        <br>
        <button type="button" class="btn btn-primary" style="width: 100%;"><i class="fa fa-backward" aria-hidden="true"></i> Agregar</button>
    </div>
    <div class="sgm-titulo col-xs-5 col-sm-5 col-md-5 col-lg-5">
        <div class="panel panel-default">
            <div class="panel-heading">Cepas disponibles</div>
            <div class="panel-body">
                <div style="height: 320px;">
                    <div class="row">
                        <div class="sgm-titulo col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Sel.</th>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="checkbox" ng-model="cepaAsociada.select">
                                        </td>
                                        
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="windowAddGridAdminEnsayo">
    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Descripción de ensayo:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputDesEnsayoAdminEnsayo" />
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Precio ensayo:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputNumberPrecioEnsayoAdminEnsayo"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Tiempo ensayo:</div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="inputNumberTiempoEnsayoAdminEnsayo"></div>
            </div>
        </div>


        <div style="margin-top: 20px; margin-right:20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearEnsayoAdminEnsayo" />
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearEnsayoAdminEnsayo" />
            </div>
        </div>
    </div>
</div>
<div id="notificationAdminEnsayo">
    <span id="messageNotificationAdminEnsayo"></span>
</div>