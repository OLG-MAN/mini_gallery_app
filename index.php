<?php

require __DIR__ . '/auth.php';
$login = getUserLogin();

?>

<html>

<head>
    <title>Photo_app</title>
    <style>
        html,
        body {
            height: 100%;
        }

        html {
            display: table;
            margin: auto;
        }

        body {
            display: table-cell;
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <?php

    if ($login === null) {
        echo 'Фото не доступны ';
    } else {
        $files = scandir(__DIR__ . '/uploads');
        $links = [];


        foreach ($files as $fileName) {
            if ($fileName === '.' || $fileName === '..') {
                continue;
            }
            $links[] = 'https://localhost:8000/uploads/' . $fileName;
        }

        foreach ($links as $link) : ?>
            <a href="<?= $link ?>"><img src="<?= $link ?>" height="150px"></a>
    <?php endforeach;
    }
    ?>



    <br><br>


    <?php if ($login === null) : ?>
        <a href="/login.php" style="text-decoration:none;"> Авторизуйтесь </a>
    <?php else : ?> Добро пожаловать, <?= $login ?><br><br>

        <a href="/logout.php" style="text-decoration:none;">Выйти</a>
        <a href="/upload.php" style="text-decoration:none;">Загрузить фото</a>
    <?php endif; ?>

</body>

</html>