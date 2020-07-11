<div class="container">
    <div class="row">
        <div class="col-md-12 mb-md-5">
            <a class="btn btn-outline-success" href="/index/add/">Создать задачу</a>
        </div>
        <?php
            $aData = $this->_('aData');
        ?>
        <div class="col-md-12">
            <form action="">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Сортировать по</label>
                            <select class="form-control" name="order_field" id="exampleFormControlSelect1">
                                <option value="name" <?if(Func::getRequest('order_field') == 'name'):?>selected<?endif;?>>Имени</option>
                                <option value="email" <?if(Func::getRequest('order_field') == 'email'):?>selected<?endif;?>>E-mail</option>
                                <option value="is_complete" <?if(Func::getRequest('order_field') == 'is_complete'):?>selected<?endif;?>>Статусу</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">&nbsp;</label>
                            <select class="form-control" name="order_by" id="exampleFormControlSelect1">
                                <option value="ASC" <?if(Func::getRequest('order_by') == 'ASC'):?>selected<?endif;?>>По возрастанию</option>
                                <option value="DESC" <?if(Func::getRequest('order_by') == 'DESC'):?>selected<?endif;?>>По убыванию</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">&nbsp;</label>
                            <button type="submit" name="filter" class="btn btn-primary form-control">Применить</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Имя</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Задача</th>
                    <th scope="col">Статус</th>
                    <?if(Users::isAuth()):?><th scope="col"></th><?endif;?>
                </tr>
                </thead>
                <tbody>
                <?if(!empty($aData['data'])):?>
                <?foreach($aData['data'] as $iKey => $aItem):?>
                <tr>
                    <th scope="row"><?=$iKey+1?></th>
                    <td><?=$aItem['name']?></td>
                    <td><?=$aItem['email']?></td>
                    <td><?=$aItem['text']?></td>
                    <td>
                        <?if($aItem['is_complete']):?>Выполнено<?else:?>В ожидании<?endif;?>
                        <?if($aItem['is_edited']):?>, Отредактировано администратором<?endif;?>
                    </td>
                    <?if(Users::isAuth()):?>
                        <td>
                            <a href="/index/edit/<?=$aItem['id']?>" class="btn btn-primary">Редактировать</a>
                        </td>
                    <?endif;?>
                </tr>
                <?endforeach;?>
                <?endif;?>
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <?if( count($aData['pagination']) > 1 ):?>
                <div class="text-center">
                    <ul class="pagination">
                        <?if($aData['pagination']['item']['f']['active']):?>
                            <li class="page-item"><a href="<?=$aData['pagination']['item']['f']['href']?>" class="page-link" aria-label="Previous"><span aria-hidden="false">«</span></a></li>
                        <?else:?>
                            <li class="page-item disabled"><a href="javascript:void(0);" class="page-link" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                        <?endif;?>

                        <?foreach ($aData['pagination']['pages'] as $_aPage):?>
                            <?if ($_aPage['active']):?>
                                <li class="page-item active"><a href="" class="page-link"><?=$_aPage['page']?> <span class="sr-only">(current)</span></a></li>
                            <?else:?>
                                <li class="page-item"><a href="<?=$_aPage['href']?>" class="page-link"><?=$_aPage['page']?></a></li>
                            <?endif;?>
                        <?endforeach?>

                        <?if($aData['pagination']['item']['l']['active']):?>
                            <li class="page-item"><a href="<?=$aData['pagination']['item']['l']['href']?>" class="page-link" aria-label="Next"><span aria-hidden="false">»</span></a></li>
                        <?else:?>
                            <li class="page-item disabled"><a href="javascript:void(0);" class="page-link" aria-label="Previous"><span aria-hidden="true">»</span></a></li>
                        <?endif;?>
                    </ul>
                </div>
            <?endif;?>
        </div>
    </div>
</div>