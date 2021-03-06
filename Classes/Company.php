<?php

namespace nlib\Hubspot\Classes;

use stdClass;

use nlib\Hubspot\Interfaces\CompanyInterface;
use nlib\Hubspot\Interfaces\HubspotInterface;
use nlib\Hubspot\Interfaces\OptionInterface;
use nlib\Hubspot\Interfaces\SearchInterface;

class Company extends Hubspot implements HubspotInterface, CompanyInterface {

    public function __construct() { $this->_base .= '/crm/v3/objects/companies'; $this->setVersion('v3'); parent::__construct(); }
    
    public function getCompany(int $id, array $options = []) : ?stdClass {

        $Company = $this->cURL($this->_base . '/' . $id . '?' . $this->getHapikey())
        ->setDebug(...$this->dd())
        ->get($options);

        return json_decode($Company);
    }

    public function getCompagnies(OptionInterface $Option) : ?stdClass {
        
        $Companies = $this->cURL($this->_base . '?' . $this->getHapikey())
        ->setDebug(...$this->dd())
        ->get(!empty($Option) ? $Option->toURL() : []);

        return json_decode($Companies);
    }

    public function search(SearchInterface $Search) : ?stdClass {

      $Companies = $this->cURL($this->_base . '/search?' . $this->getHapikey() . '&archived=true')
        ->setContentType(self::APPLICATION_JSON)
        ->setHttpheaders(['accept: application/json'])
        ->setDebug(...$this->dd())
        ->post($Search->jsonSerialize());

        return json_decode($Companies);
    }

    public function update(int $id, array $values) : ?stdClass {

        $update = $this->cURL($this->_base . '/' . $id . '?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setDebug(...$this->dd())
        ->patch($values);

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $update]);

        return json_decode($update);
    }
    
    public function create(array $values) : ?stdClass {

        $create = $this->cURL($this->_base . '/companies/?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setDebug(...$this->dd())
        ->post($values);

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $create]);

        return json_decode($create);
    }

    public function associate(int $id, array $contactid) : ?stdClass {

        $associate = $this->cURL($this->_base . '/companies/' . $id . '/contacts/' . $contactid . '?' . $this->getHapikey())
        ->setContentType(self::APPLICATION_JSON)
        ->setDebug(...$this->dd())
        ->put();

        $this->log([__CLASS__ . '::' . __FUNCTION__ => $associate]);

        return json_decode($associate);
    }
    
}