<form id="form_edit" style="width: 400px; margin: auto;">
    <p>
    <div class="title">Редактирование сотрудника</div>
    </p>
    <p >
    <div style="height: 40px; margin: 0 0 0 20px;">
        <div style="float: left;">
            <img class="avatar" src="/public/resources/account/<?= $data['employee']['user']['avatar']?>" onerror="error404(this)"/>
        </div>
        <div style="float: left; margin: 20px 0 0 20px;"><?= $data['employee']['user']['surname']." ". $data['employee']['user']['name']." ".$data['employee']['user']['patronymic']?></div>
    </div>
    </p>
    <p style="margin-top: 40px;">
    <div class="custom-form_label star">Выберите должность</div>
    <select id="position_list">
        <?php for($i = 0; $i < count($data['positionsList']); $i++):?>
            <option value="<?= $i?>" <?= $data['employee']['positions'][0]['id'] == $data['positionsList'][$i]['id'] ? "selected" : ""?>><?= $data['positionsList'][$i]['name']?></option>
        <?php endfor;?>
    </select>
    </p>
    <p style="height: 50px;">
        <button type="submit" style="float: right;">Изменить</button>
    </p>
</form>