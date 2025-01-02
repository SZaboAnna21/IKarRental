<?php

require_once "classes/carStorage.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $car_id = $_GET['car_id'] ?? null;

    if ($car_id) {
        $CRepository = new CarRepository();
        $CRepository->deleteCars(function ($car) use ($car_id) {
            return $car['id'] == $car_id; // Match the ID
        });
    }
}

header('Location: index.php');
exit();
?>
