<?php
require_once "classes/carStorage.php";
require_once "classes/auth.php";
session_start();
$auth = new Auth();
if (isset($_GET['Car'])) {
    $carId = (int)$_GET['Car'];
    $repository = new CarRepository();
    $car = $repository->findById($carId);
}
else {
    $car = null;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<header>
    <div id="top-header">
        <div id="logo">
            <a href="index.php">IkarRental</a>
            <img src="images/logo.png" />
        </div>
        <nav>
                <?php
                 if (!$auth->is_authenticated()) {
                 ?>
                 <ul>
                 <li>
                    <a href="login.php">Bejelentkezés</a>
                </li>
                <li>
                    <a href="register.php">Regisztáció</a>
                </li>
            </ul>
            <?php }
            else{?>
                <ul>
                 <li>
                    <a href="logout.php">Kijelentkezés</a>
                </li>
                <li>
                    <a href="profil.php">Profil</a>
                </li>
            </ul>
            <?php } ?>
        </nav>
    </div>
    <div id="header-image-menu">
    </div>
</header>
<body>
<h2>Sikertelen foglalás</h2>
<p>A(z) <?=$car->brand?> <?=$car->model?> nem elérhető a megadott <?=$_GET['datef']?>-<?=$_GET['dateu']?> intervallumban. Próbaljon megadni egy másik intervallumot vagy keress egy másik járművet. </p>
<a href='index.php'> Vissza a jármű oldalára</a>
</body>
</html>