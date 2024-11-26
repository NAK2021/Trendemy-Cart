<?php

namespace App\Repositories\Interfaces;

interface CartRepositoryInterface
{
    public function listCart();
    public function getCoursesIdNotInCart();
    public function countCart();
    public function addToCart($courseId);
    public function findByCourseId($courseId);
    public function findById($id);
    public function removeFromCart($id);
}
