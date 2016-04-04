<?php

namespace AppBundle\Import;

interface ImportInterface {

    public function import();

    public function getSource();
}