<?php

namespace App\Http\Controllers;

<<<<<<< HEAD
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function Index(){
        return "HomePage";
    }


=======
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\OrderServiceInterface;

class HomeController extends Controller
{
    public function index()
    {
        return view("client.home.index");
    }

    public function login()
    {
        return view("client.home.login");
    }

    public function register()
    {
        return view("client.home.register");
    }


    public function handleLogin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'required' => ':attribute không hợp lệ.',
                'email' => ':attribute không hợp lệ.',
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );

        if ($validator->passes()) {
            $remember = $request->has('remember');
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
                return redirect()->intended('/');
            } else {
                return back()->onlyInput('email')->with('error', 'Tài khoản hoặc mật khẩu không chính xác');
            }
        } else {
            return back()->onlyInput('email')->withErrors($validator);
        }
    }

    public function handleRegister(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|confirmed'
                ],
                [
                    'required' => ':attribute không hợp lệ.',
                    'email' => ':attribute không hợp lệ.',
                    'unique' => ':attribute đã được sử dụng.',
                    'confirmed' => ':attribute không khớp.',
                ],
                [
                    'name' => 'Tên',
                    'email' => 'Email',
                    'password' => 'Mật khẩu'
                ]
            );

            if ($validator->passes()) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                Auth::login($user);
                return redirect()->route('home');
            } else {
                return back()->onlyInput('name', 'email')->withErrors($validator);
            }
        } catch (Exception $ex) {
            Log::error('[' . __METHOD__ . ']: ' . $ex->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    public function sendEmail($view, $params, $subject, $to, $name)
    {
        Mail::send($view, $params, function ($email) use ($subject, $to, $name) {
            $email->subject($subject);
            $email->to($to, $name);
        });
    }
>>>>>>> b80dd2f (init commit)
}
