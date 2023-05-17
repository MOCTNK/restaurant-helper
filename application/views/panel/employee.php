<?= $panel?>
<div class="panel_container">
    <div class="employee_container">
        <div class="employee_block">
            <img class="employee_avatar" src="/public/resources/account/<?= $account['avatar']?>" onerror="error404(this)">
            <div class="employee_info">
                <div class="employee_label">
                    <span class="employee_label_title">ФИО: </span>
                    <span><?= $account['surname']." ".$account['name']." ".$account['patronymic']?></span>
                </div>
                <div class="employee_label">
                    <span class="employee_label_title">Дата рождения: </span>
                    <span><?= sqlToDate($account['date_of_birth'])?></span>
                </div>
                <div class="employee_label" >
                    <div class="employee_label_title">Должности: </div>
                    <div class="employee_label_box">
                        <ul>
                            <?php foreach ($account['positions'] as $position):?>
                                <li><?= $position['name']?></li>
                            <?php endforeach;?>
                        </ul>
                    </div>
                </div>
                <div>
                    <button style="margin:0; background-color: #f0aaaa;"  id="logout">Выйти из аккаунта</button>
                </div>
            </div>
        </div>
        <div>
            <?php foreach ($menuEmployee as $item):?>
                <a href="/panel/employee/action/<?= $item['id']?>">
                    <div class="menu_employee_card">
                        <img class="menu_employee_card_icon" src="/application/modules/<?= $item['module_name']?>/resources/action/<?= $item['action'].'.png'?>" onerror="error404(this)">
                        <div class="menu_employee_card_label"><?= $item['name']?></div>
                    </div>
                </a>
            <?php endforeach;?>
        </div>
    </div>
</div>
<script type="module" src="/public/scripts/panel/employee.js"></script>