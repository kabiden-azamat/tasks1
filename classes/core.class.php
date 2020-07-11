<?php

class Core extends Singleton {

    private static $oRouter = NULL;

    public static function getRouter() {
        if(self::$oRouter == NULL) {
            self::$oRouter = new Router();
        }
        return self::$oRouter;
    }

    public static function Run() {
        if(class_exists('Router')) {
            $sAction = self::getRouter()->getAction();
            $sModulesPath = $_SERVER['DOCUMENT_ROOT'] . DIR_SEP . 'modules' . DIR_SEP;
            $sControllerPath = $sModulesPath . $sAction . DIR_SEP . 'controller.php';
            if(file_exists($sControllerPath)) {
                require_once $sControllerPath;
                $sControllerClassName = 'Controller' . ucfirst($sAction);
                if(class_exists($sControllerClassName)) {
                    $oModel = null;
                    $sModelPath = $sModulesPath . $sAction . DIR_SEP . 'model.php';
                    if(file_exists($sModelPath)) {
                        require_once $sModelPath;
                        $sModelClassName = 'Model' . ucfirst($sAction);
                        if(class_exists($sModelClassName)) {
                            $oModel = new $sModelClassName();
                        }
                    }
                    $oController = new $sControllerClassName($oModel);
                    if(method_exists($oController, 'init')) {
                        $oController->init();
                        $oController->execEvent();
                    } else {
                        die('Не удалось инициализировать контроллер!');
                    }
                } else {
                    die('Класс контроллера не найден!');
                }
            } else {
                die('Контроллер не найден!');
            }
        } else {
            die('Класс Router не найден!');
        }
    }

}