<?php
require_once "classes/carStorage.php";

session_start();

$repository = new CarRepository();
$cars = $repository->All() 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
    <div id="top-header">
        <div id="logo">
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

<body>

    <?php 
    
    ?>
    <ul>
        <?php
        foreach ( $cars as $car){
        echo '<li>' . $car->brand . '</li>';
        }

?>
    </ul>

    <?php ?>
</body>

</html>