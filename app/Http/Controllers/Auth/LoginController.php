<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        // untuk mengecek jika inputan berupa email
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // menampung informasi login, dimana kolom type pertama adalah bersifat dinamis berdasarkan value dari type diatas
        $login = [
            $loginType => $request->username,
            'password' => $request->password,
        ];

        // lakukan login
        if (auth()->attempt($login)) {
            return redirect()->route('home'); // jika berhasil login, akan beralih ke halm home
        }

        return redirect()->route('login')->with(['error' => 'Email atau Nomor Telepon yang dimasukkan salah!']);
    }
}
