<?php

namespace VideoManager\Controller;

use VideoManager\Models\Video;
use VideoManager\Tables\VideoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $videoTable;

    public function __construct(VideoTable $videoTable)
    {
        $this->videoTable = $videoTable;
    }

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
            'car' => 'Porsche 911',
            'records' => $this->videoTable->fetchMostRecent()
        ));
        
        return $view;
    }

    public function deleteAction()
    {
        $this->layout('video-layout');

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
        $formManager = $this->serviceLocator->get('FormElementManager');
        $form = $formManager->get('VideoManager\Forms\ManageRecordForm');

        $videoId = (int)$this->params()->fromRoute('id');

        if ($this->getRequest()->isGet()) {
            if (!empty($videoId)) {
                if ($video = $this->videoTable->fetchById($videoId)) {
                    $form->setData($video->getArrayCopy());
                } else {
                    $this->flashMessenger()->addInfoMessage(
                        'Unable to find that video. Perhaps a new one?'
                    );
                    return $this->redirect()->toRoute(
                        'video', array('action' => 'manage')
                    );
                }
            }
        }

        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $video = new Video();
                $video->exchangeArray($form->getData());
                if ($this->videoTable->save($video)) {
                    if ($video->videoId) {
                        $this->flashMessenger()->addInfoMessage('Video updated');
                    } else {
                        $this->flashMessenger()->addInfoMessage('New video created');
                    }
                }

                return $this->redirect()->toRoute('video', array());
            }
        }

        return new ViewModel(array(
            'form' => $form,
            'messages' => array(
                'info' => $this->flashMessenger()->hasInfoMessages()
            )
        ));
    }


}

