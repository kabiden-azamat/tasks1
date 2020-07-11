<?php

class Render {
    private $sModuleTemplatesPath = '';
    private $sGlobalTemplatesPath = '';
    private $sGlobalTemplatesWebPath = '';
    private $sCurrentModuleTemplate = '';
    private $sTitle = '';
    private $aMessages = [];
    private $aVars = [];

    public function __construct() {
        $_SESSION['_messages_'] = (isset($_SESSION['_messages_'])) ? $_SESSION['_messages_'] : [];
        $this->sModuleTemplatesPath = $_SERVER['DOCUMENT_ROOT'] . DIR_SEP . 'modules' . DIR_SEP . Core::getRouter()->getAction() . DIR_SEP . 'templates' . DIR_SEP;
        $this->sGlobalTemplatesPath = $_SERVER['DOCUMENT_ROOT'] . DIR_SEP . 'view' . DIR_SEP;
        $this->sGlobalTemplatesWebPath = 'http://' . $_SERVER['HTTP_HOST'] . DIR_SEP . 'view' . DIR_SEP;
    }

    public function getWebTemplatePath() {
        return $this->sGlobalTemplatesWebPath;
    }

    public function setTitle($sTitle) {
        $this->sTitle = $sTitle;
    }

    public function getTitle() {
        return $this->sTitle;
    }

    public function putVar( $sVarName, $vValue ) {
        if(!preg_match( '/\A[a-zA-Z_]/', $sVarName ) ) throw new Exception( "Invalid variable name '{$sVarName}'", 1 );
        $this->aVars[ $sVarName ] = $vValue;
        return $this;
    }

    public function putVarArray($aVars) {
        foreach( $aVars as $sFldName=>$sFldValue ) {
            $this->putVar($sFldName, $sFldValue);
        }
        return $this;
    }

    public function _($sVar) {
        if(isset($this->aVars[$sVar])) {
            return $this->aVars[$sVar];
        } else {
            return false;
        }
    }

    public function __get($name) {
        if(isset($this->aVars[$name])) {
            return $this->aVars[$name];
        }
        if(isset($this->$name)) {
            return $this->$name;
        }
        return false;
    }

    public function addNotify($sText, $sUrl = false) {
        $this->addSysMessage($sText, $sUrl, 'info');
    }

    public function addMessage($sText, $sUrl = false) {
        $this->addSysMessage($sText, $sUrl, 'success');
    }

    public function addError($sText, $sUrl = false) {
        $this->addSysMessage($sText, $sUrl, 'error');
    }

    private function addSysMessage($sText, $sUrl = false, $sType = 'success') {
        $sId = 'id_' . md5($sType . $sText);
        $aMessage = [
            'text' => $sText,
            'type' => $sType,
            'id' => md5($sType . $sType)
        ];
        if($sUrl) {
            $aMessage['url'] = $sUrl;
        }
        $_SESSION['_messages_'][$sId] = $aMessage;
    }

    public function Run($sTemplateName) {
        header("Content-Type: text/html; charset=utf-8");
        $sTemplatePath = $this->sGlobalTemplatesPath . $sTemplateName . '.php';
        if(file_exists($sTemplatePath)) {
            require_once $sTemplatePath;

            $_SESSION['_messages_'] = NULL;
            unset($_SESSION['_messages_']);
        } else {
            die('Шаблон не найден!');
        }
    }

    public function setTemplate($sName) {
        $this->sCurrentModuleTemplate = $this->sModuleTemplatesPath . $sName . '.php';
        if(!file_exists($this->sCurrentModuleTemplate)) {
            die('Файл шаблона не найден!!');
        }
        return true;
    }

    public function loadTemplate() {
        if(file_exists($this->sCurrentModuleTemplate)) {
            include_once $this->sCurrentModuleTemplate;
            echo PHP_EOL;
        }
    }

    public function inc_tpl($sName) {
        if(file_exists($this->sGlobalTemplatesPath . $sName . '.php')) {
            include $this->sGlobalTemplatesPath . $sName . '.php';
        } else {
            die('Template file not found!');
        }
    }


}