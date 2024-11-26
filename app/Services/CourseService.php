<?php

namespace App\Services;

use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Services\Interfaces\CourseServiceInterface;

class CourseService implements CourseServiceInterface
{
    public function __construct(
        protected CourseRepositoryInterface $courseRepository
    ) {
    }
    public function get()
    {
        return $this->courseRepository->list();
    }
    public function find($id)
    {
        return $this->courseRepository->find($id);
    }
    public function check($id)
    {
        return $this->courseRepository->check($id);
    }
    public function getRandomCoursesNotInCart($ids)
    {
        return $this->courseRepository->getRandomCoursesNotInCart($ids);
    }
}
