<script>
    $(document).ready(function () {
        var idPerfil = <?php echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php echo $_SESSION['userId']; ?>;
        initLoadUsuarioAdmin(idPerfil, idUsuario);
    
    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de Usuarios</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: 400px; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 100%; height: 310px; float: left">
         <div id="gridAllUsuariosAdministracionUsuario"></div>
    </div>
   
</div>
<div id="windowAddUsuarioAdministracionUsuario">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 120px;height:30px; float: left">Nombre:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input type="text" id="inputNombreAdminUsuario" />
            </div>
            <div style="padding-top: 10px;border-style: solid; border:0; width: 90px;height:30px; float: left">Cargo:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 220px;height:30px; float: left">
                <div id="dropDownListCargosAdminUsuario"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 15px; border-style: solid; border:0; width: 120px;height:30px; float: left">Email:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="inputEmailAdminUsuario" type="text" />
            </div>
            <div style="padding-top: 15px;border-style: solid; border:0; width: 80px;height:30px; float: left">Jefe:</div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 220px;height:30px; float: left">
                <div id="dropDownListJefeAdminUsuario"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 15px; border-style: solid; border:0; width: 120px;height:30px; float: left">Login:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="inputLoginAdminUsuario" type="text" />
            </div>
            <div style="padding-top: 10px;border-style: solid; border:0; width: 80px;height:30px; float: left">Perfil:</div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 220px;height:30px; float: left">
                <div id="dropDownListPerfilAdminUsuario"></div>
            </div>
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 15px; border-style: solid; border:0; width: 120px;height:30px; float: left">Contraseña:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="passwordContrasenaAdminUsuario" type="password" />
            </div>
            <div style="padding-top: 10px;border-style: solid; border:0; width: 80px;height:30px; float: left">Calendario:</div>
            <div style="padding-top: 5px; padding-left: 10px;border-style: solid; border:0; width: 220px;height:30px; float: left">
                <div id="dropDownListCalendarioAdminUsuario"></div>
            </div>
        </div>
         <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 5px; border-style: solid; border:0; width: 120px;height:30px; float: left">Confirmar Contraseña:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="passwordConfirmarContrasenaAdminUsuario" type="password" />
            </div>
            
        </div>
        
        
        <div style="margin-top: 20px; margin-right: 50px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="margin-left: 30px;border-style: solid; border:0; width: auto;height:30px; float: right">
                <input type="button" value="Crear" id="buttonOKModalCrearUsuarioAdminUsuario"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalCrearUsuarioAdminUsuario"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Actualizar" id="buttonUpdatelModalCrearUsuarioAdminUsuario"/>
            </div>
        </div>
    </div>

</div>

<div id="windowResetPasswordAdministracionUsuario">

    <div style="margin-left: 30px">
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 12px;border-style: solid; border:0; width: 120px;height:30px; float: left">Nueva contraseña:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input type="password" id="inputNuevoPassAdminUsuario" />
            </div>
            
        </div>
        <div style="font-family: Verdana ;font-weight:bold ; color:#000000; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="padding-top: 15px; border-style: solid; border:0; width: 120px;height:30px; float: left">Confirmar contraseña:</div>
            <div style="padding-top: 5px; border-style: solid; border:0; width: 200px;height:30px; float: left">
                <input id="inputConfNuevoPassAdminUsuario" type="password" />
            </div>
            
        </div>
        
        
        <input id="hidUsuarioResetPassAdminusuario" type="hidden" />
        
        <div style="margin-top: 20px; margin-right: 20px; font-family: Verdana; font-size: 12px; border-style: solid; border:0; height:auto; overflow: auto">
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Reset" id="buttonOKModalResetPassAdminUsuario"/>
            </div>
            <div style="border-style: solid; border:0; width: auto;height:30px;margin-left: 10px; float: right">
                <input type="button" value="Cancelar" id="buttonCancelModalResetPassAdminUsuario"/>
            </div>
            
        </div>
    </div>

</div>


<div id="notificationAdminUsuario">
    <span id="messageNotificationAdminUsuario"></span>
</div>








