<?php

namespace App\Services\Interfaces;

interface TransactionServiceInterface
{
    public function create($orderId, $method);
}
