<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RegEstCotizacionModelClass
 *
 * @author andres
 */
class RegEstCotizacionModelClass {
    private $templateModelClass;
    
    public function __construct() {
        $this->templateModelClass = new TemplateModelClass();
    }
    
    function paintErrorAccess(){
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        
        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');
        
        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');
        
       // $logoApp = 'Soul System S.A.S.';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');
        
        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');
        
        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');
        
        $contenido = $this->templateModelClass->loadModule('views/modules/administracion/errorAccessModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
    
    function paintRegEstCotizacion(){
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        
        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');
        
        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');
        
            //$logoApp = 'Soul System S.A.S.';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');
        
        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');
        
        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');
        
        $contenido = $this->templateModelClass->loadModule('views/modules/estabilidad/regEstCotizacionModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
        function paintRegistroEstabilidad(){
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        
        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');
        
        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');
        
        //$logoApp = 'Soul System S.A.S.';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');
        
        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');
        
        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');
        
        $contenido = $this->templateModelClass->loadModule('views/modules/estabilidad/regEstCotizacionModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
    
        function paintConsultaEstabilidad(){
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        
        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');
        
        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');
        
        //$logoApp = 'Soul System S.A.S.';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');
        
        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');
        
        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');
        
        $contenido = $this->templateModelClass->loadModule('views/modules/estabilidad/regEstCotizacionModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
        function paintDocumentosEstabilidad(){
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        
        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');
        
        $nomLab = '<p><img src="views/images/tEnsayo1.png" style="height: 100px; float: left" /></p>';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $nomLab, 'NOM_LAB');
        
        //$logoApp = 'Soul System S.A.S.';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $logoApp, 'LOGO_APP');
        
        $shortProfile = $this->templateModelClass->loadModule('views/modules/general/shortProfileModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $shortProfile, 'PERFIL');
        
        $menu = $this->templateModelClass->loadModule('views/modules/general/menuModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $menu, 'MENU');
        
        $contenido = $this->templateModelClass->loadModule('views/modules/estabilidad/regEstCotizacionModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
}
