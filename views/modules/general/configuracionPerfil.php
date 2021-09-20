<div ng-app="configuracionPerfil">
    <div ng-controller="configuracionPerfilCtrl">
        <div style="font-family: Verdana ; font-size: 10px; font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
            <h1>Configuración Perfil</h1>
        </div>
        <div>
            <p>Restablecer contraseña:</p>
            <p>Nueva Contraseña:</p>
            <jqx-password-input style="margin-right: 10px; margin-bottom: 10px;" ng-model="nuevaContrasena"  jqx-width="200" jqx-height="25" ></jqx-password-input><button type="button" ng-class="classInput1()"><span ng-class="iconInput1()" aria-hidden="true"></span></button>
            <p>Confirmar Contraseña:</p>
            <jqx-password-input style="margin-right: 10px; margin-bottom: 20px;" ng-model="cNuevaContrasena"  jqx-width="200" jqx-height="25"></jqx-password-input><button type="button" ng-class="classInput2()"><span ng-class="iconInput2()" aria-hidden="true"></span></button>
            <jqx-button style="display:block;" jqx-width="100" ng-click="actualizar()">Actualizar</jqx-button>
        </div>
        
        

        <div id="notificationConfiguracionPerfil">
            <span id="messageNotificationConfiguracionPerfil"></span>
        </div>

    </div>

</div>




