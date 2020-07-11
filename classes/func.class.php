<?php

class Func {

    public static function page404() {
        http_response_code(404);
        exit;
    }

    static function getRequest($sName, $default=null, $sType=null){
        switch (strtolower($sType)) {
            default:
            case null:
                $aStorage = $_REQUEST;
                break;
            case 'get':
                $aStorage = $_GET;
                break;
            case 'post':
                $aStorage = $_POST;
                break;
        }

        if (isset($aStorage[$sName])) {
            if (is_string($aStorage[$sName])) {
                return trim(htmlspecialchars($aStorage[$sName]));
            } else {
                return $aStorage[$sName];
            }
        }
        return $default;
    }



}