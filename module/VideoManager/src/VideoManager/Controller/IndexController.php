<?php

namespace VideoManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        $view = new ViewModel(array(
            'music' => 'rock',
            'artist' => 'pearl jam'
        ));

        $view->setVariable('socialMedia', 'Google+');

        $view->setVariables(array(
            'networks' => array(
                'Twitter', 'Google+', 'LinkedIn', 'Facebook'
            ),
            'car' => 'Porsche 911'
        ));

        $view->setTemplate('simple-output');

        return $view;
    }

    public function deleteAction()
    {
        return new ViewModel();
    }

    public function viewAction()
    {
        return new ViewModel();
    }

    public function searchAction()
    {
        return new ViewModel();
    }

    public function manageAction()
    {
        return new ViewModel();
    }


}

