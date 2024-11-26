<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\Interfaces\OrderDetailRepositoryInterface;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    private $model;
    public function __construct()
    {
        $this->model = OrderDetail::class;
    }

    public function create($data)
    {
        $this->model::create($data);
    }
    public function countByOrder($orderId)
    {
        return $this->model::where('order_id', $orderId)->count();
    }
}
