function initLoadPerfilAdmin(idPerfil, idUsuario) {

    //load components
    loadListBoxAllPerfilesAdminPerfil();
    loadCheckboxMenuPrincipalRegistroMuestraAdminPerfil();
    loadCheckboxSubMenuRegistrarMuestraAdminPerfil();
    loadCheckboxSubMenuConsultaMuestrasAdminPerfil();
    loadCheckboxSubMenuAdjuntarDocumentosAdminPerfil();
    loadButtonEliminarArchivoAdjuntarDocumentosAdminPerfil();
    loadCheckboxSubMenuHistorialAlmacenamientoAdminPerfil();
    loadCheckboxSubMenuHistoricoEstadosMuestraAdminPerfil();
    loadCheckboxSubMenuRepoDocsAntiguosMuestraAdminPerfil();

    //estabilidades
    loadCheckboxMenuEstabilidades();
    loadCheckboxRegistroEstabilidades();
    loadCheckboxProgramacionEstabilidades();
    loadCheckboxResultadosEstabilidades();

    //Fisicoquimico y Microbiologia
    loadCheckboxMenuPrincipalFisMicDesAdminPerfil();
    loadCheckboxSubMenuConsultaHojaRutaMuestraAdminPerfil();
    loadCheckboxRevisionEnsayoHojaRutaAdminPerfil();
    loadCheckboxConsultaEnsayoHojaRutaAdminPerfil();
    loadCheckboxRegistroResultadoHojaRutaAdminPerfil();
    loadCheckboxReprogramacionEnsayoHojaRutaAdminPerfil();
    loadCheckboxAnalizarEnsayoHojaRutaAdminPerfil();
    loadCheckboxRevisarMuestraHojaRutaAdminPerfil();
    loadCheckboxVerificarMuestraHojaRutaAdminPerfil();
    //Programacion
    loadCheckboxMenuPrincipalProgramacionAdminPerfil();
    loadCheckboxSubMenuProgramacionAnalistasAdminPerfil();
    loadCheckboxSubMenuCOnsultaDisponibilidadUsuariosAdminPerfil();
    //Reportes
    loadCheckboxMenuPrincipalInformes();
    loadCheckboxSubMenuDisponibilidadUsuarios();
    loadCheckboxSubMenuEstadosdeMuestras();
    loadCheckboxSubMenuListadePrecios();
    loadCheckboxSubMenuGenerarStikers();

    loadCheckboxSubMenuInformeReactivos();
    loadCheckboxSubMenuInformeEstandares();

    //Administracion
    loadCheckboxMenuPrincipalAdministracionSistemaAdminPerfil();
    loadCheckboxSubMenuAdministracionPerfilAdminPerfil();
    //JP
    loadCheckboxSubMenuAdministracionEnsayos();
    loadCheckboxSubMenuAdministracionPaquetes();
    loadCheckboxSubMenuAdministracionEquipos();
    loadCheckboxSubMenuAdministracionMetodos();
    loadCheckboxSubMenuAdministracionEstandares();
    loadCheckboxSubMenuAdministracionFormasFarmaceuticas();
    loadCheckboxSubMenuAdministracionPrincipiosActivos();
    loadCheckboxSubMenuAdministracionProductos();
    loadCheckboxSubMenuAdministracionClientes();
    loadCheckboxSubMenuAdministracionUsuarios();

    loadCheckboxSubMenuAdministracionCepas();
    loadCheckboxSubMenuAdministracionReactivos();
    loadCheckboxSubMenuAdministracionMediosCultivo();
    loadCheckboxSubMenuAdministracionBandejasEntrada();
    loadCheckboxSubMenuAdministracionEnsayoEquipo();

    loadCheckboxSubMenuAdministracionColumna();
    loadCheckboxSubMenuAdministracionCondicion();
    loadCheckboxSubMenuAdministracionProductoCondicion();
    loadCheckboxSubMenuAdministracionUsuarioCliente();



    loadCheckboxSubMenuModuloEstadisticoResultados();
    //Editar muestra
    loadCheckboxMenuEditarMuestra();

    loadNotificationAdminPerfil();
    // load Events
    eventSelectListBoxAllPerfilesAdminPerfil();

}

function loadButtonEliminarArchivoAdjuntarDocumentosAdminPerfil() {
    $("#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function activateEventClickCheckBox() {
////Modulo muestra Sub menu Documenos boton aleminar archivo/////////////
    $('#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 35);
    });
    $('#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 35);
    });
    ////Muestras/////////////
    $('#checkboxMenuPrincipalRegistroMuestraAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 1);
    });
    $('#checkboxMenuPrincipalRegistroMuestraAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 1);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuRegistrarMuestraAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 2);
    });
    $('#checkboxSubMenuRegistrarMuestraAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 2);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuConsultaMuestrasAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 3);
    });
    $('#checkboxSubMenuConsultaMuestrasAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 3);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuHistorialAlmacenamientoAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 4);
    });
    $('#checkboxSubMenuHistorialAlmacenamientoAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 4);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 29);
    });
    $('#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 29);
    });
    ///////////////////////////////////////

    ///////////////////////////////////////
    $('#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 23);
    });
    $('#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 23);
    });
    ///////////////////////////////////////




    ////Estabilidades////////////
    $('#checkboxMenuEstabilidades').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 160);
    });
    $('#checkboxMenuEstabilidades').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 160);
    });
    $('#checkboxRegistroEstabilidades').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 157);
    });
    $('#checkboxRegistroEstabilidades').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 157);
    });
    $('#checkboxProgramacionEstabilidades').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 158);
    });
    $('#checkboxProgramacionEstabilidades').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 158);
    });
    $('#checkboxResultadosEstabilidades').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 159);
    });
    $('#checkboxResultadosEstabilidades').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 159);
    });


    $('#checkboxSubMenuAdjuntarDocumentosEstabAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 38);
    });
    ///////////////////////////////////////        




    ////Reportes////////////
    $('#checkboxMenuPrincipalInformes').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 39);
    });
    $('#checkboxMenuPrincipalInformes').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 39);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuDisponibilidadUsuarios').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 40);
    });
    $('#checkboxSubMenuDisponibilidadUsuarios').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 40);
    });
    ///////////////////////////////////////     
    ///////////////////////////////////////
    $('#checkboxSubMenuEstadosdeMuestras').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 41);
    });
    $('#checkboxSubMenuEstadosdeMuestras').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 41);
    });
    /////////////////////////////////////// 
    ///////////////////////////////////////
    $('#checkboxSubMenuListadePrecios').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 42);
    });
    $('#checkboxSubMenuListadePrecios').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 42);
    });
    ///////////////////////////////////////    
    ///////////////////////////////////////
    $('#checkboxSubMenuGenerarStikers').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 43);
    });
    $('#checkboxSubMenuGenerarStikers').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 43);
    });
    ///////////////////////////////////////
    ///////////////////////////////////////
    $('#checkboxSubMenuModuloEstadisticoResultados').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 44);
    });
    $('#checkboxSubMenuModuloEstadisticoResultados').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 44);
    });
    ///////////////////////////////////////







    $('#checkboxMenuPrincipalProgramacionAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 5);
    });
    $('#checkboxMenuPrincipalProgramacionAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 5);
    });
    ///////////////////////////////////////
    ///////////////////////////////////////
    $('#checkboxSubMenuProgramacionAnalistasAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 6);
    });
    $('#checkboxSubMenuProgramacionAnalistasAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 6);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 7);
    });
    $('#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 7);
    });
    /////////////////////////////////////////////////////////////

    $('#checkboxMenuPrincipalFisMicDesAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 8);
    });
    $('#checkboxMenuPrincipalFisMicDesAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 8);
    });
    $('#checkboxRevisionEnsayoHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 24);
    });
    $('#checkboxRevisionEnsayoHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 24);
    });
    $('#checkboxConsultaEnsayoHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 25);
    });
    $('#checkboxConsultaEnsayoHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 25);
    });
    $('#checkboxRegistroResultadoHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 26);
    });
    $('#checkboxRegistroResultadoHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 26);
    });
    $('#checkboxReprogramacionEnsayoHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 27);
    });
    $('#checkboxReprogramacionEnsayoHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 27);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 9);
    });
    $('#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 9);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuAdjuntarDocumentosAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 10);
    });
    $('#checkboxSubMenuAdjuntarDocumentosAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 10);
    });
    ///////////////////////////////////////
    $('#checkboxMenuPrincipalAdministracionSistemaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 11);
    });
    $('#checkboxMenuPrincipalAdministracionSistemaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 11);
    });
    ///////////////////////////////////////
    $('#checkboxSubMenuAdministracionPerfilAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 12);
    });
    $('#checkboxSubMenuAdministracionPerfilAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 12);
    });
    $('#checkboxSubMenuAdministracionUsuarios').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 13);
    });
    $('#checkboxSubMenuAdministracionUsuarios').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 13);
    });
    ////

    $('#checkboxSubMenuAdministracionEquipos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 14);
    });
    $('#checkboxSubMenuAdministracionEquipos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 14);
    });

    $('#checkboxSubMenuAdministracionMetodos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 32);
    });
    $('#checkboxSubMenuAdministracionMetodos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 32);
    });
    ////

    $('#checkboxSubMenuAdministracionPrincipiosActivos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 15);
    });
    $('#checkboxSubMenuAdministracionPrincipiosActivos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 15);
    });
    ////

    $('#checkboxSubMenuAdministracionEnsayos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 16);
    });
    $('#checkboxSubMenuAdministracionEnsayos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 16);
    });
    $('#checkboxSubMenuAdministracionPaquetes').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 17);
    });
    $('#checkboxSubMenuAdministracionPaquetes').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 17);
    });
    $('#checkboxSubMenuAdministracionEstandares').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 18);
    });
    $('#checkboxSubMenuAdministracionEstandares').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 18);
    });
    $('#checkboxSubMenuAdministracionFormasFarmaceuticas').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 19);
    });
    $('#checkboxSubMenuAdministracionFormasFarmaceuticas').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 19);
    });
    ///////////////////
    $('#checkboxSubMenuAdministracionProductos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 20);
    });
    $('#checkboxSubMenuAdministracionProductos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 20);
    });
    ////////////////////////

    $('#checkboxSubMenuAdministracionClientes').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 21);
    });
    $('#checkboxSubMenuAdministracionClientes').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 21);
    });
    ////////////////////////
    $('#checkboxSubMenuAdministracionCepas').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 50);
    });
    $('#checkboxSubMenuAdministracionCepas').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 50);
    });
    $('#checkboxSubMenuAdministracionReactivos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 48);
    });
    $('#checkboxSubMenuAdministracionReactivos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 48);
    });
    $('#checkboxSubMenuAdministracionMediosCultivo').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 49);
    });
    $('#checkboxSubMenuAdministracionMediosCultivo').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 49);
    });
    //////////////////////////
    $('#checkboxAnalizarEnsayoHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 51);
    });
    $('#checkboxAnalizarEnsayoHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 51);
    });
    //////////////////////////
    $('#checkboxVerificarMuestraHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 52);
    });
    $('#checkboxVerificarMuestraHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 52);
    });
    $('#checkboxRevisarMuestraHojaRutaAdminPerfil').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 55);
    });
    $('#checkboxRevisarMuestraHojaRutaAdminPerfil').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 55);
    });
    $('#checkboxSubMenuAdministracionBandejasEntrada').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 53);
    });
    $('#checkboxSubMenuAdministracionBandejasEntrada').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 53);
    });
    $('#checkboxSubMenuAdministracionEnsayoEquipo').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 54);
    });
    $('#checkboxSubMenuAdministracionEnsayoEquipo').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 54);
    });
    $('#checkboxMenuEditarMuestra').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 56);
    });
    $('#checkboxMenuEditarMuestra').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 56);
    });
    $('#checkboxSubMenuAdministracionColumna').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 57);
    });
    $('#checkboxSubMenuAdministracionColumna').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 57);
    });
    $('#checkboxSubMenuAdministracionCondicion').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 58);
    });
    $('#checkboxSubMenuAdministracionCondicion').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 58);
    });
    $('#checkboxSubMenuAdministracionProductoCondicion').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 59);
    });
    $('#checkboxSubMenuAdministracionProductoCondicion').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 59);
    });
    $('#checkboxSubMenuInformeReactivos').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 161);
    });
    $('#checkboxSubMenuInformeReactivos').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 161);
    });
    $('#checkboxSubMenuInformeEstandares').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 162);
    });
    $('#checkboxSubMenuInformeEstandares').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 162);
    });

    $('#checkboxSubMenuAdministracionUsuarioCliente').on('checked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxInsertPerfilPermiso(idPerfil, 60);
    });
    $('#checkboxSubMenuAdministracionUsuarioCliente').on('unchecked', function (event) {
        var listItem = $("#listBoxAllPerfilesAdminPerfil").jqxListBox('getSelectedItem');
        var idPerfil = listItem.value;
        ajaxDeletePerfilPermiso(idPerfil, 60);
    });


}

function deactivateEventClickCheckBox() {

////Modulo muestra Sub menu Documenos boton aleminar archivo/////////////
    $('#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil').off('checked');
    $('#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil').off('unchecked');
    //Muestras/////////
    $('#checkboxMenuPrincipalRegistroMuestraAdminPerfil').off('checked');
    $('#checkboxMenuPrincipalRegistroMuestraAdminPerfil').off('unchecked');
    $('#checkboxSubMenuRegistrarMuestraAdminPerfil').off('checked');
    $('#checkboxSubMenuRegistrarMuestraAdminPerfil').off('unchecked');
    $('#checkboxSubMenuConsultaMuestrasAdminPerfil').off('checked');
    $('#checkboxSubMenuConsultaMuestrasAdminPerfil').off('unchecked');
    $('#checkboxSubMenuAdjuntarDocumentosAdminPerfil').off('checked');
    $('#checkboxSubMenuAdjuntarDocumentosAdminPerfil').off('unchecked');
    $('#checkboxSubMenuHistorialAlmacenamientoAdminPerfil').off('checked');
    $('#checkboxSubMenuHistorialAlmacenamientoAdminPerfil').off('unchecked');
    $('#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil').off('checked');
    $('#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil').off('unchecked');
    $('#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil').off('checked');
    $('#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil').off('unchecked');
    //Estabilidades/////////
    $('#checkboxMenuEstabilidades').off('checked');
    $('#checkboxMenuEstabilidades').off('unchecked');
    $('#checkboxRegistroEstabilidades').off('checked');
    $('#checkboxRegistroEstabilidades').off('unchecked');
    $('#checkboxProgramacionEstabilidades').off('checked');
    $('#checkboxProgramacionEstabilidades').off('unchecked');
    $('#checkboxResultadosEstabilidades').off('checked');
    $('#checkboxResultadosEstabilidades').off('unchecked');
    //Fisicoquimico y Microbiologico

    $('#checkboxMenuPrincipalFisMicDesAdminPerfil').off('checked');
    $('#checkboxMenuPrincipalFisMicDesAdminPerfil').off('unchecked');
    $('#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil').off('checked');
    $('#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil').off('unchecked');
    $('#checkboxRevisionEnsayoHojaRutaAdminPerfil').off('checked');
    $('#checkboxRevisionEnsayoHojaRutaAdminPerfil').off('unchecked');
    $('#checkboxConsultaEnsayoHojaRutaAdminPerfil').off('checked');
    $('#checkboxConsultaEnsayoHojaRutaAdminPerfil').off('unchecked');
    $('#checkboxRegistroResultadoHojaRutaAdminPerfil').off('checked');
    $('#checkboxRegistroResultadoHojaRutaAdminPerfil').off('unchecked');
    $('#checkboxReprogramacionEnsayoHojaRutaAdminPerfil').off('checked');
    $('#checkboxReprogramacionEnsayoHojaRutaAdminPerfil').off('unchecked');
    $('#checkboxAnalizarEnsayoHojaRutaAdminPerfil').off('checked');
    $('#checkboxAnalizarEnsayoHojaRutaAdminPerfil').off('unchecked');
    $('#checkboxRevisarMuestraHojaRutaAdminPerfil').off('checked');
    $('#checkboxRevisarMuestraHojaRutaAdminPerfil').off('unchecked');
    $('#checkboxVerificarMuestraHojaRutaAdminPerfil').off('checked');
    $('#checkboxVerificarMuestraHojaRutaAdminPerfil').off('unchecked');
    //Programacion
    $('#checkboxMenuPrincipalProgramacionAdminPerfil').off('checked');
    $('#checkboxMenuPrincipalProgramacionAdminPerfil').off('unchecked');
    $('#checkboxSubMenuProgramacionAnalistasAdminPerfil').off('checked');
    $('#checkboxSubMenuProgramacionAnalistasAdminPerfil').off('unchecked');
    $('#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil').off('checked');
    $('#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil').off('unchecked');
    //Reportes/////////
    $('#checkboxMenuPrincipalInformes').off('checked');
    $('#checkboxMenuPrincipalInformes').off('unchecked');
    $('#checkboxSubMenuDisponibilidadUsuarios').off('checked');
    $('#checkboxSubMenuDisponibilidadUsuarios').off('unchecked');
    $('#checkboxSubMenuEstadosdeMuestras').off('checked');
    $('#checkboxSubMenuEstadosdeMuestras').off('unchecked');
    $('#checkboxSubMenuListadePrecios').off('checked');
    $('#checkboxSubMenuListadePrecios').off('unchecked');
    $('#checkboxSubMenuGenerarStikers').off('checked');
    $('#checkboxSubMenuGenerarStikers').off('unchecked');
    $('#checkboxSubMenuModuloEstadisticoResultados').off('checked');
    $('#checkboxSubMenuModuloEstadisticoResultados').off('unchecked');
    $('#checkboxSubMenuInformeReactivos').off('checked');
    $('#checkboxSubMenuInformeReactivos').off('unchecked');
    $('#checkboxSubMenuInformeEstandares').off('checked');
    $('#checkboxSubMenuInformeEstandares').off('unchecked');
    //Administracion
    $('#checkboxMenuPrincipalAdministracionSistemaAdminPerfil').off('checked');
    $('#checkboxMenuPrincipalAdministracionSistemaAdminPerfil').off('unchecked');
    $('#checkboxSubMenuAdministracionPerfilAdminPerfil').off('checked');
    $('#checkboxSubMenuAdministracionPerfilAdminPerfil').off('unchecked');
    // JP
    $('#checkboxSubMenuAdministracionEnsayos').off('checked');
    $('#checkboxSubMenuAdministracionEnsayos').off('unchecked');
    $('#checkboxSubMenuAdministracionPaquetes').off('checked');
    $('#checkboxSubMenuAdministracionPaquetes').off('unchecked');
    $('#checkboxSubMenuAdministracionEquipos').off('checked');
    $('#checkboxSubMenuAdministracionEquipos').off('unchecked');
    $('#checkboxSubMenuAdministracionMetodos').off('checked');
    $('#checkboxSubMenuAdministracionMetodos').off('unchecked');
    $('#checkboxSubMenuAdministracionEstandares').off('checked');
    $('#checkboxSubMenuAdministracionEstandares').off('unchecked');
    $('#checkboxSubMenuAdministracionCepas').off('checked');
    $('#checkboxSubMenuAdministracionCepas').off('unchecked');
    $('#checkboxSubMenuAdministracionReactivos').off('checked');
    $('#checkboxSubMenuAdministracionReactivos').off('unchecked');
    $('#checkboxSubMenuAdministracionMediosCultivo').off('checked');
    $('#checkboxSubMenuAdministracionMediosCultivo').off('unchecked');
    $('#checkboxSubMenuAdministracionFormasFarmaceuticas').off('checked');
    $('#checkboxSubMenuAdministracionFormasFarmaceuticas').off('unchecked');
    $('#checkboxSubMenuAdministracionPrincipiosActivos').off('checked');
    $('#checkboxSubMenuAdministracionPrincipiosActivos').off('unchecked');
    $('#checkboxSubMenuAdministracionProductos').off('checked');
    $('#checkboxSubMenuAdministracionProductos').off('unchecked');
    $('#checkboxSubMenuAdministracionClientes').off('checked');
    $('#checkboxSubMenuAdministracionClientes').off('unchecked');
    $('#checkboxSubMenuAdministracionUsuarios').off('checked');
    $('#checkboxSubMenuAdministracionUsuarios').off('unchecked');
    $('#checkboxSubMenuAdministracionBandejasEntrada').off('checked');
    $('#checkboxSubMenuAdministracionBandejasEntrada').off('unchecked');
    $('#checkboxSubMenuAdministracionEnsayoEquipo').off('checked');
    $('#checkboxSubMenuAdministracionEnsayoEquipo').off('unchecked');
    $('#checkboxSubMenuAdministracionColumna').off('checked');
    $('#checkboxSubMenuAdministracionColumna').off('unchecked');
    $('#checkboxSubMenuAdministracionCondicion').off('checked');
    $('#checkboxSubMenuAdministracionCondicion').off('unchecked');
    $('#checkboxSubMenuAdministracionProductoCondicion').off('checked');
    $('#checkboxSubMenuAdministracionProductoCondicion').off('unchecked');

    $('#checkboxSubMenuAdministracionUsuarioCliente').off('checked');
    $('#checkboxSubMenuAdministracionUsuarioCliente').off('unchecked');
    //Editar muestra
    $('#checkboxMenuEditarMuestra').off('checked');
    $('#checkboxMenuEditarMuestra').off('unchecked');


}

function loadListBoxAllPerfilesAdminPerfil() {
    var url = "model/DB/jqw/perfilData.php?query=getAllPerfil";
    var source = {
        datatype: "json",
        datafields: [
            {name: "id"},
            {name: "nombre"},
            {name: "estado"}

        ],
        id: "id",
        url: url
    };
    var dataAdapter = new $.jqx.dataAdapter(source);
    $("#listBoxAllPerfilesAdminPerfil").jqxListBox({source: dataAdapter, displayMember: "nombre", valueMember: "id", width: 200, height: 280});
}

///Muestras////
function loadCheckboxMenuPrincipalRegistroMuestraAdminPerfil() {
    $("#checkboxMenuPrincipalRegistroMuestraAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuRegistrarMuestraAdminPerfil() {
    $("#checkboxSubMenuRegistrarMuestraAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuConsultaMuestrasAdminPerfil() {
    $("#checkboxSubMenuConsultaMuestrasAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdjuntarDocumentosAdminPerfil() {
    $("#checkboxSubMenuAdjuntarDocumentosAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuHistorialAlmacenamientoAdminPerfil() {
    $("#checkboxSubMenuHistorialAlmacenamientoAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuHistoricoEstadosMuestraAdminPerfil() {
    $("#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

//Modulo nuevo documentoa antiguos
function loadCheckboxSubMenuRepoDocsAntiguosMuestraAdminPerfil() {
    $("#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}


///Estabilidades////
function loadCheckboxMenuEstabilidades() {
    $("#checkboxMenuEstabilidades").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxRegistroEstabilidades() {
    $("#checkboxRegistroEstabilidades").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxProgramacionEstabilidades() {
    $("#checkboxProgramacionEstabilidades").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxResultadosEstabilidades() {
    $("#checkboxResultadosEstabilidades").jqxCheckBox({width: 120, height: 25, disabled: true});
}


//Fisicoquimco y Microbiologia
function loadCheckboxMenuPrincipalFisMicDesAdminPerfil() {
    $("#checkboxMenuPrincipalFisMicDesAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuConsultaHojaRutaMuestraAdminPerfil() {
    $("#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxRevisionEnsayoHojaRutaAdminPerfil() {
    $("#checkboxRevisionEnsayoHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxConsultaEnsayoHojaRutaAdminPerfil() {
    $("#checkboxConsultaEnsayoHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxRegistroResultadoHojaRutaAdminPerfil() {
    $("#checkboxRegistroResultadoHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxReprogramacionEnsayoHojaRutaAdminPerfil() {
    $("#checkboxReprogramacionEnsayoHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxAnalizarEnsayoHojaRutaAdminPerfil() {
    $("#checkboxAnalizarEnsayoHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxRevisarMuestraHojaRutaAdminPerfil() {
    $("#checkboxRevisarMuestraHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxVerificarMuestraHojaRutaAdminPerfil() {
    $("#checkboxVerificarMuestraHojaRutaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}


//Programacion
function loadCheckboxMenuPrincipalProgramacionAdminPerfil() {
    $("#checkboxMenuPrincipalProgramacionAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuProgramacionAnalistasAdminPerfil() {
    $("#checkboxSubMenuProgramacionAnalistasAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuCOnsultaDisponibilidadUsuariosAdminPerfil() {
    $("#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

///Reportes////
function loadCheckboxMenuPrincipalInformes() {
    $("#checkboxMenuPrincipalInformes").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuDisponibilidadUsuarios() {
    $("#checkboxSubMenuDisponibilidadUsuarios").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuEstadosdeMuestras() {
    $("#checkboxSubMenuEstadosdeMuestras").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuListadePrecios() {
    $("#checkboxSubMenuListadePrecios").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuGenerarStikers() {
    $("#checkboxSubMenuGenerarStikers").jqxCheckBox({width: 120, height: 25, disabled: true});
}

//Administracion
function loadCheckboxMenuPrincipalAdministracionSistemaAdminPerfil() {
    $("#checkboxMenuPrincipalAdministracionSistemaAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionPerfilAdminPerfil() {
    $("#checkboxSubMenuAdministracionPerfilAdminPerfil").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionEnsayos() {
    $("#checkboxSubMenuAdministracionEnsayos").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionPaquetes() {
    $("#checkboxSubMenuAdministracionPaquetes").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionEquipos() {
    $("#checkboxSubMenuAdministracionEquipos").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionMetodos() {
    $("#checkboxSubMenuAdministracionMetodos").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionEstandares() {
    $("#checkboxSubMenuAdministracionEstandares").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionFormasFarmaceuticas() {
    $("#checkboxSubMenuAdministracionFormasFarmaceuticas").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionPrincipiosActivos() {
    $("#checkboxSubMenuAdministracionPrincipiosActivos").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionProductos() {
    $("#checkboxSubMenuAdministracionProductos").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionClientes() {
    $("#checkboxSubMenuAdministracionClientes").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionUsuarios() {
    $("#checkboxSubMenuAdministracionUsuarios").jqxCheckBox({width: 120, height: 25, disabled: true});
}


function loadCheckboxSubMenuAdministracionCepas() {
    $("#checkboxSubMenuAdministracionCepas").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionReactivos() {
    $("#checkboxSubMenuAdministracionReactivos").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionMediosCultivo() {
    $("#checkboxSubMenuAdministracionMediosCultivo").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionBandejasEntrada() {
    $("#checkboxSubMenuAdministracionBandejasEntrada").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuModuloEstadisticoResultados() {
    $("#checkboxSubMenuModuloEstadisticoResultados").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionEnsayoEquipo() {
    $("#checkboxSubMenuAdministracionEnsayoEquipo").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxMenuEditarMuestra() {
    $("#checkboxMenuEditarMuestra").jqxCheckBox({width: 120, height: 25, disabled: true});
}


function loadCheckboxSubMenuAdministracionColumna() {
    $("#checkboxSubMenuAdministracionColumna").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionCondicion() {
    $("#checkboxSubMenuAdministracionCondicion").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuAdministracionProductoCondicion() {
    $("#checkboxSubMenuAdministracionProductoCondicion").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuInformeReactivos() {
    $("#checkboxSubMenuInformeReactivos").jqxCheckBox({width: 120, height: 25, disabled: true});
}
function loadCheckboxSubMenuInformeEstandares() {
    $("#checkboxSubMenuInformeEstandares").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function loadCheckboxSubMenuAdministracionUsuarioCliente() {
    $("#checkboxSubMenuAdministracionUsuarioCliente").jqxCheckBox({width: 120, height: 25, disabled: true});
}

function eventSelectListBoxAllPerfilesAdminPerfil() {

    $('#listBoxAllPerfilesAdminPerfil').on('select', function (event) {
        deactivateEventClickCheckBox();
        var args = event.args;
        if (args) {
            var index = args.index;
            var item = args.item;
            var originalEvent = args.originalEvent;
            // get item's label and value.
            var label = item.label;
            var value = item.value;
            $("#divTituloPermisosAdminPerfil").html('Permisos para el perfil: <strong>' + label + '</strong>');
            if (label != "admin") {
////Modulo muestra Sub menu Documenos boton aleminar archivo/////////////
                $("#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil").jqxCheckBox({disabled: false});
                //Muestras//
                $("#checkboxMenuPrincipalRegistroMuestraAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuRegistrarMuestraAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuConsultaMuestrasAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdjuntarDocumentosAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuHistorialAlmacenamientoAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil").jqxCheckBox({disabled: false});
                //Estabilidades//
                $("#checkboxMenuEstabilidades").jqxCheckBox({disabled: false});
                $("#checkboxRegistroEstabilidades").jqxCheckBox({disabled: false});
                $("#checkboxProgramacionEstabilidades").jqxCheckBox({disabled: false});
                $("#checkboxResultadosEstabilidades").jqxCheckBox({disabled: false});
                //Fisicoquimico y Microbiologia
                $("#checkboxMenuPrincipalFisMicDesAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxRevisionEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxConsultaEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxRegistroResultadoHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxReprogramacionEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxAnalizarEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxVerificarMuestraHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxRevisarMuestraHojaRutaAdminPerfil").jqxCheckBox({disabled: false});
                //Programacion
                $("#checkboxMenuPrincipalProgramacionAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuProgramacionAnalistasAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil").jqxCheckBox({disabled: false});
                //Reportes//
                $("#checkboxMenuPrincipalInformes").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuDisponibilidadUsuarios").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuEstadosdeMuestras").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuListadePrecios").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuGenerarStikers").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuInformeReactivos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuInformeEstandares").jqxCheckBox({disabled: false});
                //Administracion
                $("#checkboxMenuPrincipalAdministracionSistemaAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionPerfilAdminPerfil").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionEnsayos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionPaquetes").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionEquipos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionMetodos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionEstandares").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionFormasFarmaceuticas").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionPrincipiosActivos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionProductos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionClientes").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionUsuarios").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuModuloEstadisticoResultados").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionCepas").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionReactivos").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionMediosCultivo").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionBandejasEntrada").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionEnsayoEquipo").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionColumna").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionCondicion").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionProductoCondicion").jqxCheckBox({disabled: false});
                $("#checkboxMenuEditarMuestra").jqxCheckBox({disabled: false});
                $("#checkboxSubMenuAdministracionUsuarioCliente").jqxCheckBox({disabled: false});
            } else {
////Modulo muestra Sub menu Documenos boton aleminar archivo/////////////
                $("#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil").jqxCheckBox({disabled: true});
                //Muestras///
                $("#checkboxMenuPrincipalRegistroMuestraAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuRegistrarMuestraAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuConsultaMuestrasAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdjuntarDocumentosAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuHistorialAlmacenamientoAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil").jqxCheckBox({disabled: true});
                //Estabilidades//
                $("#checkboxMenuEstabilidades").jqxCheckBox({disabled: true});
                $("#checkboxRegistroEstabilidades").jqxCheckBox({disabled: true});
                $("#checkboxProgramacionEstabilidades").jqxCheckBox({disabled: true});
                $("#checkboxResultadosEstabilidades").jqxCheckBox({disabled: true});
                //Fisicoquimico y Microbiologia
                $("#checkboxMenuPrincipalFisMicDesAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxRevisionEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxConsultaEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxRegistroResultadoHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxReprogramacionEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxAnalizarEnsayoHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxVerificarMuestraHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                //Programacion
                $("#checkboxMenuPrincipalProgramacionAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuProgramacionAnalistasAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil").jqxCheckBox({disabled: true});
                //Reportes//
                $("#checkboxMenuPrincipalInformes").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuDisponibilidadUsuarios").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuEstadosdeMuestras").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuListadePrecios").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuGenerarStikers").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuInformeReactivos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuInformeEstandares").jqxCheckBox({disabled: true});
                //Administracion                
                $("#checkboxMenuPrincipalAdministracionSistemaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionPerfilAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionEnsayos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionPaquetes").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionEquipos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionMetodos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionEstandares").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionFormasFarmaceuticas").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionPrincipiosActivos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionProductos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionClientes").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionUsuarios").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuModuloEstadisticoResultados").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionCepas").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionReactivos").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionMediosCultivo").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionBandejasEntrada").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionEnsayoEquipo").jqxCheckBox({disabled: true});
                $("#checkboxRevisarMuestraHojaRutaAdminPerfil").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionColumna").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionCondicion").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionProductoCondicion").jqxCheckBox({disabled: true});
                $("#checkboxMenuEditarMuestra").jqxCheckBox({disabled: true});
                $("#checkboxSubMenuAdministracionUsuarioCliente").jqxCheckBox({disabled: true});
            }
            chargePermisionsByidPerfil(value);
        }
    });
}

function chargePermisionsByidPerfil(idPerfil) {

    $("#divPrincipalPermisosAdminPerfil").hide(100, unCheckAllPermisions());
    $("#divPrincipalPermisosAdminPerfil").show("slow");
    var url = 'model/DB/jqw/perfilPermisoData.php';
    var response;
    $.ajax({
        type: "GET",
        url: url,
        data: "query=getPermisionsByPerfilId&IdPerfil=" + idPerfil,
        async: false,
        success: function (data, textStatus, jqXHR) {
            response = JSON.parse(data);
            if (response != null) {
                for (var i = 0; i < response.length; i++) {
                    //alert(response[i].idPermiso);
                    CheckPermisionsById(response[i].idPermiso);
                }
            }
        }
    });
    activateEventClickCheckBox();
}

function CheckPermisionsById(permisionId) {
    switch (permisionId) {
        case "1":
            $("#checkboxMenuPrincipalRegistroMuestraAdminPerfil").jqxCheckBox('check');
            break;
        case "2":
            $("#checkboxSubMenuRegistrarMuestraAdminPerfil").jqxCheckBox('check');
            break;
        case "3":
            $("#checkboxSubMenuConsultaMuestrasAdminPerfil").jqxCheckBox('check');
            break;
        case "4":
            $("#checkboxSubMenuHistorialAlmacenamientoAdminPerfil").jqxCheckBox('check');
            break;
        case "5":
            $("#checkboxMenuPrincipalProgramacionAdminPerfil").jqxCheckBox('check');
            break;
        case "6":
            $("#checkboxSubMenuProgramacionAnalistasAdminPerfil").jqxCheckBox('check');
            break;
        case "7":
            $("#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil").jqxCheckBox('check');
            break;
        case "8":
            $("#checkboxMenuPrincipalFisMicDesAdminPerfil").jqxCheckBox('check');
            break;
        case "9":
            $("#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil").jqxCheckBox('check');
            break;
        case "10":
            $("#checkboxSubMenuAdjuntarDocumentosAdminPerfil").jqxCheckBox('check');
            break;
        case "11":
            $("#checkboxMenuPrincipalAdministracionSistemaAdminPerfil").jqxCheckBox('check');
            break;
        case "12":
            $("#checkboxSubMenuAdministracionPerfilAdminPerfil").jqxCheckBox('check');
            break;
            //JP
        case "13":
            $("#checkboxSubMenuAdministracionUsuarios").jqxCheckBox('check');
            break;
        case "14":
            $("#checkboxSubMenuAdministracionEquipos").jqxCheckBox('check');
            break;
        case "15":
            $("#checkboxSubMenuAdministracionPrincipiosActivos").jqxCheckBox('check');
            break;
        case "16":
            $("#checkboxSubMenuAdministracionEnsayos").jqxCheckBox('check');
            break;
        case "17":
            $("#checkboxSubMenuAdministracionPaquetes").jqxCheckBox('check');
            break;
        case "18":
            $("#checkboxSubMenuAdministracionEstandares").jqxCheckBox('check');
            break;
        case "19":
            $("#checkboxSubMenuAdministracionFormasFarmaceuticas").jqxCheckBox('check');
            break;
        case "20":
            $("#checkboxSubMenuAdministracionProductos").jqxCheckBox('check');
            break;
        case "21":
            $("#checkboxSubMenuAdministracionClientes").jqxCheckBox('check');
            break;
        case "24":
            $("#checkboxRevisionEnsayoHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "25":
            $("#checkboxConsultaEnsayoHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "26":
            $("#checkboxRegistroResultadoHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "27":
            $("#checkboxReprogramacionEnsayoHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "29":
            $("#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil").jqxCheckBox('check');
            break;
        case "23"://Modulo nuevo documentos antiguos
            $("#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil").jqxCheckBox('check');
            break;
        case "34"://Modulo Estabilidades
//            $("#checkboxMenuPrincipalEstabilidadesAdminPerfil").jqxCheckBox('check');
            break;
        case "35"://Modulo Estabilidades
            $("#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil").jqxCheckBox('check');
            break;
        case "36"://Modulo Estabilidades
//            $("#checkboxSubMenuRegistroEstabilidadesAdminPerfil").jqxCheckBox('check');
            break;
        case "37"://Modulo Estabilidades
//            $("#checkboxSubMenuConsultaEstabilidadesAdminPerfil").jqxCheckBox('check');
            break;
        case "38"://Modulo Estabilidades
//            $("#checkboxSubMenuAdjuntarDocumentosEstabAdminPerfil").jqxCheckBox('check');
            break;
        case "39"://Modulo Reportes
            $("#checkboxMenuPrincipalInformes").jqxCheckBox('check');
            break;
        case "40"://Modulo Reportes
            $("#checkboxSubMenuDisponibilidadUsuarios").jqxCheckBox('check');
            break;
        case "41"://Modulo Reportes
            $("#checkboxSubMenuEstadosdeMuestras").jqxCheckBox('check');
            break;
        case "42"://Modulo Reportes
            $("#checkboxSubMenuListadePrecios").jqxCheckBox('check');
            break;
        case "43"://Modulo Reportes
            $("#checkboxSubMenuGenerarStikers").jqxCheckBox('check');
            break;
        case "44"://Modulo Estadistico de resultados
            $("#checkboxSubMenuModuloEstadisticoResultados").jqxCheckBox('check');
            break;
        case "48"://Modulo Reactivos
            $("#checkboxSubMenuAdministracionReactivos").jqxCheckBox('check');
            break;
        case "49"://Modulo Medios Cultivo
            $("#checkboxSubMenuAdministracionMediosCultivo").jqxCheckBox('check');
            break;
        case "50"://Modulo Cepas
            $("#checkboxSubMenuAdministracionCepas").jqxCheckBox('check');
            break;
        case "51"://Modulo Cepas
            $("#checkboxAnalizarEnsayoHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "52"://Modulo Cepas
            $("#checkboxVerificarMuestraHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "53"://Modulo bandejas de entrada
            $("#checkboxSubMenuAdministracionBandejasEntrada").jqxCheckBox('check');
            break;
        case "54":
            $("#checkboxSubMenuAdministracionEnsayoEquipo").jqxCheckBox('check');
            break;
        case "55":
            $("#checkboxRevisarMuestraHojaRutaAdminPerfil").jqxCheckBox('check');
            break;
        case "56": // Editar muestra
            $("#checkboxMenuEditarMuestra").jqxCheckBox('check');
            break;
        case "57": // Columna
            $("#checkboxSubMenuAdministracionColumna").jqxCheckBox('check');
            break;
        case "58": // condiciones
            $("#checkboxSubMenuAdministracionCondicion").jqxCheckBox('check');
            break;
        case "59": // Producto condición
            $("#checkboxSubMenuAdministracionProductoCondicion").jqxCheckBox('check');
            break;
        case "157": // Reg estabilidades
            $("#checkboxRegistroEstabilidades").jqxCheckBox('check');
            break;
        case "158": // Prog estabilidades
            $("#checkboxProgramacionEstabilidades").jqxCheckBox('check');
            break;
        case "159": // Resultados estabilidades
            $("#checkboxResultadosEstabilidades").jqxCheckBox('check');
            break;
        case "160": // Menú estabilidades
            $("#checkboxMenuEstabilidades").jqxCheckBox('check');
            break;
        case "161": // Informe reactivos
            $("#checkboxSubMenuInformeReactivos").jqxCheckBox('check');
            break;
        case "162": // Informe estàndares
            $("#checkboxSubMenuInformeEstandares").jqxCheckBox('check');
            break;
        case "60": // Informe estàndares
            $("#checkboxSubMenuAdministracionUsuarioCliente").jqxCheckBox('check');
            break;
        case "32":
            $("#checkboxSubMenuAdministracionMetodos").jqxCheckBox('check');
            break;

    }
}

function unCheckAllPermisions() {


//Muestras/////
    $("#checkboxMenuPrincipalRegistroMuestraAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuRegistrarMuestraAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuConsultaMuestrasAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdjuntarDocumentosAdminPerfil").jqxCheckBox('uncheck');
    $("#buttonEliminarArchivoAdjuntarDocumentosAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuHistorialAlmacenamientoAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuRepoDocsAntiguosMuestraAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuHistoricoEstadosMuestraAdminPerfil").jqxCheckBox('uncheck');
    //Estabilidades/////
    $("#checkboxMenuEstabilidades").jqxCheckBox('uncheck');
    $("#checkboxRegistroEstabilidades").jqxCheckBox('uncheck');
    $("#checkboxProgramacionEstabilidades").jqxCheckBox('uncheck');
    $("#checkboxResultadosEstabilidades").jqxCheckBox('uncheck');
    //Programacion
    $("#checkboxMenuPrincipalProgramacionAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuProgramacionAnalistasAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuConsultaDisponibilidadUsuariosAdminPerfil").jqxCheckBox('uncheck');
    //Fisicoquimico y Microbiologia    
    $("#checkboxMenuPrincipalFisMicDesAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuConsultaHojaRutaMuestraAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxRevisionEnsayoHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxConsultaEnsayoHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxRegistroResultadoHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxReprogramacionEnsayoHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxAnalizarEnsayoHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxVerificarMuestraHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxRevisarMuestraHojaRutaAdminPerfil").jqxCheckBox('uncheck');
    //Reportes/////
    $("#checkboxMenuPrincipalInformes").jqxCheckBox('uncheck');
    $("#checkboxSubMenuDisponibilidadUsuarios").jqxCheckBox('uncheck');
    $("#checkboxSubMenuEstadosdeMuestras").jqxCheckBox('uncheck');
    $("#checkboxSubMenuListadePrecios").jqxCheckBox('uncheck');
    $("#checkboxSubMenuGenerarStikers").jqxCheckBox('uncheck');
    $("#checkboxSubMenuInformeReactivos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuInformeEstandares").jqxCheckBox('uncheck');
    //Administracion
    $("#checkboxMenuPrincipalAdministracionSistemaAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionPerfilAdminPerfil").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionUsuarios").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionEquipos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionMetodos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionPrincipiosActivos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionEnsayos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionPaquetes").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionEstandares").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionFormasFarmaceuticas").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionProductos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionClientes").jqxCheckBox('uncheck');
    $("#checkboxSubMenuModuloEstadisticoResultados").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionCepas").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionReactivos").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionMediosCultivo").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionBandejasEntrada").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionEnsayoEquipo").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionColumna").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionCondicion").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionProductoCondicion").jqxCheckBox('uncheck');
    $("#checkboxSubMenuAdministracionUsuarioCliente").jqxCheckBox('uncheck');
    //Editar muestra
    $("#checkboxMenuEditarMuestra").jqxCheckBox('uncheck');
}

function ajaxInsertPerfilPermiso(idPerfil, idPermiso) {
    var url = "index.php"
    var data = "action=insertPermision";
    data = data + "&idPerfil=" + idPerfil;
    data = data + "&idPermiso=" + idPermiso;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result === 1) {

                openNotificationAdminPerfil('error', response.message);
            } else {
                openNotificationAdminPerfil('success', response.message);
            }

        }
    });
}

function ajaxDeletePerfilPermiso(idPerfil, idPermiso) {
    var url = "index.php"
    var data = "action=deletePermision";
    data = data + "&idPerfil=" + idPerfil;
    data = data + "&idPermiso=" + idPermiso;
    $.ajax({
        type: "POST",
        url: url,
        data: data,
        async: false,
        success: function (data, textStatus, jqXHR) {
            var response = JSON.parse(data);
            if (response.result === 1) {

                openNotificationAdminPerfil('error', response.message);
            } else {
                openNotificationAdminPerfil('success', response.message);
            }

        }
    });
}

function openNotificationAdminPerfil(template, message) {
    $("#messageNotificationAdminPerfil").text(message);
    $("#notificationAdminPerfil").jqxNotification({template: template});
    $("#notificationAdminPerfil").jqxNotification("open");
}

function loadNotificationAdminPerfil() {
    $("#notificationAdminPerfil").jqxNotification({
        width: 250, position: "top-right", opacity: 0.9,
        autoOpen: false, animationOpenDelay: 800, autoClose: true, autoCloseDelay: 3000, template: "info"
    });
}
