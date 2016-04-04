<?php

namespace AppBundle\Import;

interface ImportInterface {

    public function setParameters($parameters);

    public function import();

    public function getSource();

}