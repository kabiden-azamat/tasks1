<?php

class ControllerIndex extends Controller {

    public function init() {
        $this->addEventPreg('/^index$/i', '/^$/i', 'index');
        $this->addEventPreg('/^add$/i', '/^$/i', 'add');
        $this->addEventPreg('/^edit$/i', '/^[0-9]{1,11}$/i', '/^$/i', 'edit');
        $this->addEventPreg('/^login$/i', '/^$/i', 'login');
        $this->addEventPreg('/^logout$/i', '/^$/i', 'logout');
    }

    public function index() {
        $sOrderField = 'id';
        $sOrderBy = 'DESC';
        if(isset($_GET['filter'])) {
            if($this->getModel()->orderFieldExist(Func::getRequest('order_field'))) {
                $sOrderField = Func::getRequest('order_field');
            }
            if($this->getModel()->orderByExist(Func::getRequest('order_by'))) {
                $sOrderBy = Func::getRequest('order_by');
            }
        }
        $this->getRender()->putVar('aData', $this->getModel()->getTasksPage($sOrderField, $sOrderBy));
        $this->getRender()->setTitle('Главная');
        $this->getRender()->setTemplate('index');
        $this->getRender()->Run('index');
    }

    public function add() {
        if(isset($_POST['add'])) {
            $sName = trim(htmlspecialchars($_POST['name']));
            $sEmail = trim(htmlspecialchars($_POST['email']));
            $sText = trim(htmlspecialchars($_POST['text']));
            $aValidation = $this->getModel()->validateTask($sName, $sEmail, $sText);
            if(empty($aValidation)) {
                if($this->getModel()->addTask($sName, $sEmail, $sText)) {
                    $this->getRender()->addMessage('Задача успешно создана!');
                    Header('Location: / ');
                    exit;
                } else {
                    $this->getRender()->addError('Произошла ошибка базы данных!');
                }
            } else {
                foreach($aValidation as $sErrorText) {
                    $this->getRender()->addError($sErrorText);
                }
            }
        }
        $this->getRender()->setTitle('Создание задачи');
        $this->getRender()->setTemplate('add');
        $this->getRender()->Run('index');
    }

    public function edit() {
        if(!Users::isAuth()) {
            $this->getRender()->addError('Вы не авторизованы!');
            Header('Location: / ');
            exit;
        }
        $iID = Core::getRouter()->getParam(0);
        if($aData = $this->getModel()->getTaskByID($iID)) {
            $this->getRender()->putVar('aData', $aData);
        } else {
            $this->getRender()->addError('Задача не найдена!');
            Header('Location: / ');
            exit;
        }

        if(isset($_POST['edit'])) {
            $bIsEdited = $aData['is_edited'];
            $sName = Func::getRequest('name');
            $sEmail = Func::getRequest('email');
            $sText = Func::getRequest('text');
            if($sName != $aData['name']) $bIsEdited = 1;
            if($sEmail != $aData['email']) $bIsEdited = 1;
            if($sText != $aData['text']) $bIsEdited = 1;
            $bIsComplete = Func::getRequest('is_complete');
            if($bIsComplete)  $bIsComplete = 1; else $bIsComplete = NULL;
            $aValidation = $this->getModel()->validateTask($sName, $sEmail, $sText);
            if(empty($aValidation)) {
                if($this->getModel()->editTask($sName, $sEmail, $sText, $bIsComplete, $bIsEdited, $iID)) {
                    $this->getRender()->addMessage('Задача успешно отредактирована!');
                    Header('Location: / ');
                    exit;
                } else {
                    $this->getRender()->addError('Произошла ошибка базы данных!');
                }
            } else {
                foreach($aValidation as $sErrorText) {
                    $this->getRender()->addError($sErrorText);
                }
            }
        }

        $this->getRender()->setTitle('Редактирование задачи');
        $this->getRender()->setTemplate('edit');
        $this->getRender()->Run('index');
    }

    public function login() {
        if(Users::isAuth()) {
            Header('Location: / ');
            exit;
        }
        if(isset($_POST['auth'])) {
            if(Users::Auth(Func::getRequest('login'), Func::getRequest('password'))) {
                $this->getRender()->addMessage('Авторизация прошла успешно!');
                Header('Location: / ');
                exit;
            } else {
                $this->getRender()->addError('Неверный логин или пароль!');
            }
        }
        $this->getRender()->setTitle('Авторизация');
        $this->getRender()->setTemplate('login');
        $this->getRender()->Run('index');
    }

    public function logout() {
        $this->getRender()->addMessage('Вы вышли с аккаунта');
        Users::logout();
        Header('Location: / ');
    }

}