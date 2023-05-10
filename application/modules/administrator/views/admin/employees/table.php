<table id="custom_table">
    <tr>
        <th class="empty"></th>
        <th>id</th>
        <th>Фото</th>
        <th>ФИО</th>
        <th>Должность</th>
    </tr>
    <?php
        $i = 0;
    ?>
    <?php foreach($data as $employee):?>
        <tr class="<?= $i % 2 != 0 ? "tr-grey" : "tr-blue" ?>">
            <td class="empty">
                <div id="edit_<?= $i?>" class="button_table" style="background-image: url(/public/resources/table/icon_edit.png);"></div>
                <div id="delete_<?= $i?>" class="button_table" style="background-image: url(/public/resources/table/icon_delete.png); margin-left: 15px;"></div>
            </td>
            <td><?= $employee['user']['id']?></td>
            <td><img class="table_image" src="/public/resources/account/<?= $employee['user']['avatar']?>" onerror="error404(this)"></td>
            <td><?= $employee['user']['surname']." ".$employee['user']['name']." ".$employee['user']['patronymic']?></td>
            <td>
                <?php for($j = 0; $j < count($employee['positions']); $j++):?>
                    <li><?= $employee['positions'][$j]['name']?></li>
                <?php endfor;?>
                </ul>
            </td>
        </tr>
        <?php
            $i++;
        ?>
    <?php endforeach;?>
</table>