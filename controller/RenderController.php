<?php

/**
 * Created by PhpStorm.
 * User: hruge
 * Date: 26/02/2017
 * Time: 01:38 PM
 */
class RenderController {

    public function __construct() {
        $this->templateModelClass = new TemplateModelClass();
        $this->selectRender();
    }

    function selectRender() {
        switch ($_GET["page"]) {
            case "hoja-trabajo":
                $this->renderHojaTrabajo();
                break;
            case "adminreactivo":
                $this->renderAdminReactivo();
                break;
            case "adminestandar":
                $this->renderAdminEstandar();
                break;
            case "adminbandejas":
                $this->renderAdminBandejaEntrada();
                break;
            case "adminprodreactivo":
                $this->renderAdminProdEnsReactivo();
                break;
            case "admincondiciones":
                $this->renderAdminCondiciones();
                break;
            case "admincolumnas":
                $this->renderAdminColumnas();
                break;
            case "listaEstandares":
                $this->renderListaEstandares();
                break;
            case "adminusuariocliente":
                $this->renderAdminUsuarioCliente();
                break;
            case "adminEquipo":
                $this->renderAdminEquipos();
                break;
            case "informeConsumoMuestra":
                $this->renderInformeConsumoMuestra();
                break;
            case "informetendencia":
                $this->renderInformeTendencia();
                break;
            case "listaReactivos":
                $this->renderListaReactivos();
                break;
            case "informeEventoMuestra":
                $this->renderInformeEventoMuestra();
                break;
            case "programacion-muestra":
                $this->renderProgramacionMuestra();
                break;
            case "adminTercero":
                $this->renderAdminTercero();
                break;
            case "adminMetodo":
                $this->renderAdminMetodo();
                break;
            case "admin-forma-farmaceutica":
                $this->renderAdminFormaFarmaceutica();
                break;
            case "envase":
                $this->renderAdminEnvase();
                break;
            case "adminUsuario":
                $this->renderAdminUsuario();
                break;
            case "adminForma":
                $this->renderAdminForma();
                break;
            case "informeReanalisis":
                $this->renderInformeReanalisis();
                break;
            case "listaColumnas":
                $this->renderListaColumnas();
                break;
            case "informeCertificadoAnalisis":
                $this->renderInformeCertificadoAnalisis();
                break;
            case "informeEventoMuestraEstabilidad":
                $this->renderInformeEventoMuestraEstabilidad();
                break;
            case "informeAnalista":
                $this->renderInformeAnalista();
                break;
            case "informeEstadisticoMuestra":
                $this->renderInformeEstadisticoMuestra();
                break;
            case "informeOcupacionAnalista":    
                $this->renderInformeOcupacionAnalista();    
                break;
            case "informeEstabilidadSalir":
                $this->renderInformeEstabilidadSalir();
                break;
            case "informeUsoReactivosMuestra":
                $this->renderInformeUsoReactivosMuestra();
                break;
            case "informeResumenMuestras":
                $this->renderInformeResumenMuestras();
                break;
            case "historicoEstadosMuestra":
                $this->renderHistoricoEstadosMuestra();
                break;
            case "hojaCalculo":
                $this->renderHojaCalculo();
                break;

        }
    }

    function renderProgramacionMuestra() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/programacion/programacion-analistas-module-2.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderInformeTendencia() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-tendencia/informe-tendencia.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderHojaTrabajo() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/hoja-trabajo-module/hoja-trabajo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminReactivo() {
        /*
         * Todos pueden acceder a este módulo?
         */

        //$masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-reactivo-module/admin-reactivo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminEstandar() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-estandar-module/admin-estandar.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminBandejaEntrada() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-bandeja-entrada-module/admin-bandeja-entrada.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminProdEnsReactivo() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-prod-ensy-reactivo-module/admin-prod-ensy-reactivo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminCondiciones() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-condicion-cromatografica-module/admin-condicion-cromatografica.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminColumnas() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-columna-module/admin-columna.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderListaEstandares() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/lista-estandares/lista-estandares.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminUsuarioCliente() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-usuario-cliente-module/admin-usuario-cliente.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminEquipos() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-equipo-module/admin-equipo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderInformeConsumoMuestra() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-consumo-muestra/informe-consumo-muestra.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderListaReactivos() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/lista-reactivos/lista-reactivos.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderInformeEventoMuestra() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-evento-muestra/informe-evento-muestra.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminTercero() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-tercero/admin-tercero.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderAdminForma() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-tipo-producto/admin-tipo-producto.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminEnvase() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-envase/admin-envase.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminMetodo() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-metodo/admin-metodo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminFormaFarmaceutica() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-forma-farmaceutica/admin-forma-farmaceutica.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderAdminUsuario() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-usuario/admin-usuario.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderInformeReanalisis() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-reanalisis/informe-reanalisis.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderListaColumnas() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/lista-columnas/lista-columnas.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderInformeCertificadoAnalisis() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-certificado-analisis/informe-certificado-analisis.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderInformeEventoMuestraEstabilidad(){
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-evento-muestra-estabilidad/informe-evento-muestra-estabilidad.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderInformeAnalista() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-analista/informe-analista.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderInformeEstadisticoMuestra() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-estadistico-muestra/informe-estadistico-muestra.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
    function renderInformeOcupacionAnalista() {    
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');    
    
        $logoLab = '';    
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');    
    
        $logoApp = '';    
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');    
    
        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');    
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');    
    
        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');    
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');    
    
        $contenido = $this->templateModelClass->loadModule('views/modules/informe-ocupacion-analista/informe-ocupacion-analista.php');    
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');    
    
        $this->templateModelClass->view_page($logingPage);    
    }

    function renderInformeEstabilidadSalir() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-estabilidad-salir/informe-estabilidad-salir.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderInformeUsoReactivosMuestra() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-uso-reactivos-muestra/informe-uso-reactivos-muestra.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderInformeResumenMuestras() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/informe-resumen-muestras/informe-resumen-muestras.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderHistoricoEstadosMuestra() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/historico-estados/historico-estados.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function renderHojaCalculo() {
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 50px; float: left; margin-top: 26px;" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');

        $logoApp = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->templateModelClass->loadModule('views/modules/hojas-calculo/hoja/hoja-calculo/hoja-calculo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }
    
}
