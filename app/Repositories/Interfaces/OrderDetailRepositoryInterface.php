<?php

namespace App\Repositories\Interfaces;

interface OrderDetailRepositoryInterface
{
    public function create($data);
    public function countByOrder($orderId);
}
