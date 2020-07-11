<?php

class Model {
    private $oDB = null;

    public function getDB() {
        if($this->oDB == NULL) {
            $sDSN = "mysql:host=localhost;port=3306;dbname=task;charset=utf8";
            $aOptions = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->oDB = new PDO($sDSN, 'root', '', $aOptions);
        }
        return $this->oDB;
    }

}