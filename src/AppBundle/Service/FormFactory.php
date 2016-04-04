<?php

namespace AppBundle\Service;

class FormFactory
{
    /**
     * @var
     */
    private static $form_factory;

    public function __construct($formFactory)
    {
        self::$form_factory = $formFactory;
    }

    public static function get() {
        return self::$form_factory;
    }
}