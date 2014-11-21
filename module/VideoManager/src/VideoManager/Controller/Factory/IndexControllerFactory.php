<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Initialises the FeedsController using the FactoryInterface
 *
 * @category   VideoManager
 * @package    Controller\Factory
 * @author     Matthew Setter <matthew@maltblue.com>
 * @copyright  2014 Matthew Setter <matthew@maltblue.com>
 * @since      File available since Release/Tag: 1.0
 */
namespace VideoManager\Controller\Factory;

use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    VideoManager\Controller\IndexController;

class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm   = $serviceLocator->getServiceLocator();
        $feedTable = $sm->get('VideoManager\Tables\VideoTable');
        $controller = new IndexController($feedTable);

        return $controller;
    }
}
