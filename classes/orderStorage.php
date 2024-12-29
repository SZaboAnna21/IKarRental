<?php 
include_once "storage.php";

class Order{
    public $_id = null;
    public $carid;
    public $email;
    public $datestart;
    public $dateend;



public function __construct($carid = null, $email = null, $datestart = null, $dateend = null)
    {
        $this->carid = $carid;
        $this->email = $email;
        $this->datestart = $datestart;
        $this->dateend = $dateend;
    }

    public static function from_array(array $arr): Order
    {
        $instance = new Order();
        $instance->_id = $arr['_id'] ?? null;
        $instance->carid = $arr['carid'] ?? null;
        $instance->email = $arr['email'] ?? null;
        $instance->datestart = $arr['datestart'] ?? null;
        $instance->dateend = $arr['dateend'] ?? null;
        return $instance;
    }

    public static function from_object( $obj): Order
    {
        return self::from_array((array) $obj);
    }

}


class OrderRepository
{
    private $storage;
    public function __construct()
    {
        $filen = new JsonIO('data/orders.json');
        $this->storage = new Storage($filen);
    }
    private function convert( array $arr): array
    {
        return array_map([Order::class, 'from_object'], $arr);
    }
    public function All()
    {
        return $this->convert($this->storage->findAll());
    }
    public function add(Order $order): string
    {
        return $this->storage->insert($order);
    }

    public function deleteOrder(callable $condition): void
    {
        $this->storage->deleteMany($condition);
    }

    public function findByEmail(string $email): array {
        return $this->convert($this->storage->findMany(function ($order) use ($email) {
            return $order['email'] === $email;
        }));
    }

    public function getCarIdsByEmail(string $email): array {
        $orders = $this->findByEmail($email);
        return array_map(fn($order) => $order->carid, $orders);
    }


    public function updateOrders(callable $condition, callable $updater): void
    {
        $this->storage->updateMany($condition, $updater);
    }

}
?>