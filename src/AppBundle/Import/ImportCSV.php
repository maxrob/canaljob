<?php


namespace AppBundle\Import;


class ImportCSV implements ImportInterface
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

    }
}