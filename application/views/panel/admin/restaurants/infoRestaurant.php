<?= $panel?>
<div class="panel_container">
    <?= $adminPanel?>
    <div class="admin_container">
        <div class="menu">
            <?= $menuAdmin?>
        </div>
        <div class="container">
            <div style="width: 300px; height: 100%; float: left;">
                <img class="employee_avatar" style="position: relative;" src="/public/resources/restaurant/<?= $restaurantsData['logo']?>" onerror="error404(this)">
            </div>
            <div style="width: calc(100% - 300px); height: 100%; float: left;">
                <div class="employee_label">
                    <span class="employee_label_title">Название: </span>
                    <span><?= $restaurantsData['name']?></span>
                </div>
                <div class="employee_label">
                    <span class="employee_label_title">Адрес: </span>
                    <span><?= $restaurantsData['address']?></span>
                </div>
                <div class="employee_label">
                    <span class="employee_label_title">Описание Ресторана: </span>
                    <span><?= $restaurantsData['about']?></span>
                </div>
                <div class="employee_label">
                    <button style="margin:0; background-color: #f0aaaa;">Удалить ресторан</button>
                </div>
            </div>
        </div>
    </div>
</div>