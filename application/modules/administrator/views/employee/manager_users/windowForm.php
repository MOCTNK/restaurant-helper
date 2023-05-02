<form id="form_avatar" style="width: 400px; margin: auto;">
    <p>
    <div class="title">Создание нового пользователя</div>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label" style="margin-bottom: 10px;">Добавьте фото пользователя</div>
    <img class="avatar" src="/public/resources/account/avatar_default.png"/>
    <input id="input_avatar" class="input_file" type="file" name="avatar" style="margin-top: 10px;"/>
    </p>
</form>
<form id="form_add" style="width: 400px; margin: auto;">
    <p class="custom-form_field">
    <div class="custom-form_label star">Введите имя пользователя</div>
    <input placeholder="Имя" name="name"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Введите фамилию пользователя</div>
    <input placeholder="Фамилия" name="surname"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Введите отчество пользователя</div>
    <input placeholder="Отчество" name="patronymic"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Введите дату рождения пользователя</div>
    <input type="date" name="date_of_birth"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Введите логин</div>
    <input placeholder="Логин" name="login"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Введите пароль</div>
    <input type="password" placeholder="Пароль" name="password"/>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Повторите пароль</div>
    <input type="password" placeholder="Пароль" name="password_repeat"/>
    </p>
    <p class="custom-form_field">
        <div class="custom-checkbox_label">
            <input class="custom-checkbox" type="checkbox" placeholder="Пароль"/>
            <div class="custom-checkbox_label">Должность администратор (Дает доступ к панели администратора)</div>
        </div>
    </p>
    <p style="height: 50px;">
        <button type="submit" style="float: right;">Добавить</button>
    </p>
</form>