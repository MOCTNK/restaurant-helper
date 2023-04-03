<div class="panel">
    <div class="panel_menu">
        <a href="/panel/employee"><button class="panel_button <?php if($action == "employee") echo "panel_button_white";?>">Панель сотрудника</button></a>
        <?php if($isAdmin): ?>
            <a href="/panel/admin"><button class="panel_button <?php if($action == "admin") echo "panel_button_white";?>">Панель администратора</button></a>
        <?php endif; ?>
    </div>
    <div class="panel_account"><?= $userName?></div>
</div>