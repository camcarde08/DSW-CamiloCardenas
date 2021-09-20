<?php

class LoginModelClass {

    private $TemplateModelClass;

    public function __construct() {
        $this->TemplateModelClass = new TemplateModelClass();
    }

    function paintLogingPage() {
        $masterPage = $this->TemplateModelClass->loadTemplate('views/masterPage1.html');
        $titulo1 = '<p><img src="views/images/firmaSS.png" style="float: left" /></p>';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($masterPage, $titulo1, 'NOM_LAB');

        $logo = '<p><img src="views/images/logoSYSLAB.png" style="height: 120px; float: right" /></p>';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $logo, 'LOGO_APP');

        $nombre = '';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $nombre, 'NOM_APP');


        $contenido1 = $this->TemplateModelClass->loadModule('views/modules/loginPage/loginForm.php');
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $contenido1, 'CONTENIDO1');

        $mensage = "";
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $mensage, 'MENSAGE_LOG');

        $contenido2 = '<img src="views/images/login1.jpg" style="width:100%; float: left" />';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $contenido2, 'CONTENIDO2');

        $this->TemplateModelClass->view_page($logingPage);
    }

    function paintFailLogingPage() {

        $masterPage = $this->TemplateModelClass->loadTemplate('views/masterPage1.html');
        $titulo1 = '<p><img src="views/images/firmaSS.png" style="float: left" /></p>';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($masterPage, $titulo1, 'NOM_LAB');

        $logo = '<p><img src="views/images/logoSYSLAB.png" style="height: 120px; float: right" /></p>';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $logo, 'LOGO_APP');

        $nombre = '';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $nombre, 'NOM_APP');


        $contenido1 = $this->TemplateModelClass->loadModule('views/modules/loginPage/loginForm.php');
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $contenido1, 'CONTENIDO1');

        $mensage = "<p style='color: RED '>Error al loguear verifique sus datos e intentelo nuevamente</p>";
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $mensage, 'MENSAGE_LOG');

        $contenido2 = '<img src="views/images/login1.jpg" style="width:100%; float: left" />';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $contenido2, 'CONTENIDO2');

        $this->TemplateModelClass->view_page($logingPage);
    }

    function paintWelcomePage() {

        $masterPage = $this->TemplateModelClass->loadTemplate('views/masterPage6.html');

        $logoLab = '';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');

        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');


        $logoApp = '';
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');

        $shortProfile = $this->TemplateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');

        $menu = $this->TemplateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');

        $contenido = $this->TemplateModelClass->loadModule('views/modules/bandeja-entrada/bandeja-entrada.php');


        $logingPage = $this->TemplateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');



        $this->TemplateModelClass->view_page($logingPage);
    }

}
