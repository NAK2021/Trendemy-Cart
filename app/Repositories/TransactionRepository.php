<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{

    private $model;

    public function __construct()
    {
        $this->model = Transaction::class;
    }

    public function create($data)
    {
        $this->model::create($data);
    }
}
