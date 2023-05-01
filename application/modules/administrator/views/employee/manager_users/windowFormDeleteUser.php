<form id="form_delete" style="">
    <p>
    <div class="title">Удалить пользователя?</div>
    </p>
    <p>
        <div style="height: 40px; margin: 0 0 0 20px;">
            <div style="float: left;">
                <img class="avatar" src="/public/resources/account/<?= $data['avatar']?>" onerror="error404(this)"/>
            </div>
            <div style="float: left; margin: 20px 0 0 20px;"><?= $data['surname']." ". $data['name']." ".$data['patronymic']?></div>
        </div>
    </p>
    <p style="height: 50px;">
        <button class="button_red" type="submit" style="float: right;">Удалить</button>
    </p>
</form>
