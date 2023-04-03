<?= $panel?>
<div class="panel_container">
    <div class="employee_container">
        <div class="employee_block">
            <div class="employee_avatar" style="background-image: url(/public/images/avatars/<?= $account['avatar']?>);"></div>
            <div class="employee_info">
                <div class="employee_label">
                    <span class="employee_label_title">ФИО: </span>
                    <span><?= $account['surname']." ".$account['name']." ".$account['patronymic']?></span>
                </div>
                <div class="employee_label">
                    <span class="employee_label_title">Дата рождения: </span>
                    <span><?= $account['date_of_birth']?></span>
                </div>
                <div class="employee_label" >
                    <div class="employee_label_title">Должности: </div>
                    <div class="employee_label_box">
                        <ul>
                            <?php foreach ($positions as $position):?>
                                <li><?= $position['name']?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <div>
                    <button id="logout">Выйти из аккаунта</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="module" src="/public/scripts/panel/employee.js"></script>