<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Helpers\Toast;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'role' => [
                    'required',
                    Rule::in(['USER', 'ADMIN']),
                ],
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            $user->role = $request->role;
            $user->save();
            Toast::success('Thêm thành công!');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Toast::success('Thêm thất bại!');
        }
        return redirect()->route('admin.users.index');
    }
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'role' => [
                    'required',
                    Rule::in(['USER', 'ADMIN']),
                ],
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->save();
            Toast::success('Sửa thành công!');
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Toast::success('Sửa thất bại!');
        }
        return redirect()->route('admin.users.index');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->delete()) {
            Toast::success('Xóa thành công!');
        } else {
            Toast::error('Xóa thất bại!');
        }
        return redirect()->back();
    }
}
