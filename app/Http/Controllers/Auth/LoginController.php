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
        $inputVal = $request->all();
        $userDevice = $request->header('User-Agent');

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(['email' => $inputVal['email'], 'password' => $inputVal['password']])) {
            if (auth()->user()->is_deletd === '1') {
                auth()->logout(); // Logout pengguna

                return redirect()->route('login')->with('error', 'Your account has been deleted.');
            } else {
                $token = auth()->user()->createToken($userDevice);
                return redirect()->route('home')->withCookie("SIKLIS_TOKEN", $token->plainTextToken, 0, "", "", false, false);
            }
        } else {
            return redirect()->route('login')->with('error', 'Email & Password are incorrect.');
        }
    }
}
