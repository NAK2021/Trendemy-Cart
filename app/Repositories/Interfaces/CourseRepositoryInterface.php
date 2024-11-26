<?php

namespace App\Repositories\Interfaces;

interface CourseRepositoryInterface
{
    public function list();
    public function find($id);
    public function check($id);
    public function getRandomCoursesNotInCart($ids);
}
