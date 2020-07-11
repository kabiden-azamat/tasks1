<?php
    $aData = $this->aData;
    if(Func::getRequest('name')) $aData['name'] = Func::getRequest('name');
    if(Func::getRequest('email')) $aData['email'] = Func::getRequest('email');
    if(Func::getRequest('text')) $aData['text'] = Func::getRequest('text');
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post">
                <div class="form-group">
                    <label for="inputName">Имя</label>
                    <input type="text" name="name" class="form-control" id="inputName" value="<?=$aData['name']?>">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" value="<?=$aData['email']?>">
                </div>
                <div class="form-group">
                    <label for="inputText">Текст задачи</label>
                    <textarea class="form-control" name="text" id="inputText" rows="3"><?=$aData['text']?></textarea>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="is_complete" class="form-check-input" id="isComplete" value="1" <?if($aData['is_complete']):?>checked<?endif;?>>
                    <label class="form-check-label" for="isComplete">Выполнено</label>
                </div>
                <button type="submit" name="edit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
</div>