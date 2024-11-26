<?php

namespace App\Repositories;

use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseRepository implements CourseRepositoryInterface
{

    private $apiCourse;

    public function __construct()
    {
        $this->apiCourse = config('services.api.courses');
    }

    public function list()
    {
        try {
            $data = Http::get($this->apiCourse . 'all');
            if ($data->successful()) {
                return $data->json();
            }
            return [];
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            return [];
        }
    }

    public function find($id)
    {
        try {
            $data = Http::get($this->apiCourse . 'find/' . $id);
            if ($data->successful()) {
                return $data->json();
            }
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
        }
    }
    public function check($id)
    {
        try {
            $data = Http::get($this->apiCourse . 'check/' . $id);
            if ($data->successful()) {
                return $data->json();
            }
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
        }
    }
    public function getRandomCoursesNotInCart($ids)
    {
        try {
            $idsString = implode(',', $ids);
            $data = Http::get($this->apiCourse . 'randomCoursesNotInCart/' . $idsString);
            if ($data->successful()) {
                return $data->json();
            }
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
        }
    }
}
