<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;




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
    protected $redirectTo = '/login';//RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request){
        // dd($request->all());
        $request->validate([
            //$this->username() => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // if (method_exists($this, 'hasTooManyLoginAttempts') &&
        //     $this->hasTooManyLoginAttempts($request)) {
        //     $this->fireLockoutEvent($request);

        //     return $this->sendLockoutResponse($request);
        // }

        $user = User::where([['email', $request->email]])->first();
        if( ($user != null) && (Hash::check($request->password,$user->password) == true) ){
            $userdata = array( 'email' => $request->email, 'password' => $request->password );
            if(Auth::attempt($userdata)){
                if( Auth()->user()->hasAnyRole( Role::all() ) ){
                    // dd(Auth()->user()->getRoleNames());
                    $rol = Auth()->user()->roles->first()->name;
                    switch ($rol) {
                        case 'Administrador':
                            // return response([ 'ruta'=>route('index.admin') ]);
                            return redirect()->route('index.admin');
                            break;
                        case 'Proveedor':
                            return redirect()->route('index.proveedor');
                            // return response([ 'ruta'=>route('index.admin') ]);
                            break;
                        default:
                            return redirect()->route('no.rol');
                            break;
                    }

                }else{
                    return $this->sendFailedLoginResponse($request);
                }
            }else{
                return $this->sendFailedLoginResponse($request);
            }
        }else{
            return $this->sendFailedLoginResponse($request);
        }
    }

    public function logout(Request $request){
        // Auth::logout();
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
