<div ng-app="regMuestraModule" ng-controller="regMuestraController as regMuestra" >
    <sgm-admin-perfil></sgm-admin-perfil>
</div>

<!--<script>
    $(document).ready(function () {
        var idPerfil = <?php //echo $_SESSION['user_id_perfil']; ?>;
        var idUsuario = <?php //echo $_SESSION['userId']; ?>;
        initLoadPerfilAdmin(idPerfil, idUsuario);

    });
</script>
<div style="font-family: Verdana ;font-weight:bold ;  color: #000087; border-style: solid; border: 0; width: 100%; height: auto; margin-top: 10px; margin-left: 0%; margin-right: 0%">
    <h2>Administración de perfiles</h2>
</div>
<div style="border: #000 0px solid; width: 100%; height: auto; font-family: Verdana; overflow: hidden">
    <div style="border: #000 0px solid; width: 400px; height: 310px; float: left">
        <div style="margin-left: 100px; margin-bottom: 20px; font-family: Verdana; color: #000087; font-size: 20px;">Perfiles</div>
        <div id="listBoxAllPerfilesAdminPerfil" style="margin-left: 100px"></div>
    </div>
    <div id="divPrincipalPermisosAdminPerfil" style="font-size: 15px;border: #000 0px solid; width: 700px; height: auto; float: left">
        <div id="divTituloPermisosAdminPerfil" style="margin-bottom: 20px;font-family: Verdana; font-size: 20px; color: #000087">Permisos</div>

        <div id='checkboxMenuPrincipalRegistroMuestraAdminPerfil'>Menú Principal Registro de Análisis</div>
        <div id='checkboxSubMenuRegistrarMuestraAdminPerfil' style="margin-left: 20px">Sub menú registrar análisis</div>
        <div id='checkboxSubMenuConsultaMuestrasAdminPerfil' style="margin-left: 20px">Sub menú consulta de análisis</div>
        <div id='checkboxSubMenuAdjuntarDocumentosAdminPerfil' style="margin-left: 20px">Sub menú adjuntar y/o eliminar documentos</div>
        <div id='buttonEliminarArchivoAdjuntarDocumentosAdminPerfil' style="margin-left: 40px">Sub menú adjuntar y/o eliminar documentos</div>
        <div id='checkboxSubMenuHistorialAlmacenamientoAdminPerfil' style="margin-left: 20px">Sub menú historial de almacenamiento</div>
        <div id='checkboxSubMenuHistoricoEstadosMuestraAdminPerfil' style="margin-left: 20px">Sub menú histórico estados de análisis</div>
        <div id='checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil' style="margin-left: 20px">Módulo Documentos Antiguos</div>




        <div id='checkboxMenuPrincipalFisMicDesAdminPerfil'>Menú Hoja de trabajo</div>
        <div id='checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil' style="margin-left: 20px">Sub menú consulta hoja de ruta por muestra</div>
        <div id='checkboxRevisionEnsayoHojaRutaAdminPerfil' style="margin-left: 40px">Habilita la revisión de ensayos en la hoja de trabajo.</div>
        <div id='checkboxConsultaEnsayoHojaRutaAdminPerfil' style="margin-left: 40px">Habilita la consulta de ensayos en la hoja de trabajo</div>
        <div id='checkboxRegistroResultadoHojaRutaAdminPerfil' style="margin-left: 40px">Habilita el registro de resultados de ensayos en la hoja de trabajo.</div>
        <div id='checkboxReprogramacionEnsayoHojaRutaAdminPerfil' style="margin-left: 40px">Habilita la reprogramación de ensayos en la hoja de trabajo</div>
        <div id='checkboxAnalizarEnsayoHojaRutaAdminPerfil' style="margin-left: 40px">Habilita la opción de analizar ensayos</div>
        <div id='checkboxRevisarMuestraHojaRutaAdminPerfil' style="margin-left: 40px">Habilita la opción de revisar muestra</div>
        <div id='checkboxVerificarMuestraHojaRutaAdminPerfil' style="margin-left: 40px">Habilita la opción de verificar muestra.</div>


        <div id='checkboxMenuPrincipalProgramacionAdminPerfil'>Menú principal programación</div>
        <div id='checkboxSubMenuProgramacionAnalistasAdminPerfil' style="margin-left: 20px">Sub menú programación Analistas</div>
        <div id='checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil' style="margin-left: 20px">Sub menú consulta disponibilidad de usuarios</div>

        <div id='checkboxMenuPrincipalInformes'>Menú Principal Informes</div>
        <div id='checkboxSubMenuDisponibilidadUsuarios' style="margin-left: 20px">Sub menú disponibilidad de usuarios</div>
        <div id='checkboxSubMenuEstadosdeMuestras' style="margin-left: 20px">Sub menú estados de muestra</div>
        <div id='checkboxSubMenuListadePrecios' style="margin-left: 20px">Sub menú lista de precios</div>
        <div id='checkboxSubMenuGenerarStikers' style="margin-left: 20px">Sub menú generar stikers</div>
        <div id='checkboxSubMenuModuloEstadisticoResultados' style="margin-left: 20px">Sub menú módulo estadistico de resultados</div>
        <div id='checkboxSubMenuInformeReactivos' style="margin-left: 20px">Informe reactivos</div>
        <div id='checkboxSubMenuInformeEstandares' style="margin-left: 20px">Informe estándares</div>

        <div id='checkboxMenuPrincipalAdministracionSistemaAdminPerfil'>Menú principal Administración del Sistema</div>
        <div id='checkboxSubMenuAdministracionPerfilAdminPerfil' style="margin-left: 20px">Sub menú administración perfiles y permisos</div>
         JP  
        <div id='checkboxSubMenuAdministracionEnsayos' style="margin-left: 20px">Sub menú administración ensayos</div>
        <div id='checkboxSubMenuAdministracionPaquetes' style="margin-left: 20px">Sub menú administración paquetes</div>
        <div id='checkboxSubMenuAdministracionEquipos' style="margin-left: 20px">Sub menú administración equipos</div>
        <div id='checkboxSubMenuAdministracionMetodos' style="margin-left: 20px">Sub menú administración métodos</div>
        <div id='checkboxSubMenuAdministracionEnsayoEquipo' style="margin-left: 20px">Sub menú administración ensayo/equipo</div>
        <div id='checkboxSubMenuAdministracionEstandares' style="margin-left: 20px">Sub menú administración estándares</div>
        <div id='checkboxSubMenuAdministracionFormasFarmaceuticas' style="margin-left: 20px">Sub menú administración Tipos de producto</div>
        <div id='checkboxSubMenuAdministracionProductos' style="margin-left: 20px">Sub menú administración productos</div>
        <div id='checkboxSubMenuAdministracionReportes' style="margin-left: 20px">Sub menú administración reportes</div>
        <div id='checkboxSubMenuAdministracionPrincipiosActivos' style="margin-left: 20px">Sub menú administración principios activos</div>
        <div id='checkboxSubMenuAdministracionClientes' style="margin-left: 20px">Sub menú administración clientes</div>
        <div id='checkboxSubMenuAdministracionUsuarios' style="margin-left: 20px">Sub menú administración usuarios</div>

        <div id='checkboxSubMenuAdministracionCepas' style="margin-left: 20px">Sub menú administración cepas</div>
        <div id='checkboxSubMenuAdministracionReactivos' style="margin-left: 20px">Sub menú administración reactivos</div>
        <div id='checkboxSubMenuAdministracionMediosCultivo' style="margin-left: 20px">Sub menú administración medios de cultivo</div>
        <div id='checkboxSubMenuAdministracionBandejasEntrada' style="margin-left: 20px">Sub menú administración bandejas de entrada</div>

        <div id='checkboxSubMenuAdministracionColumna' style="margin-left: 20px">Sub menú administración columnas</div>
        <div id='checkboxSubMenuAdministracionCondicion' style="margin-left: 20px">Sub menú administración condiciones</div>
        <div id='checkboxSubMenuAdministracionProductoCondicion' style="margin-left: 20px">Sub menú administración Producto condiciones</div>
        <div id='checkboxSubMenuAdministracionUsuarioCliente' style="margin-left: 20px">Sub menú administración Usuarios de clientes</div>

        <div id='checkboxMenuEditarMuestra'>Menú Editar Muestra</div>

        <div id='checkboxMenuEstabilidades'>Estabilidades</div>
        <div id='checkboxRegistroEstabilidades' style="margin-left: 20px">Registro de muestra estabilidades</div>
        <div id='checkboxProgramacionEstabilidades' style="margin-left: 20px">Programación de muestra estabilidades</div>
        <div id='checkboxResultadosEstabilidades' style="margin-left: 20px">Registro de resultados de estabilidades</div>
    </div>
</div>
<div id="notificationAdminPerfil">
    <span id="messageNotificationAdminPerfil"></span>
</div>







-->
