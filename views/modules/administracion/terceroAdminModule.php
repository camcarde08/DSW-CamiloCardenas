<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadTerceroAdmin(idPerfil, idUsuario);

    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de Clientes</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 390px; font-family: Verdana; overflow: hidden">
    

    <div style="margin-top: 14px; border: #000 0px solid; width: 100%; height: 350px; font-family: Verdana; overflow: hidden">
        <div style="border: #000 0px solid; width: 420px; height: 350px; float: left">

            <div id="gridTercerosAdminTercero"></div>
        </div>
        <div style="font-size: 10px; border: #000 0px solid; width: 790px; height: 350px; float: left">
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Nombre: </div>
                <div style="border: #000 0px solid; width: 400px; height: 30px; float: left">
                    <input type="text" id="inputNombreterceroAdminTercero"/>
                </div>

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="border: #000 0px solid; width: 100px; height: 30px; float: left">Tipo de Identificación</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id='dropDownTipoIdentificacionAdminTercero'></div>
                </div>
                <div style="border: #000 0px solid; width: 100px; height: 30px; float: left">Número de Identificación</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div style="border: #000 0px solid; width: 400px; height: 30px; float: left">
                        <input type="text" id="inputNumeroIdentificacionAdminTercero"/>
                    </div>
                </div>

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Representante:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <input type="text" id="inputRepresentanteAdminTercero"/>
                </div>
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Dirección:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <input type="text" id="inputDireccionAdminTercero"/>
                </div>

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Teléfono 1:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <input type="text" id="inputTelefono1AdminTercero"/>
                </div>
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Teléfono 2:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <input type="text" id="inputTelefono2AdminTercero"/>
                </div>

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Fax:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <input type="text" id="inputFaxAdminTercero"/>
                </div>
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">E-mail:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <input type="text" id="inputEmailAdminTercero"/>
                </div>

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Ciudad:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id="dropDownCiudadAdminTercero"></div>
                </div>
                

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">Descuento:</div>
                <div style="padding-top: 6px; border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id='checkBoxDescuentoAdminTercero' style='margin-left: 10px; float: left;'></div>
                </div>
                <div style="font-size: 12px; padding-top: 6px; border: #000 0px solid; width: 100px; height: 30px; float: left">% Descuento:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id='numberInputPorcentajeAdminTercero'></div>
                </div>

            </div>
            <div style="margin-bottom: 5px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="font-size: 12px; padding-top: 6px;border: #000 0px solid; width: 100px; height: 30px; float: left">Contrato:</div>
                <div style="padding-top: 6px; border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id='checkBoxContratoAdminTercero' style='margin-left: 10px; float: left;'></div>
                </div>
                <div style="font-size: 12px; padding-top: 6px;border: #000 0px solid; width: 100px; height: 30px; float: left">Fecha de Contrato:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id='dateInputFechaContratoAdminTercero'></div>
                </div>
            </div>
            <div style="margin-bottom: 10px; border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="border: #000 0px solid; width: 100px; height: 30px; float: left">Fecha Vence Contrato:</div>
                <div style="border: #000 0px solid; width: 290px; height: 30px; float: left">
                    <div id='dateInputFechaVenContratoAdminTercero'></div>
                </div>
            </div>
            <div style="border: #000 0px solid; width: 100%; height: 30px; float: left">
                <div style="border: #000 0px solid; width: 110px; height: 30px; float: right">
                    <input type="button" value="Crear" id='buttonCrearTerceroAdminTercero' />
                </div>
                <div style="border: #000 0px solid; width: 110px; height: 30px; float: right">
                    <input type="button" value="Actualizar" id='buttonActualizarTerceroAdminTercero' />
                </div>
                <div style="border: #000 0px solid; width: 110px; height: 30px; float: right">
                    <input type="button" value="Editar" id='buttonEditarTerceroAdminTercero' />
                </div>
                <div style="border: #000 0px solid; width: 200px; height: 30px; float: left">
                    <input type="button" value="Gestionar Contactos" id='buttonContactosTerceroAdminTercero' />
                </div>
            </div>
        </div>
    </div>
</div>

<div id="windowAddContactoAdminTercero">

    <div>
        <div id="gridContactosAdminTercero" ></div>
       
        
        
    </div>

</div>

<div id="notificationAdminTercero">
    <span id="messageNotificationAdminTercero"></span>
</div>










