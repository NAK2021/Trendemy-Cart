<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Helpers\Toast;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    //
    public function index()
    {
        $configs = Config::latest()->get();

        return view('admin.configs.index', compact('configs'));
    }
    public function create()
    {
        return view('admin.configs.create');
    }
    public function edit($id)
    {
        $config = Config::findOrFail($id);
        return view('admin.configs.edit', compact('config'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'data' => 'required|json',
            ]);
            Config::create([
                'name' => $request->name,
                'data' => $request->data
            ]);
            Toast::success('Thêm thành công!');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Toast::success('Thêm thất bại!');
        }
        return redirect()->route('admin.configs.index');
    }
    public function update(Request $request, $id)
    {
        try {
            $config = Config::findOrFail($id);
            $request->validate([
                'name' => 'required',
                'data' => 'required|json',
            ]);
            $config->update($request->except(['_token', '_method']));
            Toast::success('Sửa thành công!');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Toast::success('Sửa thất bại!');
        }
        return redirect()->route('admin.configs.index');
    }
    public function destroy($id)
    {
        $config = Config::findOrFail($id);
        if ($config->delete()) {
            Toast::success('Xóa thành công!');
        } else {
            Toast::error('Xóa thất bại!');
        }
        return redirect()->back();
    }
}
