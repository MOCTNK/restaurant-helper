<?= $panel?>
<div class="panel_container">
    <?= $adminPanel?>
    <div class="admin_container">
        <div class="restaurant_list">
            <a href="/panel/admin/restaurants/add">
                <div class="restaurant_card">
                    <div class="restaurant_logo" style="background-image: url(/public/resources/restaurant/logo_plus.png);"></div>
                    <div class="restaurant_label">Добавить ресторан</div>
                </div>
            </a>
            <? for($i = 0; $i < count($restaurantsList); $i++):?>
                <a href="/panel/admin/restaurants/<?= $restaurantsList[$i]['id']?>">
                    <div class="restaurant_card">
                        <div class="restaurant_logo" style="background-image: url(/public/resources/restaurant/<?= $restaurantsList[$i]['logo']?>);"></div>
                        <div class="restaurant_label"><?= $restaurantsList[$i]['name']?></div>
                    </div>
                </a>
            <? endfor;?>
        </div>
    </div>
</div>