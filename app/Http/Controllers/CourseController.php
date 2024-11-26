<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CourseServiceInterface;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $courseService;
    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
    }
    public function get()
    {
        return $this->courseService->get();
    }
    public function find($id)
    {
        return $this->courseService->find($id);
    }
}
