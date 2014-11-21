<?php

namespace VideoManager\Tables\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use VideoManager\Tables\VideoTable;

class VideoTableFactory implements FactoryInterface
{
    public function createService(
        ServiceLocatorInterface $serviceLocator
    ){
        $tableGateway = $serviceLocator->get(
            'VideoManager\Tables\VideoTableGateway'
        );
        $table = new VideoTable($tableGateway);
        return $table;
    }
}
