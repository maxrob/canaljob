<?php


namespace AppBundle\Import;


class ImportXML implements ImportInterface
{
    /**
     * @var
     */
    private $parameters;

    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    public function getSource()
    {
        // TODO: Implement getSource() method.
    }

    public function import()
    {
        // TODO: Implement import() method.
    }
}