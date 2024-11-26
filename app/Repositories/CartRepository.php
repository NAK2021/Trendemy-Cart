<?php

namespace App\Repositories;

use App\Enums\CartState;
use App\Models\Cart;
use App\Repositories\Interfaces\CartRepositoryInterface;
use Illuminate\Support\Facades\Auth;



class CartRepository implements CartRepositoryInterface
{
    private $userId;
    private $model;
    public function __construct()
    {
        $this->userId = Auth::user()->id;
        $this->model = Cart::class;
    }

    private function forUser()
    {
        return $this->model::where('user_id', $this->userId);
    }

    public function listCart()
    {
        return $this->forUser()
            ->select('id', 'course_id')
            ->where('state', CartState::PENDING)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function countCart()
    {
        return $this->forUser()
            ->where('state', CartState::PENDING)
            ->count();
    }

    public function addToCart($courseId)
    {
        return $this->model::create([
            'user_id' => $this->userId,
            'course_id' => $courseId
        ]);
    }

    public function findByCourseId($courseId)
    {
        return $this->forUser()
            ->select('id', 'state')
            ->where('course_id', $courseId)
            ->first();
    }

    public function findById($id)
    {
        return $this->forUser()
            ->select('id', 'user_id', 'course_id', 'state')
            ->where('state', CartState::PENDING)
            ->where('id', $id)
            ->first();
    }

    public function removeFromCart($id)
    {
        return $this->forUser()
            ->where('id', $id)
            ->where('state', CartState::PENDING)
            ->update(['state' => CartState::REMOVED]);
    }
    public function getCoursesIdNotInCart()
    {
        return $this->forUser()
            ->whereIn('state', [CartState::PENDING, CartState::PURCHASED])
            ->pluck('course_id')
            ->toArray();
    }
}
