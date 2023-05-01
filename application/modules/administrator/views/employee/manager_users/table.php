<table id="custom_table">
    <tr>
        <th class="empty"></th>
        <th>id</th>
        <th>Фото</th>
        <th>ФИО</th>
        <th>Дата рождения</th>
        <th>Логин</th>
        <th>Админ</th>
        <th>Дата создания</th>
    </tr>
    <?php for($i = 0; $i < count($data); $i++):?>
    <tr class="<?= $i % 2 != 0 ? "tr-grey" : "tr-blue" ?>">
        <td class="empty">
        <div id="edit_<?= $i?>" class="button_table" style="background-image: url(/public/resources/table/icon_edit.png);"></div>
        <div id="delete_<?= $i?>" class="button_table" style="background-image: url(/public/resources/table/icon_delete.png); margin-left: 15px;"></div>
        </td>
        <td><?= $data[$i]['id']?></td>
        <td><img class="table_image" src="/public/resources/account/<?= $data[$i]['avatar']?>" onerror="error404(this)"></td>
        <td><?= $data[$i]['surname']." ".$data[$i]['name']." ".$data[$i]['patronymic']?></td>
        <td><?= sqlToDate($data[$i]['date_of_birth'])?></td>
        <td><?= $data[$i]['login']?></td>
        <td><?= $data[$i]['is_admin']?></td>
        <td><?= $data[$i]['date']?></td>
    </tr>
    <?php endfor;?>
</table>