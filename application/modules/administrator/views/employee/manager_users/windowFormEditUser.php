<form id="form_avatar" style="">
    <p>
    <div class="title">Редактирование пользователя</div>
    </p>
    <p class="custom-form_field">
    <div class="avatar" style="background-image: url(/public/resources/account/<?= $data['avatar']?>);"></div>
    <input id="input_avatar" class="input_file" type="file" name="avatar" style="margin-top: 10px;"/>
    </p>
</form>
<form id="form_edit" style="">
    <p class="custom-form_field">
    <input placeholder="Имя" name="name" value="<?= $data['name']?>"/>
    </p>
    <p class="custom-form_field">
    <input placeholder="Фамилия" name="surname" value="<?= $data['surname']?>"/>
    </p>
    <p class="custom-form_field">
    <input placeholder="Отчество" name="patronymic" value="<?= $data['patronymic']?>"/>
    </p>
    <p class="custom-form_field">
    <input type="date" name="date_of_birth" value="<?= $data['date_of_birth']?>"/>
    </p>
    <p style="height: 50px;">
        <button type="submit" style="float: right;">Обновить</button>
    </p>
</form>