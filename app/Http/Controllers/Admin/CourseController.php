<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Imgur;
use App\Helpers\Toast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Services\Interfaces\CourseServiceInterface;
use Exception;

class CourseController extends Controller
{
    private $courseService;
    private $apiCourse;
    public function __construct(CourseServiceInterface $courseService)
    {
        $this->courseService = $courseService;
        $this->apiCourse = config('services.api.courses');
    }
    public function index(Request $request)
    {
        try {
            $page = $request->input('page', 1);
            $response = Http::get($this->apiCourse . '?page=' . $page);
            $courses = [];
            if ($response->successful()) {

                if ($response['success']) {
                    $courses = $response['courses'];
                }
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            abort(500);
        }
        return view('admin.courses.index', compact('courses'));
    }
    public function create()
    {
        return view('admin.courses.create');
    }
    public function edit($id)
    {
        try {
            $response = $this->courseService->find($id);
            if ($response['success']) {
                $course = $response['course'];
                return view('admin.courses.edit', compact('course'));
            } else {
                abort(404);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            abort(500);
        }
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'lecturer' => 'required|string|max:255',
                'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'fake_cost' => 'required|integer',
                'cost' => 'required|integer',
            ]);
            $imageUrl = Imgur::upload($request->file('thumbnail'));
            if ($imageUrl) {
                Http::post(
                    $this->apiCourse,
                    [
                        'name' => $request->name,
                        'lecturer' => $request->lecturer,
                        'thumbnail' => $imageUrl,
                        'fake_cost' => $request->fake_cost,
                        'cost' => $request->cost,
                    ]
                );
            }
            Toast::success('Thêm thành công!');
            return redirect()->route('admin.courses.index');
        } catch (Exception $ex) {
            Log::error('Error storing course: ' . $ex->getMessage(), ['exception' => $ex]);
            abort(500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'lecturer' => 'required|string|max:255',
                'fake_cost' => 'required|integer',
                'cost' => 'required|integer',
            ]);
            if ($request->hasFile('thumbnail')) {
                $request->validate([
                    'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $imageUrl = Imgur::upload($request->file('thumbnail'));
            }
            Http::put(
                $this->apiCourse . $id,
                [
                    'name' => $request->name,
                    'lecturer' => $request->lecturer,
                    'thumbnail' => $imageUrl ?? '',
                    'fake_cost' => $request->fake_cost,
                    'cost' => $request->cost,
                ]
            );
            Toast::success('Sửa thành công!');
            return redirect()->route('admin.courses.index');
        } catch (Exception $ex) {
            Log::error('Error storing course: ' . $ex->getMessage(), ['exception' => $ex]);
            abort(500);
        }
    }
    public function destroy($id)
    {
        try {
            Http::delete($this->apiCourse . $id);
            Toast::success('Xóa thành công');
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Toast::error('Xóa thất bại');
        }
        return redirect()->back();
    }
}
