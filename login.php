<?php
if (!empty($_POST)) {
    require __DIR__ . '/auth.php';

    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (checkAuth($login, $password)) {
        setcookie('login', $login, 0, '/');
        setcookie('password', $password, 0, '/');
        header('Location: /index.php');
    } else {
        $error = 'Ошибка авторизации';
    }
}
?>
<html>
<head>
    <title>Форма авторизации</title>    
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
<?php if (isset($error)): ?>
<span style="color: red;">
    <?= $error ?>
</span>
<?php endif; ?>
<form action="/login.php" method="post">
    <label for="login"> Логин : </label><input type="text" name="login" id="login">
    <br>
    <br>
    <label for="password"> Пароль: </label><input type="password" name="password" id="password">
    <br>
    <br>
    <input type="submit" value="Войти">
</form>
</body>
</html>
