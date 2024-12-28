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

<body>

    <?php 
    
    ?>
    <ul>
        <?php
        foreach ( $cars as $car){
        echo '<li>' . $car . '</li>';
        }

?>
    </ul>

    <?php ?>
</body>

</html>