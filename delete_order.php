<?php

require_once "classes/orderStorage.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $orderId = $_GET['order_id'] ?? null;

    if ($orderId) {
        $orderRepository = new OrderRepository();
        $orderRepository->deleteOrder(function ($order) use ($orderId) {
            return $order['id'] == $orderId; // Match the ID
        });
    }
}

header('Location: profil.php');
exit();
?>
