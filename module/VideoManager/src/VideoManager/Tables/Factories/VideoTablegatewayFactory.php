<?php

namespace VideoManager\Tables\Factories;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\Hydrator\ArraySerializable;
use VideoManager\Models\Video;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;

class VideoTableGatewayFactory implements FactoryInterface
{
    public function createService(
        ServiceLocatorInterface $serviceLocator
    ){
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $hydrator = new ArraySerializable();
        $rowObjectPrototype = new Video();
        $resultSet = new HydratingResultSet(
            $hydrator, $rowObjectPrototype
        );
        return new TableGateway(
            'tblvideos', $dbAdapter, null, $resultSet
        );
    }
}
