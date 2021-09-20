<div id='content' >
    <script type="text/javascript">

        $(document).ready(function () {

            //Cotizaciones
            var registrarCotizacion = <?php echo $_SESSION['registrarCotizacion']; ?>; // Num 30
            var consultaCotizacion = <?php echo $_SESSION['consultaCotizacion']; ?>; //Num 22

            //Muestras
            var RegistroDeMuestra = <?php echo $_SESSION['RegistroDeMuestra']; ?>;
            var subMenuRegistrarMuestras = <?php echo $_SESSION['RegistrarMuestras']; ?>;
            var historialAlmacenamiento = <?php echo $_SESSION['HistorialAlmacenamiento']; ?>;
            var consultaMuestras = <?php echo $_SESSION['ConsultaMuestras']; ?>;
            var consultaMuestrasEst = <?php echo $_SESSION['ConsultaMuestrasEst']; ?>;
            var docsMuestra = <?php echo $_SESSION['DocsMuestra']; ?>;
            var repoDocs = <?php echo $_SESSION['repoDocs']; ?>; // Num 23
            var historicoEstadosMuestra = <?php echo $_SESSION['historicoEstadosMuestra']; ?>;
            //
            //
//Estabilidades

            var adminEstabilidades = true;   // Num 34           
            var regEstCotizacion = <?php echo $_SESSION['regEstCotizacion']; ?>; // Num 31
            var registrarEstabilidad = <?php echo $_SESSION['registrarEstabilidad']; ?>; // Num 36
            var consultarEstabilidad = <?php echo $_SESSION['consultarEstabilidad']; ?>; // Num 37
            var documentosEstabilidad = <?php echo $_SESSION['documentosEstabilidad']; ?>;// Num 38

            var adminEstabilidad = <?php echo $_SESSION['adminEstabilidades']; ?>;


            //Informes
            var adminInformes = <?php echo $_SESSION['adminInformes']; ?>; // Num 39
            var informeDisponibilidad = <?php echo $_SESSION['informeDisponibilidad']; ?>; // Num 40
            var informeEstadoMuestras = <?php echo $_SESSION['informeEstadoMuestras']; ?>; // Num 41
            var informeListadePrecios = <?php echo $_SESSION['informeListadePrecios']; ?>; // Num 42
            var informeReactivos = <?php echo $_SESSION['informeReactivos']; ?>; // Num 42
            var informeEstandares = <?php echo $_SESSION['informeEstandares']; ?>; // Num 42

            //subMenuListaDePrecios
            var informeGenerarStikers = <?php echo $_SESSION['informeGenerarStikers']; ?>; // Num
            var informeGenerarHCPlanta = <?php echo $_SESSION['informeGenerarHCPlanta']; ?>; // Num
            var informeGenerarInformePlanta = <?php echo $_SESSION['informeGenerarInformePlanta']; ?>; // Num
            var informeEstadistico = <?php echo $_SESSION['informeEstadistico']; ?>; // Num


            //Programacion
            var Programacion = <?php echo $_SESSION['Programacion']; ?>;
            var subMenuProgramacionAnalistas = <?php echo $_SESSION['subMenuProgramacionAnalistas']; ?>;
            var subMenuConsultaDisponibilidadUsuarios = <?php echo $_SESSION['subMenuCOnsultaDisponibilidadUsuarios']; ?>;
            //Fisicoquimco y Microbiologico
            var FissMicroDes = <?php echo $_SESSION['FissMicroDes']; ?>;
            var subMenuConHojaRutaMuestra = <?php echo $_SESSION['subMenuConHojaRutaMuestra']; ?>;
            //Administracion
            var adminSistema = <?php echo $_SESSION['adminSistema']; ?>;
            var adminPerfiles = <?php echo $_SESSION['adminPerfiles']; ?>;
            var adminUsuarios = <?php echo $_SESSION['adminUsuarios']; ?>;
            var adminEquipos = <?php echo $_SESSION['adminEquipos']; ?>;
            var adminMetodos = <?php echo $_SESSION['adminMetodos']; ?>; //permiso 32 en BD
            var adminPrinActivos = <?php echo $_SESSION['adminPrinActivos']; ?>;
            var adminEnsayos = <?php echo $_SESSION['adminEnsayos']; ?>;
            var adminPaquetes = <?php echo $_SESSION['adminPaquetes']; ?>;
            var adminEstandar = <?php echo $_SESSION['adminEstandar']; ?>;
            var adminForma = <?php echo $_SESSION['adminForma']; ?>;
            var adminProducto = <?php echo $_SESSION['adminProducto']; ?>;
            var adminTercero = <?php echo $_SESSION['adminTercero']; ?>;

            var adminEquiposEnsayos = <?php echo $_SESSION['adminEnsayoEquipo']; ?>;

            var adminMedioCultivo = <?php echo $_SESSION['adminMediosCultivo']; ?>;
            var adminCepa = <?php echo $_SESSION['adminCepas']; ?>;

            var adminReactivoPermiso = <?php echo $_SESSION['adminReactivos']; ?>;
            var adminEstandarPermiso = <?php echo $_SESSION['adminEstandar']; ?>;

            var adminBandejas = <?php echo $_SESSION['adminBandejasEntrada']; ?>;

            var adminFormaFarmaceutica = true;

            var adminEditarMuestra = <?php echo $_SESSION['adminEditarMuestra']; ?>;

            var adminProductoEnsayoReactivo = <?php echo $_SESSION['adminProductoCondiciones']; ?>;
            var adminCondiciones = <?php echo $_SESSION['adminCondiciones']; ?>;
            var adminColumnas = <?php echo $_SESSION['adminColumnas']; ?>;

            var adminUsuarioCliente = <?php echo $_SESSION['adminUsuarioCliente']; ?>;

            var informeTendencia = true;
            var informeMuestraEstReact = true;
            var informeEventoMuestra = true;
            var envase = true;
            var informeEquipos = true;
            var informeReanalisis = true;
            
            var informeColumnas=true;
            var informeCertificadoAnalisis = true;
            var informeEventoMuestraEstabilidad = true;
            
            var informeAnalista = true;

            var listadoCondiciones = true;
            var listadoEnsayos = true;
            var listadoProductos = true;
            
            var informeEstadisticoMuestra = true;

            var informeEstabilidadSalir = true;

            var informeUsoReactivosMuestra = true;

            var informeResumenMuestras = true;

            $("#jqxMenu").jqxMenu({width: '100%', height: '40px', theme: 'personal4', showTopLevelArrows: true});
            $('#jqxMenu').jqxMenu('disable', false);
            $('#jqxMenu').jqxMenu('disable', 'informes', true);
            $('#jqxMenu').jqxMenu('disable', 'a_s_equipos', true);
            //Cotizaciones

            $('#jqxMenu').jqxMenu('disable', 'menuPrinCotizaciones', !registrarCotizacion);
            $('#jqxMenu').jqxMenu('disable', 'registrarCotizacion', !regEstCotizacion); //!registrarCotizacion
            $('#jqxMenu').jqxMenu('disable', 'consultaCotizacion', !consultaCotizacion);
            //Muestras
            $('#jqxMenu').jqxMenu('disable', 'menuRegistroMuestra', !RegistroDeMuestra);
            $('#jqxMenu').jqxMenu('disable', 'subMenuRegistrarMuestras', !subMenuRegistrarMuestras);
            $('#jqxMenu').jqxMenu('disable', 'historialAlmacenamiento', !historialAlmacenamiento);
            $('#jqxMenu').jqxMenu('disable', 'consultaMuestras', !consultaMuestras);
            $('#jqxMenu').jqxMenu('disable', 'consultaMuestrasEst', !consultaMuestrasEst);
            $('#jqxMenu').jqxMenu('disable', 'docsMuestra', !docsMuestra);
            $('#jqxMenu').jqxMenu('disable', 'repoDocs', !repoDocs);
            $('#jqxMenu').jqxMenu('disable', 'historicoEstadosMuestra', !historicoEstadosMuestra);
            //Estabilidades
            $('#jqxMenu').jqxMenu('disable', 'menuEstabilidad', !adminEstabilidades);
            $('#jqxMenu').jqxMenu('disable', 'subMenuRegCotEst', !regEstCotizacion);
            $('#jqxMenu').jqxMenu('disable', 'subMenuRegistroEst', !registrarEstabilidad);
            $('#jqxMenu').jqxMenu('disable', 'subMenuConsultaEstab', !consultarEstabilidad);
            $('#jqxMenu').jqxMenu('disable', 'subMenuAdjuntarDocsEst', !documentosEstabilidad);
            //Informes
            $('#jqxMenu').jqxMenu('disable', 'menuInformes', !adminInformes);
            $('#jqxMenu').jqxMenu('disable', 'subMenuDisponibilidadUsuarios', !informeDisponibilidad);
            $('#jqxMenu').jqxMenu('disable', 'subMenuEstadosDeMuestras', !informeEstadoMuestras);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListaDePrecios', !informeListadePrecios);
            $('#jqxMenu').jqxMenu('disable', 'subMenuGenerarStikers', !informeGenerarStikers);
            $('#jqxMenu').jqxMenu('disable', 'subMenuGenerarHCPlanta', !informeGenerarHCPlanta);
            $('#jqxMenu').jqxMenu('disable', 'subMenuGenerarInformePlanta', !informeGenerarInformePlanta);
            $('#jqxMenu').jqxMenu('disable', 'subMenuEstadistico', !informeEstadistico);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListaReactivos', !informeReactivos);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListaEstandares', !informeEstandares);
            $('#jqxMenu').jqxMenu('disable', 'informeTendencia1', !informeTendencia);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeMuestraReact', !informeMuestraEstReact);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeEventoMuestra', !informeEventoMuestra);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListadoCondiciones', !listadoCondiciones);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListadoEnsayos', !listadoEnsayos);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListadoProductos', !listadoProductos);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListaEquipos', !informeEquipos);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeReanalisis', !informeReanalisis);
            $('#jqxMenu').jqxMenu('disable', 'subMenuListaColumnas', !informeColumnas);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeCertificadoAnalisis', !informeCertificadoAnalisis);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeEventoMuestraEstabilidad', !informeEventoMuestraEstabilidad);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeAnalista', !informeAnalista);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeEstadisticoMuestra', !informeEstadisticoMuestra);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeEstabilidadSalir', !informeEstabilidadSalir);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeUsoReactivosMuestra', !informeUsoReactivosMuestra);
            $('#jqxMenu').jqxMenu('disable', 'subMenuInformeResumenMuestras', !informeResumenMuestras);

            //Programacion 
            $('#jqxMenu').jqxMenu('disable', 'programacionAnalistas', !subMenuProgramacionAnalistas);
            $('#jqxMenu').jqxMenu('disable', 'consultaDisponibilidadUsuario', !subMenuConsultaDisponibilidadUsuarios);
            $('#jqxMenu').jqxMenu('disable', 'subMenuConHojaRutaMuestra', !subMenuConHojaRutaMuestra);
            //Administracion
            $('#jqxMenu').jqxMenu('disable', 'adminSistema', !adminSistema);
            $('#jqxMenu').jqxMenu('disable', 'adminPerfiles', !adminPerfiles);
            $('#jqxMenu').jqxMenu('disable', 'adminUsuarios', !adminUsuarios);
            $('#jqxMenu').jqxMenu('disable', 'adminEquipos', !adminEquipos);
            $('#jqxMenu').jqxMenu('disable', 'adminMetodos', !adminMetodos);
            $('#jqxMenu').jqxMenu('disable', 'adminPrinActivos', !adminPrinActivos);
            $('#jqxMenu').jqxMenu('disable', 'adminEnsayos', !adminEnsayos);
            $('#jqxMenu').jqxMenu('disable', 'adminPaquetes', !adminPaquetes);
            $('#jqxMenu').jqxMenu('disable', 'adminEstandar', !adminEstandar);
            $('#jqxMenu').jqxMenu('disable', 'adminForma', !adminForma);
            $('#jqxMenu').jqxMenu('disable', 'adminProducto', !adminProducto);
            $('#jqxMenu').jqxMenu('disable', 'adminProductoEnsayoReactivo', !adminProductoEnsayoReactivo);
            $('#jqxMenu').jqxMenu('disable', 'adminCondiciones', !adminCondiciones);
            $('#jqxMenu').jqxMenu('disable', 'adminColumnas', !adminColumnas);
            $('#jqxMenu').jqxMenu('disable', 'adminTercero', !adminTercero);
            $('#jqxMenu').jqxMenu('disable', 'adminEquiposEnsayos', !adminEquiposEnsayos);
            $('#jqxMenu').jqxMenu('disable', 'adminMedioCultivo', !adminMedioCultivo);
            $('#jqxMenu').jqxMenu('disable', 'adminCepa', !adminCepa);
            $('#jqxMenu').jqxMenu('disable', 'adminReactivoElemento', !adminReactivoPermiso);
            $('#jqxMenu').jqxMenu('disable', 'adminEstandarElemento', !adminEstandarPermiso);
            $('#jqxMenu').jqxMenu('disable', 'adminBandejasElemento', !adminBandejas);
            $('#jqxMenu').jqxMenu('disable', 'adminFormaFarmaceutica', !adminFormaFarmaceutica);
            $('#jqxMenu').jqxMenu('disable', 'adminEnvase', !envase);

            $('#jqxMenu').jqxMenu('disable', 'adminUsuarioCliente', !adminUsuarioCliente);


            //Editar muestra 
            $('#jqxMenu').jqxMenu('disable', 'adminEditarMuestra', !adminEditarMuestra);
            $('#jqxMenu').jqxMenu('disable', 'adminEstabilidad', !adminEstabilidad);

            var centerItems = function () {
                var firstItem = $($("#jqxMenu ul:first").children()[0]);
                firstItem.css('margin-left', 0);
                var width = 0;
                var borderOffset = 2;
                $.each($("#jqxMenu ul:first").children(), function () {
                    width += $(this).outerWidth(true) + borderOffset;
                });
                var menuWidth = $("#jqxMenu").outerWidth();
                firstItem.css('margin-left', (menuWidth / 2) - (width / 2));
            }
            centerItems();
            $(window).resize(function () {
                centerItems();
            });

            eventClickMenu(subMenuRegistrarMuestras, historialAlmacenamiento, consultaMuestras, consultaMuestrasEst, subMenuProgramacionAnalistas, subMenuConsultaDisponibilidadUsuarios, subMenuConHojaRutaMuestra, docsMuestra,
                    adminPerfiles, adminUsuarios, adminEquipos, adminMetodos, adminPrinActivos, registrarCotizacion, adminEnsayos, adminPaquetes, adminEstandar, adminForma, adminProducto, adminTercero,
                    consultaCotizacion, repoDocs, regEstCotizacion, registrarEstabilidad, consultarEstabilidad, documentosEstabilidad,
                    informeDisponibilidad, informeEstadoMuestras, informeListadePrecios, informeGenerarStikers, informeGenerarHCPlanta,
                    informeGenerarInformePlanta, informeEstadistico, adminEquiposEnsayos, adminMedioCultivo, adminCepa, adminReactivoPermiso,
                    adminEstandarPermiso, adminBandejas, adminEditarMuestra, adminProductoEnsayoReactivo,
                    adminCondiciones, adminColumnas, informeReactivos, informeEstandares, adminEstabilidad,
                    adminUsuarioCliente, informeTendencia, informeMuestraEstReact, informeEventoMuestra, adminFormaFarmaceutica, envase, informeEquipos, informeReanalisis, informeColumnas, informeCertificadoAnalisis,
                    informeEventoMuestraEstabilidad, informeAnalista, informeEstadisticoMuestra, informeEstabilidadSalir, informeUsoReactivosMuestra, informeResumenMuestras);

            // $('#session').text(uidSession);

        });



        function cInformes() {

            if (true) {
                var x = document.getElementById("admin_sistema");

                alert(x.disabled);
            } else {
                alert("adios");
            }

        }
    </script>
    <div id='jqxMenu' style="border:0">
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <!--<li id="menuPrinCotizaciones">Cotizaciones
                <ul style='width: 250px;'>
                    <li id="registrarCotizacion">Crear Cotización de FQ y Mic</li>
                     <li id="subMenuRegCotEst">Crear Cotización de Estabilidad</li>
                    <li type='separator'></li>
                    <li id="consultaCotizacion">Consulta Cotizaciónes</li>
                    <li type='separator'></li>
                   
                </ul>
            </li>-->
            <li id="menuRegistroMuestra">Registro de análisis
                <ul style='width: 250px;'>
                    <li id="subMenuRegistrarMuestras">Registrar análisis</li>
                    <li type='separator'></li>
                    <li id="consultaMuestras">Consulta de análisis</li>
                    <li type='separator'></li>
                    <li id="docsMuestra">Adjuntar y/o eliminar documentos</li>
                    <li type='separator'></li>
                    <li id="historialAlmacenamiento">Historial de almacenamiento</li>
                    <li type='separator'></li>
                    <li id="historicoEstadosMuestra">Histórico estados de análisis</li>
                    <li type='separator'></li>
                    <li id="adminEstabilidad">Módulo de estabilidades</li>
                    <li type='separator'></li>
                    <!--<li type='separator'></li>
                    <li id="repoDocs">Módulo: Documentos Antiguos</li>-->
                </ul>
            </li>
            <!--                    <li id="menuEstabilidad">Estabilidades
                                    <ul style='width: 200px;'>
                                       <li id="subMenuRegCotEst">Cotización de Estabilidad</li>
                                       <li id="subMenuRegistroEst">Registro de Estabilidades</li>
                                       <li id="subMenuConsultaEstab">Consulta de Estabilidades</li>
                                       <li id="subMenuAdjuntarDocsEst">Adjuntar Documentos</li>
                                    </ul>
                                </li>-->
            <li id="subMenuConHojaRutaMuestra" valor="true">Hoja de trabajo</li>
            </li>
            <li id="programacionAnalistas" valor="true">Programación de analistas     
                <ul style='width: 250px;'>     
                    <li id="programacionAnalistas" valor="true">Programación de analistas</li>     
                    <li type='separator'></li>     
                    <li id="consultaDisponibilidadUsuario">Consulta de disponibilidad de analistas</li>     
                </ul>     
            </li>

            <li id="menuInformes">Informes
                <ul style='width: 250px;'>
                    <!--                    <li id="subMenuDisponibilidadUsuarios">Ocupación de usuario</li>
                                        <li type='separator'></li>-->
                    <li id="subMenuInformeResumenMuestras">Resumen de muestras</li>
                    <!--                    <li type='separator'></li>
                                        <li id="subMenuListaDePrecios">Lista de precios</li>-->
                    <li type='separator'></li>
                    <li id="subMenuGenerarStikers">Generar stikers</li>
                    <!--<li type='separator'></li>
                    <li id="subMenuGenerarHCPlanta">Hoja de Cálculo Plantas</li>
                    <li type='separator'></li>
                    <li id="subMenuGenerarInformePlanta">Informe Análisis de Plantas</li>
                    <li type='separator'></li>
                    <li id="subMenuEstadistico">Módulo Estadístico Resultados</li>-->
                    <li type='separator'></li>
                    <li id="subMenuListaReactivos">Lista de reactivos</li>
                    <li type='separator'></li>
                    <li id="subMenuListaEstandares">Lista de estándares</li>
                    <li type='separator'></li>
                    <li id="informeTendencia">Análisis de tendencia</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeMuestraReact">Consumo por muestra</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeEventoMuestra">Evento por muestra</li>
                    <li type='separator'></li>
                    <li id="subMenuListaEquipos">Lista de equipos</li>
                    <li type='separator'></li>
<!--                    <li id="subMenuInformeReanalisis">Informe de reanálisis</li>
                    <li type='separator'></li>-->
                    <li id="subMenuListaColumnas">Lista de columnas</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeEventoMuestraEstabilidad">Evento por muestra estabilidad</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeAnalista">Informe analista</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeEstadisticoMuestra">Informe estadístico muestra</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeEstabilidadSalir">Informe estabilidad por salir</li>
                    <li type='separator'></li>
                    <li id="subMenuInformeUsoReactivosMuestra">Informe de uso de reactivos por muestra</li>
                </ul>
            </li>


            <li id="adminSistema">Administración del Sistema
                <ul style='width: 180px;'>
                    <li>Muestra
                        <ul>
                            <li id="adminEnsayos">Ensayos</li>
                            <li type='separator'></li>
                            <li id="adminPaquetes">Paquetes</li>
                            <li type='separator'></li>
                            <li id="adminProducto">Productos</li>
                            <li type='separator'></li>
                            <li id="adminEquiposEnsayos">Relación ensayos / equipos</li>
                            <!--<li type='separator'></li>
                            <li id="adminMedioCultivo">Medios de cultivo</li>
                            <li type='separator'></li>
                            <li id="adminCepa">Cepas</li>-->
                            <li type='separator'></li>
                            <li id="adminReactivoElemento">Reactivos</li>
                            <li type='separator'></li>
                            <li id="adminEstandarElemento">Estándares</li>
                            <li type='separator'></li>
                            <li id="adminColumnas">Columnas</li>
                            <li type='separator'></li>
                            <li id="adminProductoEnsayoReactivo">Relación producto insumos</li>
                            <li type='separator'></li>
                        </ul>
                    </li>
                    <li id="adminEquipos">Equipos</li>
                    <li type='separator'></li>
                    <li id="adminMetodos">Métodos</li>
                    <li type='separator'></li>
                    <li id="adminForma">Tipos de producto</li>
                    <li type='separator'></li>
                    <li id="adminPerfiles">Perfiles de usuario</li>
                    <li type='separator'></li>
                    <li id="adminPrinActivos">Principios activos</li>
                    <li type='separator'></li>
                    <li id="adminCondiciones">Condiciones cromatográficas</li>
                    <li type='separator'></li>
                    <li id="adminTercero">Clientes</li>
                    <li type='separator'></li>
                    <li id="adminUsuarios">Usuarios</li>
                    <li type='separator'></li>
                    <li id="adminBandejasElemento">Perfiles bandejas de entrada</li>
                    <li type='separator'></li>
                    <li id="adminUsuarioCliente">Usuarios cliente</li>
                    <li type='separator'></li>
                    <li id="adminFormaFarmaceutica">Formas farmacéuticas</li>
                    <li type='separator'></li>
                    <li id="adminEnvase">Envases</li>
                    <li type='separator'></li>
                </ul>
            </li>
            <li id="adminEditarMuestra">Editar muestra</li>
        </ul>
    </div>
</div>
<span id="temp" hidden="true"><?php echo $_SESSION['uidSession']; ?></span>
<span id="urlExtReqAdmSgm" hidden="true"><?php echo $_SESSION['systemsParameters']['externalRequestAdminSgm']; ?></span>
<span id="urlExtReqSgm2" hidden="true"><?php echo $_SESSION['systemsParameters']['externalRequestSgm2']; ?></span>

<form action="pdf/informes/listadoReactivos.php"  method="POST" target="reactivosTarg" id="formReactivo">
    <input name="jsonReactivo" id="jsonReactivo" type="hidden"/>
</form>

