<?if(!empty($_SESSION['_messages_'])):?>
    <div class="container">
    <div class="row">
    <div class="col-md-12">
    <?foreach($_SESSION['_messages_'] as $sKey => $aMessage):?>
        <?php
        $sType = '';
        switch($aMessage['type']) {
            case 'error':
                $sType = 'danger';
                break;
            case 'success':
                $sType = 'success';
                break;
            case 'info':
                $sType = 'info';
                break;
            default:
                $sType = 'info';
        }
        ?>
        <div class="alert alert-<?=$sType?>" role="alert">
            <?=$aMessage['text']?>
        </div>
    <?endforeach;?>
    </div>
    </div>
    </div>
<?endif;?>