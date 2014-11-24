<?php

namespace VideoManager\Forms;

use Zend\Form\Form;

class ManageRecordForm extends Form
{
    public function __construct()
    {
        parent::__construct('ManageRecordForm');
    }

    public function init()
    {
        $this->setAttribute('method', 'post');
        /*$this->setAttribute('class', 'form-horizontal')
             ->setAttribute('action', '/video/manage');*/

        // Add form elements
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'videoId',
            'options' => array(),
            'attributes' => array()
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'releaseDate',
            'options' => array(
                'label' => 'Release Date:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'release date'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'title',
            'options' => array(
                'label' => 'Title:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'title'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'directorId',
            'options' => array(
                'label' => 'Director:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'director'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'synopsis',
            'options' => array(
                'label' => 'Synopsis:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'synopsis'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'duration',
            'options' => array(
                'label' => 'Duration:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'duration'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'genre',
            'options' => array(
                'label' => 'Genre:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'genre'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Url',
            'name' => 'website',
            'options' => array(
                'label' => 'Website:'
            ),
            'attributes' => array(
                'class' => 'form-control',
                'placeholder' => 'website'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => 'Save'
            ),
            'attributes' => array(
                'class' => 'btn btn-default'
            )
        ));

        $this->get('submit')->setValue('Save');
    }
}
