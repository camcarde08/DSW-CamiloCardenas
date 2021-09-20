<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TemplateClass
 *
 * @author hruge
 */
class TemplateModelClass {
    //put your code here
    
    
    function loadTemplate($templateURL){
        
        $loadedTemplate = $this->load_page($templateURL);
        return $loadedTemplate;
    }
    
    function loadModule ($moduleURL){
        ob_start();        
        include $moduleURL;
        return ob_get_clean();
    }
    
    function loadModuleOnTemplate($loadedTemplate,$module,$part){
        $completePart = '/\#'.$part.'\#/ms';
        $loadedModule = $this->replace_content($completePart, $module, $loadedTemplate);
        return $loadedModule;
    }
    
    function loadTemplateMenu($source){
        ob_start();        
        include $source;
        $contenido = ob_get_clean();
        $pagina = $this->load_page('views/masterpage.html');
        $pagina = $this->replace_content('/\#MENU\#/ms',$contenido,$pagina);
        return $pagina;
    }
    
    
    
    function loadTemplateLogin(){
        ob_start();        
        include 'views/modules/loginPage/test.php';
        return ob_get_clean();
        
    }
    
    function load_page($page)
    {
        return file_get_contents($page);
    }
    
    function replace_content($in, $out,$pagina)
    {
        return preg_replace($in, $out, $pagina);
    }
    
    function view_page($html)
    {
        echo $html;
    }
}
