<?php

namespace AppBundle\Import;

interface ImportInterface {

    public function setParameters($parameters);

    public function import();

    public function getSource($url);

    public function constructObject($data);

    public function getAddressData($address);

    public function getCorrespondence($domain , $type);

    public function validateAndSubmitObject();

}