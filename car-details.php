<?php
require_once "classes/carStorage.php";
require_once "classes/auth.php";
$auth = new Auth();

// Check if an ID is provided
if (isset($_GET['id'])) {
    $carId = (int)$_GET['id'];
    $repository = new CarRepository();
    $car = $repository->findById($carId);
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

<div class="car-details">
        <h2><?php echo htmlspecialchars($car->brand . " " . $car->model); ?></h2>
        <p>Year: <?php echo htmlspecialchars($car->year); ?></p>
        <p>Transmission: <?php echo htmlspecialchars($car->transmission); ?></p>
        <p>Fuel Type: <?php echo htmlspecialchars($car->fuel_type); ?></p>
        <p>Passengers: <?php echo htmlspecialchars($car->passengers); ?></p>
        <p>Price: <?php echo htmlspecialchars($car->daily_price_huf); ?> HUF/day</p>
        <img src="<?php echo htmlspecialchars($car->image); ?>" alt="Car Image">
    </div>
    
</body>
</html>