<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initAppAutoload()
    {
        $loader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath' => APPLICATION_PATH
        ));
        return $loader;
    }
    
    protected function _initView()
    {
        $view = new Zend_View();
        
        $view->doctype('XHTML1_STRICT');
        
        $view->headTitle('Tom Shaw: Zend-Doctrine-Testing');
        
        $view->headLink()->appendStylesheet('/css/styles.css');
        
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        
        $viewRenderer->setView($view);
        
        return $view;
    }
    
    protected function _initDoctrine()
    {
        $this->getApplication()->getAutoloader()->pushAutoloader(array(
            'Doctrine',
            'autoload'
        ));
        
        spl_autoload_register(array(
            'Doctrine',
            'modelsAutoload'
        ));
        
        $doctrineConfig = $this->getOption('doctrine');
        
        $manager = Doctrine_Manager::getInstance();
        
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, $doctrineConfig['model_autoloading']);
        
        Doctrine_Core::loadModels($doctrineConfig['models_path']);
        
        $conn = Doctrine_Manager::connection($doctrineConfig['dsn'], 'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
        
        return $conn;
    }
}
