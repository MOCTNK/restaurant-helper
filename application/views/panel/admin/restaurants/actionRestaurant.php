<?= $panel?>
<div class="panel_container">
    <?= $adminPanel?>
    <div class="admin_container">
        <div class="menu">
            <?= $menuAdmin?>
        </div>
        <link href="/application/modules/<?= $moduleName?>/styles/main.css" rel="stylesheet">
        <link href="/application/modules/<?= $moduleName?>/styles/admin/<?= $actionName?>.css" rel="stylesheet">
        <div class="container"><?= $view?></div>
        <script type="text/javascript">
            const URL_ACTION = '/panel/admin/restaurants/<?= $idRestaurant?>/action/<?= $idAction?>';
            const URL_RESOURCES = '/public/resources';
            const URL_MODULE_RESOURCES = '/application/modules/<?= $moduleName?>/resources';
        </script>
        <script type="text/javascript" src="/application/modules/<?= $moduleName?>/scripts/main.js"></script>
        <script type="text/javascript" src="/application/modules/<?= $moduleName?>/scripts/admin/<?= $actionName?>.js"></script>
    </div>
</div>