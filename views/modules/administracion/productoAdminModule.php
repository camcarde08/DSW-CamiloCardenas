<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadProductoAdmin(idPerfil, idUsuario);

    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de productos</h2>
</div>


<div style="border: #000 0px solid; width: 100%; height: 870px; font-family: Verdana; overflow: hidden">
    <div style="border: #100 0px solid; width: 100%; height: 370px;">
        <div style="border: #000 0px solid; width: 100%; height: 30px; float: left">
          
        </div>
        <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
            <div id="gridAllProductoAdminProducto"></div>
        </div>
    </div>
    <div style="border: #000 0px solid; width: 100%; height: 30px;text-align: center">
        <div id="tituloDetalleProductoAdminProducto" style="margin-left: 1px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 20px;">Detalle Producto</div>
    </div>
    <!--zscfsdfd-->
    <!--asdasdasdasa-->
    <div id='tabsDetalleProductoAdminProducto'>
        <ul>
            <li style="margin-left: 30px;">Paquetes</li>
            <li>Principios Activos</li>
            <li>Ensayos</li>

        </ul>

        <div>
            <div style="border: #100 0px solid; width: 500px; height: 370px; float: left;">

                <div style="border: #000 0px solid; width: 100%; height: 30px; float: left">
                    <div id="tituloPaquetesProductoAdminProducto"style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 15px;">Paquetes del Producto</div>
                    <div style="margin-left: 10px; margin-bottom: 20px;">
                        <div id="gridProductoPaquetesAdminProducto"></div>
                        <input id="hgridProductoPaquetesAdminProducto" name="productoPaquetesData" type="hidden" />
                    </div>
                </div>
            </div>
            <div style="border: #100 0px solid; width: 150px; height: 370px; float: left;">
                <div style="margin-left: 30px; margin-top: 50px;">
                    <button id="buttonAgregarPaqueteAdminProducto"><< Agregar</button>
                </div>
                <div style="margin-left: 30px; margin-top: 30px;">
                    <button id="buttonEliminarPaqueteAdminProducto">Eliminar >></button>
                </div>
            </div>
            <div style="border: #100 0px solid; width: 450px; height: 370px; float: left;">

                <div style="border: #000 0px solid; width: 100%; height: 30px; float: left">
                    <div id="tituloPaquetesDisponiblesAdminProducto"style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 15px;">Paquetes Disponibles</div>
                    <div style="margin-left: 10px; margin-bottom: 20px;">
                        <div id="gridPaquetesDisponiblesAdminProducto"></div>
                        <input id="hgridPaquetesDisponiblesAdminProducto" name="paqueteDisponiblesData" type="hidden" />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div style="border: #100 0px solid; width: 650px; height: 370px; float: left;">

                <div style="border: #000 0px solid; width: 100%; height: 30px; float: left">
                    <div id="tituloPrincipioActivoProductoAdminProducto"style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 15px;">Principios Activos del Producto</div>
                    <div style="margin-left: 10px; margin-bottom: 20px;">
                        <div id="gridProductoPrinActivoAdminProducto"></div>
                        <input id="hgridProductoPrinActivoAdminProducto" name="productoPrincipioActivoData" type="hidden" />
                    </div>
                </div>
            </div>
            <div style="border: #100 0px solid; width: 250px; height: 370px; float: left;">
                <div style="margin-left: 50px; margin-top: 50px;">
                    <button id="buttonAgregarPrinActivoAdminProducto"><< Agregar</button>
                </div>
                <div style="margin-left: 50px; margin-top: 30px;">
                    <button id="buttonEliminarPrinActivoAdminProducto">Eliminar >></button>
                </div>
            </div>
            <div style="border: #100 0px solid; width: 250px; height: 370px; float: left;">

                <div style="border: #000 0px solid; width: 100%; height: 30px; float: left">
                    <div id="tituloPrincipioActivoDisponibleAdminProducto"style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 15px;">Principios Activos Disponibles</div>
                    <div style="margin-left: 10px; margin-bottom: 20px;">
                        <div id="gridPrinActivoDisponiblesAdminProducto"></div>
                        <input id="hgridPrinActivoDisponiblesAdminProducto" name="principioActivoProductoData" type="hidden" />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div style="border: #100 0px solid; width: 100%; height: 350px;">

                <div style="margin-top: 10px;border: #000 0px solid; width: 100%; height: 30px; float: left">
                    <div id="tituloEnsayosProductoAdminProducto"style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 15px;">Ensayos del Producto</div>
                    <div style="margin-left: 10px; margin-bottom: 20px;">
                        <div id="gridProductoEnsayosAdminProducto"></div>
                    </div>
                </div>
            </div>
        </div>


    </div> 




    <!--sadasdasdasdasda-->
    <!--zscfsdfd-->


    <!--    <div style="border: #100 0px solid; width: 100%; height: 750px;">
    
            <div style="margin-top: 10px;border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div id="tituloEnsayosProductoAdminProducto"style="margin-left: 10px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 15px;">Ensayos Producto</div>
                <div style="margin-left: 10px; margin-bottom: 20px;">
                    <div id="gridProductoEnsayosAdminProducto"></div>
                </div>
            </div>
        </div>-->


</div>

<div id="windowAddProductoAdminProducto">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Nombre del Producto:</div>

        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">

            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputNomProductoAddProductoAdminProducto" />
            </div>

        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Tipo de Producto:</div>

        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">

            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="dropDownFormaAddProductoAdminProducto" ></div>
            </div>
        </div>
<!--        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Técnica:</div>

        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">

            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <input type="text" id="inputTecnicaAddProductoAdminProducto" />
            </div>
        </div>-->
<!--        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 100%;height:30px; float: left">Tiempo de entrega:</div>

        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">

            <div style="padding-top: 0px; border-style: solid; border:0; width: 100%;height:30px; float: left">
                <div id="numberInputTiempoAddProductoAdminProducto"></div>
            </div>
        </div>-->




        <div style="margin-top: 20px; margin-right:20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalAddProductoAdminProducto"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelarModalAddProductoAdminProducto"/>
            </div>
        </div>
    </div>

</div>





<div id="notificationAdminProducto">
    <span id="messageNotificationAdminProducto"></span>
</div>

