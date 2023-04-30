<? for($i = 0; $i < count($modulesList); $i++):?>
    <? if($modulesList[$i]['init']) :?>
        <div class="module-card">
            <button id="<?= 'delete_'.$i?>" class="module-button" style="margin:0; background-color: #f0aaaa;">Отключить</button>
            <div class="module-info">
                <div class="module-title"><?= $modulesList[$i]['name']?></div>
                <div class="module-about"><?= $modulesList[$i]['about']?></div>
                <div class="module-field">Версия: <?= $modulesList[$i]['version']?></div>
                <div class="module-field">Автор: <?= $modulesList[$i]['author']?></div>
                <div class="module-field">Статус: <span style="color: green;">Подключен</span></div>
            </div>
        </div>
    <?endif;?>
<? endfor;?>
<? for($i = 0; $i < count($modulesList); $i++):?>
    <? if(!$modulesList[$i]['init']) :?>
        <div class="module-card">
            <button id="<?= 'init_'.$i?>" class="module-button" style="margin:0;">Подключить</button>
            <div class="module-info">
                <div class="module-title"><?= $modulesList[$i]['name']?></div>
                <div class="module-about"><?= $modulesList[$i]['about']?></div>
                <div class="module-field">Версия: <?= $modulesList[$i]['version']?></div>
                <div class="module-field">Автор: <?= $modulesList[$i]['author']?></div>
                <div class="module-field">Статус: <span style="color: red;">Отключен</span></div>
            </div>
        </div>
    <?endif;?>
<? endfor;?>