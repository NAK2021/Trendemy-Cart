<?php

namespace App\Services\Interfaces;

interface CourseServiceInterface
{
    public function get();
    public function find($id);
    public function check($id);
    public function getRandomCoursesNotInCart($ids);
}
