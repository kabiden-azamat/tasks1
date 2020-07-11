<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form action="" method="post">
                <div class="form-group">
                    <label for="inputLogin">Логин</label>
                    <input type="text" name="login" class="form-control" id="inputLogin" aria-describedby="emailHelp" value="<?=Func::getRequest('login')?>">
                </div>
                <div class="form-group">
                    <label for="inputPassword">Пароль</label>
                    <input type="password" name="password" class="form-control" id="inputPassword" value="<?=Func::getRequest('password')?>">
                </div>
                <button type="submit" name="auth" class="btn btn-primary">Войти</button>
            </form>
        </div>
    </div>
</div>