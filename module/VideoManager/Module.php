<?php
namespace VideoManager;

use Zend\ModuleManager\ModuleManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'VideoManager\Tables\VideoTable' => 'VideoManager\Tables\Factories\VideoTableFactory',
                'VideoManager\Tables\VideoTableGateway' => 'VideoManager\Tables\Factories\VideoTableGatewayFactory'
            )
        );
    }

}
