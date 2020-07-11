<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

define ('DIR_SEP', DIRECTORY_SEPARATOR);

spl_autoload_register('func_AutoloadClass', true, true);

function func_AutoloadClass($sClass_name) {
    $aPostfix = ['.class.php'];
    $aDirList = array(
        'classes' . DIR_SEP,
    );

    foreach($aDirList as $sDirPath) {
        foreach( $aPostfix as $sPostfix ) {
            $sClassPath = strtolower($sClass_name) . $sPostfix;

            if( file_exists($sDirPath . $sClassPath) ) {
                require_once($sDirPath . $sClassPath);
                return true;
            }
        }

    }
    return false;
}

Core::Run();