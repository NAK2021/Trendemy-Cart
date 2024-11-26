<?php

namespace App\Services\Interfaces;

interface CartServiceInterface
{
    public function list();
    public function listRecommend();
    public function add($courseId);
    public function summary($data);
    public function checkout($data);
    public function remove($id);
    public function count();
}
