<?php

namespace hubspotSA\Classes;

use nlib\Hubspot\Interfaces\HubspotInterface;
use nlib\Path\Classes\Path;
use nlib\cURL\Traits\cURLTrait;
use nlib\Log\Traits\LogTrait;
use nlib\Yaml\Traits\ParserTrait;
use nlib\Tool\Traits\ArrayTrait;

abstract class Hubspot implements HubspotInterface {

    use ParserTrait;
    use cURLTrait;
    use ArrayTrait;
    use LogTrait;

    private $_hapikeys = [];

    public function __construct() {
        if(array_key_exists('hapikey', $configs = $this->Parser()->get(Path::i()->getConfig() . 'config')))
        $this->setHapikeys($configs['hapikey']);
    }

    public function getHapikeys() : array {
        if(empty($this->_hapikeys) || !array_key_exists('hapikey', $this->_hapikeys)) $this->dlog(['Hubspot' => 'Var "hapikeys" is not correct.']);
        return $this->_hapikeys;
    }
    public function getHapikey() : string { return $this->assoc_to_GET($this->getHapikeys(), 1); }

    public function setHapikeys(string $hapikey) : self { $this->_hapikeys['hapikey'] = $hapikey; return $this; }
}