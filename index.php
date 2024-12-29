<?php
require_once "classes/carStorage.php";
require_once "classes/auth.php";
$auth = new Auth();
function is_empty( $key)
{
    return !(isset($_POST[$key]) && trim($_POST[$key]) !== "");
}
$repository = new CarRepository();
$carsf = $repository->all();

if (!(is_empty( "transmission"))) {
    $trans = $_POST["transmission"];
    $carsf = array_filter($carsf, function ($car) use ( $trans) {
        return $car->transmission === $trans;
    });
}
if (!(is_empty("filterfero"))) {
    $fero = $_POST["filterfero"];
    $carsf = array_filter($carsf, function ($car) use ( $fero) {
        return $car->passengers  >= $fero;
    });}

    if (!(is_empty( "max_price")) && !(is_empty( "min_price"))) {
        $minp = $_POST["min_price"];
        $maxp = $_POST["max_price"];
        if ($maxp >= $minp){
            $carsf = array_filter($carsf, function ($car) use ( $minp, $maxp) {
                return $car->daily_price_huf <= $maxp && $car->daily_price_huf >= $minp ;
            });

        }
        else{
            echo"invalid price range ";
        }
       
}


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
    <h1>Kölsönözz autókat könnyedén!</h1>
    <a href="register.php">Regisztáció</a>
    <div id="szures">
        <form action="" method="post">
            <label for="transmission">Váltótípusa</label>
            <select name="transmission" id="transmission">
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
            <label for="filterfero">férőhely</label>
            <input type="number" name="filterfero"  value="<?=isset($_POST["filterfero"]) ? $_POST["filterfero"] : ""?>"  min="1" max="20">
                    
            <label for="min_price">Price range:</label>
            <input type="number" name="min_price" id="min_price" min="0" step="100" 
            value="<?= isset($_POST['min_price']) ? htmlspecialchars($_POST['min_price']) : '' ?>" 
            oninput="updateMaxMin()">

            <label for="max_price">-</label>
            <input type="number" name="max_price" id="max_price" min="0" step="100" 
            value="<?= isset($_POST['max_price']) ? htmlspecialchars($_POST['max_price']) : '' ?>">

                    <button type="submit"> Szűrés</button>
        </form>

    </div>


    <?php
       echo "<div class='container'>";
       for ($i = 0; $i < $totalItems; $i += $itemsPerRow) {
           $row = array_slice($carsf, $i, $itemsPerRow);
           echo "<div class='row'>";
           foreach ($row as $item) {
            $id = (string)$item->id;
            $brand = htmlspecialchars($item->brand); // Car brand
            $model = htmlspecialchars($item->model ?? ""); // Car model (optional)
            $price = htmlspecialchars($item->daily_price_huf ?? ""); // Daily price
            $passengers = htmlspecialchars($item->passengers ?? ""); // Passenger capacity
            $imagePath = htmlspecialchars($item->image_path ?? "default.jpg"); // Car image (default if none)
            echo "
            <div class='box' onclick=\"window.location.href='car-details.php?id=$id'\">
                 <img src='images/$imagePath' alt='$brand $model' class='car-image'>
                <h2>$brand $model</h2>
                <p>Price: $price HUF/day</p>
                <p>Passengers: $passengers</p>
            </div>";
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