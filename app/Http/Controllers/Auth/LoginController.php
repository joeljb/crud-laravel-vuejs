<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\inicioSesion;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request )
    {
         //  dd($request->password);
         // $credentials = $request->only('email', 'password');

         // if (Auth::attempt($credentials)) {
         //    // Authentication passed...
         //    return redirect()->intended('/home');
         // }
         if ($this->attemptLogin($request)) {
            // dd($request->user());
            Mail::to($request->user()->email)->send(new inicioSesion());
            return $this->sendLoginResponse($request);
         }
         $this->incrementLoginAttempts($request);

         return $this->sendFailedLoginResponse($request);

    }

   // protected function sendLoginResponse(Request $request)
   // {
   //    dd($this->authenticated($request, $this->guard()->user()));
   //    return $this->authenticated($request, $this->guard()->user())
   //             ?: redirect()->intended($this->redirectPath());
   // }

   // protected function sendFailedLoginResponse(Request $request)
   //  {
   //      throw ValidationException::withMessages([
   //          $this->username() => [trans('auth.failed')],
   //      ]);
   //  }

}
