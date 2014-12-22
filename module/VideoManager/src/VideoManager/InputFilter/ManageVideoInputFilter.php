<?php

namespace VideoManager\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Filter\StringTrim;
use Zend\Filter\StripNewlines;
use Zend\Filter\StripTags;
use Zend\Validator;

class ManageVideoInputFilter extends InputFilter
{
    protected $requiredFields = array(
        'releaseDate', 'title', 'directorId', 'duration',
        'genre', 'synopsis'
    );

    protected $optionalFields = array(
        'videoId', 'website'
    );

    public function __construct()
    {
        $this->addRequiredFields()
            ->addOptionalFields();
    }

    protected function addRequiredFields()
    {
        foreach ($this->requiredFields as $fieldName) {
            $input = new Input($fieldName);
            $input->setRequired(true)
                ->setAllowEmpty(false)
                ->setBreakOnFailure(false)
                ->setFilterChain($this->getStandardFilter());

            switch ($fieldName) {
                case ("releaseDate"):
                    $input->getValidatorChain()
                        ->attach(new Validator\Date(
                                array(
                                    'format' => 'd-m-Y'
                                )
                            ));
                    break;
                case ("synopsis"):
                    $input->getValidatorChain()
                        ->attach(new Validator\StringLength(array(
                                    'max' => 500
                                )));
                    break;
            }

            $this->add($input);
        }

        return $this;
    }

    protected function addOptionalFields()
    {
        foreach ($this->optionalFields as $fieldName) {
            $input = new Input($fieldName);
            $input->setRequired(true)
                ->setAllowEmpty(true)
                ->setFilterChain($this->getStandardFilter());

            switch ($fieldName) {
                case ("videoId"):
                    $input->getValidatorChain()
                        ->attach(new Validator\Digits(array(
                                    'messageTemplates' => array(
                                        Validator\Digits::NOT_DIGITS => 'The value supplied is not a valid number',
                                        Validator\Digits::STRING_EMPTY => 'A value must be supplied',
                                        Validator\Digits::INVALID => 'The value supplied is not a valid number'
                                    )
                                )));
                    break;
            }

            $this->add($input);

        }

        return $this;
    }

    protected function getStandardFilter()
    {
        $baseInputFilterChain = new \Zend\Filter\FilterChain();
        $baseInputFilterChain->attach(new StringTrim())
            ->attach(new StripNewlines())
            ->attach(new StripTags());

        return $baseInputFilterChain;
    }
}
