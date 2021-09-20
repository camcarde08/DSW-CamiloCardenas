function eventClickMenu(p1, p2, p3, consultaMuestrasEst, p4, p5, p6, docsMuestra,
        adminPerfil, adminUsuario, adminEquipo, adminMetodo, adminPrinActivos, registrarCotizacion, adminEnsayos, adminPaquetes, adminEstandar, adminForma, adminProducto, adminTercero,
        consultaCotizacion, repoDocs, regEstCotizacion, registrarEstabilidad, consultarEstabilidad, documentosEstabilidad,
        informeDisponibilidad, informeEstadoMuestras, informeListadePrecios, informeGenerarStikers, informeGenerarHCPlanta, informeGenerarInformePlanta, informeEstadistico, adminEquiposEnsayos,
        adminMedioCultivo, adminCepa, adminReactivoPermiso, adminEstandarPermiso,
        adminBandejas, adminEditarMuestra, adminProductoEnsayoReactivo,
        adminCondiciones, adminColumnas, listaReactivos, listaEstandares, adminEstabilidad, adminUsuarioCliente,
        informeMuestraEstReact, informeTendencia, informeEventoMuestra, adminFormaFarmaceutica, envase, informeEquipos, informeReanalisis, listaColumnas, informeCertificadoAnalisis, informeEventoMuestraEstabilidad, informeAnalista, informeEstadisticoMuestra, informeEstabilidadSalir, informeUsoReactivosMuestra, informeResumenMuestras)

{
    $('#jqxMenu').on('itemclick', function (event)
    {

        var element = event.args;
        var test = element.id;

        //Cotizaciones
        if (test === 'registrarCotizacion') {
            if (registrarCotizacion) {
                window.location.href = 'index.php?action=registrarCotizacion';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'consultaCotizacion') {
            if (consultaCotizacion) {
                window.location.href = 'index.php?action=consultaCotizacion';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        //Muestras
        if (test === 'subMenuRegistrarMuestras') {
            if (p1) {
                window.location.href = 'index.php?action=regmuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'historialAlmacenamiento') {
            if (p2) {
                window.location.href = 'index.php?action=almacenmuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }


        if (test === 'consultaMuestras') {
            if (p3) {
                window.location.href = 'index.php?action=consultaMuestras';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'consultaMuestrasEst') {
            if (consultaMuestrasEst) {
                window.location.href = 'index.php?action=consultaMuestrasEst';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'historicoEstadosMuestra') {
            if (p3) {
                window.location.href = 'index.php?action=render&page=historicoEstadosMuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }



        if (test === 'docsMuestra') {
            if (docsMuestra) {
                window.location.href = 'index.php?action=docsMuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'repoDocs') {
            if (repoDocs) {
                window.location.href = 'index.php?action=repoDocs';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        //Estabilidades
        if (test === 'subMenuRegCotEst') {
            if (regEstCotizacion) {
                window.location.href = 'index.php?action=regEstCotizacion';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }//Revisar test == ?
//                    if(test === 'subMenuRegistroEst'){
//                        if(registrarEstabilidad){
//                            window.location.href = 'index.php?action=registrarEstabilidad';
//                        } else {
//                            alert ("no tiene permiso a este módulo");
//                        }
//                    }
//                    if(test === 'subMenuConsultaEstab'){
//                        if(consultarEstabilidad){
//                            window.location.href = 'index.php?action=consultarEstabilidad';
//                        } else {
//                            alert ("no tiene permiso a este módulo");
//                        }
//                    }
//                    if(test === 'subMenuAdjuntarDocsEst'){
//                        if(documentosEstabilidad){
//                            window.location.href = 'index.php?action=adjuntarDocsEstabilidad';
//                        } else {
//                            alert ("no tiene permiso a este módulo");
//                        }
//                    }


        //Fisicoquimico y Microbiologico
        if (test === 'subMenuConHojaRutaMuestra') {
            if (p6) {
                window.location.href = 'index.php?action=render&page=hoja-trabajo';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        //Programacion
        if (test === 'programacionAnalistas') {
            if (p4) {
                window.location.href = 'index.php?action=programacionAnalistas';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'consultaDisponibilidadUsuario') {
            if (p5) {
                window.location.href = 'index.php?action=render&page=informeOcupacionAnalista';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        //Informes
//                    if(test === 'verInformes'){
//                        if(verInformes){
//                            window.location.href = 'index.php?action=verInformes';
//                        } else {
//                            alert ("no tiene permiso a este módulo");
//                        }
//                    }
        if (test === 'subMenuDisponibilidadUsuarios') {
            if (informeDisponibilidad) {
                window.location.href = 'index.php?action=informeDisponibilidadUsuario';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuInformeResumenMuestras') {
            if (informeResumenMuestras) {
                window.location.href = 'index.php?action=render&page=informeResumenMuestras';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuListaDePrecios') {
            if (informeListadePrecios) {
                window.location.href = 'index.php?action=informeListadePrecios';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuGenerarStikers') {
            if (informeGenerarStikers) {
                window.location.href = 'index.php?action=informeGenerarStikers';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuGenerarHCPlanta') {
            if (informeGenerarHCPlanta) {
                window.location.href = 'index.php?action=informeGenerarHCPlanta';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuGenerarInformePlanta') {
            if (informeGenerarInformePlanta) {
                window.location.href = 'index.php?action=informeGenerarInformePlanta';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }




        if (test === 'subMenuEstadistico') {
            if (informeEstadistico) {
                window.location.href = 'index.php?action=informeEstadistico';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        //Administracion
        if (test === 'adminPerfiles') {
            if (adminPerfil) {
                window.location.href = 'index.php?action=adminPerfil';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminUsuarios') {
            if (adminUsuario) {
                window.location.href = 'index.php?action=render&page=adminUsuario';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminEquipos') {
            if (adminEquipo) {
                window.location.href = 'index.php?action=render&page=adminEquipo';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminMetodos') {
            if (adminMetodo) {
                window.location.href = 'index.php?action=render&page=adminMetodo';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'adminPrinActivos') {
            if (adminPrinActivos) {
                window.location.href = 'index.php?action=adminPrinActivos';
            } else {
                alert("no tiene permiso a este modulo");
            }
        }

        if (test === 'adminEnsayos') {
            if (adminEnsayos) {
                window.location.href = 'index.php?action=adminEnsayos';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminPaquetes') {
            if (adminPaquetes) {
                window.location.href = 'index.php?action=adminPaquetes';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminEstandar') {
            if (adminEstandar) {
                window.location.href = 'index.php?action=adminEstandar';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminForma') {
            if (adminForma) {
                window.location.href = 'index.php?action=render&page=adminForma';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminProducto') {
            if (adminProducto) {
                window.location.href = 'index.php?action=adminProducto';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminTercero') {
            if (adminTercero) {
                window.location.href = 'index.php?action=render&page=adminTercero';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminEquiposEnsayos') {
            if (adminEquiposEnsayos) {
                window.location.href = 'index.php?action=adminEquiposEnsayos';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
//                    if(test === 'subMenuGenerarStikers'){
//                        if(informeGenerarStikers){
//                            window.location.href = 'index.php?action=generarStikers';
//                        } else {
//                            alert ("no tiene permiso a este módulo");
//                        }
//                    }
        if (test === 'adminMedioCultivo') {
            if (adminMedioCultivo) {
                window.location.href = 'index.php?action=adminMedioCultivo';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'adminCepa') {
            if (adminCepa) {
                window.location.href = 'index.php?action=adminCepa';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'adminReactivoElemento') {
            if (adminReactivoPermiso) {
                window.location.href = 'index.php?action=render&page=adminreactivo';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminEstandarElemento') {
            if (adminEstandarPermiso) {
                window.location.href = 'index.php?action=render&page=adminestandar';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminBandejasElemento') {
            if (adminBandejas) {
                window.location.href = 'index.php?action=render&page=adminbandejas';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminEditarMuestra') {
            if (adminEditarMuestra) {
                var session = $('#temp').text();
                var urlExtReqAdmSgm = $('#urlExtReqAdmSgm').text();
                window.open(urlExtReqAdmSgm + session + '/editar-muestra');
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminProductoEnsayoReactivo') {
            if (adminProductoEnsayoReactivo) {
                window.location.href = 'index.php?action=render&page=adminprodreactivo';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminCondiciones') {
            if (adminCondiciones) {
                window.location.href = 'index.php?action=render&page=admincondiciones';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'adminColumnas') {
            if (adminColumnas) {
                window.location.href = 'index.php?action=render&page=admincolumnas';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuListaReactivos') {
            if (listaReactivos) {
                window.location.href = 'index.php?action=render&page=listaReactivos';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuListaEstandares') {
            if (listaEstandares) {
                window.location.href = 'index.php?action=render&page=listaEstandares';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'adminEstabilidad') {
            if (adminEstabilidad) {
                var session = $('#temp').text();
                var externalRequestSgm2 = $('#urlExtReqSgm2').text();
                window.open(externalRequestSgm2 + session + '/0');
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'adminUsuarioCliente') {
            if (adminUsuarioCliente) {
                window.location.href = 'index.php?action=render&page=adminusuariocliente';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'informeTendencia') {
            if (informeTendencia) {
                window.location.href = 'index.php?action=render&page=informetendencia';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeMuestraReact') {
            if (informeMuestraEstReact) {
                window.location.href = 'index.php?action=render&page=informeConsumoMuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeEventoMuestra') {
            if (informeEventoMuestra) {
                window.location.href = 'index.php?action=render&page=informeEventoMuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        
        if (test === 'adminFormaFarmaceutica') {
            if (adminFormaFarmaceutica) {
                window.location.href = 'index.php?action=render&page=admin-forma-farmaceutica';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        
        if (test === 'adminEnvase') {
            if (envase) {
                window.location.href = 'index.php?action=render&page=envase';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        
        if (test === 'subMenuListaEquipos') {
            if (informeEquipos) {
                window.open('pdf/informes/listadoEquipos.php');
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        //Listados pdf
        if (test === 'subMenuListadoCondiciones') {
            if (listadoCondiciones) {
                window.open('pdf/informes-v-2/varios/listado-condiciones-cromatograficas/ListadoCondicionesCromatograficas.php');
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuListadoEnsayos') {
            if (listadoEnsayos) {
                window.open('pdf/informes-v-2/varios/listado-ensayos/ListadoEnsayos.php');
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuListadoProductos') {
            if (listadoProductos) {
                window.open('pdf/informes-v-2/varios/listado-productos/ListadoProductos.php');
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        if (test === 'subMenuInformeReanalisis') {
            if (informeReanalisis) {
                window.location.href = 'index.php?action=render&page=informeReanalisis';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        
        if (test === 'subMenuListaColumnas') {
            if (listaColumnas) {
                window.location.href = 'index.php?action=render&page=listaColumnas';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }
        
        if (test === 'subMenuInformeCertificadoAnalisis') {
            if (informeCertificadoAnalisis) {
                window.location.href = 'index.php?action=render&page=informeCertificadoAnalisis';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeEventoMuestraEstabilidad') {
            if (informeEventoMuestraEstabilidad) {
                window.location.href = 'index.php?action=render&page=informeEventoMuestraEstabilidad';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeAnalista') {
            if (informeAnalista) {
                window.location.href = 'index.php?action=render&page=informeAnalista';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeEstadisticoMuestra') {
            if (informeEstadisticoMuestra) {
                window.location.href = 'index.php?action=render&page=informeEstadisticoMuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeEstabilidadSalir') {
            if (informeEstabilidadSalir) {
                window.location.href = 'index.php?action=render&page=informeEstabilidadSalir';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

        if (test === 'subMenuInformeUsoReactivosMuestra') {
            if (informeUsoReactivosMuestra) {
                window.location.href = 'index.php?action=render&page=informeUsoReactivosMuestra';
            } else {
                alert("no tiene permiso a este módulo");
            }
        }

    });
}

