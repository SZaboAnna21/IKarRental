<?php
require_once "classes/carStorage.php";
require_once "classes/auth.php";
require_once "classes/orderStorage.php";
$orderRepository = new OrderRepository();
session_start();
$auth = new Auth();
function is_empty($input, $key)
{
    return !(isset($input[$key]) && trim($input[$key]) !== "");
} 
if (isset($_GET['id'])) {
    $carId = (int)$_GET['id'];
    $repository = new CarRepository();
    $car = $repository->findById($carId);
}
else {
    $car = null;
}
$ordersforthiscar = $orderRepository->findByCarId((string)$carId);

function validate($input, &$errors,  $auth, $car, $ordersforthiscar)
{
    if (is_empty($input, "dateuntil") ||
        is_empty($input, "datefrom")) {
        $errors[] = "Dátumválasztáskötelező";
    }
    else if (!$auth->is_authenticated()){
        
        $errors[] = "jelentkezz be elobb!";
        ///header("Location: login.php"); ????????
    }
    else {
        $dateFrom = isset($input["datefrom"]) ? strtotime($input["datefrom"]) : null;
        $dateUntil = isset($input["dateuntil"]) ? strtotime($input["dateuntil"]) : null;

        if ($dateFrom && $dateUntil && $dateUntil < $dateFrom) {
            $errors[] = "A végdátumnak nagyobbnak vagy egyenlőnek kell lennie, mint a kezdő dátum.";
        } elseif (!$dateFrom || !$dateUntil) {
            $errors[] = "Hibás dátumformátum.";
        }
        foreach ($ordersforthiscar as $order) {
            $odateS = strtotime($order->datestart);
            $odateE = strtotime($order->dateend);
            if ( $odateS <= $dateUntil && $odateS >= $dateFrom ||  $dateFrom >= $odateS && $dateFrom <= $odateE ){
                $errors[] = "Ekkora nem tudsz foglalni.";
                $ds = $_POST['datefrom'];
                $de = $_POST['dateuntil'];
                header("Location: unsuccess.php?Car={$car->id}&datef={$ds}&dateu={$de}");
            }
        }
    }

    return !(bool) $errors;
}
$errors = [];
if (count($_POST)>= 1){
    if (validate($_POST, $errors, $auth, $car,$ordersforthiscar) ) {
        $ds = $_POST['datefrom'];
        $de = $_POST['dateuntil'];
        $orderRepository->add(new Order($car->id, $_SESSION["user"], $_POST["datefrom"], $_POST["dateuntil"]));
        header("Location: success.php?Car={$car->id}&datef={$ds}&dateu={$de}");
    }
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
<?php if ($errors) {?>
        <?php foreach ($errors as $error) {?>
        <a><?=$error?></a>
        <?php }?>
    <?php }?>

<div class="car-details">
        <h2><?php echo htmlspecialchars($car->brand . " " . $car->model); ?></h2>
        <p>Year: <?php echo htmlspecialchars($car->year); ?></p>
        <p>Transmission: <?php echo htmlspecialchars($car->transmission); ?></p>
        <p>Fuel Type: <?php echo htmlspecialchars($car->fuel_type); ?></p>
        <p>Passengers: <?php echo htmlspecialchars($car->passengers); ?></p>
        <p>Price: <?php echo htmlspecialchars($car->daily_price_huf); ?> HUF/day</p>
        <img src="<?php echo htmlspecialchars($car->image); ?>" alt="Car Image">
    </div>

    <form action="" method="post">
        <label for="datefrom">Dátumtól: </label>
        <input id="datefrom" name="datefrom" type="date"> - 
        <input id="dateuntil" name="dateuntil" type="date"> -ig<br>
        <input type="submit" value="Foglalás">
    </form>
    
</body>
</html>