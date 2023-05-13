<form id="form_add" style="width: 400px; margin: auto;">
    <p>
    <div class="title">Создание сотрудника</div>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Выберите пользователя</div>
    <select id="employee_list">
        <option value="" hidden disabled selected>Выбрать</option>
        <?php for($i = 0; $i < count($data['employees']); $i++):?>
            <option value="<?= $i?>">
                <?= $data['employees'][$i]['surname']." ".$data['employees'][$i]['name']." ".$data['employees'][$i]['patronymic']?>
            </option>
        <?php endfor;?>
    </select>
    </p>
    <p class="custom-form_field">
    <div class="custom-form_label star">Выберите должность</div>
    <select id="position_list">
        <option value="" hidden disabled selected>Выбрать</option>
        <?php for($i = 0; $i < count($data['positionsList']); $i++):?>
            <option value="<?= $i?>"><?= $data['positionsList'][$i]['name']?></option>
        <?php endfor;?>
    </select>
    </p>
    <p style="height: 50px;">
        <button type="submit" style="float: right;">Добавить</button>
    </p>
</form>