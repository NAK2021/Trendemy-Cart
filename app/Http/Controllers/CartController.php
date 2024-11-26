<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CartServiceInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;
    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        $listRecommend = $this->cartService->listRecommend();
        return view("client.home.cart", compact('listRecommend'));
    }
    public function list()
    {
        return $this->cartService->list();
    }
    public function addToCart(Request $request)
    {
        $course_id = $request->id;
        return $this->cartService->add($course_id);
    }
    public function summary(Request $request)
    {
        return $this->cartService->summary($request);
    }
    public function checkout(Request $request)
    {
        return $this->cartService->checkout($request);
    }
    public function remove(Request $request)
    {
        $cart_id = $request->id;
        return $this->cartService->remove($cart_id);
    }
    public function count()
    {
        return $this->cartService->count();
    }
    public function recommend()
    {
        return $this->cartService->listRecommend();
    }
}
