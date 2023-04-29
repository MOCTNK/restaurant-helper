<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?= $title?></title>
    <link rel="shortcut icon" href="/public/resources/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="/public/scripts/lib/jquery.js"></script>
    <script type="text/javascript" src="/public/scripts/main.js"></script>
    <?= $head?>
</head>
<body>
    <div class="messages-box"></div>
    <?= $content?>
</body>
<?= $afterBody?>
</html>
