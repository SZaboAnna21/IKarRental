<?php

require_once "classes/auth.php";
$auth = new Auth();
function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
}
function validate($input, &$errors, $auth)
{

    if (is_empty($input, "fullname")) {
        $errors[] = "Teljesnev megadása kötelező";
    }
    if (is_empty($input, "email")) {
        $errors[] = "Email megadása kötelező";
    }
    if (is_empty($input, "password")) {
        $errors[] = "Jelszó megadása kötelező";
    }
    if (count($errors) == 0) {
        if ($auth->user_exists($input['email'])) {
            $errors[] = "User already exists";
        }
   
    }

    return !(bool) $errors;
}

$errors = [];
if (count($_POST) != 0) {
    if (validate($_POST, $errors, $auth)) {
        $auth->register($_POST);
        header('Location: login.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<header>
    <div id="top-header">
        <div id="logo">
            <a href="index.php">IkarRental</a>
            <img src="images/logo.png" />
        </div>
        <nav>
            <ul>
                <li class="active">
                    <a href="login.php">Bejelentkezés</a>
                </li>
                <li>
                    <a href="register.php">Regisztáció</a>
                </li>
            </ul>
        </nav>
    </div>
    <div id="header-image-menu">
    </div>
</header>
    <h2>Regisztráció</h2>
    <?php if ($errors) {?>
    <ul>
        <?php foreach ($errors as $error) {?>
        <li><?=$error?></li>
        <?php }?>
    </ul>
    <?php }?>
    <form action="" method="post">
        <label for="fullname">Teljes név: </label>
        <input id="fullname" name="fullname" type="text"><br>
        <label for="email">eamil: </label>
        <input id="email" name="email" type="text"><br>
        <label for="password">Jelszó: </label>
        <input id="password" name="password" type="password"><br>
        <input type="submit" value="Regisztráció">
    </form>
    <a href="login.php">Bejelentkezés</a>
</body>

</html>