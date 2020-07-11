<?php

class ModelIndex extends Model {

    public function addTask($sName, $sEmail, $sText) {
        $oSTMT = $this->getDB()->prepare('INSERT INTO tasks (name, email, text) VALUES (?, ?, ?)');
        if($oSTMT->execute([$sName, $sEmail, $sText])) {
            return true;
        }
        return false;
    }

    public function getTaskByID($iID) {
        $oSTMT = $this->getDB()->prepare('SELECT * FROM tasks WHERE id = ?');
        if($oSTMT->execute([$iID]) && $oSTMT->rowCount() == 1) {
            return $oSTMT->fetch();
        }
        return false;
    }

    public function orderFieldExist($sFieldName) {
        $aList = ['name', 'email', 'is_complete'];
        if(in_array($sFieldName, $aList)) {
            return true;
        }
        return false;
    }

    public function orderByExist($sOrderBy) {
        $aList = ['ASC', 'DESC'];
        if(in_array($sOrderBy, $aList)) {
            return true;
        }
        return false;
    }

    public function editTask($sName, $sEmail, $sText, $bIsComplete, $bIsEdited, $iID) {
        $oSTMT = $this->getDB()->prepare('UPDATE tasks SET name = ?, email = ?, text = ?, is_complete = ?, is_edited = ? WHERE id = ?');
        if($oSTMT->execute([$sName, $sEmail, $sText, $bIsComplete, $bIsEdited, $iID])) {
            return true;
        }
        return false;
    }

    public function validateTask($sName, $sEmail, $sText) {
        $aErrors = [];
        if(!preg_match('/[a-zA-Zа-яёА-ЯЁ]{2,255}+$/i', $sName)) {
            $aErrors[] = 'Имя должно содержать только латинские или кирилические буквы, без пробелов. Быть не меньше 2 символов и не больше 255';
        }
        if(!filter_var($sEmail, FILTER_VALIDATE_EMAIL)) {
            $aErrors[] = 'E-mail введен некорректно';
        }
        if(strlen($sText) < 1 || strlen($sText) > 500) {
            $aErrors[] = 'Текст задачи должен быть не короче 1 символа и не длиннее 500 символов';
        }
        return $aErrors;
    }

    public function getTasksPage($iOrderField = 'id', $iOrderBy = 'DESC') {
        $aData = [
            'data' => [],
            'pagination' => []
        ];
        $iPage = (int) (isset($_GET['page'])) ? $_GET['page'] : 1;
        if($iPage < 1) $iPage = 1;
        $iCount = 0;
        $iLimit = 3;
        $iOffset = ($iPage - 1) * $iLimit;

        $oSTMT = $this->getDB()->query('SELECT COUNT(*) FROM tasks');
        if($oSTMT) {
            $iCount = (int) $oSTMT->fetchColumn(0);
            $iCount = ceil($iCount / $iLimit);
            $iCount = ($iCount < 1) ? 1 : $iCount;
        } else {
            die('Ошибка базы данных!');
        }

        $aData['pagination'] = $this->getPageListing($iPage, $iCount);

        $oSTMT = $this->getDB()->query("SELECT * FROM tasks ORDER BY $iOrderField $iOrderBy LIMIT $iOffset, $iLimit");
        if($oSTMT) {
            $aData['data'] = $oSTMT->fetchAll();
        } else {
            die('Ошибка базы данных!');
        }
        return $aData;
    }

    protected function getPageListing($iPage = 1, $iCountPage = 50, $iLeftRight=2) {
        $aPages  = [];

        if ( $iCountPage < 2 ) {
            return $aPages;
        }

        $iStartPage = ( $iPage - $iLeftRight );

        if( $iStartPage < 1 ) $iStartPage = 1;

        $iPageEnd = $iPage + $iLeftRight;

        if ( $iPageEnd > $iCountPage ) $iPageEnd = $iCountPage;


        $iPrevPage = ( $iPage > 1 ? $iPage - 1 : 1);
        $iNextPage = ( $iPage < $iCountPage ? $iPage + 1 : $iCountPage );


        $aPages['item']['f'] = array(
            'page'=>$iPrevPage,
            'href'=> '/?'. $this->getBuildQuery($iPrevPage),
            'active'=>$iPage > 1
        );

        $aPages['item']['l'] = array(
            'page'=>$iNextPage,
            'href'=> '/?'. $this->getBuildQuery($iNextPage),
            'active'=>$iPage < $iCountPage
        );

        $aPages['pages'] = array();

        for ($i=$iStartPage;$i<=$iPageEnd;$i++) {
            $aPages['pages'][$i]['page'] = $i;
            $aPages['pages'][$i]['href'] = '/?' . $this->getBuildQuery($i);
            $aPages['pages'][$i]['active'] = $i == $iPage;
        }

        return $aPages;
    }

    public function getBuildQuery($iPage) {
        $aGETS = $_GET;
        $aGETS['page'] = $iPage;
        return http_build_query($aGETS);
    }

}