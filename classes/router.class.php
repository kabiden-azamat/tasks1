<?php

class Router {
    protected $sAction;
    protected $sEvent;
    protected $aParams = [];
    protected $aParamsEventMatch = [];

    public function __construct() {
        $sURI = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
        $sURI = explode('?', $sURI);
        $sURI = $sURI[0];
        $sURI = substr($sURI, 1);
        $aURI = explode('/', $sURI);
        $this->sAction = (isset($aURI[0]) && !empty($aURI[0])) ? $aURI[0] : 'index';
        $this->sEvent = (isset($aURI[1]) && !empty($aURI[1])) ? $aURI[1] : 'index';
        if(count($aURI) > 2) {
            array_shift($aURI);
            array_shift($aURI);
            $this->aParams = $aURI;
        }
        $aURI = null;
        $sURI = null;
    }

    public function getAction() {
        return $this->sAction;
    }

    public function getEvent() {
        return $this->sEvent;
    }

    public function getParams() {
        return $this->aParams;
    }

    /**
     * @param $iParamIndex
     * @param bool|FALSE $sDefaultValue
     * @return bool
     */
    public function getParam($iParamIndex, $sDefaultValue = FALSE) {
        return isset($this->aParams[$iParamIndex]) ? $this->aParams[$iParamIndex] : $sDefaultValue;
    }

    /**
     * @param $aParamEventMatch
     */
    public function setParamEventMatch($aParamEventMatch) {
        $this->aParamsEventMatch = $aParamEventMatch;
    }

    /**
     * @param $iParamNum
     * @param null $iItem
     * @return null
     */
    public function getParamEventMatch($iParamNum, $iItem = null) {
        if (!is_null($iItem)) {
            if (isset($this->aParamsEventMatch['params'][$iParamNum][$iItem])) {
                return $this->aParamsEventMatch['params'][$iParamNum][$iItem];
            } else {
                return null;
            }
        } else {
            if (isset($this->aParamsEventMatch['event'][$iParamNum])) {
                return $this->aParamsEventMatch['event'][$iParamNum];
            } else {
                return null;
            }
        }
    }

}