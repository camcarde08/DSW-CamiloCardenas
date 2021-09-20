<?php

class ProgramacionModelClass {
    
    private $templateModelClass;
    
    public function __construct() {
        $this->templateModelClass = new TemplateModelClass();
    }
    
    function paintProgramacionAnalistas(){
        
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/programacion/programacionAnalistasModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
    
    function paintDisponibilidadUsuarios(){
        
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/programacion/consultaDisponibilidadAnalistasModule.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
}
