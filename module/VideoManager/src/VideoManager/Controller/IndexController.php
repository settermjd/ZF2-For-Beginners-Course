<?php

namespace VideoManager\Controller;

use VideoManager\Models\Video;
use VideoManager\Tables\VideoTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\Iterator;
use Zend\Paginator\Adapter\ArrayAdapter;

class IndexController extends AbstractActionController
{
    const DEFAULT_RECORDS_PER_PAGE = 20;

    const DEFAULT_PAGE = 1;

    protected $videoTable;

    public function __construct(VideoTable $videoTable)
    {
        $this->videoTable = $videoTable;
    }

    public function indexAction()
    {
        $view = new ViewModel();

        $view->setVariables(array(
            'allRouteParams' => $this->params()->fromRoute(),
            'paramPage' => $this->params()->fromRoute('page', 'not set'),
            'results' => $this->getPaginator($this->videoTable->fetchMostRecent())
        ));

        if ($this->getRequest()->isGet()) {
            $view->setVariable(
                'allHeaderData', $this->getRequest()->getHeader('accept')
            );
        }
        
        return $view;
    }

    public function deleteAction()
    {
        $this->layout('video-layout');

        return new ViewModel();
    }

    public function viewAction()
    {
        $videoId = (int)$this->params()->fromRoute('id');

        $view = new ViewModel();

        if (!empty($videoId)) {
            if ($video = $this->videoTable->fetchById($videoId)) {
                $view->setVariable('video', $video);
            } else {
                $this->flashMessenger()->addInfoMessage(
                    'Unable to find that video. Perhaps a new one?'
                );
                return $this->redirect()->toRoute(
                    'video', array('action' => 'manage')
                );
            }
        }

        return $view;
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

    public function getPaginator($resultset = array())
    {
        if (is_array($resultset)) {
            $paginator = new Paginator(new ArrayAdapter($resultset));
        } elseif ($resultset instanceof \Iterator) {
            $paginator = new Paginator(new Iterator($resultset));
        } else {
            $paginator = new Paginator(new ArrayAdapter());
        }

        $paginator->setCurrentPageNumber(
            $this->params()->fromRoute('page', self::DEFAULT_PAGE)
        );
        $paginator->setItemCountPerPage(
            $this->params()->fromRoute('perPage', self::DEFAULT_RECORDS_PER_PAGE)
        );

        return $paginator;
    }

}

