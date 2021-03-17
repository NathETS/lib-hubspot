<?php

namespace nlib\Hubspot\Classes;

use nlib\Hubspot\Interfaces\CompanyInterface;
use nlib\Hubspot\Interfaces\HubspotInterface;
use stdClass;

class Company extends Hubspot implements HubspotInterface, CompanyInterface {

    public function __construct() { $this->_base .= '/crm/v3/objects/companies'; parent::__construct(); }
    
    public function getCompany(int $id, array $options = []) {

        $Company = $this->cURL($this->_base . '/' . $id . '?' . $this->getHapikey())
        ->setDebug(...$this->dd())
        ->get($options);

        return json_decode($Company);
    }

    public function getCompagnies(array $options = []) {
        
        $Companies = $this->cURL($this->_base . '?' . $this->getHapikey())
        ->setDebug(...$this->dd())
        ->get($options);

        return json_decode($Companies);
    }

    public function search(string $domain, array $options = []) : ?stdClass {

        $Companies = $this->cURL($this->_base . '/search?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setHttpheaders(['accept: application/json'])
        ->setDebug(...$this->dd())
        ->post(['filterGroups' => [['filters' => [['propertyName' => 'name', 'operator' => 'EQ', 'value' => 'loremipsumcompany']]]]]);

        return json_decode($Companies);
    }

    public function update(int $id, array $values) {

        $update = $this->cURL($this->_base . '/' . $id . '?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setDebug(...$this->dd())
        ->put($values);

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $update]);

        return json_decode($update);
    }
    
    public function create(array $values) {

        $create = $this->cURL($this->_base . '/companies/?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setDebug(...$this->dd())
        ->post($values);

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $create]);

        return json_decode($create);
    }

    public function associate(int $id, array $contactid) {

        $associate = $this->cURL($this->_base . '/companies/' . $id . '/contacts/' . $contactid . '?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setDebug(...$this->dd())
        ->put();

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $associate]);

        return json_decode($associate);
    }
    
}