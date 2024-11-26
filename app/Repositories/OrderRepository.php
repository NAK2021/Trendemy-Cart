<?php

namespace App\Repositories;

use App\Enums\OrderState;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    private $model;
    private $userId;

    public function __construct()
    {
        $this->model = Order::class;
        $this->userId = Auth::user()->id;
    }

    public function find($id)
    {
        return $this->model::find($id);
    }
    public function getWithDetails($id)
    {
        return $this->model::with('details')
            ->select('id', 'code', 'discount', 'total', 'created_at')
            ->where('user_id', $this->userId)
            ->find($id);
    }
    public function create($data)
    {
        return $this->model::create($data);
    }
    public function getUsedPromotionsForUser()
    {
        return Order::where('user_id', $this->userId)
            ->where('state', OrderState::PAID)
            ->whereNotNull('promotion')
            ->pluck('promotion');
    }
}
