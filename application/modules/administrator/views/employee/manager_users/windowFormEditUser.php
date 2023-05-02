<form id="form_avatar" style="width: 400px; margin: auto;">
    <p>
    <div class="title">Редактирование пользователя</div>
    </p>
    <p class="custom-form_field">
    <img class="avatar" src="/public/resources/account/<?= $data['avatar']?>" onerror="error404(this)"/>
    <input id="input_avatar" class="input_file" type="file" name="avatar" style="margin-top: 10px;"/>
    </p>
</form>
<form id="form_edit" style="width: 400px; margin: auto;">
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
    <p class="custom-form_field">
    <input placeholder="Логин" name="login" value="<?= $data['login']?>"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-checkbox_label">
        <input class="custom-checkbox" type="checkbox" placeholder="Пароль" <?= $data['is_admin'] === "true" ? "checked" : ""?>/>
        <div class="custom-checkbox_label">Должность администратор (Дает доступ к панели администратора)</div>
    </div>
    </p>
    <p>
    <div class="title">Смена пароля</div>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label">Введите новый пароль</div>
    <input type="password" placeholder="Пароль" name="password"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label">Повторите новый пароль</div>
    <input type="password" placeholder="Пароль" name="password_repeat"/>
    </p>
    <p style="height: 50px;">
        <button type="submit" style="float: right;">Обновить</button>
    </p>
</form>