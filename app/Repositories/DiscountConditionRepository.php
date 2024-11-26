<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\DiscountCondition;
use App\Repositories\Interfaces\DiscountConditionRepositoryInterface;

class DiscountConditionRepository implements DiscountConditionRepositoryInterface
{
    private $model;
    public function __construct()
    {
        $this->model = DiscountCondition::class;
    }
    public function get()
    {
        return $this->model::get();
    }
    public function first()
    {
        return $this->model::first();
    }
}
