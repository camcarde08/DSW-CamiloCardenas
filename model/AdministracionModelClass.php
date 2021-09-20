<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdministracionModelClass
 *
 * @author andres
 */
class AdministracionModelClass {

    private $templateModelClass;

    public function __construct() {
        $this->templateModelClass = new TemplateModelClass();
    }

    function paintErrorAccess() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/errorAccessModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintEquiposEnsayos() {

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


        $contenido = $this->templateModelClass->loadModule('views/modules/admin-ensayo-equipo/admin-equipos-ensayos.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');



        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionTercero() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/terceroAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdminMedioCultivo() {

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/administracion-module/admin-medio-cultivo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdminCepa() {
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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/administracion-module/admin-cepa.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionProducto() {

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

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-producto/admin-producto.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionForma() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/formaFarAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionEstandares() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/estandarAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionMetodos() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/metodoAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionPaquetes() {

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

        $contenido = $this->templateModelClass->loadModule('views/modules/admin-paquete-module/admin-paquete.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionEnsayos() {

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

        //$contenido = $this->templateModelClass->loadModule('views/modules/administracion/ensayoAdminModule.php');
        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/administracion-module/admin-ensayo.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionPrinActivo() {

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/prinActivoAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionEquipo() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/equipoAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionPerfil() {

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/perfilAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

    function paintAdministracionUsuario() {

        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');

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

        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/usuarioAdminModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');

        $this->templateModelClass->view_page($logingPage);
    }

}
