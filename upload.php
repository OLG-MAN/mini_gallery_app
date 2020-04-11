<?php

require __DIR__ . '/auth.php';
$login = getUserLogin();

if (!empty($_FILES['attachment'])) {
    $file = $_FILES['attachment'];

    $srcFileName = $file['name'];
    $newFilePath = __DIR__ . '\upload' . $srcFileName;
    $fileSize = $file['size'];
    $limitBytes  = 1024 * 1024 * 8;
    $limitWidth  = 1920;
    $limitHeight = 1080;
    $filePath = $file['tmp_name'];
    $image = getimagesize($filePath);
    $srcFileName = $file['name'];
    $newFilePath = __DIR__ . '/uploads/' . $srcFileName;

    $allowedExtensions = ['jpg', 'png', 'gif'];
    $extension = pathinfo($srcFileName, PATHINFO_EXTENSION);

    if ($fileSize > $limitBytes) {
        $error = 'Размер файла слишком большой';
    } elseif ($file['error'] == UPLOAD_ERR_INI_SIZE) {
        $error = 'Размер файла слишком большой';
    } elseif ($image[1] > $limitHeight || $image[0] > $limitWidth){
        $error = 'Привышенно допустимое разрешение картинки';
    } elseif (!in_array($extension, $allowedExtensions)) {
        $error = 'Загрузка файлов с таким расширением запрещена!';
    } elseif ($file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Ошибка при загрузке файла.';
    } elseif (file_exists($newFilePath)) {
        $error = 'Файл с таким именем уже существует';
    } elseif (!move_uploaded_file($filePath, $newFilePath)) {
        $error = 'Ошибка при загрузке файла';
    } else {
        $result = 'Фото загружено - ' . $srcFileName;
    }
}
?>
<html>
<head>
    <title>Загрузка файла</title>
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
<?php if ($login === null): ?>
    <a href="/login.php">Авторизуйтесь</a>
<?php else: ?>
    Добро пожаловать, <?= $login ?> |
    <a href="/logout.php"style="text-decoration:none;">Выйти</a>
    <a href="/index.php" style="text-decoration:none;">На Главную</a>
    <br>
    <br>
    <?php if (!empty($error)): ?>
        <?= $error ?>
    <?php elseif (!empty($result)): ?>
        <?= $result ?>
    <?php endif; ?>
    <br>
    <br>
    <form action="/upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="attachment">
        <input type="submit">
    </form>
<?php endif; ?>
</body>
</html>
