<?php

namespace nlib\Hubspot\Classes;

use nlib\cURL\Interfaces\cURLConstantInterface;
use nlib\Hubspot\Interfaces\PropertyInterface;
use nlib\Hubspot\Interfaces\HubspotInterface;

class Property extends Hubspot implements HubspotInterface, cURLConstantInterface  {

    public function __construct() { $this->_base .= '/crm-objects/v1/objects/products'; parent::__construct(); }


    public function getProduct(int $id, array $options = []) {

        $product = $this->cURL($this->_base . '/' . $id . '?' . $this->getHapikey())
        ->setEncoding(self::JSON)
        ->get($options);

        return json_decode($product);
    }

    public function getProducts() {

        $products = $this->cURL($this->_base . '/paged?' . $this->getHapikey())
        ->setEncoding(self::JSON)
        ->get();

        return json_decode($products);
    }

    // public function update(string $property, array $values) {

    //     $update = $this->cURL($this->_base . '?' . $this->getHapikey())
    //     ->setEncoding(self::JSON)
    //     ->setContentType(self::APPLICATION_JSON)
    //     ->put($values);

    //     $this->log([__CLASS__ . '::' . __FUNCTION__ => $update]);
        
    //     return \json_decode($update);
    // }

    public function create(array $values) {

        $create = $this->cURL($this->_base . '?' . $this->getHapikey())
        ->setEncoding(self::JSON)
        ->setContentType(self::APPLICATION_JSON)
        ->post($values);

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $create]);

        return json_decode($create);
    }
}