<?php
class informesModelClass {
    private $templateModelClass;
    
    public function __construct() {
        $this->templateModelClass = new TemplateModelClass();
    }
    
    function paintErrorAccess(){
        
        $masterPage = $this->templateModelClass->loadTemplate('views/masterPage3.html');
        
        $logoLab = '';
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($masterPage, $logoLab, 'LOGO_LAB');
        
        $nomLab = '<p><img src="views/images/logoTesla.png" style="height: 120px; float: right" /></p>';
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
    
    
    function paintInformeDisponibilidadModelClass(){        
        
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/disponibilidadUsuarios.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
        }
        function paintInformeDisponibilidadPDFModelClass($dato){        
        
            echo "Ganador". $dato;   
          
        }
        function paintInformeEstadoMuestraModelClass(){
            
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/estadosmuestra.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
    
        function paintInformeListadePrecios(){
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/listadodeprecios.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
        function paintInformeGenerarHCPlanta(){
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/hcplanta.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
            function paintInformeGenerarInformePlanta(){
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/informeplanta.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
            function paintInformeGenerarStiker(){
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/generarstikers.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
    
    
    
    function paintInformeEstadistico(){
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
        
        $contenido = $this->templateModelClass->loadModule('views/modules/informes/estadisticaResultados.php');
        $logingPage = $this->templateModelClass->loadModuleOnTemplate($logingPage, $contenido, 'CONTENIDO');
        
        $this->templateModelClass->view_page($logingPage);
    }
}
