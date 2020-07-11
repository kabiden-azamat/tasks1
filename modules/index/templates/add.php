<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post" novalidate>
                <div class="form-group">
                    <label for="inputName">Имя</label>
                    <input type="text" name="name" class="form-control" id="inputName" value="<?=Func::getRequest('name')?>">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" value="<?=Func::getRequest('email')?>">
                </div>
                <div class="form-group">
                    <label for="inputText">Текст задачи</label>
                    <textarea class="form-control" name="text" id="inputText" rows="3"><?=Func::getRequest('text')?></textarea>
                </div>
                <button type="submit" name="add" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
</div>