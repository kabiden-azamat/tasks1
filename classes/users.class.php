<?php

class Users extends Singleton {
    private static $bIsAuth = false;
    private static $sLogin = 'admin';
    private static $sPassword = '123';
    private static $sSecretKey = 'ASda=';

    public static function Auth($sLogin, $sPassword) {
        if($sLogin == self::$sLogin && $sPassword == self::$sPassword) {
            $_SESSION['access_token'] = self::GenToken($sLogin, $sPassword);
            return true;
        }
        return false;
    }

    private static function GenToken($sLogin, $sPassword) {
        return md5($sLogin . $sPassword . self::$sSecretKey);
    }

    private static function CheckToken($sToken) {
        if(self::GenToken( self::$sLogin,  self::$sPassword) == $sToken) {
            return true;
        }
        return false;
    }

    public static function isAuth() {
        if( self::$bIsAuth) return true;
        if(isset($_SESSION['access_token']) && strlen($_SESSION['access_token']) == 32) {
            if(self::CheckToken($_SESSION['access_token'])) {
                self::$bIsAuth = true;
                return true;
            }
        }
        return false;
    }

    public static function logout() {
        $_SESSION['access_token'] = null;
        unset($_SESSION['access_token']);
        return true;
    }

}