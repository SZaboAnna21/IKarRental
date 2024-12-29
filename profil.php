<?php
require_once "classes/carStorage.php";
require_once "classes/auth.php";
require_once "classes/orderStorage.php";
$auth = new Auth();

$carRepository = new CarRepository();
$email = $_SESSION["user"];
$users = new UserRepository();
$user = $users->findOne(['email' => $email]);

$orderRepository = new OrderRepository();
$carIds = $orderRepository->getCarIdsByEmail($email);
$carsf = $carRepository->findByIds($carIds);

$itemsPerRow = 5;
$totalItems = count($carsf);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="st.css">
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
    <h2>Bejelentkezve mint:<?=$user['fullname']?></h2>

    <?php
       echo "<div class='container'>";
       for ($i = 0; $i < $totalItems; $i += $itemsPerRow) {
           $row = array_slice($carsf, $i, $itemsPerRow);
           echo "<div class='row'>";
           foreach ($row as $item) {
               echo "<div class='box'>" . htmlspecialchars($item->brand ). "</div>";
           }
           $remainingSlots = $itemsPerRow - count($row);
           for ($j = 0; $j < $remainingSlots; $j++) {
               echo "<div class='box hidden'></div>";
           }
           echo "</div>";
       }
       echo "</div>";
       
         ?>
</body>

</html>