<a href="/panel/admin/restaurants/<?= $idRestaurant?>">
    <div class="menu_item <?= !isset($idAction) ? "menu_item_selected" : ""?>">Ресторан</div>
</a>
<?for($i = 0; $i < count($items); $i++):?>
    <a href="/panel/admin/restaurants/<?= $idRestaurant?>/action/<?= $items[$i]['id']?>">
        <div class="menu_item <?= isset($idAction) && $idAction == $items[$i]['id'] ? "menu_item_selected" : ""?>"><?= $items[$i]['name']?></div>
    </a>
<?endfor;?>
